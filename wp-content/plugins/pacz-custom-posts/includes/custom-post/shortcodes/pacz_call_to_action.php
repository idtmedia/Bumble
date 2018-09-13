<?php

$el_class = $width = $el_position = '';

extract( shortcode_atts( array(
			'el_class' => '',
			'box_border_width' => '',
			'image_width' => '370',
			'image_height' => '690',
			'box_offset' => '180',
			'image_offset' => '-60',
			'text' => '',
			'text2' => '',
			'text3' => '',
			'small_text1' => '',
			'small_text2' => '',
			'small_text3' => '',
			'action_btn' => 'true',
			'btn1_text' => 'Read More',
			'btn2_text' => 'Purchase',
			'btn1_url' => '',
			'btn2_url' => '',
			'target' => '',
			'btn_width' => '190',
			'btn_height' => '56',
			'btn_font_size' => '14',
			'btn_radius' => '3',
			'btn_gutter' => '15',
			'btn_shadow' => '',
			'btn1_bg' => '',
			'btn2_bg' => '',
			'btn1_color' => '',
			'btn2_color' => '',
			'btn1_bg_hover' => '',
			'btn2_bg_hover' => '',
			'btn1_color_hover' => '',
			'btn2_color_hover' => '',
			'style' => '1',
			'layout_style' => 'aside1',
			'bg_color' => '',
			'border_color' => '',
			'text_size' => '',
			'small_text_size' => '',
			'font_weight' => 'bold',
			'text_transform' => 'uppercase',
			'btn_text_transform' => 'uppercase',
			'text_color' => '',
			'text_color2' => '',
			'small_text_color' => '',
			'small_text_color2' => '',
			'image' => '',
		), $atts ) );

$custom_box_css = $output = $custom_box_title_css = $default_border = '';

global $pacz_accent_color, $pacz_settings, $classiadspro_dynamic_styles;

$id = uniqid();
$classiadspro_styles = '';
	

$text_color = ($text_color == $pacz_settings['accent-color']) ? $pacz_accent_color : $text_color;
$bg_color = ($bg_color == $pacz_settings['accent-color']) ? $pacz_accent_color : $bg_color;
//$border_color = ($border_color == $pacz_settings['accent-color']) ? $pacz_accent_color : $border_color;
$border_new_color = pacz_convert_rgba($border_color, 0.1);
if($style == 'custom'){
		
		$classiadspro_styles .= '
		.callout-desc-holder h5 span{color:'.$pacz_settings['accent-color'].';}
';
	}

if($target == 'same'){
	$target = '';
}else if($target == 'new'){
	$target = '_blank';
}	
$image_offset_responsive = $image_offset / 2;
$classiadspro_styles .= '
	#pacz-cta-'.$id.' .pacz-cta-btn-holder{margin:0 -'.$btn_gutter.'px;}
	#pacz-cta-'.$id.' .cta-btn-wrap{padding:0 '.$btn_gutter.'px;margin-top:19px;}
	#pacz-cta-'.$id.' .pacz-cta-large{width:'.$btn_width.'px;height:'.$btn_height.'px;line-height:'.$btn_height.'px;font-size:'.$btn_font_size.'px;text-transform:'.$btn_text_transform.';box-shadow:'.$btn_shadow.';border-radius:'.$btn_radius.'px;}
	#pacz-cta-'.$id.' #pacz-cta-btn-'.$id.' .pacz-cta-btn1{background-color:'.$btn1_bg.'; color:'.$btn1_color.';}
	#pacz-cta-'.$id.' #pacz-cta-btn-'.$id.' .pacz-cta-btn1:hover{background-color:'.$btn1_bg_hover.'; color:'.$btn1_color_hover.';}
	#pacz-cta-'.$id.' #pacz-cta-btn-2'.$id.' .pacz-cta-btn2{background-color:'.$btn2_bg.'; color:'.$btn2_color.';}
	#pacz-cta-'.$id.' #pacz-cta-btn-2'.$id.' .pacz-cta-btn2:hover{background-color:'.$btn2_bg_hover.'; color:'.$btn2_color_hover.';}
	#pacz-cta-'.$id.'.pacz-call-to-action{hoverflow:visible;padding-bottom:10px;}
	#pacz-cta-'.$id.' .call-to-action-img{position:absolute;top:'.$image_offset.'px;}
	#pacz-cta-'.$id.'.pacz-call-to-action .pacz-inner-grid{height:inherit;}
	#pacz-cta-'.$id.' .call-to-action-content{height:inherit;}
	#pacz-cta-'.$id.' .call-to-action-content-inner{position:absolute;top:50%;transform:translateY(-50%);}
	#pacz-cta-'.$id.' .callout-small-text{font-size:'.$small_text_size.'px;}
	
	@media handheld, only screen and (max-width:480px){
		#pacz-cta-'.$id.' .call-to-action-content-inner{position:relative;top:0;transform:translateY(0);}
		#pacz-cta-'.$id.' .call-to-action-img{position:relative;top:0;margin-top:'.$image_offset_responsive.';}
		#pacz-cta-'.$id.' .call-to-action-content-inner h3 {font-size: 18px !important;}
		#pacz-cta-'.$id.' .call-to-action-content-inner p {font-size: 10px;line-height: 20px;}
		#pacz-cta-'.$id.' .pacz-cta-btn-holder{margin:0 -'.$btn_gutter.'px 30px;}
		#pacz-cta-'.$id.' .pacz-cta-large{width:115px;height:40px;line-height:40px;font-size:11px;}
	}
	@media handheld, only screen and (min-width:768) and (max-width:980px){
		#pacz-cta-'.$id.' .call-to-action-img{position:absolute;top:50%;margin-top:0;}
	}
';
if($layout_style == 'centered'){
	
$classiadspro_styles .= '
	#pacz-cta-'.$id.' .call-to-action-content-inner{position:relative;top:auto;transform:none;text-align:center;}
	#pacz-cta-'.$id.' .callout-desc{display:inline-block;}
	#pacz-cta-'.$id.' .callout-title span{color:'.$text_color2.';}
	#pacz-cta-'.$id.' .callout-small-text{color:'.$small_text_color.';}
	#pacz-cta-'.$id.' .callout-small-text span{color:'.$small_text_color2.';}
';
}
if($box_border_width > 0){
	
$classiadspro_styles .= '
	#pacz-cta-'.$id.'.pacz-call-to-action{padding:30px 30px 40px;}
';
}
if($layout_style == 'aside1'){
	
$classiadspro_styles .= '
	#pacz-cta-'.$id.'.pacz-call-to-action {height:calc('.$image_height.'px - '.$box_offset.'px);overflow:visible !important;}
	@media handheld, only screen and (max-width:480px){
		#pacz-cta-'.$id.'.pacz-call-to-action {height:100%;}
	}
';
}

if($style == '1') {
	$custom_box_css = ' style="background-color:'.$bg_color.';border:'.$box_border_width.'px solid '.$border_new_color.';"';
	$custom_box_title_css = ' style="font-size:'.$text_size.'px;font-weight:'.$font_weight.';text-transform:'.$text_transform.';color:'.$text_color.';"';
	
}

if($layout_style == 'aside1'){
	$output .= '<div'.$custom_box_css.$default_border.' id="pacz-cta-'.$id.'" class="pacz-call-to-action '.$el_class.'"><div class="pacz-inner-grid clearfix">';
	$output .= '<div class="col-md-4 col-sm-4 col-xs-12">';
	$output .= '<img class="call-to-action-img" src="'.$image.'" alt="call to action">';
	$output .= '</div>';
	$output .= '<div class="col-md-8 col-sm-8 col-xs-12 call-to-action-content">';
	$output .= '<div class="call-to-action-content-inner">';
	$output .= '<div class="callout-desc"><div class="callout-desc-holder">';
	$output .= '<h3'.$custom_box_title_css.' class="callout-title">'.$text.'</h3>';
	$output .= '<p class="callout-small-text">'.$small_text1.'</p>';
	$output .='</div></div>';
	if($action_btn == true){
		$output .= '<div class="pacz-cta-btn-holder">';
		if ( $btn1_text ) {
			$output .= '<div id="pacz-cta-btn-'.$id.'" class="cta-btn-wrap"><a class="pacz-cta-large pacz-cta-btn1 pacz-new-btn-4" href="'.$btn1_url.'" target="'.$target.'">'.$btn1_text.'</a></div>';
		}
		if ( $btn2_text ) {
			$output .= '<div id="pacz-cta-btn-2'.$id.'" class="cta-btn-wrap"><a class="pacz-cta-large pacz-cta-btn2 pacz-new-btn-4" href="'.$btn2_url.'" target="'.$target.'">'.$btn2_text.'</a></div>';
		}
		$output .= '</div>';
	}
	$output .= '</div></div><div class="clearboth"></div></div></div>';
}else if ($layout_style == 'centered'){
	$output .= '<div'.$custom_box_css.$default_border.' id="pacz-cta-'.$id.'" class="pacz-call-to-action '.$el_class.'"><div class="pacz-inner-grid clearfix">';
	$output .= '<div class="call-to-action-content">';
	$output .= '<div class="call-to-action-content-inner">';
	$output .= '<div class="callout-desc"><div class="callout-desc-holder">';
	$output .= '<h3'.$custom_box_title_css.' class="callout-title">'.$text.'<span>'.$text2.'</span>'.$text3.'</h3>';
	$output .= '<p class="callout-small-text">'.$small_text1.'<span>'.$small_text2.'</span>'.$small_text3.'</p>';
	$output .='</div></div>';
	if($action_btn == true){
		$output .= '<div class="pacz-cta-btn-holder">';
		if ( $btn1_text ) {
			$output .= '<div id="pacz-cta-btn-'.$id.'" class="cta-btn-wrap"><a class="pacz-cta-large pacz-cta-btn1 pacz-new-btn-4" href="'.$btn1_url.'" target="'.$target.'">'.$btn1_text.'</a></div>';
		}
		if ( $btn2_text ) {
			$output .= '<div id="pacz-cta-btn-2'.$id.'" class="cta-btn-wrap"><a class="pacz-cta-large pacz-cta-btn2 pacz-new-btn-4" href="'.$btn2_url.'" target="'.$target.'">'.$btn2_text.'</a></div>';
		}
		$output .= '</div>';
	}
	$output .= '</div></div><div class="clearboth"></div></div></div>';
}else{
	
}

echo '<div class="call-to-action-wrap">'.$output.'</div>';

// Hidden styles node for head injection after page load through ajax
echo '<div id="ajax-'.$id.'" class="pacz-dynamic-styles">';
echo '<!-- ' . pacz_clean_dynamic_styles($classiadspro_styles) . '-->';
echo '</div>';


// Export styles to json for faster page load
$classiadspro_dynamic_styles[] = array(
  'id' => 'ajax-'.$id ,
  'inject' => $classiadspro_styles
);
