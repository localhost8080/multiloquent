<?php
get_template_part('function_definitions');
add_action('init', 'my_init');
add_action('after_setup_theme', 'register_my_menus');
