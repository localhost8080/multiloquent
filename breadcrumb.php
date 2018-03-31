<?php
/**
 * breadcrumb template part
 *
 * @package multiloquent\template_parts
 */

/**
 * the breadcrumb for pages
 */

?>
<nav class="container-fluid hidden-xs">
	<ul class="breadcrumb clearfix pull-left col-sm-12 col-md-6 col-lg-7" itemscope itemtype="http://schema.org/BreadcrumbList">
		<?php
		echo $multiloquent->multiloquent_breadcrumbs();
?>
	</ul>
	<ul class="breadcrumb clearfix pull-right col-sm-12 col-md-6 col-lg-5">
		<?php
		require locate_template( 'metadata.php' );
?>
	</ul>
</nav>
