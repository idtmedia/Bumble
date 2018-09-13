<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function dhvc_form_field_label_params(){
	return array(
	    "name" => __("Form Label", 'dhvc-form'),
	    "base" => "dhvc_form_label",
	    "category" => __("Form Control", 'dhvc-form'),
	    "icon" => "icon-dhvc-form-label",
	    "params" => array(
	        array(
	            "type" => "dhvc_form_name",
	            "heading" => __("Name", 'dhvc-form'),
	            "param_name" => "control_name",
	            'admin_label' => true,
	            "description" => __('Field name is required.  Please enter single word, no spaces, no start with number. Underscores(_) allowed', 'dhvc-form')
	        ),
	        array(
	            'type' => 'textarea_html',
	            'holder' => 'div',
	            'heading' => __('Text', 'dhvc-form'),
	            'param_name' => 'content',
	            'value' => __('<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'dhvc-form')
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