<tr class="form-field hide-if-no-js">
	<th scope="row" valign="top"><label for="description"><?php print _e('Marker Color', 'ALSP') ?></label></th>
	<td>
		<?php echo $alsp_instance->categories_manager->choose_marker_icon_color($term->term_id); ?>
		<p class="description"><?php _e('Associate a color to this category', 'ALSP'); ?></p>
	</td>
</tr>