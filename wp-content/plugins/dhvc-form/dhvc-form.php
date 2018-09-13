<?php
/*
* Plugin Name: DHVC Form
* Plugin URI: http://sitesao.com/dhvcform/
* Description: Easy Form Builder for Wordpress with WPBakery Page Builder
* Version: 2.2.0
* Author: Sitesao
* Author URI: http://sitesao.com/
* License: License GNU General Public License version 2 or later;
* Copyright 2014  Sitesao
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!defined('DHVC_FORM'))
	define('DHVC_FORM','dhvc-form');

if(!defined('DHVC_FORM_VERSION'))
	define('DHVC_FORM_VERSION','2.2.0');

if(!defined('DHVC_FORM_URL'))
	define('DHVC_FORM_URL',untrailingslashit( plugins_url( '/', __FILE__ ) ));

if(!defined('DHVC_FORM_DIR'))
	define('DHVC_FORM_DIR',untrailingslashit( plugin_dir_path(__FILE__ ) ));

if(!defined('DHVC_FORM_TEMPLATE_DIR'))
	define('DHVC_FORM_TEMPLATE_DIR',DHVC_FORM_DIR .'/templates/');

class DHVCForm{
	public function __construct(){
		add_action( 'plugins_loaded', array($this,'plugins_loaded'), 9 );
		register_activation_hook(__FILE__,array(&$this, 'activate'));
	}
	
	public function plugins_loaded(){
		if(!defined('WPB_VC_VERSION')){
			add_action('admin_notices', array(&$this,'notice'));
			return;
		}
		$this->_includes();
		$this->_init_hooks();
	}
	
	private function _includes(){
		require_once DHVC_FORM_DIR.'/includes/functions.php';
		require_once DHVC_FORM_DIR.'/includes/shortcodes.php';
		require_once DHVC_FORM_DIR.'/includes/scan_tag.php';
		require_once DHVC_FORM_DIR.'/includes/form_actions.php';
		require_once DHVC_FORM_DIR.'/includes/assets.php';
		require_once DHVC_FORM_DIR.'/includes/db.php';
		require_once DHVC_FORM_DIR.'/includes/post_types.php';
		require_once DHVC_FORM_DIR.'/includes/editor.php';
		require_once DHVC_FORM_DIR.'/includes/submission.php';
		require_once DHVC_FORM_DIR.'/includes/field.php';
		require_once DHVC_FORM_DIR.'/includes/paypal.php';
		
		foreach (dhvc_form_get_fields() as $field=>$file)
			require_once $file;
		
		if(is_admin()){
			require_once DHVC_FORM_DIR.'/includes/admin.php';
			require_once DHVC_FORM_DIR.'/includes/entries.php';
			require_once DHVC_FORM_DIR.'/includes/settings.php';
			require_once DHVC_FORM_DIR.'/includes/meta_box.php';
		}
	}
	
	private function _init_hooks(){
		load_plugin_textdomain( 'dhvc-form', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		
		add_action( 'vc_after_init', array(&$this,'vc_after_init') );
		
		add_action('init',array(&$this,'init'));
		add_action( 'init', array( __CLASS__, 'check_version' ), 5 );
		
		add_filter('single_template',array(&$this,'single_template'),10);
		
		dhvc_form_get_request_uri();
		
		add_action('wp_ajax_dhvc_form_ajax', array($this,'form_submit'));
		add_action('wp_ajax_nopriv_dhvc_form_ajax', array($this,'form_submit'));
	}
	
	public static function check_version(){
		$db_version = '2.0.0';
		if ( ! defined( 'IFRAME_REQUEST' ) && get_option( 'dhvc_form_db_version' ) !== $db_version ) {
			$args = array(
				'post_type'=>'dhvcform',
				'posts_per_page'=> -1,
				'post_status'=>'any'
			);
			$forms = get_posts($args);
			foreach ($forms as $form){
				$form_content = $form->post_content;
				$scan_tag = new DHVCForm_Scan_Tag($form_content);
				update_post_meta($form->ID, '_form_control', $scan_tag->get_scaned_fields());
			}
			update_option('dhvc_form_db_version', $db_version);
			flush_rewrite_rules();
		}
	}
	
	public function init(){
		if(class_exists('WYSIJA')){
			define('DHVC_FORM_SUPORT_WYSIJA', true);
		}
		
		if(defined('MYMAIL_DIR')){
			define('DHVC_FORM_SUPORT_MYMAIL', true);
		}
		
		//Custom WP User URL
		add_filter('login_url', array(&$this,'login_url'));
		add_filter('logout_url', array(&$this,'logout_url'));
		add_filter('register_url', array(&$this,'register_url'));
		add_filter('lostpassword_url', array(&$this,'lostpassword_url'));
		
		add_action('wp_print_footer_scripts', 'dhvc_form_print_js_declaration');
		
		if(!is_admin()){
			//Popup Form
			add_action('wp_head', array(&$this,'get_popup_form'),100);
			add_action( 'wp_footer',array(&$this,'print_form_popup'), 50 );
			
			add_action('wp_enqueue_scripts', array(&$this, 'frontend_assets'));
			add_action( 'wp_footer', 'dhvc_form_print_js_declaration', 100 );
			add_action('template_redirect', array(&$this,'override_woocommerce_my_account_shortcode'));
		}
	}
	
	public function vc_after_init(){
		$this->_editor_init();
	}
	
	private function _editor_init(){
		require_once DHVC_FORM_DIR.'/includes/editor_backend.php';
		$dhvcform_editor_backend = new DHVCForm_Editor_Backend();
		$dhvcform_editor_backend->addHooksSettings();
		if(dhvc_form_is_enable_editor_frontend()){
			require_once DHVC_FORM_DIR.'/includes/editor_frontend.php';
			$dhvcform_editor_frontend = new DHVCForm_Editor_Frontend();
			$dhvcform_editor_frontend->init();
		}
	}
	
	public function single_template($template){
		$object = get_queried_object();
		if ( ! empty( $object->post_type ) && 'dhvcform'===$object->post_type ) {
			return DHVC_FORM_DIR.'/includes/editor-templates/single.php';
		}
		return $template;
	}
	
	public function is_vc_plugin_activate(){
		if(!function_exists('is_plugin_active'))
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		return is_plugin_active('js_composer/js_composer.php');
	}
	
	public function notice(){
		echo '<div class="updated">
			    <p>' . sprintf('<strong>%s</strong> requires <strong><a href="http://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431?ref=Sitesao" target="_blank">Visual Composer</a></strong> plugin  to be installed and activated on your site.', 'DHVC Form') . '</p>
			  </div>';
	}
	
	
	public function form_submit(){
		if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && 'XMLHttpRequest' !== $_SERVER['HTTP_X_REQUESTED_WITH'] && $_SERVER['REQUEST_METHOD'] !== 'POST' )
			die(0);
		
		$submission = DHVCForm_Submission::get_instance(true);
		$result = array(
			'form_id' => $submission->get_form_id(),
			'status' => $submission->get_status(),
			'message' => $submission->get_response()
		);
		if ( $submission->is( 'validation_failed' ) ) {
			$result['invalid_fields'] = $submission->get_invalid_fields();
			
		}
		if($submission->is('success')){
			if( $redirect = $submission->get_redirect_url())
				$result['redirect'] = $redirect;
			if($on_ok = $submission->get_on_ok())
				$result['onOk']  = $on_ok;
		}
		do_action( 'dhvc_form_submit', $result, $submission);
		$response = apply_filters( 'dhvc_form_ajax_json_echo', $result, $submission );
		wp_send_json($response);
		die();
	}
	
	public function activate(){
		if(!class_exists('DHVCForm_DB'))
			require_once DHVC_FORM_DIR.'/includes/db.php';
		global $dhvcform_db;
		$this->_create_roles();
		$dhvcform_db->create_table();
		$this->_create_upload_dir();
		flush_rewrite_rules();
	}
	
	private function _create_upload_dir(){
		$upload_dir = wp_upload_dir();
		$dir = $upload_dir['basedir'] . '/dhvcform';
		wp_mkdir_p($dir);
	}
	
	private function _create_roles(){
		global $wp_roles;
	
		if ( class_exists( 'WP_Roles' ) ) {
			if ( ! isset( $wp_roles ) ) {
				$wp_roles = new WP_Roles();
			}
		}
	
		if ( is_object( $wp_roles ) ) {
	
			$capability = array(
				"edit_dhvcform",
				"read_dhvcform",
				"delete_dhvcform",
				"edit_dhvcforms",
				"edit_others_dhvcforms",
				"publish_dhvcforms",
				"read_private_dhvcforms",
				"delete_dhvcforms",
				"delete_private_dhvcforms",
				"delete_published_dhvcforms",
				"delete_others_dhvcforms",
				"edit_private_dhvcforms",
				"edit_published_dhvcforms",
			);
			foreach ( $capability as $cap ) {
				$wp_roles->add_cap( 'administrator', $cap );
			}
		}
	}
	
	private function _remove_roles(){
		global $wp_roles;
	
		if ( class_exists( 'WP_Roles' ) ) {
			if ( ! isset( $wp_roles ) ) {
				$wp_roles = new WP_Roles();
			}
		}
	
		if ( is_object( $wp_roles ) ) {
	
			$capability = array(
				"edit_dhvcform",
				"read_dhvcform",
				"delete_dhvcform",
				"edit_dhvcforms",
				"edit_others_dhvcforms",
				"publish_dhvcforms",
				"read_private_dhvcforms",
				"delete_dhvcforms",
				"delete_private_dhvcforms",
				"delete_published_dhvcforms",
				"delete_others_dhvcforms",
				"edit_private_dhvcforms",
				"edit_published_dhvcforms",
			);
			foreach ( $capability as $cap ) {
				$wp_roles->remove_cap( 'administrator', $cap );
			}
		}
	}
	
	public function frontend_assets(){
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_register_style('dhvc-form',DHVC_FORM_URL.'/assets/css/style'.$suffix.'.css', array(), DHVC_FORM_VERSION);
		wp_register_script('dhvc-form',DHVC_FORM_URL.'/assets/js/script.js',array('jquery'),DHVC_FORM_VERSION,true);
		
		wp_enqueue_style('dhvc-form-font-awesome');
		wp_enqueue_style('dhvc-form');
		
		$dhvcformL10n = array(
			'ajax_url'=>admin_url( 'admin-ajax.php', 'relative' ),
			'plugin_url'=>DHVC_FORM_URL,
			'recaptcha_public_key'=>dhvc_form_get_option('recaptcha_public_key'),
			'_ajax_nonce'=>wp_create_nonce( 'dhvc_form_ajax_nonce' ),
			'date_format'=>dhvc_form_get_option('date_format','Y/m/d'),
			'time_format'=>dhvc_form_get_option('time_format','H:i'),
			'time_picker_step'=>dhvc_form_get_option('time_picker_step',60),
			'dayofweekstart'=>apply_filters('dhvc_form_dayofweekstart',1),
			'datetimepicker_lang'=>dhvc_form_get_option('datetimepicker_lang','en'),
			'container_class'=>dhvc_form_get_option('container_class','.vc_row-fluid')
		);
		
		wp_localize_script('dhvc-form', 'dhvcformL10n', $dhvcformL10n);
	}
	
	public function login_url($login_url){
		$user_login = dhvc_form_get_option('user_login');
		if($user_login)
			$login_url = get_permalink($user_login);
		return $login_url;
	}
	
	public function register_url($register_url){
		$user_regiter = dhvc_form_get_option('user_regiter');
		if($user_regiter)
			$register_url = get_permalink($user_regiter);
		return $register_url;
	}
	
	public function logout_url($logout_url,$redirect=''){
		$user_logout = dhvc_form_get_option('user_logout_redirect_to');
		$args = array();
		if($user_logout){
			$redirect_to = get_permalink($user_logout);
			$args['redirect_to'] = urlencode( $redirect_to );
		}
		return  add_query_arg($args, $logout_url);
	}
	
	public function lostpassword_url($lostpassword_url){
		$user_forgotten = dhvc_form_get_option('user_forgotten');
		if($user_forgotten)
			$lostpassword_url = get_permalink($user_forgotten);
		return $lostpassword_url;
	}
	
	public function override_woocommerce_my_account_shortcode(){
		global $wp,$dhvc_form_woocommerce_login,$dhvc_form_woocommerce_lost_password;
		if(defined('WC_VERSION')){
			$woocommerce_lost_password_page_id = absint(dhvc_form_get_option('woocommerce_lost_password_page_id'));
			$woocommerce_login_page_id = absint(dhvc_form_get_option('woocommerce_login_page_id'));
			if(! is_user_logged_in() && ($woocommerce_lost_password_page_id || $woocommerce_login_page_id)){
				if (isset( $wp->query_vars['lost-password'] ) ) {
					if($woocommerce_lost_password_page_id && $woocommerce_lost_password_page = get_post($woocommerce_lost_password_page_id)){
						$dhvc_form_woocommerce_lost_password = $woocommerce_lost_password_page;
						remove_shortcode('woocommerce_my_account');
						add_shortcode('woocommerce_my_account', array(&$this,'woocommerce_lost_password'));
					}
				}else{
					if($woocommerce_login_page_id && $woocommerce_my_login_page = get_post($woocommerce_login_page_id)){
						$dhvc_form_woocommerce_login = $woocommerce_my_login_page;
						remove_shortcode('woocommerce_my_account');
						add_shortcode('woocommerce_my_account', array(&$this,'woocommerce_login'));
					}
				}
			}
		}
	}
	
	public function woocommerce_lost_password(){
		global $dhvc_form_woocommerce_lost_password;
		$content = $dhvc_form_woocommerce_lost_password->post_content;
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		$content = apply_filters('dhvc_form_woocommerce_lost_password_page',$content);
		ob_start();
		echo do_shortcode($content);
		return ob_get_clean();
	}
	
	public function woocommerce_login(){
		global $dhvc_form_woocommerce_login;
		$content = $dhvc_form_woocommerce_login->post_content;
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		$content = apply_filters('dhvc_form_woocommerce_login_page',$content);
		ob_start();
		echo do_shortcode($content);
		return ob_get_clean();
	}
	
	public function get_popup_form(){
		global $dhvc_form_popup;
		if(defined('DHVC_FORM_IS_FRONTEND_EDITOR'))
			return;
		$args = array(
			'post_type'=>'dhvcform',
			'posts_per_page'=> -1,
			'post_status'=>'publish',
			'meta_query' => array(
				array(
					'key' => '_form_popup',
					'value' => '1'
				)
			)
		);
		$form = new WP_Query($args);
		$popup = array();
		if($form->have_posts()):
			while ($form->have_posts()):
				$form->the_post(); global $post;
			
				$auto_open = get_post_meta($post->ID,'_form_popup_auto_open',true);
			
				$one = get_post_meta($post->ID,'_form_popup_one',true);
				$close = get_post_meta($post->ID,'_form_popup_auto_close',true);
				$title = get_post_meta($post->ID,'_form_popup_title',true);
				$data_attr = '';
				if(!empty($auto_open)){
					$data_attr = 'data-auto-open="1" data-open-delay="'.absint(get_post_meta($post->ID,'_form_popup_auto_open_delay',true)).'" '.(!empty($one) ? 'data-one-time="1"' : 'data-one-time="0"').' '.(!empty($close ) ? 'data-auto-close="1" data-close-delay="'.absint(get_post_meta($post->ID,'_form_popup_auto_close_delay',true)).'"':'data-auto-close="0"');
				}
				$popup[] = '<div id="dhvcformpopup-'.$post->ID.'" data-id="'.$post->ID.'" class="dhvc-form-popup" '.$data_attr.' style="display:none">';
				$popup[] = '<div class="dhvc-form-popup-container" style="width:'.absint(get_post_meta($post->ID,'_form_popup_width',true)).'px">';
				$popup[] = '<div class="dhvc-form-popup-header">';
				if(!empty($title)){
					$popup[] = '<h3>'.get_the_title($post->ID).'</h3>';
				}
				$popup[] = '<a class="dhvc-form-popup-close"><span aria-hidden="true">&times;</span></a>';
				$popup[] = '</div>';
				$popup[] = '<div class="dhvc-form-popup-body">';
				$popup[] = do_shortcode('[dhvc_form id="'.$post->ID.'"]');
				$popup[] = '</div>';
				$popup[] = '</div>';
				$popup[] = '</div>';
			endwhile;
		endif;
		$dhvc_form_popup = implode("\n", $popup);
		if(!empty($popup))
			$dhvc_form_popup .= '<div class="dhvc-form-pop-overlay"></div>';
		wp_reset_postdata();
	}
	
	public function print_form_popup(){
		global $dhvc_form_popup;
		if(!defined('DHVC_FORM_IS_FRONTEND_EDITOR') && !empty($dhvc_form_popup))
			echo $dhvc_form_popup;
	}
	
}
new DHVCForm();