<?php
echo '<li class="pull-right author">' . _e(' by ', 'multiloquent') . '<a rel="author" href="' . home_url() . '/about">' . get_the_author() . '</a></li>';
echo '<li class="day pull-right ' . the_time(__('M', 'multiloquent')) . '"><span class="fa fa-calendar fa-fw"></span> <time datetime="' . the_time('c') . '">' . the_time(__('M jS, Y', 'multiloquent')) . '</time>';
if (get_the_time('c') != get_the_modified_time('c')) {
    echo '<span class="fa fa-refresh fa-fw"></span> <time datetime="' . the_modified_time('c') . '">' . the_modified_time(__('M jS, Y', 'multiloquent')) . '</time>';
}
echo '</li>';
echo '<li class="pull-right">' . edit_post_link() . '</li>';
