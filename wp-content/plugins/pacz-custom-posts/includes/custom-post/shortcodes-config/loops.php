<?php
if(class_exists('alsp_plugin')){
global $alsp_instance, $alsp_fsubmit_instance, $alsp_maps_styles;
	
	$map_styles = array('default' => '');
	foreach ($alsp_maps_styles AS $name=>$style)
		$map_styles[$name] = $name;

	$levels = array(__('All', 'pacz') => 0);
	foreach ($alsp_instance->levels->levels_array AS $level) {
		$levels[$level->name] = $level->id;
	}

	$ordering = alsp_orderingItems();
$vc_listings_args2 = array(
		'name'                    => __('ClassiadsPro Listings', 'pacz'),
		'description'             => __('Listing listings filtered by params', 'pacz'),
		'base'                    => 'webdirectory-listings2',
		'icon'                    => ALSP_RESOURCES_URL . 'images/webdirectory.png',
		'show_settings_on_create' => true,
		'category'                => __('Listing Content', 'pacz'),
		'params'                  => array(
			array(
					'type' => 'textfield',
					'param_name' => 'uid',
					'value' => '',
					'heading' => __('Enter unique string to connect this shortcode with another shortcodes.', 'pacz'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'onepage',
					'value' => array(__('No', 'pacz') => '0', __('Yes', 'pacz') => '1'),
					'heading' => __('Show all possible listings on one page?', 'pacz'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'ajax_initial_load',
					'value' => array(__('No', 'pacz') => '0', __('Yes', 'pacz') => '1'),
					'heading' => __('Load listings only after the page was completely loaded.', 'pacz'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'perpage',
					'value' => 10,
					'heading' => __('Number of listing per page', 'pacz'),
					'description' => __('Number of listings to display per page. Set -1 to display all listings without paginator.', 'pacz'),
					'dependency' => array('element' => 'onepage', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_paginator',
					'value' => array(__('No', 'pacz') => '0', __('Yes', 'pacz') => '1'),
					'heading' => __('Hide paginator', 'pacz'),
					'description' => __('When paginator is hidden - it will display only exact number of listings.', 'pacz'),
					'dependency' => array('element' => 'onepage', 'value' => '0'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'sticky_featured',
					'value' => array(__('No', 'pacz') => '0', __('Yes', 'pacz') => '1'),
					'heading' => __('Show only sticky or/and featured listings?', 'pacz'),
					'description' => __('Whether to show only sticky or/and featured listings.', 'pacz'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'order_by',
					'value' => $ordering,
					'heading' => __('Order by', 'pacz'),
					'description' => __('Order listings by any of these parameter.', 'pacz'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'order',
					'value' => array(__('Ascending', 'pacz') => 'ASC', __('Descending', 'pacz') => 'DESC'),
					'description' => __('Direction of sorting.', 'pacz'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_order',
					'value' => array(__('No', 'pacz') => '0', __('Yes', 'pacz') => '1'),
					'heading' => __('Hide ordering links?', 'pacz'),
					'description' => __('Whether to hide ordering navigation links.', 'pacz'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'hide_count',
					'value' => array(__('No', 'pacz') => '0', __('Yes', 'pacz') => '1'),
					'heading' => __('Hide number of listings?', 'pacz'),
					'description' => __('Whether to hide number of found listings.', 'pacz'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'show_views_switcher',
					'value' => array(__('Yes', 'pacz') => '1', __('No', 'pacz') => '0'),
					'heading' => __('Show listings views switcher?', 'pacz'),
					'description' => __('Whether to show listings views switcher.', 'pacz'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'listings_view_type',
					'value' => array(__('List', 'pacz') => 'list', __('Grid', 'pacz') => 'grid'),
					'heading' => __('Listings view by default', 'pacz'),
					'description' => __('Do not forget that selected view will be stored in cookies.', 'pacz'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'listings_view_grid_columns',
					'value' => array('1', '2', '3', '4'),
					'heading' => __('Number of columns for listings Grid View', 'pacz'),
					//'std' => 2,
			),
			array(
					'type' => 'textfield',
					'param_name' => 'listing_thumb_width',
					//'value' => 300,
					'heading' => __('Listing thumbnail logo width in List View', 'pacz'),
					'description' => __('in pixels', 'pacz'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'wrap_logo_list_view',
					'value' => array(__('No', 'pacz') => '0', __('Yes', 'pacz') => '1'),
					'heading' => __('Wrap logo image by text content in List View', 'pacz'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'logo_animation_effect',
					'value' => array(
							__('No effect', 'pacz') => 0,
							//sprintf(__('Animation effect #%d', 'pacz'), 1) => 1,
							//sprintf(__('Animation effect #%d', 'pacz'), 2) => 2,
							//sprintf(__('Animation effect #%d', 'pacz'), 3) => 3,
							//sprintf(__('Animation effect #%d', 'pacz'), 4) => 4,
							//sprintf(__('Animation effect #%d', 'pacz'), 5) => 5,
							sprintf(__('Animation effect #%d', 'pacz'), 6) => 6
					),
					//'std' => 6,
					'heading' => __('Thumbnail animation hover effect', 'pacz'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'address',
					'heading' => __('Address', 'pacz'),
					'description' => __('Display listings near this address, recommended to set "radius" attribute.', 'pacz'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'radius',
					'heading' => __('Radius', 'pacz'),
					'description' => __('Display listings near provided address within this radius in miles or kilometers.', 'pacz'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'author',
					'heading' => __('Author', 'pacz'),
					'description' => __('Enter exact ID of author or word "related" to get assigned listings of current author (works only on listing page or author page)', 'pacz'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_categories',
					'value' => array(__('No', 'pacz') => '0', __('Yes', 'pacz') => '1'),
					'heading' => __('Use related categories.', 'pacz'),
					'description' => __('Parameter works only on listings and categories pages.', 'pacz'),
			),
			array(
					'type' => 'categoriesfield',
					'param_name' => 'categories',
					//'value' => 0,
					'heading' => __('Select certain categories', 'pacz'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_locations',
					'value' => array(__('No', 'pacz') => '0', __('Yes', 'pacz') => '1'),
					'heading' => __('Use related locations.', 'pacz'),
					'description' => __('Parameter works only on listings and locations pages.', 'pacz'),
			),
			array(
					'type' => 'locationsfield',
					'param_name' => 'locations',
					//'value' => 0,
					'heading' => __('Select certain locations', 'pacz'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'related_tags',
					'value' => array(__('No', 'pacz') => '0', __('Yes', 'pacz') => '1'),
					'heading' => __('Use related tags.', 'pacz'),
					'description' => __('Parameter works only on listings and tags pages.', 'pacz'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'include_categories_children',
					'value' => array(__('No', 'pacz') => '0', __('Yes', 'pacz') => '1'),
					'heading' => __('Include children of selected categories and locations', 'pacz'),
					'description' => __('When enabled - any subcategories or sublocations will be included as well. Related categories and locations also affected.', 'pacz'),
			),
			array(
					'type' => 'checkbox',
					'param_name' => 'levels',
					'value' => $levels,
					'heading' => __('Listings levels', 'pacz'),
					'description' => __('Categories may be dependent from listings levels.', 'pacz'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'post__in',
					'heading' => __('Exact listings', 'pacz'),
					'description' => __('Comma separated string of listings IDs. Possible to display exact listings.', 'pacz'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'scroll',
					'value' => array(__('No', 'pacz') => '0', __('Yes', 'pacz') => '1'),
					'heading' => __('Scroll', 'pacz'),
					'description' => __('listing carousel', 'pacz'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'autoplay',
					'value' => array(__('No', 'pacz') => 'false', __('Yes', 'pacz') => 'true'),
					'heading' => __('Autoplay', 'pacz'),
					'description' => __('Autoplay', 'pacz'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'loop',
					'value' => array(__('No', 'pacz') => 'false', __('Yes', 'pacz') => 'true'),
					'heading' => __('Loop', 'pacz'),
					'description' => __('Loop', 'pacz'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'dropdown',
					'param_name' => 'owl_nav',
					'value' => array(__('No', 'pacz') => 'false', __('Yes', 'pacz') => 'true'),
					'heading' => __('Scroller Nav', 'pacz'),
					'description' => __('Scroller Nav', 'pacz'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'gutter',
					'value' => '30',
					'heading' => __('margin ', 'pacz'),
					'description' => __('margin between columns', 'pacz'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'desktop_items',
					'value' => '3',
					'heading' => __('desktop items ', 'pacz'),
					'description' => __('items to display above 1025px', 'pacz'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'tab_landscape_items',
					'value' => '3',
					'heading' => __('tab landscape items ', 'pacz'),
					'description' => __('', 'pacz'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'tab_items',
					'value' => '2',
					'heading' => __('Tab items', 'pacz'),
					'description' => __('', 'pacz'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'delay',
					'value' => '1000',
					'heading' => __('Scroll Delay  ', 'pacz'),
					'description' => __('', 'pacz'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
			array(
					'type' => 'textfield',
					'param_name' => 'autoplay_speed',
					'value' => '1000',
					'heading' => __('scrolling speed', 'pacz'),
					'description' => __('', 'pacz'),
					'dependency' => array('element' => 'scroll', 'value' => '1'),
			),
		),
	);
foreach ($alsp_instance->search_fields->search_fields_array AS $search_field) {
		if (method_exists($search_field, 'getVCParams') && ($field_params = $search_field->getVCParams()))
			$vc_listings_args2['params'] = array_merge($vc_listings_args2['params'], $field_params);
	}
	vc_map($vc_listings_args2);
}
vc_map(array(
    "name" => esc_html__("Employees", "pacz"),
    "base" => "pacz_employees",
    'icon' => 'icon-pacz-employees vc_pacz_element-icon',
    "category" => esc_html__('Loops', 'pacz'),
    'description' => esc_html__( 'Shows Employees posts in multiple styles.', 'pacz' ),
    "params" => array(
        /*array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", "pacz"),
            "param_name" => "style",
            "width" => 300,
            "value" => array(
               esc_html__('Column Based (Rounded)', "pacz") => "column_rounded",
                esc_html__('Column Based', "pacz") => "column",
                esc_html__('grid', "pacz") => "grid"
            ),
            "description" => esc_html__("", "pacz")
        ),*/
		array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", "pacz"),
            "param_name" => "hover_style",
            "width" => 300,
            "value" => array(
               esc_html__('Style 1', "pacz") => "1",
                esc_html__('Style 2', "pacz") => "2"
            ),
            "description" => esc_html__("team hover styles", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Column", "pacz"),
            "param_name" => "column",
            "value" => "4",
            "min" => "1",
            "max" => "4",
            "step" => "1",
            "unit" => 'columns',
            "description" => esc_html__("Defines how many column to be in one row.", "pacz")
        ),
       array(
            "type" => "range",
            "heading" => esc_html__("Image Width Dimension", "pacz"),
            "param_name" => "dimension",
            "value" => "370",
            "min" => "100",
            "max" => "600",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("This value wil be applied to employee image width & height. Be infomed social network icons will not be displayed in image size less than 200px.", "pacz")
        ), 
		array(
            "type" => "range",
            "heading" => esc_html__("Image height Dimension", "pacz"),
            "param_name" => "dimensionh",
            "value" => "256",
            "min" => "100",
            "max" => "600",
            "step" => "1",
            "unit" => 'px', 
            "description" => esc_html__("This value wil be applied to employee image width & height. Be infomed social network icons will not be displayed in image size less than 200px.", "pacz")
        ), 
        array(
            "type" => "range",
            "heading" => esc_html__("Count", "pacz"),
            "param_name" => "count",
            "value" => "4",
            "min" => "-1",
            "max" => "4",
            "step" => "1",
            "unit" => 'employee',
            "description" => esc_html__("How many Employees you would like to show? -1 will means whatever you have chosen in wordpress => reading => posts per page option.", "pacz")
        ),
        array(
            "type" => "multiselect",
            "heading" => esc_html__("Select specific Employees", "pacz"),
            "param_name" => "employees",
            "value" => '',
            "options" => $employees,
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Offset", "pacz"),
            "param_name" => "offset",
            "value" => "0",
            "min" => "0",
            "max" => "50",
            "step" => "1",
            "unit" => 'posts',
            "description" => esc_html__("Number of post to displace or pass over, it means based on your order of the loop, this number will define how many posts to pass over and start from the nth number of the offset.", "pacz")
        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__("scroller", "pacz"),
            "param_name" => "scroll",
			"value" => "true",
            "description" => esc_html__("put loop scroller on or off", "pacz"),

        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__("Auto Scroll", "pacz"),
            "param_name" => "autoplay",
            "value" => "false",
            "description" => esc_html__("Auto scroll on or off", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__(" Scroller navigation", "pacz"),
            "param_name" => "owl_nav",
            "value" => "false",
            "description" => esc_html__(" scroll navigation on or off", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__(" Scroller item loop", "pacz"),
            "param_name" => "item_loop",
            "value" => "false",
            "description" => esc_html__(" scroller item  on or off", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller autoplay speed", "pacz"),
            "param_name" => "autoplay_speed",
            "value" => "2000",
			"min" => "0",
			"max" => "10000",
			"step" => "1",
			"unit" => "ms",
            "description" => esc_html__(" scroller autoplay speed", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller autoplay Delay", "pacz"),
            "param_name" => "delay",
            "value" => "1000",
			"min" => "0",
			"max" => "5000",
			"step" => "1",
			"unit" => "ms",
            "description" => esc_html__("Scroller autoplay Delay per slider", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items gutter space", "pacz"),
            "param_name" => "gutter_space",
            "value" => "30",
			"min" => "0",
			"max" => "50",
			"step" => "1",
			"unit" => "px",
            "description" => esc_html__("Scroller items gutter space, defualt is 30px you can set 0 to 100px but not in -ve value", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items for desktop above 1025px", "pacz"),
            "param_name" => "desktop_items",
            "value" => "3",
			"min" => "1",
			"max" => "8",
			"step" => "1",
			"unit" => "items",
            "description" => esc_html__("Scroller items for desktop above 1025px, adjust items according to your layout", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items for tabs landscape from 960px to 1024px", "pacz"),
            "param_name" => "tab_landscape_items",
            "value" => "3",
			"min" => "1",
			"max" => "6",
			"step" => "1",
			"unit" => "items",
            "description" => esc_html__("Scroller items for tabs landscape from 960px to 1024px, adjust items according to your layout", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items for tabs from 768px to 959px", "pacz"),
            "param_name" => "tab_items",
            "value" => "2",
			"min" => "1",
			"max" => "4",
			"step" => "1",
			"unit" => "items",
            "description" => esc_html__("Scroller items for tabs landscape from 960px to 1024px, adjust items according to your layout", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
       /* array(
            "type" => "toggle",
            "heading" => esc_html__("Description", "pacz"),
            "param_name" => "description",
            "value" => "true",
            "description" => esc_html__("If you dont want to show Employees description disable this option.", "pacz")
        ), */

        array(
            "heading" => esc_html__("Order", 'pacz'),
            "description" => esc_html__("Designates the ascending or descending order of the 'orderby' parameter.", 'pacz'),
            "param_name" => "order",
            "value" => array(
                esc_html__("DESC (descending order)", 'pacz') => "DESC",
                esc_html__("ASC (ascending order)", 'pacz') => "ASC"

            ),
            "type" => "dropdown"
        ),
        array(
            "heading" => esc_html__("Orderby", 'pacz'),
            "description" => esc_html__("Sort retrieved employee items by parameter.", 'pacz'),
            "param_name" => "orderby",
            "value" => $pacz_orderby,
            "type" => "dropdown"
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Employee Image Stretchability", "pacz"),
            "param_name" => "full_width_image",
            "value" => "false",
            "description" => esc_html__("Enabling this option will set employee image cover the whole grid area.", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Viewport Animation", "pacz"),
            "param_name" => "animation",
            "value" => $css_animations,
            "description" => esc_html__("Viewport animation will be triggered when this element is being viewed when you scroll page down. you only need to choose the animation style from this option. please note that this only works in moderns. We have disabled this feature in touch devices to increase browsing speed.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz")
        )

    )
));

vc_map(array(
    "name" => esc_html__("Clients", "pacz"),
    "base" => "pacz_clients",
    'icon' => 'icon-pacz-clients vc_pacz_element-icon',
    "category" => esc_html__('Loops', 'pacz'),
    'description' => esc_html__( 'Shows Clients posts in multiple styles.', 'pacz' ),
    "params" => array(
		array(
            "heading" => esc_html__("Clients Wrapper Style", 'pacz'),
            "description" => esc_html__("Choose clients loop style", 'pacz'),
            "param_name" => "client_style",
            "value" => array(
                esc_html__("Style 1", 'pacz') => "1",
				esc_html__("Style 2", 'pacz') => "2",
               
            ),
            "type" => "dropdown"
        ),
        array(
            "heading" => esc_html__("Style", 'pacz'),
            "description" => esc_html__("Choose clients loop style", 'pacz'),
            "param_name" => "style",
            "value" => array(
                esc_html__("Column", 'pacz') => "column",
                //esc_html__("Grid", 'pacz') => "grid"
            ),
            "type" => "dropdown"
        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__("Shadow on hover", "pacz"),
            "param_name" => "clinet_shadow",
			"value" => "false",
            "description" => esc_html__("put hover shadow on or off", "pacz"),
        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__("Turn Border On/Off", "pacz"),
            "param_name" => "border",
			"value" => "true",
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("How many Columns?", "pacz"),
            "param_name" => "column",
            "value" => "3",
            "min" => "1",
            "max" => "6",
            "step" => "1",
            "unit" => 'columns',
            "description" => esc_html__("This option defines how many columns will be set in one row. This option only works for column style", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'column'
                )
            )
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Client Item height", "pacz"),
            "param_name" => "item_height",
            "value" => "120",
            "min" => "100",
            "max" => "500",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("Defines the client item height. please note that this option only works for column style.", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'column'
                )
            )
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Count", "pacz"),
            "param_name" => "count",
            "value" => "4",
            "min" => "-1",
            "max" => "50",
            "step" => "1",
            "unit" => 'clients',
            "description" => esc_html__("How many Clients you would like to show? -1 will means whatever you have chosen in wordpress => reading => posts per page option.", "pacz")
        ),
       /* array(
            "heading" => esc_html__("Scroller", 'pacz'),
            "description" => esc_html__("If you enable this option grids will be horizontally scroller and you can swipe through items.", 'pacz'),
            "param_name" => "scroll",
            "value" => array(
                esc_html__("Enable", 'pacz') => "true",
                esc_html__("Disable", 'pacz') => "false"
            ),
            "type" => "dropdown",
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'grid'
                )
            )
        ),*/
        array(
            "type" => "multiselect",
            "heading" => esc_html__("Select specific Clients", "pacz"),
            "param_name" => "clients",
            "value" => '',
            "options" => $clients,
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__("scroller", "pacz"),
            "param_name" => "scroll",
			"value" => "true",
            //"value" => array(
				//esc_html__("Off", 'pacz') => "false",
               // esc_html__("On", 'pacz') => "true"
                
           // ),
            "description" => esc_html__("put loop scroller on or off", "pacz"),
        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__("Auto Scroll", "pacz"),
            "param_name" => "autoplay",
            "value" => "false",
            "description" => esc_html__("Auto scroll on or off", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__(" Scroller navigation", "pacz"),
            "param_name" => "owl_nav",
            "value" => "false",
            "description" => esc_html__(" scroll navigation on or off", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__(" Scroller item loop", "pacz"),
            "param_name" => "item_loop",
            "value" => "false",
            "description" => esc_html__(" scroller item  on or off", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller autoplay speed", "pacz"),
            "param_name" => "autoplay_speed",
            "value" => "2000",
			"min" => "0",
			"max" => "10000",
			"step" => "1",
			"unit" => "ms",
            "description" => esc_html__(" scroller autoplay speed", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller autoplay Delay", "pacz"),
            "param_name" => "delay",
            "value" => "1000",
			"min" => "0",
			"max" => "5000",
			"step" => "1",
			"unit" => "ms",
            "description" => esc_html__("Scroller autoplay Delay per slider", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items gutter space", "pacz"),
            "param_name" => "gutter_space",
            "value" => "30",
			"min" => "0",
			"max" => "50",
			"step" => "1",
			"unit" => "px",
            "description" => esc_html__("Scroller items gutter space, defualt is 30px you can set 0 to 100px but not in -ve value", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items for desktop above 1025px", "pacz"),
            "param_name" => "desktop_items",
            "value" => "5",
			"min" => "1",
			"max" => "8",
			"step" => "1",
			"unit" => "items",
            "description" => esc_html__("Scroller items for desktop above 1025px, adjust items according to your layout", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items for tabs landscape from 960px to 1024px", "pacz"),
            "param_name" => "tab_landscape_items",
            "value" => "3",
			"min" => "1",
			"max" => "6",
			"step" => "1",
			"unit" => "items",
            "description" => esc_html__("Scroller items for tabs landscape from 960px to 1024px, adjust items according to your layout", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items for tabs from 768px to 959px", "pacz"),
            "param_name" => "tab_items",
            "value" => "2",
			"min" => "1",
			"max" => "4",
			"step" => "1",
			"unit" => "items",
            "description" => esc_html__("Scroller items for tabs landscape from 960px to 1024px, adjust items according to your layout", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),

        array(
            "heading" => esc_html__("Order", 'pacz'),
            "description" => esc_html__("Designates the ascending or descending order of the 'orderby' parameter.", 'pacz'),
            "param_name" => "order",
            "value" => array(
                esc_html__("DESC (descending order)", 'pacz') => "DESC",
                esc_html__("ASC (ascending order)", 'pacz') => "ASC"
            ),
            "type" => "dropdown"
        ),
        array(
            "heading" => esc_html__("Orderby", 'pacz'),
            "description" => esc_html__("Sort retrieved client items by parameter.", 'pacz'),
            "param_name" => "orderby",
            "value" => $pacz_orderby,
            "type" => "dropdown"
        ),
       /* array(
            "type" => "colorpicker",
            "heading" => esc_html__("Box Background Color", "pacz"),
            "param_name" => "bg_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Box Border Color", "pacz"),
            "param_name" => "border_color",
            "value" => "",
            "description" => esc_html__("Please note that this option only works for Column style as well as grid style (when scroller is enabled).", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Box Border Width", "pacz"),
            "param_name" => "border_width",
            "value" => "2",
            "min" => "0",
            "max" => "5",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Logo Box Dimension", "pacz"),
            "param_name" => "dimension",
            "value" => "120",
            "min" => "50",
            "max" => "600",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("This value will be applied to logo box width & height.", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'grid'
                )
            )
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Fit to Background", "pacz"),
            "description" => esc_html__("Scale the background image to be as large as possible so that the background area is completely covered by the background image. Some parts of the background image may not be in view within the background positioning area", "pacz"),
            "param_name" => "cover",
            "value" => "false"
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Hover State Company Details.", "pacz"),
            "param_name" => "hover_state",
            "value" => "false"
        ),*/

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Target", "pacz"),
            "param_name" => "target",
            "width" => 200,
            "value" => $target_arr,
            "description" => esc_html__("Target for the links.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz")
        )

    )
));


vc_map(array(
    "name" => esc_html__("Blog", "pacz"),
    "base" => "pacz_blog",
     'icon' => 'icon-pacz-blog vc_pacz_element-icon',
    "category" => esc_html__('Loops', 'pacz'),
    'description' => esc_html__( 'Blog loops are here.', 'pacz' ),
    "params" => array(

        array(
            "heading" => esc_html__("Style", 'pacz'),
            "description" => esc_html__("please select which blog loop style you would like to use.", 'pacz'),
            "param_name" => "style",
            "value" => array(
                esc_html__("Classic", 'pacz') => "classic",
                //esc_html__("Modern", 'pacz') => "modern",
               // esc_html__("Masonry", 'pacz') => "masonry",
                esc_html__("Tile", 'pacz') => "tile",
				esc_html__("Tile Elegant", 'pacz') => "tile_elegant",
               // esc_html__("Magazine", 'pacz') => "magazine",
                esc_html__("Thumbnail", 'pacz') => "thumb",
               // esc_html__("List", 'pacz') => "list",
               // esc_html__("Scroller", 'pacz') => "scroller",
               // esc_html__("Slideshow", 'pacz') => "slideshow"
            ),
            "type" => "dropdown"
        ),
        /*array(
            "type" => "dropdown",
            "heading" => esc_html__("Loop Structure (Magazine Style Only)", 'pacz'),
            "description" => esc_html__("", 'pacz'),
            "param_name" => "magazine_strcutre",
            "value" => array(
                esc_html__("One Column", 'pacz') => 1,
                esc_html__("Two Columns (Featured post on left side)", 'pacz') => 2,
                esc_html__("Two Columns (Featured post on right side)", 'pacz') => 3,

            ),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'magazine'
                )
            ),
        ),*/
		array(
            "type" => "dropdown",
            "heading" => esc_html__("scroller", "pacz"),
            "param_name" => "scroll",
            "value" => array(
				esc_html__("Off", 'pacz') => "false",
                esc_html__("On", 'pacz') => "true"
                
            ),
            "description" => esc_html__("put loop scroller on or off", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                   // 'grid',
                   // 'masonry',
                    'standard',
                    //'flip'
                )
            )

        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__("Auto Scroll", "pacz"),
            "param_name" => "autoplay",
            "value" => "false",
            "description" => esc_html__("Auto scroll on or off", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__(" Scroller navigation", "pacz"),
            "param_name" => "owl_nav",
            "value" => "false",
            "description" => esc_html__(" scroll navigation on or off", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__(" Scroller item loop", "pacz"),
            "param_name" => "items_loop",
            "value" => "false",
            "description" => esc_html__(" scroller item  on or off", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller autoplay speed", "pacz"),
            "param_name" => "autoplay_speed",
            "value" => "2000",
			"min" => "0",
			"max" => "10000",
			"step" => "1",
			"unit" => "ms",
            "description" => esc_html__(" scroller autoplay speed", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller autoplay Delay", "pacz"),
            "param_name" => "delay",
            "value" => "1000",
			"min" => "0",
			"max" => "5000",
			"step" => "1",
			"unit" => "ms",
            "description" => esc_html__("Scroller autoplay Delay per slider", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items gutter space", "pacz"),
            "param_name" => "gutter_space",
            "value" => "30",
			"min" => "0",
			"max" => "50",
			"step" => "1",
			"unit" => "px",
            "description" => esc_html__("Scroller items gutter space, defualt is 30px you can set 0 to 100px but not in -ve value", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items for desktop above 1025px", "pacz"),
            "param_name" => "desktop_items",
            "value" => "3",
			"min" => "1",
			"max" => "8",
			"step" => "1",
			"unit" => "items",
            "description" => esc_html__("Scroller items for desktop above 1025px, adjust items according to your layout", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items for tabs landscape from 960px to 1024px", "pacz"),
            "param_name" => "tab_landscape_items",
            "value" => "3",
			"min" => "1",
			"max" => "6",
			"step" => "1",
			"unit" => "items",
            "description" => esc_html__("Scroller items for tabs landscape from 960px to 1024px, adjust items according to your layout", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items for tabs from 768px to 959px", "pacz"),
            "param_name" => "tab_items",
            "value" => "2",
			"min" => "1",
			"max" => "4",
			"step" => "1",
			"unit" => "items",
            "description" => esc_html__("Scroller items for tabs landscape from 960px to 1024px, adjust items according to your layout", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
       /* array(
            "type" => "toggle",
            "heading" => esc_html__("Author Thumbnail (Only for Tile Style)", "pacz"),
            "param_name" => "author",
            "value" => "true",
            "description" => esc_html__("Using this option you can disable/enable author avatar from blog loop tile style.", "pacz"),
             "dependency" => array(
                'element' => "style",
                'value' => array(
                    'tile'
                )
            ),
        ),
         array(
            "type" => "dropdown",
            "heading" => esc_html__("Slideshow Layout (Slideshow Style Only)", 'pacz'),
            "description" => esc_html__("This option will let you control the slideshow layout to be full or with sidebar layout. If you are using it in a page section to have it fullwidth but the page layout is with sidebar, then you can use this option to override the functionality.", 'pacz'),
            "param_name" => "slideshow_layout",
            "value" => array(
                esc_html__("Default", 'pacz') => 'default',
                esc_html__("Full Layout", 'pacz') => 'full',
                esc_html__("With Sidebar", 'pacz') => 'sidebar',

            ),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'slideshow'
                )
            ),
        ),*/

        array(
            "type" => "range",
            "heading" => esc_html__("How many Columns?", "pacz"),
            "param_name" => "column",
            "value" => "3",
            "min" => "1",
            "max" => "4",
            "step" => "1",
            "unit" => 'columns',
            "description" => esc_html__("This option defines how many columns will be set in one row.", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'tile_elegant',
                    'tile',
                )
            )
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Images Width", "pacz"),
            "param_name" => "image_width",
            "value" => "350",
            "min" => "100",
            "max" => "1000",
            "step" => "1",
            "unit" => 'px',
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Images Height", "pacz"),
            "param_name" => "image_height",
            "value" => "260",
            "min" => "100",
            "max" => "1000",
            "step" => "1",
            "unit" => 'px',
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Image Cropping.", "pacz"),
            "description" => esc_html__("If you have this option enabled the image will be cropped based on the image height option above and the width we dynamically calculate for the layout and column you choose. if you want to show the full size featured image disable this option.", "pacz"),
            "param_name" => "cropping",
            "value" => "true",
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'classic',
                    'tile_elegant',
                    'tile',
                    //'modern',
                    //'magazine'
                )
            )
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("How many Posts in a page?", "pacz"),
            "param_name" => "count",
            "value" => "10",
            "min" => "-1",
            "max" => "50",
            "step" => "1",
            "unit" => 'posts',
            "description" => esc_html__("How many Posts you would like to show? (-1 means unlimited, please note that unlimited will be overrided the limit you defined at : Wordpress Sidebar > Settings > Reading > Blog pages show at most.)", "pacz"),
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Offset", "pacz"),
            "param_name" => "offset",
            "value" => "0",
            "min" => "0",
            "max" => "50",
            "step" => "1",
            "unit" => 'posts',
            "description" => esc_html__("Number of post to displace or pass over, it means based on your order of the loop, this number will define how many posts to pass over and start from the nth number of the offset.", "pacz"),
        ),
        array(
            "type" => "multiselect",
            "heading" => esc_html__("Select specific Categories", "pacz"),
            "param_name" => "cat",
            "options" => $categories,
            "value" => '',
            "description" => esc_html__("", "pacz"),
        ),

        array(
            "type" => "multiselect",
            "heading" => esc_html__("Select specific Posts", "pacz"),
            "param_name" => "posts",
            "options" => $posts,
            "value" => '',
            "description" => esc_html__("", "pacz"),
        ),

        array(
            "type" => "toggle",
            "heading" => esc_html__("Post Meta", "pacz"),
            "param_name" => "disable_meta",
            "value" => "true",
            "description" => esc_html__("If you dont want to show post meta (author and categories) disable this option.", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'classic',
                    'tile_elegant',
                    'tile',
                    //'scroller',
                    //'slideshow',
                    //'modern'
                )
            )
        ),


        array(
            "type" => "dropdown",
            "heading" => esc_html__("Content Type (Classic Style Only)", 'pacz'),
            "description" => esc_html__("You can show blog full content in classic style loop.", 'pacz'),
            "param_name" => "classic_excerpt",
            "value" => array(
                esc_html__("Summry (Excerpt)", 'pacz') => "excerpt",
                esc_html__("Full content", 'pacz') => "content"
            ),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'classic'
					
                )
            ),
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Pagination?", "pacz"),
            "param_name" => "pagination",
            "value" => "true",
            "description" => esc_html__("If you dont want to have pagination for this loop disable this option.", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'classic',
                   'tile_elegant',
                    'tile',
                    'thumb',
                    //'list',
                   // 'modern'
                )
            )
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Pagination Style", 'pacz'),
            "description" => esc_html__("please select which pagination style you would like to use on this loop.", 'pacz'),
            "param_name" => "pagination_style",
            "value" => array(
                esc_html__("Classic Pagination Navigation", 'pacz') => "1",
                esc_html__("Load more button", 'pacz') => "2"
            ),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'classic',
                    'tile_elegant',
                    'tile',
                    'thumb',
                    //'list',
                    //'modern'

                )
            )
        ),
		 array(
            "type" => "dropdown",
            "heading" => esc_html__("Thumb style colums", 'pacz'),
            "description" => esc_html__("please select which pagination style you would like to use on this loop.", 'pacz'),
            "param_name" => "thumb_column",
            "value" => array(
                esc_html__("One column", 'pacz') => "one-column",
                esc_html__("Two column", 'pacz') => "two-column"
            ),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'thumb'

                )
            )
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("Post Excerpt Length", "pacz"),
            "description" => esc_html__("Define the length of the length of the excerpt in number of characters. Zero will disable excerpt.", 'pacz'),
            "param_name" => "excerpt_length",
            "value" => "200",
            "min" => "0",
            "max" => "2000",
            "step" => "1",
            "unit" => 'characters',
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'classic',
                   'tile_elegant',
                    'tile',
					'thumb',
                    //'list',
                    //'magazine',
                )
            )
        ),

        array(
            "type" => "toggle",
            "heading" => esc_html__("Sortable?", "pacz"),
            "param_name" => "sortable",
            "value" => "false",
            "description" => esc_html__("If you dont want sortable filter navigation disable this option.", "pacz"),
             "dependency" => array(
                'element' => "scroll",
                'value' => array(
                   // 'classic',
                   // 'masonry',
                   // 'tile',
                   // 'list',
                   // 'thumb',
                    //'modern',
					'false'
                )
            )
        ),

        array(
            "heading" => esc_html__("Order", 'pacz'),
            "description" => esc_html__("Designates the ascending or descending order of the 'orderby' parameter.", 'pacz'),
            "param_name" => "order",
            "value" => array(
                esc_html__("DESC (descending order)", 'pacz') => "DESC",
                esc_html__("ASC (ascending order)", 'pacz') => "ASC"
            ),
            "type" => "dropdown"
        ),
        array(
            "heading" => esc_html__("Orderby", 'pacz'),
            "description" => esc_html__("Sort retrieved Blog items by parameter.", 'pacz'),
            "param_name" => "orderby",
            "value" => $pacz_orderby,
            "type" => "dropdown"
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz")
        ),
        array(
            'type' => 'item_id',
            'heading' => esc_html__( 'Item ID', 'pacz' ),
            'param_name' => "item_id"
        )

    )
));

if(function_exists( 'is_woocommerce' )) {
    $categories = get_terms( 'product_cat', array(
                    'orderby'    => 'count',
                    'hide_empty' => 0,
                 ) );
    $product_cats = array();
    if(is_array($categories)){
        foreach($categories as $cats){
            $product_cats[$cats->slug] = $cats->slug;
        }
    }

vc_map(array(
    "name" => esc_html__("Product Loops", "pacz"),
    "base" => "pacz_products",
    "icon" => 'icon-pacz-blog vc_pacz_element-icon',
    "category" => esc_html__('Loops', 'pacz'),
    'description' => esc_html__( 'Product loops are here.', 'pacz' ),
    "params" => array(

        array(
            "heading" => esc_html__("Style", 'pacz'),
            "description" => esc_html__("please select which woocommerce loop style you would like to use.", 'pacz'),
            "param_name" => "style",
            "value" => array(
                esc_html__("Classic", 'pacz') => "classic",
               // esc_html__("Modern", 'pacz') => "modern",
            ),
            "type" => "dropdown"
        ),

        array(
            "heading" => esc_html__("Display", 'pacz'),
            "description" => esc_html__("", 'pacz'),
            "param_name" => "display",
            "value" => array(
                esc_html__("Recent Products", 'pacz') => "recent",
                esc_html__("Featured Products", 'pacz') => "featured",
                esc_html__("Top Rated Products", 'pacz') => "top_rated",
                esc_html__("Product Category", 'pacz') => "product_category",
                esc_html__("Products on Sale", 'pacz') => "products_on_sale",
                esc_html__("Best Sellings Products", 'pacz') => "best_sellings"
            ),
            "type" => "dropdown"
        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__("scroller", "pacz"),
            "param_name" => "scroll",
			"value" => "true",
            "description" => esc_html__("put loop scroller on or off", "pacz"),

        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__("Auto Scroll", "pacz"),
            "param_name" => "autoplay",
            "value" => "false",
            "description" => esc_html__("Auto scroll on or off", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__(" Scroller navigation", "pacz"),
            "param_name" => "owl_nav",
            "value" => "false",
            "description" => esc_html__(" scroll navigation on or off", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__(" Scroller item loop", "pacz"),
            "param_name" => "item_loop",
            "value" => "false",
            "description" => esc_html__(" scroller item  on or off", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller autoplay speed", "pacz"),
            "param_name" => "autoplay_speed",
            "value" => "2000",
			"min" => "0",
			"max" => "10000",
			"step" => "1",
			"unit" => "ms",
            "description" => esc_html__(" scroller autoplay speed", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller autoplay Delay", "pacz"),
            "param_name" => "delay",
            "value" => "1000",
			"min" => "0",
			"max" => "5000",
			"step" => "1",
			"unit" => "ms",
            "description" => esc_html__("Scroller autoplay Delay per slider", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items gutter space", "pacz"),
            "param_name" => "gutter_space",
            "value" => "0",
			"min" => "0",
			"max" => "50",
			"step" => "1",
			"unit" => "px",
            "description" => esc_html__("Scroller items gutter space, defualt is 30px you can set 0 to 100px but not in -ve value", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items for desktop above 1025px", "pacz"),
            "param_name" => "desktop_items",
            "value" => "1",
			"min" => "1",
			"max" => "8",
			"step" => "1",
			"unit" => "items",
            "description" => esc_html__("Scroller items for desktop above 1025px, adjust items according to your layout", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items for tabs landscape from 960px to 1024px", "pacz"),
            "param_name" => "tab_landscape_items",
            "value" => "1",
			"min" => "1",
			"max" => "6",
			"step" => "1",
			"unit" => "items",
            "description" => esc_html__("Scroller items for tabs landscape from 960px to 1024px, adjust items according to your layout", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items for tabs from 768px to 959px", "pacz"),
            "param_name" => "tab_items",
            "value" => "1",
			"min" => "1",
			"max" => "4",
			"step" => "1",
			"unit" => "items",
            "description" => esc_html__("Scroller items for tabs landscape from 960px to 1024px, adjust items according to your layout", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
        array(
            "type" => "multiselect",
            "heading" => esc_html__("Select specific Categories", "pacz"),
            "param_name" => "category",
            "options" => $product_cats,
            "value" => '',
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "display",
                'value' => array(
                    'product_category',
                )
            )
        ),
		
        array(
            "heading" => esc_html__("Orderby", 'pacz'),
            "description" => esc_html__("Sort retrieved Blog items by parameter.", 'pacz'),
            "param_name" => "orderby",
            "value" => $pacz_product_orderby,
            "type" => "dropdown"
        ),
        array(
            "heading" => esc_html__("Order", 'pacz'),
            "description" => esc_html__("Designates the ascending or descending order of the 'orderby' parameter.", 'pacz'),
            "param_name" => "order",
            "value" => array(
                esc_html__("DESC (descending order)", 'pacz') => "DESC",
                esc_html__("ASC (ascending order)", 'pacz') => "ASC"
            ),
            "type" => "dropdown"
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("How many Columns?", "pacz"),
            "param_name" => "column",
            "value" => "3",
            "min" => "1",
            "max" => "4",
            "step" => "1",
            "unit" => 'columns',
            "description" => esc_html__("This option defines how many columns will be set in one row.", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("How many Product?", "pacz"),
            "param_name" => "product_per_page",
            "value" => "12",
            "min" => "4",
            "max" => "20",
            "step" => "1",
            "unit" => 'product',
            "description" => esc_html__("This option defines how many producr will be set in a page.", "pacz")
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Pagination", "pacz"),
            "description" => esc_html__("", "pacz"),
            "param_name" => "pagination",
            "value" => "true"
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz")
        )
    )
));
}
