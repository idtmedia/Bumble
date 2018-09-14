<!DOCTYPE html>
<html <?php if(function_exists('custom_vc_init')){ pacz_html_tag_schema();} ?> <?php language_attributes(); ?>>

    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        
        
		<?php if ( ! function_exists( 'wp_site_icon' ) ) : ?>
		<?php $pacz_settings = $GLOBALS['pacz_settings'];?>
		<?php if ( $pacz_settings['favicon']['url'] ) { ?>
          <link rel="shortcut icon" href="<?php echo esc_url($pacz_settings['favicon']['url']); ?>"  />
        <?php } ?>
		<?php endif; ?>

    <?php wp_head(); ?>
    </head>


<body <?php body_class('skin-blue'); ?>>


<?php


	


global $pacz_settings;
 $post_id = global_get_post_id();
 $preset_header_style = $pacz_settings['preset_header_style'];
 $preset_headers = $pacz_settings['preset_headers'];
 if($preset_headers == 1){
	$header_structure = 'standard';
	$header_align = 'left';
	$header_grid = 'false';
	$sticky_header = 0;
	$squeeze_sticky_header = 0;
	
	$boxed_layout = $pacz_settings['body-layout'];
	$header_style = $trans_header_skin = $header_padding_class = $header_grid_margin = $trans_header_skin_class = $pacz_main_wrapper_class = '';
	
	$toolbar = 0;
	$toolbar_check = get_post_meta( $post_id, '_header_toolbar', true );
	$toolbar_option = !empty($toolbar_check) ? $toolbar_check : 'true';
	$header_toolbar_grid = 0;
	$pacz_logo_location = 'header_section';
	$pacz_logo_align = 'left' ;
	
	$header_toolbar_social_location = 'disabled'; 
	$header_toolbar_social_align = 'right';
	$listing_btn_location = 'header_section';
	$listing_btn_align = 'right';

	$login_reg_btn_location = 'disabled';
	$login_reg_btn_align =  'right';
	
	$header_contact_details_location = 'disabled' ;
	$header_contact_details_align = 'left' ;
	
	$boxed_header = 1;
	
}else if($preset_headers == 2){
	$header_structure = 'margin';
	$header_align = 'left';
	$header_grid = 'false';
	$sticky_header = 0;
	$squeeze_sticky_header = 0;
	
	$boxed_layout = $pacz_settings['body-layout'];
	$header_style = $trans_header_skin = $header_padding_class = $header_grid_margin = $trans_header_skin_class = $pacz_main_wrapper_class = '';
	
	$boxed_header = 1;
	
	$toolbar = 0;
	$toolbar_check = get_post_meta( $post_id, '_header_toolbar', true );
	$toolbar_option = !empty($toolbar_check) ? $toolbar_check : 'true';
	$header_toolbar_grid = 0;
	
	$pacz_logo_location = 'header_section';
	$pacz_logo_align = 'left' ;
	
	$header_toolbar_social_location = 'disabled'; 
	$header_toolbar_social_align = 'right';
	$listing_btn_location = 'header_section';
	$listing_btn_align = 'right';

	$login_reg_btn_location = 'disabled';
	$login_reg_btn_align =  'right';
	
	$header_contact_details_location = 'disabled' ;
	$header_contact_details_align = 'left' ;
	
}else if($preset_headers == 3){
	$header_structure = 'standard';
	$header_align = 'left';
	$header_grid = 'false';
	$sticky_header = 0;
	$squeeze_sticky_header = 0;
	
	$boxed_layout = $pacz_settings['body-layout'];
	$header_style = $trans_header_skin = $header_padding_class = $header_grid_margin = $trans_header_skin_class = $pacz_main_wrapper_class = '';
	
	$boxed_header = 0;
	
	$toolbar = 0;
	$toolbar_check = get_post_meta( $post_id, '_header_toolbar', true );
	$toolbar_option = !empty($toolbar_check) ? $toolbar_check : 'true';
	$header_toolbar_grid = 0;
	$pacz_logo_location = 'header_section';
	$pacz_logo_align = 'left' ;
	
	$header_toolbar_social_location = 'disabled'; 
	$header_toolbar_social_align = 'right';
	$listing_btn_location = 'header_toolbar';
	$listing_btn_align = 'right';

	$login_reg_btn_location = 'disabled';
	$login_reg_btn_align =  'right';
	
	$header_contact_details_location = 'disabled' ;
	$header_contact_details_align = 'left' ;
	
}else if($preset_headers == 4){
	$header_structure = 'standard';
	$header_align = 'right';
	$header_grid = 0;
	$sticky_header = 0;
	$squeeze_sticky_header = 0;
	
	$boxed_layout = $pacz_settings['body-layout'];
	$header_style = $trans_header_skin = $header_padding_class = $header_grid_margin = $trans_header_skin_class = $pacz_main_wrapper_class = '';
	
	$boxed_header = 1;
	
	$toolbar = 1;
	$toolbar_check = get_post_meta( $post_id, '_header_toolbar', true );
	$toolbar_option = !empty($toolbar_check) ? $toolbar_check : 'true';
	$header_toolbar_grid = 0;
	
	$pacz_logo_location = 'header_toolbar';
	$pacz_logo_align = 'center' ;
	
	$header_toolbar_social_location = 'header_toolbar'; 
	$header_toolbar_social_align = 'left';
	$listing_btn_location = 'header_toolbar';
	$listing_btn_align = 'right';

	$login_reg_btn_location = 'disabled';
	$login_reg_btn_align =  'right';
	
	$header_contact_details_location = 'disabled' ;
	$header_contact_details_align = 'left' ;
	
}else if($preset_headers == 5){
	$header_structure = 'standard';
	$header_align = 'left';
	$header_grid = 0;
	$sticky_header = 0;
	$squeeze_sticky_header = 0;
	
	$boxed_layout = $pacz_settings['body-layout'];
	$header_style = $trans_header_skin = $header_padding_class = $header_grid_margin = $trans_header_skin_class = $pacz_main_wrapper_class = '';
	
	$boxed_header = 1;
	
	$toolbar = 1;
	$toolbar_check = get_post_meta( $post_id, '_header_toolbar', true );
	$toolbar_option = !empty($toolbar_check) ? $toolbar_check : 'true';
	$header_toolbar_grid = 0;
	$pacz_logo_location = 'header_section';
	$pacz_logo_align = 'left' ;
	
	$header_toolbar_social_location = 'header_toolbar'; 
	$header_toolbar_social_align = 'right';
	$listing_btn_location = 'header_section';
	$listing_btn_align = 'right';

	$login_reg_btn_location = 'disabled';
	$login_reg_btn_align =  'right';
	
	$header_contact_details_location = 'header_toolbar' ;
	$header_contact_details_align = 'left' ;
	
}else if($preset_headers == 6){
	
	$header_structure = 'standard';
	$header_align = 'left';
	$header_grid = 'true';
	$sticky_header = 0;
	$squeeze_sticky_header = 0;
	
	$boxed_layout = $pacz_settings['body-layout'];
	$header_style = $trans_header_skin = $header_padding_class = $header_grid_margin = $trans_header_skin_class = $pacz_main_wrapper_class = '';
	
	$boxed_header = 1;
	
	$toolbar = 1;
	$toolbar_check = get_post_meta( $post_id, '_header_toolbar', true );
	$toolbar_option = !empty($toolbar_check) ? $toolbar_check : 'true';
	$header_toolbar_grid = 1;
	$pacz_logo_location = 'header_section';
	$pacz_logo_align = 'left' ;
	
	$header_toolbar_social_location = 'header_toolbar'; 
	$header_toolbar_social_align = 'right';
	$listing_btn_location = 'header_section';
	$listing_btn_align = 'right';

	$login_reg_btn_location = 'disabled';
	$login_reg_btn_align =  'right';
	
	$header_contact_details_location = 'header_toolbar' ;
	$header_contact_details_align = 'left' ;
	//$header_style = 'transparent';
	
}else if($preset_headers == 7){
	$header_structure = 'standard';
	$header_align = 'left';
	$header_grid = 0;
	$sticky_header = 0;
	$squeeze_sticky_header = 0;
	
	$boxed_layout = $pacz_settings['body-layout'];
	$header_style = $trans_header_skin = $header_padding_class = $header_grid_margin = $trans_header_skin_class = $pacz_main_wrapper_class = '';
	
	$boxed_header = 1;
	
	$toolbar = 1;
	$toolbar_check = get_post_meta( $post_id, '_header_toolbar', true );
	$toolbar_option = !empty($toolbar_check) ? $toolbar_check : 'true';
	$header_toolbar_grid = 0;
	$pacz_logo_location = 'header_section';
	$pacz_logo_align = 'left' ;
	
	$header_toolbar_social_location = 'disabled'; 
	$header_toolbar_social_align = 'right';
	$listing_btn_location = 'header_section';
	$listing_btn_align = 'right';

	$login_reg_btn_location = 'header_toolbar';
	$login_reg_btn_align =  'right';
	
	$header_contact_details_location = 'header_toolbar' ;
	$header_contact_details_align = 'left' ;
	
	
}else if($preset_headers == 8){
	$header_structure = 'standard';
	$header_align = 'left';
	$header_grid = 0;
	$sticky_header = 0;
	$squeeze_sticky_header = 0;
	
	$header_style = $trans_header_skin = $header_padding_class = $header_grid_margin = $trans_header_skin_class = $pacz_main_wrapper_class = '';
	
	$boxed_header = 1;
	
	$toolbar = 1;
	$toolbar_check = get_post_meta( $post_id, '_header_toolbar', true );
	$toolbar_option = !empty($toolbar_check) ? $toolbar_check : 'true';
	$header_toolbar_grid = 0;
	$pacz_logo_location = 'header_section';
	$pacz_logo_align = 'left' ;
	
	$header_toolbar_social_location = 'disabled'; 
	$header_toolbar_social_align = 'right';
	$listing_btn_location = 'header_toolbar';
	$listing_btn_align = 'right';

	$login_reg_btn_location = 'header_toolbar';
	$login_reg_btn_align =  'right';
	
	$header_contact_details_location = 'header_toolbar' ;
	$header_contact_details_align = 'left' ;
	
}else if($preset_headers == 9){
	
}else if($preset_headers == 10){
	
}else if($preset_headers == 11){
	
	$boxed_header = $pacz_settings['boxed-header'];
	if($post_id || !$post_id) {
	global $pacz_settings;

		$header_structure = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'header-structure', true ) : $pacz_settings['header-structure'];
		$header_align = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'header-align', true ) : $pacz_settings['header-align'];
		$header_grid = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'header-grid', true ) : $pacz_settings['header-grid'];
		$sticky_header = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'sticky-header', true ) : $pacz_settings['sticky-header'];
		$squeeze_sticky_header =isset($pacz_settings['squeeze-sticky-header']) ? $pacz_settings['squeeze-sticky-header'] : 1;
		
	}
	$toolbar =(isset($pacz_settings['header-toolbar']) && !empty($pacz_settings['header-toolbar'])) ? $pacz_settings['header-toolbar'] : 0;
	$toolbar_check = get_post_meta( $post_id, '_header_toolbar', true );
	$toolbar_option = !empty($toolbar_check) ? $toolbar_check : 'true';
	
	$header_toolbar_grid = $pacz_settings['toolbar-grid'];
	
	$pacz_logo_location = $pacz_settings['header-logo-location'];
	$pacz_logo_align = $pacz_settings['header-logo-align']; 
	
	$header_toolbar_social_location = $pacz_settings['header-social-select']; 
	$header_toolbar_social_align = $pacz_settings['header-social-align'];
	
	$listing_btn_location = $pacz_settings['listing-btn-location'];
	$listing_btn_align = $pacz_settings['listing-btn-align'];
	
	$login_reg_btn_location = $pacz_settings['header-login-reg-location'];
	$login_reg_btn_align =  $pacz_settings['log-reg-btn-align'];
	
	$header_contact_details_location = $pacz_settings['header-contact-select'] ;
	$header_contact_details_align = $pacz_settings['header-contact-align'] ;

}else if($preset_headers == 12){ 
	$boxed_header = $pacz_settings['boxed-header'];
	if($post_id || !$post_id) {
	global $pacz_settings;

		$header_structure = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'header-structure', true ) : $pacz_settings['header-structure'];
		$header_align = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'header-align', true ) : $pacz_settings['header-align'];
		$header_grid = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'header-grid', true ) : $pacz_settings['header-grid'];
		$sticky_header = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'sticky-header', true ) : $pacz_settings['sticky-header'];
		$squeeze_sticky_header =isset($pacz_settings['squeeze-sticky-header']) ? $pacz_settings['squeeze-sticky-header'] : 1;
		
	}
	$toolbar =(isset($pacz_settings['header-toolbar']) && !empty($pacz_settings['header-toolbar'])) ? $pacz_settings['header-toolbar'] : 0;
	$toolbar_check = get_post_meta( $post_id, '_header_toolbar', true );
	$toolbar_option = !empty($toolbar_check) ? $toolbar_check : 'true';
	
	$header_toolbar_grid = $pacz_settings['toolbar-grid'];
	
	$pacz_logo_location = $pacz_settings['header-logo-location'];
	$pacz_logo_align = $pacz_settings['header-logo-align']; 
	
	$header_toolbar_social_location = $pacz_settings['header-social-select']; 
	$header_toolbar_social_align = $pacz_settings['header-social-align'];
	
	$listing_btn_location = $pacz_settings['listing-btn-location'];
	$listing_btn_align = $pacz_settings['listing-btn-align'];
	
	$login_reg_btn_location = 'header-section';
	$login_reg_btn_align =  'right';
	
	$header_contact_details_location = $pacz_settings['header-contact-select'] ;
	$header_contact_details_align = $pacz_settings['header-contact-align'] ;

}
  $boxed_layout = $pacz_settings['body-layout'];

  $header_style = $trans_header_skin = $header_padding_class = $header_grid_margin = $trans_header_skin_class = $pacz_main_wrapper_class = '';

  if($header_structure == 'margin' && $preset_headers == 12) {
    $pacz_main_wrapper_class = ' add-corner-margin';  
  } else if($header_structure == 'vertical') {
	  $header_state = $pacz_settings['vertical-header-state'];
    $pacz_main_wrapper_class = ' vertical-header vertical-' . $header_state . '-state';
  }
  
   
  

	if($post_id) {
		global $pacz_settings, $pacz_accent_color;
		$post_id = global_get_post_id();
		$preloader = get_post_meta( $post_id, '_preloader', true );
		$boxed_layout = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'background_selector_orientation', true ) : $pacz_settings['body-layout'];
		if($preset_headers == 6){
			$header_style = 'transparent';
		}else{
			$header_style = get_post_meta( $post_id, '_header_style', true );
		}
		$trans_header_skin = get_post_meta( $post_id, '_trans_header_skin', true );
		$trans_header_skin_class = ($trans_header_skin != '') ? ($trans_header_skin.'-header-skin') : '';
   
        if($preloader == 'true') { 
		?>
			<div class="pacz-body-loader-overlay"></div>
			
		<?php  } ?>
	<?php  } ?>
	<div class="theme-main-wrapper <?php echo esc_attr($pacz_main_wrapper_class); ?>">

		<?php if($header_structure == 'margin' && $preset_headers == 12) { ?>
			<div class="pacz-top-corner"></div>
			<div class="pacz-right-corner"></div>
			<div class="pacz-left-corner"></div>
			<div class="pacz-bottom-corner"></div>
		<?php } ?>
	<div id="pacz-boxed-layout" class="pacz-<?php echo esc_attr($boxed_layout); ?>-enabled">

	<?php

		$layout_template = $post_id ? get_post_meta($post_id, '_template', true ) : '';

		if($layout_template == 'no-header-title' || $layout_template == 'no-header-title-footer' || $layout_template == 'no-header-title-only-footer') return;


		if($layout_template != 'no-header' && $layout_template !='no-header-footer') :


		$logo_height = (!empty($pacz_settings['logo']['height'])) ? $pacz_settings['logo']['height'] : 50;
		if(isset($squeeze_sticky_header)) {
			$header_sticky_height =	$logo_height/1.2 + ($pacz_settings['header-padding']/2.4 * 2);
		} else {
		}
		$header_height = $logo_height + ($pacz_settings['header-padding'] * 2);

		// Export settings to json 
		$classiadspro_json[] = array(
			'name' => 'theme_header',
			'params' => array(
				'stickyHeight' => $header_sticky_height
			)
		);


		if($header_style == 'transparent') {
		  $header_class = 'transparent-header ' . $trans_header_skin_class;
		} else {
		  $header_class = $sticky_header ? 'sticky-header' : '';
		  $header_padding_class = $sticky_header ? 'sticky-header' : '';
		}
		if($header_grid == 'true' && is_page() && $header_structure != 'vertical'){
			$header_grid = $header_grid ? 'pacz-grid' : '';
		}elseif($pacz_settings['header-grid'] && $header_structure != 'vertical'){
			$header_grid = $header_grid ? 'pacz-grid' : '';
		}

		$header_grid_margin ='header_grid_margin';



		$header_class .= ($boxed_header) ? ' boxed-header' : ' full-header';
		$header_class .= ($preset_headers) ? ' header-style-v'.$preset_headers : 'header-style-v12';
		$header_class .= ($header_structure != 'vertical') ? ($header_align) ? ' header-align-'.$header_align : '' : '';
		$header_class .= ($header_structure) ? ' header-structure-'.$header_structure : '';
		$header_class .= ($header_structure == 'standard') ? (' header-hover-style-'.$pacz_settings['header-hover-style']) : '';
		$header_class .= ($header_structure == 'standard') ? (' put-header-'.$pacz_settings['header-location']) : '';

		if($header_structure != 'vertical') {
			if($toolbar && is_page()){
				if($toolbar_option == 'true'){
					if(isset($header_toolbar_grid) && $header_toolbar_grid == 1){
					echo '<div class="pacz-header-toolbar transparent-header pacz-grid">';
					}else{
					echo '<div class="pacz-header-toolbar">';
					}
						echo esc_attr($boxed_header) && $header_structure != 'vertical' ? '<div class="pacz-grid">' : '';
					  
						if($pacz_logo_location == 'header_toolbar' && $pacz_logo_align == 'left' )  {
							echo '<div class="logo-left"><ul>';
							do_action( 'header_logo' );
							echo'</ul></div>';
						}
						elseif($pacz_logo_location == 'header_toolbar' && $pacz_logo_align == 'center' )  {
							echo '<div class="logo-center"><ul>';
							do_action( 'header_logo' );
							echo'</ul></div>';
						}
						elseif($pacz_logo_location == 'header_toolbar' && $pacz_logo_align == 'right' )  {
							echo '<div class="logo-right"><ul>';
							do_action( 'header_logo' );
							echo'</ul></div>';
						}
						if($pacz_settings['checkout-box'] && $pacz_settings['checkout-box-location'] == 'header_toolbar' && $pacz_settings['checkout-box-align'] == 'left')   {
							echo '<ul class="header-checkout-left ">';
								do_action( 'header_checkout' );
							echo '</ul>';
						}
						elseif($pacz_settings['checkout-box'] && $pacz_settings['checkout-box-location'] == 'header_toolbar' && $pacz_settings['checkout-box-align'] == 'center')   {
							echo '<ul class="header-checkout-center ">';
								do_action( 'header_checkout' );
							echo '</ul>';
						}
						elseif($pacz_settings['checkout-box'] && $pacz_settings['checkout-box-location'] == 'header_toolbar' && $pacz_settings['checkout-box-align'] == 'right')   {
							echo '<ul class="header-checkout-right ">';
								do_action( 'header_checkout' );
							echo '</ul>';
						}
						if($listing_btn_location == 'header_toolbar' && $listing_btn_align == 'left' )  {
							echo '<div class="listing-btn-left"><ul>';
							do_action( 'nav_listing_btn' );
							echo'</ul></div>';
						}
						elseif($listing_btn_location == 'header_toolbar' && $listing_btn_align == 'center' )  {
							echo '<div class="listing-btn-center"><ul>';
							do_action( 'nav_listing_btn' );
							echo'</ul></div>';
						}
						elseif($listing_btn_location == 'header_toolbar' && $listing_btn_align == 'right' )  {
							echo '<div class="listing-btn-right"><ul>';
							do_action( 'nav_listing_btn' );
							echo'</ul></div>';
						}
						if($login_reg_btn_align == 'left' && $login_reg_btn_location == 'header_toolbar'){
							echo '<div class="header-toolbar-log-reg-btn aligh-left">';
							do_action('header_logreg');
							echo '</div>';
						}elseif($login_reg_btn_align == 'center' && $login_reg_btn_location == 'header_toolbar'){
							echo '<div class="header-toolbar-log-reg-btn aligh-center">';
							do_action('header_logreg');
							echo '</div>';
						}elseif($login_reg_btn_align == 'right' && $login_reg_btn_location == 'header_toolbar'){
							echo '<div class="header-toolbar-log-reg-btn aligh-right">';
							do_action('header_logreg');
							echo '</div>';
						}
						if($header_contact_details_location == 'header_toolbar' && $header_contact_details_align == 'left' ) {
							echo '<div class="contact-left">';
								do_action('header_toolbar_contact');
							echo'</div>';
						}
						elseif($header_contact_details_location == 'header_toolbar' && $header_contact_details_align == 'center' ) {
							echo '<div class="contact-center">';
								do_action('header_toolbar_contact');
							echo'</div>';
						}
						elseif($header_contact_details_location == 'header_toolbar' && $header_contact_details_align == 'right' ) {
							echo '<div class="contact-right">';
								do_action('header_toolbar_contact');
							echo'</div>';
						}
						if($header_toolbar_social_location == 'header_toolbar' && $header_toolbar_social_align == 'left' ) {
							echo '<ul class="pacz-header-toolbar-social left ">';
								do_action('header_toolbar_social');
							echo '</ul>';
						}
						elseif($header_toolbar_social_location == 'header_toolbar' && $header_toolbar_social_align == 'center' ) {
							echo '<ul class="pacz-header-toolbar-social center ">';
								do_action('header_toolbar_social');
							echo '</ul>';
						}
						elseif($header_toolbar_social_location == 'header_toolbar' && $header_toolbar_social_align == 'right' ) {
							echo '<ul class="pacz-header-toolbar-social right ">';
								do_action('header_toolbar_social');
							echo '</ul>';
						}
						do_action('header_toolbar_menu');
						
						echo esc_attr($boxed_header) && $header_structure != 'vertical' ? '</div>' : '' ;
					echo '</div>';
					echo '<div class="pacz-responsive-header-toolbar"><a href="#" class="pacz-toolbar-responsive-icon"><i class="pacz-icon-chevron-down"></i></a></div>';
				}
			
			}else if($toolbar){
				if($toolbar){
					if(isset($header_toolbar_grid) && $header_toolbar_grid == 1){
					echo '<div class="pacz-header-toolbar transparent-header pacz-grid">';
					}else{
					echo '<div class="pacz-header-toolbar">';
					}
						echo esc_attr($boxed_header) && $header_structure != 'vertical' ? '<div class="pacz-grid">' : '';
					  
						if($pacz_logo_location == 'header_toolbar' && $pacz_logo_align == 'left' )  {
							echo '<div class="logo-left"><ul>';
							do_action( 'header_logo' );
							echo'</ul></div>';
						}
						elseif($pacz_logo_location == 'header_toolbar' && $pacz_logo_align == 'center' )  {
							echo '<div class="logo-center"><ul>';
							do_action( 'header_logo' );
							echo'</ul></div>';
						}
						elseif($pacz_logo_location == 'header_toolbar' && $pacz_logo_align == 'right' )  {
							echo '<div class="logo-right"><ul>';
							do_action( 'header_logo' );
							echo'</ul></div>';
						}
						if($pacz_settings['checkout-box'] && $pacz_settings['checkout-box-location'] == 'header_toolbar' && $pacz_settings['checkout-box-align'] == 'left')   {
							echo '<ul class="header-checkout-left ">';
								do_action( 'header_checkout' );
							echo '</ul>';
						}
						elseif($pacz_settings['checkout-box'] && $pacz_settings['checkout-box-location'] == 'header_toolbar' && $pacz_settings['checkout-box-align'] == 'center')   {
							echo '<ul class="header-checkout-center ">';
								do_action( 'header_checkout' );
							echo '</ul>';
						}
						elseif($pacz_settings['checkout-box'] && $pacz_settings['checkout-box-location'] == 'header_toolbar' && $pacz_settings['checkout-box-align'] == 'right')   {
							echo '<ul class="header-checkout-right ">';
								do_action( 'header_checkout' );
							echo '</ul>';
						}
						if($listing_btn_location == 'header_toolbar' && $listing_btn_align == 'left' )  {
							echo '<div class="listing-btn-left"><ul>';
							do_action( 'nav_listing_btn' );
							echo'</ul></div>';
						}
						elseif($listing_btn_location == 'header_toolbar' && $listing_btn_align == 'center' )  {
							echo '<div class="listing-btn-center"><ul>';
							do_action( 'nav_listing_btn' );
							echo'</ul></div>';
						}
						elseif($listing_btn_location == 'header_toolbar' && $listing_btn_align == 'right' )  {
							echo '<div class="listing-btn-right"><ul>';
							do_action( 'nav_listing_btn' );
							echo'</ul></div>';
						}
						if($login_reg_btn_align == 'left' && $login_reg_btn_location == 'header_toolbar'){
							echo '<div class="header-toolbar-log-reg-btn aligh-left">';
							do_action('header_logreg');
							echo '</div>';
						}elseif($login_reg_btn_align == 'center' && $login_reg_btn_location == 'header_toolbar'){
							echo '<div class="header-toolbar-log-reg-btn aligh-center">';
							do_action('header_logreg');
							echo '</div>';
						}elseif($login_reg_btn_align == 'right' && $login_reg_btn_location == 'header_toolbar'){
							echo '<div class="header-toolbar-log-reg-btn aligh-right">';
							do_action('header_logreg');
							echo '</div>';
						}
						if($header_contact_details_location == 'header_toolbar' && $header_contact_details_align == 'left' ) {
							echo '<div class="contact-left">';
								do_action('header_toolbar_contact');
							echo'</div>';
						}
						elseif($header_contact_details_location == 'header_toolbar' && $header_contact_details_align == 'center' ) {
							echo '<div class="contact-center">';
								do_action('header_toolbar_contact');
							echo'</div>';
						}
						elseif($header_contact_details_location == 'header_toolbar' && $header_contact_details_align == 'right' ) {
							echo '<div class="contact-right">';
								do_action('header_toolbar_contact');
							echo'</div>';
						}
						if($header_toolbar_social_location == 'header_toolbar' && $header_toolbar_social_align == 'left' ) {
							echo '<ul class="pacz-header-toolbar-social left ">';
								do_action('header_toolbar_social');
							echo '</ul>';
						}
						elseif($header_toolbar_social_location == 'header_toolbar' && $header_toolbar_social_align == 'center' ) {
							echo '<ul class="pacz-header-toolbar-social center ">';
								do_action('header_toolbar_social');
							echo '</ul>';
						}
						elseif($header_toolbar_social_location == 'header_toolbar' && $header_toolbar_social_align == 'right' ) {
							echo '<ul class="pacz-header-toolbar-social right ">';
								do_action('header_toolbar_social');
							echo '</ul>';
						}
						do_action('header_toolbar_menu');
						
						echo esc_attr($boxed_header) && $header_structure != 'vertical' ? '</div>' : '' ;
					echo '</div>';
					echo '<div class="pacz-responsive-header-toolbar"><a href="#" class="pacz-toolbar-responsive-icon"><i class="pacz-icon-chevron-down"></i></a></div>';
				}
			}
		}
	
$detect_mobile = new Mobile_Detect();
if($detect_mobile->isMobile()){
	get_template_part( 'includes/templates/mobile-header');
}else{
	
	?>
<header id="pacz-header" class="<?php echo esc_attr($header_class); ?> <?php echo esc_attr($header_grid); ?> <?php echo esc_attr($header_grid_margin); ?> theme-main-header pacz-header-module" data-header-style="<?php echo esc_attr($header_style); ?>" data-header-structure="<?php echo esc_attr($header_structure); ?>" data-transparent-skin="<?php echo esc_attr($trans_header_skin); ?>" data-height="<?php echo intval($header_height); ?>" data-sticky-height="<?php echo intval($header_sticky_height); ?>">
<?php

  if($boxed_header && $header_structure != 'vertical') {
    echo '<div class="pacz-header-mainnavbar"><div class="pacz-grid clearfix">';
  }
  
  $new_header_style = 'classiads-fantro';
  if($preset_headers == 12){
		echo '<div class="classiads-fantro-logo">';
			do_action('header_logo');
		echo '</div>';
		echo '<div class="classiads-fantro-header-content">';
	  if(is_user_logged_in() && !empty($pacz_settings['loggedin_menu'])) {
          $menu_location = $pacz_settings['loggedin_menu'];
          do_action( 'vertical_navigation', $menu_location );
          do_action( 'main_navigation', $menu_location );
		  echo do_shortcode('[webdirectory-search search_form_type="4"]');
        }else{
			$pacz_menu_location = 'primary-menu';
          do_action( 'vertical_navigation', 'primary-menu' );
          do_action( 'main_navigation', 'primary-menu' );
		  echo do_shortcode('[webdirectory-search search_form_type="4"]');
        }
		echo '</div>';
  }else{
if(is_page()) {
		if(is_user_logged_in() && !empty($pacz_settings['loggedin_menu'])) {
			$pacz_menu_location = get_post_meta( $post_id, '_menu_location', true ) ? get_post_meta( $post_id, '_menu_location', true ) : $pacz_settings['loggedin_menu'];
		}else{
			$pacz_menu_location = 'primary-menu';
		}
          do_action( 'vertical_navigation', $pacz_menu_location );
          do_action( 'main_navigation', $pacz_menu_location );
      } else {
        if(is_user_logged_in() && !empty($pacz_settings['loggedin_menu'])) {
          $menu_location = $pacz_settings['loggedin_menu'];
          do_action( 'vertical_navigation', $menu_location );
          do_action( 'main_navigation', $menu_location );
        }else{
			$pacz_menu_location = 'primary-menu';
          do_action( 'vertical_navigation', 'primary-menu' );
          do_action( 'main_navigation', 'primary-menu' );
        }
      }
  }
  if($pacz_settings['boxed-header'] && $header_structure != 'vertical') {
    echo '</div></div>';
  }

    if($header_toolbar_social_location == 'header_section') {
      do_action('header_social', 'outside-grid');
    }
?>
</header>
<?php } ?>



<?php if($pacz_settings['header-location'] != 'bottom') : ?>
<div class="sticky-header-padding <?php echo esc_attr($header_padding_class);?>"></div>
<?php endif; ?>

<?php endif; ?>


<?php

if($post_id && $layout_template != 'no-title') {
  if($layout_template != 'no-footer-title' && $layout_template != 'no-sub-footer-title' && $layout_template != 'no-title-footer' && $layout_template != 'no-title-sub-footer' && $layout_template != 'no-title-footer-sub-footer') {
      do_action('page_title');
  }
} else {
  do_action('page_title');
}


?>

