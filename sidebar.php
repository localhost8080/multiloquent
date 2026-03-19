<?php

/**
 * Sidebar template part — shown inside the slide-in panel
 *
 * @package multiloquent\template_parts
 */
?>
<div class="p-4 flex flex-col gap-6">

	<!-- Search () -->
	<div class="">
		<?php get_search_form(); ?>
	</div>

	<!-- Primary navigation -->
	<?php if (has_nav_menu('primary-menu')) : ?>
		<nav aria-label="<?php esc_attr_e('Primary Navigation', 'multiloquent'); ?>">
			<?php wp_nav_menu([
				'theme_location' => 'primary-menu',
				'container'      => false,
				'menu_class'     => 'space-y-1',
				'link_before'    => '',
				'link_after'     => '',
				'walker'         => null,
				'depth'          => 3,
				'item_spacing'   => 'discard',
			]); ?>
		</nav>
	<?php endif; ?>

	<!-- Sidebar top widget area -->
	<?php if (is_active_sidebar('sidebar-top')) : ?>
		<div><?php dynamic_sidebar('sidebar-top'); ?></div>
	<?php endif; ?>

	<!-- Primary sidebar widget area -->
	<?php if (is_active_sidebar('sidebar-primary')) : ?>
		<div><?php dynamic_sidebar('sidebar-primary'); ?></div>
	<?php endif; ?>

	<!-- Sidebar bottom widget area -->
	<?php if (is_active_sidebar('sidebar-bottom')) : ?>
		<div><?php dynamic_sidebar('sidebar-bottom'); ?></div>
	<?php endif; ?>

</div>