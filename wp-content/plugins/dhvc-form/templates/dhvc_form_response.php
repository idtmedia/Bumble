<?php
$output = $css_class ='';
extract(shortcode_atts(array(
	'el_class'=> '',
	'input_css'=>'',
), $atts));

$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $this->settings['base'].' '. $el_class,$this->settings['base'],$atts );

$output .='<div class="dhvc-form-message '.$css_class.vc_shortcode_custom_css_class($input_css,' ').'">'."\n";
$output .='</div>'."\n";

echo $output;

