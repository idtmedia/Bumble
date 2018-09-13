<?php 

class alsp_submit_controller extends alsp_frontend_controller {
	public $levels = array();
	public $template_args = array();

	public function init($args = array()) {
		global $alsp_instance, $alsp_fsubmit_instance, $ALSP_ADIMN_SETTINGS;

		parent::init($args);
		
		$shortcode_atts = array_merge(array(
				'show_period' => 1,
				'show_sticky' => 1,
				'show_featured' => 1,
				'show_categories' => 1,
				'show_locations' => 1,
				'show_maps' => 1,
				'show_images' => 1,
				'show_videos' => 1,
				'columns_same_height' => 1,
				'show_steps' => 0,
				'columns' => 3,
				'levels' => null,
		), $args);
		
		$this->args = $shortcode_atts;

		if ((!isset($_GET['level']) || !is_numeric($_GET['level']) || !array_key_exists($_GET['level'], $alsp_instance->levels->levels_array)) && count($alsp_instance->levels->levels_array) > 1) {
			$this->levels = $alsp_instance->levels->levels_array;
			if ($this->args['levels']) {
				$levels_ids = array_filter(array_map('trim', explode(',', $this->args['levels'])));
				$this->levels = array_intersect_key($alsp_instance->levels->levels_array, array_flip($levels_ids));
			}
			if (alsp_is_only_woo_packages()) {
				$packages_manager = new alsp_listings_packages_manager;
				foreach ($this->levels AS $level_id=>$level)
				if (!$packages_manager->can_user_create_listing_in_level($level_id))
					unset($this->levels[$level_id]);
			}

			/* Show woo packages when:
			 * 1. user went to look at packages page
			 * 2. we sell only packages and user was not logged in
			 * 3. we sell only packages and user doesn't have any pre-paid listings
			 * */
			if (alsp_is_woo_active() && (isset($_GET['listings_packages']) || (alsp_is_only_woo_packages() && (!is_user_logged_in() || !$this->levels)))) {
				if (isset($_GET['listings_packages']))
					$this->template_args['hide_navigation'] = false;
				else
					$this->template_args['hide_navigation'] = true;

				$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'listings_packages.tpl.php');
			} else {
				$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'submitlisting_step_level.tpl.php');
			}
		} elseif (count($alsp_instance->levels->levels_array)) {
			if (count($alsp_instance->levels->levels_array) == 1) {
				$_levels = array_keys($alsp_instance->levels->levels_array);
				$level = array_shift($_levels);
			} else
				$level = $_GET['level'];

			if ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_login_mode'] == 1 && !is_user_logged_in()) {
				if (alsp_get_wpml_dependent_option('alsp_submit_login_page') && alsp_get_wpml_dependent_option('alsp_submit_login_page') != get_the_ID()) {
					$url = get_permalink(alsp_get_wpml_dependent_option('alsp_submit_login_page'));
					$url = add_query_arg('redirect_to', urlencode(alsp_submitUrl(array('level' => $level))), $url);
					wp_redirect($url);
				} else {
					add_action('wp_enqueue_scripts', array($alsp_fsubmit_instance, 'enqueue_login_scripts_styles'));
					$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'login_form.tpl.php');
				}
			} else {
				$this->alsp_user_contact_name = '';
				$this->alsp_user_contact_email = '';
				if (!isset($_POST['listing_id']) || !isset($_POST['listing_id_hash']) || !is_numeric($_POST['listing_id']) || md5($_POST['listing_id'] . wp_salt()) != $_POST['listing_id_hash']) {
					// Create Auto-Draft
					$new_post_args = array(
							'post_title' => __('Auto Draft', 'ALSP'),
							'post_type' => ALSP_POST_TYPE,
							'post_status' => 'auto-draft'
					);
					if ($new_post_id = wp_insert_post($new_post_args)) {
						$alsp_instance->listings_manager->current_listing = new alsp_listing($level);
						$alsp_instance->listings_manager->saveInitialDraft($new_post_id);

						$listing = alsp_getCurrentListingInAdmin();
					}
				} elseif (isset($_POST['submit']) && (isset($_POST['_submit_nonce']) && wp_verify_nonce($_POST['_submit_nonce'], 'alsp_submit'))) {
					// This is existed Auto-Draft
					$listing_id = $_POST['listing_id'];

					$listing = new alsp_listing();
					$listing->loadListingFromPost($listing_id);
					$alsp_instance->current_listing = $listing;
					$alsp_instance->listings_manager->current_listing = $listing;

					$errors = array();

					if (!is_user_logged_in() && ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_login_mode'] == 2 || $ALSP_ADIMN_SETTINGS['alsp_fsubmit_login_mode'] == 3)) {
						if ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_login_mode'] == 2)
							$required = '|required';
						else
							$required = '';
						$validation = new alsp_form_validation();
						$validation->set_rules('alsp_user_contact_name', __('Contact Name', 'ALSP'), $required);
						$validation->set_rules('alsp_user_contact_email', __('Contact Email', 'ALSP'), 'valid_email' . $required);
						if (!$validation->run()) {
							$user_valid = false;
							$errors[] = $validation->error_string();
						} else
							$user_valid = true;

						$this->alsp_user_contact_name = $validation->result_array('alsp_user_contact_name');
						$this->alsp_user_contact_email = $validation->result_array('alsp_user_contact_email');
					}

					if (!isset($_POST['post_title']) || !trim($_POST['post_title']) || $_POST['post_title'] == __('Auto Draft', 'ALSP')) {
						$errors[] = __('Listing title field required', 'ALSP');
						$post_title = __('Auto Draft', 'ALSP');
					} else 
						$post_title = trim($_POST['post_title']);

					$post_categories_ids = array();
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
						if ($validation_results = $alsp_instance->locations_manager->validateLocations($listing->level, $errors)) {
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
						update_post_meta($listing->post->ID, '_post_resurva_url', $_POST['post_resurva_url']);
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

					if (!alsp_is_recaptcha_passed())
						$errors[] = esc_attr__("Anti-bot test wasn't passed!", 'ALSP');

					// adapted for WPML
					global $sitepress;
					if (
					(
						(function_exists('wpml_object_id_filter') && $sitepress && $sitepress->get_default_language() != ICL_LANGUAGE_CODE && ($tos_page = $ALSP_ADIMN_SETTINGS['alsp_tospage_'.ICL_LANGUAGE_CODE]))
						||
						($tos_page = $ALSP_ADIMN_SETTINGS['alsp_tospage'])
					)
					&&
					(!isset($_POST['alsp_tospage']) || !$_POST['alsp_tospage'])
					)
						$errors[] = __('Please check the box to agree the Terms of Services.', 'ALSP');

					if ($errors) {
						$postarr = array(
								'ID' => $listing_id,
								'post_title' => $post_title,
								'post_content' => (isset($_POST['post_content']) ? $_POST['post_content'] : ''),
								'post_excerpt' => (isset($_POST['post_excerpt']) ? $_POST['post_excerpt'] : ''),
								'price' => (isset($_POST['price']) ? $_POST['price'] : ''),
								'post_type' => ALSP_POST_TYPE,
						);
						$result = wp_update_post($postarr, true);
						if (is_wp_error($result))
							$errors[] = $result->get_error_message();
							
						foreach ($errors AS $error)
							alsp_addMessage($error, 'error');
					} else {
						if (!is_user_logged_in() && ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_login_mode'] == 2 || $ALSP_ADIMN_SETTINGS['alsp_fsubmit_login_mode'] == 3 || $ALSP_ADIMN_SETTINGS['alsp_fsubmit_login_mode'] == 4)) {
							if (email_exists($this->alsp_user_contact_email)) {
								$user = get_user_by('email', $this->alsp_user_contact_email);
								$post_author_id = $user->ID;
								$post_author_username = $user->user_login;
							} else {
								if ($this->alsp_user_contact_name) {
									$display_author_name = $this->alsp_user_contact_name;
									if (get_user_by('login', $this->alsp_user_contact_name))
										$login_author_name = $this->alsp_user_contact_name . '_' . time();
									else
										$login_author_name = $this->alsp_user_contact_name;
								} else {
									$display_author_name = 'Author_' . time();
									$login_author_name = 'Author_' . time();
								}
								if ($this->alsp_user_contact_email)
									$author_email = $this->alsp_user_contact_email;
								else
									$author_email = '';
								
								$password = wp_generate_password(6, false);
								
								$post_author_id = wp_insert_user(array(
										'display_name' => $display_author_name,
										'user_login' => $login_author_name,
										'user_email' => $author_email,
										'user_pass' => $password
								));
								$post_author_username = $login_author_name;

								if ($author_email) {
									$headers = array();
									$headers[] = "From: " . get_option('blogname') . " <" . $ALSP_ADIMN_SETTINGS['alsp_admin_notifications_email'] . ">";
									$headers[] = "Reply-To: " . $ALSP_ADIMN_SETTINGS['alsp_admin_notifications_email'];
									$headers[] = "Content-Type: text/html";
										
									$subject = "[" . get_option('blogname') . "] " . __('Registration notification', 'ALSP');
									$body = str_replace('[author]', $display_author_name,
											str_replace('[listing]', $post_title,
											str_replace('[login]', $login_author_name,
											str_replace('[password]', $password,
									$ALSP_ADIMN_SETTINGS['alsp_newuser_notification']))));

									add_action('wp_mail_failed', 'alsp_error_log');
									if (wp_mail($author_email, $subject, $body, $headers))
										alsp_addMessage(__('New user was created and added to the site, login and password were sent to provided contact email.', 'ALSP'));
								}
							}

						} elseif (is_user_logged_in())
							$post_author_id = get_current_user_id();
						else
							$post_author_id = 0;

						if ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_default_status'] == 1) {
							$post_status = 'pending';
							$message = esc_attr__("Listing was saved successfully! Now it's awaiting moderators approval.", 'ALSP');
						} elseif ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_default_status'] == 2) {
							$post_status = 'draft';
							$message = __('Listing was saved successfully as draft! Contact site manager, please.', 'ALSP');
						} elseif ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_default_status'] == 3) {
							$post_status = 'publish';
							$message = __('Listing was saved successfully! Now you may manage it in your dashboard.', 'ALSP');
						}

						$postarr = array(
								'ID' => $listing_id,
								'post_title' => $post_title,
								'post_content' => (isset($_POST['post_content']) ? $_POST['post_content'] : ''),
								'post_excerpt' => (isset($_POST['post_excerpt']) ? $_POST['post_excerpt'] : ''),
								'price' => (isset($_POST['price']) ? $_POST['price'] : ''),
								'post_type' => ALSP_POST_TYPE,
								'post_author' => $post_author_id,
								'post_status' => $post_status
						);
						$result = wp_update_post($postarr, true);
						if (is_wp_error($result)) {
							alsp_addMessage($result->get_error_message(), 'error');
						} else {
							if (!$listing->level->eternal_active_period) {
								if ($ALSP_ADIMN_SETTINGS['alsp_change_expiration_date'] || current_user_can('manage_options'))
									$alsp_instance->listings_manager->changeExpirationDate();
								else {
									$expiration_date = alsp_calcExpirationDate(current_time('timestamp'), $listing->level);
									add_post_meta($listing->post->ID, '_expiration_date', $expiration_date);
								}
							}

							add_post_meta($listing->post->ID, '_listing_created', true);
							add_post_meta($listing->post->ID, '_order_date', time());
							add_post_meta($listing->post->ID, '_listing_status', 'active');
							
							if ($ALSP_ADIMN_SETTINGS['alsp_claim_functionality'] && !$ALSP_ADIMN_SETTINGS['alsp_hide_claim_metabox'])
								if (isset($_POST['is_claimable']))
									update_post_meta($listing->post->ID, '_is_claimable', true);
								else
									update_post_meta($listing->post->ID, '_is_claimable', false);
	
							alsp_addMessage($message);
							
							// renew data inside $listing object
							$listing = $alsp_instance->listings_manager->loadListing($listing_id);
							
							if ($ALSP_ADIMN_SETTINGS['alsp_newlisting_admin_notification'] && $ALSP_ADIMN_SETTINGS['alsp_admin_notifications_email']) {
								$author = get_userdata($listing->post->post_author);
								$headers = array();
								$headers[] = "From: " . get_option('blogname') . " <" . $ALSP_ADIMN_SETTINGS['alsp_admin_notifications_email'] . ">";
								$headers[] = "Reply-To: " . $ALSP_ADIMN_SETTINGS['alsp_admin_notifications_email'];
								$headers[] = "Content-Type: text/html";
							
								$subject = "[" . get_option('blogname') . "] " . __('Notification about new listing creation (do not reply)', 'ALSP');
								$body = str_replace('[user]', $author->display_name, str_replace('[listing]', $post_title,
										str_replace('[link]', admin_url('post.php?post='.$listing->post->ID.'&action=edit'),
								$ALSP_ADIMN_SETTINGS['alsp_newlisting_admin_notification'])));
	
								wp_mail($ALSP_ADIMN_SETTINGS['alsp_admin_notifications_email'], $subject, $body, $headers);
							}
	
							apply_filters('alsp_listing_creation_front', $listing);
	
							if ($alsp_instance->dashboard_page_url)
								$redirect_to = alsp_dashboardUrl();
							else
								$redirect_to = alsp_directoryUrl();
							wp_redirect($redirect_to);
							die();
						}
					}
					// renew data inside $listing object
					//$listing = $alsp_instance->listings_manager->loadListing($listing_id);
					$listing = alsp_getListing($listing_id);
					$alsp_instance->current_listing = $listing;
					$alsp_instance->listings_manager->current_listing = $listing;
				}
				if (get_current_user_id()) {
					$current_user = wp_get_current_user();
					alsp_addMessage(sprintf(__("You are logged in as %s. <a href='%s'>Log out</a> or continue submission in this account.", "ALSP"), $current_user->display_name, wp_logout_url()));
					if ($ALSP_ADIMN_SETTINGS['alsp_payments_addon'] != 'alsp_woo_payment'){
						if ($package_message = $alsp_instance->listings_packages->submitlisting_level_message($alsp_instance->current_listing->level)) {
							alsp_addMessage($package_message);
						}
					}
				} elseif ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_login_mode'] == 2 || $ALSP_ADIMN_SETTINGS['alsp_fsubmit_login_mode'] == 3) {
					alsp_addMessage(sprintf(__("Returning user? Please <a href='%s'>Log in</a> or register in this submission form.", "ALSP"), wp_login_url()));
				}
	
				$this->template = array(ALSP_FSUBMIT_TEMPLATES_PATH, 'submitlisting_step_create.tpl.php');
				if ($listing->level->categories_number > 0 || $listing->level->unlimited_categories) {
					add_action('wp_enqueue_scripts', array($alsp_instance->categories_manager, 'admin_enqueue_scripts_styles'));
				}
				
				if ($listing->level->locations_number > 0 && $listing->level->google_map) {
					add_action('wp_enqueue_scripts', array($alsp_instance->locations_manager, 'admin_enqueue_scripts_styles'));
				}

				if ($listing->level->images_number > 0 || $listing->level->videos_number > 0)
					add_action('wp_enqueue_scripts', array($alsp_instance->media_manager, 'admin_enqueue_scripts_styles'));
			}
		}
		
		apply_filters('alsp_frontend_controller_construct', $this);
	}

	public function display() {
		$output =  alsp_frontendRender($this->template, array_merge(array('frontend_controller' => $this), $this->template_args), true);
		wp_reset_postdata();

		return $output;
	}
}

?>