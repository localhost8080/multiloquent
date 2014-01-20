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
    multiloquent_render_the_archive($posts);
} else {
    echo '<p>No related posts.</p>';
}
?>
    </div>
</section>
