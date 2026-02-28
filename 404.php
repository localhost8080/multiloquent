<?php
/**
 * 404 template
 *
 * @package multiloquent\template_parts
 */
get_header();
?>
<div class="max-w-[var(--width-content)] mx-auto px-4 md:px-6 py-16 text-center">
	<h1 class="text-6xl font-black text-[var(--color-primary)] mb-4">404</h1>
	<h2 class="text-2xl font-bold mb-4"><?php esc_html_e( 'Page not found', 'multiloquent' ); ?></h2>
	<p class="text-[var(--color-muted)] mb-8">
		<?php esc_html_e( 'The page you were looking for doesn\'t exist.', 'multiloquent' ); ?>
	</p>
	<?php get_search_form(); ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
	   class="inline-block mt-6 px-5 py-2 bg-[var(--color-primary)] text-white rounded-md hover:bg-[var(--color-primary-dark)] transition-colors">
		<?php esc_html_e( '&larr; Back to home', 'multiloquent' ); ?>
	</a>
</div>
<?php get_footer(); ?>
