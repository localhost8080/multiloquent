<?php
/*
 * YARPP Template: multiloquent Author: jonathan Description: A simple example YARPP template.
 */
global $multiloquent;
?>
<section class="w-full max-w-[var(--width-wide)] mx-auto px-4 md:px-6">
	<div class="archive-grid">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				$multiloquent->multiloquent_render_the_archive();
			}
		} else {
			echo '<p>';
			printf( esc_html__( 'No related posts.', 'multiloquent' ) );
			echo '</p>';
		}
?>
	</div>
</section>
