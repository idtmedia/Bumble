<?php
/**
 * Plugin Name:  Classiads Templates By Designinvento
 * Plugin URI: https://designinvento.net/
 * Description: Classiads templates Templates
 * Author: Designinvento
 * Author URI: https://designinvento.net/
 * Version: 1.0
 * Text Domain: all-in-one-wp-migration-di-templates
 * Domain Path: /languages
 * Network: True
 */

// Check SSL Mode
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && ( $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) ) {
	$_SERVER['HTTPS'] = 'on';
}

// Plugin Basename
define( 'AI1WMDI_PLUGIN_BASENAME', basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) );

    //IF ALL IN ONE WP MIGRATION URL EXTENSION WITH CUSTOM TEMPLATES IS ACTIVE DISABLE IT TO AVOID CONFLICT
    if (defined('AI1WMLE_PLUGIN_BASENAME') && file_exists(AI1WMLE_TEMPLATES_PATH.'/demo-templates/install-template.php'))
    {
        deactivate_plugins('all-in-one-wp-migration-url-extension/all-in-one-wp-migration-url-extension.php');
    }

// Plugin Path
define( 'AI1WMDI_PATH', dirname( __FILE__ ) );

// Plugin Url
define( 'AI1WMDI_URL', plugins_url( '', AI1WMDI_PLUGIN_BASENAME ) );

// Include constants
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'constants.php';

// Include exceptions
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'exceptions.php';

// Include loader
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'loader.php';

$main_controller = new Ai1wmdi_Main_Controller();
