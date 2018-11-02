<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

//Main CLASS
if (!class_exists("difp_main_class"))
{
  class difp_main_class
  {
    
	private static $instance;
	
	public static function init()
        {
            if(!self::$instance instanceof self) {
                self::$instance = new self;
            }
            return self::$instance;
        }
	


/******************************************MAIN DISPLAY BEGIN******************************************/

    //Display the proper contents
   function main_shortcode_output( $atts, $content = null )
    {
      global $user_ID;
      if ($user_ID)
      {
	  
	  if ( ! difp_current_user_can('access_message') ){
	  
	  	return "<div class='difp-error'>".__("You do not have permission to access message system", 'ALSP')."</div>";
	  }
	  
	  $atts = shortcode_atts( array(
			'difpaction'		=> 'messagebox',
			'difp-filter'		=> 'show-all',
		), $atts, 'ALSP' );
		
		if( empty($_GET['difpaction'] ) )
		$_GET['difpaction'] = $atts['difpaction'];
		
		if( $_GET['difpaction'] == $atts['difpaction'] && empty($_GET['difp-filter'] ) )
			$_GET['difp-filter'] = $atts['difp-filter'];
	  
        //Add header
        $out = $this->Header();

        //Add Menu
        $out .= $this->Menu();
		
        //Start the guts of the display
		$switch = ( isset($_GET['difpaction'] ) && $_GET['difpaction'] ) ? $_GET['difpaction'] : 'messagebox';
		
        switch ($switch)
        {
		case has_action("difp_switch_{$switch}"):
			ob_start();
			do_action("difp_switch_{$switch}");
			$out .= ob_get_contents();
			ob_end_clean();
			break;
         case 'newmessage':
            $out .= $this->new_message();
            break;
          case 'viewmessage':
            $out .= $this->view_message();
            break;
          case 'settings':
            $out .= $this->user_settings();
            break;
		case 'announcements':
            $out .= Difp_Announcement::init()->announcement_box();
            break;
		case 'view_announcement':
            $out .= Difp_Announcement::init()->view_announcement();
            break;
		//case 'directory': // See Difp_Directory Class
            //$out .= $this->directory();
           // break;
		case 'messagebox':
          default: //Message box is shown by Default
            $out .= $this->difp_message_box();
            break;
        }

        //Add footer
        $out .= $this->Footer();
      }
      else
      { 
        $out = "<div class='difp-error'>".sprintf(__("You must <a href='%s'>login</a> to view your message.", 'ALSP'), wp_login_url( get_permalink() ) )."</div>";
      }
      return apply_filters('difp_main_shortcode_output', $out);
    }
	
	function Posted()
	{
		_deprecated_function( __FUNCTION__, '4.9', 'difp_form_posted()' );
		
		$action = !empty($_POST['difp_action']) ? $_POST['difp_action'] : '';
		
		if( ! $action )
			return;
			
		switch( $action ) {
			case has_action("difp_posted_action_{$action}"):
				do_action("difp_posted_action_{$action}", $this );
			break;
			case 'newmessage' :
				if ( ! difp_current_user_can( 'send_new_message') )
					return;
				
				Difp_Form::init()->validate_form_field();
				if( count( difp_errors()->get_error_messages()) == 0 ){
					if( $message_id = difp_send_message() ) {
						$message = get_post( $message_id );
						
						if( 'publish' == $message->post_status ) {
							difp_success()->add( 'publish', __("Message successfully sent.", 'ALSP') );
						} else {
							difp_success()->add( 'pending', __("Message successfully sent and waiting for admin moderation.", 'ALSP') );
						}
					} else {
						difp_errors()->add( 'undefined', __("Something wrong. Please try again.", 'ALSP') );
					}
				}
				
			break;
			case 'reply' :
				
				if( isset( $_GET['difp_id'] ) ){
					$pID = absint( $_GET['difp_id'] );
				} else {
					$pID = !empty($_GET['id']) ? absint($_GET['id']) : 0;
				}
				$parent_id = difp_get_parent_id( $pID );
				
				if ( ! difp_current_user_can( 'send_reply', $parent_id ) )
					return;
					
				Difp_Form::init()->validate_form_field( 'reply' );
				if( count( difp_errors()->get_error_messages()) == 0 ){
					if( $message_id = difp_send_message() ) {
						$message = get_post( $message_id );
						
						if( 'publish' == $message->post_status ) {
							difp_success()->add( 'publish', __("Message successfully sent.", 'ALSP') );
						} else {
							difp_success()->add( 'pending', __("Message successfully sent and waiting for admin moderation.", 'ALSP') );
						}
					} else {
						difp_errors()->add( 'undefined', __("Something wrong. Please try again.", 'ALSP') );
					}
				}
				
			break;
			case 'bulk_action' :
				$posted_bulk_action = ! empty($_POST['difp-bulk-action']) ? $_POST['difp-bulk-action'] : '';
				if( ! $posted_bulk_action )
					return;
				
				$token = ! empty($_POST['token']) ? $_POST['token'] : '';
				
				if ( ! difp_verify_nonce( $token, 'bulk_action') ) {
					difp_errors()->add( 'token', __("Invalid Token. Please try again!", 'ALSP') );
					return;
				}
				
				if( $bulk_action_return = Difp_Message::init()->bulk_action( $posted_bulk_action ) ) {
					difp_success()->add( 'success', $bulk_action_return );
				}
			break;
			case 'announcement_bulk_action' :
				$posted_bulk_action = ! empty($_POST['difp-bulk-action']) ? $_POST['difp-bulk-action'] : '';
				if( ! $posted_bulk_action )
					return;
				
				$token = ! empty($_POST['token']) ? $_POST['token'] : '';
				
				if ( ! difp_verify_nonce( $token, 'announcement_bulk_action') ) {
					difp_errors()->add( 'token', __("Invalid Token. Please try again!", 'ALSP') );
					return;
				}
				
				if( $bulk_action_return = Difp_Announcement::init()->bulk_action( $posted_bulk_action ) ) {
					difp_success()->add( 'success', $bulk_action_return );
				}
			break;
			case 'settings' :
				
				add_action ('difp_action_form_validated', array($this, 'settings_save'), 10, 2);
				
				Difp_Form::init()->validate_form_field( 'settings' );
				
				if( count( difp_errors()->get_error_messages()) == 0 ){
					difp_success()->add( 'saved', __("Settings successfully saved.", 'ALSP') );
				}
				
			break;
			default:
				do_action("difp_posted_action", $this );
			break;
			
		}
	}
	
	function settings_save( $where, $fields )
	{
		_deprecated_function( __FUNCTION__, '4.9', 'difp_user_settings_save()' );
		
		if( 'settings' != $where )
			return;
		
		if( !$fields || ! is_array( $fields ) )
			return;
		
		$settings = array();
		
		foreach( $fields as $field ) {
			$settings[$field['name']] = $field['posted-value'];
		}
		$settings = apply_filters('difp_filter_user_settings_before_save', $settings );
		
		update_user_option( get_current_user_id(), 'DIFP_user_options', $settings); 
	}
	
    function Header()
    {
      global $user_ID;

      $total_count = difp_get_user_message_count( 'total' );
	  $unread_count = difp_get_user_message_count( 'unread' );
	  $unread_ann_count = difp_get_user_announcement_count( 'unread' );
      $max_total = difp_get_current_user_max_message_number();
	  $max_text = $max_total ? number_format_i18n($max_total) : __('unlimited', 'ALSP' );
	  
	  $template = difp_locate_template( 'header.php');
	  
	  ob_start();
	  include( $template );
	  return ob_get_clean();
    }


    function Menu()
    {
		$template = difp_locate_template( 'menu.php');
			  
		ob_start();
		include( $template );
		return ob_get_clean();
    }

    function Footer()
    {
		
		$template = difp_locate_template( 'footer.php');
			  
		ob_start();
		include( $template );
		return ob_get_clean();
    }
	
	function difp_message_box($action = '', $total_message = false, $messages = false )
	{
	
		if ( !$action ){
	  		$action = ( ! empty( $_GET['difpaction']) ) ? $_GET['difpaction']: 'messagebox';
	  	}
		
	  	$g_filter = ! empty( $_GET['difp-filter'] ) ? $_GET['difp-filter'] : '';
	  
	  	if( false === $total_message ) {
	  		$total_message = difp_get_user_message_count('total');
	  	}
	  
	  	if( false === $messages ){
	  		$messages = Difp_Message::init()->user_messages( $action );
	  	}
	  
	  $template = difp_locate_template( 'messagebox.php');
	  
	  ob_start();
	  include( $template );
		
	  return apply_filters('difp_messagebox', ob_get_clean(), $action);
}
	
function user_settings()
    {
	  $template = difp_locate_template( 'settings.php');
	  
	  ob_start();
	  include( $template );
	  return ob_get_clean();
	  
    }

function new_message(){

	$template = difp_locate_template( 'newmessage_form.php');
	  
	  ob_start();
	  include( $template );
	  return ob_get_clean();
}
	
function view_message()
    {
      global $wpdb, $user_ID, $post;

	  if( isset( $_GET['difp_id'] ) ){
	  	$id = absint( $_GET['difp_id'] );
	  } else {
	  	$id = !empty($_GET['id']) ? absint($_GET['id']) : 0;
	  }
	  
	  if ( ! $id || ! difp_current_user_can( 'view_message', $id ) ) {
	  	return "<div class='difp-error'>".__("You do not have permission to view this message!", 'ALSP')."</div>";
	  }
	  
	  	$parent_id = difp_get_parent_id( $id );
	
		$messages = difp_get_message_with_replies( $id );
	
		$template = difp_locate_template( 'viewmessage.php');
	  
	  ob_start();
	  include( $template );
	  return ob_get_clean();

    }

/******************************************MAIN DISPLAY END******************************************/

  } //END CLASS
} //ENDIF


