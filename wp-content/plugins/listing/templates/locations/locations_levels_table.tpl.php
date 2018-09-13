<?php alsp_frontendRender('admin_header.tpl.php'); ?>
<h2>
	<?php _e('Locations levels', 'ALSP'); ?>
	<?php echo sprintf('<a class="add-new-h2" href="?page=%s&action=%s">' . __('Create new locations level', 'ALSP') . '</a>', $_GET['page'], 'add'); ?>
</h2>

<?php $locations_levels_table->display(); ?>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>