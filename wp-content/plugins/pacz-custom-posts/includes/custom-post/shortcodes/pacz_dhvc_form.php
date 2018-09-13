<?php

$el_class = $width = $el_position = '';

extract( shortcode_atts( array(
			'el_class' => '',
			'id' => '',
			'form_type' => 1,
			'register_link' => 'false',
			'form_title' => '',
			'allow_social_login' => 'true',
		), $atts ) );


global $user_ID, $user_identity, $pacz_settings, $posatds_dynamic_styles;
$register_slug = $pacz_settings['pacz-register-slug'];
$main_id = uniqid();
$classiadspro_styles = '';
	
if($form_type == 1){
$output .='<div id="login-register-password">';

	 wp_get_current_user();
	 if (!$user_ID) {
		$output .='<div class="form-wrapper ">';
		//registered 
		
			$output .='<div class="form-inner">';
			
				$output .='<h3>'.$form_title.'</h3>';
				$dhvc_form_id = $id;
				if(class_exists('DHVCForm') && !empty($dhvc_form_id)){
					$output .= do_shortcode('[dhvc_form id="'.$dhvc_form_id.'"]'); 
					$output .='<div class="form-inner-regiter-link">';
						if($register_link == 'true'){
							$output .='<p>'.esc_html__('not a member?', 'pacz').'</p>';
							$output .='<a class="dhvc-register-link" href="'.home_url('/').$register_slug.'">'.esc_html__('Create an Account', 'pacz').'</a>';
						}
					$output .='</div>';
				}else{
					$output .='<p>'.esc_html__('please install and activate DHVC plugin', 'pacz').'</p>';
				}
				if(class_exists('APSL_Class') && $allow_social_login == 'true'){
					$social_message = esc_html__('Social Connect', 'pacz');
					$dashboard = home_url('/').'my-dashboard';
					$output .='<div class="access-press-social">';
						$output .= do_shortcode('[apsl-login theme="2" login_text="'.$social_message.'" login_redirect_url="'.$dashboard.'"]');
					$output .='</div>';
				}
							
			$output .='</div>';
			
		$output .='</div>';
	 }else{
		 $output .='<div class="user_is_logedin">';
			$output .='<p>'.esc_html__('You are already login', 'pacz').'</p>';
			$output .='<div class="user_is_logedin_button">';
				$output .='<div class="user_is_logedin_button-inner">';
					$output .='<a class="btn btn-primary" href="'.home_url('/').'">'.esc_html__('Browse to Home', 'pacz').'</a>';
				$output .='</div>';
				$output .='<div class="user_is_logedin_button-inner">';
					$output .='<a class="btn btn-primary" href="'.home_url('/').'my-dashboard">'.esc_html__('Browse to Account', 'pacz').'</a>';
				$output .='</div>';
			$output .='</div>';
		 $output .='</div>';
		 
	 }
$output .='</div>';
}else if($form_type == 2){
	$output .='<div id="subscription-form-'.$main_id.'" class="subscription-form">';

	// wp_get_current_user();
	// if (!$user_ID) {
		$output .='<div class="form-wrapper ">';
		//registered 
		
			$output .='<div class="subscription-form-inner clearfix">';
			
				//$output .='<h3>'.esc_html__('Register', 'classifieds').'</h3>';
				$dhvc_form_id = $id;
				if(class_exists('DHVCForm') && !empty($dhvc_form_id)){
					$output .= do_shortcode('[dhvc_form id="'.$dhvc_form_id.'"]'); 
				}else{
					$output .='<p>'.esc_html__('please install and activate DHVC plugin', 'classifieds').'</p>';
				}
				/**
				* Detect plugin. For use on Front End only.
				*/
				//include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
							
			$output .='</div>';
		$output .='</div>';
	 //}
$output .='</div>';
}else if($form_type == 3){
	$output .='<div id="subscription-form-'.$main_id.'" class="subscription-form">';
		$output .='<div class="form-wrapper ">';
			$output .='<div class="subscription-form-inner clearfix">';
				$dhvc_form_id = $id;
				if(class_exists('DHVCForm') && !empty($dhvc_form_id)){
					$output .= do_shortcode('[dhvc_form id="'.$dhvc_form_id.'"]'); 
				}else{
					$output .='<p>'.esc_html__('please install and activate DHVC plugin', 'classifieds').'</p>';
				}
			$output .='</div>';
		$output .='</div>';
	$output .='</div>';
}
echo $output;

// Hidden styles node for head injection after page load through ajax
echo '<div id="ajax-'.$id.'" class="classifieds-dynamic-styles">';
echo '<!-- ' . pacz_clean_dynamic_styles($classiadspro_styles) . '-->';
echo '</div>';


// Export styles to json for faster page load
$classiadspro_dynamic_styles[] = array(
  'id' => 'ajax-'.$id ,
  'inject' => $classiadspro_styles
);
