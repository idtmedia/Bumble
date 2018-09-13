<?php alsp_frontendRender('admin_header.tpl.php'); ?>
<div class="alsp-configuration-page-wrap">
<h2>
	<?php _e('Configure select/radio buttons/checkboxes field', 'ALSP'); ?>
</h2>

<script>
	(function($) {
		"use strict";
	
		$(function() {
			var max_index = <?php echo ((count(array_keys($content_field->selection_items)) ? max(array_keys($content_field->selection_items)) : 1)); ?>;
			$("#add_selection_item").click(function() {
				max_index = max_index+1;
				$("#selection_items_wrapper").append('<div class="selection_item clearfix"><span class="pacz-icon-trash-o alsp-delete-selection-item"></span><input name="selection_items['+max_index+']" type="text" class="regular-text" value="" placeholder="text"/><input name="icon_selection_items['+max_index+']" type="text" class="regular-text" value="" placeholder="icon class"/><span class="pacz-icon-arrows alsp-move-label"></span></div>');
			});
			$(document).on("click", ".alsp-delete-selection-item", function() {
				//$(this).parent().remove();
				 var targeted_popup_class1 = jQuery(this).attr('data-id');
        $('.id_'+ targeted_popup_class1+'').remove();
				//$('.id_'+data-attr['id']).remove();
			});
		
			$("#selection_items_wrapper").sortable({
				placeholder: "ui-sortable-placeholder",
				helper: function(e, ui) {
					ui.children().each(function() {
						$(this).width($(this).width());
					});
					return ui;
				},
				start: function(e, ui){
					ui.placeholder.height(ui.item.height());
				}
	    	});
			//$('.selection_item').wrap('<div class="selection_item_main"></div>');
		});
	})(jQuery);
</script>

<?php _e('You may order items by drag & drop.', 'ALSP'); ?>
<form method="POST" action="">
	<?php wp_nonce_field(ALSP_PATH, 'alsp_configure_content_fields_nonce');?>
	<div class="form-table">
		<div>
			<?php //do_action('alsp_select_content_field_configuration_html', $content_field); 
				if($content_field->type == 'checkbox'){$content_field->add_configuration_options($content_field); }
			?>
			<div>
				<div scope="row">
					<label><?php _e('Selection items:', 'ALSP'); ?></label>
				</div>
				<div>
					<div id="selection_items_wrapper">
						<?php if (count($content_field->selection_items)): ?>
						
						<?php foreach ($content_field->selection_items AS $key=>$item): ?>
						<div id ="main_<?php echo $key; ?>" class="selection_item id_<?php echo $key; ?> clearfix">
							<span class="pacz-icon-trash-o alsp-delete-selection-item" data-id="<?php echo $key; ?>"></span>
							<input
								name="selection_items[<?php echo $key; ?>]"
								type="text"
								class="regular-text"
								value="<?php echo $item; ?>" />
							<span class="pacz-icon-arrows alsp-move-label"></span>
						</div>
						<script>
							(function($) {
								"use strict";
							
								$(function() {
													$("#sub_<?php echo $key; ?>").appendTo("#main_<?php echo $key; ?>");
													});
							})(jQuery);
						</script>
						<?php endforeach; ?>
						<?php if($content_field->type == 'checkbox'){ ?>
						<?php foreach ($content_field->icon_selection_items AS $key=>$item): ?>
						<div id ="sub_<?php echo $key; ?>" data-id="<?php echo $key; ?>" class="sub_item id_<?php echo $key; ?>">
							<input
								name="icon_selection_items[<?php echo $key; ?>]"
								type="text"
								class="regular-text"
								value="<?php echo $item; ?>" />
						</div>
						<?php endforeach; ?>
						<?php } ?>
						<?php else: ?>
						<div class="selection_item id_1">
							<span class="pacz-icon-trash-o alsp-delete-selection-item"></span>
							<input
								name="selection_items[1]"
								type="text"
								class="regular-text"
								value="" />
						<?php if($content_field->type == 'checkbox'){ ?>
							<input
								name="icon_selection_items[1]"
								type="text"
								class="regular-text"
								value="" />
						<?php } ?>
							<span class="pacz-icon-arrows alsp-move-label"></span>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<input type="button" id="add_selection_item" class="button button-primary" value="<?php esc_attr_e('Add selection item', 'ALSP'); ?>" />
	
	<?php submit_button(__('Save changes', 'ALSP')); ?>
</form>
</div>
<?php alsp_frontendRender('admin_footer.tpl.php'); ?>