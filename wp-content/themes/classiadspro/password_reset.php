<?php
/*
Template Name: Password Reset Template
*/
global $wpdb, $user_ID;

function tg_validate_url() {
	global $post;
	$page_url = esc_url(get_permalink( $post->ID ));
	$urlget = strpos($page_url, "?");
	if ($urlget === false) {
		$concate = "?";
	} else {
		$concate = "&";
	}
	return $page_url.$concate;
}

if (!$user_ID) { //block logged in users
	
	if(isset($_GET['key']) && $_GET['action'] == "rp") {
		$reset_key = $_GET['key'];
		$user_login = $_GET['login'];
		$user_data = get_user_by('login', $user_login);
		//echo $user_data->ID;
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
		
		if(!empty($reset_key)) {
			$new_password = wp_generate_password(7, false);
				//echo $new_password; exit();
				wp_set_password( $new_password, $user_data->ID );
				//mailing reset details to the user
			$message = __('Your new password for the account at:') . "\r\n\r\n";
			$message .= get_option('siteurl') . "\r\n\r\n";
			$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
			$message .= sprintf(__('Password: %s'), $new_password) . "\r\n\r\n";
			$message .= __('You can now login with your new password at: ') . get_option('siteurl')."/login" . "\r\n\r\n";
			
			if ( $message && !wp_mail($user_email, 'Password Reset Request', $message) ) {
				echo "<div class='error'>Email failed to send for some unknown reason</div>";
				exit();
			}
			else {
				//$redirect_to = get_bloginfo('url')."/login?action=reset_success";
				//wp_safe_redirect($redirect_to);
				//exit();
				?>
				<div class="password-rest">
					<p>Password has been reset, Please check your email for new password</p>
				</div>
				<?php
			}
		} 
		else{
			exit('Not a Valid Key.');
		}
	}
	
}
else {
	wp_redirect( home_url() ); exit;
	//redirect logged in user to home page
}
?>