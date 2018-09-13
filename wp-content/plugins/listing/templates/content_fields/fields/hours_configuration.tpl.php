<?php alsp_frontendRender('admin_header.tpl.php'); ?>
<h2>
	<?php _e('Configure opening hours field', 'ALSP'); ?>
</h2>

<form method="POST" action="">
	<?php wp_nonce_field(ALSP_PATH, 'alsp_configure_content_fields_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php _e('Time convention', 'ALSP'); ?></label>
				</th>
				<td>
					<label>
						<input
							name="hours_clock"
							type="radio"
							value="12"
							<?php if ($content_field->hours_clock == 12) echo 'checked'; ?> />
						<?php _e('12-hour clock', 'ALSP')?>
					</label>
					&nbsp;&nbsp;
					<label>
						<input
							name="hours_clock"
							type="radio"
							value="24"
							<?php if ($content_field->hours_clock == 24) echo 'checked'; ?> />
						<?php _e('24-hour clock', 'ALSP')?>
					</label>
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php submit_button(__('Save changes', 'ALSP')); ?>
</form>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>