<div class="row alsp-field-search-block-<?php echo $search_field->content_field->id; ?> alsp-field-search-block-<?php echo $random_id; ?> alsp-field-search-block-<?php echo $search_field->content_field->id; ?>_<?php echo $random_id; ?>">
	<div class="col-md-12">
		<label><?php echo $search_field->content_field->name; ?> <?php echo $search_field->content_field->currency_symbol; ?></label>
	</div>
	<div class="col-md-12 form-group">
		<input type="text" name="field_<?php echo $search_field->content_field->slug; ?>" class="form-control" value="<?php echo esc_attr($search_field->value); ?>" />
	</div>
</div>