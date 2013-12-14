<?php get_header(); ?>
<!-- google_ad_section_start-->
<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();
        get_template_part('featuredimage');
        ?>
<div id="post-<?php the_ID(); ?>" <?php post_class("container post");?>>
			
			<?php
        if (empty($hide_h1_tag)) {
            ?>
				<h1 class="featurette-heading">
					<?php the_title();?>
				</h1>
			<?php
        }
        get_template_part('breadcrumb');
        if ($values = get_post_custom_values("leadvideo")) {
            echo $values[0];
        }
        ?>
			<div class="container">
        <div class="content">
					<?php
        get_template_part('advert');
        remove_filter('the_content', 'sharing_display', 19);
        remove_filter('the_excerpt', 'sharing_display', 19);
        the_content("<p class=\"serif\">" . __('Read the rest of this page', 'multiloquent') . " &raquo;</p>");
        wp_link_pages("<p><strong>" . __('Pages', 'multiloquent') . ":</strong>", '</p>', __('number', 'multiloquent'));
        ?>						
				</div>
        <section class="comments">
            <h3 class="hidden-desktop">Comments for <?php the_title(); ?></h3>
					<?php
        comments_template();
        get_template_part('advert');
        ?>
				</section>
    </div>
    <section class="navbar navbar-fixed-bottom">
        <div class="navbar-inner">
            <div class="container">
                <h5 class="span1 hidden-phone">Sharing</h5>
                <div class="span">
							<?php
        // in here goes the jetpack plugin thing
        if (function_exists('sharing_display')) {
            echo sharing_display();
        }
        ?>
						</div>
            </div>
        </div>
    </section>
    <section class="container post">
        <div class="tagcloud">
            <div class="tag-cloud">
                <h3>Tags for <?php the_title(); ?></h3>
						<?php
        $posttags = get_the_tags();
        if ($posttags) {
            foreach ($posttags as $tag) {
                // if($tag->count > 5){
                echo '<a class="label ';
                echo get_random_solid_class($tag->slug);
                echo '" rel="nofollow" href="/tag/' . $tag->slug . '"><span class="fa fa-folder-o fa-fw"></span> ' .
                     $tag->name . '</a>';
                // }
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
        get_template_part('advert');
        ?>
		</div>
<?php
    }
} else {
    ?>
<p>
	<?php __('Sorry, no posts matched your criteria.','multiloquent');?>
</p>
<?php } ?>
<!-- google_ad_section_end-->
<?php get_footer(); ?>