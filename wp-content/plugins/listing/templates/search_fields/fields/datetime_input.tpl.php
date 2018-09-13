<?php global $ALSP_ADIMN_SETTINGS; ?>
<script>
	(function($) {
		"use strict";
	
		$(function() {
			$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $random_id; ?>").datepicker({
				showButtonPanel: true,
				dateFormat: '<?php echo $dateformat; ?>',
				onSelect: function(dateText) {
					var tmstmp_str;
					var sDate = $("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $random_id; ?>").datepicker("getDate");
					if (sDate) {
						sDate.setMinutes(sDate.getMinutes() - sDate.getTimezoneOffset());
						tmstmp_str = $.datepicker.formatDate('@', sDate)/1000;
					} else 
						tmstmp_str = 0;
					$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $random_id; ?>").datepicker('option', 'minDate', sDate);
	
					$("input[name=field_<?php echo $search_field->content_field->slug; ?>_min]").val(tmstmp_str);
				}
			});
			<?php
			if ($lang_code = alsp_getDatePickerLangCode(get_locale())): ?>
			$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $random_id; ?>").datepicker($.datepicker.regional[ "<?php echo $lang_code; ?>" ]);
			<?php endif; ?>
	
			$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $random_id; ?>").datepicker({
				showButtonPanel: true,
				dateFormat: '<?php echo $dateformat; ?>',
				onSelect: function(dateText) {
					var tmstmp_str;
					var sDate = $("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $random_id; ?>").datepicker("getDate");
					if (sDate) {
						sDate.setMinutes(sDate.getMinutes() - sDate.getTimezoneOffset());
						tmstmp_str = $.datepicker.formatDate('@', sDate)/1000;
					} else 
						tmstmp_str = 0;
					$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $random_id; ?>").datepicker('option', 'maxDate', sDate);
	
					$("input[name=field_<?php echo $search_field->content_field->slug; ?>_max]").val(tmstmp_str);
				}
			});
			<?php
			if ($lang_code = alsp_getDatePickerLangCode(get_locale())): ?>
			$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $random_id; ?>").datepicker($.datepicker.regional[ "<?php echo $lang_code; ?>" ]);
			<?php endif; ?>
	
			<?php if ($search_field->min_max_value['max']): ?>
			$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $random_id; ?>").datepicker('setDate', $.datepicker.parseDate('dd/mm/yy', '<?php echo date('d/m/Y', $search_field->min_max_value['max']); ?>'));
			$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $random_id; ?>").datepicker('option', 'maxDate', $("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $random_id; ?>").datepicker('getDate'));
			<?php endif; ?>
			$("#reset-date-max-<?php echo $random_id; ?>").click(function() {
				$.datepicker._clearDate('#alsp-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $random_id; ?>');
			})
	
			<?php if ($search_field->min_max_value['min']): ?>
			$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $random_id; ?>").datepicker('setDate', $.datepicker.parseDate('dd/mm/yy', '<?php echo date('d/m/Y', $search_field->min_max_value['min']); ?>'));
			$("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $random_id; ?>").datepicker('option', 'minDate', $("#alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $random_id; ?>").datepicker('getDate'));
			<?php endif; ?>
			$("#reset_date-min-<?php echo $random_id; ?>").click(function() {
				$.datepicker._clearDate('#alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $random_id; ?>');
			})
		});
	})(jQuery);
</script>
<?php $gap_in_fields = $ALSP_ADIMN_SETTINGS['gap_in_fields']; ?>

<div class="cz-datetime form-group search-element-col alsp-field-search-block-<?php echo $search_field->content_field->id; ?> alsp-field-search-block-<?php echo $random_id; ?> alsp-field-search-block-<?php echo $search_field->content_field->id; ?>_<?php echo $random_id; ?> clearfix pull-left" style=" width:<?php echo $search_field->content_field->fieldwidth; ?>%; padding:0 <?php echo $gap_in_fields; ?>px;">
	<div class="row clearfix">
		<div class="col-md-12">
			<label><?php echo $search_field->content_field->name; ?></label>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="form-horizontal clearfix">
				<div class="datetime-input-field alsp-has-feedback">
					<input type="text" class="form-control" id="alsp-field-input-<?php echo $search_field->content_field->id; ?>-min-<?php echo $random_id; ?>" placeholder="<?php esc_attr_e('Start date', 'ALSP'); ?>" />
					<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
					<input type="hidden" name="field_<?php echo $search_field->content_field->slug; ?>_min" value="<?php echo esc_attr($search_field->min_max_value['min']); ?>"/>
				</div>
				<div class="datetime-reset-btn">
					<input type="button" class="btn btn-primary form-control" id="reset_date-min-<?php echo $random_id; ?>" value="<?php esc_attr_e('Reset', 'ALSP')?>" />
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="form-horizontal">
				<div class="datetime-input-field alsp-has-feedback">
					<input type="text" class="form-control" id="alsp-field-input-<?php echo $search_field->content_field->id; ?>-max-<?php echo $random_id; ?>" placeholder="<?php esc_attr_e('End date', 'ALSP'); ?>" />
					<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
					<input type="hidden" name="field_<?php echo $search_field->content_field->slug; ?>_max" value="<?php echo esc_attr($search_field->min_max_value['max']); ?>"/>
				</div>
				<div class="datetime-reset-btn">
					<input type="button" class="btn btn-primary form-control" id="reset-date-max-<?php echo $random_id; ?>" value="<?php esc_attr_e('Reset', 'ALSP')?>" />
				</div>
			</div>
		</div>
	</div>
</div>