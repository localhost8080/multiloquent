<?php
/**
 * category archives template part
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package multiloquent\template_parts
 */

/**
 * category archives template part
 */

get_header();
if (have_posts()) {
    ?>
    <div class="jumbotron">
        <div class="container-fluid">
            <header>
                <h1 class="article_title">
                    <?php printf('%s', single_cat_title('', false)); ?>
                </h1>

                <p>
                    <?php
                    printf(
                        __('There are %1$s posts in the %2$s category', 'multiloquent'),
                        $wp_query->found_posts,
                        single_cat_title('', false)
                    );
                    ?>
                </p>
                <div><?php echo category_description(); ?></div>
            </header>
        </div>
    </div>
    <section class="container-fluid post">
        <?php
        $colour = $multiloquent->multiloquent_get_random_blue_class();
        while (have_posts()) {
            the_post();
            $multiloquent->multiloquent_render_the_archive($colour);
        }
        ?>
    </section>
    <section class="container-fluid post">
        <?php
        get_template_part('advert');
        ?>
    </section>
    <div class="container-fluid post">
        <nav class="navitems text-center">
            <ul class="pagination">
                <li><?php previous_posts_link(__('Previous Entries', 'multiloquent')) ?></li>
                <li><?php next_posts_link(__('Next Entries', 'multiloquent')) ?></li>
            </ul>
        </nav>
    </div>
<?php } else { ?>
    <div class="container-fluid post">
        <?php
        get_template_part('error-snippet');
        ?>
    </div>
<?php
}
get_footer();
