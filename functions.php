<?php
load_theme_textdomain('multiloquent');
// include the file that has the actual functions in it
get_template_part('function_definitions');

// some filters
add_filter('the_content', 'featured_image_in_feed');
add_action('wp_enqueue_scripts', 'dequeue_devicepx', 20);
add_filter('post_class', 'remove_hentry_function', 20);
add_action('init', 'my_init');
add_action('after_setup_theme', 'register_my_menus');
add_filter('the_tags', 'add_class_the_tags', 10, 1);
add_filter('widget_tag_cloud_args', 'my_widget_tag_cloud_args');
add_action('wp_tag_cloud', 'add_tag_class');
add_filter('wp_tag_cloud', 'wp_tag_cloud_filter', 10, 2);
add_filter('get_avatar', 'shoestrap_get_avatar');

// Widgetized sidebar
if (function_exists('register_sidebar')) {
    register_sidebars((10), array(
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<p class="nav-header">',
    'after_title' => '</p>',
    'class' => ''
        ));
}


if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(605, 100);
}
if (function_exists('add_image_size')) {
    add_image_size('featured-post-thumbnail', 605, 100);
}
if (! isset($content_width)) {
    $content_width = 900;
}
