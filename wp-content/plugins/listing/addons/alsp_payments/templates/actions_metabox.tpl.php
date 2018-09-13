<div id="misc-publishing-actions">
	<div class="misc-pub-section">
		<script>
			var window_width = 860;
			var window_height = 800;
			var leftPosition, topPosition;
			(function($) {
				"use strict";

			   	leftPosition = (window.screen.width / 2) - ((window_width / 2) + 10);
			   	topPosition = (window.screen.height / 2) - ((window_height / 2) + 50);
			})(jQuery);
		</script>
		<input type="button" onclick="window.open('<?php echo esc_url(add_query_arg('invoice_id', $invoice->post->ID, alsp_directoryUrl(array('alsp_action' => 'alsp_print_invoice')))); ?>', 'print_window', 'height='+window_height+',width='+window_width+',left='+leftPosition+',top='+topPosition+',menubar=yes,scrollbars=yes');" class="button button-primary" value="<?php esc_attr_e('Print invoice', 'ALSP'); ?>" />
	</div>

	<?php if ($invoice->gateway): ?>
	<div class="misc-pub-section">
		<a class="button button-secondary" href="<?php echo esc_url(add_query_arg('invoice_action', 'reset_gateway', alsp_get_edit_invoice_link($invoice->post->ID))); ?>"><?php _e('Reset gateway', 'ALSP'); ?></a>
	</div>
	<?php endif; ?>

	<?php if (current_user_can('edit_others_posts')): ?>
	<div class="misc-pub-section">
		<a class="button button-secondary" href="<?php echo esc_url(add_query_arg('invoice_action', 'set_paid', alsp_get_edit_invoice_link($invoice->post->ID))); ?>"><?php _e('Set as paid', 'ALSP'); ?></a>
	</div>
	<?php endif; ?>
</div>