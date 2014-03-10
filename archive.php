<?php
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
<?php  	$post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<div class="container post">
    <div class="featurette">
        <section class="row">
				<?php multiloquent_render_the_archive();?>
		</section>
        <section>
			<?php multiloquent_get_template_part('advert');?>
		</section>
        <nav class="navitems article white2">
            <div class="pagination pagination-centered">
				<?php posts_nav_link(); ?>
			</div>
        </nav>
    </div>
</div>
<?php } else { ?>
<div class="container post">
    <div class="featurette">
		<?php  multiloquent_get_template_part('error-snippet');?>
	</div>
</div>
<?php
}
wp_reset_query();
get_footer();
