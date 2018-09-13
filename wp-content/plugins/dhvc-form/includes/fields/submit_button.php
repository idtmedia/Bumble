<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
function dhvc_form_field_submit_button_params(){
	return array(
        "name" => __("Form Button Submit", 'dhvc-form'),
        "base" => "dhvc_form_submit_button",
        "category" => __("Form Control", 'dhvc-form'),
        "icon" => "icon-dhvc-form-submit-button",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Label", 'dhvc-form'),
                "param_name" => "label",
                'value' => __('Submit', 'dhvc-form'),
                'admin_label' => true,
                "description" => __('Field name is required.  Please enter single word, no spaces, no start with number. Underscores(_) allowed', 'dhvc-form')
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