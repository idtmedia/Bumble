<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Difp_Directory
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
			if( difp_current_user_can( 'access_directory') ){
				//add_filter('difp_menu_buttons', array($this, 'menu'));
				//add_action('difp_switch_directory', array($this, "directory"));
				}
    	}
	
	/*function menu( $menu ) {
	 
	 	$menu['directory']	= array(
					'title'			=> __('Directory', 'ALSP'),
					'action'			=> 'directory',
					'priority'			=> 25
					);
					
		return $menu;
	  }*/

	function directory()
    {
		if ( ! difp_current_user_can( 'access_directory') ) {
	  		echo "<div class='difp-error'>".__("You do not have permission to access directory!", 'ALSP')."</div>";
			return;
	  	}
	  
	  $args = array(
			'number' => difp_get_option('user_page', 50 ),
			'paged'	=> !empty($_GET['difppage']) ? absint($_GET['difppage']): 1,
			'orderby' => 'display_name',
			'order' => 'ASC',
			'fields' => array( 'ID', 'display_name', 'user_nicename' )
		);
		if( !empty($_GET['difp-search']) ) {
			$args['search'] = '*'. $_GET['difp-search'] . '*';
		}
	
		$args = apply_filters ('difp_directory_arguments', $args );
	
		// The Query
		$user_query = new WP_User_Query( $args );
	  	$total = $user_query->get_total();
      
	  	$template = difp_locate_template( 'directory.php');
	  
	  	ob_start();
	  	include( $template );
		echo apply_filters( 'difp_directory_output', ob_get_clean() );
	  
    }
	
	
	
 } //END CLASS

add_action('wp_loaded', array(Difp_Directory::init(), 'actions_filters'));
?>