<?php 

class alsp_content_field_price extends alsp_content_field {
	public $currency_symbol = '$';
	public $decimal_separator = ',';
	public $thousands_separator = ' ';

	protected $is_configuration_page = true;
	protected $is_search_configuration_page = true;
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
			$validation->set_rules('currency_symbol', __('Currency symbol', 'ALSP'), 'required');
			$validation->set_rules('decimal_separator', __('Decimal separator', 'ALSP'), 'required|max_length[1]');
			$validation->set_rules('thousands_separator', __('Thousands separator', 'ALSP'), 'max_length[1]');
			if ($validation->run()) {
				$result = $validation->result_array();
				if ($wpdb->update($wpdb->alsp_content_fields, array('options' => serialize(array('currency_symbol' => $result['currency_symbol'], 'decimal_separator' => $result['decimal_separator'], 'thousands_separator' => $result['thousands_separator']))), array('id' => $this->id), null, array('%d')))
					alsp_addMessage(__('Field configuration was updated successfully!', 'ALSP'));
				
				$alsp_instance->content_fields_manager->showContentFieldsTable();
			} else {
				$this->currency_symbol = $validation->result_array('currency_symbol');
				$this->decimal_separator = $validation->result_array('decimal_separator');
				$this->thousands_separator = $validation->result_array('thousands_separator');
				alsp_addMessage($validation->error_string(), 'error');

				alsp_frontendRender('content_fields/fields/price_configuration.tpl.php', array('content_field' => $this));
			}
		} else
			alsp_frontendRender('content_fields/fields/price_configuration.tpl.php', array('content_field' => $this));
	}
	
	public function buildOptions() {
		if (isset($this->options['currency_symbol']))
			$this->currency_symbol = $this->options['currency_symbol'];
		if (isset($this->options['decimal_separator']))
			$this->decimal_separator = $this->options['decimal_separator'];
		if (isset($this->options['thousands_separator']))
			$this->thousands_separator = $this->options['thousands_separator'];
	}
	
	public function renderInput() {
		if (!($template = alsp_isFrontPart('content_fields/fields/price_input_'.$this->id.'.tpl.php'))) {
			$template = 'content_fields/fields/price_input.tpl.php';
		}
		
		$template = apply_filters('alsp_content_field_input_template', $template, $this);
			
		alsp_frontendRender($template, array('content_field' => $this));
	}
	
	public function validateValues(&$errors, $data) {
		$field_index = 'alsp-field-input-' . $this->id;
	
		$validation = new alsp_form_validation();
		$rules = 'numeric';
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
		global $ALSP_ADIMN_SETTINGS;
		if (is_numeric($this->value)) {
			
			if($ALSP_ADIMN_SETTINGS['price_decimal']){
				$formatted_price = number_format($this->value, 2, $this->decimal_separator, $this->thousands_separator);
			}else{
				$formatted_price = number_format($this->value, 0, $this->decimal_separator, $this->thousands_separator);
			}
			if (!($template = alsp_isFrontPart('content_fields/fields/price_output_'.$this->id.'.tpl.php'))) {
				$template = 'content_fields/fields/price_output.tpl.php';
			}
			
			$template = apply_filters('alsp_content_field_output_template', $template, $this, $listing);
				
			alsp_frontendRender($template, array('content_field' => $this, 'formatted_price' => $formatted_price, 'listing' => $listing));
		}
	}
	
	public function orderParams() {
		global $ALSP_ADIMN_SETTINGS;
		$order_params = array('orderby' => 'meta_value_num', 'meta_key' => '_content_field_' . $this->id);
		if ($ALSP_ADIMN_SETTINGS['alsp_orderby_exclude_null'])
			$order_params['meta_query'] = array(
				array(
					'key' => '_content_field_' . $this->id,
					'value'   => array(''),
					'compare' => 'NOT IN'
				)
			);
		return $order_params;
	}
	
	public function validateCsvValues($value, &$errors) {
		if (!is_numeric($value))
			$errors[] = sprintf(__('The %s field must contain only numbers.', 'ALSP'), $this->name);

		return $value;
	}
	
	public function renderOutputForMap($location, $listing) {
		if (is_numeric($this->value)) {
			return $this->currency_symbol . ' ' . number_format($this->value, 2, $this->decimal_separator, $this->thousands_separator);
		}
	}
}
?>