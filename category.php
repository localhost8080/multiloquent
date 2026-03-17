<?php

/**
 * category archives template part
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package multiloquent\template_parts
 */

/**
 * category archives template part
 */

get_header();
if (have_posts()) {
?>
	<div class="bg-[var(--color-surface)] py-10 px-4 md:px-6 category-banner">
		<div class="max-w-[var(--width-wide)] mx-auto">
			<header>
				<h1 class="article_title">
					<?php printf('%s', single_cat_title('', false)); ?>
				</h1>

				<p>
					<?php
					printf(
						esc_html__('There are %1$s posts in the %2$s category', 'multiloquent'),
						$wp_query->found_posts,
						single_cat_title('', false)
					);
					?>
				</p>
				<div><?php echo category_description(); ?></div>
			</header>
		</div>
	</div>
	<section class="w-full max-w-[var(--width-wide)] mx-auto px-4 md:px-6">
		<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
			<?php while (have_posts()) : the_post(); ?>
				<?php $multiloquent->multiloquent_render_the_archive(); ?>
			<?php endwhile; ?>
		</div>
	</section>

	<div class="w-full max-w-[var(--width-wide)] mx-auto px-4 md:px-6">
		<nav class="text-center">
			<ul class="flex gap-2 justify-center list-none p-0">
				<li><?php previous_posts_link(esc_html__('Previous Entries', 'multiloquent')); ?></li>
				<li><?php next_posts_link(esc_html__('Next Entries', 'multiloquent')); ?></li>
			</ul>
		</nav>
	</div>
<?php } else { ?>
	<div class="w-full max-w-[var(--width-wide)] mx-auto px-4 md:px-6">
		<?php
		get_template_part('error-snippet');
		?>
	</div>
<?php
}
get_footer();
