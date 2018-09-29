<?php
/**
 * navigation template part
 *
 * @package multiloquent\template_parts
 */

/**
 * nav bar
 */

$mods = get_theme_mods();
if (! empty($mods['bootswatch']) && $mods['bootswatch'] == 'mdb') {
    ?>
<nav role="navigation" class="navbar fixed-top navbar-dark bg-primary">
	<div class="">
		<a title="navigation menu" href="javascript:void(0);" class="navbar-brand sidebar-toggle">
			<span class="fa fa-bars"></span>
		</a>
		<?php echo '<h2 class="navbar-brand"><a class="navbar-brand" title="' . get_bloginfo('name') . '" href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a></h2>'; ?>
	</div>
	<div class="material-search">
	<?php get_search_form();?>
	</div>
</nav>

<?php
} else {
    ?>

<nav role="navigation" class="navbar fixed-top navbar-light bg-light">
	<div class="">
		<a title="navigation menu" href="javascript:void(0);" class="navbar-brand sidebar-toggle">
			<span class="fa fa-bars"></span>
		</a>
		<?php echo '<h2 class="navbar-brand"><a class="navbar-brand" title="' . get_bloginfo('name') . '" href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a></h2>'; ?>
	</div>
</nav>


<?php
}
?>