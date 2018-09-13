<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


if ( ! difp_current_user_can( 'send_new_message_to', $to ) ) {
	echo "<div class='difp-error'>".__("You do not have permission to send message to this receiver!", 'ALSP')."</div>";
} elseif( isset($_POST['difp_action']) && 'shortcode-newbidding' == $_POST['difp_action'] ) {
	if( difp_errors()->get_error_messages() ) {
		echo Difp_Form::init()->form_field_output( 'shortcode-newbidding', difp_errors(), array( 'message_to' => $to ) );
	} else {
		echo difp_info_output();
	}
} else {
	echo Difp_Form::init()->form_field_output( 'shortcode-newbidding', '', array( 'message_to' => $to, 'message_title' => $subject, 'message_post_id' => $listing_id, 'message_bid' => $listing_bid ) );
}

if( ! empty( $enable_ajax )){
	echo '<div class="difp-ajax-response"></div>';
}

