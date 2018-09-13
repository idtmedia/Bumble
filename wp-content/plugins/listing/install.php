<?php 
function alsp_install_directory() {
	global $wpdb;
	$collate = '';

		if ( $wpdb->has_cap( 'collation' ) ) {
			$collate = $wpdb->get_charset_collate();
		}
	if (!get_option('alsp_installed_directory')) {
		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->alsp_content_fields_groups} (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`name` varchar(255) NOT NULL,
					`on_tab` tinyint(1) NOT NULL DEFAULT '0',
					`group_style` varchar(255) NOT NULL DEFAULT '0',
					`hide_anonymous` tinyint(1) NOT NULL DEFAULT '0',
					PRIMARY KEY (`id`)
					) $collate ;");
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->alsp_content_fields_groups} WHERE name = 'Contact Information'"))
			$wpdb->query("INSERT INTO {$wpdb->alsp_content_fields_groups} (`name`, `on_tab`, `group_style`, `hide_anonymous`) VALUES ('Contact Information', 0, 1, 0)");

		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->alsp_content_fields} (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`is_core_field` tinyint(1) NOT NULL DEFAULT '0',
					`order_num` tinyint(1) NOT NULL,
					`name` varchar(255) NOT NULL,
					`slug` varchar(255) NOT NULL,
					`description` text NOT NULL,
					`fieldwidth` varchar(255) NOT NULL,
					`fieldwidth_archive` varchar(255) NOT NULL,
					`type` varchar(255) NOT NULL,
					`icon_image` varchar(255) NOT NULL,
					`is_required` tinyint(1) NOT NULL DEFAULT '0',
					`is_configuration_page` tinyint(1) NOT NULL DEFAULT '0',
					`is_search_configuration_page` tinyint(1) NOT NULL DEFAULT '0',
					`is_ordered` tinyint(1) NOT NULL DEFAULT '0',
					`is_hide_name` tinyint(1) NOT NULL DEFAULT '0',
					`on_exerpt_page` tinyint(1) NOT NULL DEFAULT '0',
					`on_listing_page` tinyint(1) NOT NULL DEFAULT '0',
					`on_search_form` tinyint(1) NOT NULL DEFAULT '0',
					`on_search_form_archive` tinyint(1) NOT NULL DEFAULT '0',
					`on_search_form_widget` tinyint(1) NOT NULL DEFAULT '0',
					`on_map` tinyint(1) NOT NULL DEFAULT '0',
					`advanced_search_form` tinyint(1) NOT NULL,
					`advanced_archive_search_form` tinyint(1) NOT NULL,
					`advanced_widget_search_form` tinyint(1) NOT NULL,
					`categories` text NOT NULL,
					`options` text NOT NULL,
					`checkbox_icon_type` varchar(255) NOT NULL,
					`search_options` text NOT NULL,
					`group_id` int(11) NOT NULL DEFAULT '0',
					PRIMARY KEY (`id`),
					KEY `group_id` (`group_id`)
					) $collate;");
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->alsp_content_fields} WHERE slug = 'summary'"))
			$wpdb->query("INSERT INTO {$wpdb->alsp_content_fields} (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_search_configuration_page`, `is_ordered`, `is_hide_name`, `on_exerpt_page`, `on_listing_page`, `on_search_form`, `on_map`, `on_search_form_archive`, `on_search_form_widget`, `advanced_search_form`, `advanced_archive_search_form`, `advanced_widget_search_form`, `categories`, `options`, `search_options`, `group_id`) VALUES(1, 1, 'Summary', 'summary', '', 'excerpt', '', 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '0');");
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->alsp_content_fields} WHERE slug = 'address'"))
			$wpdb->query("INSERT INTO {$wpdb->alsp_content_fields} (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_search_configuration_page`, `is_ordered`, `is_hide_name`, `on_exerpt_page`, `on_listing_page`, `on_search_form`, `on_map`, `on_search_form_archive`, `on_search_form_widget`, `advanced_search_form`, `advanced_archive_search_form`, `advanced_widget_search_form`, `categories`, `options`, `search_options`, `group_id`) VALUES(1, 2, 'Address', 'address', '', 'address', 'fa-map-marker', 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, '', '', '', '0');");
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->alsp_content_fields} WHERE slug = 'content'"))
			$wpdb->query("INSERT INTO {$wpdb->alsp_content_fields} (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_search_configuration_page`, `is_ordered`, `is_hide_name`, `on_exerpt_page`, `on_listing_page`, `on_search_form`, `on_map`, `on_search_form_archive`, `on_search_form_widget`, `advanced_search_form`, `advanced_archive_search_form`, `advanced_widget_search_form`, `categories`, `options`, `search_options`, `group_id`) VALUES(1, 3, 'Description', 'content', '', 'content', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '', '', '', '0');");
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->alsp_content_fields} WHERE slug = 'categories_list'"))
			$wpdb->query("INSERT INTO {$wpdb->alsp_content_fields} (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_search_configuration_page`, `is_ordered`, `is_hide_name`, `on_exerpt_page`, `on_listing_page`, `on_search_form`, `on_map`, `on_search_form_archive`, `on_search_form_widget`, `advanced_search_form`, `advanced_archive_search_form`, `advanced_widget_search_form`, `categories`, `options`, `search_options`, `group_id`) VALUES(1, 4, 'Categories', 'categories_list', '', 'categories', '', 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, '', '', '', '0');");
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->alsp_content_fields} WHERE slug = 'listing_tags'"))
			$wpdb->query("INSERT INTO {$wpdb->alsp_content_fields} (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_search_configuration_page`, `is_ordered`, `is_hide_name`, `on_exerpt_page`, `on_listing_page`, `on_search_form`, `on_map`, `on_search_form_archive`, `on_search_form_widget`, `advanced_search_form`, `advanced_archive_search_form`, `advanced_widget_search_form`, `categories`, `options`, `search_options`, `group_id`) VALUES(1, 5, 'Listing Tags', 'listing_tags', '', 'tags', '', 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, '', '', '', '0');");
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->alsp_content_fields} WHERE slug = 'phone'"))
			$wpdb->query("INSERT INTO {$wpdb->alsp_content_fields} (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_search_configuration_page`, `is_ordered`, `is_hide_name`, `on_exerpt_page`, `on_listing_page`, `on_search_form`, `on_map`, `on_search_form_archive`, `on_search_form_widget`, `advanced_search_form`, `advanced_archive_search_form`, `advanced_widget_search_form`, `categories`, `options`, `search_options`, `group_id`) VALUES(0, 6, 'Phone', 'phone', '', 'string', 'fa-phone', 0, 1, 0, 0, 0, 1, 1, 0, 1, 0, 0, 0, 0, 0, '', 'a:2:{s:10:\"max_length\";s:2:\"25\";s:5:\"regex\";s:0:\"\";}', '', '1');");
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->alsp_content_fields} WHERE slug = 'website'"))
			$wpdb->query("INSERT INTO {$wpdb->alsp_content_fields} (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_search_configuration_page`, `is_ordered`, `is_hide_name`, `on_exerpt_page`, `on_listing_page`, `on_search_form`, `on_map`, `on_search_form_archive`, `on_search_form_widget`, `advanced_search_form`, `advanced_archive_search_form`, `advanced_widget_search_form`, `categories`, `options`, `search_options`, `group_id`) VALUES(0, 7, 'Website', 'website', '', 'website', 'fa-globe', 0, 1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, '', 'a:5:{s:8:\"is_blank\";i:1;s:11:\"is_nofollow\";i:1;s:13:\"use_link_text\";i:1;s:17:\"default_link_text\";s:13:\"view our site\";s:21:\"use_default_link_text\";i:0;}', '', '1');");
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->alsp_content_fields} WHERE slug = 'email'"))
			$wpdb->query("INSERT INTO {$wpdb->alsp_content_fields} (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_search_configuration_page`, `is_ordered`, `is_hide_name`, `on_exerpt_page`, `on_listing_page`, `on_search_form`, `on_search_form_archive`, `on_search_form_widget`, `on_map`, `advanced_search_form`, `advanced_archive_search_form`, `advanced_widget_search_form`, `categories`, `options`, `search_options`, `group_id`) VALUES(1, 8, 'Email', 'email', '', 'email', 'fa-envelope-o', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '', '', '', '1');");
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->alsp_content_fields} WHERE slug = 'price'"))
			$wpdb->query("INSERT INTO {$wpdb->alsp_content_fields} (`is_core_field`, `order_num`, `name`, `slug`, `description`, `type`, `icon_image`, `is_required`, `is_configuration_page`, `is_search_configuration_page`, `is_ordered`, `is_hide_name`, `on_exerpt_page`, `on_listing_page`, `on_search_form`, `on_search_form_archive`, `on_search_form_widget`, `on_map`, `advanced_search_form`, `advanced_archive_search_form`, `advanced_widget_search_form`, `categories`, `options`, `search_options`, `group_id`) VALUES(0, 2, 'Price', 'price', '', 'price', '', 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 0, 0, 0, '', '', '', '1');");
		
		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->alsp_levels} (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`order_num` tinyint(1) NOT NULL,
					`name` varchar(255) NOT NULL,
					`description` text NOT NULL,
					`active_interval` tinyint(1) NOT NULL,
					`active_period` varchar(255) NOT NULL,
					`eternal_active_period` tinyint(1) NOT NULL DEFAULT '1',
					`listings_in_package` INT(11) NOT NULL DEFAULT '1',
					`change_level_id` INT(11) NOT NULL DEFAULT '0',
					`raiseup_enabled` tinyint(1) NOT NULL,
					`sticky` tinyint(1) NOT NULL,
					`featured` tinyint(1) NOT NULL,
					`nofollow` tinyint(1) NOT NULL DEFAULT '0',
					`featured_level` tinyint(1) NOT NULL DEFAULT '0',
					`allow_resurva_booking` tinyint(1) NOT NULL DEFAULT '0',
					`listings_own_page` tinyint(1) NOT NULL DEFAULT '1',
					`categories_number` tinyint(1) NOT NULL,
					`unlimited_categories` tinyint(1) NOT NULL,
					`locations_number` tinyint(1) NOT NULL,
					`google_map` tinyint(1) NOT NULL,
					`google_map_markers` tinyint(1) NOT NULL,
					`logo_enabled` tinyint(1) NOT NULL,
					`images_number` tinyint(1) NOT NULL,
					`videos_number` tinyint(1) NOT NULL,
					`categories` text NOT NULL,
					`locations` text NOT NULL,
					`content_fields` text NOT NULL,
					`upgrade_meta` text NOT NULL,
					PRIMARY KEY (`id`),
					KEY `order_num` (`order_num`)
					) $collate ;");
		
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->alsp_levels} WHERE name = 'Standard'"))
			$wpdb->query("INSERT INTO {$wpdb->alsp_levels} (`order_num`, `name`, `description`, `active_interval`, `active_period`, `eternal_active_period`, `listings_in_package`, `change_level_id`, `raiseup_enabled`, `sticky`, `featured`, `nofollow`, `featured_level`, `allow_resurva_booking`, `listings_own_page`, `categories_number`, `unlimited_categories`, `locations_number`, `google_map`, `google_map_markers`, `logo_enabled`, `images_number`, `videos_number`, `categories`, `locations`, `content_fields`, `upgrade_meta`) VALUES (1, 'Standard', '', 0, '', 1, 1, 0, 1, 0, 0, 0, 1, '0', 0, 1, 3, 1, 1, 1, 6, 3, '', '', '', '', '')");

		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->alsp_levels_relationships} (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`post_id` int(11) NOT NULL,
					`level_id` int(11) NOT NULL,
					PRIMARY KEY (`id`),
					UNIQUE KEY `post_id` (`post_id`,`level_id`)
					) $collate ;");

		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->alsp_locations_levels} (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`name` varchar(255) NOT NULL,
					`in_widget` tinyint(1) NOT NULL,
					`in_address_line` tinyint(1) NOT NULL,
					PRIMARY KEY (`id`),
					KEY `in_select_widget` (`in_widget`,`in_address_line`)
					) $collate ;");
	
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->alsp_locations_levels} WHERE name = 'Country'"))
			$wpdb->query("INSERT INTO {$wpdb->alsp_locations_levels} (`name`, `in_widget`, `in_address_line`) VALUES ('Country', 1, 1);");
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->alsp_locations_levels} WHERE name = 'State'"))
			$wpdb->query("INSERT INTO {$wpdb->alsp_locations_levels} (`name`, `in_widget`, `in_address_line`) VALUES ('State', 1, 1);");
		if (!$wpdb->get_var("SELECT id FROM {$wpdb->alsp_locations_levels} WHERE name = 'City'"))
			$wpdb->query("INSERT INTO {$wpdb->alsp_locations_levels} (`name`, `in_widget`, `in_address_line`) VALUES ('City', 1, 1);");

		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->alsp_locations_relationships} (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`post_id` int(11) NOT NULL,
					`location_id` int(11) NOT NULL,
					`address_line_1` varchar(255) NOT NULL,
					`address_line_2` varchar(255) NOT NULL,
					`zip_or_postal_index` varchar(25) NOT NULL,
					`additional_info` text NOT NULL,
					`manual_coords` tinyint(1) NOT NULL,
					`map_coords_1` float(10,6) NOT NULL,
					`map_coords_2` float(10,6) NOT NULL,
					`map_icon_file` varchar(255) NOT NULL,
					PRIMARY KEY (`id`),
					KEY `location_id` (`location_id`),
					KEY `post_id` (`post_id`)
					) $collate ;");
	
		if (!is_array(get_terms(ALSP_LOCATIONS_TAX)) || !count(get_terms(ALSP_LOCATIONS_TAX))) {
			if (($parent_term = wp_insert_term('USA', ALSP_LOCATIONS_TAX)) && !is_a($parent_term, 'WP_Error')) {
				wp_insert_term('Alabama', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Alaska', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Arkansas', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Arizona', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('California', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Colorado', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Connecticut', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Delaware', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('District of Columbia', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Florida', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Georgia', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Hawaii', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Idaho', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Illinois', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Indiana', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Iowa', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Kansas', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Kentucky', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Louisiana', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Maine', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Maryland', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Massachusetts', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Michigan', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Minnesota', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Mississippi', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Missouri', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Montana', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Nebraska', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Nevada', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('New Hampshire', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('New Jersey', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('New Mexico', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('New York', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('North Carolina', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('North Dakota', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Ohio', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Oklahoma', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Oregon', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Pennsylvania', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Rhode Island', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('South Carolina', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('South Dakota', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Tennessee', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Texas', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Utah', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Vermont', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Virginia', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Washington state', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('West Virginina', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Wisconsin', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
				wp_insert_term('Wyoming', ALSP_LOCATIONS_TAX, array('parent' => $parent_term['term_id']));
			}
		}
		add_option('alsp_installed_directory', true);
		add_option('alsp_installed_directory_version', ALSP_VERSION);
		add_option('alsp_levels_upgrade_fix', 'fixed');
		add_option('fix_1_14_4', 'fixed');
		add_option('fix_1_14_9', 'fixed');
		add_option('fix_1_14_10', 'fixed');
		add_option('fix_1_14_11', 'fixed');
	}
	
	global $alsp_instance;
	$alsp_instance->loadClasses();
}
?>