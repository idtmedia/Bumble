<?php

/*
	INSTAGRAM WIDGET
*/
class Classiadspro_Widget_Instagram_Feeds extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_instagram', 'description' => 'Displays photos from Instagram' );
		WP_Widget::__construct( 'instagram', PACZ_THEME_SLUG.' - '.'Instagram', $widget_ops );

	}



	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$instagram_id = $instance['instagram_id'];
		$accessToken = $instance['accessToken'];
		$sort_by = $instance['sort_by'];
		$size = $instance['size'];
		$accessToken = $instance['accessToken'];
		$count = (int)$instance['count'];
		$column = $instance['column'];
		$display = empty( $instance['display'] ) ? 'latest' : $instance['display'];
		$output = '';
		
		if ( $count < 1 ) {
			$count = 1;
		}

		wp_enqueue_script( 'instafeed' );

		if ( !empty( $instagram_id ) ) {
			$output .= $before_widget;
			if ( $title )
				$output .= $before_title . $title . $after_title;

			$id = mt_rand( 99, 999 );
		
		
			$output .= '<div id="instagram-feeds-'.$id.'" class="pacz-instagram-feeds" data-size="'.$size.'" data-sort="'.$sort_by.'" data-count="'.$count.'" data-userid="'.$instagram_id.'" data-accesstoken="'.$accessToken.'" data-column="'.$column.'"></div>';
		
			$output .= $after_widget;
		}
		echo '<div>'.$output.'</div>';
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['instagram_id'] = strip_tags( $new_instance['instagram_id'] );
		$instance['count'] = (int) $new_instance['count'];
		$instance['column'] = $new_instance['column'];
		$instance['accessToken'] = $new_instance['accessToken'];
		$instance['size'] = $new_instance['size'];
		$instance['sort_by'] = $new_instance['sort_by'];
		$instance['display'] = strip_tags( $new_instance['display'] );

		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$instagram_id = isset( $instance['instagram_id'] ) ? esc_attr( $instance['instagram_id'] ) : '';
		$size = isset( $instance['size'] ) ? esc_attr( $instance['size'] ) : 'thumbnail';
		$sort_by = isset( $instance['sort_by'] ) ? esc_attr( $instance['sort_by'] ) : 'most-recent';
		$accessToken = isset( $instance['accessToken'] ) ? esc_attr( $instance['accessToken'] ) : '';
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 10;
		$column = isset( $instance['column'] ) ? $instance['column'] : 'four';
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">Title :</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'instagram_id' )); ?>">Instagram User id</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'instagram_id' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'instagram_id' )); ?>" type="text" value="<?php echo esc_attr($instagram_id); ?>" />
		</p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'accessToken' )); ?>">Access Token</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'accessToken' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'accessToken' )); ?>" type="text" value="<?php echo esc_attr($accessToken); ?>" />
		</p>


		<p><label for="<?php echo esc_attr($this->get_field_id( 'count' )); ?>">Number of photos to show :</label>
		<input id="<?php echo esc_attr($this->get_field_id( 'count' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'count' )); ?>" type="text" value="<?php echo esc_attr($count); ?>" size="3" /></p>


		<p><label for="<?php echo esc_attr($this->get_field_id( 'sort_by' )); ?>">Sort by:</label>
		<select id="<?php echo esc_attr($this->get_field_id( 'sort_by' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'sort_by' )); ?>" class="widefat">
			<option<?php if ( $sort_by == 'most-recent' ) echo ' selected="selected"'?> value="most-recent">Most Recent</option>
			<option<?php if ( $sort_by == 'least-recent' ) echo ' selected="selected"'?> value="least-recent">Least Recent</option>
			<option<?php if ( $sort_by == 'most-liked' ) echo ' selected="selected"'?> value="most-liked">Most Liked</option>
			<option<?php if ( $sort_by == 'least-liked' ) echo ' selected="selected"'?> value="least-liked">Least Liked</option>
			<option<?php if ( $sort_by == 'most-commented' ) echo ' selected="selected"'?> value="most-commented">Most Commented</option>
			<option<?php if ( $sort_by == 'least-commented' ) echo ' selected="selected"'?> value="least-commented">Least-commented</option>
			<option<?php if ( $sort_by == 'random' ) echo ' selected="selected"'?> value="random">Random</option>
		</select>
		</p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'size' )); ?>">Image Size:</label>
		<select id="<?php echo esc_attr($this->get_field_id( 'size' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'size' )); ?>" class="widefat">
			<option<?php if ( $size == 'thumbnail' ) echo ' selected="selected"'?> value="thumbnail">Thumbnail (150X150)</option>
			<option<?php if ( $size == 'low_resolution' ) echo ' selected="selected"'?> value="low_resolution">Low Resolution (306X306)</option>
			<option<?php if ( $size == 'standard_resolution' ) echo ' selected="selected"'?> value="standard_resolution">Standard Resolution (612X612)</option>
		</select>
		</p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'column' )); ?>">How many Images in One Row:</label>
		<select id="<?php echo esc_attr($this->get_field_id( 'column' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'column' )); ?>" class="widefat">
			<option<?php if ( $column == 'one' ) echo ' selected="selected"'?> value="one">1</option>
			<option<?php if ( $column == 'two' ) echo ' selected="selected"'?> value="two">2</option>
			<option<?php if ( $column == 'three' ) echo ' selected="selected"'?> value="three">3</option>
			<option<?php if ( $column == 'four' ) echo ' selected="selected"'?> value="four">4</option>
			<option<?php if ( $column == 'five' ) echo ' selected="selected"'?> value="five">5</option>
			
		</select>
		</p>

		<p><em>Don't know your user id or token? <a href="https://instagram.com/oauth/authorize/?client_id=467ede5a6b9b48ae8e03f4e2582aeeb3&redirect_uri=http://instafeedjs.com&response_type=token">Click here</a> to get one.</em></p>

<?php
	}
}
/***************************************************/
