<?php
$config  = array(
	'title' => sprintf( '%s Testimonials Options', PACZ_THEME_NAME ),
	'id' => 'pacz-metaboxes-notab',
	'pages' => array(
		'testimonial'
	),
	'callback' => '',
	'context' => 'normal',
	'priority' => 'core'
);
$options = array(
	array(
		"name" => esc_html__( "Author Name", "classiadspro" ),
		"subtitle" => esc_html__( "Testimonial author name.", "classiadspro" ),
		"desc" => esc_html__( "", "classiadspro" ),
		"id" => "_author",
		"default" => "",
		"size"=> 50,
		"type" => "text"
	),
	array(
		"name" => esc_html__( "Company Name", "classiadspro" ),
		"subtitle" => esc_html__( "Company or whatever position the author has. will be shown below name.", "classiadspro" ),
		"desc" => esc_html__( "", "classiadspro" ),
		"id" => "_company",
		"default" => "",
		"type" => "text"
	),
	array(
		"name" => esc_html__( "Author Position", "classiadspro" ),
		"subtitle" => esc_html__( "Company or whatever position the author has. will be shown below name.", "classiadspro" ),
		"desc" => esc_html__( "", "classiadspro" ),
		"id" => "_position",
		"default" => "",
		"type" => "text"
	),
	array(
		"name" => esc_html__( "Website URL", "classiadspro" ),
		"subtitle" => esc_html__( "Author website URL. its completely optional.", "classiadspro" ),
		"desc" => esc_html__( "please include http://", "classiadspro" ),
		"id" => "_url",
		"default" => "",
		"type" => "text"
	),
	array(
		"name" => esc_html__( "Author Quote", "classiadspro" ),
		"subtitle" => esc_html__( "Please fill this form as the author quote. you are allowed to use any type of HTML code and shortcode.", "classiadspro" ),
		"desc" => esc_html__( "", "classiadspro" ),
		"id" => "_desc",
		"default" => "",
		"type" => "editor"
	),


);
new pacz_metaboxesGenerator( $config, $options );
