function resize_sidebar() {
    if ($('.wrapper').height() < $('.sidebar').height()) {
        // the sidebar is bigger than the wrapper
        $('.wrapper').css("height", $('.sidebar').height());
    }
}
// resize the sidebar onload
$(document).load(function() {
    resize_sidebar();
});
// need to do it on ready for pages, for some reason it doesnt fire in webkit
$(document).ready(function() {
    resize_sidebar();
});
$('.sidebar-toggle').click(function() {
    // total fail fallback - if for some reason the page hasnt resized, force it
    // to resize now
    resize_sidebar();
    if ($('.sidebar').css("margin-left") != '0px') {
        // its not visible
        $('.prev_link').hide();
        $('.next_link').hide();
        $('.wrapper').css("overflow", "hidden");
        $('.wrapper').css("margin-left", "300px");
        $('.sidebar').css("margin-left", "0px");
    } else {
        // its already on the screen
        $('.wrapper').css("margin-left", "0px");
        $('.sidebar').css("margin-left", "-300px");
        $('.prev_link').show();
        $('.next_link').show();
    }
});

$('.sidebar .menu a').click(function(event) {
    // stop the link click targetting the containing element
    event.stopPropagation();
});
$('.sidebar .menu ul > li.page_item_has_children').click(function(event) {
    // this breaks the links though...
    $(this).children('ul.children').slideToggle('400', resize_sidebar);
    event.stopPropagation();
});