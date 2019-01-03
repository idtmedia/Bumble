

<?php
global $pacz_settings;
 $post_id = global_get_post_id();
 ?>


<header id="pacz-header" class="mobile-header">
<?php
 
  echo '<div class="pacz-header-mobile1">';
		 echo '<div class="pacz-mobile-header-top clearfix">';
			echo '<div class="pacz-mobile-logo-wrap pull-left">';
				do_action('header_mobile_logo');
			echo'</div>';

		echo'</div>';
		echo '<div class="pacz-mobile-header-bottom clearfix">';

			if(is_user_logged_in() && !empty($pacz_settings['loggedin_menu'])) {
				$menu_location = $pacz_settings['loggedin_menu'];
				do_action( 'main_navigation', $menu_location );
				do_action( 'responsive_nav_listing_search_link');
				do_action( 'nav_listing_btn' );
			}else{
				$pacz_menu_location = 'primary-menu';
				do_action( 'main_navigation', 'primary-menu' );
				do_action( 'responsive_nav_listing_search_link');
				do_action( 'nav_listing_btn' );
			}
            echo '<div class="pacz-mobile-login-wrap">';
            do_action('header_logreg');
            echo'</div>';
		echo'</div>';
    echo '</div>';

?>
</header>

<div class="responsive-search-form-container">
	<?php echo do_shortcode('[webdirectory-search search_form_type="4"]'); ?>
</div>
<div class="responsive-nav-container">
<span class="res-menu-close pacz-icon-long-arrow-left"></span>
<?php echo do_action('pacz_header_login_active_menu_mobile'); ?>
</div>


