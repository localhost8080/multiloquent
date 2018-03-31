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
	<div class="jumbotron">
		<div class="container-fluid clearfix">
			<?php
			while ( have_posts() ) {
				the_post();
				the_content();
			}
	?>
		</div>
	</div>
	<!-- google_ad_section_end-->
	<p class="lead text-center">
		<?php
		printf(
			esc_html_e( 'Featured Posts', 'multiloquent' )
		);
	?>
	</p>
	<?php echo $multiloquent->multiloquent_paralax_slider(); ?>
	<div class="container-fluid clearfix">
		<?php
		get_template_part( 'advert' );
	?>
	</div>
	<?php
	get_footer();
}
