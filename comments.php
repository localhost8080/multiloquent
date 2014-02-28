<?php
/*
 * The comments page for Bones
 */
// Do not delete these lines
if (! empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
    die('Please do not load this page directly. Thanks!');
}
if (post_password_required()) {
    ?>
<div class="alert alert-info"><?php _e("This post is password protected. Enter the password to view comments.", "multiloquent"); ?></div>
<?php
    return;
}
?>
<!-- You can start editing here. -->
<?php
if (have_comments()) {
    if (! empty($comments_by_type['comment'])) {
        ?>
<h3 id="comments"><?php comments_number('<span>' . __("No", "multiloquent") . '</span> ' . __("Responses", "multiloquent") . '', '<span>' . __("One", "multiloquent") . '</span> ' . __("Response", "multiloquent") . '', '<span>%</span> ' . __("Responses", "multiloquent")) . _e("to", "multiloquent");  the_title(); ?>&#8221;</h3>
<nav id="comment-nav">
    <ul class="clearfix">
        <li><?php previous_comments_link(__("Older comments", "multiloquent")) ?></li>
        <li><?php next_comments_link(__("Newer comments", "multiloquent")) ?></li>
    </ul>
</nav>
<ol class="commentlist">
<?php wp_list_comments('type=comment&callback=multiloquent_bootstrap_comments'); ?>
</ol>
<?php
    }
    if (! empty($comments_by_type['pings'])) {
        ?>
<h3 id="pings">Trackbacks/Pingbacks</h3>
<ol class="pinglist">
<?php wp_list_comments('type=pings&callback=multiloquent_list_pings'); ?>
</ol>
<?php } ?>
<nav id="comment-nav">
    <ul class="clearfix">
        <li><?php previous_comments_link( __("Older comments", "multiloquent")) ?></li>
        <li><?php next_comments_link(__("Newer comments", "multiloquent")) ?></li>
    </ul>
</nav>
<?php
} else { // this is displayed if there are no comments so far
    if (comments_open()) {
        // do nothing
    } else { // comments are closed        ?>
<p class="alert alert-info"><?php _e("Comments are closed", "multiloquent"); ?>.</p>
<?php
    }
}
if (comments_open()) {
    comment_form();
}
        