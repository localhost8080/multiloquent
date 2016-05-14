<?php

/**
 * multiloquent class file to organise functions
 *
 * @package  multiloquent
 */
/**
 * multiloquent class file to organise functions
 */
class MultiloquentBase {

    /**
     * constructor - add some actions to WordPress startup
     */
    function __construct() {
        add_action('after_setup_theme', array(
            $this,
            'multiloquent_register'
        ));
        add_action('wp_head', array(
            $this,
            'multiloquent_customize_css'
        ));
    }

    /**
     * Returns the current multiloquent version number
     *
     * @internal internal
     * @return string
     */
    function multiloquent_version() {
        $version = '9.2.02';
        return $version;
    }

    /**
     * various register actions
     *
     * @internal internal
     */
    function multiloquent_register() {
        // theme support
        load_theme_textdomain('multiloquent');
        add_theme_support('automatic-feed-links');
        add_theme_support('html5');
        add_theme_support('post-thumbnails');
        $args = array(
            'width' => 1800,
            'height' => 600,
            'default-image' => get_template_directory_uri() . '/images/default-slider.png',
            'uploads' => true
        );
        add_theme_support('custom-header', $args);
        // actions
        add_action('wp_enqueue_scripts', array(
            $this,
            'multiloquent_scripts_method'
        ));
        add_action('wp_enqueue_scripts', array(
            $this,
            'multiloquent_stylesheet_method'
        ));
        add_action('customize_register', array(
            $this,
            'multiloquent_customize_register'
        ));
        // add_action('wp_tag_cloud', array( $this, 'multiloquent_add_tag_class'));
        // filters
        add_filter('the_content', array(
            $this,
            'multiloquent_featured_image_in_feed'
        ));
        // add_filter('post_class', array($this, 'multiloquent_remove_hentry_function'), 20);
        // add_filter('the_tags', 'multiloquent_add_class_the_tags', 10, 1);
        add_filter('widget_tag_cloud_args', array(
            $this,
            'multiloquent_widget_tag_cloud_args'
        ));
        add_filter('wp_tag_cloud', array(
            $this,
            'multiloquent_tag_cloud_filter'
        ), 10, 2);
        add_filter('get_avatar', array(
            $this,
            'multiloquent_get_avatar'
        ));
        add_filter('widget_text', 'do_shortcode');
        // misc
        if (is_admin()) {
            add_editor_style('style.css');
        }
        $this->multiloquent_menu();
        set_post_thumbnail_size(605, 100);
        add_image_size('featured-post-thumbnail', 605, 100);
        if ( ! isset($content_width)) {
            $content_width = 900;
        }
        // sidebars
        add_action('widgets_init', array(
            $this,
            'multiloquent_generate_sidebars'
        ));
    }

    /**
     * adds the featured image to the rss feed
     *
     * @internal internal
     * @param string $content            
     * @return string
     */
    function multiloquent_featured_image_in_feed($content) {
        global $post;
        if (is_feed()) {
            if (has_post_thumbnail($post->ID)) {
                $output = get_the_post_thumbnail($post->ID, 'medium', array(
                    'style' => 'float:right; margin:0 0 10px 10px;'
                ));
                $content = $output . $content;
            }
        }
        return $content;
    }

    /**
     * includes the name of the php file passed.
     * - includes the name of the php file passed. Uses require_once().
     * - limitations: cant pass the file extension, only includes php files.
     * - eg: multiloquent_get_template_part('somefile'); to include somefile.php
     * @api
     *
     * @param string $file
     *            name of file to include, excluding .php extension
     * @global object $post the wordpress post object
     */
    function multiloquent_get_template_part($file) {
        // needed for the included files...
        global $post;
        require_once trailingslashit(get_template_directory()) . $file . '.php';
    }

    /**
     * adds the multiloquent custom controls for wp customise api
     * @api
     *
     * @param object $wp_customize            
     */
    function multiloquent_customize_register($wp_customize) {
        $wp_customize->add_section('multiloquent_settings', array(
            'title' => __('Multiloquent Settings', 'multiloquent'),
            'priority' => 30
        ));
        $this->multiloquent_register_and_generate_custom_control('paralax_featured', 'paralax_featured', 'default', __('Excerpt or tags in featured posts', 'multiloquent'), $wp_customize, 'multiloquent_settings');
        $this->multiloquent_register_and_generate_custom_control('bootswatch', 'bootswatch', 'default', __('bootswatch', 'multiloquent'), $wp_customize, 'colors');
        $this->multiloquent_register_and_generate_custom_control('colour', 'mulitloquent_navbar', '#F8F8F8', __('Main Elements Background Color', 'multiloquent'), $wp_customize, 'colors');
        $this->multiloquent_register_and_generate_custom_control('colour', 'mulitloquent_navbar_text', '#777777', __('Main Elements Text Color', 'multiloquent'), $wp_customize, 'colors');
        $this->multiloquent_register_and_generate_custom_control('colour', 'mulitloquent_navbar_link', '#777777', __('Main Elements Link Color', 'multiloquent'), $wp_customize, 'colors');
        $this->multiloquent_register_and_generate_custom_control('colour', 'mulitloquent_background_colour', '#FFFFFF', __('Body Background Color', 'multiloquent'), $wp_customize, 'colors');
        $this->multiloquent_register_and_generate_custom_control('colour', 'mulitloquent_background_text_colour', '#333333', __('Body Text Color', 'multiloquent'), $wp_customize, 'colors');
        $this->multiloquent_register_and_generate_custom_control('colour', 'mulitloquent_slideout_menu_colour', '#333333', __('Slide Menu Background Color', 'multiloquent'), $wp_customize, 'colors');
        $this->multiloquent_register_and_generate_custom_control('colour', 'mulitloquent_slideout_text_colour', '#FFFFFF', __('Slide Menu Text Color', 'multiloquent'), $wp_customize, 'colors');
    }

    /**
     * registers and generates the custom controls for wp customise api
     *
     * @internal internal
     * @see multiloquent_customize_register();
     * @param string $setting_type            
     * @param string $setting_name            
     * @param string $default            
     * @param string $label            
     * @param object $wp_customize            
     * @param string $section            
     */
    function multiloquent_register_and_generate_custom_control($setting_type, $setting_name, $default, $label, $wp_customize, $section) {
        $wp_customize->add_setting($setting_name, array(
            'default' => $default,
            'transport' => 'refresh',
            'sanitize_callback' => 'esc_attr'
        ));
        if ($setting_type == 'colour') {
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $setting_name, array(
                'label' => $label,
                'section' => $section,
                'settings' => $setting_name
            )));
        }
        if ($setting_type == 'bootswatch') {
            $wp_customize->add_control($setting_name, array(
                'label' => __('Select Bootswatch style:', 'multiloquent'),
                'section' => $section,
                'type' => 'select',
                'choices' => array(
                    'default' => 'multiloquent',
                    'bootstrap' => 'bootstrap',
                    'cerulean' => 'cerulean',
                    'cosmo' => 'cosmo',
                    'cyborg' => 'cyborg',
                    'darkly' => 'darkly',
                    'flatly' => 'flatly',
                    'journal' => 'journal',
                    'lumen' => 'lumen',
                    'paper' => 'paper',
                    'readable' => 'readable',
                    'sandstone' => 'sandstone',
                    'simplex' => 'simplex',
                    'slate' => 'slate',
                    'spacelab' => 'spacelab',
                    'superhero' => 'superhero',
                    'united' => 'united',
                    'yeti' => 'yeti'
                )
            ));
        }
        if ($setting_type == 'paralax_featured') {
            $wp_customize->add_control($setting_name, array(
                'label' => __('Select Featured posts style:', 'multiloquent'),
                'section' => $section,
                'type' => 'select',
                'choices' => array(
                    'empty' => 'empty',
                    'default' => 'tags',
                    'excerpt' => 'excerpt'
                )
            ));
        }
    }

    /**
     * return true if there is a bootswatch other than the default one and a value is set against the checked item,
     * or if the value is set and its not the default value [we might need to use the default values if they have a
     * different bootswatch theme set]
     * ie, if bootswatch is set to 'darkly' and the multiloquent_navbar is set to the default value, show it
     * or if the bootswatch is set to the default value and the multiloquent_navbar is not the default value, show it
     * or if the bootswatch is set to the default value and the multiloquent_navbar is the default value, dont show it
     *
     * @param string $item            
     * @param string $default_value            
     * @param array $mods            
     * @return boolean
     */
    function multiloquent_check_theme_mod_colour($item, $default_value, $mods) {
        if (( ! empty($mods['bootswatch']) && $mods['bootswatch'] != 'default' &&  ! empty($mods[$item])) || ( ! empty($mods[$item]) && $mods[$item] != $default_value)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * outputs the custom css for the wp customise API
     *
     * @internal internal
     * @todo make this return, rather than echo
     */
    function multiloquent_customize_css() {
        $output = '';
        $mods = get_theme_mods();
        if ($this->multiloquent_check_theme_mod_colour('mulitloquent_navbar', '#F8F8F8', $mods)) {
            $output .= '.navbar-default,.navbar-default .navbar-brand,.navbar-form,.jumbotron,.well,.breadcrumb,.comments, .navbar-default a:hover { ';
            $output .= 'background: ' . esc_attr(get_theme_mod('mulitloquent_navbar')) . '!important;';
            $output .= '}' . "\r\n";
        }
        if ($this->multiloquent_check_theme_mod_colour('mulitloquent_navbar_text', '#777777', $mods)) {
            $output .= '.navbar-default,.navbar-default .navbar-brand,.navbar-form,.jumbotron,.well,.breadcrumb,.comments, .navbar-default a:hover { ';
            $output .= 'color: ' . esc_attr(get_theme_mod('mulitloquent_navbar_text')) . '!important;';
            $output .= '}' . "\r\n";
        }
        if ($this->multiloquent_check_theme_mod_colour('mulitloquent_background_colour', '#FFFFFF', $mods)) {
            $output .= '.wrapper,.featured-posts { ';
            $output .= 'background: ' . esc_attr(get_theme_mod('mulitloquent_background_colour')) . ';';
            $output .= '}' . "\r\n";
        }
        if ($this->multiloquent_check_theme_mod_colour('mulitloquent_background_text_colour', '#333333', $mods)) {
            $output .= '.wrapper,.featured-posts { ';
            $output .= 'color: ' . esc_attr(get_theme_mod('mulitloquent_background_text_colour')) . ';';
            $output .= '}' . "\r\n";
        }
        if ($this->multiloquent_check_theme_mod_colour('mulitloquent_slideout_menu_colour', '#333333', $mods)) {
            $output .= 'body {';
            $output .= 'background: ' . esc_attr(get_theme_mod('mulitloquent_slideout_menu_colour')) . ';';
            $output .= '}' . "\r\n";
        }
        if ($this->multiloquent_check_theme_mod_colour('mulitloquent_background_text_colour', '#333333', $mods)) {
            $output .= 'body {';
            $output .= 'color: ' . esc_attr(get_theme_mod('mulitloquent_background_text_colour')) . ';';
            $output .= '}' . "\r\n";
        }
        if ($this->multiloquent_check_theme_mod_colour('mulitloquent_slideout_text_colour', '#FFFFFF', $mods)) {
            $output .= '.sidebar,.sidebar a {';
            $output .= 'color: ' . esc_attr(get_theme_mod('mulitloquent_slideout_text_colour')) . ';';
            $output .= '}' . "\r\n";
        }
        if ($this->multiloquent_check_theme_mod_colour('mulitloquent_navbar_text', '#777777', $mods)) {
            $output .= '.jumbotron .nav-header,.well .nav-header {';
            $output .= 'color: ' . esc_attr(get_theme_mod('mulitloquent_navbar_text')) . ';';
            $output .= '}' . "\r\n";
        }
        if ($this->multiloquent_check_theme_mod_colour('mulitloquent_navbar_link', '#777777', $mods)) {
            $output .= '.breadcrumb a,.breadcrumb a:hover,.breadcrumb a:visited,.comments a,.comments a:hover,.comments a:visited,.well a,.well a:hover,.well a:visited,.jumbotron a:visited,.jumbotron a,.jumbotron a:hover {';
            $output .= 'color: ' . esc_attr(get_theme_mod('mulitloquent_navbar_link')) . ';';
            $output .= '}' . "\r\n";
        }
        // if there is any output, render it
        if ( ! empty($output)) {
            echo '<style type="text/css">' . $output . '</style>';
        }
    }

    /**
     * enqueue the required javascript libraries.
     * - menu.js - custom built menu javascript for pop out menu
     * - bootstrap javascript library
     *
     * @internal internal
     */
    function multiloquent_scripts_method() {
        wp_enqueue_script('menu', get_template_directory_uri() . '/menu.js', array(
            'jquery'
        ), '', true);
        wp_enqueue_script('bootstrap', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array(
            'jquery'
        ), '', true);
    }

    /**
     * enqueue the stylesheets
     * - bootstrap css
     * - font awesome css
     * - style css [WordPress required with custom overrides for bootstrap]
     * - print css [custom overrides for printing]
     *
     * @internal internal
     */
    function multiloquent_stylesheet_method() {
        // todo - make is use the default one if none are set
        $mods = get_theme_mods();
        if ( ! empty($mods['bootswatch']) && $mods['bootswatch'] != 'default') {
            wp_enqueue_style('bootstrap', get_template_directory_uri() . '/bootstrap/css/' . esc_attr(get_theme_mod('bootswatch')) . '/bootstrap.min.css');
            wp_enqueue_style('style', get_stylesheet_uri());
        } else {
            wp_enqueue_style('bootstrap', get_template_directory_uri() . '/bootstrap/css/multiloquent/bootstrap.min.css');
            wp_enqueue_style('style', get_stylesheet_uri());
            // use my custom bootstrap overrides
            wp_enqueue_style('multiloquent', get_template_directory_uri() . '/bootstrap/css/multiloquent/style.css');
        }
        wp_enqueue_style('font-awesome', get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css');
        wp_enqueue_style('print', get_template_directory_uri() . '/print.css');
    }

    /**
     * registers the WordPress menu location
     *
     * @internal internal
     */
    function multiloquent_menu() {
        register_nav_menu('primary-menu', 'Primary Menu');
    }

    /**
     * generates the sidebars
     */
    function multiloquent_generate_sidebars() {
        $sidebars = array(
            '1' => 'sidebar top',
            '2' => 'mobile specific advert',
            '3' => 'non-mobile specific advert',
            '4' => 'sidebar middle',
            '5' => 'sidebar bottom',
            '6' => 'footer top left',
            '7' => 'footer top right',
            '8' => 'social media',
            '9' => 'footer bottom left',
            '10' => 'footer bottom right'
        );
        foreach ($sidebars as $key => $name) {
            $args = array(
                'id' => 'sidebar-' . $key,
                'name' => $name . ' sidebar',
                'description' => $name . ' sidebar',
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '<p class="nav-header">',
                'after_title' => '</p>',
                'class' => ''
            );
            register_sidebar($args);
        }
    }

    /**
     * removes css classes from the passed string
     * @api
     *
     * @param array $classes            
     * @return array
     */
    function multiloquent_remove_hentry_function($classes) {
        // if (($key = array_search('hentry', $classes)) !== false) {
        // unset($classes[$key]);
        // }
        return $classes;
    }

    /**
     * adds a css class to the tag
     * @api
     *
     * @param string $html            
     * @return string
     */
    function multiloquent_add_class_the_tags($html) {
        $html = str_replace('<a', '<a class="label"', $html);
        return $html;
    }

    /**
     * generates a tag cloud
     *
     * @param array $args            
     * @return array
     * @internal internal
     */
    function multiloquent_widget_tag_cloud_args($args) {
        $args['number'] = 20;
        // show less tags
        $args['largest'] = 20;
        $args['smallest'] = 8;
        $args['unit'] = 'pt';
        return $args;
    }

    /**
     * wrapper for the post title, if it has no title, supply one
     * @api
     *
     * @param int $post_id            
     * @return string
     * @example multiloquent_post_title(12);
     */
    function multiloquent_post_title($post_id = 0) {
        if ( ! empty($post_id)) {
            $the_title = get_the_title($post_id);
        } else {
            $the_title = get_the_title();
        }
        if (empty($the_title)) {
            return __('Untitled Post', 'multiloquent');
        }
        return $the_title;
    }

    /**
     * wraps the tag cloud in a div
     * @api
     *
     * @param string $tag_cloud            
     * @return string
     */
    function multiloquent_tag_cloud_filter($tag_cloud) {
        return '<div id="tag-cloud">' . $tag_cloud . '</div>';
    }

    /**
     * outputs the breadcrumb
     * @api
     *
     * @return string
     */
    function multiloquent_breadcrumbs() {
        global $post;
        $return = '';
        // $image_url = get_template_directory_uri() ;
        if ( ! is_home()) {
            $return .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
            $return .= '<a itemprop="item" href="';
            $return .= home_url();
            $return .= '">';
            $return .= '<span itemprop="name">';
            $return .= __('Home', 'multiloquent');
            $return .= '</span>';
            $return .= '</a>';
            $return .= '</li>';
        }
        if (is_category() || (is_single() &&  ! is_attachment())) {
            $category = get_the_category();
            $cat_id = $category[0]->cat_ID;
            $category_parents = get_category_parents($cat_id, false, ':::', false);
            $category_slug = explode(':::', $category_parents);
            foreach ($category_slug as $category => $slug) {
                $current_category = '';
                $current_category = get_category_by_slug($slug);
                if ( ! empty($slug) &&  ! empty($current_category)) {
                    $return .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
                    $return .= '<a itemprop="item" href="/' . $current_category->slug . '">';
                    $return .= '<span itemprop="name">' . $current_category->name . '</span>';
                    $return .= '</a>';
                    $return .= '</li>';
                }
            }
        }
        if (is_single()) {
            $return .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">' . $this->multiloquent_post_title() . '</li>';
        }
        if (is_page()) {
            $return .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">' . $this->multiloquent_post_title() . '</li>';
        }
        if (is_tag()) {
            $return .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">' . __('Tag: ', 'multiloquent') . single_tag_title('', false) . '</li>';
        }
        if (is_404()) {
            $return .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">' . __('404 - Page not Found', 'multiloquent') . '<li>';
        }
        if (is_search()) {
            $return .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">Search</li>';
        }
        if (is_year()) {
            $return .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">' . get_the_time('Y') . '</li>';
        }
        return $return;
    }

    /**
     * returns a random class from the list
     * @api
     *
     * @param string $class            
     * @return string <string>
     */
    function multiloquent_get_random_solid_class($class = '') {
        $mods = get_theme_mods();
        if ( ! empty($mods['bootswatch']) && $mods['bootswatch'] != 'default') {
            // if it uses one of the bootswatch themes, use the bootstrap colours
            $input = array(
                'label-primary',
                'label-success',
                'label-warning',
                'label-info',
                'label-danger',
                'label-default'
            );
        } else {
            $input = array(
                'swatch-red',
                'swatch-orange',
                'swatch-yellow',
                'swatch-green',
                'swatch-teal',
                'swatch-blue',
                'swatch-violet',
                'swatch-pink',
                'swatch-mid-gray',
                'swatch-gray'
            );
        }
        $apps = array(
            'phone',
            'appstore',
            'calculator',
            'compass',
            'itunes',
            'mail',
            'music',
            'weather',
            'maps',
            'videos',
            'notes',
            'reminders',
            'calendar',
            'facebook',
            'google',
            'twitter',
            'linkedin',
            'finder',
            'safari',
            'firefox'
        );
        if ( ! empty($class) && in_array($class, $apps)) {
            return $tile_colour = $class;
        } else {
            $rand_keys = array_rand($input);
            return $tile_colour = $input[$rand_keys];
        }
    }

    /**
     * returns a random value from the list
     * @api
     *
     * @return string
     */
    function multiloquent_get_random_blue_class() {
        $mods = get_theme_mods();
        if ( ! empty($mods['bootswatch']) && $mods['bootswatch'] != 'default') {
            // if it uses one of the bootswatch themes, use the bootstrap colours
            $input = array(
                'label-primary',
                'label-success',
                'label-warning',
                'label-info',
                'label-danger',
                'label-default'
            );
        } else {
            $input = array(
                'swatch-blue1',
                'swatch-blue2',
                'swatch-blue3',
                'swatch-blue4',
                'swatch-blue5',
                'swatch-blue',
                'swatch-gray',
                'swatch-violet'
            );
        }
        $apps = array(
            'phone',
            'appstore',
            'calculator',
            'compass',
            'itunes',
            'mail',
            'music',
            'weather',
            'maps',
            'videos',
            'notes',
            'reminders',
            'calendar',
            'facebook',
            'google',
            'twitter',
            'linkedin',
            'finder',
            'safari',
            'firefox'
        );
        if ( ! empty($class) && in_array($class, $apps)) {
            return $tile_colour = $class;
        } else {
            $rand_keys = array_rand($input);
            return $tile_colour = $input[$rand_keys];
        }
    }

    /**
     * returns a random string from the list
     * @api
     *
     * @param string $class            
     * @return string Ambigous
     */
    function multiloquent_get_random_colour_class($class = '') {
        $mods = get_theme_mods();
        if ( ! empty($mods['bootswatch']) && $mods['bootswatch'] != 'default') {
            // if it uses one of the bootswatch themes, use the bootstrap colours
            $input = array(
                'label-primary',
                'label-success',
                'label-warning',
                'label-info',
                'label-danger',
                'label-default'
            );
        } else {
            $input = array(
                'gradient-red',
                'gradient-orange',
                'gradient-yellow',
                'gradient-green',
                'gradient-teal',
                'gradient-blue',
                'gradient-violet',
                'gradient-magenta',
                'gradient-black',
                'gradient-silver'
            );
        }
        $apps = array(
            'phone',
            'appstore',
            'calculator',
            'compass',
            'itunes',
            'mail',
            'music',
            'weather',
            'maps',
            'videos',
            'notes',
            'reminders',
            'calendar',
            'facebook',
            'google',
            'twitter',
            'linkedin',
            'finder',
            'safari',
            'firefox'
        );
        if ( ! empty($class) && in_array($class, $apps)) {
            return $tile_colour = $class;
        } else {
            $rand_keys = array_rand($input);
            return $tile_colour = $input[$rand_keys];
        }
    }

    /**
     * outputs the category list as a hierarchy
     * @api
     *
     * @param string $cat            
     * @return string
     */
    function multiloquent_category_list_as_hierarchy($cat = '0') {
        $tags = get_categories('hide_empty=true&orderby=name&order=ASC&parent=' . $cat);
        // Output a wrapper so that our arrays will be contained in 4 columns.
        $html = '';
        if ($tags) {
            // Output the markup for each tag found for each character.
            // in here I need to recurse down
            $old_tile_colour = $this->multiloquent_get_random_blue_class();
            foreach ((array) $tags as $tag) {
                // set the old colour so I can re-set it at the bottom
                $new_tile_colour = $this->multiloquent_get_random_solid_class($tag->slug);
                // fetch the new colour, if the returned string matches the slug, then set the tile_colour to it,
                // otherwise,
                // set it to the old one which is only set before this loop
                if ($new_tile_colour == $tag->slug) {
                    $tile_colour = $new_tile_colour;
                } else {
                    $tile_colour = $old_tile_colour;
                }
                if ($cat == '0') {
                    $html .= '<ul class="thumbnails row">';
                }
                $tag_link = get_category_link($tag->term_id);
                if (strlen($tag->name) > '30') {
                    $html .= '<li class="tag-item tile tile-double double-height col-sm-6 col-md-4 col-lg-3 ' . $tile_colour . '"onclick="javascript:window.location.href=';
                    $html .= "'" . $tag_link . "'";
                    $html .= '" >';
                } elseif (strlen($tag->name) > '10') {
                    $html .= '<li class="tag-item tile tile-double col-sm-6 col-md-4 col-lg-3 ' . $tile_colour . '"onclick="javascript:window.location.href=';
                    $html .= "'" . $tag_link . "'";
                    $html .= '" >';
                } elseif (strlen($tag->name) > '5') {
                    $html .= '<li class="tag-item tile tile-double col-sm-6 col-md-4 col-lg-3 ' . $tile_colour . '"onclick="javascript:window.location.href=';
                    $html .= "'" . $tag_link . "'";
                    $html .= '" >';
                } else {
                    $html .= '<li class="tag-item tile col-sm-6 col-md-4 col-lg-3 ' . $tile_colour . '"onclick="javascript:window.location.href=';
                    $html .= "'" . $tag_link . "'";
                    $html .= '" >';
                }
                if (strlen($tag->name) > '30') {
                    $html .= '<h2 class="nowrap"><a href="' . $tag_link . '" title="View the article tagged ' . $tag->name . '" >' . $tag->name . '</a></h2>';
                } elseif (strlen($tag->name) > '10') {
                    $html .= '<h3><a href="' . $tag_link . '" title="View the article tagged ' . $tag->name . '" >' . $tag->name . '</a></h3>';
                } else {
                    $html .= '<h2><a href="' . $tag_link . '" title="View the article tagged ' . $tag->name . '" >' . $tag->name . '</a></h2>';
                }
                $html .= '<span class="badge">' . $tag->count . '</span>';
                $html .= '</li>';
                $html .= $this->multiloquent_category_list_as_hierarchy($tag->term_id);
                if ($cat == '0') {
                    $html .= '</ul>';
                }
            }
        }
        return $html;
    }

    /**
     * generates the homepage featured posts box
     * @api
     *
     * @return string
     */
    function multiloquent_paralax_slider() {
        global $wpdb;
        $total_posts = '5';
        
        if (function_exists('get_tptn_pop_posts')) {
            $args = array(
                'daily' => false,
                'strict_limit' => true,
                'posts_only' => false,
                'limit' => 5,
                'posts_only' => true
            );
            // todo - this needs to be an array of objects..
            $top_ten_post_array = get_tptn_pop_posts($args);
            $posts_to_get = '';
            foreach ($top_ten_post_array as $post => $val) {
                $posts_to_get[] = $val['ID'];
            }
            $args = array(
                'post__in' => $posts_to_get
            );
            $recent_posts = get_posts($args);
        } else {
            $args = array(
                'numberposts' => $total_posts,
                'offset' => 0,
                'category' => '',
                'orderby' => 'post_date',
                'order' => 'DESC',
                'include' => '',
                'exclude' => '',
                'post_type' => 'post',
                'post_status' => 'publish'
            );
            $recent_posts = get_posts($args);
        }
        $count = 1;
        $output = '<div class="container mb">';
        foreach ($recent_posts as $val) {
            $slider_image = wp_get_attachment_image_src(get_post_thumbnail_id($val->ID), 'single-post-thumbnail');
            if ($slider_image) {
                $theimg = $slider_image[0];
            } else {
                $theimg = get_header_image();
            }
            $colour = $this->multiloquent_get_random_blue_class();
            if ($count == '1') {
                $output .= '<div class="paralax_image_holder float_left col-sm-8 col-md-8 col-lg-8 alpha omega doubleheight"> ';
                $output .= '<span style="background-image:url(' . $theimg . ');" class="grayscale"></span>';
                $output .= '<div class="paralax_image_bg doubleheight ' . $colour . '"></div>';
            }
            if ($count == '2') {
                $output .= '<div class="paralax_image_holder float_left col-sm-4 col-md-4 col-lg-4 alpha omega"> ';
                $output .= '<span style="background-image:url(' . $theimg . ');" class="grayscale"></span>';
                $output .= '<div class="paralax_image_bg ' . $colour . '"></div>';
            }
            if ($count == '3') {
                $output .= '<div class="paralax_image_holder float_left col-sm-4 col-md-4 col-lg-4 alpha omega"> ';
                $output .= '<span style="background-image:url(' . $theimg . ');" class="grayscale"></span>';
                $output .= '<div class="paralax_image_bg ' . $colour . '"></div>';
            }
            if ($count == '4') {
                $output .= '<div class="paralax_image_holder float_left col-sm-4 col-md-4 col-lg-4 alpha omega"> ';
                $output .= '<span style="background-image:url(' . $theimg . ');" class="grayscale"></span>';
                $output .= '<div class="paralax_image_bg ' . $colour . '"></div>';
            }
            if ($count == '5') {
                $output .= '<div class="paralax_image_holder float_left col-sm-8 col-md-8 col-lg-8 alpha omega"> ';
                $output .= '<span style="background-image:url(' . $theimg . ');" class="grayscale"></span>';
                $output .= '<div class="paralax_image_bg ' . $colour . '"></div>';
            }
            $output .= '<div class="paralax_image_text"><span class="h1"><a href="' . get_permalink($val->ID) . '">' . trim(stripslashes($this->multiloquent_post_title($val->ID))) . '</a></span>';
            $output .= '<p>';
            // get tags function call in here
            $output .= $this->multiloquent_render_tags($val);
            $output .= '</p>';
            $output .= '</div>';
            $output .= '</div>';
            $count ++;
        }
        $output .= '</div>';
        return $output;
    }

    /**
     * generates the featured posts mini-boxes
     * @api
     *
     * @return string
     */
    function multiloquent_paralax_featured_sliders() {
        global $wpdb;
        $total_posts = '4';
        $posts_to_get = '';
    if (function_exists('get_tptn_pop_posts')) {
            $args = array(
                'daily' => false,
                'strict_limit' => true,
                'posts_only' => false,
                'limit' => 4,
                'posts_only' => true
            );
            // todo - this needs to be an array of objects..
            $top_ten_post_array = get_tptn_pop_posts($args);
            $posts_to_get = '';
            foreach ($top_ten_post_array as $post => $val) {
                $posts_to_get[] = $val['ID'];
            }
            $args = array(
                'post__in' => $posts_to_get
            );
            $recent_posts = get_posts($args);
        }  else {
            $args = array(
                'numberposts' => $total_posts,
                'offset' => 0,
                'category' => '',
                'orderby' => 'post_date',
                'order' => 'DESC',
                'include' => '',
                'exclude' => '',
                'post_type' => 'post',
                'post_status' => 'publish'
            );
            $recent_posts = get_posts($args);
        }
        $count = 1;
        $output = '<div class="featured-posts">';
        $colour = $this->multiloquent_get_random_blue_class();
        foreach ($recent_posts as $val) {
            $slider_image = wp_get_attachment_image_src(get_post_thumbnail_id($val->ID), 'single-post-thumbnail');
            if ($slider_image) {
                $theimg = $slider_image[0];
            } else {
                $theimg = get_header_image();
            }
            if ($count == '1' || $count == '2') {
                $output .= '<div class="paralax_image_holder halfheight col-sm-6 col-md-3 col-lg-3 alpha omega">';
            } else {
                $output .= '<div class="paralax_image_holder halfheight hidden-xs hidden-sm col-md-3 col-lg-3 alpha omega">';
            }
            $output .= '<span style="background-image:url(' . $theimg . ');" class="grayscale"></span>';
            $output .= '<div class="paralax_image_bg halfheight ' . $colour . '"></div>';
            $output .= '<div class="paralax_image_text halfheight">';
            $output .= '<span class="h1"><a href="' . get_permalink($val->ID) . '">' . $this->multiloquent_post_title($val->ID) . '</a></span>';
            $output .= '</div></div>';
            $count ++;
        }
        $output .= '</div>';
        return $output;
    }

    /**
     * gets the users avatar
     * @api
     *
     * @param string $avatar            
     * @return mixed
     */
    function multiloquent_get_avatar($avatar) {
        $avatar = str_replace("class='avatar", "class='avatar img-responsive center-block", $avatar);
        return $avatar;
    }

    /**
     * renders the archive lists in the colour supplied
     *
     * @api
     *
     * @param string $colour            
     * @todo make this return rather than echo
     * @see multiloquent_get_random_colour_class()
     * @see multiloquent_get_random_solid_class()
     * @see multiloquent_get_random_blue_class()
     */
    function multiloquent_render_the_archive($colour) {
        // set it to blank so that it doesnt get the previous one..
        global $post;
        $thumbnail_id = get_the_ID();
        $slider_image = wp_get_attachment_image_src(get_post_thumbnail_id($thumbnail_id), 'single-post-thumbnail');
        if ( ! empty($slider_image)) {
            $the_image = $slider_image[0];
            // $width = $slider_image[1];
            // $height = $slider_image[2];
            // in here I need to check if its a mobile, and then give a different image:
        } else {
            $the_image = get_header_image();
        }
        ?>
<div class="paralax_image_holder col-sm-6 col-md-4 col-lg-4" style="margin-bottom: 30px;">
    <span style="background-image:url('<?php echo $the_image ?>');" class="grayscale"></span>
    <div class="paralax_image_bg <?php echo $colour ?>"></div>
    <div class="paralax_image_text">
        <span class="h1"> <a href="<?php the_permalink() ?>">
                        <?php
        echo $this->multiloquent_post_title();
        ?>
                    </a>
        </span>
        <p>
                    <?php echo $this->multiloquent_render_tags($post); ?>
                </p>
    </div>
</div>
<?php
    }

    /**
     * renders the tags or the excerpt for the supplied post id, depending on the setting in the wp_customize setting
     * @api
     *
     * @param object $val            
     * @param bool $force_tags
     *            (set to true to force tag output)
     * @return string
     */
    function multiloquent_render_tags($val, $force_tags = false) {
        $output = '';
        // check if they have selected tags or excerpt
        $mods = get_theme_mods();
        if ( ! empty($mods['paralax_featured']) && $mods['paralax_featured'] == 'excerpt' && empty($force_tags)) {
            // they have selected 'excerpt'
            // $excerpt = apply_filters( 'get_the_excerpt', $val->post_excerpt );
            $excerpt = wp_trim_words(apply_filters('the_excerpt', $val->post_excerpt));
            if (empty($excerpt)) {
                $excerpt = wp_trim_words($val->post_content);
            }
            $output .= $excerpt;
        } elseif ( ! empty($mods['paralax_featured']) && $mods['paralax_featured'] == 'empty' && empty($force_tags)) {
            // dont output anything, leave the tags thing empty, append nothing to the output to fool the wordpress
            // coding standards
            $output .= '';
        } else {
            $posttags = wp_get_post_tags($val->ID);
            if ($posttags) {
                foreach ($posttags as $tag) {
                    $output .= '<a class="label ';
                    $output .= $this->multiloquent_get_random_solid_class($tag->slug);
                    $output .= '" href="' . get_tag_link($tag->term_id) . '"><span class="fa fa-folder-o fa-fw"></span> ' . $tag->name . '</a>';
                }
            }
        }
        return $output;
    }
}
global $multiloquent;
$multiloquent = new MultiloquentBase();
