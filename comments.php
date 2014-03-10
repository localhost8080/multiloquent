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
        <h3><?php printf(_n('One Response to &ldquo;%2$s&rdquo;', '%1$s Responses to &ldquo;%2$s&rdquo;', get_comments_number(), 'multiloquent'), number_format_i18n(get_comments_number()), multiloquent_post_title()); ?></h3>
        <ol class="media-list">
          <?php wp_list_comments(); ?>
        </ol>
    
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
