<?php 

class alsp_content_field_content extends alsp_content_field {
	protected $can_be_ordered = false;
	protected $is_categories = false;
	protected $is_slug = false;
	
	public function isNotEmpty($listing) {
		if (post_type_supports(ALSP_POST_TYPE, 'editor') && !empty($listing->post->post_content))
			return true;
		else
			return false;
	}

	public function validateValues(&$errors, $data) {
		$listing = alsp_getCurrentListingInAdmin();
		if (post_type_supports(ALSP_POST_TYPE, 'editor') && $this->is_required && (!isset($data['post_content']) || !$data['post_content']))
			$errors[] = __('Listing content is required', 'ALSP');
		else
			return $listing->post->post_content;
	}
	
	public function renderOutput($listing) {
		if (!($template = alsp_isFrontPart('content_fields/fields/content_output_'.$this->id.'.tpl.php'))) {
			$template = 'content_fields/fields/content_output.tpl.php';
		}
		
		$template = apply_filters('alsp_content_field_output_template', $template, $this, $listing);
			
		alsp_frontendRender($template, array('content_field' => $this, 'listing' => $listing));
	}
	
	public function renderOutputForMap($location, $listing) {
		return $listing->post->post_content;
	}
}
?>