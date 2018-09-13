<?php if (count($search_field->min_max_options)): ?>
<?php if ($columns == 1) $col_md = 12; else $col_md = 6; ?>
<div class="row alsp-field-search-block-<?php echo $search_field->content_field->id; ?> alsp-field-search-block-<?php echo $random_id; ?> alsp-field-search-block-<?php echo $search_field->content_field->id; ?>_<?php echo $random_id; ?>">
	<div class="col-md-12">
		<label><?php echo $search_field->content_field->name; ?> <?php echo $search_field->content_field->currency_symbol; ?></label>
	</div>

	<div class="col-md-<?php echo $col_md; ?> form-group">
		<select name="field_<?php echo $search_field->content_field->slug; ?>_min" class="form-control">
		<option value=""><?php _e('- Select min -', 'ALSP'); ?></option>
		<?php foreach ($search_field->min_max_options AS $item): ?>
			<?php if (is_numeric($item)): ?>
			<option value="<?php echo $item; ?>" <?php selected($search_field->min_max_value['min'], $item); ?>><?php echo number_format($item, 2, $search_field->content_field->decimal_separator, $search_field->content_field->thousands_separator); ?></option>
			<?php endif; ?>
		<?php endforeach; ?>
		</select>
	</div>

	<div class="col-md-<?php echo $col_md; ?> form-group">
		<select name="field_<?php echo $search_field->content_field->slug; ?>_max" class="form-control">
		<option value=""><?php _e('- Select max -', 'ALSP'); ?></option>
		<?php foreach ($search_field->min_max_options AS $item): ?>
			<?php if (is_numeric($item)): ?>
			<option value="<?php echo $item; ?>" <?php selected($search_field->min_max_value['max'], $item); ?>><?php echo number_format($item, 2, $search_field->content_field->decimal_separator, $search_field->content_field->thousands_separator); ?></option>
			<?php endif; ?>
		<?php endforeach; ?>
		</select>
	</div>
</div>
<?php endif; ?>