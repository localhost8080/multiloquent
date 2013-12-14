<nav>
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                <span class="icon-bar"></span> <span class="icon-bar"></span>
            </a>
            <ul class="nav">
                <li class="active"><a title="<?php bloginfo('name'); ?>" href="<?php echo home_url(); ?>/"><span
                        class="fa fa-desktop fa-fw"></span>
                        <h5 style="font-size: 17px; display: inline-block; margin: 0 0 0 15px; padding: 0;"><?php bloginfo('name'); ?></h5></a></li>
            </ul>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    Menu <span class="caret"></span>
                </button>
                <div class="dropdown-menu" role="menu">
  <?php wp_nav_menu( array('menu' => 'header' )); ?>
</div>
            </div>
            <ul class="nav nav-collapse collapse search-box">
                <li><?php get_search_form();?></li>
            </ul>
        </div>
    </div>
</nav>