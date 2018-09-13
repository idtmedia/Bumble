<input type="button" id="cat_reset_icon" class="button button-primary button-large" value="<?php esc_attr_e('Reset icon image', 'ALSP'); ?>" />

		<div class="alsp-icons-theme-block">
		<?php foreach ($categories_icons AS $icon): ?>
			<div class="cat_alsp-icon" icon_file="<?php echo $icon; ?>"><img src="<?php echo ALSP_CATEGORIES_ICONS_URL . $icon; ?>" title="<?php echo $icon; ?>" /></div>
		<?php endforeach;?>
		</div>
		<div class="clear_float"></div>