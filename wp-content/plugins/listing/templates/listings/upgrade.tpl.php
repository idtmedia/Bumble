<?php alsp_frontendRender('admin_header.tpl.php'); ?>
<form action="<?php echo admin_url('options.php?page=alsp_upgrade&listing_id=' . $listing->post->ID . '&upgrade_action=upgrade&referer=' . urlencode($referer)); ?>" method="POST">
	<?php if ($action == 'show'): ?>
	<h3><?php _e('Get your listing featured on top!', 'ALSP'); ?></h3>
	<?php foreach ($levels->levels_array AS $level): ?>
	<?php if ($listing->level->id != $level->id && (!isset($listing->level->upgrade_meta[$level->id]) || !$listing->level->upgrade_meta[$level->id]['disabled'])): ?>
	<p>
		<label><input type="radio" name="new_level_id" value="<?php echo $level->id; ?>" /> <?php echo apply_filters('alsp_level_upgrade_option', $level->name, $listing->level, $level); ?></label>
	</p>
	<?php endif; ?>
	<?php endforeach; ?>

	<input type="submit" value="<?php esc_attr_e('Proceed to checkout', 'ALSP'); ?>" class="button button-primary" id="submit" name="submit">
	&nbsp;&nbsp;&nbsp;
	<a href="<?php echo $referer; ?>" class="button button-primary"><?php _e('Cancel', 'ALSP'); ?></a>
	<?php elseif ($action == 'upgrade'): ?>
	<a href="<?php echo $referer; ?>" class="button button-primary"><?php _e('Go back ', 'ALSP'); ?></a>
	<?php endif; ?>
</form>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>