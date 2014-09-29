<?php

/**
 * multiloquent function definitions
 * @todo - make this oo
 * @package multiloquent\functions
 */

/**
 * various register actions
 *
 * @internal internal
 *
 */
function multiloquent_register() {
    // theme support
    add_theme_support('automatic-feed-links');
    add_theme_support('html5');
    add_theme_support('post-thumbnails');
    $args = array('width' => 1800, 'height' => 600, 'default-image' => get_template_directory_uri() . '/images/default-slider.png', 'uploads' => true,);
    add_theme_support('custom-header', $args);

    // actions
    add_action('wp_enqueue_scripts', $multiloquent->multiloquent_scripts_method);
    add_action('wp_enqueue_scripts', $multiloquent->multiloquent_stylesheet_method);
    add_action('customize_register', $multiloquent->multiloquent_customize_register);
    add_action('wp_tag_cloud', $multiloquent->multiloquent_add_tag_class);

    // filters
    add_filter('the_content', $multiloquent->multiloquent_featured_image_in_feed);
    add_filter('post_class', $multiloquent->multiloquent_remove_hentry_function, 20);

    // add_filter('the_tags', 'multiloquent_add_class_the_tags', 10, 1);
    add_filter('widget_tag_cloud_args', $multiloquent->multiloquent_widget_tag_cloud_args);
    add_filter('wp_tag_cloud', $multiloquent->multiloquent_tag_cloud_filter, 10, 2);
    add_filter('get_avatar', $multiloquent->multiloquent_get_avatar);
    add_filter('widget_text', 'do_shortcode');

    // misc
    if (is_admin()) {
        add_editor_style('style.css');
    }
    multiloquent_menu();
    set_post_thumbnail_size(605, 100);
    add_image_size('featured-post-thumbnail', 605, 100);
    if (!isset($content_width)) {
        $content_width = 900;
    }

    // sidebars
    $sidebars = array('1' => 'sidebar top', '2' => 'mobile specific advert', '3' => 'non-mobile specific advert', '4' => 'sidebar middle', '5' => 'sidebar bottom', '6' => 'footer top left', '7' => 'footer top right', '8' => 'social media', '9' => 'footer bottom left', '10' => 'footer bottom right',);
    $multiloquent->multiloquent_generate_sidebars($sidebars);
}

