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

if (empty($_REQUEST['search']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['search'])), 'search')) {
    // 404 ?
    get_header();
    echo '<div class="container-fluid post clearfix"> ';
    get_template_part('error-snippet');
    echo '</div>';
    get_footer();
    exit;
} else {
    // process form data
    require locate_template('archive.php');
}
