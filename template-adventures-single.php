<?php
/*
 * Template Name Posts: Adventures
 */

get_header();
echo '<!-- google_ad_section_start-->';
if (have_posts()) {
    while (have_posts()) {
        the_post();
        echo $multiloquent->multiloquent_paralax_featured_sliders();
        require(locate_template('featuredimage.php'));
        echo '<div id="post-' . get_the_ID() . '" ';
        echo post_class('post');
        echo '>';
        $title_string = $multiloquent->multiloquent_post_title();
        $title_string = preg_replace('(\d+)', '', $title_string);
        $title_string = preg_replace('/[^A-Za-z0-9 ]/', '', $title_string);
        $title_string = trim($title_string);
        $locations = explode(' to ', $title_string);

        $map_url  = 'https://www.google.com/maps/embed/v1/directions';
        $map_url .= '?key=AIzaSyCqrE65OBtskUyqwILNZlRQ3ikTOseYCuw';
        $map_url .= '&origin='.urlencode(trim($locations[0]));
        $map_url .= '&destination='.urlencode(trim($locations[1]));
        $map_url .= '&mode=walking';
        ?>
        <div class="container">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo $map_url?>"></iframe>
                <?php
                if ($values = get_post_custom_values('leadvideo')) {
                    echo '<iframe width="100%" height="400" src="//www.youtube.com/embed/';
                    echo $values[0];
                    echo '" frameborder="0" allowfullscreen></iframe>';
                }
                ?></div>
            </div>
            <div class="container">
                <div class="col-sm-12 col-md-12 col-lg-12">
                   <?php
                   remove_filter('the_content', 'sharing_display', 19);
                   remove_filter('the_excerpt', 'sharing_display', 19);
                   the_content('<p class="serif">' . 'Read the rest of this page' . ' &raquo;</p>');
                   wp_link_pages('<p><strong>Pages:</strong>', '</p>', 'number');
                   ?>
               </div>
           </div>
           <?php
           next_post_link('%link', '<span class="next_link btn btn-default btn-lg"><span class="fa fa-chevron-left"></span></span>', true);
           previous_post_link('%link', '<span class="prev_link btn btn-default btn-lg"><span class="fa fa-chevron-right"></span></span>', true);
           echo '</div>';
       }
   } else {
    echo '<p>Sorry, no posts matched your criteria.<p>';
}
echo '<!-- google_ad_section_end-->';
get_footer();
