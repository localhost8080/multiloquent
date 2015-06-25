<?php
/**
 * search result template part
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package multiloquent\template_parts
 */

/**
 * search results page
 */

if (empty( $_REQUEST['search'])  || ! wp_verify_nonce(wp_unslash(sanitize_text_field($_REQUEST['search'])), 'search' )) {
    // 404 ?
    get_header();
    echo '<div class="container post"> ';
    require(locate_template('error-snippet.php'));
    echo '</div>';
    get_footer();
    exit;
} else {
   // process form data
    require(locate_template('archive.php'));
}
