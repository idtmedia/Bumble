<?php

extract( shortcode_atts( array(
            'title' => '',
            'email' => get_bloginfo( 'admin_email' ),
            'style' => 'classic',
            'skin' => 'dark',
            'skin_color' => '',
            'btn_text_color' => '',
            'btn_hover_text_color' => '',
            'phone' => 'true',
            'captcha' => 'true',
            'el_class' => '',
        ), $atts ) );




$id = uniqid();
$tabindex = $id;
$name_str = esc_html__( 'FULL NAME ', 'pacz' );
$email_str = esc_html__( 'EMAIL', 'pacz' );
$submit_str = esc_html__( 'SUBMIT', 'pacz' );
$content_str = esc_html__( 'SHORT MESSAGE', 'pacz' );
$phone_str = esc_html__( 'YOUR PHONE NUMBER', 'pacz' );
$enter_captcha = esc_html__( 'Enter Captcha', 'pacz' );
$not_readable = esc_html__( 'Not readable?', 'pacz' );
$change_text= esc_html__( 'Change text.', 'pacz' );

$icon_user = $style == 'classic' ? '<i class="pacz-icon-user"></i>' : '';
$icon_email = $style == 'classic' ? '<i class="pacz-icon-envelope-o"></i>' : '';
$icon_phone = $style == 'classic' ? '<i class="pacz-theme-icon-phone"></i>' : '';
$icon_lock= $style == 'classic' ? '<i class="pacz-li-lock"></i>' : '';

$email = antispambot($email);
$output = $skin_style = "";

// Get global JSON contructor object for styles and create local variable
global $classiadspro_dynamic_styles;
$classiadspro_styles = '';

if ( $style == 'modern' ) {
    $classiadspro_styles .= '
        #contact-form-'.$id.' .text-input,
        #contact-form-'.$id.' .pacz-textarea,
        #contact-form-'.$id.' .pacz-button{
            border-color:'.$skin_color.';
        }
        #contact-form-'.$id.' .text-input,
        #contact-form-'.$id.' .pacz-textarea{
            color:'.$skin_color.';
        }
        #contact-form-'.$id.' .text-input::-webkit-input-placeholder,
        #contact-form-'.$id.' .pacz-textarea::-webkit-input-placeholder,
        #contact-form-'.$id.' .text-input:-moz-placeholder,
        #contact-form-'.$id.' .pacz-textarea:-moz-placeholder,
        #contact-form-'.$id.' .text-input::-moz-placeholder,
        #contact-form-'.$id.' .pacz-textarea::-moz-placeholder,
        #contact-form-'.$id.' .text-input:-ms-input-placeholder,
        #contact-form-'.$id.' .pacz-textarea:-ms-input-placeholder{
            color:'.$skin_color.';
        }
        #contact-form-'.$id.' .pacz-button{
            color:'.$btn_text_color.' !important;
        }
        #contact-form-'.$id.' .pacz-button:hover{
            background-color:'.$skin_color.';
            color:'.$btn_hover_text_color.' !important;
        }
        #contact-form-'.$id.' .captcha-change-image {
            color:'.$skin_color.';
        }
        ';
}

$skin_style .= ($style == 'modern') ? '' : $skin.'-skin ';

$output .= '<div id="contact-form-'.$id.'" class="pacz-contact-form-wrapper classic-style dark-skin '.$el_class.'">';
$output .= '    <form class="pacz-contact-form three-column" method="post" novalidate="novalidate">';
$output .= '        <div class="pacz-form-row">
                        <input placeholder="'.$name_str.'" type="text" required="required" name="contact_name" class="text-input" value="" tabindex="'.($tabindex++).'" />
						'.$icon_user.'
                    </div>';
$output .= '        <div class="pacz-form-row">
                        
                        <input placeholder="'.$email_str.'" type="email" required="required" name="contact_email" class="text-input" value="" tabindex="'.($tabindex++).'" />
						'.$icon_email.'
                        </div>';
if($phone == 'true'){
$output .= '        <div class="pacz-form-row">
                        
                        <input placeholder="'.$phone_str.'" type="text" name="contact_phone" class="text-input" value="" tabindex="'.($tabindex++).'" />
						'.$icon_phone.'
						</div>';
}
$output .= '        <div class="pacz-form-textarea-wrap">
                        <textarea required="required" placeholder="'.$content_str.'" name="contact_content" class="pacz-textarea" tabindex="'.($tabindex++).'"></textarea></div>';



// CAPTCHA 
if($captcha == 'true') {
	
$output .= '<div class="pacz-form-row">
                '.$icon_lock.'
                <input placeholder="'.$enter_captcha.'" type="text" name="captcha" class="captcha-form text-input full" required="required" autocomplete="off" />
                    <img src="' . plugins_url( 'captcha/captcha.php', dirname(__FILE__) ) . '" class="captcha-image" alt="captcha txt"> 
                    <a href="#" class="captcha-change-image">'.$not_readable.' '.$change_text.'</a>
            </div>';
}    

$output .= '        <div class="button-row">
                        <button tabindex="'.($tabindex++).'" class="pacz-progress-button pacz-button  outline-button medium" data-style="move-up">
                            <span class="pacz-progress-button-content">'.$submit_str.'</span>
                            <span class="pacz-progress">
                                <span class="pacz-progress-inner"></span>
                            </span>
                            <span class="state-success"><i class="pacz-icon-check"></i></span>
                            <span class="state-error"><i class="pacz-icon-times"></i></span>
                        </button>
                    </div>';
$output .= '        <i class="pacz-contact-loading pacz-icon-refresh"></i>';
$output .= '        <i class="pacz-contact-success pacz-theme-icon-tick"></i>';
$output .= '        <input type="hidden" value="'.$email.'" name="contact_to"/>';
$output .= '    </form>';
$output .= '    <div class="clearboth"></div>';
$output .= '</div>';

echo '<div>'.$output.'</div>';


// Hidden styles node for head injection after page load through ajax
echo '<div id="ajax-'.$id.'" class="pacz-dynamic-styles">';
echo '<!-- ' . pacz_clean_dynamic_styles($classiadspro_styles) . '-->';
echo '</div>';


// Export styles to json for faster page load
$classiadspro_dynamic_styles[] = array(
  'id' => 'ajax-'.$id ,
  'inject' => $classiadspro_styles
);
