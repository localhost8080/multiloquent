<?php if (is_front_page ()) {
	get_header (); ?>
		<!-- google_ad_section_start-->
			<div class="hero-unit">
				 <?php rewind_posts();
					 while (have_posts()) {
		 				the_post();
		 			  	the_content("<p class=\"serif\">" . __('Read the rest of this page', 'jonathansblog') ." &raquo;</p>");
					 } ?>	
			</div>
		<!-- google_ad_section_end-->
		<div class="container">
			<?php get_template_part('advert');?>
		</div>
		<?php get_template_part('slider');?>
		<aside>
			<?php get_sidebar(); ?>
		</aside>
	<?php get_footer();
} else {
	get_header ();?>
		<div class="container">
			<!-- google_ad_section_start-->
				<article>
					 <?php rewind_posts();
					 while (have_posts()) {
		 				the_post();
		 			  	the_content("<p class=\"serif\">" . __('Read the rest of this page', 'jonathansblog') ." &raquo;</p>");
					 } ?>
				</article>		
			<!-- google_ad_section_end-->
			<?php get_template_part('advert');?>
		</div>
			<aside>
				<?php get_sidebar(); ?>
			</aside>
		<?php get_footer(); 
} 
?>
