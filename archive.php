<?php
get_header();
is_tag();
if (have_posts()) {
    ?>
<div class="hero-unit">
    <div class="container">
        <header>
            <h1 class="article_title">
<?php
    if (is_category()) {
        printf(__('%s', 'multiloquent'), single_cat_title('', false));
    } elseif (is_tag()) {
        _e('Posts Tagged', 'multiloquent');
        echo '&#8216;';
        single_tag_title();
        echo '&#8217;';
    } elseif (is_day()) {
        printf(__('Archive for %s', 'multiloquent'), get_the_time(__('F jS, Y', 'multiloquent')));
    } elseif (is_month()) {
        printf(__('Archive for %s', 'multiloquent'), get_the_time(__('F Y', 'multiloquent')));
    } elseif (is_year()) {
        printf(__('Archive for %s', 'multiloquent'), get_the_time('Y'));
    } elseif (is_search()) {
        __('Search Results', 'multiloquent');
    } elseif (is_author()) {
        _e('All entries by this author', 'multiloquent');
    } elseif (isset($_GET['paged']) && ! empty($_GET['paged'])) {
        _e('Blog Archives', 'multiloquent');
    }
    ?>
                </h1>
        </header>
    </div>
</div>
<div class="container post">
    <div class="featurette">
        <section class="row">
                <?php
    $post = $posts[0]; // Hack. Set $post so that the_date() works.
    $tile_colour = get_random_blue_class();
    while (have_posts()) {
        the_post();
        // set it to blank so that it doesnt get the previous one..
        $slider_image = array();
        $slider_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
        if (! empty($slider_image)) {
            $theimg = $slider_image[0];
            $width = $slider_image[1];
            $height = $slider_image[2];
            // in here I need to check if its a mobile, and then give a different image:
        } else {
            $theimg = get_template_directory_uri() . '/images/default-slider.png';
            $width = '1100';
            $height = '500';
        }
        ?>
            <div class="paralax_image_holder span4" style="margin-bottom: 30px;">
                <img src="<?php echo $theimg?>" class="grayscale" alt="<?php the_title()?>" width="<?php echo $width ?>" height="<?php echo $height ?>">
                <div class="paralax_image_bg <?php echo $tile_colour?>"></div>
                <div class="paralax_image_text">
                    <h1>
                        <a href="<?php the_permalink() ?>"><?php the_title()?></a>
                    </h1>
                    <p>
                            <?php
        $posttags = wp_get_post_tags($post->ID);
        if ($posttags) {
            foreach ($posttags as $tag) {
                echo '<a class="label ';
                echo get_random_solid_class($tag->slug);
                echo '" rel="nofollow" href="/tag/' . $tag->slug . '"><span class="fa fa-folder-o fa-fw"></span> ' . $tag->name . '</a>';
            }
        }
        ?>
                        </p>
                </div>
            </div>
            <?php
    }
    ?>
        </section>
        <section>
            <?php get_template_part('advert');?>
        </section>
        <nav class="navitems article white2">
            <?php
            


$total_pages = $wp_query->max_num_pages;

if ($total_pages > 1){

  $current_page = max(1, get_query_var('paged'));
  
  echo paginate_links(array(
      'base' => get_pagenum_link(1) . '%_%',
      'format' => '/page/%#%',
      'current' => $current_page,
      'total' => $total_pages,
    ));
}
    ?>
        </nav>
    </div>
</div>
<?php
} else {
    ?>
<div class="container post">
    <div class="featurette">
        <?php  get_template_part('error_snippet');?>
    </div>
</div>
<?php
}
wp_reset_query();
get_footer();
