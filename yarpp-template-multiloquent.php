<?php
/*
 * YARPP Template: multiloquent Author: jonathan Description: A simple example YARPP template.
 */
?>
<section class="container post">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <h3>Other Posts related to <?php echo multiloquent_post_title(); ?></h3>
            <div>
                <?php
                if (have_posts()) {
                    $colour = multiloquent_get_random_blue_class();
                    while (have_posts()) {
                        the_post();
                        multiloquent_render_the_archive($colour);
                    }
                } else {
                    echo '<p>No related posts.</p>';
                }
                ?>
            </div>
        </div>ß
    </div>
</section>
