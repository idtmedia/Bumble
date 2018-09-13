<?php
$output = $css_class ='';

extract(shortcode_atts(array(
	'captcha_type'=>'2',
	'type'=>'recaptcha',
	'theme'=>'red',
	'language'=>'en',
	'control_label'=>'',
	'control_name'=>'',
	'placeholder'=>'',
	'help_text'=>'',
	'required'=>'1',
	'attributes'=>'',
	'el_class'=> '',
	'input_css'=>'',
), $atts));

$name = $this->getControlName($control_name);
global $dhvc_form;
$label = $control_label;
$language = apply_filters('dhvc_form_language_code',$language);
if($captcha_type == '2'){
	
	if(!defined('DHVC_FORM_RECATPTCHA_ONLOAD_CALLBACK')){
		define('DHVC_FORM_RECATPTCHA_ONLOAD_CALLBACK', true);
		dhvc_form_add_js_declaration("
		var dhvc_form_recatptcha_widgets = [];
		var dhvc_form_recatptcha_callback = function () {
		    jQuery('.dhvc-form-recaptcha2').each(function(){
				var widget_id = grecaptcha.render( jQuery(this).attr('id'), {
			        'sitekey': '".dhvc_form_get_option('recaptcha_public_key')."',
			        'theme': 'light'
		   		 } );
				dhvc_form_recatptcha_widgets.push(widget_id);
			});
		};
		jQuery(document.body).on('dhvc_form_submit', function(event, form, data) {
			switch ( data.status ) {
				case 'validation_failed':
				case 'spam':
				case 'success':
				case 'upload_failed':
				case 'form_not_exist':
				case 'action_failed':
				case 'call_action_failed':
					for ( var i = 0; i < dhvc_form_recatptcha_widgets.length; i++ ) {
						grecaptcha.reset( dhvc_form_recatptcha_widgets[ i ] );
					}
			}
		});
		");
	}
	wp_enqueue_script( 'dhvc-form-recaptcha2' );
}else{
	wp_enqueue_script('dhvc-form-recaptcha');
	dhvc_form_add_js_declaration('
	jQuery( document ).ready(function(){
		Recaptcha.create("' . dhvc_form_get_option('recaptcha_public_key') . '", "'.$name.'", {theme: "' . $theme . '",lang : \''.$language.'\',tabindex: 0});
	});
	');
}
if(empty($name)){
	echo __('Field name is required', 'dhvc-form');
	return;
}
$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $this->settings['base'].' '. $el_class,$this->settings['base'],$atts );

$output .='<div class="dhvc-form-group dhvc-form-'.$name.'-box '.$css_class.vc_shortcode_custom_css_class($input_css,' ').'">'."\n";
if(!empty($label)){
	$output .='<label class="dhvc-form-label" for="'.$name.'">'.$label.(!empty($required) ? ' <span class="required">*</span>':'').'</label>' . "\n";
}
if($captcha_type == '2'){
	$site_key = dhvc_form_get_option('recaptcha_public_key');
	$secret_key	 = dhvc_form_get_option('recaptcha_private_key');
	if ( ! empty( $site_key ) && ! empty( $secret_key ) ) {
		$url = add_query_arg( 'k', $site_key,'https://www.google.com/recaptcha/api/fallback' );
		$output .='<div type="recaptcha" data-dhvcform-recaptcha="recaptcha" class="dhvc-form-recaptcha dhvc-form-recaptcha2" id="'.$name.'"></div>';
		$output .='<noscript>
	<div style="width: 302px; height: 422px;">
		<div style="width: 302px; height: 422px; position: relative;">
			<div style="width: 302px; height: 422px; position: absolute;">
				<iframe src="'.$url.'" frameborder="0" scrolling="no" style="width: 302px; height:422px; border-style: none;">
				</iframe>
			</div>
			<div style="width: 300px; height: 60px; border-style: none; bottom: 12px; left: 25px; margin: 0px; padding: 0px; right: 25px; background: #f9f9f9; border: 1px solid #c1c1c1; border-radius: 3px;">
				<textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid #c1c1c1; margin: 10px 25px; padding: 0px; resize: none;">
				</textarea>
			</div>
		</div>
	</div>
</noscript>';
	}else{
		$output .= __('Plese settup site Captcha in DHVC Form Settings','dhvc-form');
	}
}else{
	$output .='<div class="dhvc-form-recaptcha" data-dhvcform-recaptcha="recaptcha" id="'.$name.'"></div>';	
}

if(!empty($help_text)){
	$output .='<span class="help_text">'.$help_text.'</span>' . "\n";
}
$output .='</div>'."\n";

echo $output;
