<?php if(is_mobile_device()){?>
<div class="row">
	<div class="ads">
			<?php 
/* Widgetized sidebar, if you have the plugin installed. */
    if (! function_exists('dynamic_sidebar') || ! dynamic_sidebar(2)) {}
    ?>
		</div>
</div>
<?php }else{?>
<div class="row">
	<div class="ads">
			<?php 
/* Widgetized sidebar, if you have the plugin installed. */
    if (! function_exists('dynamic_sidebar') || ! dynamic_sidebar(3)) {}
    ?>
		</div>
</div>
<?php }?>