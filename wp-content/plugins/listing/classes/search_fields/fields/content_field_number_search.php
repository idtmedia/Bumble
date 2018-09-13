<?php 

class alsp_content_field_number_search extends alsp_content_field_search {
	public $mode = 'exact_number';
	public $min_max_options = array();
	public $min_max_value = array('min' => '', 'max' => '');
	public $slider_step_1_min = 0;
	public $slider_step_1_max = 100;

	public function searchConfigure() {
		global $wpdb, $alsp_instance;

		if (alsp_getValue($_POST, 'submit') && wp_verify_nonce($_POST['alsp_configure_content_fields_nonce'], ALSP_PATH)) {
			$validation = new alsp_form_validation();
			$validation->set_rules('mode', __('Search mode', 'ALSP'), 'required|alpha_dash');
			$validation->set_rules('min_max_options[]', __('Min-Max options', 'ALSP'), 'numeric');
			$validation->set_rules('slider_step_1_min', __('From option', 'ALSP'), 'integer');
			$validation->set_rules('slider_step_1_max', __('To option', 'ALSP'), 'integer');
			if ($validation->run()) {
				$result = $validation->result_array();
				if ($wpdb->update($wpdb->alsp_content_fields, array('search_options' => serialize(array('mode' => $result['mode'], 'min_max_options' => $result['min_max_options[]'], 'slider_step_1_min' => $result['slider_step_1_min'], 'slider_step_1_max' => $result['slider_step_1_max']))), array('id' => $this->content_field->id), null, array('%d')))
					alsp_addMessage(__('Search field configuration was updated successfully!', 'ALSP'));
				
				$alsp_instance->content_fields_manager->showContentFieldsTable();
			} else {
				$this->mode = $validation->result_array('mode');
				$this->min_max_options = $validation->result_array('min_max_options[]');
				$this->slider_step_1_min = $validation->result_array('slider_step_1_min');
				$this->slider_step_1_max = $validation->result_array('slider_step_1_max');
				alsp_addMessage($validation->error_string(), 'error');

				alsp_frontendRender('search_fields/fields/number_price_configuration.tpl.php', array('search_field' => $this));
			}
		} else{
			alsp_frontendRender('search_fields/fields/number_price_configuration.tpl.php', array('search_field' => $this));
		}
		
	}
	
	public function buildSearchOptions() {
		if (isset($this->content_field->search_options['mode']))
			$this->mode = $this->content_field->search_options['mode'];
		if (isset($this->content_field->search_options['min_max_options']))
			$this->min_max_options = $this->content_field->search_options['min_max_options'];
		if (isset($this->content_field->search_options['slider_step_1_min']))
			$this->slider_step_1_min = $this->content_field->search_options['slider_step_1_min'];
		if (isset($this->content_field->search_options['slider_step_1_max']))
			$this->slider_step_1_max = $this->content_field->search_options['slider_step_1_max'];
	}
	
	public function renderSearch($random_id) {
		if ($this->mode == 'exact_number')
			alsp_frontendRender('search_fields/fields/number_input_exactnumber.tpl.php', array('search_field' => $this, 'columns' => $columns, 'random_id' => $random_id));
		elseif ($this->mode == 'min_max')
			alsp_frontendRender('search_fields/fields/number_input_minmax.tpl.php', array('search_field' => $this, 'columns' => $columns, 'random_id' => $random_id));
		elseif ($this->mode == 'min_max_slider' || $this->mode == 'range_slider')
			alsp_frontendRender('search_fields/fields/number_input_slider.tpl.php', array('search_field' => $this, 'columns' => $columns, 'price_col' => $price_col, 'random_id' => $random_id));
	}
	
	public function validateSearch(&$args, $defaults = array(), $include_GET_params = true) {
		if ($this->mode == 'exact_number') {
			$field_index = 'field_' . $this->content_field->slug;

			if ($include_GET_params)
				$value = alsp_getValue($_GET, $field_index, alsp_getValue($defaults, $field_index));
			else
				$value = alsp_getValue($defaults, $field_index);

			if ($value && is_numeric($value)) {
				$this->value = $value;
				$args['meta_query']['relation'] = 'AND';
				$args['meta_query'][] = array(
						'key' => '_content_field_' . $this->content_field->id,
						'value' => $this->value,
						'type' => 'NUMERIC'
				);
			}
		} elseif ($this->mode == 'min_max' || $this->mode == 'min_max_slider' || $this->mode == 'range_slider') {
			$field_index = 'field_' . $this->content_field->slug . '_min';
			$value = alsp_getValue($_GET, $field_index, alsp_getValue($defaults, $field_index));
			if ($value && is_numeric($value)) {
				$this->min_max_value['min'] = $value;
				$args['meta_query']['relation'] = 'AND';
				$args['meta_query'][] = array(
						'key' => '_content_field_' . $this->content_field->id,
						'value' => $this->min_max_value['min'],
						'type' => 'numeric',
						'compare' => '>='
				);
			}
			$field_index = 'field_' . $this->content_field->slug . '_max';
			$value = alsp_getValue($_GET, $field_index, alsp_getValue($defaults, $field_index));
			if ($value && is_numeric($value)) {
				$this->min_max_value['max'] = $value;
				$args['meta_query']['relation'] = 'AND';
				$args['meta_query'][] = array(
						'key' => '_content_field_' . $this->content_field->id,
						'value' => $this->min_max_value['max'],
						'type' => 'numeric',
						'compare' => '<='
				);
			}
		}
	}
	
	public function getBaseUrlArgs(&$args) {
		if ($this->mode == 'exact_number') {
			parent::getBaseUrlArgs($args);
		} elseif ($this->mode == 'min_max' || $this->mode == 'min_max_slider' || $this->mode == 'range_slider') {
			$field_index = 'field_' . $this->content_field->slug . '_min';
			if (isset($_GET[$field_index]) && is_numeric($_GET[$field_index]))
				$args[$field_index] = $_GET[$field_index];
			
			$field_index = 'field_' . $this->content_field->slug . '_max';
			if (isset($_GET[$field_index]) && is_numeric($_GET[$field_index]))
				$args[$field_index] = $_GET[$field_index];
		}
	}
	
	public function getVCParams() {
		if ($this->mode == 'exact_number') {
			return array(
					array(
							'type' => 'textfield',
							'param_name' => 'field_' . $this->content_field->slug,
							'heading' => $this->content_field->name,
					),
			);
		} elseif ($this->mode == 'min_max' || $this->mode == 'min_max_slider' || $this->mode == 'range_slider') {
			return array(
					array(
							'type' => 'textfield',
							'param_name' => 'field_' . $this->content_field->slug . '_min',
							'heading' => $this->content_field->name . ' ' . __('Min', 'ALSP'),
					),
					array(
							'type' => 'textfield',
							'param_name' => 'field_' . $this->content_field->slug . '_max',
							'heading' => $this->content_field->name . ' ' . __('Max', 'ALSP'),
					),
			);
		}
	}
}
?>