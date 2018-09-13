<?php

class Artbees_Widget_Sub_Navigation extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget-sub-navigation', 'description' => 'Displays a list of Sub Pages' );
		WP_Widget::__construct( 'subnav', THEME_SLUG.' - '. 'Sub Navigation', $widget_ops );
	}

	function widget( $args, $instance ) {
		global $post;
		$children=wp_list_pages( 'echo=0&child_of=' . $post->ID . '&title_li=' );
		if ( $children ) {
			$parent = $post->ID;
		}else {
			$parent = $post->post_parent;
			if ( !$parent ) {
				$parent = $post->ID;
			}
		}
		$parent_title = get_the_title( $parent );

		extract( $args );
		$title = $instance['title'];
		$sortby = empty( $instance['sortby'] ) ? 'menu_order' : $instance['sortby'];
		$exclude = $instance['exclude'];

		$output = wp_list_pages( array( 'title_li' => '', 'echo' => 0, 'child_of' =>$parent, 'sort_column' => $sortby, 'exclude' => $exclude, 'depth' => 2 ) );

		if ( !empty( $output ) ) {
			echo $before_widget;
			if ( $title )
				echo $before_title . $title . $after_title;
?>
		<ul>
			<?php echo $output; ?>
		</ul>
		<?php
			echo $after_widget;
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		if ( in_array( $new_instance['sortby'], array( 'post_title', 'menu_order', 'ID' ) ) ) {
			$instance['sortby'] = $new_instance['sortby'];
		} else {
			$instance['sortby'] = 'menu_order';
		}

		$instance['exclude'] = strip_tags( $new_instance['exclude'] );

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'sortby' => 'menu_order', 'title' => '', 'exclude' => '' ) );
		$title = esc_attr( $instance['title'] );
		$exclude = esc_attr( $instance['exclude'] );
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'mk_framework'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>







        <p>
			<label for="<?php echo $this->get_field_id( 'sortby' ); ?>"><?php _e('Sort by:', 'mk_framework'); ?></label>
			<select name="<?php echo $this->get_field_name( 'sortby' ); ?>" id="<?php echo $this->get_field_id( 'sortby' ); ?>" class="widefat">
				<option value="menu_order"<?php selected( $instance['sortby'], 'menu_order' ); ?>><?php _e('', 'mk_framework'); ?><?php _e('Page order', 'mk_framework'); ?></option>
				<option value="post_title"<?php selected( $instance['sortby'], 'post_title' ); ?>><?php _e('', 'mk_framework'); ?><?php _e('Page title', 'mk_framework'); ?></option>
				<option value="ID"<?php selected( $instance['sortby'], 'ID' ); ?>><?php _e('', 'mk_framework'); ?><?php _e('Page ID', 'mk_framework'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude' ); ?>"><?php _e('Exclude:', 'mk_framework'); ?></label> <input type="text" value="<?php echo $exclude; ?>" name="<?php echo $this->get_field_name( 'exclude' ); ?>" id="<?php echo $this->get_field_id( 'exclude' ); ?>" class="widefat" />
			<br />
			<small><?php _e('Page IDs, Separate with a comma (eg: 12,34,543,98)', 'mk_framework'); ?></small>
		</p>
<?php
	}

}

register_widget("Artbees_Widget_Sub_Navigation");