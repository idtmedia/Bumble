<?php
global $product;

//if($product->get_type() == 'listings_package'){
$config  = array(
    'title' => sprintf('%s Page Options', PACZ_THEME_NAME),
    'id' => 'pacz-woo-metabox',
    'pages' => array(
        'product'
    ),
    'callback' => '',
    'context' => 'normal',
    'priority' => 'core'
);

$options = array(
	array(
		"name" => esc_html__( 'Breadcrumb Custom Color', 'classiadspro' ),
		"subtitle" => esc_html__( "Using this option you can change breadcrumb link and text color.", "classiadspro" ),
		"id" => "_package_batch_color",
		"default" => "",
		"type" => "color"
	 ),
    array(
		"name" => esc_html__( 'Breadcrumb Custom text', 'classiadspro' ),
		"subtitle" => esc_html__( "Using this option you can change breadcrumb link and text color.", "classiadspro" ),
		"id" => "_package_batch_text",
		"default" => "",
		"type" => "text"
	 )
  
);

new pacz_metaboxesGenerator($config, $options);
//}else{
	
//}