<?php
// this is a direct lift of the comments from shoestrap; I personally use disqus for my comments, but this comment
// system was already done :D
// http://shoestrap.org/
if (post_password_required()) {
    return;
}
if (have_comments()) {
    ?>
<section id="comments">
    <div>
        <h3><?php printf(_n('One comment', '%1$s comments', get_comments_number(), 'multiloquent'), number_format_i18n(get_comments_number())); ?></h3>
        <div class="media-list">
          <?php
    $comments = get_comments(array(
        'status' => 'approve',
        'post_id' => get_the_ID()
    ));
    foreach ($comments as $k => $c) {
        // now we can make out comments properly
        // wow, disqus has a lot of markup :|
        ?>
<div class="post-content">
                <div class="avatar">
                    <div class="user">
<?php echo get_avatar($c->comment_author_email, '64');?>
</div>
                </div>
                <div class="post-body">
                    <header>
                        <span class="post-byline"> <span class="author publisher-anchor-color"><?php echo $c->comment_author;?></span>
                        </span> <span class="post-meta"> <span class="time-ago"><?php echo $c->comment_date;?></span>
                        </span>
                    </header>
                    <div class="post-body-inner">
                        <div class="post-message-container">
                            <div class="publisher-anchor-color">
                                <div class="post-message">

<?php echo  $c->comment_content; ?>

</div>
                            </div>
                        </div>
                    </div>
                    <footer>
                       
                            <span> <i class="icon icon-mobile icon-reply"></i><span class="text">Reply</span></span>
                       
                    </footer>
                </div>
            </div>
            
<?php
    }
    ?>
        </div>
    
        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) { ?>
        <nav>
            <ul class="pager">
            <?php if (get_previous_comments_link()) { ?>
              <li class="previous"><?php previous_comments_link('&larr; Older comments'); ?></li>
            <?php
        }
        if (get_next_comments_link()) {
            ?>
              <li class="next"><?php next_comments_link('Newer comments &rarr;'); ?></li>
            <?php
        }
        ?>
          </ul>
        </nav>
        <?php
    }
    if (! comments_open() && ! is_page() && post_type_supports(get_post_type(), 'comments')) {
        ?>
        <div class="alert alert-block fade in">
            <a class="close" data-dismiss="alert">&times;</a>
            <p><?php echo 'Comments are closed.'; ?></p>
        </div>
        <?php
    }
    ?>
      </div>
</section>
<?php
}
if (! have_comments() && ! comments_open() && ! is_page() && post_type_supports(get_post_type(), 'comments')) {
    ?>
<section id="comments">
    <div class="alert alert-block fade in">
        <a class="close" data-dismiss="alert">&times;</a>
        <p><?php echo 'Comments are closed.'; ?></p>
    </div>
</section>
<?php
}
if (comments_open()) {
    ?>
<section>
    <div>
        <p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p>
    <?php if (get_option('comment_registration') && !is_user_logged_in()) { ?>
      <p><?php printf('You must be <a href="%s">logged in</a> to post a comment.', wp_login_url(get_permalink())); ?></p>
    <?php
    } else {
        comment_form();
    }
    ?>
  </div>
</section>
<?php
}
