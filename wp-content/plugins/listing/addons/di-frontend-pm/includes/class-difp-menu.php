<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Difp_Menu
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
			add_action ('difp_menu_button', array($this, 'menu'));
    	}

	function menu(){
		$menu = '';
		
		  foreach( $this->get_menu() as $menu_array ) {
			$class = sanitize_html_class( $menu_array['class'] );
			 if ( isset($_GET['difpaction']) && $_GET['difpaction'] == $menu_array['action'])
			 $class = sanitize_html_class( $menu_array['active-class'] );
			 
			 $menu .= "<a class='$class' href='".difp_query_url( $menu_array['action'] )."'>".strip_tags( $menu_array['title'], '<span>' )."</a>";
		  }
		  echo $menu;
	 }
	
	private function get_menu()
	{
		$menu = array(
				//'newmessage'	=> array(
					//'title'			=> __('New Message', 'ALSP'),
					//'action'			=> 'newmessage',
				//	'priority'			=> 5
				//	),
				'message_box'	=> array(
					'title'			=> sprintf(__('Message Box%s', 'ALSP'), difp_get_new_message_button() ),
					'action'			=> 'messagebox',
					'priority'			=> 10
					),
				'settings'	=> array(
					'title'			=> __('Settings', 'ALSP'),
					'action'			=> 'settings',
					'priority'			=> 15
					),
				'announcements'	=> array(
					'title'			=> sprintf(__('Announcement%s', 'ALSP'), difp_get_new_announcement_button() ),
					'action'			=> 'announcements',
					'priority'			=> 20
					)
							
				);
		if( ! difp_current_user_can( 'send_new_message' ) ) {
			unset($menu['newmessage']);
		}
							
		$menu = apply_filters('difp_menu_buttons', $menu );
						
				foreach ( $menu as $key => $tab )
					{
				
						$defaults = array(
								'title'			=> '',
								'action'		=> $key,
								'class'			=> 'difp-button',
								'active-class'	=> 'difp-button-active',
								'priority'		=> 20
							);
					$menu[$key] = wp_parse_args( $tab, $defaults);
			
				}
			uasort( $menu, 'difp_sort_by_priority' );
							
		return $menu;
	}
	
 } //END CLASS

add_action('wp_loaded', array(Difp_Menu::init(), 'actions_filters'));

