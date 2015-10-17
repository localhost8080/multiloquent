<?php
/**
 * breadcrumb template part
 *
 * @package multiloquent\template_parts
 */

/**
 * the breadcrumb for pages
 */


?>
<nav class="container hidden-xs">
    <ul class="breadcrumb clearfix">
        <?php
        echo $multiloquent->multiloquent_breadcrumbs();
        require(locate_template('metadata.php'));
        ?>
    </ul>
</nav>
