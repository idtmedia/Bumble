<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Difp_Emails
  {
 	private static $instance;
	
	public static function init()
        {
            if(!self::$instance instanceof self) {
                self::$instance = new self;
            }
            return self::$instance;
        }
		
    function actions_filters()
    {
		if( isset( $_POST['action'] ) && 'difp_update_ajax' == $_POST['action'] )
			return;
			
		if( true != apply_filters( 'difp_enable_email_send', true ) )
			return;

		//add_action ('publish_difp_message', array($this, 'publish_send_email'), 10, 2);
		add_action ('transition_post_status', array($this, 'publish_send_email'), 10, 3);
		add_action( 'difp_save_message', array($this, 'save_send_email'), 20, 2 ); //after '_difp_participants' meta saved, if from Back End
		add_action( 'difp_action_message_after_send', array($this, 'save_send_email'), 20, 2 ); //Front End
		
		if ( '1' == difp_get_option('notify_ann', '1' ) ){
			add_action ('transition_post_status', array($this, 'publish_notify_users'), 10, 3);
			add_action( 'difp_save_announcement', array($this, 'save_notify_users'), 20, 2 ); //after '_difp_participant_roles' meta saved
		}
    }
	
	function publish_send_email( $new_status, $old_status, $post )
	{
		 if ( 'difp_message' != $post->post_type || $old_status == 'publish'  || $new_status != 'publish' ) {
		 	return;
		}
		if( get_post_meta( $post->ID, '_difp_email_sent', true ) )
			return;
		
		$this->send_email( $post->ID, $post );
	}
	
	function save_send_email( $postid, $post )
	{
		if ( ! $post instanceof WP_Post ) {
			$post = get_post( $postid );
		}
		if( 'publish' != $post->post_status )
			return;
		
		if( get_post_meta( $postid, '_difp_email_sent', true ) )
			return;
			
		$this->send_email( $postid, $post );
	}
	
	function send_email( $postid, $post ){
		
		$participants = difp_get_participants( $postid );
		
		if( $participants && is_array( $participants ) )
		{
			
			$subject =  get_bloginfo("name").': '.__('New Message', 'ALSP');
//			$message = __('You have received a new message in', 'ALSP'). "\r\n";
//			$message .= get_bloginfo("name")."\r\n";
//			$message .= sprintf(__("From: %s", 'ALSP'), difp_get_userdata( $post->post_author, 'display_name', 'id') ). "\r\n";
//			$message .= sprintf(__("Subject: %s", 'ALSP'),  $post->post_title ). "\r\n";
//			$message .= __('Please Click the following link to view full Message.', 'ALSP')."\r\n";
//			$message .= difp_query_url('messagebox')."\r\n";
            $blog_name = get_bloginfo("name");
            $from = difp_get_userdata( $post->post_author, 'display_name', 'id');
            $subject = $post->post_title;
            $content = $post->post_content;
            $message = '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head> <title></title> <!--[if !mso]><!-- --> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!--<![endif]--><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><style type="text/css"> #outlook a { padding: 0; } .ReadMsgBody { width: 100%; } .ExternalClass { width: 100%; } .ExternalClass * { line-height:100%; } body { margin: 0; padding: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; } table, td { border-collapse:collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; } img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; } p { display: block; margin: 13px 0; }</style><!--[if !mso]><!--><style type="text/css"> @media only screen and (max-width:480px) { @-ms-viewport { width:320px; } @viewport { width:320px; } }</style><!--<![endif]--><!--[if mso]><xml> <o:OfficeDocumentSettings> <o:AllowPNG/> <o:PixelsPerInch>96</o:PixelsPerInch> </o:OfficeDocumentSettings></xml><![endif]--><!--[if lte mso 11]><style type="text/css"> .outlook-group-fix { width:100% !important; }</style><![endif]--><!--[if !mso]><!--> <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet" type="text/css"> <style type="text/css"> @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700); @import url(https://fonts.googleapis.com/css?family=Cabin); </style> <!--<![endif]--><style type="text/css"> @media only screen and (min-width:480px) { .mj-column-per-100 { width:100%!important; } }</style></head><body style="background: #FFFFFF;"> <div class="mj-container" style="background-color:#FFFFFF;"><!--[if mso | IE]> <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;"> <tr> <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"> <![endif]--><div style="margin:0px auto;max-width:600px;background:#000000;"><table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#000000;" align="center" border="0"><tbody><tr><td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:9px 0px 9px 0px;"><!--[if mso | IE]> <table role="presentation" border="0" cellpadding="0" cellspacing="0"> <tr> <td style="vertical-align:top;width:600px;"> <![endif]--><div class="mj-column-per-100 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%;"><table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"><tbody><tr><td style="word-wrap:break-word;font-size:0px;padding:10px 10px 10px 10px;" align="center"><table role="presentation" cellpadding="0" cellspacing="0" style="border-collapse:collapse;border-spacing:0px;" align="center" border="0"><tbody><tr><td style="width:186px;"><img alt="" title="" height="auto" src="http://pwmhosting.ca/bumble/wp-content/uploads/2018/08/logo.png" style="border:none;border-radius:0px;display:block;font-size:13px;outline:none;text-decoration:none;width:100%;height:auto;" width="186"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]> </td></tr></table> <![endif]--></td></tr></tbody></table></div><!--[if mso | IE]> </td></tr></table> <![endif]--> <!--[if mso | IE]> <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;"> <tr> <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"> <![endif]--><table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;" border="0"><tbody><tr><td><div style="margin:0px auto;max-width:600px;"><table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;" align="center" border="0"><tbody><tr><td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:0px 0px 0px 0px;"><!--[if mso | IE]> <table role="presentation" border="0" cellpadding="0" cellspacing="0"> <tr> <td style="vertical-align:top;width:600px;"> <![endif]--><div class="mj-column-per-100 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%;"></div><!--[if mso | IE]> </td></tr></table> <![endif]--></td></tr></tbody></table></div></td></tr></tbody></table><!--[if mso | IE]> </td></tr></table> <![endif]--> <!--[if mso | IE]> <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;"> <tr> <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"> <![endif]--><table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;" border="0"><tbody><tr><td><div style="margin:0px auto;max-width:600px;"><table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;" align="center" border="0"><tbody><tr><td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:0px 0px 0px 0px;"><!--[if mso | IE]> <table role="presentation" border="0" cellpadding="0" cellspacing="0"> <tr> <td style="vertical-align:top;width:600px;"> <![endif]--><div class="mj-column-per-100 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%;"><table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"><tbody><tr><td style="word-wrap:break-word;font-size:0px;padding:19px 20px 19px 20px;" align="center"><div style="cursor:auto;color:#000000;font-family:Cabin, sans-serif;font-size:15px;line-height:22px;text-align:center;border: 1px solid #f05d22; padding: 10px;"><p>You have received a new message!</p>
    <p><strong>From</strong>: '.$from.'
    <strong>Subject</strong>: '.$subject.'
    <strong>Message</strong>: '.$content.'</p>
    <p>Please Click the following <a href="'.get_site_url().'/my-dashboard/?alsp_action=messages'.'">link</a> to access your message.</p>
</div></td></tr></tbody></table></div><!--[if mso | IE]> </td></tr></table> <![endif]--></td></tr></tbody></table></div></td></tr></tbody></table><!--[if mso | IE]> </td></tr></table> <![endif]--> <!--[if mso | IE]> <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;"> <tr> <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"> <![endif]--><!--[if mso | IE]> </td></tr></table> <![endif]--> <!--[if mso | IE]> <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;"> <tr> <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"> <![endif]--><!--[if mso | IE]> </td></tr></table> <![endif]--></div></body></html>';
			
//			if( 'html' == difp_get_option( 'email_content_type', 'plain_text' ) ) {
				$message = nl2br( $message );
				$content_type = 'text/html';
//			} else {
//				$content_type = 'text/plain';
//			}
			$attachments = array();
			$headers = array();
			$headers['from'] = 'From: '.stripslashes( difp_get_option('from_name', wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) ) ).' <'. difp_get_option('from_email', get_bloginfo('admin_email')) .'>';
			$headers['content_type'] = "Content-Type: $content_type";
			
			
			difp_add_email_filters();
			
			foreach( $participants as $participant ) 
			{
				if( $participant == $post->post_author )
					continue;
					
				if( ! difp_get_user_option( 'allow_emails', 1, $participant ) )
					continue;
					
				$to = difp_get_userdata( $participant, 'user_email', 'id');
				
				if( ! $to )
					continue;
					
				$content = apply_filters( 'difp_filter_before_email_send', compact( 'subject', 'message', 'headers', 'attachments' ), $post, $to );

				if( empty( $content['subject'] ) || empty( $content['message'] ) )
					continue;
						
				wp_mail( $to, $content['subject'], $content['message'], $content['headers'], $content['attachments'] );
			} //End foreach
			
			difp_remove_email_filters();
			
			update_post_meta( $post->ID, '_difp_email_sent', time() );
		}
	}
	
	function publish_notify_users( $new_status, $old_status, $post )
	{
		 if ( 'difp_announcement' != $post->post_type || $old_status == 'publish'  || $new_status != 'publish' ) {
		 	return;
		}
		if( get_post_meta( $post->ID, '_difp_email_sent', true ) )
			return;
		
		$this->notify_users( $post->ID, $post );
	}
	
	function save_notify_users( $postid, $post )
	{
		if( 'publish' != $post->post_status )
			return;
		
		if( get_post_meta( $postid, '_difp_email_sent', true ) )
			return;
			
		$this->notify_users( $postid, $post );
	}
	
	//Mass emails when announcement is created
	function notify_users( $postid, $post ) {
		
		$roles = difp_get_participant_roles( $postid );
		
		if( !$roles || !is_array( $roles ) ) {
			return;
		} 
		$args = array( 
				'role__in' => $roles,
				'fields' => array( 'ID', 'user_email' ),
				'orderby' => 'ID' 
		);
		$usersarray = get_users( $args );
		$to = difp_get_option('ann_to', get_bloginfo('admin_email'));
		
		$user_emails = array();
		foreach  ($usersarray as $user) {
			$notify = difp_get_user_option( 'allow_ann', 1, $user->ID);
			
			if ($notify == '1'){
				$user_emails[] = $user->user_email;
			}
		}
		//var_dump($user_emails);
		
		$subject =  get_bloginfo("name").': '.__('New Announcement', 'ALSP');
		$message = __('A new Announcement is Published in ', 'ALSP')."\r\n";
		$message .= get_bloginfo("name")."\r\n";
		$message .= sprintf(__("Title: %s", 'ALSP'), $post->post_title ). "\r\n";
		$message .= __('Please Click the following link to view full Announcement.', 'ALSP'). "\r\n";
		$message .= difp_query_url('announcements'). "\r\n";
		
		if( 'html' == difp_get_option( 'email_content_type', 'plain_text' ) ) {
			$message = nl2br( $message );
			$content_type = 'text/html';
		} else {
			$content_type = 'text/plain';
		}
		$attachments = array();
		$headers = array();
		$headers['from'] = 'From: '.stripslashes( difp_get_option('from_name', wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) ) ).' <'. difp_get_option('from_email', get_bloginfo('admin_email')) .'>';
		$headers['content_type'] = "Content-Type: $content_type";
		
		$content = apply_filters( 'difp_filter_before_announcement_email_send', compact( 'subject', 'message', 'headers', 'attachments' ), $post, $user_emails );
		
		if( empty( $content['subject'] ) || empty( $content['message'] ) )
			return false;
		
		do_action( 'difp_action_before_announcement_email_send', $content, $post, $user_emails );
		
		if( ! apply_filters( "difp_announcement_email_send_{$postid}", true ) )
			return false;
		
		$chunked_bcc = array_chunk( $user_emails, 25);
		
	difp_add_email_filters( 'announcement' );
	
	foreach($chunked_bcc as $bcc_chunk){
		if( ! $bcc_chunk )
			continue;
	
		//$headers = array();
		$content['headers']['Bcc'] = 'Bcc: '.implode(',', $bcc_chunk);
		
		wp_mail($to , $content['subject'], $content['message'], $content['headers'], $content['attachments'] );
	}
		
	difp_remove_email_filters( 'announcement' );
	
	update_post_meta( $post->ID, '_difp_email_sent', time() );
	
    }
	
	
	
  } //END CLASS

add_action('wp_loaded', array(Difp_Emails::init(), 'actions_filters'));

