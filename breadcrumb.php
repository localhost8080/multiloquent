<?php
/**
 * breadcrumb template part
 *
 * @package multiloquent\template_parts
 */
global $multiloquent;
?>
<nav class="container hidden-xs">
	<ul class="breadcrumb clearfix">
		<?php
		echo $multiloquent->multiloquent_breadcrumbs();
		get_template_part('metadata');
		?>
	</ul>
</nav>
