<?php
/**
 * generate the metadata snippet.
 * used in the breadcrumbs
 *
 * @package multiloquent\template_parts
 */

/**
 * generate metadata for posts
 */

echo '<li class="">';
echo '<span itemprop="author" class="author">';
// check to see if the user has a url set in their meta data; if they have then use it as the rel=author link
$user_url = get_the_author_meta( 'user_url' );
if ( ! empty( $user_url ) ) {
	echo '<a href="' . $user_url . '" rel="author">';
	printf(
		esc_html__( 'by %s', 'multiloquent' ),
		get_the_author()
	);
	echo '</a>';
} else {
	printf(
		esc_html__( 'by %s', 'multiloquent' ),
		the_author_posts_link()
	);
}
echo '</span>';
echo '<span class="day ' . get_the_time( 'M' ) . '"> <span class="fa fa-calendar fa-fw"></span> <time itemprop="datePublished" datetime="' . get_the_time( 'c' ) . '">' . get_the_time( 'M jS, Y' ) . '</time>';
if ( get_the_time( 'c' ) != get_the_modified_time( 'c' ) ) {
	echo '<span class="fa fa-refresh fa-fw"></span> <time itemprop="dateModified" datetime="' . get_the_modified_time( 'c' ) . '">' . get_the_modified_time( 'M jS, Y' ) . '</time>';
}
echo '</span> ';
edit_post_link();
echo '</li>';
