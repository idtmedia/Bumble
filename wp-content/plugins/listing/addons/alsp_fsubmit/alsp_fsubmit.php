<?php

define('ALSP_FSUBMIT_PATH', plugin_dir_path(__FILE__));

function alsp_fsubmit_loadPaths() {
	define('ALSP_FSUBMIT_TEMPLATES_PATH', ALSP_FSUBMIT_PATH . 'templates/');
	define('ALSP_FSUBMIT_RESOURCES_PATH', ALSP_FSUBMIT_PATH . 'resources/');
	define('ALSP_FSUBMIT_RESOURCES_URL', plugins_url('/', __FILE__) . 'resources/');
}
add_action('init', 'alsp_fsubmit_loadPaths', 0);

define('ALSP_FSUBMIT_SHORTCODE', 'webdirectory-submit');
define('ALSP_DASHBOARD_SHORTCODE', 'webdirectory-dashboard');

include_once ALSP_FSUBMIT_PATH . 'classes/dashboard_controller.php';
include_once ALSP_FSUBMIT_PATH . 'classes/submit_controller.php';
include_once ALSP_FSUBMIT_PATH . 'classes/levels_table_controller.php';
if(alsp_is_woo_active()){
	include_once ALSP_FSUBMIT_PATH . 'classes/wc/wc.php';
}
global $alsp_wpml_dependent_options;
$alsp_wpml_dependent_options[] = 'alsp_tospage';
$alsp_wpml_dependent_options[] = 'alsp_submit_login_page';
$alsp_wpml_dependent_options[] = 'alsp_dashboard_login_page';

class alsp_fsubmit_plugin {

	public function init() {
		global $alsp_instance, $alsp_shortcodes_init, $ALSP_ADIMN_SETTINGS;
		if (!get_option('alsp_installed_fsubmit'))
			//alsp_install_fsubmit();
			add_action('init', 'alsp_install_fsubmit', 0);
		add_action('alsp_version_upgrade', 'alsp_upgrade_fsubmit');

		//add_filter('alsp_build_settings', array($this, 'plugin_settings'));

		// add new shortcodes for frontend submission and dashboard
		$alsp_shortcodes_init['webdirectory-submit'] = 'alsp_submit_controller';
		$alsp_shortcodes_init['webdirectory-dashboard'] = 'alsp_dashboard_controller';
		$alsp_shortcodes_init['webdirectory-levels-table'] = 'alsp_levels_table_controller';
		add_shortcode('webdirectory-submit', array($alsp_instance, 'renderShortcode'));
		add_shortcode('webdirectory-dashboard', array($alsp_instance, 'renderShortcode'));
		add_shortcode('webdirectory-levels-table', array($alsp_instance, 'renderShortcode'));
		
		add_action('init', array($this, 'getSubmitPage'), 0);
		add_action('init', array($this, 'getDasboardPage'), 0);

		add_filter('alsp_get_edit_listing_link', array($this, 'edit_listings_links'), 10, 2);

		add_action('alsp_directory_frontpanel', array($this, 'add_submit_button'));
		add_action('alsp_directory_frontpanel', array($this, 'add_claim_button'));
		
		add_action('alsp_directory_frontpanel', array($this, 'add_logout_button'));

		add_action('init', array($this, 'remove_admin_bar'));
		if($ALSP_ADIMN_SETTINGS['restrict_non_admin']){
			add_action('admin_init', array($this, 'restrict_dashboard'));
		}
		//add_action('alsp_listing_process_activate', array($this, 'listing_activation_post_status'), 10, 2);
		
		if ($ALSP_ADIMN_SETTINGS['alsp_payments_addon'] == 'alsp_buitin_payment') {
			add_action('show_user_profile', array($this, 'add_user_profile_fields'));
			add_action('edit_user_profile', array($this, 'add_user_profile_fields'));
			add_action('personal_options_update', array($this, 'save_user_profile_fields'));
			add_action('edit_user_profile_update', array($this, 'save_user_profile_fields'));
		}

		add_action('transition_post_status', array($this, 'on_listing_approval'), 10, 3);
		add_action('transition_post_status', array($this, 'on_listing_pending_approval'), 10, 3);
		
		add_filter('no_texturize_shortcodes', array($this, 'alsp_no_texturize'));

		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
	}
	
	public function alsp_no_texturize($shortcodes) {
		$shortcodes[] = 'webdirectory-submit';
		$shortcodes[] = 'webdirectory-dashboard';

		return $shortcodes;
	}
	
	/**
	 * check is there template in one of these paths:
	 * - themes/theme/alsp-plugin/templates/alsp_fsubmit/
	 * - plugins/alsp/templates/alsp_fsubmit/
	 * 
	 */
	public function check_custom_template($template, $args) {
		if (is_array($template)) {
			$template_path = $template[0];
			$template_file = $template[1];
			
			if ($template_path == ALSP_FSUBMIT_TEMPLATES_PATH && ($fsubmit_template = alsp_isFrontPart('alsp_fsubmit/' . $template_file))) {
				return $fsubmit_template;
			}
		}
		return $template;
	}

	public function getSubmitPage() {
		
		global $alsp_instance, $wpdb, $wp_rewrite, $ALSP_ADIMN_SETTINGS;
		
		$alsp_instance->submit_page_url = '';
		$alsp_instance->submit_page_slug = '';
		$alsp_instance->submit_page_id = 0;
		
		if ($submit_page = $wpdb->get_row("SELECT ID AS id, post_name AS slug FROM {$wpdb->posts} WHERE (post_content LIKE '%[" . ALSP_FSUBMIT_SHORTCODE . "]%' OR post_content LIKE '%[" . ALSP_FSUBMIT_SHORTCODE . " %') AND post_status = 'publish' AND post_type = 'page' LIMIT 1", ARRAY_A)) {
			$alsp_instance->submit_page_id = $submit_page['id'];
			$alsp_instance->submit_page_slug = $submit_page['slug'];
			
			// adapted for WPML
			global $sitepress;
			if (function_exists('wpml_object_id_filter') && $sitepress) {
				if ($tpage = apply_filters('wpml_object_id', $alsp_instance->submit_page_id, 'page')) {
					$alsp_instance->submit_page_id = $tpage;
					$alsp_instance->submit_page_slug = get_post($alsp_instance->submit_page_id)->post_name;
				}
			}
			
			if ($wp_rewrite->using_permalinks())
				$alsp_instance->submit_page_url = get_permalink($alsp_instance->submit_page_id);
			else
				$alsp_instance->submit_page_url = add_query_arg('page_id', $alsp_instance->submit_page_id, home_url('/'));
		}

		if ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_button'] && $alsp_instance->submit_page_id === 0 && is_admin())
			alsp_addMessage(sprintf(__("You enabled <b>Listing Frontend submission addon</b>: sorry, but there isn't any page with [webdirectory-submit] shortcode. Create new page with [webdirectory-submit] shortcode or disable Frontend submission addon in settings.", 'ALSP')));
	}

	public function getDasboardPage() {
		global $alsp_instance, $wpdb, $wp_rewrite;
		
		$alsp_instance->dashboard_page_url = '';
		$alsp_instance->dashboard_page_slug = '';
		$alsp_instance->dashboard_page_id = 0;

		if ($dashboard_page = $wpdb->get_row("SELECT ID AS id, post_name AS slug FROM {$wpdb->posts} WHERE post_content LIKE '%[" . ALSP_DASHBOARD_SHORTCODE . "]%' AND post_status = 'publish' AND post_type = 'page' LIMIT 1", ARRAY_A)) {
			$alsp_instance->dashboard_page_id = $dashboard_page['id'];
			$alsp_instance->dashboard_page_slug = $dashboard_page['slug'];
			
			// adapted for WPML
			global $sitepress;
			if (function_exists('wpml_object_id_filter') && $sitepress) {
				if ($tpage = apply_filters('wpml_object_id', $alsp_instance->dashboard_page_id, 'page')) {
					$alsp_instance->dashboard_page_id = $tpage;
					$alsp_instance->dashboard_page_slug = get_post($alsp_instance->dashboard_page_id)->post_name;
				}
			}
			
			if ($wp_rewrite->using_permalinks())
				$alsp_instance->dashboard_page_url = get_permalink($alsp_instance->dashboard_page_id);
			else
				$alsp_instance->dashboard_page_url = add_query_arg('page_id', $alsp_instance->dashboard_page_id, home_url('/'));
		}
	}
	
	public function add_submit_button() {
		
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;
		$page_id = get_queried_object_id();
		$page_object = get_page( $page_id );
		if (strpos(!$page_object->post_content, '[webdirectory-listing]')){
			if ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_button'] && $alsp_instance->submit_page_url)
				echo '<a class="alsp-submit-listing-link btn btn-primary" href="' . alsp_submitUrl() . '" rel="nofollow"><span class="glyphicon glyphicon-plus"></span> ' . __('Submit new listing', 'ALSP') . '</a> ';
		}
	}

	public function add_claim_button($listing) {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;
		$page_id = get_queried_object_id();
		$page_object = get_page( $page_id );
		if (strpos($page_object->post_content, '[webdirectory-listing]') && $ALSP_ADIMN_SETTINGS['alsp_single_listing_style'] == 2){
			if ($listing && $listing->is_claimable && $alsp_instance->dashboard_page_url && $ALSP_ADIMN_SETTINGS['alsp_claim_functionality'] && $listing->post->post_author != get_current_user_id())
				echo '<li><a class="alsp-claim-listing-link" href="' . alsp_dashboardUrl(array('listing_id' => $listing->post->ID, 'alsp_action' => 'claim_listing')) . '" rel="nofollow"></span> ' . __('Claim Ad', 'ALSP') . '</a></li> ';
		}else{
			if ($listing && $listing->is_claimable && $alsp_instance->dashboard_page_url && $ALSP_ADIMN_SETTINGS['alsp_claim_functionality'] && $listing->post->post_author != get_current_user_id())
				echo '<a class="alsp-claim-listing-link btn btn-primary" href="' . alsp_dashboardUrl(array('listing_id' => $listing->post->ID, 'alsp_action' => 'claim_listing')) . '" rel="nofollow"><span class="glyphicon glyphicon-flag"></span> ' . __('Is this your ad?', 'ALSP') . '</a> ';
		}
	}

	public function add_logout_button() {
		global $alsp_instance, $post;
		$page_id = get_queried_object_id();
		$page_object = get_page( $page_id );
		if (strpos(!$page_object->post_content, '[webdirectory-listing]')){
			if ($post->ID == $alsp_instance->dashboard_page_id)
				echo '<a class="alsp-logout-link btn btn-primary" href="' . wp_logout_url(home_url('/')) . '" rel="nofollow"><span class="glyphicon glyphicon-log-out"></span> ' . __('Log out', 'ALSP') . '</a>';
		}
	}
	
	public function remove_admin_bar() {
		global $ALSP_ADIMN_SETTINGS;
		if ($ALSP_ADIMN_SETTINGS['alsp_hide_admin_bar'] && !current_user_can('administrator') && !is_admin()) {
			show_admin_bar(false);
			add_filter('show_admin_bar', '__return_false', 99999);
		}elseif(!$ALSP_ADIMN_SETTINGS['alsp_hide_admin_bar'] && current_user_can('administrator')){
			$current_user = wp_get_current_user();
			$user_id = $current_user->ID ;
			delete_user_meta( $user_id, 'show_admin_bar_front', '');
		}
		
	}

	public function restrict_dashboard() {
		global $alsp_instance, $pagenow;

		if ($pagenow != 'admin-ajax.php' && $pagenow != 'async-upload.php')
			if (!current_user_can('administrator') && is_admin()) {
				alsp_addMessage(__('You can not see dashboard!', 'ALSP'), 'error');
				wp_redirect(alsp_dashboardUrl());
				die();
			}
	}

	public function edit_listings_links($url, $post_id) {
		global $alsp_instance;

		if (!is_admin() && $alsp_instance->dashboard_page_url && ($post = get_post($post_id)) && $post->post_type == ALSP_POST_TYPE)
			return alsp_dashboardUrl(array('alsp_action' => 'edit_listing', 'listing_id' => $post_id));
	
		return $url;
	}
	
	/* public function listing_activation_post_status($listing, $is_renew) {
		if (!$is_renew) {
			if ($listing->post->post_status != 'publish') {
				if (get_option('alsp_fsubmit_default_status') == 1) {
					$post_status = 'pending';
					$message = __('Listing awaiting moderators approval.', 'ALSP');
				} elseif (get_option('alsp_fsubmit_default_status') == 2) {
					$post_status = 'draft';
					$message = __('Listing was saved successfully as draft! Contact site manager, please.', 'ALSP');
				} elseif (get_option('alsp_fsubmit_default_status') == 3) {
					$post_status = 'publish';
					$message = false;
				}
				wp_update_post(array('ID' => $listing->post->ID, 'post_status' => $post_status));
				if ($message)
					alsp_addMessage($message);
			}
		}
	} */
	
	public function add_user_profile_fields($user) { ?>
		<h3><?php _e('Directory billing information', 'ALSP'); ?></h3>
	
		<table class="form-table">
			<tr>
				<th><label for="alsp_billing_name"><?php _e('Full name', 'ALSP'); ?></label></th>
				<td>
					<input type="text" name="alsp_billing_name" id="alsp_billing_name" value="<?php echo esc_attr(get_the_author_meta('alsp_billing_name', $user->ID)); ?>" class="regular-text" /><br />
				</td>
			</tr>
			<tr>
				<th><label for="alsp_billing_address"><?php _e('Full address', 'ALSP'); ?></label></th>
				<td>
					<textarea name="alsp_billing_address" id="alsp_billing_address" cols="30" rows="3"><?php echo esc_textarea(get_the_author_meta('alsp_billing_address', $user->ID)); ?></textarea>
				</td>
			</tr>
		</table>
<?php }

	public function save_user_profile_fields($user_id) {
		if (!current_user_can('edit_user', $user_id))
			return false;

		update_user_meta($user_id, 'alsp_billing_name', $_POST['alsp_billing_name']);
		update_user_meta($user_id, 'alsp_billing_address', $_POST['alsp_billing_address']);
	}

	public function on_listing_approval($new_status, $old_status, $post) {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;

		if ($ALSP_ADIMN_SETTINGS['alsp_approval_notification']) {
			if (
				$post->post_type == ALSP_POST_TYPE &&
				'publish' == $new_status &&
				'pending' == $old_status &&
				($listing = $alsp_instance->listings_manager->loadListing($post)) &&
				($author = get_userdata($listing->post->post_author))
			) {
				$headers[] = "From: " . get_option('blogname') . " <" . alsp_get_admin_notification_email() . ">";
				$headers[] = "Reply-To: " . alsp_get_admin_notification_email();
				$headers[] = "Content-Type: text/html";
					
				$subject = "[" . get_option('blogname') . "] " . __('Approval of listing', 'ALSP');
					
				$body = str_replace('[author]', $author->display_name,
						str_replace('[listing]', $listing->post->post_title,
						str_replace('[link]', alsp_dashboardUrl(),
				$ALSP_ADIMN_SETTINGS['alsp_approval_notification'])));
					
				wp_mail($author->user_email, $subject, $body, $headers);
			}
		}
	}
	public function on_listing_pending_approval($new_status, $old_status, $post) {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;

		if ($ALSP_ADIMN_SETTINGS['alsp_pending_approval_notification']) {
			if (
				$post->post_type == ALSP_POST_TYPE &&
				//'publish' == $new_status &&
				'pending' == $new_status &&
				($listing = $alsp_instance->listings_manager->loadListing($post)) &&
				($author = get_userdata($listing->post->post_author))
			) {
				$headers[] = "From: " . get_option('blogname') . " <" . alsp_get_admin_notification_email() . ">";
				$headers[] = "Reply-To: " . alsp_get_admin_notification_email();
				$headers[] = "Content-Type: text/html";
					
				$subject = "[" . get_option('blogname') . "] " . __('Listing Received', 'ALSP');
					
				$body = str_replace('[author]', $author->display_name,
						str_replace('[listing]', $listing->post->post_title,
						str_replace('[link]', alsp_dashboardUrl(),
				$ALSP_ADIMN_SETTINGS['alsp_pending_approval_notification'])));
					
				wp_mail($author->user_email, $subject, $body, $headers);
			}
		}
	}
	public function enqueue_scripts_styles($load_scripts_styles = false) {
		global $alsp_instance, $alsp_fsubmit_enqueued;
		$page_id = get_queried_object_id();
		$page_object = get_page( $page_id );
		
		if (($alsp_instance->frontend_controllers || $load_scripts_styles) && !$alsp_fsubmit_enqueued) {
			if(!is_author() && !is_404() && !is_search()){
				if (strpos($page_object->post_content, '[webdirectory-dashboard]')){
					wp_register_style('alsp_user_panel', ALSP_FSUBMIT_RESOURCES_URL . 'css/user_panel.css');
					wp_register_script('alsp_js_userpanel', ALSP_RESOURCES_URL . 'js/js_userpanel.min.js', array('jquery'), false, true);
					wp_enqueue_style('alsp_user_panel');
					wp_enqueue_script('alsp_js_userpanel');
				}
			}
			wp_register_style('alsp_fsubmit', ALSP_FSUBMIT_RESOURCES_URL . 'css/submitlisting.css');
			wp_enqueue_style('alsp_fsubmit');
			if (is_file(ALSP_FSUBMIT_RESOURCES_PATH . 'css/submitlisting-custom.css'))
				wp_register_style('alsp_fsubmit-custom', ALSP_FSUBMIT_RESOURCES_URL . 'css/submitlisting-custom.css');
				wp_enqueue_style('alsp_fsubmit-custom');
				
			if (function_exists('is_rtl') && is_rtl())
				wp_register_style('alsp_fsubmit_rtl', ALSP_FSUBMIT_RESOURCES_URL . 'css/submitlisting-rtl.css');
				wp_enqueue_style('alsp_fsubmit_rtl');

			$alsp_fsubmit_enqueued = true;
		}
	}
	
	public function enqueue_login_scripts_styles() {
		global $action;
		$action = 'login';
		do_action('login_enqueue_scripts');
		do_action('login_head');
	}
}

function alsp_install_fsubmit() {
	add_option('alsp_fsubmit_default_status', 3);
	add_option('alsp_fsubmit_login_mode', 1);

	alsp_upgrade_fsubmit('1.5.0');
	alsp_upgrade_fsubmit('1.5.4');
	alsp_upgrade_fsubmit('1.6.2');
	alsp_upgrade_fsubmit('1.8.3');
	alsp_upgrade_fsubmit('1.8.4');
	alsp_upgrade_fsubmit('1.9.0');
	alsp_upgrade_fsubmit('1.9.7');
	alsp_upgrade_fsubmit('1.10.0');
	alsp_upgrade_fsubmit('1.12.7');
	alsp_upgrade_fsubmit('1.13.0');
	
	add_option('alsp_installed_fsubmit', 1);
}

function alsp_upgrade_fsubmit($new_version) {
	if ($new_version == '1.5.0') {
		add_option('alsp_fsubmit_edit_status', 3);
		add_option('alsp_fsubmit_button', 1);
		add_option('alsp_hide_admin_bar', 0);
		add_option('alsp_newuser_notification', 'Hello [author],

your listing "[listing]" was successfully submitted.

You may manage your listing using following credentials:
login: [login]
password: [password]');
	}
	
	if ($new_version == '1.5.4')
		add_option('alsp_allow_edit_profile', 1);

	if ($new_version == '1.6.2')
		add_option('alsp_enable_frontend_translations', 1);

	if ($new_version == '1.8.3') {
		add_option('alsp_claim_functionality', 0);
		add_option('alsp_claim_approval', 1);
		add_option('alsp_after_claim', 'active');
		add_option('alsp_hide_claim_contact_form', 0);
		add_option('alsp_claim_notification', 'Hello [author],

your listing "[listing]" was claimed by [claimer].

You may approve or reject this claim at
[link]

[message]');
		add_option('alsp_claim_approval_notification', 'Hello [claimer],

congratulations, your claim for listing "[listing]" was successfully approved.

Now you may manage your listing at the dashboard
[link]');
		add_option('alsp_newlisting_admin_notification', 'Hello,

user [user] created new listing "[listing]".

You may manage this listing at
[link]');
	}
	
	if ($new_version == '1.8.4') {
		add_option('alsp_enable_tags', 1);
	}

	if ($new_version == '1.9.0') {
		add_option('alsp_tospage', '');
	}

	if ($new_version == '1.9.7') {
		add_option('alsp_hide_claim_metabox', 0);
	}

	if ($new_version == '1.10.0') {
		add_option('alsp_submit_login_page', '');
		add_option('alsp_dashboard_login_page', '');
	}

	if ($new_version == '1.12.7') {
		add_option('alsp_approval_notification', 'Hello [author],

your listing "[listing]" was successfully approved.
				
Now you may manage your listing at the dashboard
[link]');
		add_option('alsp_claim_decline_notification', 'Hello [claimer],

your claim for listing "[listing]" was declined.');
	}
	
	if ($new_version == '1.13.0') {
		add_option('alsp_woocommerce_functionality', 0);
		add_option('alsp_woocommerce_mode', 'both');
	}
}

function alsp_submitUrl($path = '') {
	global $alsp_instance;

	// adapted for WPML
	global $sitepress;
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		if ($sitepress->get_option('language_negotiation_type') == 3) {
			// remove any previous value.
			$alsp_instance->submit_page_url = remove_query_arg('lang', $alsp_instance->submit_page_url);
		}
	}

	if (!is_array($path)) {
		if ($path) {
			// found that on some instances of WP "native" trailing slashes may be missing
			$url = rtrim($alsp_instance->submit_page_url, '/') . '/' . rtrim($path, '/') . '/';
		} else
			$url = $alsp_instance->submit_page_url;
	} else
		$url = add_query_arg($path, $alsp_instance->submit_page_url);

	// adapted for WPML
	global $sitepress;
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		$url = $sitepress->convert_url($url);
	}

	return $url;
}

function alsp_dashboardUrl($path = '') {
	global $alsp_instance;
	
	if ($alsp_instance->dashboard_page_url) {
		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			if ($sitepress->get_option('language_negotiation_type') == 3) {
				// remove any previous value.
				$alsp_instance->dashboard_page_url = remove_query_arg('lang', $alsp_instance->dashboard_page_url);
			}
		}
	
		if (!is_array($path)) {
			if ($path) {
				// found that on some instances of WP "native" trailing slashes may be missing
				$url = rtrim($alsp_instance->dashboard_page_url, '/') . '/' . rtrim($path, '/') . '/';
			} else
				$url = $alsp_instance->dashboard_page_url;
		} else
			$url = add_query_arg($path, $alsp_instance->dashboard_page_url);
	
		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress) {
			$url = $sitepress->convert_url($url);
		}
	} else
		$url = alsp_directoryUrl();

	return $url;
}

global $alsp_fsubmit_instance;

$alsp_fsubmit_instance = new alsp_fsubmit_plugin();
$alsp_fsubmit_instance->init();

?>
