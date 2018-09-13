<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class DHVCForm_Admin{
	
	public function __construct(){
		add_action( 'init', array( $this, 'init' ) );
		
		add_filter( 'post_updated_messages', array( &$this, 'post_updated_messages' ) );
		add_action( 'admin_print_scripts', array( &$this, 'disable_autosave' ) );
		
		add_action( 'admin_enqueue_scripts', array($this,'enqueue_scripts') );
		
		add_action('delete_post', array(&$this,'delete_post'));
		add_action( 'save_post', array(&$this,'save_post'),1,2 );
		
		// Admin Columns
		add_filter( 'manage_edit-dhvcform_columns', array( $this, 'edit_columns' ) );
		add_action( 'manage_dhvcform_posts_custom_column', array( $this, 'custom_columns' ), 2 );
		
		// Views and filtering
		add_filter( 'views_edit-dhvcform', array( &$this, 'custom_order_views' ) );
		add_filter( 'post_row_actions', array( $this, 'remove_row_actions' ), 100, 1 );
		add_filter( 'post_row_actions', array( $this, 'add_row_actions' ), 100, 2 );
		
	}

	public function init(){
		add_action( 'admin_menu', array( $this, 'create_admin_menu' ));
	}
	
	public function enqueue_scripts($hook_suffix){
		$screen         = get_current_screen();
		if('dhvcform'===$screen->post_type || false!==strpos($hook_suffix, 'dhvc-form')){
			wp_enqueue_style('dhvc_form_admin',DHVC_FORM_URL.'/assets/css/admin.css');
			
			wp_register_script( 'dhvc_form_admin', DHVC_FORM_URL.'/assets/js/admin.js', array( 'jquery' ), DHVC_FORM_VERSION, true );
			wp_localize_script( 'dhvc_form_admin', 'dhvc_form_admin', array(
				'ajax_url'=>admin_url( 'admin-ajax.php', 'relative' ),
				'plugin_url'=>DHVC_FORM_URL,
				'delete_confirm'=>__('Are your sure?','dhvc-form'),
				'conditional_tmpl'=>dhvc_form_conditional_tmpl(),
				'rate_option_tmpl'=>dhvc_form_rate_option_tmpl(),
				'option_tmpl'=>dhvc_form_option_tmpl(),
				'recipient_tmpl'=>dhvc_form_recipient_tmpl(),
				'paypal_list_tmpl'=>dhvc_form_paypal_list_tmpl(),
			) );
			wp_enqueue_script('dhvc_form_admin');
		}
	}
	
	public function create_admin_menu(){
		add_menu_page(__('Forms','dhvc-form'), __('Forms','dhvc-form'), 'edit_dhvcforms', 'dhvc-form',null,DHVC_FORM_URL.'/assets/images/visual_composer.png','50.5');
	}
	
	public function delete_post($post_id){
		global $dhvcform_db;
		if ( ! current_user_can( 'delete_posts' ) )
			return;
	
	
		if ( $post_id > 0 ) {
			$post_type = get_post_type( $post_id );
			if($post_type === 'dhvcform')
				$dhvcform_db->delete_entry_by_form($post_id);
		}
	}
	
	/**
	 * 
	 * @param unknown $post_id
	 * @param WP_Post $post
	 */
	public function save_post($post_id, $post){
		// $post_id and $post are required
		if ( empty( $post_id ) || empty( $post ) ) {
			return;
		}
		
		// Dont' save meta boxes for revisions or autosaves
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}
		
		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events
		if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
			return;
		}
		
		// Check user has permission to edit
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		// Check the post type
		if ('dhvcform'!==$post->post_type ) {
			return;
		}
		$scan_tag = new DHVCForm_Scan_Tag($post->post_content);
		update_post_meta($post->ID, '_form_control', $scan_tag->get_scaned_fields());
	}
	
	
	public function disable_autosave(){
		global $post;
	
		if ( $post && get_post_type( $post->ID ) === 'dhvcform' ) {
			wp_dequeue_script( 'autosave' );
		}
	}
	
	public function post_updated_messages( $messages ) {
		global $post;
		$messages['dhvcform'] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => __( 'Form updated.', 'dhvc-form' ),
			2 => __( 'Custom field updated.', 'dhvc-form' ),
			3 => __( 'Custom field deleted.', 'dhvc-form' ),
			4 => __( 'Form updated.', 'dhvc-form' ),
			5 => isset($_GET['revision']) ? sprintf( __( 'Form restored to revision from %s', 'dhvc-form' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => __( 'Form updated.', 'dhvc-form' ),
			7 => __( 'Form saved.', 'dhvc-form' ),
			8 => __( 'Form submitted.', 'dhvc-form' ),
			9 => sprintf( __( 'Form scheduled for: <strong>%1$s</strong>.', 'dhvc-form' ),date_i18n( __( 'M j, Y @ G:i', 'dhvc-form' ), strtotime( $post->post_date ) ) ),
			10 => __( 'Form draft updated.', 'dhvc-form' )
		);
		return $messages;
	}
	
	public function edit_columns( $existing_columns ) {
		$columns = array();
	
		$columns['cb']             = isset($existing_columns['cb']) ? $existing_columns['cb'] : '';
		$columns['form_id']        = __( 'ID', 'dhvc-form' );
		$columns['title']          = __( 'Title', 'dhvc-form' );
		$columns['shortcode']      = __( 'Shortcode', 'dhvc-form' );
	
		unset($existing_columns['title']);
		unset($existing_columns['cb']);
	
		return array_merge($columns,$existing_columns);
	}
	
	public function custom_columns( $column ) {
		global $post;
		switch ( $column ) {
			case 'shortcode':
				echo '<input class="wp-ui-text-highlight code" type="text" onfocus="this.select();" readonly="readonly" value="'.esc_attr('[dhvc_form id="'.$post->ID.'"]').'" style="width:99%">';
				break;
			case 'form_id':
				echo get_the_ID();
				break;
		}
	}
	
	public function custom_order_views($views){
		unset( $views['publish'] );
	
		if ( isset( $views['trash'] ) ) {
			$trash = $views['trash'];
			unset( $views['draft'] );
			unset( $views['trash'] );
			$views['trash'] = $trash;
		}
	
		return $views;
	}
	
	public function add_row_actions($actions){
		global $post;
		$actions['delete'] = "<a class='submitdelete' id='dhvc_form_submitdelete' title='" . esc_attr( __( 'Delete this item permanently' ) ) . "' href='" . get_delete_post_link( $post->ID, '', true ) . "'>" . __( 'Delete Permanently' ) . "</a>";
		return $actions;
	}
	
	public function remove_row_actions( $actions ) {
		if ( 'dhvcform' === get_post_type() ) {
			unset( $actions['view'] );
			unset( $actions['edit_vc'] );
			unset( $actions['trash'] );
			unset( $actions['inline hide-if-no-js'] );
		}
	
		return $actions;
	}
}
new DHVCForm_Admin();