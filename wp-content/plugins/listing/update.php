<?php 
function alsp_upgrade_notice(){ ?>
	<div class="notice alsp-notice notice-error">
		<p><?php echo esc_html__('Listing', 'ALSP'); ?> <?php echo ALSP_VERSION ?> <?php echo esc_html__(' Required Database Upgrade, please click below to update database.', 'ALSP'); ?></p>
		<div class="">
			<form method="post" enctype="multipart/form-data">
				<button id="alsp_db_update" class="update_submit" type="submit" name="alsp_db_update"><?php echo esc_html__('Update', 'ALSP'); ?></button>
			</form>
		</div>
	</div>
<?php
}
if (get_option('alsp_installed_directory')) {
	if(!get_option('fix_1_14_11') || get_option('fix_1_14_11') != 'fixed'){
		if(isset($_POST['alsp_db_update'])){
			upgrade_to_1_14_11();
			header("Refresh:0");
		}
		add_action('admin_notices', 'alsp_upgrade_notice');
	}
}

function upgrade_to_1_14_11() {
	global $wpdb;
	$prefix = $wpdb->prefix;
	
	$fieldwidth_archive = $wpdb->get_results("SHOW COLUMNS FROM ".$prefix."alsp_content_fields LIKE 'fieldwidth_archive'", ARRAY_A);
	$advanced_archive_search_form = $wpdb->get_results("SHOW COLUMNS FROM ".$prefix."alsp_content_fields LIKE 'advanced_archive_search_form'", ARRAY_A);
	$advanced_widget_search_form = $wpdb->get_results("SHOW COLUMNS FROM ".$prefix."alsp_content_fields LIKE 'advanced_widget_search_form'", ARRAY_A);
	
	$listings_in_package = $wpdb->get_results("SHOW COLUMNS FROM ".$prefix."alsp_levels LIKE 'listings_in_package'", ARRAY_A);
	$change_level_id = $wpdb->get_results("SHOW COLUMNS FROM ".$prefix."alsp_levels LIKE 'change_level_id'", ARRAY_A);
	$listings_resurva = $wpdb->get_results("SHOW COLUMNS FROM ".$prefix."alsp_levels LIKE 'allow_resurva_booking'", ARRAY_A);
	$group_style = $wpdb->get_results("SHOW COLUMNS FROM ".$prefix."alsp_content_fields_groups LIKE 'group_style'", ARRAY_A);
	$checkbox = $wpdb->get_results("SHOW COLUMNS FROM ".$prefix."alsp_content_fields LIKE 'checkbox_icon_type'", ARRAY_A);
	
	if (empty($fieldwidth_archive)) {
		$wpdb->query("ALTER TABLE `".$prefix."alsp_content_fields` ADD `fieldwidth_archive` VARCHAR(255) DEFAULT NULL AFTER `fieldwidth`");
	}
	if (empty($advanced_archive_search_form)) {
		$wpdb->query("ALTER TABLE `".$prefix."alsp_content_fields` ADD `advanced_archive_search_form` tinyint(1) NOT NULL AFTER `advanced_search_form`");
	}
	if (empty($advanced_widget_search_form)) {
		$wpdb->query("ALTER TABLE `".$prefix."alsp_content_fields` ADD `advanced_widget_search_form` tinyint(1) NOT NULL AFTER `advanced_archive_search_form`");
	}
	
	if (empty($listings_in_package)) {
		$wpdb->query("ALTER TABLE `".$prefix."alsp_levels` ADD `listings_in_package` INT(11) NOT NULL DEFAULT '1' AFTER `eternal_active_period`");
	}
	if (empty($change_level_id)) {
		$wpdb->query("ALTER TABLE `".$prefix."alsp_levels` ADD `change_level_id` INT(11) NOT NULL DEFAULT '0' AFTER `eternal_active_period`");
	}
	if (empty($listings_resurva)) {
		$wpdb->query("ALTER TABLE `".$prefix."alsp_levels` ADD `allow_resurva_booking` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `featured_level`");
	}
	if (empty($group_style)) {
		$wpdb->query("ALTER TABLE `".$prefix."alsp_content_fields_groups` ADD `group_style` varchar(255) NOT NULL AFTER `on_tab`");
	}
	if (empty($checkbox)) {
		$wpdb->query("ALTER TABLE `".$prefix."alsp_content_fields` ADD `checkbox_icon_type` varchar(255) NOT NULL AFTER `options`");
	}
	
	update_option('fix_1_14_11', 'fixed');
	update_option('alsp_installed_directory_version', ALSP_VERSION);
}
?>