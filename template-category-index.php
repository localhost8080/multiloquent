<?php
/*
 * Template Name: Category Index
 */

get_header();
?>
<div class="bg-[var(--color-surface)] py-10">
	<div class="max-w-[var(--width-wide)] mx-auto px-4 md:px-6">
		<h1>
			<?php
			printf(
				esc_html__('Category List', 'multiloquent')
			);
			?>
		</h1>
	</div>
</div>
<div class="max-w-[var(--width-wide)] mx-auto px-4 md:px-6">
	<!-- google_ad_section_start-->
	<article>
		<?php echo $multiloquent->multiloquent_category_list_as_hierarchy('0'); ?>
	</article>
	<!-- google_ad_section_end-->

</div>
<?php
get_footer();
