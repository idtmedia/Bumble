<?php 

class alsp_content_field_address extends alsp_content_field {
	protected $can_be_required = true;
	protected $can_be_ordered = false;
	protected $is_categories = false;
	protected $is_slug = false;
	
	public function isNotEmpty($listing) {
		if ($listing->locations)
			return true;
		else
			return false;
	}

	public function renderOutput($listing) {
		if ($listing->level->locations_number) {
			if (!($template = alsp_isFrontPart('content_fields/fields/address_output_'.$this->id.'.tpl.php'))) {
				$template = 'content_fields/fields/address_output.tpl.php';
			}
			
			$template = apply_filters('alsp_content_field_output_template', $template, $this, $listing);
			
			alsp_frontendRender($template, array('content_field' => $this, 'listing' => $listing));
		}
	}
	
	public function renderOutputForMap($location, $listing) {
		if ($listing->level->locations_number)
			return $location->getWholeAddress();
	}
}
?>