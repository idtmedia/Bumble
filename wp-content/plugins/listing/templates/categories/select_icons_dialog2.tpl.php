		<input type="button" id="reset_icon2" class="button button-primary button-large" value="<?php esc_attr_e('Reset icon image', 'ALSP'); ?>" />

		<div class="alsp-icons-theme-block">
		<?php foreach ($categories_icons2 AS $icon2): ?>
			<div class="alsp-icon2" icon_file2="<?php echo $icon2; ?>"><img src="<?php echo ALSP_CATEGORIES_ICONS_URL . $icon2; ?>" title="<?php echo $icon2; ?>" /></div>
		<?php endforeach;?>
		</div>
		<div class="clear_float"></div>