<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//
if(!function_exists('vc_add_shortcode_param')){
	function vc_add_shortcode_param( $name, $form_field_callback, $script_url = null ) {
		return WpbakeryShortcodeParams::addField( $name, $form_field_callback, $script_url );
	}
}

function dhvc_form_textarea_variable_field($settings, $value){
	$param_line ='';
	$param_line .='<select onchange="dhvc_form_select_variable(this)" class="dhvc-form-select-variable">';
	$param_line .='<option value="">'.__('Insert variable...','dhvc-form').'</option>';
	foreach (dhvc_form_get_variables() as $label=>$key){
		$param_line .='<option value="'.esc_attr($key).'">'.esc_html($label).'</option>';
	}
	$param_line .='</select>';
	$param_line .= '<textarea name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textarea ' . $settings['param_name'] . ' ' . $settings['type'] . '">' . $value . '</textarea>';
	return $param_line;
		
}
vc_add_shortcode_param('dhvc_form_textarea_variable', 'dhvc_form_textarea_variable_field');

function dhvc_form_heading_field($settings, $value){
	return '<div style="background: none repeat scroll 0 0 #E1E1E1;font-size: 14px;font-weight: bold;padding: 5px 10px;">'.$value.'</div>';
}
vc_add_shortcode_param('dhvc_form_heading', 'dhvc_form_heading_field');

function dhvc_form_control_id_field($settings, $value){
	if(empty($value))
		$value = dhvc_form_gen_control_id();

	return '<input name="'.$settings['param_name'].'" class="wpb_vc_param_value dhvc-woo-param-value wpb-textinput" type="hidden" value="'.$value.'"/>';
}
vc_add_shortcode_param('dhvc_form_control_id', 'dhvc_form_control_id_field');

function dhvc_form_input_variable_field($settings, $value){
	$param_line ='';
	$param_line .='<select onchange="dhvc_form_select_variable(this)" class="dhvc-form-select-variable">';
	$param_line .='<option value="">'.__('Insert variable...','dhvc-form').'</option>';
	foreach (dhvc_form_get_variables() as $label=>$key){
		$param_line .='<option value="'.esc_attr($key).'">'.esc_html($label).'</option>';
	}
	$param_line .='</select>';
	$param_line .= '<input type="text" name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '" value="'.$value.'">' ;
	return $param_line;
		
}
vc_add_shortcode_param('dhvc_form_input_variable', 'dhvc_form_input_variable_field');

function dhvc_form_name_field($param, $value){
	return '<input name="' . $param['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $param['param_name'] . ' ' . $param['type'] . '" type="text" value="' . $value . '"/>';
}
vc_add_shortcode_param('dhvc_form_name', 'dhvc_form_name_field');

function dhvc_form_validator_field($settings, $value){
	$value_arr = explode(',', $value);
	if(empty($value_arr))
		$value_arr = array();
	$param_line ='';
	$param_line .='<select onchange="dhvc_form_select_validator(this)" multiple class="dhvc-form-select-validator">';
	$param_line .='<option value="">'.__('Select validator...','dhvc-form').'</option>';
	foreach (dhvc_form_get_validation() as $label=>$key){
		$param_line .='<option value="'.esc_attr($key).'" '.(in_array($key, $value_arr) ? 'selected="selected"':'').'>'.esc_html($label).'</option>';
	}
	$param_line .='</select>';
	$param_line .= '<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '" value="'.$value.'">' ;
	return $param_line;

}
vc_add_shortcode_param('dhvc_form_validator', 'dhvc_form_validator_field');

function dhvc_form_conditional_field($settings, $value){
	$value_64 = base64_decode($value);
	$value_arr = json_decode($value_64);
	$param_line ='';
	$param_line .='<div class="dhvc-form-conditional-list clearfix">';
	$param_line .= '<table>';
	$param_line .='<tbody>';
	if(is_array($value_arr) && !empty($value_arr)){
		foreach ($value_arr as $k=>$v){
			if(!property_exists($v,'element') || empty($v->element))
				continue;

			$param_line .='<tr>';
			$param_line .= '<td>';
			$param_line .='<label>'.__('If value this element','dhvc-form').'</label>';
			$param_line .='<select id="conditional-type" onchange="dhvc_form_conditional_select_type(this)">';
			$param_line .='<option '.selected($v->type,'=',false).' value="=">'.__('equals','dhvc-form').'</option>';
			$param_line .='<option '.selected($v->type,'>',false).' value=">">'.__('is greater than','dhvc-form').'</option>';
			$param_line .='<option '.selected($v->type,'<',false).' value="<">'.__('is less than','dhvc-form').'</option>';
			$param_line .='<option '.selected($v->type,'not_empty',false).' value="not_empty">'.__('not empty','dhvc-form').'</option>';
			$param_line .='<option '.selected($v->type,'is_empty',false).' value="is_empty">'.__('is empty','dhvc-form').'</option>';
			$param_line .='</select>';
			$param_line .= '</td>';
			$param_line .= '<td>';
			$param_line .='<label>'.__('Value','dhvc-form').'</label>';
			$param_line .='<input type="text" id="conditional-value" value="'.esc_attr($v->value).'" />';
			$param_line .= '</td>';
			$param_line .= '<td>';
			$param_line .='<label>'.__('Then','dhvc-form').'</label>';
			$param_line .='<select id="conditional-action">';
			$param_line .='<option '.selected($v->action,'hide',false).' value="hide">'.__('Hide','dhvc-form').'</option>';
			$param_line .='<option '.selected($v->action,'show',false).' value="show">'.__('Show','dhvc-form').'</option>';
			$param_line .='</select>';
			$param_line .= '</td>';
			$param_line .= '<td>';
			$param_line .='<label>'.__('Element(s) name','dhvc-form').'</label>';
			$param_line .='<input type="text" placeholder="element_1,element_2" value="'.esc_attr($v->element).'" id="conditional-element" />';
			$param_line .= '</td>';
			$param_line .= '<td class="dhvc-form-conditional">';
			$param_line .='<a href="#" onclick="return dhvc_form_conditional_remove(this);"  id="conditional-remove" title="'.__('Remove','dhvc-form').'">-</a>';
			$param_line .= '</td>';
			$param_line .='</tr>';
		}
	}
	$param_line .='</tbody>';
	$param_line .='<tfoot>';
	$param_line .='<tr>';
	$param_line .= '<td colspan="5">';
	$param_line .='<a href="#" onclick="return dhvc_form_conditional_add(this);"  class="button" title="'.__('Add','dhvc-form').'">'.__('Add','dhvc-form').'</a>';
	$param_line .= '</td>';
	$param_line .='</tr>';
	$param_line .='</tfoot>';
	$param_line .= '</table>';
	$param_line .= '<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '" value="'.$value.'">' ;
	$param_line .='</div>';
	return $param_line;
}
vc_add_shortcode_param('dhvc_form_conditional', 'dhvc_form_conditional_field');

function dhvc_form_rate_option_field($settings, $value){
	$value_64 = base64_decode($value);
	$value_arr = json_decode($value_64);
	if(empty($value_arr) && !is_array($value_arr)){
			
		for($i=0;$i<5;$i++){
			$value = $i+1;
			$option = new stdClass();
			$option->label = $value.'/5';
			$option->value = $value;
			$value_arr[] = $option;
		}
	}
	$param_line ='';
	$param_line .='<div class="dhvc-form-rate-option-list clearfix">';
	$param_line .= '<table>';
	$param_line .='<tbody>';
	if(is_array($value_arr) && !empty($value_arr)){
		foreach ($value_arr as $k=>$v){
			$param_line .='<tr>';
			$param_line .= '<td>';
			$param_line .='<input type="text" id="rate-label" value="'.esc_attr($v->label).'" />';
			$param_line .= '</td>';
			$param_line .= '<td>';
			$param_line .= __('Value','dhvc-form').':<span>'.esc_attr($v->value).'</span>';
			$param_line .='<input type="hidden" id="rate-value" value="'.esc_attr($v->value).'" />';
			$param_line .= '</td>';
			$param_line .= '<td class="dhvc-form-conditional">';
			$param_line .='<a href="#" onclick="return dhvc_form_rate_option_remove(this);"  title="'.__('Remove','dhvc-form').'">-</a>';
			$param_line .= '</td>';
			$param_line .='</tr>';
		}
	}
	$param_line .='</tbody>';
	$param_line .='<tfoot>';
	$param_line .='<tr>';
	$param_line .= '<td colspan="3">';
	$param_line .='<a href="#" onclick="return dhvc_form_rate_option_add(this);"  class="button" title="'.__('Add','dhvc-form').'">'.__('Add','dhvc-form').'</a>';
	$param_line .= '</td>';
	$param_line .='</tfoot>';
	$param_line .= '</table>';
	$param_line .= '<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '" value="'.$value.'">' ;
	$param_line .='</div>';
	return $param_line;
}
vc_add_shortcode_param('dhvc_form_rate_option', 'dhvc_form_rate_option_field');

function dhvc_form_paypal_items_list_field($settings, $value){
	$value_64 = base64_decode($value);
	$value_arr = json_decode($value_64);
	if(empty($value_arr) && !is_array($value_arr)){
		for($i = 0;$i<2;$i++){
			$option = new stdClass();
			$option->label = 'Item';
			$option->qty='field_1';
			$option->price = 'field_1*field_2';
			$value_arr[] = $option;
		}
	}
	$param_line ='';
	$param_line .='<div class="dhvc-form-paypal-item-list clearfix">';
	$param_line .= '<table>';
	$param_line .= '<thead>';
	$param_line .='<tr>';
	$param_line .='<td>';
	$param_line .=__('Items','dhvc-form');
	$param_line .='</td>';
	$param_line .='<td>';
	$param_line .=__('Qty','dhvc-form');
	$param_line .='</td>';
	$param_line .='<td>';
	$param_line .=__('Price','dhvc-form');
	$param_line .='</td>';
	$param_line .='<td>';
	$param_line .='</td>';
	$param_line .='</tr>';
	$param_line .= '</thead>';
	$param_line .='<tbody>';
	if(is_array($value_arr) && !empty($value_arr)){
		foreach ($value_arr as $k=>$v){
			$param_line .='<tr>';
			$param_line .= '<td>';
			$param_line .='<input type="text" placeholder="Item" id="label" value="'.esc_html($v->label).'" />';
			$param_line .= '</td>';
			$param_line .= '<td>';
			$param_line .='<input type="text" id="qty" placeholder="field_1" value="'.esc_html($v->qty).'" />';
			$param_line .= '</td>';
			$param_line .= '<td>';
			$param_line .='<input type="text" placeholder="field_1*field_2" id="price" value="'.esc_html($v->price).'" />';
			$param_line .= '</td>';
			$param_line .= '<td class="dhvc-form-conditional">';
			$param_line .='<a href="#" onclick="return dhvc_form_paypal_list_remove(this);"  title="'.__('Remove','dhvc-form').'">-</a>';
			$param_line .= '</td>';
			$param_line .='</tr>';
		}
	}
	$param_line .='</tbody>';
	$param_line .='<tfoot>';
	$param_line .='<tr>';
	$param_line .= '<td colspan="4">';
	$param_line .='<a href="#" onclick="return dhvc_form_paypal_list_add(this);" class="button" title="'.__('Add','dhvc-form').'">'.__('Add','dhvc-form').'</a>';
	$param_line .= '</td>';
	$param_line .='</tfoot>';
	$param_line .= '</table>';
	$param_line .= '<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '" value="'.$value.'">' ;
	$param_line .='</div>';
	return $param_line;
}
vc_add_shortcode_param('dhvc_form_paypal_items_list', 'dhvc_form_paypal_items_list_field');

function dhvc_form_option_field($settings, $value){
	$value_64 = base64_decode($value);
	$value_arr = json_decode($value_64);
	if(empty($value_arr) && !is_array($value_arr)){
		for($i = 0;$i<2;$i++){
			$option = new stdClass();
			$option->is_default = 0;
			$option->label='Option'.$i;
			$option->value = 'value'.$i;
			$value_arr[] = $option;
		}
	}
	$param_line ='';
	$param_line .='<div class="dhvc-form-option-list clearfix" data-option-type="'.(isset($settings['option_checkbox']) ? 'checkbox' : 'radio').'">';
	$param_line .= '<table>';
	$param_line .= '<thead>';
	$param_line .='<tr>';
	$param_line .='<td>';
	$param_line .=__('Is Default','dhvc-form');
	$param_line .='</td>';
	$param_line .='<td>';
	$param_line .=__('Label','dhvc-form');
	$param_line .='</td>';
	$param_line .='<td>';
	$param_line .=__('Value','dhvc-form');
	$param_line .='</td>';
	$param_line .='<td>';
	$param_line .='</td>';
	$param_line .='</tr>';
	$param_line .= '</thead>';
	$param_line .='<tbody>';
	if(is_array($value_arr) && !empty($value_arr)){
		foreach ($value_arr as $k=>$v){
			$param_line .='<tr>';
			$param_line .= '<td>';
			$param_line .='<input type="'.(isset($settings['option_checkbox']) ? 'checkbox' : 'radio').'" name="is_default" id="is_default" '.checked($v->is_default,'1',false).' value="1" />';
			$param_line .= '</td>';
			$param_line .= '<td>';
			$param_line .='<input type="text" id="label" value="'.esc_html($v->label).'" />';
			$param_line .= '</td>';
			$param_line .= '<td>';
			$param_line .='<input type="text" id="value" value="'.esc_html($v->value).'" />';
			$param_line .= '</td>';
			$param_line .= '<td class="dhvc-form-conditional">';
			$param_line .='<a href="#" onclick="return dhvc_form_option_remove(this);"  title="'.__('Remove','dhvc-form').'">-</a>';
			$param_line .= '</td>';
			$param_line .='</tr>';
		}
	}
	$param_line .='</tbody>';
	$param_line .='<tfoot>';
	$param_line .='<tr>';
	$param_line .= '<td colspan="4">';
	$param_line .='<a href="#" onclick="return dhvc_form_option_add(this);" class="button" title="'.__('Add','dhvc-form').'">'.__('Add','dhvc-form').'</a>';
	$param_line .= '</td>';
	$param_line .='</tfoot>';
	$param_line .= '</table>';
	$param_line .= '<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '" value="'.$value.'">' ;
	$param_line .='</div>';
	return $param_line;
}
vc_add_shortcode_param('dhvc_form_option', 'dhvc_form_option_field');