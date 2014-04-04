<?php
/*
 * Template Name Posts: Full width
 */
get_header();
echo '<!-- google_ad_section_start-->';
if (have_posts()) {
    while (have_posts()) {
        the_post();
        get_template_part('featuredposts');
        get_template_part('featuredimage');
        echo '<div id="post-' . get_the_ID() . '" ';
        echo post_class("post");
        echo '>';
        if (empty($multiloquent_hide_h1_tag)) {
            ?>
<h1 class="container">
<?php echo multiloquent_post_title();?>
</h1>
<?php
        }
        get_template_part('breadcrumb');
        ?>
<div class="container">
    <div class="col-sm-12 col-md-12 col-lg-12">
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
        get_template_part('advert');
        get_template_part('social');
        if (comments_open()) {
            ?>
    <h3 class="hidden-lg">Comments for <?php echo multiloquent_post_title(); ?></h3>
                    <?php comments_template(); ?>    
                </section>
<?php
        }
        get_template_part('advert');
        if (function_exists('related_posts')) {
            related_posts();
        }
        get_template_part('advert');
        ?>
       </div>
<?php
    }
} else {
    echo '<p>Sorry, no posts matched your criteria.<p>';
}
echo '<!-- google_ad_section_end-->';
get_footer();
