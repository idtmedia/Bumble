<?php if (has_term('', ALSP_TAGS_TAX, $listing->post->ID)): ?>
	<?php echo get_the_term_list($listing->post->ID, ALSP_TAGS_TAX, '', ', ', ''); ?>
<?php endif; ?>