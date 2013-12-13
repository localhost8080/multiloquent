<?php
/*
 * YARPP Template: multiloquent Author: jonathan Description: A simple example YARPP template.
 */
?><h3>Other Posts related to <?php the_title(); ?></h3>
<div class="row">
<?php

if (have_posts()) {
    $post = $posts[0];
    
    $tile_colour = get_random_blue_class();
    while (have_posts()) {
        the_post();
        // set it to blank so that it doesnt keep the previous one
        $slider_image = array();
        $slider_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
        if (! empty($slider_image)) {
            $theimg = $slider_image[0];
            $width = $slider_image[1];
            $height = $slider_image[2];
        } else {
            $theimg = get_template_directory_uri() . '/images/default-slider.png';
            $width = '1100';
            $height = '500';
        }
        ?>
    	<div class="paralax_image_holder span4"
        style="margin-bottom: 30px;">
        <img src="<?php echo $theimg?>" class="grayscale"
            alt="<?php the_title()?>" width="<?php echo $width ?>"
            height="<?php echo $height ?>">
        <div class="paralax_image_bg <?php echo $tile_colour?>"></div>
        <div class="paralax_image_text">
            <h1>
                <a href="<?php the_permalink() ?>"><?php the_title()?></a>
            </h1>
            <p>
		
        <?php
        $posttags = wp_get_post_tags($post->ID);
        if ($posttags) {
            foreach ($posttags as $tag) {
                echo '<a class="label ';
                echo get_random_solid_class($tag->slug);
                echo '" rel="nofollow" href="/tag/' . $tag->slug . '"><span class="fa fa-folder-o fa-fw"></span> ' .
                     $tag->name . '</a>';
            }
        }
        ?>
            </p>
        </div>
    </div>		
	<?php } ?>
</div>
<?php
} else {
    ?>
<p>No related posts.</p>
<?php
}
?>

 