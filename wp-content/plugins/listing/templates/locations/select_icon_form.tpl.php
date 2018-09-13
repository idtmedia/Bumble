<tr class="form-field hide-if-no-js">
	<th scope="row" valign="top"><label for="description"><?php print _e('Icon', 'ALSP') ?></label></th>
	<td>
		<?php echo $alsp_instance->locations_manager->choose_icon_link($term->term_id); ?>
		<p class="description"><?php _e('Associate an icon to this location', 'ALSP'); ?></p>
	</td>
</tr>