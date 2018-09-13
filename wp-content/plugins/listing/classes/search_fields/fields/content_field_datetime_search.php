<?php 

class alsp_content_field_datetime_search extends alsp_content_field_search {
	public $min_max_value = array('min' => '', 'max' => '');

	public function renderSearch($random_id, $columns = 2, $datetime_col = 6, $search_form_type = '') {
		wp_enqueue_script('jquery-ui-datepicker');
		
		if ($i18n_file = alsp_getDatePickerLangFile(get_locale())) {
			wp_register_script('datepicker-i18n', $i18n_file, array('jquery-ui-datepicker'));
			wp_enqueue_script('datepicker-i18n');
		}

		alsp_frontendRender('search_fields/fields/datetime_input.tpl.php', array('search_field' => $this, 'columns' => $columns, 'datetime_col' => $datetime_col, 'dateformat' => alsp_getDatePickerFormat(), 'random_id' => $random_id, 'search_form_type' => $search_form_type));
	}
	
	public function validateSearch(&$args, $defaults = array(), $include_GET_params = true) {
		$field_index = 'field_' . $this->content_field->slug . '_min';

		if ($include_GET_params)
			$value = alsp_getValue($_GET, $field_index, alsp_getValue($defaults, $field_index));
		else
			$value = alsp_getValue($defaults, $field_index);

		if ($value && (is_numeric($value) || strtotime($value))) {
			$this->min_max_value['min'] = $value;
			$args['meta_query']['relation'] = 'AND';
			$args['meta_query'][] = array(
					'key' => '_content_field_' . $this->content_field->id . '_date',
					'value' => $this->min_max_value['min'],
					'type' => 'numeric',
					'compare' => '>='
			);
		}

		$field_index = 'field_' . $this->content_field->slug . '_max';
		$value = alsp_getValue($_GET, $field_index, alsp_getValue($defaults, $field_index));
		if ($value && (is_numeric($value) || strtotime($value))) {
			$this->min_max_value['max'] = $value;
			$args['meta_query']['relation'] = 'AND';
			$args['meta_query'][] = array(
					'key' => '_content_field_' . $this->content_field->id . '_date',
					'value' => $this->min_max_value['max'],
					'type' => 'numeric',
					'compare' => '<='
			);
		}
	}
	
	public function getBaseUrlArgs(&$args) {
		$field_index = 'field_' . $this->content_field->slug . '_min';
		if (isset($_GET[$field_index]) && $_GET[$field_index] && is_numeric($_GET[$field_index]))
			$args[$field_index] = $_GET[$field_index];

		$field_index = 'field_' . $this->content_field->slug . '_max';
		if (isset($_GET[$field_index]) && $_GET[$field_index] && is_numeric($_GET[$field_index]))
			$args[$field_index] = $_GET[$field_index];
	}
	
	public function getVCParams() {
		wp_enqueue_script('jquery-ui-datepicker');
		if ($i18n_file = alsp_getDatePickerLangFile(get_locale())) {
			wp_register_script('datepicker-i18n', $i18n_file, array('jquery-ui-datepicker'));
			wp_enqueue_script('datepicker-i18n');
		}
		
		return array(
				array(
					'type' => 'datefieldmin',
					'param_name' => 'field_' . $this->content_field->slug . '_min',
					'heading' => __('From ', 'ALSP') . $this->content_field->name,
					'field_id' => $this->content_field->id,
				),
				array(
					'type' => 'datefieldmax',
					'param_name' => 'field_' . $this->content_field->slug . '_max',
					'heading' => __('To ', 'ALSP') . $this->content_field->name,
					'field_id' => $this->content_field->id,
				)
			);
	}
}

add_action('vc_before_init', 'alsp_vc_init_datefield');
function alsp_vc_init_datefield() {
	vc_add_shortcode_param('datefieldmin', 'alsp_datefieldmin_param');
	vc_add_shortcode_param('datefieldmax', 'alsp_datefieldmax_param');
}
function alsp_datefieldmin_param($settings, $value) {
	return alsp_frontendRender('search_fields/fields/datetime_input_vc_min.tpl.php', array('settings' => $settings, 'value' => $value, 'dateformat' => alsp_getDatePickerFormat()), true);
}
function alsp_datefieldmax_param($settings, $value) {
	return alsp_frontendRender('search_fields/fields/datetime_input_vc_max.tpl.php', array('settings' => $settings, 'value' => $value, 'dateformat' => alsp_getDatePickerFormat()), true);
}
?>