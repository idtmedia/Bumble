<div class="alsp-field alsp-field-input-block alsp-field-input-block-<?php echo $content_field->id; ?>">
	
	<div class="website-input-wrap">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<label class="alsp-control-label web-input-lable alsp-submit-field-title"><?php echo $content_field->name; ?><?php if ($content_field->canBeRequired() && $content_field->is_required): ?><span class="alsp-red-asterisk">*</span><?php endif; ?></label>
				<label><?php _e('URL:', 'ALSP'); ?></label>
				<input type="text" name="alsp-field-input-url_<?php echo $content_field->id; ?>" class="alsp-field-input-url form-control regular-text" value="<?php echo esc_url($content_field->value['url']); ?>" />
			</div>
			<?php if ($content_field->use_link_text): ?>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<label><?php _e('Link text:', 'ALSP'); ?></label>
				<input type="text" name="alsp-field-input-text_<?php echo $content_field->id; ?>" class="alsp-field-input-text form-control regular-text" value="<?php echo esc_attr($content_field->value['text']); ?>" />
			</div>
			<?php endif; ?>
		</div>
		<?php if ($content_field->description): ?><p class="description"><?php echo $content_field->description; ?></p><?php endif; ?>
	</div>
</div>