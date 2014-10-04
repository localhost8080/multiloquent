<?php
/**
 * nav bar
 * @package multiloquent\template_parts
 */

/**
 * navigation template part
 *
 * @package multiloquent\template_parts
 */
?>
<nav role="navigation" class="navbar navbar-default navbar-fixed-top">
	<div class="navbar-header">
		<a title="navigation menu" href="javascript:void(0);" class="navbar-brand sidebar-toggle"><span class="fa fa-bars"></span></a>
		<?php echo '<h2><a class="navbar-brand title_text" title="'. get_bloginfo('name').'" href="'. esc_url(home_url('/')) .'">'. get_bloginfo('name').'</a></h2>';?>
	</div>
</nav>
