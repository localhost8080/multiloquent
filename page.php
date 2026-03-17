<?php

/**
 * Static page template
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package multiloquent\template_parts
 */

get_header();
global $multiloquent;
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<!-- Featured image hero -->

		<div class="entry-hero">
			<?php if (has_post_thumbnail()) : ?>
				<?php the_post_thumbnail('multiloquent-hero', ['loading' => 'eager', 'fetchpriority' => 'high']); ?>
			<?php endif; ?>
			<div class="entry-hero-overlay">
				<?php $multiloquent->multiloquent_breadcrumbs(); ?>
				<header>
					<h1 style="margin:0;font-size:2.25rem;font-weight:700;line-height:1.2;"><?php the_title(); ?></h1>
				</header>
			</div>
		</div>

		<div id="post-<?php the_ID(); ?>" <?php post_class('max-w-[var(--width-content)] mx-auto px-4 md:px-6 py-8'); ?>>

			<!-- Page content -->
			<div class="entry-content">
				<?php the_content(); ?>
				<?php wp_link_pages([
					'before' => '<p class="mt-6 font-semibold">' . esc_html__('Pages:', 'multiloquent') . '</p>',
					'after'  => '</p>',
				]); ?>
			</div>


			<!-- Comments -->
			<?php if (comments_open() || get_comments_number()) : ?>
				<div class="mt-12">
					<?php comments_template(); ?>
				</div>
			<?php endif; ?>

			<!-- Related posts (YARPP) -->
			<?php if (function_exists('related_posts')) related_posts(); ?>

		</div>

	<?php endwhile;
else : ?>

	<div class="max-w-[var(--width-content)] mx-auto px-4 md:px-6 py-8">
		<?php get_template_part('error-snippet'); ?>
	</div>

<?php endif; ?>

<?php get_footer(); ?>