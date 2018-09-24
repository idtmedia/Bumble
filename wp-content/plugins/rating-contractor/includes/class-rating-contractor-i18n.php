<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://creativeosc.com
 * @since      1.0.0
 *
 * @package    Rating_Contractor
 * @subpackage Rating_Contractor/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Rating_Contractor
 * @subpackage Rating_Contractor/includes
 * @author     Ngo Ngoc Thang <thangnn1510@gmail.com>
 */
class Rating_Contractor_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'rating-contractor',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
