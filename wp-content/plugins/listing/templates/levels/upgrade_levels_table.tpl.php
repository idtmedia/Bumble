<?php alsp_frontendRender('admin_header.tpl.php'); ?>

<script>
	(function($) {
	"use strict";

		$(function() {
			$("input[name*='level_disabled_']").each( function() {
				levelDisableChange($(this));
			});
	
			$("input[name*='level_disabled_']").change( function() {
				levelDisableChange($(this));
			});
	
			function levelDisableChange(checkbox) {
				if (checkbox.is(':checked'))
					checkbox.parent().parent().find("input:not(.level_disabled)").attr('disabled', 'true');
				else
					checkbox.parent().parent().find("input:not(.level_disabled)").removeAttr('disabled');
			}
		});
	})(jQuery);
</script>
<h2>
	<?php _e('Listings upgrade', 'ALSP'); ?>
</h2>

<h3>
	<?php _e('Set prices for listings upgrade according to their levels.', 'ALSP'); ?>
</h3>

<form method="POST" action="<?php echo admin_url('admin.php?page=alsp_manage_upgrades'); ?>">
	<table class="widefat alsp-admin-table">
		<thead>
			<tr>
				<th></th>
				<?php foreach ($levels->levels_array AS $level): ?>
				<th><?php echo $level->name; ?></th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<?php $i = 0; ?>
		<?php foreach ($levels->levels_array AS $level1): ?>
		<?php $i++; ?>
		<tr <?php if ($i % 2 != 0) echo "class='alternate'"; ?>>
			<th><?php echo $level1->name; ?></th>
			<?php foreach ($levels->levels_array AS $level2): ?>
			<th title="<?php esc_attr(printf(__("From %s to %s", 'ALSP'), $level1->name, $level2->name)); ?>">
				<?php if ($level1->id != $level2->id): ?>
				<?php do_action('alsp_upgrade_meta_html', $level1, $level2); ?>
				<label><input type="checkbox" name="level_raiseup_<?php echo $level1->id; ?>_<?php echo $level2->id; ?>" value=1 <?php if (isset($level1->upgrade_meta[$level2->id])) checked($level1->upgrade_meta[$level2->id]['raiseup'], 1, true); ?> /> <?php _e('Raise Up after upgrade', 'ALSP'); ?></label><br />
				<label><input type="checkbox" class="level_disabled" name="level_disabled_<?php echo $level1->id; ?>_<?php echo $level2->id; ?>" value=1 <?php if (isset($level1->upgrade_meta[$level2->id])) checked($level1->upgrade_meta[$level2->id]['disabled'], 1, true); ?> /> <?php printf(__("Disable upgrade from %s to %s level", 'ALSP'), $level1->name, $level2->name); ?></label>
				<?php else: ?>
				N/A
				<?php endif; ?>
			</th>
			<?php endforeach; ?>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php submit_button(__('Save changes', 'ALSP')); ?>
</form>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>