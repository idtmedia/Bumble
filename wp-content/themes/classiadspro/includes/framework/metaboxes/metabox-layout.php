<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active('listing/alsp.php')) {
	$listing = ALSP_POST_TYPE;
}else{
	$listing = 'ALSP_POST_TYPE';
}
$config  = array(
	'title' => sprintf( '%s Page layout', PACZ_THEME_NAME ),
	'id' => 'pacz-layout-metabox',
	'pages' => array(
		'portfolio',
		'post',
		'page',
		'causes',
		$listing
	),
	'callback' => '',
	'context' => 'side',
	'priority' => 'core'
);
$options = array(


	array(
		"name" => esc_html__( "Page Layout", "classiadspro" ),
		"subtitle" => esc_html__( "Please choose this page's layout. Default : Full layout", "classiadspro" ),
		"id" => "_layout",
		"default" => 'right',
		"placeholder" => 'false',
		"width" => 230,
		"options" => array(
			"right" => 'Right Sidebar',
			"left" => 'Left Sidebar',
			"full" => 'No sidebar',
		),
		"type" => "select"
	),

	array(
    "name" => esc_html__("Choose a Sidebar", "classiadspro" ),
    "subtitle" => esc_html__( "Assign a custom sidebar to this page.", "classiadspro" ),
    "id" => "_sidebar",
    "width" => 230,
    "default" => '',
    'placeholder' => 'true',
    "options" => pacz_get_sidebar_options(),
    "type" => "select"
  ),



);

new pacz_metaboxesGenerator( $config, $options );
