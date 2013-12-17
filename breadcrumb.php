<nav class="container hidden-xs">
    <ul class="breadcrumb clearfix">
		<?php
if (function_exists('breadcrumbs')) {
    breadcrumbs();
}
get_template_part('metadata');
?>
	</ul>
</nav>