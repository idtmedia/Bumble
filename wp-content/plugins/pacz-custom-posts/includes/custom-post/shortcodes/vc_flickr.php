<?php

extract( shortcode_atts( array(
			'el_class' => '',
			'flickr_id' => '95572727@N00',
			'count' => '6',
			'column' => 'four'
		), $atts ) );
global $pacz_settings;

$api_key = $pacz_settings['flickr-api-key'];

$output = "\n\t".'<div class="pacz-flickr-feeds flickr-widget-wrapper '.$el_class.'">';
$output .= '<div data-count="'.$count.'" data-userid="'.$flickr_id.'" data-key="'.$api_key.'" class="pacz-flickr-feeds '.$column.'-column"><div class="clearboth"></div></div><div class="clearboth"></div>';
$output .= "\n\t".'</div>';

echo '<div>'.$output.'</div>';
