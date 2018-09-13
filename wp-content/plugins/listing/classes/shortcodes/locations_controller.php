<?php 

class alsp_locations_controller extends alsp_frontend_controller {

	public function init($args = array()) {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;
		
		parent::init($args);

		$shortcode_atts = array_merge(array(
				'custom_home' => 0,
				'location_style' => 0,
				'parent' => 0,
				'depth' => 1,
				'columns' => 1,
				'count' => 0,
				'sublocations' => 0,
				'location_bg' => '#333',
				'location_bg_image' => '',
				'gradientbg1' => '',
				'gradientbg2' => '',
				'opacity1' => '',
				'opacity2' => '',
				'gradient_angle' => '',
				'location_width' => 30,
				'location_height' => 480,
				'location_padding' => 15,
				'locations' => array(),
		), $args);
		$this->args = $shortcode_atts;

		if ($this->args['custom_home']) {
			if ($alsp_instance->getShortcodeProperty('webdirectory', 'is_location')) {
				$location = $alsp_instance->getShortcodeProperty('webdirectory', 'location');
				$this->args['parent'] = $location->term_id;
			}
			$this->args['location_style'] = alsp_getValue($args, 'location_style');
			$this->args['depth'] = alsp_getValue($args, 'depth', $ALSP_ADIMN_SETTINGS['alsp_locations_nesting_level']);
			$this->args['columns'] = alsp_getValue($args, 'columns', $ALSP_ADIMN_SETTINGS['alsp_locations_columns']);
			$this->args['count'] = alsp_getValue($args, 'count', $ALSP_ADIMN_SETTINGS['alsp_show_location_count']);
			$this->args['sublocations'] = alsp_getValue($args, 'subcats', $ALSP_ADIMN_SETTINGS['alsp_sublocations_items']);
			$this->args['location_bg'] = alsp_getValue($args, 'location_bg');
			$this->args['location_bg_image'] = alsp_getValue($args, 'location_bg_image');
			$this->args['gradientbg1'] = alsp_getValue($args, 'gradientbg1');
			$this->args['gradientbg2'] = alsp_getValue($args, 'gradientbg2');
			$this->args['opacity1'] = alsp_getValue($args, 'opacity1');
			$this->args['opacity2'] = alsp_getValue($args, 'opacity2');
			$this->args['gradient_angle'] = alsp_getValue($args, 'gradient_angle');
			$this->args['location_width'] = alsp_getValue($args, 'location_width');
			$this->args['location_height'] = alsp_getValue($args, 'location_height');
			$this->args['location_padding'] = alsp_getValue($args, 'location_padding');
		}
		if (isset($this->args['locations']) && !is_array($this->args['locations']))
			if ($locations = array_filter(explode(',', $this->args['locations']), 'trim'))
				$this->args['locations'] = $locations;

		apply_filters('alsp_frontend_controller_construct', $this);
	}

		
	public function display() {
		
		ob_start();
		 alsp_renderAllLocations($this->args['parent'], $this->args['location_style'], $this->args['depth'], $this->args['columns'], $this->args['count'], $this->args['sublocations'], $this->args['location_bg'], $this->args['location_bg_image'], $this->args['gradientbg1'], $this->args['gradientbg2'], $this->args['opacity1'], $this->args['opacity2'], $this->args['gradient_angle'], $this->args['location_width'], $this->args['location_height'], $this->args['location_padding'], $this->args['locations']);
		$output = ob_get_clean();

		return $output;
		
	}
}

?>