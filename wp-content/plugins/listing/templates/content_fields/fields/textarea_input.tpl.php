<div class="alsp-field alsp-field-input-block alsp-field-input-block-<?php echo $content_field->id; ?>">
	<label class="alsp-control-label alsp-submit-field-title"><?php echo $content_field->name; ?><?php if ($content_field->canBeRequired() && $content_field->is_required): ?><span class="alsp-red-asterisk">*</span><?php endif; ?></label>
	<div class="textarea-field-wrap">
		<?php if ($content_field->html_editor): ?>
		<?php wp_editor($content_field->value, 'alsp-field-input-'.$content_field->id, array('media_buttons' => false, 'editor_class' => 'alsp-editor-class')); ?>
		<?php else: ?>
		<textarea name="alsp-field-input-<?php echo $content_field->id; ?>" class="alsp-field-input-textarea form-control" rows="5"><?php echo esc_textarea($content_field->value); ?></textarea>
		<?php endif; ?>
		<?php if ($content_field->description): ?><p class="description"><?php echo $content_field->description; ?></p><?php endif; ?>
	</div>
</div>