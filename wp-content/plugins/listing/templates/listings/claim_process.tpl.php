<?php alsp_frontendRender('admin_header.tpl.php'); ?>

<h2>
	<?php printf(__('Approve or decline claim of listing "%s"', 'ALSP'), $listing->title()); ?>
</h2>

<?php if ($action == 'show'): ?>
<p><?php printf(__('User "%s" had claimed this listing.', 'ALSP'), $listing->claim->claimer->display_name); ?></p>
<?php if ($listing->claim->claimer_message): ?>
<p><?php _e('Message from claimer:', 'ALSP'); ?><br /><i><?php echo $listing->claim->claimer_message; ?></i></p>
<?php endif; ?>
<p><?php _e('In case of approval new owner will receive email notification.', 'ALSP'); ?></p>

<a href="<?php echo admin_url('options.php?page=alsp_process_claim&listing_id=' . $listing->post->ID . '&claim_action=approve&referer=' . urlencode($referer)); ?>" class="button button-primary"><?php _e('Approve', 'ALSP'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo admin_url('options.php?page=alsp_process_claim&listing_id=' . $listing->post->ID . '&claim_action=decline&referer=' . urlencode($referer)); ?>" class="button button-primary"><?php _e('Decline', 'ALSP'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo $referer; ?>" class="button button-primary"><?php _e('Cancel', 'ALSP'); ?></a>
<?php elseif ($action == 'processed'): ?>
<a href="<?php echo $referer; ?>" class="button button-primary"><?php _e('Go back ', 'ALSP'); ?></a>
<?php endif; ?>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>