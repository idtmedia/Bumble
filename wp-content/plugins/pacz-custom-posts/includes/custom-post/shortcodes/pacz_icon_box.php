<?php

$el_class = '';
extract(shortcode_atts(array(
	'el_class' => '',
	'title' => '',
	'style' => 'style1',
	'p_line_height' => '26',
	'icon_align' => 'left',
	'icon_type' => 'icon',
	'icon' => '',
	'icon_image' => '',
	'icon_bg_color_hover' => '',
	'icon_image_hover' => '',
	'box_style8_border_width' => 1,
	'box_style8_border_radius' => '',
	'box_style8_box_shadow' =>0,
	'custom_icon' => '',
	'rounded' => 'true',
	'icon_frame' => 'true',
	'read_more_txt' => '',
	'read_more_url' => '',
	'icon_color' => '',
	'txt_color' => '',
	'title_color' => '',
	'btn_skin' => '',
	'btn_hover_skin' => '',
	'icon_size' => 'small',
	'animation' => '',
), $atts));

$output = '';

$id = uniqid();

if (!empty($icon)) {
	$icon = (strpos($icon, 'pacz-') !== FALSE) ? ($icon) : ('pacz-' . $icon);
} else {
	$icon = '';
}
// Get global JSON contructor object for styles and create local variable
global $classiadspro_dynamic_styles;
$classiadspro_styles = '';
    
$classiadspro_styles .= '
	#icon-box-' . $id . '.pacz-box-icon.style1-box .icon-box-container{background-color:#f9fbfe;width:150px;height:150px;border-radius:50%;position:relative;margin:0 auto 20px;border:15px solid #fff;box-shadow: 0 0 10px rgba(0,0,0,.1);}
	#icon-box-' . $id . '.pacz-box-icon.style1-box:hover .icon-box-container{background-color:'.$icon_bg_color_hover.';}
	#icon-box-' .$id  . ' .icon-box-container img.box-image{display: block;left: 0;margin: 0 auto; position: absolute;right: 0;top: 50%;transform: translateY(-50%);}
	#icon-box-'.$id.' .icon-box-container img.image-normal{display:block;}
	#icon-box-'.$id.' .icon-box-container img.image-hover{display:none;}
	#icon-box-'.$id.':hover .icon-box-container img.image-normal{display:none;}
	#icon-box-'.$id.':hover .icon-box-container img.image-hover{display:block;}
';

$animation_css = ($animation != '') ? (' pacz-animate-element ' . $animation . ' ') : '';

$output .= '<div id="icon-box-' . $id . '" class="pacz-box-icon size-' . $icon_size . ' type-' . $icon_type . ' icon-' . $icon_align . '-align icon-frame-' . $icon_frame . ' icon-round-' . $rounded . ' ' . $style . '-box ' . $el_class . $animation_css . '" onClick="return true">';

$output .= '<div class="icon-box-container'.($icon_type == 'image' ? '' : ' icon-type-holder').'">';

$icon_image1 = wp_get_attachment_image_src($icon_image, 'full');
$icon_image2 = wp_get_attachment_image_src($icon_image_hover, 'full');


//$output .= ($custom_icon == '') ? ('<i class="box-ico ' . $icon . '"></i>') : ('<i class="box-ico ' . $custom_icon . '"></i>');
$output .= ($icon_type == 'icon') ? ('<i class="box-ico ' . $icon . '"></i>') : ('<img class="box-image image-normal" src="' . $icon_image1[0] . '" alt="" /><img class="box-image image-hover" src="' . $icon_image2[0] . '" alt="" />');
$output .= '</div>';

$output .= '<div class="icon-box-content">';
$output .= '<h4 style="color:' . $title_color . '" class="icon-box-title">' . $title . '</h4>';

$output .= '<div style="color:' . $txt_color . '" class="icon-box-desc">' . wpb_js_remove_wpautop($content, true) . '</div>';
if (!empty($read_more_url) && !empty($read_more_txt)) {
	$button_align = ($style == 'style2') ? 'left' : 'center';
	$output .='<div class="pacz-button-btn"><a class="pacz-button btn-'.$id.' oulline_button small rounded" href="'.$read_more_url.'">'.$read_more_txt.'</a></div>';
}

$output .= '<div class="clearboth"></div></div>';
$output .= '</div>';

global $pacz_accent_color, $pacz_settings;
$icon_color = ($icon_color == $pacz_settings['accent-color']) ? $pacz_accent_color : $icon_color;
$icon_bg = $pacz_settings['accent-color'];


    
if ($style == 'style1' || $style == 'style2' || $style == 'style3' || $style == 'style5' || $style == 'style8' || $style == 'style9') {
	$classiadspro_styles .= '
#icon-box-' . $id . ' .box-ico{color:' . $icon_color . ';}
#icon-box-' . $id . ' .pacz-button-btn a{color:'.$btn_skin.';border:1px solid '.$btn_skin.';}
#icon-box-' . $id . ' .pacz-button-btn:hover a{color:#fff;border:1px solid '.$btn_hover_skin.'background-color:'.$btn_skin.' !important;};

';
}

if ($style == 'style1' && $icon_type == 'icon') {
	if ($icon_type == 'icon') {
		$classiadspro_styles .= '
#icon-box-' . $id . ':hover{
	
	-webkit-box-shadow: 0 0 6px 3px rgba(0,0,0,0.04);
	-moz-box-shadow: 0 0 6px 3px rgba(0,0,0,0.04);
	box-shadow: 0 0 6px 3px rgba(0,0,0,0.04);
}
    ';
	}
}

if ( $style == 'style5' && $icon_type == 'icon') {
		$classiadspro_styles .= '
#icon-box-' . $id . '.pacz-box-icon.style5-box .icon-box-container{background-color:#fff !important;}
#icon-box-' . $id . '.pacz-box-icon.style5-box:hover .icon-box-container.icon-type-holder{background-color:'.$icon_color.' !important;border-color:'.$icon_color.' !important;}
#icon-box-' . $id . '.pacz-box-icon.style5-box:hover .icon-box-container .box-ico{color:#fff;}
    ';
}
if ($style == 'style3' && $icon_type == 'icon') {
	if ($icon_type == 'icon') {
		$classiadspro_styles .= '
#icon-box-' . $id . ':hover .icon-box-container{background-color:' . $icon_color . '; border-color:' . $icon_color . ';}
#icon-box-' . $id . ':hover.style3-box{border-color:' . $icon_color . ';}
    ';
	}
}
if ( $style == 'style8' && $icon_type == 'icon') {
	if ($icon_type == 'icon') {
		$classiadspro_styles .= '
#icon-box-' . $id . '{}
#icon-box-' . $id . '{	border-width:'. $box_style8_border_width .'px;
						border-radius:'.$box_style8_border_radius.'px;
						box-shadow:0 0 4px 2px rgba(237,240,241,0.' .$box_style8_box_shadow.');
						}
#icon-box-' . $id . ':hover{border-color:' . $icon_color . ';}
#icon-box-' . $id . ':hover .icon-box-container{background-color:' . $icon_color . '; border-color:' . $icon_color . ';}
#icon-box-' . $id . ':hover .icon-box-container .box-ico{color:#fff;}
    ';
	}
}
if ($style == 'style4' || $style == 'style6') {
	if ($icon_type == 'icon') {
		$classiadspro_styles .= '
#icon-box-' . $id . ' .icon-box-container{ border-color:#eaeaea;}
#icon-box-' . $id . ' .icon-box-container .box-ico{color:' . $icon_color . ';}
#icon-box-' . $id . ':hover .icon-box-container{background-color:' . $icon_color . '; border-color:' . $icon_color . ';}
#icon-box-' . $id . ':hover .icon-box-container .box-ico{color:#fff;}
'; 
	}
}

if ($style == 'style7') {
	if ($icon_frame == 'true') {
		$color_darker = pacz_hex_darker($icon_color, 10);
		$classiadspro_styles .= "
        #icon-box-{$id} .icon-box-container{background-color:{$icon_color};}
        #icon-box-{$id} .box-ico {
        text-shadow: {$color_darker} 1px 1px, 
        {$color_darker} 2px 2px,
        {$color_darker} 3px 3px,
        {$color_darker} 4px 4px,
        {$color_darker} 5px 5px,
        {$color_darker} 6px 6px,
        {$color_darker} 7px 7px,
        {$color_darker} 8px 8px,
        {$color_darker} 9px 9px,
        {$color_darker} 10px 10px,
        {$color_darker} 11px 11px,
        {$color_darker} 12px 12px,
        {$color_darker} 13px 13px,
        {$color_darker} 14px 14px,
        {$color_darker} 15px 15px,
        {$color_darker} 16px 16px,
        {$color_darker} 17px 17px,
        {$color_darker} 18px 18px,
        {$color_darker} 19px 19px,
        {$color_darker} 20px 20px,
        {$color_darker} 21px 21px,
        {$color_darker} 22px 22px,
        {$color_darker} 23px 23px,
        {$color_darker} 24px 24px,
        {$color_darker} 25px 25px,
        {$color_darker} 26px 26px,
        {$color_darker} 27px 27px,
        {$color_darker} 28px 28px,
        {$color_darker} 29px 29px,
        {$color_darker} 30px 30px,
        {$color_darker} 31px 31px,
        {$color_darker} 32px 32px,
        {$color_darker} 33px 33px,
        {$color_darker} 34px 34px,
        {$color_darker} 35px 35px,
        {$color_darker} 36px 36px,
        {$color_darker} 37px 37px,
        {$color_darker} 38px 38px,
        {$color_darker} 39px 39px,
        {$color_darker} 40px 40px,
        {$color_darker} 41px 41px,
        {$color_darker} 42px 42px,
        {$color_darker} 43px 43px,
        {$color_darker} 44px 44px,
        {$color_darker} 45px 45px,
        {$color_darker} 46px 46px,
        {$color_darker} 47px 47px,
        {$color_darker} 48px 48px,
        {$color_darker} 49px 49px,
        {$color_darker} 50px 50px;
    }
";
}
}
if ($style == 'style7') {
	
	$classiadspro_styles .= "
		#icon-box-{$id}:hover.pacz-box-icon.style7-box.size-small.icon-frame-false.icon-left-align .icon-box-container{background-color:{$icon_color};border-color:{$icon_color};}
		#icon-box-{$id}:hover.pacz-box-icon.style7-box.size-small.icon-frame-false.icon-left-align .icon-box-container .box-ico {color:#fff;}
	";
}
if ($style == 'style9' && $icon_type == 'icon') {
	if ($icon_type == 'icon') {
		$classiadspro_styles .= '
#icon-box-' . $id . '{	-webkit-box-shadow: 0 0 6px 3px rgba(0,0,0,0.03);
				-moz-box-shadow: 0 0 6px 3px rgba(0,0,0,0.03);
				box-shadow: 0 0 6px 3px rgba(0,0,0,0.03);
				
	}
#icon-box-' . $id . ':hover{	-webkit-box-shadow: 0 0 10px 5px rgba(0,0,0,0.05);
				-moz-box-shadow: 0 0 6px 3px rgba(0,0,0,0.05);
				box-shadow: 0 0 6px 3px rgba(0,0,0,0.05);
				
	}
    ';
	}
}
	 else {
		$classiadspro_styles .= "#icon-box-{$id} .box-ico{color:{$icon_color}}";
	}

$classiadspro_styles .= '#icon-box-' . $id . ' .icon-box-desc, #icon-box-' . $id . ' .icon-box-desc p{line-height:' . $p_line_height . 'px;}';


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
