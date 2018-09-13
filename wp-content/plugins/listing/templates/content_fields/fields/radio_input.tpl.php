<?php if (count($content_field->selection_items)): ?>
<div class="alsp-field alsp-field-input-block alsp-field-input-block-<?php echo $content_field->id; ?>">
	<label class="alsp-control-label alsp-submit-field-title"><?php echo $content_field->name; ?><?php if ($content_field->canBeRequired() && $content_field->is_required): ?><span class="alsp-red-asterisk">*</span><?php endif; ?></label>
	<div class="col-md-12">
		<?php foreach ($content_field->selection_items AS $key=>$item): ?>
		<div class="alsp-radio">
			<label>
				<input type="radio" name="alsp-field-input-<?php echo $content_field->id; ?>" class="alsp-field-input-radio" value="<?php echo esc_attr($key); ?>" <?php checked($content_field->value, $key, true); ?> />
				<?php echo $item; ?>
			</label>
		</div>
		<?php endforeach; ?>
		<?php if ($content_field->description): ?><p class="description"><?php echo $content_field->description; ?></p><?php endif; ?>
	</div>
</div>
<?php endif; ?>