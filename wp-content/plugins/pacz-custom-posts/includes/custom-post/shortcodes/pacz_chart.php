<?php

extract( shortcode_atts( array(
			'desc' 			=> '',
			'desc_color' 	=> '',
			'percent' 		=> '',
			'bar_color' 	=> '',
			'track_color' 	=> '',
			'line_width' 	=> '',
			'bar_size' 		=> '',
			'content' 		=> '',
			'content_type' 	=> '',
			'icon' 			=> '',
			'icon_size' 	=> '32px',
			'font_size' 	=> '18',
			'disc_font_size' 	=> '18',
			'font_weight' 	=> 'default',
			'custom_text' 	=> '',
			'el_class' 		=> '',
			'animation' 	=> '',
		), $atts ) );

$output = $desc_color_style = '';

if(!empty( $icon )) {
    $icon = (strpos($icon, 'pacz-') !== FALSE) ? ( $icon ) : ( 'pacz-'.$icon );    
} else {
    $icon = '';
}

///////////////////////////////////////////////////////////
//
// Prepare conditional output
//
//////////////////////////////////////////////////////////
if(!empty($desc_color)){
	$desc_color_style .= 'color:'.$desc_color.'';
}

$animation_css = ($animation != '') ? (' pacz-animate-element ' . $animation . ' ') : '';
$output .= '<div class="'.$animation_css.'">';
$output .= '<div class="pacz-chart" style="width:'.$bar_size.'px;height:'.$bar_size.'px;line-height:'.$bar_size.'px" data-percent="'.$percent.'" data-barColor="'.$bar_color.'" data-trackColor="'.$track_color.'" data-lineWidth="'.$line_width.'" data-barSize="'.$bar_size.'">';
if ( $content_type == 'icon' ) {
	$output .= '<i style="line-height:'.$bar_size.'px;color:'.$bar_color.'; font-size: '.$icon_size.';" class="'.$icon.'"></i>';
} elseif ( $content_type == 'custom_text' ) {
	$output .= '<span class="chart-custom-text" style="font-size:'.$font_size.'px; color:'.$bar_color.'; font-weight:'.$font_weight.';">'.$custom_text.'</span>';
} else {
	$output .= '<div class="chart-percent" style="font-size:'.$font_size.'px; color:'.$bar_color.'; font-weight:'.$font_weight.';"><span>'.$percent.'</span>%</div>';
}
$output .= '</div>';
$output .= '<div class="pacz-chart-desc" style="font-size:'.$disc_font_size.'px; '.$desc_color_style.'">'.$desc.'</div>';
$output .= '</div>';
echo '<div>'.$output.'</div>';
