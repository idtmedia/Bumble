<?php
$output = $css_class ='';

extract(shortcode_atts(array(
	'control_label'=>'',
	'control_name'=>'',
	'help_text'=>'',
	'required'=>'',
	'attributes'=>'',
	'el_class'=> '',
	'input_css'=>'',
), $atts));

$name = $this->getControlName($control_name);
if(empty($name)){
	echo __('Field name is required', 'dhvc-form');
	return;
}
$label = $control_label;

$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $this->settings['base'].' '. $el_class,$this->settings['base'],$atts );

$output .='<div class="dhvc-form-group dhvc-form-'.$name.'-box '.$css_class.vc_shortcode_custom_css_class($input_css,' ').'">'."\n";
if(!empty($label)){
	$output .='<label class="dhvc-form-label">'.$label.(!empty($required) ? ' <span class="required">*</span>':'').'</label>' . "\n";
}
$output .='<div class="dhvc-form-file">'."\n";
//$output .= '<input type="file" class="dhvc-form-value dhvc-form-control-'.$name.' '.(!empty($required) ? ' dhvc-form-required-entry':'').'" id="'.$name.'" name="'.$name.'" '
//		.(!empty($required) ? ' required aria-required="true"':'').' '.$attributes.'>' . "\n";
$output .='<label for="dhvc_form_control_'.$name.'">';
$output .= '<span class="dhvc-form-file-button">'."\n";
$output .= '<i>'.__('Browse','dhvc-form').'</i>'."\n";
$output .= '</span>'."\n";
$output .='<input id="dhvc_form_control_'.$name.'" data-field-name="'.$name.'" name="'.$name.'" class="dhvc-form-value dhvc-form-validate-extension dhvc-form-control-'.$name.' '.(!empty($required) ? ' dhvc-form-required-entry':'').'" type="file">';
$output .= '<input autocomplete="off" class="dhvc-form-control" type="text" value="" readonly="readonly">'."\n";
$output .= '</label>' . "\n";				
$output .='</div>';
if(!empty($help_text)){
	$output .='<span class="dhvc-form-help">'.$help_text.'</span>' . "\n";
}
$output .='</div>'."\n";

echo $output;

