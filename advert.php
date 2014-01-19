<div class="ads">
<?php
if (multiloquent_is_mobile_device()) {
    if (is_active_sidebar(2)) {
        dynamic_sidebar(2);
    }
} else {
    if (is_active_sidebar(3)) {
        dynamic_sidebar(3);
    }
}
?>
</div>