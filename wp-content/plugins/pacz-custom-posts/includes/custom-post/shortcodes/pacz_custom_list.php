<?php

extract( shortcode_atts( array(
			'el_class' => '',
			'style' => 'f00c',
			'icon_color'=> '',
			'animation' => '',
			'margin_bottom' => '',
		), $atts ) );

$id = uniqid();
$output = $animation_css = '';
if ( $animation != '' ) {
	$animation_css = ' pacz-animate-element ' . $animation . ' ';
}

if(substr( $style, 0, 2 ) == 'e6' ) {
	$font_family = 'Pe-icon-line';
} else if(substr( $style, 0, 2 ) == 'e0' ) {
	$font_family = 'Flaticon';
} else if ( substr( $style, 0, 1 ) == 'e' ) {
	$font_family = 'DesignsvillaWPTokens';
}  else {
	$font_family = 'FontAwesome';
}

global $pacz_accent_color, $pacz_settings;

$icon_color = ($icon_color == $pacz_settings['accent-color']) ? $pacz_accent_color : $icon_color;

$output .= '<div id="list-style-'.$id.'" class="pacz-list-styles '.$animation_css.$el_class.'" style="margin-bottom:'.$margin_bottom.'px">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';


// Get global JSON contructor object for styles and create local variable
global $classiadspro_dynamic_styles;
$classiadspro_styles = '';

$classiadspro_styles .= '
#list-style-'.$id.' ul li:before {
    font-family:"'.$font_family.'";
    content: "\\'.$style.'";
    color:'.$icon_color.'
}';

echo '<div>'.$output.'</div>';


// Hidden styles node for head injection after page load through ajax
echo '<div id="ajax-'.$id.'" class="pacz-dynamic-styles">';
echo '<!-- ' . pacz_clean_dynamic_styles($classiadspro_styles) . '-->';
echo '</div>';

// Export styles to json for faster page load
$classiadspro_dynamic_styles[] = array(
  'id' => 'ajax-'.$id ,
  'inject' => $classiadspro_styles
);