<?php
/*
 * Template Name Posts: Full width
 */
get_header();
echo '<!-- google_ad_section_start-->';
if (have_posts()) {
    while (have_posts()) {
        the_post();
        get_template_part('featuredimage');
        echo '<div id="post-' . get_the_ID() . '" ' . get_post_class("post") . '>';
        if (empty($hide_h1_tag)) {
            ?>
<h1 class="featurette-heading container">
<?php the_title();?>
</h1>
<?php
        }
        get_template_part('breadcrumb');
        ?>
<div class="container">
        <?php
        if ($values = get_post_custom_values("leadvideo")) {
            echo '<iframe width="100%" height="400" src="//www.youtube.com/embed/';
            echo $values[0];
            echo '" frameborder="0" allowfullscreen></iframe>';
        }
        remove_filter('the_content', 'sharing_display', 19);
        remove_filter('the_excerpt', 'sharing_display', 19);
        the_content("<p class=\"serif\">" . __('Read the rest of this page', 'multiloquent') . " &raquo;</p>");
        wp_link_pages("<p><strong>" . __('Pages', 'multiloquent') . ":</strong>", '</p>', __('number', 'multiloquent'));
        ?>
        </div>
<?php
        get_template_part('advert');
        get_template_part('social');
        ?>
<section class="comments_full container">
    <h3 class="hidden-lg">Comments for <?php the_title(); ?></h3>
                    <?php comments_template(); ?>    
                </section>
<?php get_template_part('advert');?>
<section class="container">
    <div class="tagcloud">
        <div class="tag-cloud">
            <h3>Tags for <?php the_title(); ?></h3>
            <?php
        $posttags = get_the_tags();
        if ($posttags) {
            foreach ($posttags as $tag) {
                // if($tag->count > 5){
                echo '<a class="label ';
                echo get_random_solid_class($tag->slug);
                echo '" rel="nofollow" href="/tag/' . $tag->slug . '"><span class="icon-tag icon-white"></span> ' . $tag->name . '</a>';
                // }
            }
        }
        ?>
        </div>
    </div>
</section>
<?php
        if (function_exists('related_posts')) {
            related_posts();
        }
        get_template_part('advert');
        echo '</div>';
    }
} else {
    echo '<p>' . __('Sorry, no posts matched your criteria.', 'multiloquent') . '<p>';
}
echo '<!-- google_ad_section_end-->';
get_footer();
