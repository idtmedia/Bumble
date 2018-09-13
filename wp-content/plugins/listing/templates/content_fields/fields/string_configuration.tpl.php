<?php alsp_frontendRender('admin_header.tpl.php'); ?>
<h2>
	<?php _e('Configure text string field',  'ALSP'); ?>
</h2>

<form method="POST" action="">
	<?php wp_nonce_field(ALSP_PATH, 'alsp_configure_content_fields_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php _e('Max length',  'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="max_length"
						type="text"
						size="2"
						value="<?php echo esc_attr($content_field->max_length); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('PHP RegEx template',  'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="regex"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($content_field->regex); ?>" />
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php submit_button(__('Save changes', 'ALSP')); ?>
</form>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>