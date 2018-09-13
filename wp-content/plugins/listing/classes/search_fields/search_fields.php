<?php

include_once ALSP_PATH . 'classes/search_fields/content_field_search.php';
include_once ALSP_PATH . 'classes/search_fields/fields/content_field_string_search.php';
include_once ALSP_PATH . 'classes/search_fields/fields/content_field_select_search.php';
include_once ALSP_PATH . 'classes/search_fields/fields/content_field_checkbox_search.php';
include_once ALSP_PATH . 'classes/search_fields/fields/content_field_radio_search.php';
include_once ALSP_PATH . 'classes/search_fields/fields/content_field_number_search.php';
include_once ALSP_PATH . 'classes/search_fields/fields/content_field_price_search.php';
include_once ALSP_PATH . 'classes/search_fields/fields/content_field_datetime_search.php';
include_once ALSP_PATH . 'classes/search_fields/fields/content_field_textarea_search.php';

class alsp_search_fields {
	public $search_fields_array = array(); // fields on search form
	public $filter_fields_array = array(); // all content fields available to filter listings
	public $advanced_open = 0;
	public $random_id;
	//public $button_field_width = 25;
	public $gap_in_fields = 10;
	public function __construct() {
		$this->load_search_fields();
		
		add_filter('alsp_search_args', array($this,  'retrieve_search_args'), 100, 4);
		add_filter('alsp_base_url_args', array($this, 'base_url_args'));
		
		// handle search configuration page
		add_action('admin_menu', array($this, 'menu'), 11);
		
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles'), 100);
	}
	
	public function menu() {
		global $alsp_instance;
	
		add_action($alsp_instance->content_fields_manager->menu_page_hook, array($this, 'search_configuration_page'));
	}
	
	public function search_configuration_page() {
		if (isset($_GET['action']) && $_GET['action'] == 'configure_search' && isset($_GET['field_id'])) {
			$field_id = $_GET['field_id'];
			if (isset($this->search_fields_array[$field_id])) {
				$search_field = $this->search_fields_array[$field_id];
				if (method_exists($search_field, 'searchConfigure'))
					$search_field->searchConfigure();
			}
		}
	}
	
	public function load_search_fields() {
		global $alsp_instance;
	
		// load only for our page
		if (!$this->search_fields_array) {
			$content_fields = $alsp_instance->content_fields->content_fields_array;
	
			foreach ($content_fields AS $content_field) {
				$field_search_class = get_class($content_field) . '_search';
				if (class_exists($field_search_class)) {
					$search_field = new $field_search_class;
					$search_field->assignContentField($content_field);
					$search_field->convertSearchOptions();
					if ($content_field->canBeSearched() && (is_admin() || $content_field->on_search_form || $content_field->on_search_form_archive || $content_field->on_search_form_widget)) {
							$this->search_fields_array[$content_field->id] = $search_field;
							$this->filter_fields_array[$content_field->id] = $search_field;
					} else {
						$this->filter_fields_array[$content_field->id] = $search_field;
					}
				}
			}
		}
	}
	
	public function render_content_fields($random_id, $advanced_open = 0, $search_form_type = 6) {
		$is_advanced_search_panel = 0;
		foreach ($this->search_fields_array AS $search_field){
			if ($search_field->content_field->advanced_search_form) {
				$is_advanced_search_panel = 1;
				break;
			}
		}
		//$use_advanced = 1;
		if ((isset($_GET['use_advanced']) && ($_GET['use_advanced'] == 1)) || $advanced_open == 1){
			$use_advanced = 1;
		}else{
			$use_advanced = 0;
		}
		alsp_frontendRender('search_fields/fields_search_form.tpl.php', array('search_fields' => $this->search_fields_array, 'is_advanced_search_panel' => $is_advanced_search_panel, 'use_advanced' => $use_advanced, 'search_form_type' => $search_form_type, 'random_id' => $random_id));
	}
	
	public function retrieve_search_args($args, $defaults = array(), $include_GET_params = true, $shortcode_hash = null) {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;
		$include_tax_children = alsp_getValue($defaults, 'include_categories_children');

		if ($include_GET_params)
			$categories = (alsp_getValue($_REQUEST, 'categories') ? alsp_getValue($_REQUEST, 'categories') : alsp_getValue($defaults, 'categories'));
		else
			$categories = alsp_getValue($defaults, 'categories');

		if ($categories) {
			if ($categories = array_filter(explode(',', $categories), 'trim')) {
				$field = 'term_id';
				foreach ($categories AS $category)
					if (!is_numeric($category))
						$field = 'slug';

				$args['tax_query'][] = array(
						'taxonomy' => ALSP_CATEGORIES_TAX,
						'terms' => $categories,
						'field' => $field,
						'include_children' => $include_tax_children
				);
			}
		}

		if ($search_locations = alsp_getValue($defaults, 'locations')) {
			if ($locations = array_filter(explode(',', $search_locations), 'trim')) {
				$field = 'term_id';
				foreach ($locations AS $location)
					if (!is_numeric($location))
						$field = 'slug';

				$args['tax_query'][] = array(
						'taxonomy' => ALSP_LOCATIONS_TAX,
						'terms' => $locations,
						'field' => $field,
						'include_children' => $include_tax_children
				);
			}
		}

		if ($search_tags = alsp_getValue($defaults, 'tags')) {
			if ($tags = array_filter(explode(',', $search_tags), 'trim')) {
				$field = 'term_id';
				foreach ($tags AS $tag)
				if (!is_numeric($tag))
					$field = 'slug';

				$args['tax_query'][] = array(
						'taxonomy' => ALSP_TAGS_TAX,
						'terms' => $tags,
						'field' => 'term_id'
				);
			}
		}

		if ($include_GET_params) {
			$search_location = alsp_getValue($_REQUEST, 'location_id', alsp_getValue($defaults, 'location_id'));
			$address = trim(alsp_getValue($_REQUEST, 'address', alsp_getValue($defaults, 'address')));
			$radius = alsp_getValue($_REQUEST, 'radius', alsp_getValue($defaults, 'radius'));
		} else {
			$search_location = alsp_getValue($defaults, 'location_id');
			$address = trim(alsp_getValue($defaults, 'address'));
			$radius = alsp_getValue($defaults, 'radius');
		}
		if (!$address && (alsp_getValue($defaults, 'start_address')))
			$address = alsp_getValue($defaults, 'start_address');

		$start_latitude = alsp_getValue($defaults, 'start_latitude');
		$start_longitude = alsp_getValue($defaults, 'start_longitude');

		// Do not search by radius when only location ID was selected
		if ($radius && is_numeric($radius) && ($address || ($start_latitude && $start_longitude))) {
			$alsp_instance->radius_values_array[$shortcode_hash]['radius'] = $radius;

			if (($search_location && is_numeric($search_location)) || $address || ($start_latitude && $start_longitude)) {
				$coords = null;
				if ($address || $search_location) {
					$chain = array();
					$parent_id = $search_location;
					while ($parent_id != 0) {
						if ($term = get_term($parent_id, ALSP_LOCATIONS_TAX)) {
							$chain[] = $term->name;
							$parent_id = $term->parent;
						} else
							$parent_id = 0;
					}
					$location_string = implode(', ', $chain);
					
					if ($address)
						$location_string = $address . ' ' . $location_string;
					if (get_option('alsp_default_geocoding_location'))
						$location_string = $location_string . ' ' . get_option('alsp_default_geocoding_location');
					
					$alsp_locationGeoname = new alsp_locationGeoname();
					$coords = $alsp_locationGeoname->geocodeRequest($location_string, 'coordinates');
				} elseif ($start_latitude && $start_longitude) {
					$coords[1] = $start_latitude;
					$coords[0] = $start_longitude;
				}

				if ($coords) {
					add_filter('alsp_ordering_options', array($this, 'order_by_distance_html'), 10, 4);

					$alsp_instance->radius_values_array[$shortcode_hash]['x_coord'] = $coords[1]; // latitude
					$alsp_instance->radius_values_array[$shortcode_hash]['y_coord'] = $coords[0]; // longitude

					// radius_params must be localized by 2 ways: inside retrieve_search_args() function and in wp_enqueue_scripts hook
					// this one for webdirectory-map shortcode
					if (($frontend_controller = $alsp_instance->getShortcodeByHash($shortcode_hash)) /* && $frontend_controller->google_map */) {
						wp_localize_script(
							'alsp_js_functions',
							'radius_params_'.$shortcode_hash,
							array(
								'radius_value' => $radius,
								'map_coords_1' => $coords[1],
								'map_coords_2' => $coords[0],
								'dimension' => $ALSP_ADIMN_SETTINGS['alsp_miles_kilometers_in_search']
							)
						);
					}

					if (get_option('alsp_miles_kilometers_in_search') == 'miles')
						$R = 3956; // earth's mean radius in miles
					else
						$R = 6367; // earth's mean radius in km

					$dLat = '((map_coords_1-'.$coords[1].')*PI()/180)';
					$dLong = '((map_coords_2-'.$coords[0].')*PI()/180)';
					$a = '(sin('.$dLat.'/2) * sin('.$dLat.'/2) + cos('.$coords[1].'*pi()/180) * cos(map_coords_1*pi()/180) * sin('.$dLong.'/2) * sin('.$dLong.'/2))';
					$c = '2*atan2(sqrt('.$a.'), sqrt(1-'.$a.'))';
					$sql = $R.'*'.$c; 

					global $wpdb, $alsp_address_locations;
					$results = $wpdb->get_results($wpdb->prepare(
						"SELECT DISTINCT
							id, post_id, " . $sql . " AS distance FROM {$wpdb->alsp_locations_relationships}
						HAVING
							distance <= %d
						ORDER BY
							distance
						", $radius), ARRAY_A);

					$post_ids = array();
					$alsp_address_locations = array();
					foreach ($results AS $row) {
						$post_ids[] = $row['post_id'];
						$alsp_address_locations[] = $row['id'];
					}
					$post_ids = array_unique($post_ids);

					if ($post_ids) {
						$args['post__in'] = $post_ids;
					} else
						// Do not show any listings
						$args['post__in'] = array(0);

					$args = $this->order_by_distance_args($args, $defaults, $include_GET_params, $shortcode_hash);
				}
			}
		}

		foreach ($this->filter_fields_array AS $filter_field)
			$filter_field->validateSearch($args, $defaults, $include_GET_params);

		return $args;
	}
	
	public function order_by_distance_args($args, $defaults, $include_GET_params, $shortcode_hash) {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;
		if (isset($alsp_instance->radius_values_array[$shortcode_hash]) && $alsp_instance->radius_values_array[$shortcode_hash]['radius']) {
			if (!isset($defaults['order_by']) || !$defaults['order_by'])
				$defaults['order_by'] = 'distance';
				//$defaults['order'] = 'ASC';
			
			if ($include_GET_params) {
				$order_by = alsp_getValue($_GET, 'order_by', alsp_getValue($defaults, 'order_by'));
				$order = alsp_getValue($_GET, 'order', alsp_getValue($defaults, 'order'));
			} else {
				$order_by = alsp_getValue($defaults, 'order_by');
				$order = alsp_getValue($defaults, 'order');
			}

			// When search by radius - order by distance by default instead of ordering by date
			if ($order_by == 'distance' && $ALSP_ADIMN_SETTINGS['alsp_orderby_distance']) {
				$args['orderby'] = 'post__in';
				unset($args['meta_key']);
				if ($order == 'DESC') {
					if (isset($args['post__in']) && is_array($args['post__in']))
						$args['post__in'] = array_reverse($args['post__in']);
				}
	
				if (!$ALSP_ADIMN_SETTINGS['alsp_orderby_sticky_featured']) {
					// Do not affect levels weights when search by radius
					remove_filter('posts_join', 'join_levels');
					remove_filter('posts_orderby', 'orderby_levels', 1);
					remove_filter('get_meta_sql', 'add_null_values');
				}
			}
		}

		return $args;
	}
	
	public function order_by_distance_html($ordering, $base_url, $defaults = array(), $shortcode_hash = null) {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;

		if (isset($alsp_instance->radius_values_array[$shortcode_hash]) && $alsp_instance->radius_values_array[$shortcode_hash]['radius']) {
			if (!isset($_GET['order_by']) || !$_GET['order_by'] || $_GET['order_by'] == 'distance') {
				if (isset($defaults['order_by']) && $defaults['order_by'] && isset($ordering['array'][$defaults['order_by']])) {
					$url = esc_url(add_query_arg('order_by', $defaults['order_by'], $base_url));
					$ordering['links'][$defaults['order_by']] = '<a href="' . $url . '">' . $ordering['array'][$defaults['order_by']] . '</a>';
					$ordering['struct'][$defaults['order_by']]['url'] = $url;
					$ordering['struct'][$defaults['order_by']]['class'] = '';
				}
	
				$order_by = 'distance';
				$order = alsp_getValue($_GET, 'order', 'ASC');
			} else {
				$order_by = alsp_getValue($defaults, 'order_by');
				$order = alsp_getValue($defaults, 'order');
			}
	
			$class = '';
			$next_order = 'ASC';
			// When search by radius - order by distance by default instead of ordering by date
			if ($order_by == 'distance' && $ALSP_ADIMN_SETTINGS['alsp_orderby_distance']) {
				if (!$order || $order == 'DESC') {
					$class = 'descending';
					$next_order = 'ASC';
					$url = esc_url(add_query_arg('order_by', 'distance', $base_url));
				} elseif ($order == 'ASC') {
					$class = 'ascending';
					$next_order = 'DESC';
					$url = esc_url(add_query_arg('order', $next_order, add_query_arg('order_by', 'distance', $base_url)));
				}
			} else
				$url = esc_url(add_query_arg('order_by', 'distance', $base_url));
	
			$ordering['links']['distance'] = '<a class="' . $class . '" href="' . $url . '">' . __('Distance', 'ALSP') . '</a>';
			$ordering['array']['distance'] = __('Distance', 'ALSP');
			$ordering['struct']['distance'] = array('class' => $class, 'url' => $url, 'field_name' => __('Distance', 'ALSP'), 'order' => $next_order);
		}

		return $ordering;
	}
	
	public function base_url_args($args) {
		if (isset($_GET['categories']) && $_GET['categories'] && is_numeric($_GET['categories']))
			$args['categories'] = $_GET['categories'];
		if (isset($_GET['radius']) && $_GET['radius'] && is_numeric($_GET['radius']))
			$args['radius'] = $_GET['radius'];

		//$this->load_search_fields();
		foreach ($this->search_fields_array AS $search_field)
			$search_field->getBaseUrlArgs($args);
		
		return $args;
	}
	
	public function enqueue_scripts_styles() {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;
	
		if (!(function_exists('is_rtl') && is_rtl()))
			wp_enqueue_script('jquery-ui-slider');
		else {
			wp_register_style('jquery-ui-slider', ALSP_RESOURCES_URL . 'css/jquery.ui.slider-rtl.css');
			wp_deregister_script('jquery-ui-slider');
			wp_register_script('jquery-ui-slider', ALSP_RESOURCES_URL . 'js/jquery.ui.slider-rtl.min.js', array('jquery-ui-core') , false, true);
			wp_enqueue_style('jquery-ui-slider');
			wp_enqueue_script('jquery-ui-slider');
		}

		wp_enqueue_script('jquery-touch-punch');
	
		wp_localize_script(
			'jquery-ui-slider',
			'slider_params',
			array(
				'min' => $ALSP_ADIMN_SETTINGS['alsp_radius_search_min'],
				'max' => $ALSP_ADIMN_SETTINGS['alsp_radius_search_max']
			)
		);

		// radius_params must be localized by 2 ways: inside retrieve_search_args() function and in wp_enqueue_scripts hook
		// this one for webdirectory shortcode
		foreach ($alsp_instance->radius_values_array AS $shortcode_hash=>$value) {
			if (($frontend_controller = $alsp_instance->getShortcodeByHash($shortcode_hash)) && isset($value['x_coord']) && isset($value['y_coord'])) {
				wp_localize_script(
					'alsp_js_functions',
					'radius_params_'.$frontend_controller->hash,
					array(
						'radius_value' => $value['radius'],
						'map_coords_1' => $value['x_coord'],
						'map_coords_2' => $value['y_coord'],
						'dimension' => $ALSP_ADIMN_SETTINGS['alsp_miles_kilometers_in_search']
					)
				);
			}
		}
	}
}

?>