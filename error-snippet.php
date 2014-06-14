<?php 
/**
 * snippet used if no results found template part
 */

?><div class="container">
		<?php get_template_part('advert');?>
		<!-- google_ad_section_start-->
</div>
<article class="container">
    <h1>I dont have anything that matches (or nearly matches) that</h1>
        <?php echo '<p>you might want to use the search or go to the <a title="'. bloginfo('name').'" href="'. home_url().'/">homepage</a></p>';?>
</article>
<div class="container">
    <!-- google_ad_section_end-->
		<?php get_template_part('advert');?>
</div>
