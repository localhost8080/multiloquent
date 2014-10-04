<?php
/**
 * the search form
 */

/**
 * search form.
 * wordpress template part
 *
 * @package multiloquent\template_parts
 */

?>
<form action="<?php echo esc_url(home_url('/')); ?>" id="search_form" class="mb" method="post">
	<div class="input-group">
		<input type="text" id="s" name="s" autocomplete="off" placeholder="Search" class="form-control">
		<input type="hidden" value="the_search_text" name="action">
		<span class="input-group-addon">
			<label title="search" for="s" class="" style="margin:0"><span class="fa fa-search fafw"></span></label>
		</span>
        <?php wp_nonce_field('search','search'); ?>
	</div>
</form>
