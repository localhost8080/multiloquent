<?php
/*
 * Template Name Posts: Full width with no header, footer adverts or tags
 */

$hide_the_footer_links = '1';
get_header();
echo '<!-- google_ad_section_start-->';
if (have_posts()) {
    while (have_posts()) {
        the_post();
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
        ?>
<div>

        <?php

        remove_filter('the_content', 'sharing_display', 19);
        remove_filter('the_excerpt', 'sharing_display', 19);
        the_content("<p class=\"serif\">" . 'Read the rest of this page' . " &raquo;</p>");
        wp_link_pages("<p><strong>Pages:</strong>", '</p>', 'number');
        ?>

</div>
<?php

      
        echo '</div>';
    }
} else {
    echo '<p>Sorry, no posts matched your criteria.<p>';
}
echo '<!-- google_ad_section_end-->';
get_footer();
