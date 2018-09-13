<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<h2><?php _e("Set your preferences below", 'ALSP'); ?></h2>

<?php echo difp_info_output(); ?>

<?php echo Difp_Form::init()->form_field_output( 'settings'); ?>