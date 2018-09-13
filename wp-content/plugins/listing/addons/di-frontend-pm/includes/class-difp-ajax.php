<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Difp_Ajax
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
			add_action('wp_ajax_difp_autosuggestion_ajax', array($this, 'difp_autosuggestion_ajax' ) );
			add_action('wp_ajax_difp_notification_ajax', array($this, 'difp_notification_ajax' ) );
			add_action('wp_ajax_nopriv_difp_notification_ajax', array($this, 'difp_notification_ajax' ) );
    	}

	function difp_autosuggestion_ajax() {
		global $user_ID;
		
		if(difp_get_option('hide_autosuggest') == '1' && !difp_is_user_admin() )
			die();
		
		if ( check_ajax_referer( 'difp-autosuggestion', 'token', false )) {
		
			$searchq = $_POST['searchBy'];
			
			$args = array(
					'search' => "*{$searchq}*",
					'search_columns' => array( 'display_name' ),
					'exclude' => array( $user_ID ),
					'number' => 5,
					'orderby' => 'display_name',
					'order' => 'ASC',
					'fields' => array( 'ID', 'display_name', 'user_nicename' )
			);
			
			if( strlen($searchq) > 0 )
			{
				$args = apply_filters ('difp_autosuggestion_arguments', $args );
	
				// The Query
				$users = get_users( $args );
			
				echo "<ul>";
				if ( ! empty( $users ) )
				{
					foreach( $users as $user)
					{	
						$display = apply_filters( 'difp_autosuggestion_user_name', $user->display_name, $user->ID );
						
						?><li><a href="#" onClick="difp_fill_autosuggestion('<?php echo $user->user_nicename; ?>','<?php echo $display; ?>');return false;"><?php echo $display; ?></a></li><?php
					}
				} else {
					echo "<li>".__("No matches found", 'ALSP')."</li>";
				}
				echo "</ul>";
			}
		}
		die();
	}
	
	function difp_notification_ajax() {

		if ( check_ajax_referer( 'difp-notification', 'token', false )) {
		
			$notification = difp_notification();
			if ( $notification )
				wp_die( $notification );
		}
		die();
	}
	
  } //END CLASS

add_action('init', array(Difp_Ajax::init(), 'actions_filters'));

