<div class="alsp-form-group alsp-field alsp-field-input-block alsp-field-input-block-<?php echo $content_field->id; ?>">
	<label class="alsp-control-label alsp-submit-field-title"><?php echo $content_field->name; ?><?php if ($content_field->canBeRequired() && $content_field->is_required): ?><span class="alsp-red-asterisk">*</span><?php endif; ?></label>
	<div class="file-upload-field-wrap">
		<div class="row">
			<?php if ($file): ?>
			<div class="col-md-6">
				<label><?php _e('Uploaded file:', 'ALSP'); ?></label>
				<a href="<?php echo esc_url($file->guid); ?>" target="_blank"><?php echo basename($file->guid); ?></a>
				<input type="hidden" name="alsp-uploaded-file-<?php echo $content_field->id; ?>" value="<?php echo $file->ID; ?>" />
				<br />
				<label><input type="checkbox" name="alsp-reset-file-<?php echo $content_field->id; ?>" value="1" /> <?php _e('reset uploaded file', 'ALSP'); ?></label>
			</div>
			<?php endif; ?>
			<div class="col-md-6">
				<label><?php _e('Select file to upload:', 'ALSP'); ?></label>
				<input type="file" name="alsp-field-input-<?php echo $content_field->id; ?>" class="alsp-field-input-fileupload" />
			</div>
			<?php if ($content_field->use_text): ?>
			<div class="col-md-12">
				<label><?php _e('File title:', 'ALSP'); ?></label>
				<input type="text" name="alsp-field-input-text-<?php echo $content_field->id; ?>" class="alsp-field-input-text alsp-form-control regular-text" value="<?php echo esc_attr($content_field->value['text']); ?>" />
			</div>
			<?php endif; ?>
		</div>
		<?php if ($content_field->description): ?><p class="description"><?php echo $content_field->description; ?></p><?php endif; ?>
	</div>
</div>