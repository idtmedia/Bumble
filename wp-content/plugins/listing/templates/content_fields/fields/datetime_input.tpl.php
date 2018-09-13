<script>
	(function($) {
		"use strict";
	
		$(function() {
			$("#alsp-field-input-<?php echo $content_field->id; ?>").datepicker({
				<?php if (function_exists('is_rtl') && is_rtl()): ?>isRTL: true,<?php endif; ?>
				showButtonPanel: true,
				dateFormat: '<?php echo $dateformat; ?>',
				onSelect: function(dateText) {
					var tmstmp_str;
					var sDate = $("#alsp-field-input-<?php echo $content_field->id; ?>").datepicker("getDate");
					if (sDate) {
						sDate.setMinutes(sDate.getMinutes() - sDate.getTimezoneOffset());
						tmstmp_str = $.datepicker.formatDate('@', sDate)/1000;
					} else 
						tmstmp_str = 0;
	
					$("input[name=alsp-field-input-<?php echo $content_field->id; ?>]").val(tmstmp_str);
				}
			});
			<?php
			if ($lang_code = alsp_getDatePickerLangCode(get_locale())): ?>
			$("#alsp-field-input-<?php echo $content_field->id; ?>").datepicker($.datepicker.regional[ "<?php echo $lang_code; ?>" ]);
			<?php endif; ?>
			
			<?php if ($content_field->value['date']): ?>
			$("#alsp-field-input-<?php echo $content_field->id; ?>").datepicker('setDate', $.datepicker.parseDate('dd/mm/yy', '<?php echo date('d/m/Y', $content_field->value['date']); ?>'));
			<?php endif; ?>
			$("#reset_date").click(function() {
				$.datepicker._clearDate('#alsp-field-input-<?php echo $content_field->id; ?>');
			})
		});
	})(jQuery);
</script>
<div class="alsp-field alsp-field-input-block alsp-field-output-block-<?php echo $content_field->type; ?> alsp-field-input-block-<?php echo $content_field->id; ?>">
	
	<div class="input-date-time-wrap clearfix">
		
			<label class="alsp-control-label alsp-submit-field-title"><?php echo $content_field->name; ?><?php if ($content_field->canBeRequired() && $content_field->is_required): ?><span class="alsp-red-asterisk">*</span><?php endif; ?></label>
			<div class="input-date-time-filed-wrap clearfix">
				<div class="alsp-has-feedback input-date-time-filed">
					<input type="text" id="alsp-field-input-<?php echo $content_field->id; ?>" class="alsp-field-input-datetime form-control" />
					<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
					<input type="hidden" name="alsp-field-input-<?php echo $content_field->id; ?>" value="<?php echo esc_attr($content_field->value['date']); ?>"/>
				</div>
				<div class="input-date-time-btn">
					<input type="button" class="btn btn-primary" id="reset_date" value="<?php esc_attr_e('reset date', 'ALSP')?>" />
				</div>
			</div>
		
		<?php if ($content_field->is_time): ?>
			<div class="min-hours-wrap clearfix">
				<div class="input-date-time-hours">
					<select class="cs-select  pacz-select2" name="alsp-field-input-hour_<?php echo $content_field->id; ?>">
						<option value="00" <?php if ($content_field->value['hour'] == '00') echo 'selected'; ?>>00</option>
						<option value="01" <?php if ($content_field->value['hour'] == '01') echo 'selected'; ?>>01</option>
						<option value="02" <?php if ($content_field->value['hour'] == '02') echo 'selected'; ?>>02</option>
						<option value="03" <?php if ($content_field->value['hour'] == '03') echo 'selected'; ?>>03</option>
						<option value="04" <?php if ($content_field->value['hour'] == '04') echo 'selected'; ?>>04</option>
						<option value="05" <?php if ($content_field->value['hour'] == '05') echo 'selected'; ?>>05</option>
						<option value="06" <?php if ($content_field->value['hour'] == '06') echo 'selected'; ?>>06</option>
						<option value="07" <?php if ($content_field->value['hour'] == '07') echo 'selected'; ?>>07</option>
						<option value="08" <?php if ($content_field->value['hour'] == '08') echo 'selected'; ?>>08</option>
						<option value="09" <?php if ($content_field->value['hour'] == '09') echo 'selected'; ?>>09</option>
						<option value="10" <?php if ($content_field->value['hour'] == '10') echo 'selected'; ?>>10</option>
						<option value="11" <?php if ($content_field->value['hour'] == '11') echo 'selected'; ?>>11</option>
						<option value="12" <?php if ($content_field->value['hour'] == '12') echo 'selected'; ?>>12</option>
						<option value="13" <?php if ($content_field->value['hour'] == '13') echo 'selected'; ?>>13</option>
						<option value="14" <?php if ($content_field->value['hour'] == '14') echo 'selected'; ?>>14</option>
						<option value="15" <?php if ($content_field->value['hour'] == '15') echo 'selected'; ?>>15</option>
						<option value="16" <?php if ($content_field->value['hour'] == '16') echo 'selected'; ?>>16</option>
						<option value="17" <?php if ($content_field->value['hour'] == '17') echo 'selected'; ?>>17</option>
						<option value="18" <?php if ($content_field->value['hour'] == '18') echo 'selected'; ?>>18</option>
						<option value="19" <?php if ($content_field->value['hour'] == '19') echo 'selected'; ?>>19</option>
						<option value="20" <?php if ($content_field->value['hour'] == '20') echo 'selected'; ?>>20</option>
						<option value="21" <?php if ($content_field->value['hour'] == '21') echo 'selected'; ?>>21</option>
						<option value="22" <?php if ($content_field->value['hour'] == '22') echo 'selected'; ?>>22</option>
						<option value="23" <?php if ($content_field->value['hour'] == '23') echo 'selected'; ?>>23</option>
					</select>
				</div>
				<div class="input-date-time-minutes">
					<select class="cs-select  pacz-select2" name="alsp-field-input-minute_<?php echo $content_field->id; ?>">
						<option value="00" <?php if ($content_field->value['minute'] == '00') echo 'selected'; ?>>00</option>
						<option value="01" <?php if ($content_field->value['minute'] == '01') echo 'selected'; ?>>01</option>
						<option value="02" <?php if ($content_field->value['minute'] == '02') echo 'selected'; ?>>02</option>
						<option value="03" <?php if ($content_field->value['minute'] == '03') echo 'selected'; ?>>03</option>
						<option value="04" <?php if ($content_field->value['minute'] == '04') echo 'selected'; ?>>04</option>
						<option value="05" <?php if ($content_field->value['minute'] == '05') echo 'selected'; ?>>05</option>
						<option value="06" <?php if ($content_field->value['minute'] == '06') echo 'selected'; ?>>06</option>
						<option value="07" <?php if ($content_field->value['minute'] == '07') echo 'selected'; ?>>07</option>
						<option value="08" <?php if ($content_field->value['minute'] == '08') echo 'selected'; ?>>08</option>
						<option value="09" <?php if ($content_field->value['minute'] == '09') echo 'selected'; ?>>09</option>
						<option value="10" <?php if ($content_field->value['minute'] == '10') echo 'selected'; ?>>10</option>
						<option value="11" <?php if ($content_field->value['minute'] == '11') echo 'selected'; ?>>11</option>
						<option value="12" <?php if ($content_field->value['minute'] == '12') echo 'selected'; ?>>12</option>
						<option value="13" <?php if ($content_field->value['minute'] == '13') echo 'selected'; ?>>13</option>
						<option value="14" <?php if ($content_field->value['minute'] == '14') echo 'selected'; ?>>14</option>
						<option value="15" <?php if ($content_field->value['minute'] == '15') echo 'selected'; ?>>15</option>
						<option value="16" <?php if ($content_field->value['minute'] == '16') echo 'selected'; ?>>16</option>
						<option value="17" <?php if ($content_field->value['minute'] == '17') echo 'selected'; ?>>17</option>
						<option value="18" <?php if ($content_field->value['minute'] == '18') echo 'selected'; ?>>18</option>
						<option value="19" <?php if ($content_field->value['minute'] == '19') echo 'selected'; ?>>19</option>
						<option value="20" <?php if ($content_field->value['minute'] == '20') echo 'selected'; ?>>20</option>
						<option value="21" <?php if ($content_field->value['minute'] == '21') echo 'selected'; ?>>21</option>
						<option value="22" <?php if ($content_field->value['minute'] == '22') echo 'selected'; ?>>22</option>
						<option value="23" <?php if ($content_field->value['minute'] == '23') echo 'selected'; ?>>23</option>
						<option value="24" <?php if ($content_field->value['minute'] == '24') echo 'selected'; ?>>24</option>
						<option value="25" <?php if ($content_field->value['minute'] == '25') echo 'selected'; ?>>25</option>
						<option value="26" <?php if ($content_field->value['minute'] == '26') echo 'selected'; ?>>26</option>
						<option value="27" <?php if ($content_field->value['minute'] == '27') echo 'selected'; ?>>27</option>
						<option value="28" <?php if ($content_field->value['minute'] == '28') echo 'selected'; ?>>28</option>
						<option value="29" <?php if ($content_field->value['minute'] == '29') echo 'selected'; ?>>29</option>
						<option value="30" <?php if ($content_field->value['minute'] == '30') echo 'selected'; ?>>30</option>
						<option value="31" <?php if ($content_field->value['minute'] == '31') echo 'selected'; ?>>31</option>
						<option value="32" <?php if ($content_field->value['minute'] == '32') echo 'selected'; ?>>32</option>
						<option value="33" <?php if ($content_field->value['minute'] == '33') echo 'selected'; ?>>33</option>
						<option value="34" <?php if ($content_field->value['minute'] == '34') echo 'selected'; ?>>34</option>
						<option value="35" <?php if ($content_field->value['minute'] == '35') echo 'selected'; ?>>35</option>
						<option value="36" <?php if ($content_field->value['minute'] == '36') echo 'selected'; ?>>36</option>
						<option value="37" <?php if ($content_field->value['minute'] == '37') echo 'selected'; ?>>37</option>
						<option value="38" <?php if ($content_field->value['minute'] == '38') echo 'selected'; ?>>38</option>
						<option value="39" <?php if ($content_field->value['minute'] == '39') echo 'selected'; ?>>39</option>
						<option value="40" <?php if ($content_field->value['minute'] == '40') echo 'selected'; ?>>40</option>
						<option value="41" <?php if ($content_field->value['minute'] == '41') echo 'selected'; ?>>41</option>
						<option value="42" <?php if ($content_field->value['minute'] == '42') echo 'selected'; ?>>42</option>
						<option value="43" <?php if ($content_field->value['minute'] == '43') echo 'selected'; ?>>43</option>
						<option value="44" <?php if ($content_field->value['minute'] == '44') echo 'selected'; ?>>44</option>
						<option value="45" <?php if ($content_field->value['minute'] == '45') echo 'selected'; ?>>45</option>
						<option value="46" <?php if ($content_field->value['minute'] == '46') echo 'selected'; ?>>46</option>
						<option value="47" <?php if ($content_field->value['minute'] == '47') echo 'selected'; ?>>47</option>
						<option value="48" <?php if ($content_field->value['minute'] == '48') echo 'selected'; ?>>48</option>
						<option value="49" <?php if ($content_field->value['minute'] == '49') echo 'selected'; ?>>49</option>
						<option value="50" <?php if ($content_field->value['minute'] == '50') echo 'selected'; ?>>50</option>
						<option value="51" <?php if ($content_field->value['minute'] == '51') echo 'selected'; ?>>51</option>
						<option value="52" <?php if ($content_field->value['minute'] == '52') echo 'selected'; ?>>52</option>
						<option value="53" <?php if ($content_field->value['minute'] == '53') echo 'selected'; ?>>53</option>
						<option value="54" <?php if ($content_field->value['minute'] == '54') echo 'selected'; ?>>54</option>
						<option value="55" <?php if ($content_field->value['minute'] == '55') echo 'selected'; ?>>55</option>
						<option value="56" <?php if ($content_field->value['minute'] == '56') echo 'selected'; ?>>56</option>
						<option value="57" <?php if ($content_field->value['minute'] == '57') echo 'selected'; ?>>57</option>
						<option value="58" <?php if ($content_field->value['minute'] == '58') echo 'selected'; ?>>58</option>
						<option value="59" <?php if ($content_field->value['minute'] == '59') echo 'selected'; ?>>59</option>
					</select>
				</div>
		</div>
		<?php endif; ?>
		<?php if ($content_field->description): ?><p class="description"><?php echo $content_field->description; ?></p><?php endif; ?>
		
		
	</div>
</div>