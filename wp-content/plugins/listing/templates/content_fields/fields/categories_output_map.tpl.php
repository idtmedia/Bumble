<?php if (has_term('', ALSP_CATEGORIES_TAX, $listing->post->ID)): ?>
	<?php echo get_the_term_list($listing->post->ID, ALSP_CATEGORIES_TAX, '', ', ', ''); ?>
<?php endif; ?>