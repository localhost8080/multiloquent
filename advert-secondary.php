<?php
/**
 * Secondary advert widget area
 *
 * @package multiloquent\template_parts
 */
if ( is_active_sidebar( 'advert-secondary' ) ) {
	echo '<div class="advert-secondary my-4">';
	dynamic_sidebar( 'advert-secondary' );
	echo '</div>';
}
