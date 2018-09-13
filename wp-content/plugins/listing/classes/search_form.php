<?php

class alsp_search_form {
	public $uid;
	public $controller;
	public $args = array();
	public $search_fields_array = array();
	public $search_fields_array_advanced = array();
	public $search_fields_array_all = array();
	public $is_advanced_search_panel = false;
	public $advanced_open = false;
	
	public function __construct($uid = null, $controller = 'listings_controller', $args = array()) {
		$this->uid = $uid;
		$this->controller = $controller;
	}

	public function display($advanced_open = 0, $keyword_field_width = 25, $category_field_width = 25, $location_field_width = 25, $address_field_width = 25, $radius_field_width = 25, $button_field_width = 25, $search_button_margin_top = 0, $gap_in_fields = 10, $search_form_type = 1) {
		global $alsp_instance;

		// random ID needed because there may be more than 1 search form on one page
		$random_id = alsp_generateRandomVal();
		
		$search_url = ($alsp_instance->index_page_url) ? alsp_directoryUrl() : home_url('/');

		alsp_frontendRender('search_form.tpl.php', array('random_id' => $random_id, 'advanced_open' => $advanced_open, 'button_field_width' => $button_field_width, 'search_button_margin_top' => $search_button_margin_top, 'keyword_field_width' => $keyword_field_width, 'category_field_width' => $category_field_width, 'location_field_width' => $location_field_width, 'address_field_width' => $address_field_width, 'radius_field_width' => $radius_field_width, 'gap_in_fields' => $gap_in_fields, 'search_form_type' => $search_form_type, 'search_url' => $search_url, 'hash' => $this->uid, 'controller' => $this->controller));
	}
}
?>