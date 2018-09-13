<?php

extract( shortcode_atts( array(
			"style" => 'classic',
			"mile_width" => '150',
			"mile_height" => '150',
			"mile_radius" => '500',
			"mile_shadow" => 'false',
			"mile_border_width" => '2',
			"mile_border_style" => 'solid',
			"mile_border_color" => '#ffffff',
			"mile_bg_color" => '',
			"icon" => '',
			"icon" => '',
			"color" => '#ffffff',
			"type" => 'text',
			'text_size' => 14,
			'icon_size' => 16,
			'number_size' => 36,
			'font_family' => '',
			"start" => 0,
			"stop" => 100,
			"speed" => 2000,
			"text" => '',
			'number_background' => '',
			'number_background_hover' => '',
			'text_icon_color' => '#ffffff',
			'text_suffix' => '',
			'border_bottom' => '#eee',
			'number_suffix_text_size' => '',
			'el_class' => '',
		), $atts ) );

$output = $output_icon = '';

switch ($icon_size) {
	case 16:
		$line_height = 32;
		break;
	case 32:
		$line_height = 64;
		break;	
	case 48:
		$line_height = 86;
		break;	
	case 64:
		$line_height = 106;
		break;			
	case 128:
		$line_height = 170;
		break;		
	default:
		$line_height = 32;
		break;
}
$id = uniqid();
global$classiadspro_dynamic_styles, $pacz_settings;
$classiadspro_styles = '';
	if($mile_shadow == 'true'){
		
		$classiadspro_styles .= '
.pacz-milestone{	-webkit-box-shadow: 0 0 6px 3px rgba(0,0,0,0.03);
				-moz-box-shadow: 0 0 6px 3px rgba(0,0,0,0.03);
				box-shadow: 0 0 6px 3px rgba(0,0,0,0.03);
				
	}
.pacz-milestone:hover{	-webkit-box-shadow: 0 0 10px 5px rgba(0,0,0,0.05);
				-moz-box-shadow: 0 0 6px 3px rgba(0,0,0,0.05);
				box-shadow: 0 0 6px 3px rgba(0,0,0,0.05);
				
	}
';
	}
if($style == 'classic' || $style == 'modern'){
		
		$classiadspro_styles .= '
.pacz-milestone{position:relative;}
.pacz-milestone .content{position:absolute;top:50%;left:0;right:0; transform: translateY(-50%);width:100%;}
';
	}
if(!empty($number_background)){
	$number_container_bg = $number_background;
}else{
	$number_container_bg = $pacz_settings['btn-hover'];
}
if(!empty($number_background_hover)){
	$number_container_bg_hover = $number_background_hover;
}else{
	$number_container_bg_hover = $pacz_settings['accent-color'];
}

if($style == 'modern'){
if(!empty($color)){
	$text_color = $color;
	$text_color_hover = $color;
}else{
	$text_color = $number_container_bg_hover;
	$text_color_hover = $number_container_bg;
}		
		$classiadspro_styles .= '

#milestone-'.$id.'.pacz-milestone .content .milestone-number{width:120px;height:120px;border-radius:50%;background-color:'.$number_container_bg.';color:'.$text_color.' !important;line-height:120px !important;}
#milestone-'.$id.'.pacz-milestone:hover .content .milestone-number{background-color:'.$number_container_bg_hover.';color:'.$text_color_hover.'!important;}
';
	}
if($style  == 'modern'){
	$mile_width = '100';
	$unit = '%';
}else{
	$mile_width = $mile_width;
	$unit ='px';
}
$text_icon_color = !empty($text_icon_color) ? ('color:'.$text_icon_color.';') : '';

if ( $type == 'icon' ) {
	if(!empty( $icon )) {
    $icon = (strpos($icon, 'pacz-') !== FALSE) ? ( $icon ) : ( 'pacz-'.$icon);
	} else {
	    $icon = '';
	}

	}
	if($type == 'icon'){
		$output_icon .= '<i style="font-size:'.$icon_size.'px;line-height:'.$line_height.'px;'.$text_icon_color.'" class="'.$icon.'"></i>';
	}else{
	$output_icon .= '<div style="font-size:'.$text_size.'px;'.$text_icon_color.'" class="milestone-text">'.$text.'</div>';
}

$output .= '<div id="milestone-'.$id.'" style="background-color:'.$mile_bg_color.'; width:'.$mile_width.''.$unit.';height:'.$mile_height.'px;border-radius:'.$mile_radius.'px;border-color:'.$mile_border_color.';border-width:'.$mile_border_width.'px;border-style:'.$mile_border_style.'" class="pacz-milestone '.$style.'-style '.$el_class.'" >';

$output .= '<div class="content">';
if($style == 'classic' || $style  == 'modern'){
	$output .= '<div style="color:'.$color.';font-family:'.$font_family.';font-size:'.$number_size.'px; line-height:'.$number_size.'px;" class="milestone-number content-'.$type.'" data-speed="'.$speed.'" data-stop="'.$stop.'">'.$start.'</div><div class="clearboth"></div>';
	$output .= $output_icon;
}else{
	$output .= $output_icon;
	$output .= '<div style="color:'.$color.';font-family:'.$font_family.';font-size:'.$number_size.'px;line-height:'.$number_size.'px; " class="milestone-number content-'.$type.'" data-speed="'.$speed.'" data-stop="'.$stop.'">'.$start.'</div><div class="clearboth"></div>';
	$output .= '<span style="font-size:'.$number_suffix_text_size.'px;'.$text_icon_color.'">'.$text_suffix.'</span>';

}

$output .= '</div></div>';

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
