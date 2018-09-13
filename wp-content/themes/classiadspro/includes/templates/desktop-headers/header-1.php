

<?php
global $pacz_settings;
 $post_id = global_get_post_id();
 $preset_header_style = $pacz_settings['preset_header_style'];
 $preset_headers = $pacz_settings['preset_headers'];
 
 /* preset values */
 
	$header_structure = 'standard';
	$header_align = 'left';
	$header_grid = 'false';
	$sticky_header = 0;
	$squeeze_sticky_header = 0;
	
	$boxed_layout = $pacz_settings['body-layout'];
	$header_style = $trans_header_skin = $header_padding_class = $header_grid_margin = $trans_header_skin_class = $pacz_main_wrapper_class = '';
	
	$toolbar = 0;
	$toolbar_check = get_post_meta( $post_id, '_header_toolbar', true );
	$toolbar_option = !empty($toolbar_check) ? $toolbar_check : 'true';
	$header_toolbar_grid = 0;
	$pacz_logo_location = 'header_section';
	$pacz_logo_align = 'left' ;
	
	$header_toolbar_social_location = 'disabled'; 
	$header_toolbar_social_align = 'right';
	$listing_btn_location = 'header_section';
	$listing_btn_align = 'right';

	$login_reg_btn_location = 'disabled';
	$login_reg_btn_align =  'right';
	
	$header_contact_details_location = 'disabled' ;
	$header_contact_details_align = 'left' ;
	
	$boxed_header = 1;
	
 
 ?>


<header id="pacz-header" class="<?php echo esc_attr($header_class); ?> <?php echo esc_attr($header_grid); ?> <?php echo esc_attr($header_grid_margin); ?> theme-main-header pacz-header-module" data-header-style="<?php echo esc_attr($header_style); ?>" data-header-structure="<?php echo esc_attr($header_structure); ?>" data-transparent-skin="<?php echo esc_attr($trans_header_skin); ?>" data-height="<?php echo intval($header_height); ?>" data-sticky-height="<?php echo intval($header_sticky_height); ?>">
<?php

	echo '<div class="pacz-header-mainnavbar">';
		echo '<div class="pacz-grid clearfix">';
			if(is_user_logged_in() && !empty($pacz_settings['loggedin_menu'])) {
				$pacz_menu_location = get_post_meta( $post_id, '_menu_location', true ) ? get_post_meta( $post_id, '_menu_location', true ) : $pacz_settings['loggedin_menu'];
			}else{
				$pacz_menu_location = 'primary-menu';
			}
			do_action( 'main_navigation', $pacz_menu_location );
		echo '</div>';
	echo '</div>';
?>
</header>



