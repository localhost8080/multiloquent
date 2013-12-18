<?php
get_template_part('function_definitions');
add_filter('the_content', 'featured_image_in_feed');
remove_filter('the_content', 'tptn_add_viewed_count');
add_action('wp_enqueue_scripts', 'dequeue_devicepx', 20);
add_filter('post_class', 'remove_hentry_function', 20);
// remove jetpack open graph tags
// remove_action('wp_head','jetpack_og_tags');
load_theme_textdomain('multiloquent');
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(605, 100);
}
if (function_exists('add_image_size')) {
    add_image_size('featured-post-thumbnail', 605, 100);
}

add_filter('the_tags', 'add_class_the_tags', 10, 1);
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
add_filter('widget_tag_cloud_args', 'my_widget_tag_cloud_args');
add_action('wp_tag_cloud', 'add_tag_class');
add_filter('wp_tag_cloud', 'wp_tag_cloud_filter', 10, 2);
add_filter('get_avatar', 'shoestrap_get_avatar');
if (is_admin()) {
    add_filter('manage_posts_columns', 'post_column_views');
    add_action('manage_posts_custom_column', 'post_custom_column_views', 10, 2);
    add_filter('manage_edit-post_sortable_columns', 'register_post_column_views_sortable');
    add_filter('posts_orderby', 'new_posts_orderby', 10, 2);
    add_editor_style('style.css');
    add_editor_style('bootstrap/bootstrap-min.css');
}
add_action('init', 'my_init');
add_action('after_setup_theme', 'register_my_menus');
