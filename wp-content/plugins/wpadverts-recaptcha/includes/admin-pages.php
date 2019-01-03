<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Renders reCAPTCHA config form.
 * 
 * The page is rendered in wp-admin / Classifieds / Options / reCAPTCHA panel
 * 
 * @since 1.0
 * @return void
 */
function wpadverts_recaptcha_page_options() {
    
    $flash = Adverts_Flash::instance();
    $error = array();
    
    $options = get_option ( "wpadverts_recaptcha_config", array() );
    $options=null;
    if( $options === null || empty( $options ) ) {
        $options = adverts_config( "recaptcha.ALL" );
    }
    
    $scheme = Adverts::instance()->get("form_recaptcha_config");
    $form = new Adverts_Form( $scheme );
    $form->bind( $options );
    
    $button_text = __("Update Options", "adverts");

    if(isset($_POST) && !empty($_POST)) {
        $form->bind( $_POST );
        $valid = $form->validate();

        if($valid) {
            
            update_option( "wpadverts_recaptcha_config", $form->get_values() );
            $flash->add_info( __("Settings updated.", "adverts") );
        } else {
            $flash->add_error( __("There are errors in your form.", "adverts") );
        }
    }
    
    include dirname( ADVERTS_PATH ) . '/wpadverts-recaptcha/admin/options.php';
}

// Fee Per Category config form
Adverts::instance()->set("form_recaptcha_config", array(
    "name" => "recaptcha_config",
    "action" => "",
    "field" => array(
        array(
            "name" => "_header_recaptcha_keys",
            "type" => "adverts_field_header",
            "title" => __("API Keys", "wpadverts-recaptcha"),
            "order" => 10
        ),
        array(
            "name" => "site_key",
            "type" => "adverts_field_text",
            "order" => 10,
            "label" => __( "Site Key", "wpadverts-recaptcha" ),
            "is_required" => true,
            "validator" => array( 
                array( "name" => "is_required" ),
            )
        ),
        array(
            "name" => "secret_key",
            "type" => "adverts_field_text",
            "order" => 10,
            "label" => __( "Secret Key", "wpadverts-recaptcha" ),
            "is_required" => true,
            "validator" => array( 
                array( "name" => "is_required" ),
            )
        ),
        array(
            "name" => "_header_recaptcha_theme",
            "type" => "adverts_field_header",
            "title" => __("reCAPTCHA", "wpadverts-recaptcha"),
            "order" => 10
        ),
        array(
            "name" => "data_theme",
            "type" => "adverts_field_select",
            "order" => 10,
            "label" => __( "Theme", "wpadverts-recaptcha" ),
            "is_required" => true,
            "options" => array(
                array( "value" => "light", "text" => __( "Light", "wpadverts-recaptcha" ) ),
                array( "value" => "dark", "text" => __( "Dark", "wpadverts-recaptcha" ) ),
            )
        ),
        array(
            "name" => "data_type",
            "type" => "adverts_field_select",
            "order" => 10,
            "label" => __( "Type", "wpadverts-recaptcha" ),
            "is_required" => true,
            "options" => array(
                array( "value" => "image", "text" => __( "Image", "wpadverts-recaptcha" ) ),
                array( "value" => "audio", "text" => __( "Audio", "wpadverts-recaptcha" ) ),
            )
        ),
        array(
            "name" => "data_size",
            "type" => "adverts_field_select",
            "order" => 10,
            "label" => __( "Size", "wpadverts-recaptcha" ),
            "is_required" => true,
            "options" => array(
                array( "value" => "normal", "text" => __( "Normal", "wpadverts-recaptcha" ) ),
                array( "value" => "compact", "text" => __( "Compact", "wpadverts-recaptcha" ) ),
            )
        ),
        array(
            "name" => "_header_recaptcha_enable",
            "type" => "adverts_field_header",
            "title" => __("Enable reCAPTCHA", "wpadverts-recaptcha"),
            "order" => 10
        ),
        array(
            "name" => "enabled[advert]",
            "type" => "adverts_field_select",
            "order" => 10,
            "label" => __( "Advert Add ([adverts_add])", "wpadverts-recaptcha" ),
            "is_required" => true,
            "options" => array(
                array( "value" => "0", "text" => __( "Disabled", "wpadverts-recaptcha" ) ),
                array( "value" => "1", "text" => __( "Enabled for All users", "wpadverts-recaptcha" ) ),
                array( "value" => "2", "text" => __( "Enabled for Unregistered users", "wpadverts-recaptcha" ) ),
            )
        ),
        array(
            "name" => "enabled[contact]",
            "type" => "adverts_field_select",
            "order" => 10,
            "label" => __( "Contact Form", "wpadverts-recaptcha" ),
            "is_required" => true,
            "options" => array(
                array( "value" => "0", "text" => __( "Disabled", "wpadverts-recaptcha" ) ),
                array( "value" => "1", "text" => __( "Enabled for All users", "wpadverts-recaptcha" ) ),
                array( "value" => "2", "text" => __( "Enabled for Unregistered users", "wpadverts-recaptcha" ) ),
            )
        ),
    )
) );
