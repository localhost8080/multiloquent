<nav role="navigation" class="navbar navbar-default navbar-fixed-top">
    	<div class="container">
	    	<div class="navbar-header">
	          <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" title="<?php bloginfo('name'); ?>" href="<?php echo home_url(); ?>/"><span class="fa fa-desktop fa-fw"></span><?php bloginfo('name'); ?></a>
	        </div>
	        <div class="navbar-collapse collapse">
		    	<ul class="nav navbar-nav navbar-right">
			        <li><a href="/category"><span class="fa fa-folder-o fa-fw"></span>categories</a></li>
					<?php /*<li><a href="/tags"><span class="fa fa-folder-o fa-fw"></span>tags</a></li>	*/?>
					<li><?php get_search_form();?></li> 
				</ul>  
	        </div> 
    	</div>
</nav>
