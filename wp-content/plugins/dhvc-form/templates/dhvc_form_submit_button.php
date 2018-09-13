<?php

$output ='';
extract(shortcode_atts(array(
	'label'=>__('Submit','dhvc-form'),
	'el_class'=>'',
	'input_css'=>'',
), $atts));

$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $this->settings['base'].' '. $el_class,$this->settings['base'],$atts );


$output = '<div class="dhvc-form-action '.$css_class.vc_shortcode_custom_css_class($input_css,' ').'"><button type="submit" class="button dhvc-form-submit"><span class="dhvc-form-submit-label">'.esc_html($label).'</span><span class="dhvc-form-submit-spinner"></span></button></div>';

echo $output;