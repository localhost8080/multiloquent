<?php get_header(); ?>
	<!-- google_ad_section_start-->
	<?php if (have_posts()) {
		while (have_posts()) {
			the_post(); ?>	
				<?php get_template_part('featuredimage');?>			
				<div id="post-<?php the_ID(); ?>" <?php post_class("post");?>>
					<?php if(empty($hide_h1_tag)){?>
					<h1 class="container featurette-heading">
						<?php the_title();?>
					</h1>
					<?}?>
					<?php get_template_part('breadcrumb'); ?>
					
					<div class="container">
						<div class="col-sm-12 col-md-6 col-lg-7">
							<?php if ($values = get_post_custom_values("leadvideo")){
								echo '<iframe width="100%" height="400" src="//www.youtube.com/embed/';
								echo $values[0]; 
								echo '" frameborder="0" allowfullscreen></iframe>'; 
								}
							?>
							<?php
							remove_filter( 'the_content', 'sharing_display', 19 );
							remove_filter( 'the_excerpt', 'sharing_display', 19 );
							the_content("<p class=\"serif\">" . __('Read the rest of this page', 'jonathansblog') ." &raquo;</p>");
							wp_link_pages("<p><strong>" . __('Pages', 'jonathansblog') . ":</strong>", '</p>', __('number','jonathansblog'));
							?>	
							<?php get_template_part('advert');?>					
						</div>
						<section class="col-sm-12 col-md-6 col-lg-5 comments">
							<?php comments_template(); ?>
							<?php get_template_part('advert');?>
						</section>					
					</div>
						<?php get_template_part('social');?>
					<section class="container">
							<div class="tagcloud">
								<div class="tag-cloud col-sm-12 col-md-12 col-lg-12">
									<h3>Tags for <?php the_title(); ?></h3><div>
									<?php
									
									$posttags = get_the_tags();
									if ($posttags) {
									  foreach($posttags as $tag) {
										//if($tag->count > 5){
									    	echo '<a class="label ';
									    	echo get_random_solid_class($tag->slug);
											echo '" rel="nofollow" href="/tag/'.$tag->slug.'"><span class="fa fa-folder-o fa-fw"></span> '.$tag->name.'</a>'; 
									    //}
									  }
									}
									?>
									</div>
								</div>
							</div>
					</section>
				<?php if(function_exists('related_posts')){?>
					<section class="container post">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<?php related_posts();?>
						</div>
					</section>
				<?php }/*?>
				<div class="container post">
					<?php //get_template_part('social');?>
				</div>*/?>
				<?php get_template_part('advert');?>
			</div> 
	<?php }
} else{ ?>
		<p>
			<?php __('Sorry, no posts matched your criteria.','jonathansblog');?>
		</p>
	<?php } ?>
	<!-- google_ad_section_end-->	
<?php get_footer(); ?>