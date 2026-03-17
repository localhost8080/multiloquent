<?php

/**
 * tag archive template part
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package multiloquent\template_parts
 */

/**
 * template for tag archives
 */

get_header();
if (have_posts()) {
?>
	<div class="bg-[var(--color-surface)] py-10 px-4 md:px-6 category-banner">
		<div class="max-w-[var(--width-wide)] mx-auto">
			<header>
				<h1 class="article_title">
					<?php
					printf(
						esc_html__('Posts Tagged %s', 'multiloquent'),
						single_cat_title('', false)
					);
					?>
				</h1>

				<p>
					<?php
					printf(
						esc_html__('There are %1$s posts tagged %2$s', 'multiloquent'),
						$wp_query->found_posts,
						single_cat_title('', false)
					);
					?>
				</p>
			</header>
		</div>
	</div>
	<section class="w-full max-w-[var(--width-wide)] mx-auto px-4 md:px-6">
		<?php
		while (have_posts()) {
			the_post();
			$multiloquent->multiloquent_render_the_archive();
		}
		?>
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
