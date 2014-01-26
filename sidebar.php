
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
            <p><span class="fa fa-gamepad fa-fw"></span><span style="font-size: 12px;">This website is most definitely not best viewed in Netscape</span></p>
            <p><span class="fa fa-folder-open-o fa-fw"></span> multiloquent html5 theme <?php echo multiloquent_version();?></p>
</div>
