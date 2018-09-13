<?php alsp_frontendRender('admin_header.tpl.php'); ?>
<h2>
	<?php _e('Configure select/checkbox/radio search field', 'ALSP'); ?>
</h2>

<form method="POST" action="">
	<?php wp_nonce_field(ALSP_PATH, 'alsp_configure_content_fields_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php _e('Search input mode', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
				</th>
				<td>
					<select name="search_input_mode">
						<option value="checkboxes" <?php selected($search_field->search_input_mode, 'checkboxes'); ?>><?php _e('checkboxes', 'ALSP'); ?></option>
						<option value="selectbox" <?php selected($search_field->search_input_mode, 'selectbox'); ?>><?php _e('selectbox', 'ALSP'); ?></option>
						<option value="radiobutton" <?php selected($search_field->search_input_mode, 'radiobutton'); ?>><?php _e('radio buttons', 'ALSP'); ?></option>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php submit_button(__('Save changes', 'ALSP')); ?>
</form>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>