<?php
/*
 * Template Name Posts: Full width blank template
 */

get_header();
echo '<!-- google_ad_section_start-->';
if (have_posts()) {
    while (have_posts()) {
        the_post();
        echo '<div id="post-' . get_the_ID() . '" ';
        echo post_class('post');
        echo '>';
        ?>
        <div>
            <?php
            remove_filter('the_content', 'sharing_display', 19);
            remove_filter('the_excerpt', 'sharing_display', 19);
            the_content('<p class="serif">' . 'Read the rest of this page' . ' &raquo;</p>');
            wp_link_pages('<p><strong>Pages:</strong>', '</p>', 'number');
            ?>

        </div>
        <?php
        echo '</div>';
    }
} else {
    echo '<p>Sorry, no posts matched your criteria.<p>';
}
echo '<!-- google_ad_section_end-->';
?></div><?php
get_sidebar();
require(locate_template('navigation.php'));
wp_footer();
?>
</body>
</html>
