<?php 

class alsp_directory_controller extends alsp_frontend_controller {
	public $is_home = false;
	public $is_search = false;
	public $is_single = false;
	public $is_category = false;
	public $is_location = false;
	public $is_tag = false;
	public $is_favourites = false;
	public $breadcrumbs = array();
	public $custom_home = false;
	public $is_map_on_page = 1;
	public $request_by = 'directory_controller';

	public function init($args = array(), $shortcode = 'webdirectory') {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;
		
		parent::init($args);

		if (isset($args['custom_home']) && $args['custom_home'])
			$this->custom_home = true;

		if (get_query_var('page'))
			$paged = get_query_var('page');
		elseif (get_query_var('paged'))
			$paged = get_query_var('paged');
		else
			$paged = 1;

		if (get_query_var('listing-alsp') || ($shortcode == 'webdirectory-listing' && isset($args['listing_id']) && is_numeric($args['listing_id']))) {
			if (get_query_var('listing-alsp'))
				$args = array(
						'post_type' => ALSP_POST_TYPE,
						'post_status' => 'publish',
						'name' => get_query_var('listing-alsp'),
						'posts_per_page' => 1,
				);
			else 
				$args = array(
						'post_type' => ALSP_POST_TYPE,
						'post_status' => 'publish',
						'p' => $args['listing_id'],
						'posts_per_page' => 1,
				);
			$this->query = new WP_Query($args);
			$this->processQuery(true);
			// Google Map uID must be absolutely unique on single listing page
			$this->hash = md5(time());

			if (count($this->listings)) {
				$listings_array = $this->listings;
				$listing = array_shift($listings_array);
				$this->listing = $listing;
				if (!$this->listing->level->listings_own_page)
					wp_redirect(alsp_directoryUrl());
				
				$this->listing->increaseClicksStats();

				global $wp_rewrite;
				if ($shortcode != 'webdirectory-listing' && $wp_rewrite->using_permalinks() && (($ALSP_ADIMN_SETTINGS['alsp_permalinks_structure'] == 'category_slug' || $ALSP_ADIMN_SETTINGS['alsp_permalinks_structure'] == 'location_slug' || $ALSP_ADIMN_SETTINGS['alsp_permalinks_structure'] == 'tag_slug'))) {
					switch ($ALSP_ADIMN_SETTINGS['alsp_permalinks_structure']) {
						case 'category_slug':
							if ($terms = get_the_terms($this->listing->post->ID, ALSP_CATEGORIES_TAX)) {
								$term = array_shift($terms);
								$uri = '';
								if ($parents = alsp_get_term_parents_slugs($term->term_id, ALSP_CATEGORIES_TAX))
									$uri = implode('/', $parents);
								if ($uri != get_query_var('tax-slugs-alsp')) {
									wp_redirect(get_the_permalink($this->listing->post->ID), 301);
									die();
								}
							}
							break;
						case 'location_slug':
							if ($terms = get_the_terms($this->listing->post->ID, ALSP_LOCATIONS_TAX)) {
								$term = array_shift($terms);
								$uri = '';
								if ($parents = alsp_get_term_parents_slugs($term->term_id, ALSP_LOCATIONS_TAX))
									$uri = implode('/', $parents);
								if ($uri != get_query_var('tax-slugs-alsp')) {
									wp_redirect(get_the_permalink($this->listing->post->ID), 301);
									die();
								}
							}
							break;
						case 'tag_slug':
							if (($terms = get_the_terms($post->ID, ALSP_TAGS_TAX)) && ($term = array_shift($terms))) {
								if ($term->slug != get_query_var('tax-slugs-alsp')) {
									wp_redirect(get_the_permalink($this->listing->post->ID), 301);
									die();
								}
							}
							break;
					}
				}
				
				$this->is_single = true;
				$this->template = 'frontend/listing_single.tpl.php';

				$this->page_title = $listing->title();

				if ($ALSP_ADIMN_SETTINGS['alsp_enable_breadcrumbs']) {
					if (!$ALSP_ADIMN_SETTINGS['alsp_hide_home_link_breadcrumb'])
						$this->breadcrumbs[] = '<li><a href="' . alsp_directoryUrl() . '">' . __('Home', 'ALSP') . '</a></li>';
					switch ($ALSP_ADIMN_SETTINGS['alsp_breadcrumbs_mode']) {
						case 'category':
							if ($terms = get_the_terms($this->listing->post->ID, ALSP_CATEGORIES_TAX)) {
								$term = array_shift($terms);
								$this->breadcrumbs = array_merge($this->breadcrumbs, alsp_get_term_parents($term, ALSP_CATEGORIES_TAX, true, true));
							}
							break;
						case 'location':
							if ($terms = get_the_terms($this->listing->post->ID, ALSP_LOCATIONS_TAX)) {
								$term = array_shift($terms);
								$this->breadcrumbs = array_merge($this->breadcrumbs, alsp_get_term_parents($term, ALSP_LOCATIONS_TAX, true, true));
							}
							break;
					}
					$this->breadcrumbs[] = $listing->title();
				}

				if ($ALSP_ADIMN_SETTINGS['alsp_listing_contact_form'] && defined('WPCF7_VERSION') && alsp_get_wpml_dependent_option('alsp_listing_contact_form_7')) {
					add_filter('wpcf7_form_action_url', array($this, 'alsp_add_listing_id_to_wpcf7'));
					add_filter('wpcf7_form_hidden_fields', array($this, 'alsp_add_listing_id_to_wpcf7_field'));
				}
				
				add_filter('language_attributes', array($this, 'add_opengraph_doctype'));
				add_action('wp_head', array($this, 'insert_fb_in_head'), -10);
				if (function_exists('rel_canonical'))
					remove_action('wp_head', 'rel_canonical');
				// replace the default WordPress canonical URL function with your own
				add_action('wp_head', array($this, 'rel_canonical_with_custom_tag_override'));
			}/*  else {
				if ($template = get_404_template()) {
					status_header(404);
					nocache_headers();
				} else
					$template = get_index_template();

				if ($template = apply_filters('template_include', $template))
					include($template);
				exit;
			} */
		} elseif ($alsp_instance->action == 'search') {
			$this->is_search = true;
			$this->template = 'frontend/search.tpl.php';
			
			if (!$ALSP_ADIMN_SETTINGS['alsp_map_on_excerpt'])
				$this->is_map_on_page = 0;

			if ($ALSP_ADIMN_SETTINGS['alsp_main_search'])
				$this->search_form = new alsp_search_form($this->hash, $this->request_by);

			$default_orderby_args = array('order_by' => $ALSP_ADIMN_SETTINGS['alsp_default_orderby'], 'order' => $ALSP_ADIMN_SETTINGS['alsp_default_order']);
			
			$get_params = $_GET;
			array_walk($get_params, 'sanitize_text_field');
			$this->args = array_merge($default_orderby_args, $get_params);

			if (!$ALSP_ADIMN_SETTINGS['alsp_ajax_initial_load']) {
				//$this->args = array_merge($default_orderby_args, $get_params);
				$order_args = apply_filters('alsp_order_args', array(), $default_orderby_args);
	
				$args = array(
						'post_type' => ALSP_POST_TYPE,
						'post_status' => 'publish',
						'meta_query' => array(array('key' => '_listing_status', 'value' => 'active')),
						'posts_per_page' => $ALSP_ADIMN_SETTINGS['alsp_listings_number_excerpt'],
						'paged' => $paged,
				);
				$args = array_merge($args, $order_args);
				$args = apply_filters('alsp_search_args', $args, array(), true, $this->hash);
				
				// found some plugins those break WP_Query by injections in pre_get_posts action, so decided to remove this hook temporarily
				global $wp_filter;
				if (isset($wp_filter['pre_get_posts'])) {
					$pre_get_posts = $wp_filter['pre_get_posts'];
					unset($wp_filter['pre_get_posts']);
				}
				$this->query = new WP_Query($args);
				$this->processQuery($ALSP_ADIMN_SETTINGS['alsp_map_on_excerpt']);
				if (isset($pre_get_posts))
					$wp_filter['pre_get_posts'] = $pre_get_posts;
			} else {
				$this->do_initial_load = false;
				//$this->args = $get_params;
				if ($this->is_map_on_page) {
					$this->google_map = new alsp_google_maps();
					$this->google_map->setUniqueId($this->hash);
				}
			}

			$this->page_title = __('Search results', 'ALSP');

			$this->args['perpage'] = $ALSP_ADIMN_SETTINGS['alsp_listings_number_excerpt'];

			if ($ALSP_ADIMN_SETTINGS['alsp_enable_breadcrumbs']) {
				if (!$ALSP_ADIMN_SETTINGS['alsp_hide_home_link_breadcrumb'])
					$this->breadcrumbs[] = '<a href="' . alsp_directoryUrl() . '">' . __('Home', 'ALSP') . '</a>';
				$this->breadcrumbs[] = __('Search results', 'ALSP');
			}
			$base_url_args = apply_filters('alsp_base_url_args', array('alsp_action' => 'search'));
			$this->base_url = alsp_directoryUrl($base_url_args);
		} elseif (get_query_var('category-alsp')) {
			if ($category_object = alsp_get_term_by_path(get_query_var('category-alsp'))) {
				$this->is_category = true;
				$this->category = $category_object;
				
				if (!$ALSP_ADIMN_SETTINGS['alsp_map_on_excerpt'])
					$this->is_map_on_page = 0;
				
				if ($ALSP_ADIMN_SETTINGS['alsp_main_search'])
					$this->search_form = new alsp_search_form($this->hash, $this->request_by);

				$default_orderby_args = array('order_by' => $ALSP_ADIMN_SETTINGS['alsp_default_orderby'], 'order' => $ALSP_ADIMN_SETTINGS['alsp_default_order']);

				$get_params = $_GET;
				array_walk($get_params, 'sanitize_text_field');
				$this->args = array_merge($default_orderby_args, $get_params);

				$this->args['categories'] = $category_object->term_id;

				if (!$ALSP_ADIMN_SETTINGS['alsp_ajax_initial_load']) {
					$order_args = apply_filters('alsp_order_args', array(), $default_orderby_args);
	
					$args = array(
							'tax_query' => array(
									array(
										'taxonomy' => ALSP_CATEGORIES_TAX,
										'field' => 'slug',
										'terms' => $category_object->slug,
									)
							),
							'post_type' => ALSP_POST_TYPE,
							'post_status' => 'publish',
							'meta_query' => array(array('key' => '_listing_status', 'value' => 'active')),
							'posts_per_page' => $ALSP_ADIMN_SETTINGS['alsp_listings_number_excerpt'],
							'paged' => $paged
					);
					$args = array_merge($args, $order_args);
	
					// found some plugins those break WP_Query by injections in pre_get_posts action, so decided to remove this hook temporarily
					global $wp_filter;
					if (isset($wp_filter['pre_get_posts'])) {
						$pre_get_posts = $wp_filter['pre_get_posts'];
						unset($wp_filter['pre_get_posts']);
					}
					$this->query = new WP_Query($args);
					$this->processQuery($this->is_map_on_page);
					if (isset($pre_get_posts))
						$wp_filter['pre_get_posts'] = $pre_get_posts;
				} else {
					$this->do_initial_load = false;
					if ($this->is_map_on_page) {
						$this->google_map = new alsp_google_maps();
						$this->google_map->setUniqueId($this->hash);
					}
				}

				$this->args['perpage'] = $ALSP_ADIMN_SETTINGS['alsp_listings_number_excerpt'];
				$this->template = 'frontend/category.tpl.php';
				$this->page_title = $category_object->name;

				if ($ALSP_ADIMN_SETTINGS['alsp_enable_breadcrumbs']) {
					if (!$ALSP_ADIMN_SETTINGS['alsp_hide_home_link_breadcrumb'])
						$this->breadcrumbs[] = '<a href="' . alsp_directoryUrl() . '">' . __('Home', 'ALSP') . '</a>';
					$this->breadcrumbs = array_merge($this->breadcrumbs, alsp_get_term_parents($category_object, ALSP_CATEGORIES_TAX, true, true));
				}
				
				$this->base_url = get_term_link($category_object, ALSP_CATEGORIES_TAX);
			} else {
				if ($template = get_404_template()) {
					status_header(404);
					nocache_headers();
				} else
					$template = get_index_template();

				if ($template = apply_filters('template_include', $template))
					include($template);
				exit;
			}
		} elseif (get_query_var('location-alsp')) {
			if ($location_object = alsp_get_term_by_path(get_query_var('location-alsp'))) {
				$this->is_location = true;
				$this->location = $location_object;
				
				if (!$ALSP_ADIMN_SETTINGS['alsp_map_on_excerpt'])
					$this->is_map_on_page = 0;

				global $alsp_tax_terms_locations;
				$alsp_tax_terms_locations = get_term_children($location_object->term_id, ALSP_LOCATIONS_TAX);
				$alsp_tax_terms_locations[] = $location_object->term_id;
				
				if ($ALSP_ADIMN_SETTINGS['alsp_main_search'])
					$this->search_form = new alsp_search_form($this->hash, $this->request_by);

				$default_orderby_args = array('order_by' => $ALSP_ADIMN_SETTINGS['alsp_default_orderby'], 'order' => $ALSP_ADIMN_SETTINGS['alsp_default_order']);
				
				$get_params = $_GET;
				array_walk($get_params, 'sanitize_text_field');
				$this->args = array_merge($default_orderby_args, $get_params);

				$this->args['location_id'] = $location_object->term_id;
				
				if (!$ALSP_ADIMN_SETTINGS['alsp_ajax_initial_load']) {
					$order_args = apply_filters('alsp_order_args', array(), $default_orderby_args);
	
					$args = array(
							'tax_query' => array(
									array(
										'taxonomy' => ALSP_LOCATIONS_TAX,
										'field' => 'slug',
										'terms' => $location_object->slug,
									)
							),
							'post_type' => ALSP_POST_TYPE,
							'post_status' => 'publish',
							'meta_query' => array(array('key' => '_listing_status', 'value' => 'active')),
							'posts_per_page' => $ALSP_ADIMN_SETTINGS['alsp_listings_number_excerpt'],
							'paged' => $paged
					);
					$args = array_merge($args, $order_args);
	
					// found some plugins those break WP_Query by injections in pre_get_posts action, so decided to remove this hook temporarily
					global $wp_filter;
					if (isset($wp_filter['pre_get_posts'])) {
						$pre_get_posts = $wp_filter['pre_get_posts'];
						unset($wp_filter['pre_get_posts']);
					}
					$this->query = new WP_Query($args);
					$this->processQuery($this->is_map_on_page);
					if (isset($pre_get_posts))
						$wp_filter['pre_get_posts'] = $pre_get_posts;
				} else {
					$this->do_initial_load = false;
					if ($this->is_map_on_page) {
						$this->google_map = new alsp_google_maps();
						$this->google_map->setUniqueId($this->hash);
					}
				}

				$this->args['perpage'] = $ALSP_ADIMN_SETTINGS['alsp_listings_number_excerpt'];
				$this->template = 'frontend/location.tpl.php';
				$this->page_title = $location_object->name;
				
				if ($ALSP_ADIMN_SETTINGS['alsp_enable_breadcrumbs']) {
					if (!$ALSP_ADIMN_SETTINGS['alsp_hide_home_link_breadcrumb'])
						$this->breadcrumbs[] = '<a href="' . alsp_directoryUrl() . '">' . __('Home', 'ALSP') . '</a>';
					$this->breadcrumbs = array_merge($this->breadcrumbs, alsp_get_term_parents($location_object, ALSP_LOCATIONS_TAX, true, true));
				}
				
				$this->base_url = get_term_link($location_object, ALSP_LOCATIONS_TAX);
			} else {
				if ($template = get_404_template()) {
					status_header(404);
					nocache_headers();
				} else
					$template = get_index_template();

				if ($template = apply_filters('template_include', $template))
					include($template);
				exit;
			}
		} elseif (get_query_var('tag-alsp')) {
			if ($tag_object = get_term_by('slug', get_query_var('tag-alsp'), ALSP_TAGS_TAX)) {
				$this->is_tag = true;
				$this->tag = $tag_object;
				
				if (!$ALSP_ADIMN_SETTINGS['alsp_map_on_excerpt'])
					$this->is_map_on_page = 0;

				if ($ALSP_ADIMN_SETTINGS['alsp_main_search'])
					$this->search_form = new alsp_search_form($this->hash, $this->request_by);

				$default_orderby_args = array('order_by' => $ALSP_ADIMN_SETTINGS['alsp_default_orderby'], 'order' => $ALSP_ADIMN_SETTINGS['alsp_default_order']);
				
				$get_params = $_GET;
				array_walk($get_params, 'sanitize_text_field');
				$this->args = array_merge($default_orderby_args, $get_params);

				$this->args['tag_id'] = $tag_object->term_id;
				
				if (!$ALSP_ADIMN_SETTINGS['alsp_ajax_initial_load']) {
					$order_args = apply_filters('alsp_order_args', array(), $default_orderby_args);
	
					$args = array(
							'tax_query' => array(
									array(
											'taxonomy' => ALSP_TAGS_TAX,
											'field' => 'slug',
											'terms' => $tag_object->slug,
									)
							),
							'post_type' => ALSP_POST_TYPE,
							'post_status' => 'publish',
							'meta_query' => array(array('key' => '_listing_status', 'value' => 'active')),
							'posts_per_page' => $ALSP_ADIMN_SETTINGS['alsp_listings_number_excerpt'],
							'paged' => $paged,
					);
					$args = array_merge($args, $order_args);
		
					// found some plugins those break WP_Query by injections in pre_get_posts action, so decided to remove this hook temporarily
					global $wp_filter;
					if (isset($wp_filter['pre_get_posts'])) {
						$pre_get_posts = $wp_filter['pre_get_posts'];
						unset($wp_filter['pre_get_posts']);
					}
					$this->query = new WP_Query($args);
					$this->processQuery($this->is_map_on_page);
					if (isset($pre_get_posts))
						$wp_filter['pre_get_posts'] = $pre_get_posts;
				} else {
					$this->do_initial_load = false;
					if ($this->is_map_on_page) {
						$this->google_map = new alsp_google_maps();
						$this->google_map->setUniqueId($this->hash);
					}
				}

				$this->args['perpage'] = $ALSP_ADIMN_SETTINGS['alsp_listings_number_excerpt'];
				$this->template = 'frontend/tag.tpl.php';
				$this->page_title = $tag_object->name;

				if ($ALSP_ADIMN_SETTINGS['alsp_enable_breadcrumbs']) {
					if (!$ALSP_ADIMN_SETTINGS['alsp_hide_home_link_breadcrumb'])
						$this->breadcrumbs[] = '<a href="' . alsp_directoryUrl() . '">' . __('Home', 'ALSP') . '</a>';
					$this->breadcrumbs[] = '<a href="' . get_term_link($tag_object->slug, ALSP_TAGS_TAX) . '" title="' . esc_attr(sprintf(__('View all listings in %s', 'ALSP'), $tag_object->name)) . '">' . $tag_object->name . '</a>';
				}
				
				$this->base_url = get_term_link($tag_object, ALSP_TAGS_TAX);
			} else {
				if ($template = get_404_template()) {
					status_header(404);
					nocache_headers();
				} else
					$template = get_index_template();

				if ($template = apply_filters('template_include', $template))
					include($template);
				exit;
			}
		} elseif ($alsp_instance->action == 'myfavourites') {
			$this->is_favourites = true;

			if (!$favourites = alsp_checkQuickList())
				$favourites = array(0);
			$args = array(
					'post__in' => $favourites,
					'post_type' => ALSP_POST_TYPE,
					'post_status' => 'publish',
					'meta_query' => array(array('key' => '_listing_status', 'value' => 'active')),
					'posts_per_page' => $ALSP_ADIMN_SETTINGS['alsp_listings_number_excerpt'],
					'paged' => $paged,
			);
			$this->query = new WP_Query($args);
			$this->processQuery($ALSP_ADIMN_SETTINGS['alsp_map_on_excerpt']);
			
			$this->args['perpage'] = $ALSP_ADIMN_SETTINGS['alsp_listings_number_excerpt'];
			$this->template = 'frontend/favourites.tpl.php';
			$this->page_title = __('My bookmarks', 'ALSP');

			if ($ALSP_ADIMN_SETTINGS['alsp_enable_breadcrumbs']) {
				if (!$ALSP_ADIMN_SETTINGS['alsp_hide_home_link_breadcrumb'])
					$this->breadcrumbs[] = '<a href="' . alsp_directoryUrl() . '">' . __('Home', 'ALSP') . '</a>';
				$this->breadcrumbs[] = __('My bookmarks', 'ALSP');
			}
		} elseif (!$alsp_instance->action) {
			$this->is_home = true;
			
			if (!$ALSP_ADIMN_SETTINGS['alsp_map_on_index'])
				$this->is_map_on_page = 0;

			if ($ALSP_ADIMN_SETTINGS['alsp_main_search'])
				$this->search_form = new alsp_search_form($this->hash, $this->request_by);

			$default_orderby_args = array('order_by' => $ALSP_ADIMN_SETTINGS['alsp_default_orderby'], 'order' => $ALSP_ADIMN_SETTINGS['alsp_default_order']);

			$get_params = $_GET;
			array_walk($get_params, 'sanitize_text_field');
			$this->args = array_merge($default_orderby_args, $get_params);

			if (!$ALSP_ADIMN_SETTINGS['alsp_ajax_initial_load']) {
				$order_args = apply_filters('alsp_order_args', array(), $default_orderby_args);
	
				$args = array(
						'post_type' => ALSP_POST_TYPE,
						'post_status' => 'publish',
						'meta_query' => array(array('key' => '_listing_status', 'value' => 'active')),
						'posts_per_page' => $ALSP_ADIMN_SETTINGS['alsp_listings_number_index'],
						'paged' => $paged,
				);
				$args = array_merge($args, $order_args);
	
				$this->query = new WP_Query($args);
				//var_dump($this->query->request);
				$this->processQuery($this->is_map_on_page);
			} else {
				$this->do_initial_load = false;
				if ($this->is_map_on_page) {
					$this->google_map = new alsp_google_maps();
					$this->google_map->setUniqueId($this->hash);
				}
			}

			$base_url_args = apply_filters('alsp_base_url_args', array());
			$this->base_url = alsp_directoryUrl($base_url_args);

			$this->args['perpage'] = $ALSP_ADIMN_SETTINGS['alsp_listings_number_index'];
			$this->template = 'frontend/index.tpl.php';
			$this->page_title = get_post($alsp_instance->index_page_id)->post_title;
		}
		$this->args['is_home'] = $this->is_home;
		$this->args['paged'] = $paged;
		$this->args['custom_home'] = (int)$this->custom_home;
		$this->args['with_map'] = $this->is_map_on_page;
		$this->args['listing_post_style'] = $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'];
		$this->args['listing_image_width'] =  $ALSP_ADIMN_SETTINGS['alsp_logo_width'];
		$this->args['listing_image_height'] =  $ALSP_ADIMN_SETTINGS['alsp_logo_height'];
		$this->args['onepage'] = 0;
		$this->args['hide_paginator'] = 0;
		$this->args['hide_count'] = 0;
		$this->args['hide_order'] = (int)(!($ALSP_ADIMN_SETTINGS['alsp_show_orderby_links']));
		$this->args['show_views_switcher'] = (int)$ALSP_ADIMN_SETTINGS['alsp_views_switcher'];
		$this->args['scroll'] = 0;
		$this->args['location_style'] = 0;
		$this->args['listings_view_type'] = (int)$ALSP_ADIMN_SETTINGS['alsp_views_switcher_default'];
		$this->args['listings_view_grid_columns'] = (int)$ALSP_ADIMN_SETTINGS['alsp_views_switcher_grid_columns'];
		$this->args['logo_animation_effect'] = (int)get_option('alsp_logo_animation_effect');

		add_action('get_header', array($this, 'configure_seo_filters'), 2);
		
		// adapted for WPML
		add_filter('icl_ls_languages', array($this, 'adapt_wpml_urls'));
		add_filter('WPML_alternate_hreflang', array($this, 'alternate_hreflang'), 10, 2);

		// this is possible to build custom home page instead of static set of blocks
		if (!$this->is_single && $this->custom_home)
			$this->template = 'frontend/listings_block.tpl.php';

		apply_filters('alsp_frontend_controller_construct', $this);
	}
	
	public function tempLangToWPML () {
		return $this->temp_lang;
	}
	
	// adapted for WPML
	public function adapt_wpml_urls($w_active_languages) {
		global $sitepress, $alsp_instance;

		// WPML will not switch language using $sitepress->switch_lang() function when there is 'lang=' parameter in the URL, so we have to use such hack
		if ($sitepress->get_option('language_negotiation_type') == 3)
			remove_all_filters('icl_current_language');

		foreach ($w_active_languages AS &$language) {
			$sitepress->switch_lang($language['language_code']);
			$this->temp_lang = $language['language_code'];
			add_filter('icl_current_language', array($this, 'tempLangToWPML'));
			$alsp_instance->getIndexPage();
			if ($this->is_single && ($tlisting_post_id = apply_filters('wpml_object_id', $this->listing->post->ID, ALSP_POST_TYPE, false, $language['language_code']))) {
				$language['url'] = get_permalink($tlisting_post_id);
			}
			if ($this->is_category && ($tterm_id = apply_filters('wpml_object_id', $this->category->term_id, ALSP_CATEGORIES_TAX, false, $language['language_code']))) {
				$tterm = get_term($tterm_id, ALSP_CATEGORIES_TAX);
				$language['url'] = get_term_link($tterm);
			}
			if ($this->is_location && ($tterm_id = apply_filters('wpml_object_id', $this->location->term_id, ALSP_LOCATIONS_TAX, false, $language['language_code']))) {
				$tterm = get_term($tterm_id, ALSP_LOCATIONS_TAX);
				$language['url'] = get_term_link($tterm, ALSP_LOCATIONS_TAX);
			}
			if ($this->is_tag && ($tterm_id = apply_filters('wpml_object_id', $this->tag->term_id, ALSP_TAGS_TAX, false, $language['language_code']))) {
				$tterm = get_term($tterm_id, ALSP_TAGS_TAX);
				$language['url'] = get_term_link($tterm, ALSP_TAGS_TAX);
			}
			if ($this->is_favourites) {
				$language['url'] = alsp_directoryUrl(array('alsp_action' => 'myfavourites'));
			}
			remove_filter('icl_current_language', array($this, 'tempLangToWPML'));
		}
		$sitepress->switch_lang(ICL_LANGUAGE_CODE);
		$alsp_instance->getIndexPage();
		return $w_active_languages;
	}
	
	// adapted for WPML
	public function alternate_hreflang($url, $lang) {
		global $sitepress, $alsp_instance;
		
		// WPML will not switch language using $sitepress->switch_lang() function when there is 'lang=' parameter in the URL, so we have to use such hack
		if ($sitepress->get_option('language_negotiation_type') == 3)
			remove_all_filters('icl_current_language');

		$sitepress->switch_lang($lang['language_code']);
		$this->temp_lang = $lang['language_code'];
		add_filter('icl_current_language', array($this, 'tempLangToWPML'));
		$alsp_instance->getIndexPage();
		if ($this->is_single && ($tlisting_post_id = apply_filters('wpml_object_id', $this->listing->post->ID, ALSP_POST_TYPE, false, $lang['language_code']))) {
			$url = get_permalink($tlisting_post_id);
		}
		if ($this->is_category && ($tterm_id = apply_filters('wpml_object_id', $this->category->term_id, ALSP_CATEGORIES_TAX, false, $lang['language_code']))) {
			$tterm = get_term($tterm_id, ALSP_CATEGORIES_TAX);
			$url = get_term_link($tterm, ALSP_CATEGORIES_TAX);
		}
		if ($this->is_location && ($tterm_id = apply_filters('wpml_object_id', $this->location->term_id, ALSP_LOCATIONS_TAX, false, $lang['language_code']))) {
			$tterm = get_term($tterm_id, ALSP_LOCATIONS_TAX);
			$url = get_term_link($tterm, ALSP_LOCATIONS_TAX);
		}
		if ($this->is_tag && ($tterm_id = apply_filters('wpml_object_id', $this->tag->term_id, ALSP_TAGS_TAX, false, $lang['language_code']))) {
			$tterm = get_term($tterm_id, ALSP_TAGS_TAX);
			$url = get_term_link($tterm, ALSP_TAGS_TAX);
		}
		if ($this->is_favourites) {
			$url = alsp_directoryUrl(array('alsp_action' => 'myfavourites'));
		}
		remove_filter('icl_current_language', array($this, 'tempLangToWPML'));
		$sitepress->switch_lang(ICL_LANGUAGE_CODE);
		$alsp_instance->getIndexPage();

		return $url;
	}

	// Add listing ID to query string while rendering Contact Form 7
	public function alsp_add_listing_id_to_wpcf7($url) {
		if ($this->is_single)
			$url = esc_url(add_query_arg('listing_id', $this->listing->post->ID, $url));
		
		return $url;
	}
	// Add listing ID to hidden fields while rendering Contact Form 7
	public function alsp_add_listing_id_to_wpcf7_field($fields) {
		if ($this->is_single) {
			$fields["listing_id"] = $this->listing->post->ID;
		}
		
		return $fields;
	}

	public function configure_seo_filters() {
		if ($this->is_home || $this->is_single || $this->is_search || $this->is_category || $this->is_location || $this->is_tag || $this->is_favourites) {
			// When using WP 4.4, just use the new hook.
			add_filter('pre_get_document_title', array($this, 'page_title'), 16);
			add_filter('wp_title', array($this, 'page_title'), 10, 2);
			if (defined('WPSEO_VERSION')) {
				if (version_compare(WPSEO_VERSION, '1.7.2', '<'))
					global $wpseo_front;
				else
					$wpseo_front = WPSEO_Frontend::get_instance();

				// real number of page for WP SEO plugin
				if ($this->query) {
					global $wp_query;
					$wp_query->max_num_pages = $this->query->max_num_pages;
				}

				// remove force_rewrite option of WP SEO plugin
				remove_action('template_redirect', array(&$wpseo_front, 'force_rewrite_output_buffer'), 99999);
				remove_action('wp_footer', array(&$wpseo_front, 'flush_cache'), -1);
				
				remove_filter('wp_title', array(&$wpseo_front, 'title'), 15, 3);
				remove_action('wp_head', array(&$wpseo_front, 'head'), 1);
	
				add_action('wp_head', array($this, 'page_meta'));
			}
		}
	}
	
	public function page_meta() {
		if (version_compare(WPSEO_VERSION, '1.7.2', '<'))
			global $wpseo_front;
		else
			$wpseo_front = WPSEO_Frontend::get_instance();
		if ($this->is_single) {
			global $post;
			$saved_page = $post;
			$post = get_post($this->listing->post->ID);
	
			$wpseo_front->metadesc();
			//$wpseo_front->metakeywords();
	
			$post = $saved_page;
		} elseif ($this->is_category) {
			if (version_compare(WPSEO_VERSION, '1.5.0', '<'))
				$metadesc = wpseo_get_term_meta($this->category, $this->category->taxonomy, 'desc');
			else
				$metadesc = WPSEO_Taxonomy_Meta::get_term_meta($this->category, $this->category->taxonomy, 'desc');

			if (!$metadesc && isset($wpseo_front->options['metadesc-tax-' . $this->category->taxonomy]))
				$metadesc = wpseo_replace_vars($wpseo_front->options['metadesc-tax-' . $this->category->taxonomy], (array) $this->category );
			$metadesc = apply_filters('wpseo_metadesc', trim($metadesc));
			echo '<meta name="description" content="' . esc_attr(strip_tags(stripslashes($metadesc))) . '"/>' . "\n";
		} elseif ($this->is_location) {
			if (version_compare(WPSEO_VERSION, '1.5.0', '<'))
				$metadesc = wpseo_get_term_meta($this->location, $this->location->taxonomy, 'desc');
			else
				$metadesc = WPSEO_Taxonomy_Meta::get_term_meta($this->location, $this->location->taxonomy, 'desc');

			if (!$metadesc && isset($wpseo_front->options['metadesc-tax-' . $this->location->taxonomy]))
				$metadesc = wpseo_replace_vars($wpseo_front->options['metadesc-tax-' . $this->location->taxonomy], (array) $this->location );
			$metadesc = apply_filters('wpseo_metadesc', trim($metadesc));
			echo '<meta name="description" content="' . esc_attr(strip_tags(stripslashes($metadesc))) . '"/>' . "\n";
		} elseif ($this->is_tag) {
			if (version_compare(WPSEO_VERSION, '1.5.0', '<'))
				$metadesc = wpseo_get_term_meta($this->tag, $this->tag->taxonomy, 'desc');
			else
				$metadesc = WPSEO_Taxonomy_Meta::get_term_meta($this->tag, $this->tag->taxonomy, 'desc');

			if (!$metadesc && isset($wpseo_front->options['metadesc-tax-' . $this->tag->taxonomy]))
				$metadesc = wpseo_replace_vars($wpseo_front->options['metadesc-tax-' . $this->tag->taxonomy], (array) $this->tag );
			$metadesc = apply_filters('wpseo_metadesc', trim($metadesc));
			echo '<meta name="description" content="' . esc_attr(strip_tags(stripslashes($metadesc))) . '"/>' . "\n";
		} elseif ($this->is_home) {
			$wpseo_front->metadesc();
			//$wpseo_front->metakeywords();
		}
	}
	
	public function page_title($title, $separator = '|') {
		global $alsp_instance;
		if (defined('WPSEO_VERSION')) {
			if (version_compare(WPSEO_VERSION, '1.7.2', '<'))
				global $wpseo_front;
			else
				$wpseo_front = WPSEO_Frontend::get_instance();
			if ($this->is_single) {
				$title = $wpseo_front->get_content_title(get_post($this->listing->post->ID));
				return esc_html(strip_tags(stripslashes(apply_filters('wpseo_title', $title))));
			} elseif ($this->is_category) {
				if (version_compare(WPSEO_VERSION, '1.5.0', '<'))
					$title = trim(wpseo_get_term_meta($this->category, $this->category->taxonomy, 'title'));
				else
					$title = trim(WPSEO_Taxonomy_Meta::get_term_meta($this->category, $this->category->taxonomy, 'title'));

				if (!empty($title))
					return wpseo_replace_vars($title, (array)$this->category);
				return $wpseo_front->get_title_from_options('title-tax-' . $this->category->taxonomy, $this->category);
			} elseif ($this->is_location) {
				if (version_compare(WPSEO_VERSION, '1.5.0', '<'))
					$title = trim(wpseo_get_term_meta($this->location, $this->location->taxonomy, 'title'));
				else
					$title = trim(WPSEO_Taxonomy_Meta::get_term_meta($this->location, $this->location->taxonomy, 'title'));

				if (!empty($title))
					return wpseo_replace_vars($title, (array)$this->location);
				return $wpseo_front->get_title_from_options('title-tax-' . $this->location->taxonomy, $this->location);
			} elseif ($this->is_tag) {
				if (version_compare(WPSEO_VERSION, '1.5.0', '<'))
					$title = trim(wpseo_get_term_meta($this->tag, $this->tag->taxonomy, 'title'));
				else
					$title = trim(WPSEO_Taxonomy_Meta::get_term_meta($this->tag, $this->tag->taxonomy, 'title'));

				if (!empty($title))
					return wpseo_replace_vars($title, (array)$this->tag);
				return $wpseo_front->get_title_from_options('title-tax-' . $this->tag->taxonomy, $this->tag);
			} elseif ($this->is_home) {
				//$page = get_post($alsp_instance->index_page_id);
				//return $wpseo_front->get_title_from_options('title-' . ALSP_POST_TYPE, (array) $page);
				return $wpseo_front->get_content_title();
			}

			if ($this->getPageTitle())
				$title = esc_html(strip_tags(stripslashes($this->getPageTitle()))) . ' ';
			return $title . wpseo_replace_vars('%%sep%% %%sitename%%', array());
		} else {
			$directory_title = '';
			if ($this->getPageTitle())
				$directory_title = $this->getPageTitle() . ' ' . $separator . ' ';
			if (alsp_get_wpml_dependent_option('alsp_directory_title')) 
				$directory_title .= alsp_get_wpml_dependent_option('alsp_directory_title');
			else
				$directory_title .= get_option('blogname');
			return $directory_title;
		}
	
		return $title;
	}

	// rewrite canonical URL
	public function rel_canonical_with_custom_tag_override() {
		echo '<link rel="canonical" href="' . get_permalink($this->listing->post->ID) . '" />
';
	}
	
	// Adding the Open Graph in the Language Attributes
	public function add_opengraph_doctype($output) {
		return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
	}
	
	// Lets add Open Graph Meta Info
	public function insert_fb_in_head() {
		global $ALSP_ADIMN_SETTINGS;
		echo '<meta property="og:type" content="article" />
';
		echo '<meta property="og:title" content="' . esc_attr($this->listing->title()) . '" />
';
		if ($this->listing->post->post_excerpt)
			$excerpt = $this->listing->post->post_excerpt;
		else
			$excerpt = $this->listing->getExcerptFromContent();
		echo '<meta property="og:description" content="' . esc_attr($excerpt) . '" />
';		
		echo '<meta property="og:url" content="' . get_permalink($this->listing->post->ID) . '" />
';
		echo '<meta property="og:site_name" content="' . $ALSP_ADIMN_SETTINGS['alsp_directory_title'] . '" />
';
		if ($this->listing->logo_image) {
			$thumbnail_src = $src_full = wp_get_attachment_image_src($this->listing->logo_image, 'medium');
			echo '<meta property="og:image" content="' . esc_attr($thumbnail_src[0]) . '" />
';
		}
	}

	public function display() {
		$output =  alsp_frontendRender($this->template, array('frontend_controller' => $this), true);
		wp_reset_postdata();

		return $output;
	}
}

add_action('init', 'alsp_handle_wpcf7');
function alsp_handle_wpcf7() {
	global $ALSP_ADIMN_SETTINGS;
	if (defined('WPCF7_VERSION')) {
		if ($ALSP_ADIMN_SETTINGS['alsp_listing_contact_form'] && defined('WPCF7_VERSION') && alsp_get_wpml_dependent_option('alsp_listing_contact_form_7')) {
			add_filter('wpcf7_mail_components', 'alsp_wpcf7_handle_email', 10, 2);
		}
			
		function alsp_wpcf7_handle_email($WPCF7_components, $WPCF7_currentform) {
			if (isset($_REQUEST['listing_id'])) {
				$post = get_post($_REQUEST['listing_id']);
	
				$mail = $WPCF7_currentform->prop('mail');
				// DO not touch mail_2
				if ($mail['recipient'] == $WPCF7_components['recipient']) {
					if ($post && isset($_POST['_wpcf7']) && preg_match_all('/'.get_shortcode_regex().'/s', alsp_get_wpml_dependent_option('alsp_listing_contact_form_7'), $matches)) {
						foreach ($matches[2] AS $key=>$shortcode) {
							if ($shortcode == 'contact-form-7') {
								if ($attrs = shortcode_parse_atts($matches[3][$key])) {
									if (isset($attrs['id']) && $attrs['id'] == $_POST['_wpcf7']) {
										$contact_email = null;
										if ($ALSP_ADIMN_SETTINGS['alsp_custom_contact_email'] && ($listing = alsp_getListing($post)) && $listing->contact_email) {
											$contact_email = $listing->contact_email;
										} elseif (($listing_owner = get_userdata($post->post_author)) && $listing_owner->user_email) {
											$contact_email = $listing_owner->user_email;
										}
										if ($contact_email)
											$WPCF7_components['recipient'] = $contact_email;
									}
								}
							}
						}
					}
				}
			}
			return $WPCF7_components;
		}
	}
}

?>