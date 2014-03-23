<?php
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
<h1 class="container featurette-heading">
                <?php echo multiloquent_post_title();?>
            </h1>
<?php
        }
        multiloquent_get_template_part('breadcrumb');
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
        multiloquent_get_template_part('advert');
        echo '</div>';
        if (comments_open()) {
            echo '<section class="col-sm-12 col-md-6 col-lg-5 comments">';
            comments_template();
            multiloquent_get_template_part('advert');
            echo '</section>';
        }
        ?>
</div>
<?php //multiloquent_get_template_part('social');?>
<section class="container">
    <div class="tagcloud clearfix mb">
        <div class="tag-cloud col-sm-12 col-md-12 col-lg-12">
            <h3>Tags for <?php echo multiloquent_post_title(); ?></h3>
            <div>
        <?php
        $posttags = get_the_tags();
        if ($posttags) {
            foreach ($posttags as $tag) {
                // if($tag->count > 5){
                echo '<a class="label ';
                echo multiloquent_get_random_solid_class($tag->slug);
                echo '" rel="nofollow" href="' . get_tag_link($tag->term_id) . '"><span class="fa fa-folder-o fa-fw"></span> ' . $tag->name . '</a>';
                // }
            }
        }
        ?>
                </div>
        </div>
    </div>
</section>
<?php
        if (function_exists('related_posts')) {
            ?>
<section class="container post">
    <div class="col-sm-12 col-md-12 col-lg-12">
                            <?php related_posts();?>
                        </div>
</section>
<?php
        }
        next_post_link('<div class="next_link btn btn-default btn-lg">%link</div>', '<span class="fa fa-chevron-left"></span>', TRUE);
        previous_post_link('<div class="prev_link btn btn-default btn-lg">%link</div>', '<span class="fa fa-chevron-left"></span>', TRUE);
        multiloquent_get_template_part('advert');
        echo '</div>';
    }
} else {
    echo '<p>Sorry, no posts matched your criteria.<p>';
}
echo '<!-- google_ad_section_end-->';
get_footer();
