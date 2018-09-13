<p>
	<label for="<?php echo $widget->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
	<input class="widefat" id="<?php echo $widget->get_field_id('title'); ?>" name="<?php echo $widget->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
</p>
<p>
	<label for="<?php echo $widget->get_field_id('uid'); ?>"><?php _e('uID:'); ?></label> 
	<input class="widefat" id="<?php echo $widget->get_field_id('uid'); ?>" name="<?php echo $widget->get_field_name('uid'); ?>" type="text" value="<?php echo esc_attr($instance['uid']); ?>" /><?php _e('Enter unique string to connect search form with another elements on the page.', 'ALSP'); ?>
</p>
<p>
	<input id="<?php echo $widget->get_field_name('search_visibility'); ?>" name="<?php echo $widget->get_field_name('search_visibility'); ?>" type="checkbox" value="1" <?php checked($instance['search_visibility'], 1, true); ?> />
	<label for="<?php echo $widget->get_field_id('search_visibility'); ?>"><?php _e('Show only when there is no any other search form on page'); ?></label> 
</p>
<p>
	<input id="<?php echo $widget->get_field_name('visibility'); ?>" name="<?php echo $widget->get_field_name('visibility'); ?>" type="checkbox" value="1" <?php checked($instance['visibility'], 1, true); ?> />
	<label for="<?php echo $widget->get_field_id('visibility'); ?>"><?php _e('Show only on directory pages'); ?></label> 
</p>