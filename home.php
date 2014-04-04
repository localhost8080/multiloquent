<?php
// this is the template for the home page when its set to display blog posts
if (have_posts()) {
    ?>
<p class="lead text-center">Recent Posts</p>
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
            <ul class="pagination pagination-centered">
                <li><?php previous_posts_link('Previous Entries') ?></li>
                <li><?php next_posts_link('Next Entries') ?></li>
            </ul>
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

