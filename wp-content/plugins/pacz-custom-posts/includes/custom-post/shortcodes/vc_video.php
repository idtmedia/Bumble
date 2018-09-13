<?php

$title = $link = $size = $el_position = $width = $el_class = '';
extract( shortcode_atts( array(
			'title' => '',
			'link' => '',
			'el_class' => '',
			'animation' => '',
		), $atts ) );
$output = $animation_css ='';

if (empty ($link)) { return null; }


$animation_css = ($animation != '') ? (' pacz-animate-element ' . $animation . ' ') : '';
global $wp_embed;
$embed = '[embed]<iframe src="'.$link.'"></iframe>[/embed]';

$output .= "\n\t".'<div class="pacz-video-player '.$animation_css.$el_class.'">';
if ( !empty( $title ) ) {
	$output .= '<div class="pacz-video-title">'.$title.'</div>';
}
$output .= '<div class="video-container">' . $embed . '</div>';
$output .= "\n\t".'</div>';
echo '<div>'.$output.'</div>';
