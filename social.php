<section class="navbar navbar-default navbar-fixed-bottom">
    <div class="container">
        <div class="col-xs-4 col-sm-7 col-md-6 col-lg-6">
            <?php
            // in here goes the jetpack plugin thing
            if (function_exists('sharing_display')) {
                echo sharing_display();
            }
            ?>
        </div>
        <div class="col-xs-6 col-sm-5 col-md-6 col-lg-6 sharing_buttons">
           <?php
        if (function_exists('dynamic_sidebar') && is_active_sidebar(8)) {
            echo '<div class="col-sm-6 col-md-6 col-lg-6 no-bullets">';
            dynamic_sidebar(8);
            echo '</div>';
        }
        ?>
        </div>
    </div>
</section>