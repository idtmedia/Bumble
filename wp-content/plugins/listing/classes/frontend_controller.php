<?php 

class alsp_frontend_controller {
	public $args = array();
	public $query;
	public $page_title;
	public $template;
	public $listings = array();
	public $search_form;
	public $google_map;
	public $paginator;
	public $breadcrumbs = array();
	public $base_url;
	public $messages = array();
	public $hash = null;
	public $levels_ids;
	public $do_initial_load = true;
	public $request_by = 'frontend_controller';
	public $scroll = '0';

	public function __construct($args = array()) {
		apply_filters('alsp_frontend_controller_construct', $this);
	}
	
	public function init($attrs = array()) {
		global $ALSP_ADIMN_SETTINGS;
		$this->args['logo_animation_effect'] = get_option('alsp_logo_animation_effect');
		$this->args['listing_post_style'] = $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'];

		if (!$this->hash)
			if (isset($attrs['uid']) && $attrs['uid'])
				$this->hash = md5($attrs['uid']);
			else
				$this->hash = md5(get_class($this).serialize($attrs));
	}
	public function processQuery($load_map = true, $map_args = array()) {
		global $ALSP_ADIMN_SETTINGS;
		// this is special construction,
		// this needs when we order by any postmeta field, this adds listings to the list with "empty" fields
		if (isset($this->query->query_vars['orderby']) && ($this->query->query_vars['orderby'] == 'meta_value_num' || $this->query->query_vars['orderby'] == 'meta_value') && (!isset($this->query->query_vars['meta_key']) || $this->query->query_vars['meta_key'] != '_order_date')) {
			$args = $this->query->query_vars;

			// there is strange thing - WP adds `taxonomy` and `term_id` args to the root of query vars array
			// this may cause problems
			unset($args['taxonomy']);
			unset($args['term_id']);
			if (empty($args['s']))
				unset($args['s']);
			
			$original_posts_per_page = $args['posts_per_page'];

			$ordered_posts_ids = get_posts(array_merge($args, array('fields' => 'ids', 'nopaging' => true)));
			//var_dump($ordered_posts_ids);
			$ordered_max_num_pages = ceil(count($ordered_posts_ids)/$original_posts_per_page) - (int) $ordered_posts_ids;

			$args['paged'] = $args['paged'] - $ordered_max_num_pages;
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = '_order_date';
			$args['order'] = 'DESC';
			$args['posts_per_page'] = $original_posts_per_page - $this->query->post_count;
			$all_posts_ids = get_posts(array_merge($args, array('fields' => 'ids', 'nopaging' => true)));
			$all_posts_count = count($all_posts_ids);
			//var_dump($all_posts_count);

			if ($this->query->found_posts) {
				$args['post__not_in'] = array_map('intval', $ordered_posts_ids);
				if (isset($args['post__in']) && is_array($args['post__in']) && $args['post__in']) {
					$args['post__in'] = array_diff($args['post__in'], $args['post__not_in']);
					if (!$args['post__in'])
						$args['posts_per_page'] = 0;
				}
			}

			$unordered_query = new WP_Query($args);
			//var_dump($args);

			//var_dump($unordered_query->request);
			//var_dump($this->query->request);

			if ($args['posts_per_page'])
				$this->query->posts = array_merge($this->query->posts, $unordered_query->posts);

			$this->query->post_count = count($this->query->posts);
			$this->query->found_posts = $all_posts_count;
			$this->query->max_num_pages = ceil($all_posts_count/$original_posts_per_page);
		}

		if ($load_map) {
			$this->google_map = new alsp_google_maps($map_args);
			$this->google_map->setUniqueId($this->hash);
		}
		
		while ($this->query->have_posts()) {
			$this->query->the_post();

			$listing = new alsp_listing;
			$listing->loadListingFromPost(get_post());
			$listing->logo_animation_effect = (isset($this->args['logo_animation_effect'])) ? $this->args['logo_animation_effect'] : get_option('alsp_logo_animation_effect');
			$listing->listing_post_style = (isset($this->args['listing_post_style'])) ? $this->args['listing_post_style']: $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'];
			$listing->listing_image_width = (isset($this->args['listing_image_width'])) ? $this->args['listing_image_width']: $ALSP_ADIMN_SETTINGS['alsp_logo_width'];
			$listing->listing_image_height = (isset($this->args['listing_image_height'])) ? $this->args['listing_image_height']: $ALSP_ADIMN_SETTINGS['alsp_logo_height'];
			
			if ($load_map && !$this->google_map->is_ajax_markers_management())
				$this->google_map->collectLocations($listing);
			
			$this->listings[get_the_ID()] = $listing;
		}
		
		global $alsp_address_locations, $alsp_tax_terms_locations;
		// empty this global arrays - there may be some google maps on one page with different arguments
		$alsp_address_locations = array();
		$alsp_tax_terms_locations = array();

		// this is reset is really required after the loop ends 
		wp_reset_postdata();
		
		remove_filter('posts_join', 'join_levels');
		remove_filter('posts_orderby', 'orderby_levels', 1);
		remove_filter('get_meta_sql', 'add_null_values');
	}
	
	public function getQuery() {
		return $this->query;
	}
	
	public function getPageTitle() {
		return $this->page_title;
	}

	public function getBreadCrumbs() {
		//if (!(function_exists('is_rtl') && is_rtl()))
			return implode(' » ', $this->breadcrumbs);
		/* else
			return implode(' « ', array_reverse($this->breadcrumbs)); */
	}

	public function getBaseUrl() {
		return $this->base_url;
	}
	
	public function where_levels_ids($where = '') {
		if ($this->levels_ids)
			$where .= " AND (alsp_levels.id IN (" . implode(',', $this->levels_ids) . "))";
		return $where;
	}
	
	public function display() {
		$output =  alsp_frontendRender($this->template, array('frontend_controller' => $this), true);
		wp_reset_postdata();
	
		return $output;
	}
}

/**
 * join levels_relationships and levels tables into the query
 * 
 * */
function join_levels($join = '') {
	global $wpdb;

	$join .= " LEFT JOIN {$wpdb->alsp_levels_relationships} AS alsp_lr ON alsp_lr.post_id = {$wpdb->posts}.ID ";
	$join .= " LEFT JOIN {$wpdb->alsp_levels} AS alsp_levels ON alsp_levels.id = alsp_lr.level_id ";

	return $join;
}

/**
 * sticky and featured listings in the first order
 * 
 */
function orderby_levels($orderby = '') {
	$orderby = " alsp_levels.sticky DESC, alsp_levels.featured DESC, " . $orderby;
	return $orderby;
}

/**
 * sticky and featured listings in the first order
 * 
 */
function where_sticky_featured($where = '') {
	$where .= " AND (alsp_levels.sticky=1 OR alsp_levels.featured=1)";
	return $where;
}

/**
 * Listings with empty values must be sorted as well
 * 
 */
function add_null_values($clauses) {
	$clauses['where'] = preg_replace("/wp_postmeta\.meta_key = '_content_field_([0-9]+)'/", "(wp_postmeta.meta_key = '_content_field_$1' OR wp_postmeta.meta_value IS NULL)", $clauses['where']);
	return $clauses;
}


add_filter('alsp_order_args', 'alsp_order_listings', 10, 3);
function alsp_order_listings($order_args = array(), $defaults = array(), $include_GET_params = true) {
	global $alsp_instance, $ALSP_ADIMN_SETTINGS;

	if ($include_GET_params && isset($_GET['order_by']) && $_GET['order_by']) {
		$order_by = $_GET['order_by'];
		$order = alsp_getValue($_GET, 'order', 'ASC');
	} else {
		if (isset($defaults['order_by']) && $defaults['order_by']) {
			$order_by = $defaults['order_by'];
			$order = alsp_getValue($defaults, 'order', 'ASC');
		} else {
			$order_by = 'post_date';
			$order = 'DESC';
		}
	}

	$order_args['order'] = $order;

	if ($order_by == 'rand') {
		// do not order by rand in search results
		if (!$alsp_instance->getShortcodeProperty('webdirectory', 'is_search')) {
			if ($ALSP_ADIMN_SETTINGS['alsp_orderby_sticky_featured']) {
				add_filter('posts_join', 'join_levels');
				add_filter('posts_orderby', 'orderby_levels', 1);
			}
			$order_args['orderby'] = 'rand';
		} else 
			$order_by = 'post_date';
	}

	if ($order_by == 'title') {
		//$order_args['orderby'] = 'title';
		$order_args['orderby'] = array('title' => $order_args['order'], 'meta_value_num' => 'ASC');
		$order_args['meta_key'] = '_order_date';
		if ($ALSP_ADIMN_SETTINGS['alsp_orderby_sticky_featured']) {
			add_filter('posts_join', 'join_levels');
			add_filter('posts_orderby', 'orderby_levels', 1);
		}
	} elseif ($order_by == 'post_date' || $ALSP_ADIMN_SETTINGS['alsp_orderby_sticky_featured']) {
		// Do not affect levels weights when already ordering by posts IDs
		if (!isset($order_args['orderby']) || $order_args['orderby'] != 'post__in') {
			add_filter('posts_join', 'join_levels');
			add_filter('posts_orderby', 'orderby_levels', 1);
			add_filter('get_meta_sql', 'add_null_values');
		}

		if ($order_by == 'post_date') {
			$alsp_instance->order_by_date = true;
			// First of all order by _order_date parameter
			$order_args['orderby'] = 'meta_value_num';
			$order_args['meta_key'] = '_order_date';
		} else
			$order_args = array_merge($order_args, $alsp_instance->content_fields->getOrderParams($defaults));
	} else
		$order_args = array_merge($order_args, $alsp_instance->content_fields->getOrderParams($defaults));

	return $order_args;
}

function alsp_what_search($args, $defaults = array(), $include_GET_params = true) {
	if ($include_GET_params)
		$args['s'] = alsp_getValue($_GET, 'what_search', alsp_getValue($defaults, 'what_search'));
	else
		$args['s'] =  alsp_getValue($defaults, 'what_search');

	return $args;
}
add_filter('alsp_search_args', 'alsp_what_search', 10, 3);

function alsp_address($args, $defaults = array(), $include_GET_params = true) {
	global $wpdb, $alsp_address_locations;

	if ($include_GET_params) {
		$address = alsp_getValue($_GET, 'address', alsp_getValue($defaults, 'address'));
		$search_location = alsp_getValue($_GET, 'location_id', alsp_getValue($defaults, 'location_id'));
	} else {
		$search_location = alsp_getValue($defaults, 'location_id');
		$address = alsp_getValue($defaults, 'address');
	}
	
	$where_sql_array = array();
	if ($search_location && is_numeric($search_location)) {
		$term_ids = get_terms(ALSP_LOCATIONS_TAX, array('child_of' => $search_location, 'fields' => 'ids', 'hide_empty' => false));
		$term_ids[] = $search_location;
		$where_sql_array[] = "(location_id IN (" . implode(', ', $term_ids) . "))";
	}
	
	if ($address)
		$where_sql_array[] = $wpdb->prepare("(address_line_1 LIKE '%%%s%%' OR address_line_2 LIKE '%%%s%%' OR zip_or_postal_index LIKE '%%%s%%')", $address, $address, $address);

	if ($where_sql_array) {
		$results = $wpdb->get_results("SELECT id, post_id FROM {$wpdb->alsp_locations_relationships} WHERE " . implode(' AND ', $where_sql_array), ARRAY_A);
		$post_ids = array();
		foreach ($results AS $row) {
			$post_ids[] = $row['post_id'];
			$alsp_address_locations[] = $row['id'];
		}
		if ($post_ids)
			$args['post__in'] = $post_ids;
		else
			// Do not show any listings
			$args['post__in'] = array(0);	
	}
	return $args;
}
add_filter('alsp_search_args', 'alsp_address', 10, 3);

function alsp_base_url_args($args) {
	global $ALSP_ADIMN_SETTINGS;
	if (isset($_GET['what_search']) && $_GET['what_search'])
		$args['what_search'] = urlencode($_GET['what_search']);
	if (isset($_GET['address']) && $_GET['address'])
		$args['address'] = urlencode($_GET['address']);
	if (isset($_GET['location_id']) && $_GET['location_id'] && is_numeric($_GET['location_id']))
		$args['location_id'] = $_GET['location_id'];
	
	// Required in ajax controller for get_pagenum_link() filter
	if ($ALSP_ADIMN_SETTINGS['alsp_ajax_initial_load']) {
		if (isset($_GET['order_by']) && $_GET['order_by'])
			$args['order_by'] = $_GET['order_by'];
		if (isset($_GET['order']) && $_GET['order'])
			$args['order'] = $_GET['order'];
	}

	return $args;
}
add_filter('alsp_base_url_args', 'alsp_base_url_args');

function alsp_related_shortcode_args($shortcode_atts) {
	global $alsp_instance;

	if ((isset($shortcode_atts['categories']) && $shortcode_atts['categories'] == 'related') || (isset($shortcode_atts['related_categories']) && $shortcode_atts['related_categories'])) {
		if (($directory_controller = $alsp_instance->getShortcodeProperty('webdirectory')) || ($directory_controller = $alsp_instance->getShortcodeProperty('webdirectory-listing'))) {
			if ($directory_controller->is_category) {
				$shortcode_atts['categories'] = $directory_controller->category->term_id;
			} elseif ($directory_controller->is_single) {
				if ($terms = get_the_terms($directory_controller->listing->post->ID, ALSP_CATEGORIES_TAX)) {
					$terms_ids = array();
					foreach ($terms AS $term)
						$terms_ids[] = $term->term_id;
					$shortcode_atts['categories'] = implode(',', $terms_ids);
				}
				$shortcode_atts['post__not_in'] = $directory_controller->listing->post->ID;
			}
		}
	}

	if ((isset($shortcode_atts['locations']) && $shortcode_atts['locations'] == 'related') || (isset($shortcode_atts['related_locations']) && $shortcode_atts['related_locations'])) {
		if (($directory_controller = $alsp_instance->getShortcodeProperty('webdirectory')) || ($directory_controller = $alsp_instance->getShortcodeProperty('webdirectory-listing'))) {
			if ($directory_controller->is_location) {
				$shortcode_atts['locations'] = $directory_controller->location->term_id;
			} elseif ($directory_controller->is_single) {
				if ($terms = get_the_terms($directory_controller->listing->post->ID, ALSP_LOCATIONS_TAX)) {
					$terms_ids = array();
					foreach ($terms AS $term)
						$terms_ids[] = $term->term_id;
					$shortcode_atts['locations'] = implode(',', $terms_ids);
				}
				$shortcode_atts['post__not_in'] = $directory_controller->listing->post->ID;
			}
		}
	}

	if (isset($shortcode_atts['related_tags']) && $shortcode_atts['related_tags']) {
		if (($directory_controller = $alsp_instance->getShortcodeProperty('webdirectory')) || ($directory_controller = $alsp_instance->getShortcodeProperty('webdirectory-listing'))) {
			if ($directory_controller->is_tag) {
				$shortcode_atts['tags'] = $directory_controller->tag->term_id;
			} elseif ($directory_controller->is_single) {
				if ($terms = get_the_terms($directory_controller->listing->post->ID, ALSP_TAGS_TAX)) {
					$terms_ids = array();
					foreach ($terms AS $term)
						$terms_ids[] = $term->term_id;
					$shortcode_atts['tags'] = implode(',', $terms_ids);
				}
				$shortcode_atts['post__not_in'] = $directory_controller->listing->post->ID;
			}
		}
	}

	if (isset($shortcode_atts['author']) && $shortcode_atts['author'] === 'related') {
		if (($directory_controller = $alsp_instance->getShortcodeProperty('webdirectory')) || ($directory_controller = $alsp_instance->getShortcodeProperty('webdirectory-listing'))) {
			if ($directory_controller->is_single) {
				$shortcode_atts['author'] = $directory_controller->listing->post->post_author;
				$shortcode_atts['post__not_in'] = $directory_controller->listing->post->ID;
			}
		} elseif ($user_id = get_the_author_meta('ID')) {
			$shortcode_atts['author'] = $user_id;
		}
	}

	return $shortcode_atts;
}
add_filter('alsp_related_shortcode_args', 'alsp_related_shortcode_args');

?>