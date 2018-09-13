<?php
$output ='';
global $dhvc_form;
extract(shortcode_atts(array(
	'control_name'=>'',
	'default_value'=>'',
), $atts));
$name = $this->getControlName($control_name);
if(empty($name)){
	echo __('Field name is required', 'dhvc-form');
	return;
}
$default_value = esc_attr($default_value);
$default_value = apply_filters('dhvc_form_hidden_default_value', $default_value,$dhvc_form,$name);

$output .= '<input type="hidden" class="dhvc-form-value" data-field-name="'.$name.'" id="dhvc_form_control_'.$name.'" name="'.$name.'" value="'.$default_value.'">' . "\n";
echo $output;