<?php

add_action('vc_before_init', 'alsp_vc_init');

function alsp_vc_init() {
	global $alsp_instance, $alsp_fsubmit_instance, $alsp_maps_styles;
	
	$map_styles = array('default' => '');
	foreach ($alsp_maps_styles AS $name=>$style)
		$map_styles[$name] = $name;

	$levels = array(__('All', 'ALSP') => 0);
	foreach ($alsp_instance->levels->levels_array AS $level) {
		$levels[$level->name] = $level->id;
	}

	$ordering = alsp_orderingItems();
	
	vc_add_shortcode_param('categoriesfield', 'alsp_categories_param');
	function alsp_categories_param($settings, $value) {
		$out = "<script>
			function updateTagChecked() { jQuery('#" . $settings['param_name'] . "').val(jQuery('#" . $settings['param_name'] . "_select').val()); }
	
			jQuery(function() {
				jQuery('#" . $settings['param_name'] . "_select option').click(updateTagChecked);
				updateTagChecked();
			});
		</script>";
	
		$out .= '<select multiple="multiple" id="' . $settings['param_name'] . '_select" name="' . $settings['param_name'] . '_select" style="height: 300px">';
		$out .= '<option value="" ' . ((!$value) ? 'selected' : '') . '>' . __('- Select All -', 'ALSP') . '</option>';
		ob_start();
		alsp_renderOptionsTerms(ALSP_CATEGORIES_TAX, 0, explode(',', $value));
		$out .= ob_get_clean();
		$out .= '</select>';
		$out .= '<input type="hidden" id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value" value="' . $value . '" />';
	
		return $out;
	}

	vc_add_shortcode_param('locationsfield', 'alsp_locations_param');
	function alsp_locations_param($settings, $value) {
		$out = "<script>
			function updateTagChecked() { jQuery('#" . $settings['param_name'] . "').val(jQuery('#" . $settings['param_name'] . "_select').val()); }
	
			jQuery(function() {
				jQuery('#" . $settings['param_name'] . "_select option').click(updateTagChecked);
				updateTagChecked();
			});
		</script>";
	
		$out .= '<select multiple="multiple" id="' . $settings['param_name'] . '_select" name="' . $settings['param_name'] . '_select" style="height: 300px">';
		$out .= '<option value="" ' . ((!$value) ? 'selected' : '') . '>' . __('- Select All -', 'ALSP') . '</option>';
		ob_start();
		alsp_renderOptionsTerms(ALSP_LOCATIONS_TAX, 0, explode(',', $value));
		$out .= ob_get_clean();
		$out .= '</select>';
		$out .= '<input type="hidden" id="' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value" value="' . $value . '" />';
	
		return $out;
	}
	
	vc_map( array(
		'name'                    => __('ALSP Listing', 'ALSP'),
		'description'             => __('Main shortcode', 'ALSP'),
		'base'                    => 'webdirectory',
		'icon'                    => ALSP_RESOURCES_URL . 'images/webdirectory.png',
		'show_settings_on_create' => true,
		'category'                => __('Listing Content', 'ALSP'),
		'params'                  => array(
			array(
					'type' => 'dropdown',
					'param_name' => 'custom_home',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Is it on custom home page?', 'ALSP'),
			),
		),
	));
	
	if ($alsp_fsubmit_instance) {
		vc_map( array(
			'name'                    => __('Listings submit', 'ALSP'),
			'description'             => __('Listings submission pages', 'ALSP'),
			'base'                    => 'webdirectory-submit',
			'icon'                    => ALSP_RESOURCES_URL . 'images/webdirectory.png',
			'show_settings_on_create' => false,
			'category'                => __('Listing Content', 'ALSP'),
			'params'                  => array(
				array(
						'type' => 'dropdown',
						'param_name' => 'show_steps',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Show submission steps?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'columns',
						'value' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'),
						'std' => 3,
						'heading' => __('Columns number on choose level page', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'columns_same_height',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Show negative paratmeters?', 'ALSP'),
						'description' => __('Show parameters those have negation. For example, such row in table will be shown: Featured Listings - No. In other case it will be completely hidden.', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_period',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show level active period on choose level page?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_sticky',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show is level sticky on choose level page?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_featured',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show is level featured on choose level page?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_categories',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => esc_attr__("Show level's categories number on choose level page?", 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_locations',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => esc_attr__("Show levels locations number on choose level page?", 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_maps',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show is level supports maps on choose level page?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_images',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => esc_attr__("Show level's images number on choose level page?", 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_videos',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => esc_attr__("Show level's videos number on choose level page?", 'ALSP'),
				),
			),
		));
		vc_map( array(
			'name'                    => __('Pricing table', 'ALSP'),
			'description'             => __('Listings levels table. Works in the same way as 1st step on Listings submit, displays only pricing table. Note, that page with Listings submit element required.', 'ALSP'),
			'base'                    => 'webdirectory-levels-table',
			'icon'                    => ALSP_RESOURCES_URL . 'images/webdirectory.png',
			'show_settings_on_create' => false,
			'category'                => __('Listing Content', 'ALSP'),
			'params'                  => array(
				array(
						'type' => 'dropdown',
						'param_name' => 'columns',
						'value' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'),
						'std' => 3,
						'heading' => __('Columns number on choose level page', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'columns_same_height',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Show negative paratmeters?', 'ALSP'),
						'description' => __('Show parameters those have negation. For example, such row in table will be shown: Featured Listings - No. In other case it will be completely hidden.', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_period',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show level active period on choose level page?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_sticky',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show is level sticky on choose level page?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_featured',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show is level featured on choose level page?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_categories',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => esc_attr__("Show level's categories number on choose level page?", 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_locations',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => esc_attr__("Show level's locations number on choose level page?", 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_maps',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => __('Show is level supports maps on choose level page?', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_images',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => esc_attr__("Show level's images number on choose level page?", 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'show_videos',
						'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
						'heading' => esc_attr__("Show level's videos number on choose level page?", 'ALSP'),
				),
			),
		));
		vc_map( array(
			'name'                    => __('Users Dashboard', 'ALSP'),
			'description'             => __('Listing frontend dashboard', 'ALSP'),
			'base'                    => 'webdirectory-dashboard',
			'icon'                    => ALSP_RESOURCES_URL . 'images/webdirectory.png',
			'show_settings_on_create' => false,
			'category'                => __('Listing Content', 'ALSP'),
		));
	}
	
	$vc_listings_args = array(
		'name'                    => __('Listing Listings', 'ALSP'),
		'description'             => __('Listing listings filtered by params', 'ALSP'),
		'base'                    => 'webdirectory-listings',
		'icon'                    => ALSP_RESOURCES_URL . 'images/webdirectory.png',
		'show_settings_on_create' => true,
		'category'                => __('Listing Content', 'ALSP'),
		'params'                  => array(
			array(
					'type' => 'textfield',
					'param_name' => 'uid',
					'value' => '',
					'heading' => __('Enter unique string to connect this shortcode with another shortcodes.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'onepage',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Show all possible listings on one page?', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'ajax_initial_load',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Load listings only after the page was completely loaded.', 'ALSP'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'perpage',
					'value' => 10,
					'heading' => __('Number of listing per page', 'ALSP'),
					'description' => __('Number of listings to display per page. Set -1 to display all listings without paginator.', 'ALSP'),
					'dependency' => array('element' => 'onepage', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_paginator',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Hide paginator', 'ALSP'),
					'description' => __('When paginator is hidden - it will display only exact number of listings.', 'ALSP'),
					'dependency' => array('element' => 'onepage', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'sticky_featured',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Show only sticky or/and featured listings?', 'ALSP'),
					'description' => __('Whether to show only sticky or/and featured listings.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'order_by',
					'value' => $ordering,
					'heading' => __('Order by', 'ALSP'),
					'description' => __('Order listings by any of these parameter.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'order',
					'value' => array(__('Ascending', 'ALSP') => 'ASC', __('Descending', 'ALSP') => 'DESC'),
					'description' => __('Direction of sorting.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_order',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Hide ordering links?', 'ALSP'),
					'description' => __('Whether to hide ordering navigation links.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_count',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Hide number of listings?', 'ALSP'),
					'description' => __('Whether to hide number of found listings.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'show_views_switcher',
					'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
					'heading' => __('Show listings views switcher?', 'ALSP'),
					'description' => __('Whether to show listings views switcher.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'listings_view_type',
					'value' => array(__('List', 'ALSP') => 'list', __('Grid', 'ALSP') => 'grid'),
					'heading' => __('Listings view by default', 'ALSP'),
					'description' => __('Do not forget that selected view will be stored in cookies.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'listings_view_grid_columns',
					'value' => array('1', '2', '3', '4'),
					'heading' => __('Number of columns for listings Grid View', 'ALSP'),
					//'std' => 2,
			),
			array(
					'type' => 'textfield',
					'param_name' => 'address',
					'heading' => __('Address', 'ALSP'),
					'description' => __('Display listings near this address, recommended to set "radius" attribute.', 'ALSP'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'radius',
					'heading' => __('Radius', 'ALSP'),
					'description' => __('Display listings near provided address within this radius in miles or kilometers.', 'ALSP'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'author',
					'heading' => __('Author', 'ALSP'),
					'description' => __('Enter exact ID of author or word "related" to get assigned listings of current author (works only on listing page or author page)', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_categories',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Use related categories.', 'ALSP'),
					'description' => __('Parameter works only on listings and categories pages.', 'ALSP'),
			),
			array(
					'type' => 'categoriesfield',
					'param_name' => 'categories',
					//'value' => 0,
					'heading' => __('Select certain categories', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_locations',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Use related locations.', 'ALSP'),
					'description' => __('Parameter works only on listings and locations pages.', 'ALSP'),
			),
			array(
					'type' => 'locationsfield',
					'param_name' => 'locations',
					//'value' => 0,
					'heading' => __('Select certain locations', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_tags',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Use related tags.', 'ALSP'),
					'description' => __('Parameter works only on listings and tags pages.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'include_categories_children',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Include children of selected categories and locations', 'ALSP'),
					'description' => __('When enabled - any subcategories or sublocations will be included as well. Related categories and locations also affected.', 'ALSP'),
			),
			array(
					'type' => 'checkbox',
					'param_name' => 'levels',
					'value' => $levels,
					'heading' => __('Listings levels', 'ALSP'),
					'description' => __('Categories may be dependent from listings levels.', 'ALSP'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'post__in',
					'heading' => __('Exact listings', 'ALSP'),
					'description' => __('Comma separated string of listings IDs. Possible to display exact listings.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'scroll',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Scroll', 'ALSP'),
					'description' => __('listing carousel', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'autoplay',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Autoplay', 'ALSP'),
					'description' => __('Autoplay', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'loop',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Loop', 'ALSP'),
					'description' => __('Loop', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'owl_nav',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Scroller Nav', 'ALSP'),
					'description' => __('Scroller Nav', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'gutter',
					'value' => '30',
					'heading' => __('margin ', 'ALSP'),
					'description' => __('margin between columns', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'desktop_items',
					'value' => '3',
					'heading' => __('desktop items ', 'ALSP'),
					'description' => __('items to display above 1025px', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'tab_landscape_items',
					'value' => '3',
					'heading' => __('tab landscape items ', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'tab_items',
					'value' => '2',
					'heading' => __('Tab items', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'delay',
					'value' => '1000',
					'heading' => __('Scroll Delay  ', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'autoplay_speed',
					'value' => '1000',
					'heading' => __('scrolling speed', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
		),
	);
	foreach ($alsp_instance->search_fields->search_fields_array AS $search_field) {
		if (method_exists($search_field, 'getVCParams') && ($field_params = $search_field->getVCParams()))
			$vc_listings_args['params'] = array_merge($vc_listings_args['params'], $field_params);
	}
	vc_map($vc_listings_args);
	
	$vc_listings_args2 = array(
		'name'                    => __('Listing2 Listings', 'ALSP'),
		'description'             => __('Listing listings filtered by params', 'ALSP'),
		'base'                    => 'webdirectory-listings',
		'icon'                    => ALSP_RESOURCES_URL . 'images/webdirectory.png',
		'show_settings_on_create' => true,
		'category'                => __('Listing Content', 'ALSP'),
		'params'                  => array(
			array(
					'type' => 'textfield',
					'param_name' => 'uid',
					'value' => '',
					'heading' => __('Enter unique string to connect this shortcode with another shortcodes.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'listing_post_style',
					'value' => array(__('10', 'ALSP') => '10', __('11', 'ALSP') => '11'),
					'heading' => __('post style', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'onepage',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Show all possible listings on one page?', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'ajax_initial_load',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Load listings only after the page was completely loaded.', 'ALSP'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'perpage',
					'value' => 10,
					'heading' => __('Number of listing per page', 'ALSP'),
					'description' => __('Number of listings to display per page. Set -1 to display all listings without paginator.', 'ALSP'),
					'dependency' => array('element' => 'onepage', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_paginator',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Hide paginator', 'ALSP'),
					'description' => __('When paginator is hidden - it will display only exact number of listings.', 'ALSP'),
					'dependency' => array('element' => 'onepage', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'sticky_featured',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Show only sticky or/and featured listings?', 'ALSP'),
					'description' => __('Whether to show only sticky or/and featured listings.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'order_by',
					'value' => $ordering,
					'heading' => __('Order by', 'ALSP'),
					'description' => __('Order listings by any of these parameter.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'order',
					'value' => array(__('Ascending', 'ALSP') => 'ASC', __('Descending', 'ALSP') => 'DESC'),
					'description' => __('Direction of sorting.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_order',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Hide ordering links?', 'ALSP'),
					'description' => __('Whether to hide ordering navigation links.', 'ALSP'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'listing_order_by_txt',
					'heading' => __('Order By Text', 'ALSP'),
					'description' => __('Option will work if Ordering links are On', 'ALSP'),
					'dependency' => array('element' => 'hide_order', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_count',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Hide number of listings?', 'ALSP'),
					'description' => __('Whether to hide number of found listings.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'show_views_switcher',
					'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
					'heading' => __('Show listings views switcher?', 'ALSP'),
					'description' => __('Whether to show listings views switcher.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'listings_view_type',
					'value' => array(__('List', 'ALSP') => 'list', __('Grid', 'ALSP') => 'grid'),
					'heading' => __('Listings view by default', 'ALSP'),
					'description' => __('Do not forget that selected view will be stored in cookies.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'listings_view_grid_columns',
					'value' => array('1', '2', '3', '4'),
					'heading' => __('Number of columns for listings Grid View', 'ALSP'),
					//'std' => 2,
			),
			array(
					'type' => 'range',
					'param_name' => 'listing_image_width',
					'value' => 370,
					'min' => 0,
					'max' => 770,
					'heading' => __('Grid image width', 'ALSP'),
					'step' => 1,
					'unit' => 'px',
					//'std' => 2,
			),
			array(
					'type' => 'range',
					'param_name' => 'listing_image_height',
					'value' => 270,
					'min' => 0,
					'max' => 770,
					'heading' => __('Grid image Height', 'ALSP'),
					'step' => 1,
					'unit' => 'px',
					//'std' => 2,
			),
			array(
					'type' => 'textfield',
					'param_name' => 'address',
					'heading' => __('Address', 'ALSP'),
					'description' => __('Display listings near this address, recommended to set "radius" attribute.', 'ALSP'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'radius',
					'heading' => __('Radius', 'ALSP'),
					'description' => __('Display listings near provided address within this radius in miles or kilometers.', 'ALSP'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'author',
					'heading' => __('Author', 'ALSP'),
					'description' => __('Enter exact ID of author or word "related" to get assigned listings of current author (works only on listing page or author page)', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_categories',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Use related categories.', 'ALSP'),
					'description' => __('Parameter works only on listings and categories pages.', 'ALSP'),
			),
			array(
					'type' => 'categoriesfield',
					'param_name' => 'categories',
					//'value' => 0,
					'heading' => __('Select certain categories', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_locations',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Use related locations.', 'ALSP'),
					'description' => __('Parameter works only on listings and locations pages.', 'ALSP'),
			),
			array(
					'type' => 'locationsfield',
					'param_name' => 'locations',
					//'value' => 0,
					'heading' => __('Select certain locations', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_tags',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Use related tags.', 'ALSP'),
					'description' => __('Parameter works only on listings and tags pages.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'include_categories_children',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Include children of selected categories and locations', 'ALSP'),
					'description' => __('When enabled - any subcategories or sublocations will be included as well. Related categories and locations also affected.', 'ALSP'),
			),
			array(
					'type' => 'checkbox',
					'param_name' => 'levels',
					'value' => $levels,
					'heading' => __('Listings levels', 'ALSP'),
					'description' => __('Categories may be dependent from listings levels.', 'ALSP'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'post__in',
					'heading' => __('Exact listings', 'ALSP'),
					'description' => __('Comma separated string of listings IDs. Possible to display exact listings.', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'scroll',
					'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
					'heading' => __('Scroll', 'ALSP'),
					'description' => __('listing carousel', 'ALSP'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'autoplay',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Autoplay', 'ALSP'),
					'description' => __('Autoplay', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'loop',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Loop', 'ALSP'),
					'description' => __('Loop', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'owl_nav',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Scroller Nav', 'ALSP'),
					'description' => __('Scroller Nav', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'gutter',
					'value' => '30',
					'heading' => __('margin ', 'ALSP'),
					'description' => __('margin between columns', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'desktop_items',
					'value' => '3',
					'heading' => __('desktop items ', 'ALSP'),
					'description' => __('items to display above 1025px', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'tab_landscape_items',
					'value' => '3',
					'heading' => __('tab landscape items ', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'tab_items',
					'value' => '2',
					'heading' => __('Tab items', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'delay',
					'value' => '1000',
					'heading' => __('Scroll Delay  ', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'autoplay_speed',
					'value' => '1000',
					'heading' => __('scrolling speed', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
		),
	);
	foreach ($alsp_instance->search_fields->search_fields_array AS $search_field) {
		if (method_exists($search_field, 'getVCParams') && ($field_params = $search_field->getVCParams()))
			$vc_listings_args2['params'] = array_merge($vc_listings_args2['params'], $field_params);
	}
	vc_map($vc_listings_args2);
	
	vc_map(array(
			'name'                    => __('Single Listing', 'ALSP'),
			'description'             => __('The page with single listing', 'ALSP'),
			'base'                    => 'webdirectory-listing',
			'icon'                    => ALSP_RESOURCES_URL . 'images/webdirectory.png',
			'show_settings_on_create' => true,
			'category'                => __('Listing Content', 'ALSP'),
			'params'                  => array(
					array(
							'type' => 'textfield',
							'param_name' => 'listing_id',
							'heading' => __('ID of listing', 'ALSP'),
							'description' => __('Enter exact ID of listing or leave empty to build custom page for any single listing.', 'ALSP'),
					),
			),
		)
	);
	
	$vc_maps_args = array(
			'name'                    => __('Listing Map', 'ALSP'),
			'description'             => __('Listing map and markers', 'ALSP'),
			'base'                    => 'webdirectory-map',
			'icon'                    => ALSP_RESOURCES_URL . 'images/webdirectory.png',
			'show_settings_on_create' => true,
			'category'                => __('Listing Content', 'ALSP'),
			'params'                  => array(
					array(
							'type' => 'dropdown',
							'param_name' => 'custom_home',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Is it on custom home page?', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'uid',
							'value' => '',
							'heading' => __('Enter unique string to connect this shortcode with another shortcodes.', 'ALSP'),
							'dependency' => array('element' => 'custom_home', 'value' => '0'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'search_on_map',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Show search form on the map?', 'ALSP'),
							'dependency' => array('element' => 'custom_home', 'value' => '0'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'num',
							//'value' => -1,
							'heading' => __('Number of markers', 'ALSP'),
							'description' => __('Number of markers to display on map (default -1 this means unlimited).', 'ALSP'),
							'dependency' => array('element' => 'custom_home', 'value' => '0'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'width',
							'heading' => __('Width', 'ALSP'),
							'description' => __('Set map width in pixels. With empty field the map will take all possible width.', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'height',
							'value' => 400,
							'heading' => __('Height', 'ALSP'),
							'description' => __('Set map height in pixels, also possible to set 100% value.', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'map_style',
							'value' => $map_styles,
							'heading' => __('Google Maps style', 'ALSP'),
							'dependency' => array('element' => 'custom_home', 'value' => '0'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'sticky_scroll',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Make map to be sticky on scroll', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'sticky_scroll_toppadding',
							'value' => 10,
							'heading' => __('Sticky scroll top padding', 'ALSP'),
							'description' => __('Top padding in pixels.', 'ALSP'),
							'dependency' => array('element' => 'sticky_scroll', 'value' => '1'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'show_summary_button',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Show summary button?', 'ALSP'),
							'description' => __('Show summary button in InfoWindow?', 'ALSP'),
							'dependency' => array('element' => 'custom_home', 'value' => '0'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'show_readmore_button',
							'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
							'heading' => __('Show readmore button?', 'ALSP'),
							'description' => __('Show read more button in InfoWindow?', 'ALSP'),
							'dependency' => array('element' => 'custom_home', 'value' => '0'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'geolocation',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('GeoLocation', 'ALSP'),
							'description' => __('Enable automatic geolocation.', 'ALSP'),
							'dependency' => array('element' => 'custom_home', 'value' => '0'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'ajax_loading',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('AJAX loading', 'ALSP'),
							'description' => __('When map contains lots of markers - this may slow down map markers loading. Select AJAX to speed up loading. Requires Starting Address or Starting Point coordinates Latitude and Longitude.', 'ALSP'),
							'dependency' => array('element' => 'custom_home', 'value' => '0'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'ajax_markers_loading',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Maps info window AJAX loading', 'ALSP'),
							'description' => __('This may additionaly speed up loading.', 'ALSP'),
							'dependency' => array('element' => 'custom_home', 'value' => '0'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'start_address',
							'heading' => __('Starting Address', 'ALSP'),
							'description' => __('When map markers load by AJAX - it should have starting point and starting zoom. Enter start address or select latitude and longitude. Example: 1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'start_latitude',
							'heading' => __('Starting Point Latitude', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'start_longitude',
							'heading' => __('Starting Point Longitude', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'start_zoom',
							'heading' => __('Starting Point Zoom', 'ALSP'),
							'value' => array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19'),
							//'std' => 11,
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'sticky_featured',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Show markers only of sticky or/and featured listings?', 'ALSP'),
							'description' => __('Whether to show markers only of sticky or/and featured listings.', 'ALSP'),
							'dependency' => array('element' => 'custom_home', 'value' => '0'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'address',
							'heading' => __('Address', 'ALSP'),
							'description' => __('Display markers near this address, recommended to set "radius" attribute.', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'radius',
							'heading' => __('Radius', 'ALSP'),
							'description' => __('display listings near provided address within this radius in miles or kilometers.', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'radius_cycle',
							'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
							'heading' => __('Show radius cycle?', 'ALSP'),
							'description' => __('Display radius cycle on map when radius filter provided.', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'clusters',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Group map markers in clusters?', 'ALSP'),
							'dependency' => array('element' => 'custom_home', 'value' => '0'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'enable_full_screen',
							'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
							'heading' => __('Enable full screen button', 'ALSP'),
							'dependency' => array('element' => 'custom_home', 'value' => '0'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'enable_wheel_zoom',
							'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
							'heading' => __('Enable zoom by mouse wheel', 'ALSP'),
							'dependency' => array('element' => 'custom_home', 'value' => '0'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'enable_dragging_touchscreens',
							'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
							'heading' => __('Enable map dragging on touch screen devices', 'ALSP'),
							'dependency' => array('element' => 'custom_home', 'value' => '0'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'center_map_onclick',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Center map on marker click', 'ALSP'),
							'dependency' => array('element' => 'custom_home', 'value' => '0'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'author',
							'heading' => __('Author', 'ALSP'),
							'description' => __('Enter exact ID of author or word "related" to get assigned listings of current author (works only on listing page or author page)', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'related_categories',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Use related categories.', 'ALSP'),
							'description' => __('Parameter works only on listings and categories pages.', 'ALSP'),
					),
					array(
							'type' => 'categoriesfield',
							'param_name' => 'categories',
							//'value' => 0,
							'heading' => __('Select certain categories', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'related_locations',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Use related locations.', 'ALSP'),
							'description' => __('Parameter works only on listings and locations pages.', 'ALSP'),
					),
					array(
							'type' => 'locationsfield',
							'param_name' => 'locations',
							//'value' => 0,
							'heading' => __('Select certain locations', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'related_tags',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Use related tags.', 'ALSP'),
							'description' => __('Parameter works only on listings and tags pages.', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'include_categories_children',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Include children of selected categories and locations', 'ALSP'),
							'description' => __('When enabled - any subcategories or sublocations will be included as well. Related categories and locations also affected.', 'ALSP'),
					),
					array(
							'type' => 'checkbox',
							'param_name' => 'levels',
							'value' => $levels,
							'heading' => __('Listings levels', 'ALSP'),
							'description' => __('Categories may be dependent from listings levels.', 'ALSP'),
							'dependency' => array('element' => 'custom_home', 'value' => '0'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'post__in',
							'heading' => __('Exact listings', 'ALSP'),
							'description' => __('Comma separated string of listings IDs. Possible to display exact listings.', 'ALSP'),
							'dependency' => array('element' => 'custom_home', 'value' => '0'),
					),
			),
	);
	foreach ($alsp_instance->search_fields->search_fields_array AS $search_field) {
		if (method_exists($search_field, 'getVCParams') && ($field_params = $search_field->getVCParams()))
			$vc_maps_args['params'] = array_merge($vc_maps_args['params'], $field_params);
	}
	vc_map($vc_maps_args);

	vc_map( array(
		'name'                    => __('Categories List', 'ALSP'),
		'description'             => __('Listing categories list', 'ALSP'),
		'base'                    => 'webdirectory-categories',
		'icon'                    => ALSP_RESOURCES_URL . 'images/webdirectory.png',
		'show_settings_on_create' => true,
		'category'                => __('Listing Content', 'ALSP'),
		'params'                  => array(
			/*array(
				'type' => 'dropdown',
				'param_name' => 'custom_home',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('Is it on custom home page?', 'ALSP'),
			),*/
			array(
				'type' => 'dropdown',
				'param_name' => 'cat_style',
				'value' => array(__('Style 1 ( Elca and Max )', 'ALSP') => '1', __('Style 2 Echo', 'ALSP') => '2',  __('Style 3 Zee', 'ALSP') => '3', __('Style 4 Wox', 'ALSP') => '4', __('Style 5 Ultra', 'ALSP') => '5', __('Style 6 Mintox', 'ALSP') => '6', __('Style 7 Zoco', 'ALSP') => '7',  __('Style 8 Fantro (List)', 'ALSP') => '8'),
				'heading' => __('category styles', 'ALSP'),
			),
			array(
				'type' => 'textfield',
				'param_name' => 'parent',
				//'value' => 0,
				'heading' => __('Parent category', 'ALSP'),
				'description' => __('ID of parent category (default 0 – this will build whole categories tree starting from the root).', 'ALSP'),
				'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'depth',
				'value' => array('1', '2'),
				'heading' => __('Categories nesting level', 'ALSP'),
				'description' => __('The max depth of categories tree. When set to 1 – only root categories will be listed.', 'ALSP'),
				"dependency" => array(
                'element' => "cat_style",
                'value' => array(
                    '3',
					'6',
					'7'
                ),
				)
			),
			array(
				'type' => 'textfield',
				'param_name' => 'subcats',
				//'value' => 0,
				'heading' => __('Show subcategories items number', 'ALSP'),
				'description' => __('This is the number of subcategories those will be displayed in the table, when category item includes more than this number "View all" link appears at the bottom.', 'ALSP'),
				'dependency' => array('element' => 'depth', 'value' => '2'),
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'columns',
				'value' => array('1', '2', '3', '4', 'inline'),
				'heading' => __('Categories columns number', 'ALSP'),
				'description' => __('Categories list is divided by columns.', 'ALSP'),
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'count',
				'value' => array(__('Yes', 'ALSP') => '1', __('No', 'ALSP') => '0'),
				'heading' => __('Show category listings count?', 'ALSP'),
				'description' => __('Whether to show number of listings assigned with current category in brackets.', 'ALSP'),
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'scroll',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('scroll', 'ALSP'),
				'description' => __('', 'ALSP'),
				"dependency" => array(
                'element' => "cat_style",
                'value' => array(
                    '1',
					'2',
					'3',
					'4',
					'5'
                ),
				)
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'autoplay',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Autoplay', 'ALSP'),
					'description' => __('Autoplay', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'loop',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Loop', 'ALSP'),
					'description' => __('Loop', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'owl_nav',
					'value' => array(__('No', 'ALSP') => 'false', __('Yes', 'ALSP') => 'true'),
					'heading' => __('Scroller Nav', 'ALSP'),
					'description' => __('Scroller Nav', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'gutter',
					'value' => '30',
					'heading' => __('margin ', 'ALSP'),
					'description' => __('margin between columns', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'desktop_items',
					'value' => '3',
					'heading' => __('desktop items ', 'ALSP'),
					'description' => __('items to display above 1025px', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'tab_landscape_items',
					'value' => '3',
					'heading' => __('tab landscape items ', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'tab_items',
					'value' => '2',
					'heading' => __('Tab items', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'delay',
					'value' => '1000',
					'heading' => __('Scroll Delay  ', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'autoplay_speed',
					'value' => '1000',
					'heading' => __('scrolling speed', 'ALSP'),
					'description' => __('', 'ALSP'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
				'type' => 'checkbox',
				'param_name' => 'levels',
				'value' => $levels,
				'heading' => __('Listings levels', 'ALSP'),
				'description' => __('Categories may be dependent from listings levels.', 'ALSP'),
			),
			array(
				'type' => 'categoriesfield',
				'param_name' => 'categories',
				//'value' => 0,
				'heading' => __('Categories', 'ALSP'),
				'description' => __('Comma separated string of categories slugs or IDs. Possible to display exact categories.', 'ALSP'),
			),
		),
	));

	vc_map( array(
		'name'                    => __('Locations List', 'ALSP'),
		'class'                    => 'location-element',
		'description'             => __('Listing locations list', 'ALSP'),
		'base'                    => 'webdirectory-locations',
		'icon'                    => ALSP_RESOURCES_URL . 'images/webdirectory.png',
		'show_settings_on_create' => true,
		'category'                => __('Listing Content', 'ALSP'),
		'params'                  => array(
			
			/*array(
				'type' => 'dropdown',
				'param_name' => 'custom_home',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('Is it on custom home page?', 'ALSP'),
			),*/
			array(
				'type' => 'dropdown',
				'param_name' => 'location_style',
				'value' => array(__('Default', 'ALSP') => '0', __('Style1', 'ALSP') => '1', __('Style2', 'ALSP') => '2',  __('Style3', 'ALSP') => '3', __('Style4', 'ALSP') => '4',  __('Style5', 'ALSP') => '5',  __('Style6', 'ALSP') => '6',  __('Style 7', 'ALSP') => '7', __('Style 8 solic', 'ALSP') => '8', __('Style 9 Montox', 'ALSP') => '9', __('Style 10 Directory', 'ALSP') => '10'),
				'heading' => __('Location styles', 'ALSP'),
			),
			array(
				'type' => 'textfield',
				'param_name' => 'parent',
				//'value' => 0,
				'heading' => __('Parent location', 'ALSP'),
				'description' => __('ID of parent location (default 0 – this will build whole locations tree starting from the root).', 'ALSP'),
				'dependency' => array('element' => 'custom_home', 'value' => '0'),
			),
			array(
            "type" => "colorpicker",
            "heading" => esc_html__("background Color", "classiadspro"),
            "param_name" => "location_bg",
            "value" => "",
            "description" => esc_html__("", "classiadspro")
			),
		array(
            "type" => "upload",
            "heading" => esc_html__("Background Image", "classiadspro"),
            "param_name" => "location_bg_image",
            "value" => "",
            "description" => esc_html__("", "classiadspro")
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Gredient Color 1", "classiadspro"),
            "param_name" => "gradientbg1",
            "value" => "",
            "description" => esc_html__("", "classiadspro")
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Gredient Color 2", "classiadspro"),
            "param_name" => "gradientbg2",
            "value" => "",
            "description" => esc_html__("", "classiadspro")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Opacity Color 1", "classiadspro"),
            "param_name" => "opacity1",
            "value" => "0",
            "min" => "0",
            "max" => "100",
            "step" => "1",
            "unit" => '%',
            "description" => esc_html__("", "classiadspro")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Opacity Color 2", "classiadspro"),
            "param_name" => "opacity2",
            "value" => "0",
            "min" => "0",
            "max" => "100",
            "step" => "1",
            "unit" => '%',
            "description" => esc_html__("", "classiadspro")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Gredient Angle", "classiadspro"),
            "param_name" => "gradient_angle",
            "value" => "0",
            "min" => "0",
            "max" => "360",
            "step" => "1",
            "unit" => 'deg',
            "description" => esc_html__("", "classiadspro")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Collumn width", "classiadspro"),
            "param_name" => "location_width",
            "value" => "30",
            "min" => "0",
            "max" => "200",
            "step" => "1",
            "unit" => '%',
            "description" => esc_html__("", "classiadspro")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Collumn Height ", "classiadspro"),
            "param_name" => "location_height",
            "value" => "480",
            "min" => "0",
            "max" => "800",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "classiadspro")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Padding Top", "classiadspro"),
            "param_name" => "location_padding",
            "value" => "15",
            "min" => "0",
            "max" => "200",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "classiadspro")
        ),
			array(
				'type' => 'dropdown',
				'param_name' => 'depth',
				'value' => array('1', '2'),
				'heading' => __('Locations nesting level', 'ALSP'),
				'description' => __('The max depth of locations tree. When set to 1 – only root locations will be listed.', 'ALSP'),
			),
			array(
				'type' => 'textfield',
				'param_name' => 'sublocations',
				//'value' => 0,
				'heading' => __('Show sublocations items number', 'ALSP'),
				'description' => __('This is the number of sublocations those will be displayed in the table, when location item includes more than this number "View all sublocations ->" link appears at the bottom.', 'ALSP'),
				'dependency' => array('element' => 'depth', 'value' => '2'),
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'columns',
				'value' => array('1', '2', '3', '4'),
				'heading' => __('Locations columns number', 'ALSP'),
				'description' => __('Locations list is divided by columns.', 'ALSP'),
			),
			array(
				'type' => 'dropdown',
				'param_name' => 'count',
				'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
				'heading' => __('Show location listings count?', 'ALSP'),
				'description' => __('Whether to show number of listings assigned with current location in brackets.', 'ALSP'),
			),
			array(
				'type' => 'locationsfield',
				'param_name' => 'locations',
				//'value' => 0,
				'heading' => __('Locations', 'ALSP'),
				'description' => __('Comma separated string of locations slugs or IDs. Possible to display exact locations.', 'ALSP'),
			),
		),
	));

	vc_map( array(
		'name'                    => __('Search form', 'ALSP'),
		'description'             => __('Listing listings search form', 'ALSP'),
		'base'                    => 'webdirectory-search',
		'icon'                    => ALSP_RESOURCES_URL . 'images/webdirectory.png',
		'show_settings_on_create' => false,
		'category'                => __('Listing Content', 'ALSP'),
		'params'                  => array(
				array(
						'type' => 'textfield',
						'param_name' => 'uid',
						'value' => '',
						'heading' => __('Enter unique string to connect this shortcode with another shortcodes.', 'ALSP'),
				),
				array(
						'type' => 'range',
						'param_name' => 'keyword_field_width',
						'value' => 25,
						'min' => 0,
						'max' => 100,
						'step' => 1,
						'unit' => '%',
						'heading' => __('Set Width for Keyword Field In Search Form', 'ALSP'),
				),
				array(
						'type' => 'range',
						'param_name' => 'category_field_width',
						'value' => 25,
						'min' => 0,
						'max' => 100,
						'step' => 1,
						'unit' => '%',
						'heading' => __('Set Width for Category Field In Search Form', 'ALSP'),
				),
				array(
						'type' => 'range',
						'param_name' => 'location_field_width',
						'value' => 25,
						'min' => 0,
						'max' => 100,
						'step' => 1,
						'unit' => '%',
						'heading' => __('Set Width for Location Field In Search Form', 'ALSP'),
				),
				array(
						'type' => 'range',
						'param_name' => 'address_field_width',
						'value' => 25,
						'min' => 0,
						'max' => 100,
						'step' => 1,
						'unit' => '%',
						'heading' => __('Set Width for Address Field In Search Form', 'ALSP'),
				),
				array(
						'type' => 'range',
						'param_name' => 'radius_field_width',
						'value' => 25,
						'min' => 0,
						'max' => 100,
						'step' => 1,
						'unit' => '%',
						'heading' => __('Set Width for Radius Field In Search Form', 'ALSP'),
				),
				array(
						'type' => 'range',
						'param_name' => 'button_field_width',
						'value' => 25,
						'min' => 0,
						'max' => 100,
						'step' => 1,
						'unit' => '%',
						'heading' => __('Set Width for Search Button Field In Search Form', 'ALSP'),
				),
				array(
						'type' => 'range',
						'param_name' => 'search_button_margin_top',
						'value' => 0,
						'min' => 0,
						'max' => 50,
						'step' => 1,
						'unit' => 'px',
						'heading' => __('Set Margin top for Search Button Field In Search Form', 'ALSP'),
				),
				array(
						'type' => 'range',
						'param_name' => 'gap_in_fields',
						'value' => 10,
						'min' => 0,
						'max' => 100,
						'step' => 1,
						'unit' => '%',
						'heading' => __('Set gap between Field In Search Form', 'ALSP'),
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'advanced_open',
						'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
						'heading' => __('Advanced search panel always open', 'ALSP'),
						'save_always' => true,
				),
				array(
						'type' => 'dropdown',
						'param_name' => 'search_form_type',
						'value' => array(__('Custom', 'ALSP') => '1'),
						'heading' => __('Form Type', 'ALSP'),
						'save_always' => true,
				),
			),
	));
	$vc_slider_args = array(
			'name'                    => __('Listings slider', 'ALSP'),
			'description'             => __('Listing listings in slider view', 'ALSP'),
			'base'                    => 'webdirectory-slider',
			'icon'                    => ALSP_RESOURCES_URL . 'images/webdirectory.png',
			'show_settings_on_create' => true,
			'category'                => __('Listing Content', 'ALSP'),
			'params'                  => array(
					array(
							'type' => 'textfield',
							'param_name' => 'slides',
							'value' => 3,
							'heading' => __('Maximum number of slides', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'max_width',
							'heading' => __('Maximum width of slider in pixels', 'ALSP'),
							'description' => __('Leave empty to make it auto width.', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'height',
							'value' => 230,
							'heading' => __('Height of slider in pixels', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'slide_width',
							'value' => 330,
							'heading' => __('Maximum width of one slide in pixels', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'max_slides',
							'value' => array('2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6'),
							'heading' => __('Maximum number of slides to be shown in carousel', 'ALSP'),
							'description' => __('Slides will be sized up if carousel becomes larger than the original size.', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'auto_slides',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Enable automatic rotating slideshow', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'auto_slides_delay',
							'value' => 3000,
							'heading' => __('The delay in rotation (in ms)', 'ALSP'),
							'dependency' => array('element' => 'auto_slides', 'value' => '1'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'sticky_featured',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Show only sticky or/and featured listings?', 'ALSP'),
							'description' => __('Whether to show only sticky or/and featured listings.', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'order_by_rand',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Order listings randomly?', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'order_by',
							'value' => $ordering,
							'heading' => __('Order by', 'ALSP'),
							'description' => __('Order listings by any of these parameter.', 'ALSP'),
							'dependency' => array('element' => 'order_by_rand', 'value' => '0'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'order',
							'value' => array(__('Ascending', 'ALSP') => 'ASC', __('Descending', 'ALSP') => 'DESC'),
							'description' => __('Direction of sorting.', 'ALSP'),
							'dependency' => array('element' => 'order_by_rand', 'value' => '0'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'address',
							'heading' => __('Address', 'ALSP'),
							'description' => __('Display listings near this address, recommended to set "radius" attribute.', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'radius',
							'heading' => __('Radius', 'ALSP'),
							'description' => __('Display listings near provided address within this radius in miles or kilometers.', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'author',
							'heading' => __('Author', 'ALSP'),
							'description' => __('Enter exact ID of author or word "related" to get assigned listings of current author (works only on listing page or author page)', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'related_categories',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Use related categories.', 'ALSP'),
							'description' => __('Parameter works only on listings and categories pages.', 'ALSP'),
					),
					array(
							'type' => 'categoriesfield',
							'param_name' => 'categories',
							//'value' => 0,
							'heading' => __('Select certain categories', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'related_locations',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Use related locations.', 'ALSP'),
							'description' => __('Parameter works only on listings and locations pages.', 'ALSP'),
					),
					array(
							'type' => 'locationsfield',
							'param_name' => 'locations',
							//'value' => 0,
							'heading' => __('Select certain locations', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'related_tags',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Use related tags.', 'ALSP'),
							'description' => __('Parameter works only on listings and tags pages.', 'ALSP'),
					),
					array(
							'type' => 'dropdown',
							'param_name' => 'include_categories_children',
							'value' => array(__('No', 'ALSP') => '0', __('Yes', 'ALSP') => '1'),
							'heading' => __('Include children of selected categories and locations', 'ALSP'),
							'description' => __('When enabled - any subcategories or sublocations will be included as well. Related categories and locations also affected.', 'ALSP'),
					),
					array(
							'type' => 'checkbox',
							'param_name' => 'levels',
							'value' => $levels,
							'heading' => __('Listings levels', 'ALSP'),
							'description' => __('Categories may be dependent from listings levels.', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'post__in',
							'heading' => __('Exact listings', 'ALSP'),
							'description' => __('Comma separated string of listings IDs. Possible to display exact listings.', 'ALSP'),
					),
			),
	);
	foreach ($alsp_instance->search_fields->search_fields_array AS $search_field) {
		if (method_exists($search_field, 'getVCParams') && ($field_params = $search_field->getVCParams()))
			$vc_slider_args['params'] = array_merge($vc_slider_args['params'], $field_params);
	}
	vc_map($vc_slider_args);
	
	vc_map( array(
		'name'                    => __('Front buttons', 'ALSP'),
		'description'             => __('Submit listing, my bookmarks, edit listing, print listing, ....', 'ALSP'),
		'base'                    => 'webdirectory-buttons',
		'icon'                    => ALSP_RESOURCES_URL . 'images/webdirectory.png',
		'show_settings_on_create' => false,
		'category'                => __('Listing Content', 'ALSP'),
	));

}

add_action('vc_load_default_templates_action', 'alsp_custom_templates_vc');
function alsp_custom_templates_vc() {
	$data               = array();
	$data['name']       = __('Listing custom homepage 1', 'ALSP');
	$data['content']    = <<<CONTENT
        [vc_row][vc_column width="2/3"][webdirectory-search columns="2"][webdirectory custom_home="1"][/vc_column][vc_column width="1/3"][webdirectory-categories parent="0" depth="1" columns="1" subcats="1" count="1" categories="0" custom_home="1" levels="0"][webdirectory-map custom_home="1" sticky_scroll="1" sticky_scroll_toppadding="25" height="100%"][/vc_column][/vc_row]
CONTENT;

	vc_add_default_templates($data);

	$data               = array();
	$data['name']       = __('Listing custom homepage 2', 'ALSP');
	$data['content']    = <<<CONTENT
        [vc_row][vc_column width="1/1"][webdirectory-search columns="2"][/vc_column][/vc_row][vc_row][vc_column width="1/2"][webdirectory-slider slides="10" height="350" slide_width="130" max_slides="4" sticky_featured="0" order_by="post_date" order="ASC" field_methods_of_payment="0" order_by_rand="0" auto_slides="1" auto_slides_delay="3000"][/vc_column][vc_column width="1/2"][webdirectory-map custom_home="1" height="500"][/vc_column][/vc_row][vc_row][vc_column width="1/1"][webdirectory-buttons][webdirectory custom_home="1"][/vc_column][/vc_row]
CONTENT;

	vc_add_default_templates($data);
	
	$data               = array();
	$data['name']       = __('Listing custom homepage 3', 'ALSP');
	$data['content']    = <<<CONTENT
        [vc_row][vc_column width="1/2"][webdirectory-map custom_home="1" sticky_scroll="1" sticky_scroll_toppadding="20" height="100%"][/vc_column][vc_column width="1/2"][webdirectory custom_home="1"][/vc_column][/vc_row][vc_row el_class="scroller_bottom"][/vc_row]
CONTENT;

	vc_add_default_templates($data);
}

?>