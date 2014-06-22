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
    <span class="input-group-addon">
            <label title="search" for="s" class="" style="margin:0"><span class="fa fa-search fafw"></span></label>
        </span>
        <input type="text" id="s" name="s" autocomplete="off" placeholder="Search" class="form-control"> 
        <input type="hidden" value="the_search_text" name="action">
        
    </div>   
</form>
