<?php global $ALSP_ADIMN_SETTINGS; ?>
<?php $gap_in_fields = $ALSP_ADIMN_SETTINGS['gap_in_fields']; ?>
<div class="row alsp-field-search-block-<?php echo $search_field->content_field->id; ?> alsp-field-search-block-<?php echo $random_id; ?> alsp-field-search-block-<?php echo $search_field->content_field->id; ?>_<?php echo $random_id; ?> pull-left" style=" width:<?php echo $search_field->content_field->fieldwidth; ?>%; padding:<?php echo $gap_in_fields; ?>px;">
	<div class="col-md-12">
		<label><?php echo $search_field->content_field->name; ?></label>
	</div>
	<div class="col-md-12 form-group">
		<input type="text" class="form-control" name="field_<?php echo $search_field->content_field->slug; ?>" value="<?php echo esc_attr($search_field->value); ?>" />
	</div>
</div>