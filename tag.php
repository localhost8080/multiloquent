<?php
/**
 * template for tag archives
 */

/**
 * tag archive template part
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
                <h1 class="article_title">
                   <?php
                   echo 'Posts Tagged';
                   echo ' &#8216;';
                   single_tag_title();
                   echo '&#8217;';
                   ?>
               </h1>
               <p><?php echo 'There are '. $wp_query->found_posts.' posts tagged '. single_tag_title('', false);?></p>
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
