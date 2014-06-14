<?php 
/**
 * search form.
 * wordpress template part
 */

?>
<form action="<?php echo esc_url(home_url('/')); ?>" id="search_form" class="mb">
    <div class="input-prepend">
        <label title="search" for="s" class="add-on"><span class="fa fa-search fafw"></span></label> <input type="text" id="s" name="s" autocomplete="off" placeholder="Search"> <input type="hidden" value="the_search_text" name="action">
    </div>
</form>
