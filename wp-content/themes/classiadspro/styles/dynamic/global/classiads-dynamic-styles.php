<?php

/*
 *
 * Contains all the dynamic css rules generated based on theme settings.
 *
 */

//function pacz_dynamic_css() {

	//wp_enqueue_style('pacz-style', get_stylesheet_uri(), false, false, 'all');

	global $pacz_settings;

	$output = $typekit_fonts_1 = $attach = $custom_breadcrumb_page = $custom_breadcrumb_hover_color = $custom_breadcrumb_color = '';

/* Get skin color from global $_GET for skin switcher panel */
	if (isset($_GET['skin'])) {
		$accent_color = '#' . $_GET['skin'];
		$btn_hover = '#' . $_GET['btn-hover'];
		$pacz_settings['footer-link-color']['hover'] = '#' . $_GET['skin'];
		$pacz_settings['dashboard-link-color']['hover'] = '#' . $_GET['skin'];
		$pacz_settings['sidebar-link-color']['hover'] = '#' . $_GET['skin'];
		$pacz_settings['link-color']['hover'] = '#' . $_GET['skin'];
		$pacz_settings['footer-social-color']['hover'] = '#' . $_GET['skin'];
		$pacz_settings['main-nav-top-color']['hover'] = '#' . $_GET['skin'];
		$pacz_settings['main-nav-sub-color']['bg-hover'] = '#' . $_GET['skin'];
		$pacz_settings['main-nav-sub-color']['bg-active'] = '#' . $_GET['skin'];

	} else {
		$accent_color = $pacz_settings['accent-color'];
		$btn_hover = $pacz_settings['btn-hover'];
	}

/**
 * Typekit fonts
 * */

	$typekit_id = isset($pacz_settings['typekit-id']) ? $pacz_settings['typekit-id'] : '';
	$typekit_elements_list_1 = isset($pacz_settings['typekit-element-names']) ? $pacz_settings['typekit-element-names'] : '';
	$typekit_font_family_1 = isset($pacz_settings['typekit-font-family']) ? $pacz_settings['typekit-font-family'] : '';

	if ($typekit_id != '' && $typekit_elements_list_1 != '' && $typekit_font_family_1 != '') {
		if (is_array($typekit_elements_list_1)) {
			$typekit_elements_list_1 = implode(', ', $typekit_elements_list_1);
		} else {
			$typekit_elements_list_1 = $typekit_elements_list_1;
		}
		$typekit_fonts_1 = $typekit_elements_list_1 . ' {font-family: "' . $typekit_font_family_1 . '"}';

	}

###########################################
# Structure
###########################################

// Sidebar Width deducted from content width percentage
global $post;
if(is_page() && !has_shortcode($post->post_content, 'vc_row')){
	$output .= "
	.theme-content {padding:70px 0;}
	";
}
	$sidebar_width = 100 - $pacz_settings['content-width'];

	$boxed_layout_width = $pacz_settings['grid-width']+60;
	
Classiadspro_Static_Files::addGlobalStyle("
.pacz-grid,
.pacz-inner-grid
{
	max-width: {$pacz_settings['grid-width']}px;
}

.theme-page-wrapper.right-layout .theme-content, .theme-page-wrapper.left-layout .theme-content
{
	width: {$pacz_settings['content-width']}%;
}

.theme-page-wrapper #pacz-sidebar.pacz-builtin
{
	width: {$sidebar_width}%;
}



.pacz-boxed-enabled,
.pacz-boxed-enabled #pacz-header.sticky-header,
.pacz-boxed-enabled #pacz-header.transparent-header-sticky,
.pacz-boxed-enabled .pacz-secondary-header
{
	max-width: {$boxed_layout_width}px;

}

@media handheld, only screen and (max-width: {$pacz_settings['grid-width']}px)
{

#sub-footer .item-holder
{
	margin:0 20px;
}

}

");

###########################################
# Backgrounds
###########################################

/**
 * Body background
 */
	$body_bg = $pacz_settings['body-bg']['color'] ? 'background-color:' . $pacz_settings['body-bg']['color'] . ';' : '';
	$body_bg .= $pacz_settings['body-bg']['url'] ? 'background-image:url(' . $pacz_settings['body-bg']['url'] . ');' : ' ';
	$body_bg .= $pacz_settings['body-bg']['position'] ? 'background-position:' . $pacz_settings['body-bg']['position'] . ';' : '';
	$body_bg .= $pacz_settings['body-bg']['attachment'] ? 'background-attachment:' . $pacz_settings['body-bg']['attachment'] . ';' : '';
	$body_bg .= $pacz_settings['body-bg']['repeat'] ? 'background-repeat:' . $pacz_settings['body-bg']['repeat'] . ';' : '';
	$body_bg .= (isset($pacz_settings['body-bg']['cover']) && $pacz_settings['body-bg']['cover'] == 1) ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

/**
 * Header background
 */
	$header_bg_color = $pacz_settings['header-bg']['color'] ? 'background-color:' . $pacz_settings['header-bg']['color'] . ';' : '';
	$header_bg = $pacz_settings['header-bg']['color'] ? 'background-color:' . $pacz_settings['header-bg']['color'] . ';' : '';
	$header_bg .= $pacz_settings['header-bg']['url'] ? 'background-image:url(' . $pacz_settings['header-bg']['url'] . ');' : ' ';
	$header_bg .= $pacz_settings['header-bg']['position'] ? 'background-position:' . $pacz_settings['header-bg']['position'] . ';' : '';
	$header_bg .= $pacz_settings['header-bg']['attachment'] ? 'background-attachment:' . $pacz_settings['header-bg']['attachment'] . ';' : '';
	$header_bg .= $pacz_settings['header-bg']['repeat'] ? 'background-repeat:' . $pacz_settings['header-bg']['repeat'] . ';' : '';
	$header_bg .= (isset($pacz_settings['header-bg']['cover']) && $pacz_settings['header-bg']['cover'] == 1) ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

/**
 * Header toolbar background
 */
	$toolbar_bg = $pacz_settings['toolbar-bg']['color'] ? 'background-color:' . $pacz_settings['toolbar-bg']['color'] . ';' : '';
	$toolbar_bg .= $pacz_settings['toolbar-bg']['url'] ? 'background-image:url(' . $pacz_settings['toolbar-bg']['url'] . ');' : ' ';
	$toolbar_bg .= $pacz_settings['toolbar-bg']['position'] ? 'background-position:' . $pacz_settings['toolbar-bg']['position'] . ';' : '';
	$toolbar_bg .= $pacz_settings['toolbar-bg']['attachment'] ? 'background-attachment:' . $pacz_settings['toolbar-bg']['attachment'] . ';' : '';
	$toolbar_bg .= $pacz_settings['toolbar-bg']['repeat'] ? 'background-repeat:' . $pacz_settings['toolbar-bg']['repeat'] . ';' : '';
	$toolbar_bg .= (isset($pacz_settings['toolbar-bg']['cover']) && $pacz_settings['toolbar-bg']['cover'] == 1) ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

/**
 * Page Title background
 */
	$page_title_bg = $pacz_settings['page-title-bg']['color'] ? 'background-color:' . $pacz_settings['page-title-bg']['color'] . ';' : '';
	$page_title_bg .= $pacz_settings['page-title-bg']['url'] ? 'background-image:url(' . $pacz_settings['page-title-bg']['url'] . ');' : ' ';
	$page_title_bg .= $pacz_settings['page-title-bg']['position'] ? 'background-position:' . $pacz_settings['page-title-bg']['position'] . ';' : '';
	$page_title_bg .= $pacz_settings['page-title-bg']['attachment'] ? 'background-attachment:' . $pacz_settings['page-title-bg']['attachment'] . ';' : '';
	$page_title_bg .= $pacz_settings['page-title-bg']['repeat'] ? 'background-repeat:' . $pacz_settings['page-title-bg']['repeat'] . ';' : '';
	$page_title_bg .= (isset($pacz_settings['page-title-bg']['cover']) && $pacz_settings['page-title-bg']['cover'] == 1) ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';
	$page_title_bg .= $pacz_settings['page-title-bg']['border'] ? 'border-bottom:1px solid ' . $pacz_settings['page-title-bg']['border'] . ';' : '';

/**
 * Page background
 */
	$page_bg = $pacz_settings['page-bg']['color'] ? 'background-color:' . $pacz_settings['page-bg']['color'] . ';' : '';
	$page_bg .= $pacz_settings['page-bg']['url'] ? 'background-image:url(' . $pacz_settings['page-bg']['url'] . ');' : ' ';
	$page_bg .= $pacz_settings['page-bg']['position'] ? 'background-position:' . $pacz_settings['page-bg']['position'] . ';' : '';
	$page_bg .= $pacz_settings['page-bg']['attachment'] ? 'background-attachment:' . $pacz_settings['page-bg']['attachment'] . ';' : '';
	$page_bg .= $pacz_settings['page-bg']['repeat'] ? 'background-repeat:' . $pacz_settings['page-bg']['repeat'] . ';' : '';
	$page_bg .= (isset($pacz_settings['page-bg']['cover']) && $pacz_settings['page-bg']['cover'] == 1) ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

/**
 * Footer background
 */
	$footer_bg = $pacz_settings['footer-bg']['color'] ? 'background-color:' . $pacz_settings['footer-bg']['color'] . ';' : '';
	$footer_bg .= $pacz_settings['footer-bg']['url'] ? 'background-image:url(' . $pacz_settings['footer-bg']['url'] . ');' : ' ';
	$footer_bg .= $pacz_settings['footer-bg']['position'] ? 'background-position:' . $pacz_settings['footer-bg']['position'] . ';' : '';
	$footer_bg .= $pacz_settings['footer-bg']['attachment'] ? 'background-attachment:' . $pacz_settings['footer-bg']['attachment'] . ';' : '';
	$footer_bg .= $pacz_settings['footer-bg']['repeat'] ? 'background-repeat:' . $pacz_settings['footer-bg']['repeat'] . ';' : '';
	$footer_bg .= (isset($pacz_settings['footer-bg']['cover']) && $pacz_settings['footer-bg']['cover'] == 1) ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

	$page_title_color = $pacz_settings['page-title-color'];
	$page_title_size = $pacz_settings['page-title-size'];
	$page_title_padding = 200;
	$page_title_weight = '';
	$page_title_letter_spacing = '';

	if (global_get_post_id()) {


		$post_id = global_get_post_id();

		$intro = get_post_meta($post_id, '_page_title_intro', true);

		
		if($intro != 'none') {
			$attach = 'background-attachment: scroll;';
		}

		$enable = get_post_meta($post_id, '_custom_bg', true);

		if ($enable == 'true') {
			$body_bg = get_post_meta($post_id, 'body_color', true) ? 'background-color: ' . get_post_meta($post_id, 'body_color', true) . ';' : '';
			$body_bg .= get_post_meta($post_id, 'body_image', true) ? 'background-image:url(' . get_post_meta($post_id, 'body_image', true) . ');' : '';
			$body_bg .= get_post_meta($post_id, 'body_repeat', true) ? 'background-repeat:' . get_post_meta($post_id, 'body_repeat', true) . ';' : '';
			$body_bg .= get_post_meta($post_id, 'body_position', true) ? 'background-position:' . get_post_meta($post_id, 'body_position', true) . ';' : '';
			$body_bg .= get_post_meta($post_id, 'body_attachment', true) ? 'background-attachment:' . get_post_meta($post_id, 'body_attachment', true) . ';' : '';
			$body_bg .= (get_post_meta($post_id, 'body_cover', true) == 'true') ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

			$header_bg = get_post_meta($post_id, 'header_color', true) ? 'background-color: ' . get_post_meta($post_id, 'header_color', true) . ';' : '';
			$header_bg_color = get_post_meta($post_id, 'header_color', true) ? 'background-color: ' . get_post_meta($post_id, 'header_color', true) . ';' : '';
			$header_bg .= get_post_meta($post_id, 'header_image', true) ? 'background-image:url(' . get_post_meta($post_id, 'header_image', true) . ');' : '';
			$header_bg .= get_post_meta($post_id, 'header_repeat', true) ? 'background-repeat:' . get_post_meta($post_id, 'header_repeat', true) . ';' : '';
			$header_bg .= get_post_meta($post_id, 'header_position', true) ? 'background-position:' . get_post_meta($post_id, 'header_position', true) . ';' : '';
			$header_bg .= get_post_meta($post_id, 'header_attachment', true) ? 'background-attachment:' . get_post_meta($post_id, 'header_attachment', true) . ';' : '';
			$header_bg .= (get_post_meta($post_id, 'header_cover', true) == 'true') ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

			$page_title_bg = get_post_meta($post_id, 'banner_color', true) ? 'background-color: ' . get_post_meta($post_id, 'banner_color', true) . ';' : '';
			$page_title_bg .= get_post_meta($post_id, 'banner_image', true) ? 'background-image:url(' . get_post_meta($post_id, 'banner_image', true) . ');' : '';
			$page_title_bg .= get_post_meta($post_id, 'banner_repeat', true) ? 'background-repeat:' . get_post_meta($post_id, 'banner_repeat', true) . ';' : '';
			$page_title_bg .= get_post_meta($post_id, 'banner_position', true) ? 'background-position:' . get_post_meta($post_id, 'banner_position', true) . ';' : '';
			$page_title_bg .= get_post_meta($post_id, 'banner_attachment', true) ? 'background-attachment:' . get_post_meta($post_id, 'banner_attachment', true) . ';' : '';
			$page_title_bg .= (get_post_meta($post_id, 'banner_cover', true) == 'true') ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

			$page_bg = get_post_meta($post_id, 'page_color', true) ? 'background-color: ' . get_post_meta($post_id, 'page_color', true) . ' !important;' : '';
			$page_bg .= get_post_meta($post_id, 'page_image', true) ? 'background-image:url(' . get_post_meta($post_id, 'page_image', true) . ') !important;' : '';
			$page_bg .= get_post_meta($post_id, 'page_repeat', true) ? 'background-repeat:' . get_post_meta($post_id, 'page_repeat', true) . ' !important;' : '';
			$page_bg .= get_post_meta($post_id, 'page_position', true) ? 'background-position:' . get_post_meta($post_id, 'page_position', true) . ' !important;' : '';
			$page_bg .= get_post_meta($post_id, 'page_attachment', true) ? 'background-attachment:' . get_post_meta($post_id, 'page_attachment', true) . ' !important;' : '';
			$page_bg .= (get_post_meta($post_id, 'page_cover', true) == 'true') ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

			$footer_bg = get_post_meta($post_id, 'footer_color', true) ? 'background-color: ' . get_post_meta($post_id, 'footer_color', true) . ';' : '';
			$footer_bg .= get_post_meta($post_id, 'footer_image', true) ? 'background-image:url(' . get_post_meta($post_id, 'footer_image', true) . ');' : '';
			$footer_bg .= get_post_meta($post_id, 'footer_repeat', true) ? 'background-repeat:' . get_post_meta($post_id, 'footer_repeat', true) . ';' : '';
			$footer_bg .= get_post_meta($post_id, 'footer_position', true) ? 'background-position:' . get_post_meta($post_id, 'footer_position', true) . ';' : '';
			$footer_bg .= get_post_meta($post_id, 'footer_attachment', true) ? 'background-attachment:' . get_post_meta($post_id, 'footer_attachment', true) . ';' : '';
			$footer_bg .= (get_post_meta($post_id, 'footer_cover', true) == 'true') ? 'background-size: cover;background-repeat: no-repeat;-moz-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;' : '';

			$page_title_color = get_post_meta($post_id, '_page_title_color', true) ? get_post_meta($post_id, '_page_title_color', true) : $pacz_settings['page-title-color'];
			$page_title_weight = get_post_meta($post_id, '_page_title_weight', true) ? ('font-weight:' . get_post_meta($post_id, '_page_title_weight', true)) : '';
			$page_title_letter_spacing = get_post_meta($post_id, '_page_title_letter_spacing', true) ? ('letter-spacing:' . get_post_meta($post_id, '_page_title_letter_spacing', true) . 'px;') : '';

			$page_title_size = get_post_meta($post_id, '_page_title_size', true) ? get_post_meta($post_id, '_page_title_size', true) : $pacz_settings['page-title-size'];
			$page_title_padding = get_post_meta($post_id, '_page_title_padding', true) ? get_post_meta($post_id, '_page_title_padding', true) : 40;
			
			$header_grid_margin = get_post_meta($post_id, 'header-grid-margin-top', true) ? get_post_meta($post_id, 'header-grid-margin-top', true) : $pacz_settings['header-grid-margin-top'];
			$header_border_top = get_post_meta($post_id, 'header-border-top', true) ? get_post_meta($post_id, 'header-border-top', true) : $pacz_settings['header-border-top'];
		}
		/*** custom breadcrumb coloring ***/
		$custom_breadcrumb_page = get_post_meta($post_id, '_breadcrumb_skin', true) ? 1 : 0;
		$custom_breadcrumb_color = get_post_meta($post_id, '_breadcrumb_custom_color', true) ? get_post_meta($post_id, '_breadcrumb_custom_color', true) : '';
		$custom_breadcrumb_hover_color = get_post_meta($post_id, '_breadcrumb_custom_hover_color', true) ? get_post_meta($post_id, '_breadcrumb_custom_hover_color', true) : '';

	}

	$header_bottom_border = (isset($pacz_settings['header-bottom-border']) && !empty($pacz_settings['header-bottom-border'])) ? ('border-bottom:1px solid' . $pacz_settings['header-bottom-border'] . ';') : '';

Classiadspro_Static_Files::addGlobalStyle("
	body,.theme-main-wrapper{
		{$body_bg}
	}

");

$listing_header_btn_color_regular = (isset($pacz_settings['listing-header-btn-color']['regular']))? $pacz_settings['listing-header-btn-color']['regular'] : '';
$listing_header_btn_color_hover = (isset($pacz_settings['listing-header-btn-color']['hover']))? $pacz_settings['listing-header-btn-color']['hover'] : '';
$listing_header_btn_color_bg = (isset($pacz_settings['listing-header-btn-color']['bg']))? $pacz_settings['listing-header-btn-color']['bg'] : '';
$listing_header_btn_color_bghover = (isset($pacz_settings['listing-header-btn-color']['bg-hover']))? $pacz_settings['listing-header-btn-color']['bg-hover'] : '';

$post_id = global_get_post_id();
$header_border_top = get_post_meta($post_id, 'header-border-top', true) ? get_post_meta($post_id, 'header-border-top', true) : $pacz_settings['header-border-top'];
if (is_page() && $header_border_top == 'true') {
		
Classiadspro_Static_Files::addGlobalStyle("
		.theme-main-wrapper:not(.vertical-header) #pacz-header,
		.theme-main-wrapper:not(.vertical-header) .pacz-secondary-header
		{
			border-top:1px solid {$accent_color};
		}
");
}
else if (isset($pacz_settings['header-border-top']) && ($pacz_settings['header-border-top'] == 1)) {
		
Classiadspro_Static_Files::addGlobalStyle("
		.theme-main-wrapper:not(.vertical-header) #pacz-header,
		.theme-main-wrapper:not(.vertical-header) .pacz-secondary-header
		{
			border-top:1px solid {$accent_color};
		}
");
}

Classiadspro_Static_Files::addGlobalStyle(" 
	#pacz-header,.pacz-secondary-header{
	{$header_bg};
	{$header_bg_color};
	}
.listing-btn{
	display:inline-block;
	
	}
.listing-btn .listing-header-btn{
	min-width:120px;
	display:inline;
	padding:8px 12px;
	font-weight:bold;
	text-transform:uppercase;
	color:{$listing_header_btn_color_regular};
	border-radius:0;
	background:{$listing_header_btn_color_bg};
	font-size:12px;
	font-weight:normal;
}
.listing-btn.mobile-submit a{
	color:{$listing_header_btn_color_regular};
	background:{$listing_header_btn_color_bg};
}
.listing-btn .listing-header-btn:hover,
.listing-btn.mobile-submit a{
	background:{$listing_header_btn_color_bghover} !important;
	color:{$listing_header_btn_color_hover} !important;
}
.submit-page-buton.hours-field-btn,
.cz-creat-listing-inner .submit .button.btn{
	color:#fff;
	background:{$pacz_settings['accent-color']};
}
.submit-page-buton.hours-field-btn:hover,
.cz-creat-listing-inner .submit .button.btn:hover{
	background:{$pacz_settings['btn-hover']};
}

");

/***** side-dashboard setting move to line number 246 if required ****

.pacz-side-dashboard {
	background-color:{$pacz_settings['dashboard-bg']};
}
.pacz-side-dashboard .widgettitle,
.pacz-side-dashboard .widgettitle a
{
	color: {$pacz_settings['dashboard-title-color']};
}


.pacz-side-dashboard,
.pacz-side-dashboard p
{
	color: {$pacz_settings['dashboard-txt-color']};
}

.pacz-side-dashboard a
{
	color: {$pacz_settings['dashboard-link-color']['regular']};
}

.pacz-side-dashboard a:hover
{
	color: {$pacz_settings['dashboard-link-color']['hover']};
}

*/
/**
 * Header Toolbar font settings
 */
$toolbar_font = (isset($pacz_settings['toolbar-font']['font-family']) && !empty($pacz_settings['toolbar-font']['font-family'])) ? ('font-family:' . $pacz_settings['toolbar-font']['font-family'] . ';') : '';
$toolbar_font .= (isset($pacz_settings['toolbar-font']['font-weight']) && !empty($pacz_settings['toolbar-font']['font-weight'])) ? ('font-weight:' . $pacz_settings['toolbar-font']['font-weight'] . ';') : '';
$toolbar_font .= (isset($pacz_settings['toolbar-font']['font-size']) && !empty($pacz_settings['toolbar-font']['font-size'])) ? ('font-size:' . $pacz_settings['toolbar-font']['font-size'] . ';') : '';
$logo_height = (!empty($pacz_settings['logo']['height'])) ? $pacz_settings['logo']['height'] : 50;
$toolbar_height = $pacz_settings['toolbar_height'];
$page_title_padding = $toolbar_height+($pacz_settings['header-padding'] * 2) + 50;
$page_title_height = $page_title_padding+ 94;
$toolbar_lineheight = $pacz_settings['toolbar_height'] - 2; 

$toolbar =(isset($pacz_settings['header-toolbar']) && !empty($pacz_settings['header-toolbar'])) ? $pacz_settings['header-toolbar'] : 0;
$toolbar_check = get_post_meta( $post_id, '_header_toolbar', true );
$toolbar_option = !empty($toolbar_check) ? $toolbar_check : 'true';

if($toolbar){
        if($toolbar_option == 'true'){
			$header_margin_top = $toolbar_height;
			$sticky_header_padding_top =$toolbar_height+($pacz_settings['header-padding'] * 2) +50;
		}
}else{
	$header_margin_top = 1;
	$sticky_header_padding_top =($pacz_settings['header-padding'] * 2) +50;
}
Classiadspro_Static_Files::addGlobalStyle("
	#pacz-header.sticky-trigger-header{
	
	}
");

if($pacz_settings['top-footer'] == 0){
	
Classiadspro_Static_Files::addGlobalStyle("
	#pacz-footer{padding-top:100px;}

");	
	
}else if($pacz_settings['top-footer'] == 1 && $pacz_settings['footer_form_style'] == 2){
Classiadspro_Static_Files::addGlobalStyle("
#pacz-footer{padding-top:100px;}
	.footer-top{margin-bottom:100px;border-top:2px solid {$accent_color};}
");	
}
Classiadspro_Static_Files::addGlobalStyle("

.pacz-header-toolbar{
{$toolbar_bg};
{$toolbar_font};
height:{$toolbar_height}px;
line-height:{$toolbar_lineheight}px;
}

.sticky-header-padding {
	{$header_bg_color}
	
}

#pacz-header.transparent-header-sticky,
#pacz-header.sticky-header {
{$header_bottom_border}}


.transparent-header.light-header-skin,
.transparent-header.dark-header-skin
 {
  border-top: none !important;
  
}

#pacz-page-title .pacz-page-title-bg {
{$page_title_bg};
{$attach}
}

#theme-page
{
{$page_bg}}

#pacz-footer
{
{$footer_bg}
}
#sub-footer
{
	background-color: {$pacz_settings['sub-footer-bg']};
}
.footer-top{
	background-color: {$pacz_settings['top-footer-bg']};
}



#pacz-page-title .pacz-page-heading{
	font-size:{$page_title_size}px;
	color:{$page_title_color};
	{$page_title_weight};
	{$page_title_letter_spacing};
}
#pacz-breadcrumbs {
	line-height:{$page_title_size}px;
}

");

Classiadspro_Static_Files::addGlobalStyle("
	
	#pacz-page-title
{
	padding-top:50px !important;
	height:140px !important;
}
	
");

###########################################
	# Widgets
	###########################################

	$widget_font_family = (isset($pacz_settings['widget-title']['font-family']) && !empty($pacz_settings['widget-title']['font-family'])) ? ('font-family:' . $pacz_settings['widget-title']['font-family'] . ';') : '';
	$widget_font_size = (isset($pacz_settings['widget-title']['font-size']) && !empty($pacz_settings['widget-title']['font-size'])) ? ('font-size:' . $pacz_settings['widget-title']['font-size'] . ';') : '';
	$widget_font_weight = (isset($pacz_settings['widget-title']['font-weight']) && !empty($pacz_settings['widget-title']['font-weight'])) ? ('font-weight:' . $pacz_settings['widget-title']['font-weight'] . ';') : '';
	$widget_title_divider = (isset($pacz_settings['widget-title-divider']) && $pacz_settings['widget-title-divider'] == 1) ? '' : 'display: none;'; 

	if(isset($pacz_settings['footer-col-border']) && $pacz_settings['footer-col-border'] == 1){
Classiadspro_Static_Files::addGlobalStyle("
#pacz-footer [class*='pacz-col-'] {
  border-right:1px solid {$pacz_settings['footer-col-border-color']};
}
#pacz-footer [class*='pacz-col-']:last-of-type {
  border-right:none;
}
#pacz-footer .pacz-col-1-2:nth-child(2),
#pacz-footer [class*='pacz-col-']:last-child {
  border-right:none;
}

");
}
Classiadspro_Static_Files::addGlobalStyle("
.widgettitle
{
{$widget_font_family}
{$widget_font_size}
{$widget_font_weight}
}

.widgettitle:after{
	{$widget_title_divider}
}

#pacz-footer .widget_posts_lists ul li .post-list-title{
	color:{$pacz_settings['footer-title-color']};
}
#pacz-footer .widget_posts_lists ul li .post-list-title:hover{
	color: {$pacz_settings['footer-link-color']['hover']};
}
.widget_posts_lists ul li {
	border-color:{$pacz_settings['footer-recent-lisitng-border-color']};
}
.classiadspro-form-row .classiadspro-subscription-button{
	background-color:{$accent_color};
}
.classiadspro-form-row .classiadspro-subscription-button:hover{
	background-color:{$pacz_settings['btn-hover']};
}
.widget-social-container.simple-style a.dark{
	color: {$pacz_settings['footer-social-color']['regular']} !important;
}
.widget-social-container.simple-style a.dark:hover{
	color: {$pacz_settings['footer-social-color']['hover']}!important;
}
.widget .phone-number i,
.widget .email-id i{
	color: {$pacz_settings['footer-social-color']['hover']}!important;
}
#pacz-sidebar .widgettitle,
#pacz-sidebar .widgettitle  a
{
	color: {$pacz_settings['sidebar-title-color']};
}


#pacz-sidebar,
#pacz-sidebar p
{
	color: {$pacz_settings['sidebar-txt-color']};
}


#pacz-sidebar a
{
	color: {$pacz_settings['sidebar-link-color']['regular']};
}

#pacz-sidebar a:hover
{
	color: {$pacz_settings['sidebar-link-color']['hover']};
}

#pacz-footer .widgettitle,
#pacz-footer .widgettitle a
{
	color: {$pacz_settings['footer-title-color']};
}

#pacz-footer,
#pacz-footer p
{
	color: {$pacz_settings['footer-txt-color']};
}

#pacz-footer a
{
	color: {$pacz_settings['footer-link-color']['regular']};
}

#pacz-footer a:hover
{
	color: {$pacz_settings['footer-link-color']['hover']};
}

.pacz-footer-copyright,
.pacz-footer-copyright a {
	color: {$pacz_settings['footer-socket-color']} !important;
}

.sub-footer .pacz-footer-social li a i{
	color: {$pacz_settings['footer-social-color']['regular']} !important;
}

.sub-footer .pacz-footer-social a:hover {
	color: {$pacz_settings['footer-social-color']['hover']}!important;
}

#sub-footer .pacz-footer-social li a.icon-twitter i,
#sub-footer .pacz-footer-social li a.icon-linkedin i,
#sub-footer .pacz-footer-social li a.icon-facebook i,
#sub-footer .pacz-footer-social li a.icon-pinterest i,
#sub-footer .pacz-footer-social li a.icon-google-plus i,
#sub-footer .pacz-footer-social li a.icon-instagram i,
#sub-footer .pacz-footer-social li a.icon-dribbble i,
#sub-footer .pacz-footer-social li a.icon-rss i,
#sub-footer .pacz-footer-social li a.icon-youtube-play i,
#sub-footer .pacz-footer-social li a.icon-behance i,
#sub-footer .pacz-footer-social li a.icon-whatsapp i,
#sub-footer .pacz-footer-social li a.icon-vimeo i,
#sub-footer .pacz-footer-social li a.icon-weibo i,
#sub-footer .pacz-footer-social li a.icon-spotify i,
#sub-footer .pacz-footer-social li a.icon-vk i,
#sub-footer .pacz-footer-social li a.icon-qzone i,
#sub-footer .pacz-footer-social li a.icon-wechat i,
#sub-footer .pacz-footer-social li a.icon-renren i,
#sub-footer .pacz-footer-social li a.icon-imdb i{
	color: {$pacz_settings['footer-social-color']['regular']} !important;
	
}
#sub-footer .pacz-footer-social li a:hover i{color: {$pacz_settings['footer-social-color']['hover']}!important;}

#sub-footer .pacz-footer-social li a.icon-twitter:hover,
#sub-footer .pacz-footer-social li a.icon-linkedin:hover,
#sub-footer .pacz-footer-social li a.icon-facebook:hover,
#sub-footer .pacz-footer-social li a.icon-pinterest:hover,
#sub-footer .pacz-footer-social li a.icon-google-plus:hover,
#sub-footer .pacz-footer-social li a.icon-instagram:hover,
#sub-footer .pacz-footer-social li a.icon-dribbble:hover,
#sub-footer .pacz-footer-social li a.icon-rss:hover,
#sub-footer .pacz-footer-social li a.icon-youtube-play:hover,
#sub-footer .pacz-footer-social li a.icon-tumblr:hover,
#sub-footer .pacz-footer-social li a.icon-behance:hover,
#sub-footer .pacz-footer-social li a.icon-whatsapp:hover,
#sub-footer .pacz-footer-social li a.icon-vimeo:hover,
#sub-footer .pacz-footer-social li a.icon-weibo:hover,
#sub-footer .pacz-footer-social li a.icon-spotify:hover,
#sub-footer .pacz-footer-social li a.icon-vk:hover,
#sub-footer .pacz-footer-social li a.icon-qzone:hover,
#sub-footer .pacz-footer-social li a.icon-wechat:hover,
#sub-footer .pacz-footer-social li a.icon-renren:hover,
#sub-footer .pacz-footer-social li a.icon-imdb:hover{
	background-color: {$pacz_settings['footer-social-color']['bg-hover']}!important;
	
}

#sub-footer .pacz-footer-social li a{
	background-color: {$pacz_settings['footer-social-color']['bg']}!important;
	box-shadow:none;
	}
#pacz-footer .widget_tag_cloud a,
#pacz-footer .widget_product_tag_cloud a {
  border-color:{$pacz_settings['footer-link-color']['regular']};
  
  
}
#pacz-footer .widget_tag_cloud a:hover,
#pacz-footer .widget_product_tag_cloud:hover a {
  border-color:{$pacz_settings['accent-color']};
  background-color:{$pacz_settings['accent-color']};
  
  
}

.widget_tag_cloud a:hover,
.widget_product_tag_cloud:hover a,
#pacz-sidebar .widget_tag_cloud a:hover,
#pacz-sidebar .widget_product_tag_cloud a:hover {
  border-color:{$pacz_settings['accent-color']};
  background-color:{$pacz_settings['accent-color']};
  
  
}
#pacz-sidebar .widget_posts_lists ul li .post-list-meta data {
  background-color:{$pacz_settings['accent-color']};
  color:#fff;
}
#pacz-sidebar .widget_posts_lists ul li .post-list-title{
	color:{$pacz_settings['heading-color']};
	
}
#pacz-sidebar .widget_archive ul li a:before,
#pacz-sidebar .widget_categories a:before{
	color:{$pacz_settings['accent-color']};
	
}
#pacz-sidebar .widget_archive ul li a:hover:before,
#pacz-sidebar .widget_categories a:hover:before{
	color:#fff;
	background-color:{$pacz_settings['accent-color']};
	
}
#pacz-sidebar .widgettitle:before {
	background-color:{$pacz_settings['accent-color']};
	
}

.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
    background: #fff;
    border: 5px solid {$pacz_settings['accent-color']};
    color: #fff;
}

.sidebar-wrapper .alsp-widget-listing-title a{color: {$pacz_settings['sidebar-title-color']} !important;}
.listing-widget-hover-overlay{
	background: {$pacz_settings['btn-hover']} !important;
}
.hover-overlay{
	 background: {$pacz_settings['accent-color']} !important;
}
.listing-post-style-11 figure .price .alsp-field-content{
	background-color:{$pacz_settings['accent-color']};
}
.listing-post-style-13 figure .price .alsp-field-content{
	background-color:{$pacz_settings['accent-color']};
}
");
if(is_rtl()){
Classiadspro_Static_Files::addGlobalStyle("
		.listing-post-style-13 figure .price .alsp-field-content:after{
			border-bottom-color:{$pacz_settings['accent-color']};
			border-right-color:{$pacz_settings['accent-color']};
			border-top-color:{$pacz_settings['accent-color']};
		}
	");
}else{
	Classiadspro_Static_Files::addGlobalStyle("
		.listing-post-style-13 figure .price .alsp-field-content:after{
			border-bottom-color:{$pacz_settings['accent-color']};
			border-left-color:{$pacz_settings['accent-color']};
			border-top-color:{$pacz_settings['accent-color']};
		}
");
}
Classiadspro_Static_Files::addGlobalStyle("
.listing-post-style-13 .cat-wrapper .listing-cat{
	color:{$pacz_settings['accent-color']} !important;
}
.location-style8.alsp-locations-columns .alsp-locations-column-wrapper .alsp-locations-root a .location-icon{
	background-color:{$pacz_settings['accent-color']};
}
.location-style8.alsp-locations-columns .alsp-locations-column-wrapper .alsp-locations-root a:hover{
	color:{$pacz_settings['accent-color']};
}
.location-style9.alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a:hover{
	color:{$pacz_settings['accent-color']};
	border-color:{$pacz_settings['accent-color']};
}
.location-style9.alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a:hover .location-icon{
	color:{$pacz_settings['accent-color']};
}
.cat-style-6 .alsp-categories-row:not(.owl-carousel) .alsp-categories-column-wrapper .subcategories ul li:last-child a:hover{
	
	background-color:{$pacz_settings['accent-color']};
}

");

###########################################
	# Typography & Coloring
	###########################################

	$body_font_backup = (isset($pacz_settings['body-font']['font-backup']) && !empty($pacz_settings['body-font']['font-backup'])) ? ('font-family:' . $pacz_settings['body-font']['font-backup'] . ';') : '';
	$body_font_family = (isset($pacz_settings['body-font']['font-family']) && !empty($pacz_settings['body-font']['font-family'])) ? ('font-family:' . $pacz_settings['body-font']['font-family'] . ';') : '';
	$heading_font_family = (isset($pacz_settings['heading-font']['font-family']) && !empty($pacz_settings['heading-font']['font-family'])) ? ('font-family:' . $pacz_settings['heading-font']['font-family'] . ';') : '';
	$p_font_size = (isset($pacz_settings['p-text-size']) && !empty($pacz_settings['p-text-size'])) ? $pacz_settings['p-text-size'] : $pacz_settings['body-font']['font-size'];
	$cart_link_color_regular = (isset($pacz_settings['header_cart_link_color']['regular']))? $pacz_settings['header_cart_link_color']['regular'] : '';
	$cart_link_color_hover = (isset($pacz_settings['header_cart_link_color']['hover']))? $pacz_settings['header_cart_link_color']['hover'] : '';
	$cart_link_color_bg = (isset($pacz_settings['header_cart_link_color']['bg']))? $pacz_settings['header_cart_link_color']['bg'] : '';
	$cart_link_color_bghover = (isset($pacz_settings['header_cart_link_color']['bg-hover']))? $pacz_settings['header_cart_link_color']['bg-hover'] : '';

	Classiadspro_Static_Files::addGlobalStyle("
	.woocommerce-product-rating .star-rating:before,
.woocommerce .star-rating:before,
.woocommerce-page ul.products.classic-style li.product .star-rating span:before,
.woocommerce ul.products.classic-style li.product .star-rating span:before,
.woocommerce-page .woocommerce-product-rating,
.woocommerce .woocommerce-product-rating,
.woocommerce .star-rating{
  color: {$accent_color} !important;
}
.entry-summary .product_meta .posted_in,
.entry-summary .product_meta .tagged_as,
.submit-cat-lable{
	color:{$pacz_settings['heading-color']};
}
.entry-summary .product_meta .posted_in a,
.entry-summary .product_meta .tagged_as a{
	color:{$pacz_settings['body-txt-color']};
}
.entry-summary .product_meta .posted_in a:hover,
.entry-summary .product_meta .tagged_as a:hover{
	color:{$pacz_settings['accent-color']};
}
	body{
	line-height: 20px;
{$body_font_backup}
{$body_font_family}
	font-size:{$pacz_settings['body-font']['font-size']};
	color:{$pacz_settings['body-txt-color']};
}

{$typekit_fonts_1}

p {
	font-size:{$p_font_size}px;
	color:{$pacz_settings['body-txt-color']};
	line-height:{$pacz_settings['p-line-height']}px;
}

#pacz-footer p {
	font-size:{$pacz_settings['footer-p-text-size']}px;
}
a {
	color:{$pacz_settings['link-color']['regular']};
}

a:hover {
	color:{$pacz_settings['link-color']['hover']};
}


.outline-button{
	background-color:{$pacz_settings['accent-color']} !important;
	}
.tweet-icon{
	border-color:{$pacz_settings['accent-color']};
	color:{$pacz_settings['accent-color']};
	
	}
.tweet-user,
.tweet-time{
	color:{$pacz_settings['accent-color']};
	
	}
#theme-page .pacz-custom-heading h4:hover{
	color:{$pacz_settings['heading-color']};
	
}

.title-divider span{background:{$pacz_settings['accent-color']};}
#theme-page h1,
#theme-page h2,
#theme-page h3,
#theme-page h4,
#theme-page h5,
#theme-page h6,
.subscription-form .title h5
{
	font-weight:{$pacz_settings['heading-font']['font-weight']};
	color:{$pacz_settings['heading-color']};
}
#theme-page h1:hover,
#theme-page h2:hover,
#theme-page h3:hover,
#theme-page h4:hover,
#theme-page h5:hover,
#theme-page h6:hover
{
	font-weight:{$pacz_settings['heading-font']['font-weight']};
	color:{$pacz_settings['accent-color']};
}
.blog-tile-entry .blog-entry-heading .blog-title a,
.blog-title a{
	color:{$pacz_settings['heading-color']};
}

.blog-tile-entry .blog-entry-heading .blog-title a:hover,
.blog-title a:hover,
.blog-tile-entry .item-holder .metatime a{
	color:{$pacz_settings['accent-color']};
}
.blog-tile-entry.tile-elegant .metatime a,
.blog-tile-entry.tile-elegant .blog-comments,
.blog-tile-entry.tile-elegant .author,
.blog-tile-entry.tile-elegant .author span:hover{
	color:{$pacz_settings['link-color']['regular']};
}
.blog-tile-entry.tile-elegant .metatime a:hover,
.blog-tile-entry.tile-elegant .blog-comments:hover,
.blog-tile-entry.tile-elegant .author:hover{
	color:{$pacz_settings['link-color']['hover']};
}
.tile-elegant .blog-readmore-btn a{
	color:{$pacz_settings['heading-color']};
}
.author-title{
	color:{$pacz_settings['heading-color']};
	{$heading_font_family}
}
.tile-elegant .blog-readmore-btn a:hover{
	color:{$pacz_settings['accent-color']};
}

.tile-elegant .blog-readmore-btn:hover:before,
.blog-tile-entry.tile-elegant .blog-meta::before{
	background:{$pacz_settings['accent-color']};
}
.woocommerce-page ul.products.classic-style li.product a,
.woocommerce ul.products.classic-style li.product a
 {
	color:{$pacz_settings['heading-color']};
	
}
.woocommerce-page ul.products.classic-style li.product a:hover,
.woocommerce ul.products.classic-style li.product a:hover,
.woocommerce-page ul.products li.product .price ins,
.woocommerce ul.products li.product .price ins,
.woocommerce-page ul.products.classic-style li.product .pacz-love-this:hover,
.woocommerce ul.products.classic-style li.product .pacz-love-this:hover,
.woocommerce-page ul.products.classic-style li.product .pacz-love-this.item-loved,
.woocommerce ul.products.classic-style li.product .pacz-love-this.item-loved { 
	
	color:{$pacz_settings['accent-color']};
	
}
.woocommerce-page ul.products.classic-style li.product .add_to_cart_button,
.woocommerce ul.products.classic-style li.product .add_to_cart_button{
	background:{$pacz_settings['accent-color']};
}
.woocommerce-page ul.products.classic-style li.product .add_to_cart_button:hover,
.woocommerce ul.products.classic-style li.product .add_to_cart_button:hover{
	background:{$pacz_settings['btn-hover']} !important;
	color:#fff;
}
.woocommerce-page nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li a, .woocommerce-page #content nav.woocommerce-pagination ul li a, .woocommerce #content nav.woocommerce-pagination ul li a, .woocommerce-page nav.woocommerce-pagination ul li span, .woocommerce nav.woocommerce-pagination ul li span, .woocommerce-page #content nav.woocommerce-pagination ul li span, .woocommerce #content nav.woocommerce-pagination ul li span {
    border-color:{$pacz_settings['accent-color']} !important;
	color:{$pacz_settings['accent-color']} !important;
	
}
.pacz-header-toolbar .pacz-cart-link,
#menu-main .pacz-cart-link{
	color:{$cart_link_color_regular};
	background:{$cart_link_color_bg} !important;
}
.pacz-header-toolbar .pacz-cart-link:hover,
#menu-main .pacz-cart-link:hover{
	color:{$cart_link_color_hover} !important;
	background:{$cart_link_color_bghover};
}
.woocommerce-page nav.woocommerce-pagination ul li a:hover,
.woocommerce nav.woocommerce-pagination ul li a:hover,
.woocommerce-page #content nav.woocommerce-pagination ul li a:hover,
.woocommerce #content nav.woocommerce-pagination ul li a:hover,
.woocommerce-page nav.woocommerce-pagination ul li span:hover,
.woocommerce nav.woocommerce-pagination ul li span:hover,
.woocommerce-page #content nav.woocommerce-pagination ul li span:hover,
.woocommerce #content nav.woocommerce-pagination ul li span:hover {
  background-color:{$pacz_settings['accent-color']} !important;
  color:#fff !important;
  
}
.woocommerce-page nav.woocommerce-pagination ul li span.current,
.woocommerce nav.woocommerce-pagination ul li span.current,
.woocommerce-page #content nav.woocommerce-pagination ul li span.current,
.woocommerce #content nav.woocommerce-pagination ul li span.current {
  background-color:{$pacz_settings['accent-color']} !important;
  color:#fff !important;
}


.countdown_style_five ul li .countdown-timer{
	color:{$pacz_settings['heading-color']} !important;
	
}
.owl-nav .owl-prev, .owl-nav .owl-next{
	color:{$pacz_settings['accent-color']};
	
	}
.owl-nav .owl-prev:hover, .owl-nav .owl-next:hover{
	background:{$pacz_settings['accent-color']};
	
	}
.single-listing .owl-nav .owl-prev:hover, .single-listing .owl-nav .owl-next:hover {
	color: {$pacz_settings['btn-hover']} !important;
}
.countdown_style_five ul li .countdown-text{
	color:{$pacz_settings['body-txt-color']} !important;
	
}

.single-social-share li a:hover,
.pacz-next-prev .pacz-next-prev-wrap a:hover {
  color: {$pacz_settings['accent-color']};
}
.woocommerce-share .single-social-share li a{
	background-color: {$pacz_settings['accent-color']};
}
.woocommerce-share .single-social-share li a:hover{
	background-color: {$pacz_settings['btn-hover']};
	color:#fff;
}

h1, h2, h3, h4, h5, h6
{
{$heading_font_family}}
#pacz-footer .widget_posts_lists ul li .post-list-title{
	{$heading_font_family}
}

input,
button,
textarea {
{$body_font_family}}

.woocommerce-page a.button,
.woocommerce a.button,
.woocommerce-page button.button,
.woocommerce button.button,
.woocommerce-page input.button,
.woocommerce input.button,
.woocommerce-page #respond input#submit,
.woocommerce #respond input#submit,
.woocommerce-page #content input.button,
.woocommerce #content input.button,
.woocommerce-page .button-icon-holder a,
.woocommerce .button-icon-holder a,
.place-order .button{
	background:{$accent_color};
	color:#fff !important;
}
.woocommerce-page a.button:hover,
.woocommerce a.button:hover,
.woocommerce-page button.button:hover,
.woocommerce button.button:hover,
.woocommerce-page input.button:hover,
.woocommerce input.button:hover,
.woocommerce-page #respond input#submit:hover,
.woocommerce #respond input#submit:hover,
.woocommerce-page #content input.button:hover,
.woocommerce #content input.button:hover,
.woocommerce-page .button-icon-holder a:hover,
.woocommerce .button-icon-holder a:hover {
	background:{$pacz_settings['btn-hover']};
}
.related.products h3 span,
.product-subtotal .woocommerce-Price-amount.amount{
	color:{$accent_color};
}
.related.products h3:hover,
.woocommerce-page .cart-header li,
.woocommerce form .cart-header li,
.cart_item li.product-name a{
	color:{$pacz_settings['heading-color']} !important;
}
.listing-main-content .alsp-field .alsp-field-caption .alsp-field-name,
.alsp-fields-group-caption,
.alsp-video-field-name,
.comments-heading-label{
	{$heading_font_family};
	color:{$pacz_settings['heading-color']};
	
}
");

###########################################
# Main Navigation
###########################################

	$nav_text_align = (isset($pacz_settings['nav-alignment']) && !empty($pacz_settings['nav-alignment'])) ? ('text-align:' . $pacz_settings['nav-alignment'] . ';') : ('text-align:left;');

	$main_nav_font_family = (isset($pacz_settings['main-nav-font']['font-family']) && !empty($pacz_settings['main-nav-font']['font-family'])) ? ('font-family:' . $pacz_settings['main-nav-font']['font-family'] . ';') : '';

	if($pacz_settings['header-structure'] == 'vertical'){
		$main_nav_top_level_space = (isset($pacz_settings['main-nav-item-space']) && !empty($pacz_settings['main-nav-item-space']) && isset($pacz_settings['vertical-nav-item-space']) && !empty($pacz_settings['vertical-nav-item-space'])) ? ('padding:'. $pacz_settings['vertical-nav-item-space'] . 'px ' . $pacz_settings['main-nav-item-space'] . 'px;') : ('padding: 9px 15px;');
		$plus_for_submenu = $pacz_settings['main-nav-item-space'] + 10;
		$main_nav_top_level_space_lr = (isset($pacz_settings['main-nav-item-space'])) && !empty($pacz_settings['main-nav-item-space']) ? ('padding: 0 '.$plus_for_submenu .'px ;') : ('padding: 0 15px;');

		$main_nav_top_level_space_bt = isset($pacz_settings['vertical-nav-item-space']) && !empty($pacz_settings['vertical-nav-item-space']) ? ('padding:'. $pacz_settings['vertical-nav-item-space'] . 'px 0;') : ('padding: 9px 0;');

		
	}else{
		$main_nav_top_level_space = (isset($pacz_settings['main-nav-item-space'])) && !empty($pacz_settings['main-nav-item-space']) ? ('padding: 0 ' . $pacz_settings['main-nav-item-space'] . 'px;') : ('padding: auto 17px;');
	}
	

	$main_nav_top_level_font_size = 'font-size:' . $pacz_settings['main-nav-font']['font-size'] . ';';

	$main_nav_top_level_font_transform = (isset($pacz_settings['main-nav-top-transform']) && !empty($pacz_settings['main-nav-top-transform'])) ? ('text-transform: ' . $pacz_settings['main-nav-top-transform'] . ';') : ('text-transform: uppercase;');

	$main_nav_top_level_font_weight = 'font-weight:' . $pacz_settings['main-nav-font']['font-weight'] . ';';

	$main_nav_sub_level_font_size = (isset($pacz_settings['sub-nav-top-size']) && !empty($pacz_settings['sub-nav-top-size'])) ? ('font-size:' . $pacz_settings['sub-nav-top-size'] . 'px;') : ('font-size:' . $pacz_settings['main-nav-font']['font-size'] . 'px;');

	$main_nav_sub_level_font_transform = (isset($pacz_settings['sub-nav-top-transform']) && !empty($pacz_settings['sub-nav-top-transform'])) ? ('text-transform: ' . $pacz_settings['sub-nav-top-transform'] . ';') : ('text-transform: uppercase;');
	
	$main_nav_sub_level_font_weight = (isset($pacz_settings['sub-nav-top-weight']) && !empty($pacz_settings['sub-nav-top-weight'])) ? ('font-weight:' . $pacz_settings['sub-nav-top-weight'] . ';') : ('font-weight:' . $pacz_settings['main-nav-font']['font-weight'] . ';');
	
	$logo_height = (!empty($pacz_settings['logo']['height'])) ? $pacz_settings['logo']['height'] : 50;
	$header_toolbar_height = $logo_height;
	$header_height = ($pacz_settings['header-padding'] * 2) + $logo_height;
	if (isset($pacz_settings['squeeze-sticky-header']) && ($pacz_settings['squeeze-sticky-header'] == 1)) {
		$sticky_logo_height = round($logo_height / 1.2);
		$sticky_header_padding = round($pacz_settings['header-padding'] / 2);
		$header_sticky_height = round($logo_height / 1.2 +(($pacz_settings['header-padding'] / 2) * 2));
	} else {
		$sticky_logo_height = $logo_height;
		$sticky_header_padding = $pacz_settings['header-padding'];
		$header_sticky_height = round($logo_height+(($pacz_settings['header-padding']) * 1));
	}
	$resposive_logo_height = round($logo_height / 1.5);
	$responsive_header_height = ($pacz_settings['header-padding'] * 2) + $resposive_logo_height;
	$header_vertical_width = (isset($pacz_settings['header-vertical-width']) && !empty($pacz_settings['header-vertical-width'])) ? $pacz_settings['header-vertical-width'] : ('280');
	$header_vertical_padding = (isset($pacz_settings['header-padding-vertical']) && !empty($pacz_settings['header-padding-vertical'])) ? $pacz_settings['header-padding-vertical'] : ('30'); 

	$vertical_nav_width = $header_vertical_width - ($header_vertical_padding * 2);
	
	# Header Toolbar
	if($pacz_settings['header-toolbar'] == 1){
		$header_height_with_toolbar = $header_toolbar_height+($pacz_settings['header-padding'] * 2) + 30;
	}else{
		$header_height_with_toolbar = $logo_height+($pacz_settings['header-padding'] * 2);
	}
	$toolbar_border = isset($pacz_settings['toolbar-border-top']) && ($pacz_settings['toolbar-border-top'] == 1) ? '' : 'border:none;';
	$sticky_triger_translate = $header_toolbar_height + 60;
	//$sticky_header_padding_top = $logo_height+($pacz_settings['header-padding'] * 2) +100;
	$header_hover_style1_padding = $pacz_settings['header-padding'] / 1.8;
	if($pacz_settings['header-toolbar'] == 1){
		Classiadspro_Static_Files::addGlobalStyle("
		#pacz-header {
    box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
}
		");
	}
	$header_style = 'transparent';
	if($pacz_settings['header-toolbar'] == 1 && $header_style == 'transparent'){
		Classiadspro_Static_Files::addGlobalStyle("
		#pacz-header.transparent-header{
			top: {$toolbar_height}px;
			
		}
		#pacz-header.transparent-header.sticky-trigger-header {
			top: 0px !important;
			position:fixed !important;
			
		}
		");
	}else{
		$header_height_with_toolbar = $logo_height+($pacz_settings['header-padding'] * 2);
	}
if($pacz_settings['header-logo-location'] == 'header_toolbar' && $pacz_settings['header-align'] == 'left'){
Classiadspro_Static_Files::addGlobalStyle("	
#pacz-header{border:0;}
#pacz-main-navigation{}
#pacz-main-navigation > ul { float: left;}
#pacz-main-navigation > ul li.menu-item { float: left;}
");
}


Classiadspro_Static_Files::addGlobalStyle("
.header-searchform-input input[type=text]{
	background-color:{$pacz_settings['header-bg']['color']};
}

.theme-main-wrapper:not(.vertical-header) .sticky-header.sticky-header-padding {
	
}
body:not(.vertical-header).sticky--header-padding .sticky-header-padding.sticky-header {
	
}

.bottom-header-padding.none-sticky-header {
	padding-top:{$header_height}px;	
}

.bottom-header-padding.none-sticky-header {
	padding-top:{$header_height}px;	
}
.single-listing .modal-dialog {
	margin-top:{$header_height}px;	
}
.bottom-header-padding.sticky-header {
	padding-top:{$header_sticky_height}px;	
}
.listing-btn{
	display:inline-block;
	
	}
");
if($pacz_settings['preset_headers'] != 12){
Classiadspro_Static_Files::addGlobalStyle("
#pacz-header:not(.header-structure-vertical) #pacz-main-navigation > ul > li.menu-item,
#pacz-header:not(.header-structure-vertical) #pacz-main-navigation > ul > li.menu-item > a,
#pacz-header:not(.header-structure-vertical) .pacz-header-search,
#pacz-header:not(.header-structure-vertical) .pacz-header-search a,
#pacz-header:not(.header-structure-vertical) .pacz-header-wpml-ls,
#pacz-header:not(.header-structure-vertical) .pacz-header-wpml-ls a,
#pacz-header:not(.header-structure-vertical) .pacz-shopping-cart,
#pacz-header:not(.header-structure-vertical) .pacz-responsive-cart-link,
#pacz-header:not(.header-structure-vertical) .dashboard-trigger,
#pacz-header:not(.header-structure-vertical) .pacz-header-social,
#pacz-header:not(.header-structure-vertical) .pacz-margin-header-burger,
#pacz-header:not(.header-structure-vertical) .listing-btn,
#pacz-header:not(.header-structure-vertical) .logreg-header
{
	height:{$header_height}px;
	line-height:{$header_height}px;
}
");
}
if($pacz_settings['preset_headers'] == 12){
	Classiadspro_Static_Files::addGlobalStyle("
	#pacz-header:not(.header-structure-vertical){
		padding-top:25px;
		padding-bottom:25px;
	}
	.classiads-fantro-logo{
		min-height:1px;
	}
	.pacz-header-logo{
		margin:0 !important;
		position:absolute;
		top:50%;
		left:0;
		transform:translateY(-50%);
	}
	.logreg-header .dropdown{
		margin-top:-10px;
	}
	.logreg-header .dropdown .author-nicename{
		display:none;
	}
	.logreg-header .dropdown .author-displayname {
		font-size: 14px;
	}
	.search-form-style-header1 .listing-btn{float:right;}
	.search-form-style-header1 .listing-btn .listing-header-btn{
		font-size:14px;
		min-width:150px;
		line-height:45px;
		min-height:45px;
		border-radius:5px;
		margin-left:15px;
		margin-top:1px;
	}
");
}
Classiadspro_Static_Files::addGlobalStyle("
#pacz-header:not(.header-structure-vertical).sticky-trigger-header #pacz-main-navigation > ul > li.menu-item,
#pacz-header:not(.header-structure-vertical).sticky-trigger-header #pacz-main-navigation > ul > li.menu-item > a,
#pacz-header:not(.header-structure-vertical).sticky-trigger-header .pacz-header-search,
#pacz-header:not(.header-structure-vertical).sticky-trigger-header .pacz-header-search a,
#pacz-header:not(.header-structure-vertical).sticky-trigger-header .pacz-shopping-cart,
#pacz-header:not(.header-structure-vertical).sticky-trigger-header .pacz-responsive-cart-link,
#pacz-header:not(.header-structure-vertical).sticky-trigger-header .dashboard-trigger,
#pacz-header:not(.header-structure-vertical).sticky-trigger-header .pacz-header-social,
#pacz-header:not(.header-structure-vertical).sticky-trigger-header .pacz-margin-header-burger,
#pacz-header:not(.header-structure-vertical).sticky-trigger-header .pacz-header-wpml-ls,
#pacz-header:not(.header-structure-vertical).sticky-trigger-header .pacz-header-wpml-ls a,
#pacz-header:not(.header-structure-vertical).sticky-trigger-header .listing-btn 
{
	height:{$header_sticky_height}px;
	line-height:{$header_sticky_height}px;
}
#pacz-header:not(.header-structure-vertical).header-style-v12.sticky-trigger-header #pacz-main-navigation > ul > li.menu-item,
#pacz-header:not(.header-structure-vertical).header-style-v12.sticky-trigger-header #pacz-main-navigation > ul > li.menu-item > a,
#pacz-header:not(.header-structure-vertical).header-style-v12.sticky-trigger-header .pacz-header-search,
#pacz-header:not(.header-structure-vertical).header-style-v12.sticky-trigger-header .pacz-header-search a,
#pacz-header:not(.header-structure-vertical).header-style-v12.sticky-trigger-header .pacz-shopping-cart,
#pacz-header:not(.header-structure-vertical).header-style-v12.sticky-trigger-header .pacz-responsive-cart-link,
#pacz-header:not(.header-structure-vertical).header-style-v12.sticky-trigger-header .dashboard-trigger,
#pacz-header:not(.header-structure-vertical).header-style-v12.sticky-trigger-header .pacz-header-social,
#pacz-header:not(.header-structure-vertical).header-style-v12.sticky-trigger-header .pacz-margin-header-burger,
#pacz-header:not(.header-structure-vertical).header-style-v12.sticky-trigger-header .pacz-header-wpml-ls,
#pacz-header:not(.header-structure-vertical).header-style-v12.sticky-trigger-header .pacz-header-wpml-ls a,
#pacz-header:not(.header-structure-vertical).header-style-v12.sticky-trigger-header .listing-btn 
{
	height:auto;
	line-height:inherit;
}
.main-navigation-ul a.pacz-login-2,
.main-navigation-ul a.pacz-logout-2,
.main-navigation-ul a.pacz-register-2{
	line-height:{$header_height}px;
	color:{$pacz_settings['main-nav-top-color']['regular']};
	background-color:{$pacz_settings['main-nav-top-color']['bg']};
	
}
.main-navigation-ul a.pacz-login-2:hover,
.main-navigation-ul a.pacz-logout-2:hover,
.main-navigation-ul a.pacz-register-2:hover{
	line-height:{$header_height}px;
	color:{$pacz_settings['main-nav-top-color']['hover']};
	background-color:{$pacz_settings['main-nav-top-color']['bg-hover']};
	
}
.pacz-burger-icon i{
	color:{$accent_color};
}
");

	if (isset($pacz_settings['squeeze-sticky-header']) && ($pacz_settings['squeeze-sticky-header'])) {
		Classiadspro_Static_Files::addGlobalStyle("
	#pacz-header:not(.header-structure-vertical).sticky-trigger-header #pacz-main-navigation > ul > li.menu-item > a {
		padding-left:15px;
		padding-right:15px;
	}
	");
	}

	Classiadspro_Static_Files::addGlobalStyle(".pacz-header-logo,
.pacz-header-logo a{
	height:{$logo_height}px;
	line-height:{$logo_height}px;
}

#pacz-header:not(.header-structure-vertical).sticky-trigger-header .pacz-header-logo,
#pacz-header:not(.header-structure-vertical).sticky-trigger-header .pacz-header-logo a{
	height:{$sticky_logo_height}px;
	line-height:{$sticky_logo_height}px;
}

.vertical-expanded-state #pacz-header.header-structure-vertical,
.vertical-condensed-state  #pacz-header.header-structure-vertical:hover{
	width: {$header_vertical_width}px !important;
}

#pacz-header.header-structure-vertical{
	padding-left: {$header_vertical_padding}px !important;
	padding-right: {$header_vertical_padding}px !important;
}

.vertical-condensed-state .pacz-vertical-menu {
  width:{$vertical_nav_width}px;
}


.theme-main-wrapper.vertical-expanded-state #theme-page > .pacz-main-wrapper-holder,
.theme-main-wrapper.vertical-expanded-state #theme-page > .pacz-page-section,
.theme-main-wrapper.vertical-expanded-state #theme-page > .wpb_row,
.theme-main-wrapper.vertical-expanded-state #pacz-page-title,
.theme-main-wrapper.vertical-expanded-state #pacz-footer {
	padding-left: {$header_vertical_width}px;
}

@media handheld, only screen and (max-width:{$pacz_settings['res-nav-width']}px) {
	.theme-main-wrapper.vertical-expanded-state #theme-page > .pacz-main-wrapper-holder,
	.theme-main-wrapper.vertical-expanded-state #theme-page > .pacz-page-section,
	.theme-main-wrapper.vertical-expanded-state #theme-page > .wpb_row,
	.theme-main-wrapper.vertical-expanded-state #pacz-page-title,
	.theme-main-wrapper.vertical-expanded-state #pacz-footer,
	.theme-main-wrapper.vertical-condensed-state #theme-page > .pacz-main-wrapper-holder,
	.theme-main-wrapper.vertical-condensed-state #theme-page > .pacz-page-section,
	.theme-main-wrapper.vertical-condensed-state #theme-page > .wpb_row,
	.theme-main-wrapper.vertical-condensed-state #pacz-page-title,
	.theme-main-wrapper.vertical-condensed-state #pacz-footer {
		padding-left: 0px;
	}
	.pacz-header-logo{
	height:{$resposive_logo_height}px;
	line-height:{$resposive_logo_height}px;
	margin-top: 0px !important;
	margin-bottom: 0px !important;
	position:absolute;
	right:0;
	top:50%;
	transform:translateY(-50%);
	display:inline-block;
}

.pacz-header-logo a{
	height:{$resposive_logo_height}px;
	line-height:{$resposive_logo_height}px;
	margin-top: 0px !important;
	margin-bottom: 0px !important;
}

	
}

.theme-main-wrapper.vertical-header #pacz-page-title,
.theme-main-wrapper.vertical-header #pacz-footer,
.theme-main-wrapper.vertical-header #pacz-header,
.theme-main-wrapper.vertical-header #pacz-header.header-structure-vertical .pacz-vertical-menu{
	box-sizing: border-box;
}


@media handheld, only screen and (min-width:{$pacz_settings['res-nav-width']}px) {
	.vertical-condensed-state #pacz-header.header-structure-vertical:hover ~ #theme-page > .pacz-main-wrapper-holder,
	.vertical-condensed-state #pacz-header.header-structure-vertical:hover ~ #theme-page > .pacz-page-section,
	.vertical-condensed-state #pacz-header.header-structure-vertical:hover ~ #theme-page > .wpb_row,
	.vertical-condensed-state #pacz-header.header-structure-vertical:hover ~ #pacz-page-title,
	.vertical-condensed-state #pacz-header.header-structure-vertical:hover ~ #pacz-footer {
		padding-left: {$header_vertical_width}px ;
	}
}

.pacz-header-logo
 {
	margin-top: {$pacz_settings['header-padding']}px;
	margin-bottom: {$pacz_settings['header-padding']}px;
}


#pacz-header:not(.header-structure-vertical).sticky-trigger-header .pacz-header-logo,
#pacz-header:not(.header-structure-vertical).sticky-trigger-header .pacz-header-logo a
{
	margin-top:{$sticky_header_padding}px;
	margin-bottom: {$sticky_header_padding}px;
}


#pacz-main-navigation > ul > li.menu-item > a {
	{$main_nav_top_level_space}
	{$main_nav_font_family}
	{$main_nav_top_level_font_size}
	{$main_nav_top_level_font_transform}
	{$main_nav_top_level_font_weight}
}

.pacz-header-logo.pacz-header-logo-center {
	{$main_nav_top_level_space}
}

.pacz-vertical-menu > li.menu-item > a {
	{$main_nav_top_level_space}
	{$main_nav_font_family}
	{$main_nav_top_level_font_size}
	{$main_nav_top_level_font_transform}
	{$main_nav_top_level_font_weight}
}
");

	if ($pacz_settings['header-structure'] == 'vertical') {
		Classiadspro_Static_Files::addGlobalStyle("
	.header-structure-vertical .pacz-vertical-menu > .menu-item > .sub-menu {
		{$main_nav_top_level_space_lr}
	}
	");
	}

	Classiadspro_Static_Files::addGlobalStyle("


.pacz-vertical-menu li.menu-item > a,
.pacz-vertical-menu .pacz-header-logo {
	{$nav_text_align} 
}

.main-navigation-ul > li ul.sub-menu li.menu-item a.menu-item-link{
	{$main_nav_sub_level_font_size}
	{$main_nav_sub_level_font_transform}
	{$main_nav_sub_level_font_weight}
}

.pacz-vertical-menu > li ul.sub-menu li.menu-item a{
	{$main_nav_sub_level_font_size}
	{$main_nav_sub_level_font_transform}
	{$main_nav_sub_level_font_weight}
}

#pacz-main-navigation > ul > li.menu-item > a,
.pacz-vertical-menu li.menu-item > a
{
	color:{$pacz_settings['main-nav-top-color']['regular']};
	background-color:{$pacz_settings['main-nav-top-color']['bg']};
}

#pacz-main-navigation > ul > li.current-menu-item > a,
#pacz-main-navigation > ul > li.current-menu-ancestor > a,
#pacz-main-navigation > ul > li.menu-item:hover > a
{
	color:{$pacz_settings['main-nav-top-color']['hover']};
	background-color:{$pacz_settings['main-nav-top-color']['bg-hover']};
}
.header-hover-style-1 .nav-hover-style1{
	bottom: {$pacz_settings['header-padding']}px;
    left: 0;
    line-height: 2px !important;
    margin: 0 -1.5px;
    position: absolute;
    right: 0;
}

.header-hover-style-1.sticky-trigger-header .nav-hover-style1{
	bottom: {$header_hover_style1_padding}px;
}

.header-hover-style-1 .nav-hover-style1 span{margin:0 1.5px;display:inline-block;width:8px;height:2px;background:{$pacz_settings['main-nav-top-color']['hover']};}
.header-hover-style-1 .sub-menu .nav-hover-style1{display:none;}
.pacz-vertical-menu > li.current-menu-item > a,
.pacz-vertical-menu > li.current-menu-ancestor > a,
.pacz-vertical-menu > li.menu-item:hover > a,
.pacz-vertical-menu ul li.menu-item:hover > a {
	color:{$pacz_settings['main-nav-top-color']['hover']};
}



#pacz-main-navigation > ul > li.menu-item > a:hover
{
	color:{$pacz_settings['main-nav-top-color']['hover']};
	background-color:{$pacz_settings['main-nav-top-color']['bg-hover']};
}

.dashboard-trigger,
.res-nav-active,
.pacz-responsive-cart-link {
	color:{$pacz_settings['main-nav-top-color']['regular']};
}

.dashboard-trigger:hover,
.res-nav-active:hover {
	color:{$pacz_settings['main-nav-top-color']['hover']};
}");

if (isset($pacz_settings['navigation-border-top']) && ($pacz_settings['navigation-border-top'] == 1)) {
		Classiadspro_Static_Files::addGlobalStyle("
		#pacz-main-navigation ul li.no-mega-menu > ul,
		#pacz-main-navigation ul li.has-mega-menu > ul,
		#pacz-main-navigation ul li.pacz-header-wpml-ls > ul{
			border-top:1px solid {$accent_color};
		}");
}


Classiadspro_Static_Files::addGlobalStyle("#pacz-main-navigation ul li.no-mega-menu ul,
#pacz-main-navigation > ul > li.has-mega-menu > ul,
.header-searchform-input .ui-autocomplete,
.pacz-shopping-box,
.shopping-box-header > span,
#pacz-main-navigation ul li.pacz-header-wpml-ls > ul {
	background-color:{$pacz_settings['main-nav-sub-bg']};
}

#pacz-main-navigation ul ul.sub-menu a.menu-item-link,
#pacz-main-navigation ul li.pacz-header-wpml-ls > ul li a
{
	color:{$pacz_settings['main-nav-sub-color']['regular']};
}

#pacz-main-navigation ul ul li.current-menu-item > a.menu-item-link,
#pacz-main-navigation ul ul li.current-menu-ancestor > a.menu-item-link {
	color:{$pacz_settings['main-nav-sub-color']['hover']};
	background-color:{$pacz_settings['main-nav-sub-color']['bg-active']} !important;
}


.header-searchform-input .ui-autocomplete .search-title,
.header-searchform-input .ui-autocomplete .search-date,
.header-searchform-input .ui-autocomplete i
{
	color:{$pacz_settings['main-nav-sub-color']['regular']};
}
.header-searchform-input .ui-autocomplete i,
.header-searchform-input .ui-autocomplete img
{
	border-color:{$pacz_settings['main-nav-sub-color']['regular']};
}

.header-searchform-input .ui-autocomplete li:hover  i,
.header-searchform-input .ui-autocomplete li:hover img
{
	border-color:{$pacz_settings['main-nav-sub-color']['hover']};
}


#pacz-main-navigation .megamenu-title,
.pacz-mega-icon,
.pacz-shopping-box .mini-cart-title,
.pacz-shopping-box .mini-cart-button {
	color:{$pacz_settings['main-nav-sub-color']['regular']};
}

#pacz-main-navigation ul ul.sub-menu a.menu-item-link:hover,
.header-searchform-input .ui-autocomplete li:hover,
#pacz-main-navigation ul li.pacz-header-wpml-ls > ul li a:hover
{
	color:{$pacz_settings['main-nav-sub-color']['hover']};
	background-color:{$pacz_settings['main-nav-sub-color']['bg-hover']} !important;
}

.header-searchform-input .ui-autocomplete li:hover .search-title,
.header-searchform-input .ui-autocomplete li:hover .search-date,
.header-searchform-input .ui-autocomplete li:hover i,
#pacz-main-navigation ul ul.sub-menu a.menu-item-link:hover i
{
	color:{$pacz_settings['main-nav-sub-color']['hover']};
}


.header-searchform-input input[type=text],
.dashboard-trigger,
.header-search-icon,
.header-search-close,
.header-wpml-icon
{
	color:{$pacz_settings['main-nav-top-color']['regular']};
}");

$header_search_icon_color = (isset($pacz_settings['header-search-icon-color']) && !empty($pacz_settings['header-search-icon-color'])) ? $pacz_settings['header-search-icon-color'] : $pacz_settings['main-nav-top-color']['regular'];

Classiadspro_Static_Files::addGlobalStyle("
.header-search-icon {
	color:{$header_search_icon_color};	
}

.pacz-burger-icon div {
      background-color:{$pacz_settings['main-nav-top-color']['regular']};
 }



.header-search-icon:hover
{
	color: {$pacz_settings['main-nav-top-color']['regular']};
}


.responsive-nav-container, .responsive-shopping-box
{
	background-color:{$pacz_settings['main-nav-sub-bg']};
}

.pacz-responsive-nav a,
.pacz-responsive-nav .has-mega-menu .megamenu-title
{
	color:#fff;
	background-color:{$pacz_settings['main-nav-sub-color']['bg']};
}

.pacz-responsive-nav li a:hover
{
	color:{$pacz_settings['main-nav-sub-color']['hover']};
	background-color:{$pacz_settings['main-nav-sub-color']['bg-hover']};
}");

$header_border_bottom_color = (isset($pacz_settings['toolbar-border-bottom-color']) && !empty($pacz_settings['toolbar-border-bottom-color'])) ? $pacz_settings['toolbar-border-bottom-color'] : 'transparent';
$header_phone_email_icon_color = (isset($pacz_settings['toolbar-phone-email-icon-color']) && !empty($pacz_settings['toolbar-phone-email-icon-color'])) ? $pacz_settings['toolbar-phone-email-icon-color'] : $pacz_settings['toolbar-text-color'];
if(isset($pacz_settings['toolbar-grid']) && $pacz_settings['toolbar-grid'] == 1){
Classiadspro_Static_Files::addGlobalStyle("
.pacz-header-toolbar {
	padding-left:50px;
	padding-right:50px;
}
");	
}

$social_link_bg = (isset($pacz_settings['toolbar-social-link-color-bg']['rgba'])) ? $pacz_settings['toolbar-social-link-color-bg']['rgba'] : '';
$social_link_bg_hover = (isset($pacz_settings['toolbar-social-link-color']['bg-hover'])) ? $pacz_settings['toolbar-social-link-color']['bg-hover'] : '';
Classiadspro_Static_Files::addGlobalStyle("
.pacz-header-toolbar {
	{$toolbar_border}	
	
	border-color:{$header_border_bottom_color};
}
.pacz-header-toolbar span {
	color:{$pacz_settings['toolbar-text-color']};	
}

.pacz-header-toolbar span i {
	color:{$header_phone_email_icon_color};	
}

.pacz-header-toolbar a{
	color:{$pacz_settings['toolbar-link-color']['regular']};	
}
.pacz-header-toolbar a:hover{
	color:{$pacz_settings['toolbar-link-color']['hover']};	
}

.pacz-header-toolbar a{
	color:{$pacz_settings['toolbar-link-color']['regular']};	
}
.pacz-header-toolbar .pacz-header-toolbar-social li a,
.pacz-header-social a,
.pacz-cart-link{
	color:{$pacz_settings['toolbar-social-link-color']['regular']} !important;	
	background-color:{$social_link_bg};	
}
.pacz-header-toolbar .pacz-header-toolbar-social li a:hover,
.pacz-header-social a:hover,
.pacz-cart-link:hover{
	color:{$pacz_settings['toolbar-social-link-color']['hover']} !important;
	background-color:{$social_link_bg_hover};	
}

");

###########################################
	# Responsive Mode
	###########################################

	$grid_width_100 = $pacz_settings['grid-width']+100;

	Classiadspro_Static_Files::addGlobalStyle("

@media handheld, only screen and (max-width: {$grid_width_100}px)
{

.dashboard-trigger.res-mode {
	display:block !important;
}

.dashboard-trigger.desktop-mode {
	display:none !important;
}

}



@media handheld, only screen and (max-width: {$pacz_settings['res-nav-width']}px)
{

#pacz-header.sticky-header,
.pacz-secondary-header,
.transparent-header-sticky {
	position: relative !important;
	left:auto !important;
    right:auto!important;
    top:auto !important;
}

#pacz-header:not(.header-structure-vertical).put-header-bottom,
#pacz-header:not(.header-structure-vertical).put-header-bottom.sticky-trigger-header,
#pacz-header:not(.header-structure-vertical).put-header-bottom.header-offset-passed,
.admin-bar #pacz-header:not(.header-structure-vertical).put-header-bottom.sticky-trigger-header {
	position:relative;
	bottom:auto;
}

.pacz-margin-header-burger {
	display:none;
}

.main-navigation-ul li.menu-item,
.pacz-vertical-menu li.menu-item,
.main-navigation-ul li.sub-menu,
.sticky-header-padding,
.secondary-header-space
{
	display:none !important;
}

.vertical-expanded-state #pacz-header.header-structure-vertical, .vertical-condensed-state #pacz-header.header-structure-vertical{
	width: 100% !important;
	height: auto !important;
}
.vertical-condensed-state  #pacz-header.header-structure-vertical:hover {
	width: 100% !important;
}
.header-structure-vertical .pacz-vertical-menu{
	position:relative;
	padding:0;
	width: 100%;
}
.header-structure-vertical .pacz-header-social.inside-grid{
	position:relative;
	padding:0;
	width: auto;
	bottom: inherit !important;
	height:{$header_height}px;
	line-height:{$header_height}px;
	float:right !important;
	top: 0 !important;
}
/*
.pacz-header-logo, .pacz-header-logo a {
	height:80px;
	line-height:80px;
}
#menu-main-navigation .pacz-header-logo {
	margin-bottom:20px;
	
}
.pacz-vertical-menu .responsive-nav-link {
	height:120px !important;
}
.pacz-vertical-header-burger {
	display:none!important;
}

.header-structure-vertical .pacz-header-social.inside-grid {
	height:120px;
	line-height:120px;
}
*/

.vertical-condensed-state .header-structure-vertical .pacz-vertical-menu>li.pacz-header-logo {
	-webkit-transform: translate(0,0);
	-moz-transform: translate(0,0);
	-ms-transform: translate(0,0);
	-o-transform: translate(0,0);
	opacity: 1!important;
	position: relative!important;
	left: 0!important;
}
.vertical-condensed-state .header-structure-vertical .pacz-vertical-header-burger{
	opacity:0 !important;
}


.pacz-header-logo {
	padding:0 !important;
}

.pacz-vertical-menu .responsive-nav-link{
	float:left !important;
	height:{$header_height}px;
}
.pacz-vertical-menu .responsive-nav-link i{
	height:{$header_height}px;
	line-height:{$header_height}px;
}
.pacz-vertical-menu .pacz-header-logo {
	float:left !important
}


.header-search-icon i,
.pacz-cart-link i,
.pacz-responsive-cart-link i
{
	padding:0 !important;
	margin:0 !important;
	border:none !important;
}

.header-search-icon,
.pacz-cart-link,
.pacz-responsive-cart-link
{
	margin:0 8px !important;
	padding:0 !important;
}


.pacz-header-logo
{

	margin-left:20px !important;
	display:inline-block !important;
}


.main-navigation-ul
{
	text-align:center !important;
}

.responsive-nav-link {
	display:inline-block !important;
}

.pacz-shopping-box {
	display:none !important;
}
.pacz-shopping-cart{
	display:none !important;
}
.pacz-responsive-shopping-cart{
	display: inline-block !important;
}

}


#pacz-header.transparent-header {
  position: absolute;
  left: 0;
}

.pacz-boxed-enabled #pacz-header.transparent-header {
  left: inherit;
}

.add-corner-margin .pacz-boxed-enabled #pacz-header.transparent-header {
  left: 0;
}

.transparent-header {
  transition: all 0.3s ease-in-out;
  -webkit-transition: all 0.3s ease-in-out;
  -moz-transition: all 0.3s ease-in-out;
  -ms-transition: all 0.3s ease-in-out;
  -o-transition: all 0.3s ease-in-out;
}

.transparent-header.transparent-header-sticky {
  opacity: 1;
  left: auto !important;
}
.transparent-header #pacz-main-navigation ul li .sub {
  border-top: none;
}
.transparent-header .pacz-cart-link:hover,
.transparent-header .pacz-responsive-cart-link:hover,
.transparent-header .dashboard-trigger:hover,
.transparent-header .res-nav-active:hover,
.transparent-header .header-search-icon:hover {
  opacity: 0.7;
}
.transparent-header .header-searchform-input input[type=text] {
  background-color: transparent;
}
.transparent-header.light-header-skin .dashboard-trigger,
.transparent-header.light-header-skin .dashboard-trigger:hover,
.transparent-header.light-header-skin .res-nav-active,
.transparent-header.light-header-skin #pacz-main-navigation > ul > li.menu-item > a,
.transparent-header.light-header-skin #pacz-main-navigation > ul > li.current-menu-item > a,
.transparent-header.light-header-skin #pacz-main-navigation > ul > li.current-menu-ancestor > a,
.transparent-header.light-header-skin #pacz-main-navigation > ul > li.menu-item:hover > a,
.transparent-header.light-header-skin #pacz-main-navigation > ul > li.menu-item > a:hover,
.transparent-header.light-header-skin .res-nav-active:hover,
.transparent-header.light-header-skin .header-searchform-input input[type=text],
.transparent-header.light-header-skin .header-search-icon,
.transparent-header.light-header-skin .header-search-close,
.transparent-header.light-header-skin .header-search-icon:hover,
.transparent-header.light-header-skin .pacz-cart-link,
.transparent-header.light-header-skin .pacz-responsive-cart-link,
.transparent-header.light-header-skin .pacz-header-social a,
.transparent-header.light-header-skin .pacz-header-wpml-ls a{
  color: #fff !important;
}
.transparent-header.light-header-skin .pacz-burger-icon div {
  background-color: #fff;
}
.transparent-header.light-header-skin .pacz-light-logo {
  display: inline-block !important;
}
.transparent-header.light-header-skin .pacz-dark-logo {
  
}
.transparent-header.light-header-skin.transparent-header-sticky .pacz-light-logo {
  display: none !important;
}
.transparent-header.light-header-skin.transparent-header-sticky .pacz-dark-logo {
  display: inline-block !important;
}
.transparent-header.dark-header-skin .dashboard-trigger,
.transparent-header.dark-header-skin .dashboard-trigger:hover,
.transparent-header.dark-header-skin .res-nav-active,
.transparent-header.dark-header-skin #pacz-main-navigation > ul > li.menu-item > a,
.transparent-header.dark-header-skin #pacz-main-navigation > ul > li.current-menu-item > a,
.transparent-header.dark-header-skin #pacz-main-navigation > ul > li.current-menu-ancestor > a,
.transparent-header.dark-header-skin #pacz-main-navigation > ul > li.menu-item:hover > a,
.transparent-header.dark-header-skin #pacz-main-navigation > ul > li.menu-item > a:hover,
.transparent-header.dark-header-skin .res-nav-active:hover,
.transparent-header.dark-header-skin .header-searchform-input input[type=text],
.transparent-header.dark-header-skin .header-search-icon,
.transparent-header.dark-header-skin .header-search-close,
.transparent-header.dark-header-skin .header-search-icon:hover,
.transparent-header.dark-header-skin .pacz-cart-link,
.transparent-header.dark-header-skin .pacz-responsive-cart-link,
.transparent-header.dark-header-skin .pacz-header-social a,
.transparent-header.dark-header-skin .pacz-header-wpml-ls a {
  
}
.transparent-header.dark-header-skin .pacz-burger-icon div {
  
}



");

	###########################################
	# Accent Color
	###########################################


	Classiadspro_Static_Files::addGlobalStyle("
.pacz-skin-color,
.blog-categories a:hover,
.blog-categories,
.rating-star .rated,
.widget_testimonials .testimonial-position,
.entry-meta .cats a,
.search-meta span a,
.blog-meta time a,
.entry-meta time a,
.entry-meta .entry-categories a,
.blog-author span,
.search-meta span,
.single-share-trigger:hover,
.single-share-trigger.pacz-toggle-active,
.project_content_section .project_cats a,
.pacz-love-holder i:hover,
.blog-comments span,
.comment-count i:hover,
.widget_posts_lists li .cats a,
.pacz-tweet-shortcode span a,
.pacz-pricing-table .pacz-icon-star,
.pacz-process-steps.dark-skin .step-icon,
.pacz-sharp-next,
.pacz-sharp-prev,
.prev-item-caption,
.next-item-caption,
.pacz-employees.column_rounded-style .team-member-position, 
.pacz-employees.column-style .team-member-position,
.pacz-employees .team-info-wrapper .team-member-position,
.pacz-event-countdown.accent-skin .countdown-timer,
.pacz-event-countdown.accent-skin .countdown-text,
.pacz-box-text:hover i,
.pacz-process-steps.light-skin .pacz-step:hover .step-icon,
.pacz-process-steps.light-skin .active-step-item .step-icon,
.blog-tile-entry time a,
.woocommerce-thanks-text,
#login-register-password .userid:before,
#login-register-password .userpass:before,
#login-register-password .useremail:before,
#login-register-password .userfname:before,
#login-register-password .userlname:before,
.radio-check-item:before,
.reg-page-link a,
.td_listings_id span.pacz-fic4-bookmark-white,
.td_listings_options .dropdown .dropdown-menu a span,
.comments_numbers
{
	color: {$accent_color};
}

.form-inner input.user-submit,
.alsp-advanced-search-label{
	background: {$accent_color} ;
	color:#fff;
}
.form-inner input.user-submit:hover{
	background: {$pacz_settings['btn-hover']} ;
	color:#fff;
}
.author-btns a{
	background: {$accent_color} ;
}

.author-btns a:hover{
	background: {$pacz_settings['btn-hover']} ;
}
.widget_author .author-btns.style2 a{
	color: {$pacz_settings['body-txt-color']} !important ;
}
.widget_author .author-btns.style2 a:hover{
	background: {$pacz_settings['btn-hover']} ;
	border-color: {$pacz_settings['btn-hover']} ;
	color:#fff !important;
}
.author-phone.style2 a{
	background: {$accent_color} ;
	color:#fff !important;
}
.author-phone.style2 a i{
	color:#fff !important;
}
.single-listing  .alsp-field-output-block-checkbox .alsp-field-content li:before{
	color: {$accent_color} ;
}
.blog-thumb-entry .blog-thumb-content .blog-thumb-content-inner a.blog-readmore:hover:before,
.blog-thumb-entry.two-column  .blog-thumb-content .blog-thumb-metas:before{
	background: {$accent_color} ;
}
.pacz-employeee-networks li a:hover {
	background: {$accent_color} ;
	border-color: {$accent_color} !important;
	
}
.pacz-testimonial.creative-style .slide{
	
	
}
.pacz-testimonial.boxed-style .testimonial-content{
	border-bottom:2px solid {$accent_color} !important;
	
}
.pacz-testimonial.modern-style .slide{
	
	
}
.testimonial3-style .owl-dot.active span,
.testimonial4-style .owl-dot.active span{background: {$accent_color} !important;}
.pacz-testimonial.modern-style .slide .author-details .testimonial-position,
.pacz-testimonial.modern-style .slide .author-details .testimonial-company{
	color: {$accent_color} !important;
	
}
.pacz-love-holder .item-loved i,
.widget_posts_lists .cats a,
#pacz-breadcrumbs a:hover,
.widget_social_networks a.light,
.widget_posts_tabs .cats a {
	color: {$accent_color} !important;
}

a:hover,
.pacz-tweet-shortcode span a:hover {
	color:{$pacz_settings['link-color']['hover']};
}



/* Main Skin Color : Background-color Property */
#wp-calendar td#today,
div.jp-play-bar,
.pacz-header-button:hover,
.next-prev-top .go-to-top:hover,
.masonry-border,
.author-social li a:hover,
.slideshow-swiper-arrows:hover,
.pacz-clients-shortcode .clients-info,
.pacz-contact-form-wrapper .pacz-form-row i.input-focused,
.pacz-login-form .form-row i.input-focused,
.comment-form-row i.input-focused,
.widget_social_networks a:hover,
.pacz-social-network a:hover,
.blog-masonry-entry .post-type-icon:hover,
.list-posttype-col .post-type-icon:hover,
.single-type-icon,
.demo_store,
.add_to_cart_button:hover,
.pacz-process-steps.dark-skin .pacz-step:hover .step-icon,
.pacz-process-steps.dark-skin .active-step-item .step-icon,
.pacz-process-steps.light-skin .step-icon,
.pacz-social-network a.light:hover,
.widget_tag_cloud a:hover,
.widget_categories a:hover,
.sharp-nav-bg,
.gform_wrapper .button:hover,
.pacz-event-countdown.accent-skin li:before,
.masonry-border,
.pacz-gallery.thumb-style .gallery-thumb-lightbox:hover,
.fancybox-close:hover,
.fancybox-nav span:hover,
.blog-scroller-arrows:hover,
ul.user-login li a i,
.pacz-isotop-filter ul li a.current,
.pacz-isotop-filter ul li a:hover
{
	border-color: {$accent_color};
	color: {$accent_color};
}




::-webkit-selection
{
	background-color: {$accent_color};
	color:#fff;
}

::-moz-selection
{
	background-color: {$accent_color};
	color:#fff;
}

::selection
{
	background-color: {$accent_color};
	color:#fff;
}

.next-prev-top .go-to-top,
.pacz-contact-form-wrapper .text-input:focus, .pacz-contact-form-wrapper .pacz-textarea:focus,
.widget .pacz-contact-form-wrapper .text-input:focus, .widget .pacz-contact-form-wrapper .pacz-textarea:focus,
.pacz-contact-form-wrapper .pacz-form-row i.input-focused,
.comment-form-row .text-input:focus, .comment-textarea textarea:focus,
.comment-form-row i.input-focused,
.pacz-login-form .form-row i.input-focused,
.pacz-login-form .form-row input:focus,
.pacz-event-countdown.accent-skin li
{
	border-color: {$accent_color}!important;
}
.pacz-go-top {background-color:{$pacz_settings['btn-hover']};}

#wpadminbar {
  
}
.listing-post-style-10 .listing-rating.grid-rating .rating-numbers,
.listing-post-style-14 .listing-rating.grid-rating .rating-numbers,
.listing-post-style-listview_ultra .listing-rating.grid-rating .rating-numbers{
	background-color:{$accent_color};
}
");


if (isset($pacz_settings['sub-footer-border-top']) && ($pacz_settings['sub-footer-border-top'] == 1)) {
	$subfooter_border_top_color = (isset($pacz_settings['sub-footer-border-top-color']['rgba']))? $pacz_settings['sub-footer-border-top-color']['rgba'] : '';
	Classiadspro_Static_Files::addGlobalStyle("
	#sub-footer .pacz-grid{
		border-top:1px solid {$subfooter_border_top_color};
	}");
}


###########################################
	# Accent Color
	###########################################
	
	Classiadspro_Static_Files::addGlobalStyle("
.dynamic-btn{
		background-color:{$accent_color} !important;
		border-color:{$accent_color} !important;
		color:#fff !important;
	}
.dynamic-btn:hover{
		background-color:{$btn_hover} !important;
		border-color:{$btn_hover} !important;
		color:#fff !important;
	}
	
	
	
	
	
	");
###########################################
# MISC
###########################################

	Classiadspro_Static_Files::addGlobalStyle("

.pacz-divider .divider-inner i
{
	background-color: {$pacz_settings['page-bg']['color']};
}

.pacz-loader
{
	border: 2px solid {$accent_color};
}
.progress-bar.bar .bar-tip {
	color:{$accent_color};
	
}
.custom-color-heading{
	color:{$accent_color};
	
}

.alt-title span,
.single-post-fancy-title span,
.woocommerce-share ul
{
	
}

.pacz-box-icon .pacz-button-btn a.pacz-button:hover {
	background-color:{$accent_color};
	border-color:{$accent_color};
}


 
.ls-btn1:hover{
	color:{$accent_color} !important;
}
.pacz-commentlist li .comment-author a{
	font-weight:400 !important;
	color:{$pacz_settings['heading-color']} !important;
	{$heading_font_family}
}
.pacz-commentlist li .comment-reply a {
	background-color:{$accent_color} !important;
}
.pacz-commentlist li .comment-reply a:hover{
	color:{$accent_color} !important;
}
.form-submit #submit {
  color:#fff;
  background-color:{$accent_color};
}
.form-submit #submit:hover {
  background-color:{$pacz_settings['btn-hover']};
}

.pacz-pagination .current-page,
.pacz-pagination .page-number:hover,
.pacz-pagination .current-page:hover {
    background-color:{$accent_color} !important;
	border-color:{$accent_color} !important;
	color:#fff !important;
}
.pacz-pagination .page-number,
.pacz-pagination .current-page {
  color:{$accent_color};
  border-color:{$accent_color};
}
.pacz-pagination .pacz-pagination-next a,
.pacz-pagination .pacz-pagination-previous a {
  color:{$accent_color};
  border-color:{$accent_color};
}
.pacz-pagination .pacz-pagination-next:hover a,
.pacz-pagination .pacz-pagination-previous:hover a {
  background-color:{$accent_color} !important;
	border-color:{$accent_color} !important;
	color:#fff !important;
}
.pacz-loadmore-button:hover {
  background-color:{$accent_color} !important;
	color:#fff !important;
}
.pacz-searchform .pacz-icon-search:hover {
  background-color:{$accent_color} !important;
  color:#fff;
}
.footer-sell-btn a{
	background-color:{$accent_color};
}
.footer-sell-btn a:hover{
	background-color:{$pacz_settings['btn-hover']};
}
");

###########################################
# listing plugin
###########################################
$search_border_20 = pacz_convert_rgba($pacz_settings['main-searchbar-border-color'], 0.2);
$main_searchbar_bg_color = (isset($pacz_settings['main-searchbar-bg-color']['rgba'])) ? $pacz_settings['main-searchbar-bg-color']['rgba'] : '';
$featured_text = esc_html__('Featured', 'classiadspro');
	Classiadspro_Static_Files::addGlobalStyle("


.alsp-listing-header h2 a,
.alsp-categories-root a,
.alsp-content .btn-default,
.alsp-price span,
.premium-listing-text,
.premium-listing-text:hover,
.alsp-list-group-item:first-child{
	color:{$pacz_settings['heading-color']} !important;
	font-weight:{$pacz_settings['heading-font']['font-weight']};
	text-transform:uppercase;
}
.alsp-listing-header h2 a,
.premium-listing-text span,
.alsp-orderby-links .btn-default.btn-primary,
.handpick-locations .alsp-locations-column-wrapper a,
.alsp-categories-root a,
.alsp-price{
	{$heading_font_family}
}
.alsp-listing-header h2 a:hover,
.alsp-price,
.premium-listing-text span,
.alsp-price:hover,
.view-all-btn,
.view-all-btn:hover{
	color:{$accent_color} !important;
}
.alsp-listings-grid .alsp-listing-text-content-wrap .alsp-field-output-block-price,
.alsp-listings-grid .alsp-listing  figcaption .alsp-figcaption .alsp-location span,
.alsp-categories-column-wrapper .subcategories ul li a{
	{$body_font_family}
	
}

.alsp-list-group-item{
	
	color:{$pacz_settings['body-txt-color']};
}

.alsp-listings-grid .alsp-listing-text-content-wrap .alsp-field-output-block-categories .alsp-field-content .alsp-label,
.alsp-content .btn-primary.alsp-grid-view-btn,
.alsp-content .btn-primary.alsp-list-view-btn,
.btn-primary {
	background-color:{$accent_color} !important;
	border-color:{$accent_color} !important;
	color:#fff;
	border-radius:0;
}
.view_swither_panel_style2 .btn-primary.alsp-grid-view-btn,
.view_swither_panel_style2 .btn-primary.alsp-list-view-btn{
	background:none !important;
	color:{$pacz_settings['btn-hover']} !important;
	border:none !important;
}
.alsp-orderby-links a.btn.btn-default.btn-primary{
	background:none !important;
	padding:6px 12px !important;
}

.alsp-categories-root a:hover{
	color:{$pacz_settings['heading-color']} !important;
}
.subcategories ul li a,
.subcategories ul li a span{
	color:{$pacz_settings['link-color']['regular']};
}


.subcategories ul li a:hover,
.subcategories ul li a:hover span,
.alsp-content .btn-default:hover,
.alsp-orderby-links .btn-default.btn-primary,
.alsp-orderby-links .btn-default.btn-primary:hover{
	color:{$pacz_settings['link-color']['hover']} !important;
}
.view_swither_panel_style2 .alsp-orderby-links a.btn-default:hover,
.view_swither_panel_style2 .alsp-orderby-links a.btn-primary,
.view_swither_panel_style2 .alsp-orderby-links a.btn-primary:hover{
	border-color:{$pacz_settings['link-color']['hover']} !important;
}
.cat-style-2 .alsp-categories-column-wrapper .alsp-categories-root a,
.cat-style-1 .alsp-categories-column-wrapper .alsp-categories-root a .categories-count{
	color:{$pacz_settings['body-txt-color']} !important;
}
.cat-style-2 .alsp-categories-column-wrapper .alsp-categories-root a .categories-count,
.author-name{
	color:{$pacz_settings['heading-color']} !important;
}

.btn-primary:hover{
	
	background-color:{$pacz_settings['btn-hover']} !important;
	border-color:{$pacz_settings['btn-hover']} !important;
}
.single-listing.alsp-content .nav-tabs > li a,
.single-listing.alsp-content .nav-tabs > li a:hover,
.access-press-social .apsl-login-new-text{
	color:{$pacz_settings['heading-color']} !important;
}
.single-listing.alsp-content .nav-tabs > li a i,
.author-phone a i{
	color:{$accent_color} !important;
}
.cat-scroll-header,
.search-form-style2 .search-wrap h5,
.alsp-single-listing-text-content-wrap .alsp-fields-group .alsp-fields-group-caption,
.alsp-single-listing-text-content-wrap .alsp-field-output-block .alsp-field-caption{
	{$heading_font_family};
	color:{$pacz_settings['heading-color']} !important;
}

.handpick-locations .alsp-locations-column-wrapper a{}
.alsp-dashboard-tabs-content .alsp-table ul li.td_listings_options .btn-group a{
	background-color:#fff !important;
	border-color: #fff !important;
}
.alsp-dashboard-tabs-content .alsp-table ul li.td_listings_options .btn-group a span{
	color:{$accent_color} !important;
}
.alsp-dashboard-tabs-content .alsp-table ul:first-child li,
.alsp-dashboard-tabs-content .alsp-table ul:first-child li a,
.alsp-dashboard-tabs-content .alsp-table ul:first-child li a span,
.alsp-content .alsp-submit-section-adv .alsp-panel-default > .alsp-panel-heading h3{
	{$heading_font_family};
}
.alsp-content .alsp-submit-section-adv .alsp-panel-default > .alsp-panel-heading h3{
    background-color: {$pacz_settings['btn-hover']} !important;
}
.pacz-user-avatar-delete a,
.single-listing .alsp-field-content a,
.author-avatar-btn a{
	color:{$pacz_settings['link-color']['regular']} !important;
}
.pacz-user-avatar-delete a:hover,
.author-avatar-btn a:hover{
	background-color:{$pacz_settings['btn-hover']} !important;
	border-color:{$pacz_settings['btn-hover']} !important;
	color:#fff !important;
}

.save-avatar-btn .profile-avatar-btn,
.listing-author-box .author-info .author-btn a,
.alsp-social-widget ul.alsp-social li a{
	background-color:{$accent_color} !important;
	border-color:{$accent_color} !important;
	color:#fff !important;
}
.save-avatar-btn .profile-avatar-btn:hover,
.listing-author-box .author-info .author-btn a:hover,
.alsp-social-widget ul.alsp-social li a:hover{
	background-color:{$pacz_settings['btn-hover']} !important;
	border-color:{$pacz_settings['btn-hover']} !important;
	color:#fff !important;
}
.search-form-style2 .search-wrap h5:before,
.listing-author-box .author-info .author-info-list ul li i,
.alsp-listing-header .rating-numbers{
	background-color:{$accent_color};
}

.alsp-listing.alsp-featured .alsp-listing-logo a.alsp-listing-logo-img-wrap::after{
	background-color:#ff5656 !important;
}
.ui-widget-header,
.ui-slider-horizontal {
    background:{$pacz_settings['btn-hover']} !important;
    
}
.cz-datetime .datetime-reset-btn .btn.btn-primary{
	background-color:{$accent_color} !important;
}
.cz-datetime .datetime-reset-btn .btn.btn-primary:hover{
	background:{$pacz_settings['btn-hover']} !important;
}
.listings.location-archive .alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a{
	
}
.alsp-locations-column-wrapper  .alsp-locations-root a .loaction-name{
	{$heading_font_family}
}
:not(.listing-archive) .search-form-style2.alsp-content.alsp-search-form .bs-caret,
:not(.location-archive) .search-form-style2.alsp-content.alsp-search-form .bs-caret,
:not(.cat-archive) .search-form-style2.alsp-content.alsp-search-form .bs-caret,
:not(.search-result) .search-form-style2.alsp-content.alsp-search-form .bs-caret,
:not(.listing-archive) .search-form-style2.alsp-content.alsp-search-form .alsp-get-location.glyphicon-screenshot::before,
:not(.location-archive) .search-form-style2.alsp-content.alsp-search-form .alsp-get-location.glyphicon-screenshot::before,
:not(.cat-archive) .search-form-style2.alsp-content.alsp-search-form .alsp-get-location.glyphicon-screenshot::before,
:not(.search-result) .search-form-style2.alsp-content.alsp-search-form .alsp-get-location.glyphicon-screenshot::before{
	background-color:{$accent_color} !important;
	color:#fff;
}



.alsp_search_widget .bs-caret,
.alsp-locations-widget .alsp-locations-root a .location-icon,
.location-style4.alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a:before,
.listings.location-archive .alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a:before{
	background-color:{$accent_color} !important;
}
.alsp_search_widget .alsp-has-feedback:hover .glyphicon-screenshot,
.alsp-locations-widget .alsp-locations-root a:hover .location-icon,
.location-style4.alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a:hover:before,
.listings.location-archive .alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a:hover:before{
	background-color:{$pacz_settings['btn-hover']} !important;
}

.alsp-listings-block.cz-listview article .alsp-field-caption{
	color:{$pacz_settings['heading-color']};
}
.alsp-listings-block.cz-listview article .alsp-field-output-block.alsp-field-output-block-categories .field-content .label.label-primary{
	background-color:{$accent_color} !important;
}
.alsp-listings-block.cz-listview article .alsp-field-output-block .alsp-field-caption .alsp-field-icon{
	color:{$accent_color} !important;
}
.alsp-single-listing-logo-wrap header.alsp-listing-header .statVal span.ui-rater-rating {
	background-color:{$accent_color} !important;
}
.cz-checkboxes .checkbox .radio-check-item:before,
.alsp-price.alsp-payments-free,
.alsp-content .alsp-list-group-item i.pacz-icon-check,
.checkbox-wrap .checkbox label:before,
label span.radio-check-item:before{
    color:{$accent_color} !important;
}
.pplan-style-3 .alsp-choose-plan ul li .alsp-price del .woocommerce-Price-amount,
.pplan-style-3 .alsp-choose-plan ul li .alsp-price del .woocommerce-Price-amount .woocommerce-Price-currencySymbol,
.pplan-style-3 .alsp-choose-plan ul li .alsp-price del,
.alsp-choose-plan ul li .alsp-price del,
.alsp-price del .woocommerce-Price-amount,
.alsp-price del .woocommerce-Price-amount .woocommerce-Price-currencySymbol{
	color:{$pacz_settings['body-txt-color']} !important;
}
.pplan-style-3 .alsp-choose-plan ul li .alsp-price span,
.pplan-style-3 .alsp-choose-plan ul li .alsp-price{
	color:{$pacz_settings['heading-color']} !important;
}
.pplan-style-3 .alsp-choose-plan:hover ul li.alsp-list-group-item:first-child {
	background-color:{$accent_color} !important;
	border-color:#fff;
	box-shadow:none;
	
}
.pplan-style-3 .alsp-choose-plan:hover ul li.alsp-list-group-item:first-child span,
.pplan-style-3 .alsp-choose-plan:hover ul li.alsp-list-group-item:first-child,
.pplan-style-3 .alsp-choose-plan:hover ul li.alsp-list-group-item:first-child .alsp-price,
.pplan-style-3 .alsp-choose-plan:hover ul li.alsp-list-group-item:first-child .alsp-price span{
	color:#fff !important;
}
.alsp-categories-widget .alsp-categories-root a .categories-count{
	color: {$pacz_settings['sidebar-txt-color']};
}
.alsp-categories-widget .alsp-categories-root a:hover,
.alsp-categories-widget .alsp-categories-root a:hover .categories-count,
a.alsp-hint-icon:after{
	color:{$accent_color} !important;
}
.listing-post-style-2 .featured-ad{
	background:{$accent_color};
}
.listing-post-style-2:hover .featured-ad{
background:{$pacz_settings['btn-hover']};
}
.listing-post-style-3 figure .price,
.listing-post-style-7 figure .price .alsp-field-output-block-price .alsp-field-content{
	background:{$accent_color};
}
.listing-post-style-3:hover figure .price,
.listing-post-style-7:hover figure .price .alsp-field-output-block-price .alsp-field-content{
	background:{$pacz_settings['btn-hover']};
}
.alsp-listings-grid .listing-post-style-3 .alsp-listing-text-content-wrap .alsp-field-output-block-price,
.alsp-listings-grid .listing-post-style-5 .alsp-listing-text-content-wrap .alsp-field-output-block-categories .alsp-field-content .alsp-label,
.alsp-listings-grid .listing-post-style-9 .alsp-listing-text-content-wrap .alsp-field-output-block-categories .alsp-field-content .alsp-label,
.popular-level{
	background-color:{$accent_color} !important;
}
.alsp-listings-grid .listing-post-style-3 .listing-wrapper:hover .alsp-listing-text-content-wrap .alsp-field-output-block-categories .alsp-field-content .alsp-label,
.alsp-listings-grid .listing-post-style-5 .alsp-listing-text-content-wrap .alsp-field-output-block-price,
.alsp-listings-grid .listing-post-style-9 .alsp-listing-text-content-wrap .alsp-field-output-block-price {
	color:{$accent_color} !important;
}
.location-style2 .alsp-locations-column-wrapper .alsp-locations-column-wrapper-inner .alsp-locations-root a .location-count,
.location-style3 .alsp-locations-column-wrapper .alsp-locations-column-wrapper-inner .alsp-locations-root a .location-count{
	background-color:{$accent_color} !important;
}
.single-listing .alsp-label, {
	color:{$pacz_settings['body-txt-color']} !important;
	background:none !important;
}

.single-listing .alsp-label-primary {background:none;}
.alsp-listings-grid .listing-post-style-3 .listing-wrapper:hover .alsp-listing-text-content-wrap{
	background:{$pacz_settings['heading-color']};
}
.single-listing-btns ul li a{
	color:{$pacz_settings['body-txt-color']};
}
.widget_author .classiadspro-author.style2 .author-social-follow-ul li a:hover{
	background-color:{$accent_color};
	color:#fff !important;
}

.alsp-listings-grid .listing-post-style-3 .listing-wrapper:hover .alsp-listing-text-content-wrap .alsp-field-output-block-categories .alsp-label-primary a{
	color:{$pacz_settings['btn-hover']} !important;
}
.search-wrap,
.search-form-style1 .advanced-search-button{
	background-color:{$main_searchbar_bg_color};
	border-color:{$search_border_20};
}
.search-form-style1 .advanced-search-button a{color:{$pacz_settings['body-txt-color']} !important;}
.alsp-listings-grid .listing-post-style-7 .alsp-listing-text-content-wrap .second-content-field .alsp-field-output-block-string .alsp-field-caption .alsp-field-icon {
	color:{$accent_color};
}
.alsp-listings-grid .listing-post-style-8 .listing-wrapper:hover .alsp-listing-text-content-wrap{
	
}
.alsp-listing .alsp-listing-text-content-wrap .listing-metas em.alsp-listing-date i,
.alsp-listing .alsp-listing-text-content-wrap .listing-views i,
.alsp-listing .alsp-listing-text-content-wrap .listing-id i,
.alsp-listing .listing-wrapper .alsp-listing-text-content-wrap .listing-location i,
.single-listing .alsp-listing-date i,
.single-listing .listing-views i,
.single-location-address i,
.dashbeard-btn-panel .cz-btn-wrap a.favourites-link:hover{
	color:{$pacz_settings['btn-hover']};
}
.alsp-listings-grid .listing-post-style-10 .listing-wrapper .alsp-listing-text-content-wrap .listing-location i{
	color:{$pacz_settings['body-txt-color']};
}
.dashbeard-btn-panel .cz-btn-wrap a.favourites-link{
	background-color:{$accent_color};
}
.alsp-listing.listing-post-style-9 .alsp-listing-logo .price .alsp-field span.alsp-field-content{
	{$heading_font_family};
	font-weight:bold;
}
.alsp-listing.listing-post-style-6.alsp-featured .alsp-listing-logo a.alsp-listing-logo-img-wrap:after,
{
    content: '{$featured_text}';
	font-family: inherit;
    display: inline-block;
    height: auto;
    width: auto;
    padding: 7px 12px;
    position: absolute;
	bottom:30px;
	left:30px !important;
	color:#fff;
	z-index:1;
	font-size:14px;
	border-radius:3px;
	line-height:1;
	text-transform:uppercase;
	background-color:{$pacz_settings['btn-hover']};
}
.alsp-listing.listing-post-style-9 .alsp-listing-logo .price .alsp-field span.alsp-field-content{
	background:{$pacz_settings['btn-hover']} !important;
}
.cz-listview .alsp-listing-text-content-wrap .price span.alsp-field-content{
	background:{$pacz_settings['btn-hover']} !important;
}
.cz-listview .listing-post-style-listview_ultra .alsp-listing-text-content-wrap .price span.alsp-field-content{
	background:{$accent_color} !important;
}
.single-listing .price span.alsp-field-content,
.alsp-single-listing-logo-wrap a i{
	background-color:{$accent_color};
}
.author-verified{
	
}
.author_type,
.author_verifed{
	border-color:{$accent_color};
	color:{$accent_color};
}
.author_unverifed{
	border-color:#E37B33;
	color:#E37B33;
}
.alsp-listings-grid .listing-post-style-10 .alsp-listing-text-content-wrap .alsp-field-output-block-price{
	color:{$pacz_settings['heading-color']};
}
.alsp-listings-grid .listing-post-style-10 .alsp-listing-text-content-wrap .listing-cat{
	color:{$pacz_settings['body-txt-color']};
}
.single-listing .listing-main-content,
#pacz-sidebar .widget,
.listing-list-view-inner-wrap,
.blog-classic-entry,
.single-post .theme-content .inner-content,
.pacz-single-comment{
	border-radius:{$pacz_settings['sidebar_content_radius']}px;
}



	");
	
if(class_exists('alsp_plugin')){
	global $ALSP_ADIMN_SETTINGS;
	$listing_title_font = $ALSP_ADIMN_SETTINGS['alsp_listing_title_font'];
	$alsp_search_style3_mtop = $ALSP_ADIMN_SETTINGS['alsp_search_style3_mtop'];
	Classiadspro_Static_Files::addGlobalStyle("
	
		header.alsp-listing-header h2 {
		font-size: {$listing_title_font}px;
		}
		.search-form-style3.alsp-content.alsp-search-form {
		margin-top: {$alsp_search_style3_mtop}px !important;
		}
	");

	if (!$ALSP_ADIMN_SETTINGS['alsp_search_style3_shadow']){ 
		Classiadspro_Static_Files::addGlobalStyle("
			.search-form-style3 .search-wrap {
				box-shadow:none;
			}
		");
	}
	if (!$ALSP_ADIMN_SETTINGS['alsp_map_on_excerpt']){ 
		Classiadspro_Static_Files::addGlobalStyle("
			.listings.cat-archive .main-search-bar .alsp-content.alsp-search-form {margin: 0 !important;}
			.listings.location-archive .main-search-bar .alsp-content.alsp-search-form {margin: 0 !important;}
		");
	}
	global $alsp_instance;
	$page_id = get_queried_object_id();
	$page_object = get_page( $page_id );
	if (!is_author() && !is_404() && !is_search() && !is_archive() && (strpos($page_object->post_content, '[webdirectory-listing'))){
		Classiadspro_Static_Files::addGlobalStyle("
			#theme-page .theme-page-wrapper .inner-page-wrapper .vc_row #pacz-sidebar {
				padding-left: 15px;
				padding-right:15px;
			}
		");
	}
}


###########################################
# subscription form
###########################################

Classiadspro_Static_Files::addGlobalStyle("
	.subscription-form  form#signup-1 .subs-form-btn{
		background-color:{$accent_color} !important;
	}
	.subscription-form  form#signup-1 .subs-form-btn:hover{
		background-color:{$pacz_settings['subs-btn-hover']} !important;
		
	}
");

/* Login AND REGISTER Buttons */
$logreg_padding_top = round($toolbar_height / 2) - 17;
Classiadspro_Static_Files::addGlobalStyle("

.header-toolbar-log-reg-btn a.pacz-login,
.header-toolbar-log-reg-btn a.pacz-register{
	margin-top:{$logreg_padding_top}px;
	color:#fff !important;
}
.author-displayname{
	color:{$pacz_settings['heading-color']} !important;
}
.header-toolbar-log-reg-btn a.pacz-login-2,
.header-toolbar-log-reg-btn a.pacz-register-2{
	margin-top:{$logreg_padding_top}px;
}
.header-toolbar-log-reg-btn a.pacz-login{background-color:{$accent_color};}
.header-toolbar-log-reg-btn a.pacz-register{background-color:{$pacz_settings['btn-hover']};}

.header-toolbar-log-reg-btn .dropdown-content a{
	
}
.header-toolbar-log-reg-btn a.pacz-login:hover{background-color:{$pacz_settings['btn-hover']};}
.header-toolbar-log-reg-btn a.pacz-register:hover{background-color:{$accent_color};}

.header-toolbar-log-reg-btn a.pacz-logout i,
.header-toolbar-log-reg-btn a.pacz-login i{
}

.pacz-header-toolbar .header-toolbar-contact{
	padding-top:{$logreg_padding_top}px;

}
.pacz-header-toolbar .header-toolbar-contact i{
	background-color:{$accent_color};
	color:#fff !important;
}
.theme-content .main-header .logo,
.theme-content .main-header .logo:hover{
	//background-color:{$accent_color};
}
.user-panel .author-thumbnail{
	border:3px solid {$accent_color};
}

.skin-blue .user-panel-main .sidebar-menu > li.active > a,
.skin-blue .user-panel-main .sidebar-menu>li>.treeview-menu{
	border-left-color:{$accent_color};
}
.verified-ad-tag,
.unverified-ad-tag{
	color:{$pacz_settings['body-txt-color']};
}

");
if(!is_404() && !is_search() && !is_author() && class_exists('DHVCForm')){
	$dhvc_input_border_color = get_post_meta( $post->ID, '_input_border_color', true );
	$dhvc_input_hover_border_color = get_post_meta( $post->ID, '_input_hover_border_color', true );
	$dhvc_input_focus_border_color = get_post_meta( $post->ID, '_input_focus_border_color', true );
	$dhvc_input_border_size = get_post_meta( $post->ID, '_input_border_size', true );
	$dhvc_input_height = get_post_meta( $post->ID, '_input_height', true );
	$dhvc_button_bg_color = get_post_meta( $post->ID, '_button_bg_color', true );
	$dhvc_button_height = get_post_meta( $post->ID, '_button_height', true );
if(isset($dhvc_input_border_color) && empty($dhvc_input_border_color)){
	Classiadspro_Static_Files::addGlobalStyle("
	.dhvc-form-flat .dhvc-form-input input, .dhvc-form-flat .dhvc-form-file input[type=text], .dhvc-form-flat .dhvc-form-captcha input, .dhvc-form-flat .dhvc-form-select select, .dhvc-form-flat .dhvc-form-textarea textarea, .dhvc-form-flat .dhvc-form-radio i, .dhvc-form-flat .dhvc-form-checkbox i {
	border-color:#eee;
	}
");
	}
if(isset($dhvc_input_border_size) && empty($dhvc_input_border_size)){
	Classiadspro_Static_Files::addGlobalStyle("
	.dhvc-form-flat .dhvc-form-input input, .dhvc-form-flat .dhvc-form-file input[type=text], .dhvc-form-flat .dhvc-form-captcha input, .dhvc-form-flat .dhvc-form-select select, .dhvc-form-flat .dhvc-form-textarea textarea, .dhvc-form-flat .dhvc-form-radio i, .dhvc-form-flat .dhvc-form-checkbox i {
	border-width:1px;
	}
");
	}
if(isset($dhvc_input_height) && empty($dhvc_input_height)){
	Classiadspro_Static_Files::addGlobalStyle("
	.dhvc-form-flat .dhvc-form-input input, .dhvc-form-flat .dhvc-form-file input[type=text], .dhvc-form-flat .dhvc-form-captcha input, .dhvc-form-flat .dhvc-form-select select, .dhvc-form-flat .dhvc-form-textarea textarea, .dhvc-form-flat .dhvc-form-radio i, .dhvc-form-flat .dhvc-form-checkbox i {
	height:50px;
	}
");
	}
if(isset($dhvc_button_bg_color) && empty($dhvc_button_bg_color)){
	Classiadspro_Static_Files::addGlobalStyle("
	.dhvc-form-submit, .dhvc-form-submit:focus, .dhvc-form-submit:hover, .dhvc-form-submit:active {
    background-color:{$accent_color};
}
");
	}
if(isset($dhvc_input_focus_border_color) && empty($dhvc_input_focus_border_color) || isset($dhvc_input_hover_border_color) && empty($dhvc_input_hover_border_color)){
	Classiadspro_Static_Files::addGlobalStyle("
	.dhvc-form-flat .dhvc-form-input input:focus, .dhvc-form-flat .dhvc-form-captcha input:focus, .dhvc-form-flat .dhvc-form-file:hover input[type='text']:focus, .dhvc-form-flat .dhvc-form-select select:focus, .dhvc-form-flat .dhvc-form-textarea textarea:focus, .dhvc-form-flat .dhvc-form-radio input:checked + i, .dhvc-form-flat .dhvc-form-checkbox input:checked + i{
	border-color:{$accent_color};
	}
");
	}
if(isset($dhvc_button_height) && empty($dhvc_button_height)){
	Classiadspro_Static_Files::addGlobalStyle("
	.dhvc-form-submit, .dhvc-form-submit:focus, .dhvc-form-submit:hover, .dhvc-form-submit:active {
    height: 50px;
}
");
	}
Classiadspro_Static_Files::addGlobalStyle("
	.dhvc-form-flat .dhvc-form-input input, .dhvc-form-flat .dhvc-form-file input[type=text], .dhvc-form-flat .dhvc-form-captcha input, .dhvc-form-flat .dhvc-form-select select, .dhvc-form-flat .dhvc-form-textarea textarea, .dhvc-form-flat .dhvc-form-radio i, .dhvc-form-flat .dhvc-form-checkbox i,.dhvc-form-flat .dhvc-form-action.dhvc_form_submit_button {
	margin:7px 0 !important;
	}
	.footer-form-style4 .dhvc-form-flat .dhvc-form-input input, .footer-form-style4 .dhvc-form-flat .dhvc-form-action.dhvc_form_submit_button{
		margin: 0 !important;
	}
	.dhvc-form-submit{
		background-color:{$accent_color};
		display:block;
		width:100%;
	}
	.dhvc-form-submit:hover, .dhvc-form-submit:active, .dhvc-form-submit:focus {
		background-color:{$pacz_settings['btn-hover']};
	}
	.dhvc-form-submit, .dhvc-form-submit:hover, .dhvc-form-submit:active, .dhvc-form-submit:focus {
		opacity:1;
	}
	.dhvc-form-add-on i{color:{$accent_color};}
	.dhvc-form-group .dhvc-form-control {padding-left:20px;padding-right:50px}
	.dhvc-register-link{color:{$accent_color}}
");
if(isset($dhvc_button_height) && !empty($dhvc_button_height)){
	Classiadspro_Static_Files::addGlobalStyle("
	.dhvc-form-add-on{width:{$dhvc_button_height}; line-height:{$dhvc_button_height};height:{$dhvc_button_height};}
");
	}else{
	Classiadspro_Static_Files::addGlobalStyle("
	.dhvc-form-add-on{width:50px !important;line-height:50px !important;height:50px !important;border-left:1px solid #eee;}
");	
	}
	
}
	
###########################################
# BREADCRUMB CUSTOM SKIN STYLES
###########################################

$breadcrumb_skin = (isset($pacz_settings['breadcrumb-skin']) && !empty($pacz_settings['breadcrumb-skin']) && $pacz_settings['breadcrumb-skin'] == 'custom' ) ? 1 : 0;
$breadcrumb_custom_color_regular = (isset($pacz_settings['breadcrumb-skin-custom']['regular']) && !empty($pacz_settings['breadcrumb-skin-custom']['regular']) ) ? $pacz_settings['breadcrumb-skin-custom']['regular'] : $custom_breadcrumb_color ;
$breadcrumb_custom_color_hover = (isset($pacz_settings['breadcrumb-skin-custom']['hover']) && !empty($pacz_settings['breadcrumb-skin-custom']['hover']) ) ? $pacz_settings['breadcrumb-skin-custom']['hover'] : $custom_breadcrumb_hover_color ;

if($breadcrumb_skin == 1){

	if($custom_breadcrumb_page == 1){
		
		Classiadspro_Static_Files::addGlobalStyle(" #pacz-breadcrumbs .custom-skin{
			color: {$breadcrumb_custom_color_regular} !important;
		}
		#pacz-breadcrumbs .custom-skin a{
			color: {$breadcrumb_custom_color_regular} !important;
		}
		#pacz-breadcrumbs .custom-skin a:hover{
			color: {$breadcrumb_custom_color_hover} !important;
		}

		");
	}

}



###########################################star-rating
	# WOOCOMMERCE DYNAMIC STYLES
	###########################################
	if (class_exists('woocommerce')) {

		$accent_color_90 = pacz_convert_rgba($accent_color, 0.9);

		Classiadspro_Static_Files::addGlobalStyle("


.woocommerce-page .quantity .plus,
.woocommerce-page .quantity .minus,
.product_meta a,
.sku_wrapper span,
.order-total,

.mini-cart-remove,
.add_to_cart_button .pacz-icon-plus,
.add_to_cart_button .pacz-theme-icon-magnifier
{
	color: {$accent_color};
}

.pacz-checkout-payement h3,
.woocommerce-message .button:hover,
.woocommerce-error .button:hover,
.woocommerce-info .button:hover,
.woocommerce.widget_shopping_cart .amount,
.widget_product_categories .current-cat,
.widget_product_categories li a:hover
 {
	color: {$accent_color} !important;
}

.add_to_cart_button:hover,
.woocommerce-page ul.products li.product .add_to_cart_button:hover,
.widget_price_filter .ui-slider .ui-slider-range,

.mini-cart-button:hover,
.widget_product_tag_cloud a:hover,
.product-single-lightbox:hover,
.woocommerce-page span.onfeatured,
.woocommerce .onfeatured{
	background-color: {$accent_color} !important;
}

.product-loading-icon {
	background-color:{$accent_color_90};
}

.pacz-cart-link {
	color:{$pacz_settings['main-nav-top-color']['regular']};
}
.pacz-cart-link:hover {
	color:{$pacz_settings['main-nav-top-color']['hover']};
}

.mini-cart-remove,
.mini-cart-button {
	border-color: {$accent_color};
}
.quantity-number(color:#fff;)
.pacz-dynamic-styles {display:none}
.mini-cart-price .amount,
.mini-cart-remove:hover {
  color: {$accent_color};
}
.woocommerce-page .quantity .plus,
.woocommerce .quantity .plus,
.woocommerce-page #content .quantity .plus,
.woocommerce #content .quantity .plus,
.woocommerce-page .quantity .minus,
.woocommerce .quantity .minus,
.woocommerce-page #content .quantity .minus,
.woocommerce #content .quantity .minus,
.woocommerce-page .quantity input.qty,
.woocommerce .quantity input.qty,
.woocommerce-page #content .quantity input.qty,
.woocommerce #content .quantity input.qty,
.woocommerce-page a.button.alt,
.woocommerce a.button.alt,
.woocommerce-page input.button.alt,
.woocommerce input.button.alt,
.woocommerce-page .single_add_to_cart_button, .woocommerce .single_add_to_cart_button{
   border-color: {$accent_color};
   color: {$accent_color};
   
}
.woocommerce-page button.button.alt,
.woocommerce button.button.alt,
.woocommerce-page #respond input#submit.alt,
.woocommerce #respond input#submit.alt,
.woocommerce-page #content input.button.alt,
.woocommerce #content input.button.alt{
	background-color:{$accent_color};
	border-color: {$accent_color};
   color: #fff;
}
.woocommerce-page .quantity .plus:hover,
.woocommerce .quantity .plus:hover,
.woocommerce-page #content .quantity .plus:hover,
.woocommerce #content .quantity .plus:hover,
.woocommerce-page .quantity .minus:hover,
.woocommerce .quantity .minus:hover,
.woocommerce-page #content .quantity .minus:hover,
.woocommerce #content .quantity .minus:hover,
.woocommerce-page .quantity input.qty:hover,
.woocommerce .quantity input.qty:hover,
.woocommerce-page #content .quantity input.qty:hover,
.woocommerce #content .quantity input.qty:hover,
.woocommerce-page a.button.alt:hover,
.woocommerce a.button.alt:hover,
.woocommerce-page button.button.alt:hover,
.woocommerce button.button.alt:hover,
.woocommerce-page input.button.alt:hover,
.woocommerce input.button.alt:hover,
.woocommerce-page #respond input#submit.alt:hover,
.woocommerce #respond input#submit.alt:hover,
.woocommerce-page #content input.button.alt:hover,
.woocommerce #content input.button.alt:hover,
.woocommerce-page .single_add_to_cart_button:hover, .woocommerce .single_add_to_cart_button:hover {
   border-color: {$pacz_settings['btn-hover']};
   background-color:{$pacz_settings['btn-hover']};
   color:#fff;
}
woocommerce-page .single_add_to_cart_button:hover i,
.woocommerce .single_add_to_cart_button:hover i{
   color:#fff !important;
}
.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a,
.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active a,
.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a,
.woocommerce-page div.product span.price ins,
.woocommerce div.product span.price ins,
.woocommerce-page #content div.product span.price ins,
.woocommerce #content div.product span.price ins,
.woocommerce-page div.product p.price ins,
.woocommerce div.product p.price ins,
.woocommerce-page #content div.product p.price ins,
.woocommerce #content div.product p.price ins{
  color: {$accent_color};
  
}
.rev-btn, .rev-btn:visited {
	box-shadow:inherit !important;
}
.woocommerce-orders-table__header .nobr{
	color:{$pacz_settings['heading-color']};
}
");

	}

	//$output .= $pacz_settings['custom-css'];

	//$output = preg_replace('/\r|\n|\t/', '', $output);


	//wp_enqueue_style('theme-dynamic-styles', get_template_directory_uri() . '/custom.css');

	//wp_add_inline_style('theme-dynamic-styles', $output);

//}
//add_action('wp_enqueue_scripts', 'pacz_dynamic_css', 30);


###########################################
# STYLES FOR VISUAL STUDIO IMPORTANT TAG
###########################################
/*function pacz_important_dynamic_css(){
	$output = '';
	echo'
	<style>
		@media handheld, only screen and (max-width: 767px)
		{
			[class*="vc_custom_"]
			{
				padding-left: 0 !important;
				padding-right: 0 !important;
			}
			#classiadspro-page-title {
				height: 120px !important;
				padding-top: 35px !important;
			}
		}
	</style>	
	';

	

}

add_action('wp_enqueue_scripts', 'pacz_important_dynamic_css', 9999);*/
