<?php
/*
 * Template Name: tag Index
*/
get_header();
?>
<div class="jumbotron">
    <div class="container">
        <h1>Tag list</h1>
    </div>
</div>
<div class="container">
    <!-- google_ad_section_start-->
    <article>
     <?php
    // Make an array from A to Z.
    // $characters = range('a', 'z');
    // Check if $characters exists and ensure that it is an array.
    //  if ($characters && is_array($characters)) {
    //  foreach ($characters as $index => $character) {
    // Get the tag information for each characters in the array.
     $tags = get_tags(array(
                      'order' => 'ASC',
                      ));
            // print_r($tags);
     if ($index != 0 && $index % 4 == 0) {
        $html = "<div class='post-tags clearfix' style='clear:left;'>";
    } else {
        $html = "<div class='post-tags clearfix'>";
    }
            // Output the character and use it as the title.
    $html .= "<h3 class='title'>{$character}</h3>";
            // Output the markup for each tag found for each character.
    if ($tags) {
        $html .= '<ul class="thumbnails row">';
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
                $html .= '<li class="tag-item tile tile-double double-height col-sm-6 col-md-4 col-lg-3 ' . $tile_colour . '" onclick="javascript:window.location.href=';
                $html .= "'" . $tag_link . "'";
                $html .= '" >';
            } elseif (strlen($tag->name) > '10') {
                $html .= '<li class="tag-item tile tile-double col-sm-6 col-md-4 col-lg-3 ' . $tile_colour . '" onclick="javascript:window.location.href=';
                $html .= "'" . $tag_link . "'";
                $html .= '" >';
            } elseif (strlen($tag->name) > '5') {
                $html .= '<li class="tag-item tile tile-double col-sm-6 col-md-4 col-lg-3 ' . $tile_colour . '" onclick="javascript:window.location.href=';
                $html .= "'" . $tag_link . "'";
                $html .= '" >';
            } else {
                $html .= '<li class="tag-item tile col-sm-6 col-md-4 col-lg-3 ' . $tile_colour . '" onclick="javascript:window.location.href=';
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
            $html .= '<span class="badge">' . $tag->count . '</span>';
            $html .= '</li>';
        }
        $html .= '</ul>';
    }
    $html .= '</div>';
            // Output the markup for the current character.
    echo $html;
            // Increment the index by 1.
    $index ++;
       // }
   // }
    ?>
</article>
<!-- google_ad_section_end-->
<?php require(locate_template('advert.php'));?>
</div>
<?php get_footer();
