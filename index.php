<?php
/**
 * fallback page if no other index page found
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package multiloquent\template_parts
 */

/**
 * fallback if no other archive pages are found
 */
get_header();
if (have_posts()) {
    ?>
    <div class="jumbotron">
        <div class="container-fluid clearfix">
            <header>
                <h1 class="article_title">
                    <?php
if (is_category()) {
        printf('%s', single_cat_title('', false));
    } elseif (is_tag()) {
        printf(
            esc_html_e('Posts Tagged %s', 'multiloquent'),
            single_tag_title()
        );
    } elseif (is_day()) {
        printf(
            esc_html_e('Archive for %s', 'multiloquent'),
            get_the_time('F jS, Y')
        );
    } elseif (is_month()) {
        printf(
            esc_html_e('Archive for %s', 'multiloquent')
            , get_the_time('F Y')
        );
    } elseif (is_year()) {
        printf(
            esc_html_e('Archive for %s', 'multiloquent'),
            get_the_time('Y')
        );
    } elseif (is_search()) {
        printf(
            esc_html_e('Search Results', 'multiloquent')
        );
    } elseif (is_author()) {
        printf(
            esc_html_e('All entries by this author', 'multiloquent')
        );
    } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
        printf(
            esc_html_e('Blog Archives', 'multiloquent')
        );
    } elseif (is_home()) {
        printf(
            esc_html_e('Recent Posts', 'multiloquent')
        );
    }
    ?>
                </h1>
            </header>
        </div>
    </div>
    <section class="container-fluid post clearfix">
        <?php
$colour = $multiloquent->multiloquent_get_random_blue_class();
    while (have_posts()) {
        the_post();
        $multiloquent->multiloquent_render_the_archive($colour);
    }
    ?>
    </section>
    <section class="container-fluid post clearfix">
        <?php
get_template_part('advert');
    ?>
    </section>
    <div class="container-fluid post clearfix">
        <nav class="navitems text-center">
            <ul class="pagination">
                <li><?php previous_posts_link('Previous Entries', 'multiloquent')?></li>
                <li><?php next_posts_link('Next Entries', 'multiloquent')?></li>
            </ul>
        </nav>
    </div>
<?php } else {?>
    <div class="container-fluid post clearfix">
        <?php
get_template_part('error-snippet');
    ?>
    </div>
<?php
}
get_footer();
