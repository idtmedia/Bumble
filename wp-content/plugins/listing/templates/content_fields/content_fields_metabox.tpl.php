<script>
	(function($) {
		"use strict";
	
		$(function() {
			var fields_in_categories = new Array();
	<?php
	foreach ($content_fields AS $content_field): 
		if (!$content_field->is_core_field)
			if (!$content_field->isCategories() || $content_field->categories === array()) { ?>
				fields_in_categories[<?php echo $content_field->id?>] = [];
		<?php } else { ?>
				fields_in_categories[<?php echo $content_field->id?>] = [<?php echo implode(',', $content_field->categories); ?>];
		<?php } ?>
	<?php endforeach; ?>
	
			hideShowFields();
	
			$("input[name=tax_input\\[alsp-category\\]\\[\\]]").change(function() {hideShowFields()});
			$("#alsp-category-pop input[type=checkbox]").change(function() {hideShowFields()});
	
			function hideShowFields() {
				var selected_categories_ids = [];
				$.each($("input[name=tax_input\\[alsp-category\\]\\[\\]]:checked"), function() {
					selected_categories_ids.push($(this).val());
				});
	
				$(".alsp-field-input-block").hide();
				$.each(fields_in_categories, function(index, value) {
					var show_field = false;
					if (value != undefined) {
						if (value.length > 0) {
							var key;
							for (key in value) {
								var key2;
								for (key2 in selected_categories_ids)
									if (value[key] == selected_categories_ids[key2])
										show_field = true;
							}
						}
	
						if ((value.length == 0 || show_field) && $(".alsp-field-input-block-"+index).length)
							$(".alsp-field-input-block-"+index).show();
					}
				});
			}
		});
	})(jQuery);
</script>

<div class="clearfix">
	<div class="col-md-12 alsp-content-fields-metabox form-horizontal cz-form-meta">
		<div class="row">
			<p class="col-md-12 alsp-description-big"><?php _e('Content fields may be dependent on selected categories', 'ALSP'); ?></p>
			<?php
			foreach ($content_fields AS $content_field) {
			    if($content_field->slug !="raised_up_date"){ // ThangNN: Hide this field from job posting
                    if (!$content_field->is_core_field)
                        $content_field->renderInput();
                }

			}
			?>
		</div>
	</div>
</div>