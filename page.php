<?php
get_header();
?>
<div class="container">
    <!-- google_ad_section_start-->
    <article>
    <?php
    rewind_posts();
    while (have_posts()) {
        the_post();
        the_content("<p class=\"serif\">" . 'Read the rest of this page' . " &raquo;</p>");
    }
    ?>
    </article>
     <?php
    if (comments_open()) {
        ?>
<section class="comments_full container">
        <h3 class="hidden-lg">Comments for <?php echo multiloquent_post_title() ?></h3>
                    <?php comments_template(); ?>    
                </section>
<?php
    }
    ?>
    <!-- google_ad_section_end-->
    
            <?php multiloquent_get_template_part('advert');?>
        </div>
<?php
get_footer();
