<?php
/*
Plugin Name: Ads Listing System Plugin
Plugin URI:
Description: Provides an ability to build any kind of directory site: classifieds, events directory, cars, bikes, boats and other vehicles dealers site, pets, real estate portal on your WordPress powered site. In other words - whatever you want.
Version: 1.14.11
Author: Designinvento
Author URI: https://themeforest.net/user/designinvento
License: GPLv2 or any later version
*/

define('ALSP_VERSION', '1.14.11');

define('ALSP_PATH', plugin_dir_path(__FILE__));
define('ALSP_URL', plugins_url('/', __FILE__));

define('ALSP_TEMPLATES_PATH', ALSP_PATH . 'templates/');

define('ALSP_RESOURCES_PATH', ALSP_PATH . 'resources/');
define('ALSP_RESOURCES_URL', ALSP_URL . 'resources/');
define('ALSP_POST_TYPE', 'alsp_listing');
define('ALSP_CATEGORIES_TAX', 'alsp-category');
define('ALSP_LOCATIONS_TAX', 'alsp-location');
define('ALSP_TAGS_TAX', 'alsp-tag');
//define('ALSP_ADIMN_SETTINGS', get_option('alsp_admin_settings'));

$ALSP_ADIMN_SETTINGS = get_option('alsp_admin_settings');
global $ALSP_ADIMN_SETTINGS;
// Deactivate deprecated modules
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
$fsubmit =  'alsp_fsubmit/alsp_fsubmit.php';
if (is_plugin_active($fsubmit)) {
	add_option('alsp_fsubmit_addon', 1);
	deactivate_plugins($fsubmit);
	exit('Press F5!!!');
}
$payments =  'alsp_payments/alsp_payments.php';
if (is_plugin_active($payments)) {
	add_option('alsp_payments_addon', 1);
	deactivate_plugins($payments);
	exit('Press F5!!!');
}
$ratings =  'alsp_ratings/alsp_ratings.php';
if (is_plugin_active($ratings)) {
	add_option('alsp_ratings_addon', 1);
	deactivate_plugins($ratings);
	exit('Press F5!!!');
}
$elocations =  'alsp_elocations/alsp_elocations.php';
if (is_plugin_active($elocations)) {
	deactivate_plugins($elocations);
	exit('Press F5!!!');
}
$esearch =  'alsp_esearch/alsp_esearch.php';
if (is_plugin_active($esearch)) {
	deactivate_plugins($esearch);
	exit('Press F5!!!');
}

include_once ALSP_PATH . 'install.php';
include_once ALSP_PATH . 'update.php';
include_once ALSP_PATH . 'classes/admin.php';
include_once ALSP_PATH . 'classes/form_validation.php';
include_once ALSP_PATH . 'classes/listings/listings_manager.php';
include_once ALSP_PATH . 'classes/listings/listing.php';
if ($ALSP_ADIMN_SETTINGS['alsp_payments_addon'] != 'alsp_woo_payment') {
	include_once ALSP_PATH . 'classes/listings/listings_packages.php';
}
include_once ALSP_PATH . 'classes/categories_manager.php';
include_once ALSP_PATH . 'classes/media_manager.php';
include_once ALSP_PATH . 'classes/content_fields/content_fields_manager.php';
include_once ALSP_PATH . 'classes/content_fields/content_fields.php';
include_once ALSP_PATH . 'classes/locations/locations_manager.php';
include_once ALSP_PATH . 'classes/locations/locations_levels_manager.php';
include_once ALSP_PATH . 'classes/locations/locations_levels.php';
include_once ALSP_PATH . 'classes/locations/location.php';
include_once ALSP_PATH . 'classes/levels/levels_manager.php';
include_once ALSP_PATH . 'classes/levels/levels.php';
include_once ALSP_PATH . 'classes/frontend_controller.php';
include_once ALSP_PATH . 'classes/shortcodes/directory_controller.php';
include_once ALSP_PATH . 'classes/shortcodes/listings_controller.php';
include_once ALSP_PATH . 'classes/shortcodes/map_controller.php';
include_once ALSP_PATH . 'classes/shortcodes/categories_controller.php';
include_once ALSP_PATH . 'classes/shortcodes/locations_controller.php';
include_once ALSP_PATH . 'classes/shortcodes/search_controller.php';
include_once ALSP_PATH . 'classes/shortcodes/slider_controller.php';
include_once ALSP_PATH . 'classes/shortcodes/buttons_controller.php';
include_once ALSP_PATH . 'classes/ajax_controller.php';
include_once ALSP_PATH . 'classes/settings_manager.php';
include_once ALSP_PATH . 'classes/google_maps.php';
include_once ALSP_PATH . 'classes/widgets.php';
include_once ALSP_PATH . 'classes/csv_manager.php';
include_once ALSP_PATH . 'classes/location_geoname.php';
include_once ALSP_PATH . 'classes/search_form.php';
include_once ALSP_PATH . 'classes/search_fields/search_fields.php';
include_once ALSP_PATH . 'functions.php';
include_once ALSP_PATH . 'functions_ui.php';
include_once ALSP_PATH . 'maps_styles.php';
include_once ALSP_PATH . 'vc.php';

// Categories icons constant
if ($custom_dir = alsp_AssetsIsCdir('images/categories_icons/')) {
	define('ALSP_CATEGORIES_ICONS_PATH', $custom_dir);
	define('ALSP_CATEGORIES_ICONS_URL', alsp_getCAssetDirurl('images/categories_icons/'));
} else {
	define('ALSP_CATEGORIES_ICONS_PATH', ALSP_RESOURCES_PATH . 'images/categories_icons/');
	define('ALSP_CATEGORIES_ICONS_URL', ALSP_RESOURCES_URL . 'images/categories_icons/');
}

// Locations icons constant
if ($custom_dir = alsp_AssetsIsCdir('images/locations_icons/')) {
	define('ALSP_LOCATION_ICONS_PATH', $custom_dir);
	define('ALSP_LOCATIONS_ICONS_URL', alsp_getCAssetDirurl('images/locations_icons/'));
} else {
	define('ALSP_LOCATION_ICONS_PATH', ALSP_RESOURCES_PATH . 'images/locations_icons/');
	define('ALSP_LOCATIONS_ICONS_URL', ALSP_RESOURCES_URL . 'images/locations_icons/');
}

// Map Markers Icons Path
if ($custom_dir = alsp_AssetsIsCdir('images/map_icons/')) {
	define('ALSP_MAP_ICONS_PATH', $custom_dir);
	define('ALSP_MAP_ICONS_URL', alsp_getCAssetDirurl('images/map_icons/'));
} else {
	define('ALSP_MAP_ICONS_PATH', ALSP_RESOURCES_PATH . 'images/map_icons/');
	define('ALSP_MAP_ICONS_URL', ALSP_RESOURCES_URL . 'images/map_icons/');
}

global $alsp_instance;
global $alsp_messages;
define('ALSP_MAIN_SHORTCODE', 'webdirectory');
define('ALSP_LISTING_SHORTCODE', 'webdirectory-listing');

/*
 * There are 2 types of shortcodes in the system:
 1. those process as simple wordpress shortcodes
 2. require initialization on 'wp' hook
 
 [webdirectory] shortcode must be initialized on 'wp' hook and then renders as simple shortcode
 */
global $alsp_shortcodes, $alsp_shortcodes_init;
$alsp_shortcodes = array(
		'webdirectory' => 'alsp_directory_controller',
		'webdirectory-listing' => 'alsp_directory_controller',
		'webdirectory-listings' => 'alsp_listings_controller',
		'webdirectory-map' => 'alsp_map_controller',
		'webdirectory-categories' => 'alsp_categories_controller',
		'webdirectory-locations' => 'alsp_locations_controller',
		'webdirectory-search' => 'alsp_search_controller',
		'webdirectory-slider' => 'alsp_slider_controller',
		'webdirectory-buttons' => 'alsp_buttons_controller',
);
$alsp_shortcodes_init = array(
		'webdirectory' => 'alsp_directory_controller',
		'webdirectory-listing' => 'alsp_directory_controller',
		'webdirectory-listings' => 'alsp_listings_controller',
);

class alsp_plugin {
	public $admin;
	public $listings_manager;
	public $locations_manager;
	public $locations_levels_manager;
	public $categories_manager;
	public $content_fields_manager;
	public $media_manager;
	public $settings_manager;
	public $levels_manager;
	public $csv_manager;

	public $current_listing; // this is object of listing under edition right now
	public $levels;
	public $locations_levels;
	public $content_fields;
	public $search_fields;
	public $ajax_controller;
	public $index_page_id;
	public $index_page_slug;
	public $index_page_url;
	public $listing_page_id;
	public $listing_page_slug;
	public $listing_page_url;
	public $frontend_controllers = array();
	public $_frontend_controllers = array(); // this duplicate property needed because we unset each controller when we render shortcodes, but WP doesn't really know which shortcode already was processed
	public $action;
	
	public $radius_values_array = array();
	
	public $order_by_date = false; // special flag, used to display or hide sticky pin

	public function __construct() {
		register_activation_hook(__FILE__, array($this, 'activation'));
		register_deactivation_hook(__FILE__, array($this, 'deactivation'));
		//do_action('sheduled_events');
	}
	
	public function activation() {
		global $wp_version;

		if (version_compare($wp_version, '3.6', '<')) {
			deactivate_plugins(basename(__FILE__)); // Deactivate ourself
			wp_die("Sorry, but you can't run this plugin on current WordPress version, it requires WordPress v3.6 or higher.");
		}
		flush_rewrite_rules();
		
		wp_schedule_event(current_time('timestamp'), 'hourly', 'sheduled_events');
	}

	public function deactivation() {
		flush_rewrite_rules();

		wp_clear_scheduled_hook('sheduled_events');
	}
	
	public function init() {
		global $alsp_instance, $alsp_shortcodes, $wpdb;

		$_GET = stripslashes_deep($_GET);
		if (isset($_REQUEST['alsp_action']))
			$this->action = $_REQUEST['alsp_action'];

		add_action('plugins_loaded', array($this, 'load_textdomains'));

		if (!isset($wpdb->alsp_content_fields))
			$wpdb->alsp_content_fields = $wpdb->prefix . 'alsp_content_fields';
		if (!isset($wpdb->alsp_content_fields_groups))
			$wpdb->alsp_content_fields_groups = $wpdb->prefix . 'alsp_content_fields_groups';
		if (!isset($wpdb->alsp_levels))
			$wpdb->alsp_levels = $wpdb->prefix . 'alsp_levels';
		if (!isset($wpdb->alsp_levels_relationships))
			$wpdb->alsp_levels_relationships = $wpdb->prefix . 'alsp_levels_relationships';
		if (!isset($wpdb->alsp_locations_levels))
			$wpdb->alsp_locations_levels = $wpdb->prefix . 'alsp_locations_levels';
		if (!isset($wpdb->alsp_locations_relationships))
			$wpdb->alsp_locations_relationships = $wpdb->prefix . 'alsp_locations_relationships';

		add_action('sheduled_events', array($this, 'suspend_expired_listings'));
		
		foreach ($alsp_shortcodes AS $shortcode=>$function)
			add_shortcode($shortcode, array($this, 'renderShortcode'));
		
		add_action('init', array($this, 'register_post_type'), 0);
		add_action('init', array($this, 'getIndexPage'), 0);
		add_action('init', array($this, 'checkMainShortcode'), 0);
		
		add_action('wp', array($this, 'suspend_expired_listings_call'), 1);
		add_action('wp', array($this, 'loadFrontendControllers'), 1);

		if (!get_option('alsp_installed_directory') || get_option('alsp_installed_directory_version') != ALSP_VERSION) {
			if (get_option('alsp_installed_directory'))
				$this->loadClasses();

			add_action('init', 'alsp_install_directory', 0);
		} else {
			$this->loadClasses();
		}
		add_filter('template_include', array($this, 'printlisting_template'), 100000);

		add_action('wp_loaded', array($this, 'wp_loaded'));
		add_filter('query_vars', array($this, 'add_query_vars'));
		add_filter('rewrite_rules_array', array($this, 'rewrite_rules'));
		
		add_filter('redirect_canonical', array($this, 'prevent_wrong_redirect'), 10, 2);
		add_filter('post_type_link', array($this, 'listing_permalink'), 10, 3);
		add_filter('term_link', array($this, 'category_permalink'), 10, 3);
		add_filter('term_link', array($this, 'location_permalink'), 10, 3);
		add_filter('term_link', array($this, 'tag_permalink'), 10, 3);
		
		// adapted for Polylang
		add_action('init', array($this, 'pll_setup'));

		add_filter('comments_open', array($this, 'filter_comment_status'), 100, 2);
		
		add_filter('wp_unique_post_slug_is_bad_flat_slug', array($this, 'reserve_slugs'), 10, 2);
		
		add_filter('no_texturize_shortcodes', array($this, 'alsp_no_texturize'));

		// WPML builds wrong urls for translations,
		// also Paid Memberships Pro plugin breaks its redirect after login and before session had started,
		// that is why this filter must be disabled
		//add_filter('home_url', array($this, 'add_trailing_slash_to_home'), 1000, 2);

		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
		//add_action('wp_head', array($this, 'enqueue_dynamic_css'), 9999);
		add_action('redux/loaded', array($this, 'custom_listing_config'));

	}
	public function custom_listing_config() {
	require_once ALSP_PATH . 'alsp-options.php';
	}
	public function load_textdomains() {
		load_plugin_textdomain('ALSP', '', dirname(plugin_basename( __FILE__ )) . '/languages');
	}
	
	public function loadClasses() {
		global $ALSP_ADIMN_SETTINGS;
		$this->levels = new alsp_levels;
		$this->locations_levels = new alsp_locations_levels;
		$this->content_fields = new alsp_content_fields;
		$this->search_fields = new alsp_search_fields;
		$this->ajax_controller = new alsp_ajax_controller;
		$this->admin = new alsp_admin();
		if ($ALSP_ADIMN_SETTINGS['alsp_payments_addon'] != 'alsp_woo_payment'){
			$this->listings_packages = new alsp_listings_packages;
		}
	}

	public function alsp_no_texturize($shortcodes) {
		global $alsp_shortcodes;
		
		foreach ($alsp_shortcodes AS $shortcode=>$function)
			$shortcodes[] = $shortcode;
		
		return $shortcodes;
	}

	public function renderShortcode() {
		global $alsp_shortcodes;

		// remove content filters in order not to break the layout of page
		remove_filter('the_content', 'wpautop');
		remove_filter('the_content', 'wptexturize');
		remove_filter('the_content', 'shortcode_unautop');
		remove_filter('the_content', 'convert_chars');
		remove_filter('the_content', 'prepend_attachment');
		remove_filter('the_content', 'convert_smilies');

		$attrs = func_get_args();
		$shortcode = $attrs[2];

		$filters_where_not_to_display = array(
				'wp_head',
				'init',
				'wp',
		);
		
		if (isset($this->_frontend_controllers[$shortcode]) && !in_array(current_filter(), $filters_where_not_to_display)) {
			$shortcode_controllers = $this->_frontend_controllers[$shortcode];
			foreach ($shortcode_controllers AS $key=>&$controller) {
				unset($this->_frontend_controllers[$shortcode][$key]); // there are possible more than 1 same shortcodes on a page, so we have to unset which already was displayed
				if (method_exists($controller, 'display'))
					return $controller->display();
			}
		}

		if (isset($alsp_shortcodes[$shortcode])) {
			$shortcode_class = $alsp_shortcodes[$shortcode];
			if ($attrs[0] === '')
				$attrs[0] = array();
			$shortcode_instance = new $shortcode_class();
			$this->frontend_controllers[$shortcode][] = $shortcode_instance;
			$shortcode_instance->init($attrs[0], $shortcode);

			if (method_exists($shortcode_instance, 'display'))
				return $shortcode_instance->display();
		}
	}

	public function loadFrontendControllers() {
		global $post, $wp_query;

		if ($wp_query->posts) {
			$pattern = get_shortcode_regex();
			foreach ($wp_query->posts AS $archive_post) {
				if (isset($archive_post->post_content))
				$this->loadNestedFrontendController($pattern, $archive_post->post_content);
			}
		} elseif ($post && isset($post->post_content)) {
			$pattern = get_shortcode_regex();
			$this->loadNestedFrontendController($pattern, $post->post_content);
		}
	}

	// this may be recursive function to catch nested shortcodes
	public function loadNestedFrontendController($pattern, $content) {
		global $alsp_shortcodes_init, $alsp_shortcodes;

		if (preg_match_all('/'.$pattern.'/s', $content, $matches) && array_key_exists(2, $matches)) {
			foreach ($matches[2] AS $key=>$shortcode) {
				if ($shortcode != 'shortcodes') {
					if (isset($alsp_shortcodes_init[$shortcode]) && class_exists($alsp_shortcodes_init[$shortcode])) {
						$shortcode_class = $alsp_shortcodes_init[$shortcode];
						if (!($attrs = shortcode_parse_atts($matches[3][$key])))
							$attrs = array();
						$shortcode_instance = new $shortcode_class();
						$this->frontend_controllers[$shortcode][] = $shortcode_instance;
						$this->_frontend_controllers[$shortcode][] = $shortcode_instance;
						$shortcode_instance->init($attrs, $shortcode);
					} elseif (isset($alsp_shortcodes[$shortcode]) && class_exists($alsp_shortcodes[$shortcode])) {
						$shortcode_class = $alsp_shortcodes[$shortcode];
						$this->frontend_controllers[$shortcode][] = $shortcode_class;
					}
					if ($shortcode_content = $matches[5][$key])
						$this->loadNestedFrontendController($pattern, $shortcode_content);
				}
			}
		}
	}
	
	public function checkMainShortcode() {
		global $ALSP_ADIMN_SETTINGS;
		if ($this->index_page_slug == $ALSP_ADIMN_SETTINGS['alsp_category_slug'] || $this->index_page_slug == $ALSP_ADIMN_SETTINGS['alsp_tag_slug'])
			alsp_addMessage('Categories or tags slug is the same as slug of directory page! This may cause problems. Go to <a href="' . admin_url('admin.php?page=alsp_settings') . '">settings page</a> and enter another slug.', 'error');
		
		if ($this->index_page_id === 0 && is_admin())
			alsp_addMessage(sprintf(__("<b>Ads Listing System Plugin</b>: sorry, but there isn't any page with [webdirectory] shortcode. Create <a href=\"%s\">this special page</a> for you?", 'ALSP'), admin_url('admin.php?page=alsp_settings&action=directory_page_installation')));
	}

	public function getIndexPage() {
		if ($array = alsp_getIndexPage()) {
			$this->index_page_id = $array['id'];
			$this->index_page_slug = $array['slug'];
			$this->index_page_url = $array['url'];
		}

		if ($array = alsp_getListingPage()) {
			$this->listing_page_id = $array['id'];
			$this->listing_page_slug = $array['slug'];
			$this->listing_page_url = $array['url'];
		}
	}
	public function suspend_expired_listings_call() {
		$this->suspend_expired_listings();
	}
	public function add_query_vars($vars) {
		$vars[] = 'listing-alsp';
		$vars[] = 'category-alsp';
		$vars[] = 'location-alsp';
		$vars[] = 'tag-alsp';
		$vars[] = 'tax-slugs-alsp';

		if (!is_admin()) {
			// order query var may damage sorting of listings at the frontend - it shows WP posts instead of directory listings
			$key = array_search('order', $vars);
			unset($vars[$key]);
		}

		return $vars;
	}
	
	public function rewrite_rules($rules) {
		return $this->alsp_addRules() + $rules;
	}
	
	public function alsp_addRules() {
		/*   		foreach (get_option('rewrite_rules') AS $key=>$rule)
		 echo $key . '
		' . $rule . '
	
	
		';   */
		
		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress && ($languages = $sitepress->get_active_languages()) && count($languages) > 1) {
			$original_index_page_id = $this->index_page_id;
			$original_listing_page_id = $this->listing_page_id;
			$rules = array();
			foreach ($languages AS $lang_code=>$lang) {
				if ($this->index_page_id = apply_filters('wpml_object_id', $original_index_page_id, 'page', false, $lang_code)) {
					$post = get_post($this->index_page_id);
					$this->index_page_slug = $post->post_name;
					$this->listing_page_id = apply_filters('wpml_object_id', $original_listing_page_id, 'page', false, $lang_code);

					$rules = $rules + $this->buildRules($lang_code);
				}
			}
			$this->getIndexPage();
			return $rules;
		} else {
			return $this->buildRules();
		}
	}
	
	public function buildRules($lang_code = '') {
		global $wp_rewrite;

		$lang_directory = '';
		$lang_param = '';

		// adapted for WPML
		global $sitepress, $ALSP_ADIMN_SETTINGS;
		if ($lang_code && function_exists('wpml_object_id_filter') && $sitepress) {
			if ($sitepress->get_setting('language_negotiation_type') == 1 && ($lang_code != $sitepress->get_default_language() || $sitepress->get_setting('use_directory'))) {
				$lang_directory = $lang_code . '/';
			} elseif ($sitepress->get_setting('language_negotiation_type') == 3 && $lang_code != $sitepress->get_default_language()) {
				$lang_param = '\?lang='.$lang_code;
			}
		}

		$page_url = $this->index_page_slug;
		
		foreach (get_post_ancestors($this->index_page_id) AS $parent_id) {
			$parent = get_page($parent_id);
			$page_url = $parent->post_name . '/' . $page_url;
		}
		
		$rules[$lang_directory.'(' . $page_url . ')/' . $wp_rewrite->pagination_base . '/?([0-9]{1,})/?' . $lang_param . '$'] = 'index.php?page_id=' .  $this->index_page_id . '&paged=$matches[2]';
		$rules[$lang_directory.'(' . $page_url . ')/?' . $lang_param . '$'] = 'index.php?page_id=' .  $this->index_page_id;
		
		$rules[$lang_directory.'(' . $page_url . ')?/?' . $ALSP_ADIMN_SETTINGS['alsp_category_slug'] . '/(.+?)/' . $wp_rewrite->pagination_base . '/?([0-9]{1,})/?' . $lang_param . '$'] = 'index.php?page_id=' .  $this->index_page_id . '&category-alsp=$matches[2]&paged=$matches[3]';
		$rules[$lang_directory.'(' . $page_url . ')?/?' . $ALSP_ADIMN_SETTINGS['alsp_category_slug'] . '/(.+?)/?' . $lang_param . '$'] = 'index.php?page_id=' .  $this->index_page_id . '&category-alsp=$matches[2]';
		
		$rules[$lang_directory.'(' . $page_url . ')?/?' . $ALSP_ADIMN_SETTINGS['alsp_location_slug'] . '/(.+?)/' . $wp_rewrite->pagination_base . '/?([0-9]{1,})/?' . $lang_param . '$'] = 'index.php?page_id=' .  $this->index_page_id . '&location-alsp=$matches[2]&paged=$matches[3]';
		$rules[$lang_directory.'(' . $page_url . ')?/?' . $ALSP_ADIMN_SETTINGS['alsp_location_slug'] . '/(.+?)/?' . $lang_param . '$'] = 'index.php?page_id=' .  $this->index_page_id . '&location-alsp=$matches[2]';
		
		$rules[$lang_directory.'(' . $page_url . ')?/?' . $ALSP_ADIMN_SETTINGS['alsp_tag_slug'] . '/([^\/.]+)/' . $wp_rewrite->pagination_base . '/?([0-9]{1,})/?' . $lang_param . '$'] = 'index.php?page_id=' .  $this->index_page_id . '&tag-alsp=$matches[2]&paged=$matches[3]';
		$rules[$lang_directory.'(' . $page_url . ')?/?' . $ALSP_ADIMN_SETTINGS['alsp_tag_slug'] . '/([^\/.]+)/?' . $lang_param . '$'] = 'index.php?page_id=' .  $this->index_page_id . '&tag-alsp=$matches[2]';
		
		if ($this->listing_page_id)
			$listing_page_id = $this->listing_page_id;
		else
			$listing_page_id = $this->index_page_id;

		$rules[$lang_directory.$page_url . '/([^\/.]+)/?' . $lang_param . '$'] = 'index.php?page_id=' . $listing_page_id . '&listing-alsp=$matches[1]';
		if (strpos(get_option('permalink_structure'), '/%post_id%/%postname%') === FALSE) {
			// /%post_id%/%postname%/ will not work when the same structure enabled for native WP posts
			// also avoid mismatches with archive pages with /%year%/%monthnum%/ permalinks structure
			$rules[$lang_directory.'(' . $page_url . ')?/?(?!(?:199[0-9]|20[012][0-9])/(?:0[1-9]|1[012]))([0-9]+)/([^\/.]+)/?' . $lang_param . '$'] = 'index.php?page_id=' . $listing_page_id . '&listing-alsp=$matches[3]';
		}
		
		$rules[$lang_directory.'(' . $page_url . ')?/?' . $ALSP_ADIMN_SETTINGS['alsp_listing_slug'] . '/(.+?)/([^\/.]+)/?' . $lang_param . '$'] = 'index.php?page_id=' . $listing_page_id . '&tax-slugs-alsp=$matches[2]&listing-alsp=$matches[3]';
		$rules[$lang_directory.'(' . $page_url . ')?/?' . $ALSP_ADIMN_SETTINGS['alsp_listing_slug'] . '/([^\/.]+)/?' . $lang_param . '$'] = 'index.php?page_id=' . $listing_page_id . '&listing-alsp=$matches[2]';
		
		return $rules;
	}
	
	public function wp_loaded() {
		if ($rules = get_option('rewrite_rules'))
			foreach ($this->alsp_addRules() as $key=>$value) {
				if (!isset($rules[$key]) || $rules[$key] != $value) {
					global $wp_rewrite;
					$wp_rewrite->flush_rules();
					return;
				}
			}
	}
	
	public function prevent_wrong_redirect($redirect_url, $requested_url) {
		
		if ($this->frontend_controllers) {
			// add/remove www. into/from $requested_url when needed
			$user_home = @parse_url(home_url());
			if (!empty($user_home['host'])) {
				if (strpos($user_home['host'], 'www.') === 0) {
					$requested_home = @parse_url($requested_url);
					if (!empty($requested_home['host'])) {
						if (strpos($requested_home['host'], 'www.') !== 0) {
							$requested_url = str_replace($requested_home['host'], 'www.'.$requested_home['host'], $requested_url);
						}
					}
				} else {
					$requested_home = @parse_url($requested_url);
					if (!empty($requested_home['host'])) {
						if (strpos($requested_home['host'], 'www.') === 0) {
							$pos = strpos($requested_url, 'www.');
							$requested_url = substr_replace($requested_url, '', $pos, 4);
						}
					}
				}
			}
			return $requested_url;
		}
	
		return $redirect_url;
	}

	public function listing_permalink($permalink, $post, $leavename) {
		if ($post->post_type == ALSP_POST_TYPE) {
			global $wp_rewrite, $ALSP_ADIMN_SETTINGS;
			if ($wp_rewrite->using_permalinks()) {
				if ($leavename)
					$postname = '%postname%';
				else
					$postname = $post->post_name;

				switch ($ALSP_ADIMN_SETTINGS['alsp_permalinks_structure']) {
					case 'post_id':
						return alsp_directoryUrl($post->ID . '/' . $postname);
						break;
					case 'postname':
						if (get_option('page_on_front') == $this->index_page_id)
							return alsp_directoryUrl($post->ID . '/' . $postname);
						else
							return alsp_directoryUrl($postname);
						break;
					case 'listing_slug':
						if ($ALSP_ADIMN_SETTINGS['alsp_listing_slug'])
							return alsp_directoryUrl($ALSP_ADIMN_SETTINGS['alsp_listing_slug'] . '/' . $postname);
						else
							if (get_option('page_on_front') == $this->index_page_id)
								return alsp_directoryUrl($post->ID . '/' . $postname);
							else
								return alsp_directoryUrl($postname);
						break;
					case 'category_slug':
						if ($ALSP_ADIMN_SETTINGS['alsp_listing_slug'] && $ALSP_ADIMN_SETTINGS['alsp_category_slug'] && ($terms = get_the_terms($post->ID, ALSP_CATEGORIES_TAX))) {
							$term = array_shift($terms);
							if ($cur_term = alsp_get_term_by_path(get_query_var('category-alsp'))) {
								foreach ($terms AS $lterm) {
									$term_path_ids = alsp_get_term_parents_ids($lterm->term_id, ALSP_CATEGORIES_TAX);
									if ($cur_term->term_id == $lterm->term_id) { $term = $lterm; break; }  // exact term much more better
									if (in_array($cur_term->term_id, $term_path_ids)) { $term = $lterm; break; }
								}
							}
							$uri = '';
							if ($parents = alsp_get_term_parents_slugs($term->term_id, ALSP_CATEGORIES_TAX))
								$uri = implode('/', $parents);
							return alsp_directoryUrl($ALSP_ADIMN_SETTINGS['alsp_listing_slug'] . '/' . $uri . '/' . $postname);
						} else
							if (get_option('page_on_front') == $this->index_page_id)
								return alsp_directoryUrl($post->ID . '/' . $postname);
							else
								return alsp_directoryUrl($postname);
						break;
					case 'location_slug':
						if ($ALSP_ADIMN_SETTINGS['alsp_listing_slug'] && $ALSP_ADIMN_SETTINGS['alsp_location_slug'] && ($terms = get_the_terms($post->ID, ALSP_LOCATIONS_TAX)) && ($term = array_shift($terms))) {
							if ($cur_term = alsp_get_term_by_path(get_query_var('location-alsp'))) {
								foreach ($terms AS $lterm) {
									$term_path_ids = alsp_get_term_parents_ids($lterm->term_id, ALSP_LOCATIONS_TAX);
									if ($cur_term->term_id == $lterm->term_id) { $term = $lterm; break; }  // exact term much more better
									if (in_array($cur_term->term_id, $term_path_ids)) { $term = $lterm; break; }
								}
							}
							$uri = '';
							if ($parents = alsp_get_term_parents_slugs($term->term_id, ALSP_LOCATIONS_TAX))
								$uri = implode('/', $parents);
							return alsp_directoryUrl($ALSP_ADIMN_SETTINGS['alsp_listing_slug'] . '/' . $uri . '/' . $postname);
						} else {
							if (get_option('page_on_front') == $this->index_page_id)
								return alsp_directoryUrl($post->ID . '/' . $postname);
							else
								return alsp_directoryUrl($postname);
						}
						break;
					case 'tag_slug':
						if ($ALSP_ADIMN_SETTINGS['alsp_listing_slug'] && $ALSP_ADIMN_SETTINGS['alsp_tag_slug'] && ($terms = get_the_terms($post->ID, ALSP_TAGS_TAX)) && ($term = array_shift($terms))) {
							return alsp_directoryUrl($ALSP_ADIMN_SETTINGS['alsp_listing_slug'] . '/' . $term->slug . '/' . $postname);
						} else
							if (get_option('page_on_front') == $this->index_page_id)
								return alsp_directoryUrl($post->ID . '/' . $postname);
							else
								return alsp_directoryUrl($postname);
						break;
					default:
						if (get_option('page_on_front') == $this->index_page_id)
							return alsp_directoryUrl($post->ID . '/' . $postname);
						else
							return alsp_directoryUrl($postname);
				}
			} else
				return alsp_ListingUrl($post->post_name);
		}
		return $permalink;
	}

	public function category_permalink($permalink, $category, $tax) {
		if ($tax == ALSP_CATEGORIES_TAX) {
			global $wp_rewrite, $ALSP_ADIMN_SETTINGS;
			if ($wp_rewrite->using_permalinks()) {
				$uri = '';
				if ($parents = alsp_get_term_parents_slugs($category->term_id, ALSP_CATEGORIES_TAX))
					$uri = implode('/', $parents);
				return alsp_directoryUrl($ALSP_ADIMN_SETTINGS['alsp_category_slug'] . '/' . $uri);
			} else
				return alsp_directoryUrl(array('category-alsp' => $category->slug));
		}
		return $permalink;
	}

	public function location_permalink($permalink, $location, $tax) {
		if ($tax == ALSP_LOCATIONS_TAX) {
			global $wp_rewrite, $ALSP_ADIMN_SETTINGS;
			if ($wp_rewrite->using_permalinks()) {
				$uri = '';
				if ($parents = alsp_get_term_parents_slugs($location->term_id, ALSP_LOCATIONS_TAX))
					$uri = implode('/', $parents);
				return alsp_directoryUrl($ALSP_ADIMN_SETTINGS['alsp_location_slug'] . '/' . $uri);
			} else
				return alsp_directoryUrl(array('location-alsp' => $location->slug));
		}
		return $permalink;
	}

	public function tag_permalink($permalink, $tag, $tax) {
		if ($tax == ALSP_TAGS_TAX) {
			global $wp_rewrite, $ALSP_ADIMN_SETTINGS;
			if ($wp_rewrite->using_permalinks())
				return alsp_directoryUrl($ALSP_ADIMN_SETTINGS['alsp_tag_slug'] . '/' . $tag->slug);
			else
				return alsp_directoryUrl(array('tag-alsp' => $tag->slug));
		}
		return $permalink;
	}
	
	public function reserve_slugs($is_bad_flat_slug, $slug) {
		global $ALSP_ADIMN_SETTINGS;
		if (in_array($slug, array($ALSP_ADIMN_SETTINGS['alsp_listing_slug'], $ALSP_ADIMN_SETTINGS['alsp_category_slug'], $ALSP_ADIMN_SETTINGS['alsp_location_slug'], $ALSP_ADIMN_SETTINGS['alsp_tag_slug'])))
			return true;
		return $is_bad_flat_slug;
	}

	public function register_post_type() {
		global $ALSP_ADIMN_SETTINGS;
		$args = array(
			'labels' => array(
				'name' => __('Listings', 'ALSP'),
				'singular_name' => __('Listing', 'ALSP'),
				'add_new' => __('Create new listing', 'ALSP'),
				'add_new_item' => __('Create new listing', 'ALSP'),
				'edit_item' => __('Edit listing', 'ALSP'),
				'new_item' => __('New listing', 'ALSP'),
				'view_item' => __('View listing', 'ALSP'),
				'search_items' => __('Search listings', 'ALSP'),
				'not_found' =>  __('No listings found', 'ALSP'),
				'not_found_in_trash' => __('No listings found in trash', 'ALSP')
			),
			'has_archive' => true,
			'description' => __('Listings', 'ALSP'),
			'public' => true,
			'exclude_from_search' => false, // this must be false otherwise it breaks pagination for custom taxonomies
			'supports' => array('title', 'author', 'comments'),
			'menu_icon' => ALSP_RESOURCES_URL . 'images/menuicon.png',
		);
		if ($ALSP_ADIMN_SETTINGS['alsp_enable_description'])
			$args['supports'][] = 'editor';
		if ($ALSP_ADIMN_SETTINGS['alsp_enable_summary'])
			$args['supports'][] = 'excerpt';
		register_post_type(ALSP_POST_TYPE, $args);
		
		register_taxonomy(ALSP_CATEGORIES_TAX, ALSP_POST_TYPE, array(
				'hierarchical' => true,
				'has_archive' => true,
				'labels' => array(
					'name' =>  __('Listing categories', 'ALSP'),
					'menu_name' =>  __('Listing categories', 'ALSP'),
					'singular_name' => __('Category', 'ALSP'),
					'add_new_item' => __('Create category', 'ALSP'),
					'new_item_name' => __('New category', 'ALSP'),
					'edit_item' => __('Edit category', 'ALSP'),
					'view_item' => __('View category', 'ALSP'),
					'update_item' => __('Update category', 'ALSP'),
					'search_items' => __('Search categories', 'ALSP'),
				),
			)
		);
		register_taxonomy(ALSP_LOCATIONS_TAX, ALSP_POST_TYPE, array(
				'hierarchical' => true,
				'has_archive' => true,
				'labels' => array(
					'name' =>  __('Listing locations', 'ALSP'),
					'menu_name' =>  __('Listing locations', 'ALSP'),
					'singular_name' => __('Location', 'ALSP'),
					'add_new_item' => __('Create location', 'ALSP'),
					'new_item_name' => __('New location', 'ALSP'),
					'edit_item' => __('Edit location', 'ALSP'),
					'view_item' => __('View location', 'ALSP'),
					'update_item' => __('Update location', 'ALSP'),
					'search_items' => __('Search locations', 'ALSP'),
					
				),
			)
		);
		register_taxonomy(ALSP_TAGS_TAX, ALSP_POST_TYPE, array(
				'hierarchical' => false,
				'labels' => array(
					'name' =>  __('Listing tags', 'ALSP'),
					'menu_name' =>  __('Listing tags', 'ALSP'),
					'singular_name' => __('Tag', 'ALSP'),
					'add_new_item' => __('Create tag', 'ALSP'),
					'new_item_name' => __('New tag', 'ALSP'),
					'edit_item' => __('Edit tag', 'ALSP'),
					'view_item' => __('View tag', 'ALSP'),
					'update_item' => __('Update tag', 'ALSP'),
					'search_items' => __('Search tags', 'ALSP'),
				),
			)
		);
	}

	public function suspend_expired_listings() {
		global $wpdb, $ALSP_ADIMN_SETTINGS;

		$posts_ids = $wpdb->get_col($wpdb->prepare("
				SELECT
					wp_pm1.post_id
				FROM
					{$wpdb->postmeta} AS wp_pm1
				LEFT JOIN
					{$wpdb->postmeta} AS wp_pm2 ON wp_pm1.post_id=wp_pm2.post_id
				LEFT JOIN
					{$wpdb->posts} AS wp_posts ON wp_pm1.post_id=wp_posts.ID
				LEFT JOIN
					{$wpdb->alsp_levels_relationships} AS wp_lr ON wp_lr.post_id=wp_pm1.post_id
				LEFT JOIN
					{$wpdb->alsp_levels} AS wp_l ON wp_l.id=wp_lr.level_id
				WHERE
					wp_pm1.meta_key = '_expiration_date' AND
					wp_pm1.meta_value < %d AND
					wp_pm2.meta_key = '_listing_status' AND
					(wp_pm2.meta_value = 'active' OR wp_pm2.meta_value = 'stopped') AND
					(wp_l.eternal_active_period = '0')
			", current_time('timestamp')));
		$listings_ids_to_suspend = $posts_ids;
		foreach ($posts_ids AS $post_id) {
			if (!get_post_meta($post_id, '_expiration_notification_sent', true) && $listing = alsp_getListing($post_id)) {
				if ($ALSP_ADIMN_SETTINGS['alsp_expiration_notification']) {
					$listing_owner = get_userdata($listing->post->post_author);
			
					$subject = __('Expiration notification', 'ALSP');
			
					$body = str_replace('[listing]', $listing->title(),
							str_replace('[link]', (($ALSP_ADIMN_SETTINGS['alsp_fsubmit_addon'] && isset($this->dashboard_page_url) && $this->dashboard_page_url) ? alsp_dashboardUrl(array('alsp_action' => 'renew_listing', 'listing_id' => $post_id)) : admin_url('options.php?page=alsp_renew&listing_id=' . $post_id)),
							$ALSP_ADIMN_SETTINGS['alsp_expiration_notification']));
					alsp_mail($listing_owner->user_email, $subject, $body);
					
					add_post_meta($post_id, '_expiration_notification_sent', true);
				}
			}

			// adapted for WPML
			global $sitepress;
			if (function_exists('wpml_object_id_filter') && $sitepress) {
				$trid = $sitepress->get_element_trid($post_id, 'post_' . ALSP_POST_TYPE);
				$translations = $sitepress->get_element_translations($trid, 'post_' . ALSP_POST_TYPE, false, true);
				foreach ($translations AS $lang=>$translation) {
					$listings_ids_to_suspend[] = $translation->element_id;
				}
			} else {
				$listings_ids_to_suspend[] = $post_id;
			}
		}
		$listings_ids_to_suspend = array_unique($listings_ids_to_suspend);
		foreach ($listings_ids_to_suspend AS $listing_id) {
			update_post_meta($listing_id, '_listing_status', 'expired');
			wp_update_post(array('ID' => $listing_id, 'post_status' => 'draft')); // This needed in order terms counts were always actual
			
			$listing = alsp_getListing($listing_id);
			if ($listing->level->change_level_id && ($new_level = $this->levels->getLevelById($listing->level->change_level_id))) {
				if ($wpdb->query("UPDATE {$wpdb->alsp_levels_relationships} SET level_id=" . $new_level->id . "  WHERE post_id=" . $listing->post->ID)) {
					$listing->setLevelByPostId($listing->post->ID);
				
					$continue = true;
					$continue_invoke_hooks = true;
					apply_filters('alsp_listing_renew', $continue, $listing, array(&$continue_invoke_hooks));
				}
			}
		}

		$posts_ids = $wpdb->get_col($wpdb->prepare("
				SELECT
					wp_pm1.post_id
				FROM
					{$wpdb->postmeta} AS wp_pm1
				LEFT JOIN
					{$wpdb->postmeta} AS wp_pm2 ON wp_pm1.post_id=wp_pm2.post_id
				LEFT JOIN
					{$wpdb->posts} AS wp_posts ON wp_pm1.post_id=wp_posts.ID
				LEFT JOIN
					{$wpdb->alsp_levels_relationships} AS wp_lr ON wp_lr.post_id=wp_pm1.post_id
				LEFT JOIN
					{$wpdb->alsp_levels} AS wp_l ON wp_l.id=wp_lr.level_id
				WHERE
					wp_pm1.meta_key = '_expiration_date' AND
					wp_pm1.meta_value < %d AND
					wp_pm2.meta_key = '_listing_status' AND
					(wp_pm2.meta_value = 'active' OR wp_pm2.meta_value = 'stopped') AND
					(wp_l.eternal_active_period = '0')
			", current_time('timestamp')+($ALSP_ADIMN_SETTINGS['alsp_send_expiration_notification_days']*86400)));

		$listings_ids = $posts_ids;

		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			foreach ($posts_ids AS $post_id) {
				$trid = $sitepress->get_element_trid($post_id, 'post_' . ALSP_POST_TYPE);
				$listings_ids[] = $trid;
			}
		} else {
			$listings_ids = $posts_ids;
		}

		$listings_ids = array_unique($listings_ids);
		foreach ($listings_ids AS $listing_id) {
			if (!get_post_meta($listing_id, '_preexpiration_notification_sent', true) && ($listing = alsp_getListing($listing_id))) {
				if ($ALSP_ADIMN_SETTINGS['alsp_preexpiration_notification']) {
					$listing_owner = get_userdata($listing->post->post_author);

					$subject = __('Expiration notification', 'ALSP');
					
					$body = str_replace('[listing]', $listing->title(),
							str_replace('[days]', $ALSP_ADIMN_SETTINGS['alsp_send_expiration_notification_days'],
							str_replace('[link]', (($ALSP_ADIMN_SETTINGS['alsp_fsubmit_addon'] && isset($this->dashboard_page_url) && $this->dashboard_page_url) ? alsp_dashboardUrl(array('alsp_action' => 'renew_listing', 'listing_id' => $listing_id)) : admin_url('options.php?page=alsp_renew&listing_id=' . $listing_id)),
							$ALSP_ADIMN_SETTINGS['alsp_preexpiration_notification'])));
					alsp_mail($listing_owner->user_email, $subject, $body);
					
					add_post_meta($listing_id, '_preexpiration_notification_sent', true);
				}

				$continue_invoke_hooks = true;
				if ($listing = $this->listings_manager->loadListing($listing_id)) {
					apply_filters('alsp_listing_renew', false, $listing, array(&$continue_invoke_hooks));
				}
			}
		}
	}

	/**
	 * Special template for listings printing functionality
	 */
	public function printlisting_template($template) {
		if ((is_page($this->index_page_id) || is_page($this->listing_page_id)) && ($this->action == 'printlisting' || $this->action == 'pdflisting')) {
			if (!($template = alsp_isFrontPart('frontend/listing_print.tpl.php')) && !($template = alsp_isFrontPart('frontend/listing_print-custom.tpl.php'))) {
				$template = alsp_isFrontPart('frontend/listing_print.tpl.php');
			}
		}
		return $template;
	}
	
	function filter_comment_status($open, $post_id) {
		global $ALSP_ADIMN_SETTINGS;
		$post = get_post($post_id);
		if ($post->post_type == ALSP_POST_TYPE) {
			if ($ALSP_ADIMN_SETTINGS['alsp_listings_comments_mode'] == 'enabled')
				return true;
			elseif ($ALSP_ADIMN_SETTINGS['alsp_listings_comments_mode'] == 'disabled')
				return false;
			else 
				return $open;
		} else
			return $open;
	}

	/**
	 * Get property by shortcode name
	 * 
	 * @param string $shortcode
	 * @param string $property if property missed - return controller object
	 * @return mixed
	 */
	public function getShortcodeProperty($shortcode, $property = false) {
		if (!isset($this->frontend_controllers[$shortcode]) || !isset($this->frontend_controllers[$shortcode][0]))
			return false;

		if ($property && !isset($this->frontend_controllers[$shortcode][0]->$property))
			return false;

		if ($property)
			return $this->frontend_controllers[$shortcode][0]->$property;
		else 
			return $this->frontend_controllers[$shortcode][0];
	}
	
	public function getShortcodeByHash($hash) {
		if (!isset($this->frontend_controllers) || !is_array($this->frontend_controllers) || empty($this->frontend_controllers))
			return false;

		foreach ($this->frontend_controllers AS $shortcodes)
			foreach ($shortcodes AS $controller)
				if (is_object($controller) && $controller->hash == $hash)
					return $controller;
	}
	
	public function getListingsShortcodeByuID($uid) {
		foreach ($this->frontend_controllers AS $shortcodes)
			foreach ($shortcodes AS $controller)
				if (is_object($controller) && get_class($controller) == 'alsp_listings_controller' && $controller->args['uid'] == $uid)
					return $controller;
	}

	public function enqueue_scripts_styles($load_scripts_styles = false) {
		global $alsp_enqueued, $ALSP_ADIMN_SETTINGS, $pacz_settings;
		if($pacz_settings['minify-css']){
			$css_min = '.min';
		}else{
			$css_min = '';
		}
		if (($this->frontend_controllers || is_author() || is_page() || is_home() || is_404() || $load_scripts_styles) && !$alsp_enqueued) {
			add_action('wp_head', array($this, 'enqueue_global_vars'));

			wp_register_style('alsp_bootstrap', ALSP_RESOURCES_URL . 'css/bootstrap.css');
			
				wp_register_style('alsp_frontend', ALSP_RESOURCES_URL . 'css/frontend' . $css_min . '.css');
				wp_register_style('alsp_font_awesome', ALSP_RESOURCES_URL . 'css/font-awesome.css');
				if(class_exists('Classiadspro_Theme')){
					wp_register_style('alsp-font-icons', PACZ_THEME_STYLES . '/fonticon-custom.min.css');
				}
	
			if ($frontend_custom = alsp_isAssets('css/frontend-custom.css')) {
				wp_register_style('alsp_frontend-custom', $frontend_custom, array(), ALSP_VERSION);
			}
			if ($pacz_settings['minify-js']) {
					wp_register_script('alsp_js_functions', ALSP_RESOURCES_URL . 'js/js_functions.min.js', array('jquery'), false, true);
					wp_register_script('alsp_categories_scripts', ALSP_RESOURCES_URL . 'js/manage_categories.min.js', array('jquery'), false, true);
				}else{
					wp_register_script('alsp_js_functions', ALSP_RESOURCES_URL . 'js/js_functions.js', array('jquery'), false, true);
					wp_register_script('alsp_categories_scripts', ALSP_RESOURCES_URL . 'js/manage_categories.js', array('jquery'), false, true);
				}

			wp_register_style('alsp_media_styles', ALSP_RESOURCES_URL . 'lightbox/css/lightbox.min.css');
			wp_register_script('alsp_media_scripts_lightbox', ALSP_RESOURCES_URL . 'lightbox/js/lightbox.min.js', array('jquery'), false, true);
			wp_register_script('alsp_media_scripts', ALSP_RESOURCES_URL . 'js/ajaxfileupload.min.js', array('jquery'), false, true);
			wp_register_style('alsp-jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.min.css');

			wp_register_script('alsp_google_maps_edit', ALSP_RESOURCES_URL . 'js/google_maps_edit.js', array('jquery'), false, true);
			
			if (function_exists('is_rtl') && is_rtl()){
				wp_register_style('alsp_frontend_rtl', ALSP_RESOURCES_URL . 'css/frontend-rtl' . $css_min . '.css');
			}
			
			wp_enqueue_style('alsp_frontend');
			wp_enqueue_style('alsp_frontend-custom');
			wp_enqueue_style('alsp_frontend_rtl');
			wp_enqueue_script('jquery-ui-dialog');
			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_style('alsp-jquery-ui-style');
			wp_enqueue_script('alsp_js_functions');
			
			wp_register_style('alsp_listings_slider', ALSP_RESOURCES_URL . 'css/bxslider/jquery.bxslider.css');
			wp_enqueue_style('alsp_listings_slider');

			// Single Listing page
			if ($this->getShortcodeProperty('webdirectory', 'is_single') || $this->getShortcodeProperty('webdirectory-listing', 'is_single')) {
					wp_enqueue_style('alsp_media_styles');
					wp_enqueue_script('alsp_media_scripts_lightbox');
			}
			
			wp_localize_script(
				'alsp_js_functions',
				'alsp_google_maps_callback',
				array(
						'callback' => 'alsp_load_maps_api'
				)
			);
			
			if ($ALSP_ADIMN_SETTINGS['alsp_enable_recaptcha'] && $ALSP_ADIMN_SETTINGS['alsp_recaptcha_public_key'] && $ALSP_ADIMN_SETTINGS['alsp_recaptcha_private_key']) {
				wp_register_script('alsp_recaptcha', '//google.com/recaptcha/api.js');
				wp_enqueue_script('alsp_recaptcha');
			}
			

			$alsp_enqueued = true;
		}
		$page_id = get_queried_object_id();
		$page_object = get_page( $page_id );
		if (!is_author() && !is_404() && !is_search() && !is_archive() && (strpos($page_object->post_content, '[woocommerce_my_account '))){
			wp_register_style('alsp_user_panel', ALSP_FSUBMIT_RESOURCES_URL . 'css/user_panel.min.css');
			wp_register_script('alsp_js_userpanel', ALSP_RESOURCES_URL . 'js/js_userpanel.min.js', array('jquery'), false, true);
			wp_enqueue_style('alsp_user_panel');
			wp_enqueue_script('alsp_js_userpanel');
		}
	}
	
	public function enqueue_global_vars() {
		global $ALSP_ADIMN_SETTINGS;
		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			$ajaxurl = admin_url('admin-ajax.php?lang=' .  $sitepress->get_current_language());
		} else
			$ajaxurl = admin_url('admin-ajax.php');

		echo '
<script>
';
		echo 'var alsp_controller_args_array = {};
';
		echo 'var alsp_map_markers_attrs_array = [];
';
		echo 'var alsp_map_markers_attrs = (function(map_id, markers_array, enable_radius_cycle, enable_clusters, show_summary_button, show_readmore_button, draw_panel, map_style_name, enable_full_screen, enable_wheel_zoom, enable_dragging_touchscreens, center_map_onclick, map_attrs) {
		this.map_id = map_id;
		this.markers_array = markers_array;
		this.enable_radius_cycle = enable_radius_cycle;
		this.enable_clusters = enable_clusters;
		this.show_summary_button = show_summary_button;
		this.show_readmore_button = show_readmore_button;
		this.draw_panel = draw_panel;
		this.map_style_name = map_style_name;
		this.enable_full_screen = enable_full_screen;
		this.enable_wheel_zoom = enable_wheel_zoom;
		this.enable_dragging_touchscreens = enable_dragging_touchscreens;
		this.center_map_onclick = center_map_onclick;
		this.map_attrs = map_attrs;
		});
';
		global $alsp_maps_styles;
		if($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 15){
			$in_favourites_icon = 'pacz-icon-bookmark';
			$not_in_favourites_icon = 'pacz-icon-bookmark-o';
		}else{
			$in_favourites_icon = 'pacz-icon-heart';
			$not_in_favourites_icon = 'pacz-icon-heart-o';
		}
		echo 'var alsp_js_objects = ' . json_encode(
				array(
						'ajaxurl' => $ajaxurl,
						'ajax_loader_url' => ALSP_RESOURCES_URL . 'images/ajax-loader.png',
						'ajax_iloader_url' => ALSP_RESOURCES_URL . 'images/ajax-indicator.gif',
						'ajax_infocloder_url' => ALSP_RESOURCES_URL . 'images/mapclose.png',
						'ajax_loader_text' => __('Loading...', 'ALSP'),
						'search_button_text' => __('Search', 'ALSP'),
						'ajax_map_loader_url' => ALSP_RESOURCES_URL . 'images/ajax-map-loader.gif',
						'in_favourites_icon' => $in_favourites_icon ,
						'not_in_favourites_icon' => $not_in_favourites_icon,
						'in_favourites_msg' => __('Remove Bookmark', 'ALSP'),
						'not_in_favourites_msg' => __('Add Bookmark', 'ALSP'),
						'ajax_load' => (int)$ALSP_ADIMN_SETTINGS['alsp_ajax_load'],
						'ajax_initial_load' => (int)$ALSP_ADIMN_SETTINGS['alsp_ajax_initial_load'],
						'is_rtl' => is_rtl(),
						'send_button_text' => __('Send message', 'ALSP'),
						'send_button_sending' => __('Sending...', 'ALSP'),
						'recaptcha_public_key' => (($ALSP_ADIMN_SETTINGS['alsp_enable_recaptcha'] && $ALSP_ADIMN_SETTINGS['alsp_recaptcha_public_key'] && $ALSP_ADIMN_SETTINGS['alsp_recaptcha_private_key']) ? $ALSP_ADIMN_SETTINGS['alsp_recaptcha_public_key'] : ''),
						'lang' => (($sitepress && get_option('alsp_map_language_from_wpml')) ? ICL_LANGUAGE_CODE : ''),
						'manual_coods' => $ALSP_ADIMN_SETTINGS['alsp_enable_manual_coords'],
				)
		) . ';
';
			
		$map_content_fields = $this->content_fields->getMapContentFields();
		$map_content_fields_icons = array('fa-info-circle');
		foreach ($map_content_fields AS $content_field)
			if (is_a($content_field, 'alsp_content_field') && $content_field->icon_image)
				$map_content_fields_icons[] = $content_field->icon_image;
			else
				$map_content_fields_icons[] = '';
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
						'infowindow_width' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_infowindow_width'],
						'infowindow_offset' => -(int)$ALSP_ADIMN_SETTINGS['alsp_map_infowindow_offset'],
						'infowindow_logo_width' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_infowindow_logo_width'],
						'infowindow_logo_height' => (int)$ALSP_ADIMN_SETTINGS['alsp_map_infowindow_logo_height'],
						'alsp_map_info_window_button_readmore' => __('Read more »', 'ALSP'),
						'alsp_map_info_window_button_summary' => __('« Summary', 'ALSP'),
						'map_style_name' => $ALSP_ADIMN_SETTINGS['alsp_map_style'],
						'draw_area_button' => __('', 'ALSP'),
						'edit_area_button' => __('', 'ALSP'),
						'apply_area_button' => __('', 'ALSP'),
						'reload_map_button' => __('', 'ALSP'),
						'my_location_button' => __('', 'ALSP'),
						'alsp_map_content_fields_icons' => $map_content_fields_icons,
						'map_markers_array' => alsp_get_fa_icons_names(),
						'map_styles' => $alsp_maps_styles,
						'address_autocomplete_code' => $ALSP_ADIMN_SETTINGS['alsp_address_autocomplete_code'],
				)
		) . ';
';
		echo '</script>
';
	}

	// Include dynamically generated css code if css file does not exist.
	/*public function enqueue_dynamic_css($load_scripts_styles = false) {
		if ($this->frontend_controllers || $load_scripts_styles) {
			$upload_dir = wp_upload_dir();
			$filename = trailingslashit(set_url_scheme($upload_dir['baseurl'])) . 'alsp-plugin.css';
			$filename_dir = trailingslashit($upload_dir['basedir']) . 'alsp-plugin.css';
			global $wp_filesystem;
			if (empty($wp_filesystem)) {
				require_once(ABSPATH .'/wp-admin/includes/file.php');
				WP_Filesystem();
			}
			if ((!$wp_filesystem || !trim($wp_filesystem->get_contents($filename_dir))) ||
				// When we are in palettes comparison mode - this will build css according to $_COOKIE['alsp_compare_palettes']
				(isset($_COOKIE['alsp_compare_palettes']) && get_option('alsp_compare_palettes')))
			{
				ob_start();
				include ALSP_PATH . '/classes/customization/dynamic_css.php';
				$dynamic_css = ob_get_contents();
				ob_get_clean();
				echo '<style type="text/css">
	';
				echo $dynamic_css;
				echo '</style>';
			}
		}
	}*/
	
	// adapted for Polylang
	public function pll_setup() {
		if (defined("POLYLANG_VERSION")) {
			add_filter('post_type_link', array($this, 'pll_stop_add_lang_to_url_post'), 0, 2);
			add_filter('post_type_link', array($this, 'pll_start_add_lang_to_url_post'), 100, 2);
			add_filter('term_link', array($this, 'pll_stop_add_lang_to_url_term'), 0, 3);
			add_filter('term_link', array($this, 'pll_start_add_lang_to_url_term'), 100, 3);
			add_filter('rewrite_rules_array', array($this, 'pll_rewrite_rules'));
		}
	}
	public function pll_stop_add_lang_to_url_post($permalink, $post) {
		$this->pll_force_lang = false;
		if ($post->post_type == ALSP_POST_TYPE) {
			global $polylang;
			if (isset($polylang->links->links_model->model->options['force_lang']) && $polylang->links->links_model->model->options['force_lang']) {
				$this->pll_force_lang = true;
				$polylang->links->links_model->model->options['force_lang'] = 0;
			}
		}
		return $permalink;
	}
	public function pll_start_add_lang_to_url_post($permalink, $post) {
		if ($this->pll_force_lang && $post->post_type == ALSP_POST_TYPE) {
			global $polylang;
			$polylang->links->links_model->model->options['force_lang'] = 1;
		}
		return $permalink;
	}
	public function pll_stop_add_lang_to_url_term($permalink, $term, $tax) {
		$this->pll_force_lang = false;
		if ($tax == ALSP_CATEGORIES_TAX || $tax == ALSP_LOCATIONS_TAX || $tax == ALSP_TAGS_TAX) {
			global $polylang;
			if (isset($polylang->links->links_model->model->options['force_lang']) && $polylang->links->links_model->model->options['force_lang']) {
				$this->pll_force_lang = true;
				$polylang->links->links_model->model->options['force_lang'] = 0;
			}
		}
	}
	public function pll_start_add_lang_to_url_term($permalink, $term, $tax) {
		if ($this->pll_force_lang && ($tax == ALSP_CATEGORIES_TAX || $tax == ALSP_LOCATIONS_TAX || $tax == ALSP_TAGS_TAX)) {
			global $polylang;
			$polylang->links->links_model->model->options['force_lang'] = 1;
		}
		return $permalink;
	}
	public function pll_rewrite_rules($rules) {
		global $polylang, $wp_current_filter;
		$wp_current_filter[] = 'alsp_listing';
		return $polylang->links->links_model->rewrite_rules($this->buildRules()) + $rules;
	}
}

$alsp_instance = new alsp_plugin();
$alsp_instance->init();

include_once ALSP_PATH . 'addons/di-report-abuse/di-report-abuse.php';

include_once ALSP_PATH . 'addons/di-frontend-pm/di-frontend-pm.php';


global $ALSP_ADIMN_SETTINGS;
if($ALSP_ADIMN_SETTINGS['alsp_fsubmit_addon']){
	include_once ALSP_PATH . 'addons/alsp_fsubmit/alsp_fsubmit.php';
}
if ($ALSP_ADIMN_SETTINGS['alsp_payments_addon'] == 'alsp_buitin_payment'){
	include_once ALSP_PATH . 'addons/alsp_payments/alsp_payments.php';
}
if ($ALSP_ADIMN_SETTINGS['alsp_ratings_addon'] && $ALSP_ADIMN_SETTINGS['alsp_ratting_type'] == 'new'){
	include_once ALSP_PATH . 'addons/di-reviews/di-reviews.php';
}else{
	include_once ALSP_PATH . 'addons/alsp_ratings/alsp_ratings.php';
}

?>
