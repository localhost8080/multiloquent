</div>
<?php
get_sidebar();
get_template_part('navigation');
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
                <hr/>
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
wp_footer();
?>
<script type="text/javascript">
function resize_sidebar(){
    if(jQuery('.wrapper').height() < jQuery('.sidebar').height()){
        // the sidebar is bigger than the wrapper
        jQuery('.wrapper').css("height",jQuery('.sidebar').height());
    }
}
// resize the sidebar onload
jQuery(document).load(function() {
    resize_sidebar();
});
// need to do it on ready for pages, for some reason it doesnt fire in webkit
jQuery(document).ready(function(){
    resize_sidebar();
});
jQuery('.sidebar-toggle').click(function(){
    // total fail fallback - if for some reason the page hasnt resized, force it to resize now
    resize_sidebar();
    if(jQuery('.sidebar').css("margin-left")!='0px' )
    {
        // its not visible 
        jQuery('.prev_link').hide();
        jQuery('.next_link').hide();
        jQuery('.wrapper').css("overflow","hidden");
        jQuery('.wrapper').css("margin-left","300px");
        jQuery('.sidebar').css("margin-left","0px");   
    } else {
        // its already on the screen
        jQuery('.wrapper').css("margin-left","0px");
        jQuery('.sidebar').css("margin-left","-300px");
        jQuery('.prev_link').show();
        jQuery('.next_link').show();
    }
});

jQuery('.sidebar .menu a').click(function(event){
    // stop the link click targetting the containing element
    event.stopPropagation();
});
jQuery('.sidebar .menu ul > li.page_item_has_children').click(function(event){
    // this breaks the links though...
    jQuery(this).children('ul.children').slideToggle('400',resize_sidebar);  
    event.stopPropagation();
});


</script>
</body>
</html>
