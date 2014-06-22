<?php 
/**
 * search form.
 * wordpress template part
 * 
 * @package multiloquent\template_parts
 */

?>
<form action="<?php echo esc_url(home_url('/')); ?>" id="search_form" class="mb">
    <div class="input-group">
        <input type="text" id="s" name="s" autocomplete="off" placeholder="Search" class="form-control"> 
        <input type="hidden" value="the_search_text" name="action">
        <span class="input-group-btn">
            <span class="btn btn-default"><label title="search" for="s" class="add-on">Go!</label></span>
        </span>
    </div>   
</form>
