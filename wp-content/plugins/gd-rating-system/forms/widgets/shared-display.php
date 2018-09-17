<h4><?php _e("Extras", "gd-rating-system"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular" colspan="2">
                <label for="<?php echo $this->get_field_id('_class'); ?>"><?php _e("Additional CSS Class", "gd-rating-system"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('_class'); ?>" name="<?php echo $this->get_field_name('_class'); ?>" type="text" value="<?php echo esc_attr($instance['_class']); ?>" />
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Developers", "gd-rating-system"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular" colspan="2">
                <label for="<?php echo $this->get_field_id('_devid'); ?>"><?php _e("Unique ID", "gd-rating-system"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('_devid'); ?>" name="<?php echo $this->get_field_name('_devid'); ?>" type="text" value="<?php echo esc_attr($instance['_devid']); ?>" />
            </td>
        </tr>
    </tbody>
</table>
