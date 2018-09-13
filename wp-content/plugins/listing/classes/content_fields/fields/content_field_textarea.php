<?php 

class alsp_content_field_textarea extends alsp_content_field {
	public $max_length = 500;
	public $html_editor = false;
	public $do_shortcodes = false;

	protected $can_be_ordered = false;
	protected $is_configuration_page = true;
	protected $can_be_searched = true;
	
	public function isNotEmpty($listing) {
		if ($this->value)
			return true;
		else
			return false;
	}

	public function configure() {
		global $wpdb, $alsp_instance;

		if (alsp_getValue($_POST, 'submit') && wp_verify_nonce($_POST['alsp_configure_content_fields_nonce'], ALSP_PATH)) {
			$validation = new alsp_form_validation();
			$validation->set_rules('max_length', __('Max length', 'ALSP'), 'required|is_natural_no_zero');
			$validation->set_rules('html_editor', __('HTML editor enabled', 'ALSP'), 'is_checked');
			$validation->set_rules('do_shortcodes', __('Shortcodes processing', 'ALSP'), 'is_checked');
			if ($validation->run()) {
				$result = $validation->result_array();
				if ($wpdb->update($wpdb->alsp_content_fields, array('options' => serialize(array('max_length' => $result['max_length'], 'html_editor' => $result['html_editor'], 'do_shortcodes' => $result['do_shortcodes']))), array('id' => $this->id), null, array('%d')))
					alsp_addMessage(__('Field configuration was updated successfully!', 'ALSP'));
				
				$alsp_instance->content_fields_manager->showContentFieldsTable();
			} else {
				$this->max_length = $validation->result_array('max_length');
				$this->html_editor = $validation->result_array('html_editor');
				$this->do_shortcodes = $validation->result_array('do_shortcodes');
				alsp_addMessage($validation->error_string(), 'error');

				alsp_frontendRender('content_fields/fields/textarea_configuration.tpl.php', array('content_field' => $this));
			}
		} else
			alsp_frontendRender('content_fields/fields/textarea_configuration.tpl.php', array('content_field' => $this));
	}
	
	public function buildOptions() {
		if (isset($this->options['max_length']))
			$this->max_length = $this->options['max_length'];
		if (isset($this->options['html_editor']))
			$this->html_editor = $this->options['html_editor'];
		if (isset($this->options['do_shortcodes']))
			$this->do_shortcodes = $this->options['do_shortcodes'];
	}
	
	public function renderInput() {
		if (!($template = alsp_isFrontPart('content_fields/fields/textarea_input_'.$this->id.'.tpl.php'))) {
			$template = 'content_fields/fields/textarea_input.tpl.php';
		}
		
		$template = apply_filters('alsp_content_field_input_template', $template, $this);
			
		alsp_frontendRender($template, array('content_field' => $this));
	}
	
	public function validateValues(&$errors, $data) {
		$field_index = 'alsp-field-input-' . $this->id;
	
		$validation = new alsp_form_validation();
		$rules = 'max_length[' . $this->max_length . ']';
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
		
		if ($this->do_shortcodes)
			$this->value = apply_filters('the_content', wpautop($this->value));
		else {
			remove_filter('the_content', 'do_shortcode', 11);
			$this->value = apply_filters('the_content', wpautop($this->value));
			add_filter('the_content', 'do_shortcode', 11);
		}

		$this->value = apply_filters('alsp_content_field_load', $this->value, $this, $post_id);
		return $this->value;
	}
	
	public function renderOutput($listing = null) {
		add_filter('the_content', 'wpautop');
		if (!$this->do_shortcodes)
			remove_filter('the_content', 'do_shortcode', 11);

		if (!($template = alsp_isFrontPart('content_fields/fields/textarea_output_'.$this->id.'.tpl.php'))) {
			$template = 'content_fields/fields/textarea_output.tpl.php';
		}
		
		$template = apply_filters('alsp_content_field_output_template', $template, $this, $listing);
			
		alsp_frontendRender($template, array('content_field' => $this, 'listing' => $listing));

		if (!$this->do_shortcodes)
			add_filter('the_content', 'do_shortcode', 11);
		remove_filter('the_content', 'wpautop');
	}
	
	public function validateCsvValues($value, &$errors) {
		if (strlen($value) > $this->max_length)
			$errors[] = sprintf(__('The %s field can not exceed %s characters in length.', 'ALSP'), $this->name, $this->max_length);
		else
			return $value;
	}
	
	public function renderOutputForMap($location, $listing) {
		return $this->value;
	}
}
?>