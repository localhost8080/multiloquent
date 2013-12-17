<?php
if (has_post_thumbnail()) {
    // the current post has a thumbnail
    // set_post_thumbnail_size( 605, 100,1 ); // Normal post thumbnails
    $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
    ?>
<figure class="thumbnail main_image">
    <img class="featured-image" width="605" height="100" src="<?php echo $image[0]?>" alt="image for <?php the_title(); ?>" />
    <figcaption>
        <span class="fa fa-comment-o fa-fw"></span> <?php the_title(); ?></figcaption>
</figure>
<?php
} else {
    // the current post lacks a thumbnail
    // use the old method
    if (get_post_meta($post->ID, 'leadimage', true)) {
    } else {
        global $hide_h1_tag;
        $hide_h1_tag = 1;
        ?>
<div class="jumbotron">
    <div class="container">
        <h1><?php the_title() ?></h1>
    </div>
</div>
<?php
    }
}
?>
