<?php
/**
 * Snippet to display adverts
 *
 * @package multiloquent\template_parts
 */

/**
 * Advert template part
 */
?>

<div class="ads text-center">
	<?php
	if ( wp_is_mobile() ) {
		if ( is_active_sidebar( 11 ) ) {
			dynamic_sidebar( 11 );
		}
	} else {
		if ( is_active_sidebar( 12 ) ) {
			dynamic_sidebar( 12 );
		}
	}
?>
</div>
