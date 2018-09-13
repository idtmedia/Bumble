<?php
$config  = array(
	'title' => sprintf( '%s Clients Options', PACZ_THEME_NAME ),
	'id' => 'pacz-metaboxes-notab',
	'pages' => array(
		'clients'
	),
	'callback' => '',
	'context' => 'normal',
	'priority' => 'core'
);
$options = array(

	array(
		"name" => esc_html__( "Company Name", "classiadspro" ),
		"desc" => esc_html__( "", "classiadspro" ),
		"subtitle" => esc_html__( "", "classiadspro" ),
		"id" => "_company",
		"default" => "",
		"option_structure" => 'sub',
		"divider" => true,
		"size"=> 50,
		"type" => "text"
	),

	array(
		"name" => esc_html__( "Website URL", "classiadspro" ),
		"desc" => esc_html__( "Include http://", "classiadspro" ),
		"subtitle" => esc_html__( "URL to the client's website or any external source. Optional!", "classiadspro" ),
		"id" => "_url",
		"default" => "",
		"type" => "text"
	),


);
new pacz_metaboxesGenerator( $config, $options );
