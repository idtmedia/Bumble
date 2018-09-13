

	jQuery(document).ready(function() {

		pacz_social_network_widgets();
		pacz_color_picker();
		pacz_social_networks_custom_skin();

	});


	function pacz_social_network_widgets() {

		jQuery('.social_icon_select_sites').live('change', function() {
			var wrap = jQuery(this).closest('p').siblings('.social_icon_wrap');
			wrap.children('p').hide();
			jQuery('option:selected', this).each(function() {
				wrap.find('.social_icon_' + this.value).show();
			});
		});
		jQuery('.social_icon_custom_count').live('change', function() {

			var wrap = jQuery(this).closest('p').siblings('.social_custom_icon_wrap');
			wrap.children('div').hide();
			var count = jQuery(this).val();
			for (var i = 1; i <= count; i++) {
				wrap.find('.social_icon_custom_' + i).show();
			}
		});
	}


	function pacz_color_picker() {

		var $ = jQuery;

		Color.prototype.toString = function() {
			if (this._alpha < 1) {
				return this.toCSS('rgba', this._alpha).replace(/\s+/g, '');
			}
			var hex = parseInt(this._color, 10).toString(16);
			if (this.error)
				return '';
			if (hex.length < 6) {
				for (var i = 6 - hex.length - 1; i >= 0; i--) {
					hex = '0' + hex;
				}
			}
			return '#' + hex;
		};
		$('.color-picker-holder .color-picker').each(function() {
			var $control = $(this);

/*			if (!$control.hasClass('pickerStarted')) {*/

				var value = $control.val().replace(/\s+/g, ''),
					alpha_val = 100,
					$alpha, $alpha_output;
				if (value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)) {
					alpha_val = parseFloat(value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)[1]) * 100;
				}
				$control.wpColorPicker({
					clear: function(event, ui) {
						$alpha.val(100);
						$alpha_output.val(100 + '%');
					}
				});
				$('<div class="vc_alpha-container">' + '<label>Alpha: <output class="rangevalue">' + alpha_val + '%</output></label>' + '<input type="range" min="1" max="100" value="' + alpha_val + '" name="alpha" class="vc_alpha-field">' + '</div>').appendTo($control.parents('.wp-picker-container:first').addClass('vc_color-picker').find('.iris-picker'));
				$alpha = $control.parents('.wp-picker-container:first').find('.vc_alpha-field');
				$alpha_output = $control.parents('.wp-picker-container:first').find('.vc_alpha-container output')
				$alpha.bind('change keyup', function() {
					var alpha_val = parseFloat($alpha.val()),
						iris = $control.data('a8cIris'),
						color_picker = $control.data('wpWpColorPicker');
					$alpha_output.val($alpha.val() + '%');
					iris._color._alpha = alpha_val / 100.0;
					$control.val(iris._color.toString());
					color_picker.toggler.css({
						backgroundColor: $control.val()
					});
				}).val(alpha_val).trigger('change');

			/*	$control.addClass('pickerStarted');
			}*/
		});
	}

	function pacz_social_networks_custom_skin() {

			jQuery('.social-network-select-skin').live('change', function() {
				var $container = jQuery(this).parent('p').siblings('#pacz-social-custom-skin');
				if(jQuery(this).val() == 'custom') {
					$container.show();
				} else {
					$container.hide();
				}

			}).change();
		}