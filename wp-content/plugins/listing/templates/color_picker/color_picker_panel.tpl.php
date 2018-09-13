<script>
		(function($) {
			"use strict";

			$(function() {
				<?php $align = (is_rtl() ? 'right' : 'left' ); ?>
				$(document).on('mouseenter', '.alsp-no-touch #alsp-color-picker-panel', function () {
					$('#alsp-color-picker-panel').stop().animate({<?php echo $align; ?>: "0px"}, 500);
				});
				$(document).on('mouseleave', '.alsp-no-touch #alsp-color-picker-panel', function () {
					var width = $('#alsp-color-picker-panel').width() - 50;
					$('#alsp-color-picker-panel').stop().animate({<?php echo $align; ?>: - width}, 500);
				});
	
				var panel_opened = false;
				$('html').on('click', '.alsp-touch #alsp-color-picker-panel-tools', function () {
					if (panel_opened) {
						var width = $('#alsp-color-picker-panel').width() - 50;
						$('#alsp-color-picker-panel').stop().animate({<?php echo $align; ?>: - width}, 500);
						panel_opened = false;
					} else {
						$('#alsp-color-picker-panel').stop().animate({<?php echo $align; ?>: "0px"}, 500);
						panel_opened = true;
					}
				});
			});
		})(jQuery);
	</script>
	<div id="alsp-color-picker-panel" class="alsp-content">
		<fieldset id="alsp-color-picker">
			<label><?php _e('Choose color palette:'); ?></label>
			<?php $selected_scheme = (isset($_COOKIE['alsp_compare_palettes']) ? $_COOKIE['alsp_compare_palettes'] : get_option('alsp_color_scheme')); ?>
			<?php alsp_frontendRender('color_picker/color_picker_settings.tpl.php', array('selected_scheme' => $selected_scheme)); ?>
			<label><?php printf(__('Return to the <a href="%s">backend</a>', 'ALSP'), admin_url('admin.php?page=alsp_settings#_customization')); ?></label>
		</fieldset>
		<div id="alsp-color-picker-panel-tools" class="clearfix">
			<img src="<?php echo ALSP_RESOURCES_URL . 'images/settings.png'; ?>" />
		</div>
	</div>