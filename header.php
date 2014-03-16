<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1 user-scalable=no">
<title><?php wp_title(''); ?></title>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php
    if (function_exists('yoast_analytics')) {
        yoast_analytics();
    }
    wp_head();
    ?>
</head>
<body <?php body_class();?>>
<div class="container">
<div class="wrapper col-lg-12 col-md-12">