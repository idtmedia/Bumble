<?php
/**
 *
 *
 * @author  Designinvento
 * @copyright (c) Designinvento
 * @link  http://designinvento.net
 * @since  Version 2.0
 * @package  ClassiadsPro
 */



add_action( 'header_logo', 'pacz_header_logo' );
add_action( 'header_mobile_logo', 'pacz_header_mobile_logo' );
add_action( 'main_navigation', 'pacz_main_navigation' );
add_action( 'vertical_navigation', 'pacz_vertical_navigation' );
add_action( 'header_search', 'pacz_header_search' );
add_action( 'header_logreg', 'pacz_header_logreg' );
if(!is_contractor()){
	add_action( 'nav_listing_btn', 'pacz_nav_listing_btn' );
}
add_action( 'header_search_form', 'pacz_header_search_form' );
add_action( 'header_social', 'pacz_header_social');
add_action( 'header_toolbar_social', 'pacz_header_toolbar_social');
add_action( 'header_toolbar_contact', 'pacz_header_toolbar_contact');
add_action( 'header_contact', 'pacz_header_contact');
add_action( 'dashboard_trigger_link', 'pacz_dashboard_trigger_link' );
add_action( 'responsive_nav_trigger_link', 'pacz_responsive_nav_trigger_link' );
add_action( 'responsive_nav_listing_search_link', 'pacz_responsive_nav_search_link' );
add_action( 'margin_style_burger_icon', 'pacz_margin_style_burger_icon' );
add_action( 'vertical_header_burger_icon', 'pacz_vertical_header_burger_icon' );
add_action( 'pacz_header_login_active_menu_mobile', 'pacz_header_login_active_menu' );





/*
* Create Header Logo
******/
if ( !function_exists( 'pacz_header_logo' ) ) {
	function pacz_header_logo() {

		global $pacz_settings,$allowedtags;
		$logo = isset($pacz_settings['logo']['url']) ? $pacz_settings['logo']['url'] : '';
		$logo_retina = isset($pacz_settings['logo-retina']['url']) ? $pacz_settings['logo-retina']['url'] : '';
		$mobile_logo = isset($pacz_settings['mobile-logo']['url']) ? $pacz_settings['mobile-logo']['url'] : '';
		$mobile_logo_retina = isset($pacz_settings['mobile-logo-retina']['url']) ? $pacz_settings['mobile-logo-retina']['url'] : '';

		$post_id = global_get_post_id();

		if($post_id) {

			$enable = get_post_meta($post_id, '_custom_bg', true );

			if($enable == 'true') {
				$logo_meta = get_post_meta($post_id, 'logo', true );
				$logo_retina_meta = get_post_meta($post_id, 'logo_retina', true );
				$logo_mobile_meta = get_post_meta($post_id, 'responsive_logo', true );
				$logo_mobile_retina_meta = get_post_meta($post_id, 'responsive_logo_retina', true );

				$logo = (isset($logo_meta) && !empty($logo_meta)) ? $logo_meta : $logo;
				$logo_retina = (isset($logo_retina_meta) && !empty($logo_retina_meta)) ? $logo_retina_meta : $logo_retina;
				$mobile_logo = (isset($logo_mobile_meta) && !empty($logo_mobile_meta)) ? $logo_mobile_meta : $mobile_logo;
				$mobile_logo_retina = (isset($logo_mobile_retina_meta) && !empty($logo_mobile_retina_meta)) ? $logo_mobile_retina_meta : $mobile_logo_retina;
			}
		}

		//$mobile_logo_csss = (!empty($mobile_logo)) ? 'mobile-menu-exists' : '';

		$output = '<li class="pacz-header-logo">';
		$output .= '<a href="'.esc_url(home_url( '/' )).'" title="'.get_bloginfo( 'name' ).'">';

		if ( !empty( $logo ) ) {
			$output .= '<img alt="'.get_bloginfo( 'name' ).'" class="pacz-dark-logo" src="'.$logo.'" data-retina-src="'.$logo_retina.'" />';
		} else {
			$output .= '<img alt="'.get_bloginfo( 'name' ).'" class="pacz-dark-logo" src="'.PACZ_THEME_IMAGES.'/classiadspro-logo.png" data-retina-src="'.PACZ_THEME_IMAGES.'/classiadspro-logo-2x.png" />';
		}
		$output .= '</a></li>';

		echo wp_kses_post($output);

	}
}
if ( !function_exists( 'pacz_header_mobile_logo' ) ) {
	function pacz_header_mobile_logo() {

		global $pacz_settings,$allowedtags;
		$mobile_logo = isset($pacz_settings['mobile-logo']['url']) ? $pacz_settings['mobile-logo']['url'] : '';
		$mobile_logo_retina = isset($pacz_settings['mobile-logo-retina']['url']) ? $pacz_settings['mobile-logo-retina']['url'] : '';

		$post_id = global_get_post_id();

		if($post_id) {

			$enable = get_post_meta($post_id, '_custom_bg', true );

			if($enable == 'true') {
				$logo_mobile_meta = get_post_meta($post_id, 'responsive_logo', true );
				$logo_mobile_retina_meta = get_post_meta($post_id, 'responsive_logo_retina', true );
				
				$mobile_logo = (isset($logo_mobile_meta) && !empty($logo_mobile_meta)) ? $logo_mobile_meta : $mobile_logo;
				$mobile_logo_retina = (isset($logo_mobile_retina_meta) && !empty($logo_mobile_retina_meta)) ? $logo_mobile_retina_meta : $mobile_logo_retina;
			}
		}

		$mobile_logo_csss = (!empty($mobile_logo)) ? 'mobile-menu-exists' : '';

		$output = '';
		$output .= '<a href="'.esc_url(home_url( '/' )).'" title="'.get_bloginfo( 'name' ).'">';

		if ( !empty( $mobile_logo) ) {
			$output .= '<img alt="'.get_bloginfo( 'name' ).'" class="pacz-mobile-logo" src="'.$mobile_logo.'" data-retina-src="'.$mobile_logo_retina.'" />';
		}
		$output .= '</a>';

		echo wp_kses_post($output);

	}
}
/***************************************/








/***********************************
Create Vertical Navigation
***********************************/
if(!function_exists('pacz_vertical_navigation')) {
	function pacz_vertical_navigation($menu_location) {
	global $pacz_settings;
	$post_id = global_get_post_id();
	$header_structure = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'header-structure', true ) : $pacz_settings['header-structure'];
	
	$header_style = $header_structure;

	if($header_style != 'vertical') return false;

	echo wp_nav_menu( array(
		'theme_location' => $menu_location,
		'container' => false,
		'container_id' => false,
		'container_class' => false,
		'menu_class' => 'pacz-vertical-menu',
		'fallback_cb' => '',
		'walker' => new header_icon_walker()
	));
	}
}






/*
* Create Header Search HTML content
******/
if ( !function_exists( 'pacz_header_search' ) ) {
	function pacz_header_search() {
		global $pacz_settings;
		
		$header_location = (isset($pacz_settings['header-search-location']) && !empty($pacz_settings['header-search-location']) && $pacz_settings['header-search-location'] == 'left') ? 'align-left' : '';
		if($pacz_settings['header-search']){
			echo '<li class="pacz-header-search '.$header_location.'">
				<a class="header-search-icon" href="#"><i class="pacz-icon-search"></i></a>
			</li>';	
		}
	}
}
/***************************************/


/*
* Create Header Login Register Buttons
******/
if ( !function_exists( 'pacz_header_logreg' ) ) {
	function pacz_header_logreg() {
		global $pacz_settings;
		 $preset_header_style = $pacz_settings['preset_headers'];
		$logedin_user = wp_get_current_user()->ID;
		$logedin_user_display_name = get_the_author_meta( 'display_name', $logedin_user );
		$logedin_user_name = get_the_author_meta( 'user_nicename', $logedin_user );
		require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";
		$author_img_url = get_the_author_meta('pacz_author_avatar_url', $logedin_user, true); 
		if($preset_header_style == 12){
			if(!empty($author_img_url)) {
				$params = array( 'width' => 37, 'height' => 37, 'crop' => true );
				$user_thumb = "<img src='" . bfi_thumb( "$author_img_url", $params ) . "' alt='".$logedin_user_name."' />";
			} elseif(function_exists('pacz_get_avatar_url')){ 
				$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $logedin_user), $size = '37' );
				$user_thumb ='<img src="'.$avatar_url.'" alt="'.$logedin_user_name.'" />';
			}else{
				$user_thumb ='';
			}
		}else{
			if(!empty($author_img_url)) {
				$params = array( 'width' => 48, 'height' => 48, 'crop' => true );
				$user_thumb = "<img src='" . bfi_thumb( "$author_img_url", $params ) . "' alt='".$logedin_user_name."' />";
			} elseif(function_exists('pacz_get_avatar_url')){  
				$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $logedin_user), $size = '48' );
				$user_thumb ='<img src="'.$avatar_url.'" alt="'.$logedin_user_name.'" />';
			}else{
				$user_thumb ='';
			}
		}
		
		$login = $pacz_settings['pacz-login-slug'];
		$register = $pacz_settings['pacz-register-slug'];
		if(!empty($pacz_settings['pacz-logreg-header-btn']) && isset($pacz_settings['pacz-logreg-style']) && $pacz_settings['pacz-logreg-style'] == 1){
			if(is_user_logged_in()){
				if(class_exists('alsp_dashboard_controller')){
					echo '<div class="dropdown clearfix">';
						echo '<button class="dropbtn">'.$user_thumb .'<p class="author-name-header"><span class="author-displayname">'.$logedin_user_display_name.'</span><span class="author-nicename">'.$logedin_user_name.'</span></p></button>';
						global $frontend_controller;
						//if($frontend_controller->listings_count > 0){
							//$listing_count = $frontend_controller->listings_count;
						//}else{
							//$listing_count = 0;
						//}
						echo '<div class="dropdown-content"><ul class="clearfix">';
                             if(is_contractor()){
                                 echo '<li><i class="pacz-icon-file-o"></i><a href="'.alsp_dashboardUrl(array('alsp_action' => 'my_bids')).'">'.esc_html__('My Bids', 'classiadspro').'</a></li>';
                             }else{
                                 echo '<li><i class="pacz-icon-file-o"></i><a href="'.alsp_dashboardUrl().'">'.esc_html__('My Dashboard', 'classiadspro').'</a></li>';
                                 echo '<li><i class="pacz-icon-check-square-o"></i><a href="'.alsp_dashboardUrl().'">'.esc_html__('My Listings', 'classiadspro').'</a></li>';
                             }
                             echo '<li><i class="pacz-icon-check-square-o"></i><a href="'.alsp_dashboardUrl(array('alsp_action' => 'messages')).'">'.esc_html__('My Messages', 'classiadspro').'</a></li>';
                             echo '<li><i class="pacz-li-settings"></i><a href="'.alsp_dashboardUrl(array('alsp_action' => 'profile')).'">'.esc_html__('Edit Profile', 'classiadspro').'</a></li>';
							echo '<li>';
								//echo '<i class="pacz-fic-money"></i>';
								//echo do_action('alsp_dashboard_links2', $frontend_controller);
							echo '</li>';
							echo '<li><i class="pacz-icon-sign-out"></i><a href="'.wp_logout_url(esc_url( home_url('/'))).'">'.esc_html__('logout', 'classiadspro').'</a></li>';
						echo '<ul></div>';
					echo '</div>'; 
				}else{
					echo '<a class="pacz-logout clearfix" href="'.wp_logout_url(esc_url( home_url('/'))).'">'.esc_html__('logout', 'classiadspro').'<i class="pacz-icon-unlock"></i></a>';
				}
			}else{
				echo '<a class="pacz-login clearfix" href="'.esc_url(home_url('/').$login).'">'.esc_html__('login', 'classiadspro').'<i class="pacz-icon-lock"></i></a>';
				echo '<a class="pacz-register" href="'.esc_url(home_url('/').$register).'">'.esc_html__('Register', 'classiadspro').'</a>';
			}
		}else if(!empty($pacz_settings['pacz-logreg-header-btn']) && isset($pacz_settings['pacz-logreg-style']) && $pacz_settings['pacz-logreg-style'] == 2){
			if(is_user_logged_in()){
				if(class_exists('alsp_dashboard_controller')){
					echo '<div class="dropdown">';
						echo '<button class="dropbtn">'.$user_thumb .'<p class="author-name-header"><span class="author-displayname">'.$logedin_user_display_name.'</span><span class="author-nicename">'.$logedin_user_name.'</span></p></button>';
						echo '<div class="dropdown-content"><ul class="clearfix">';
                            if(is_contractor()){
                                echo '<li><i class="pacz-icon-file-o"></i><a href="'.alsp_dashboardUrl(array('alsp_action' => 'my_bids')).'">'.esc_html__('My Bids', 'classiadspro').'</a></li>';
                            }else{
                                echo '<li><i class="pacz-icon-file-o"></i><a href="'.alsp_dashboardUrl().'">'.esc_html__('My Dashboard', 'classiadspro').'</a></li>';
                                echo '<li><i class="pacz-icon-check-square-o"></i><a href="'.alsp_dashboardUrl().'">'.esc_html__('My Listings', 'classiadspro').'</a></li>';
                            }
                            echo '<li><i class="pacz-icon-check-square-o"></i><a href="'.alsp_dashboardUrl(array('alsp_action' => 'messages')).'">'.esc_html__('My Messages', 'classiadspro').'</a></li>';
                            echo '<li><i class="pacz-li-settings"></i><a href="'.alsp_dashboardUrl(array('alsp_action' => 'profile')).'">'.esc_html__('Edit Profile', 'classiadspro').'</a></li>';
							//echo '<li>';
								//echo '<i class="pacz-fic-money"></i>';
								//echo do_action('alsp_dashboard_links2', $frontend_controller);
							//echo '</li>';
							echo '<li><i class="pacz-icon-sign-out"></i><a href="'.wp_logout_url(esc_url( home_url('/'))).'">'.esc_html__('logout', 'classiadspro').'</a></li>';
						echo '<ul></div>';
					echo '</div>'; 
				}else{
					echo '<a class="pacz-logout-2 clearfix" href="'.wp_logout_url(esc_url( home_url('/'))).'">'.esc_html__('logout', 'classiadspro').'</a>';
				} 
			}else{
				if($preset_header_style == 12){
					echo '<a class="pacz-login-3 clearfix" href="'.esc_url(home_url('/').$login).'"><i class="pacz-li-user"></i>'.esc_html__('login', 'classiadspro').'</a>';
					echo '<span class="pacz-login-3-div">&#47;</span>';
					echo '<a class="pacz-register-3" href="'.esc_url(home_url('/').$register).'">'.esc_html__('Register', 'classiadspro').'</a>';
				}else{
					echo '<a class="pacz-login-2 clearfix" href="'.esc_url(home_url('/').$login).'">'.esc_html__('login', 'classiadspro').'</a>';
					echo '<a class="pacz-register-2" href="'.esc_url(home_url('/').$register).'">'.esc_html__('Register', 'classiadspro').'</a>';
				}
			}
		}
	}
}
/***************************************/

/*
* Create Header Login Register Buttons
******/
if ( !function_exists( 'pacz_header_login_active_menu' ) ) {
	function pacz_header_login_active_menu() {
		global $pacz_settings;
		
		$logedin_user = wp_get_current_user()->ID;
		$logedin_user_display_name = get_the_author_meta( 'display_name', $logedin_user );
		$logedin_user_name = get_the_author_meta( 'user_nicename', $logedin_user );
		require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";
		$author_img_url = get_the_author_meta('pacz_author_avatar_url', $logedin_user, true); 
			if(!empty($author_img_url)) {
				$params = array( 'width' => 70, 'height' => 70, 'crop' => true );
				$user_thumb = "<img src='" . bfi_thumb( "$author_img_url", $params ) . "' alt='".$logedin_user_name."' />";
			} else { 
				$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $logedin_user), $size = '70' );
				$user_thumb ='<img src="'.$avatar_url.'" alt="'.$logedin_user_name.'" />';
			}
		
		$login = $pacz_settings['pacz-login-slug'];
		$register = $pacz_settings['pacz-register-slug'];
		
			if(is_user_logged_in()){
				if(class_exists('alsp_dashboard_controller')){
					echo '<div class="mobile-active-menu-user-wrap">';
						echo '<div class="mobile-active-menu-user-thumb"><span class="user_default_image">'.$user_thumb .'</span></div>';
						echo '<p class="mobile-active-menu-logreg-links"><span class="author-displayname">'.$logedin_user_display_name.'</span><br/><span class="author-nicename">'.$logedin_user_name.'</span><br/><a href="'.alsp_dashboardUrl().'">'.esc_html__('My Dashboard', 'classiadspro').'</a></p>';
					echo '</div>';
				}else{
					echo '<a class="pacz-logout clearfix" href="'.wp_logout_url(esc_url( home_url('/'))).'">'.esc_html__('logout', 'classiadspro').'<i class="pacz-icon-unlock"></i></a>';
				}
			}else{
				echo '<div class="mobile-active-menu-user-wrap">';
					echo '<div class="mobile-active-menu-user-thumb"><span class="user_default_image"><i class="pacz-li-user"></i></span></div>';
					echo '<p class="mobile-active-menu-logreg-links"><a class="" href="'.esc_url(home_url('/').$login).'">'.esc_html__('login', 'classiadspro').'</a> '.esc_html__('or create your', 'classiadspro').' <a class="" href="'.esc_url(home_url('/').$register).'">'.esc_html__('Account', 'classiadspro').'</a> '.esc_html__('With us', 'classiadspro').'</p>';
				echo '</div>';
			}
	}
}
/***************************************/

/*
* Create Header listing button HTML content
******/
if ( !function_exists( 'pacz_nav_listing_btn' ) ) {
	function pacz_nav_listing_btn() {
		global $pacz_settings;
		$listing_btn_style = (isset($pacz_settings['listing_btn_style']))? $pacz_settings['listing_btn_style']: '';
		$header_listing_url = $pacz_settings['listing-btn-url'];
		$header_listing_btn_text = $pacz_settings['listing-btn-text'];
		$listing_btn_align = $pacz_settings['listing-btn-align'];
		if(empty($pacz_settings['listing-btn'])){
			$detect_mobile = new Mobile_Detect();
			if(!$detect_mobile->isMobile()){
				if($listing_btn_style == 1){
					echo '<li class="listing-btn '.$listing_btn_align.'">
						<a class="listing-header-btn one" href="'.$header_listing_url.'">'.$header_listing_btn_text.'</a>
					</li>';	
				}else if($listing_btn_style == 2){
					echo '<li class="listing-btn '.$listing_btn_align.'">
						<a class="listing-header-btn listing-btn-style2" href="'.$header_listing_url.'">'.$header_listing_btn_text.'</a>
					</li>';	
				}
			}else{
				echo '<div class="listing-btn mobile-submit">
					<a class="listing-header-btn two" href="'.$header_listing_url.'">'.$header_listing_btn_text.'</a>
				</div>';
			}
		}
	}
}
/***************************************/

/*
* Create WPML Language Selector HTML content
******/
if(defined('ICL_SITEPRESS_VERSION') && defined('ICL_LANGUAGE_CODE')) 
{
	if(!function_exists('pacz_wpml_selector'))
	{
		function pacz_wpml_selector() {
			$languages = icl_get_languages('skip_missing=0&orderby=id');
			$output = "";

			if(is_array($languages))
			{
				
	       		$output .= '<li class="pacz-header-wpml-ls">
	       						<a class="header-wpml-icon" href="#">
	       							<i class="pacz-icon-globe"></i>
	       						</a>';
				$output .= '	<ul class="language-selector-box">';
				foreach($languages as $lang)
				{
					$output .= "	<li class='language_".$lang['language_code']."'>
										<a href='".$lang['url']."'>";
					$output .= "			<span class='pacz-lang-name'>".$lang['translated_name']."</span>";
					$output .= "		</a>
									</li>";
				}
				$output .= "	</ul>";
				$output .= "</li>";
			}
			
			echo wp_kses_post($output);
		}
	}

	add_action( 'header_wpml', 'pacz_wpml_selector');
}
/***************************************/




/*
* Create Header Search Form HTML content
******/
if ( !function_exists( 'pacz_header_search_form' ) ) {
	function pacz_header_search_form() {

	echo '<form method="get" class="header-searchform-input" action="'.esc_url(home_url('/')).'">
            <input class="search-ajax-input" type="text" value="" name="s" id="s" />
            <input value="" type="submit" />
            <a href="#" class="header-search-close"><i class="pacz-icon-close"></i></a>
   		 </form>';

	}
}
/***************************************/

/*
* Create Responsive Navigation trigger link Form HTML content. Please note that this link will appear in reposnive mode.
******/
if ( !function_exists( 'pacz_responsive_nav_trigger_link' ) ) {
	function pacz_responsive_nav_trigger_link() {

		echo '<li class="responsive-nav-link">
			<div class="pacz-burger-icon">
	              <div class="burger-icon-1"></div>
	              <div class="burger-icon-2"></div>
	              <div class="burger-icon-3"></div>
            	</div>
		</li>';

	}
}
/*
* Create Responsive Navigation trigger link Form HTML content. Please note that this link will appear in reposnive mode.
******/
if ( !function_exists( 'pacz_responsive_nav_search_link' ) ) {
	function pacz_responsive_nav_search_link() {

		echo '<div class="responsive-nav-search-link"><div class="pacz-burger-icon search-burgur pacz-theme-icon-search"></div></div>';

	}
}
/***************************************/





/*
* Header Section Social Networks
******/
if ( !function_exists( 'pacz_header_social' ) ) {
	function pacz_header_social($location) {
		global $pacz_settings;

		if($pacz_settings['header-social-select'] == 'disabled') return false;
		if($pacz_settings['header-social-select'] == 'header_toolbar') return false;

		$output = '';

		if($location == 'outside-grid') {
			$output .= '<div class="pacz-header-social '.$location.'">';
		} else {
			$output .= '<li class="pacz-header-social '.$location.'">';	
		}	
		
		

		if(!empty($pacz_settings['header-social-facebook'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-facebook'].'"><i class="pacz-icon-facebook"></i></a>';
		}
		if(!empty($pacz_settings['header-social-twitter'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-twitter'].'"><i class="pacz-icon-twitter"></i></a>';
		}
		if(!empty($pacz_settings['header-social-google-plus'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-google-plus'].'"><i class="pacz-icon-google-plus"></i></a>';
		}
		if(!empty($pacz_settings['header-social-rss'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-rss'].'"><i class="pacz-icon-rss"></i></a>';
		}
		if(!empty($pacz_settings['header-social-pinterest'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-pinterest'].'"><i class="pacz-icon-pinterest"></i></a>';
		}
		if(!empty($pacz_settings['header-social-instagram'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-instagram'].'"><i class="pacz-icon-instagram"></i></a>';
		}
		if(!empty($pacz_settings['header-social-dribbble'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-dribbble'].'"><i class="pacz-icon-dribbble"></i></a>';
		}
		if(!empty($pacz_settings['header-social-linkedin'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-linkedin'].'"><i class="pacz-icon-linkedin"></i></a>';
		}
		if(!empty($pacz_settings['header-social-tumblr'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-tumblr'].'"><i class="pacz-icon-tumblr"></i></a>';
		}
		if(!empty($pacz_settings['header-social-youtube'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-youtube'].'"><i class="pacz-icon-youtube"></i></a>';
		}
		if(!empty($pacz_settings['header-social-vimeo'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-vimeo'].'"><i class="pacz-theme-icon-social-vimeo"></i></a>';
		}
		if(!empty($pacz_settings['header-social-spotify'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-spotify'].'"><i class="pacz-theme-icon-social-spotify"></i></a>';
		}

		if(!empty($pacz_settings['header-social-weibo'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-weibo'].'"><i class="pacz-theme-icon-weibo"></i></a>';
		}
		if(!empty($pacz_settings['header-social-wechat'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-wechat'].'"><i class="pacz-theme-icon-wechat"></i></a>';
		}
		if(!empty($pacz_settings['header-social-renren'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-renren'].'"><i class="pacz-theme-icon-renren"></i></a>';
		}
		if(!empty($pacz_settings['header-social-imdb'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-imdb'].'"><i class="pacz-theme-icon-imdb"></i></a>';
		}
		if(!empty($pacz_settings['header-social-vkcom'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-vkcom'].'"><i class="pacz-theme-icon-vk"></i></a>';
		}
		if(!empty($pacz_settings['header-social-qzone'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-qzone'].'"><i class="pacz-theme-icon-qzone"></i></a>';
		}
		if(!empty($pacz_settings['header-social-whatsapp'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-whatsapp'].'"><i class="pacz-theme-icon-whatsapp"></i></a>';
		}
		if(!empty($pacz_settings['header-social-behance'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-behance'].'"><i class="pacz-theme-icon-behance"></i></a>';
		}

		if($location == 'outside-grid') {
			$output .= '</div>';	
		} else {
			$output .= '</li>';
		}
		

		echo wp_kses_post($output);
	}
}






/*
* Header Structure margin burger icon
******/
if ( !function_exists( 'pacz_margin_style_burger_icon' ) ) {
	function pacz_margin_style_burger_icon() {

		global $pacz_settings;
	$post_id = global_get_post_id();
	$header_structure = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'header-structure', true ) : $pacz_settings['header-structure'];
	

		if($header_structure != 'margin') return false;

		echo '<div class="pacz-margin-header-burger">
				<div class="pacz-burger-icon">
	              <i class="pacz-fic3-list-3"></i>
				  <i class="pacz-flaticon-cross39"></i>
            	</div>
              </div>';

	}
}
/***************************************/



/*
* Header Structure Vertical burger icon
******/
if ( !function_exists( 'pacz_vertical_header_burger_icon' ) ) {
	function pacz_vertical_header_burger_icon() {

		global $pacz_settings;
	$post_id = global_get_post_id();
	$header_structure = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'header-structure', true ) : $pacz_settings['header-structure'];
	

		

		if($header_structure == 'vertical' && $pacz_settings['vertical-header-state'] == 'condensed') {

				echo '<li class="pacz-vertical-header-burger">
						<div class="pacz-burger-icon">
			              <div class="burger-icon-1"></div>
			              <div class="burger-icon-2"></div>
			              <div class="burger-icon-3"></div>
		            	</div>
		              </li>';
          }

	}
}
/***************************************/



/*
* Header Toolbar Contact
******/
if ( !function_exists( 'pacz_header_toolbar_contact' ) ) {
	function pacz_header_toolbar_contact() {
	global $pacz_settings;
	if($pacz_settings['header-contact-select'] == 'disabled') return false;
		if($pacz_settings['header-contact-select'] == 'header_section') return false;

		if ( !empty( $pacz_settings['header-toolbar-phone'] ) ) {
			echo '<span class="header-toolbar-contact">';
			if (!empty( $pacz_settings['header-toolbar-phone-icon'])) {
				echo '<i class="'.$pacz_settings['header-toolbar-phone-icon'].'"></i>';
				echo stripslashes( $pacz_settings['header-toolbar-phone'] );
			}else{
				echo esc_html__('Phone', 'classiadspro').': '.stripslashes( $pacz_settings['header-toolbar-phone'] );
			}
			echo '</span>';
		}
		if ( !empty( $pacz_settings['header-toolbar-email']) && !empty( $pacz_settings['header-toolbar-email-icon']) ) {
			echo '<span class="header-toolbar-contact">';
			echo '<i class="'.$pacz_settings['header-toolbar-email-icon'].'"></i>';
			echo '<a href="mailto:'.antispambot( $pacz_settings['header-toolbar-email'] ).'">'.antispambot( $pacz_settings['header-toolbar-email'] ).'</a></span>';
		}elseif( !empty( $pacz_settings['header-toolbar-email']) && empty( $pacz_settings['header-toolbar-email-icon']) ) {
			echo '<span class="header-toolbar-contact">';
			echo '<span>'.esc_html__('Email: ', 'classiadspro').'</span><a href="mailto:'.antispambot( $pacz_settings['header-toolbar-email'] ).'">'.antispambot( $pacz_settings['header-toolbar-email'] ).'</a></span>';
		}

	}
}

/*
* Header Toolbar Contact
******/
if ( !function_exists( 'pacz_header_contact' ) ) {
	function pacz_header_contact($location) {
	global $pacz_settings;
	if($pacz_settings['header-contact-select'] == 'disabled') return false;
		if($pacz_settings['header-contact-select'] == 'header_toolbar') return false;

		$output = '';

		if($location == 'outside-grid') {
			$output .= '<div class="header-contact">';
		} else {
			$output .= '<li class="header-contact">';	
		}		

		if ( !empty( $pacz_settings['header-toolbar-phone'] ) ) {
			$output .= '<span class="header-toolbar-contact">';
			if (!empty( $pacz_settings['header-toolbar-phone-icon'])) {
				$output .= '<i class="'.$pacz_settings['header-toolbar-phone-icon'].'"></i>';
				$output .= stripslashes( $pacz_settings['header-toolbar-phone'] );
			}else{
				$output .= esc_html__('Phone: ', 'classiadspro').stripslashes( $pacz_settings['header-toolbar-phone'] );
			}
			$output .= '</span>';
		}
		if ( !empty( $pacz_settings['header-toolbar-email'] ) ) {
			$output .= '<span class="header-toolbar-contact">';
			if (!empty( $pacz_settings['header-toolbar-email-icon'])) {
			$output .= '<i class="'.$pacz_settings['header-toolbar-email-icon'].'"></i>';
			}
			$output .= '<a href="mailto:'.antispambot( $pacz_settings['header-toolbar-email'] ).'">'.antispambot( $pacz_settings['header-toolbar-email'] ).'</a></span>';
		}
		if($location == 'outside-grid') {
			$output .= '</div>';	
		} else {
			$output .= '</li>';
		}
		echo wp_kses_post($output);
	}
}



/*
* Create Main Navigation
******/
if ( !function_exists( 'pacz_main_navigation' ) ) {
	function pacz_main_navigation($menu_location) {

		global $pacz_settings;
	$post_id = global_get_post_id();
	$header_structure = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'header-structure', true ) : $pacz_settings['header-structure'];
	
		$header_style = $header_structure;
		if($header_style == 'vertical') return false;
		$output = '<nav id="pacz-main-navigation" class="clearfix">';
		$output .= wp_nav_menu( array(
				'theme_location' => $menu_location,
				'container' => false,
				'container_id' => false,
				'container_class' => false,
				'menu_class' => 'main-navigation-ul clearfix',
				'echo' => false,
				'fallback_cb' => 'link_to_menu_editor',
				'walker' => new pacz_custom_walker
			) );
		$output .= '</nav>';
		
		if($pacz_settings['header-search']) {
			ob_start();
			do_action( 'header_search_form' );
			$output .= ob_get_contents();
			ob_end_clean();
		}

		echo wp_kses_post($output);

	}
}
/***************************************/




/*
* Fallback menu
******/
if ( !function_exists( 'link_to_menu_editor' ) ) {
	function link_to_menu_editor( $args ) {
		global $pacz_settings;
		$preset_headers = $pacz_settings['preset_headers'];
	    extract( $args );

	    $link = '';

	    if ( FALSE !== stripos( $items_wrap, '<ul' )
	        or FALSE !== stripos( $items_wrap, '<ol' )
	    )
	    {
	        $link = "<li class='menu-item'>$link</li>";
	    }
		if($pacz_settings['header-logo-location'] == 'header_section' && $preset_headers != 12) {
	    ob_start();
		do_action( 'header_logo' );
		$link .= ob_get_contents();
		ob_end_clean();
		}
		ob_start();
		do_action( 'header_search' );
		$link .= ob_get_contents();
		ob_end_clean();


	    $output = sprintf( $items_wrap, $menu_id, $menu_class, $link );
	    if ( ! empty ( $container ) )
	    {
	        $output  = "<$container class='$container_class' id='$container_id'>$output</$container>";
	    }

	    if ( $echo )
	    {
	        echo wp_kses_post($output);
	    }

	    return $output;
	}
}




/*
* Append Header elements to Main Navigation list items.
******/
if ( !function_exists( 'add_first_nav_item' ) ) {
	function add_first_nav_item( $items, $args ) {
		global $pacz_settings;
		$post_id = global_get_post_id();
		$header_search = (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'header-search', true ) : $pacz_settings['header-search'];
		$preset_header_style = $pacz_settings['preset_header_style'];
		$preset_headers = $pacz_settings['preset_headers'];
		 if($preset_headers == 1){
			 
			$pacz_logo_location = 'header_section';
			$pacz_logo_align = 'left' ;
			
			$header_toolbar_social_location = 'disabled'; 
			$header_toolbar_social_align = 'right';
			$listing_btn_location = 'header_section';
			$listing_btn_align = 'right';
			
			$login_reg_btn_location = 'disabled';
			$login_reg_btn_align =  'right';
			$header_align = 'right';
			 
		 }else if($preset_headers == 2){
			$pacz_logo_location = 'header_section';
			$pacz_logo_align = 'left' ;
			
			$header_toolbar_social_location = 'disabled'; 
			$header_toolbar_social_align = 'right';
			$listing_btn_location = 'header_section';
			$listing_btn_align = 'right';
			
			$login_reg_btn_location = 'disabled';
			$login_reg_btn_align =  'right';
			$header_align = 'right';
			 
		 }else if($preset_headers == 3){
			 $pacz_logo_location = 'header_section';
			$pacz_logo_align = 'left' ;
			
			$header_toolbar_social_location = 'disabled'; 
			$header_toolbar_social_align = 'left';
			$listing_btn_location = 'header_section';
			$listing_btn_align = 'right';
			
			$login_reg_btn_location = 'disabled';
			$login_reg_btn_align =  'right';
			 
		 }else if($preset_headers == 4){
			$pacz_logo_location = 'header_toolbar';
			$pacz_logo_align = 'center' ;
			
			$header_toolbar_social_location = 'header_toolbar'; 
			$header_toolbar_social_align = 'left';
			$listing_btn_location = 'header_toolbar';
			$listing_btn_align = 'right';
			
			$login_reg_btn_location = 'header_section';
			$login_reg_btn_align =  'right';
			$header_align = 'left';
			 
		 }else if($preset_headers == 5){
			$pacz_logo_location = 'header_section';
			$pacz_logo_align = 'left' ;
			
			$header_toolbar_social_location = 'header_toolbar'; 
			$header_toolbar_social_align = 'right';
			$listing_btn_location = 'header_section';
			$listing_btn_align = 'right';
			
			$login_reg_btn_location = 'header_toolbar';
			$login_reg_btn_align =  'right';
			$header_align = 'right';
			 
		 }else if($preset_headers == 6){
			$pacz_logo_location = 'header_section';
			$pacz_logo_align = 'left' ;
			
			$header_toolbar_social_location = 'header_toolbar'; 
			$header_toolbar_social_align = 'right';
			$listing_btn_location = 'header_section';
			$listing_btn_align = 'right';
			
			$login_reg_btn_location = 'header_toolbar';
			$login_reg_btn_align =  'right';
			$header_align = 'right';
			 
		 }else if($preset_headers == 7){
			$pacz_logo_location = 'header_section';
			$pacz_logo_align = 'left' ;
			
			$header_toolbar_social_location = 'header_toolbar'; 
			$header_toolbar_social_align = 'right';
			$listing_btn_location = 'header_section';
			$listing_btn_align = 'right';
			
			$login_reg_btn_location = 'header_toolbar';
			$login_reg_btn_align =  'right';
			$header_align = 'right';
			 
		 }else if($preset_headers == 8){
			$pacz_logo_location = 'header_section';
			$pacz_logo_align = 'left' ;
			
			$header_toolbar_social_location = 'disabled'; 
			$header_toolbar_social_align = 'right';
			$listing_btn_location = 'header_toolbar';
			$listing_btn_align = 'right';
			
			$login_reg_btn_location = 'header_toolbar';
			$login_reg_btn_align =  'right';
			$header_align = 'left';
			$logreg_align = 'right';
			 
		 }else if($preset_headers == 9){
			 
		 }else if($preset_headers == 10){
			 
		 }else if($preset_headers == 11){
			$pacz_logo_location = $pacz_settings['header-logo-location'];
			$pacz_logo_align = $pacz_settings['header-logo-align']; 
			
			$header_toolbar_social_location = $pacz_settings['header-social-select']; 
			$header_toolbar_social_align = $pacz_settings['header-social-align'];
			
			$listing_btn_location = $pacz_settings['listing-btn-location'];
			$listing_btn_align = $pacz_settings['listing-btn-align'];
			
			$login_reg_btn_location = $pacz_settings['header-login-reg-location'];
			$login_reg_btn_align =  $pacz_settings['log-reg-btn-align'];
			$header_align = $pacz_settings['header-align'];
			$logreg_align = $pacz_settings['log-reg-btn-align'];
			 
		 }else if($preset_headers == 12){
			 $pacz_logo_location = $pacz_settings['header-logo-location'];
			$pacz_logo_align = $pacz_settings['header-logo-align']; 
			
			$header_toolbar_social_location = $pacz_settings['header-social-select']; 
			$header_toolbar_social_align = $pacz_settings['header-social-align'];
			
			$listing_btn_location = $pacz_settings['listing-btn-location'];
			$listing_btn_align = $pacz_settings['listing-btn-align'];
			
			$login_reg_btn_location = 'header_section';
			$login_reg_btn_align =  $pacz_settings['log-reg-btn-align'];
			$header_align = $pacz_settings['header-align'];
			$logreg_align = $pacz_settings['log-reg-btn-align'];
		 }


		$output = '';

		if ( !is_admin() && ($args->theme_location == 'primary-menu' || $args->theme_location == 'second-menu' || $args->theme_location == 'third-menu' || $args->theme_location == 'fourth-menu' || $args->theme_location == 'fifth-menu' || $args->theme_location == 'sixth-menu' || $args->theme_location == 'seventh-menu') ) {

			ob_start();
			do_action( 'responsive_nav_trigger_link' );
			$output .= ob_get_contents();
			ob_end_clean();

			ob_start();
			do_action( 'margin_style_burger_icon' );
			$output .= ob_get_contents();
			ob_end_clean();

			ob_start();
			do_action( 'vertical_header_burger_icon' );
			$output .= ob_get_contents();
			ob_end_clean();

				ob_start();
			do_action('header_contact', 'inside-grid');
			$output .= ob_get_contents();
			ob_end_clean();
			?>
		<!--	<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Tutorials
    <span class="caret"></span></button>
    <ul class="dropdown-menu">->
      <?php
	 /* wp_list_categories( array(
											'orderby'            => 'name',
											'show_count'         => true,
											'use_desc_for_title' => false,
											'hide_empty' => false,
											'taxonomy'           => ALSP_CATEGORIES_TAX,
											'walker' => new pacz_pacz_custom_menu(),
										) ); */
										?>
   <!-- </ul>
  </div>-->
			<?php
			$detect_mobile = new Mobile_Detect();
			
			if($pacz_logo_location == 'header_section'  && $preset_headers != 12 && (!$detect_mobile->isMobile())) {
			ob_start();
			do_action( 'header_logo' );
			$output .= ob_get_contents();
			ob_end_clean();
			}
			$output .= $items;
			

			if ( class_exists( 'woocommerce' )) {
				if($pacz_settings['checkout-box'] && $pacz_settings['checkout-box-location'] == 'header_section') {
					ob_start();
					do_action( 'header_checkout' );
					$output .= ob_get_contents();
					ob_end_clean();
				}
			}
			
			if($pacz_settings['header-search']) {
				ob_start();
				do_action( 'header_search' );
				$output .= ob_get_contents();
				ob_end_clean();
			}
			if(isset($login_reg_btn_location) && $login_reg_btn_location == 'header_section' && !$detect_mobile->isMobile()) {
				$output .='<li class="logreg-header '.$login_reg_btn_align.'">';
				ob_start();
				do_action('header_logreg');
				$output .= ob_get_contents();
				ob_end_clean();
				$output .='</li>';
			}
			if(isset($listing_btn_location) && $listing_btn_location == 'header_section' && $pacz_settings['listing-btn-url'] && $preset_headers != 12 && !$detect_mobile->isMobile()) {
				ob_start();
				do_action( 'nav_listing_btn' );
				$output .= ob_get_contents();
				ob_end_clean();
			}
			if($pacz_settings['header-wpml']) {
				ob_start();
				do_action( 'header_wpml' );
				$output .= ob_get_contents();
				ob_end_clean();
			}


			ob_start();
			do_action('header_social', 'inside-grid');
			$output .= ob_get_contents();
			ob_end_clean();
			
			

		} else {
			$output .= $items;
		}
		return $output;
	}
	add_filter( 'wp_nav_menu_items', 'add_first_nav_item', 10, 2 );
}
/***************************************/


/*
* Header Toolbar Social Networks
******/
if ( !function_exists( 'pacz_header_toolbar_social' ) ) {
	function pacz_header_toolbar_social() {
		global $pacz_settings;

		if($pacz_settings['header-social-select'] == 'disabled') return false;
		if($pacz_settings['header-social-select'] == 'header_section') return false;

		$output = '';

		$output .= '<li class="pacz-header-toolbar-social">';
		

		if(!empty($pacz_settings['header-social-facebook'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-facebook'].'"><i class="pacz-icon-facebook"></i></a>';
		}
		if(!empty($pacz_settings['header-social-twitter'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-twitter'].'"><i class="pacz-icon-twitter"></i></a>';
		}
		if(!empty($pacz_settings['header-social-google-plus'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-google-plus'].'"><i class="pacz-icon-google-plus"></i></a>';
		}
		if(!empty($pacz_settings['header-social-rss'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-rss'].'"><i class="pacz-icon-rss"></i></a>';
		}
		if(!empty($pacz_settings['header-social-pinterest'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-pinterest'].'"><i class="pacz-icon-pinterest"></i></a>';
		}
		if(!empty($pacz_settings['header-social-instagram'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-instagram'].'"><i class="pacz-icon-instagram"></i></a>';
		}
		if(!empty($pacz_settings['header-social-dribbble'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-dribbble'].'"><i class="pacz-icon-dribbble"></i></a>';
		}
		if(!empty($pacz_settings['header-social-linkedin'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-linkedin'].'"><i class="pacz-icon-linkedin"></i></a>';
		}
		if(!empty($pacz_settings['header-social-tumblr'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-tumblr'].'"><i class="pacz-icon-tumblr"></i></a>';
		}
		if(!empty($pacz_settings['header-social-youtube'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-youtube'].'"><i class="pacz-icon-youtube"></i></a>';
		}

		if(!empty($pacz_settings['header-social-vimeo'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-vimeo'].'"><i class="pacz-theme-icon-social-vimeo"></i></a>';
		}
		if(!empty($pacz_settings['header-social-spotify'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-spotify'].'"><i class="pacz-theme-icon-social-spotify"></i></a>';
		}

		if(!empty($pacz_settings['header-social-weibo'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-weibo'].'"><i class="pacz-theme-icon-weibo"></i></a>';
		}
		if(!empty($pacz_settings['header-social-wechat'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-wechat'].'"><i class="pacz-theme-icon-wechat"></i></a>';
		}
		if(!empty($pacz_settings['header-social-renren'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-renren'].'"><i class="pacz-theme-icon-renren"></i></a>';
		}
		if(!empty($pacz_settings['header-social-imdb'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-imdb'].'"><i class="pacz-theme-icon-imdb"></i></a>';
		}
		if(!empty($pacz_settings['header-social-vkcom'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-vkcom'].'"><i class="pacz-theme-icon-vk"></i></a>';
		}
		if(!empty($pacz_settings['header-social-qzone'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-qzone'].'"><i class="pacz-theme-icon-qzone"></i></a>';
		}
		if(!empty($pacz_settings['header-social-whatsapp'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-whatsapp'].'"><i class="pacz-theme-icon-whatsapp"></i></a>';
		}
		if(!empty($pacz_settings['header-social-behance'])) {
			$output .= '<a target="_blank" href="'.$pacz_settings['header-social-behance'].'"><i class="pacz-theme-icon-behance"></i></a>';
		}

		$output .= '</li>';
		

		echo wp_kses_post($output);
	}
}
