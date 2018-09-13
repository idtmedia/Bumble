<?php

$el_class = $width = $el_position = '';

extract( shortcode_atts( array(
			'el_class' => '',
			'border_color' => '',
			'bg_color' => '',
			'bg_image' => '',
			'text_align' => 'left',
			'bg_position' => 'center center',
			'bg_repeat' => 'repeat',
			'bg_stretch' => '',
			'padding_left' => '20',
			'padding_right' => '20',
			'top' => '0',
			'bottom' => '0',
			'padding_top' => '20',
			'padding_bottom' => '20',
			'margin_bottom' => '20',
			'margin_top' => '0',
			'drop_shadow' => 'false',
			'position' => 'relative',
			'z_index' => '',
			'animation' => '',
			'visibility' => '',
			'alsp_masonry_grid' => "false",
		), $atts ) );

$output = $bg_stretch_class = $animation_css = $drop_shadow_css = '';
$id = uniqid();

if ( $bg_stretch == 'true' ) {
	$bg_stretch_class = 'pacz-background-stretch';
}
if($drop_shadow == 'true') {
	$drop_shadow_css = 'drop-outer-shadow';
}
if ( $animation != '' ) {
	$animation_css = 'pacz-animate-element ' . $animation . ' ';
}
if($alsp_masonry_grid != 'false'){
	$pacz_masonary_class = 'alsp-masonry-grid';
}else{
	$pacz_masonary_class = '';
}
$backgroud_image = !empty( $bg_image ) ? 'background-image:url('.$bg_image.'); ' : '';
$border = !empty( $border_color ) ? ( 'border:2px solid '.$border_color.';' ) : '';

$output .= '<div style="text-align:'.$text_align.'" id="pacz-custom-box-'.$id.'" class="pacz-grid pacz-custom-boxed pacz-shortcode '.$pacz_masonary_class.' '.$drop_shadow_css.' '.$bg_stretch_class.' '.$visibility.' '.$animation_css.$el_class.'">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '<div class="clearboth"></div></div>';


// Get global JSON contructor object for styles and create local variable
global $classiadspro_dynamic_styles;
$classiadspro_styles = '';

$classiadspro_styles .= '
#pacz-custom-box-'.$id.' {
	z-index:'.$z_index.';
	position:'.$position.';
    padding:'.$padding_top.'px '.$padding_right.'px '.$padding_bottom.'px '.$padding_left.'px;
	top:'.$top.'px;
	bottom'.$bottom.'px;
	margin-top:'.$margin_top.'px;
    margin-bottom:'.$margin_bottom.'px;
    '. $backgroud_image.'
    background-attachment:scroll;
    background-repeat:'.$bg_repeat.';
    background-color:'.$bg_color.';
    background-position:'.$bg_position.';
    '.$border.'
	
}
#pacz-custom-box-'.$id.' .pacz-divider .divider-inner i{
    background-color: '.$bg_color.' !important;
}';
if ( $position == 'absolute' ) {
	$classiadspro_styles .= '
	
	
	';
}

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
