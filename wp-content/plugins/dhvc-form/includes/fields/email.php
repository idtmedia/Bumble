<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

function dhvc_form_field_email_validation_filter($result, $field){
	$name = $field->get_name();
	$value = isset( $_POST[$name] ) ? trim( strtr( (string) $_POST[$name], "\n", " " ) ) : '';
	if($field->is_required() && ''==$value)
		$result->invalidate($field, dhvc_form_get_message('invalid_required'));
	elseif ( '' !== $value && !dhvc_form_is_email($value))
		$result->invalidate($field,dhvc_form_get_message('invalid_email'));
	return $result;

}
add_filter( 'dhvc_form_validate_email', 'dhvc_form_field_email_validation_filter', 10, 2 );

function dhvc_form_field_email_params(){
	return array(
	    "name" => __("Form Email", 'dhvc-form'),
	    "base" => "dhvc_form_email",
	    "category" => __("Form Control", 'dhvc-form'),
	    "icon" => "icon-dhvc-form-email",
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
	            "heading" => __("Default value", 'dhvc-form'),
	            "param_name" => "default_value"
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Maximum length characters", 'dhvc-form'),
	            "param_name" => "maxlength"
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
	            "type" => "dropdown",
	            "heading" => __("Read only ? ", 'dhvc-form'),
	            "param_name" => "readonly",
	            "value" => array(
	                __('No', 'dhvc-form') => 'no',
	                __('Yes', 'dhvc-form') => 'yes'
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