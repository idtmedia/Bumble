<?php

define('ALSP_RATINGS_PATH', plugin_dir_path(__FILE__));

function alsp_ratings_loadPaths() {
	define('ALSP_RATINGS_TEMPLATES_PATH',  ALSP_RATINGS_PATH . 'templates/');

	if (!defined('ALSP_THEME_MODE'))
		define('ALSP_RATINGS_RESOURCES_URL', plugins_url('/', __FILE__) . 'resources/');
}
add_action('init', 'alsp_ratings_loadPaths', 0);

define('ALSP_RATING_PREFIX', '_alsp_rating_');
define('ALSP_AVG_RATING_KEY', '_alsp_avg_rating');

include_once ALSP_RATINGS_PATH . 'classes/ratings.php';

class alsp_ratings_plugin {

	public function __construct() {
		register_activation_hook(__FILE__, array($this, 'activation'));
	}
	
	public function activation() {
		include_once(ABSPATH . 'wp-admin/includes/plugin.php');
		if (!defined('ALSP_VERSION')) {
			deactivate_plugins(basename(__FILE__)); // Deactivate ourself
			wp_die("ALSP Ads Listing System Plugin required.");
		}
	}

	public function init() {
		global $alsp_instance;
		
		if (!get_option('alsp_installed_ratings'))
			alsp_install_ratings();
		add_action('alsp_version_upgrade', 'alsp_upgrade_ratings');

		add_filter('alsp_build_settings', array($this, 'plugin_settings'));
		
		add_action('wp_ajax_alsp_save_rating', array($this, 'save_rating'));
		add_action('wp_ajax_nopriv_alsp_save_rating', array($this, 'save_rating'));
		
		add_action('wp_ajax_alsp_flush_ratings', array($this, 'flush_ratings'));
		add_action('wp_ajax_nopriv_alsp_flush_ratings', array($this, 'flush_ratings'));
		
		add_filter('alsp_listing_loading', array($this, 'load_listing'));
		add_filter('alsp_listing_map_loading', array($this, 'load_listing'));

		add_filter('comment_text', array($this, 'rating_in_comment'), 10000);
		
		//add_action('alsp_listing_pre_logo_wrap_html', array($this, 'render_rating'));
		add_action('alsp_listing_title_html', array($this, 'render_rating'), 10, 2);
		add_action('alsp_dashboard_listing_title', array($this, 'render_rating_dashboard'));

		add_filter('alsp_map_info_window_fields', array($this, 'add_rating_field_to_map_window'));
		add_filter('alsp_map_info_window_fields_values', array($this, 'render_rating_in_map_window'), 10, 3);
		
		add_filter('alsp_default_orderby_options', array($this, 'order_by_rating_option'));
		add_filter('alsp_ordering_options', array($this, 'order_by_rating_html'), 10, 3);
		add_filter('alsp_order_args', array($this, 'order_by_rating_args'), 101, 2);
		
		$this->loadRatingsByLevels();
		add_filter('alsp_levels_loading', array($this, 'loadRatingsByLevels'), 10, 2);
		add_filter('alsp_level_html', array($this, 'ratings_options_in_level_html'));
		add_filter('alsp_level_validation', array($this, 'ratings_options_in_level_validation'));
		add_filter('alsp_level_create_edit_args', array($this, 'ratings_options_in_level_create_add'), 1, 2);
		
		add_action('add_meta_boxes', array($this, 'addRatingsMetabox'), 301);

		add_action('alsp_edit_listing_metaboxes_post', array($this, 'frontendRatingsMetabox'));

		add_filter('manage_'.ALSP_POST_TYPE.'_posts_columns', array($this, 'add_listings_table_columns'));
		add_filter('manage_'.ALSP_POST_TYPE.'_posts_custom_column', array($this, 'manage_listings_table_rows'), 10, 2);
		
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
	}
	/**
	 * check is there template in one of these paths:
	 * - themes/theme/alsp-plugin/templates/alsp_payments/
	 * - plugins/alsp/templates/alsp_payments/
	 *
	 */
	public function check_custom_template($template, $args) {
		if (is_array($template)) {
			$template_path = $template[0];
			$template_file = $template[1];
	
			if ($template_path == ALSP_RATINGS_TEMPLATES_PATH && ($fsubmit_template = alsp_isFrontPart('alsp_payments/' . $template_file))) {
				return $fsubmit_template;
			}
		}
		return $template;
	}

	public function loadRatingsByLevels($level = null, $array = array()) {
		global $alsp_instance, $wpdb;
	
		if (!$array && isset($alsp_instance->levels->levels_array)) {
			$array = $wpdb->get_results("SELECT * FROM {$wpdb->alsp_levels} ORDER BY order_num", ARRAY_A);

			foreach ($array AS $row) {
				$alsp_instance->levels->levels_array[$row['id']]->ratings_enabled = $row['ratings_enabled'];
	
				if (is_object($level) && $level->id == $row['id'])
					$level->ratings_enabled = $row['ratings_enabled'];
			}
		} else
			$level->ratings_enabled = $array['ratings_enabled'];
	
		return $level;
	}
	
	public function ratings_options_in_level_html($level) {
		alsp_frontendRender(array(ALSP_RATINGS_TEMPLATES_PATH, 'ratings_options_in_level.tpl.php'), array('level' => $level));
	}
	
	public function ratings_options_in_level_validation($validation) {
		$validation->set_rules('ratings_enabled', __('Ratings', 'ALSP'), 'is_checked');
			
		return $validation;
	}
	
	public function ratings_options_in_level_create_add($insert_update_args, $array) {
		$insert_update_args['ratings_enabled'] = alsp_getValue($array, 'ratings_enabled', 1);
		return $insert_update_args;
	}
	
	public function load_listing($listing) {
		if ($listing->level->ratings_enabled)
			$listing->avg_rating = new alsp_avg_rating($listing->post->ID);
		
		return $listing;
	}
	
	public function addRatingsMetabox($post_type) {
		if ($post_type == ALSP_POST_TYPE && ($level = alsp_getCurrentListingInAdmin()->level) && $level->ratings_enabled) {
			add_meta_box('alsp_ratings',
					__('Listing ratings', 'ALSP'),
					array($this, 'listingRatingsMetabox'),
					ALSP_POST_TYPE,
					'normal',
					'high');
		}
	}
	
	public function listingRatingsMetabox($post) {
		$listing = new alsp_listing();
		$listing->loadListingFromPost($post);

		$total_counts = array('1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0);
		foreach ($listing->avg_rating->ratings AS $rating)
			$total_counts[$rating->value]++;
		
		krsort($total_counts);

		alsp_frontendRender(array(ALSP_RATINGS_TEMPLATES_PATH, 'ratings_metabox.tpl.php'), array('listing' => $listing, 'total_counts' => $total_counts));
	}
	
	public function frontendRatingsMetabox($listing) {
		if ($listing->level->ratings_enabled) {
			echo '<div class="alsp-submit-section">';
				echo '<h3 class="alsp-submit-section-label">' . __('Listing ratings', 'ALSP') . '</h3>';
				echo '<div class="alsp-submit-section-inside">';
					$this->listingRatingsMetabox($listing->post);
				echo '</div>';
			echo '</div>';
		}
	}
	
	public function flush_ratings() {
		$post_id = alsp_getValue($_POST, 'post_id');
		
		if (($post = get_post($post_id)) && ((get_option('alsp_manage_ratings') && alsp_current_user_can_edit_listing($post_id)) || current_user_can('edit_others_posts'))) {
			alsp_flush_ratings($post_id);
		}
		die();
	}
	
	public function add_listings_table_columns($columns) {
		$alsp_columns['alsp_rating'] = __('Rating', 'ALSP');

		$comments_index = array_search("comments", array_keys($columns));

		return array_slice($columns, 0, $comments_index, true) + $alsp_columns + array_slice($columns, $comments_index, count($columns)-$comments_index, true);
	}
	
	public function manage_listings_table_rows($column, $post_id) {
		if ($column == "alsp_rating") {
			$listing = new alsp_listing();
			$listing->loadListingFromPost($post_id);
			$this->render_rating($listing, false, false);
		}
	}
	
	public function save_rating() {
		$post_id = alsp_getValue($_GET, 'post_id');
		$rating = alsp_getValue($_POST, 'rating');
		$_wpnonce = wp_verify_nonce(alsp_getValue($_GET, '_wpnonce'), 'save_rating');

		if (($post = get_post($post_id)) && $rating && ($rating >= 1 && $rating <= 5) && $_wpnonce) {
			if (!$this->is_listing_rated($post->ID)) {
				$user_id = get_current_user_id();
				$ip = alsp_ip_address();
				if (get_option('alsp_only_registered_users') && !$user_id)
					return false;

				if ($user_id)
					add_post_meta($post->ID, ALSP_RATING_PREFIX . $user_id, $rating);
				elseif ($ip)
					add_post_meta($post->ID, ALSP_RATING_PREFIX . $ip, $rating);

				setcookie(ALSP_RATING_PREFIX . $post->ID, $rating, time() + 31536000);

				$avg_rating = new alsp_avg_rating($post->ID);
				$avg_rating->update_avg_rating();
				echo $avg_rating->avg_value;
			} else {
				$avg_rating = new alsp_avg_rating($post->ID);
				echo $avg_rating->avg_value;
			}
		}
		die();
	}
	
	public function is_listing_rated($id) {
		if (!isset($_COOKIE[ALSP_RATING_PREFIX . $id])) {
			if ($user_id = get_current_user_id())
				if (get_post_meta($id, ALSP_RATING_PREFIX . $user_id, true))
					return true;
		
			if ($ip = alsp_ip_address())
				if (get_post_meta($id, ALSP_RATING_PREFIX . $ip, true))
					return true;
		} else {
			return true;
		}
	}

	public function render_rating($listing, $meta_tags = false, $active = true, $show_avg = true) {
		global $alsp_instance;
		
		// Single Listing page
		/* if ($alsp_instance->getShortcodeProperty('webdirectory', 'is_single') || $alsp_instance->getShortcodeProperty('webdirectory-listing', 'is_single')) {
			// Do not render rating at this hook when we are on single listing page
			return ;
		} */

		if ($listing->level->ratings_enabled) {
			if ($this->is_listing_rated($listing->post->ID))
				$active = false;
			if (get_option('alsp_only_registered_users') && !get_current_user_id())
				$active = false;
			if ($alsp_instance->action == 'printlisting' || $alsp_instance->action == 'pdflisting')
				$active = false;
			
			/* if (
				$alsp_instance->getShortcodeProperty('webdirectory') || $alsp_instance->getShortcodeProperty('webdirectory-listings') ||
				$alsp_instance->getShortcodeProperty('webdirectory', 'is_single') || $alsp_instance->getShortcodeProperty('webdirectory-listing')
			)
				$show_avg = false;  */

			alsp_frontendRender(array(ALSP_RATINGS_TEMPLATES_PATH, 'avg_rating.tpl.php'), array('listing' => $listing, 'meta_tags' => $meta_tags, 'active' => $active, 'show_avg' => $show_avg));
		}
		
		return $listing;
	}

	public function render_rating_dashboard($listing) {
		global $alsp_instance;

		if ($listing->level->ratings_enabled)
			alsp_frontendRender(array(ALSP_RATINGS_TEMPLATES_PATH, 'avg_rating.tpl.php'), array('listing' => $listing, 'meta_tags' => false, 'active' => false, 'show_avg' => true));
		
		return $listing;
	}
	
	public function add_rating_field_to_map_window($fields) {
		if (get_option('alsp_rating_on_map'))
			$fields = array('rating' => '') + $fields;

		return $fields;
	}

	public function render_rating_in_map_window($content_field, $field_slug, $listing) {
		if (get_option('alsp_rating_on_map') && $field_slug == 'rating' && $listing->level->ratings_enabled && isset($listing->avg_rating))
			return alsp_frontendRender(array(ALSP_RATINGS_TEMPLATES_PATH, 'avg_rating.tpl.php'), array('listing' => $listing, 'meta_tags' => false, 'active' => false, 'show_avg' => true), true);
	}
	
	public function order_by_rating_args($args, $defaults = array(), $include_GET_params = true) {
		global $ALSP_ADIMN_SETTINGS;
		if (get_option('alsp_orderby_rating')) {
			if ($include_GET_params && isset($_GET['order_by']) && $_GET['order_by']) {
				$order_by = $_GET['order_by'];
				$order = alsp_getValue($_GET, 'order', 'DESC');
			} else {
				if (isset($defaults['order_by']) && $defaults['order_by']) {
					$order_by = $defaults['order_by'];
					$order = alsp_getValue($defaults, 'order', 'DESC');
				}
			}
	
			if (isset($order_by) && $order_by == 'rating_order') {
				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = ALSP_AVG_RATING_KEY;
				$args['order'] = $order;
				if ($ALSP_ADIMN_SETTINGS['alsp_orderby_sticky_featured']) {
					add_filter('get_meta_sql', array($this, 'add_null_values'));
					add_filter('alsp_frontend_controller_construct', array($this, 'remove_query_filters'));
				}
				if ($ALSP_ADIMN_SETTINGS['alsp_orderby_exclude_null']) {
					add_filter('posts_join', 'join_levels');
					add_filter('posts_where', array($this, 'where_ratings_levels'));
					add_filter('alsp_frontend_controller_construct', array($this, 'remove_query_filters'));
				}
			}
		}

		return $args;
	}
	public function where_ratings_levels($where = '') {
		$where .= " AND alsp_levels.ratings_enabled=1";
		return $where;
	}
	/**
	* Listings with empty values must be sorted as well
	*
	*/
	public function add_null_values($clauses) {
		$clauses['where'] = str_replace("wp_postmeta.meta_key = '".ALSP_AVG_RATING_KEY."'", "(wp_postmeta.meta_key = '".ALSP_AVG_RATING_KEY."' OR wp_postmeta.meta_value IS NULL)", $clauses['where']);
		return $clauses;
	}
	public function remove_query_filters() {
		remove_filter('posts_join', 'join_levels');
		remove_filter('posts_where', array($this, 'where_ratings_levels'));
		remove_filter('get_meta_sql', array($this, 'add_null_values'));
	}
	
	public function order_by_rating_option($ordering) {
		if (get_option('alsp_orderby_rating'))
			$ordering['rating_order'] = __('Rating', 'ALSP');
		
		return $ordering;
	}

	public function order_by_rating_html($ordering, $base_url, $defaults = array()) {
		if (get_option('alsp_orderby_rating')) {
			$order_by = false;
			if (isset($_GET['order_by']) && $_GET['order_by']) {
				$order_by = $_GET['order_by'];
				$order = alsp_getValue($_GET, 'order', 'DESC');
			} else {
				if (isset($defaults['order_by']) && $defaults['order_by']) {
					$order_by = $defaults['order_by'];
					$order = alsp_getValue($defaults, 'order', 'DESC');
				}
			}
		
			$class = '';
			$next_order = 'DESC';
			if ($order_by == 'rating_order') {
				if ($order == 'ASC') {
					$class = 'ascending';
					$next_order = 'DESC';
					$url = esc_url(add_query_arg('order_by', 'rating_order', $base_url));
				} elseif (!$order || $order == 'DESC') {
					$class = 'descending';
					$next_order = 'ASC';
					$url = esc_url(add_query_arg(array('order_by' => 'rating_order', 'order' => 'ASC'), $base_url));
				}
			} else
				$url = esc_url(add_query_arg('order_by', 'rating_order', $base_url));
	
			$ordering['links']['rating_order'] = '<a class="' . $class . '" href="' . $url . '">' . __('Rating', 'ALSP') . '</a>';
			$ordering['array']['rating_order'] = __('Rating', 'ALSP');
			$ordering['struct']['rating_order'] = array('class' => $class, 'url' => $url, 'field_name' => __('Rating', 'ALSP'), 'order' => $next_order);
		}
	
		return $ordering;
	}
	
	public function rating_in_comment($output) {
		$comment = 0;
		if (($comment = get_comment($comment)) && ($post = get_post()) && $post->post_type == ALSP_POST_TYPE) {
			if ($rating = alsp_build_single_rating($comment->comment_post_ID, $comment->user_id))
				$output = alsp_frontendRender(array(ALSP_RATINGS_TEMPLATES_PATH, 'single_rating.tpl.php'), array('rating' => $rating), true) . $output;
		}
	
		return $output;
	}

	public function enqueue_scripts_styles($load_scripts_styles = false) {
		global $alsp_instance, $alsp_ratings_enqueued;
		if ((is_admin() || $alsp_instance->frontend_controllers || $load_scripts_styles) && !$alsp_ratings_enqueued) {
			if (!(function_exists('is_rtl') && is_rtl())) {
				wp_register_script('rater', ALSP_RATINGS_RESOURCES_URL . 'js/jquery.rater.js', array('jquery'), false, true);
				wp_register_style('rater', ALSP_RATINGS_RESOURCES_URL . 'css/rater.css');
			} else { 
				wp_register_script('rater', ALSP_RATINGS_RESOURCES_URL . 'js/jquery.rater-rtl.js', array('jquery'), false, true);
				wp_register_style('rater', ALSP_RATINGS_RESOURCES_URL . 'css/rater-rtl.css');
			}
	
			
			if (is_file(ALSP_RATINGS_RESOURCES_URL . 'css/rater-custom.css'))
				wp_register_style('rater-custom', ALSP_RATINGS_RESOURCES_URL . 'css/rater-custom.css');
			
			wp_enqueue_script('rater');
			wp_enqueue_style('rater');
			
			wp_enqueue_style('rater-custom');

			$alsp_ratings_enqueued = true;
		}
	}
}

function alsp_install_ratings() {
	global $wpdb;

	// there may be possible bug in WP, on some servers it doesn't allow to execute more than one SQL query in one request
	$wpdb->query("ALTER TABLE {$wpdb->alsp_levels} ADD `ratings_enabled` tinyint(1) NOT NULL DEFAULT '1' AFTER `google_map_markers`");
	if (array_search('ratings_enabled', $wpdb->get_col("DESC {$wpdb->alsp_levels}"))) {
		add_option('alsp_only_registered_users', 0);
		add_option('alsp_rating_on_map', 1);
		add_option('alsp_manage_ratings', 1);

		alsp_upgrade_ratings('1.5.8');
		
		add_option('alsp_installed_ratings', 1);
	}
}

function alsp_upgrade_ratings($new_version) {
	if ($new_version == '1.5.8') {
		add_option('alsp_orderby_rating', 1);
	}
}

global $alsp_ratings_instance;

$alsp_ratings_instance = new alsp_ratings_plugin();
$alsp_ratings_instance->init();

?>
