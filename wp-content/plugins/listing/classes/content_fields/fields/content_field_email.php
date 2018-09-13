<?php 

class alsp_content_field_email extends alsp_content_field {
	protected $can_be_ordered = false;
	
	public function isNotEmpty($listing) {
		if ($this->value)
			return true;
		else
			return false;
	}

	public function renderInput() {
		if (!($template = alsp_isFrontPart('content_fields/fields/email_input_'.$this->id.'.tpl.php'))) {
			$template = 'content_fields/fields/email_input.tpl.php';
		}
		
		$template = apply_filters('alsp_content_field_input_template', $template, $this);
			
		alsp_frontendRender($template, array('content_field' => $this));
	}
	
	public function validateValues(&$errors, $data) {
		$field_index = 'alsp-field-input-' . $this->id;

		$validation = new alsp_form_validation();
		$rules = 'valid_email';
		if ($this->canBeRequired() && $this->is_required)
			$rules .= '|required';
		$validation->set_rules($field_index, $this->name, $rules);
		if (!$validation->run())
			$errors[] = $validation->error_string();
	
		return $validation->result_array($field_index);
	}
	
	public function saveValue($post_id, $validation_results) {
		return update_post_meta($post_id, '_content_field_' . $this->id, $validation_results);
	}
	
	public function loadValue($post_id) {
		$this->value = get_post_meta($post_id, '_content_field_' . $this->id, true);
		
		$this->value = apply_filters('alsp_content_field_load', $this->value, $this, $post_id);
		return $this->value;
	}
	
	public function renderOutput($listing = null) {
		if (!($template = alsp_isFrontPart('content_fields/fields/email_output_'.$this->id.'.tpl.php'))) {
			$template = 'content_fields/fields/email_output.tpl.php';
		}
		
		$template = apply_filters('alsp_content_field_output_template', $template, $this, $listing);
			
		alsp_frontendRender($template, array('content_field' => $this, 'listing' => $listing));
	}
	
	public function validateCsvValues($value, &$errors) {
		$validation = new alsp_form_validation();
		if ($validation->valid_email($value))
			return $value;
	}
	
	public function renderOutputForMap($location, $listing) {
		return alsp_frontendRender('content_fields/fields/email_output_map.tpl.php', array('content_field' => $this, 'listing' => $listing), true);
	}
}
?>