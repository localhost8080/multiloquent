</div>
<?php 
get_sidebar();
multiloquent_get_template_part('navigation'); ?>
<footer class="well">
    <div class="container">
        <aside>
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
                <p class="col-sm-12 col-md-12 col-lg-12">
                    <span class="fa fa-gamepad fa-fw"></span><span style="font-size: 12px;">This website is most definitely not best viewed in Netscape</span>
                </p>
                <p class="col-sm-12 col-md-12 col-lg-12">
                    <span class="fa fa-folder-open-o fa-fw"></span> multiloquent html5 theme <?php echo multiloquent_version();?>
                </p>
            </div>
        </aside>
    </div>
</footer>

<?php

wp_footer();
?>
<script type="text/javascript">
if(jQuery('.wrapper').height() < jQuery('.sidebar').height()){
    // the sidebar is bigger than the wrapper
       jQuery('.wrapper').css("height",jQuery('.sidebar').height());
}
jQuery('.sidebar-toggle').click(function(){
    if(jQuery('.sidebar').css("margin-left")!='0px' )
    {
        // its not visible 
        jQuery('.wrapper').css("overflow","hidden");
        jQuery('.wrapper').css("margin-left","20%");
        jQuery('.sidebar').css("margin-left","0");   
    } else {
        // its already on the screen
        jQuery('.wrapper').css("margin-left","0");
        jQuery('.sidebar').css("margin-left","-20%");
    }
});

</script>
</body>
</html>
