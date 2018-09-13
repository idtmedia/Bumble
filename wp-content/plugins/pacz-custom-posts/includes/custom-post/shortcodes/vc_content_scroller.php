<?php

extract( shortcode_atts( array(
			"images" => '',
			"animation_speed" => 700,
			"slideshow_speed" => 7000,
			"direction_nav" => "true",
			'bg_color' => '',
			'attachment' => 'scroll',
			'bg_position' => 'left top',
			'border_color' => '',
			'direction' => 'horizontal',
			'bg_image' => '',
			'bg_stretch' => '',
			"el_class" => '',
		), $atts ) );

$id = uniqid();
$style_output = $bg_stretch_class = '';



$style_output .= !empty( $bg_image ) ? 'background-image:url('.$bg_image.'); ' : '';
$style_output .= !empty( $bg_color ) ? 'background-color:'.$bg_color.';' : '';
$style_output .= !empty( $attachment ) ? 'background-attachment:'.$attachment.';' : '';
$style_output .= !empty( $bg_position ) ? 'background-position:'.$bg_position.';' : '';
$style_output .= !empty( $border_color ) ? 'border:1px solid '.$border_color.';border-left:none;border-right:none;' : '';

if ( $bg_stretch == 'true' ) {
	$bg_stretch_class = 'pacz-background-stretch ';
}

$output .= '<div id="content_scroller_'.$id.'" class="pacz-content-scroller '.$bg_stretch_class.$el_class.'" style="'. $style_output.'"><div class="pacz-swiper-container pacz-swiper-slider" data-freeModeFluid="true" data-loop="false" data-slidesPerView="1" data-pagination="false" data-freeMode="false" data-direction="'.$direction.'" data-slideshowSpeed="'.$slideshow_speed.'" data-animationSpeed="'.$animation_speed.'" data-directionNav="'.$direction_nav.'">';
$output .= '<div class="pacz-swiper-wrapper">';

$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';

if ( $direction_nav == 'true' ) {
	$output .= '<a class="pacz-swiper-prev swiper-arrows"><i class="pacz-nuance-icon-prev-big"></i></a>';
	$output .= '<a class="pacz-swiper-next swiper-arrows"><i class="pacz-nuance-icon-next-big"></i></a>';
}
$output .= '</div></div><div class="clearboth"></div>';

echo '<div>'.$output.'</div>';
