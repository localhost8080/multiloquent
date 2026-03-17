<?php
/**
 * home page template part if static page selected as homepage
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package multiloquent\template_parts
 */

/**
 * template for static homepage if set in options
 */

if ( 'posts' == get_option( 'show_on_front' ) ) {
	include get_home_template();
} else {
	get_header();
	?>
	<!-- google_ad_section_start-->
	<div class="bg-[var(--color-surface)] py-10">
		<div class="max-w-[var(--width-wide)] mx-auto px-4 md:px-6">
			<?php
			while ( have_posts() ) {
				the_post();
				the_content();
			}
	?>
		</div>
	</div>
	<!-- google_ad_section_end-->
	<p class="text-lg text-center">
		<?php
		printf(
			esc_html__( 'Featured Posts', 'multiloquent' )
		);
	?>
	</p>
	<?php echo $multiloquent->multiloquent_paralax_slider(); ?>
	<div class="max-w-[var(--width-wide)] mx-auto px-4 md:px-6">
		<?php
		get_template_part( 'advert' );
	?>
	</div>
	<?php
	get_footer();
}
