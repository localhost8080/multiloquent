<?php
// author pages
// have an archive and a bio for the author
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
            <?php // TODO - look up the author specific details things to put them here, like avatars, etc?>
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
<div class="container post">
    <div class="featurette">
        <section class="row">
						<?php
    $colour = multiloquent_get_random_blue_class();
    while (have_posts()) {
        the_post();
        multiloquent_render_the_archive($post, $colour);
    }
    ?>
		</section>
        <section>
			<?php get_template_part('advert');?>
		</section>
        <nav class="navitems article white2">
            <nav class="navitems article white2">
                <ul class="pagination pagination-centered">
                    <li><?php previous_posts_link('Previous Entries') ?></li>
                    <li><?php next_posts_link('Next Entries') ?></li>
                </ul>
            </nav>
        </nav>
    </div>
</div>
<?php } else { ?>
<div class="container post">
    <div class="featurette">
		<?php  get_template_part('error-snippet');?>
	</div>
</div>
<?php
}
get_footer();
