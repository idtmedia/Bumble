<?php alsp_frontendRender('admin_header.tpl.php'); ?>
<h2>
	<?php _e('Configure number field', 'ALSP'); ?>
</h2>

<form method="POST" action="">
	<?php wp_nonce_field(ALSP_PATH, 'alsp_configure_content_fields_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php _e('Is integer or decimal', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="is_integer"
						type="radio"
						value="1"
						<?php if($content_field->is_integer) echo 'checked'; ?> />
					<?php _e('integer', 'ALSP')?>
					&nbsp;&nbsp;
					<input
						name="is_integer"
						type="radio"
						value="0"
						<?php if(!$content_field->is_integer) echo 'checked'; ?> />
					<?php _e('decimal', 'ALSP')?>
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
			<tr>
				<th scope="row">
					<label><?php _e('Min', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="min"
						type="text"
						size="2"
						value="<?php echo esc_attr($content_field->min); ?>" />
					<p class="description"><?php _e("leave empty if you do not need to limit this field", 'ALSP'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Max', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="max"
						type="text"
						size="2"
						value="<?php echo esc_attr($content_field->max); ?>" />
					<p class="description"><?php _e("leave empty if you do not need to limit this field", 'ALSP'); ?></p>
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php submit_button(__('Save changes', 'ALSP')); ?>
</form>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>