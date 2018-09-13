<?php if (has_term('', ALSP_TAGS_TAX, $listing->post->ID)): ?>
<div class="alsp-field alsp-field-output-block alsp-field-output-block-<?php echo $content_field->type; ?> alsp-field-output-block-<?php echo $content_field->id; ?>">
	<?php if ($content_field->icon_image || !$content_field->is_hide_name): ?>
	<span class="alsp-field-caption">
		<?php if ($content_field->icon_image): ?>
		<span class="alsp-field-icon fa fa-lg <?php echo $content_field->icon_image; ?>"></span>
		<?php endif; ?>
		<?php if (!$content_field->is_hide_name): ?>
		<span class="alsp-field-name"><?php echo $content_field->name?>:</span>
		<?php endif; ?>
	</span>
	<?php endif; ?>
	<span class="alsp-field-content">
	<?php //echo get_the_term_list($listing->post->ID, ALSP_TAGS_TAX, '', ', ', ''); ?>
		<?php
		$terms = get_the_terms($listing->post->ID, ALSP_TAGS_TAX);
		foreach ($terms as $term): ?>
			<span class="alsp-label alsp-label-primary"><a href="<?php echo get_term_link($term, ALSP_TAGS_TAX); ?>" rel="tag"><?php echo $term->name; ?></a>&nbsp;&nbsp;<span class="glyphicon glyphicon-tag"></span></span>
		<?php endforeach; ?>
	</span>
</div>
<?php endif; ?>