<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

echo '<div id="difp-reply-form">';

if ( ! difp_current_user_can( 'send_reply', $parent_id ) ) {
	echo "<div class='difp-error'>".__("You do not have permission to send reply to this message!", 'ALSP')."</div>";
} elseif( isset($_POST['difp_action']) && 'reply' == $_POST['difp_action'] ) {
	if( difp_errors()->get_error_messages() ) {
		echo Difp_Form::init()->form_field_output('reply', difp_errors(), array( 'difp_parent_id' => $parent_id ));
	} else {
		echo difp_info_output();
		
		if( 'threaded' == difp_get_message_view() ){
			unset( $_REQUEST['message_content'] ); //hack to empty message content
			echo Difp_Form::init()->form_field_output('reply', '', array( 'difp_parent_id' => $parent_id ));
		}
	}
} else {
	echo Difp_Form::init()->form_field_output('reply', '', array( 'difp_parent_id' => $parent_id ));
}

echo '</div>';
