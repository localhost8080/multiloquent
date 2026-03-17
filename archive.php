<?php
/**
 * Archive template (dates, authors, custom post types)
 *
 * @package multiloquent\template_parts
 */
get_header();
global $multiloquent;
?>

<div class="max-w-[var(--width-wide)] mx-auto px-4 md:px-6 py-8">

	<?php if ( have_posts() ) : ?>
		<header class="mb-8">
			<?php the_archive_title( '<h1 class="text-3xl font-bold">', '</h1>' ); ?>
			<?php the_archive_description( '<div class="mt-2 text-[var(--color-muted)]">', '</div>' ); ?>
		</header>

		<div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:[grid-auto-rows:14rem]">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php $multiloquent->multiloquent_render_the_archive(); ?>
			<?php endwhile; ?>
		</div>

		<nav class="mt-10 flex justify-between gap-4" aria-label="<?php esc_attr_e( 'Posts navigation', 'multiloquent' ); ?>">
			<?php previous_posts_link( '<span class="pagination-link">&larr; ' . esc_html__( 'Newer posts', 'multiloquent' ) . '</span>' ); ?>
			<?php next_posts_link( '<span class="pagination-link">' . esc_html__( 'Older posts', 'multiloquent' ) . ' &rarr;</span>' ); ?>
		</nav>

	<?php else : ?>
		<?php get_template_part( 'error-snippet' ); ?>
	<?php endif; ?>

</div>

<?php get_footer(); ?>
