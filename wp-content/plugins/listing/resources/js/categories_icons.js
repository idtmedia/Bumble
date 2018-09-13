(function($) {
	"use strict";
	
	var category_icon_image_input, category_marker_icon_input, category_marker_icon_tag;
	
	$(function() {
		var category_icon_image_url = categories_icons.categories_icons_url;

		$(document).on("click", ".cat_select_icon_image", function() {
			category_icon_image_input = $(this).parent().find('.cat_icon_image');

			var dialog = $('<div id="select_field_icon_dialog"></div>').dialog({
				width: ($(window).width()*0.5),
				height: ($(window).height()*0.8),
				modal: true,
				resizable: false,
				draggable: false,
				title: categories_icons.ajax_dialog_title,
				open: function() {
					alsp_ajax_loader_show();
					
					$.ajax({
						type: "POST",
						url: alsp_js_objects.ajaxurl,
						data: {'action': 'alsp_select_category_icon_dialog'},
						dataType: 'html',
						success: function(response_from_the_action_function){
							if (response_from_the_action_function != 0) {
								$('#select_field_icon_dialog').html(response_from_the_action_function);
								if (category_icon_image_input.val())
									$(".alsp-icon[icon_file='"+category_icon_image_input.val()+"']").addClass("alsp-selected-icon");
							}
						},
						complete: function() {
							alsp_ajax_loader_hide();
						}
					});
					$(document).on("click", ".ui-widget-overlay", function() { $('#select_map_icon_dialog').remove(); });
				},
				close: function() {
					$('#select_field_icon_dialog').remove();
				}
			});
		});
		$(document).on("click", ".cat_alsp-icon", function() {
			$(".alsp-selected-icon").removeClass("alsp-selected-icon");
			var icon_file = $(this).attr('icon_file');
			alsp_ajax_loader_show();
			$.ajax({
				type: "POST",
				url: alsp_js_objects.ajaxurl,
				data: {'action': 'alsp_select_category_icon', 'icon_file': icon_file, 'category_id': category_icon_image_input.parent().find(".category_id").val()},
				dataType: 'html',
				success: function(response_from_the_action_function){
					if (response_from_the_action_function != 0) {
						if (category_icon_image_input) {
							category_icon_image_input.val(icon_file);
							category_icon_image_input.parent().find(".cat_icon_image_tag").attr('src', category_icon_image_url+icon_file).show();
							category_icon_image_input = false;
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
		$(document).on("click", "#cat_reset_icon", function() {
			$(".alsp-selected-icon").removeClass("alsp-selected-icon");
			alsp_ajax_loader_show();
			$.ajax({
				type: "POST",
				url: alsp_js_objects.ajaxurl,
				data: {'action': 'alsp_select_category_icon', 'category_id': category_icon_image_input.parent().find(".category_id").val()},
				dataType: 'html',
				success: function(response_from_the_action_function){
					if (category_icon_image_input) {
						category_icon_image_input.val('');
						category_icon_image_input.parent().find(".cat_icon_image_tag").attr('src', '').hide();
						category_icon_image_input = false;
					}
				},
				complete: function() {
					$('#select_field_icon_dialog').remove();
					alsp_ajax_loader_hide();
				}
			});
		});
		
		$(document).on("click", ".select_marker_icon_image", function() {
			category_marker_icon_input = $(this).parent().find('.marker_icon_image');
			category_marker_icon_tag = $(this).parent().find('.alsp-marker-icon-tag');

			var dialog = $('<div id="select_marker_icon_dialog"></div>').dialog({
				width: ($(window).width()*0.5),
				height: ($(window).height()*0.8),
				modal: true,
				resizable: false,
				draggable: false,
				title: categories_icons.ajax_marker_dialog_title,
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
								if (category_marker_icon_input.val())
									$("#"+category_marker_icon_input.val()).addClass("alsp-selected-icon");
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
			category_marker_icon_input.val($(this).attr('id'));
			alsp_ajax_loader_show();
			$.ajax({
				type: "POST",
				url: alsp_js_objects.ajaxurl,
				data: {'action': 'alsp_select_category_marker_icon', 'icon_name': category_marker_icon_input.val(), 'category_id': category_marker_icon_input.parent().find(".category_id").val()},
				dataType: 'html',
				success: function(response_from_the_action_function){
					if (response_from_the_action_function != 0) {
						if (category_marker_icon_input) {
							category_marker_icon_tag.removeClass().addClass('alsp-marker-icon-tag fa '+category_marker_icon_input.val());
							category_marker_icon_input = false;
						}
					}
				},
				complete: function() {
					$(this).addClass("alsp-selected-icon");
					$('#select_marker_icon_dialog').remove();
					alsp_ajax_loader_hide();
				}
			});
		});
		$(document).on("click", "#reset_fa_icon", function() {
			$(".alsp-selected-icon").removeClass("alsp-selected-icon");
			category_marker_icon_input.val('');
			alsp_ajax_loader_show();
			$.ajax({
				type: "POST",
				url: alsp_js_objects.ajaxurl,
				data: {'action': 'alsp_select_category_marker_icon', 'category_id': category_marker_icon_input.parent().find(".category_id").val()},
				dataType: 'html',
				success: function(response_from_the_action_function){
					if (category_marker_icon_input) {
						category_marker_icon_tag.removeClass().addClass('alsp-marker-icon-tag');
						category_marker_icon_input = false;
					}
				},
				complete: function() {
					$('#select_marker_icon_dialog').remove();
					alsp_ajax_loader_hide();
				}
			});
		});
		
		$(".marker_color").wpColorPicker();
		$(document).on('focus', '.marker_color', function(){
			var parent = $(this).parent();
            $(this).wpColorPicker()
            parent.find('.wp-color-result').click();
        }); 
		$(document).on("click", ".save_color", function() {
			var category_marker_color_input = $(this).parents(".alsp-content").find(".marker_color");
			alsp_ajax_loader_show();
			$.ajax({
				type: "POST",
				url: alsp_js_objects.ajaxurl,
				data: {'action': 'alsp_select_category_marker_color', 'color': category_marker_color_input.val(), 'category_id': category_marker_color_input.parents(".alsp-content").find(".category_id").val()},
				dataType: 'html',
				complete: function() {
					alsp_ajax_loader_hide();
				}
			});
		});
	});
	$(function() {
		var category_icon_image_url = categories_icons.categories_icons_url;
	$(document).on("click", ".select_icon_image2", function() {
			category_icon_image_input = $(this).parent().find('.icon_image2');

			var dialog = $('<div id="select_field_icon_dialog2"></div>').dialog({
				width: ($(window).width()*0.5),
				height: ($(window).height()*0.8),
				modal: true,
				resizable: false,
				draggable: false,
				title: categories_icons.ajax_dialog_title,
				open: function() {
					alsp_ajax_loader_show();
					$.ajax({
						type: "POST",
						url: alsp_js_objects.ajaxurl,
						data: {'action': 'alsp_select_category_icon_dialog2'},
						dataType: 'html',
						success: function(response_from_the_action_function){
							if (response_from_the_action_function != 0) {
								$('#select_field_icon_dialog2').html(response_from_the_action_function);
								if (category_icon_image_input.val())
									$(".alsp-icon2[icon_file='"+category_icon_image_input.val()+"']").addClass("alsp-selected-icon2");
							}
						},
						complete: function() {
							alsp_ajax_loader_hide();
						}
					});
					$(document).on("click", ".ui-widget-overlay", function() { $('#select_map_icon_dialog2').remove(); });
				},
				close: function() {
					$('#select_field_icon_dialog2').remove();
				}
			});
		});
		
		$(document).on("click", ".alsp-icon2", function() {
			
			$(".alsp-selected-icon2").removeClass("alsp-selected-icon2");
			var icon_file2 = $(this).attr('icon_file2');
			alsp_ajax_loader_show();
			$.ajax({
				type: "POST",
				url: alsp_js_objects.ajaxurl,
				data: {'action': 'alsp_select_category_icon2', 'icon_file2': icon_file2, 'category_id2': category_icon_image_input.parent().find(".category_id2").val()},
				dataType: 'html',
				success: function(response_from_the_action_function){
					if (response_from_the_action_function != 0) {
						if (category_icon_image_input) {
							category_icon_image_input.val(icon_file2);
							category_icon_image_input.parent().find(".icon_image_tag2").attr('src', category_icon_image_url+icon_file2).show();
							category_icon_image_input = false;
						}
					}
				},
				complete: function() {
					$(this).addClass("alsp-selected-icon2");
					$('#select_field_icon_dialog2').remove();
					alsp_ajax_loader_hide();
				}
			});
		});
		
		$(document).on("click", "#reset_icon2", function() {
			$(".alsp-selected-icon2").removeClass("alsp-selected-icon2");
			alsp_ajax_loader_show();
			$.ajax({
				type: "POST",
				url: alsp_js_objects.ajaxurl,
				data: {'action': 'alsp_select_category_icon2', 'category_id2': category_icon_image_input.parent().find(".category_id2").val()},
				dataType: 'html',
				success: function(response_from_the_action_function){
					if (category_icon_image_input) {
						category_icon_image_input.val('');
						category_icon_image_input.parent().find(".icon_image_tag2").attr('src', '').hide();
						category_icon_image_input = false;
					}
				},
				complete: function() {
					$('#select_field_icon_dialog2').remove();
					alsp_ajax_loader_hide();
				}
			});
		});
	});
	
})(jQuery);
