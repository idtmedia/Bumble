<?php 

class alsp_content_field_excerpt extends alsp_content_field {
	protected $can_be_ordered = false;
	protected $is_categories = false;
	protected $is_slug = false;
	
	public function isNotEmpty($listing) {
		global $ALSP_ADIMN_SETTINGS;
		if (post_type_supports(ALSP_POST_TYPE, 'excerpt') && ($listing->post->post_excerpt || ($ALSP_ADIMN_SETTINGS['alsp_cropped_content_as_excerpt'] && $listing->post->post_content !== '')))
			return true;
		else
			return false;
	}

	public function validateValues(&$errors, $data) {
		$listing = alsp_getCurrentListingInAdmin();
		if (post_type_supports(ALSP_POST_TYPE, 'excerpt') && $this->is_required && (!isset($data['post_excerpt']) || !$data['post_excerpt']))
			$errors[] = __('Listing excerpt is required', 'ALSP');
		else
			return $listing->post->post_excerpt;
	}
	
	public function renderOutput($listing) {
		if (!($template = alsp_isFrontPart('content_fields/fields/excerpt_output_'.$this->id.'.tpl.php'))) {
			$template = 'content_fields/fields/excerpt_output.tpl.php';
		}
		
		$template = apply_filters('alsp_content_field_output_template', $template, $this, $listing);
			
		alsp_frontendRender($template, array('content_field' => $this, 'listing' => $listing));
	}
	
	public function renderOutputForMap($location, $listing) {
		return $listing->post->post_excerpt;
	}
}
?>