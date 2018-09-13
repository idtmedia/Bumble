<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

//Announcement CLASS
class Difp_Announcement
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
		add_action( 'transition_post_status', array($this, 'recalculate_user_stats'), 10, 3 );
		add_action( 'set_user_role', array($this, 'set_user_role'), 10, 3 );
    	}
	

function recalculate_user_stats( $new_status, $old_status, $post ){
	
	if ( 'difp_announcement' != $post->post_type || $old_status === $new_status ) {
		return;
	}
	
	if( 'publish' == $new_status || 'publish' == $old_status ){
		delete_metadata( 'user', 0, '_difp_user_announcement_count', '', true );
	}
}

function set_user_role( $user_id, $role, $old_roles ){
	
	delete_user_meta( $user_id, '_difp_user_announcement_count' );
}

function get_announcement( $id )
{
	$args = array(
		'post_type' => 'difp_announcement',
		'post_status' => 'publish',
		'post__in' => array( $id ),
	 );
	return new WP_Query( $args );
}

function get_user_announcements()
{

	$user_id = get_current_user_id();
	
	$filter = ! empty( $_GET['difp-filter'] ) ? $_GET['difp-filter'] : '';
	
		$args = array(
			'post_type' => 'difp_announcement',
			'post_status' => 'publish',
			'post_parent' => 0,
			'posts_per_page' => difp_get_option('announcements_page',15),
			'paged'	=> !empty($_GET['difppage']) ? absint($_GET['difppage']): 1,
			'meta_query' => array(
				array(
					'key' => '_difp_participant_roles',
					'value' => wp_get_current_user()->roles,
					'compare' => 'IN'
				)
				
			)
		 );
		$args['meta_query'][] = array(
			'relation' => 'OR',
				array(
					'key' => '_difp_deleted_by',
					//'value' => serialize($user_id),
					'compare' => 'NOT EXISTS'
				),
				array(
					'key' => '_difp_deleted_by',
					'value' => serialize($user_id),
					'compare' => 'NOT LIKE'
				),
		);
				
		 
		 if( ! $user_id )
			$args['post__in'] = array(0);
		 
		 switch( $filter ) {
		 	case 'after-i-registered' :
				$args['date_query'] = array( 'after' => difp_get_userdata( $user_id, 'user_registered', 'id' ) );
			break;
			case 'read' :
				$args['meta_query'][] = array(
					'key' => '_difp_read_by',
					'value' => serialize($user_id),
					'compare' => 'LIKE'
				);
			break;
			case 'unread' :
				$args['meta_query'][] = array(
					'relation' => 'OR',
						array(
							'key' => '_difp_read_by',
							//'value' => serialize($user_id),
							'compare' => 'NOT EXISTS'
						),
						array(
							'key' => '_difp_read_by',
							'value' => serialize($user_id),
							'compare' => 'NOT LIKE'
						),
				);
			break;
			default:
				$args = apply_filters( 'difp_announcement_query_args_'. $filter, $args);
			break;
		 }
		 $args = apply_filters( 'difp_announcement_query_args', $args);
		 
	return new WP_Query( $args );

}

function get_user_announcement_count( $value = 'all', $force = false, $user_id = false )
{
	if( ! $user_id ) {
		$user_id = get_current_user_id();
	}
	
	if( 'show-all' == $value )
		$value = 'total';
	
	if( ! $user_id ) {
		if( 'all' == $value ) {
			return array();
		} else {
			return 0;
		}
	}
	
	$user_meta = get_user_meta( $user_id, '_difp_user_announcement_count', true );
	
	if( false === $user_meta || $force || !isset( $user_meta['total'] ) || !isset( $user_meta['read'] )|| !isset( $user_meta['unread'] ) ) {
	
		$args = array(
			'post_type' => 'difp_announcement',
			'post_status' => 'publish',
			'post_parent' => 0,
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => '_difp_participant_roles',
					'value' => get_userdata( $user_id )->roles,
					'compare' => 'IN'
				)
				
			)
		 );
		 $args['meta_query'][] = array(
			'relation' => 'OR',
				array(
					'key' => '_difp_deleted_by',
					//'value' => serialize($user_id),
					'compare' => 'NOT EXISTS'
				),
				array(
					'key' => '_difp_deleted_by',
					'value' => serialize($user_id),
					'compare' => 'NOT LIKE'
				),
		);
		 $announcements = get_posts( $args );
		 
		 $total_count 		= 0;
		 $read_count 		= 0;
		 $unread_count 		= 0;
		 $after_i_registered_count = 0;
		 
		 if( $announcements && !is_wp_error($announcements) ) {
			 foreach( $announcements as $announcement ) {
		
			 	$total_count++;
				
			 	$read_by = get_post_meta( $announcement->ID, '_difp_read_by', true );
			
				if( is_array( $read_by ) && in_array( $user_id, $read_by ) ) {
					$read_count++;
				} else {
					$unread_count++;
				}
				$user_registered = strtotime(difp_get_userdata( $user_id, 'user_registered', 'id' ));
					
				if( $user_registered < strtotime( $announcement->post_date ) ) {
					$after_i_registered_count++;
				}
				
			 }
			}

		 
		 $user_meta = array(
			'total' => $total_count,
			'read' => $read_count,
			'unread' => $unread_count,
			'after-i-registered' => $after_i_registered_count
		);
		update_user_meta( $user_id, '_difp_user_announcement_count', $user_meta );
	}
	if( isset($user_meta[$value]) ) {
		return $user_meta[$value];
	}
	if( 'all' == $value ) {
		return $user_meta;
	} else {
		return 0;
	}

}

function bulk_action( $action, $ids = null ) {

	if( null === $ids ) {
		$ids = !empty($_POST['difp-message-cb'])? $_POST['difp-message-cb'] : array();
	}
	if( !$action || !$ids || !is_array($ids) ) {
		return '';
	}
	
	$count = 0;
	foreach( $ids as $id ) {
		if( $this->bulk_individual_action( $action, absint($id) ) ) {
			$count++;
		}
	}
	$message = '';
	
	if( $count ) {
		delete_user_meta( get_current_user_id(), '_difp_user_announcement_count' );
		
		if( 'delete' == $action ){
			$message = sprintf(_n('%s announcement', '%s announcements', $count, 'ALSP'), number_format_i18n($count) );
			$message .= ' ';
			$message .= __('successfully deleted.', 'ALSP');
		} 
		//$message = '<div class="difp-success">'.$message.'</div>';
	}
	return apply_filters( 'difp_bulk_action_message', $message, $count);
}

function bulk_individual_action( $action, $id ) {
	$return = false;
	
	switch( $action ) {
		case 'delete':
			if( difp_current_user_can( 'view_announcement', $id ) ) {
				$deleted = get_post_meta( $id, '_difp_deleted_by', true );
				if( ! is_array( $deleted ) )
					$deleted = array();
				
				if( empty( $deleted[ get_current_user_id() ] ) ) {
					$deleted[ get_current_user_id() ] = time();
					$return = update_post_meta( $id, '_difp_deleted_by', $deleted );
				}
			}

		break;
		default:
			$return = apply_filters( 'difp_announcement_bulk_individual_action', false, $action, $id );
		break;
	}
	return $return;
}

function get_table_bulk_actions()
{
	
	$actions = array(
			'delete' => __('Delete', 'ALSP')
			);

	
	return apply_filters('difp_announcement_table_bulk_actions', $actions );
}

function get_table_filters()
{
	$filters = array(
			'show-all' => __('Show all', 'ALSP'),
			'read' => __('Read', 'ALSP'),
			'unread' => __('Unread', 'ALSP'),
			'after-i-registered' => __('After i registered', 'ALSP')
			);
	return apply_filters('difp_announcementbox_table_filters', $filters );
}

function get_table_columns()
{
	$columns = array(
			'difp-cb' => __('Checkbox', 'ALSP'),
			'date' => __('Date', 'ALSP'),
			'title' => __('Title', 'ALSP')
			);
	return apply_filters('difp_announcement_table_columns', $columns );
}

function get_column_content($column)
{
	switch( $column ) {
		
		case has_action("difp_get_announcement_column_content_{$column}"):

			do_action("difp_get_announcement_column_content_{$column}");

		break;
		case 'difp-cb' :
			?><input type="checkbox" name="difp-message-cb[]" value="<?php echo get_the_ID(); ?>" /><?php
		break;
		case 'date' :
			?><span class="difp-message-date"><?php the_time(); ?></span><?php
		break;
		case 'title' :
			if( ! difp_is_read() ) {
					$span = '<span class="difp-unread-classp"><span class="difp-unread-class">' .__("Unread", "ALSP"). '</span></span>';
					$class = ' difp-strong';
				} else {
					$span = '';
					$class = '';
				} 
			?><span class="<?php echo $class; ?>"><a href="<?php echo difp_query_url('view_announcement', array('difp_id'=> get_the_ID())); ?>"><?php the_title(); ?></a></span><?php echo $span; ?><div class="difp-message-excerpt"><?php echo difp_get_the_excerpt(100); ?></div><?php
		break;
		default:
			do_action( 'difp_get_announcement_column_content', $column );
		break;
	}
}

	function announcement_box()
	{		
		  $g_filter = ! empty( $_GET['difp-filter'] ) ? $_GET['difp-filter'] : '';
		  
		  $total_announcements = $this->get_user_announcement_count('total');
		  
		  $announcements = $this->get_user_announcements();
		  
		  $template = difp_locate_template( 'announcement_box.php');
		  
		  ob_start();
		  include( $template );
		  return ob_get_clean();
	}

function view_announcement()
    {
      global $post;

	  if( isset( $_GET['difp_id'] ) ){
	  	$id = absint( $_GET['difp_id'] );
	  } else {
	  	$id = !empty($_GET['id']) ? absint($_GET['id']) : 0;
	  }
	  
	  if ( ! $id || ! difp_current_user_can( 'view_announcement', $id ) ) {
	  	return "<div class='difp-error'>".__("You do not have permission to view this announcement!", 'ALSP')."</div>";
	  }

      $announcement = $this->get_announcement( $id );

	  $template = difp_locate_template( 'view_announcement.php');
		  
		ob_start();
		include( $template );
		return ob_get_clean();
    }

	
	
  } //END CLASS

add_action('wp_loaded', array(Difp_Announcement::init(), 'actions_filters'));

