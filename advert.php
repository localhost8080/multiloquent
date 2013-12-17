<div class="ads">
<?php
if (is_mobile_device()) {
    if (function_exists('dynamic_sidebar') && is_active_sidebar(2)) {
        dynamic_sidebar(2);
    }
} else {
    if (function_exists('dynamic_sidebar') && is_active_sidebar(3)) {
        dynamic_sidebar(3);
    }
}
?>
</div>