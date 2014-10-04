<?php
/**
 * template for static homepage if set in options
 */

/**
 * home page template part if static page selected as homepage
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package multiloquent\template_parts
 */

if ('posts' == get_option('show_on_front')) {
    include (get_home_template());
} else {
    get_header();
    ?>
    <!-- google_ad_section_start-->
    <div class="jumbotron">
        <div class="container">
            <?php
            while (have_posts()) {
                the_post();
                the_content('<p class="serif">' . 'Read the rest of this page' . ' &raquo;</p>');
            }
            ?>
        </div>
    </div>
    <!-- google_ad_section_end-->
    <p class="lead text-center">Featured Posts</p>
    <?php echo $multiloquent->multiloquent_paralax_slider();?>
    <div class="container">
        <?php require(locate_template('advert.php'));?>
    </div>
    <?php
    get_footer();
}

