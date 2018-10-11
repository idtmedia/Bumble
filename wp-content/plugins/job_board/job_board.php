<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://creativeosc.com
 * @since             1.0.0
 * @package           Job_board
 *
 * @wordpress-plugin
 * Plugin Name:       Job Board
 * Plugin URI:        http://creativeosc.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Ngo Ngoc Thang
 * Author URI:        http://creativeosc.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       job_board
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-job_board-activator.php
 */
function activate_job_board() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-job_board-activator.php';
	Job_board_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-job_board-deactivator.php
 */
function deactivate_job_board() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-job_board-deactivator.php';
	Job_board_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_job_board' );
register_deactivation_hook( __FILE__, 'deactivate_job_board' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-job_board.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_job_board() {

	$plugin = new Job_board();
	$plugin->run();

}
run_job_board();

add_shortcode( 'bidding_form', 'bidding_form' );
function bidding_form( $atts) {
    $a = shortcode_atts( array(
        'job_id' => '',
    ), $atts );

    // Return output
    ob_start();
    if(is_user_logged_in()) {
        if(Job_board::check_can_apply(get_current_user_id(), $a['job_id'])){
            //            <p class="dir_message_field"><label for="apply_attachment">Attachment</label>
//                <input type="file" name="apply_attachment" id="apply_attachment" />
//            </p>
            echo '<form action="" method="post" id="commentform" class="comment-form" enctype="multipart/form-data">
            <p class="dir_message_field">
                <label for="apply_cost">'.__('YOUR BID AMOUNT ($)').':</label>
                <input type="number" min="0.01" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" id="apply_cost" name="apply_cost" placeholder="'.__('YOUR BID AMOUNT ($)').'" size="25">
            </p>
            <p class="dir_message_field"><label for="apply_message">'.__('Message').'</label>
                <textarea id="apply_message" name="apply_message" cols="84" rows="9" aria-required="true" required="required" placeholder="'.__('Tell us why you’re a good fit for this project (your skills & experience in the field)').'"></textarea>
            </p>
            <p class="form-submit"><input name="submit" type="submit" id="submit" class="submit" value="'.__('Submit application').'">
                <input type="hidden" name="contractor" value="' . get_current_user_id() . '">
                <input type="hidden" name="job" value="' . $a['job_id'] . '">
                ' . wp_nonce_field('post_application_action', 'post_application_nonce') . '
            </p>
            </form>';
        }else{
            _e('You dont have permission for access this form or you applied for this job already');
        }
    }else{
        _e('Please login to access the form');
    }
    return ob_get_clean();
}

function get_total_bids(){
    $user_id = get_current_user_id();
    $args = array(
        'post_type' => 'alsp_listing',
        'author' => $user_id,
        'orderby' => 'post_date',
        'order' => 'ASC',
        'posts_per_page' => -1
    );
    $current_user_jobs = get_posts($args);
    $post_ids_array = array();

    if (count($current_user_jobs) > 0) {
        foreach ($current_user_jobs as $post) :
            setup_postdata($post);
            $post_ids_array[] = $post->ID;
        endforeach;
        wp_reset_postdata();
    }
    $applications = get_posts(array(
        'posts_per_page' => -1,
        'post_type' => 'bidding',
        'meta_query' => array(
            array(
                'key' => 'job',
                'value' => $post_ids_array,
                'compare' => 'IN',
            ),
        ),
    ));
    return count($applications);
}

// Deal with images uploaded from the front-end while allowing ACF to do it's thing
//function my_acf_pre_save_post($post_id) {

//}

//add_filter('acf/pre_save_post' , 'my_acf_pre_save_post');