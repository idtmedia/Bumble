<?php if (count($content_field->selection_items)): ?>
<div class="form-group alsp-field alsp-field-input-block alsp-field-input-block-<?php echo $content_field->id; ?> alsp-field-input-block-<?php echo $content_field->type; ?>">
	<label class="alsp-control-label alsp-submit-field-title"><?php echo $content_field->name; ?><?php if ($content_field->canBeRequired() && $content_field->is_required): ?><span class="alsp-red-asterisk">*</span><?php endif; ?></label>
	<div class="checkbox-wrap">
		<?php foreach ($content_field->selection_items AS $key=>$item): ?>
		<div class="checkbox">
			<label>
				<input type="checkbox" name="alsp-field-input-<?php echo $content_field->id; ?>[]" class="alsp-field-input-checkbox" value="<?php echo esc_attr($key); ?>" <?php if (in_array($key, $content_field->value)) echo 'checked'; ?> />
				<?php echo $item; ?>
				<span class="radio-check-item"></span>
			</label>
		</div>
		<?php endforeach; ?>
		<?php if ($content_field->description): ?><p class="description"><?php echo $content_field->description; ?></p><?php endif; ?>
	</div>
</div>
<?php endif; ?>