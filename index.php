<?php

/**
 * Fallback archive template
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package multiloquent\template_parts
 */

get_header();
?>

<div class="max-w-[var(--width-wide)] mx-auto px-4 md:px-6 py-8">

	<?php if (have_posts()) : ?>

		<!-- Archive heading -->
		<header class="mb-8">
			<h1 class="text-3xl font-bold">
				<?php
				if (is_category()) {
					single_cat_title();
				} elseif (is_tag()) {
					printf(esc_html__('Posts tagged: %s', 'multiloquent'), single_tag_title('', false));
				} elseif (is_day()) {
					printf(esc_html__('Archive: %s', 'multiloquent'), get_the_time('F jS, Y'));
				} elseif (is_month()) {
					printf(esc_html__('Archive: %s', 'multiloquent'), get_the_time('F Y'));
				} elseif (is_year()) {
					printf(esc_html__('Archive: %s', 'multiloquent'), get_the_time('Y'));
				} elseif (is_search()) {
					esc_html_e('Search results', 'multiloquent');
				} elseif (is_author()) {
					esc_html_e('Posts by this author', 'multiloquent');
				} else {
					esc_html_e('Recent Posts', 'multiloquent');
				}
				?>
			</h1>
			<?php if (is_category() && category_description()) : ?>
				<p class="mt-2 text-[var(--color-muted)]"><?php echo category_description(); ?></p>
			<?php endif; ?>
		</header>

		<!-- Post grid -->
		<div class="archive-grid">
			<?php while (have_posts()) : the_post(); ?>
				<?php global $multiloquent;
				$multiloquent->multiloquent_render_the_archive(); ?>
			<?php endwhile; ?>
		</div>



		<!-- Pagination -->
		<nav class="mt-10 flex justify-between gap-4" aria-label="<?php esc_attr_e('Posts navigation', 'multiloquent'); ?>">
			<?php previous_posts_link('<span class="pagination-link">&larr; ' . esc_html__('Newer posts', 'multiloquent') . '</span>'); ?>
			<?php next_posts_link('<span class="pagination-link">' . esc_html__('Older posts', 'multiloquent') . ' &rarr;</span>'); ?>
		</nav>

	<?php else : ?>

		<?php get_template_part('error-snippet'); ?>

	<?php endif; ?>

</div>

<?php get_footer(); ?>