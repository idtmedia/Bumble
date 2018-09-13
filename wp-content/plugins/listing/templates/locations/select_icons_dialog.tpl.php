<input type="button" id="reset_icon" class="button button-primary button-large" value="<?php esc_attr_e('Reset icon image', 'ALSP'); ?>" />

		<div class="alsp-icons-theme-block">
		<?php foreach ($locations_icons AS $icon): ?>
			<div class="alsp-map-icon" icon_file="<?php echo $icon; ?>"><img src="<?php echo ALSP_LOCATIONS_ICONS_URL . $icon; ?>" title="<?php echo $icon; ?>" /></div>
		<?php endforeach;?>
		</div>
		<div class="clear_float"></div>