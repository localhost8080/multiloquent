<div class="container footer">
    <div class="row">
		<?php if ( function_exists('dynamic_sidebar') && is_active_sidebar(4) ) { ?>
			<div class="span6">
				<?php
    /* recent posts. */
    if (! function_exists('dynamic_sidebar') || ! dynamic_sidebar(4)) {}
    ?>
			</div>
		<?php
}
if (function_exists('dynamic_sidebar') && is_active_sidebar(5)) {
    ?>
			<div class="span6">	
			<?php
    // this is my top ten posts
    if (! function_exists('dynamic_sidebar') || ! dynamic_sidebar(5)) {}
    ?>
			</div>
		<?php }?>
	
	</div>
</div>
<div class="container footer">
    <div class="row">	
		<?php if ( function_exists('dynamic_sidebar') && is_active_sidebar(6) ) { ?>
			<div class="span6">
				<?php
    /* twitter */
    if (! function_exists('dynamic_sidebar') || ! dynamic_sidebar(6)) {}
    ?>
			</div>
			<?php }?>
			<?php if ( function_exists('dynamic_sidebar') && is_active_sidebar(7) ) { ?>
			<div class="span6">
				<?php
    /* facebook */
    if (! function_exists('dynamic_sidebar') || ! dynamic_sidebar(7)) {}
    ?>
			</div>
		<?php }?>	
	</div>
</div>
<hr />
