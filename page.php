<?php
get_header();
if (is_front_page()) {
    ?>
<!-- google_ad_section_start-->
<div class="jumbotron">
    <div class="container">
                <?php
    rewind_posts();
    while (have_posts()) {
        the_post();
        the_content("<p class=\"serif\">" . __('Read the rest of this page', 'multiloquent') . " &raquo;</p>");
    }
    ?>    
    </div>
</div>
<!-- google_ad_section_end-->
<div class="container">
            <?php get_template_part('advert');?>
        </div>
<?php
    get_template_part('slider');
} else {
    ?>
<div class="container">
    <!-- google_ad_section_start-->
    <article>
                     <?php
    rewind_posts();
    while (have_posts()) {
        the_post();
        the_content("<p class=\"serif\">" . __('Read the rest of this page', 'multiloquent') . " &raquo;</p>");
    }
    ?>
    </article>
    <!-- google_ad_section_end-->
            <?php get_template_part('advert');?>
        </div>
<?php
}
get_footer();
