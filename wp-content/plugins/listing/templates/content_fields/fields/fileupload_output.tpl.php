<?php if ($file): ?>
<div class="alsp-field alsp-field-output-block alsp-field-output-block-<?php echo $content_field->type; ?> alsp-field-output-block-<?php echo $content_field->id; ?>">
	<?php if ($content_field->icon_image || !$content_field->is_hide_name): ?>
	<span class="alsp-field-caption">
		<?php if ($content_field->icon_image): ?>
		<span class="alsp-field-icon alsp-fa alsp-fa-lg <?php echo $content_field->icon_image; ?>"></span>
		<?php endif; ?>
		<?php if (!$content_field->is_hide_name): ?>
		<span class="alsp-field-name"><?php echo $content_field->name?>:</span>
		<?php endif; ?>
	</span>
	<?php endif; ?>
	<span class="alsp-field-content">
		<a href="<?php echo esc_url(wp_get_attachment_url($file->ID)); ?>" target="_blank"><?php if ($content_field->value['text'] && $content_field->use_text) echo $content_field->value['text']; else echo basename(wp_get_attachment_url($file->ID)); ?></a>
	</span>
</div>
<?php endif; ?>