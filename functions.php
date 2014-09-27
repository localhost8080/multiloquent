<?php
/**
 *  multiloquent functions file.
 *
 *  @package multiloquent\functions
 */

require_once (trailingslashit(get_template_directory()) . 'function-definitions.php');
global $multiloquent;
$multiloquent = new multiloquent_base();

// dont know that these will work
add_action('after_setup_theme', $multiloquent->multiloquent_register($wp_customize));
add_action('wp_head', $multiloquent->multiloquent_customize_css($wp_customize));

