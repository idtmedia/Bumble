<h3>
	<?php echo sprintf(__('Delete listing "%s"', 'ALSP'), $alsp_instance->current_listing->title()); ?>
</h3>

<p><?php _e('Listing will be completely deleted with all metadata, comments and attachments.', 'ALSP'); ?></p>

<?php do_action('alsp_renew_html', $alsp_instance->current_listing); ?>

<a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'delete_listing', 'listing_id' => $alsp_instance->current_listing->post->ID, 'delete_action' => 'delete', 'referer' => urlencode($frontend_controller->referer))); ?>" class="btn btn-primary"><?php _e('Delete listing', 'ALSP'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo $frontend_controller->referer; ?>" class="btn btn-primary"><?php _e('Cancel', 'ALSP'); ?></a>