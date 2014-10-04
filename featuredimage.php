<?php
/**
 * output the featured image, or a default image if none set
 */

/**
 * template part to output a featured image or a default image if none set
 *
 * @package multiloquent\template_parts
 */

if (has_post_thumbnail()) {
    // the current post has a thumbnail
    // set_post_thumbnail_size( 605, 100,1 ); // Normal post thumbnails
    $slider_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
    $theimg = $slider_image[0];
} else {
	$theimg = get_header_image();
}
    // remove the domain part as some hosts baulk at it
    //$urlparts = parse_url($theimg);
    //$extracted = $_SERVER['DOCUMENT_ROOT'].$urlparts['path'];
    //$dimensions = getimagesize($extracted);
    //$width = $dimensions[0];
    //$height = $dimensions[1];

?>

<h1 class="multiloquent_h1_tag" style="background-image:url('<?php echo $theimg;?>');"><?php echo $multiloquent->multiloquent_post_title(); ?></h1>
<figure class="thumbnail main_image">
    <figcaption>
        <span class="fa fa-comment-o fa-fw"></span> <?php echo $multiloquent->multiloquent_post_title(); ?></figcaption>
    </figure>

