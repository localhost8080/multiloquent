<?php
/**
 * navigation template part
 *
 * @package multiloquent\template_parts
 */

/**
 * nav bar
 */

?>
<nav role="navigation" class="navbar fixed-top navbar-light bg-light">
    <div class="">
        <a title="navigation menu" href="javascript:void(0);" class="navbar-brand sidebar-toggle">
            <span class="fa fa-bars"></span>
        </a>
        <?php echo '<h2 class="navbar-brand"><a class="title_text" title="' . get_bloginfo('name') . '" href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a></h2>'; ?>
    </div>
</nav>
