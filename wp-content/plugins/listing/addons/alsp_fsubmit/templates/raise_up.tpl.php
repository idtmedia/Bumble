<h3>
	<?php echo apply_filters('alsp_raiseup_option', sprintf(__('Raise up listing "%s"', 'ALSP'), $alsp_instance->current_listing->title()), $alsp_instance->current_listing); ?>
</h3>

<p><?php _e('Listing will be raised up to the top of all lists, those ordered by date.', 'ALSP'); ?></p>
<p><?php _e('Note, that listing will not stick on top, so new listings and other listings, those were raised up later, will place higher.', 'ALSP'); ?></p>
<?php //echo do_shortcode('[add_to_cart id="2802"]'); ?>
<?php do_action('alsp_raise_up_html', $alsp_instance->current_listing); ?>

<?php if ($frontend_controller->action == 'show'): ?>
<a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'raiseup_listing', 'listing_id' => $alsp_instance->current_listing->post->ID, 'raiseup_action' => 'raiseup', 'referer' => urlencode($frontend_controller->referer))); ?>" class="btn btn-primary"><?php _e('Raise up', 'ALSP'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo $frontend_controller->referer; ?>" class="btn btn-primary"><?php _e('Cancel', 'ALSP'); ?></a>
<?php elseif ($frontend_controller->action == 'raiseup'): ?>
<a href="<?php echo $frontend_controller->referer; ?>" class="btn btn-primary"><?php _e('Go back ', 'ALSP'); ?></a>
<?php endif; ?>