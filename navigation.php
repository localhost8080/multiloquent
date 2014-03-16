<nav role="navigation" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
            </button>
            <a href="javascript:void(0);" onclick="jQuery('.sidebar').toggle();" class="navbar-brand"><span class="fa fa-bars"></span></a>
            <?php echo '<a class="navbar-brand" title="'. get_bloginfo('name').'" href="'. esc_url(home_url('/')) .'"><span class="fa fa-desktop fa-fw"></span>'. get_bloginfo('name').'</a>';?>
        
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><?php get_search_form();?></li>
            </ul>
            <?php
            if (is_active_sidebar(1)) {
                echo '<div class="restricted-height-sidebar">';
                dynamic_sidebar(1);
                echo '</div>';
            }
            ?>
            
        </div>
    </div>
</nav>
