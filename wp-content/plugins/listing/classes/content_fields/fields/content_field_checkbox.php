<?php 

class alsp_content_field_checkbox extends alsp_content_field_select {
	public $how_display_items;
	public $check_icon_type;
	public $value = array();
	public $icon_selection_items = array();
	protected $can_be_searched = true;
	protected $is_search_configuration_page = true;
	
	public function __construct() {
		parent::__construct();
		
		//add_action('alsp_select_content_field_configuration_html', array($this, 'add_configuration_options'));
	}
	
	public function add_configuration_options($content_field) {
		if (is_a($content_field, 'alsp_content_field_checkbox')) {
			echo '
				<div class="checkbox_how_to_show">
					<div class="item-label">
						<label>' . __('How to display items', 'ALSP') . '</label>
					</div>
					<div class="how-to-show-input">
						<label>
							<input
								name="how_display_items"
								type="radio"
								value="all"
								' . checked($this->how_display_items, 'all', true) . ' />
								' . __('All items with checked/unchecked marks', 'ALSP') .'
						</label>
						<br />
						<label>
							<input
								name="how_display_items"
								type="radio"
								value="checked"
								' . checked($this->how_display_items, 'checked', false) . ' />
								' . __('Only checked items', 'ALSP') . '
						</label>
					</div>
				</div>
				<div class="check_icon_type">
					<div class="item-label">
						<label>' . __('Select icon type', 'ALSP') . '</label>
					</div>
					<div class="check_icon_type_input">
						<label>
							<input
								name="check_icon_type"
								type="radio"
								value="default"
								' . checked($this->check_icon_type, 'default', true) . ' />
								' . __('default check icon ', 'ALSP') .'
						</label>
						<br />
						<label>
							<input
								name="check_icon_type"
								type="radio"
								value="custom_icon"
								' . checked($this->check_icon_type, 'custom_icon', false) . ' />
								' . __('Custom icons', 'ALSP') . '
						</label>
					</div>
				</div>';
		}
	}
	
	
	
	public function configure() {
		global $wpdb, $alsp_instance;
	
		if (alsp_getValue($_POST, 'submit') && wp_verify_nonce($_POST['alsp_configure_content_fields_nonce'], ALSP_PATH)) {
			$validation = new alsp_form_validation();
			$validation->set_rules('selection_items[]', __('Selection items', 'ALSP'), 'required');
			$validation->set_rules('how_display_items', __('How to display items', 'ALSP'), 'required');
			$validation->set_rules('check_icon_type', __('Select Icon Type', 'ALSP'), 'required');
			$validation->set_rules('icon_selection_items[]', __('Selection Icon', 'ALSP'), '');
			if ($validation->run()) {
				$result = $validation->result_array();
	
				$insert_update_args['selection_items'] = $result['selection_items[]'];
				$insert_update_args['how_display_items'] = $result['how_display_items'];
				$insert_update_args['check_icon_type'] = $result['check_icon_type'];
				$insert_update_args['icon_selection_items'] = $result['icon_selection_items[]'];
	
				$insert_update_args = apply_filters('alsp_selection_items_update_args', $insert_update_args, $this, $result);
	
				if ($insert_update_args) {
					$wpdb->update($wpdb->alsp_content_fields, array('options' => serialize($insert_update_args)), array('id' => $this->id), null, array('%d'));
				}
	
				alsp_addMessage(__('Field configuration was updated successfully!', 'ALSP'));
	
				do_action('alsp_update_selection_items', $result['selection_items[]'], $this);
	
				$alsp_instance->content_fields_manager->showContentFieldsTable();
			} else {
				$this->selection_items = $validation->result_array('selection_items[]');
				alsp_addMessage($validation->error_array(), 'error');
	
				alsp_frontendRender('content_fields/fields/select_configuration.tpl.php', array('content_field' => $this));
			}
		} else {
			alsp_frontendRender('content_fields/fields/select_configuration.tpl.php', array('content_field' => $this));
		}
	}
	
	public function buildOptions() {
		if (isset($this->options['selection_items'])) {
			$this->selection_items = $this->options['selection_items'];
		}
		if (isset($this->options['how_display_items'])) {
			$this->how_display_items = $this->options['how_display_items'];
		}
		if (isset($this->options['check_icon_type'])) {
			$this->check_icon_type = $this->options['check_icon_type'];
		}
		if (isset($this->options['icon_selection_items'])) {
			$this->icon_selection_items = $this->options['icon_selection_items'];
		}
	}

	public function renderInput() {
		if (!($template = alsp_isFrontPart('content_fields/fields/checkbox_input_'.$this->id.'.tpl.php'))) {
			$template = 'content_fields/fields/checkbox_input.tpl.php';
		}
		
		$template = apply_filters('alsp_content_field_input_template', $template, $this);
			
		alsp_frontendRender($template, array('content_field' => $this));
	}
	
	public function validateValues(&$errors, $data) {
		$field_index = 'alsp-field-input-' . $this->id . '[]';

		$validation = new alsp_form_validation();
		$validation->set_rules($field_index, $this->name);
		if (!$validation->run())
			$errors[] = $validation->error_array();
		elseif ($selected_items_array = $validation->result_array($field_index)) {
			foreach ($selected_items_array AS $selected_item) {
				if (!in_array($selected_item, array_keys($this->selection_items)))
					$errors[] = sprintf(__("This selection option index \"%d\" doesn't exist", 'ALSP'), $selected_item);
			}
	
			return $selected_items_array;
		} elseif ($this->canBeRequired() && $this->is_required)
			$errors[] = sprintf(__('At least one option must be selected in "%s" content field', 'ALSP'), $this->name);
	}
	
	public function saveValue($post_id, $validation_results) {
		delete_post_meta($post_id, '_content_field_' . $this->id);
		if ($validation_results && is_array($validation_results)) {
			foreach ($validation_results AS $value)
				add_post_meta($post_id, '_content_field_' . $this->id, $value);
		}
		return true;
	}
	
	public function loadValue($post_id) {
		if (!($this->value = get_post_meta($post_id, '_content_field_' . $this->id)) || $this->value[0] == '')
			$this->value = array();
		else {
			$result = array();
			foreach ($this->selection_items AS $key=>$value) {
				if (array_search($key, $this->value) !== FALSE)
					$result[] = $key;
			}
			$this->value = $result;
		}
		
		$this->value = apply_filters('alsp_content_field_load', $this->value, $this, $post_id);
		return $this->value;
	}
	
	public function renderOutput($listing = null) {
		if (!($template = alsp_isFrontPart('content_fields/fields/checkbox_output_'.$this->id.'.tpl.php'))) {
			$template = 'content_fields/fields/checkbox_output.tpl.php';
		}

		$template = apply_filters('alsp_content_field_output_template', $template, $this, $listing);
			
		alsp_frontendRender($template, array('content_field' => $this, 'listing' => $listing));
	}
	
	public function validateCsvValues($value, &$errors) {
		if ($value) {
			$output = array();
			foreach ((array) $value AS $key=>$selected_item) {
				if (array_key_exists($selected_item, $this->selection_items))
					$output[] = $selected_item;

				if (!in_array($selected_item, $this->selection_items))
					$errors[] = sprintf(__("This selection option \"%s\" doesn't exist", 'ALSP'), $selected_item);
				else
					$output[] = array_search($selected_item, $this->selection_items);
			}
			return $output;
		} else 
			return '';
	}
	
	public function exportCSV() {
		return implode(';', $this->value);
	}
	
	public function renderOutputForMap($location, $listing) {
		return alsp_frontendRender('content_fields/fields/checkbox_output_map.tpl.php', array('content_field' => $this, 'listing' => $listing), true);
	}
}
?>