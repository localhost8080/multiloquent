<?php
/**
 * The template for displaying Archive pages
 */

/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example,  multiloquent
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package multiloquent
 */
get_header();
if (have_posts()) {
    ?>
    <div class="jumbotron">
        <div class="container">
            <header>
                <h1 class="article_title">
                     <?php
                     if (is_category()) {
                        printf('%s', single_cat_title('', false));
                    } elseif (is_tag()) {
                        echo 'Posts Tagged';
                        echo '&#8216; ';
                        single_tag_title();
                        echo '&#8217;';
                    } elseif (is_day()) {
                        printf('Archive for %s', get_the_time('F jS, Y'));
                    } elseif (is_month()) {
                        printf('Archive for %s', get_the_time('F Y'));
                    } elseif (is_year()) {
                        printf('Archive for %s', get_the_time('Y'));
                    } elseif (is_search()) {
                        echo 'Search Results';
                    } elseif (is_author()) {
                        echo 'All entries by this author';
                    } elseif (isset($_GET['paged']) && ! empty($_GET['paged'])) {
                        echo 'Blog Archives';
                    } elseif (is_home()) {
                        echo 'Recent Posts';
                    }
                    ?>
                </h1>
            </header>
        </div>
    </div>
<section class="container post">
  <?php
  $colour = $multiloquent->multiloquent_get_random_blue_class();
    while (have_posts()) {
        the_post();
        $multiloquent->multiloquent_render_the_archive($colour);
    }
    ?>
</section>
<section class="container post">
 <?php
 require(locate_template('advert.php'));
 ?>
</section>
<div class="container post">
    <nav class="navitems text-center">
        <ul class="pagination">
            <li><?php previous_posts_link('Previous Entries'); ?></li>
            <li><?php next_posts_link('Next Entries'); ?></li>
        </ul>
    </nav>
</div>
    <?php
    } else {
    ?>
<div class="container post">
    <?php
    require(locate_template('error-snippet.php'));
    ?>
</div>
<?php
}
get_footer();
