<?php alsp_frontendRender('admin_header.tpl.php'); ?>
<h2>
	<?php _e('Configure number/price search field', 'ALSP'); ?>
</h2>

<script>
	(function($) {
		"use strict";
	
		$(function() {
			$("#add_selection_item").click(function() {
				$("#selection_items_wrapper").append('<div class="selection_item"><input name="min_max_options[]" type="text" size="9" value="" /><img class="alsp-delete-selection-item" src="<?php echo ALSP_RESOURCES_URL . 'images/delete.png'?>" title="<?php esc_attr_e('Remove option', 'ALSP')?>" /></div>');
			});
			$(document).on("click", ".alsp-delete-selection-item", function() {
				$(this).parent().remove();
			});
		});
	})(jQuery);
</script>

<form method="POST" action="">
	<?php wp_nonce_field(ALSP_PATH, 'alsp_configure_content_fields_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php _e('Search mode', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
				</th>
				<td>
					<label>
						<input
							name="mode"
							type="radio"
							value="exact_number"
							<?php checked($search_field->mode, 'exact_number'); ?> />
						<?php _e('Enter exact number for search', 'ALSP'); ?>
					</label>
					<br />
					<label>
						<input
							name="mode"
							type="radio"
							value="min_max"
							<?php checked($search_field->mode, 'min_max'); ?> />
						<?php _e('Select Min-Max options for search', 'ALSP'); ?>
					</label>
					<br />
					<label>
						<input
							name="mode"
							type="radio"
							value="min_max_slider"
							<?php checked($search_field->mode, 'min_max_slider'); ?> />
						<?php _e('Search range slider with steps from Min-Max options', 'ALSP'); ?>
					</label>
					<br />
					<label>
						<input
							name="mode"
							type="radio"
							value="range_slider"
							<?php checked($search_field->mode, 'range_slider'); ?> />
						<?php _e('Search range slider with step 1.', 'ALSP'); ?>
					</label>
					 <?php _e('From:', 'ALSP'); ?><input type="text" name="slider_step_1_min" size=4 value="<?php echo $search_field->slider_step_1_min; ?>" /> <?php _e('To:', 'ALSP'); ?><input type="text" name="slider_step_1_max" size=4 value="<?php echo $search_field->slider_step_1_max; ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Min-Max options:', 'ALSP'); ?>
				</th>
				<td>
					<div id="selection_items_wrapper">
						<?php if (count($search_field->min_max_options)): ?>
						<?php foreach ($search_field->min_max_options AS $item): ?>
						<div class="selection_item">
							<input
								name="min_max_options[]"
								type="text"
								size="9"
								value="<?php echo $item; ?>" />
							<img class="alsp-delete-selection-item" src="<?php echo ALSP_RESOURCES_URL . 'images/delete.png'?>" title="<?php esc_attr_e('Remove min-max option', 'ALSP')?>" />
						</div>
						<?php endforeach; ?>
						<?php else: ?>
						<div class="selection_item">
							<input
								name="min_max_options[]"
								type="text"
								size="9"
								value="" />
							<img class="alsp-delete-selection-item" src="<?php echo ALSP_RESOURCES_URL . 'images/delete.png'?>" title="<?php esc_attr_e('Remove min-max option', 'ALSP')?>" />
						</div>
						<?php endif; ?>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<input type="button" id="add_selection_item" class="button button-primary" value="<?php esc_attr_e('Add min-max option', 'ALSP'); ?>" />
	
	<?php submit_button(__('Save changes', 'ALSP')); ?>
</form>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>