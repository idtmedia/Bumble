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
	<?php
		global $ALSP_ADIMN_SETTINGS; 
		if($ALSP_ADIMN_SETTINGS['price_symb'] == 'post'){ ?>
			<span class="alsp-field-content symb-post">
	<?php }else{ ?>
	<span class="alsp-field-content">
	<?php } ?>
		<?php
		if($ALSP_ADIMN_SETTINGS['price_symb'] == 'post'){
			echo $formatted_price.'<span class="symbol_style2">'.$content_field->currency_symbol.'</span>';
		}else{
			echo '<span class="symbol_style2">'.$content_field->currency_symbol.'</span>'.$formatted_price;
		}
		?>
	</span>
</div>