<?php alsp_frontendRender('admin_header.tpl.php'); ?>
<h2>
	<?php _e('Listing Debug', 'ALSP'); ?>
</h2>

<textarea style="width: 100%; height: 700px">
$alsp_instance->index_page_id = <?php echo $alsp_instance->index_page_id; ?>

$alsp_instance->listing_page_id = <?php echo $alsp_instance->listing_page_id; ?>

<?php if (isset($alsp_instance->submit_page_id)): ?>
$alsp_instance->submit_page_id = <?php echo $alsp_instance->submit_page_id; ?>
<?php endif; ?>

<?php if (isset($alsp_instance->dashboard_page_id)): ?>
$alsp_instance->dashboard_page_id = <?php echo $alsp_instance->dashboard_page_id; ?>
<?php endif; ?>


geolocation response = <?php var_dump($geolocation_response); ?>


<?php foreach ($rewrite_rules AS $key=>$rule)
echo $key . '
' . $rule . '

';
?>


<?php foreach ($settings AS $setting)
echo $setting['option_name'] . ' = ' . $setting['option_value'] . '

';
?>


<?php var_dump($levels); ?>


<?php var_dump($content_fields); ?>
</textarea>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>