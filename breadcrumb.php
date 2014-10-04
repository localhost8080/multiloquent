<?php
/**
 * the breadcrumb for pages
 */

/**
 * breadcrumb template part
 *
 * @package multiloquent\template_parts
 */
?>
<nav class="container hidden-xs">
	<ul class="breadcrumb clearfix">
		<?php
		echo $multiloquent->multiloquent_breadcrumbs();
		require(locate_template('metadata.php'));
		?>
	</ul>
</nav>
