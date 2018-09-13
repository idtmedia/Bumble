<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function dhvc_form_field_file_validation_filter($result, $field){
	$name = $field->get_name();
	$file = isset( $_FILES[$name] ) ? $_FILES[$name] : null;
	if ( $file['error'] && UPLOAD_ERR_NO_FILE != $file['error'] ) {
		$result->invalidate( $tag, dhvc_form_get_message( 'upload_failed_php_error' ) );
		return $result;
	}
	if ( empty( $file['tmp_name'] ) && $field->is_required() ) {
		$result->invalidate( $field, dhvc_form_get_message( 'invalid_required' ) );
		return $result;
	}
	if ( ! is_uploaded_file( $file['tmp_name'] ) ) {
		return $result;
	}
	$file_type_pattern = implode( '|', dhvc_form_allowed_file_extension() );
	$file_type_pattern = trim( $file_type_pattern, '|' );
	$file_type_pattern = '(' . $file_type_pattern . ')';
	$file_type_pattern = '/\.' . $file_type_pattern . '$/i';
	if ( ! preg_match( $file_type_pattern, $file['name'] ) ) {
		$result->invalidate( $field, dhvc_form_get_message( 'upload_file_type_invalid' ) );
		return $result;
	}
	
	$allowed_size = dhvc_form_allowed_size(); // default size 1 MB
	
	if ( $file['size'] > $allowed_size ) {
		$result->invalidate( $field, dhvc_form_get_message( 'upload_file_too_large' ) );
		return $result;
	}
	
	if ( $submission = DHVCForm_Submission::get_instance() ) {
		$submission->add_upload_files( $name, $file );
	}
	
	return $result;

}
add_filter( 'dhvc_form_validate_file', 'dhvc_form_field_file_validation_filter', 10, 2 );


function dhvc_form_field_file_params(){
	return array(
	    "name" => __("Form File", 'dhvc-form'),
	    "base" => "dhvc_form_file",
	    "category" => __("Form Control", 'dhvc-form'),
	    "icon" => "icon-dhvc-form-file",
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
	            "type" => "textarea",
	            "heading" => __("Help text", 'dhvc-form'),
	            "param_name" => "help_text",
	            'description' => __('This is the help text for this form control.', 'dhvc-form')
	        ),
	        array(
	            "type" => "checkbox",
	            "heading" => __("Required ? ", 'dhvc-form'),
	            "param_name" => "required",
	            "value" => array(
	                __('Yes, please', 'dhvc-form') => '1'
	            )
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Attributes", 'dhvc-form'),
	            "param_name" => "attributes",
	            'description' => __('Add attribute for this form control,eg: <em>onclick="" onchange="" </em> or \'<em>data-*</em>\'  attributes HTML5, not in attributes: <span style="color:#ff0000">type, value, name, required, placeholder, maxlength, id</span>', 'dhvc-form')
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