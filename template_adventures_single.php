<?php
/*
Template Name Posts: Adventures
*/
?>
<?php get_header(); ?>
	<!-- google_ad_section_start-->
	<?php if (have_posts()) {
		while (have_posts()) {
			the_post(); ?>		
			<?php get_template_part('featuredimage');?>		
			<div id="post-<?php the_ID(); ?>" <?php post_class("post");?>>				
				<?php if(empty($hide_h1_tag)){?>
				<h1 class="featurette-heading container">
					<?php the_title();?>
				</h1>
				<?}?>
				<?php 
					$title_string = get_the_title();
					$title_string = str_replace('plan','',$title_string);
					$title_string = str_replace('part','',$title_string);
					$title_string = str_replace('day','',$title_string);
					$title_string = str_replace('the','',$title_string);
					$title_string = str_replace('in','',$title_string);
					$title_string = str_replace('off','',$title_string);
					$title_string = str_replace(':','',$title_string);
					$title_string = str_replace('–','',$title_string);				
					$title_string = preg_replace('(\d+)', '', $title_string);
					$title_string = trim($title_string);
					$locations = explode(' to ', $title_string);
					get_template_part('breadcrumb'); 
				?>

				<div class="container">
					<iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.uk/maps?f=q&amp;source=s_q&amp;hl=en&amp;q=<?=$title_string?>&amp;saddr=<?=trim($locations[0])?>&amp;daddr=<?=trim($locations[1])?>&amp;ie=UTF8&amp;t=m&amp;z=8&amp;output=embed"></iframe>
					<?php 
						if ($values = get_post_custom_values("leadvideo")){
							echo '<iframe width="100%" height="400" src="//www.youtube.com/embed/';
							echo $values[0]; 
							echo '" frameborder="0" allowfullscreen></iframe>';
						}
					?>
				</div>
				<div class="container">
					<?php
						remove_filter( 'the_content', 'sharing_display', 19 );
						remove_filter( 'the_excerpt', 'sharing_display', 19 );
						the_content("<p class=\"serif\">" . __('Read the rest of this page', 'jonathansblog') ." &raquo;</p>");
						wp_link_pages("<p><strong>" . __('Pages', 'jonathansblog') . ":</strong>", '</p>', __('number','jonathansblog'));
					?>
				</div>
			</div> 
	<?php }
} else{ ?>
	<p>
		<?php __('Sorry, no posts matched your criteria.','jonathansblog');?>
	</p>
<?php } ?>
	<!-- google_ad_section_end-->
<?php get_footer(); ?>