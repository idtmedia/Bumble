<p>
	<label for="<?php echo $widget->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
	<input class="widefat" id="<?php echo $widget->get_field_id('title'); ?>" name="<?php echo $widget->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
</p>
<p>
	<label for="<?php echo $widget->get_field_id('number_of_listings'); ?>"><?php _e('Number of listings:'); ?></label> 
	<input id="<?php echo $widget->get_field_id('number_of_listings'); ?>" size="2" name="<?php echo $widget->get_field_name('number_of_listings'); ?>" type="text" value="<?php echo esc_attr($instance['number_of_listings']); ?>" />
</p>
<p>
	<input id="<?php echo $widget->get_field_id('is_sticky_featured'); ?>" name="<?php echo $widget->get_field_name('is_sticky_featured'); ?>" type="checkbox" value="1" <?php checked($instance['is_sticky_featured'], 1, true); ?> />
	<label for="<?php echo $widget->get_field_id('is_sticky_featured'); ?>"><?php _e('Sticky and featured listings on top'); ?></label> 
</p>
<p>
	<input id="<?php echo $widget->get_field_id('only_sticky_featured'); ?>" name="<?php echo $widget->get_field_name('only_sticky_featured'); ?>" type="checkbox" value="1" <?php checked($instance['only_sticky_featured'], 1, true); ?> />
	<label for="<?php echo $widget->get_field_id('only_sticky_featured'); ?>"><?php _e('Only sticky and featured listings'); ?></label> 
</p>
<p>
	<input id="<?php echo $widget->get_field_id('is_slider_view'); ?>" name="<?php echo $widget->get_field_name('is_slider_view'); ?>" type="checkbox" value="1" <?php checked($instance['is_slider_view'], 1, true); ?> />
	<label for="<?php echo $widget->get_field_id('is_slider_view'); ?>"><?php _e('Turn On Slider View'); ?></label> 
</p>
<p>
	<label for="<?php echo $widget->get_field_id('width'); ?>"><?php _e('Image width only for slider view:'); ?></label> 
	<input class="widefat" id="<?php echo $widget->get_field_id('width'); ?>" name="<?php echo $widget->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr($instance['width']); ?>" />
</p>
<p>
	<label for="<?php echo $widget->get_field_id('height'); ?>"><?php _e('Image height only for slider view:'); ?></label> 
	<input class="widefat" id="<?php echo $widget->get_field_id('height'); ?>" name="<?php echo $widget->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($instance['height']); ?>" />
</p>
<p>
	<input id="<?php echo $widget->get_field_name('visibility'); ?>" name="<?php echo $widget->get_field_name('visibility'); ?>" type="checkbox" value="1" <?php checked($instance['visibility'], 1, true); ?> />
	<label for="<?php echo $widget->get_field_id('visibility'); ?>"><?php _e('Show only on directory pages'); ?></label> 
</p>