<?php
/**
 * Search results template
 *
 * @package multiloquent\template_parts
 */
get_header();
global $multiloquent;
?>

<div class="max-w-[var(--width-wide)] mx-auto px-4 md:px-6 py-8">

	<header class="mb-8">
		<h1 class="text-3xl font-bold">
			<?php printf( esc_html__( 'Search results for: %s', 'multiloquent' ), '<span class="text-[var(--color-primary)]">' . esc_html( get_search_query() ) . '</span>' ); ?>
		</h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:[grid-auto-rows:14rem]">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php $multiloquent->multiloquent_render_the_archive(); ?>
			<?php endwhile; ?>
		</div>

		<nav class="mt-10 flex justify-between gap-4">
			<?php previous_posts_link( '<span class="pagination-link">&larr; ' . esc_html__( 'Newer results', 'multiloquent' ) . '</span>' ); ?>
			<?php next_posts_link( '<span class="pagination-link">' . esc_html__( 'Older results', 'multiloquent' ) . ' &rarr;</span>' ); ?>
		</nav>
	<?php else : ?>
		<?php get_template_part( 'error-snippet' ); ?>
	<?php endif; ?>

</div>

<?php get_footer(); ?>
