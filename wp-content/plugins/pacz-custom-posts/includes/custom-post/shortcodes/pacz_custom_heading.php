<?php

extract( shortcode_atts( array(
			'el_class' => '',
			'style' => '1',
			'custom_heading_text1' => '',
			'custom_heading_text2' => '',
			'custom_heading_text3' => '',
			'custom_heading_color' => '',
			'custom_text_color' => '',
			'custom_text_below_title' => '',
		), $atts ) );

$id = uniqid();





global $pacz_accent_color, $pacz_settings;
$classiadspro_styles = '';

if ($custom_heading_text2) {
	$classiadspro_styles .= '
		.custom-color-heading{
			color:'.$pacz_accent_color.';
		}
	';
}

$output .= '<div class="pacz-custom-heading"><h4 style="color:'.$custom_heading_color.'">' . $custom_heading_text1. ' <span class="custom-color-heading">' . $custom_heading_text2. ' </span> ' . $custom_heading_text3. '</h4></div>';
if($style == 1){
	$output .= '<div class="title-divider"><span></span><span></span><span></span></div>';
}else if($style == 2){
	
}else if($style == 3){
	$output .= '<div class="title-divider"><span></span></div>';
}else if($style == 4){
	$output .= '<div class="title-divider"><span></span><span></span></div>';
}
$output .= '<div class="custom-text-below-title"><p style="color:'.$custom_text_color.'">'.$custom_text_below_title.'</p></div>';
echo '<div id="custom-heading-'.$id.'" class="pacz-custom-heading-wrap style-'.$style.'">'.$output.'</div>';


// Hidden styles node for head injection after page load through ajax
echo '<div id="ajax-'.$id.'" class="pacz-dynamic-styles">';
echo '<!-- ' . pacz_clean_dynamic_styles($classiadspro_styles) . '-->';
echo '</div>';


// Export styles to json for faster page load
$classiadspro_dynamic_styles[] = array(
  'id' => 'ajax-'.$id ,
  //'inject' => $classiadspro_styles
);
