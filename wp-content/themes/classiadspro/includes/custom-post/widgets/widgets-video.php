<?php

/*
	VIDEO WIDGET
*/

class Classiadspro_Widget_Video extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_video', 'description' => 'You can add youtube and Vimeo' );
		WP_Widget::__construct( 'video', PACZ_THEME_SLUG.' - '.'Video', $widget_ops );


	}



	function widget( $args, $instance ) {
		extract( $args );
		$title = $instance['title'];
		$type= $instance['type'];
		$clip_id= $instance['clip_id'];
		$video_title= $instance['video_title'];
		$video_desc= $instance['video_desc'];
		$width= 400;
		$output = '';

		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;



		if ( !empty( $clip_id ) ) {
			$height = intval( $width * 9 / 16 );

			$output .= '<div class="pacz-frame">';

			$output .= '<i class="blog-post-type-icon pacz-nuance-icon-video"></i>';

			// Vimeo Video post type
			if ( $type =='vimeo' ) {
				//$output .= '<div class="pacz-video-container"><iframe src="http://player.vimeo.com/video/'.$clip_id.'?title=0&amp;byline=0&amp;portrait=0&amp;color=00c65d" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
			}

			// Youtube Video post type
			if ( $type =='youtube' ) {
				$height = intval( $width * 9 / 16 ) + 25;
				//$output .= '<div class="pacz-video-container"><iframe src="http://www.youtube.com/embed/'.$clip_id.'?showinfo=0&theme=light&color=white&autohide=1" frameborder="0" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
			}

			// dailymotion Video post type
			if ( $type =='dailymotion' ) {

				//$output .= '<div class="pacz-video-container"><iframe frameborder="0" width="'.$width.'" height="'.$height.'" src="http://www.dailymotion.com/embed/video/'.$clip_id.'?foreground=%2300c65d&highlight=%23ffffff&background=%23000000&logo=0"></iframe></div>';
			}

			// bliptv Video post type
			if ( $type =='bliptv' ) {
				//$output .= '<div class="pacz-video-container"><iframe src="http://blip.tv/play/'.$clip_id.'.x?p=1" width="'.$width.'" height="'.$height.'" frameborder="0" allowfullscreen></iframe><embed type="application/x-shockwave-flash" src="http://a.blip.tv/api.swf#'.$clip_id.'" style="display:none"></embed></div>';
			}


			// viddler Video post type
			if ( $type =='viddler' ) {
				//$output .= '<div class="pacz-video-container"><iframe id="viddler-bdce8c7" src="//www.viddler.com/embed/'.$clip_id.'/?f=1&offset=0&autoplay=0&secret=18897048&disablebranding=0&view_secret=18897048" width="'.$width.'" height="'.$height.'" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true" scrolling="no" style="overflow:hidden !important;"></iframe></div>';
			}

			if(!empty($video_title)) {
				$output .= '<h5 class="video-title">'.$video_title.'</h5>';
			}
			if(!empty($video_desc)) {
				$output .= '<p class="video-desc">'.$video_desc.'</p>';
			}	
			$output .= '</div>';

		}




		$output .= $after_widget;
echo '<div>'.$output.'</div>';
	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['type'] = strip_tags( $new_instance['type'] );
		$instance['clip_id'] = $new_instance['clip_id'];
		$instance['video_title'] = $new_instance['video_title'];
		$instance['video_desc'] = $new_instance['video_desc'];

		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$type = isset( $instance['type'] ) ? $instance['type'] : 'youtube';
		$clip_id = isset( $instance['clip_id'] ) ? $instance['clip_id'] : '';
		$video_desc = isset( $instance['video_desc'] ) ? $instance['video_desc'] : '';
		$video_title = isset( $instance['video_title'] ) ? $instance['video_title'] : '';
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">Title:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

     	<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'type' )); ?>">Type:</label>
			<select name="<?php echo esc_attr($this->get_field_name( 'type' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'type' )); ?>" class="widefat">
            	<option value="youtube"<?php selected( $type, 'youtube' );?>>Youtube</option>
				<option value="vimeo"<?php selected( $type, 'vimeo' );?>>Vimeo</option>
				<option value="dailymotion"<?php selected( $type, 'dailymotion' );?>>dailymotion</option>
				<option value="bliptv"<?php selected( $type, 'bliptv' );?>>bliptv</option>
				<option value="viddler"<?php selected( $type, 'viddler' );?>>viddler</option>

			</select>
		</p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'clip_id' )); ?>">Clip ID:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'clip_id' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'clip_id' )); ?>" type="text" value="<?php echo esc_attr($clip_id); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'video_title' )); ?>">Video Title:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'video_title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'video_title' )); ?>" type="text" value="<?php echo esc_attr($video_title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'video_desc' )); ?>">Video Description:</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'video_desc' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'video_desc' )); ?>" type="text" value="<?php echo esc_attr($video_desc); ?>" /></p>
<?php

	}
}
/***************************************************/
