<?php
/**
 * sidebar template part
 *
 * @package multiloquent\template_parts
 */

/**
 * the sidebar for multiloquent
 */

?>
<aside class="sidebar mt-3">
	<div class="text-capitalize">
		<?php
		$mods = get_theme_mods();
        if (empty($mods['bootswatch']) || !empty($mods['bootswatch']) && $mods['bootswatch'] != 'mdb') {
            get_search_form();
        }

		wp_nav_menu(
			array(
				'theme_location' => 'primary-menu',
			)
		);
		if ( is_active_sidebar( 1 ) ) {
			dynamic_sidebar( 1 );
		}
		/* recent posts. */
		if ( is_active_sidebar( 4 ) ) {
			dynamic_sidebar( 4 );
		}
		if ( is_active_sidebar( 5 ) ) {
			dynamic_sidebar( 5 );
		}
?>
	</div>
</aside>
