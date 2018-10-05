<?php
/**
 * static page template part
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package multiloquent\template_parts
 */

/**
 * static page template
 */

get_header();
echo '<!-- google_ad_section_start-->';
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		echo $multiloquent->multiloquent_paralax_featured_sliders();
		require locate_template( 'featuredimage.php' );
		echo '<div id="post-' . get_the_ID() . '" ';
		echo post_class( 'post' );
		echo '>';
		require locate_template( 'breadcrumb.php' );
		?>
		<div class="container clearfix">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<?php
				
				// remove_filter( 'the_content', 'sharing_display', 19 );
				// remove_filter( 'the_excerpt', 'sharing_display', 19 );
				the_content();
				wp_link_pages( '<p><strong>Pages:</strong>', '</p>', 'number' );
				?>
			</div>
			<?php
			get_template_part( 'advert' );
			?>
		</div>
		<?php
		get_template_part( 'social' );
		if ( comments_open() ) {
			?>
			<section class="container clearfix">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<h3 class="hidden-lg">
						<?php
						printf(
							esc_html__( 'Comments for %s', 'multiloquent' ),
							$multiloquent->multiloquent_post_title()
						);
						?>
					</h3>
					<?php
					comments_template();
					get_template_part( 'advert-secondary' );
					?>
				</div>
			</section>
		<?php
		}

		if ( function_exists( 'related_posts' ) ) {
			related_posts();
		}
		?>
		<section class="container-fluid clearfix">
			<?php
			get_template_part( 'advert' );
			?>
		</section>
		<?php
		echo '</div>';
	}
} else {
?>
	<div class="container post clearfix">
		<?php
		get_template_part( 'error-snippet' );
		?>
	</div>
<?php
}
echo '<!-- google_ad_section_end-->';
get_footer();
