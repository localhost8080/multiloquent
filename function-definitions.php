<?php

/**
 * Returns a version number
 *
 * @return string
 */
function multiloquent_version()
{
    $version = '6.1.01';
    return $version;
}

function multiloquent_get_template_part($file)
{
    global $post;
    require_once (trailingslashit(get_template_directory()) . $file . '.php');
}

function multiloquent_featured_image_in_feed($content)
{
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

function multiloquent_customize_register($wp_customize)
{
    multiloquent_register_and_generate_custom_control('mulitloquent_navbar', '#F8F8F8', 'Background Color', $wp_customize, 'colors');
    multiloquent_register_and_generate_custom_control('mulitloquent_navbar_text', '#777777', 'Text Color', $wp_customize, 'colors');
    multiloquent_register_and_generate_custom_control('mulitloquent_navbar_border', '#E7E7E7', 'Border Color', $wp_customize, 'colors');
    multiloquent_register_and_generate_custom_control('mulitloquent_navbar_link', '#777777', 'Link Color', $wp_customize, 'colors');
}

function multiloquent_register_and_generate_custom_control($setting_name, $default, $label, $wp_customize, $section)
{
    $wp_customize->add_setting($setting_name, array(
        'default' => $default,
        'transport' => 'refresh'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $setting_name, array(
        'label' => $label,
        'section' => $section,
        'settings' => $setting_name
    )));
}

function multiloquent_customize_css()
{
    ?>
<style type="text/css">
.navbar-default,.navbar-default .navbar-brand,.navbar-form,#search_form,.jumbotron,.well,.breadcrumb,.comments {
    background: <?php echo get_theme_mod('mulitloquent_navbar'); ?>! important;
    color: <?php
    
echo get_theme_mod('mulitloquent_navbar_text');
    ?>;
}

.jumbotron .nav-header,.well .nav-header {
    color: <?php
    
echo get_theme_mod('mulitloquent_navbar_text');
    ?>;
}

.breadcrumb a,.breadcrumb a:hover,.breadcrumb a:visited,.comments a,.comments a:hover,.comments a:visited,.well a,.well a:hover,.well a:visited,.jumbotron a:visited,.jumbotron a,.jumbotron a:hover {
    color: <?php
    
echo get_theme_mod('mulitloquent_navbar_link');
    ?>;
}

.navbar-fixed-top {
    border-bottom: 1px solid<?php
    
echo get_theme_mod('mulitloquent_navbar_border');
    ?>;
}

.navbar-fixed-bottom {
    border-top: 1px solid<?php
    
echo get_theme_mod('mulitloquent_navbar_border');
    ?>;
}

#search_form input,.navbar-form input {
    border: 1px solid<?php
    
echo get_theme_mod('mulitloquent_navbar_border');
    ?>;
}
</style>
<?php
}

function multiloquent_scripts_method()
{
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array(
        'jquery'
    ));
}

function multiloquent_stylesheet_method()
{
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css');
    wp_enqueue_style('font-awesome-css', get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css');
    wp_enqueue_style('style-css', get_stylesheet_uri());
    wp_enqueue_style('print-css', get_template_directory_uri() . '/print.css');
}

function multiloquent_register()
{
    // theme support
    add_theme_support('automatic-feed-links');
    add_theme_support('html5');
    add_theme_support('post-thumbnails');
    // actions
    add_action('wp_enqueue_scripts', 'multiloquent_scripts_method');
    add_action('wp_enqueue_scripts', 'multiloquent_stylesheet_method');
    add_action('customize_register', 'multiloquent_customize_register');
    add_action('wp_tag_cloud', 'multiloquent_add_tag_class');
    // filters
    add_filter('the_content', 'multiloquent_featured_image_in_feed');
    add_filter('post_class', 'multiloquent_remove_hentry_function', 20);
    add_filter('the_tags', 'multiloquent_add_class_the_tags', 10, 1);
    add_filter('widget_tag_cloud_args', 'multiloquent_widget_tag_cloud_args');
    add_filter('wp_tag_cloud', 'multiloquent_tag_cloud_filter', 10, 2);
    add_filter('get_avatar', 'multiloquent_get_avatar');
    // misc
    if (is_admin()) {
        add_editor_style('style.css');
    }
    set_post_thumbnail_size(605, 100);
    add_image_size('featured-post-thumbnail', 605, 100);
    if (! isset($content_width)) {
        $content_width = 900;
    }
    // sidebars
    $sidebars = array(
        '1' => 'top navigation',
        '2' => 'mobile specific advert',
        '3' => 'non-mobile specific advert',
        '4' => 'above footer top left',
        '5' => 'above footer top right',
        '6' => 'above footer bottom left',
        '7' => 'above footer bottom right',
        '8' => 'social media',
        '9' => 'footer middle',
        '10' => 'footer right'
    );
    multiloquent_generate_sidebars($sidebars);
}

function multiloquent_generate_sidebars($array)
{
    foreach ($array as $name) {
        $args = array(
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

function multiloquent_remove_hentry_function($classes)
{
    if (($key = array_search('hentry', $classes)) !== false) {
        unset($classes[$key]);
    }
    return $classes;
}

function multiloquent_add_class_the_tags($html)
{
    $html = str_replace('<a', '<a class="label"', $html);
    return $html;
}

function multiloquent_widget_tag_cloud_args($args)
{
    $args['number'] = 20; // show less tags
    $args['largest'] = 9.75; // make largest and smallest the same - i don't like the varying font-size look
    $args['smallest'] = 9.75;
    $args['unit'] = 'px';
    return $args;
}
// filter tag clould output so that it can be styled by CSS
function multiloquent_add_tag_class($taglinks)
{
    $tags = explode('</a>', $taglinks);
    $regex = "#(.*tag-link[-])(.*)(' title.*)#e";
    foreach ($tags as $tag) {
        $tagn[] = preg_replace($regex, "('$1$2 label tag-'.get_tag($2)->slug.'$3')", $tag);
    }
    $taglinks = implode('</a>', $tagn);
    return $taglinks;
}

function multiloquent_post_title($post_id = '')
{
    if (! empty($post_id)) {
        $the_title = get_the_title($post_id);
    } else {
        $the_title = get_the_title();
    }
    if (empty($the_title)) {
        return 'Untitled Post';
    }
    return $the_title;
}

function multiloquent_tag_cloud_filter($return)
{
    return '<div id="tag-cloud">' . $return . '</div>';
}

/**
 * outputs the breadcrumb
 */
function multiloquent_breadcrumbs()
{
    $return = '';
    // $image_url = get_template_directory_uri() ;
    if (! is_home()) {
        $return .= '<li><a href="';
        $return .= home_url();
        $return .= '">';
        $return .= 'Home';
        $return .= '</a></li><li>';
    }
    if (is_category() || (is_single() && ! is_attachment())) {
        $category = get_the_category();
        $catID = $category[0]->cat_ID;
        $return .= get_category_parents($catID, true, '</li><li>', false);
    }
    if (is_single()) {
        $return .= multiloquent_post_title() . '</li>';
    }
    if (is_page()) {
        $return .= multiloquent_post_title() . '</li>';
    }
    if (is_tag()) {
        $return .= 'Tag: ' . single_tag_title('', false) . '</li>';
    }
    if (is_404()) {
        $return .= '404 - Page not Found<li>';
    }
    if (is_search()) {
        $return .= 'Search</li>';
    }
    if (is_year()) {
        $return .= get_the_time('Y') . '</li>';
    }
    return $return;
}

function multiloquent_render_pagingation()
{
    global $wp_query;
    $total_pages = $wp_query->max_num_pages;
    // check if search result
    if (get_query_var('paged')) {
        $paged = get_query_var('paged');
    } elseif (get_query_var('page')) {
        $paged = get_query_var('page');
    } else {
        $paged = 1;
    }
    if ($total_pages > 1) {
        $current_page = max(1, get_query_var('paged'));
        echo paginate_links(array(
            'base' => get_pagenum_link(1) . '%_%',
            'posts_per_page' => - 1,
            'current' => $current_page,
            'total' => $total_pages,
            'posts_per_page' => - 1,
            'orderby' => 'date',
            'order' => 'asc',
            'paged' => $paged,
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorias',
                    'field' => 'slug'
                )
            )
        ));
    }
    echo paginate_links();
}

function multiloquent_get_random_solid_class($class = '')
{
    $input = array(
        "swatch-red",
        "swatch-orange",
        "swatch-yellow",
        "swatch-green",
        "swatch-teal",
        "swatch-blue",
        "swatch-violet",
        "swatch-pink",
        "swatch-mid-gray",
        "swatch-gray"
    );
    $apps = array(
        "phone",
        "appstore",
        "calculator",
        "compass",
        "itunes",
        "mail",
        "music",
        "weather",
        "maps",
        "videos",
        "notes",
        "reminders",
        "calendar",
        "facebook",
        "google",
        "twitter",
        "linkedin",
        "finder",
        "safari",
        "firefox"
    );
    if (! empty($class) && in_array($class, $apps)) {
        return $tile_colour = $class;
    } else {
        $rand_keys = array_rand($input);
        return $tile_colour = $input[$rand_keys];
    }
}

function multiloquent_get_random_blue_class()
{
    $input = array(
        "swatch-blue1",
        "swatch-blue2",
        "swatch-blue3",
        "swatch-blue4",
        "swatch-blue5",
        "swatch-blue",
        "swatch-gray",
        "swatch-violet"
    );
    $apps = array(
        "phone",
        "appstore",
        "calculator",
        "compass",
        "itunes",
        "mail",
        "music",
        "weather",
        "maps",
        "videos",
        "notes",
        "reminders",
        "calendar",
        "facebook",
        "google",
        "twitter",
        "linkedin",
        "finder",
        "safari",
        "firefox"
    );
    if (! empty($class) && in_array($class, $apps)) {
        return $tile_colour = $class;
    } else {
        $rand_keys = array_rand($input);
        return $tile_colour = $input[$rand_keys];
    }
}

function multiloquent_get_random_colour_class($class = '')
{
    $input = array(
        "gradient-red",
        "gradient-orange",
        "gradient-yellow",
        "gradient-green",
        "gradient-teal",
        "gradient-blue",
        "gradient-violet",
        "gradient-magenta",
        "gradient-black",
        "gradient-silver"
    );
    $apps = array(
        "phone",
        "appstore",
        "calculator",
        "compass",
        "itunes",
        "mail",
        "music",
        "weather",
        "maps",
        "videos",
        "notes",
        "reminders",
        "calendar",
        "facebook",
        "google",
        "twitter",
        "linkedin",
        "finder",
        "safari",
        "firefox"
    );
    if (! empty($class) && in_array($class, $apps)) {
        return $tile_colour = $class;
    } else {
        $rand_keys = array_rand($input);
        return $tile_colour = $input[$rand_keys];
    }
}

function multiloquent_category_list_as_hierarchy($cat = '0')
{
    $tags = get_categories('hide_empty=true&orderby=name&order=ASC&parent=' . $cat);
    // Output a wrapper so that our arrays will be contained in 4 columns.
    $html = '';
    if ($tags) {
        // Output the markup for each tag found for each character.
        // in here I need to recurse down
        $old_tile_colour = multiloquent_get_random_blue_class();
        foreach ((array) $tags as $tag) {
            // set the old colour so I can re-set it at the bottom
            $new_tile_colour = multiloquent_get_random_solid_class($tag->slug);
            // fetch the new colour, if the returned string matches the slug, then set the tile_colour to it, otherwise,
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
            $html .= "</li>";
            $html .= multiloquent_category_list_as_hierarchy($tag->term_id);
            if ($cat == '0') {
                $html .= '</ul>';
            }
        }
    }
    return $html;
}

function multiloquent_paralax_slider()
{
    global $wpdb;
    $output = '';
    $total_posts = '5';
    if (function_exists('tptn_pop_posts')) {
        $sql = "SELECT postnumber, sum(cntaccess) as sumCount, ID, post_type, post_status, post_content
		FROM wp_top_ten_daily INNER JOIN wp_posts ON postnumber=ID
		AND post_type = 'post'
		AND post_status = 'publish'
		and dp_date BETWEEN SYSDATE() - INTERVAL 30 DAY AND SYSDATE() group by ID
		ORDER BY sumCount DESC LIMIT 5;";
        $recent_posts = $wpdb->get_results($sql);
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
    $output = '<div class="container mb"><div class="row alpha">';
    foreach ($recent_posts as $val) {
        $slider_image = wp_get_attachment_image_src(get_post_thumbnail_id($val->ID), 'single-post-thumbnail');
        ;
        if ($slider_image) {
            $theimg = $slider_image[0];
        } else {
            $theimg = get_template_directory_uri() . '/images/default-slider.png';
        }
        $dimensions = getimagesize($theimg);
        $width = $dimensions[0];
        $height = $dimensions[1];
        if ($count == '1') {
            $output .= '<div class="paralax_image_holder float_left col-sm-8 col-md-8 col-lg-8 alpha omega doubleheight"> ';
            $output .= '<img src="' . $theimg . '" class="grayscale" alt="' . trim(stripslashes(multiloquent_post_title($val->ID))) . '" width="' . $width . '" height="' . $height . '">';
            $output .= '<div class="paralax_image_bg doubleheight swatch-blue4"></div>';
        }
        if ($count == '2') {
            $output .= '<div class="paralax_image_holder float_left col-sm-4 col-md-4 col-lg-4 alpha omega"> ';
            $output .= '<img src="' . $theimg . '" class="grayscale" alt="' . trim(stripslashes(multiloquent_post_title($val->ID))) . '" width="' . $width . '" height="' . $height . '">';
            $output .= '<div class="paralax_image_bg swatch-blue2"></div>';
        }
        if ($count == '3') {
            $output .= '<div class="paralax_image_holder float_left col-sm-4 col-md-4 col-lg-4 alpha omega"> ';
            $output .= '<img src="' . $theimg . '" class="grayscale" alt="' . trim(stripslashes(multiloquent_post_title($val->ID))) . '" width="' . $width . '" height="' . $height . '">';
            $output .= '<div class="paralax_image_bg swatch-blue5"></div>';
        }
        if ($count == '4') {
            $output .= '<div class="paralax_image_holder float_left col-sm-4 col-md-4 col-lg-4 alpha omega"> ';
            $output .= '<img src="' . $theimg . '" class="grayscale" alt="' . trim(stripslashes(multiloquent_post_title($val->ID))) . '" width="' . $width . '" height="' . $height . '">';
            $output .= '<div class="paralax_image_bg swatch-blue"></div>';
        }
        if ($count == '5') {
            $output .= '<div class="paralax_image_holder float_left col-sm-8 col-md-8 col-lg-8 alpha omega"> ';
            $output .= '<img src="' . $theimg . '" class="grayscale" alt="' . trim(stripslashes(multiloquent_post_title($val->ID))) . '" width="' . $width . '" height="' . $height . '">';
            $output .= '<div class="paralax_image_bg swatch-blue2"></div>';
        }
        $output .= '<div class="paralax_image_text"><span class="h1"><a href="' . get_permalink($val->ID) . '">' . trim(stripslashes(multiloquent_post_title($val->ID))) . '</a></span>';
        $output .= '<p>';
        $posttags = wp_get_post_tags($val->ID);
        if ($posttags) {
            foreach ($posttags as $tag) {
                $output .= '<a class="label ';
                $output .= multiloquent_get_random_solid_class($tag->slug);
                $output .= '" rel="nofollow" href="' . get_tag_link($tag->term_id) . '"><span class="fa fa-folder-o fa-fw"></span> ' . $tag->name . '</a>';
            }
        }
        $output .= '</p></div>';
        $output .= '</div>';
        $count ++;
    }
    $output .= '</div></div>';
    return $output;
}

function multiloquent_paralax_featured_sliders()
{
    global $wpdb;
    $output = '';
    $total_posts = '5';
    if (function_exists('tptn_pop_posts')) {
        $sql = "SELECT postnumber, sum(cntaccess) as sumCount, ID, post_type, post_status, post_content
		FROM wp_top_ten_daily INNER JOIN wp_posts ON postnumber=ID
		AND post_type = 'post'
		AND post_status = 'publish'
		and dp_date BETWEEN SYSDATE() - INTERVAL 30 DAY AND SYSDATE() group by ID
		ORDER BY sumCount DESC LIMIT 5;";
        $recent_posts = $wpdb->get_results($sql);
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
    $output = '<div class="featured-posts hidden-xs">';
    foreach ($recent_posts as $val) {
        $slider_image = wp_get_attachment_image_src(get_post_thumbnail_id($val->ID), 'single-post-thumbnail');
        ;
        if ($slider_image) {
            $theimg = $slider_image[0];
        } else {
            $theimg = get_template_directory_uri() . '/images/default-slider.png';
        }
        $dimensions = getimagesize($theimg);
        $width = $dimensions[0];
        $height = $dimensions[1];
        if ($count == '1' || $count == '2') {
            $output .= '<div class="float_left col-sm-6 col-md-3 col-lg-3 alpha omega"> ';
        } else {
            $output .= '<div class="float_left hidden-sm col-md-2 col-lg-2 alpha omega">';
        }
        $output .= '<div class-"row"><img src="' . $theimg . '" class="col-lg-6 col-md-6 col-sm-6 img-responsive" alt="' . trim(stripslashes(multiloquent_post_title($val->ID))) . '" width="' . $width . '" height="' . $height . '">';
        $output .= '<span class="col-lg-6 col-md-6 col-sm-6"><a href="' . get_permalink($val->ID) . '">' . trim(stripslashes(multiloquent_post_title($val->ID))) . '</a></span>';
        $output .= '</div></div>';
        $count ++;
    }
    $output .= '</div>';
    return $output;
}

function multiloquent_get_avatar($avatar)
{
    $avatar = str_replace("class='avatar", "class='avatar pull-left media-object", $avatar);
    return $avatar;
}

function multiloquent_render_the_archive()
{
    global $post;
    $tile_colour = multiloquent_get_random_blue_class();
    while (have_posts()) {
        the_post();
        // set it to blank so that it doesnt get the previous one..
        $slider_image = array();
        $slider_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
        if (! empty($slider_image)) {
            $theimg = $slider_image[0];
            // $width = $slider_image[1];
            // $height = $slider_image[2];
            // in here I need to check if its a mobile, and then give a different image:
        } else {
            $theimg = get_template_directory_uri() . '/images/default-slider.png';
        }
        $dimensions = getimagesize($theimg);
        $width = $dimensions[0];
        $height = $dimensions[1];
        ?>
<div class="paralax_image_holder col-sm-6 col-md-4 col-lg-4" style="margin-bottom: 30px;">
    <img src="<?php echo $theimg?>" class="grayscale" alt="<?php echo multiloquent_post_title()?>" width="<?php echo $width ?>" height="<?php echo $height ?>">
    <div class="paralax_image_bg <?php echo $tile_colour?>"></div>
    <div class="paralax_image_text">
        <span class="h1"><a href="<?php the_permalink() ?>"><?php  echo multiloquent_post_title()?></a></span>
        <p>
    	<?php
        $posttags = wp_get_post_tags($post->ID);
        if ($posttags) {
            foreach ($posttags as $tag) {
                echo '<a class="label ';
                echo multiloquent_get_random_solid_class($tag->slug);
                echo '" rel="nofollow" href="' . get_tag_link($tag->term_id) . '"><span class="fa fa-folder-o fa-fw"></span> ' . $tag->name . '</a>';
            }
        }
        ?>
    	</p>
    </div>
</div>
<?php
    }
}
