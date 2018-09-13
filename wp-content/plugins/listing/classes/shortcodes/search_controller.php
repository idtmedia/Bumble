<?php 

class alsp_search_controller extends alsp_frontend_controller {

	public function init($args = array()) {
		global $ALSP_ADIMN_SETTINGS;
		parent::init($args);

		$this->args = array_merge(array(
				'advanced_open' => 0,
				'keyword_field_width' => 25,
				'category_field_width' => 25,
				'location_field_width' => 25,
				'address_field_width' => 25,
				'radius_field_width' => 25,
				'button_field_width' => 25,
				'search_button_margin_top' => 0,
				'gap_in_fields' => 10,
				'search_form_type' => 1,
				'uid' => null,
		), $args);
		/*$form_type = (isset(alsp_getValue($args, 'search_form_type'));
		$this->args = $shortcode_atts;
		$this->args['advanced_open'] = alsp_getValue($args, 'advanced_open');
		$this->args['keyword_field_width'] = alsp_getValue($args, 'keyword_field_width', $ALSP_ADIMN_SETTINGS['keyword_field_width']);
		$this->args['category_field_width'] = alsp_getValue($args, 'category_field_width', $ALSP_ADIMN_SETTINGS['category_field_width']);
		$this->args['location_field_width'] = alsp_getValue($args, 'location_field_width', $ALSP_ADIMN_SETTINGS['location_field_width']);
		$this->args['address_field_width'] = alsp_getValue($args, 'address_field_width', $ALSP_ADIMN_SETTINGS['address_field_width']);
		$this->args['radius_field_width'] = alsp_getValue($args, 'radius_field_width', $ALSP_ADIMN_SETTINGS['radius_field_width']);
		$this->args['button_field_width'] = alsp_getValue($args, 'button_field_width', $ALSP_ADIMN_SETTINGS['button_field_width']);
		$this->args['gap_in_fields'] = alsp_getValue($args, 'gap_in_fields', $ALSP_ADIMN_SETTINGS['gap_in_fields']);
		$this->args['search_form_type'] = (isset($form_type))? $form_type : 0;*/
		$hash = false;
		if ($this->args['uid'])
			$hash = md5($this->args['uid']);
		
		$this->search_form = new alsp_search_form($hash, 'listings_controller', $this->args);
		
		apply_filters('alsp_frontend_controller_construct', $this);
	}

	public function display() {
		ob_start();
		$this->search_form->display($this->args['advanced_open'], $this->args['keyword_field_width'], $this->args['category_field_width'], $this->args['location_field_width'], $this->args['address_field_width'], $this->args['radius_field_width'], $this->args['button_field_width'], $this->args['search_button_margin_top'], $this->args['gap_in_fields'], $this->args['search_form_type']);
		$output = ob_get_clean();
		
		return $output;
	}
}

?>