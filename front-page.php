<?php
get_header();
if ('posts' == get_option('show_on_front')) {
    echo multiloquent_paralax_slider();
    include (get_home_template());
} else {
    ?>
<!-- google_ad_section_start-->
<div class="jumbotron">
    <div class="container">
            <?php
    while (have_posts()) {
        the_post();
        the_content("<p class=\"serif\">" . 'Read the rest of this page' . " &raquo;</p>");
    }
    ?>    
            </div>
</div>
<!-- google_ad_section_end-->
<?php echo multiloquent_paralax_slider();?>
<div class="container">
            <?php get_template_part('advert');?>
        </div>
<?php
}
get_footer();
