<?php
/*
 * Template Name: tag Index
 */
get_header();
?>
<div class="bg-[var(--color-surface)] py-10">
	<div class="max-w-[var(--width-wide)] mx-auto px-4 md:px-6">
		<h1>
			<?php
			printf(
				esc_html__('Tags List', 'multiloquent')
			);
			?>
		</h1>
	</div>
</div>
<div class="max-w-[var(--width-wide)] mx-auto px-4 md:px-6">
	<!-- google_ad_section_start-->
	<article>
		<?php
		$tags = get_tags(
			array(
				'order' => 'ASC',
			)
		);
		if ($index != 0 && $index % 4 == 0) {
			$html = "<div class='post-tags' style='clear:left;'>";
		} else {
			$html = "<div class='post-tags'>";
		}
		$html .= "<h3 class='title'>{$character}</h3>";
		if ($tags) {
			$html .= '<ul class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 list-none p-0">';
			$first_colour = $multiloquent->multiloquent_get_random_solid_class($tag->slug);
			foreach ((array) $tags as $tag) {
				$tag_link = get_tag_link($tag->term_id);
				$second_colour = $multiloquent->multiloquent_get_random_blue_class($tag->slug);
				if ($tag->slug == $second_colour) {
					$tile_colour = $second_colour;
				} else {
					$tile_colour = $first_colour;
				}
				if (strlen($tag->name) > '30') {
					$html .= '<li class="tag-item tile tile-double double-height ' . $tile_colour . '" onclick="javascript:window.location.href=';
					$html .= "'" . $tag_link . "'";
					$html .= '" >';
				} elseif (strlen($tag->name) > '10') {
					$html .= '<li class="tag-item tile tile-double ' . $tile_colour . '" onclick="javascript:window.location.href=';
					$html .= "'" . $tag_link . "'";
					$html .= '" >';
				} elseif (strlen($tag->name) > '5') {
					$html .= '<li class="tag-item tile tile-double ' . $tile_colour . '" onclick="javascript:window.location.href=';
					$html .= "'" . $tag_link . "'";
					$html .= '" >';
				} else {
					$html .= '<li class="tag-item tile ' . $tile_colour . '" onclick="javascript:window.location.href=';
					$html .= "'" . $tag_link . "'";
					$html .= '" >';
				}
				if (strlen($tag->name) > '30') {
					$html .= '<h2 class="nowrap"><a href="' . $tag_link . '" title="View all ' . $tag->count . ' articles with the tag of ' . $tag->name . '" >';
					$html .= "{$tag->name}</a></h2>";
				} elseif (strlen($tag->name) > '10') {
					$html .= '<h3><a href="' . $tag_link . '" title="View all ' . $tag->count . ' articles with the tag of ' . $tag->name . '" >';
					$html .= "{$tag->name}</a></h3>";
				} else {
					$html .= '<h2><a href="' . $tag_link . '" title="View all ' . $tag->count . ' articles with the tag of ' . $tag->name . '" >';
					$html .= "{$tag->name}</a></h2>";
				}
				$html .= '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-[var(--color-primary)] text-white">' . $tag->count . '</span>';
				$html .= '</li>';
			}
			$html .= '</ul>';
		}
		$html .= '</div>';
		echo $html;
		$index++;
		?>
	</article>
	<!-- google_ad_section_end-->

</div>
<?php
get_footer();
