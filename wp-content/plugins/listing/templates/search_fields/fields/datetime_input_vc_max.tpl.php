<script>
	(function($) {
		"use strict";
	
		$(function() {
			$("#alsp-field-input-<?php echo $settings['field_id']; ?>_max").datepicker({
				dateFormat: '<?php echo $dateformat; ?>',
				onSelect: function(dateText) {
					var tmstmp_str;
					var sDate = $("#alsp-field-input-<?php echo $settings['field_id']; ?>_max").datepicker("getDate");
					if (sDate) {
						sDate.setMinutes(sDate.getMinutes() - sDate.getTimezoneOffset());
						tmstmp_str = $.datepicker.formatDate('@', sDate)/1000;
					} else 
						tmstmp_str = 0;
					$("#alsp-field-input-<?php echo $settings['field_id']; ?>_min").datepicker('option', 'maxDate', sDate);
	
					$("input[name=<?php echo $settings['param_name']; ?>]").val(tmstmp_str);
				}
			});
			<?php
			if ($lang_code = alsp_getDatePickerLangCode(get_locale())): ?>
			$("#alsp-field-input-<?php echo $settings['field_id']; ?>_max").datepicker($.datepicker.regional[ "<?php echo $lang_code; ?>" ]);
			<?php endif; ?>
	
			<?php if ($value): ?>
			$("#alsp-field-input-<?php echo $settings['field_id']; ?>_max").datepicker('setDate', $.datepicker.parseDate('dd/mm/yy', '<?php echo date('d/m/Y', $value); ?>'));
			$("#alsp-field-input-<?php echo $settings['field_id']; ?>_min").datepicker('option', 'maxDate', $("#alsp-field-input-<?php echo $settings['field_id']; ?>_max").datepicker('getDate'));
			<?php endif; ?>
			$("#reset_date_max").click(function() {
				$.datepicker._clearDate('#alsp-field-input-<?php echo $settings['field_id']; ?>_max');
			})
		});
	})(jQuery);
</script>
<input type="text" id="alsp-field-input-<?php echo $settings['field_id']; ?>_max" placeholder="<?php esc_attr_e('End date', 'ALSP'); ?>" class="form-control" size="9" />
<input type="hidden" name="<?php echo $settings['param_name']; ?>" value="<?php echo esc_attr($value); ?>" class="wpb_vc_param_value"/>
<input type="button" id="reset_date_max" value="<?php esc_attr_e('reset date', 'ALSP')?>" />