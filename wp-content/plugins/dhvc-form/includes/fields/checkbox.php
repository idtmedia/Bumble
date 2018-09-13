<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function dhvc_form_field_checkbox_validation_filter($result, $field){
	$name = $field->get_name();
	if ( isset( $_POST[$name] ) && is_array( $_POST[$name] ) ) {
		foreach ( $_POST[$name] as $key => $value ) {
			if ( '' === $value ) {
				unset( $_POST[$name][$key] );
			}
		}
	}

	$empty = ! isset( $_POST[$name] ) || empty( $_POST[$name] ) && '0' !== $_POST[$name];
	
	if($field->is_required() && $empty )
		$result->invalidate($field, dhvc_form_get_message('invalid_required'));
	return $result;

}
add_filter( 'dhvc_form_validate_checkbox', 'dhvc_form_field_checkbox_validation_filter', 10, 2 );


function dhvc_form_field_checkbox_params(){
	return array(
        "name" => __("Form Checkboxes", 'dhvc-form'),
        "base" => "dhvc_form_checkbox",
        "category" => __("Form Control", 'dhvc-form'),
        "icon" => "icon-dhvc-form-checkbox",
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
                "type" => "dhvc_form_option",
                "heading" => __("Options", 'dhvc-form'),
                "param_name" => "options",
                'option_checkbox' => true,
            	'description'=>__('You can use formart "Label===Image_Src" for option label to dipslay image select options, ex: 1 coffee==http://sitesao.com/dhvcform/wp-content/uploads/2017/10/coffee-big.png','dhvc-form'),
            ),
        	array(
        		"type" => "textfield",
        		"heading" => __("Option with", 'dhvc-form'),
        		"param_name" => "option_width",
        		'description' => __('Enter option item width (Note: CSS measurement units allowed),ex: 50%', 'dhvc-form')
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
                "heading" => __("Disabled ? ", 'dhvc-form'),
                "param_name" => "disabled",
                "value" => array(
                    __('Yes, please', 'dhvc-form') => '1'
                )
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