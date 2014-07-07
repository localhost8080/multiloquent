function resize_sidebar() {
    if (jQuery('.wrapper').height() < jQuery('.sidebar').height()) {
        // the sidebar is bigger than the wrapper
        jQuery('.wrapper').css("min-height", jQuery('.sidebar').height());
    } else {
        // make the sidebar the same height as the wrapper, incase its smaller
        jQuery('.sidebar').css("min-height", jQuery('.wrapper').height());
    }
}
// resize the sidebar onload

jQuery(document).load(function() {
    resize_sidebar();
});
// need to do it on ready for pages, for some reason it doesnt fire in webkit
jQuery(document).ready(function() {
    resize_sidebar();
});
jQuery('.sidebar-toggle').click(function() {
    // total fail fallback - if for some reason the page hasnt resized, force it
    // to resize now
    resize_sidebar();
    if (jQuery('.sidebar').css("margin-left") != '0px') {
        // its not visible
        jQuery('.prev_link').hide();
        jQuery('.next_link').hide();
        jQuery('.wrapper').css("overflow", "hidden");
        jQuery('.wrapper').css("margin-left", "300px");
        jQuery('.wrapper').css("margin-right", "-300px");
        jQuery('.sidebar').css("margin-left", "0px");
    } else {
        // its already on the screen
        jQuery('.wrapper').css("margin-left", "0px");
        jQuery('.sidebar').css("margin-left", "-300px");
        jQuery('.wrapper').css("margin-right", "0px");
        jQuery('.prev_link').show();
        jQuery('.next_link').show();
    }
});

jQuery('.sidebar .menu a').click(function(event) {
    // stop the link click targetting the containing element
    event.stopPropagation();
});
jQuery('.sidebar .menu ul > li.page_item_has_children').click(function(event) {
    // this breaks the links though...
    jQuery(this).children('ul.children').slideToggle('400', resize_sidebar);
    event.stopPropagation();
});
jQuery('.sidebar ul.menu > li.menu-item-has-children').click(function(event) {
    // this breaks the links though...
    jQuery(this).children('ul.sub-menu').slideToggle('400', resize_sidebar);
    event.stopPropagation();
});