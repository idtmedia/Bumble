<?php alsp_frontendRender('admin_header.tpl.php'); ?>
<h2>
	<?php _e('Choose level for new listing', 'ALSP'); ?>
</h2>

<?php if ($levels_count == 0): ?>
<p><?php echo sprintf(__('Before listings creation you must have at least one listings level, please create new level <a href="%s">here</a>', 'ALSP'), admin_url('admin.php?page=alsp_levels&action=add')); ?></p>
<?php endif; ?>

<?php 
	$levels_table->display();
?>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>