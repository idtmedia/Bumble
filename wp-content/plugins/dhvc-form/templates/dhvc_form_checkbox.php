<?php
$output = $css_class ='';

extract(shortcode_atts(array(
	'control_label'=>'',
	'control_name'=>'',
	'options'=>'',
	'option_width'=>'',
	'help_text'=>'',
	'required'=>'',
	'disabled'=>'',
	'conditional'=>'',
	'el_class'=> '',
	'input_css'=>'',
), $atts));

$name = $this->getControlName($control_name);
if(empty($name)){
	echo __('Field name is required', 'dhvc-form');
	return;
}
$label = $control_label;

$option_width_pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
// allowed metrics: http://www.w3schools.com/cssref/css_units.asp
$option_width_regexr = preg_match( $option_width_pattern, $option_width, $option_width_matches );
$option_width_value = isset( $option_width_matches[1] ) ? (float) $option_width_matches[1] : 0;
$option_width_unit = isset( $option_width_matches[2] ) ? $option_width_matches[2] : 'px';
$option_width_ = $option_width_value . $option_width_unit;

$inline_css = ( (float) $option_width_ > 0.0 ) ? ' style="width: ' . esc_attr( $option_width_ ) . '"' : '';


$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $this->settings['base'].' '. $el_class,$this->settings['base'],$atts );

$output .='<div class="dhvc-form-group dhvc-form-'.$name.'-box '.$css_class.vc_shortcode_custom_css_class($input_css,' ').'">'."\n";
if(!empty($label)){
	$output .='<label class="dhvc-form-label">'.$label.(!empty($required) ? ' <span class="required">*</span>':'').'</label>' . "\n";
}

$output .='<div class="dhvc-form-checkbox'.(!empty($inline_css) ? ' dhvc-form-checkbox__custom_w':'').(!empty($conditional) ? ' dhvc-form-conditional':'').'">'."\n";
if(!empty($options)){
	$options_arr = json_decode(base64_decode($options));
	global $dhvc_form;
	$options_arr = apply_filters('dhvc_form_checkbox_options', $options_arr,$dhvc_form,$name);
	$checkbox_name = (count($options_arr) > 1) ? $name.'[]' : $name;
	
	if(!empty($options_arr)){
		$i =0;
		foreach ((array)$options_arr as $option){
			$id = uniqid('_');
			$label_image = '';
			$label_class = '';
			$label_arr = explode('==', $option->label);
			if(isset($label_arr[1]) && 'http'===substr($label_arr[1], 0, 4 )){
				$label_class = 'dhvc-form-image-label';
				$label_image = '<span class="dhvc-form-radio__image"><img src="'.$label_arr[1].'"/></span>';
			}
			$output .='<label  class="'.$label_class.'" for="dhvc_form_control_'.sanitize_title($option->value).$id.'" '.$inline_css.'>';
			$output .= $label_image;
			$output .= '<input data-field-name="'.$name.'" data-name="'.$name.'" '.(!empty($conditional) ? 'data-conditional-name="'.$name.'" data-conditional="'.esc_attr(base64_decode($conditional)).'"': '' ).' type="checkbox" '.(!empty($disabled) ? ' disabled':'').' class="dhvc-form-value dhvc-form-control-'.$name.' '.(!empty($required) && $i ==0 ? 'dhvc-form-required-entry':'').'"  id="dhvc_form_control_'.sanitize_title($option->value).$id.'" '.($option->is_default === 1 ? 'checked="checked"' :'').' name="'.$checkbox_name.'" value="'.esc_attr($option->value).'"><i></i>';
			$output .= !empty($label_image) ? esc_html($label_arr[0]) : esc_html($option->label);
			$output .= '</label>'."\n";
			$i++;
		}
	}
}
$output .='</div>';
if(!empty($help_text)){
	$output .='<span class="dhvc-form-help">'.$help_text.'</span>' . "\n";
}
$output .='</div>'."\n";

echo $output;