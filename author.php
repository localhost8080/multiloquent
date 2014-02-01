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
			<?php _e('All entries by ', 'multiloquent') . the_author();?>
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
            <p><?php echo 'There are '.$wp_query->found_posts.' posts by '. the_author();?></p>
            </div>
        </header>
    </div>
</div>
<?php  	$post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<div class="container post">
    <div class="featurette">
        <section class="row">
				<?php multiloquent_render_the_archive();?>
		</section>
        <section>
			<?php get_template_part('advert');?>
		</section>
        <nav class="navitems article white2">
            <div class="pagination pagination-centered">
				<?php multiloquent_render_pagingation(); ?>
			</div>
        </nav>
    </div>
</div>
<?php } else { ?>
<div class="container post">
    <div class="featurette">
		<?php  get_template_part('error_snippet');?>
	</div>
</div>
<?php
}
wp_reset_query();
get_footer();
