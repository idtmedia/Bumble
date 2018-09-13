<?php
/*
* @package   Comments Ratings
* @author    Designinvento <help.designinvento@gmail.com>
* @license   GPL-2.0+
* @link      http://designinvento.net
* @copyright 2015 Designinvento
*
* @wordpress-plugin
Plugin Name: Comments Ratings
Plugin URI:  http://designinvento.net
Description: Easily transform your comments into reviews.
Version: 1.1.5
Author: Designinvento
Author URI: http://designinvento.net
Author Email: help.designinvento@gmail.com
Text Domain: comments-ratings
License:     GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
Domain Path: /lang
*/


if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined('EXT')) {
	define('EXT', '.php');
}
define('DIRS_DIR', plugin_dir_path( __FILE__ ));
define('DIRS_URL', plugin_dir_url( __FILE__ ));
require 'includes/main/bootstrap'.EXT;

$config = include 'includes/dir-config'.EXT;

//load_plugin_textdomain( 'comments-ratings', false, basename( dirname( __FILE__ ) ) . '/languages/' );


$defaults = include 'includes/dir-defaults'.EXT;

$current_data = get_option($config['settings-key']);

if ($current_data === false) {
	add_option($config['settings-key'], $defaults);
}
else if (count(array_diff_key($defaults, $current_data)) != 0) {
	$plugindata = array_merge($defaults, $current_data);
	update_option($config['settings-key'], $plugindata);
}

$basepath = dirname(__FILE__).DIRECTORY_SEPARATOR;
$callbackpath = $basepath.'callbacks'.DIRECTORY_SEPARATOR;
direviews::require_all($callbackpath);

require_once( plugin_dir_path( __FILE__ ) . 'includes/class-direviews.php' );


register_activation_hook( __FILE__, array( 'DiRClass', 'activate' ) );


function direviews_init_plugin() {
	global $direviews_plugin;
	$direviews_plugin = DiRClass::get_instance();
}

add_action( 'after_setup_theme', 'direviews_init_plugin' );