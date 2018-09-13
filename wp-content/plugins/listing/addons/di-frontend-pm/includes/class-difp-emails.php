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
			$message = __('You have received a new message in', 'ALSP'). "\r\n";
			$message .= get_bloginfo("name")."\r\n";
			$message .= sprintf(__("From: %s", 'ALSP'), difp_get_userdata( $post->post_author, 'display_name', 'id') ). "\r\n";
			$message .= sprintf(__("Subject: %s", 'ALSP'),  $post->post_title ). "\r\n";
			$message .= __('Please Click the following link to view full Message.', 'ALSP')."\r\n";
			$message .= difp_query_url('messagebox')."\r\n";
			
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

