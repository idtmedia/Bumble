<?php 

class alsp_dashboard_controller extends alsp_frontend_controller {

	public function init($args = array(), $args2 = array(), $args3 = array(), $args4 = array()) {
		global $alsp_instance, $alsp_fsubmit_instance, $sitepress, $ALSP_ADIMN_SETTINGS;
		
		parent::init($args,$args2,$args3,$args4);

		if (!is_user_logged_in()) {
			if (alsp_get_wpml_dependent_option('alsp_dashboard_login_page') && alsp_get_wpml_dependent_option('alsp_dashboard_login_page') != get_the_ID()) {
				$url = get_permalink(alsp_get_wpml_dependent_option('alsp_dashboard_login_page'));
				$url = add_query_arg('redirect_to', urlencode(get_permalink()), $url);
				wp_redirect($url);
			} else {
				add_action('wp_enqueue_scripts', array($alsp_fsubmit_instance, 'enqueue_login_scripts_styles'));
				$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'login_form.tpl.php');
			}
		} else {
			if (isset($_POST['referer']))
				$this->referer = $_POST['referer'];
			else
				$this->referer = wp_get_referer();
			if (isset($_POST['cancel']) && isset($_POST['referer'])) {
				wp_redirect($_POST['referer']);
				die();
			}

			if (!$alsp_instance->action) {
				if (get_query_var('page'))
					$paged = get_query_var('page');
				elseif (get_query_var('paged'))
					$paged = get_query_var('paged');
				else
					$paged = 1;
			} else
				$paged = -1;
			
			$args = array(
					'post_type' => ALSP_POST_TYPE,
					//'author' => get_current_user_id(),
					'paged' => $paged,
					'posts_per_page' => 20,
					'post_status' => 'any'
			);
			$args2 = array(
					'post_type' => ALSP_POST_TYPE,
					//'author' => get_current_user_id(),
					'paged' => $paged,
					'posts_per_page' => 20,
					'post_status' => 'publish'
			);
			$args3 = array(
					'post_type' => ALSP_POST_TYPE,
					//'author' => get_current_user_id(),
					'paged' => $paged,
					'posts_per_page' => 20,
					'post_status' => 'draft'
			);
			$args4 = array(
					'post_type' => ALSP_POST_TYPE,
					//'author' => get_current_user_id(),
					'paged' => $paged,
					'posts_per_page' => 20,
					'post_status' => 'pending'
			);
			add_filter('posts_where', array($this, 'add_claimed_listings_where'));
			$this->query = new WP_Query($args);
			$this->query2 = new WP_Query($args2);
			$this->query3 = new WP_Query($args3);
			$this->query4 = new WP_Query($args4);
			remove_filter('posts_where', array($this, 'add_claimed_listings_where'));
			wp_reset_postdata();
			
			$this->listings_count = $this->query->found_posts;
			$this->listings_count2 = $this->query2->found_posts;
			$this->listings_count3 = $this->query3->found_posts;
			$this->listings_count4 = $this->query4->found_posts;
			
			$this->active_tab = 'listings';

			if (!$alsp_instance->action) {
				$this->processQuery(false);

				$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
				$this->subtemplate = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'listings.tpl.php');
			} elseif ($alsp_instance->action == 'edit_listing' && isset($_GET['listing_id']) && is_numeric($_GET['listing_id'])) {
				$listing_id = alsp_getValue($_GET, 'listing_id');
				if ($listing_id && alsp_current_user_can_edit_listing($listing_id)) {
					$listing = $alsp_instance->listings_manager->loadListing($listing_id);
					
					if (isset($_POST['submit'])) {
						$errors = array();

						if (!isset($_POST['post_title']) || !trim($_POST['post_title']) || $_POST['post_title'] == __('Auto Draft')) {
							$errors[] = __('Listing title field required', 'ALSP');
							$post_title = __('Auto Draft');
						} else
							$post_title = trim($_POST['post_title']);
						
						if ($listing->level->categories_number > 0 || $listing->level->unlimited_categories) {
							if ($post_categories_ids = $alsp_instance->categories_manager->validateCategories($listing->level, $_POST, $errors)) {
								foreach ($post_categories_ids AS $key=>$id)
									$post_categories_ids[$key] = intval($id);
							}
							wp_set_object_terms($listing->post->ID, $post_categories_ids, ALSP_CATEGORIES_TAX);
						}

						if ($ALSP_ADIMN_SETTINGS['alsp_enable_tags']) {
							if ($post_tags_ids = $alsp_instance->categories_manager->validateTags($_POST, $errors)) {
								foreach ($post_tags_ids AS $key=>$id)
									$post_tags_ids[$key] = intval($id);
							}
							wp_set_object_terms($listing->post->ID, $post_tags_ids, ALSP_TAGS_TAX);
						}
						
						$alsp_instance->content_fields->saveValues($listing->post->ID, $post_categories_ids, $listing->level->id, $errors, $_POST);
						
						if ($listing->level->locations_number) {
							if ($validation_results = $alsp_instance->locations_manager->validateLocations($errors)) {
								$alsp_instance->locations_manager->saveLocations($listing->level, $listing->post->ID, $validation_results);
							}
						}
						
						if ($listing->level->images_number || $listing->level->videos_number) {
							if ($validation_results = $alsp_instance->media_manager->validateAttachments($listing->level, $errors))
								$alsp_instance->media_manager->saveAttachments($listing->level, $listing->post->ID, $validation_results);
						}
						
						if ($ALSP_ADIMN_SETTINGS['alsp_listing_contact_form'] && $ALSP_ADIMN_SETTINGS['alsp_custom_contact_email']) {
							$alsp_form_validation = new alsp_form_validation();
							$alsp_form_validation->set_rules('contact_email', __('Contact email', 'ALSP'), 'valid_email');
						
							if (!$alsp_form_validation->run()) {
								$errors[] = $alsp_form_validation->error_string();
							} else {
								update_post_meta($listing->post->ID, '_contact_email', $alsp_form_validation->result_array('contact_email'));
								
							}
						}
						if(isset($_POST['post_resurva_url'])){
							if(!metadata_exists('post', $listing->post->ID, '_post_resurva_url' ) ) {
								add_post_meta($listing->post->ID, '_post_resurva_url', $_POST['post_resurva_url']);
							}else{
								update_post_meta($listing->post->ID, '_post_resurva_url', $_POST['post_resurva_url']);
							}
						}

						if ($errors) {
							$postarr = array(
									'ID' => $listing_id,
									'post_title' => $post_title,
									'post_content' => (isset($_POST['post_content']) ? $_POST['post_content'] : ''),
									'post_excerpt' => (isset($_POST['post_excerpt']) ? $_POST['post_excerpt'] : ''),
									'price' => (isset($_POST['post_excerpt']) ? $_POST['price'] : ''),
							);
							$result = wp_update_post($postarr, true);
							if (is_wp_error($result))
								$errors[] = $result->get_error_message();

							foreach ($errors AS $error)
								alsp_addMessage($error, 'error');
							$listing = $alsp_instance->listings_manager->loadListing($listing_id);
						} else {
							if (!$listing->level->eternal_active_period && $listing->status != 'expired') {
								if ($ALSP_ADIMN_SETTINGS['alsp_change_expiration_date'] || current_user_can('manage_options')) {
									$alsp_instance->listings_manager->changeExpirationDate();
								} else {
									$expiration_date = alsp_calcExpirationDate(current_time( 'timestamp' ), $listing->level);
									add_post_meta($listing->post->ID, '_expiration_date', $expiration_date);
								}
							}

							if ($ALSP_ADIMN_SETTINGS['alsp_claim_functionality'] && !$ALSP_ADIMN_SETTINGS['alsp_hide_claim_metabox'])
								if (isset($_POST['is_claimable']))
									update_post_meta($listing->post->ID, '_is_claimable', true);
								else
									update_post_meta($listing->post->ID, '_is_claimable', false);

							if ($listing->post->post_status == 'publish') {
								if ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_edit_status'] == 1) {
									$post_status = 'pending';
								} elseif ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_edit_status'] == 2) {
									$post_status = 'draft';
								} elseif ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_edit_status'] == 3 || !$ALSP_ADIMN_SETTINGS['alsp_fsubmit_edit_status']) {
									$post_status = 'publish';
								}
							}
							if ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_edit_status'] == 1) {
								$message = esc_attr__("Listing was saved successfully! Now it's awaiting moderators approval.", 'ALSP');
							} elseif ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_edit_status'] == 2) {
								$message = __('Listing was saved successfully as draft! Contact site manager, please.', 'ALSP');
							} elseif ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_edit_status'] == 3 || !$ALSP_ADIMN_SETTINGS['alsp_fsubmit_edit_status']) {
								$message = __('Listing was saved successfully!', 'ALSP');
							}

							$postarr = array(
									'ID' => $listing_id,
									'post_title' => $post_title,
									'post_content' => (isset($_POST['post_content']) ? $_POST['post_content'] : ''),
									'post_excerpt' => (isset($_POST['post_excerpt']) ? $_POST['post_excerpt'] : ''),
									'price' => (isset($_POST['post_excerpt']) ? $_POST['price'] : ''),
							);
							if (isset($post_status))
								$postarr['post_status'] = $post_status;

							$result = wp_update_post($postarr, true);
							if (is_wp_error($result)) {
								alsp_addMessage($result->get_error_message(), 'error');
							} else {
								alsp_addMessage($message);
								
								if (!$this->referer || $post_status != 'publish')
									$this->referer = alsp_dashboardUrl();
								wp_redirect($this->referer);
								die();
							}
						}
					}

					$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'edit_listing.tpl.php');
					if ($listing->level->categories_number > 0 || $listing->level->unlimited_categories) {
						add_action('wp_enqueue_scripts', array($alsp_instance->categories_manager, 'admin_enqueue_scripts_styles'));
					}
					
					if ($listing->level->locations_number > 0 && $listing->level->google_map) {
						add_action('wp_enqueue_scripts', array($alsp_instance->locations_manager, 'admin_enqueue_scripts_styles'));
					}
	
					if ($listing->level->images_number > 0 || $listing->level->videos_number > 0)
						add_action('wp_enqueue_scripts', array($alsp_instance->media_manager, 'admin_enqueue_scripts_styles'));
				}
			} elseif ($alsp_instance->action == 'raiseup_listing' && isset($_GET['listing_id']) && is_numeric($_GET['listing_id'])) {
				$listing_id = alsp_getValue($_GET, 'listing_id');
				if ($listing_id && alsp_current_user_can_edit_listing($listing_id) && ($listing = $alsp_instance->listings_manager->loadListing($listing_id)) && $listing->status == 'active') {
					$this->action = 'show';
					if (isset($_GET['raiseup_action']) && $_GET['raiseup_action'] == 'raiseup') {
						if ($listing->processRaiseUp())
							alsp_addMessage(__('Listing was raised up successfully!', 'ALSP'));
						/* else
							alsp_addMessage(__('An error has occurred and listing was not raised up', 'ALSP'), 'error'); */
						$this->action = $_GET['raiseup_action'];
						$this->referer = $_GET['referer'];
					}
					$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'raise_up.tpl.php');
				} else
					wp_die('You are not able to manage this listing', 'ALSP');
			} elseif ($alsp_instance->action == 'renew_listing' && isset($_GET['listing_id']) && is_numeric($_GET['listing_id'])) {
				$listing_id = alsp_getValue($_GET, 'listing_id');
				if ($listing_id && alsp_current_user_can_edit_listing($listing_id) && ($listing = $alsp_instance->listings_manager->loadListing($listing_id))) {
					$this->action = 'show';
					if (isset($_GET['renew_action']) && $_GET['renew_action'] == 'renew') {
						if ($listing->processActivate())
							alsp_addMessage(__('Listing was renewed successfully!', 'ALSP'));
						/* else
							alsp_addMessage(__('An error has occurred and listing was not renewed', 'ALSP'), 'error'); */
						$this->action = $_GET['renew_action'];
						$this->referer = $_GET['referer'];
					}
					$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'renew.tpl.php');
				} else
					wp_die('You are not able to manage this listing', 'ALSP');
			} elseif ($alsp_instance->action == 'delete_listing' && isset($_GET['listing_id']) && is_numeric($_GET['listing_id'])) {
				$listing_id = alsp_getValue($_GET, 'listing_id');
				if ($listing_id && alsp_current_user_can_edit_listing($listing_id) && ($listing = $alsp_instance->listings_manager->loadListing($listing_id))) {
					if (isset($_GET['delete_action']) && $_GET['delete_action'] == 'delete') {
						if (wp_delete_post($listing_id, true) !== FALSE) {
							$alsp_instance->listings_manager->delete_listing_data($listing_id);

							alsp_addMessage(__('Listing was deleted successfully!', 'ALSP'));
							wp_redirect(alsp_dashboardUrl());
							die();
						} else 
							alsp_addMessage(__('An error has occurred and listing was not deleted', 'ALSP'), 'error');
					}
					$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'delete.tpl.php');
				} else
					wp_die('You are not able to manage this listing', 'ALSP');
			}elseif ($alsp_instance->action == 'change_status' && isset($_GET['listing_id']) && is_numeric($_GET['listing_id'])) {
				$listing_id = alsp_getValue($_GET, 'listing_id');
				if ($listing_id && alsp_current_user_can_edit_listing($listing_id) && ($listing = $alsp_instance->listings_manager->loadListing($listing_id))) {
					if (isset($_GET['status_action']) && $_GET['status_action'] == 'private') {
						if (wp_update_post($listing_id, true) !== FALSE) {
							//$alsp_instance->listings_manager->delete_listing_data($listing_id);
							wp_update_post(array('ID' => $listing_id, 'post_status' => 'private'));

							alsp_addMessage(__('Listing status was changed successfully!', 'ALSP'));
							wp_redirect(alsp_dashboardUrl());
							die();
						}else{ 
							alsp_addMessage(__('An error has occurred and listing status was not changed', 'ALSP'), 'error');
						}
					} elseif (isset($_GET['status_action']) && $_GET['status_action'] == 'publish') {
						if (wp_update_post($listing_id, true) !== FALSE) {
							//$alsp_instance->listings_manager->delete_listing_data($listing_id);
							wp_update_post(array('ID' => $listing_id, 'post_status' => 'publish'));

							alsp_addMessage(__('Listing status was changed successfully!', 'ALSP'));
							wp_redirect(alsp_dashboardUrl());
							die();
						}else{ 
							alsp_addMessage(__('An error has occurred and listing status was not changed', 'ALSP'), 'error');
						}
							
					}
					if (isset($_POST['post_markas_submit'])) {
						$listingmarkas = $_POST['post_markas'];
						update_post_meta($listing_id, '_listing_mark_as', $listingmarkas);
						alsp_addMessage(__('Listing status was changed successfully!', 'ALSP'));
						wp_redirect(alsp_dashboardUrl());
					}
					$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'change_status.tpl.php');
				} else
					wp_die('You are not able to manage this listing', 'ALSP');
			}elseif ($alsp_instance->action == 'notice_to_admin' && isset($_GET['listing_id']) && is_numeric($_GET['listing_id'])) {
				$listing_id = alsp_getValue($_GET, 'listing_id');
				if ($listing_id && alsp_current_user_can_edit_listing($listing_id) && ($listing = $alsp_instance->listings_manager->loadListing($listing_id))) {
					if (isset($_POST['notice_to_admin_submit'])) {
						$listingnotice = $_POST['_notice_to_admin'];
						update_post_meta($listing_id, '_notice_to_admin', $listingnotice);
						alsp_addMessage(__('Notice sent successfully!', 'ALSP'));
						wp_redirect(alsp_dashboardUrl());
					}
					$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'notice_to_admin.tpl.php');
				} else
					wp_die('You are not able to manage this listing', 'ALSP');
			} elseif ($alsp_instance->action == 'upgrade_listing' && isset($_GET['listing_id']) && is_numeric($_GET['listing_id'])) {
				$listing_id = alsp_getValue($_GET, 'listing_id');
				if ($listing_id && alsp_current_user_can_edit_listing($listing_id) && ($listing = $alsp_instance->listings_manager->loadListing($listing_id)) && $listing->status == 'active') {
					$this->action = 'show';
					if (isset($_GET['upgrade_action']) && $_GET['upgrade_action'] == 'upgrade') {
						$alsp_form_validation = new alsp_form_validation();
						$alsp_form_validation->set_rules('new_level_id', __('New level ID', 'ALSP'), 'required|integer');

						if ($alsp_form_validation->run()) {
							if ($listing->changeLevel($alsp_form_validation->result_array('new_level_id')))
								alsp_addMessage(__('Listing level was changed successfully!', 'ALSP'));
							$this->action = $_GET['upgrade_action'];
						} else
							alsp_addMessage(__('New level must be selected!', 'ALSP'), 'error');

						$this->referer = $_GET['referer'];
					}
					$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'upgrade.tpl.php');
				} else
					wp_die('You are not able to manage this listing', 'ALSP');
			} elseif ($alsp_instance->action == 'view_stats' && isset($_GET['listing_id']) && is_numeric($_GET['listing_id'])) {
				$listing_id = alsp_getValue($_GET, 'listing_id');
				if ($ALSP_ADIMN_SETTINGS['alsp_enable_stats'] && $listing_id && alsp_current_user_can_edit_listing($listing_id) && ($listing = $alsp_instance->listings_manager->loadListing($listing_id))) {
					add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
					$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'view_stats.tpl.php');
				} else
					wp_die('You are not able to manage this listing', 'ALSP');
			} elseif ($alsp_instance->action == 'profile') {
				if ($ALSP_ADIMN_SETTINGS['alsp_allow_edit_profile']) {
					$user_id = get_current_user_id();
					$current_user = wp_get_current_user();
	
					include_once ABSPATH . 'wp-admin/includes/user.php';
	
					if (isset($_POST['user_id'])) {
						if ($_POST['user_id'] == $user_id) {
							global $wpdb;
		
							if (!is_multisite()) {
								$errors = edit_user($user_id);
								if(isset($_POST['alsp_billing_name'])){
									update_user_meta($user_id, 'alsp_billing_name', $_POST['alsp_billing_name']);
								}
								if(isset($_POST['alsp_billing_address'])){
									update_user_meta($user_id, 'alsp_billing_address', $_POST['alsp_billing_address']);
								}
								if($ALSP_ADIMN_SETTINGS['frontend_panel_user_phone']){ update_user_meta($user_id, 'user_phone', $_POST['user_phone']); }
								if($ALSP_ADIMN_SETTINGS['frontend_panel_user_website']){ update_user_meta($user_id, 'user_website', $_POST['user_website']); }
								update_user_meta($user_id, 'address', $_POST['address']);
								if($ALSP_ADIMN_SETTINGS['frontend_panel_social_links']){
									update_user_meta($user_id, 'author_fb', $_POST['author_fb']);
									update_user_meta($user_id, 'author_tw', $_POST['author_tw']);
									update_user_meta($user_id, 'author_linkedin', $_POST['author_linkedin']);
									update_user_meta($user_id, 'author_gplus', $_POST['author_gplus']);
									update_user_meta($user_id, 'author_flickr', $_POST['author_flickr']);
									update_user_meta($user_id, 'author_behance', $_POST['author_behance']);
									update_user_meta($user_id, 'author_dribbble', $_POST['author_dribbble']);
									update_user_meta($user_id, 'author_ytube', $_POST['author_ytube']);
									update_user_meta($user_id, 'author_vimeo', $_POST['author_vimeo']);
									update_user_meta($user_id, 'author_instagram', $_POST['author_instagram']);
								}
								
								if($ALSP_ADIMN_SETTINGS['frontend_panel_user_type']){ update_user_meta($user_id, '_user_type', $_POST['user_type']); }
								
							} else {
								$user = get_userdata($user_id);
							
								// Update the email address in signups, if present.
								if ($user->user_login && isset($_POST['email']) && is_email($_POST['email']) && $wpdb->get_var($wpdb->prepare("SELECT user_login FROM {$wpdb->signups} WHERE user_login = %s", $user->user_login)))
									$wpdb->query($wpdb->prepare("UPDATE {$wpdb->signups} SET user_email = %s WHERE user_login = %s", $_POST['email'], $user->user_login));
							
								// We must delete the user from the current blog if WP added them after editing.
								$delete_role = false;
								$blog_prefix = $wpdb->get_blog_prefix();
								if ($user_id != $current_user->ID) {
									$cap = $wpdb->get_var("SELECT meta_value FROM {$wpdb->usermeta} WHERE user_id = '{$user_id}' AND meta_key = '{$blog_prefix}capabilities' AND meta_value = 'a:0:{}'");
									if (!is_network_admin() && null == $cap && $_POST['role'] == '') {
										$_POST['role'] = 'contributor';
										$delete_role = true;
									}
								}
								if (!isset($errors) || (isset($errors) && is_object($errors) && false == $errors->get_error_codes()))
									$errors = edit_user($user_id);
								if ( $delete_role ) // stops users being added to current blog when they are edited
									delete_user_meta($user_id, $blog_prefix . 'capabilities');
							}
							
							if (!is_wp_error($errors)) {
								alsp_addMessage(__('Your profile was successfully updated!', 'ALSP'));
								wp_redirect(alsp_dashboardUrl(array('alsp_action' => 'profile')));
								die();
							}
						} else
							wp_die('You are not able to manage profile', 'ALSP');
					}
	
					$this->user = get_user_to_edit($user_id);
	
					wp_enqueue_script('password-strength-meter');
					wp_enqueue_script('user-profile');
					
					$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'profile.tpl.php');
					$this->active_tab = 'profile';
				} else
					wp_die('You are not able to manage profile', 'ALSP');
			} elseif ($alsp_instance->action == 'messages') {
				$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'messages.tpl.php');
					$this->active_tab = 'messages';
			}elseif ($alsp_instance->action == 'claim_listing' && isset($_GET['listing_id']) && is_numeric($_GET['listing_id'])) {
				$listing_id = alsp_getValue($_GET, 'listing_id');
				if ($listing_id && ($listing = $alsp_instance->listings_manager->loadListing($listing_id)) && $listing->is_claimable) {
					$claimer_id = get_current_user_id();
					if ($listing->post->post_author != $claimer_id) {
						$this->action = 'show';
						if (isset($_GET['claim_action']) && $_GET['claim_action'] == 'claim') {
							if (isset($_POST['claim_message']) && $_POST['claim_message'])
								$claimer_message = $_POST['claim_message'];
							else
								$claimer_message = '';
							if ($listing->claim->updateRecord($claimer_id, $claimer_message, 'pending')) {
								update_post_meta($listing->post->ID, '_is_claimable', false);
								if ($ALSP_ADIMN_SETTINGS['alsp_claim_approval']) {
									if ($ALSP_ADIMN_SETTINGS['alsp_claim_notification']) {
										$author = get_userdata($listing->post->post_author);
										$claimer = get_userdata($claimer_id);
		
										$headers[] = "From: " . get_option('blogname') . " <" . get_option('admin_email') . ">";
										$headers[] = "Reply-To: " . get_option('admin_email');
										$headers[] = "Content-Type: text/html";
		
										$subject = "[" . get_option('blogname') . "] " . __('Claim notification', 'ALSP');
		
										$body = str_replace('[author]', $author->display_name,
												str_replace('[listing]', $listing->post->post_title,
												str_replace('[claimer]', $claimer->display_name,
												str_replace('[link]', alsp_dashboardUrl(),
												str_replace('[message]', $claimer_message,
										$ALSP_ADIMN_SETTINGS['alsp_claim_notification'])))));
		
										wp_mail($author->user_email, $subject, $body, $headers);
									}
									alsp_addMessage(__('Listing was claimed successfully!', 'ALSP'));
								} else {
									// Automatically process claim without approval
									$listing->claim->approve();
									alsp_addMessage(__('Listing claim was approved successfully!', 'ALSP'));
								}
							}

							$this->action = $_GET['claim_action'];
						}
						$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
						$this->subtemplate = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'claim.tpl.php');
					} else
						wp_die('This is your own listing', 'ALSP');
				}
			} elseif ($alsp_instance->action == 'process_claim' && isset($_GET['listing_id']) && is_numeric($_GET['listing_id'])) {
				$listing_id = alsp_getValue($_GET, 'listing_id');
				if ($listing_id && alsp_current_user_can_edit_listing($listing_id) && ($listing = $alsp_instance->listings_manager->loadListing($listing_id)) && $listing->claim->isClaimed()) {
					$this->action = 'show';
					if (isset($_GET['claim_action']) && ($_GET['claim_action'] == 'approve' || $_GET['claim_action'] == 'decline')) {
						if ($_GET['claim_action'] == 'approve') {
							$listing->claim->approve();
							if ($ALSP_ADIMN_SETTINGS['alsp_claim_approval_notification']) {
								$claimer = get_userdata($listing->claim->claimer_id);

								$headers[] = "From: " . get_option('blogname') . " <" . get_option('admin_email') . ">";
								$headers[] = "Reply-To: " . get_option('admin_email');
								$headers[] = "Content-Type: text/html";
							
								$subject = "[" . get_option('blogname') . "] " . __('Approval of claim notification', 'ALSP');
							
								$body = str_replace('[claimer]', $claimer->display_name,
										str_replace('[listing]', $listing->post->post_title,
										str_replace('[link]', alsp_dashboardUrl(),
								$ALSP_ADIMN_SETTINGS['alsp_claim_approval_notification'])));
							
								wp_mail($claimer->user_email, $subject, $body, $headers);
							}
							alsp_addMessage(__('Listing claim was approved successfully!', 'ALSP'));
						} elseif ($_GET['claim_action'] == 'decline') {
							$listing->claim->deleteRecord();
							update_post_meta($listing->post->ID, '_is_claimable', true);
							alsp_addMessage(__('Listing claim was declined!', 'ALSP'));
						}
						$this->action = 'processed';
						$this->referer = $_GET['referer'];
					}

					$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'dashboard.tpl.php');
					$this->subtemplate = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'claim_process.tpl.php');
				} else
					wp_die('You are not able to manage this listing', 'ALSP');
			// adapted for WPML
			}  elseif (function_exists('wpml_object_id_filter') && $sitepress && get_option('alsp_enable_frontend_translations') && $alsp_instance->action == 'add_translation' && isset($_GET['listing_id']) && isset($_GET['to_lang'])) {
				$master_post_id = $_GET['listing_id'];
				$lang_code = $_GET['to_lang'];

				global $iclTranslationManagement;

				require_once( ICL_PLUGIN_PATH . '/inc/translation-management/translation-management.class.php' );
				if (!isset($iclTranslationManagement))
					$iclTranslationManagement = new TranslationManagement;
				
				$post_type = get_post_type($master_post_id);
				if ($sitepress->is_translated_post_type($post_type)) {
					if ($new_listing_id = $iclTranslationManagement->make_duplicate($master_post_id, $lang_code)) {
						$iclTranslationManagement->reset_duplicate_flag($new_listing_id);
						alsp_addMessage(__('Translation was successfully created!', 'ALSP'));
						do_action('wpml_switch_language', $lang_code);
						wp_redirect(add_query_arg(array('alsp_action' => 'edit_listing', 'listing_id' => $new_listing_id), get_permalink(apply_filters('wpml_object_id', $alsp_instance->dashboard_page_id, 'page', true, $lang_code))));
					} else {
						alsp_addMessage(__('Translation was not created!', 'ALSP'), 'error');
						wp_redirect(alsp_dashboardUrl());
					}
					die();
				}
			}
		}

		apply_filters('alsp_frontend_controller_construct', $this);
	}

	public function display() {
		$output =  alsp_frontendRender($this->template, array('frontend_controller' => $this), true);
		wp_reset_postdata();

		return $output;
	}

	public function add_claimed_listings_where($where = '') {
		global $wpdb;
		
		$claimed_posts = '';
		$claimed_posts_ids = array();

		$results = $wpdb->get_results("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_claimer_id' AND meta_value='" . get_current_user_id() . "'", ARRAY_A);
		foreach ($results AS $row)
			$claimed_posts_ids[] = $row['post_id'];
		if ($claimed_posts_ids)
			$claimed_posts = " OR {$wpdb->posts}.ID IN (".implode(',', $claimed_posts_ids).") ";
		$where .= " AND ({$wpdb->posts}.post_author IN (".get_current_user_id().")" . $claimed_posts . ")";
		
		return $where;
	}
	
	public function enqueue_scripts_styles() {
		wp_register_script('alsp_stats', ALSP_RESOURCES_URL . 'js/chart.min.js');
		wp_enqueue_script('alsp_stats');
	}
}

?>