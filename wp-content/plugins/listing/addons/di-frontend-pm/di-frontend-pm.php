<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Di_Frontend_Pm {

	private static $instance;
	
	private function __construct() {

		$this->constants();
		$this->includes();
		$this->actions();
		//$this->filters();

	}
	
	public static function init()
        {
            if(!self::$instance instanceof self) {
                self::$instance = new self;
            }
            return self::$instance;
        }
	
	function constants()
    	{
			global $wpdb;
			
			define('DIFP_PLUGIN_VERSION', '5.3' );
			define('DIFP_PLUGIN_FILE',  __FILE__ );
			define('DIFP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			define('DIFP_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
			
			if ( !defined ('DIFP_MESSAGES_TABLE' ) )
			define('DIFP_MESSAGES_TABLE',$wpdb->prefix.'difp_messages');
			
			if ( !defined ('DIFP_META_TABLE' ) )
			define('DIFP_META_TABLE',$wpdb->prefix.'difp_meta');
    	}
	
	function includes()
    	{
			require_once( DIFP_PLUGIN_DIR. 'functions.php');

			if( file_exists( DIFP_PLUGIN_DIR. 'pro/pro-features.php' ) ) {
				require_once( DIFP_PLUGIN_DIR. 'pro/pro-features.php');
			}
    	}
	
	function actions()
    	{
			register_activation_hook(__FILE__ , array($this, 'difp_plugin_activate' ) );
			register_deactivation_hook(__FILE__ , array($this, 'difp_plugin_deactivate' ) );
    	}
	
	function difp_plugin_activate(){
	
	}
	
	function difp_plugin_deactivate(){
	}
	
} //END Class

Di_Frontend_Pm::init();
	
