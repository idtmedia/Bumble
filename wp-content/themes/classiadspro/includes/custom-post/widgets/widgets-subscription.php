<?php

/*
	Subscription Form
*/

class Classiadspro_Widget_Subscription_Form extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_subscription_form', 'description' => 'Subscription form.' );
		WP_Widget::__construct( 'subscription_form', PACZ_THEME_SLUG.' - '.'Subscription Form', $widget_ops );
	}



	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$form_id = $instance['form_id'];

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;
		?>
	<?php if(isset($form_id) && !empty($form_id)){ ?>
	<div class="classiadspro-subscription-form-wrapper <?php echo $skin; ?>-skin">
        <div class="classiadspro-form-row clearfix">
			<?php echo do_shortcode('[dhvc_form id="'.$form_id.'"]'); ?>
        </div>
	</div>
	<?php } ?>
<?php
		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['form_id'] = $new_instance['form_id'];
		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$form_id = isset( $instance['form_id'] ) ? $instance['form_id'] : '';
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id( 'form_id' ); ?>">DHVC Form ID</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'form_id' ); ?>" name="<?php echo $this->get_field_name( 'form_id' ); ?>" type="text" value="<?php echo $form_id; ?>" /></p>

<?php

	}

}
/***************************************************/