<?php
$output = $css_class = '';

extract ( shortcode_atts ( array (
		'control_label' => '',
		'control_name' => '',
		'placeholder' => '',
		'help_text' => '',
		'required' => '1',
		'attributes' => '',
		'el_class' => '' ,
		'input_css'=>'',
), $atts ) );
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
	$output .='<label class="dhvc-form-label" for="dhvc_form_control_'.$name.'">'.$label.(!empty($required) ? ' <span class="required">*</span>':'').'</label>' . "\n";
}

if(!class_exists('ReallySimpleCaptcha')){
	$output .='<div class="dhvc-form-captcha-notice">'."\n";
	$output .= sprintf(__( "To use CAPTCHA, you need %s plugin installed.", 'dhvc-form' ),'<a target="_blank" href="https://wordpress.org/plugins/really-simple-captcha/">Really Simple CAPTCHA</a>');
	$output .='</div>';
}else{
	$output .='<div class="dhvc-form-captcha">'."\n";
	$filename = dhvc_form_field_captcha_generate();
	$prefix = substr( $filename, 0, strrpos( $filename, '.' ) );
	$output .= '<input autocomplete="off" type="text" id="dhvc_form_control_'.$name.'" name="'.$name.'" '
			.' class="dhvc-form-control dhvc-form-control-'.$name.' dhvc-form-value'.(!empty($required) ? ' dhvc-form-required-entry dhvc-form-validate-captcha':'').'" '.(!empty($required) ? ' required aria-required="true"':'').' placeholder="'.$placeholder.'">' . "\n";
	$output .= '<div class="dhvc-form-captcha-img">';
	$output .='<img class="dhvc-form-captcha-img-'.$name.'" src="'.dhvc_form_field_captcha_img_url($filename).'">';
	$output .='<input type="hidden" name="_dhvc_form_captcha_challenge_'.$name.'" value="'.$prefix.'" />';
	$output .='</div>';
	$output .='</div>';
	if(!empty($help_text)){
		$output .='<span class="dhvc-form-help">'.$help_text.'</span>' . "\n";
	}
}
$output .='</div>'."\n";

echo $output;
