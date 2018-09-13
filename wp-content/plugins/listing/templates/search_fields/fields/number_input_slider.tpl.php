<?php $index = $search_field->content_field->id . '_' . $random_id; ?>
<?php if (count($search_field->min_max_options) && $search_field->mode == 'min_max_slider'): ?>
<?php $min_value = (($search_field->min_max_value['min']) ? $search_field->min_max_value['min'] : __('min', 'ALSP')); ?>
<?php $max_value = (($search_field->min_max_value['max']) ? $search_field->min_max_value['max'] : __('max', 'ALSP')); ?>
<?php elseif ($search_field->mode == 'range_slider'): ?>
<?php $min_value = (($search_field->min_max_value['min']) ? $search_field->min_max_value['min'] : __('min', 'ALSP')); ?>
<?php $max_value = (($search_field->min_max_value['max']) ? $search_field->min_max_value['max'] : __('max', 'ALSP')); ?>
<?php endif; ?>
<div class="row alsp-field-search-block-<?php echo $search_field->content_field->id; ?> alsp-field-search-block-<?php echo $random_id; ?> alsp-field-search-block-<?php echo $index; ?>" style=" width:<?php echo $search_field->content_field->fieldwidth; ?>%; padding:0 <?php echo $gap_in_fields; ?>px;">
	<div class="col-md-12">
		<label><?php echo $search_field->content_field->name; ?> <span id="slider_label_<?php echo $index; ?>"><?php echo $min_value . ' - ' . $max_value; ?></span></label>
	</div>
	
	<script>
		(function($) {
			"use strict";
		
			$(function() {
				<?php if (count($search_field->min_max_options) && $search_field->mode == 'min_max_slider'): ?>
				var slider_params_<?php echo $index; ?> = ['<?php _e('min', 'ALSP'); ?>', <?php echo implode(',', $search_field->min_max_options); ?>, '<?php _e('max', 'ALSP'); ?>'];
				var slider_min = 0;
				var slider_max = slider_params_<?php echo $index; ?>.length-1;
				<?php elseif ($search_field->mode == 'range_slider'): ?>
				var slider_min = <?php echo $search_field->slider_step_1_min-1; ?>;
				var slider_max = <?php echo $search_field->slider_step_1_max+1; ?>;
				<?php endif; ?>
				$('#range_slider_<?php echo $index; ?>').slider({
					<?php if (function_exists('is_rtl') && is_rtl()): ?>
					isRTL: true,
					<?php endif; ?>
					min: slider_min,
					max: slider_max,
					range: true,
					<?php if (count($search_field->min_max_options) && $search_field->mode == 'min_max_slider'): ?>
					values: [<?php echo ((($min = array_search($search_field->min_max_value['min'], $search_field->min_max_options)) !== false) ? $min+1 : 0); ?>, <?php echo ((($max = array_search($search_field->min_max_value['max'], $search_field->min_max_options)) !== false) ? $max+1 : count($search_field->min_max_options)+1); ?>],
					<?php elseif ($search_field->mode == 'range_slider'): ?>
					values: [<?php echo (($search_field->min_max_value['min']) ? $search_field->min_max_value['min']+1 : $search_field->slider_step_1_min-1); ?>, <?php echo (($search_field->min_max_value['max']) ? $search_field->min_max_value['max']+1 : $search_field->slider_step_1_max+1); ?>],
					<?php endif; ?>
					slide: function(event, ui) {
						<?php if (count($search_field->min_max_options) && $search_field->mode == 'min_max_slider'): ?>
						$('#slider_label_<?php echo $index; ?>').html(slider_params_<?php echo $index; ?>[ui.values[0]] + ' - ' + slider_params_<?php echo $index; ?>[ui.values[1]]);
						if (slider_params_<?php echo $index; ?>[ui.values[0]] == '<?php _e('min', 'ALSP'); ?>')
							$('#field_<?php echo $index; ?>_min').val('');
						else
							$('#field_<?php echo $index; ?>_min').val(slider_params_<?php echo $index; ?>[ui.values[0]]);
						if (slider_params_<?php echo $index; ?>[ui.values[1]] == '<?php _e('max', 'ALSP'); ?>')
							$('#field_<?php echo $index; ?>_max').val('');
						else
							$('#field_<?php echo $index; ?>_max').val(slider_params_<?php echo $index; ?>[ui.values[1]]);
						<?php elseif ($search_field->mode == 'range_slider'): ?>
						if (ui.values[0] == <?php echo $search_field->slider_step_1_min-1; ?>) {
							var min = '<?php _e('min', 'ALSP'); ?>';
							$('#field_<?php echo $index; ?>_min').val('');
						} else {
							var min = ui.values[0];
							$('#field_<?php echo $index; ?>_min').val(ui.values[0]);
						}
						if (ui.values[1] == <?php echo $search_field->slider_step_1_max+1; ?>) {
							var max = '<?php _e('max', 'ALSP'); ?>';
							$('#field_<?php echo $index; ?>_max').val('');
						} else {
							var max = ui.values[1];
							$('#field_<?php echo $index; ?>_max').val(ui.values[1]);
						}
		
						$('#slider_label_<?php echo $index; ?>').html(min + ' - ' + max);
						<?php endif; ?>
					}
				});
			});
		})(jQuery);
	</script>
	<div class="col-md-12 form-group alsp-jquery-ui-slider">
		<div id="range_slider_<?php echo $index; ?>"></div>
		<input type="hidden" id="field_<?php echo $index; ?>_min" name="field_<?php echo $search_field->content_field->slug; ?>_min" value="<?php echo (($min_value == __('min', 'ALSP')) ? '' : $min_value); ?>" />
		<input type="hidden" id="field_<?php echo $index; ?>_max" name="field_<?php echo $search_field->content_field->slug; ?>_max" value="<?php echo (($max_value == __('max', 'ALSP')) ? '' : $max_value); ?>" />
	</div>
</div>
