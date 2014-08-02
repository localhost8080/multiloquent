<?php
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
        get_template_part('featuredposts');
        
        echo '<article id="post-' . get_the_ID() . '" ';
        echo post_class('post');
        echo '>';
        get_template_part('featuredimage');
        get_template_part('breadcrumb');
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
        get_template_part('advert');
        ?>
        <section class="row">
        <div class="tagcloud clearfix mb">
            <div class="tag-cloud">
                <h3>Tags for <?php echo multiloquent_post_title(); ?></h3>
                <div>
                    <?php echo multiloquent_render_tags($post, 1);?>
                </div>
            </div>
        </div>
        </section>
        <?php
        echo '</div>';
        if (comments_open()) {
            echo '<div class="col-sm-12 col-md-6 col-lg-5 comments breadcrumb">';
            comments_template();
            get_template_part('advert');
            echo '</div>';
        }
        get_template_part('advert');
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
get_template_part('social');
get_footer();
