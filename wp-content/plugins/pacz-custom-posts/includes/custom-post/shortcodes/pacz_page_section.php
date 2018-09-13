<?php
$output  = $backgroud_image_alter = $color_mask_css = $parallax_scroll = $video_output = $page_intro_class = '';
extract( shortcode_atts( array(
			'el_class' => '',
			'layout_structure' => 'full',
			'bg_color' => '',
			'border_color' => '',
			'bg_image' => '',
			'bg_repeat' => 'repeat',
			'section_id' => '',
			'bg_stretch' => '',
			'attachment' => '',
			'bg_position' => 'left top',
			'parallax' => 'false',
			'padding_top' => '20',
			'padding_bottom' => '20',
			'mask_opacity' => '',
			'full_height' => 'false',
    		'intro_effect' => 'false',
			'bg_video' => 'no',
			'mp4' => '',
			'webm' => '',
			'ogv' => '',
			'poster_image' => '',
			'mask' => 'false',
			'parallax_direction' => 'false',
			'full_width' => 'false',
			'color_mask' => '',
			'visibility' => '',
			'expandable' => 'false',
			'expandable_txt' => '',
			'expandable_txt_align' => 'center',
			'expandable_txt_color' => '#ccc',
			'expandable_txt_size'=> 16,
			'expandable_icon' => 'pacz-theme-icon-plus',
			'expandable_icon_size' => 16,
			'expandable_image' => ''
		), $atts ) );

global $post;


$id = uniqid();

wp_enqueue_script( 'wpb_composer_front_js' );


$bg_stretch_class = ( $bg_stretch == 'true' ) ? 'pacz-background-stretch ' : '';

$backgroud_image = !empty( $bg_image ) ? 'background-image:url('.$bg_image.'); ' : '';

if($expandable != 'true'){
	if($layout_structure == 'full') {

		if ($parallax_direction == 'both_axis_mouse' ) {
			$backgroud_image_alter = '<div class="pacz-mouse-parallax parallax-both-axis parallax-layer" style="'.$backgroud_image.'"></div>';
			$backgroud_image = '';

		} else if($parallax_direction == 'vertical_mouse'){
			$backgroud_image_alter = '<div class="pacz-mouse-parallax parallax-y-axis parallax-layer" style="'.$backgroud_image.'"></div>';
			$backgroud_image = '';

		} else if($parallax_direction == 'horizontal_mouse') {
			$backgroud_image_alter = '<div class="pacz-mouse-parallax parallax-x-axis parallax-layer" style="'.$backgroud_image.'"></div>';
			$backgroud_image = '';

		} else if($parallax_direction == 'vertical') {
			
			$parallax_scroll = ($parallax == 'true') ? ' data-center="background-position: 50% 0px;" data-bottom-top="background-position: 50% 200px;" data-top-bottom="background-position: 50% -200px;"' : '';	

		} else if($parallax_direction == 'horizontal') {

			$parallax_scroll = ($parallax == 'true') ? 'data-bottom-top="background-position: 0px 50%" data-top-bottom="background-position: 3000px 50%;"' : '';	
		}
	} else {
			$backgroud_image = '';
	}
}

$padding_top = ( $full_height == 'true' && $expandable == 'false') ? 0 : $padding_top;
$padding_bottom = ( $full_height == 'true' && $expandable == 'false') ? 0 : $padding_bottom;
$full_height = ($expandable == 'false') ? $full_height : 'false';

$page_section_id = !empty( $section_id ) ? ( ' id="'.$section_id.'"' ) : '';

$border_css = ( empty( $bg_image ) && !empty( $border_color ) ) ? 'border:1px solid '.$border_color.';border-left:none;border-right:none;' : '';
echo  '<div class="clearboth"></div></div></div></div>';

/* Fixes page section for blog single page */
if(is_singular('post')) {
	echo  '</div>';
}



if($intro_effect != 'false' && $intro_effect != '') {
    $page_intro_class = 'intro-true ';    
    wp_dequeue_script('SmoothScroll');
    $parallax = 'false';
}


echo  '<div'.$page_section_id.'  data-intro-effect="' . $intro_effect . '" class="page-section-'.$id.' ' . $page_intro_class . ' fullwidth-'.$full_width.' section-expandable-'.$expandable.' full-height-'.$full_height.' '.$bg_stretch_class.' pacz-video-holder pacz-page-section parallax-'.$parallax.' '.$visibility.' '.$el_class.'" data-direction="'.$parallax_direction.'">';

echo  wp_kses_post($backgroud_image_alter);


if ( $mask == 'true' && $layout_structure == 'full') {
	echo  '<div class="pacz-section-mask"></div>';
}
if ( !empty( $color_mask ) ) {
	$color_mask_css = ' style="background-color:'.$color_mask.';opacity:'.$mask_opacity.';"';
}
echo  '<div'.$color_mask_css.' class="pacz-section-color-mask"></div>';


/**
 * Video Background
 */
if ( $bg_video == 'yes') {

	if(!empty($poster_image)) {
			$video_output .= '<div style="background-image:url('.$poster_image.');" class="pacz-video-section-touch"></div>';	
	}

	$video_output .= '<div class="pacz-section-video"><video poster="'.$poster_image.'" muted="muted" preload="auto" loop="true" autoplay="true">';

	if ( !empty( $mp4 ) ) {
		$video_output .= '<source type="video/mp4" src="'.$mp4.'" />';
	}
	if ( !empty( $webm ) ) {
		$video_output .= '<source type="video/webm" src="'.$webm.'" />';
	}
	if ( !empty( $ogv ) ) {
		$video_output .= '<source type="video/ogg" src="'.$ogv.'" />';
	}

	$video_output .= '</video></div>';
}

if($layout_structure == 'full') {
	echo  $video_output;
}
/***************************/

echo  ($full_height == 'true' && $expandable == 'false') ? '<div class="pacz-page-section-loader sharp-slider-loading"><div class="pacz-preloader"><div class="pacz-loader"></div></div></div>' : '';


if($expandable == 'true') {
	echo  '<div class="expandable-section-trigger"><div class="pacz-expandable-wrapper"><div class="vc_col-sm-12  wpb_column column_container ">';
	
	echo  (!empty($expandable_txt)) ? '<div class="pacz-grid"><span class="align-'.$expandable_txt_align.'" style="color:'.$expandable_txt_color.';font-size:'.$expandable_txt_size.'px">'.$expandable_txt.'</span></div>' : '';
	if(empty($expandable_image)) {
		echo  '<i style="color:'.$expandable_txt_color.';font-size:'.$expandable_icon_size.'px;margin-top:-'.($expandable_icon_size/2).'px;margin-left:-'.($expandable_icon_size/2).'px" class="'.$expandable_icon.'"></i>';	
	} else {
		echo  '<img class="expandable-section-image" src="'.$expandable_image.'">';	
	}
	

	echo  '</div></div></div>';
} 



/* Content container */
if($layout_structure == 'full') {
	if ( $full_width == 'true' ) {
		echo  '<div class="page-section-fullwidth vc_row-fluid page-section-content"><div class="pacz-padding-wrapper">'.wpb_js_remove_wpautop( $content ).'</div><div class="clearboth"></div></div>';
	} else {
		echo  '<div class="pacz-grid vc_row-fluid page-section-content"><div class="pacz-padding-wrapper">'.wpb_js_remove_wpautop( $content ).'</div><div class="clearboth"></div></div>';
	}
} else {
	echo  '<div class="pacz-half-layout '.$layout_structure.'_layout" style="background-image:url('.$bg_image.');">';
	echo  '<div>'.$video_output.'</div>';
	echo  '</div>';

	echo  '<div class="pacz-half-layout-container page-section-content '.$layout_structure.'_layout">'.wpb_js_remove_wpautop( $content ).'</div><div class="clearboth"></div>';
}
echo  '<div class="clearboth"></div></div>';






/*
*specific page section custom styles.
*/

// Get global JSON contructor object for styles and create local variable
global $classiadspro_dynamic_styles;
$classiadspro_styles = '';

$classiadspro_styles .= '
.page-section-'.$id.'
{
    padding:'.$padding_top.'px 0 '.$padding_bottom.'px;
    '. $backgroud_image.'
    background-attachment:'.$attachment.';
    '.( $bg_color ? ( 'background-color:'.$bg_color.';' ) : '' ).'
    background-position:'.$bg_position.';
    background-repeat:'.$bg_repeat.';
    '.$border_css.'
}
.page-section-'.$id.' .alt-title span
{
	'.( $bg_color ? ( 'background-color:'.$bg_color.';' ) : '' ).'
}
.page-section-'.$id. '.section-expandable-true:not(.active-toggle):hover .pacz-section-color-mask {
		opacity:'.($mask_opacity + 0.2).' !important;
}
';
if(!$expandable_txt == 'true'){
	$classiadspro_styles .= '.page-section-'.$id. ' .expandable-section-trigger i 
	{
		'.( empty($expandable_txt) ? ( 'opacity:1;' ) : '' ).'
		top:0 !important;
	}
	
	';
}
/**************************/


$layout = get_post_meta( $post->ID, '_layout', true );
echo  '<div class="pacz-main-wrapper-holder"><div class="theme-page-wrapper '.$layout.'-layout pacz-grid vc_row-fluid no-padding">';
if($layout == 'left' || $layout == 'right'){
	
	echo  '<div class="theme-content-wrap">';
}
echo  '<div class="theme-content no-padding">';


/* Fixes page section for blog single post */
if(is_singular('post')) {
	echo '<div class="single-content">';
}




// Hidden styles node for head injection after page load through ajax
echo '<div id="ajax-'.$id.'" class="pacz-dynamic-styles">';
echo '<!-- ' . pacz_clean_dynamic_styles($classiadspro_styles) . '-->';
echo '</div>';


// Export styles to json for faster page load
$classiadspro_dynamic_styles[] = array(
  'id' => 'ajax-'.$id ,
  'inject' => $classiadspro_styles
);
