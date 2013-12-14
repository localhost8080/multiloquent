<?php
/*
 * Template Name Posts: Adventures
 */
get_header();
echo '<!-- google_ad_section_start-->';
if (have_posts()) {
    while (have_posts()) {
        the_post();
        ?>
<div <? echo 'id="post-'.get_ the_ID().'" '. get_post_class("container post")?>>
    <h1 class="featurette-heading">
					<?php the_title();?>
				</h1>
				<?php
        $title_string = get_the_title();
        $title_string = str_replace('plan', '', $title_string);
        $title_string = str_replace('part', '', $title_string);
        $title_string = str_replace('day', '', $title_string);
        $title_string = str_replace('the', '', $title_string);
        $title_string = str_replace('in', '', $title_string);
        $title_string = str_replace('off', '', $title_string);
        $title_string = str_replace(':', '', $title_string);
        $title_string = str_replace('-', '', $title_string);
        $title_string = preg_replace('(\d+)', '', $title_string);
        $title_string = trim($title_string);
        $locations = explode(' to ', $title_string);
        get_template_part('breadcrumb');
        ?>

				<div class="span5">
        <iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.uk/maps?f=q&amp;source=s_q&amp;hl=en&amp;q=<?php echo $title_string?>&amp;saddr=<?php echo trim($locations[0])?>&amp;daddr=<?php echo trim($locations[1])?>&amp;ie=UTF8&amp;t=m&amp;z=8&amp;output=embed"></iframe>
					<?php
        if ($values = get_post_custom_values("leadvideo")) {
            echo $values[0];
        }
        ?>
				</div>
    <div class="content span6">
					<?php
        remove_filter('the_content', 'sharing_display', 19);
        remove_filter('the_excerpt', 'sharing_display', 19);
        the_content("<p class=\"serif\">" . __('Read the rest of this page', 'multiloquent') . " &raquo;</p>");
        wp_link_pages("<p><strong>" . __('Pages', 'multiloquent') . ":</strong>", '</p>', __('number', 'multiloquent'));
        ?>
				</div>
</div>
<?php
    }
} else {
    echo '<p>' . __('Sorry, no posts matched your criteria.', 'multiloquent') . '</p>';
}
echo '<!-- google_ad_section_end-->';
get_footer();
