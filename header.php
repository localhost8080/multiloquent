<?php
/**
 * Site header
 *
 * @package multiloquent\template_parts
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-[var(--color-base)] text-[var(--color-contrast)] font-[var(--font-family-system)]' ); ?>>
<?php wp_body_open(); ?>

<!-- Skip to content (accessibility) -->
<a href="#main-content"
   class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:px-4 focus:py-2 focus:bg-[var(--color-primary)] focus:text-white focus:rounded focus:shadow-lg">
	<?php esc_html_e( 'Skip to content', 'multiloquent' ); ?>
</a>

<!-- ===== Fixed top navbar ===== -->
<header id="site-header"
        class="fixed top-0 inset-x-0 z-50 h-16 flex items-center px-4 gap-3
               bg-[var(--color-base)] border-b border-[var(--color-border)] shadow-sm"
        role="banner">

	<!-- Hamburger (shows on all viewports — sidebar slides in) -->
	<button class="sidebar-toggle flex-shrink-0 p-2 rounded-md
	               hover:bg-[var(--color-surface-alt)] transition-colors"
	        aria-controls="sidebar"
	        aria-expanded="false"
	        aria-label="<?php esc_attr_e( 'Open navigation', 'multiloquent' ); ?>">
		<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 pointer-events-none" fill="none"
		     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
			<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
		</svg>
	</button>

	<!-- Site name / logo -->
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
	   class="navbar-brand flex-shrink-0 text-[var(--color-contrast)] hover:text-[var(--color-primary)] no-underline transition-colors">
		<?php bloginfo( 'name' ); ?>
	</a>

	<!-- Spacer -->
	<div class="flex-1"></div>

	<!-- Header search (desktop) -->
	<div class="hidden sm:block w-56">
		<?php get_search_form(); ?>
	</div>
</header>

<!-- ===== Sidebar overlay (mobile) ===== -->
<div id="sidebar-overlay"
     class="fixed inset-0 z-40 bg-black/40 hidden"
     aria-hidden="true"></div>

<!-- ===== Slide-in sidebar ===== -->
<aside id="sidebar"
       class="fixed top-16 left-0 z-40 h-[calc(100dvh-4rem)] w-[var(--width-sidebar)]
              bg-[var(--color-surface)] border-r border-[var(--color-border)]
              overflow-y-auto -translate-x-full transition-transform duration-300 ease-in-out"
       aria-label="<?php esc_attr_e( 'Site navigation', 'multiloquent' ); ?>">
	<?php get_sidebar(); ?>
</aside>

<!-- ===== Main content wrapper ===== -->
<div id="page-wrapper" class="flex flex-col min-h-screen pt-16">
	<main id="main-content" class="flex-1 w-full">
