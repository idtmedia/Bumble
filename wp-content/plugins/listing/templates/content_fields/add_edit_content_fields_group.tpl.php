<?php alsp_frontendRender('admin_header.tpl.php'); ?>

<h2>
	<?php
	if ($group_id)
		_e('Edit content fields group', 'ALSP');
	else
		_e('Create new content fields group', 'ALSP');
	?>
</h2>

<form method="POST" action="">
	<?php wp_nonce_field(ALSP_PATH, 'alsp_content_fields_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php _e('Fields Group name', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="name"
						id="content_fields_group_name"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($content_fields_group->name); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('On tab', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="on_tab"
						type="checkbox"
						value="1"
						<?php checked($content_fields_group->on_tab); ?> />
					<p class="description"><?php _e("Place this group on separate tab on single listings pages", 'ALSP'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Group Style', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
				</th>
				<td>
					<select name="group_style" id="group_style">
						<option value=""><?php _e('- Select style -', 'ALSP'); ?></option>
						<option value="1" <?php selected($content_fields_group->group_style, '1'); ?>><?php echo esc_html__('style 1', 'ALSP') ?></option>
						<option value="2" <?php selected($content_fields_group->group_style, '2'); ?>><?php echo esc_html__('style 2', 'ALSP') ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Hide from anonymous users', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="hide_anonymous"
						type="checkbox"
						value="1"
						<?php checked($content_fields_group->hide_anonymous); ?> />
					<p class="description"><?php _e("This group of fields will be shown only for registered users", 'ALSP'); ?></p>
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php
	if ($group_id)
		submit_button(__('Save changes', 'ALSP'));
	else
		submit_button(__('Create content fields group', 'ALSP'));
	?>
</form>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>