<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class DHVCForm_Assets {
	
	public static function init(){
		if(is_admin()){
			add_action('admin_init', array( __CLASS__, 'register_assets' ));
		}else{
			add_action( 'template_redirect', array( __CLASS__, 'register_assets' ) );
		}
	}
	
	public static function register_assets(){
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	
		$language = apply_filters('dhvc_form_language_code','en');
	
		wp_register_script( 'dhvc-form-recaptcha2', "https://www.google.com/recaptcha/api.js?onload=dhvc_form_recatptcha_callback&render=explicit&hl=$language", array('jquery'), '1.0.0',true );
		
		wp_register_style('dhvc-form-font-awesome',DHVC_FORM_URL.'/assets/fonts/font-awesome/css/font-awesome'.$suffix.'.css', array(), '4.1.0');
		
		wp_register_style('dhvc-form-datetimepicker',DHVC_FORM_URL.'/assets/datetimepicker/jquery.datetimepicker.css', array(),'2.2.9');
		wp_register_script('dhvc-form-datetimepicker',DHVC_FORM_URL.'/assets/datetimepicker/jquery.datetimepicker'.$suffix.'.js',array('jquery'),'2.4.6',true);
		
		wp_register_style('dhvc-form-minicolor',DHVC_FORM_URL.'/assets/minicolors/jquery.minicolors'.$suffix.'.css', array(),'2.1');
		wp_register_script('dhvc-form-minicolor',DHVC_FORM_URL.'/assets/minicolors/jquery.minicolors'.$suffix.'.js',array('jquery'),'2.1',true);
	
		wp_register_style('dhvc-form-bootstrap-tooltip',DHVC_FORM_URL.'/assets/css/bootstrap-tooltip.css', array(),'3.2.0');
		wp_register_script('dhvc-form-bootstrap-tooltip',DHVC_FORM_URL.'/assets/js/bootstrap-tooltip.js',array('jquery'),'3.2.0',true);

		wp_register_script('dhvc-form-jquery-cookie',DHVC_FORM_URL.'/assets/js/jquery_cookie.js',array('jquery'),'1.4.1',true);		
		wp_register_script('dhvc-form-recaptcha','http://www.google.com/recaptcha/api/js/recaptcha_ajax.js',array('jquery'),true);
	
	}
}

DHVCForm_Assets::init();