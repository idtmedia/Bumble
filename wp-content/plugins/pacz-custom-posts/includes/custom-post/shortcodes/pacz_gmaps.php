<?php


extract( shortcode_atts( array(
			'height' => '500',
			'full_height' => 'false',
			'parallax' => 'false',
			'latitude' => '31.5497',
			'longitude' => '74.3436',
			'address' => 'Lahore',

			'latitude_2' => '',
			'longitude_2' => '',
			'address_2' => '',

			'latitude_3' => '',
			'longitude_3' => '',
			'address_3' => '',

			'zoom' => '14',
			'pan_control' => 'true',
			'draggable' => 'true',
			'zoom_control' => 'true',
			'map_type_control' => 'true',
			'scale_control' => 'true',
			'pin_icon' => '',
			'modify_coloring' => 'true',
			'hue' => '##ff4400',
			'saturation' => '-68',
			'lightness' => '-4',
			'gamma' => '',
			'el_class' => '',
			
		), $atts ) );

$output = '';

if ( $longitude == '' && $latitude == '') { return null; }

if ( $zoom < 1 ) {
	$zoom = 1;
}

$id = uniqid();



if($parallax == 'true') {
	wp_enqueue_script( 'skrollr');
	$parallax_class = 'pacz-gmaps-parallax';
	$parallax_atts = 'data-top-center="margin-top:-200px" data-bottom-center="margin-top:0px"';
	$parallax_height = $height+200;
} else {
	$parallax_class = $parallax_atts = '';
	$parallax_height = $height;
}
global $pacz_settings;
$gmapapi = $pacz_settings['gmapapi'];
$output .= '<div class="'.$parallax_class.' pacz-gmaps-wrapper" style="height:'.$height.'px"><div id="google-map-'.$id.'" class="pacz-gmaps" '.$parallax_atts.' style="height:'.$parallax_height.'px;width:100%;" data-fullHeight="'.$full_height.'" data-zoom="'.$zoom.'" data-pin-icon="'.$pin_icon.'" data-latitude="'.$latitude.'" data-longitude="'.$longitude.'" data-address="'.$address.'" data-latitude2="'.$latitude_2.'" data-longitude2="'.$longitude_2.'" data-address2="'.$address_2.'" data-latitude3="'.$latitude_3.'" data-longitude3="'.$longitude_3.'" data-address3="'.$address_3.'" data-pan-control="'.$pan_control.'" data-zoom-control="'.$zoom_control.'" data-map-type-control="'.$map_type_control.'" data-scale-control="'.$scale_control.'" data-draggable="'.$draggable.'" data-modify-coloring="'.$modify_coloring.'" data-saturation="'.$saturation.'" data-lightness="'.$lightness.'" data-hue="'.$hue.'" data-gamma="'.$gamma.'"></div></div>';

$output .= '<script type="text/javascript" src="http://maps.google.com/maps/api/js?key='.$gmapapi.'"></script>';


echo $output;
