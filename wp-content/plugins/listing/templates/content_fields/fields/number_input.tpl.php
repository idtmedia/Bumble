<div class="alsp-field alsp-field-input-block alsp-field-input-block-<?php echo $content_field->id; ?>">
	<label class="alsp-control-label alsp-submit-field-title"><?php echo $content_field->name; ?><?php if ($content_field->canBeRequired() && $content_field->is_required): ?><span class="alsp-red-asterisk">*</span><?php endif; ?></label>
	<div class="number-field-wrap">
		<input type="text" name="alsp-field-input-<?php echo $content_field->id; ?>" class="alsp-field-input-number form-control" value="<?php echo esc_attr($content_field->value); ?>" size="4" />
		<?php if ($content_field->description): ?><p class="description"><?php echo $content_field->description; ?></p><?php endif; ?>
	</div>
</div>