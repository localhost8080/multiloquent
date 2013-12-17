
	<div class="row">
		<?php if ( function_exists('dynamic_sidebar') && is_active_sidebar(4) ) { ?>
			<div class="col-sm-6 col-md-6 col-lg-6 no-bullets">
				<?php
				/* recent posts. */
				if (!function_exists('dynamic_sidebar')||!dynamic_sidebar(4)){}
				?>
			</div>
		<?php }
		if (function_exists('dynamic_sidebar')&&is_active_sidebar(5)){
			?>
			<div class="col-sm-6 col-md-6 col-lg-6 no-bullets">	
			<?php
				// this is my top ten posts
				if (!function_exists('dynamic_sidebar')||!dynamic_sidebar(5)){}
				?>
			</div>
		<?php }?>
	
	</div>

	<div class="row">	
		<?php if ( function_exists('dynamic_sidebar') && is_active_sidebar(6) ) { ?>
			<div class="col-sm-6 col-md-6 col-lg-6 no-bullets">
				<?php
				/* twitter */
				if (!function_exists('dynamic_sidebar')||!dynamic_sidebar(6)){}
				?>
			</div>
			<?php }?>
			<?php if ( function_exists('dynamic_sidebar') && is_active_sidebar(7) ) { ?>
			<div class="col-sm-6 col-md-6 col-lg-6 no-bullets">
				<?php
				/* facebook */
				if (!function_exists('dynamic_sidebar')||!dynamic_sidebar(7)){}
				?>
			</div>
		<?php }?>	
	</div>
<hr />
