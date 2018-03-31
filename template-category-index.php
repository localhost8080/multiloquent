<?php
/*
 * Template Name: Category Index
 */

get_header();
?>
    <div class="jumbotron">
        <div class="container-fluid clearfix">
            <h1>
                <?php
printf(
    esc_html_e('Category List', 'multiloquent')
);
?>
            </h1>
        </div>
    </div>
    <div class="container-fluid clearfix">
        <!-- google_ad_section_start-->
        <article>
            <?php echo $multiloquent->multiloquent_category_list_as_hierarchy('0'); ?>
        </article>
        <!-- google_ad_section_end-->
        <?php
get_template_part('advert');
?>
    </div>
<?php
get_footer();
