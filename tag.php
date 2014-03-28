<?php
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
<div class="container post">
    <div class="featurette">
        <section class="row">
				<?php multiloquent_render_the_archive();?>
		</section>
        <section>
			<?php multiloquent_get_template_part('advert');?>
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
		<?php  multiloquent_get_template_part('error-snippet');?>
	</div>
</div>
<?php
}
wp_reset_query();
get_footer();
