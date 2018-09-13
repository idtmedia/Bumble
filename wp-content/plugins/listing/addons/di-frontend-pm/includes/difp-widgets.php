<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DIFP_menu_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'difp_menu_widget', // Base ID
			__( 'DIFP Menu Widget', 'ALSP' ), // Name
			array( 'description' => __( 'DesignInvento Messaging System Menu Widget', 'ALSP' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		
		echo "<div id='difp-menu'>";
		do_action('difp_menu_button');
		echo "</div>";
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : __( 'DIFP Menu Widget', 'ALSP' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}

// register DIFP_menu_widget widget
function register_difp_menu_widget() {
if ( difp_current_user_can( 'access_message' ) )
    register_widget( 'DIFP_menu_widget' );
}
add_action( 'widgets_init', 'register_difp_menu_widget' );

class DIFP_text_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'difp_text_widget', // Base ID
			__( 'DIFP Text Widget', 'ALSP' ), // Name
			array( 'description' => __( 'DesignInvento Messaging System Text Widget', 'ALSP' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		global $user_ID;
		
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		$show_messagebox = isset( $instance['show_messagebox'] ) ? $instance['show_messagebox'] : false;
		$show_announcement = isset( $instance['show_announcement'] ) ? $instance['show_announcement'] : false;
		
			echo __('Welcome', 'ALSP') . ' ' . difp_get_userdata( $user_ID, 'display_name', 'id' ). '<br />';
			
			echo __('You have', 'ALSP');
		
		if ( $show_messagebox )
			{
				$unread_count = difp_get_new_message_number();
				$sm = sprintf(_n('%s unread message', '%s unread messages', $unread_count, 'ALSP'), number_format_i18n($unread_count) );
				echo "<a href='".difp_query_url('messagebox')."'> $sm</a>";
				
			}
		if ( $show_messagebox && $show_announcement )
				echo __(' and', 'ALSP');
				
		if ( $show_announcement )
			{
				$unread_ann_count = difp_get_user_announcement_count( 'unread' );
				$sa = sprintf(_n('%s unread announcement', '%s unread announcements', $unread_ann_count, 'ALSP'), number_format_i18n($unread_ann_count) );
				
				echo "<a href='".difp_query_url('announcements')."'> $sa</a>";
			}
	
			
		do_action('difp_text_widget');
		
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title =  isset( $instance['title'] ) ? $instance['title'] : __( 'DIFP Text Widget', 'ALSP' );
		$show_messagebox =  isset( $instance['show_messagebox'] ) ? $instance['show_messagebox'] : false;
		$show_announcement =  isset( $instance['show_announcement'] ) ? $instance['show_announcement'] : false;
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
    	<input class="checkbox" type="checkbox" <?php checked( $show_messagebox, 1 ); ?> id="<?php echo $this->get_field_id( 'show_messagebox' ); ?>" name="<?php echo $this->get_field_name( 'show_messagebox' ); ?>" value="1"/>
    	<label for="<?php echo $this->get_field_id( 'show_messagebox' ); ?>"><?php _e('Show Messagebox?', 'ALSP'); ?></label>
		</p>
		<p>
    	<input class="checkbox" type="checkbox" <?php checked( $show_announcement, 1 ); ?> id="<?php echo $this->get_field_id( 'show_announcement' ); ?>" name="<?php echo $this->get_field_name( 'show_announcement' ); ?>" value="1"/>
    	<label for="<?php echo $this->get_field_id( 'show_announcement' ); ?>"><?php _e('Show Announcement?', 'ALSP'); ?></label>
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['show_messagebox'] = ( ! empty( $new_instance['show_messagebox'] ) ) ? strip_tags( $new_instance['show_messagebox'] ) : '';
		$instance['show_announcement'] = ( ! empty( $new_instance['show_announcement'] ) ) ? strip_tags( $new_instance['show_announcement'] ) : '';

		return $instance;
	}

}

// register DIFP_menu_widget widget
function register_difp_text_widget() {
if ( difp_current_user_can( 'access_message' ) )
    register_widget( 'DIFP_text_widget' );
}
add_action( 'widgets_init', 'register_difp_text_widget' );


class DIFP_empty_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'difp_empty_widget', // Base ID
			__( 'DIFP Empty Widget', 'ALSP' ), // Name
			array( 'description' => __( 'DesignInvento Messaging System Empty Widget', 'ALSP' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		$show_help = isset( $instance['show_help'] ) ? $instance['show_help'] : false;
		
		if ( $show_help )
			{
				echo "Use <code>add_action('difp_empty_widget_{$this->number}', 'your_function' );</code> to hook to ONLY this widget where 'your_function' is your callback function.";
				echo "<br />Use <code>add_action('difp_empty_widget', 'your_function' );</code> to hook to all DIFP Empty widget where 'your_function' is your callback function";
			}
		
		do_action('difp_empty_widget_' . $this->number);
		do_action('difp_empty_widget');
		
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : __( 'DIFP Empty Widget', 'ALSP' );
		$show_help = isset( $instance['show_help'] ) ? $instance['show_help'] : false;
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		
		<p>
    	<input class="checkbox" type="checkbox" <?php checked( $show_help, 1 ); ?> id="<?php echo $this->get_field_id( 'show_help' ); ?>" name="<?php echo $this->get_field_name( 'show_help' ); ?>" value="1"/>
    	<label for="<?php echo $this->get_field_id( 'show_help' ); ?>"><?php _e('Display help to configure this widget in front end?', 'ALSP'); ?></label>
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['show_help'] = ( ! empty( $new_instance['show_help'] ) ) ? strip_tags( $new_instance['show_help'] ) : '';

		return $instance;
	}

}

// register DIFP_menu_widget widget
function register_difp_empty_widget() {
if ( difp_current_user_can( 'access_message' ) )
    register_widget( 'DIFP_empty_widget' );
}
add_action( 'widgets_init', 'register_difp_empty_widget' );

?>