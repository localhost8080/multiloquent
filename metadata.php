<li class="pull-right">
	<span class="author"><?php _e(' by ','jonathansblog'); ?>
		<span>
			<a rel="author" href="<?php echo home_url(); ?>/about"><?php the_author(); ?></a>
		</span>
	</span>
	<span class="divider">/</span>
	<span class="day <?php the_time(__('M','jonathansblog')); ?>">
		<span class="fa fa-calendar fa-fw"></span> <time datetime="<?php the_time('c');?>"><?php the_time(__('M jS, Y','jonathansblog')); ?></time>
		<?php if(get_the_time('c') != get_the_modified_time('c')){?>
			<span class="fa fa-refresh fa-fw"></span> <time datetime="<?php the_modified_time('c');?>"><?php the_modified_time(__('M jS, Y','jonathansblog')); ?></time>
		<?php }?>
	</span>
	<?php edit_post_link(); ?>
</li>
