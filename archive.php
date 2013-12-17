<?php
get_header();
is_tag();
if (have_posts()) {
    ?>
<div class="jumbotron">
    <div class="container">
        <header>
            <h1 class="article_title">
			<?php
    if (is_category()) {
        printf(__('%s', 'jonathansblog'), single_cat_title('', false));
    } elseif (is_tag()) {
        _e('Posts Tagged', 'jonathansblog');
        echo '&#8216;';
        single_tag_title();
        echo '&#8217;';
    } elseif (is_day()) {
        printf(__('Archive for %s', 'jonathansblog'), get_the_time(__('F jS, Y', 'jonathansblog')));
    } elseif (is_month()) {
        printf(__('Archive for %s', 'jonathansblog'), get_the_time(__('F Y', 'jonathansblog')));
    } elseif (is_year()) {
        printf(__('Archive for %s', 'jonathansblog'), get_the_time('Y'));
    } elseif (is_search()) {
        __('Search Results', 'jonathansblog');
    } elseif (is_author()) {
        _e('All entries by this author', 'jonathansblog');
    } elseif (isset($_GET['paged']) && ! empty($_GET['paged'])) {
        _e('Blog Archives', 'jonathansblog');
    }
    ?>
            </h1>
        </header>
    </div>
</div>
<?php  	$post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<div class="container post">
    <div class="featurette">
        <section class="row">
				<?php render_the_archive();?>
		</section>
        <section>
			<?php get_template_part('advert');?>
		</section>
        <nav class="navitems article white2">
            <div class="pagination pagination-centered">
				<?php render_pagingation(); ?>
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
