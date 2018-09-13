<?php
/*
extract(shortcode_atts(array(
	'media_type' => 'image',
	'autoplay' => '',
	'video_host' => '',
	'video_host_social' => '',
	'social_youtube_id' => '',
	'social_vimeo_id' => '',
	'mp4' => '',
	'webm' => '',
	'ogv' => '',
	'preview_image' => '',
	'media_width' => 500,
	'media_height' => 350,
	'title' => '',
	'text_color' => '',
	'rounded_corner' => 'false',
	'bg_color' => '',
	'border_color' => '',
	'crop' => 'true',
	'image_link' => 'lightbox',
	'src' => '',
	'animation' => '',
	'align' => 'left',
	'url' => '',
	'target' => '_self',
	'el_class' => '',
	'visibility' => '',
	'title_color' => '',
	'title_text_transform' => '',
	'title_font_weight' => '',
), $atts));

require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";	

$output = $videoContent = $stream_source = '';

$id = uniqid();

$animation_css = ($animation != '') ? (' pacz-animate-element ' . $animation . ' ') : '';

if ($media_type == 'video') {
	if($video_host == 'self_hosted'){
		$videoContent .= '<div class="pacz-imagebox-video pacz-video-wrapper video-self-hosted"><div class="pacz-video-container"><video poster="" muted="muted" preload="auto" loop="true" >';

		if (!empty($mp4)) {
			//MP4 must be first for iPad!
			$videoContent .= '<source type="video/mp4" src="' . $mp4 . '" />';
		}
		if (!empty($webm)) {
			$videoContent .= '<source type="video/webm" src="' . $webm . '" />';
		}	
		if (!empty($ogv)) {
			$videoContent .= '<source type="video/ogg" src="' . $ogv . '" />';
		}

		$videoContent .= '</video></div></div>';

		$videoContent .= '<div class="pacz-imagebox-item-image pacz-imagebox-video-preview"><img src="' . $preview_image . '" alt="" /></div>';

		$stream_source = 'self_hosted';
	}else{
		$videoContent .= '<div class="pacz-imagebox-video pacz-video-wrapper video-social-hosted"><div class="pacz-video-container">';
		if ($video_host_social == 'social_hosted_youtube'){
			$stream_source = 'youtube';
			$videoContent .= '<iframe id="player" src="https://www.youtube.com/embed/'.$social_youtube_id.'?rel=0&amp;enablejsapi=1" frameborder="0"  allowfullscreen></iframe>';
		} else if ($video_host_social == 'social_hosted_vimeo'){
			$stream_source = 'vimeo';
			$videoContent .= '<iframe id="player" src="//player.vimeo.com/video/'.$social_vimeo_id.'?api=1&amp;title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;loop=1;" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		}
		$videoContent .= '</div></div>';
	}
} else {

	$image_id = pacz_get_attachment_id_from_url($src);
	$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	$image_title = get_the_title($image_id);
	$image_src_array = wp_get_attachment_image_src($image_id, 'full', true);
}

$txt_color = ($text_color != '') ? ('color:' . $text_color . ';') : '';
$bg_color = ($bg_color != '') ? ('background-color:' . $bg_color . ';') : '';
$border_color = ($border_color != '') ? ('border:2px solid ' . $border_color . ';') : '';
$video_autoplay = ($autoplay != '' && $autoplay == 'false') ? 'false' : 'true';
$stream_source_tag = ($stream_source == '') ? '' : 'data-source="'.$stream_source.'"';



$output .= '<div id="image-box-' . $id . '" class="pacz-image-box autoplay-'.$video_autoplay.' rounded-'.$rounded_corner.' align-' . $align . ' ' . $visibility . ' ' . $animation_css . $el_class . '" style="max-width: ' . $media_width . 'px;' . $bg_color .$border_color. '" '.$stream_source_tag.'>';

$output .= '<div class="pacz-image-box-media" style="max-height:' . $media_height . 'px;">'; 
if ($media_type == 'video') {
	$output .= $videoContent;
} else {
	$output .= '<div class="featured-image" style="max-height:' . $media_height . 'px;" onClick="return true">';
	if ($image_link == 'lightbox') {
		$output .= '<div class="hover-overlay"></div>';
		$output .= '<div class="gallery-meta"><a class="pacz-lightbox" href="' . $image_src_array[0] . '" title="' . $image_title . '"><i class="pacz-theme-icon-plus"></i></a></div>';
	} else {
		$output .= '<div class="hover-overlay"></div>';
		$output .= '<div class="gallery-meta">';
		$output .= ($url != '') ? '<a class="" target="' . $target . '" href="' . $url . '" title="' . $image_title . '"><i class="pacz-theme-icon-next-big"></i></a>' : '';
		$output .= '</div>';
	}

	if ($crop == 'true') {
		$image_src = bfi_thumb($src, array(
			'width' => $media_width,
			'height' => $media_height,
			'crop' => true
		));
		$output .= '<img alt="' . $alt . '" title="' . $image_title . '" src="' . $image_src . '" />';
	} else {
		$output .= '<img alt="' . $alt . '" title="' . $image_title . '" src="' . $src . '" />';
	}
	
	$output .= '</div>';
}
$output .= '</div>';

$output .= '<div class="item-holder">';
$output .= '<div class="image-box-title" style="font-weight:'.$title_font_weight.'; color:'.$title_color.'; text-transform:'.$title_text_transform.';">' . $title . '</div>';
$output .= '<div class="image-box-desc">' . wpb_js_remove_wpautop($content, true) . '</div>';
$output .= '</div>';
$output .= '<div class="clearboth"></div></div>';


// Get global JSON contructor object for styles and create local variable
global $classiadspro_dynamic_styles;
$classiadspro_styles = '';
	
$classiadspro_styles .= '
#image-box-' . $id . ' .image-box-title,
#image-box-' . $id . ' .image-box-desc,
#image-box-' . $id . ' .image-box-desc p
{
    ' . $txt_color . '
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
*/