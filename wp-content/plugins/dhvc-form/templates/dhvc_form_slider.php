<?php

$output = $css_class ='';

extract ( shortcode_atts ( array (
		'type' => 'slider',
		'control_label' => '',
		'control_name' => '',
		'minimum_value' => '',
		'maximum_value' => '',
		'step' => '',
		'default_value' => '',
		'help_text' => '',
		'conditional'=>'',
		'el_class' => '',
		'input_css'=>'',
), $atts ) );

wp_enqueue_script('jquery-ui-slider');
wp_enqueue_script('jquery-ui-touch-punch',DHVC_FORM_URL.'/assets/js/jquery.ui.touch-punch.min.js');

$name = $this->getControlName($control_name);

if(empty($name)){
	echo __('Field name is required', 'dhvc-form');
	return;
}

$default_value = absint($default_value);
global $dhvc_form;
$default_value = apply_filters('dhvc_form_slider_default_value', $default_value,$dhvc_form,$name);
$label = $control_label;

$minmax = absint($minimum_value) + ((absint($maximum_value) - absint($minimum_value)) * 0.3 );

$el_class = $this->getExtraClass($el_class);
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $this->settings['base'].' '. $el_class,$this->settings['base'],$atts );
$output .='<div class="dhvc-form-group dhvc-form-'.$name.'-box '.$css_class.vc_shortcode_custom_css_class($input_css,' ').'">'."\n";
if(!empty($label)){
	$output .='<label class="dhvc-form-label">'.$label.(!empty($required) ? ' <span class="required">*</span>':'').($type == "slider" ? ' (<span class="dhvc-form-slider-value">'.$default_value.'</span>)' : '(<span class="dhvc-form-slider-value-from">0</span> - <span class="dhvc-form-slider-value-to">'.$minmax.'</span>)').'</label>' . "\n";
}
$output .='<div class="dhvc-form-slider '.(!empty($conditional) && $type == "slider" ? ' dhvc-form-conditional':'').' dhvc-form-control-'.$name.'">'."\n";
$output .='<div class="dhvc-form-slider-control" data-min="'.absint($minimum_value).'" data-max="'.absint($maximum_value).'" data-step="'.absint($step).'" data-type="'.$type.'" data-value="'.$default_value.'" data-minmax="'.$minmax.'"></div>';
$output .='<input '.(!empty($conditional)  && $type == "slider" ? 'data-conditional-name="'.$name.'" data-conditional="'.esc_attr(base64_decode($conditional)).'"': '' ).' type="hidden" data-field-name="'.$name.'" class="dhvc-form-value" id="dhvc_form_control_'.$name.'" name="'.$name.'" value="'.($type == "slider" ? $default_value : '0-'.$minmax).'">' . "\n";
$output .='</div>';
if(!empty($help_text)){
	$output .='<span class="dhvc-form-help">'.$help_text.'</span>' . "\n";
}
$output .='</div>'."\n";

echo $output;