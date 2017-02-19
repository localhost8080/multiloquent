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
    <?php 
    get_template_part('advert');
    ?>
    <!-- google_ad_section_start-->
</div>
<article class="container">
    <h1>
        <?php
        printf(
            __('I dont have anything that matches (or nearly matches) that', 'multiloquent')
        );
        ?>
    </h1>

    <p>
        <?php
        printf(
            __('you might want to use the search or go to the <a title="%1$s" href="%2$s">homepage</a>', 'multiloquent'),
            get_bloginfo('name'),
            home_url()
        );
        ?>
    </p>
</article>
<div class="container">
    <!-- google_ad_section_end-->
    <?php 
    get_template_part('advert');
    ?>
</div>
