<?php
$output = $css_class ='';
extract(shortcode_atts(array(
	'control_label'=>'',
	'control_name'=>'',
	'default_value'=>'',
	'minlength'=>'',
	'maxlength'=>'',
	'icon'=>'',
	'placeholder'=>'',
	'help_text'=>'',
	'required'=>'',
	'readonly'=>'',
	'validator'=>'',
	'attributes'=>'',
	'el_class'=> '',
	'input_css'=>'',
), $atts));

$name = $this->getControlName($control_name);
if(empty($name)){
	echo __('Field name is required', 'dhvc-form');
	return;
}

$default_value = esc_attr($default_value);
global $dhvc_form;
$default_value = apply_filters('dhvc_form_text_default_value', $default_value,$dhvc_form,$name);
$label = $control_label;

$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $this->settings['base'].' '. $el_class,$this->settings['base'],$atts );

$input_class='';
$icon_html = '';
if(!empty($icon) && $icon != 'None'){
	$input_class = ' dhvc-form-has-add-on';
	$icon_html ='<span class="dhvc-form-add-on"><i class="'.$icon.'"></i></span>'."\n";
}

$output .='<div class="dhvc-form-group dhvc-form-'.$name.'-box '.$css_class.vc_shortcode_custom_css_class($input_css,' ').'">'."\n";
if(!empty($label)){
	$output .='<label class="dhvc-form-label" for="dhvc_form_control_'.$name.'">'.$label.(!empty($required) ? ' <span class="required">*</span>':'').'</label>' . "\n";
}
$output .='<div class="dhvc-form-input '.$input_class.'">'."\n";
$output .= '<input data-field-name="'.$name.'" autocomplete="off" type="text" id="dhvc_form_control_'.$name.'" name="'.$name.'" value="'.$default_value.'" '.(!empty($minlength) ? ' minlength="'.$minlength.'"' : '').' '.(!empty($maxlength) ? ' maxlength="'.$maxlength.'"' : '')
		.' class="dhvc-form-control dhvc-form-control-'.$name.' dhvc-form-value'.(!empty($required) ? ' dhvc-form-required-entry':'').' '.(!empty($validator) ? str_replace(',', ' ', $validator):'').'" '.(!empty($required) ? ' required aria-required="true"':'').' '.($readonly =='yes' ? ' readonly':'').' placeholder="'.$placeholder.'" '.$attributes.'>' . "\n";
$output .=$icon_html;
$output .='</div>';
if(!empty($help_text)){
	$output .='<span class="dhvc-form-help">'.$help_text.'</span>' . "\n";
}
$output .='</div>'."\n";

echo $output;

