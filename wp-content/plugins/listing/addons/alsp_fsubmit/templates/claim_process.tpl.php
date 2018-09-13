<h3>
	<?php printf(__('Approve or decline claim of listing "%s"', 'ALSP'), $alsp_instance->current_listing->title()); ?>
</h3>

<?php if ($frontend_controller->action == 'show'): ?>
<p><?php printf(__('User "%s" had claimed this listing.', 'ALSP'), $alsp_instance->current_listing->claim->claimer->display_name); ?></p>
<?php if ($alsp_instance->current_listing->claim->claimer_message): ?>
<p><?php _e('Message from claimer:', 'ALSP'); ?><br /><i><?php echo $alsp_instance->current_listing->claim->claimer_message; ?></i></p>
<?php endif; ?>
<p><?php _e('In case of approval new owner will receive email notification.', 'ALSP'); ?></p>

<a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'process_claim', 'listing_id' => $alsp_instance->current_listing->post->ID, 'claim_action' => 'approve', 'referer' => urlencode($frontend_controller->referer))); ?>" class="btn btn-primary"><?php _e('Approve', 'ALSP'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'process_claim', 'listing_id' => $alsp_instance->current_listing->post->ID, 'claim_action' => 'decline', 'referer' => urlencode($frontend_controller->referer))); ?>" class="btn btn-primary"><?php _e('Decline', 'ALSP'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo $frontend_controller->referer; ?>" class="btn btn-primary"><?php _e('Cancel', 'ALSP'); ?></a>
<?php elseif ($frontend_controller->action == 'processed'): ?>
<a href="<?php echo $frontend_controller->referer; ?>" class="btn btn-primary"><?php _e('Go back ', 'ALSP'); ?></a>
<?php endif; ?>