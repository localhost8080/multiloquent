<?php
/**
 * Returns a version number
 *
 * @return string
 */
function version()
{
    $version = '6.0.4';
    return $version;
}

function featured_image_in_feed($content)
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

/**
 * performs my initialisation stuff
 */
function my_init()
{
    /* these files are loaded via CDN in the js_load.php file to improve render speed */
    if (! is_admin()) {
        wp_deregister_script('jquery');
    }
    add_theme_support('automatic-feed-links');
    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);
    // put the wp head at the bottom, to get the pageloads are faster....
    add_action('wp_footer', 'wp_print_scripts', 5);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);
    add_action('wp_footer', 'wp_print_head_scripts', 5);
}

function dequeue_devicepx()
{
    wp_dequeue_script('devicepx');
}


function remove_hentry_function($classes)
{
    if (($key = array_search('hentry', $classes)) !== false) {
        unset($classes[$key]);
    }
    return $classes;
}


function register_my_menus()
{
    register_nav_menus(array(
    'header_menu' => __('Header Navigation', 'multiloquent'),
    'footer_menu' => __('Footer Navigation', 'multiloquent')
    ));
}

function add_class_the_tags($html)
{
    $html = str_replace('<a', '<a class="label"', $html);
    return $html;
}


function my_widget_tag_cloud_args($args)
{
    $args['number'] = 20; // show less tags
    $args['largest'] = 9.75; // make largest and smallest the same - i don't like the varying font-size look
    $args['smallest'] = 9.75;
    $args['unit'] = 'px';
    return $args;
}
// filter tag clould output so that it can be styled by CSS
function add_tag_class($taglinks)
{
    $tags = explode('</a>', $taglinks);
    $regex = "#(.*tag-link[-])(.*)(' title.*)#e";
    foreach ($tags as $tag) {
        $tagn[] = preg_replace($regex, "('$1$2 label tag-'.get_tag($2)->slug.'$3')", $tag);
    }
    $taglinks = implode('</a>', $tagn);
    return $taglinks;
}

function wp_tag_cloud_filter($return)
{
    return '<div id="tag-cloud">' . $return . '</div>';
}

/**
 * outputs the breadcrumb
 */
function breadcrumbs()
{
    $return = '';
    // $image_url = get_template_directory_uri() ;
    if (! is_home()) {
        $return .= '<li><a href="';
        $return .=  home_url();
        $return .=  '">';
        $return .=  'home';
        $return .=  '</a><span class="divider">/</span></li>';
    }
    if (is_category() || (is_single() && ! is_attachment())) {
        $category = get_the_category();
        $catid = $category[0]->cat_ID;
        $return .=  '<li>' . get_category_parents($catid, true, '<span class="divider">/</span>', false);
    }
    if (is_single()) {
        $return .=  '<li><h5 style="margin:0;padding:0">' . get_the_title() . '</h5></li>';
    }
    if (is_page()) {
        $return .=  '<li><h5 style="margin:0;padding:0">' . get_the_title() . '</h5></li>';
    }
    if (is_tag()) {
        $return .=  '<li><h5 style="margin:0;padding:0">Tag: ' . single_tag_title('', false) . '</h5></li>';
    }
    if (is_404()) {
        $return .=  '<li><h5 style="margin:0;padding:0">404 - Page not Found</h5><li>';
    }
    if (is_search()) {
        $return .=  '<li><h5 style="margin:0;padding:0">Search</span></li>';
    }
    if (is_year()) {
        $return .=  '<li><h5 style="margin:0;padding:0">' . get_the_time('Y') . '</h5></li>';
    }

    return $return;
}

function jb_get_previous_posts_link($label = null)
{
    global $paged;
    if (null === $label) {
        $label = __('&laquo; Previous Page', 'multiloquent');
    }
    if (! is_single() && $paged > 1) {
        $attr = apply_filters('previous_posts_link_attributes', '');
        return '<a href="' . untrailingslashit(previous_posts(false)) . "\" $attr>" . preg_replace('/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $label) . '</a>';
    }
}

function get_random_solid_class($class = '')
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

function get_random_blue_class()
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

function get_random_colour_class($class = '')
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

function get_user_agents_list()
{
    $useragents = array(
        "iPhone", // Apple iPhone
        "iPod", // Apple iPod touch
        "incognito", // Other iPhone browser
        "iPad", // iPad
        "webmate", // Other iPhone browser
        "Android", // 1.5+ Android
        "dream", // Pre 1.5 Android
        "CUPCAKE", // 1.5+ Android
        "blackberry9500", // Storm
        "blackberry9530", // Storm
        "blackberry9520", // Storm v2
        "blackberry9550", // Storm v2
        "blackberry 9800", // Torch
        "webOS", // Palm Pre Experimental
        "s8000", // Samsung Dolphin browser
        "bada", // Samsung Dolphin browser
        "Googlebot-Mobile", // the Google mobile crawler
        "MSIE"
    ); // force internet explorer to not get the cool stuff cos its crap
    asort($useragents);
    return $useragents;
}

function is_mobile_device()
{
    $useragents = get_user_agents_list();
    // echo '<!-- useragents'.print_r($userAgents).'-->';
    if (! empty($_SERVER['HTTP_USER_AGENT'])) {
        $browser = $_SERVER['HTTP_USER_AGENT'];
    } else {
        $browser = '';
    }
    foreach ($useragents as $agent) {
        if (preg_match("#$agent#i", $browser)) {
            $return = true;
            break;
        } else {
            $return = false;
        }
    }
    return $return;
}

function get_PostViews($post_ID)
{
    global $wpdb;
    $table_name = $wpdb->prefix . "top_ten";
    $cntaccess = '';
    if (is_admin()) {
        $resultscount = $wpdb->get_row("select postnumber, cntaccess from $table_name WHERE postnumber = $post_ID");
        $cntaccess = number_format((($resultscount) ? $resultscount->cntaccess : 0));
    }
    return $cntaccess;
}
// Function: Add/Register the Non-sortable 'Views' Column to your Posts tab in WP Dashboard.
function post_column_views($newcolumn)
{
    // Retrieves the translated string, if translation exists, and assign it to the 'default' array.
    $newcolumn['post_views'] = __('Views', 'multiloquent');
    return $newcolumn;
}
// Add the sorting SQL for the themes
function new_posts_orderby($orderby, $wp_query)
{
    global $wpdb;
    // $orderby = '';
    if (is_admin()) {
        $table_name = $wpdb->prefix . "top_ten";
        $wp_query->query = wp_parse_args($wp_query->query);
        if ('post_views' == @$wp_query->query['orderby']) {
            $orderby = "(select cntaccess from " . $table_name . " WHERE postnumber = $wpdb->posts.ID) " . $wp_query->get('order') . "";
        }
        return $orderby;
    }
}

function make_category_list_as_hierarchy($cat = '0')
{
    $tags = get_categories('hide_empty=true&orderby=name&order=ASC&parent=' . $cat);
    // Output a wrapper so that our arrays will be contained in 4 columns.
    $html = '';
    if ($tags) {
        // Output the markup for each tag found for each character.
        // in here I need to recurse down
        $old_tile_colour = get_random_blue_class();
        foreach ((array) $tags as $tag) {
            // set the old colour so I can re-set it at the bottom
            $new_tile_colour = get_random_solid_class($tag->slug);
            // fetch the new colour, if the returned string matches the slug, then set the tile_colour to it, otherwise,
            // set it to the old one which is only set before this loop
            if ($new_tile_colour == $tag->slug) {
                $tile_colour = $new_tile_colour;
            } else {
                $tile_colour = $old_tile_colour;
            }
            if ($cat == '0') {
                $html .= '<ul class="thumbnails">';
            }
            $tag_link = get_category_link($tag->term_id);
            if (strlen($tag->name) > '30') {
                $html .= '<li class="tag-item tile tile-double double-height ' . $tile_colour . '"onclick="javascript:window.location.href=';
                $html .= "'" . $tag_link . "'";
                $html .= '" >';
            } elseif (strlen($tag->name) > '10') {
                $html .= '<li class="tag-item tile tile-double ' . $tile_colour . '"onclick="javascript:window.location.href=';
                $html .= "'" . $tag_link . "'";
                $html .= '" >';
            } elseif (strlen($tag->name) > '5') {
                $html .= '<li class="tag-item tile tile-double ' . $tile_colour . '"onclick="javascript:window.location.href=';
                $html .= "'" . $tag_link . "'";
                $html .= '" >';
            } else {
                $html .= '<li class="tag-item tile ' . $tile_colour . '"onclick="javascript:window.location.href=';
                $html .= "'" . $tag_link . "'";
                $html .= '" >';
            }
            if (strlen($tag->name) > '30') {
                $html .= '<h2 class="nowrap"><a href="' . $tag_link . '" title="View the article tagged ' . $tag->name . '" >' . $tag->name . '</a></h2>';
                $html .= "<h4>{$tag->count}</h4>";
            } elseif (strlen($tag->name) > '10') {
                $html .= '<h3><a href="' . $tag_link . '" title="View the article tagged ' . $tag->name . '" >' . $tag->name . '</a></h3>';
                $html .= "<h4>{$tag->count}</h4>";
            } else {
                $html .= '<h2><a href="' . $tag_link . '" title="View the article tagged ' . $tag->name . '" >' . $tag->name . '</a></h2>';
                $html .= "<h4>{$tag->count}</h4>";
            }
            $html .= "</li>";
            $html .= make_category_list_as_hierarchy($tag->term_id);
            if ($cat == '0') {
                $html .= '</ul>';
            }
        }
    }
    return $html;
}

function jb_paralax_slider()
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
    $output = '<div class="container"><div class="row alpha">';
    foreach ($recent_posts as $key => $val) {
        $slider_image = wp_get_attachment_image_src(get_post_thumbnail_id($val->ID), 'single-post-thumbnail');
        ;
        if ($slider_image) {
            $theimg = $slider_image[0];
            $width = $slider_image[1];
            $height = $slider_image[2];
        } else {
            $theimg = get_template_directory_uri() . '/images/default-slider.png';
            $width = '1100';
            $height = '500';
        }
        if ($count == '1') {
            $output .= '<div class="paralax_image_holder float_left span8 alpha omega doubleheight"> ';
            $output .= '<img src="' . $theimg . '" class="grayscale" alt="' . trim(stripslashes(get_the_title($val->ID))) . '" width="' . $width . '" height="' . $height . '">';
            $output .= '<div class="paralax_image_bg doubleheight swatch-blue4"></div>';
        }
        if ($count == '2') {
            $output .= '<div class="paralax_image_holder float_left span4 alpha omega"> ';
            $output .= '<img src="' . $theimg . '" class="grayscale" alt="' . trim(stripslashes(get_the_title($val->ID))) . '" width="' . $width . '" height="' . $height . '">';
            $output .= '<div class="paralax_image_bg swatch-blue2"></div>';
        }
        if ($count == '3') {
            $output .= '<div class="paralax_image_holder float_left span4 alpha omega"> ';
            $output .= '<img src="' . $theimg . '" class="grayscale" alt="' . trim(stripslashes(get_the_title($val->ID))) . '" width="' . $width . '" height="' . $height . '">';
            $output .= '<div class="paralax_image_bg swatch-blue5"></div>';
        }
        if ($count == '4') {
            $output .= '<div class="paralax_image_holder float_left span4 alpha omega"> ';
            $output .= '<img src="' . $theimg . '" class="grayscale" alt="' . trim(stripslashes(get_the_title($val->ID))) . '" width="' . $width . '" height="' . $height . '">';
            $output .= '<div class="paralax_image_bg swatch-blue"></div>';
        }
        if ($count == '5') {
            $output .= '<div class="paralax_image_holder float_left span8 alpha omega"> ';
            $output .= '<img src="' . $theimg . '" class="grayscale" alt="' . trim(stripslashes(get_the_title($val->ID))) . '" width="' . $width . '" height="' . $height . '">';
            $output .= '<div class="paralax_image_bg swatch-blue2"></div>';
        }
        $output .= '<div class="paralax_image_text"><h1><a href="' . get_permalink($val->ID) . '">' . trim(stripslashes(get_the_title($val->ID))) . '</a></h1>';
        $output .= '<p>';
        $posttags = wp_get_post_tags($val->ID);
        if ($posttags) {
            foreach ($posttags as $tag) {
                $output .= '<a class="label ';
                $output .= get_random_solid_class($tag->slug);
                $output .= '" rel="nofollow" href="/tag/' . $tag->slug . '"><span class="fa fa-folder-o fa-fw"></span> ' . $tag->name . '</a>';
            }
        }
        $output .= '</p></div>';
        $output .= '</div>';
        $count ++;
    }
    $output .= '</div></div>';
    return $output;
}

function shoestrap_get_avatar($avatar)
{
    $avatar = str_replace("class='avatar", "class='avatar pull-left media-object", $avatar);
    return $avatar;
}