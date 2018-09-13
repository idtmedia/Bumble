<?php alsp_frontendRender('admin_header.tpl.php'); ?>
<h2>
	<?php
	if ($locations_level_id)
		_e('Edit locations level', 'ALSP');
	else
		_e('Create new locations level', 'ALSP');
	?>
</h2>

<form method="POST" action="">
	<?php wp_nonce_field(ALSP_PATH, 'alsp_locations_levels_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php _e('Level name', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="name"
						type="text"
						class="regular-text"
						value="<?php echo $locations_level->name; ?>" />
				</td>
			</tr>
			<!--<tr>
				<th scope="row">
					<label><?php //_e('In location widget', 'ALSP'); ?></label>
				</th>
				<td>
					<input type="checkbox" value="1" name="in_widget" <?php //if ($locations_level->in_widget) echo 'checked'; ?> />
					<p class="description"><?php //_e("Render locations of this level in select locations list widget", 'ALSP'); ?></p>
				</td>
			</tr> -->
			<tr>
				<th scope="row">
					<label><?php _e('In address line', 'ALSP'); ?></label>
				</th>
				<td>
					<input type="checkbox" value="1" name="in_address_line" <?php if ($locations_level->in_address_line) echo 'checked'; ?> />
					<p class="description"><?php _e("Render locations of this level in address line", 'ALSP'); ?></p>
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php
	if ($locations_level_id)
		submit_button(__('Save changes', 'ALSP'));
	else
		submit_button(__('Create locations level', 'ALSP'));
	?>
</form>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>