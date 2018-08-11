<?php
/**
 * This is the error template part - it is included when no result is found from a search or archive page
 *
 * @package multiloquent\template_parts
 */

/**
 * snippet used if no results found.
 * wordpress template part
 */


echo $multiloquent->multiloquent_paralax_featured_sliders();
//require locate_template( 'featuredimage.php' );

 ?>



<div class="container-fluid clearfix">
	<?php
	get_template_part( 'advert' );
?>
	<!-- google_ad_section_start-->
</div>
<article class="container-fluid clearfix mt-5 text-center">
	<h1>
		<?php
		printf(
			esc_html__( 'I dont have anything that matches (or nearly matches) that', 'multiloquent' )
		);
?>
	</h1>

	<p>
		<?php
		printf(
			esc_html__( 'You might want to use the search or go to ', 'multiloquent' )
		);
		
		printf(
			'<a title="%1$s" href="%2$s">%1$s</a>',
			get_bloginfo( 'name' ),
			home_url()
		);
?>
	</p>
</article>
<div class="container-fluid clearfix">
	<!-- google_ad_section_end-->
	<?php
	get_template_part( 'advert' );
?>
</div>
