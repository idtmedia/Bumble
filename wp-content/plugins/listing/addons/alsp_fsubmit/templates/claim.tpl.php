<?php global $ALSP_ADIMN_SETTINGS; ?>

<h3>
	<?php echo apply_filters('alsp_claim_option', sprintf(__('Claim listing "%s"', 'ALSP'), $alsp_instance->current_listing->title()), $alsp_instance->current_listing); ?>
</h3>
<?php if ($frontend_controller->action == 'show'): ?>
<?php if ($ALSP_ADIMN_SETTINGS['alsp_claim_approval']): ?>
<p><?php _e('Notification about claim for this listing will be sent to the current listing owner.', 'ALSP'); ?></p>
<p><?php esc_attr_e("After approval you will become owner of this listing, you'll receive email notification.", 'ALSP'); ?></p>
<?php endif; ?>
<?php if ($ALSP_ADIMN_SETTINGS['alsp_after_claim'] == 'expired'): ?>
<p><?php echo __('After approval listing status become expired.', 'ALSP') . (($ALSP_ADIMN_SETTINGS['alsp_payments_addon'] == 'alsp_buitin_payment') ? apply_filters('alsp_renew_option', __(' The price for renewal', 'ALSP'), $alsp_instance->current_listing) : ''); ?></p>
<?php endif; ?>

<?php do_action('alsp_claim_html', $alsp_instance->current_listing); ?>

<form method="post" action="<?php echo alsp_dashboardUrl(array('alsp_action' => 'claim_listing', 'listing_id' => $alsp_instance->current_listing->post->ID, 'claim_action' => 'claim')); ?>">
	<input type="hidden" name="referer" value="<?php echo $frontend_controller->referer; ?>" />
	<div class="form-group row">
		<div class="col-md-12">
			<textarea name="claim_message" class="form-control" rows="5"></textarea>
			<p class="description"><?php _e('additional information to moderator', 'ALSP'); ?></p>
		</div>
	</div>
	<input type="submit" class="btn btn-primary" value="<?php esc_attr_e('Send Claim', 'ALSP'); ?>"></input>
	&nbsp;&nbsp;&nbsp;
	<a href="<?php echo $frontend_controller->referer; ?>" class="btn btn-primary"><?php _e('Cancel', 'ALSP'); ?></a>
</form>
<?php elseif ($frontend_controller->action == 'claim'): ?>
<a href="<?php echo $frontend_controller->referer; ?>" class="btn btn-primary"><?php _e('Go back ', 'ALSP'); ?></a>
<?php endif; ?>