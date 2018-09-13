<?php alsp_frontendRender('admin_header.tpl.php'); ?>

<h2>
	<?php _e('Configure textarea field', 'ALSP'); ?>
</h2>

<form method="POST" action="">
	<?php wp_nonce_field(ALSP_PATH, 'alsp_configure_content_fields_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php _e('Max length', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
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
					<label><?php _e('HTML editor enabled', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="html_editor"
						type="checkbox"
						value="1"
						<?php checked(1, $content_field->html_editor, true)?> />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Run shortcodes', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="do_shortcodes"
						type="checkbox"
						value="1"
						<?php checked(1, $content_field->do_shortcodes, true)?> />
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php submit_button(__('Save changes', 'ALSP')); ?>
</form>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>