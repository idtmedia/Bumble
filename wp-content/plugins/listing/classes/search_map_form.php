<?php

class search_map_form extends alsp_search_form {

	public function __construct($uid = null) {
		$this->uid = $uid;
		$this->controller = 'listings_controller';
	}

	public function display($advanced_open = false, $keyword_field_width = '', $category_field_width = '', $location_field_width = '', $address_field_width = '', $radius_field_width = '', $button_field_width = '', $gap_in_fields = '', $search_form_type = 'body') {
		global $alsp_instance;
		$advanced_open = false;
		$keyword_field_width = 30;
		$category_field_width = 30;
		$location_field_width = 30;
		$address_field_width = 30;
		$radius_field_width = 30;
		$button_field_width = 30;
		$gap_in_fields = 10;
		$search_form_type = 'body';
		// random ID needed because there may be more than 1 search form on one page
		$random_id = alsp_generateRandomVal();
		
		$search_url = ($alsp_instance->index_page_url) ? alsp_directoryUrl() : home_url('/');

		alsp_frontendRender('search_archive_form.tpl.php', array('random_id' => $random_id, 'advanced_open' => $advanced_open, 'keyword_field_width' => 30, 'category_field_width' => $category_field_width, 'location_field_width' => $location_field_width, 'address_field_width' => $address_field_width, 'radius_field_width' => $radius_field_width, 'button_field_width' => $button_field_width, 'gap_in_fields' => $gap_in_fields, 'search_form_type' => $search_form_type, 'search_url' => $search_url, 'hash' => $this->uid, 'controller' => $this->controller));
	}
}
?>