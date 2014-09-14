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
    get_template_part('error-snippet');
    echo '</div>';
    get_footer();
    exit;
} else {
   // process form data
    get_template_part('archive');
}
