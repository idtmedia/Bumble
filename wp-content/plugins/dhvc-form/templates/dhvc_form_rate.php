<?php

$output = $css_class ='';

extract ( shortcode_atts ( array (
		'control_label' => '',
		'control_name' => '',
		'rate_option'=>'',
		'help_text' => '',
		'conditional'=>'',
		'el_class' => '',
		'input_css'=>'',
), $atts ) );
wp_enqueue_style('dhvc-form-bootstrap-tooltip');
wp_enqueue_script('dhvc-form-bootstrap-tooltip');
$name = $this->getControlName($control_name);
if(empty($name)){
	echo __('Field name is required', 'dhvc-form');
	return;
}
$label = esc_html($control_label);

$el_class = $this->getExtraClass($el_class);
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $this->settings['base'].' '. $el_class,$this->settings['base'],$atts );

$output .='<div class="dhvc-form-group dhvc-form-'.$name.'-box '.$css_class.vc_shortcode_custom_css_class($input_css,' ').'">'."\n";
if(!empty($label)){
	$output .='<label class="dhvc-form-label">'.$label.(!empty($required) ? ' <span class="required">*</span>':'').'</label>' . "\n";
}
$output .='<div class="dhvc-form-rate '.(!empty($conditional) ? ' dhvc-form-conditional':'').' dhvc-form-control-'.$name.'">'."\n";
$rate_option_64 = base64_decode($rate_option);
$rate_option_arr = json_decode($rate_option_64);

if(is_array($rate_option_arr) && !empty($rate_option_arr)){
	$c = count($rate_option_arr);
	for($i = $c;$i--;$i > 0 ){
		$v = $rate_option_arr[$i];
		$output .='<input data-field-name="'.$name.'" '.(!empty($conditional) ? 'data-conditional-name="'.$name.'" data-conditional="'.esc_attr(base64_decode($conditional)).'"': '' ).' name="'.$name.'" value="'.$v->value.'" id="'.sanitize_title($name).'-'.$v->value.'" class="dhvc-form-value" type="radio">' . "\n";
		$output .='<label class="dhvc-form-rate-star" data-toggle="tooltip" data-original-title="'.esc_html($v->label).'" for="'.sanitize_title($name).'-'.$v->value.'"><i class="fa fa-star"></i></label>' . "\n";
	}
}
$output .='</div>';
if(!empty($help_text)){
	$output .='<span class="dhvc-form-help">'.$help_text.'</span>' . "\n";
}
$output .='</div>'."\n";

echo $output;