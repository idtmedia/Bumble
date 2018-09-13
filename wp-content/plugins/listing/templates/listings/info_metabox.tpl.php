<?php global $ALSP_ADIMN_SETTINGS; ?>

<div id="misc-publishing-actions">
	<div class="misc-pub-section">
		<label for="post_level"><?php _e('Listing level', 'ALSP'); ?>:</label>
		<span id="post-level-display">
			<?php
			if ($listing->listing_created && $listing->level->isUpgradable())
					echo '<a href="' . admin_url('options.php?page=alsp_upgrade&listing_id=' . $listing->post->ID) . '">';
			else
				echo '<b>'; ?>
			<?php echo apply_filters('alsp_create_option', $listing->level->name, $listing); ?>
			<?php
			if ($listing->listing_created && $listing->level->isUpgradable())
				echo '</a>';
			else
				echo '</b>'; ?>
		</span>
	</div>

	<?php if ($listing->listing_created): ?>
	<div class="misc-pub-section">
		<label for="post_level"><?php _e('Listing status', 'ALSP'); ?>:</label>
		<span id="post-level-display">
			<?php if ($listing->status == 'active'): ?>
			<span class="alsp-badge alsp-listing-status-active"><?php _e('active', 'ALSP'); ?></span>
			<?php elseif ($listing->status == 'expired'): ?>
			<span class="alsp-badge alsp-listing-status-expired"><?php _e('expired', 'ALSP'); ?></span><br />
			<a href="<?php echo admin_url('options.php?page=alsp_renew&listing_id=' . $listing->post->ID); ?>"><img src="<?php echo ALSP_RESOURCES_URL; ?>images/page_refresh.png" class="alsp-field-icon" /><?php echo apply_filters('alsp_renew_option', __('renew listing', 'ALSP'), $listing); ?></a>
			<?php elseif ($listing->status == 'unpaid'): ?>
			<span class="alsp-badge alsp-listing-status-unpaid"><?php _e('unpaid ', 'ALSP'); ?></span>
			<?php elseif ($listing->status == 'stopped'): ?>
			<span class="alsp-badge alsp-listing-status-stopped"><?php _e('stopped', 'ALSP'); ?></span>
			<?php endif;?>
			<?php do_action('alsp_listing_status_option', $listing); ?>
		</span>
	</div>

	<?php if ($ALSP_ADIMN_SETTINGS['alsp_enable_stats']): ?>
	<div class="misc-pub-section">
		<label for="post_level"><?php echo sprintf(__('Total clicks: %d', 'ALSP'), (get_post_meta($alsp_instance->current_listing->post->ID, '_total_clicks', true) ? get_post_meta($alsp_instance->current_listing->post->ID, '_total_clicks', true) : 0)); ?></label>
	</div>
	<?php endif; ?>

	<div class="misc-pub-section curtime">
		<span id="timestamp">
			<?php _e('Order date', 'ALSP'); ?>:
			<b><?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), intval($listing->order_date)); ?></b>
			<?php if ($listing->level->raiseup_enabled && $listing->status == 'active'): ?>
			<br />
			<a href="<?php echo admin_url('options.php?page=alsp_raise_up&listing_id=' . $listing->post->ID); ?>"><img src="<?php echo ALSP_RESOURCES_URL; ?>images/raise_up.png" class="alsp-field-icon" /><?php echo apply_filters('alsp_raiseup_option', __('raise up listing', 'ALSP'), $listing); ?></a>
			<?php endif; ?>
		</span>
	</div>

	<?php if ($listing->level->eternal_active_period || $listing->expiration_date): ?>
	<div class="misc-pub-section curtime">
		<span id="timestamp">
			<?php _e('Expiry on', 'ALSP'); ?>:
			<?php if ($listing->level->eternal_active_period): ?>
			<b><?php _e('Eternal active period', 'ALSP'); ?></b>
			<?php else: ?>
			<b><?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), intval($listing->expiration_date)); ?></b>
			<?php endif; ?>
		</span>
	</div>
	<?php endif; ?>

	<?php endif; ?>
</div>