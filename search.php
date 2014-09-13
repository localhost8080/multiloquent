<?php 
/**
 * search result template part
 * 
 * @package multiloquent\template_parts
 */

if (empty( $_POST['name_of_nonce_field'])  || ! wp_verify_nonce( $_POST['search'], 'search' ) ) {
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
