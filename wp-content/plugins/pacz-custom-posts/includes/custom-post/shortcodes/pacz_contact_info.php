<?php
$output = '';
extract( shortcode_atts( array(
			'skin' => 'dark',
			'text_icon_color' => '',
			'border_color' => '',
			'name' => '',
			'cellphone' => '',
			'phone' => '',
			'address' => '',
			'website' => '',
			'email' => '',
			'animation' => '',
			'el_class' => '',
		), $atts ) );


$style_id = uniqid();
$animation_css = ($animation != '') ? (' class="pacz-animate-element ' . $animation . '" ') : '';

if ( $skin == 'custom' ) {

	// Get global JSON contructor object for styles and create local variable
	global $classiadspro_dynamic_styles;
	$classiadspro_styles = '';

	    $classiadspro_styles .= '
	        #pacz-contactinfo-shortcode-'.$style_id.'.custom-skin li i {
	            border-right: 2px solid '.$border_color.';
				color: '.$text_icon_color.';
	        }
	        #pacz-contactinfo-shortcode-'.$style_id.' ul li{
	        	color: '.$text_icon_color.' !important;
	        }
	        #pacz-contactinfo-shortcode-'.$style_id.' ul li a{
	        	color: '.$text_icon_color.' !important;
	        }';

	// Hidden styles node for head injection after page load through ajax
	echo '<div id="ajax-'.$style_id.'" class="pacz-dynamic-styles">';
	echo '<!-- ' . pacz_clean_dynamic_styles($classiadspro_styles) . '-->';
	echo '</div>';


	// Export styles to json for faster page load
	$classiadspro_dynamic_styles[] = array(
	  'id' => 'ajax-'.$style_id ,
	  'inject' => $classiadspro_styles
	);
}


$output .= '<div id="pacz-contactinfo-shortcode-'.$style_id.'" class="widget_contact_info pacz-contactinfo-shortcode '.$skin.'-skin '.$el_class.'">';
$output .= '<ul>';
$output .= !empty( $name )  ? '<li'.$animation_css.'><i class="pacz-theme-icon-user"></i><span itemprop="name">'.$name.'</span></li>' : '';
$output .= !empty( $cellphone )  ? '<li'.$animation_css.'><i class="pacz-theme-icon-cellphone"></i><span>'.$cellphone.'</span></li>' : '';
$output .= !empty( $phone )  ? '<li'.$animation_css.'><i class="pacz-theme-icon-phone"></i><span>'.$phone.'</span></li>' : '';
$output .= !empty( $address )  ? '<li'.$animation_css.'><i class="pacz-theme-icon-office"></i><span itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">'.$address.'</span></li>' : '';
$output .= !empty( $website )  ? '<li'.$animation_css.'><i class="pacz-icon-globe"></i><span><a href="' . $website . '">'.$website.'</a></span></li>' : '';
$output .= !empty( $email )  ? '<li'.$animation_css.'><i class="pacz-theme-icon-email"></i><span itemprop="email"><a href="mailto:' . antispambot($email) . '">'.$email.'</a></span></li>' : '';

$output .= '</ul>';
$output .= '</div>';

echo '<div>'.$output.'</div>';

