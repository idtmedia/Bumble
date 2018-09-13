<p>
	<label for="<?php echo $widget->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
	<input class="widefat" id="<?php echo $widget->get_field_id('title'); ?>" name="<?php echo $widget->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
</p>
<p>
	<label for="<?php echo $widget->get_field_id('style'); ?>"><?php _e('Categories widget style:'); ?></label>
	<select id="<?php echo $widget->get_field_id('style'); ?>" name="<?php echo $widget->get_field_name('style'); ?>">
	<option value=1 <?php selected($instance['style'], 1); ?>><?php echo esc_html__('Style 1 (default)', 'ALSP'); ?></option>
	<option value=2 <?php selected($instance['style'], 2); ?>><?php echo esc_html__('Style 2 (ultra)', 'ALSP'); ?></option>
	</select>
</p>
<p>
	<label for="<?php echo $widget->get_field_id('depth'); ?>"><?php _e('Categories nesting level:'); ?></label>
	<select id="<?php echo $widget->get_field_id('depth'); ?>" name="<?php echo $widget->get_field_name('depth'); ?>">
	<option value=1 <?php selected($instance['depth'], 1); ?>>1</option>
	<option value=2 <?php selected($instance['depth'], 2); ?>>2</option>
	</select>
</p>
<p>
	<input id="<?php echo $widget->get_field_id('counter'); ?>" name="<?php echo $widget->get_field_name('counter'); ?>" type="checkbox" value="1" <?php checked($instance['counter'], 1, true); ?> />
	<label for="<?php echo $widget->get_field_id('counter'); ?>"><?php _e('Show listings counts'); ?></label> 
</p>
<p>
	<label for="<?php echo $widget->get_field_id('subcats'); ?>"><?php _e('Show subcategories items number:'); ?></label> 
	<input id="<?php echo $widget->get_field_id('subcats'); ?>" size="2" name="<?php echo $widget->get_field_name('subcats'); ?>" type="text" value="<?php echo esc_attr($instance['subcats']); ?>" />
	<p class="description"><?php _e('Leave 0 to show all subcategories', 'ALSP'); ?></p>
</p>
<p>
	<label for="<?php echo $widget->get_field_id('parent'); ?>"><?php _e('Parent category:'); ?></label> 
	<input id="<?php echo $widget->get_field_id('parent'); ?>" size="2" name="<?php echo $widget->get_field_name('parent'); ?>" type="text" value="<?php echo esc_attr($instance['parent']); ?>" />
	<p class="description"><?php _e('Leave 0 to show all root categories', 'ALSP'); ?></p>
</p>
<p>
	<input id="<?php echo $widget->get_field_name('visibility'); ?>" name="<?php echo $widget->get_field_name('visibility'); ?>" type="checkbox" value="1" <?php checked($instance['visibility'], 1, true); ?> />
	<label for="<?php echo $widget->get_field_id('visibility'); ?>"><?php _e('Show only on directory pages'); ?></label> 
</p>