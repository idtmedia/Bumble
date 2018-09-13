(function($) {
	"use strict";
	
	var location_icon_image_input;
	
	$(function() {
		var location_icon_image_url = locations_icons.locations_icons_url;

		$(document).on("click", ".select_icon_image", function() {
			location_icon_image_input = $(this).parent().find('.icon_image');

			var dialog = $('<div id="select_field_icon_dialog"></div>').dialog({
				width: ($(window).width()*0.5),
				height: ($(window).height()*0.8),
				modal: true,
				resizable: false,
				draggable: false,
				title: locations_icons.ajax_dialog_title,
				open: function() {
					alsp_ajax_loader_show();
					$.ajax({
						type: "POST",
						url: alsp_js_objects.ajaxurl,
						data: {'action': 'alsp_select_location_icon_dialog'},
						dataType: 'html',
						success: function(response_from_the_action_function){
							if (response_from_the_action_function != 0) {
								$('#select_field_icon_dialog').html(response_from_the_action_function);
								if (location_icon_image_input.val())
									$(".alsp-map-icon[icon_file='"+location_icon_image_input.val()+"']").addClass("alsp-selected-icon");
							}
						},
						complete: function() {
							alsp_ajax_loader_hide();
						}
					});
					$(document).on("click", ".ui-widget-overlay", function() { $('#select_field_icon_dialog').remove(); });
				},
				close: function() {
					$('#select_field_icon_dialog').remove();
				}
			});
		});
		$(document).on("click", ".alsp-map-icon", function() {
			location_icon_image_input = $(this).parent().find('.icon_image');
			$(".alsp-selected-icon").removeClass("alsp-selected-icon");
			var icon_file = $(this).attr('icon_file');
			alsp_ajax_loader_show();
			$.ajax({
				type: "POST",
				url: alsp_js_objects.ajaxurl,
				data: {'action': 'alsp_select_location_icon', 'icon_file': icon_file, 'location_id': location_icon_image_input.parent().find(".location_id").val()},
				dataType: 'html',
				success: function(response_from_the_action_function){
					if (response_from_the_action_function != 0) {
						if (location_icon_image_input) {
							location_icon_image_input.val(icon_file);
							location_icon_image_input.parent().find(".icon_image_tag").attr('src', location_icon_image_url+icon_file).show();
							location_icon_image_input = false;
						}
					}
				},
				complete: function() {
					$(this).addClass("alsp-selected-icon");
					$('#select_field_icon_dialog').remove();
					alsp_ajax_loader_hide();
				}
			});
		});
		$(document).on("click", "#reset_icon", function() {
			$(".alsp-selected-icon").removeClass("alsp-selected-icon");
			alsp_ajax_loader_show();
			$.ajax({
				type: "POST",
				url: alsp_js_objects.ajaxurl,
				data: {'action': 'alsp_select_location_icon', 'location_id': location_icon_image_input.parent().find(".location_id").val()},
				dataType: 'html',
				success: function(response_from_the_action_function){
					if (location_icon_image_input) {
						location_icon_image_input.val('');
						location_icon_image_input.parent().find(".icon_image_tag").attr('src', '').hide();
						location_icon_image_input = false;
					}
				},
				complete: function() {
					$('#select_field_icon_dialog').remove();
					alsp_ajax_loader_hide();
				}
			});
		});
	});
})(jQuery);