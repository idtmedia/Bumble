<div>
	<img class="icon_image_tag2 alsp-field-icon2" src="<?php if ($icon_file2) echo esc_url(ALSP_CATEGORIES_ICONS_URL . $icon_file2); ?>" <?php if (!$icon_file2): ?>style="display: none;" <?php endif; ?> />
	<input type="hidden" name="icon_image2" class="icon_image2" value="<?php if ($icon_file2) echo esc_attr($icon_file2); ?>">
	<input type="hidden" name="category_id2" class="category_id2" value="<?php echo esc_attr($term_id); ?>">
	<a class="select_icon_image2" href="javascript: void(0);"><?php _e('Select icon', 'ALSP'); ?></a>
</div>