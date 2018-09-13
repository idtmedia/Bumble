<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly


function dhvc_form_field_rate_validation_filter($result, $field){
	$name = $field->get_name();
	$value = isset( $_POST[$name] ) ? (string) $_POST[$name] : '';
	if($field->is_required() && ''==$value)
		$result->invalidate($field, dhvc_form_get_message('invalid_required'));
	return $result;

}
add_filter( 'dhvc_form_validate_rate', 'dhvc_form_field_rate_validation_filter', 10, 2 );



function dhvc_form_field_rate_params(){
	return array(
	    "name" => __("Form Rate", 'dhvc-form'),
	    "base" => "dhvc_form_rate",
	    "category" => __("Form Control", 'dhvc-form'),
	    "icon" => "icon-dhvc-form-rate",
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
	            "type" => "dhvc_form_rate_option",
	            "heading" => __("Options", 'dhvc-form'),
	            "param_name" => "rate_option"
	        ),
	        array(
	            "type" => "textarea",
	            "heading" => __("Help text", 'dhvc-form'),
	            "param_name" => "help_text",
	            'description' => __('This is the help text for this form control.', 'dhvc-form')
	        ),
	        array(
	            "type" => "dhvc_form_conditional",
	            "heading" => __("Conditional Logic", 'dhvc-form'),
	            "param_name" => "conditional",
	            'description' => __('Create rules to show or hide this field depending on the values of other fields ', 'dhvc-form')
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