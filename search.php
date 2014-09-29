<?php 
/**
 * search result template part
 * 
 * @package multiloquent\template_parts
 */

if (empty( $_REQUEST['search'])  || ! wp_verify_nonce( sanitize_text_field($_REQUEST['search']), 'search' ) ) {
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
