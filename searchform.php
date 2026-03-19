<?php

/**
 * search form.
 * wordpress template part
 *
 * @package multiloquent\template_parts
 */
?>
<form action="<?php echo esc_url(home_url('/')); ?>" class="search_form" method="get">
	<div class="flex">
		<input type="text" class="s" name="s" autocomplete="off" placeholder="Search"
			class="w-full rounded-l-md border border-[var(--color-border)] bg-[var(--color-base)] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]">
		<input type="hidden" value="the_search_text" name="action">
		<?php wp_nonce_field('search', 'search'); ?>
		<label title="search" for="s"
			class="flex items-center justify-center px-3 py-2 bg-[var(--color-primary)] text-white rounded-r-md hover:opacity-90 transition-colors cursor-pointer">
			<span class="fa fa-search fafw"></span>
		</label>
	</div>
</form>