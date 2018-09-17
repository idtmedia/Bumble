<?php

global $wp_roles;
$list = array(
    array('title' => __("Global", "gd-rating-system"), 
          'values' => array('all' => __("Everyone", "gd-rating-system"), 'visitor' => __("Only Visitors", "gd-rating-system"), 'user' => __("All Users", "gd-rating-system"))),
    array('title' => __("User Roles", "gd-rating-system"), 
          'values' => array())
);

foreach ($wp_roles->role_names as $role => $title) {
    $list[1]['values']['role:'.$role] = $title;
}

?>

<h4><?php _e("Visibility", "gd-rating-system"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('_display'); ?>"><?php _e("Display To", "gd-rating-system"); ?>:</label>
                <?php d4p_render_grouped_select($list, array('id' => $this->get_field_id('_display'), 'class' => 'widefat', 'name' => $this->get_field_name('_display'), 'selected' => $instance['_display'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('_hook'); ?>"><?php _e("Visibility Hook", "gd-rating-system"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('_hook'); ?>" name="<?php echo $this->get_field_name('_hook'); ?>" type="text" value="<?php echo esc_attr($instance['_hook']); ?>" />
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Before and After Content", "gd-rating-system"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('before'); ?>"><?php _e("Before", "gd-rating-system"); ?>:</label>
                <textarea class="widefat half-height" id="<?php echo $this->get_field_id('before'); ?>" name="<?php echo $this->get_field_name('before'); ?>"><?php echo esc_textarea($instance['before']); ?></textarea>
            </td>
        </tr>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('after'); ?>"><?php _e("After", "gd-rating-system"); ?>:</label>
                <textarea class="widefat half-height" id="<?php echo $this->get_field_id('after'); ?>" name="<?php echo $this->get_field_name('after'); ?>"><?php echo esc_textarea($instance['after']); ?></textarea>
            </td>
        </tr>
    </tbody>
</table>
