<?php
/**
 * multiloquent theme footer
 */

/**
 * footer template part
 *
 * @package multiloquent\template_parts
 */
?>
</div>
<?php
get_sidebar();
?>
</div>
<?php
require(locate_template('navigation.php'));
if (empty($hide_the_footer_links)) {
    ?>
    <footer class="well">
        <div class="container">
            <aside>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6 no-bullets mb">
                        <?php
                        if (is_active_sidebar(6)) {
                            dynamic_sidebar(6);
                        }
                        ?>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 no-bullets mb">
                        <?php
                        if (is_active_sidebar(7)) {
                            dynamic_sidebar(7);
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6 no-bullets">
                        <p class="nav-header">Useful Stuff</p>
                        <?php
                        // sidebar 10 for some things in footer
                        if (is_active_sidebar(9)) {
                            dynamic_sidebar(9);
                        }
                        ?>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 no-bullets">
                        <p class="nav-header">More Useful Stuff</p>
                        <?php
                        // sidebar 10 for some things in footer
                        if (is_active_sidebar(10)) {
                            dynamic_sidebar(10);
                        }
                        ?>
                    </div>
                </div>
            </aside>
        </div>
    </footer>
    <?php
}
wp_footer();
?>
</body>
</html>
