<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Difp_Attachment
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
	//add_action ('difp_display_after_parent_message', array($this, 'display_attachment'));
	add_action ('difp_display_after_message', array($this, 'display_attachment'));
	add_action ('difp_display_after_announcement', array($this, 'display_attachment'));
	add_action('template_redirect', array($this, 'download_file' ) );
	
	add_action ('before_delete_post', array($this, 'delete_attachments') );
	
	if ( '1' == difp_get_option('allow_attachment', 1)) {
		add_action ('difp_action_message_after_send', array($this, 'upload_attachment'), 10, 3 );
		}
    }
	
	
function upload_attachment( $message_id, $message, $inserted_message ) {
    if ( !isset( $_FILES['difp_upload'] ) ) {
        return false;
    }
	add_filter('upload_dir', array($this, 'upload_dir'));
	
    $fields = (int) difp_get_option('attachment_no', 4);

    for ($i = 0; $i < $fields; $i++) {
        $tmp_name = isset( $_FILES['difp_upload']['tmp_name'][$i] ) ? basename( $_FILES['difp_upload']['tmp_name'][$i] ) : '' ;

            if ( $tmp_name ) {
                $upload = array(
                    'name' => $_FILES['difp_upload']['name'][$i],
                    'type' => $_FILES['difp_upload']['type'][$i],
                    'tmp_name' => $_FILES['difp_upload']['tmp_name'][$i],
                    'error' => $_FILES['difp_upload']['error'][$i],
                    'size' => $_FILES['difp_upload']['size'][$i]
                );

                $this->upload_file( $upload, $message_id, $inserted_message );
            }//file exists
        }// end for
		
	remove_filter('upload_dir', array($this, 'upload_dir'));
}

	function upload_dir($upload) {
	/* Append year/month folders if that option is set */
		$subdir = '';
        if ( get_option( 'uploads_use_yearmonth_folders' ) ) {
                $time = current_time( 'mysql' );

            $y = substr( $time, 0, 4 );
            $m = substr( $time, 5, 2 );

            $subdir = "/$y/$m";    
        }
	$upload['subdir']	= '/di-frontend-pm' . $subdir;
	$upload['path']		= $upload['basedir'] . $upload['subdir'];
	$upload['url']		= $upload['baseurl'] . $upload['subdir'];
	return $upload;
	}

/**
 * Generic function to upload a file
 *
 * @since 3.3
 * @param array $upload_data
 * @param int $message_id
 * @return bool
 */
function upload_file( $upload_data, $message_id, $inserted_message ) {

	if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
	
    $movefile = wp_handle_upload( $upload_data, array('test_form' => false) );

    if ($message_id && $movefile['type']&& $movefile['url'] && $movefile['file']) {
		
		// Prepare an array of post data for the attachment.
		$attachment = array(
			'guid'           => $movefile['url'], 
			'post_mime_type' => $movefile['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $movefile['url'] ) ),
			'post_content'   => '',
			'post_author'	=> $inserted_message->post_author,
			'post_status'    => 'inherit'
		);
		
		// Insert the attachment.
		$attach_id = wp_insert_attachment( $attachment, $movefile['file'], $message_id );
		
		if ( $attach_id )
        return true;
    }

    return false;
}

	function display_attachment() {
	
	$attachment_ids = difp_get_attachments( get_the_ID(), 'ids');
	
	if ( $attachment_ids ) {
		  echo "<hr /><strong>" . __("Attachments", 'ALSP') . ":</strong><br />";
		  foreach ( $attachment_ids as $attachment_id ){
		  
			$name = esc_html( basename(wp_get_attachment_url( $attachment_id )) );
		
			echo "<a href='".difp_query_url('download', array( 'difp_id' => $attachment_id, 'token' => wp_create_nonce('download_' . $attachment_id ) ))."' title='". sprintf(__( 'Download %s', 'ALSP'), $name ) . "'>{$name}</a><br />";
				} 
			}
		}

	function download_file(){
	
		if ( empty($_GET['difpaction']) || $_GET['difpaction'] != 'download' )
			return;
		
		if( isset( $_GET['difp_id'] ) ){
			$id = absint( $_GET['difp_id'] );
		} else {
			$id = !empty($_GET['id']) ? absint($_GET['id']) : 0;
		}

		$token = ! empty( $_GET['token'] ) ? $_GET['token'] : '';
	
		if ( ! $id || ! wp_verify_nonce( $token, 'download_' . $id ) )
		wp_die(__('Invalid token', 'ALSP'));
		
		if ( !difp_current_user_can( 'access_message' ) )
		wp_die(__('No attachments found', 'ALSP'));
	
		if ( 'attachment' != get_post_type( $id ) || 'publish' != get_post_status ( $id ) )
		wp_die(__('No attachments found', 'ALSP'));
	
		if( 'threaded' == difp_get_message_view() ) {
			$message_id = difp_get_parent_id($id);
		} else {
			$message_id = wp_get_post_parent_id($id);
		}
		$post_type = get_post_type($message_id);
		
		if( ! in_array( $post_type, array( 'difp_message', 'difp_announcement' ) ) ) {
			wp_die(__('You have no permission to download this attachment.', 'ALSP'));
		} elseif( 'difp_message' == $post_type && ! difp_current_user_can('view_message', $message_id ) ) {
			wp_die(__('You have no permission to download this attachment.', 'ALSP'));
		} elseif( 'difp_announcement' == $post_type && ! difp_current_user_can('view_announcement', $message_id ) ) {
			wp_die(__('You have no permission to download this attachment.', 'ALSP'));
		}
			  
	
			$attachment_type = get_post_mime_type( $id );
			$attachment_url = wp_get_attachment_url( $id );
			$attachment_path = get_attached_file( $id );
			$attachment_name = basename($attachment_url);
	
		if( !file_exists($attachment_path) ){
			wp_delete_attachment( $id );
			wp_die(__('Attachment already deleted', 'ALSP'));
		}
		
		
			header("Content-Description: File Transfer");
			header("Content-Transfer-Encoding: binary");
			header("Content-Type: $attachment_type", true, 200);
			header("Content-Disposition: attachment; filename=\"$attachment_name\"");
			header("Content-Length: " . filesize($attachment_path));
			nocache_headers();
			
			//clean all levels of output buffering
			while (ob_get_level()) {
				ob_end_clean();
			}
			
			readfile($attachment_path);
			
				exit;
		}
		
	
	function delete_attachments( $message_id ) {

		if( ! in_array( get_post_type( $message_id ), array( 'difp_message', 'difp_announcement' ) ) )
			return false;
		
		$attachment_ids = difp_get_attachments( $message_id, 'ids' );
			
		if ( $attachment_ids ) {
		  foreach ( $attachment_ids as $attachment_id ){
			wp_delete_attachment( $attachment_id ); 
		
			} 
		}
   }

	
	
	
  } //END CLASS

add_action('wp_loaded', array(Difp_Attachment::init(), 'actions_filters'));

