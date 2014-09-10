<?php
/*
 * Template Name Posts: Adventures
 */
get_header();
echo '<!-- google_ad_section_start-->';
if (have_posts()) {
    while (have_posts()) {
        the_post();
        get_template_part('featuredposts');
        get_template_part('featuredimage');
        echo '<div id="post-' . get_the_ID() . '" ';
        echo post_class('post');
        echo '>';
        
        $title_string = multiloquent_post_title();
        $title_string = str_replace('plan', '', $title_string);
        $title_string = str_replace('part', '', $title_string);
        $title_string = str_replace('day', '', $title_string);
        $title_string = str_replace('the', '', $title_string);
        $title_string = str_replace('in', '', $title_string);
        $title_string = str_replace('off', '', $title_string);
        $title_string = str_replace(':', '', $title_string);
        $title_string = preg_replace('(\d+)', '', $title_string);
        $title_string = trim($title_string);
        $locations = explode(' to ', $title_string);
        get_template_part('breadcrumb');
        ?>
        <div class="container">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.uk/maps?f=q&amp;source=s_q&amp;hl=en&amp;q=<?php echo $title_string?>&amp;saddr=<?php echo trim($locations[0])?>&amp;daddr=<?php echo trim($locations[1])?>&amp;ie=UTF8&amp;t=m&amp;z=8&amp;output=embed"></iframe>
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
