<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type"
	content="<?php bloginfo('html_type'); ?>; charset=utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1 user-scalable=no"><?php //if(!empty($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT']=='facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)'){ ?><?php if(preg_match('/^FacebookExternalHit\/.*?/i',$_SERVER['HTTP_USER_AGENT'])){?>
    <meta name="apple-mobile-web-app-capable" content="yes"><?php } ?>
    <title><?php
    if (function_exists('ghpseo_output')) {
        ghpseo_output('main_title');
    } else {
        if (is_home()) {
            echo get_bloginfo('name') . ' - ';
            bloginfo('description');
        } elseif (is_single() or is_page()) {
            wp_title('');
            echo ' - ' . get_bloginfo('name');
        } elseif (is_category() || is_tag()) {
            echo wp_title('');
        } elseif (is_day()) {
            echo get_bloginfo('name') . ' - ' . get_the_time('d') . '. ' . get_the_time('F') . ' ' . get_the_time('Y');
        } elseif (is_month()) {
            echo get_bloginfo('name') . ' - ' . get_the_time('F') . ' ' . get_the_time('Y');
        } elseif (is_year()) {
            echo get_bloginfo('name') . ' - ' . get_the_time('Y');
        } elseif (is_search()) {
            echo get_bloginfo('name') . ' - &lsaquo;' . esc_html($s, 1) . '&rsaquo;';
        } elseif (is_404()) {
            echo get_bloginfo('name') . '  - 404 - ERROR';
        }
    }
    ?></title>
<link rel="alternate" type="application/rss+xml"
	title="<?php bloginfo('name'); ?> RSS Feed" href="/feed">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head();?>
    <?php
    
if (function_exists('yoast_analytics')) {
        yoast_analytics();
    }
    ?>
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<link type='text/css' rel='stylesheet' media='screen'
	href='<?php echo  get_template_directory_uri(); ?>/bootstrap/css/metro-bootstrap.css?v=<?php echo version();?>'>
<link type='text/css' rel='stylesheet' media='screen'
	href='<?php echo  get_template_directory_uri(); ?>/bootstrap/css/custom.css?v=<?php echo version();?>'>
<link
	href="//netdna.bootstrapcdn.com/font-awesome/4.0.1/css/font-awesome.css"
	rel="stylesheet" media="screen" type="text/css">
</head>
<body <?php if ( is_home() ) { ?> id="home" <?php } body_class();?>>