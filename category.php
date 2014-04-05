<?php
get_header();
if (have_posts()) {
    ?>
<div class="jumbotron">
    <div class="container">
        <header>
            <h1 class="article_title">
			<?php printf('%s', single_cat_title('', false)); ?>
            </h1>
            <p><?php echo 'There are '.$wp_query->found_posts.' posts in the '. single_cat_title('', false).' category';?></p>
        </header>
    </div>
</div>
<div class="container post">
    <section>
		<?php
    $colour = multiloquent_get_random_blue_class();
    while (have_posts()) {
        the_post();
        multiloquent_render_the_archive($colour);
    }
    ?>
		</section>
    <section>
			<?php get_template_part('advert');?>
		</section>
</div>
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
