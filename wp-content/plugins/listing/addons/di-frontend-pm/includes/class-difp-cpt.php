<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Difp_Cpt {

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
		add_action ('init', array($this, 'create_cpt') );
		add_action ('admin_menu', array($this, 'admin_menu') );
		//add_action ('contextual_help', array($this, 'contextual_help'), 10, 3 );
		add_action ('save_post_difp_message', array($this, 'save_message'), 10, 3 );
		add_action ('save_post_difp_announcement', array($this, 'save_announcement'), 10, 3 );
		
		add_action ('difp_save_message', array($this, 'difp_save_message_to'), 10, 3 );
		add_action ('difp_save_message', array($this, 'difp_save_message'), 10, 3 );
		
		add_action ('difp_save_announcement', array($this, 'save_announcement_to'), 10, 3 );
		
		add_action ('edit_form_after_title', array($this, 'edit_form_after_title') );
		add_action ('add_meta_boxes', array($this, 'add_meta_boxes') );
		add_filter( 'redirect_post_location', array($this, 'redirect_post_location'), 10, 2 );
		add_filter('manage_difp_message_posts_columns', array($this, 'columns_head'));
		add_filter('post_row_actions', array($this, 'view_link'), 10, 2 );
		add_action('manage_difp_message_posts_custom_column', array($this, 'columns_content'), 10, 2);
		//add_filter( 'manage_difp_message_sortable_columns', array($this, 'sortable_column' ));
		
		add_filter('manage_difp_announcement_posts_columns', array($this, 'announcement_columns_head'));
		add_action('manage_difp_announcement_posts_custom_column', array($this, 'announcement_columns_content'), 10, 2);
		
		//add_action ('post_submitbox_start', array($this, 'post_submitbox_start_info') );
		//add_action( 'pre_get_posts', array($this, 'sortable_orderby' ));
    }

	function create_cpt()
	{
		/** difp_message Post Type */
		$labels = array(
			'name' 				=> _x('Messages', 'post type general name', 'ALSP' ),
			'singular_name' 	=> _x('Message', 'post type singular name', 'ALSP' ),
			'add_new' 			=> __( 'New Message', 'ALSP' ),
			'add_new_item' 		=> __( 'New Message', 'ALSP' ),
			'edit_item' 		=> __( 'Edit Message', 'ALSP' ),
			'new_item' 			=> __( 'New Message', 'ALSP' ),
			'all_items' 		=> __( 'All Messages', 'ALSP' ),
			'view_item' 		=> __( 'View Message', 'ALSP' ),
			'search_items' 		=> __( 'Search Message', 'ALSP' ),
			'not_found' 		=>  __( 'No Messages found', 'ALSP' ),
			'not_found_in_trash'=> __( 'No Messages found in Trash', 'ALSP' ),
			'parent_item_colon' => '',
			'menu_name' 		=> difp_is_pro() ? 'DesignInvento Messaging System PRO' : 'DesignInvento Messaging System'
		);
	
		$args = array(
			'labels' 			=> apply_filters( 'difp_message_cpt_labels', $labels ),
			'query_var' 		=> false,
			'rewrite' 			=> false,
			'show_ui' 			=> true,
			//'show_in_menu' 		=> true,
			'capability_type' 	=> 'difp_message',
			'capabilities' => array(
				'create_posts' => 'do_not_allow', //will be changed in next version to send message from BACK END
				 ),
			'map_meta_cap'      => true,
			'menu_icon'   		=> 'dashicons-email-alt',
			'supports' 			=> apply_filters( 'difp_message_cpt_supports', array( 'title', 'editor' ) ),
			'can_export'		=> true
		);
		register_post_type( 'difp_message', apply_filters( 'difp_message_cpt_args', $args )  );
		
		
		/** difp_announcement Post Type */
		$announcement_labels = array(
			'name' 				=> _x('Announcements', 'post type general name', 'ALSP' ),
			'singular_name' 	=> _x('Announcement', 'post type singular name', 'ALSP' ),
			'add_new' 			=> __( 'New Announcement', 'ALSP' ),
			'add_new_item' 		=> __( 'New Announcement', 'ALSP' ),
			'edit_item' 		=> __( 'Edit Announcement', 'ALSP' ),
			'new_item' 			=> __( 'New Announcement', 'ALSP' ),
			'all_items' 		=> __( 'All Announcements', 'ALSP' ),
			'view_item' 		=> __( 'View Announcement', 'ALSP' ),
			'search_items' 		=> __( 'Search Announcement', 'ALSP' ),
			'not_found' 		=>  __( 'No Announcements found', 'ALSP' ),
			'not_found_in_trash'=> __( 'No Announcements found in Trash', 'ALSP' ),
			'parent_item_colon' => '',
			'menu_name' 		=> __( 'Di Messages', 'ALSP' )
		);
		
		$announcement_args = array(
			'labels' 			=> apply_filters( 'difp_announcement_cpt_labels', $announcement_labels ),
			'query_var' 		=> false,
			'rewrite' 			=> false,
			'show_ui' 			=> true,
			'show_in_menu' 		=> 'edit.php?post_type=difp_message',
			'capability_type' 	=> 'difp_announcement',
			'map_meta_cap'      => true,
			'supports' 			=> apply_filters( 'difp_announcement_cpt_supports', array( 'title', 'editor' ) ),
			'can_export'		=> true
		);
		register_post_type( 'difp_announcement', apply_filters( 'difp_announcement_cpt_args', $announcement_args )  );
	
	}
	
	function admin_menu(){
		//add_submenu_page( 'edit.php?post_type=difp_message', __( 'New Announcement', 'ALSP' ), __( 'New Announcement', 'ALSP' ), 'create_difp_announcements', 'post-new.php?post_type=difp_announcement' );
	}


	function contextual_help( $contextual_help, $screen_id, $screen ) { 
	  if ( 'difp_message' == $screen->id ) {
	
		$contextual_help = '<h2>Message</h2>
		<p>Test help.</p> 
		<p>Test help.</p>';
	
	  } elseif ( 'edit-difp_message' == $screen->id ) {
	
		$contextual_help = '<h2>Editing Message</h2>
		<p>Test help.</p> 
		<p>Test help.</p>';
	
	  }
	  return $contextual_help;
	}

function edit_form_after_title( $post ) {
    if( ! in_array( $post->post_type, array( 'difp_message', 'difp_announcement' ) ) ) {
        return;
    }

    wp_nonce_field( 'difp_nonce', 'difp_nonce' );
}

function add_meta_boxes() {
    add_meta_box( 
        'difp_message_to_box',
        __( 'Message To', 'ALSP' ),
        array($this, 'difp_message_to_box_content'),
        'difp_message',
        'side',
        'high'
    );
	remove_meta_box( 'slugdiv', 'difp_message', 'normal' );
	 //remove_meta_box( 'submitdiv', 'difp_message', 'core' );
	 add_meta_box( 'difp_announcement_to', __( 'Announcement to roles', 'ALSP' ), array($this, 'announcement_to'), 'difp_announcement', 'side', 'core' );
}

function announcement_to( $post ) {
 
		$participants = difp_get_participant_roles( $post->ID );

		
			foreach( get_editable_roles() as $key => $role ) {
			
				?><label><input id="" class="" name="participant_roles[]" type="checkbox" value="<?php echo $key; ?>" <?php if( in_array( $key, $participants ) ) echo'checked="checked"'; ?> /> <?php echo translate_user_role( $role['name'] ); ?></label><br /><?php
			}
			if ( isset($_GET['action'])  && $_GET['action'] == 'edit' ) {
				echo '<hr />';
				_e('Changing this will NOT send email to newly added users OR prevent email sending to removed users if any', 'ALSP');
			}

	}

function save_announcement_to( $announcement_id, $announcement, $update ){
	if( isset($_POST['participant_roles'] ) && is_array( $_POST['participant_roles'] ) ) {
		delete_post_meta( $announcement_id, '_difp_participant_roles' );
		
			foreach($_POST['participant_roles'] as $role ) {
				add_post_meta( $announcement_id, '_difp_participant_roles', $role );
			}
	
	}
}
	
function difp_message_to_box_content( $post ) {
 
	if ( isset($_GET['action'])  && $_GET['action'] == 'edit' ) {
		$participants = difp_get_participants( $post->ID );
		
		if( $participants ) {
			foreach( $participants as $participant ) {
			
				if( $participant != $post->post_author )
				echo '<a href="'. get_edit_user_link( $participant ) .'" target="_blank">'. esc_attr( difp_get_userdata( $participant, 'display_name', 'ID' ) ) .'</a><br />';
			}
		}
		echo '<hr />';
		echo '<h2><strong>'. __('Sender', 'ALSP') . '</strong></h2>';
		echo '<a href="'. get_edit_user_link( $post->post_author ) .'" target="_blank">'. esc_attr( difp_get_userdata( $post->post_author, 'display_name', 'ID' ) ) .'</a>';

	} else {

		$parent = ( !empty( $_REQUEST['difp_parent_id'] ) ) ? absint( $_REQUEST['difp_parent_id'] ) : '';
		$to 	= ( !empty( $_REQUEST['difp_to'] ) ) ? $_REQUEST['difp_to'] : '';
		
		if( $parent ) {
			echo 'You are replying to <a href="'.difp_query_url('viewmessage', array( 'difp_id' => $parent ) ).'" title="" target="_blank">' . $parent . '</a>';
			echo '<input type="hidden" name="difp_parent_id" value="' . $parent . '" />';
		} else {
			wp_register_script( 'difp-script', DIFP_PLUGIN_URL . 'assets/js/script.js', array( 'jquery' ), '3.1', true );
			wp_localize_script( 'difp-script', 'difp_script', 
					array( 
						'ajaxurl' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce('difp-autosuggestion')
					) 
				);
			wp_enqueue_script( 'difp-script' ); ?>
							
			<input type="hidden" name="message_to" id="difp-message-to" autocomplete="off" value="<?php echo difp_get_userdata( $to, 'user_login' ); ?>" />		
			<input type="text" name="message_top" id="difp-message-top" autocomplete="off" value="<?php echo difp_get_userdata($to, 'display_name'); ?>" />
			<img src="<?php echo DIFP_PLUGIN_URL; ?>assets/images/loading.gif" class="difp-ajax-img" style="display:none;"/>
			<div id="difp-result"></div><?php
		} 
	}
}

function difp_save_message_to( $message_id, $message, $update ){
	if( ! empty($_REQUEST['message_to'] ) ) { //BACK END message_to return login of participants
		if( is_array( $_REQUEST['message_to'] ) ) {
			foreach( $_REQUEST['message_to'] as $participant ) {
				add_post_meta( $message_id, '_difp_participants', difp_get_userdata( $participant, 'ID', 'login' ) );
			}
		} else {
			add_post_meta( $message_id, '_difp_participants', difp_get_userdata( $_REQUEST['message_to'], 'ID', 'login' ) );
		}
		add_post_meta( $message_id, '_difp_participants', $message->post_author );
		
		unset( $_REQUEST['message_to'] );
	}
}

function difp_save_message( $message_id, $message, $update ){
	if( ! empty($_REQUEST['difp_parent_id'] ) ) {
	remove_action ('difp_save_message', array($this, 'difp_save_message'), 10, 3 );
			wp_update_post(
						array(
							'ID' => $message_id, 
							'post_parent' => absint($_REQUEST['difp_parent_id'])
						)
					);
				unset( $_REQUEST['difp_parent_id'] );
	add_action ('difp_save_message', array($this, 'difp_save_message'), 10, 3 );
	}
}
function post_submitbox_start_info()
{
	global $post;
	
	if( ! in_array( $post->post_type, array( 'difp_message', 'difp_announcement' ) ) ) {
        return;
    }
	
	_e('Can NOT be edited once published', 'ALSP');
}

	function save_message( $message_id, $message, $update ) {
			if ( ! is_admin() ) return; //only for BACK END . for FRONT END use 'difp_action_message_after_send' action hook
			if ( empty( $message_id ) || empty( $message ) || empty( $_POST ) ) return;
			if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
			if ( is_admin() && ( empty($_POST['difp_nonce']) || ! wp_verify_nonce( $_POST['difp_nonce'], 'difp_nonce' ) ) ) return;
			if ( wp_is_post_revision( $message ) ) return;
			if ( wp_is_post_autosave( $message ) ) return;
			//if ( ! current_user_can( 'edit_difp_messages' ) ) return;
			if ( ! current_user_can( 'edit_difp_message', $message_id ) && ! current_user_can( 'delete_difp_message', $message_id ) ) return;
			//if ( $message->post_type != 'difp_message' ) return;
			
			do_action( 'difp_save_message', $message_id, $message, $update );
		}
		
	function save_announcement( $announcement_id, $announcement, $update ) {
			if ( empty( $announcement_id ) || empty( $announcement ) || empty( $_POST ) ) return;
			if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
			if ( empty($_POST['difp_nonce']) || ! wp_verify_nonce( $_POST['difp_nonce'], 'difp_nonce' ) ) return;
			if ( wp_is_post_revision( $announcement ) ) return;
			if ( wp_is_post_autosave( $announcement ) ) return;
			//if ( ! current_user_can( 'edit_difp_announcements' ) ) return;
			if ( ! current_user_can( 'edit_difp_announcement', $announcement_id ) && ! current_user_can( 'delete_difp_announcement', $announcement_id ) ) return;
			//if ( $announcement->post_type != 'difp_announcement' ) return;
	
			do_action( 'difp_save_announcement', $announcement_id, $announcement, $update );
		}


function view_link($actions, $post)
{
    if ( $post->post_type=='difp_message' )
    {
		$actions['difp_view'] = '<a href="'.difp_query_url('viewmessage', array( 'difp_id' => $post->ID ) ).'" title="" target="_blank">' . __("View", "ALSP") . '</a>';
		$actions['difp_reply'] = '<a href="'.difp_query_url('viewmessage', array( 'difp_id' => $post->ID ) ).'#difp-reply-form" title="" target="_blank">' . __("Reply", "ALSP") . '</a>';

    } elseif( $post->post_type=='difp_announcement' ) {
		$actions['difp_view'] = '<a href="'.difp_query_url('view_announcement', array( 'difp_id' => $post->ID ) ).'" title="" target="_blank">' . __("View", "ALSP") . '</a>';
	}
    return $actions;
}

function columns_head($defaults) {
	$defaults['author'] = __('From', 'ALSP');
	$defaults['participants'] = __('To', 'ALSP');
    $defaults['parent'] = __('Parent', 'ALSP');
    return $defaults;
}
function columns_content($column_name, $post_ID) {
	global $post;
	
    if ($column_name == 'parent') {
        $parent = $post->post_parent;
		
		if( $parent ) {
			echo '<a href="'.difp_query_url('viewmessage', array( 'difp_id' => $parent ) ).'" title="" target="_blank">' . esc_attr( $parent ) . '</a>';
		} else {
			_e('No Parent', 'ALSP');
		}
    }
	if ($column_name == 'participants') {
        $participants = difp_get_participants( $post_ID );
		
		if( $participants ) {
			foreach( $participants as $participant ) {
			
				if( $participant != $post->post_author )
				echo '<a href="'. get_edit_user_link( $participant ) .'" target="_blank">'. esc_attr( difp_get_userdata( $participant, 'display_name', 'ID' ) ) .'</a><br />';
			}
		} else {
		_e('No Participants', 'ALSP');
		}
    }
}
function sortable_column( $columns ) {
    $columns['parent'] = 'parent';
 
    return $columns;
}
function sortable_orderby( $query ) {
    if( ! is_admin() || ! $query->is_main_query() || $query->get( 'post_type') != 'difp_message' )
        return;
 
    $orderby = $query->get( 'orderby');
 
    if( 'parent' == $orderby ) {
        //$query->set('meta_key','_difp_parent_id');
        //$query->set('orderby','meta_value_num');
		//$query->set('orderby','parent');
    }
}

function announcement_columns_head($defaults) {
	$defaults['to'] = __('To', 'ALSP');
	$defaults['read_count'] = __('Read Count', 'ALSP');
	$defaults['deleted_count'] = __('Deleted Count', 'ALSP');
    return $defaults;
}

function announcement_columns_content($column_name, $post_ID) {
	
	if ($column_name == 'to') {
		global $wp_roles;
		
       $roles = difp_get_participant_roles( $post_ID );
	
		if( $roles && is_array( $roles ) ) {
			foreach( $roles as $role ) {
				if( $wp_roles->is_role( $role ) )
				 echo translate_user_role( $wp_roles->roles[ $role ]['name'] ) .'<br />';
			}
		}
    }
    if ($column_name == 'read_count') {
       $read_by = get_post_meta( $post_ID, '_difp_read_by', true );
	
		if( ! is_array( $read_by ) ) {
			$read_by = array();
		}
		echo count( $read_by );
    }
	if ($column_name == 'deleted_count') {
       $deleted_by = get_post_meta( $post_ID, '_difp_deleted_by', true );
	
		if( ! is_array( $deleted_by ) ) {
			$deleted_by = array();
		}
		echo count( $deleted_by );
    }
	
}

/**
 * Redirect to the edit.php on post save or publish.
 */
function redirect_post_location( $location, $post_id ) {

    if ( isset( $_POST['save'] ) || isset( $_POST['publish'] ) ) {
		$post_type = get_post_type( $post_id );
		
		if ( 'difp_message' == $post_type )
        return admin_url( "edit.php?post_type=difp_message" );
		
		if ( 'difp_announcement' == $post_type )
        return admin_url( "edit.php?post_type=difp_announcement" );
    }

    return $location;
}
}

add_action('init', array( Difp_Cpt::init(), 'actions_filters'), 5);
