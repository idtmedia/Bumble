<?php

class classiadsproSidebarGenerator {
	var $sidebar_names = array();
	var $footer_sidebar_count = 0;
	var $footer_sidebar_names = array();

	function __construct() {

		$this->sidebar_names = array(
			'page'=>esc_html__( 'Pages', 'classiadspro' ),
			'blog'=>esc_html__( 'Blog', 'classiadspro' ),
			'single_post'=>esc_html__( 'Blog Single', 'classiadspro' ),
			'search'=>esc_html__( 'Search', 'classiadspro' ),
			'404'=>esc_html__( '404', 'classiadspro' ),
			'archive'=>esc_html__( 'Archive', 'classiadspro' ),
			'woocommerce'=>esc_html__( 'Woocommerce Shop', 'classiadspro' ),
			'woocommerce_single'=>esc_html__( 'Woocommerce Single', 'classiadspro' ),
			'bbpress'=>esc_html__( 'bbPress', 'classiadspro' ),
			'alsp_listing_single'=>esc_html__( 'Listing Single', 'classiadspro' ),
			'author'=>esc_html__( 'Author Page', 'classiadspro' ),
		);


		$this->footer_sidebar_names = array(
			esc_html__( 'Footer Column One', 'classiadspro' ),
			esc_html__( 'Footer Column Two', 'classiadspro' ),
			esc_html__( 'Footer Column Three', 'classiadspro' ),
			esc_html__( 'Footer Column Four', 'classiadspro' ),
			esc_html__( 'Footer Column Five', 'classiadspro' ),
			esc_html__( 'Footer Column Six', 'classiadspro' ),
		);

	}

	function register_sidebar() {

		$i = 1;

		foreach ( $this->sidebar_names as $name ) {
			register_sidebar( array(
					'name' => $name,
					'id' => 'sidebar-'.$i,
					'description' => $name,
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget' => '</section>',
					'before_title' => '<div class="widgettitle">',
					'after_title' => '</div>',
				) );

			$i++;
		}
		foreach ( $this->footer_sidebar_names as $name ) {
			register_sidebar( array(
					'name' =>  $name,
					'id' => 'sidebar-'.$i,
					'description' => $name,
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget' => '</section>',
					'before_title' => '<div class="widgettitle">',
					'after_title' => '</div>',
				) );
			$i++;
		}

		$i++;

		$custom_sidebars = get_option( 'pacz_settings' );
		$custom_sidebars_array = isset($custom_sidebars['custom-sidebar']) ? $custom_sidebars['custom-sidebar'] : null;
		if ( $custom_sidebars_array != null ) {
			foreach ( $custom_sidebars_array as $key => $value ) {
				register_sidebar( array(
						'name' =>  $value,
						'id' => 'sidebar-'.$i,
						'description' => $value,
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget' => '</section>',
						'before_title' => '<div class="widgettitle">',
						'after_title' => '</div>',
					) );
				$i++;
			}
		}
	}

	function get_sidebar( $post_id = null ) {
		global $post;
		if ( is_active_sidebar("archive") && is_archive() ) {
			$sidebar = $this->sidebar_names["archive"];
		}
		if (is_home() ) {
			$sidebar = $this->sidebar_names['blog'];
		}
		if (is_active_sidebar("search") && is_search() ) {
			$sidebar = $this->sidebar_names["search"];
		}
		if (is_active_sidebar("404") && is_404() ) {
			$sidebar = $this->sidebar_names["404"];
		}
		if (is_active_sidebar("single_post") && is_singular( 'post' ) ) {
			$sidebar = $this->sidebar_names['single_post'];
		}
		if (is_active_sidebar("alsp_listing_single") && is_page() && has_shortcode($post->post_content, 'webdirectory-listing') ) {
			$sidebar = $this->sidebar_names['alsp_listing_single'];
		}
		if (is_author()) {
			$sidebar = $this->sidebar_names['alsp_listing_single'];
		}
		if (is_active_sidebar("page") && is_page() && !is_home() ) {
			$sidebar = $this->sidebar_names['page'];
		}
		if ( function_exists('is_woocommerce') && is_active_sidebar("woocommerce") && is_woocommerce() && is_archive()) {
			$sidebar = $this->sidebar_names["woocommerce"];
		}
		if ( function_exists('is_woocommerce') && is_single()) {
			$sidebar = $this->sidebar_names["woocommerce_single"];
		}
		if ( function_exists('is_bbpress') && is_active_sidebar("bbpress") && is_bbpress()) {
			$sidebar = $this->sidebar_names['bbpress'];
		}

		if(is_author()){
			$sidebar = $this->sidebar_names['author'];
		}else{
			if ( !empty( $post_id ) ) {
				$custom = get_post_meta( $post_id, '_sidebar', true );
				if ( !empty( $custom ) ) {
					$sidebar = $custom;
				}
			}
		}
		
		if ( isset( $sidebar ) ) {
			dynamic_sidebar( $sidebar );
		}
	}

	function get_footer_sidebar(){
		$post_id = global_get_post_id();
		if($post_id) {
				if($this->footer_sidebar_count == 0) {
					$single_area = get_post_meta($post_id, '_widget_first_col', true);
					if(!empty($single_area)) {
						dynamic_sidebar($single_area);
					} else {
						dynamic_sidebar($this->footer_sidebar_names[$this->footer_sidebar_count]);
					}
				}
				if($this->footer_sidebar_count == 1) {
					$single_area = get_post_meta($post_id, '_widget_second_col', true);
					if(!empty($single_area)) {
						dynamic_sidebar($single_area);
					} else {
						dynamic_sidebar($this->footer_sidebar_names[$this->footer_sidebar_count]);
					}
				}
				if($this->footer_sidebar_count == 2) {
					$single_area = get_post_meta($post_id, '_widget_third_col', true);
					if(!empty($single_area)) {
						dynamic_sidebar($single_area);
					} else {
						dynamic_sidebar($this->footer_sidebar_names[$this->footer_sidebar_count]);
					}
				}
				if($this->footer_sidebar_count == 3) {
					$single_area = get_post_meta($post_id, '_widget_fourth_col', true);
					if(!empty($single_area)) {
						dynamic_sidebar($single_area);
					} else {
						dynamic_sidebar($this->footer_sidebar_names[$this->footer_sidebar_count]);
					}
				}
				if($this->footer_sidebar_count == 4) {
					$single_area = get_post_meta($post_id, '_widget_fifth_col', true);
					if(!empty($single_area)) {
						dynamic_sidebar($single_area);
					} else {
						dynamic_sidebar($this->footer_sidebar_names[$this->footer_sidebar_count]);
					}
				}
				if($this->footer_sidebar_count == 5) {
					$single_area = get_post_meta($post_id, '_widget_sixth_col', true);
					if(!empty($single_area)) {
						dynamic_sidebar($single_area);
					} else {
						dynamic_sidebar($this->footer_sidebar_names[$this->footer_sidebar_count]);
					}
				}
		} else {
			dynamic_sidebar($this->footer_sidebar_names[$this->footer_sidebar_count]);
		}
		$single_area = '';
		$this->footer_sidebar_count++;
	}

}
global $_classiadsproSidebarGenerator;
$_classiadsproSidebarGenerator = new classiadsproSidebarGenerator;

add_action( 'widgets_init', array( $_classiadsproSidebarGenerator, 'register_sidebar' ) );

function pacz_sidebar_generator( $function ) {
	global $_classiadsproSidebarGenerator;
	$args = array_slice( func_get_args(), 1 );
	return call_user_func_array( array( &$_classiadsproSidebarGenerator, $function ), $args );
}
