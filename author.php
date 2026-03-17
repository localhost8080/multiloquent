<?php

/**
 *  author pages template part.
 *  have an archive and a bio for the author
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package multiloquent
 */

/**
 * The template for displaying Author archive pages
 */

get_header();
if (have_posts()) {
?>
	<div class="bg-[var(--color-surface)] py-10 px-4 md:px-6 category-banner">
		<div class="max-w-[var(--width-wide)] mx-auto">
			<header class="profile">
				<div class="w-full flex flex-wrap">
					<div class="w-full sm:w-2/3 px-4">
						<h2><?php the_author_meta('display_name'); ?></h2>

						<p>
							<strong>
								<?php
								printf(
									esc_html__('Website: ', 'multiloquent')
								);
								?>
							</strong>
							<?php the_author_link(); ?>
						</p>
					</div>
					<div class="w-full sm:w-1/3 text-center px-4">
						<figure>
							<?php echo get_avatar(get_the_author_meta('ID')); ?>
							<figcaption class="ratings">
								<p>
									<?php
									printf(
										esc_html__('Post count: %s', 'multiloquent'),
										$wp_query->found_posts
									);
									?>
								</p>
							</figcaption>
						</figure>
					</div>
				</div>
				<div class="w-full divider mt-4">
					<div class="w-full">
						<?php
						$description = get_the_author_meta('description');
						if (! empty($description)) {
							echo '<p>' . $description . '</p>';
						}
						?>
					</div>
				</div>
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
