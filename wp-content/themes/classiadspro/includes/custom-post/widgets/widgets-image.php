<?php

/*
	VIDEO WIDGET
*/

class Classiadspro_Widget_Image extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_image', 'description' => 'You can add custom image ad' );
		WP_Widget::__construct( 'image', PACZ_THEME_SLUG.' - '.'image', $widget_ops );


	}



	function widget( $args, $instance ) {
		extract( $args );
		$title = $instance['title'];
		$image_url= $instance['image_url'];
		$target_url= $instance['target_url'];
		$image_title= $instance['image_title'];
		$image_alt= $instance['image_alt'];
		$dimension = $instance['image_width'];
		$dimensionh = $instance['image_height'];
		$output = '';

		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";   
		$image_src_array = $image_url;
        $image_src       = bfi_thumb($image_url, array(
            'width' => $dimension,
            'height' => $dimensionh,
            'crop' => true
        ));

		if ( !empty( $image_url ) ) {
			

			$output .= '<div class="pacz-custom-image">';

			$output .= '<a href="'.$target_url.'" target="_blank"><img class="sidebar-widget-image" src="'. pacz_thumbnail_image_gen($image_src, $dimension, $dimensionh) . '" alt="'.$image_alt.'" title="'.$image_title.'"/></a>';
			$output .= '</div>';

		}




		$output .= $after_widget;
echo '<div>'.$output.'</div>';
	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['image_url'] = $new_instance['image_url'];
		$instance['target_url'] = $new_instance['target_url'];
		$instance['image_title'] = $new_instance['image_title'];
		$instance['image_alt'] = $new_instance['image_alt'];
		$instance['image_width'] = $new_instance['image_width'];
		$instance['image_height'] = $new_instance['image_height'];

		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$image_url = isset( $instance['image_url'] ) ? $instance['image_url'] : '';
		$target_url = isset( $instance['target_url'] ) ? $instance['target_url'] : '';
		$image_alt = isset( $instance['image_alt'] ) ? $instance['image_alt'] : '';
		$image_title = isset( $instance['image_title'] ) ? $instance['image_title'] : '';
		$dimension = isset( $instance['image_width'] ) ? $instance['image_width'] : '';
		$dimensionh = isset( $instance['image_height'] ) ? $instance['image_height'] : '';
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">Title:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>


		<p><label for="<?php echo esc_attr($this->get_field_id( 'target_url' )); ?>">Target url:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'target_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'target_url' )); ?>" type="text" value="<?php echo esc_attr($target_url); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'image_url' )); ?>">Image url:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'image_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'image_url' )); ?>" type="text" value="<?php echo esc_attr($image_url); ?>" /></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'image_title' )); ?>">Image Title:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'image_title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'image_title' )); ?>" type="text" value="<?php echo esc_attr($image_title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'image_alt' )); ?>">Image Alt:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'image_alt' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'image_alt' )); ?>" type="text" value="<?php echo esc_attr($image_alt); ?>" /></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'image_width' )); ?>">Image Width:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'image_width' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'image_width' )); ?>" type="text" value="<?php echo esc_attr($dimension); ?>" /></p>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'image_height' )); ?>">Image height:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'image_height' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'image_height' )); ?>" type="text" value="<?php echo esc_attr($dimensionh); ?>" /></p>
<?php

	}
}
/***************************************************/
