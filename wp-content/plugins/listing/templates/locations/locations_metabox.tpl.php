<?php global $ALSP_ADIMN_SETTINGS; ?>

<script>
	(function($) {
		"use strict";
	
		$(function() {
			var locations_number = <?php echo $listing->level->locations_number; ?>;
	
			<?php if ($listing->level->google_map && $listing->level->google_map_markers): ?>
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_map_markers_type'] == 'images'): ?>
				var map_icon_file_input;
				$(document).on("click", ".select_map_icon", function() {
					map_icon_file_input = $(this).parents(".alsp-location-input").find('.alsp-map-icon-file');
		
					var dialog = $('<div id="select_map_icon_dialog">').dialog({
						width: ($(window).width()*0.5),
						height: ($(window).height()*0.8),
						modal: true,
						resizable: false,
						draggable: false,
						title: '<?php echo esc_js(__('Select map marker icon', 'ALSP')); ?>',
						open: function() {
							alsp_ajax_loader_show();
							$.ajax({
								type: "POST",
								url: alsp_js_objects.ajaxurl,
								data: {'action': 'alsp_select_map_icon'},
								dataType: 'html',
								success: function(response_from_the_action_function){
									if (response_from_the_action_function != 0) {
										$('#select_map_icon_dialog').html(response_from_the_action_function);
										if (map_icon_file_input.val())
											$(".alsp-map-icon[icon_file='"+map_icon_file_input.val()+"']").addClass("alsp-selected-icon");
									}
								},
								complete: function() {
									alsp_ajax_loader_hide();
								}
							});
							$(document).on("click", ".ui-widget-overlay", function() { $('#select_map_icon_dialog').remove(); });
						},
						close: function() {
							$('#select_map_icon_dialog').remove();
						}
					});
				});
				$(document).on("click", ".alsp-map-icon", function() {
					$(".alsp-selected-icon").removeClass("alsp-selected-icon");
					
					if (map_icon_file_input) {
						map_icon_file_input.val($(this).attr('icon_file'));
						map_icon_file_input = false;
						$(this).addClass("alsp-selected-icon");
						$('#select_map_icon_dialog').remove();
						alsp_generateMap_backend();
					}
				});
				$(document).on("click", "#reset_icon", function() {
					if (map_icon_file_input) {
						$(".alsp-selected-icon").removeClass("alsp-selected-icon");
						map_icon_file_input.val('');
						map_icon_file_input = false;
						$('#select_map_icon_dialog').remove();
						alsp_generateMap_backend();
					}
				});
			<?php else: ?>
				var map_icon_file_input;
				$(document).on("click", ".select_map_icon", function() {
					map_icon_file_input = $(this).parents(".alsp-location-input").find('.alsp-map-icon-file');
					// modified: please use span instead of div in below line
					var dialog = $('<span id="select_marker_icon_dialog"></span>').dialog({
						width: ($(window).width()*0.5),
						height: ($(window).height()*0.8),
						modal: true,
						resizable: false,
						draggable: false,
						title: '<?php echo esc_js(__('Select map marker icon', 'ALSP') . (($ALSP_ADIMN_SETTINGS['alsp_map_markers_type'] == 'icons') ? __(' (icon and color may depend on selected categories)', 'ALSP') : '')); ?>',
						open: function() {
							alsp_ajax_loader_show();
							$.ajax({
								type: "POST",
								url: alsp_js_objects.ajaxurl,
								data: {'action': 'alsp_select_field_icon'},
								dataType: 'html',
								success: function(response_from_the_action_function){
									if (response_from_the_action_function != 0) {
										$('#select_marker_icon_dialog').html(response_from_the_action_function);
										if (map_icon_file_input.val())
											$("#"+map_icon_file_input.val()).addClass("alsp-selected-icon");
									}
								},
								complete: function() {
									alsp_ajax_loader_hide();
								}
							});
							$(document).on("click", ".ui-widget-overlay", function() { $('#select_marker_icon_dialog').remove(); });
						},
						close: function() {
							$('#select_field_icon_dialog').remove();
						}
					});
				});
				$(document).on("click", ".fa-icon", function() {
					$(".alsp-selected-icon").removeClass("alsp-selected-icon");
					if (map_icon_file_input) {
						map_icon_file_input.val($(this).attr('id'));
						map_icon_file_input = false;
						$(this).addClass("alsp-selected-icon");
						$('#select_marker_icon_dialog').remove();
						alsp_generateMap_backend();
					}
				});
				$(document).on("click", "#reset_fa_icon", function() {
					if (map_icon_file_input) {
						$(".alsp-selected-icon").removeClass("alsp-selected-icon");
						map_icon_file_input.val('');
						map_icon_file_input = false;
						$('#select_marker_icon_dialog').remove();
						alsp_generateMap_backend();
					}
				});
			<?php endif; ?>
			<?php endif; ?>
			
			$(".add_address").click(function() {
				alsp_ajax_loader_show();
				$.ajax({
					type: "POST",
					url: alsp_js_objects.ajaxurl,
					data: {'action': 'alsp_add_location_in_metabox', 'post_id': <?php echo $listing->post->ID; ?>},
					success: function(response_from_the_action_function){
						if (response_from_the_action_function != 0) {
							$("#alsp-locations-wrapper").append(response_from_the_action_function);
							$(".delete_location").show();
							if (locations_number == $(".alsp-location-in-metabox-wrap").length)
								$(".add_address").hide();
							alsp_setupAutocomplete();
						}
					},
					complete: function() {
						alsp_ajax_loader_hide();
					}
				});
			});
			$(document).on("click", ".delete_location", function() {
				$(this).parents(".alsp-location-in-metabox-wrap").remove();
				if ($(".alsp-location-in-metabox-wrap").length == 1)
					$(".delete_location").hide();
	
				<?php if ($listing->level->google_map): ?>
				alsp_generateMap_backend();
				<?php endif; ?>
	
				if (locations_number > $(".alsp-location-in-metabox-wrap").length)
					$(".add_address").show();
			});
	
			$(document).on("click", ".alsp-manual-coords", function() {
	        	if ($(this).is(":checked"))
	        		$(this).parents(".alsp-manual-coords-wrapper").find(".alsp-manual-coords-block").show(200);
	        	else
	        		$(this).parents(".alsp-manual-coords-wrapper").find(".alsp-manual-coords-block").hide(200);
	        });
	
	        if (locations_number > $(".alsp-location-in-metabox-wrap").length)
				$(".add_address").show();
		});
	})(jQuery);
</script>

<div class="alsp-locations-metabox">
	<div id="alsp-locations-wrapper" class="form-horizontal">
		<?php
		 $uID = rand(1, 10000);
		if ($listing->locations)
			foreach ($listing->locations AS $location)
				alsp_frontendRender('locations/locations_in_metabox.tpl.php', array('listing' => $listing, 'location' => $location, 'locations_levels' => $locations_levels, 'delete_location_link' => (count($listing->locations) > 1) ? true : false));
		else
			alsp_frontendRender('locations/locations_in_metabox.tpl.php', array('listing' => $listing, 'location' => new alsp_location, 'locations_levels' => $locations_levels, 'delete_location_link' => false));
		?>
	</div>
	<?php if ($listing->level->locations_number > 1): ?>
		<div class="add-address-btn">	
			<?php echo '<a class="add_address" style="display: none;" href="javascript:void(0);" title="'. __('Add address', 'ALSP').'" ><i class="pacz-icon-plus-circle"></i></a>'; ?>
		</div>
	<?php endif; ?>
	<?php if ($listing->level->google_map): ?>
		<div class="alsp-maps-canvas-wrap">
			
				<div class="generate-map-btn">
					<input type="hidden" name="map_zoom" class="alsp-map-zoom" value="<?php echo $listing->map_zoom; ?>" />
					<input type="button" class="generate-on-map" onClick="alsp_generateMap_backend(); return false;" value="<?php esc_attr_e('Generate map', 'ALSP'); ?>" />
				</div>
			
		
		<div class="alsp-maps-canvas" id="alsp-maps-canvas" style="width: auto; height: 450px;"></div>
	</div>
	<?php endif;?>
</div>