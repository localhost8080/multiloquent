<?php
get_header();
is_tag();
if (have_posts()) {
    ?>
<div class="hero-unit">
    <div class="container">
        <header>
            <?php /* If this is a category archive */ if (is_category()) { ?>
            <h1 class="article_title"><?php printf( __('%s','multiloquent'), single_cat_title('', false)); ?></h1>
            <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
            <h1 class="article_title">
                <?php _e('Posts Tagged','multiloquent'); ?>
                &#8216;
                <?php single_tag_title(); ?>
                &#8217;</h1>
                <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
                <h1 class="article_title"><?php printf( __('Archive for %s','multiloquent'), get_the_time(__('F jS, Y','multiloquent'))); ?></h1>
                <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
                <h1 class="article_title"><?php printf( __('Archive for %s','multiloquent'), get_the_time(__('F Y','multiloquent'))); ?></h1>
                <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
                <h1 class="article_title"><?php printf( __('Archive for %s','multiloquent'), get_the_time('Y')); ?></h1>
                <?php /* If this is a search */ } elseif (is_search()) { ?>
                <h1 class="article_title">
                    <?php __('Search Results','multiloquent'); ?>
                </h1>
                <?php /* If this is an author archive */ } elseif (is_author()) { ?>
                <h1 class="article_title">
                    <?php _e('All entries by this author','multiloquent'); ?>
                </h1>
                <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
                <h1 class="article_title">
                    <?php _e('Blog Archives','multiloquent'); ?>
                </h1>
                <?php } ?>
        </header>
    </div>
</div>
<?php      $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<div class="container post">
    <div class="featurette">
        <section class="row">
                <?php
    $tile_colour = get_random_blue_class();
    while (have_posts()) :
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
                <img src="<?php echo $theimg?>" class="grayscale" alt="<?php the_title()?>" width="<?php echo $width ?>"
                    height="<?php echo $height ?>">
                <div class="paralax_image_bg <?php echo $tile_colour?>"></div>
                <div class="paralax_image_text">
                    <h1>
                        <a href="<?php the_permalink() ?>"><?php  the_title()?></a>
                    </h1>
                    <p>
                            <?php
        $posttags = wp_get_post_tags($post->ID);
        if ($posttags) {
            foreach ($posttags as $tag) {
                echo '<a class="label ';
                echo get_random_solid_class($tag->slug);
                echo '" rel="nofollow" href="/tag/' . $tag->slug . '"><span class="fa fa-folder-o fa-fw"></span> ' .
                     $tag->name . '</a>';
            }
        }
        ?>
                        </p>
                </div>
            </div>
            <?php endwhile; ?>
        </section>
        <section>
            <?php get_template_part('advert');?>
        </section>
        <nav class="navitems article white2">
            <?php if(function_exists('pagenavi')) { pagenavi(); } ?>
        </nav>
    </div>
</div>
<?php } else { ?>
<div class="container post">
    <div class="featurette">
        <?php  get_template_part('error_snippet');?>
    </div>
</div>
<?php
}
wp_reset_query();
get_footer();
?>