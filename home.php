<?php

/**
 * Blog homepage template (when set to display blog posts)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package multiloquent\template_parts
 */

get_header();
global $multiloquent;
?>

<?php if (have_posts()) : ?>

	<!-- Featured posts carousel -->
	<?php echo $multiloquent->multiloquent_paralax_slider(); ?>

	<div class="max-w-[var(--width-wide)] mx-auto px-4 md:px-6 py-8">
		<h2 class="text-2xl font-bold mb-6"><?php esc_html_e('Recent Posts', 'multiloquent'); ?></h2>

		<div class="archive-grid">
			<?php while (have_posts()) : the_post(); ?>
				<?php $multiloquent->multiloquent_render_the_archive(); ?>
			<?php endwhile; ?>
		</div>



		<!-- Pagination -->
		<nav class="mt-10 flex justify-between gap-4" aria-label="<?php esc_attr_e('Posts navigation', 'multiloquent'); ?>">
			<?php previous_posts_link('<span class="pagination-link">&larr; ' . esc_html__('Newer posts', 'multiloquent') . '</span>'); ?>
			<?php next_posts_link('<span class="pagination-link">' . esc_html__('Older posts', 'multiloquent') . ' &rarr;</span>'); ?>
		</nav>
	</div>

<?php else : ?>

	<div class="max-w-[var(--width-wide)] mx-auto px-4 md:px-6 py-8">
		<?php get_template_part('error-snippet'); ?>
	</div>

<?php endif; ?>

<?php get_footer(); ?>