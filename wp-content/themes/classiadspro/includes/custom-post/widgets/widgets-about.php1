<?php

/*
	VIDEO WIDGET
*/

class Classiadspro_Widget_About extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_about', 'description' => 'About us Widget' );
		WP_Widget::__construct( 'about', PACZ_THEME_SLUG.' - '.'about', $widget_ops );


	}



	function widget( $args, $instance ) {
		extract( $args );
		
		$title = $instance['title'];
		$logo_image= $instance['logo_image'];
		$content = $instance['_content'];
		$phone_number = $instance['phone_number'];
		$email_id = $instance['email_id'];
		$readmore = $instance['readmore_url'];
		$logo = $instance['logo'];
		//$logo = isset( $instance['logo'] ) ? $instance['logo'] : '';
		
		//$dimension = $instance['image_width'];
		//$dimensionh = $instance['image_height'];
		$output = '';

		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		//require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";   
		//$image_src_array = $logo_image;
       // $image_src       = bfi_thumb($image_url, array(
         //   'width' => $dimension,
         //   'height' => $dimensionh,
         //   'crop' => true
       // ));

		
			

			$output .= '<div class="pacz-about-us">';
			if($logo == 'top' && !empty($logo_image)){
			$output .= '<a style="margin-bottom:20px;display:block;" href="'.get_home_url().'" ><img class="sidebar-widget-about" src="'.$logo_image.'" alt="'.get_bloginfo( 'name' ).'" title="'.get_bloginfo( 'name' ).'"/></a>';
			}
			if(!empty($content)){
			$output .= '<p class="about-content">'.$content.'</p>';
			}
			if($logo == 'bottom' && !empty($logo_image)){
			$output .= '<a href="'.get_home_url().'" ><img class="sidebar-widget-about" src="'.$logo_image.'" alt="'.get_bloginfo( 'name' ).'" title="'.get_bloginfo( 'name' ).'"/></a>';
			}
			$output .= '</div>';
			if(!empty($readmore)){
			$output .= '<a class="about-readmore" href="'.$readmore.'" target="_blank">read more</a>';
			}
			$output .= '<div class="about-social">';
			if(!empty($phone_number)){
			$output .= '<p class="phone-number"><i class="pacz-icon-phone"></i>'.$phone_number.'</p>';
			}
			if(!empty($email_id)){
			$output .= '<p class="email-id"><i class="pacz-icon-envelope-o"></i>'.$email_id.'</p>';
			}
			$output .= '</div>';

		




		$output .= $after_widget;
echo '<div>'.$output.'</div>';
	}


	function update( $new_instance, $old_instance ) {
		//$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['logo_image'] = $new_instance['logo_image'];
		$instance['_content'] = $new_instance['_content'];
		$instance['phone_number'] = $new_instance['phone_number'];
		$instance['email_id'] = $new_instance['email_id'];
		$instance['readmore_url'] = $new_instance['readmore_url'];
		$instance['logo'] = $new_instance['logo'];

		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$logo_image = isset( $instance['logo_image'] ) ? $instance['logo_image'] : '';
		$content = isset( $instance['_content'] ) ? $instance['_content'] : '';
		$phone_number = isset( $instance['phone_number'] ) ? $instance['phone_number'] : '';
		$email_id = isset( $instance['email_id'] ) ? $instance['email_id'] : '';
		$readmore_url = isset( $instance['readmore_url'] ) ? $instance['readmore_url'] : 'top';
		$logo = isset( $instance['logo'] ) ? $instance['logo'] : '';
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">Title:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'logo_image' )); ?>">Image logo:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'logo_image' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'logo_image' )); ?>" type="text" value="<?php echo esc_attr($logo_image); ?>" /></p>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'logo' )); ?>">Logo Postion: options(top, bottom)</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'logo' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'logo' )); ?>" type="text" value="<?php echo esc_attr($logo); ?>" /></p>
		<p>
		<p><label for="<?php echo esc_attr($this->get_field_id( '_content' )); ?>">About Content:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( '_content' )); ?>" name="<?php echo esc_attr($this->get_field_name( '_content' )); ?>" type="text" value="<?php echo esc_attr($content); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'phone_number' )); ?>">Phone Number:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'phone_number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'phone_number' )); ?>" type="text" value="<?php echo esc_attr($phone_number); ?>" /></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'email_id' )); ?>">Email id:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'email_id' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'email_id' )); ?>" type="text" value="<?php echo esc_attr($email_id); ?>" /></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'readmore_url' )); ?>">Read More url:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'image_width' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'readmore_url' )); ?>" type="text" value="<?php echo esc_attr($readmore_url); ?>" /></p>

<?php

	}
}
/***************************************************/
