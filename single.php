<?php
/**
 * template for blog posts
 */

/**
 * single post template part
 *
 * @package multiloquent\template_parts
 */

get_header();
echo '<!-- google_ad_section_start-->';
if (have_posts()) {
    while (have_posts()) {
        the_post();
        echo $multiloquent->multiloquent_paralax_featured_sliders();
        echo '<article id="post-' . get_the_ID() . '" ';
        echo post_class('post');
        echo '>';
        require(locate_template('featuredimage.php'));
        require(locate_template('breadcrumb.php'));
        ?>
        <div class="container">
            <?php
            if (comments_open()) {
                echo '<div class="col-sm-12 col-md-6 col-lg-7">';
            } else {
                echo '<div class="col-sm-12 col-md-12 col-lg-12">';
            }
            if ($values = get_post_custom_values('leadvideo')) {
                echo '<iframe width="100%" height="400" src="//www.youtube.com/embed/';
                echo $values[0];
                echo '" frameborder="0" allowfullscreen></iframe>';
            }
            remove_filter('the_content', 'sharing_display', 19);
            remove_filter('the_excerpt', 'sharing_display', 19);
            the_content('<p class="serif">' . 'Read the rest of this page' . ' &raquo;</p>');
            wp_link_pages('<p><strong>Pages:</strong>', '</p>', 'number');
            require(locate_template('advert.php'));
            ?>
            <section class="row">
                <div class="tagcloud clearfix mb">
                    <div class="tag-cloud">
                        <h3>Tags for <?php echo $multiloquent->multiloquent_post_title(); ?></h3>
                        <div>
                            <?php echo $multiloquent->multiloquent_render_tags($post, 1);?>
                        </div>
                    </div>
                </div>
            </section>
            <?php
            echo '</div>';
            if (comments_open()) {
                echo '<div class="col-sm-12 col-md-6 col-lg-5 comments breadcrumb">';
                comments_template();
                require(locate_template('advert.php'));
                echo '</div>';
            }
            require(locate_template('advert.php'));
            ?>
        </div>
        <?php
        // get_template_part('social');
        if (function_exists('related_posts')) {
            related_posts();
        }
        next_post_link('%link', '<span style="text-indent:-9000px; position:absolute;">%title</span><span class="next_link btn btn-default btn-lg"><span class="fa fa-chevron-left"></span></span>', true);
        previous_post_link('%link', '<span style="text-indent:-9000px; position:absolute;">%title</span><span class="prev_link btn btn-default btn-lg"><span class="fa fa-chevron-right"></span></span>', true);
        echo '</article>';
    }
} else {
    echo '<p>Sorry, no posts matched your criteria.<p>';
}
echo '<!-- google_ad_section_end-->';
require(locate_template('social.php'));
get_footer();
