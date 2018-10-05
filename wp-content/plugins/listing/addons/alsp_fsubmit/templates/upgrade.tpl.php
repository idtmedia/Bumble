<h3>
	<?php echo sprintf(__('Change level of listing "%s"', 'ALSP'), $alsp_instance->current_listing->title()); ?>
</h3>

<p><?php _e('The level of listing will be changed. You may upgrade or downgrade the level. If new level has an option of limited active period - expiration date of listing will be reassigned automatically.', 'ALSP'); ?></p>

<form action="<?php echo alsp_dashboardUrl(array('alsp_action' => 'upgrade_listing', 'listing_id' => $alsp_instance->current_listing->post->ID, 'upgrade_action' => 'upgrade', 'referer' => urlencode($frontend_controller->referer))); ?>" method="POST">
	<?php if ($frontend_controller->action == 'show'): ?>
	<h3><?php _e('Choose new level', 'ALSP'); ?></h3>
	<?php foreach ($alsp_instance->levels->levels_array AS $level):
            $name = $level->name;
	        if($level->name=='Featured Listing') $name = 'Feature your listing for 7 days!';
            ?>
	<?php if ($alsp_instance->current_listing->level->id != $level->id && (!isset($alsp_instance->current_listing->level->upgrade_meta[$level->id]) || !$alsp_instance->current_listing->level->upgrade_meta[$level->id]['disabled'])): ?>
	<p>
		<label><input type="radio" name="new_level_id" value="<?php echo $level->id; ?>" /> <?php echo apply_filters('alsp_level_upgrade_option', $name, $alsp_instance->current_listing->level, $level); ?></label>
	</p>
	<?php endif; ?>
	<?php endforeach; ?>
	
	<br />
	<br />
	<input type="submit" value="<?php esc_attr_e('Change level', 'ALSP'); ?>" class="btn btn-primary" id="submit" name="submit">
	&nbsp;&nbsp;&nbsp;
	<a href="<?php echo $frontend_controller->referer; ?>" class="btn btn-primary"><?php _e('Cancel', 'ALSP'); ?></a>
	<?php elseif ($frontend_controller->action == 'upgrade'): ?>
	<a href="<?php echo $frontend_controller->referer; ?>" class="btn btn-primary"><?php _e('Go back ', 'ALSP'); ?></a>
	<?php endif; ?>
</form>