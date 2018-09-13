<h3>
	<?php echo apply_filters('alsp_renew_option', sprintf(__('Renew listing "%s"', 'ALSP'), $alsp_instance->current_listing->title()), $alsp_instance->current_listing); ?>
</h3>

<p><?php _e('Listing will be renewed and raised up to the top of all lists, those ordered by date.', 'ALSP'); ?></p>

<?php do_action('alsp_renew_html', $alsp_instance->current_listing); ?>

<?php if ($frontend_controller->action == 'show'): ?>
<a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'renew_listing', 'listing_id' => $alsp_instance->current_listing->post->ID, 'renew_action' => 'renew', 'referer' => urlencode($frontend_controller->referer))); ?>" class="btn btn-primary"><?php _e('Renew listing', 'ALSP'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo $frontend_controller->referer; ?>" class="btn btn-primary"><?php _e('Cancel', 'ALSP'); ?></a>
<?php elseif ($frontend_controller->action == 'renew'): ?>
<a href="<?php echo $frontend_controller->referer; ?>" class="btn btn-primary"><?php _e('Go back ', 'ALSP'); ?></a>
<?php endif; ?>