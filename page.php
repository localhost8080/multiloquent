<?php
/*
 * Template Name Posts: Full width
 */
get_header();
echo '<!-- google_ad_section_start-->';
if (have_posts()) {
    while (have_posts()) {
        the_post();
        multiloquent_get_template_part('featuredposts');
        multiloquent_get_template_part('featuredimage');
        echo '<div id="post-' . get_the_ID() . '" ';
        echo post_class("post");
        echo '>';
        if (empty($multiloquent_hide_h1_tag)) {
            ?>
<h1 class="featurette-heading container">
<?php echo multiloquent_post_title();?>
</h1>
<?php
        }
        multiloquent_get_template_part('breadcrumb');
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
        the_content("<p class=\"serif\">" . 'Read the rest of this page' . " &raquo;</p>");
        wp_link_pages("<p><strong>Pages:</strong>", '</p>', 'number');
        ?>
        </div>
<?php
        multiloquent_get_template_part('advert');
        multiloquent_get_template_part('social');
        if (comments_open()) {
            ?>
<section class="comments_full container">
    <h3 class="hidden-lg">Comments for <?php echo multiloquent_post_title(); ?></h3>
                    <?php comments_template(); ?>    
                </section>
<?php
        }
        multiloquent_get_template_part('advert');
        
        if (function_exists('related_posts')) {
            related_posts();
        }
        multiloquent_get_template_part('advert');
        echo '</div>';
    }
} else {
    echo '<p>Sorry, no posts matched your criteria.<p>';
}
echo '<!-- google_ad_section_end-->';
get_footer();
