<?php
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
<h1 class="container featurette-heading">
                <?php echo multiloquent_post_title();?>
            </h1>
<?php
        }
        get_template_part('breadcrumb');
        ?>
<div class="container">
<?php
        if (comments_open()) {
            echo '<div class="col-sm-12 col-md-6 col-lg-7">';
        } else {
            echo '<div class="col-sm-12 col-md-12 col-lg-12">';
        }
        if ($values = get_post_custom_values("leadvideo")) {
            echo '<iframe width="100%" height="400" src="//www.youtube.com/embed/';
            echo $values[0];
            echo '" frameborder="0" allowfullscreen></iframe>';
        }
        remove_filter('the_content', 'sharing_display', 19);
        remove_filter('the_excerpt', 'sharing_display', 19);
        the_content("<p class=\"serif\">" . 'Read the rest of this page' . " &raquo;</p>");
        wp_link_pages("<p><strong>" . 'Pages' . ":</strong>", '</p>', 'number');
        get_template_part('advert');
        ?>
        <section class="row">
        <div class="tagcloud clearfix mb">
            <div class="tag-cloud">
                <h3>Tags for <?php echo multiloquent_post_title(); ?></h3>
                <div>
                    <?php multiloquent_render_tags($id);?>
                </div>
            </div>
        </div>
    </section>
        <?php
        echo '</div>';
        if (comments_open()) {
            echo '<section class="col-sm-12 col-md-6 col-lg-5 comments">';
            comments_template();
            get_template_part('advert');
            echo '</section>';
        }
        ?>
</div>
<?php
        // get_template_part('social');
        if (function_exists('related_posts')) {
            ?>
<section class="container post">
    <div class="col-sm-12 col-md-12 col-lg-12">
                            <?php related_posts();?>
                        </div>
</section>
<?php
        }
        next_post_link('%link', '<span class="next_link btn btn-default btn-lg"><span class="fa fa-chevron-left"></span></span>', true);
        previous_post_link('%link', '<span class="prev_link btn btn-default btn-lg"><span class="fa fa-chevron-right"></span></span>', true);
        get_template_part('advert');
        echo '</div>';
    }
} else {
    echo '<p>Sorry, no posts matched your criteria.<p>';
}
echo '<!-- google_ad_section_end-->';
get_template_part('social');
get_footer();
