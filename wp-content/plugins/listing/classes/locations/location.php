<?php 

class alsp_location {
	public $id;
	public $post_id;
	public $selected_location = 0;
	public $address_line_1;
	public $address_line_2;
	public $zip_or_postal_index;
	public $additional_info;
	public $manual_coords = false;
	public $map_coords_1;
	public $map_coords_2;
	public $map_icon_file;
	public $map_icon_color;
	public $map_icon_manually_selected;
	
	public function __construct($post_id = null) {
		$this->post_id = $post_id;
	}

	public function createLocationFromArray($array) {
		$this->id = alsp_getValue($array, 'id');
		$this->selected_location = alsp_getValue($array, 'selected_location');
		$this->address_line_1 = alsp_getValue($array, 'address_line_1');
		$this->address_line_2 = alsp_getValue($array, 'address_line_2');
		$this->zip_or_postal_index = alsp_getValue($array, 'zip_or_postal_index');
		$this->additional_info = alsp_getValue($array, 'additional_info');
		$this->manual_coords = alsp_getValue($array, 'manual_coords');
		$this->map_coords_1 = alsp_getValue($array, 'map_coords_1');
		$this->map_coords_2 = alsp_getValue($array, 'map_coords_2');
		$this->map_icon_file = alsp_getValue($array, 'map_icon_file');
		$this->map_icon_color = alsp_getValue($array, 'map_icon_color');
		$this->map_icon_manually_selected = alsp_getValue($array, 'map_icon_manually_selected');
	}
	
	public function getSelectedLocationString($glue = ', ', $reverse = false) {
		global $alsp_instance;

		if ($this->selected_location != 0) {
			$chain = array();
			$parent_id = $this->selected_location;
			while ($parent_id != 0) {
				if (!is_wp_error($term = get_term($parent_id, ALSP_LOCATIONS_TAX)) && $term) {
					$chain[] = $term->name;
					$parent_id = $term->parent;
				} else 
					break;
			}

			// reverse locations for actual locations levels 
			$chain = array_reverse($chain);

			$locations_levels = $alsp_instance->locations_levels;
			$locations_levels_array = array_values($locations_levels->levels_array);
			$result_chain = array();
			foreach ($chain AS $location_key=>$location) {
				if ($locations_levels_array[$location_key]->in_address_line)
					$result_chain[] = $location;
			}

			// do not reverse as it was reversed before
			if (!$reverse)
				$result_chain = array_reverse($result_chain);
			return implode($glue, $result_chain);
		}
	}

	public function getWholeAddress($microdata = true, $glue = ', ', $reverse = false) {
		global $ALSP_ADIMN_SETTINGS;
		$out = array();
		$separator_previous = false;
		$orders = $ALSP_ADIMN_SETTINGS['alsp-addresses-order']['enabled'];
		foreach ($orders AS $key=>$value) {
			switch ($key) {
				case 'location':
					if ($location_string = $this->getSelectedLocationString($glue, $reverse)) {
						$out[] = (($microdata) ? '<span itemprop="addressLocality">' : '') . $location_string . (($microdata) ? '</span>' : '');
						$separator_previous = false;
					} elseif (in_array($separator_previous, array('space','comma','break')))
						array_pop($out);
					break;
				case 'line-1':
					if (trim($this->address_line_1) && $ALSP_ADIMN_SETTINGS['alsp_enable_address_line_1']) {
						$out[] = (($microdata) ? '<span itemprop="streetAddress">' : '') . trim($this->address_line_1) . (($microdata) ? '</span>' : '');
						$separator_previous = false;
					} elseif (in_array($separator_previous, array('space','comma','break')))
						array_pop($out);
					break;
				case 'line-2':
					if (trim($this->address_line_2) && $ALSP_ADIMN_SETTINGS['alsp_enable_address_line_2']) {
						$out[] = trim($this->address_line_2);
						$separator_previous = false;
					} elseif (in_array($separator_previous, array('space','comma','break')))
						array_pop($out);
					break;
				case 'zip':
					if (trim($this->zip_or_postal_index) && $ALSP_ADIMN_SETTINGS['alsp_enable_postal_index']) {
						$out[] = (($microdata) ? '<span itemprop="postalCode">' : '') . trim($this->zip_or_postal_index) . (($microdata) ? '</span>' : '');
						$separator_previous = false;
					} elseif (in_array($separator_previous, array('space','comma','break')))
						array_pop($out);
					break;
				case 'space1':
				case 'space2':
				case 'space3':
					if ($separator_previous != 'break' && $out) {
						$out[] = ' ';
						$separator_previous = 'space';
					}
					break;
				case 'comma1':
				case 'comma2':
				case 'comma3':
					if ($separator_previous != 'break' && $out) {
						$out[] = ', ';
						$separator_previous = 'comma';
					}
					break;
				case 'break1':
				case 'break2':
					if ($separator_previous != 'break' && $out) {
						$out[] = '<br />';
						$separator_previous = 'break';
					}
					break;
			}
		}

		return trim(implode('', $out), ', ');
	}
	
	public function renderInfoFieldForMap() {
		global $ALSP_ADIMN_SETTINGS;
		if ($ALSP_ADIMN_SETTINGS['alsp_enable_additional_info'])
			return $this->additional_info;
	}
	
	/* codzila custom code */
	
	public function getWholeAddress_ongrid($microdata = true, $glue = ', ', $reverse = false) {
		global $ALSP_ADIMN_SETTINGS;
		$out = array();
		$separator_previous = false;
		$orders = $ALSP_ADIMN_SETTINGS['alsp-addresses-order_ongrid']['enabled'];
		foreach ($orders AS $key=>$value) {
			switch ($key) {
				case 'location':
					if ($location_string = $this->getSelectedLocationString($glue, $reverse)) {
						$out[] = (($microdata) ? '<span itemprop="addressLocality">' : '') . $location_string . (($microdata) ? '</span>' : '');
						$separator_previous = false;
					} elseif (in_array($separator_previous, array('space','comma','break')))
						array_pop($out);
					break;
				case 'line-1':
					if (trim($this->address_line_1) && $ALSP_ADIMN_SETTINGS['alsp_enable_address_line_1']) {
						$out[] = (($microdata) ? '<span itemprop="streetAddress">' : '') . trim($this->address_line_1) . (($microdata) ? '</span>' : '');
						$separator_previous = false;
					} elseif (in_array($separator_previous, array('space','comma','break')))
						array_pop($out);
					break;
				case 'line-2':
					if (trim($this->address_line_2) && $ALSP_ADIMN_SETTINGS['alsp_enable_address_line_2']) {
						$out[] = trim($this->address_line_2);
						$separator_previous = false;
					} elseif (in_array($separator_previous, array('space','comma','break')))
						array_pop($out);
					break;
				case 'zip':
					if (trim($this->zip_or_postal_index) && $ALSP_ADIMN_SETTINGS['alsp_enable_postal_index']) {
						$out[] = (($microdata) ? '<span itemprop="postalCode">' : '') . trim($this->zip_or_postal_index) . (($microdata) ? '</span>' : '');
						$separator_previous = false;
					} elseif (in_array($separator_previous, array('space','comma','break')))
						array_pop($out);
					break;
				case 'space1':
				case 'space2':
				case 'space3':
					if ($separator_previous != 'break' && $out) {
						$out[] = ' ';
						$separator_previous = 'space';
					}
					break;
				case 'comma1':
				case 'comma2':
				case 'comma3':
					if ($separator_previous != 'break' && $out) {
						$out[] = ', ';
						$separator_previous = 'comma';
					}
					break;
				case 'break1':
				case 'break2':
					if ($separator_previous != 'break' && $out) {
						$out[] = '<br />';
						$separator_previous = 'break';
					}
					break;
			}
		}

		return trim(implode('', $out), ', ');
	}
}

?>