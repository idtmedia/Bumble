<?php if (array_filter($content_field->value)): ?>
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
	<?php if ($strings = $content_field->processStrings()): ?>
	<div class="alsp-field-content alsp-hours-field">
		<?php foreach ($strings AS $string): ?>
		<div><?php echo $string; ?></div>
		<?php endforeach; ?>
		<div class="clear_float"></div>
	</div>
	<?php endif; ?>
</div>
<?php endif; ?>