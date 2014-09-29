<?php
/**
 *  multiloquent functions file.
 *
 *  @package multiloquent\functions
 */

require_once (trailingslashit(get_template_directory()) . 'function-definitions.php');
require_once (trailingslashit(get_template_directory()) . 'multiloquent-base.php');

global $multiloquent;
$multiloquent = new multiloquent_base();

add_action('after_setup_theme', 'multiloquent_register');
add_action('wp_head', $multiloquent->multiloquent_customize_css);
