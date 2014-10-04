<?php
/**
 * This is the error template part - it is included when no result is found from a search or archive page
 * @package multiloquent\template_parts
 */

/**
 * snippet used if no results found.
 * wordpress template part
 *
 * @package multiloquent\template_parts
 */

?>
<div class="container">
<?php require(locate_template('advert.php'));?>
<!-- google_ad_section_start-->
</div>
<article class="container">
	<h1>I dont have anything that matches (or nearly matches) that</h1>
	<?php echo '<p>you might want to use the search or go to the <a title="'. bloginfo('name').'" href="'. home_url().'/">homepage</a></p>';?>
</article>
<div class="container">
	<!-- google_ad_section_end-->
	<?php require(locate_template('advert.php'));?>
</div>
