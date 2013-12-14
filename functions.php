<?php
load_theme_textdomain('multiloquent');

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
add_filter('the_content', 'featured_image_in_feed');
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
add_action('wp_enqueue_scripts', 'dequeue_devicepx', 20);
add_filter('post_class', 'remove_hentry_function', 20);

function remove_hentry_function($classes)
{
    if (($key = array_search('hentry', $classes)) !== false) {
        unset($classes[$key]);
    }
    return $classes;
}
add_action('init', 'my_init');
add_action('after_setup_theme', 'register_my_menus');

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
    // $image_url = get_template_directory_uri() ;
    if (! is_home()) {
        echo '<li><a href="';
        echo home_url();
        echo '">';
        echo 'home';
        echo '</a><span class="divider">/</span></li>';
    }
    if (is_category() || (is_single() && ! is_attachment())) {
        $category = get_the_category();
        $catid = $category[0]->cat_ID;
        echo '<li>' . get_category_parents($catid, true, '<span class="divider">/</span>', false);
    }
    if (is_single()) {
        echo '<li><h5 style="margin:0;padding:0">' . get_the_title() . '</h5></li>';
    }
    if (is_page()) {
        echo '<li><h5 style="margin:0;padding:0">' . get_the_title() . '</h5></li>';
    }
    if (is_tag()) {
        echo '<li><h5 style="margin:0;padding:0">Tag: ' . single_tag_title('', false) . '</h5></li>';
    }
    if (is_404()) {
        echo '<li><h5 style="margin:0;padding:0">404 - Page not Found</h5><li>';
    }
    if (is_search()) {
        echo '<li><h5 style="margin:0;padding:0">Search</span></li>';
    }
    if (is_year()) {
        echo '<li><h5 style="margin:0;padding:0">' . get_the_time('Y') . '</h5></li>';
    }
    // TODO - make it return rather than echo
}

/**
 * Function that Rounds To The Nearest Value.
 * Needed for the pagenavi() function
 */
function round_num($num, $to_nearest)
{
    /* Round fractions down (http://php.net/manual/en/function.floor.php) */
    return floor($num / $to_nearest) * $to_nearest;
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

/**
 * Function that performs a Boxed Style Numbered Pagination (also called Page Navigation).
 * Function is largely based on Version 2.4 of the WP-PageNavi plugin
 */
function pagenavi($before = '', $after = '')
{
    global $wp_query;
    $pagenavi_options = array();
    $pagenavi_options['pages_text'] = ('Page %CURRENT_PAGE% of %TOTAL_PAGES%:');
    $pagenavi_options['current_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['page_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['first_text'] = ('First Page');
    $pagenavi_options['last_text'] = ('Last Page');
    $pagenavi_options['next_text'] = 'Next &raquo;';
    $pagenavi_options['prev_text'] = '&laquo; Previous';
    $pagenavi_options['dotright_text'] = '...';
    $pagenavi_options['dotleft_text'] = '...';
    $pagenavi_options['num_pages'] = 5; // continuous block of page numbers
    $pagenavi_options['always_show'] = 0;
    $pagenavi_options['num_larger_page_numbers'] = 0;
    $pagenavi_options['larger_page_numbers_multiple'] = 5;
    // If NOT a single Post is being displayed
    /* http://codex.wordpress.org/Function_Reference/is_single) */
    if (! is_single()) {
        $wp_query->request;
        // intval Get the integer value of a variable
        /* http://php.net/manual/en/function.intval.php */
        // $posts_per_page = intval(get_query_var('posts_per_page'));
        // Retrieve variable in the WP_Query class.
        /* http://codex.wordpress.org/Function_Reference/get_query_var */
        $paged = intval(get_query_var('paged'));
        // $numposts = $wp_query->found_posts;
        $max_page = $wp_query->max_num_pages;
        // empty Determine whether a variable is empty
        /* http://php.net/manual/en/function.empty.php */
        if (empty($paged) || $paged == 0) {
            $paged = 1;
        }
        $pages_to_show = intval($pagenavi_options['num_pages']);
        $l_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
        $l_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
        $pages_minus_1 = $pages_to_show - 1;
        $half_page_start = floor($pages_minus_1 / 2);
        // ceil Round fractions up (http://us2.php.net/manual/en/function.ceil.php)
        $half_page_end = ceil($pages_minus_1 / 2);
        $start_page = $paged - $half_page_start;
        if ($start_page <= 0) {
            $start_page = 1;
        }
        $end_page = $paged + $half_page_end;
        if (($end_page - $start_page) != $pages_minus_1) {
            $end_page = $start_page + $pages_minus_1;
        }
        if ($end_page > $max_page) {
            $start_page = $max_page - $pages_minus_1;
            $end_page = $max_page;
        }
        if ($start_page <= 0) {
            $start_page = 1;
        }
        $l_per_page = $l_page_to_show * $l_page_multiple;
        // round_num() custom function - Rounds To The Nearest Value.
        $l_start_page_start = (round_num($start_page, 10) + $l_page_multiple) - $l_per_page;
        $l_start_page_end = round_num($start_page, 10) + $l_page_multiple;
        $l_end_page_start = round_num($end_page, 10) + $l_page_multiple;
        $larger_end_page_end = round_num($end_page, 10) + ($l_per_page);
        if ($l_start_page_end - $l_page_multiple == $start_page) {
            $l_start_page_start = $l_start_page_start - $l_page_multiple;
            $l_start_page_end = $l_start_page_end - $l_page_multiple;
        }
        if ($l_start_page_start <= 0) {
            $l_start_page_start = $l_page_multiple;
        }
        if ($l_start_page_end > $max_page) {
            $l_start_page_end = $max_page;
        }
        if ($larger_end_page_end > $max_page) {
            $larger_end_page_end = $max_page;
        }
        if ($max_page > 1 || intval($pagenavi_options['always_show']) == 1) {
            /* http://php.net/manual/en/function.str-replace.php */
            /*number_format_i18n(): Converts integer number to format based on locale (wp-includes/functions.php*/
            $pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
            $pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
            echo $before . '<div class="pagination pagination-centered"><ul>' . "\n";
            if (! empty($pages_text)) {
                echo '<li><span>' . $pages_text . '</span></li>';
            }
            // Displays a link to the previous post which exists in chronological order from the current post.
            /* http://codex.wordpress.org/Function_Reference/previous_post_link */
            $prev_link = jb_get_previous_posts_link($pagenavi_options['prev_text']);
            echo '<li>' . $prev_link . '</li>';
            if ($start_page >= 2 && $pages_to_show < $max_page) {
                $first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
                // esc_url(): Encodes < > & " ' (less than, greater than, ampersand, double quote, single quote).
                /* http://codex.wordpress.org/Data_Validation */
                // get_pagenum_link():(wp-includes/link-template.php)-Retrieve get links for page numbers.
                echo '<li><a href="' . untrailingslashit(esc_url(get_pagenum_link())) . '" class="first" title="' . $first_page_text . '">1</a></li>';
                if (! empty($pagenavi_options['dotleft_text'])) {
                    echo '<li><span>' . $pagenavi_options['dotleft_text'] . '</span></li>';
                }
            }
            if ($l_page_to_show > 0 && $l_start_page_start > 0 && $l_start_page_end <= $max_page) {
                for ($i = $l_start_page_start; $i < $l_start_page_end; $i += $l_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<li><a href="' . untrailingslashit(esc_url(get_pagenum_link($i))) . '" class="single_page" title="' . $page_text . '">' . $page_text . '</a></li>';
                }
            }
            for ($i = $start_page; $i <= $end_page; $i ++) {
                if ($i == $paged) {
                    $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
                    echo '<li><span>' . $current_page_text . '</span></li>';
                } else {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<li><a href="' . untrailingslashit(esc_url(get_pagenum_link($i))) . '" class="single_page" title="' . $page_text . '">' . $page_text . '</a></li>';
                }
            }
            if ($end_page < $max_page) {
                if (! empty($pagenavi_options['dotright_text'])) {
                    echo '<li><span>' . $pagenavi_options['dotright_text'] . '</span></li>';
                }
                $last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
                echo '<li><a href="' . untrailingslashit(esc_url(get_pagenum_link($max_page))) . '" class="last" title="' . $last_page_text . '">' . $max_page . '</a></li>';
            }
            $next_link = get_next_posts_link($pagenavi_options['next_text'], $max_page);
            echo '<li>' . $next_link . '</li>';
            if ($l_page_to_show > 0 && $l_end_page_start < $max_page) {
                for ($i = $l_end_page_start; $i <= $larger_end_page_end; $i += $l_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<li><a href="' . untrailingslashit(esc_url(get_pagenum_link($i))) . '" class="single_page" title="' . $page_text . '">' . $page_text . '</a></li>';
                }
            }
            echo '</ul></div>' . $after . "\n";
        }
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
add_filter('get_avatar', 'shoestrap_get_avatar');
