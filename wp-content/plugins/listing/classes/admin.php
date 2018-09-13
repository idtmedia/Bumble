<?php

class alsp_admin {

	public function __construct() {
		global $alsp_instance;

		add_action('admin_menu', array($this, 'menu'));

		//$alsp_instance->settings_manager = new alsp_settings_manager;

		$alsp_instance->levels_manager = new alsp_levels_manager;

		$alsp_instance->listings_manager = new alsp_listings_manager;

		$alsp_instance->locations_manager = new alsp_locations_manager;

		$alsp_instance->locations_levels_manager = new alsp_locations_levels_manager;

		$alsp_instance->categories_manager = new alsp_categories_manager;

		$alsp_instance->content_fields_manager = new alsp_content_fields_manager;

		$alsp_instance->media_manager = new alsp_media_manager;

		$alsp_instance->csv_manager = new alsp_csv_manager;
		
		//$alsp_instance->maps_importer = new alsp_maps_importer;

		add_action('admin_menu', array($this, 'addChooseLevelPage'));
		add_action('load-post-new.php', array($this, 'handleLevel'));

		// hide some meta-blocks when create/edit posts
		add_action('admin_init', array($this, 'hideMetaBlocks'));
		
		add_filter('post_row_actions', array($this, 'removeQuickEdit'), 10, 2);
		add_filter('quick_edit_show_taxonomy', array($this, 'removeQuickEditTax'), 10, 2);

		add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts_styles'), 0);

		add_action('admin_notices', 'alsp_renderMessages');

		add_action('wp_ajax_alsp_generate_color_palette', array($this, 'generate_color_palette'));
		add_action('wp_ajax_nopriv_alsp_generate_color_palette', array($this, 'generate_color_palette'));
		add_action('wp_ajax_alsp_get_jqueryui_theme', array($this, 'get_jqueryui_theme'));
		add_action('wp_ajax_nopriv_alsp_get_jqueryui_theme', array($this, 'get_jqueryui_theme'));
		add_action('vp_alsp_option_before_ajax_save', array($this, 'remove_colorpicker_cookie'));
		//add_action('wp_footer', array($this, 'render_colorpicker'));
	}

	public function addChooseLevelPage() {
		add_submenu_page('options.php',
			__('Choose level of new listing', 'ALSP'),
			__('Choose level of new listing', 'ALSP'),
			'publish_posts',
			'alsp_choose_level',
			array($this, 'chooseLevelsPage')
		);
	}

	// Special page to choose the level for new listing
	public function chooseLevelsPage() {
		global $alsp_instance;

		$alsp_instance->levels_manager->displayChooseLevelTable();
	}
	
	public function handleLevel() {
		global $alsp_instance;

		if (isset($_GET['post_type']) && $_GET['post_type'] == ALSP_POST_TYPE) {
			if (!isset($_GET['level_id'])) {
				// adapted for WPML
				global $sitepress;
				if (function_exists('wpml_object_id_filter') && $sitepress && isset($_GET['trid']) && isset($_GET['lang']) && isset($_GET['source_lang'])) {
					global $sitepress;
					$listing_id = $sitepress->get_original_element_id_by_trid($_GET['trid']);
					
					$listing = new alsp_listing();
					$listing->loadListingFromPost($listing_id);
					wp_redirect(add_query_arg(array('post_type' => 'alsp_listing', 'level_id' => $listing->level->id, 'trid' => $_GET['trid'], 'lang' => $_GET['lang'], 'source_lang' => $_GET['source_lang']), admin_url('post-new.php')));
				} else {
					if (count($alsp_instance->levels->levels_array) != 1) {
						wp_redirect(add_query_arg('page', 'alsp_choose_level', admin_url('options.php')));
					} else {
						$single_level = array_shift($alsp_instance->levels->levels_array);
						wp_redirect(add_query_arg(array('post_type' => 'alsp_listing', 'level_id' => $single_level->id), admin_url('post-new.php')));
					}
				}
				die();
			}
		}
	}

	public function menu() {
		add_menu_page(
			esc_html__( 'Classiads Dashborad', 'classiads' ),
			esc_html__( 'Classiads Options', 'classiads' ),
			'manage_options',
			'classiads_settings',
			array($this, 'classiads_dashboard'),
			'',
			0
		);
		add_submenu_page('classiads_settings', 'Icon Library', 'Icon Library', 'manage_options', 'icon-library', 'icon_library_submenu_page_callback', '', 30);
	}
	public function classiads_dashboard(){}
	
	public function debug() {
		global $alsp_instance, $wpdb;
		
		$alsp_locationGeoname = new alsp_locationGeoname();
		$geolocation_response = $alsp_locationGeoname->geonames_request('1600 Amphitheatre Parkway Mountain View, CA 94043', 'test');

		$settings = $wpdb->get_results("SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name LIKE 'alsp_%'", ARRAY_A);

		alsp_frontendRender('debug.tpl.php', array(
			'rewrite_rules' => get_option('rewrite_rules'),
			'geolocation_response' => $geolocation_response,
			'settings' => $settings,
			'levels' => $alsp_instance->levels,
			'content_fields' => $alsp_instance->content_fields,
		));
	}

	/*public function reset() {
		global $alsp_instance, $wpdb;
		
		if (isset($_GET['reset']) && $_GET['reset'] == 'settings') {
			if ($wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE 'alsp_%'") !== false) {
				delete_option('vpt_option');
				alsp_save_dynamic_css();
				alsp_addMessage('All directory settings were deleted!');
			}
		}
		alsp_frontendRender('reset.tpl.php');
	}*/
	
	public function hideMetaBlocks() {
		 global $post, $pagenow;

		if (($pagenow == 'post-new.php' && isset($_GET['post_type']) && $_GET['post_type'] == ALSP_POST_TYPE) || ($pagenow == 'post.php' && $post && $post->post_type == ALSP_POST_TYPE)) {
			$user_id = get_current_user_id();
			update_user_meta($user_id, 'metaboxhidden_' . ALSP_POST_TYPE, array('authordiv', 'trackbacksdiv', 'commentstatusdiv', 'postcustom'));
		}
	}

	public function removeQuickEdit($actions, $post) {
		if ($post->post_type == ALSP_POST_TYPE) {
			unset($actions['inline hide-if-no-js']);
			unset($actions['view']);
		}
		return $actions;
	}

	public function removeQuickEditTax($show_in_quick_edit, $taxonomy_name) {
		if ($taxonomy_name == ALSP_CATEGORIES_TAX || $taxonomy_name == ALSP_LOCATIONS_TAX)
			$show_in_quick_edit = false;
		
		return $show_in_quick_edit;
	}
	
	public function admin_enqueue_scripts_styles() {
		add_action('admin_head', array($this, 'enqueue_global_vars'));

		//wp_register_style('alsp_bootstrap', PACZ_THEME_STYLES . '/bootstrap.min.css');
		if(class_exists('Classiadspro_Theme')){
			wp_register_style('alsp_select2', PACZ_THEME_STYLES . '/select2.css');
			wp_register_style('alsp_bootstrap', PACZ_THEME_STYLES . '/bootstrap.min.css');
			wp_register_style('alsp_fonticon_icons', PACZ_THEME_STYLES . '/fonticon-custom.min.css');
		}
		wp_register_style('alsp_admin', ALSP_RESOURCES_URL . 'css/admin.css');
		wp_register_style('alsp_admin_notice', ALSP_RESOURCES_URL . 'css/admin_notice.css');
		wp_register_script('alsp_js_functions', ALSP_RESOURCES_URL . 'js/js_functions.js', array('jquery'), false, true);

		// this jQuery UI version 1.10.3 is for WP v3.7.1
		wp_register_style('alsp-jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.css');
		if(class_exists('Classiadspro_Theme')){
			wp_register_script('alsp_bootstrap_js', PACZ_THEME_JS . '/bootstrap.min.js', array('jquery'));
			wp_register_script('alsp_select2_js', PACZ_THEME_JS . '/select2.min.js', array('jquery'));
		}
		wp_register_script('alsp_google_maps_edit', ALSP_RESOURCES_URL . 'js/google_maps_edit.js', array('jquery'));
		 global $pagenow;
		 if ($pagenow == 'edit-tags.php' || $pagenow == 'term.php') {
			wp_register_script('alsp_categories_edit_scripts', ALSP_RESOURCES_URL . 'js/categories_icons.js', array('jquery'));
		 }
		wp_register_script('alsp_categories_scripts', ALSP_RESOURCES_URL . 'js/manage_categories.js', array('jquery'));
		
		wp_register_script('alsp_locations_edit_scripts', ALSP_RESOURCES_URL . 'js/locations_icons.js', array('jquery'));
		
		wp_register_style('alsp_media_styles', ALSP_RESOURCES_URL . 'lightbox/css/lightbox.css');
		wp_register_script('alsp_media_scripts_lightbox', ALSP_RESOURCES_URL . 'lightbox/js/lightbox.min.js', array('jquery'));
		wp_register_script('alsp_media_scripts', ALSP_RESOURCES_URL . 'js/ajaxfileupload.js', array('jquery'));
		wp_register_script('alsp_select2_triger', ALSP_RESOURCES_URL . 'js/select2-triger.js', array('jquery'));
		if(class_exists('Classiadspro_Theme')){
		wp_enqueue_style('alsp_select2');
		wp_enqueue_style('alsp_fonticon_icons');
		wp_add_inline_style('alsp_fonticon_icons', pacz_enqueue_font_icons());
		wp_enqueue_script('alsp_bootstrap_js');
		}
		wp_enqueue_style('alsp_admin');
		wp_enqueue_style('alsp_admin_notice');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_style('alsp-jquery-ui-style');
		
		global $pagenow;

   if ($pagenow != 'admin.php') {
        wp_enqueue_script('alsp_js_functions');
      }
		
	 global $post;

    if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
        if ( 'alsp_listing' == $post->post_type ) {     
            wp_register_style('alsp_fsubmit_admin', ALSP_URL . 'addons/alsp_fsubmit/resources/css/submitlisting.css');
			wp_enqueue_style('alsp_bootstrap');
			wp_enqueue_style('alsp_fsubmit_admin');
			
			if (is_file(ALSP_URL . 'addons/alsp_fsubmit/resources/css/submitlisting-custom.css')){
				wp_register_style('alsp_fsubmit-custom_admin', ALSP_URL . 'addons/alsp_fsubmit/resources/css/submitlisting-custom.css');
				wp_enqueue_style('alsp_fsubmit-custom_admin');
			}
			wp_enqueue_script('alsp_select2_js');
			wp_enqueue_script('alsp_select2_triger');
			if (function_exists('is_rtl') && is_rtl()){
				wp_register_style('alsp_fsubmit_rtl_admin', ALSP_URL . 'addons/alsp_fsubmit/resources/css/submitlisting-rtl.css');
				wp_enqueue_style('alsp_fsubmit_rtl_admin');
			}
			
       }
    }
		wp_localize_script(
			'alsp_js_functions',
			'alsp_google_maps_callback',
			array(
					'callback' => 'alsp_load_maps_api_backend'
			)
		);

		wp_enqueue_script('alsp_google_maps_edit');
	}
	
	public function enqueue_global_vars() {
		// adapted for WPML
		global $sitepress, $ALSP_ADIMN_SETTINGS;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			$ajaxurl = admin_url('admin-ajax.php?lang=' .  $sitepress->get_current_language());
		} else
			$ajaxurl = admin_url('admin-ajax.php');

		echo '
<script>
';
		echo 'var alsp_js_objects = ' . json_encode(
				array(
						'ajaxurl' => $ajaxurl,
						'ajax_loader_url' => ALSP_RESOURCES_URL . 'images/ajax-loader.gif',
						'is_rtl' => is_rtl(),
				)
		) . ';
';

		global $alsp_maps_styles;
		echo 'var alsp_google_maps_objects = ' . json_encode(
				array(
						'notinclude_maps_api' => ((defined('ALSP_NOTINCLUDE_MAPS_API') && ALSP_NOTINCLUDE_MAPS_API) ? 1 : 0),
						'google_api_key' => $ALSP_ADIMN_SETTINGS['alsp_google_api_key'],
						'map_markers_type' => $ALSP_ADIMN_SETTINGS['alsp_map_markers_type'],
						'default_marker_color' => $ALSP_ADIMN_SETTINGS['alsp_default_marker_color'],
						'default_marker_icon' => $ALSP_ADIMN_SETTINGS['alsp_default_marker_icon'],
						'global_map_icons_path' => ALSP_MAP_ICONS_URL,
						'marker_image_width' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_marker_width'],
						'marker_image_height' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_marker_height'],
						'marker_image_anchor_x' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_marker_anchor_x'],
						'marker_image_anchor_y' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_marker_anchor_y'],
						'default_geocoding_location' => $ALSP_ADIMN_SETTINGS['alsp_default_geocoding_location'],
						'map_style_name' => $ALSP_ADIMN_SETTINGS['alsp_map_style'],
						'map_markers_array' => alsp_get_fa_icons_names(),
						'map_styles' => $alsp_maps_styles,
						'address_autocomplete_code' => $ALSP_ADIMN_SETTINGS['alsp_address_autocomplete_code'],
				)
		) . ';
';
		echo '</script>
';
	}

	/*public function generate_color_palette() {
		ob_start();
		include ALSP_PATH . '/classes/customization/dynamic_css.php';
		$dynamic_css = ob_get_contents();
		ob_get_clean();

		echo $dynamic_css;
		die();
	}*/

	/*public function get_jqueryui_theme() {
		global $alsp_color_schemes;

		if (isset($_COOKIE['alsp_compare_palettes']) && get_option('alsp_compare_palettes')) {
			$scheme = $_COOKIE['alsp_compare_palettes'];
			if ($scheme && isset($alsp_color_schemes[$scheme]['alsp_jquery_ui_schemas']))
				echo '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/' . $alsp_color_schemes[$scheme]['alsp_jquery_ui_schemas'] . '/jquery-ui.css';
		}
		die();
	}*/
	
	/*public function remove_colorpicker_cookie($opt) {
		if (isset($_COOKIE['alsp_compare_palettes'])) {
			unset($_COOKIE['alsp_compare_palettes']);
			setcookie('alsp_compare_palettes', null, -1, '/');
		}
	}*/

	/*public function render_colorpicker() {
		global $alsp_instance;

		if (!empty($alsp_instance->frontend_controllers))
			if (get_option('alsp_compare_palettes'))
				if (current_user_can('manage_options'))
					alsp_frontendRender('color_picker/color_picker_panel.tpl.php');
	}*/
}
?>