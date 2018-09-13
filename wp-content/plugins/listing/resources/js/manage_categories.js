(function($) {
	"use strict";
	
	$(function() {
		if (level_categories.level_categories_array.length > 0)
			removeUnnecessaryCategories();
	
		function removeUnnecessaryCategories() {
			$('ul.alsp-categorychecklist li').each(function(i) {
				if ($(this).find('>ul>li').length > 0) {
					if ($.inArray($(this).find('>label>input[type="checkbox"]').val(), level_categories.level_categories_array) == -1) {
						$(this).find('>label>input[type="checkbox"]').attr('disabled', 'disabled');
						var passed = false;
						$(this).find('>ul>li>label>input[type="checkbox"]').each(function() {
							if ($.inArray($(this).val(), level_categories.level_categories_array) != -1) {
								passed = true;
							}
						});
						if (!passed) {
							$(this).remove();
							removeUnnecessaryCategories();
							return false;
						}
					}
				} else if ($.inArray($(this).find('>label>input[type="checkbox"]').val(), level_categories.level_categories_array) == -1) {
					$(this).remove();
					removeUnnecessaryCategories();
					return false;
				}
			});
			$("ul.alsp-categorychecklist ul.children").filter( function() {
			    return $.trim($(this).html()) == '';
			}).remove()
		}
		
		$('ul.alsp-categorychecklist li').each(function() {
			if ($(this).children('ul').length > 0) {
				$(this).addClass('parent');
				$(this).prepend('<span class="alsp-category-parent"></span>');
				if ($(this).find('ul input[type="checkbox"]:checked').length > 0)
					$(this).find('.alsp-category-parent').prepend('<span class="alsp-category-has-checked"></span>');
			} else
				$(this).prepend('<span class="alsp-category-empty"></span>');
		});
		$('ul.alsp-categorychecklist li ul').each(function() {
			$(this).hide();
		});
		$('ul.alsp-categorychecklist li.parent > .alsp-category-parent').click(function() {
			$(this).parent().toggleClass('active');
			$(this).parent().children('ul').slideToggle('fast');
		});
		$('ul.alsp-categorychecklist li input[type="checkbox"]').change(function() {
			$('ul.alsp-categorychecklist li').each(function() {
				if ($(this).children('ul').length > 0) {
					if ($(this).find('ul input[type="checkbox"]:checked').length > 0) {
						$(this).find('.alsp-parent-cat input').attr("checked", "checked");
						if ($(this).find('.alsp-category-parent .alsp-category-has-checked').length == 0){
							$(this).find('.alsp-category-parent').prepend('<span class="alsp-category-has-checked"></span>');
						}
					} else
							$(this).find('.alsp-category-parent .alsp-category-has-checked').remove();
				}
			});
		});
		
		$("input[name=tax_input\\[alsp-category\\]\\[\\]]").change(function() {alsp_manageCategories($(this))});
		$("#alsp-category-pop input[type=checkbox]").change(function() {alsp_manageCategories($(this))});
		
		function alsp_manageCategories(checked_object) {
			if (checked_object.is(":checked") && level_categories.level_categories_number != 'unlimited') {
				if ($("input[name=tax_input\\[alsp-category\\]\\[\\]]:checked").length > level_categories.level_categories_number) {
					alert(level_categories.level_categories_notice_number);
					$("#in-alsp-category-"+checked_object.val()).attr("checked", false);
					$("#in-popular-alsp-category-"+checked_object.val()).attr("checked", false);
				}
			}
	
			if (checked_object.is(":checked") && level_categories.level_categories_array.length > 0) {
				var result = false;
				if ($.inArray(checked_object.val(), level_categories.level_categories_array) == -1) {
					alert(level_categories.level_categories_notice_disallowed);
					$("#in-alsp-category-"+checked_object.val()).attr("checked", false);
					$("#in-popular-alsp-category-"+checked_object.val()).attr("checked", false);
					checked_object.trigger("change");
				} else
					return true;
			} else
				return true;
		}
		
		$(".alsp-expand-terms").click(function() {
			$('ul.alsp-categorychecklist li.parent').each(function() {
				$(this).addClass('active');
				$(this).children('ul').slideDown('fast');
			});
		});
		$(".alsp-collapse-terms").click(function() {
			$('ul.alsp-categorychecklist li.parent').each(function() {
				$(this).removeClass('active');
				$(this).children('ul').slideUp('fast');
			});
		});
	});
})(jQuery);
