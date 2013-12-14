<div class="container footer">
    <div class="row">
		<?php
if (function_exists('dynamic_sidebar') && is_active_sidebar(4)) {
    echo '<div class="span6">';
    /* recent posts. */
    dynamic_sidebar(4);
    echo '</div>';
}
if (function_exists('dynamic_sidebar') && is_active_sidebar(5)) {
    echo '<div class="span6">';
    // this is my top ten posts
    dynamic_sidebar(5);
    echo '</div>';
}
?>
	
	</div>
</div>
<div class="container footer">
    <div class="row">	
		<?php
if (function_exists('dynamic_sidebar') && is_active_sidebar(6)) {
    echo '<div class="span6">';
    /* twitter */
    dynamic_sidebar(6);
    echo '</div>';
}
if (function_exists('dynamic_sidebar') && is_active_sidebar(7)) {
    echo '<div class="span6">';
    /* facebook */
    dynamic_sidebar(7);
    echo '</div>';
}
?>	
	</div>
</div>
<hr />
