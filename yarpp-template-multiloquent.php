<?php
/*
 * YARPP Template: multiloquent Author: jonathan Description: A simple example YARPP template.
 */
global $multiloquent;
?>
<section class="w-full max-w-[var(--width-wide)] mx-auto px-4 md:px-6">
	<div>
		<?php
		if ( have_posts() ) {
			$colour = $multiloquent->multiloquent_get_random_blue_class();
			while ( have_posts() ) {
				the_post();
				$multiloquent->multiloquent_render_the_archive( $colour );
			}
		} else {
			echo '<p>';
			printf( esc_html__( 'No related posts.', 'multiloquent' ) );
			echo '</p>';
		}
?>
	</div>
</section>
