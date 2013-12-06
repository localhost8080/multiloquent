<?php get_template_part('navigation'); ?>
<section class="well">
	<div class="container">
		<div class="row">
			<div class="span6">
				<h3>Useful Stuff</h3>
				<ul class="nav nav-pills nav-stacked">
					<?php
						global $user_ID;
						if ($user_ID && current_user_can ( 'update_core' )) {?>
							<li><a href="/wp-admin"><span class="fa fa-user fa-fw"></span> Dashboard</a></li>
						<?php }else{ ?>
							<li><a href="/wp-login.php"><span class="fa fa-lock fa-fw"></span> Login</a></li>
						<?php } ?>
					<li><a href="/about"><span class="fa fa-clock-o fa-fw"></span> &#169; 2008 - <?php echo date('Y'); ?></a></li>
					<li><a href="/about"><span class="fa fa-folder-open-o fa-fw"></span> Jonathansblog html5 theme <?php echo version();?></a></li>
					<li><a href="/about"><span class="fa fa-gamepad fa-fw"></span><span style="font-size:12px;">This website is most definitely not best viewed in Netscape</span></a></li>
				</ul>
			</div>
			<div class="span6">
				<h3>More Useful Stuff</h3>
				<?php wp_nav_menu( array('menu' => 'footer' )); ?>
			</div>
		</div>
	</div>	
</section>
<?php get_template_part('js_load'); ?>
<?php if (function_exists('tptn_add_viewed_count')){
	echo tptn_add_viewed_count(' ');
	
}?>
<?php wp_footer(); ?>
</body>
</html>
