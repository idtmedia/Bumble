<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function dhvc_form_field_multiple_select_validation_filter($result, $field){
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
add_filter( 'dhvc_form_validate_multiple_select', 'dhvc_form_field_multiple_select_validation_filter', 10, 2 );


function dhvc_form_field_multiple_select_params(){
	return array(
        "name" => __("Form Multiple Select", 'dhvc-form'),
        "base" => "dhvc_form_multiple_select",
        "category" => __("Form Control", 'dhvc-form'),
        "icon" => "icon-dhvc-form-select",
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
                'option_checkbox' => true
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