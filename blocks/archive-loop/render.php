<?php
/**
 * Archive Loop block — server-side render.
 *
 * Loops the main WP_Query using the theme's archive card renderer so every
 * archive/category/tag/author/search/home template gets the same card style
 * (hero first post, smaller cards for the rest).
 *
 * @package multiloquent
 */

global $multiloquent;

if ( ! have_posts() ) {
	echo '<p class="has-text-align-center" style="color:var(--wp--preset--color--muted);padding:var(--wp--preset--spacing--70) 0">'
		. esc_html__( 'No posts found.', 'multiloquent' )
		. '</p>';
	return;
}
?>

<div <?php echo get_block_wrapper_attributes( [ 'class' => 'archive-grid alignwide' ] ); ?>>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php $multiloquent->multiloquent_render_the_archive(); ?>
	<?php endwhile; ?>
</div>

<nav class="flex justify-between gap-4 alignwide"
     style="margin-top:var(--wp--preset--spacing--60)"
     aria-label="<?php esc_attr_e( 'Posts navigation', 'multiloquent' ); ?>">
	<?php previous_posts_link( '<span class="pagination-link">&larr; ' . esc_html__( 'Newer posts', 'multiloquent' ) . '</span>' ); ?>
	<?php next_posts_link( '<span class="pagination-link">' . esc_html__( 'Older posts', 'multiloquent' ) . ' &rarr;</span>' ); ?>
</nav>
