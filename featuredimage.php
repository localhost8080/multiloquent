<?php
if (has_post_thumbnail()) {
    // the current post has a thumbnail
    // set_post_thumbnail_size( 605, 100,1 ); // Normal post thumbnails
    $slider_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
    $theimg = $slider_image[0];
    $dimensions = getimagesize($theimg);
    $width = $dimensions[0];
    $height = $dimensions[1];
    ?>
<figure class="thumbnail main_image">
    <img class="featured-image" width="<?php echo $width?>" height="<?php echo $height?>" src="<?php echo $theimg?>" alt="image for <?php echo multiloquent_post_title(); ?>" />
    <figcaption>
        <span class="fa fa-comment-o fa-fw"></span> <?php echo multiloquent_post_title(); ?></figcaption>
</figure>
<?php
} else {
    // the current post lacks a thumbnail
    // use the old method
    if (get_post_meta($post->ID, 'leadimage', true)) {
    } else {
        global $multiloquent_hide_h1_tag;
        $multiloquent_hide_h1_tag = 1;
        ?>
<div class="jumbotron">
    <div class="container">
        <h1><?php echo multiloquent_post_title(); ?></h1>
    </div>
</div>
<?php
    }
}
