<?php 

class alsp_levels {
	public $levels_array = array();

	public function __construct() {
		$this->getLevelsFromDB();
	}
	
	public function saveOrder($order_input) {
		global $wpdb;

		if ($order_ids = explode(',', trim($order_input))) {
			$i = 1;
			foreach ($order_ids AS $id) {
				$wpdb->update($wpdb->alsp_levels, array('order_num' => $i), array('id' => $id));
				$i++;
			}
		}
		$this->getLevelsFromDB();
		return true;
	}
	
	public function getLevelsFromDB() {
		global $wpdb;
		$this->levels_array = array();

		$array = $wpdb->get_results("SELECT * FROM {$wpdb->alsp_levels} ORDER BY order_num", ARRAY_A);
		foreach ($array AS $row) {
			$level = new alsp_level;
			$level->buildLevelFromArray($row);
			$this->levels_array[$row['id']] = $level;
		}
	}
	
	public function getLevelById($level_id) {
		if (isset($this->levels_array[$level_id]))
			return $this->levels_array[$level_id];
	}
	
	public function getDefaultLevel() {
		$array_keys = array_keys($this->levels_array);
		$first_id = array_shift($array_keys);
		return $this->getLevelById($first_id);
	}

	public function createLevelFromArray($array) {
		global $wpdb, $alsp_instance;
		
		$insert_update_args = array(
				'name' => alsp_getValue($array, 'name'),
				'description' => alsp_getValue($array, 'description'),
				'active_interval' => alsp_getValue($array, 'active_interval', 1),
				'active_period' => alsp_getValue($array, 'active_period', 'day'),
				'eternal_active_period' => alsp_getValue($array, 'eternal_active_period', 0),
				'listings_in_package' => alsp_getValue($array, 'listings_in_package', 1),
				'change_level_id' => alsp_getValue($array, 'change_level_id', 1),
				'raiseup_enabled' => alsp_getValue($array, 'raiseup_enabled'),
				'sticky' => alsp_getValue($array, 'sticky'),
				'listings_own_page' => alsp_getValue($array, 'listings_own_page'),
				'nofollow' => alsp_getValue($array, 'nofollow'),
				'featured' => alsp_getValue($array, 'featured'),
				'categories_number' => alsp_getValue($array, 'categories_number', 0),
				'locations_number' => alsp_getValue($array, 'locations_number', 1),
				'unlimited_categories' => alsp_getValue($array, 'unlimited_categories'),
				'google_map' => alsp_getValue($array, 'google_map'),
				'logo_enabled' => alsp_getValue($array, 'logo_enabled'),
				'featured_level' => $array['featured_level'],
				'allow_resurva_booking' => $array['allow_resurva_booking'],
				'images_number' => alsp_getValue($array, 'images_number'),
				'videos_number' => alsp_getValue($array, 'videos_number'),
				'categories' => serialize($array['categories_list']),
				'locations' => serialize($array['locations_list']),
				'content_fields' => serialize($array['content_fields_list']),
				'locations_number' => alsp_getValue($array, 'locations_number', 1),
				'google_map_markers' => alsp_getValue($array, 'google_map_markers', 1),
		);
		$insert_update_args = apply_filters('alsp_level_create_edit_args', $insert_update_args, $array);

		if ($wpdb->insert($wpdb->alsp_levels, $insert_update_args)) {
			$new_level_id = $wpdb->insert_id;
			
			do_action('alsp_update_level', $new_level_id, $array);
			
			$this->getLevelsFromDB();
			$levels = $alsp_instance->levels;
			$results = array();
			foreach ($levels->levels_array AS $level) {
				$results[$level->id]['disabled'] = false;
				$results[$level->id]['raiseup'] = false;
			}
			$level = $this->getLevelById($new_level_id);
			$level->saveUpgradeMeta($results);
			return true;
		}
	}
	
	public function saveLevelFromArray($level_id, $array) {
		global $wpdb;

		$insert_update_args = array(
				'name' => alsp_getValue($array, 'name'),
				'description' => alsp_getValue($array, 'description'),
				'active_interval' => alsp_getValue($array, 'active_interval'),
				'active_period' => alsp_getValue($array, 'active_period'),
				'eternal_active_period' => alsp_getValue($array, 'eternal_active_period'),
				'listings_in_package' => alsp_getValue($array, 'listings_in_package'),
				'change_level_id' => alsp_getValue($array, 'change_level_id'),
				'sticky' => alsp_getValue($array, 'sticky'),
				'listings_own_page' => alsp_getValue($array, 'listings_own_page'),
				'nofollow' => alsp_getValue($array, 'nofollow'),
				'raiseup_enabled' => alsp_getValue($array, 'raiseup_enabled'),
				'featured' => alsp_getValue($array, 'featured'),
				'categories_number' => alsp_getValue($array, 'categories_number'),
				'locations_number' => alsp_getValue($array, 'locations_number', 1),
				'unlimited_categories' => alsp_getValue($array, 'unlimited_categories'),
				'google_map' => alsp_getValue($array, 'google_map'),
				'logo_enabled' => alsp_getValue($array, 'logo_enabled'),
				'featured_level' => $array['featured_level'],
				'allow_resurva_booking' => $array['allow_resurva_booking'],
				'images_number' => alsp_getValue($array, 'images_number'),
				'videos_number' => alsp_getValue($array, 'videos_number'),
				'categories' => serialize($array['categories_list']),
				'locations' => serialize($array['locations_list']),
				'content_fields' => serialize($array['content_fields_list']),
				'locations_number' => alsp_getValue($array, 'locations_number', 1),
				'google_map_markers' => alsp_getValue($array, 'google_map_markers', 1),
		);
		$insert_update_args = apply_filters('alsp_level_create_edit_args', $insert_update_args, $array);
	
		if ($wpdb->update($wpdb->alsp_levels, $insert_update_args, array('id' => $level_id), null, array('%d')) !== false) {
			do_action('alsp_update_level', $level_id, $array);
			
			$old_level = $this->getLevelById($level_id);
			$this->getLevelsFromDB();
			$new_level = $this->getLevelById($level_id);
			
			// update listings from eternal active period to numeric
			if ($old_level->eternal_active_period && !$new_level->eternal_active_period) {
				$expiration_date = alsp_calcExpirationDate(current_time('timestamp'), $new_level);
				$postids = $this->getPostIdsByLevelId($level_id);
				foreach ($postids AS $post_id) {
					delete_post_meta($post_id, '_expiration_date');
					update_post_meta($post_id, '_expiration_date', $expiration_date);
				}
			} elseif (!$old_level->eternal_active_period && $new_level->eternal_active_period) {
				$postids = $this->getPostIdsByLevelId($level_id);
				foreach ($postids AS $post_id)
					delete_post_meta($post_id, '_expiration_date');
			}
			
			return true;
		}
	}
	
	public function deleteLevel($level_id) {
		global $wpdb;
		
		$postids = $this->getPostIdsByLevelId($level_id);
		foreach ($postids AS $post_id)
			wp_delete_post($post_id, true);
	
		$wpdb->delete($wpdb->alsp_levels, array('id' => $level_id));

		// Renew levels' upgrade meta
		/* $this->getLevelsFromDB();
		$results = array();
		foreach ($this->levels_array AS $level1) {
			foreach ($this->levels_array AS $level2) {
				$results[$level1->id][$level2->id]['disabled'] = $level1->upgrade_meta[$level2->id]['disabled'];
				$results[$level1->id][$level2->id]['raiseup'] = $level1->upgrade_meta[$level2->id]['raiseup'];
			}
			$level1->saveUpgradeMeta($results[$level1->id]);
		} */

		$this->getLevelsFromDB();
		return true;
	}
	
	public function getPostIdsByLevelId($level_id) {
		global $wpdb;

		return $postids = $wpdb->get_col($wpdb->prepare("SELECT post_id FROM {$wpdb->alsp_levels_relationships} WHERE level_id=%d", $level_id));
	}
}

class alsp_level {
	public $id;
	public $order_num;
	public $name;
	public $description;
	public $active_interval;
	public $active_period;
	public $eternal_active_period = 1;
	public $listings_in_package = 1;
	public $change_level_id = 0;
	public $featured = 0;
	public $listings_own_page = 1;
	public $nofollow = 0;
	public $raiseup_enabled = 0;
	public $sticky = 0;
	public $categories_number = 0;
	public $unlimited_categories = 1;
	public $locations_number = 1;
	public $google_map = 1;
	public $google_map_markers = 1;
	public $logo_enabled;
	public $featured_level;
	public $allow_resurva_booking;
	public $images_number = 1;
	public $videos_number = 1;
	public $categories = array();
	public $locations = array();
	public $content_fields = array();
	public $upgrade_meta = array();

	public function buildLevelFromArray($array) {
		$this->id = alsp_getValue($array, 'id');
		$this->order_num = alsp_getValue($array, 'order_num');
		$this->name = alsp_getValue($array, 'name');
		$this->description = alsp_getValue($array, 'description');
		$this->active_interval = alsp_getValue($array, 'active_interval');
		$this->active_period = alsp_getValue($array, 'active_period');
		$this->eternal_active_period = alsp_getValue($array, 'eternal_active_period');
		$this->listings_in_package = alsp_getValue($array, 'listings_in_package');
		$this->change_level_id = alsp_getValue($array, 'change_level_id');
		$this->featured = alsp_getValue($array, 'featured');
		$this->sticky = alsp_getValue($array, 'sticky');
		$this->listings_own_page = alsp_getValue($array, 'listings_own_page');
		$this->nofollow = alsp_getValue($array, 'nofollow');
		$this->raiseup_enabled = alsp_getValue($array, 'raiseup_enabled');
		$this->categories_number = alsp_getValue($array, 'categories_number');
		$this->unlimited_categories = alsp_getValue($array, 'unlimited_categories');
		$this->locations_number = alsp_getValue($array, 'locations_number');
		$this->google_map = alsp_getValue($array, 'google_map');
		$this->google_map_markers = alsp_getValue($array, 'google_map_markers');
		$this->logo_enabled = alsp_getValue($array, 'logo_enabled');
		$this->featured_level = alsp_getValue($array, 'featured_level');
		$this->allow_resurva_booking = alsp_getValue($array, 'allow_resurva_booking');
		$this->images_number = alsp_getValue($array, 'images_number');
		$this->videos_number = alsp_getValue($array, 'videos_number');
		$this->categories = alsp_getValue($array, 'categories');
		$this->locations = alsp_getValue($array, 'locations');
		$this->content_fields = alsp_getValue($array, 'content_fields');
		$this->upgrade_meta = (alsp_getValue($array, 'upgrade_meta')) ? unserialize(alsp_getValue($array, 'upgrade_meta')) : array();
		
		$this->convertCategories();
		$this->convertLocations();
		$this->convertContentFields();
		
		apply_filters('alsp_levels_loading', $this, $array);
	}
	
	public function convertCategories() {
		if ($this->categories) {
			$unserialized_categories = maybe_unserialize($this->categories);
			if (count($unserialized_categories) > 1 || $unserialized_categories != array(''))
				$this->categories = $unserialized_categories;
			else
				$this->categories = array();
		} else
			$this->categories = array();
		return $this->categories;
	}

	public function convertLocations() {
		if ($this->locations) {
			$unserialized_locations = maybe_unserialize($this->locations);
			if (count($unserialized_locations) > 1 || $unserialized_locations != array(''))
				$this->locations = $unserialized_locations;
			else
				$this->locations = array();
		} else
			$this->locations = array();
		return $this->locations;
	}

	public function convertContentFields() {
		if ($this->content_fields) {
			$unserialized_content_fields = maybe_unserialize($this->content_fields);
			if (count($unserialized_content_fields) > 1 || $unserialized_content_fields != array(''))
				$this->content_fields = $unserialized_content_fields;
			else
				$this->content_fields = array();
		} else
			$this->content_fields = array();
		return $this->content_fields;
	}
	
	public function getActivePeriodString() {
		if ($this->eternal_active_period)
			return __('Never expire', 'ALSP');
		else {
			if ($this->active_period == 'day')
				return $this->active_interval . ' ' . _n('day', 'days', $this->active_interval, 'ALSP');
			elseif ($this->active_period == 'week')
				return $this->active_interval . ' ' . _n('week', 'weeks', $this->active_interval, 'ALSP');
			elseif ($this->active_period == 'month')
				return $this->active_interval . ' ' . _n('month', 'months', $this->active_interval, 'ALSP');
			elseif ($this->active_period == 'year')
				return $this->active_interval . ' ' . _n('year', 'years', $this->active_interval, 'ALSP');
		}
	}
	
	public function saveUpgradeMeta($meta) {
		global $wpdb;
		
		$this->upgrade_meta = $meta;
		
		$this->upgrade_meta = apply_filters('alsp_level_upgrade_meta', $this->upgrade_meta, $this);

		return $wpdb->update($wpdb->alsp_levels, array('upgrade_meta' => serialize($this->upgrade_meta)), array('id' => $this->id));
	}
	
	public function isUpgradable() {
		global $alsp_instance;

		if (count($alsp_instance->levels->levels_array) > 1) {
			foreach ($this->upgrade_meta AS $id=>$meta) {
				if (($id != $this->id) && (!isset($meta['disabled']) || !$meta['disabled'] || (current_user_can('editor') || current_user_can('administrator'))))
					return true;
			}
		}
		return false;
	}
}

// adapted for WPML
add_action('init', 'alsp_levels_names_into_strings');
function alsp_levels_names_into_strings() {
	global $alsp_instance, $sitepress;

	if (function_exists('wpml_object_id_filter') && $sitepress) {
		foreach ($alsp_instance->levels->levels_array AS &$level) {
			$level->name = apply_filters('wpml_translate_single_string', $level->name, 'ALSP Listing', 'The name of level #' . $level->id);
			$level->description = apply_filters('wpml_translate_single_string', $level->description, 'ALSP Listing', 'The description of level #' . $level->id);
		}
	}
}

add_filter('alsp_level_create_edit_args', 'alsp_filter_level_settings', 10, 2);
function alsp_filter_level_settings($insert_update_args, $array) {
	global $sitepress;

	if (function_exists('wpml_object_id_filter') && $sitepress) {
		if ($sitepress->get_default_language() != ICL_LANGUAGE_CODE) {
			if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['level_id'])) {
				$level_id = $_GET['level_id'];
				if ($name_string_id = icl_st_is_registered_string('ALSP Listing', 'The name of level #' . $level_id))
					icl_add_string_translation($name_string_id, ICL_LANGUAGE_CODE, $insert_update_args['name'], ICL_TM_COMPLETE);
				if ($description_string_id = icl_st_is_registered_string('ALSP Listing', 'The description of level #' . $level_id))
					icl_add_string_translation($description_string_id, ICL_LANGUAGE_CODE, $insert_update_args['description'], ICL_TM_COMPLETE);
				unset($insert_update_args['name']);
				unset($insert_update_args['description']);
				
				unset($insert_update_args['categories']);
				unset($insert_update_args['locations']);
			} else { 
				$insert_update_args['categories'] = '';
				$insert_update_args['locations'] = '';
			}
		}
	}
	return $insert_update_args;
}

add_action('alsp_update_level', 'alsp_save_level_categories_locations', 10, 2);
function alsp_save_level_categories_locations($level_id, $array) {
	global $sitepress;

	if (function_exists('wpml_object_id_filter') && $sitepress) {
		if ($sitepress->get_default_language() != ICL_LANGUAGE_CODE) {
			update_option('alsp_wpml_level_categories_'.$level_id.'_'.ICL_LANGUAGE_CODE, alsp_getValue($array, 'categories_list'));
			update_option('alsp_wpml_level_locations_'.$level_id.'_'.ICL_LANGUAGE_CODE, alsp_getValue($array, 'locations_list'));
		}
		
		if ($sitepress->get_default_language() == ICL_LANGUAGE_CODE) {
			do_action('wpml_register_single_string', 'ALSP Listing', 'The name of level #' . $level_id, alsp_getValue($array, 'name'));
			do_action('wpml_register_single_string', 'ALSP Listing', 'The description of level #' . $level_id, alsp_getValue($array, 'description'));
		}
	}
}
	
add_action('init', 'alsp_load_levels_categories_locations');
function alsp_load_levels_categories_locations() {
	global $alsp_instance, $sitepress;

	if (function_exists('wpml_object_id_filter') && $sitepress) {
		if ($sitepress->get_default_language() != ICL_LANGUAGE_CODE) {
			foreach ($alsp_instance->levels->levels_array AS &$level) {
				$_categories = get_option('alsp_wpml_level_categories_'.$level->id.'_'.ICL_LANGUAGE_CODE);
				if ($_categories && (count($_categories) > 1 || $_categories != array('')))
					$level->categories = $_categories;
				else
					$level->categories = array();
				$_locations = get_option('alsp_wpml_level_locations_'.$level->id.'_'.ICL_LANGUAGE_CODE);
				if ($_locations && (count($_locations) > 1 || $_locations != array('')))
					$level->locations = $_locations;
				else
					$level->locations = array();
			}
		}
	}
}

?>