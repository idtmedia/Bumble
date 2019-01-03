<?php
/*
 * Plugin Name: WP Adverts - reCAPTCHA
 * Plugin URI: https://wpadverts.com/
 * Description: Protect your WPAdverts forms from spam using reCAPTCHA technology.
 * Author: Greg Winiarski
 * Text Domain: wpadverts-recaptcha
 * Version: 1.0
 * 
 * Adverts is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Adverts is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Adverts. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package Adverts
 * @subpackage reCAPTCHA
 * @author Grzegorz Winiarski
 * @global $adverts_namespace array
 * @version 1.0
 */

// Add reCAPTCHA to $adverts_namespace
add_action( 'plugins_loaded', 'wpadverts_recaptcha_namespace' );

/**
 * Adds default addon configuration to $adverts_namespace
 * 
 * @global array $adverts_namespace
 * 
 * @access public
 * @since 1.0
 * @return void
 */
function wpadverts_recaptcha_namespace() {
    global $adverts_namespace;

    // Add PayPal Standard to adverts_namespace, in order to store module options and default options
    $adverts_namespace['recaptcha'] = array(
        'option_name' => 'wpadverts_recaptcha_config',
        'default' => array(
            'site_key' => '',
            'secret_key' => '',
            'enabled' => array(
                'advert' => 1,
                'contact' => 1
            ),
            'data_theme' => 'light',
            'data_type' => 'image',
            'data_size' => 'normal'
        )
    );
}

// Init reCAPTCHA addon
// add_action( 'init', 'adverts_recaptcha_init' );

if(is_admin() ) {
    // Run Adverts reCAPTCHA admin only actions
    add_action( 'init', 'adverts_recaptcha_init_admin' );
} else {
    // Run Adverts reCAPTCHA frontend only actions
    add_action( 'init', 'adverts_recaptcha_init_frontend' );
}

/**
 * Init Adverts reCAPTCHA frontend filters
 * 
 * This function executes actions/filters that need to be run with each frontend
 * request when the integration is enabled.
 * 
 * @access public
 * @since 1.0
 * @return void
 */
function adverts_recaptcha_init_frontend() {
    load_plugin_textdomain( "wpadverts-recaptcha", false, dirname( plugin_basename( __FILE__ ) ) . "/languages/" );
    
    add_filter( "adverts_form_load", "adverts_recaptcha_form_load" );
}

/**
 * Init WPAdverts reCAPTCHA admin filters and actions
 * 
 * @access public
 * @since 1.0
 * @return void
 */
function adverts_recaptcha_init_admin() {
    if( ! defined( "ADVERTS_PATH" ) ) {
        return;
    }
    
    include_once ADVERTS_PATH . 'includes/class-updates-manager.php';
    $manager = new Adverts_Updates_Manager(
        "wpadverts-recaptcha/wpadverts-recaptcha.php", 
        "wpadverts-recaptcha", 
        "1.0.0"
    );
    $manager->connect(); 
}

/**
 * Renders reCAPTCHA field
 * 
 * This functions is registered as field renderer by adverts_form_add_field() function
 * in adverts_recaptcha_form_load() function.
 * 
 * @see adverts_recaptcha_form_load()
 * 
 * @since 1.0
 * @param array $field  Field params
 * @return void
 */
function adverts_recaptcha_field( $field ) {
    
    include_once ADVERTS_PATH . "/includes/class-html.php";

    $html = new Adverts_Html("div", array(
        "class" => "g-recaptcha",
        "data-sitekey" => adverts_config( "recaptcha.site_key" ),
        "data-theme" => adverts_config( "recaptcha.data_theme" ),
        "data-type" => adverts_config( "recaptcha.data_type" ),
        "data-size" => adverts_config( "recaptcha.data_size" ),
    ));
    $html->forceLongClosing(true);

    echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
    echo $html->render();
}


/**
 * Loads reCAPTCHA field
 * 
 * This function loads reCAPTCHA field into form in which it is enabled in configuration.
 * 
 * @since 1.0.0
 * @param array $form   Form Scheme
 * @return array        Updated Form scheme
 */
function adverts_recaptcha_form_load( $form ) {
    
    $options = adverts_config( "recaptcha.ALL" );
    $option_name = $form["name"];
    
    if( ! isset( $options["enabled"][$option_name] ) || is_admin() ) {
        return $form;
    }
    
    // do not show payment options when editing Ad.
    $id = adverts_request( "advert_id" );
    $ad = get_post( $id );
    if( intval($id) && $ad && in_array($ad->post_status, array("publish", "expired", "pending" ) ) ) {
        return $form;
    }
    
    $option = $options["enabled"][$option_name];
    
    if($option == "0" ) {
        // disable reCAPTCHA for this form
        return $form;
    } elseif( $option == 2 && get_current_user_id() > 0 ) {
        // enable for unregistered
        return $form;
    } 
    
    adverts_form_add_validator("recaptcha_validate", array(
        "callback" => "wpadverts_recaptcha_validate",
        "label" => __( "reCAPTCHA", "wpadverts-recaptcha" ),
        "params" => array(),
        "default_error" => __( "Incorrect captcha value.", "wpadverts-recaptcha" ),
        "message" => array(
            "http-error" => __( "Cannot connect to reCAPTCHA server.", "wpadverts-recaptcha" ),
            "missing-input-secret" => __( "The secret parameter is missing.", "wpadverts-recaptcha" ),
            "invalid-input-secret" => __( "The secret parameter is invalid or malformed.", "wpadverts-recaptcha" ),
            "missing-input-response" => __( "The captcha is missing.", "wpadverts-recaptcha" ),
            "invalid-input-response" => __( "The captcha is invalid or malformed.", "wpadverts-recaptcha" ),
        ),
        "validate_empty" => true
    ));
    
    adverts_form_add_field("adverts_recaptcha_field", array(
        "renderer" => "adverts_recaptcha_field",
        "callback_save" => null,
        "callback_bind" => "adverts_bind_single",
    ));
    
    $form["field"][] = array(
        "name" => "_adverts_recaptcha_header",
        "type" => "adverts_field_header",
        "order" => 1000,
        "label" => __( 'Captcha', 'adverts-recaptcha' )
    );
    $form["field"][] = array(
        "name" => "g-recaptcha-response",
        "type" => "adverts_recaptcha_field",
        "order" => 1000,
        "label" => __( "Captcha", "adverts-recaptcha" ),
        "validator" => array( 
            array( "name" => "recaptcha_validate" ),
        )
    );
    
    return $form;
}

/**
 * reCAPTCHA validator
 * 
 * Checks if provided captcha is valid.
 * 
 * @param string $captcha
 * @return boolean|string
 */
function wpadverts_recaptcha_validate( $captcha ) {
    
    $query = array(
        "secret" => adverts_config( "recaptcha.secret_key" ),
        "response" => $_POST["g-recaptcha-response"],
        "remoteip" => $_SERVER["REMOTE_ADDR"]
    );

    $response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?".http_build_query($query));

    if(is_wp_error($response)) {
        return "http-error";
    } 

    $data = json_decode( $response["body"] );

    if($data->success) {
        return true;
    }

    $ec = 'error-codes';

    $errors = array(
        "missing-input-secret" ,
        "invalid-input-secret",
        "missing-input-response",
        "invalid-input-response",
    );

    foreach( $errors as $key ) {
        if( isset( $data->$ec ) && in_array( $key, $data->$ec ) ) {
            return $key; 
        }
    }

    return 'invalid';
}