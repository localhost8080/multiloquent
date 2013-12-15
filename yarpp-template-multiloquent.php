<?php
/*
 * YARPP Template: multiloquent Author: jonathan Description: A simple example YARPP template.
 */
?>
<section class="container post">
    <h3>Other Posts related to <?php the_title(); ?></h3>
    <div class="row">
<?php
if (have_posts()) {
    render_the_archive($posts);
} else {
    echo '<p>No related posts.</p>';
}
?>
    </div>
</section>
