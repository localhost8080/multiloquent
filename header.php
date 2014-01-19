<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1 user-scalable=no">
<?php
if (preg_match('/^FacebookExternalHit\/.*?/i', $_SERVER['HTTP_USER_AGENT'])) {
    ?>
    <meta name="apple-mobile-web-app-capable" content="yes"><?php } ?>
    <title><?php
    wp_title();
    ?></title>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php
    
    if (function_exists('yoast_analytics')) {
        yoast_analytics();
    }
    ?>
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<link type="text/css" rel="stylesheet" media="screen" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet" media="screen" href="//netdna.bootstrapcdn.com/font-awesome/4.0.1/css/font-awesome.min.css">
<?php
echo '<link type="text/css" rel="stylesheet" media="screen" href="' . get_template_directory_uri() . '/style.css?v=' . multiloquent_version() . '">';
echo '<link type="text/css" rel="stylesheet" media="print" href="' . get_template_directory_uri() . '/print.css">';
wp_head();
?>
</head>
<body <?php
if (is_home()) {
    echo 'id="home"';
}
body_class();
?>>