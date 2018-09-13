<?php

extract(shortcode_atts(array(
	'title' => false,
	'style' => 'simple',
	'icon' => '',
	'icon_color' => '',
	'pane_bg' => '',
	"el_class" => '',
), $atts));

$id = uniqid();
$output = '';

if (!empty($icon)) {
	$icon = (strpos($icon, 'pacz-') !== FALSE) ? ($icon) : ('pacz-' . $icon);
} else {
	$icon = '';
}

$output .= '<div id="pacz-toggle-' . $id . '" class="pacz-toggle pacz-shortcode ' . $style . '-style ' . $el_class . '">';
$output .= '<div class="pacz-toggle-title"><i style="color:' . $icon_color . '" class="' . $icon . '"></i>' . $title . '</div>';
$output .= '<div class="pacz-toggle-pane"><div style="background-color:' . $pane_bg . '" class="inner-box">' . wpb_js_remove_wpautop(do_shortcode(trim($content))) . '</div></div></div>';
echo '<div>'.$output.'</div>';
