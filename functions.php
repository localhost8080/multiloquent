<?php
get_template_part('function-definitions');
add_action('init', 'multiloquent_init');
add_action('after_setup_theme', 'multiloquent_register');
add_action('wp_head', 'multiloquent_customize_css');
