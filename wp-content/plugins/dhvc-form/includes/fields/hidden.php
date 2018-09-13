<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function dhvc_form_field_hidden_params(){
	return array(
	    "name" => __("Form Hidden", 'dhvc-form'),
	    "base" => "dhvc_form_hidden",
	    "category" => __("Form Control", 'dhvc-form'),
	    "icon" => "icon-dhvc-form-hidden",
	    "params" => array(
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
	        )
	    )
	);
}