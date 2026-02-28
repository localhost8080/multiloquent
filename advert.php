<?php
/**
 * Primary advert widget area
 *
 * @package multiloquent\template_parts
 */
if ( is_active_sidebar( 'advert-primary' ) ) {
	echo '<div class="advert-primary my-4">';
	dynamic_sidebar( 'advert-primary' );
	echo '</div>';
}
