<?php
/**
 * Error / no-posts snippet
 *
 * @package multiloquent\template_parts
 */
?>
<div class="py-16 text-center">
	<p class="text-2xl font-semibold text-[var(--color-muted)] mb-4">
		<?php esc_html_e( 'Nothing found.', 'multiloquent' ); ?>
	</p>
	<p class="text-[var(--color-muted)] mb-6">
		<?php esc_html_e( 'Try a search or browse the menu.', 'multiloquent' ); ?>
	</p>
	<?php get_search_form(); ?>
</div>
