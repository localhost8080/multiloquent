
<li class="pull-right">
<?php
echo '<span class="author">' . _e(' by ', 'multiloquent');
echo '<a rel="author" href="' . home_url() . '/about">' . the_author() . '</a>';
echo '</span>';
echo '<span class="divider">/</span><span class="day ' . the_time(__('M', 'multiloquent')) . '"> <span
        class="fa fa-calendar fa-fw"></span> <time datetime="' . the_time('c') . '">' .
     the_time(__('M jS, Y', 'multiloquent')) . '</time>';
if (get_the_time('c') != get_the_modified_time('c')) {
    echo '<span class="fa fa-refresh fa-fw"></span> <time datetime="' . the_modified_time('c') . '">' .
         the_modified_time(__('M jS, Y', 'multiloquent')) . '</time>';
}
echo '</span>';
edit_post_link();
?>
</li>
