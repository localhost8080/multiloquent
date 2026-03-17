<?php
/*
 * Template Name Posts: Full width
 */

get_header();
echo '<!-- google_ad_section_start-->';
if (have_posts()) {
	while (have_posts()) {
		the_post();
		echo $multiloquent->multiloquent_paralax_featured_sliders();
		require locate_template('featuredimage.php');
		echo '<div id="post-' . get_the_ID() . '" ';
		echo post_class('post');
		echo '>';

		require locate_template('breadcrumb.php');
?>
		<div class="max-w-[var(--width-content)] mx-auto px-4 md:px-6 mt-8">
			<div class="w-full">
				<?php
				// remove_filter( 'the_content', 'sharing_display', 19 );
				// remove_filter( 'the_excerpt', 'sharing_display', 19 );
				the_content();
				wp_link_pages('<p><strong>Pages:</strong>', '</p>', 'number');
				?>
			</div>
			<?php
			get_template_part('advert');
			?>
		</div>
		<?php
		get_template_part('social');
		if (comments_open()) {
		?>
			<section class="max-w-[var(--width-content)] mx-auto px-4 md:px-6 mt-8">
				<div class="w-full">
					<h3 class="lg:hidden">Comments for <?php echo $multiloquent->multiloquent_post_title(); ?></h3>
					<?php
					comments_template();

					?>
				</div>
			</section>
		<?php
		}
		?>
		<section class="max-w-[var(--width-content)] mx-auto px-4 md:px-6 mt-8">
			<div class="tagcloud">
				<div class="tag-cloud">
					<h3>Tags for <?php echo $multiloquent->multiloquent_post_title(); ?></h3>
					<?php
					$posttags = get_the_tags();
					if ($posttags) {
						foreach ($posttags as $tag) {
							echo '<a class="label ';
							echo $multiloquent->multiloquent_get_random_solid_class($tag->slug);
							echo '" href="' . get_tag_link($tag->term_id) . '"><span class="icon-tag icon-white"></span> ' . $tag->name . '</a>';
						}
					}
					?>
				</div>
			</div>
		</section>
		<?php
		if (function_exists('related_posts')) {
			related_posts();
		}
		?>
		<section class="w-full px-4 md:px-6">
			<?php
			get_template_part('advert');
			?>
		</section>
	<?php
		next_post_link('%link', '<span style="text-indent:-9000px; position:absolute;">%title</span><span class="next_link inline-flex items-center justify-center px-4 py-2 bg-[var(--color-primary)] text-white rounded-md hover:opacity-90 transition-colors"><span class="fa fa-chevron-left"></span></span>', true);
		previous_post_link('%link', '<span style="text-indent:-9000px; position:absolute;">%title</span><span class="prev_link inline-flex items-center justify-center px-4 py-2 bg-[var(--color-primary)] text-white rounded-md hover:opacity-90 transition-colors"><span class="fa fa-chevron-right"></span></span>', true);
		echo '</div>';
	}
} else {
	?>
	<div class="max-w-[var(--width-content)] mx-auto px-4 md:px-6">
		<?php
		get_template_part('error-snippet');
		?>
	</div>
<?php
}
echo '<!-- google_ad_section_end-->';
get_footer();
