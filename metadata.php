<li class="pull-right">
<?php
echo '<span class="author">' . _e(' by ', 'multiloquent');
the_author_posts_link();
echo '</span>';
echo '<span class="day ' . get_the_time(__('M', 'multiloquent')) . '"> <span
        class="fa fa-calendar fa-fw"></span> <time datetime="' . get_the_time('c') . '">' . get_the_time(__('M jS, Y', 'multiloquent')) . '</time>';
if (get_the_time('c') != get_the_modified_time('c')) {
    echo '<span class="fa fa-refresh fa-fw"></span> <time datetime="' . get_the_modified_time('c') . '">' . get_the_modified_time(__('M jS, Y', 'multiloquent')) . '</time>';
}
echo '</span> ';
edit_post_link();
?>
</li>