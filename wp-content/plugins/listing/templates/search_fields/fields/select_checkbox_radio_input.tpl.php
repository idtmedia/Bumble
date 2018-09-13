<?php global $ALSP_ADIMN_SETTINGS; ?>
<?php if (count($search_field->content_field->selection_items)): ?>
<?php $gap_in_fields = $ALSP_ADIMN_SETTINGS['gap_in_fields']; ?>
<?php  if ($columns == 1) $col_md = 6; else $col_md = 4; ?>
<div class="cz-checkboxes search-element-col alsp-field-search-block-<?php echo $search_field->content_field->id; ?> alsp-field-search-block-<?php echo $random_id; ?> alsp-field-search-block-<?php echo $search_field->content_field->id; ?>_<?php echo $random_id; ?> pull-left clearfix" style=" width:<?php echo $search_field->content_field->fieldwidth; ?>%; padding:0 <?php echo $gap_in_fields; ?>px;">
	<div class="search-content-filed-label">
		<label><?php echo $search_field->content_field->name; ?></label>
	</div>
	<?php
	if ($search_field->search_input_mode == 'checkboxes' || $search_field->search_input_mode =='radiobutton'):
		$i = 1;
		while ($i <= ($columns+1)): ?>
		
			
			<?php $j = 1; ?>
			<?php foreach ($search_field->content_field->selection_items AS $key=>$item): ?>
			<?php if ($i == $j): ?>
			<div class="<?php if ($search_field->search_input_mode =='checkboxes'): ?>checkbox<?php elseif ($search_field->search_input_mode =='radiobutton'): ?>alsp-radio<?php endif; ?> ">
				<label> 
					<?php if ($search_field->search_input_mode =='checkboxes'): ?>
					<input type="checkbox" name="field_<?php echo $search_field->content_field->slug; ?>[]" value="<?php echo esc_attr($key); ?>" <?php if (in_array($key, $search_field->value)) echo 'checked'; ?> class="selectpicker" />
					<?php elseif ($search_field->search_input_mode =='radiobutton'): ?>
					<input type="radio" name="field_<?php echo $search_field->content_field->slug; ?>" value="<?php echo esc_attr($key); ?>" <?php if (in_array($key, $search_field->value)) echo 'checked'; ?> />
					<?php endif; ?>
					<?php echo '<span class="radio-check-item">'. $item.'</span>'; ?>
				</label>
			</div>
			<?php endif; ?>
			<?php $j++; ?>
			<?php if ($j > ($columns+1)) $j = 1; ?>
			<?php endforeach; ?>
		
		<?php $i++; ?>
		<?php endwhile; ?>
	<?php elseif ($search_field->search_input_mode == 'selectbox'): ?>
	
		
		<select name="field_<?php echo $search_field->content_field->slug; ?>" class=" cs-select cs-skin-elastic pacz-select2" style="width: 100%;">
			<option value="" <?php if (!$search_field->value) echo 'disabled selected'; ?>><?php printf(__('- Select %s -', 'ALSP'), $search_field->content_field->name); ?></option>
			<?php foreach ($search_field->content_field->selection_items AS $key=>$item): ?>
			<option value="<?php echo esc_attr($key); ?>" <?php if (in_array($key, $search_field->value)) echo 'selected'; ?>><?php echo $item; ?></option>
			<?php endforeach; ?>
		</select>
	
	<?php endif; ?>
</div>
<?php endif; ?>