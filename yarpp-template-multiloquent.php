<?php
/*
 * YARPP Template: multiloquent Author: jonathan Description: A simple example YARPP template.
 */
global $multiloquent;
?>
<section class="container-fluid post">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <?php
            /*
             * <h3>
             * <?php
             * // printf(
             * // __('Other Posts related to %s', 'multiloquent'),
             * // $multiloquent->multiloquent_post_title()
             * // );
             *
             * __('Related Posts', 'multiloquent');
             * ?>
             *
             * </h3>
             */
            ?>

            <div>
                <?php
                if (have_posts()) {
                    $colour = $multiloquent->multiloquent_get_random_blue_class();
                    while (have_posts()) {
                        the_post();
                        $multiloquent->multiloquent_render_the_archive($colour);
                    }
                } else {
                    echo '<p>';
                    printf(__('No related posts.', 'multiloquent'));
                    echo '</p>';
                }
                ?>
            </div>
        </div>
    </div>
</section>
