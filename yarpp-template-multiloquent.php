<?php
/*
 * YARPP Template: multiloquent Author: jonathan Description: A simple example YARPP template.
 */
?>
<section class="container post">
    <h3>Other Posts related to <?php echo multiloquent_post_title(); ?></h3>
    <div class="row">
<?php
if (have_posts()) {
    $colour = multiloquent_get_random_blue_class();
    while (have_posts()) {
        the_post();
        multiloquent_render_the_archive($colour);
    }
} else {
    echo '<p>No related posts.</p>
        ';
}
?>
    </div>
</section>
