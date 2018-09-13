<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function dhvc_form_recaptcha_check($recaptcha_challenge_field,$recaptcha_response_field){
	if(!function_exists('recaptcha_check_answer'))
		require_once DHVC_FORM_DIR.'/includes/recaptchalib.php';
	$privatekey =  dhvc_form_get_option('recaptcha_private_key');
	$check_answer = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$recaptcha_challenge_field,$recaptcha_response_field);
	if($check_answer->is_valid)
		return true;
	return false;
}

function dhvc_form_recaptcha_check2($response_token ) {
	$is_human = false;

	if ( empty( $response_token ) ) {
		return $is_human;
	}

	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$sitekey = dhvc_form_get_option('recaptcha_public_key');
	$secret = dhvc_form_get_option('recaptcha_private_key');
	$response = wp_safe_remote_post( $url, array(
		'body' => array(
			'secret' => $secret,
			'response' => $response_token,
			'remoteip' => $_SERVER['REMOTE_ADDR'] ) ) );

	if ( 200 != wp_remote_retrieve_response_code( $response ) ) {
		return $is_human;
	}

	$response = wp_remote_retrieve_body( $response );
	$response = json_decode( $response, true );
	$is_human = isset( $response['success'] ) && true == $response['success'];
	return $is_human;
}

/**
 * 
 * @param DHVCForm_Validation $result
 * @param DHVCForm_Field $field
 * @return DHVCForm_Validation
 */
function dhvc_form_field_recaptcha_validation_filter($result, $field){
	$type = $field->attr('captcha_type');
	$into = 'div#'.$field->get_name().'.dhvc-form-recaptcha';
	if('1'===$type){
		$recaptcha_challenge_field  = isset($_POST["recaptcha_challenge_field"]) ? $_POST["recaptcha_challenge_field"] : '';
		$recaptcha_response_field =isset($_POST["recaptcha_response_field"]) ? $_POST["recaptcha_response_field"] : '';
		if(empty($recaptcha_challenge_field) || empty($recaptcha_response_field)){
			$result->invalidate($field, dhvc_form_get_message('recaptcha_not_check'), $into);
		}elseif(!dhvc_form_recaptcha_check($recaptcha_challenge_field,$recaptcha_response_field)){
			$result->invalidate($field, dhvc_form_get_message('invalid_recaptcha'), $into);
		}
	}else{
		$response_token = isset( $_POST['g-recaptcha-response'] ) ? $_POST['g-recaptcha-response'] : '';
		if(empty($response_token)){
			$result->invalidate($field, dhvc_form_get_message('recaptcha_not_check'), $into);
		}elseif (!dhvc_form_recaptcha_check2($response_token)){
			$result->invalidate($field, dhvc_form_get_message('invalid_recaptcha'), $into);
		}
	}
	return $result;

}
add_filter( 'dhvc_form_validate_recaptcha', 'dhvc_form_field_recaptcha_validation_filter', 10, 2 );

function dhvc_form_field_recaptcha_params(){
	return array(
	    "name" => __("Form reCaptcha", 'dhvc-form'),
	    "base" => "dhvc_form_recaptcha",
	    "category" => __("Form Control", 'dhvc-form'),
	    "icon" => "icon-dhvc-form-recaptcha",
		'description' => __( 'Display Google reCaptcha', 'dhvc-form' ),
	    "params" => array(
	        array(
	            "type" => "dropdown",
	            "heading" => __("reCaptcha Version", 'dhvc-form'),
	            "param_name" => "captcha_type",
	            'std' => '2',
	            "value" => array(
	                __('Version 1', 'dhvc-form') => '1',
	                __('Version 2', 'dhvc-form') => '2'
	            ),
	            'description' => __('Select reCaptcha version you want use.', 'dhvc-form')
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Theme", 'dhvc-form'),
	            "param_name" => "theme",
	            "value" => array(
	                __('Red', 'dhvc-form') => 'red',
	                __('Clean', 'dhvc-form') => 'clean',
	                __('White', 'dhvc-form') => 'white',
	                __('BlackGlass', 'dhvc-form') => 'blackglass'
	            ),
	            "dependency" => array(
	                'element' => "captcha_type",
	                'value' => array(
	                    '1'
	                )
	            ),
	            'description' => __('Defines which theme to use for reCAPTCHA.', 'dhvc-form')
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Language", 'dhvc-form'),
	            "param_name" => "language",
	            "dependency" => array(
	                'element' => "captcha_type",
	                'value' => array(
	                    '1'
	                )
	            ),
	            "value" => dhvc_form_get_recaptcha_lang(),
	            'description' => __('Select the language you would like to use for the reCAPTCHA display from the available options.', 'dhvc-form')
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Label", 'dhvc-form'),
	            "param_name" => "control_label",
	            'admin_label' => true
	        ),
	        array(
	            "type" => "dhvc_form_name",
	            "heading" => __("Name", 'dhvc-form'),
	            "param_name" => "control_name",
	            'admin_label' => true,
	            "description" => __('Field name is required.  Please enter single word, no spaces, no start with number. Underscores(_) allowed', 'dhvc-form')
	        ),
	        array(
	            "type" => "textarea",
	            "heading" => __("Help text", 'dhvc-form'),
	            "param_name" => "help_text",
	            'description' => __('This is the help text for this form control.', 'dhvc-form')
	        ),
	        array(
	            'type' => 'textfield',
	            'heading' => __('Extra class name', 'dhvc-form'),
	            'param_name' => 'el_class',
	            'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'dhvc-form')
	        ),
	    	array(
	    		'type' => 'css_editor',
	    		'heading' => __( 'CSS box', 'dhvc-form' ),
	    		'param_name' => 'input_css',
	    		'group' => __( 'Design Options', 'dhvc-form' ),
	    	),
	    )
	);
}