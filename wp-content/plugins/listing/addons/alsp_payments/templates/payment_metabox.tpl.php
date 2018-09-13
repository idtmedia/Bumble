<?php global $wp_rewrite, $ALSP_ADIMN_SETTINGS; ?>
<?php if ($ALSP_ADIMN_SETTINGS['alsp_paypal_email'] && $wp_rewrite->using_permalinks()): ?>
<?php if ($ALSP_ADIMN_SETTINGS['alsp_paypal_single']): ?>
<div class="alsp-payment-method">
	<div class="alsp-payment-gateway-icon">
		<a href="<?php echo alsp_get_edit_invoice_link($invoice->post->ID); ?>&alsp_gateway=paypal"><?php echo $paypal->buy_button(); ?></a>
	</div>
	<a href="<?php echo alsp_get_edit_invoice_link($invoice->post->ID); ?>&alsp_gateway=paypal"><?php echo $paypal->name(); ?></a>
	<p class="description"><?php echo $paypal->description(); ?></p>
</div>
<?php endif; ?>
<?php if ($ALSP_ADIMN_SETTINGS['alsp_paypal_subscriptions'] && $invoice->is_subscription): ?>
<div class="alsp-payment-method">
	<div class="alsp-payment-gateway-icon">
		<a href="<?php echo alsp_get_edit_invoice_link($invoice->post->ID); ?>&alsp_gateway=paypal_subscription"><?php echo $paypal_subscription->buy_button(); ?></a>
	</div>
	<a href="<?php echo alsp_get_edit_invoice_link($invoice->post->ID); ?>&alsp_gateway=paypal_subscription"><?php echo $paypal_subscription->name(); ?></a>
	<p class="description"><?php echo $paypal_subscription->description(); ?></p>
</div>
<?php endif; ?>
<?php endif; ?>

<?php if (($ALSP_ADIMN_SETTINGS['alsp_stripe_test'] && $ALSP_ADIMN_SETTINGS['alsp_stripe_test_secret'] && $ALSP_ADIMN_SETTINGS['alsp_stripe_test_public']) || ($ALSP_ADIMN_SETTINGS['alsp_stripe_live_secret'] && $ALSP_ADIMN_SETTINGS['alsp_stripe_live_public'])): ?>
<?php alsp_frontendRender(array(ALSP_PAYMENTS_PATH, 'templates/stripe_button.tpl.php'), array('stripe' => $stripe, 'invoice' => $invoice)); ?>
<?php endif; ?>

<?php if ($ALSP_ADIMN_SETTINGS['alsp_allow_bank']): ?>
<div class="alsp-payment-method">
	<div class="alsp-payment-gateway-icon">
		<a href="<?php echo alsp_get_edit_invoice_link($invoice->post->ID); ?>&alsp_gateway=bank_transfer"><?php echo $bank_transfer->buy_button(); ?></a>
	</div>
	<a href="<?php echo alsp_get_edit_invoice_link($invoice->post->ID); ?>&alsp_gateway=bank_transfer"><?php echo $bank_transfer->name(); ?></a>
	<p class="description"><?php echo $bank_transfer->description(); ?></p>
</div>
<?php endif; ?>
<div class="clear_float"></div>