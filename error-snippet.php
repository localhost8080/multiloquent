<?php
/**
 * This is the error template part - it is included when no result is found from a search or archive page
 * @package multiloquent\template_parts
 */

/**
 * snippet used if no results found.
 * wordpress template part
 */

?>
<div class="container">
    <?php require(locate_template('advert.php'));?>
    <!-- google_ad_section_start-->
</div>
<article class="container">
	<h1>
	<?php 
	__('I dont have anything that matches (or nearly matches) that', 'multiloquent')
	?>
	</h1>
	<p>
	<?php 
	__('you might want to use the search or go to the', 'multiloquent');
	echo ' <a title="'. bloginfo('name').'" href="'. home_url().'/">';
	__('homepage', 'multiloquent');
	echo '</a></p>';
	?>
    </p>
</article>
<div class="container">
	<!-- google_ad_section_end-->
	<?php require(locate_template('advert.php'));?>
</div>
