<?php
/** 
 *  author pages template part.
 *  have an archive and a bio for the author
 */
get_header();
if (have_posts()) {
    ?>
<div class="jumbotron">
    <div class="container">
        <header>
            <h1 class="article_title">
             <p>
			<?php echo 'All entries by ' . get_the_author();?>
            </p>
            </h1>
            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"> 
            <?php echo get_avatar(get_the_author_meta('ID'));?>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                <p>
                    <b>Author name: </b><?php the_author_meta('display_name'); ?></p>
                <p>
                    <b>Author homepage: </b><?php the_author_link();?></p>
            <?php
    $description = get_the_author_meta('description');
    if (! empty($description)) {
        echo '<p>' . $description . '</p>';
    }
    ?>
            <p><?php echo 'There are '.$wp_query->found_posts.' posts by '. get_the_author();?></p>
            </div>
        </header>
    </div>
</div>
<section class="container post">
	<?php
    $colour = multiloquent_get_random_blue_class();
    while (have_posts()) {
        the_post();
        multiloquent_render_the_archive($colour);
    }
    ?>
</section>
<section class="container post">
	<?php get_template_part('advert');?>
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
		<?php  get_template_part('error-snippet');?>
</div>
<?php
}
get_footer();
