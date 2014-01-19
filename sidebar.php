
<div class="row">
        <?php
        /* recent posts. */
        if (is_active_sidebar(4)) {
            echo '<div class="col-sm-6 col-md-6 col-lg-6 no-bullets">';
            dynamic_sidebar(4);
            echo '</div>';
        }
        if (is_active_sidebar(5)) {
            echo '<div class="col-sm-6 col-md-6 col-lg-6 no-bullets">';
            dynamic_sidebar(5);
            echo '</div>';
        }
        ?>
</div>
<div class="row">    
        <?php
        /* recent posts. */
        if (is_active_sidebar(6)) {
            echo '<div class="col-sm-6 col-md-6 col-lg-6 no-bullets">';
            dynamic_sidebar(6);
            echo '</div>';
        }
        if (is_active_sidebar(7)) {
            echo '<div class="col-sm-6 col-md-6 col-lg-6 no-bullets">';
            dynamic_sidebar(7);
            echo '</div>';
        }
        ?>
    </div>
<hr />
