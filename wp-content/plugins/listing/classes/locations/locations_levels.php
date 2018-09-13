<?php 

class alsp_locations_levels {
	public $levels_array;

	public function __construct() {
		$this->getLevelsFromDB();
	}

	public function getLevelsFromDB() {
		global $wpdb;
		$this->levels_array = array();

		$array = $wpdb->get_results("SELECT * FROM {$wpdb->alsp_locations_levels}", ARRAY_A);
		foreach ($array AS $row) {
			$level = new alsp_locations_level;
			$level->buildLevelFromArray($row);
			$this->levels_array[$row['id']] = $level;
		}
	}
	
	public function getNamesArray() {
		$names = array();
		foreach ($this->levels_array AS $level)
			$names[] = $level->name;
		
		return $names;
	}

	public function getSelectionsArray() {
		$selections = array();
		foreach ($this->levels_array AS $level)
			$selections[] = $level->name;
		
		return $selections;
	}
	
	public function getLevelById($level_id) {
		if (isset($this->levels_array[$level_id]))
			return $this->levels_array[$level_id];
	}
	
	public function createLevelFromArray($array) {
		global $wpdb;
		
		$insert_update_args = array(
				'name' => $array['name'],
				//'in_widget' => $array['in_widget'],
				'in_address_line' => $array['in_address_line'],
		);
	
		return $wpdb->insert($wpdb->alsp_locations_levels, $insert_update_args);
	}
	
	public function saveLevelFromArray($level_id, $array) {
		global $wpdb;
		
		$insert_update_args = array(
				'name' => $array['name'],
				//'in_widget' => $array['in_widget'],
				'in_address_line' => $array['in_address_line'],
		);
	
		return $wpdb->update($wpdb->alsp_locations_levels, $insert_update_args,	array('id' => $level_id), null, array('%d')) !== false;
	}
	
	public function deleteLevel($level_id) {
		global $wpdb;
	
		$wpdb->delete($wpdb->alsp_locations_levels, array('id' => $level_id));
		return true;
	}
}

class alsp_locations_level {
	public $id;
	public $name;
	//public $in_widget = 1;
	public $in_address_line = 1;

	public function buildLevelFromArray($array) {
		$this->id = alsp_getValue($array, 'id');
		$this->name = alsp_getValue($array, 'name');
		//$this->in_widget = alsp_getValue($array, 'in_widget');
		$this->in_address_line =alsp_getValue($array, 'in_address_line');
	}
}


if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class alsp_manage_locations_levels_table extends WP_List_Table {

	public function __construct() {
		parent::__construct(array(
				'singular' => __('locations level', 'ALSP'),
				'plural' => __('locations levels', 'ALSP'),
				'ajax' => false
		));
	}

	public function get_columns() {
		$columns = array(
				'locations_level_name' => __('Name', 'ALSP'),
				//'in_widget' => __('In locations widget', 'ALSP'),
				'in_address_line' => __('In address line', 'ALSP'),
		);

		return $columns;
	}

	public function getItems($locations_levels) {
		$items_array = array();
		foreach ($locations_levels->levels_array as $id=>$level) {
			$items_array[$id] = array(
					'id' => $level->id,
					'locations_level_name' => $level->name,
					//'in_widget' => $level->in_widget,
					'in_address_line' => $level->in_address_line,
			);
		}
		return $items_array;
	}

	public function prepareItems($locations_levels) {
		$this->_column_headers = array($this->get_columns(), array(), array());

		$this->items = $this->getItems($locations_levels);
	}

	public function column_locations_level_name($item) {
		$actions = array(
				'edit' => sprintf('<a href="?page=%s&action=%s&level_id=%d">' . __('Edit', 'ALSP') . '</a>', $_GET['page'], 'edit', $item['id']),
				'delete' => sprintf('<a href="?page=%s&action=%s&level_id=%d">' . __('Delete', 'ALSP') . '</a>', $_GET['page'], 'delete', $item['id']),
		);
		return sprintf('%1$s %2$s', sprintf('<a href="?page=%s&action=%s&level_id=%d">' . $item['locations_level_name'] . '</a>', $_GET['page'], 'edit', $item['id']), $this->row_actions($actions));
	}

	/* public function column_in_widget($item) {
		if ($item['in_widget'])
			return '<img src="' . ALSP_RESOURCES_URL . 'images/accept.png" />';
		else
			return '<img src="' . ALSP_RESOURCES_URL . 'images/delete.png" />';
	} */

	public function column_in_address_line($item) {
		if ($item['in_address_line'])
			return '<img src="' . ALSP_RESOURCES_URL . 'images/accept.png" />';
		else
			return '<img src="' . ALSP_RESOURCES_URL . 'images/delete.png" />';
	}

	public function column_default($item, $column_name) {
		switch($column_name) {
			default:
				return $item[$column_name];
		}
	}

	function no_items() {
		__('No locations levels found', 'ALSP');
	}
}

add_action('init', 'alsp_locations_levels_names_into_strings');
function alsp_locations_levels_names_into_strings() {
	global $alsp_instance, $sitepress;

	if (function_exists('wpml_object_id_filter') && $sitepress) {
		if (function_exists('icl_register_string'))
			foreach ($alsp_instance->locations_levels->levels_array AS &$locations_level) {
				icl_register_string('ALSP Listing', 'The name of locations level #' . $locations_level->id, $locations_level->name);
				$locations_level->name = icl_t('ALSP Listing', 'The name of locations level #' . $locations_level->id, $locations_level->name);
			}
	}
}

?>