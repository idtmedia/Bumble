<?php

class Classiadspro_WP_Nav_Menu_Widget extends WP_Widget {


	function __construct() {
		$widget_ops = array( 'classname' => 'widget_custom_menu', 'description' => 'Displays a custom menu.' );
		WP_Widget::__construct( 'custom_menu_widget', PACZ_THEME_SLUG.' - '.'Custom Menu', $widget_ops );


	}
 
   function widget($args, $instance) {
       extract( $args );
       
       $nav_menu = !empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;
       $align = isset( $instance['align'] ) ? $instance['align'] : '';
       $font_weight = isset( $instance['font_weight'] ) ? $instance['font_weight'] : '';
       $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
       $color = isset( $instance['color'] ) ? $instance['color'] : '';
       $hover_color = isset( $instance['hover_color'] ) ? $instance['hover_color'] : '';
       $uniqueID = 'custom-menu-'.uniqid();
		$output = '';
		
       if ( !$nav_menu )
           return;
 		$output = '';

    global $classiadspro_styles;
 		$classiadspro_styles .= '
					#'.$uniqueID.' a {';
					if ( !empty($color) ) {
		$classiadspro_styles .= 	'	color: '.$color.' !important;';
    $classiadspro_styles .=  ' font-weight: '.$font_weight.' !important;';
					}
		$classiadspro_styles .= '}';
		$classiadspro_styles .= '#'.$uniqueID.' a:hover { ';
					if ( !empty($hover_color) ) { 
		$classiadspro_styles .= '	color: '.$hover_color.' !important;';
					}
		$classiadspro_styles .= '}';
		

		echo $before_widget;
		
		echo '<div id="'.$uniqueID.'" class="pacz-custom-menu align-'.$align.'">';	
		if ( $title ){
			echo $before_title . $title . $after_title;
		}
		
		wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu ) );
		echo '</div>';
		echo $after_widget;
		
   }
 
   function update( $new_instance, $old_instance ) {
       $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
       $instance['nav_menu'] = (int) $new_instance['nav_menu'];
       $instance['font_weight'] = $new_instance['font_weight'];
       $instance['align'] = $new_instance['align'];
       $instance['color'] = $new_instance['color'];
       $instance['hover_color'] = $new_instance['hover_color'];
       return $instance;
   }
 
   function form( $instance ) {
       $title = isset( $instance['title'] ) ? $instance['title'] : '';
       $nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
       $font_weight = isset( $instance['font_weight'] ) ? $instance['font_weight'] : '';
       $align = isset( $instance['align'] ) ? $instance['align'] : '';
       $color = isset( $instance['color'] ) ? $instance['color'] : '';
       $hover_color = isset( $instance['hover_color'] ) ? $instance['hover_color'] : '';
 
       // Get menus
       $menus = wp_get_nav_menus( array( 'orderby' => 'name' ) );
 
       // If no menus exists, direct the user to go and create some.
       if ( !$menus ) {
           echo '<p>'. sprintf( esc_html__('No menus have been created yet.', 'classiadspro'), admin_url('nav-menus.php') ) .'</p>';
           return;
       }
       ?>
       
       <p>
           <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'classiadspro') ?></label>
           <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" />
       </p>
       <p>
           <label for="<?php echo esc_attr($this->get_field_id('nav_menu')); ?>"><?php esc_html_e('Select Menu:', 'classiadspro'); ?></label>
           <select id="<?php echo esc_attr($this->get_field_id('nav_menu')); ?>" name="<?php echo esc_attr($this->get_field_name('nav_menu')); ?>">
               <option value="0"><?php esc_html_e( '&mdash; Select &mdash;', 'classiadspro' ) ?></option>
       <?php
           foreach ( $menus as $menu ) {
               echo '<option value="' . $menu->term_id . '"'
                   . selected( $nav_menu, $menu->term_id, false )
                   . '>'. esc_html( $menu->name ) . '</option>';
           }
       ?>
           </select>
       </p>
       <p>
          <label for="<?php echo esc_attr($this->get_field_id( 'font_weight' )); ?>"><?php esc_html_e('Font Weight:', 'classiadspro'); ?></label>
          <select name="<?php echo esc_attr($this->get_field_name( 'font_weight' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'font_weight' )); ?>" class="widefat">
            <option value="inherit"<?php selected( $font_weight, 'inherit');?>>Default</option>
            <option value="300"<?php selected( $font_weight, '300');?>>Light</option>
            <option value="normal"<?php selected( $font_weight, 'normal');?>>Normal</option>
            <option value="bold"<?php selected( $font_weight, 'bold');?>>Bold</option>
            <option value="bolder"<?php selected( $font_weight, 'bolder');?>>Bolder</option>
            <option value="900"<?php selected( $font_weight, '900');?>>Extra Bold</option>
          </select>
        </p>
        <p>
    			<label for="<?php echo esc_attr($this->get_field_id( 'align' )); ?>"><?php esc_html_e('Align:', 'classiadspro'); ?></label>
    			<select name="<?php echo esc_attr($this->get_field_name( 'align' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'align' )); ?>" class="widefat">
    				<option value="left"<?php selected( $align, 'left');?>>Left</option>
    				<option value="center"<?php selected( $align, 'center');?>>Center</option>
    				<option value="right"<?php selected( $align, 'right');?>>Right</option>
    			</select>
  		  </p>
       	<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'color' )); ?>"><?php esc_html_e('Color:', 'classiadspro'); ?></label>
			<div class="color-picker-holder"><input data-default-color="<?php echo esc_attr($color); ?>" class="color-picker" id="<?php echo esc_attr($this->get_field_id( 'color' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'color' )); ?>" type="text" value="<?php echo esc_attr($color); ?>" /></div>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'hover_color' )); ?>"><?php esc_html_e('Hover Color:', 'classiadspro'); ?></label>
			<div class="color-picker-holder">
				<input data-default-color="<?php $hover_color; ?>" class="color-picker" id="<?php echo esc_attr($this->get_field_id( 'hover_color' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hover_color' )); ?>" type="text" value="<?php echo esc_attr($hover_color); ?>" /></div>
		</p>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				pacz_color_picker();
			});
		</script>
       <?php
   }
}