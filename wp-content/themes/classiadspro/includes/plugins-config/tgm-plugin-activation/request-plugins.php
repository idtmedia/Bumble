<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1
 * @author     Thomas Griffin <thomas@thomasgriffinmedia.com>
 * @author     Gary Jones <gamajo@gamajo.com>
 * @copyright  Copyright (c) 2012, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once PACZ_THEME_PLUGINS_CONFIG . "/tgm-plugin-activation/class-tgm-plugin-activation.php";

add_action( 'tgmpa_register', 'pacz_classiadspro_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function pacz_classiadspro_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(



        // This is an example of how to include a plugin from the WordPress Plugin Repository

        array(
            'name' => 'Visual Composer',
            'slug' => 'js_composer',
            'source' => 'https://assets.classiads.co/plugins/classiadspro/5-4/js_composer.zip',
            'required' => true,
            'version' => '5.5.2',
			'is_automatic' => true, // automatically activate plugins after installation
            'force_activation' => false,
            'force_deactivation' => false
        ),
		array(
            'name' => 'Classiadspro  Custom Posts', // The plugin name.
            'slug' => 'pacz-custom-posts', // The plugin slug (typically the folder name).
            'source' => 'https://assets.classiads.co/plugins/classiadspro/5-4/pacz-custom-posts.zip',
            'required' => true, // If false, the plugin is only 'recommended' instead of required.
            'version' => '2.2',
			'is_automatic' => true, // automatically activate plugins after installation
            'force_activation' => false,
            'force_deactivation' => false
        ),
		array(
            'name' => ' Listing',
            'slug' => 'listing',
            'source' => 'https://assets.classiads.co/plugins/classiadspro/5-4/listing.zip',
            'required' => true,
            'version' => '1.14.9',
			'is_automatic' => true, // automatically activate plugins after installation
            'force_activation' => false,
            'force_deactivation' => false
        ),
		array(
            'name' => ' Ultimate Addons for Visual Composer',
            'slug' => 'Ultimate_VC_Addons',
            'source' => 'https://assets.classiads.co/plugins/classiadspro/5-4/Ultimate_VC_Addons.zip',
            'required' => false,
            'version' => '3.16.24',
			'is_automatic' => true, // automatically activate plugins after installation
            'force_activation' => false,
            'force_deactivation' => false
        ),
		array(
            'name' => 'Slider Revolution',
            'slug' => 'revslider',
            'source' => 'https://assets.classiads.co/plugins/classiadspro/5-4/revslider.zip',
            'required' => false,
            'version' => '5.4.8',
			'is_automatic' => true, // automatically activate plugins after installation
            'force_activation' => false,
            'force_deactivation' => false
        ),
		array(
            'name' => 'AccessPress Social Login',
            'slug' => 'AccessPress_Social_Login',
            'source' => 'https://assets.classiads.co/plugins/classiadspro/5-4/AccessPress_Social_Login.zip',
            'required' => false,
            'version' => '1.3.3',
			'is_automatic' => true, // automatically activate plugins after installation
            'force_activation' => false,
            'force_deactivation' => false
        ),
		array(
            'name' => 'DHVC Form',
            'slug' => 'dhvc-form',
            'source' => 'https://assets.classiads.co/plugins/classiadspro/5-4/dhvc-form.zip',
            'required' => false,
            'version' => '2.2.0',
			'is_automatic' => true, // automatically activate plugins after installation
            'force_activation' => false,
            'force_deactivation' => false
        ),
		array(
            'name' => 'All-in-One WP Migration',
            'slug' => 'all-in-one-wp-migration',
            'source' => '',
            'required' => false,
            'version' => '',
			'is_automatic' => true, // automatically activate plugins after installation
            'force_activation' => false,
            'force_deactivation' => false
        ),
		array(
            'name' => 'Classiads Templates By Designinvento',
            'slug' => 'all-in-one-wp-migration-di-templates',
            'source' => 'https://assets.classiads.co/plugins/classiadspro/5-4/all-in-one-wp-migration-di-templates.zip',
            'required' => false,
            'version' => '1.0',
			'is_automatic' => true, // automatically activate plugins after installation
            'force_activation' => false,
            'force_deactivation' => false
        ),
		array(
            'name' => 'Taxonomy Terms Order',
            'slug' => 'taxonomy-terms-order',
            'source' => '',
            'required' => false,
            'version' => '',
			'is_automatic' => true, // automatically activate plugins after installation
            'force_activation' => false,
            'force_deactivation' => false
        ),
		array(
            'name' => 'WooCommerce',
            'slug' => 'woocommerce',
            'source' => '',
            'required' => false,
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false
        ),


    );

/**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => esc_html__( 'Install Required Plugins', 'classiadspro' ),
            'menu_title'                      => esc_html__( 'Install Plugins', 'classiadspro' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s', 'classiadspro' ), // %s = plugin name.
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'classiadspro' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'classiadspro' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'classiadspro' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'classiadspro' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'classiadspro' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'classiadspro' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'classiadspro'  ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'classiadspro'  ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'classiadspro'  ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'classiadspro'  ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'classiadspro'  ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer', 'classiadspro' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'classiadspro' ),
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'classiadspro' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}