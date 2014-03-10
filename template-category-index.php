<?php
/*
 * Template Name: Category Index
 */
get_header();
?>
<div class="jumbotron">
    <div class="container">
        <h1>Category list</h1>
    </div>
</div>
<div class="container">
    <!-- google_ad_section_start-->
    <article>
		<?php echo multiloquent_category_list_as_hierarchy('0'); ?>	
	</article>
    <!-- google_ad_section_end-->
	<?php multiloquent_get_template_part('advert'); ?>
</div>
<?php get_footer();
