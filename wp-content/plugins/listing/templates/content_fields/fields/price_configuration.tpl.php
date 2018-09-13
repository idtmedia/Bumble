<?php alsp_frontendRender('admin_header.tpl.php'); ?>
<h2>
	<?php _e('Configure price field', 'ALSP'); ?>
</h2>

<form method="POST" action="">
	<?php wp_nonce_field(ALSP_PATH, 'alsp_configure_content_fields_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php _e('Currency symbol', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="currency_symbol"
						type="text"
						size="1"
						value="<?php echo esc_attr($content_field->currency_symbol); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Decimal separator', 'ALSP'); ?></label>
				</th>
				<td>
					<select name="decimal_separator">
						<option value="." <?php if($content_field->decimal_separator == '.') echo 'selected'; ?>><?php _e('dot', 'ALSP')?></option>
						<option value="," <?php if($content_field->decimal_separator == ',') echo 'selected'; ?>><?php _e('comma', 'ALSP')?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Thousands separator', 'ALSP'); ?></label>
				</th>
				<td>
					<select name="thousands_separator">
						<option value="" <?php if($content_field->thousands_separator == '') echo 'selected'; ?>><?php _e('no separator', 'ALSP')?></option>
						<option value="." <?php if($content_field->thousands_separator == '.') echo 'selected'; ?>><?php _e('dot', 'ALSP')?></option>
						<option value="," <?php if($content_field->thousands_separator == ',') echo 'selected'; ?>><?php _e('comma', 'ALSP')?></option>
						<option value=" " <?php if($content_field->thousands_separator == ' ') echo 'selected'; ?>><?php _e('space', 'ALSP')?></option>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php submit_button(__('Save changes', 'ALSP')); ?>
</form>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>