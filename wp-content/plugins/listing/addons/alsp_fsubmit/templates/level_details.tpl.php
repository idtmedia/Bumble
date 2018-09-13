<?php global $ALSP_ADIMN_SETTINGS; ?>
<?php if (($ALSP_ADIMN_SETTINGS['alsp_payments_addon'] == 'alsp_woo_payment' && !alsp_is_woo_active()) && $args['show_period']): ?>
	<li class="alsp-list-group-item">
		<?php echo $level->getActivePeriodString(); ?>
	</li>
<?php endif; ?>
<?php if ($args['show_sticky'] && ($args['columns_same_height'] || (!$args['columns_same_height'] && $level->sticky))): ?>
	<?php if ($ALSP_ADIMN_SETTINGS['alsp_payments_addon'] != 'alsp_woo_payment'): ?>
	<?php if ($level->listings_in_package > 1): ?>
	<li class="alsp-list-group-item">
		<?php printf(__("Total Listings <strong>%d</strong>", "ALSP"), $level->listings_in_package); ?>
	</li>
	<?php endif; ?>
	<?php endif; ?>
	<li class="alsp-list-group-item">
		
		<?php if($ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] == 'pplan-style-1'){ _e('Sticky', 'ALSP'); } ?>
		<?php if ($level->sticky): ?>
		<i class="pacz-icon-check"></i>
		<?php else: ?>
		<i class="pacz-icon-remove"></i>
		<?php endif; ?>
		<?php if($ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] != 'pplan-style-1'){ _e('Sticky', 'ALSP'); } ?>
	</li>
<?php endif; ?>
<?php if ($args['show_featured'] && ($args['columns_same_height'] || (!$args['columns_same_height'] && $level->featured))): ?>
	<li class="alsp-list-group-item">
		<?php if($ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] == 'pplan-style-1'){ _e('Featured', 'ALSP'); } ?>
		<?php if ($level->featured): ?>
		<i class="pacz-icon-check"></i>
		<?php else: ?>
		<i class="pacz-icon-remove"></i>
		<?php endif; ?>
		<?php if($ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] != 'pplan-style-1'){ _e('Featured', 'ALSP'); } ?>
	</li>
<?php endif; ?>
<?php //if ($level->allow_resurva_booking): ?>
	<li class="alsp-list-group-item">
		<?php _e('Resurva Booking', 'ALSP'); ?>
		<?php if ($level->allow_resurva_booking): ?>
		<i class="pacz-icon-check"></i>
		<?php else: ?>
		<i class="pacz-icon-remove"></i>
		<?php endif; ?>
	</li>
<?php //endif; ?>
<?php if ($args['show_maps'] && ($args['columns_same_height'] || (!$args['columns_same_height'] && $level->google_map))): ?>
	<li class="alsp-list-group-item">
		<?php if($ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] == 'pplan-style-1'){ _e('Google map', 'ALSP'); } ?>
		<?php if ($level->google_map): ?>
		<i class="pacz-icon-check"></i>
		<?php else: ?>
		<i class="pacz-icon-remove"></i>
		<?php endif; ?>
		<?php if($ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] != 'pplan-style-1'){ _e('Google map', 'ALSP'); } ?>
	</li>
<?php endif; ?>
<?php if ($args['show_categories'] && ($args['columns_same_height'] || (!$args['columns_same_height'] && ($level->categories_number || $level->unlimited_categories)))): ?>
	<li class="alsp-list-group-item">
		<?php
		if (!$level->unlimited_categories)
			if ($level->categories_number == 1)
				_e('1 category', 'ALSP');
			elseif ($level->categories_number != 0)
				printf(__('Up to <strong>%d</strong> categories', 'ALSP'), $level->categories_number);
			else 
				_e('No categories', 'ALSP');
		else _e('Unlimited categories', 'ALSP'); ?>
	</li>
<?php endif; ?>
<?php if ($args['show_locations'] && ($args['columns_same_height'] || (!$args['columns_same_height'] && $level->locations_number))): ?>
	<li class="alsp-list-group-item">
		<?php
		if ($level->locations_number == 1)
			_e('1 location', 'ALSP');
		elseif ($level->locations_number != 0)
			printf(__('Up to <strong>%d</strong> locations', 'ALSP'), $level->locations_number);
		else
			_e('No locations', 'ALSP'); ?>
	</li>
<?php endif; ?>
<?php if ($args['show_images'] && ($args['columns_same_height'] || (!$args['columns_same_height'] && $level->images_number))): ?>
	<li class="alsp-list-group-item">
		<?php
		if ($level->images_number == 1)
			_e('1 image', 'ALSP');
		elseif ($level->images_number != 0)
			printf(__('Up to <strong>%d</strong> images', 'ALSP'), $level->images_number);
		else
			_e('No images', 'ALSP'); ?>
	</li>
<?php endif; ?>
<?php if ($args['show_videos'] && ($args['columns_same_height'] || (!$args['columns_same_height'] && $level->videos_number))): ?>
	<li class="alsp-list-group-item">
		<?php
		if ($level->videos_number == 1)
			_e('1 video', 'ALSP');
		elseif ($level->videos_number != 0)
			printf(__('Up to <strong>%d</strong> videos', 'ALSP'), $level->videos_number);
		else
			_e('No videos', 'ALSP'); ?>
	</li>
<?php endif; ?>