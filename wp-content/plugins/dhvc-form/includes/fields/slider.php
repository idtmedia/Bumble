<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function dhvc_form_field_slider_validation_filter($result, $field){
	$name = $field->get_name();
	$value = isset( $_POST[$name] ) ? (string) $_POST[$name] : '';
	if($field->is_required() && ''==$value)
		$result->invalidate($field, dhvc_form_get_message('invalid_required'));
	return $result;

}
add_filter( 'dhvc_form_validate_slider', 'dhvc_form_field_slider_validation_filter', 10, 2 );


function dhvc_form_field_slider_params(){
	return array(
	    "name" => __("Form Slider", 'dhvc-form'),
	    "base" => "dhvc_form_slider",
	    "category" => __("Form Control", 'dhvc-form'),
	    "icon" => "icon-dhvc-form-slider",
	    "params" => array(
	        array(
	            "type" => "dropdown",
	            "heading" => __("Type", 'dhvc-form'),
	            "param_name" => "type",
	            "value" => array(
	                __('Slider', 'dhvc-form') => 'slider',
	                __('Range', 'dhvc-form') => 'range'
	            ),
	            'admin_label' => true
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
	            "type" => "textfield",
	            "heading" => __("Minimum Value", 'dhvc-form'),
	            "param_name" => "minimum_value",
	            "value" => 0
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Maximum Value", 'dhvc-form'),
	            "param_name" => "maximum_value",
	            "value" => 100
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Step", 'dhvc-form'),
	            "param_name" => "step",
	            "value" => 5
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Default value", 'dhvc-form'),
	            "param_name" => "default_value"
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
	            "dependency" => array(
	                'element' => "type",
	                'value' => array(
	                    'slider'
	                )
	            ),
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