<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function dhvc_form_field_paypal_params(){
	return array(
		"name" => __("Form Paypal", 'dhvc-form'),
		"base" => "dhvc_form_paypal",
		"category" => __("Form Control", 'dhvc-form'),
		"icon" => "icon-dhvc-form-paypal",
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Paypal Order Description", 'dhvc-form'),
				"param_name" => "order_description",
				'value'=>'DHVC Form Order',
			),
			array(
				"type" => "textfield",
				"heading" => __("Item text", 'dhvc-form'),
				"param_name" => "item_text",
				'value'=>'Items',
			),
			array(
				"type" => "textfield",
				"heading" => __("Qty text", 'dhvc-form'),
				"param_name" => "qty_text",
				'value'=>'Qty',
			),
			array(
				"type" => "textfield",
				"heading" => __("Price text", 'dhvc-form'),
				"param_name" => "price_text",
				'value'=>'Price',
			),
			array(
				"type" => "dhvc_form_paypal_items_list",
				"heading" => __("Items list", 'dhvc-form'),
				"param_name" => "item_list",
				'description' => __('You can use operation ( + , - , * , / ) field, ex: field_1*field_2.', 'dhvc-form')
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