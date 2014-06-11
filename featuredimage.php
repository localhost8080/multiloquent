<?php
if (has_post_thumbnail()) {
    // the current post has a thumbnail
    // set_post_thumbnail_size( 605, 100,1 ); // Normal post thumbnails
    $slider_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
    $theimg = $slider_image[0];
} else {
	$theimg = get_template_directory_uri() . '/images/default-slider.png';
}   
    // remove the domain part as some hosts baulk at it
    $urlparts = parse_url($theimg);
    $extracted = $_SERVER['DOCUMENT_ROOT'].$urlparts['path'];
    $dimensions = getimagesize($extracted);
    $width = $dimensions[0];
    $height = $dimensions[1];
    $thetitle = multiloquent_post_title();
    ?>
<figure class="thumbnail main_image">
    <img class="featured-image" width="<?php echo $width?>" height="<?php echo $height?>" src="<?php echo $theimg?>" alt="image for <?php echo multiloquent_post_title(); ?>" />
    <h1 class="container text-center">
         <?php echo $thetitle; ?>
     </h1>
    <figcaption>
    <span class="fa fa-comment-o fa-fw"></span> <?php echo $thetitle; ?></figcaption>
</figure>

