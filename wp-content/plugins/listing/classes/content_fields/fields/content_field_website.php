<?php 

class alsp_content_field_website extends alsp_content_field {
	public $is_blank = false;
	public $is_nofollow = false;
	public $use_link_text = 1;
	public $default_link_text = '';
	public $use_default_link_text = 0;
	public $value = array('url' => '', 'text' => '');
	
	protected $can_be_ordered = false;
	protected $is_configuration_page = true;
	
	public function isNotEmpty($listing) {
		if ($this->value['url'])
			return true;
		else
			return false;
	}

	public function configure() {
		global $wpdb, $alsp_instance;

		if (alsp_getValue($_POST, 'submit') && wp_verify_nonce($_POST['alsp_configure_content_fields_nonce'], ALSP_PATH)) {
			$validation = new alsp_form_validation();
			$validation->set_rules('is_blank', __('Open link in new window', 'ALSP'), 'is_checked');
			$validation->set_rules('is_nofollow', __('Add nofollow attribute', 'ALSP'), 'is_checked');
			$validation->set_rules('use_link_text', __('Default link text', 'ALSP'), 'is_checked');
			$validation->set_rules('default_link_text', __('Default link text', 'ALSP'));
			$validation->set_rules('use_default_link_text', __('Use default link text', 'ALSP'), 'is_checked');
			if ($validation->run()) {
				$result = $validation->result_array();
				if ($wpdb->update($wpdb->alsp_content_fields, array('options' => serialize(array('is_blank' => $result['is_blank'], 'is_nofollow' => $result['is_nofollow'], 'use_link_text' => $result['use_link_text'], 'default_link_text' => $result['default_link_text'], 'use_default_link_text' => $result['use_default_link_text']))), array('id' => $this->id), null, array('%d')))
					alsp_addMessage(__('Field configuration was updated successfully!', 'ALSP'));
				
				$alsp_instance->content_fields_manager->showContentFieldsTable();
			} else {
				$this->is_blank = $validation->result_array('is_blank');
				$this->is_nofollow = $validation->result_array('is_nofollow');
				$this->use_link_text = $validation->result_array('use_link_text');
				$this->default_link_text = $validation->result_array('default_link_text');
				$this->use_default_link_text = $validation->result_array('use_default_link_text');
				alsp_addMessage($validation->error_array(), 'error');

				alsp_frontendRender('content_fields/fields/website_configuration.tpl.php', array('content_field' => $this));
			}
		} else
			alsp_frontendRender('content_fields/fields/website_configuration.tpl.php', array('content_field' => $this));
	}
	
	public function buildOptions() {
		if (isset($this->options['is_blank']))
			$this->is_blank = $this->options['is_blank'];

		if (isset($this->options['is_nofollow']))
			$this->is_nofollow = $this->options['is_nofollow'];

		if (isset($this->options['use_link_text']))
			$this->use_link_text = $this->options['use_link_text'];

		if (isset($this->options['default_link_text']))
			$this->default_link_text = $this->options['default_link_text'];

		if (isset($this->options['use_default_link_text']))
			$this->use_default_link_text = $this->options['use_default_link_text'];
	}
	
	public function renderInput() {
		// Default link text
		if ($this->value['text'] == '')
			$this->value['text'] = $this->default_link_text;

		if (!($template = alsp_isFrontPart('content_fields/fields/website_input_'.$this->id.'.tpl.php'))) {
			$template = 'content_fields/fields/website_input.tpl.php';
		}
		
		$template = apply_filters('alsp_content_field_input_template', $template, $this);
			
		alsp_frontendRender($template, array('content_field' => $this));
	}
	
	public function validateValues(&$errors, $data) {
		$field_index_url = 'alsp-field-input-url_' . $this->id;
		$field_index_text = 'alsp-field-input-text_' . $this->id;

		$validation = new alsp_form_validation();
		$rules = 'valid_url[1]'; // 1 - is the second parameter must be $prepare_url=true
		if ($this->canBeRequired() && $this->is_required)
			$rules .= '|required';
		$validation->set_rules($field_index_url, $this->name, $rules);
		$validation->set_rules($field_index_text, $this->name);
		if (!$validation->run())
			$errors[] = $validation->error_string();

		return array('url' => $validation->result_array($field_index_url), 'text' => $validation->result_array($field_index_text));
	}
	
	public function saveValue($post_id, $validation_results) {
		return update_post_meta($post_id, '_content_field_' . $this->id, $validation_results);
	}
	
	public function loadValue($post_id) {
		if ($value = get_post_meta($post_id, '_content_field_' . $this->id, true)) {
			$this->value = maybe_unserialize($value);
		}
		
		// Default link text
		if ($this->value['text'] == '' && $this->use_default_link_text)
			$this->value['text'] = $this->default_link_text;

		$this->value = apply_filters('alsp_content_field_load', $this->value, $this, $post_id);
		return $this->value;
	}
	
	public function renderOutput($listing = null) {
		if (!($template = alsp_isFrontPart('content_fields/fields/website_output_'.$this->id.'.tpl.php'))) {
			$template = 'content_fields/fields/website_output.tpl.php';
		}
		
		$template = apply_filters('alsp_content_field_output_template', $template, $this, $listing);
		
		alsp_frontendRender($template, array('content_field' => $this, 'listing' => $listing));
	}
	
	public function validateCsvValues($value, &$errors) {
		$value = explode('>', $value);
		$url = $value[0];
		$validation = new alsp_form_validation();
		if (!$validation->valid_url($url))
			$errors[] = __("Website URL field is invalid", "ALSP");

		$text = (isset($value[1]) ? $value[1] : '');
		return array('url' => $url, 'text' => $text);
	}
	
	public function exportCSV() {
		if ($this->value['url']) {
			$output = $this->value['url'];
			if ($this->value['text'] && (!$this->use_default_link_text || $this->value['text'] != $this->default_link_text))
				$output .= ">" . $this->value['text'];
			return  $output;
		}
	}
	
	public function renderOutputForMap($location, $listing) {
		return alsp_frontendRender('content_fields/fields/website_output_map.tpl.php', array('content_field' => $this, 'listing' => $listing), true);
	}
}
?>