<?php get_template_part('navigation'); ?>
<footer class="well">
    <div class="container">
        <aside>
            <?php get_sidebar(); ?>
        </aside>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 no-bullets">
                <p class="nav-header">Useful Stuff</p>
                <ul>
                        
                    <?php
    global $user_ID;
    if ($user_ID && current_user_can('update_core')) {
        ?>
                            <li><a href="/wp-admin"><span class="fa fa-user fa-fw"></span> Dashboard</a></li>
                        <?php }else{ ?>
                            <li><a href="/wp-login.php"><span class="fa fa-lock fa-fw"></span> Login</a></li>
                        <?php } ?>
                    <li><span class="fa fa-clock-o fa-fw"></span> &#169; 2008 - <?php echo date('Y') .' '. get_bloginfo('name'); ?></li>
                    <li><span class="fa fa-folder-open-o fa-fw"></span> multiloquent html5 theme <?php echo version();?></li>
                    <li><span class="fa fa-gamepad fa-fw"></span><span style="font-size: 12px;">This website is most definitely not best viewed in Netscape</span></li>
                </ul>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 no-bullets">
                <p class="nav-header">More Useful Stuff</p>
                <?php
    // sidebar 10 for some things in footer
    if (! function_exists('dynamic_sidebar') || ! dynamic_sidebar(10)) {
    }
    ?>
            </div>
        </div>
    </div>
</footer>
<?php get_template_part('js_load'); ?>
<?php

if (function_exists('tptn_add_viewed_count')) {
    echo tptn_add_viewed_count(' ');
}
?>
<?php wp_footer(); ?>
</body>
</html>
