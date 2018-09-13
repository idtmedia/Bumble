<?php

extract(shortcode_atts(array(
	'image_width' => 500,
	'image_height' => '400',
	'crop' => 'true',
	'hover_style' => 'style1',
	'margin_bottom' => 10,
	'src' => '',
	'animation' => '',
	'align' => 'left',
	'float' => 'none',
	'padding_left_right' => '',
	'custom_url' => '',
	'target' => '_self',
	'hover' => 'true',
	'custom_lightbox_url' => '',
	'group' => 'shortcode',
	'el_class' => '',
	'lightbox_ifarme' => 'false',
	'visibility' => '',
	'circular' => 'false',
), $atts));

$output = '';


require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";	

$animation_css = ($animation != '') ? (' pacz-animate-element ' . $animation . ' ') : '';

$image_id = pacz_get_attachment_id_from_url($src);
$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
$title = get_the_title($image_id);

$output .= '<div class="pacz-image circular-'.$circular.' align-' . $align . ' ' . $hover_style . '-image ' . $visibility . ' ' . $animation_css . $el_class . '" style="max-width: ' . $image_width . 'px; margin-bottom:' . $margin_bottom . 'px; float:'.$float.';padding-left:'.$padding_left_right.'px; padding-right:'.$padding_left_right.'px;" onClick="return true">';


if ($crop == 'true') {
	$image_src = bfi_thumb($src, array(
	'width' => $image_width,
	'height' => $image_height,
	'crop' => true
	));
	if ($custom_url != '' && $hover == 'false') {
		$output .= '<a target="' . $target . '" href="' . $custom_url . '" title="' . $title . '"><img alt="' . $alt . '" title="' . $title . '" src="' . pacz_thumbnail_image_gen($image_src, $image_width, $image_height) . '" /></a>';
	}else{
		$output .= '<img alt="' . $alt . '" title="' . $title . '" src="' . pacz_thumbnail_image_gen($image_src, $image_width, $image_height) . '" />';
	}
} else {
	if ($custom_url != '' && $hover == 'false') {
		$output .= '<a target="' . $target . '" href="' . $custom_url . '" title="' . $title . '"><img alt="' . $alt . '" title="' . $title . '" src="' . $src . '" /></a>';
	}else{
		$output .= '<img alt="' . $alt . '" title="' . $title . '" src="' . $src . '" />';
	}
}

if ($hover != 'false') {
	$output .= '<div class="hover-overlay"></div>';

	$output .= '<div class="pacz-image-hover">';
	if ($custom_url != '') {
	$output .= '<a target="' . $target . '" href="' . $custom_url . '" title="' . $title . '">';
	} else {
		$lightbox_src = !empty($custom_lightbox_url) ? $custom_lightbox_url : $src;
		$lightbox_ifarme = ($lightbox_ifarme == 'true') ? ' fancybox.iframe' : '';
		$output .= ($hover != 'false') ? '<a href="' . $lightbox_src . '" title="' . $title . '" rel="image-' . $group . '" class="pacz-lightbox' . $lightbox_ifarme . '">' : '';
	}
	$output .= '<i class="pacz-theme-icon-plus"></i>';

	if ($custom_url != '') {
		$output .= '</a>';
	} else {
		if ($hover != 'false') {
			$output .= '</a>';
		}
	}
	if (!empty($title)) {
		$output .= '<div class="pacz-image-caption">' . $title . '</div>';
	}
	$output .= '</div>';
}


$output .= '</div>';

echo $output;
