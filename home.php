<?php
/**
 * homepage when set to display blog posts on homepage
 */

/**
 * this is the template for the home page when its set to display blog posts
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package multiloquent\template_parts
 */

get_header();
if (have_posts()) {
    ?>
    <div class="jumbotron">
        <div class="container">
            <header>
                <h1 class="article_title">Featured Posts</h1>
            </header>
        </div>
    </div>
    <?php
    echo $multiloquent->multiloquent_paralax_slider();
    ?>
    <p class="lead text-center">Recent Posts</p>
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
   <?php require(locate_template('advert.php'));?>
</section>
<div class="container post">
    <nav class="navitems text-center">
        <ul class="pagination">
            <li><?php previous_posts_link('Previous Entries') ?></li>
            <li><?php next_posts_link('Next Entries') ?></li>
        </ul>
    </nav>
</div>
<?php } else { ?>
<div class="container post">
  <?php  require(locate_template('error-snippet.php'));?>
</div>
<?php
}
get_footer();
