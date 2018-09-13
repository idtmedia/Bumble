<?php
/**
 * Uninstall DesignInvento Messaging System
 *
 * Deletes all the plugin data
 */

// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;

include_once( 'functions.php' );

global $wpdb;

if( difp_get_option( 'delete_data_on_uninstall', false ) ) {

	/** Delete All the Custom Post Types of Frpnt End PM */
	$post_types = array( 'difp_message', 'difp_announcement' );
	
	foreach ( $post_types as $post_type ) {

		$items = get_posts( array( 'post_type' => $post_type, 'post_status' => 'any', 'numberposts' => -1, 'fields' => 'ids' ) );

		if ( $items ) {
			foreach ( $items as $item ) {
				wp_delete_post( $item, true);
			}
		}
	}

	/** Delete all the Plugin Options */
	delete_option( 'DIFP_admin_options' );
	delete_metadata( 'user', 0, 'DIFP_user_options', '', true );
	delete_metadata( 'user', 0, '_difp_user_message_count', '', true );
	delete_metadata( 'user', 0, '_difp_user_announcement_count', '', true );
	
	$roles = array( 'administrator', 'editor' );
	$caps = difp_get_plugin_caps();
	
	foreach( $roles as $role ) {
		$role_obj = get_role( $role );
		if( !$role_obj )
			continue;
			
		foreach( $caps as $cap ) {
			$role_obj->remove_cap( $cap );
		}
	}

	// Remove all database tables of DesignInvento Messaging System (if any)
	$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "difp_messages" );
	$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "difp_meta" );

	// Remove any transients we've left behind
	$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '\_transient\_difp\_%'" );
	$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '\_transient\_timeout\_difp\_%'" );
}
