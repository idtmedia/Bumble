<?php
/**
 * Contact Form Module
 * 
 * This module display contact form on Ad details pages instead of just the contact information.
 * 
 * @package Adverts
 * @subpackage ContactForm
 * @author Grzegorz Winiarski
 * @version 0.1
 */

global $adverts_namespace;

// Add Contact Form to adverts_namespace, in order to store module options and default options
$adverts_namespace['contact_form'] = array(
    'option_name' => 'adext_contact_form_config',
    'default' => array(
        'show_phone' => '1',
        'from_name' => '',
        'from_email' => ''
    )
);

if(is_admin() ) {
    add_action( "init", "adext_contact_form_init_admin", 20 );
} else {
    add_action( "init", "adext_contact_form_init_frontend", 20 );
}

/**
 * Renders contact form on Ad details page
 * 
 * This function is called by adverts_tpl_single_bottom action in
 * wpadverts/templates/single.php
 * 
 * @see adverts_tpl_single_bottom action
 * 
 * @since 1.0.10
 * @access public
 * @param int $post_id Post ID
 * @return void
 */
function adext_contact_form( $post_id ) {
   
    include_once ADVERTS_PATH . 'includes/class-form.php';
    include_once ADVERTS_PATH . 'includes/class-html.php';
    
    $show_form = false;
    $flash = array( "error" => array(), "info" => array());;
    $email = get_post_meta( $post_id, "adverts_email", true );
    $phone = get_post_meta( $post_id, "adverts_phone", true );
    $message = null;
    $form = new Adverts_Form( Adverts::instance()->get( "form_contact_form" ) );
    $buttons = array(
        array(
            "tag" => "input",
            "name" => "adverts_contact_form",
            "type" => "submit",
            "value" => __( "Send Message", "adverts" ),
            "style" => "font-size:1.2em; margin-top:1em",
            "html" => null
        ),
    );
    
    if( adverts_request( "adverts_contact_form" ) ) {
        
        wp_enqueue_script( 'adverts-contact-form-scroll' );
        
        $form->bind( stripslashes_deep( $_POST ) );
        $valid = $form->validate();
        
        if( $valid ) {
            
            $reply_to = $form->get_value( "message_email" );
            
            if( $form->get_value( "message_name" ) ) {
                $reply_to = $form->get_value( "message_name" ) . "<$reply_to>";
            }
            $post = get_post($post_id);
            $mail = array(
                "to" => get_post_meta( $post_id, "adverts_email", true ),
                "subject" => $form->get_value( "message_subject" ),
                "message" => 'From: '.$form->get_value( "message_name" ).'<br>'.
                            'Email: '.$form->get_value( "message_email" ).'<br>'.
                            'Message:'.$form->get_value( "message_body" ),
                "headers" => array(
                    "Reply-To: " . $reply_to,
                    'Content-Type: text/html; charset=UTF-8'
                )
            );

            $body = '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head> <title></title> <!--[if !mso]><!-- --> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!--<![endif]--><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><style type="text/css"> #outlook a { padding: 0; } .ReadMsgBody { width: 100%; } .ExternalClass { width: 100%; } .ExternalClass * { line-height:100%; } body { margin: 0; padding: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; } table, td { border-collapse:collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; } img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; } p { display: block; margin: 13px 0; }</style><!--[if !mso]><!--><style type="text/css"> @media only screen and (max-width:480px) { @-ms-viewport { width:320px; } @viewport { width:320px; } }</style><!--<![endif]--><!--[if mso]><xml> <o:OfficeDocumentSettings> <o:AllowPNG/> <o:PixelsPerInch>96</o:PixelsPerInch> </o:OfficeDocumentSettings></xml><![endif]--><!--[if lte mso 11]><style type="text/css"> .outlook-group-fix { width:100% !important; }</style><![endif]--><!--[if !mso]><!--> <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet" type="text/css"> <style type="text/css"> @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700); @import url(https://fonts.googleapis.com/css?family=Cabin); </style> <!--<![endif]--><style type="text/css"> @media only screen and (min-width:480px) { .mj-column-per-100 { width:100%!important; } }</style></head><body style="background: #FFFFFF;"> <div class="mj-container" style="background-color:#FFFFFF;"><!--[if mso | IE]> <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;"> <tr> <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"> <![endif]--><div style="margin:0px auto;max-width:600px;background:#000000;"><table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#000000;" align="center" border="0"><tbody><tr><td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:9px 0px 9px 0px;"><!--[if mso | IE]> <table role="presentation" border="0" cellpadding="0" cellspacing="0"> <tr> <td style="vertical-align:top;width:600px;"> <![endif]--><div class="mj-column-per-100 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%;"><table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"><tbody><tr><td style="word-wrap:break-word;font-size:0px;padding:10px 10px 10px 10px;" align="center"><table role="presentation" cellpadding="0" cellspacing="0" style="border-collapse:collapse;border-spacing:0px;" align="center" border="0"><tbody><tr><td style="width:186px;"><img alt="" title="" height="auto" src="http://pwmhosting.ca/bumble/wp-content/uploads/2018/08/logo.png" style="border:none;border-radius:0px;display:block;font-size:13px;outline:none;text-decoration:none;width:100%;height:auto;" width="186"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]> </td></tr></table> <![endif]--></td></tr></tbody></table></div><!--[if mso | IE]> </td></tr></table> <![endif]--> <!--[if mso | IE]> <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;"> <tr> <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"> <![endif]--><table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;" border="0"><tbody><tr><td><div style="margin:0px auto;max-width:600px;"><table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;" align="center" border="0"><tbody><tr><td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:0px 0px 0px 0px;"><!--[if mso | IE]> <table role="presentation" border="0" cellpadding="0" cellspacing="0"> <tr> <td style="vertical-align:top;width:600px;"> <![endif]--><div class="mj-column-per-100 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%;"></div><!--[if mso | IE]> </td></tr></table> <![endif]--></td></tr></tbody></table></div></td></tr></tbody></table><!--[if mso | IE]> </td></tr></table> <![endif]--> <!--[if mso | IE]> <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;"> <tr> <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"> <![endif]--><table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;" border="0"><tbody><tr><td><div style="margin:0px auto;max-width:600px;"><table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;" align="center" border="0"><tbody><tr><td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:0px 0px 0px 0px;"><!--[if mso | IE]> <table role="presentation" border="0" cellpadding="0" cellspacing="0"> <tr> <td style="vertical-align:top;width:600px;"> <![endif]--><div class="mj-column-per-100 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%;"><table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"><tbody><tr><td style="word-wrap:break-word;font-size:0px;padding:19px 20px 19px 20px;" align="center"><div style="cursor:auto;color:#000000;font-family:Cabin, sans-serif;font-size:15px;line-height:22px;text-align:center;border: 1px solid #f05d22; padding: 10px;"><p>Congratulations! You have received a new message on your ad: <strong>'.$post->post_title.'</strong></p>
    '.$mail["message"].'
</div></td></tr></tbody></table></div><!--[if mso | IE]> </td></tr></table> <![endif]--></td></tr></tbody></table></div></td></tr></tbody></table><!--[if mso | IE]> </td></tr></table> <![endif]--> <!--[if mso | IE]> <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;"> <tr> <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"> <![endif]--><!--[if mso | IE]> </td></tr></table> <![endif]--> <!--[if mso | IE]> <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;"> <tr> <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"> <![endif]--><!--[if mso | IE]> </td></tr></table> <![endif]-->
    <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;" border="0"><tbody><tr><td><div style="margin:0px auto;max-width:600px;"><table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;" align="center" border="0"><tbody><tr><td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:0px 0px 0px 0px;"><!--[if mso | IE]> <table role="presentation" border="0" cellpadding="0" cellspacing="0"> <tr> <td style="vertical-align:top;width:600px;"> <![endif]--><div class="mj-column-per-100 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%;"><table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"><tbody><tr><td style="word-wrap:break-word;font-size:0px;padding:18px 25px 18px 25px;padding-top:10px;padding-left:25px;" align="center"></td></tr></tbody></table></div><!--[if mso | IE]> </td></tr></table> <![endif]--></td></tr></tbody></table></div></td></tr></tbody></table></div></body></html>';
            
            $mail = apply_filters( "adverts_contact_form_email", $mail, $post_id, $form );
           
            add_filter( 'wp_mail_from', 'adext_contact_form_mail_from' );
            add_filter( 'wp_mail_from_name', 'adext_contact_form_mail_from_name' );
            
            wp_mail( $mail["to"], $mail["subject"], $body, $mail["headers"] );
            
            remove_filter( 'wp_mail_from', 'adext_contact_form_mail_from' );
            remove_filter( 'wp_mail_from_name', 'adext_contact_form_mail_from_name' );
            
            $form->bind( array() );
            
            $flash["info"][] = array(
                "message" => __( "Your message has been sent.", "adverts" ),
                "icon" => "adverts-icon-ok"
            );
        } else {
            $flash["error"][] = array(
                "message" => __( "There are errors in your form.", "adverts" ),
                "icon" => "adverts-icon-attention-alt"
            );
            $show_form = true; 
        }
    } else {
        
        if( get_current_user_id() > 0 ) {
            $user = wp_get_current_user();
            /* @var $user WP_User */
            
            $bind = array(
                "message_name" => $user->display_name,
                "message_email" => $user->user_email
            );
            
            $form->bind( $bind );
            
        }
    }
    
    ?>

    <div id="adverts-contact-form-scroll"></div>

    <?php adverts_flash( $flash ) ?>

    <div class="adverts-single-actions">
        <?php if( ! empty( $email ) ): ?>
        <a href="#" class="adverts-button adverts-show-contact-form">
            <?php esc_html_e("Send Message", "adverts") ?>
            <span class="adverts-icon-down-open"></span>
        </a>
        <?php endif; ?>
        
        <?php if( adverts_config( "contact_form.show_phone") == "1" && ! empty( $phone ) ): ?>
        <span class="adverts-button" style="background-color: transparent; cursor: auto">
            <?php esc_html_e( "Phone", "adverts" ) ?>
            <a href="tel:<?php echo esc_html( $phone ) ?>"><?php echo esc_html( $phone ) ?></a>
            <span class="adverts-icon-phone"></span>
        </span>
        <?php endif; ?>
    </div>

    <?php if( ! empty( $email ) ): ?>
    <div class="adverts-contact-box" <?php if($show_form): ?>style="display: block"<?php endif ?>>
        <?php include apply_filters( "adverts_template_load", ADVERTS_PATH . 'templates/form.php' ) ?>
    </div>
    <?php endif; ?>

    <?php
}

/**
 * Frontend Adverts Contact Form Init Function
 * 
 * Deregister default contact box and register contact form box instead.
 * 
 * @since 1.0.10
 * @return void
 */
function adext_contact_form_init_frontend() {
    remove_action('adverts_tpl_single_bottom', 'adverts_single_contact_information');
    add_action('adverts_tpl_single_bottom', 'adext_contact_form');
    
    wp_register_script( 'adverts-contact-form-scroll', ADVERTS_URL  .'/assets/js/adverts-contact-form-scroll.js', array( 'jquery' ), "1", true);
}

/**
 * Frontend Adverts Contact Form Admin Init Function
 * 
 * Deregister default show contact AJAX action
 * 
 * @since 1.0.10
 * @return void
 */
function adext_contact_form_init_admin() {
    remove_action('wp_ajax_adverts_show_contact', 'adverts_show_contact');
    remove_action('wp_ajax_nopriv_adverts_show_contact', 'adverts_show_contact');
}

/**
 * Sets default mail "From" email
 * 
 * This function is applied via wp_mail_from filter in adext_contact_form function.
 * 
 * @since 1.0.10
 * @param string $from_email
 * @return string
 */
function adext_contact_form_mail_from( $from_email ) {
    if( adverts_config( "contact_form.from_email") ) {
        return adverts_config( "contact_form.from_email");
    } else {
        return $from_email;
    }
}

/**
 * Sets default mail "From" name
 * 
 * This function is applied via wp_mail_from filter in adext_contact_form function.
 * 
 * @since 1.0.10
 * @param string $from_name
 * @return string
 */
function adext_contact_form_mail_from_name( $from_name ) {
    if( adverts_config( "contact_form.from_name") ) {
        return adverts_config( "contact_form.from_name");
    } else {
        return $from_name;
    }
}

// Contact Form
Adverts::instance()->set("form_contact_form", array(
    "name" => "contact",
    "action" => "",
    "field" => array(
        array(
            "name" => "message_name",
            "type" => "adverts_field_text",
            "label" => __("Your Name", "adverts"),
            "order" => 10,
            "class" => "",
            "validator" => array( 
                array( "name" => "is_required" ),
            )
        ),
        array(
            "name" => "message_email",
            "type" => "adverts_field_text",
            "label" => __("Your Email", "adverts"),
            "order" => 10,
            "class" => "",
            "validator" => array( 
                array( "name" => "is_required" ),
                array( "name" => "is_email" ),
            )
        ),
        array(
            "name" => "message_subject",
            "type" => "adverts_field_text",
            "label" => __("Subject", "adverts"),
            "order" => 10,
            "class" => "",
            "validator" => array( 
                array( "name" => "is_required" ),
            )
        ),
        array(
            "name" => "message_body",
            "type" => "adverts_field_textarea",
            "mode" => "plain-text",
            "label" => __("Message", "adverts"),
            "order" => 10,
            "class" => "",
            "validator" => array( 
                array( "name" => "is_required" ),
            )
        ),
    )
));