<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function dhvc_form_field_password_validation_filter($result, $field){
	$name = $field->get_name();
	
	$value = isset( $_POST[$name] ) ? (string) $_POST[$name] : '';
	
	if($field->is_required() && ''==$value)
		$result->invalidate($field, dhvc_form_get_message('invalid_required'));
	elseif (''!=$value){
		$cpassword = $field->attr('password_field');
		$cpassword_value = isset($_POST[$cpassword]) ? (string) $_POST[$cpassword] : '';
		if('1'==$field->attr('validator') && strlen($value) < 6){
			$result->invalidate($field, sprintf(dhvc_form_get_message('invalid_min'),6));
		}elseif ('1'==$field->attr('confirmation') && !empty($cpassword) && $cpassword_value!==$value ){
			$result->invalidate($field,dhvc_form_get_message('invalid_cpassword'));
		}
	}
	return $result;

}
add_filter( 'dhvc_form_validate_password', 'dhvc_form_field_password_validation_filter', 10, 2 );


function dhvc_form_field_password_params(){
	return array(
	    "name" => __("Form Password", 'dhvc-form'),
	    "base" => "dhvc_form_password",
	    "category" => __("Form Control", 'dhvc-form'),
	    "icon" => "icon-dhvc-form-password",
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
	            "type" => "checkbox",
	            "heading" => __("Is confirmation ? ", 'dhvc-form'),
	            "param_name" => "confirmation",
	            "value" => array(
	                __('Yes, please', 'dhvc-form') => '1'
	            )
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Password field ", 'dhvc-form'),
	            "param_name" => "password_field",
	            "dependency" => array(
	                'element' => "confirmation",
	                'not_empty' => true
	            ),
	            'description' => __('enter passwords field name to validate match', 'dhvc-form')
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Placeholder text", 'dhvc-form'),
	            "param_name" => "placeholder"
	        ),
	    	array (
	    		"type" => "dropdown",
	    		"heading" => __ ( "Icon", 'dhvc-form' ),
	    		"param_name" => "icon",
	    		"param_holder_class" => 'dhvc-form-font-awesome',
	    		"value" => dhvc_form_font_awesome(),
	    		'description' => __ ( 'Select icon add-on for this control.', 'dhvc-form' )
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
	            "type" => "checkbox",
	            "heading" => __("Read only ? ", 'dhvc-form'),
	            "param_name" => "readonly",
	            "value" => array(
	                __('Yes, please', 'dhvc-form') => '1'
	            )
	        ),
	        array(
	            "type" => "checkbox",
	            "heading" => __("Password validator ? ", 'dhvc-form'),
	            "param_name" => "validator",
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