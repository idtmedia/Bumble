<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function dhvc_form_field_captcha_tmp_dir() {
	return dhvc_form_upload_dir('dir').'/captcha';
}

function dhvc_form_field_captcha_tmp_url() {
	return dhvc_form_upload_dir('url').'/captcha';
}

function dhvc_form_field_captcha_img_url($filename) {
	$url = trailingslashit( dhvc_form_field_captcha_tmp_url() ) . $filename;

	if ( is_ssl() && 'http:' == substr( $url, 0, 5 ) ) {
		$url = 'https:' . substr( $url, 5 );
	}

	return apply_filters( 'dhvc_form_field_captcha_img_url', esc_url_raw( $url ) );
}

function dhvc_form_field_captcha_init(){
	static $captcha = null;
	
	if ( $captcha ) {
		return $captcha;
	}
	if ( class_exists( 'ReallySimpleCaptcha' ) ) {
		$captcha = new ReallySimpleCaptcha();
	} else {
		return false;
	}
	
	$dir = trailingslashit( dhvc_form_field_captcha_tmp_dir() );
	
	$captcha->tmp_dir = $dir;
	if ( is_callable( array( $captcha, 'make_tmp_dir' ) ) ) {
		$result = $captcha->make_tmp_dir();
	
		if ( ! $result ) {
			return false;
		}
	
		return $captcha;
	}
}

function dhvc_form_field_captcha_generate(){
	if ( ! $captcha = dhvc_form_field_captcha_init() ) {
		return false;
	}
	
	if ( ! is_dir( $captcha->tmp_dir ) || ! wp_is_writable( $captcha->tmp_dir ) ) {
		return false;
	}

	$img_type = imagetypes();

	if ( $img_type & IMG_PNG ) {
		$captcha->img_type = 'png';
	} elseif ( $img_type & IMG_GIF ) {
		$captcha->img_type = 'gif';
	} elseif ( $img_type & IMG_JPG ) {
		$captcha->img_type = 'jpeg';
	} else {
		return false;
	}
	
	$captcha->img_size = array( 100, 30 );
	
	
	$prefix = wp_rand();
	$captcha_word = $captcha->generate_random_word();
	return $captcha->generate_image( $prefix, $captcha_word );
}

function dhvc_form_field_captcha_remove( $prefix ) {
	if ( ! $captcha = dhvc_form_field_captcha_init() ) {
		return false;
	}

	if ( preg_match( '/[^0-9]/', $prefix ) ) {
		return false;
	}

	$captcha->remove( $prefix );
}

function dhvc_form_field_captcha_check( $prefix, $response ) {
	if ( ! $captcha = dhvc_form_field_captcha_init() ) {
		return false;
	}
	return $captcha->check( $prefix, $response );
}

function dhvc_form_field_captcha_ajax_refill( $items, $submission) {
	if ( ! is_array( $items ) ) {
		return $items;
	}

	$fes = dhvc_form_find_field('captcha',$submission->get_form_id());
	if ( empty( $fes ) ) {
		return $items;
	}

	$refill = array();

	foreach ( $fes as $fe ) {
		$name = $fe->get_name();

		if ( empty( $name ) ) {
			continue;
		}
		if ( $filename = dhvc_form_field_captcha_generate() ) {
			$captcha_url = dhvc_form_field_captcha_img_url( $filename );
			$refill[$name] = $captcha_url;
		}
	}

	if ( ! empty( $refill ) ) {
		$items['captcha'] = $refill;
	}
	
	return $items;
}
add_filter( 'dhvc_form_ajax_json_echo', 'dhvc_form_field_captcha_ajax_refill',10,2);


function dhvc_form_field_captcha_cleanup_files(){
	if ( ! $captcha = dhvc_form_field_captcha_init() ) {
		return false;
	}
	if ( is_callable( array( $captcha, 'cleanup' ) ) ) {
		return $captcha->cleanup();
	}
}
add_action( 'template_redirect', 'dhvc_form_field_captcha_cleanup_files', 20 );

function dhvc_form_field_captcha_validation_filter($result, $field){
	$name = $field->get_name();
	
	$captchac = '_dhvc_form_captcha_challenge_' . $name;
	
	$prefix = isset( $_POST[$captchac] ) ? (string) $_POST[$captchac] : '';
	$response = isset( $_POST[$name] ) ? (string) $_POST[$name] : '';
	$response = dhvc_form_canonicalize( $response );
	
	if(''==$response){
		$result->invalidate($field, dhvc_form_get_message('invalid_required'));
	}elseif ( 0 == strlen( $prefix ) || ! dhvc_form_field_captcha_check( $prefix, $response ) ){
		$result->invalidate($field, dhvc_form_get_message('captcha_not_match'));
	}
	
	if ( 0 != strlen( $prefix ) ) {
		dhvc_form_field_captcha_remove( $prefix );
	}
	
	
	return $result;

}
add_filter( 'dhvc_form_validate_captcha', 'dhvc_form_field_captcha_validation_filter', 10, 2 );

function dhvc_form_field_captcha_params(){
	return array(
	    "name" => __("Form Simple Captcha", 'dhvc-form'),
	    "base" => "dhvc_form_captcha",
	    "category" => __("Form Control", 'dhvc-form'),
	    "icon" => "icon-dhvc-form-captcha",
	    "params" => array(
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
	            "type" => "textfield",
	            "heading" => __("Placeholder text", 'dhvc-form'),
	            "param_name" => "placeholder"
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