<?php
/**
 * Comment form
 * this is a direct lift of the comments from shoestrap;
 * I personally use disqus for my comments, but this comment system was already done :D
 * http://shoestrap.org/
 * @package multiloquent\template_parts
 */

/**
 * Comment template part.
 */
if (post_password_required()) {
    return;
}
if (have_comments()) {
    ?>
    <section itemprop="comment" id="comments">
        <div>
            <h3>
            <?php
printf(
        esc_html_e('%1$s comments', 'multiloquent'),
        number_format_i18n(get_comments_number())
    );
    ?>
            </h3>
            <ol class="comment-list">
                <?php wp_list_comments();?>
            </ol>

            <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) {?>
                <nav>
                    <ul class="pager">
                        <?php if (get_previous_comments_link()) {?>
                            <li class="previous"><?php previous_comments_link(esc_html_e('&larr; Older comments', 'multiloquent'));?></li>
                        <?php
}
        if (get_next_comments_link()) {
            ?>
                            <li class="next"><?php next_comments_link(esc_html_e('Newer comments &rarr;', 'multiloquent'));?></li>
                        <?php
}
        ?>
                    </ul>
                </nav>
            <?php
}
    if ( ! comments_open() && ! is_page() && post_type_supports(get_post_type(), 'comments')) {
        ?>
                <div class="alert alert-block fade in">
                    <a class="close" data-dismiss="alert">&times;</a>

                    <p>
                        <?php
printf(
            esc_html_e('Comments are closed.', 'multiloquent')
        );
        ?>
                    </p>
                </div>
            <?php
}
    ?>
        </div>
    </section>
<?php
}
if ( ! have_comments() && ! comments_open() && ! is_page() && post_type_supports(get_post_type(), 'comments')) {
    ?>
    <section id="comments">
        <div class="alert alert-block fade in">
            <a class="close" data-dismiss="alert">&times;</a>

            <p>
                <?php
printf(
        esc_html_e('Comments are closed.', 'multiloquent')
    );
    ?>
            </p>
        </div>
    </section>
<?php
}
if (comments_open()) {
    ?>
    <section>
        <div>
            <p class="cancel-comment-reply"><?php cancel_comment_reply_link();?></p>
            <?php if (get_option('comment_registration') && ! is_user_logged_in()) {?>
                <p>
                    <?php
printf(
        esc_html_e('You must be <a href="%s">logged in</a> to post a comment.', 'multiloquent'),
        wp_login_url(get_permalink()));
        ?>
                </p>
            <?php
} else {
        $comments_args = array(
            'comment_field' => '<p class="comment-form-comment"><label for="comment">Comment</label><br /><textarea class="form-control" id="comment" name="comment" aria-required="true"></textarea></p>',
            'class_form' => '',
            'class_submit' => 'btn btn-success',
        );
        comment_form($comments_args);
    }
    ?>
        </div>
    </section>
<?php
}
