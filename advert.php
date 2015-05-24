<?php
/**
 * Snippet to display adverts
 * @package multiloquent\template_parts
 */

/**
 * Advert template part
 *
 */

?>

<div class="ads">
	<?php
	if (wp_is_mobile()) {
		if (is_active_sidebar(2)) {
			dynamic_sidebar(2);
		}
	} else {
		if (is_active_sidebar(3)) {
			dynamic_sidebar(3);
		}
	}
	?>
</div>
