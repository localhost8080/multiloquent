<?php
/**
 *  multiloquent functions file.
 *  
 *  @package multiloquent\functions
 */

require_once ( trailingslashit( get_template_directory() ) . 'function-definitions.php' );
add_action( 'after_setup_theme', 'multiloquent_register' );
add_action( 'wp_head', 'multiloquent_customize_css' );
