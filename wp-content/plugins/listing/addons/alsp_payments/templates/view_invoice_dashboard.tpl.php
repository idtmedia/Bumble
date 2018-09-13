<?php global $ALSP_ADIMN_SETTINGS; ?>
<div class="alsp-directory-frontpanel">
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
			<input type="button" class="alsp-print-listing-link btn btn-primary" onclick="window.open('<?php echo esc_url(add_query_arg('invoice_id', $frontend_controller->invoice->post->ID, alsp_directoryUrl(array('alsp_action' => 'alsp_print_invoice')))); ?>', 'print_window', 'height='+window_height+',width='+window_width+',left='+leftPosition+',top='+topPosition+',menubar=yes,scrollbars=yes');" value="<?php esc_attr_e('Print invoice', 'ALSP'); ?>" />
			
			<?php if ($frontend_controller->invoice->gateway): ?>
			<input type="button" class="alsp-reset-link btn btn-primary" onclick="window.location='<?php echo esc_url(add_query_arg('invoice_action', 'reset_gateway', alsp_get_edit_invoice_link($frontend_controller->invoice->post->ID))); ?>';" value="<?php esc_attr_e('Reset gateway', 'ALSP'); ?>" />
			<?php endif; ?>
		</div>
		
		<div class="alsp-submit-section">
			<h3 class="alsp-submit-section-label"><?php _e('Invoice Info', 'ALSP'); ?></h3>
			<div class="alsp-submit-section-inside">
				<?php alsp_frontendRender(array(ALSP_PAYMENTS_TEMPLATES_PATH, 'info_metabox.tpl.php'), array('invoice' => $frontend_controller->invoice)); ?>
			</div>
		</div>

		<?php if (($ALSP_ADIMN_SETTINGS['alsp_paypal_email'] || $ALSP_ADIMN_SETTINGS['alsp_allow_bank'] || (($ALSP_ADIMN_SETTINGS['alsp_stripe_test'] && $ALSP_ADIMN_SETTINGS['alsp_stripe_test_secret'] && $ALSP_ADIMN_SETTINGS['alsp_stripe_test_public']) || ($ALSP_ADIMN_SETTINGS['alsp_stripe_live_secret'] && $ALSP_ADIMN_SETTINGS['alsp_stripe_live_public'])) || (($ALSP_ADIMN_SETTINGS['alsp_authorize_test'] && $ALSP_ADIMN_SETTINGS['alsp_authorize_test_loginid'] && $ALSP_ADIMN_SETTINGS['alsp_authorize_test_transactionid']) || ($ALSP_ADIMN_SETTINGS['alsp_authorize_live_loginid'] && $ALSP_ADIMN_SETTINGS['alsp_authorize_live_transactionid']))) && $frontend_controller->invoice->status == 'unpaid' && !$frontend_controller->invoice->gateway): ?>
		<div class="alsp-submit-section">
			<h3 class="alsp-submit-section-label"><?php _e('Invoice Payment - choose payment gateway', 'ALSP'); ?></h3>
			<div class="alsp-submit-section-inside">
				<?php alsp_frontendRender(array(ALSP_PAYMENTS_TEMPLATES_PATH, 'payment_metabox.tpl.php'), array('invoice' => $frontend_controller->invoice, 'paypal' => $frontend_controller->paypal, 'paypal_subscription' => $frontend_controller->paypal_subscription, 'bank_transfer' => $frontend_controller->bank_transfer, 'stripe' => $frontend_controller->stripe)); ?>
			</div>
		</div>
		<?php endif; ?>

		<div class="alsp-submit-section">
			<h3 class="alsp-submit-section-label"><?php _e('Invoice Log', 'ALSP'); ?></h3>
			<div class="alsp-submit-section-inside">
				<?php alsp_frontendRender(array(ALSP_PAYMENTS_TEMPLATES_PATH, 'log_metabox.tpl.php'), array('invoice' => $frontend_controller->invoice)); ?>
			</div>
		</div>

		<a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'invoices')); ?>" class="btn btn-primary"><?php _e('View all invoices', 'ALSP'); ?></a>