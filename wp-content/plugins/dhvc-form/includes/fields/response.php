<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function dhvc_form_field_response_params(){
	return array(
		"name" => __("Form Response", 'dhvc-form'),
		"base" => "dhvc_form_response",
		"category" => __("Form Control", 'dhvc-form'),
		"icon" => "icon-dhvc-form-response",
		'description' => __( 'Form message response', 'dhvc-form' ),
		"params" => array(
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