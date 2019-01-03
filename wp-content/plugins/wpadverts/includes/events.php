<?php
/**
 * Scheduled Events
 * 
 * Registers wp-admin / Classifieds / Options page: menu item, UI and logic.
 *
 * @package     Adverts
 * @copyright   Copyright (c) 2015, Grzegorz Winiarski
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       0.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


add_action( 'wp', 'adverts_setup_schedule' );
add_filter( 'cron_schedules', 'adverts_cron_5_min' );

add_action( 'adverts_event_gc', 'adverts_event_gc' );
add_action( 'adverts_event_expire_ads', 'adverts_event_expire_ads' );

/**
 * Schedules Adverts events
 * 
 * This function schedules (in wp-cron) default events.
 * 
 * @since 0.1
 * @return void
 */
function adverts_setup_schedule() {
    
    // Schedule garbage collection, if not already scheduled
    if ( ! wp_next_scheduled( 'adverts_event_gc' ) ) {
        wp_schedule_event( time(), 'daily', 'adverts_event_gc');
    }
    
    // Schedule expired ads check, if not already scheduled
    if ( ! wp_next_scheduled( 'adverts_event_expire_ads' ) ) {
        wp_schedule_event( time(), '5minutes', 'adverts_event_expire_ads');
    }

}

/**
 * Adds new schedule to WP Cron
 * 
 * Registers new "every 5 minutes" cron schedule. This schedule is used to 
 * expire ads. {@see adverts_event_expire_ads}
 * 
 * @param array $schedules
 * @since 0.1
 * @return array
 */
function adverts_cron_5_min( $schedules ) {
    $schedules['5minutes'] = array(
        'interval' => 300,
        'display' => __( 'Every 5 minutes', 'adverts' )
    );
    return $schedules;
}

/**
 * Ads Garbage Collector
 * 
 * This function will delete all the Ads that were created while posting ad in
 * the frontend, but user for some reason did not finished posting them.
 * 
 * @since 0.1
 * @return void
 */
function adverts_event_gc() {
    
    // find tmp adverts that were last modified more than 24 hours ago,
    // by this time it is safe to assume that user will not finish posting the ad.
    $posts = new WP_Query( array(
        "post_type" => "advert",
        "post_status" => adverts_tmp_post_status(),
        "date_query" => array(
            array(
                "column" => "post_modified_gmt",
                "before" => date("Y-m-d H:i:s", current_time( 'timestamp', 1) - 3600*24)
            )
        )
    ) );
    
    if($posts->post_count) {
        foreach($posts->posts as $post) {
            
            // delete all attachements associated with this post.
            $param = array( 'post_parent' => $post->ID, 'post_type' => 'attachment' );
            $children = get_posts( $param );

            if( is_array( $children ) ) {
                foreach( $children as $attch) {
                    adverts_delete_post( $attch->ID );
                }
            } 

            // delete or trash the post
            adverts_delete_post( $post->ID );
        }
    }
    

}

/**
 * Expires ads
 * 
 * Function finds Adverts that already expired (value in _expiration_date
 * meta field is lower then current timestamp) and changes their status to 'expired'.
 * 
 * @since 0.1
 * @return void
 */
function adverts_event_expire_ads() {
    
    // find adverts with status 'publish' which exceeded expiration date
    // (_expiration_date is a timestamp)
    $posts = new WP_Query( array( 
        "post_type" => "advert",
        "post_status" => "publish",
        "meta_query" => array(
            array(
                "key" => "_expiration_date",
                "value" => current_time( 'timestamp' ),
                "compare" => "<="
            )
        )
    ) );
    

    if( $posts->post_count ) {
        foreach($posts->posts as $post) {
            // change post status to expired.
            $update = wp_update_post( array( 
                "ID" => $post->ID,
                "post_status" => "expired"
            ) );
        } // endforeach
    } // endif
    
}
