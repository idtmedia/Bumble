<?php global $ALSP_ADIMN_SETTINGS; ?>
<?php if (extension_loaded('openssl')): ?>
<script src="https://checkout.stripe.com/checkout.js"></script>
<script>
	(function($) {
		"use strict";
	function AuthorizeCheckout(){}
		$(document).ready(function()  {
			var handler = ({
				key: '<?php echo esc_js($authorize->api_login_id); ?>',
				token: function(token) {
					$('<form action="<?php echo alsp_get_edit_invoice_link($invoice->post->ID); ?>&alsp_gateway=authorize" method="POST">' + 
						'<input type="hidden" name="authorize_email" value="' + token.email + '">' +
						'<input type="hidden" name="authorize_token" value="' + token.id + '">' +
						'</form>').appendTo($(document.body)).submit();
				}
			});
			
			$('.authorize_button').click( function(e) {
				handler.open({
					name: '<?php echo esc_js(get_option('blogname')); ?>',
					description: '<?php echo esc_js($invoice->post->post_title); ?>',
					<?php $current_user = wp_get_current_user(); ?>
					email: '<?php echo esc_js($current_user->user_email); ?>',
					amount: <?php echo esc_js($invoice->taxesPrice(false)*100); ?>,
					currency: '<?php echo esc_js($ALSP_ADIMN_SETTINGS['alsp_payments_currency']); ?>' 
				});
				e.preventDefault();
			});
		});
	})(jQuery);

</script>
<div class="alsp-payment-method">
	<div class="alsp-payment-gateway-icon">
		<a class="authorize_button" href="<?php echo alsp_get_edit_invoice_link($invoice->post->ID); ?>&alsp_gateway=authorize"><?php echo $authorize->buy_button(); ?></a>
	</div>
	<a class="authorize_button" href="<?php echo alsp_get_edit_invoice_link($invoice->post->ID); ?>&alsp_gateway=authorize"><?php echo $authorize->name(); ?></a>
	<p class="description"><?php echo $authorize->description(); ?></p>
</div>
<?php else: ?>
<div class="alsp-payment-method">
	<div class="alsp-payment-gateway-icon">
		<?php echo $authorize->buy_button(); ?>
	</div>
	<div><?php echo $authorize->name(); ?></div>
	<p class="description"><?php _e('Payment by Auythorize requires installed OpenSSL extension!', 'ALSP'); ?></p>
</div>
<?php endif; ?>