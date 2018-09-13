<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Difp_Update
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
		add_filter('difp_admin_settings_tabs', array($this, 'sections'));
		add_filter('difp_settings_fields', array($this, 'fields'));
		add_action('difp_admin_settings_field_output_update', array($this, 'field_output'));
		add_action('admin_enqueue_scripts', array($this, 'difp_update_script' ));
		add_action('wp_ajax_difp_update_ajax', array($this, 'ajax'));
		
		add_action('admin_init', array( $this, 'install'), 20 );
		add_action('admin_init', array( $this, 'message_view_changed'), 25 );
		add_action('admin_init', array( $this, 'auto_update'), 30 );
		
		add_action('difp_plugin_update', array( $this, 'update') );
    }
	
	function install(){
		if( false !== difp_get_option( 'plugin_version', false ) )
			return;
		
		global $wpdb;
		
		$roles = array_keys( get_editable_roles() );
		$id = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_content LIKE '%[ALSP%' AND post_status = 'publish' AND post_type = 'page' LIMIT 1");
		
		$options = array();
		
		$options['userrole_access'] = $roles;
		$options['userrole_new_message'] = $roles;
		$options['userrole_reply'] = $roles;
		$options['plugin_version'] = DIFP_PLUGIN_VERSION;
		$options['page_id'] = $id;
		
		difp_update_option( $options );
		difp_add_caps_to_roles();
		$this->create_htaccess();
	}
	
	function update( $prev_ver ){
		if( version_compare( $prev_ver, '5.3', '<' ) ){
			$this->create_htaccess();
		}
	}
	
	function sections( $tabs)
	{
		$tabs['update'] =  array(
				'priority'			=> 45,
				'tab_title'			=> __('Update', 'ALSP'),
				);
		return $tabs;
		
	}
	
	function fields( $fields)
	{
		$fields['update'] =   array(
				'type'	=>	'update',
				'section'	=> 'update',
				'label' => __( 'Update', 'ALSP' )
				);
		return $fields;
		
	}
	
	function field_output( $field ){
		
		wp_enqueue_script( 'difp_update_script');
		?>
		<div id="difp-update-warning">
		 <strong><?php _e( 'DO NOT close this window. This may take several minutes, please be patient.', 'ALSP' ); ?></strong>
		</div>
		<div><img src="<?php echo DIFP_PLUGIN_URL; ?>assets/images/loading.gif" class="difp-ajax-img" style="display:none;"/>
		</div>
		<div id="difp-ajax-response"></div>
		<?php
	}
	function difp_update_script() {

		wp_register_script( 'difp_update_script', DIFP_PLUGIN_URL . 'assets/js/difp_update_script.js', array( 'jquery' ), '4.9', true );
	}
	
	function message_view_changed(){
		if( get_option( '_difp_message_view_changed' ) ){
			add_filter( 'difp_update_enable_version_check', '__return_false' );
			add_filter( 'difp_require_manual_update', '__return_true' );
			add_action( 'difp_plugin_manual_update', array($this, 'individual_to_threaded') );
		}
	}
	
	function auto_update(){
		if ( defined('DOING_AJAX') && DOING_AJAX ) {
			return;
		}
		if( isset( $_GET['tab'] ) && 'update' == $_GET['tab'] ) {
			return;
		}
		$prev_ver = difp_get_option( 'plugin_version', '4.1' );
	
		if( version_compare( $prev_ver, DIFP_PLUGIN_VERSION, '=' ) && apply_filters( 'difp_update_enable_version_check', true ) ) {
			return;
		}
		
		$require = false;
		
		global $wpdb;
		if( $wpdb->get_var("SHOW TABLES LIKE '". DIFP_MESSAGES_TABLE . "'") == DIFP_MESSAGES_TABLE ) {
			if( ! $wpdb->get_var("SELECT COUNT(*) FROM " . DIFP_MESSAGES_TABLE . " WHERE id IS NOT NULL LIMIT 1") ) {
				//$wpdb->query( "DROP TABLE IF EXISTS ".DIFP_MESSAGES_TABLE );
				//$wpdb->query( "DROP TABLE IF EXISTS ".DIFP_META_TABLE );
			} else {
				$require = true;
			}
		}
		if( version_compare( $prev_ver, '5.1', '<' ) ) {
			$require = true;
		}
		
		if( apply_filters( 'difp_require_manual_update', $require, $prev_ver ) ){
			$redirect = add_query_arg( array(
				'post_type'   => 'difp_message',
				'page'        => 'difp_settings',
				'tab'			=> 'update',
				//'difp_update'  => 'start'
			), admin_url( 'edit.php' ) );
			wp_redirect( $redirect ); /* exit; */ //No need to exit.There may have other action after this from other plugin
		} else{
			do_action( 'difp_plugin_auto_update', $prev_ver );
			do_action( 'difp_plugin_update', $prev_ver );
			
			difp_update_option( 'plugin_version', DIFP_PLUGIN_VERSION );
		}
	}
	
	function ajax(){
		
		$prev_ver = difp_get_option( 'plugin_version', '3.3' );
		
		if( version_compare( $prev_ver, '4.1', '<' ) ) {
			$this->update_version_41();
		}
		
		if( version_compare( $prev_ver, '5.1', '<' ) ) {
			$this->update_version_51();
		}
		
		do_action( 'difp_plugin_manual_update', $prev_ver );
		do_action( 'difp_plugin_update', $prev_ver );
		
		difp_update_option( 'plugin_version', DIFP_PLUGIN_VERSION );
		$response = array(
			'update'  		=> 'completed',
			'message'	=>__('Update completed.', 'ALSP')
		);
		wp_send_json( $response );
	}
	
	function update_version_41(){
		$updated = difp_get_option( 'v41', 0, 'difp_updated_versions' );
		if( $updated )
			return;

		global $wpdb;
		if( $wpdb->get_var("SHOW TABLES LIKE '". DIFP_MESSAGES_TABLE . "'") != DIFP_MESSAGES_TABLE ) {
			return difp_update_option( 'v41', 1, 'difp_updated_versions' );
		}
		
		ignore_user_abort( true );

		if ( ! ini_get( 'safe_mode' ) )
		@set_time_limit( 300 );
		
		$custom_int   = isset( $_POST['custom_int'] )    ? absint( $_POST['custom_int'] )           	: 0;
		$custom_str = isset( $_POST['custom_str'] )      ? sanitize_text_field($_POST['custom_str']): 'messages';

		if( 'announcements' == $custom_str ){
			$announcements = $this->get_announcements( 0, 25 );
			if( $announcements ){
				foreach( $announcements as $announcement ){
					$this->insert_announcement( $announcement );
				}
				delete_metadata( 'user', 0, '_difp_user_announcement_count', '', true );
				
				$custom_int = $custom_int + count( $announcements );
				
				$response = array(
					//'update'  		=> 'continue',
					'message'	=> sprintf(_n('%s announcement updated', '%s announcements updated', $custom_int, 'ALSP'), number_format_i18n( $custom_int ) ),
					'custom_int'        => $custom_int,
					'custom_str'		=> $custom_str
				);
				wp_send_json( $response );
			}
		
		} else {
			$messages = $this->get_messages( 0, 25 );
			if( $messages ){
				
				foreach( $messages as $message ){
					$this->insert_message( $message );
				}
				$custom_int = $custom_int + count( $messages );
				$response = array(
					//'update'  		=> 'continue',
					'message'	=> sprintf(_n('%s message updated', '%s messages updated', $custom_int, 'ALSP'), number_format_i18n( $custom_int ) ),
					'custom_int'        => $custom_int,
					'custom_str'		=> $custom_str
				);
				wp_send_json( $response );
				
			} else {
				$response = array(
					//'update'  		=> 'continue',
					'message'	=>__('All messages updated', 'ALSP'),
					'custom_int'        	=> 0,
					'custom_str'		=> 'announcements'
				);
				wp_send_json( $response );
			}
		}
		
		delete_metadata( 'user', 0, '_difp_user_message_count', '', true );
		delete_metadata( 'user', 0, '_difp_user_announcement_count', '', true );
		
		difp_update_option( 'v41', 1, 'difp_updated_versions' );
		$response = array(
			//'update'  		=> 'continue',
			'message'	=>__('All messages and announcements updated', 'ALSP'),
			'custom_int'        => 0,
			'custom_str'		=> ''
		);
		wp_send_json( $response );
	}
	
	function update_version_51(){
		$updated = difp_get_option( 'v51', 0, 'difp_updated_versions' );
		if( $updated )
			return;
		
		$custom_int   = isset( $_POST['custom_int'] )        ? absint( $_POST['custom_int'] )           	: 0;
		
		ignore_user_abort( true );
		if ( ! ini_get( 'safe_mode' ) )
			@set_time_limit( 300 );
		
		if( ! difp_get_option( 'v51-part-1', 0, 'difp_updated_versions' ) ){
			global $wpdb;
		
			$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = REPLACE( meta_key, '_message_key', '_difp_message_key' ) WHERE meta_key = '_message_key'" );
			
			$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = REPLACE( meta_key, '_participant_roles', '_difp_participant_roles' ) WHERE meta_key = '_participant_roles'" );
			
			$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = REPLACE( meta_key, '_participants', '_difp_participants' ) WHERE meta_key = '_participants'" );
		
			difp_update_option( 'v51-part-1', 1, 'difp_updated_versions' );
			$response = array(
				//'update'  		=> 'continue',
				'message'	=>__('Messages meta updated', 'ALSP'),
				'custom_int'        => 0,
				'custom_str'		=> ''
			);
			wp_send_json( $response );
		}
		if( 'threaded' != difp_get_message_view() )
			difp_update_option( 'v51-part-2', 1, 'difp_updated_versions' );
		
		if( ! difp_get_option( 'v51-part-2', 0, 'difp_updated_versions' ) ){
			$this->individual_to_threaded();
		
			difp_update_option( 'v51-part-2', 1, 'difp_updated_versions' );
			$response = array(
				//'update'  		=> 'continue',
				'message'	=>__('Messages meta updated', 'ALSP'),
				'custom_int'        => 0,
				'custom_str'		=> ''
			);
			wp_send_json( $response );
		}
		
		foreach( array( 'administrator', 'editor' ) as $role ) {
			$role_obj = get_role( $role );
			if( !$role_obj )
				continue;
			
			$role_obj->add_cap( 'create_difp_messages' );
			$role_obj->add_cap( 'edit_published_difp_messages' );
			$role_obj->add_cap( 'edit_published_difp_announcements' );
		}
		
		difp_update_option( 'v51', 1, 'difp_updated_versions' );
		$response = array(
			//'update'  		=> 'continue',
			'message'	=> __('Messages meta updated', 'ALSP'),
			'custom_int'        => 0,
			'custom_str'		=> ''
		);
		wp_send_json( $response );
	}
	
	function individual_to_threaded(){
		//global $wpdb;
		
		$custom_int   = isset( $_POST['custom_int'] )   ? absint( $_POST['custom_int'] )  : 0;
		
		ignore_user_abort( true );
		if ( ! ini_get( 'safe_mode' ) )
			@set_time_limit( 300 );
			
		$args = array(
			'post_type' => 'difp_message',
			'post_status' => 'publish',
			'post_parent' => 0,
			//'fields' => 'ids',
			'posts_per_page' => 50,
			'meta_query' => array(
				array(
					'key' => '_difp_last_reply_by',
					'compare' => 'NOT EXISTS'
				)
				
			)
		 );
		 $posts = get_posts( $args );
		 
		 if( $posts ) {
			 $child_args = array(
				'post_type' => 'difp_message',
				'post_status' => 'publish',
				'posts_per_page' => 1
			 );
			 
			 foreach( $posts as $post ){
				$child_args['post_parent'] = $post->ID;
				
				$child = get_posts( $child_args );
				if( $child && ! empty( $child[0] ) ){
					update_post_meta( $post->ID, '_difp_last_reply_by', $child[0]->post_author );
					update_post_meta( $post->ID, '_difp_last_reply_id', $child[0]->ID );
					
					update_post_meta( $post->ID, '_difp_last_reply_time', strtotime( $child[0]->post_date_gmt ) );
					//$wpdb->update( $wpdb->posts, array( 'post_modified' => $child[0]->post_date, 'post_modified_gmt' => $child[0]->post_date_gmt ), array( 'ID' => $post->ID ) );
				} else {
					add_post_meta( $post->ID, '_difp_last_reply_by', $post->post_author, true );
					add_post_meta( $post->ID, '_difp_last_reply_id', $post->ID, true );
					
					add_post_meta( $post->ID, '_difp_last_reply_time', strtotime( $post->post_date_gmt ), true );
				}
			 }
			 
			$custom_int = $custom_int + count( $posts );
			$response = array(
				//'update'  		=> 'continue',
				'message'	=> sprintf(_n('%s message meta updated', '%s messages meta updated', $custom_int, 'ALSP'), number_format_i18n( $custom_int ) ),
				'custom_int'        => $custom_int,
				'custom_str'		=> ''
			);
			wp_send_json( $response );
		 }
		delete_metadata( 'user', 0, '_difp_user_message_count', '', true );
		update_option( '_difp_message_view_changed', 0 );
	}
	
	function insert_announcement( $announcement ){
		$arr = array(
				'post_title'	=> $announcement->message_title,
				'post_content'	=> $announcement->message_contents,
				'post_author'	=> $announcement->from_user,
				'post_date'	=> $announcement->send_date,
				'post_type'	=> 'difp_announcement',
				'post_status'    => 'publish'
			);
		if( ! $ann_id = wp_insert_post($arr) )
			return;
		add_post_meta( $ann_id, '_difp_import_from_table', time(), true );

		foreach( array_keys( get_editable_roles() ) as $role ) {
			add_post_meta( $ann_id, '_difp_participant_roles', $role );
		}
		
		$seen = $this->get_announcement_meta( $announcement->id );
		$seen = maybe_unserialize( $seen );
		
		if( $seen && is_array($seen) ) {
			add_post_meta( $ann_id, '_difp_read_by', $seen, true );
		}
		
		$deleted = $this->get_announcement_meta( $announcement->id, 'announcement_deleted_user_id' );
		$deleted = maybe_unserialize( $deleted );
		
		if( $deleted && is_array($deleted) ) {
			$deleted = array_flip( $deleted );
			
			foreach( $deleted as $del_user_id => $v ) {
				$deleted[ $del_user_id ] = time();
			}
			add_post_meta( $ann_id, '_difp_deleted_by', $deleted, true );
		}
		$this->insert_attachment( $ann_id, $announcement->id, $announcement->from_user );
		$this->delete_message( $announcement->id );
	}
	
	function insert_message( $message ){
		$arr = array(
				'message_title'	=> $message->message_title,
				'message_content'	=> $message->message_contents,
				'difp_parent_id'	=> 0,
				'message_post_id'	=> $message->message_post_id,
				'message_bid'	=> $message->message_bid,
				'message_to_id'	=> $message->to_user
			);
		$override = array(
				'post_author'	=> $message->from_user,
				'post_date'	=> $message->send_date
			);
		
		if( $message_id = difp_send_message( $arr, $override ) ) {
			if( 1 == $message->status ) {
				difp_make_read( true, $message_id, $message->to_user );
			}
			if( 1 == $message->from_del ) {
				add_post_meta( $message_id, '_difp_delete_by_'. $message->from_user, time(), true ); //No time from previous version
			} elseif( 1 == $message->to_del ) {
				add_post_meta( $message_id, '_difp_delete_by_'. $message->to_user, time(), true );
			}
			add_post_meta( $message_id, '_difp_import_from_table', time(), true );
			
			$this->insert_attachment( $message_id, $message->id, $message->from_user );
			$this->insert_replies( $message_id, $message->id );
			
			$this->delete_message( $message->id );
		}
	}
	
	function insert_attachment( $message_id, $message_prev_id, $author )
	{
		if( ! $attachments = $this->get_attachments( $message_prev_id ) )
		return;
		
		foreach( $attachments as $attachment ) {
			$unserialized_file = maybe_unserialize( $attachment->field_value );
			if ( $unserialized_file['type'] && $unserialized_file['url'] && $unserialized_file['file'] ) {
				// Prepare an array of post data for the attachment.
				$att = array(
					'guid'           => $unserialized_file['url'], 
					'post_mime_type' => $unserialized_file['type'],
					'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $unserialized_file['url'] ) ),
					'post_content'   => '',
					'post_author'	=> $author,
					'post_status'    => 'inherit'
				);
				
				// Insert the attachment.
				wp_insert_attachment( $att, $unserialized_file['file'], $message_id );
			}
		}
		
	}
	function insert_replies( $message_id, $message_prev_id )
	{
		if( ! $replies = $this->get_replies( $message_prev_id ) )
		return;
		
		foreach( $replies as $reply ) {
			$arr = array(
					'message_title'	=> $reply->message_title,
					'message_content'	=> $reply->message_contents,
					'difp_parent_id'	=> $message_id
				);
			$override = array(
					'post_author'	=> $reply->from_user,
					'post_date'	=> $reply->send_date
				);
			
			if( $reply_id = difp_send_message( $arr, $override ) ) {
				$this->insert_attachment( $reply_id, $reply->id, $reply->from_user );
				
				$this->delete_message( $reply->id );
			}
			
		}
		
	}
	
	function delete_message( $message_id )
    {	global $wpdb;
 
 		$wpdb->query($wpdb->prepare("DELETE FROM ".DIFP_MESSAGES_TABLE." WHERE id = %d", $message_id ));
		$wpdb->query($wpdb->prepare("DELETE FROM ".DIFP_META_TABLE." WHERE message_id = %d", $message_id ));

    }
	
	function get_messages( $start, $end )
    {	global $wpdb;
 
	 return $wpdb->get_results($wpdb->prepare("SELECT * FROM ".DIFP_MESSAGES_TABLE." WHERE parent_id = %d AND (status = 0 OR status = 1) ORDER BY last_date DESC LIMIT %d, %d", 0, $start, $end ));

    }
	function get_messages_count()
    {	global $wpdb;
 
	 return $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM ".DIFP_MESSAGES_TABLE." WHERE parent_id = %d AND (status = 0 OR status = 1) ORDER BY last_date DESC", 0 ));

    }
	function get_replies( $parent )
    {
 		global $wpdb;
	 return $wpdb->get_results($wpdb->prepare("SELECT * FROM ".DIFP_MESSAGES_TABLE." WHERE parent_id = %d AND (status = 0 OR status = 1) ORDER BY last_date DESC", $parent ));

    }
	function get_attachments( $message_id )
    {
 		global $wpdb;
	 return $wpdb->get_results($wpdb->prepare("SELECT * FROM ".DIFP_META_TABLE." WHERE message_id = %d AND field_name = %s", $message_id, 'attachment' ));

    }
	function get_announcements( $start, $end )
    {	global $wpdb;
 
	 return $wpdb->get_results($wpdb->prepare("SELECT * FROM ".DIFP_MESSAGES_TABLE." WHERE status = %d LIMIT %d, %d", 2, $start, $end ));

    }
	function get_announcements_count()
    {	global $wpdb;
 
	 return $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM ".DIFP_MESSAGES_TABLE." WHERE status = %d", 2 ));

    }
	function get_announcement_meta( $id, $meta = 'announcement_seen_user_id' )
    {	global $wpdb;
 
	 return $wpdb->get_var($wpdb->prepare("SELECT field_value FROM ".DIFP_META_TABLE." WHERE message_id = %d AND field_name = %s LIMIT 1", $id, $meta ));

    }
    
    function create_htaccess(){
    	
		$wp_upload_dir = wp_upload_dir();
		$upload_path = $wp_upload_dir['basedir'] . '/ALSP';
		$htaccess_path = $upload_path . '/.htaccess';
    	
		// Make sure the /ALSP folder is created
		wp_mkdir_p( $upload_path );

		//.htaccess file content
		$htaccess = "Options -Indexes\ndeny from all\n";
		
		if( ! file_exists( $htaccess_path ) && wp_is_writable( $upload_path ) ) {
			// Create the file if it doesn't exist
			@file_put_contents( $htaccess_path, $htaccess );
		}
    }
	
	
  } //END CLASS

add_action('admin_init', array(Difp_Update::init(), 'actions_filters'));

function difp_insert_dummy_message(){
	global $wpdb;
	
	for( $i = 0; $i < 3000; $i++ ) {
	$from = rand(1, 5);
	
		$wpdb->insert( DIFP_MESSAGES_TABLE, array( 
		'from_user' => $from, 
		'to_user' => rand(1, 5), 
		'message_title' => 'this is title', 
		'message_contents' => 'this is message', 
		'parent_id' => 0, 
		'last_sender' => $from, 
		'send_date' => current_time('mysql'), 
		'last_date' => current_time('mysql'),
		'status' => rand(0, 2) 
		), 
		array( '%d', '%d', '%s', '%s', '%d', '%d', '%s', '%s', '%d' ));
		
	}
}

function difp_insert_dummy_message2(){
	global $wpdb;
	
	for( $i = 0; $i < 3000; $i++ ) {
	
		$wpdb->insert( $wpdb->posts, array( 
		'post_author' => rand(1, 5), 
		'post_date_gmt' => current_time('mysql'), 
		'post_title' => 'this is title post', 
		'post_content' => 'this is message post', 
		'post_parent' => 0, 
		'post_status' => 'publish',
		'post_type'		=>'difp_message'
		), 
		array( '%d', '%s', '%s', '%s', '%d', '%s', '%s' ));
		
	}
}
//add_action('wp_loaded', 'difp_insert_dummy_message2' );

