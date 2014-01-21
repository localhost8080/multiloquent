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
			<?php
            _e('All entries by', 'multiloquent') . the_author();
            ?>
            </h1>
            <?php // TODO - look up the author specific details things to put them here, like avatars, etc?>
            <p><b>Author name:</b><?php the_author_meta( 'display_name' ); ?></p>
            <p><b>Author homepage:</b><?php the_author_link();?></p>
            <p><b>About:</b><?php the_author_meta( 'description' ); ?></p>            
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
