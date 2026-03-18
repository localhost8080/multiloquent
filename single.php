<?php

/**
 * Single post template
 *
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
					<h1 style="margin:0 0 0.5rem;font-size:2.25rem;font-weight:700;line-height:1.2;"><?php the_title(); ?></h1>
					<p style="font-size:0.875rem;opacity:0.8;display:flex;flex-wrap:wrap;gap:0.25rem 0.75rem;margin:0;">
						<span><?php echo esc_html(get_the_date()); ?></span>
						<span>&mdash;</span>
						<?php the_author_posts_link(); ?>
						<?php $cats = get_the_category();
						if ($cats) : ?>
							<span>&mdash;</span>
							<?php foreach ($cats as $cat) : ?>
								<a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="tag-label" rel="category tag"><?php echo esc_html($cat->name); ?></a>
							<?php endforeach; ?>
						<?php endif; ?>
					</p>
				</header>
			</div>
		</div>

		<div id="post-<?php the_ID(); ?>" <?php post_class('max-w-[var(--width-content)] mx-auto px-4 md:px-6 py-8'); ?>>

			<!-- Post content -->
			<div class="entry-content">
				<?php the_content(); ?>
				<?php wp_link_pages([
					'before' => '<p class="mt-6 font-semibold">' . esc_html__('Pages:', 'multiloquent') . '</p>',
					'after'  => '</p>',
				]); ?>
			</div>

			<!-- Tags -->
			<?php $tags = get_the_tags();
			if ($tags) : ?>
				<div class="mt-8">
					<h3 class="text-base font-semibold mb-3"><?php esc_html_e('Tags', 'multiloquent'); ?></h3>
					<div class="flex flex-wrap gap-2">
						<?php foreach ($tags as $tag) : ?>
							<a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-label">
								<?php echo esc_html($tag->name); ?>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Post navigation (prev / next) -->
			<nav class="mt-10 flex justify-between gap-4 text-sm" aria-label="<?php esc_attr_e('Post navigation', 'multiloquent'); ?>">
				<?php previous_post_link('<span class="pagination-link">&larr; %link</span>', '%title'); ?>
				<?php next_post_link('<span class="pagination-link">%link &rarr;</span>',  '%title'); ?>
			</nav>

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