<?php 

class alsp_ajax_controller {

	public function __construct() {
		add_action('wp_ajax_alsp_get_map_markers', array($this, 'get_map_markers'));
		add_action('wp_ajax_nopriv_alsp_get_map_markers', array($this, 'get_map_markers'));

		add_action('wp_ajax_alsp_get_map_marker_info', array($this, 'get_map_marker_info'));
		add_action('wp_ajax_nopriv_alsp_get_map_marker_info', array($this, 'get_map_marker_info'));

		add_action('wp_ajax_alsp_get_sharing_buttons', array($this, 'get_sharing_buttons'));
		add_action('wp_ajax_nopriv_alsp_get_sharing_buttons', array($this, 'get_sharing_buttons'));

		add_action('wp_ajax_alsp_controller_request', array($this, 'controller_request'));
		add_action('wp_ajax_nopriv_alsp_controller_request', array($this, 'controller_request'));

		add_action('wp_ajax_alsp_search_by_poly', array($this, 'search_by_poly'));
		add_action('wp_ajax_nopriv_alsp_search_by_poly', array($this, 'search_by_poly'));
		
		add_action('wp_ajax_alsp_select_field_icon', array($this, 'select_field_icon'));
		add_action('wp_ajax_nopriv_alsp_select_field_icon', array($this, 'select_field_icon'));
		
		add_action('wp_ajax_alsp_contact_form', array($this, 'contact_form'));
		add_action('wp_ajax_nopriv_alsp_contact_form', array($this, 'contact_form'));
	}

	public function controller_request() {
		global $ALSP_ADIMN_SETTINGS, $alsp_instance;

		$post_args = $_POST;

		switch ($post_args['controller']) {
            case "contractor_controller": //ThangNN's additional code
                $shortcode_atts = array_merge(array(
                    'perpage' => 8,
                    'onepage' => 0,
                    'sticky_featured' => 0,
                    'order_by' => 'post_date',
                    'order' => 'DESC',
                    'hide_order' => 0,
                    'hide_count' => 0,
                    'hide_paginator' => 0,
                    'show_views_switcher' => 1,
                    'listings_view_type' => 'list',
                    'listings_view_grid_columns' => 2,
                    'logo_animation_effect' => 6,
                    'listing_post_style' => 3,
                    'author' => 0,
                    'scroll' => 0, //cz custom
                    'desktop_items' => '3' , //cz custom
                    'tab_landscape_items' => '3' , //cz custom
                    'tab_items' => '2' , //cz custom
                    'autoplay' => 'false' , //cz custom
                    'loop' => 'false' , //cz custom
                    'owl_nav' => 'false' , //cz custom
                    'delay' => '1000' , //cz custom
                    'autoplay_speed' => '1000' , //cz custom
                    'gutter' => '30' , //cz custom
                    'paged' => 1,
                    'template' => array('frontend/listings_block.tpl.php'),
                ), $post_args);
                // Strongly required for paginator
//                set_query_var('page', $shortcode_atts['paged']);
                $controller = new alsp_frontend_controller();
                $controller->init($post_args);
                $controller->hash = $post_args['hash'];
                $controller->args = $shortcode_atts;
                $controller->request_by = 'contractor_controller';
                $controller->custom_home = (isset($shortcode_atts['custom_home']) && $shortcode_atts['custom_home']);

                $args = array(
                    /*'post_type' => ALSP_POST_TYPE,
                    'post_status' => 'publish',
                    //'meta_query' => array(array('key' => '_listing_status', 'value' => 'active')),
                    'posts_per_page' => $shortcode_atts['perpage'],
                    'paged' => $shortcode_atts['paged'],*/
                    'role' => 'Contributor',
//                    'number' => $shortcode_atts['perpage'],
//                    'offset' =>   $shortcode_atts['paged']*$shortcode_atts['perpage']
                    'number' =>  $shortcode_atts['perpage'],
                    'offset' =>  ($post_args['paged']-1)*$shortcode_atts['perpage']
                );

//                var_dump($args);

                /*$args = apply_filters('alsp_search_args', $args, $shortcode_atts, true, $controller->hash);


                // found some plugins those break WP_Query by injections in pre_get_posts action, so decided to remove this hook temporarily
                global $wp_filter;
                if (isset($wp_filter['pre_get_posts'])) {
                    $pre_get_posts = $wp_filter['pre_get_posts'];
                    unset($wp_filter['pre_get_posts']);
                }*/
                $controller->query = new WP_User_Query($args);
                //var_dump($controller->query->request);

                // while random sorting - we have to exclude already shown listings, we are taking only needed
//                if (isset($shortcode_atts['existing_listings']) && $order_args['orderby'] == 'rand') {
//                    $all_posts_count = count($controller->query->posts);
//                    $existing_listings = array_filter(explode(',', $shortcode_atts['existing_listings']));
//                    foreach ($controller->query->posts AS $key=>$post) {
//                        if (in_array($post->ID, $existing_listings)) {
//                            unset($controller->query->posts[$key]);
//                        }
//                    }
//                    $controller->query->posts = array_values($controller->query->posts);
//                    $controller->query->posts = array_slice($controller->query->posts, 0, $shortcode_atts['perpage']);
//
//                    $controller->query->post_count = count($controller->query->posts);
//                    $controller->query->found_posts = $all_posts_count;
//                    $controller->query->max_num_pages = ceil($all_posts_count/$shortcode_atts['perpage']);
//                }




                $grid_padding = $ALSP_ADIMN_SETTINGS['alsp_grid_padding'];
                $alsp_grid_margin_bottom = $ALSP_ADIMN_SETTINGS['alsp_grid_margin_bottom'];
                $listings_html = '';
                if (!isset($post_args['without_listings']) || !$post_args['without_listings']) {
                    if (isset($post_args['do_append']) && $post_args['do_append']) {
                        if ( !empty($controller->query->get_results()))
                            foreach ($controller->query->get_results() as $contractor) {
                                $contractorID = $contractor->ID;
                                $contractor_img_url = get_the_author_meta('pacz_author_avatar_url', $contractorID, true);
                                $contractor_name = get_the_author_meta('display_name', $contractorID);
                                $contractor_address =      get_the_author_meta('address', $contractorID, true)
                                    .', '.get_the_author_meta('city', $contractorID, true)
                                    .', '.get_the_author_meta('state', $contractorID, true)
                                    .', '.get_the_author_meta('postalcode', $contractorID, true)
                                    .', '.get_the_author_meta('country', $contractorID, true);
                               if (!empty($contractor_img_url)) {
                                    $params = array('width' => 300, 'height' => 370, 'crop' => true);
                                    $imageUrl = bfi_thumb("$contractor_img_url", $params);

                                } else {
                                    $avatar_url = pacz_get_avatar_url(get_the_author_meta('user_email', $contractorID), $size = '300');
                                   $imageUrl = $avatar_url;
                                }
                                $listings_html .= '<article id="post-' . $contractorID . '" class="row alsp-listing listing-post-style-grid pacz-isotop-item isotop-item masonry-'.$controller->hash.'   clearfix isotope-item  " style="padding-left:'.$grid_padding.'px; padding-right:'.$grid_padding.'px; margin-bottom:'.$alsp_grid_margin_bottom.'px;" >';
                                $listings_html .= '<div class="listing-wrapper clearfix">';
                                //$listings_html .= $listing_style_to_show;
//                                $listings_html .= $controller->listings[$contractorID]->display(false, true);
//                                $listings_html .=  $shortcode_atts['paged'];
                                $listings_html .= '<figure class="alsp-listing-logo alsp-listings-own-page">
                                                     <a href="'.get_site_url().'/author/'.$contractor->user_login.'">
                                                         
                                                            <img
                                                                alt="'.$contractor_name.'"
                                                                src="'.$imageUrl.'"
                                                                width="370" height="260">                                                                                  
                                                        </a></figure>
                                                        <div class="clearfix alsp-listing-text-content-wrap">                                                                                
                                                            <header class="alsp-listing-header"><h2><a
                                                                        href="'.get_site_url().'/author/'.$contractor->user_login.'"
                                                                        title="'.$contractor_name.'">'.$contractor_name.'</a>
                                                                    <!--<span
                                                                            class="author-unverified pacz-icon-check-circle"></span>-->
                                                                </h2></header>
                                                            <p class="listing-location"><i
                                                                    class="pacz-fic3-pin-1"></i><span
                                                                    class="alsp-location" itemprop="address"
                                                                    itemscope=""
                                                                    itemtype="http://schema.org/PostalAddress"><span
                                                                        class="alsp-show-on-map"
                                                                        data-location-id=""><span
                                                                            itemprop="streetAddress">'.$contractor_address.'</span></span>
                                                            </p>
                                                        </div>';
                                 $listings_html .= '</div>';
                                $listings_html .= '</article>';
                            }
                        unset($controller->args['do_append']);
                    } else
                        $listings_html = alsp_frontendRender('frontend/listings_block.tpl.php', array('frontend_controller' => $controller), true);
                }
                wp_reset_postdata();

                $out = array(
                    'html' => $listings_html,
                    'hash' => $controller->hash,
//                    'map_markers' => (($controller->google_map) ? $controller->google_map->locations_option_array : ''),
                    'hide_show_more_listings_button' => ($shortcode_atts['paged'] >= $controller->query->max_num_pages) ? 1 : 0,
                );

//                if (isset($alsp_instance->radius_values_array[$controller->hash]) && isset($alsp_instance->radius_values_array[$controller->hash]['x_coord']) && isset($alsp_instance->radius_values_array[$controller->hash]['y_coord'])) {
//                    $out['radius_params'] = array(
//                        'radius_value' => $alsp_instance->radius_values_array[$controller->hash]['radius'],
//                        'map_coords_1' => $alsp_instance->radius_values_array[$controller->hash]['x_coord'],
//                        'map_coords_2' => $alsp_instance->radius_values_array[$controller->hash]['y_coord'],
//                        'dimension' => $ALSP_ADIMN_SETTINGS['alsp_miles_kilometers_in_search']
//                    );
//                }

                echo json_encode($out);

                break;
			case "directory_controller":
			case "listings_controller":
				if ($post_args['controller'] == "directory_controller")
					$shortcode_atts = array_merge(array(
							'perpage' => (isset($post_args['is_home']) && $post_args['is_home']) ? $ALSP_ADIMN_SETTINGS['alsp_listings_number_index'] : $ALSP_ADIMN_SETTINGS['alsp_listings_number_excerpt'],
							'onepage' => 0,
							'sticky_featured' => 0,
							'order_by' => $ALSP_ADIMN_SETTINGS['alsp_default_orderby'],
							'order' => $ALSP_ADIMN_SETTINGS['alsp_default_order'],
							'hide_order' => (int)(!($ALSP_ADIMN_SETTINGS['alsp_show_orderby_links'])),
							'hide_count' => 0,
							'hide_paginator' => 0,
							'show_views_switcher' => (int)$ALSP_ADIMN_SETTINGS['alsp_views_switcher'],
							'listings_view_type' => $ALSP_ADIMN_SETTINGS['alsp_views_switcher_default'],
							'listings_view_grid_columns' => (int)$ALSP_ADIMN_SETTINGS['alsp_views_switcher_grid_columns'],
							'logo_animation_effect' => (int)get_option('alsp_logo_animation_effect'),
							'listing_post_style' => 3,
							'author' => 0,
							'scroll' => 0, //cz custom
							'desktop_items' => '3' , //cz custom
							'tab_landscape_items' => '3' , //cz custom
							'tab_items' => '2' , //cz custom
							'autoplay' => 'false' , //cz custom
							'loop' => 'false' , //cz custom
							'owl_nav' => 'false' , //cz custom
							'delay' => '1000' , //cz custom
							'autoplay_speed' => '1000' , //cz custom
							'gutter' => '30' , //cz custom
							'paged' => 1,
							'template' => 'frontend/listings_block.tpl.php',
					), $post_args);
				elseif ($post_args['controller'] == "listings_controller")
					$shortcode_atts = array_merge(array(
							'perpage' => 10,
							'onepage' => 0,
							'sticky_featured' => 0,
							'order_by' => 'post_date',
							'order' => 'DESC',
							'hide_order' => 0,
							'hide_count' => 0,
							'hide_paginator' => 0,
							'show_views_switcher' => 1,
							'listings_view_type' => 'list',
							'listings_view_grid_columns' => 2,
							'logo_animation_effect' => 6,
							'listing_post_style' => 3,
							'author' => 0,
							'scroll' => 0, //cz custom
							'desktop_items' => '3' , //cz custom
							'tab_landscape_items' => '3' , //cz custom
							'tab_items' => '2' , //cz custom
							'autoplay' => 'false' , //cz custom
							'loop' => 'false' , //cz custom
							'owl_nav' => 'false' , //cz custom
							'delay' => '1000' , //cz custom
							'autoplay_speed' => '1000' , //cz custom
							'gutter' => '30' , //cz custom
							'paged' => 1,
							'template' => array('frontend/listings_block.tpl.php'),
					), $post_args);

				// This is required workaround
				if (isset($post_args['order_by'])) {
					$_GET['order_by'] = alsp_getValue($post_args, 'order_by', $shortcode_atts['order_by']);
					$_GET['order'] = alsp_getValue($post_args, 'order', $shortcode_atts['order']);
				} elseif (isset($post_args['radius']) && $post_args['radius'] && ((isset($post_args['location_id']) && $post_args['location_id']) || (isset($post_args['address']) && $post_args['address']))) {
					// When search by radius - order by distance by default instead of ordering by date
					$shortcode_atts['order_by'] = 'distance';
					$shortcode_atts['order'] = 'ASC';
				}

				// Strongly required for paginator
				set_query_var('page', $shortcode_atts['paged']);

				$controller = new alsp_frontend_controller();
				$controller->init($post_args);
				$controller->hash = $post_args['hash'];
				$controller->args = $shortcode_atts;
				$controller->request_by = 'listings_controller';
				$controller->custom_home = (isset($shortcode_atts['custom_home']) && $shortcode_atts['custom_home']);

				$default_orderby_args = array('order_by' => $shortcode_atts['order_by'], 'order' => $shortcode_atts['order']);
				$order_args = apply_filters('alsp_order_args', array(), $default_orderby_args, false);
				
				// while random sorting and we have to exclude already shown listings - do not limit records, we will take needed later
				if (isset($shortcode_atts['existing_listings']) && $order_args['orderby'] == 'rand') {
					$perpage = -1;
				} else {
					$perpage = $shortcode_atts['perpage'];
				}
				
				$args = array(
						'post_type' => ALSP_POST_TYPE,
						'post_status' => 'publish',
						//'meta_query' => array(array('key' => '_listing_status', 'value' => 'active')),
						'posts_per_page' => $shortcode_atts['perpage'],
						'paged' => $shortcode_atts['paged'],
				);
				if ($shortcode_atts['author'])
					$args['author'] = $shortcode_atts['author'];
				// render just one page
				if ($shortcode_atts['onepage'])
					$args['posts_per_page'] = -1;

				$args = array_merge($args, $order_args);
				$args = apply_filters('alsp_search_args', $args, $shortcode_atts, true, $controller->hash);
				if (isset($shortcode_atts['post__in'])) {
					$args = array_merge($args, array('post__in' => explode(',', $shortcode_atts['post__in'])));
				}
				if (isset($shortcode_atts['post__not_in'])) {
					$args = array_merge($args, array('post__not_in' => explode(',', $shortcode_atts['post__not_in'])));
				}
				
				if (isset($shortcode_atts['levels']) && !is_array($shortcode_atts['levels'])) {
					if ($levels = array_filter(explode(',', $shortcode_atts['levels']), 'trim')) {
						$controller->levels_ids = $levels;
						add_filter('posts_where', array($controller, 'where_levels_ids'));
					}
				}
				
				if (isset($shortcode_atts['levels']) || $shortcode_atts['sticky_featured']) {
					add_filter('posts_join', 'join_levels');
					if ($shortcode_atts['sticky_featured'])
						add_filter('posts_where', 'where_sticky_featured');
				}
					
				// found some plugins those break WP_Query by injections in pre_get_posts action, so decided to remove this hook temporarily
				global $wp_filter;
				if (isset($wp_filter['pre_get_posts'])) {
					$pre_get_posts = $wp_filter['pre_get_posts'];
					unset($wp_filter['pre_get_posts']);
				}
				$controller->query = new WP_Query($args);
				//var_dump($controller->query->request);
				
				// adapted for Relevanssi
				//if (alsp_is_relevanssi_search($shortcode_atts)) {
					//$controller->query->query_vars['s'] = alsp_getValue($shortcode_atts, 'what_search');
					//$controller->query->query_vars['posts_per_page'] = $perpage;
					//relevanssi_do_query($controller->query);
				//}
				//var_dump($controller->query->request);
				
				// while random sorting - we have to exclude already shown listings, we are taking only needed
				if (isset($shortcode_atts['existing_listings']) && $order_args['orderby'] == 'rand') {
					$all_posts_count = count($controller->query->posts);
					$existing_listings = array_filter(explode(',', $shortcode_atts['existing_listings']));
					foreach ($controller->query->posts AS $key=>$post) {
						if (in_array($post->ID, $existing_listings)) {
							unset($controller->query->posts[$key]);
						}
					}
					$controller->query->posts = array_values($controller->query->posts);
					$controller->query->posts = array_slice($controller->query->posts, 0, $shortcode_atts['perpage']);

					$controller->query->post_count = count($controller->query->posts);
					$controller->query->found_posts = $all_posts_count;
					$controller->query->max_num_pages = ceil($all_posts_count/$shortcode_atts['perpage']);
				}
				
				if (isset($post_args['with_map']) && $post_args['with_map'])
					$load_map_markers = true;
				else
					$load_map_markers = false;
				
				$map_args = array();
				if (isset($post_args['map_markers_is_limit']) && $post_args['map_markers_is_limit'])
					$map_args['map_markers_is_limit'] = true;
				else
					$map_args['map_markers_is_limit'] = false;
				
				$controller->processQuery($load_map_markers);
				
				if (isset($pre_get_posts))
					$wp_filter['pre_get_posts'] = $pre_get_posts;

				$base_url_args = apply_filters('alsp_base_url_args', array());
				if (isset($post_args['base_url']) && $post_args['base_url'])
					$controller->base_url = add_query_arg($base_url_args, $post_args['base_url']);
				else 
					$controller->base_url = alsp_directoryUrl($base_url_args);
				
				
				global $alsp_global_base_url;
				$alsp_global_base_url = $controller->base_url;
				add_filter('get_pagenum_link', array($this, 'get_pagenum_link'));
				
				$listing_post_styles = $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'];
				 
				 if(get_option('listing_style_to_show') == 'show_grid_style'){
					if(isset($listing_post_styles) && !empty($listing_post_styles)) {
						$listing_style = $listing_post_styles;
					}else{
						$listing_style = '';
					}
				 }else{
					 $listing_style = $ALSP_ADIMN_SETTINGS['alsp_listing_listview_post_style'];
				 }
				  if($ALSP_ADIMN_SETTINGS['alsp_listing_responsive_grid']){
					$alsp_responsive_col = 'responsive-2col';
				 }else{
					$alsp_responsive_col = '';
				 }
				 if($ALSP_ADIMN_SETTINGS['alsp_grid_masonry_display'] && get_option('listing_style_to_show') == 'show_grid_style'){
				 $masonry = 'masonry';
				 $isotope_el_class = 'isotop-enabled pacz-theme-loop ';
			 }else{
				 $masonry = '';
				 $isotope_el_class = '';
			 }
				 $grid_padding = $ALSP_ADIMN_SETTINGS['alsp_grid_padding'];
				$alsp_grid_margin_bottom = $ALSP_ADIMN_SETTINGS['alsp_grid_margin_bottom'];
				$listings_html = '';
				if (!isset($post_args['without_listings']) || !$post_args['without_listings']) {
					if (isset($post_args['do_append']) && $post_args['do_append']) {
						if ($controller->listings)
							while ($controller->query->have_posts()) {
								$controller->query->the_post(); 
								
								$listings_html .= '<article id="post-' . get_the_ID() . '" class="row alsp-listing '.$alsp_responsive_col.' listing-post-style-'.$listing_style.' pacz-isotop-item isotop-item masonry-'.$controller->hash.'   clearfix isotope-item ' . (($controller->listings[get_the_ID()]->level->featured) ? 'alsp-featured' : '') . ' ' . (($controller->listings[get_the_ID()]->level->sticky) ? 'alsp-sticky' : '') . '" style="padding-left:'.$grid_padding.'px; padding-right:'.$grid_padding.'px; margin-bottom:'.$alsp_grid_margin_bottom.'px;" >';
								$listings_html .= '<div class="listing-wrapper clearfix">';
								//$listings_html .= $listing_style_to_show;
								$listings_html .= $controller->listings[get_the_ID()]->display(false, true);
								$listings_html .= '</div>';
								$listings_html .= '</article>';
							}
						unset($controller->args['do_append']);
					} else
						$listings_html = alsp_frontendRender('frontend/listings_block.tpl.php', array('frontend_controller' => $controller), true);
				}
				wp_reset_postdata();
				
				$out = array(
						'html' => $listings_html,
						'hash' => $controller->hash,
						'map_markers' => (($controller->google_map) ? $controller->google_map->locations_option_array : ''),
						'hide_show_more_listings_button' => ($shortcode_atts['paged'] >= $controller->query->max_num_pages) ? 1 : 0,
				);
				
				if (isset($alsp_instance->radius_values_array[$controller->hash]) && isset($alsp_instance->radius_values_array[$controller->hash]['x_coord']) && isset($alsp_instance->radius_values_array[$controller->hash]['y_coord'])) {
					$out['radius_params'] = array(
							'radius_value' => $alsp_instance->radius_values_array[$controller->hash]['radius'],
							'map_coords_1' => $alsp_instance->radius_values_array[$controller->hash]['x_coord'],
							'map_coords_2' => $alsp_instance->radius_values_array[$controller->hash]['y_coord'],
							'dimension' => $ALSP_ADIMN_SETTINGS['alsp_miles_kilometers_in_search']
					);
				}
				
				echo json_encode($out);

				break;
		}
		
		die();
	}
	
	public function get_pagenum_link($result) {
		global $alsp_global_base_url;

		if ($alsp_global_base_url) {
			preg_match('/paged=(.?)/', $result, $matches);
			if (isset($matches[1])) {
				global $wp_rewrite;
				if ($wp_rewrite->using_permalinks()) {
					$parsed_url = parse_url($alsp_global_base_url);
					$query_args = (isset($parsed_url['query'])) ? wp_parse_args($parsed_url['query']) : array();
					$query_args = array_map('urlencode', $query_args);
					$url_without_get = ($pos_get = strpos($alsp_global_base_url, '?')) ? substr($alsp_global_base_url, 0, $pos_get) : $alsp_global_base_url;
					return esc_url(add_query_arg($query_args, trailingslashit(trailingslashit($url_without_get) . 'page/' . $matches[1])));
				} else
					return add_query_arg('page', $matches[1], $alsp_global_base_url);
			} else 
				return $alsp_global_base_url;
		}
		return $result;
	}

	public function get_map_markers() {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;

		$post_args = $_POST;
		$hash = $post_args['hash'];

		$map_markers = array();
		if (isset($post_args['neLat']) && isset($post_args['neLng']) && isset($post_args['swLat']) && isset($post_args['swLng'])) {
			// needed to unset 'ajax_loading' parameter when it is calling by AJAX, then $args will be passed to map controller
			if (isset($post_args['ajax_loading']))
				unset($post_args['ajax_loading']);
			
			if (isset($post_args['radius']) && $post_args['radius'] && ((isset($post_args['location_id']) && $post_args['location_id']) || (isset($post_args['address']) && $post_args['address']))) {
				// When search by radius - order by distance by default instead of ordering by date
				$post_args['order_by'] = 'distance';
				$post_args['order'] = 'ASC';
			}
			
			$post_args['custom_home'] = 0;

			$map_controller = new alsp_map_controller();
			$map_controller->hash = $hash;
			$map_controller->init($post_args);
			wp_reset_postdata();
			
			$map_markers = $map_controller->google_map->locations_option_array;
		}
			
		$listings_html = '';
		if ((!isset($post_args['without_listings']) || !$post_args['without_listings'])) {
			$shortcode_atts = array_merge(array(
					'perpage' => 10,
					'onepage' => 0,
					'sticky_featured' => 0,
					'order_by' => 'post_date',
					'order' => 'DESC',
					'hide_order' => 0,
					'hide_count' => 0,
					'hide_paginator' => 0,
					'show_views_switcher' => 1,
					'listings_view_type' => 'list',
					'listings_view_grid_columns' => 2,
					'author' => 0,
					'paged' => 1,
					'scroll' => 0,
					'ajax_initial_load' => 0,
					'template' => 'frontend/listings_block.tpl.php',
			), $post_args);

			$post_ids = array();
			if (isset($map_controller->google_map->locations_array) && $map_controller->google_map->locations_array) {
				foreach ($map_controller->google_map->locations_array AS $location)
					$post_ids[] = $location->post_id;
				$shortcode_atts['post__in'] = implode(',', $post_ids);
			} else
				$shortcode_atts['post__in'] = 0;

			$listings_controller = new alsp_listings_controller();
			$listings_controller->init($shortcode_atts);
			$listings_controller->hash = $hash;
			
			$base_url_args = apply_filters('alsp_base_url_args', array());
			if (isset($post_args['base_url']) && $post_args['base_url'])
				$listings_controller->base_url = add_query_arg($base_url_args, $post_args['base_url']);
			else
				$listings_controller->base_url = alsp_directoryUrl($base_url_args);

			$listings_html = alsp_frontendRender('frontend/listings_block.tpl.php', array('frontend_controller' => $listings_controller), true);
			wp_reset_postdata();
		}

		$out = array(
				'html' => $listings_html,
				'hash' => $hash,
				'map_markers' => $map_markers,
		);

		if (isset($alsp_instance->radius_values_array[$hash]) && isset($alsp_instance->radius_values_array[$hash]['x_coord']) && isset($alsp_instance->radius_values_array[$hash]['y_coord'])) {
			$out['radius_params'] = array(
					'radius_value' => $alsp_instance->radius_values_array[$hash]['radius'],
					'map_coords_1' => $alsp_instance->radius_values_array[$hash]['x_coord'],
					'map_coords_2' => $alsp_instance->radius_values_array[$hash]['y_coord'],
					'dimension' => $ALSP_ADIMN_SETTINGS['alsp_miles_kilometers_in_search']
			);
		}
			
		echo json_encode($out);

		die();
	}
	
	public function search_by_poly() {
		$post_args = $_POST;
		$hash = $post_args['hash'];
		
		$out = array(
				'hash' => $hash
		);

		$map_markers = array();
		if (isset($post_args['geo_poly']) && $post_args['geo_poly']) {
			$map_controller = new alsp_map_controller();
			$map_controller->hash = $hash;
			// Here we need to remove any location-based parameters, leave only content-based (like categories, content fields, ....)
			$post_args['ajax_loading'] = 0; // ajax loading always OFF
			$post_args['ajax_markers_loading'] = 0; // ajax infowindow always OFF
			$post_args['radius'] = 0; // this is not the case for radius search
			$post_args['address'] = ''; // this is not the case for address search
			$post_args['location_id'] = 0; // this is not the case for search by location ID
			$post_args['locations'] = ''; // this is not the case for search by locations
			$post_args['custom_home'] = 0;
			$map_controller->init($post_args);
			wp_reset_postdata();

			$map_markers = $map_controller->google_map->locations_option_array;
		}
		
		$listings_html = '';
		if ((!isset($post_args['without_listings']) || !$post_args['without_listings'])) {
			$shortcode_atts = array_merge(array(
					'perpage' => 10,
					'onepage' => 0,
					'sticky_featured' => 0,
					'order_by' => 'post_date',
					'order' => 'DESC',
					'hide_order' => 0,
					'hide_count' => 0,
					'hide_paginator' => 0,
					'show_views_switcher' => 1,
					'listings_view_type' => 'list',
					'listings_view_grid_columns' => 2,
					'author' => 0,
					'paged' => 1,
					'scroll' => 0,
					'ajax_initial_load' => 0,
					'template' => 'frontend/listings_block.tpl.php',
			), $post_args);

			if (isset($map_controller->google_map->locations_array) && $map_controller->google_map->locations_array) {
				$post_ids = array();
				foreach ($map_controller->google_map->locations_array AS $location)
					$post_ids[] = $location->post_id;
				$shortcode_atts['post__in'] = implode(',', $post_ids);
			} else
				$shortcode_atts['post__in'] = 0;
		
			$listings_controller = new alsp_listings_controller();
			$listings_controller->init($shortcode_atts);
			$listings_controller->hash = $hash;
		
			$listings_html = alsp_frontendRender('frontend/listings_block.tpl.php', array('frontend_controller' => $listings_controller), true);
			wp_reset_postdata();
		}
		
		$out['html'] = $listings_html;
		$out['map_markers'] = $map_markers;

		echo json_encode($out);
	
		die();
	}
	
	public function get_map_marker_info() {
		global $alsp_instance, $wpdb;

		if (isset($_POST['location_id']) && is_numeric($_POST['location_id'])) {
			$location_id = $_POST['location_id'];

			$row = $wpdb->get_row("SELECT * FROM {$wpdb->alsp_locations_relationships} WHERE id=".$location_id, ARRAY_A);

			if ($row && $row['location_id'] || $row['map_coords_1'] != '0.000000' || $row['map_coords_2'] != '0.000000' || $row['address_line_1'] || $row['zip_or_postal_index']) {
				$listing = new alsp_listing;
				if ($listing->loadListingFromPost($row['post_id'])) {
					$location = new alsp_location($row['post_id']);
					$location_settings['id'] = alsp_getValue($row, 'id');
					$location_settings['selected_location'] = alsp_getValue($row, 'location_id');
					$location_settings['address_line_1'] = alsp_getValue($row, 'address_line_1');
					$location_settings['address_line_2'] = alsp_getValue($row, 'address_line_2');
					$location_settings['zip_or_postal_index'] = alsp_getValue($row, 'zip_or_postal_index');
					$location_settings['additional_info'] = alsp_getValue($row, 'additional_info');
					if ($listing->level->google_map) {
						$location_settings['manual_coords'] = alsp_getValue($row, 'manual_coords');
						$location_settings['map_coords_1'] = alsp_getValue($row, 'map_coords_1');
						$location_settings['map_coords_2'] = alsp_getValue($row, 'map_coords_2');
						if ($listing->level->google_map_markers)
							$location_settings['map_icon_file'] = alsp_getValue($row, 'map_icon_file');
					}
					$location->createLocationFromArray($location_settings);
						
					$logo_image = '';
					if ($listing->logo_image) {
						$src = wp_get_attachment_image_src($listing->logo_image, array(80, 80));
						$logo_image = $src[0];
					}
						
					$listing_link = '';
					if ($listing->level->listings_own_page)
						$listing_link = get_permalink($listing->post->ID);
						
					$content_fields_output = $listing->setMapContentFields($alsp_instance->content_fields->getMapContentFields(), $location);

					$locations_option_array = array(
							$location->id,
							$location->map_coords_1,
							$location->map_coords_2,
							$location->map_icon_file,
							$location->map_icon_color,
							$listing->map_zoom,
							$listing->title(),
							$logo_image,
							$listing_link,
							$content_fields_output,
							'post-' . $listing->post->ID,
					);
						
					echo json_encode($locations_option_array);
				}
			}
		}
		die();
	}
	
	public function select_field_icon() {
		alsp_frontendRender('select_fa_icons.tpl.php', array('icons' => alsp_get_fa_icons_names()));
		die();
	}
	
	public function get_sharing_buttons() {
		alsp_frontendRender('frontend/sharing_buttons_ajax_response.tpl.php', array('post_id' => $_POST['post_id']));
		die();
	}
	
	public function contact_form() {
		global $ALSP_ADIMN_SETTINGS;
		check_ajax_referer('alsp_contact_nonce', 'security');

		$success = '';
		$error = '';
		$validation = new alsp_form_validation;
		if (!is_user_logged_in()) {
			$validation->set_rules('contact_name', __('Contact name', 'ALSP'), 'required');
			$validation->set_rules('contact_email', __('Contact email', 'ALSP'), 'required|valid_email');
		}
		$validation->set_rules('listing_id', __('Listing ID', 'ALSP'), 'required');
		$validation->set_rules('contact_message', __('Your message', 'ALSP'), 'required|max_length[1500]');
		if ($validation->run()) {
			$listing = new alsp_listing();
			if ($listing->loadListingFromPost($validation->result_array('listing_id'))) {
				if (!is_user_logged_in()) {
					$contact_name = $validation->result_array('contact_name');
					$contact_email = $validation->result_array('contact_email');
				} else {
					$current_user = wp_get_current_user();
					$contact_name = $current_user->display_name;
					$contact_email = $current_user->user_email;
				}
				$contact_message = $validation->result_array('contact_message');
	
				if (alsp_is_recaptcha_passed()) {
					if ($ALSP_ADIMN_SETTINGS['alsp_custom_contact_email'] && $listing->contact_email)
						$listing_owner_email = $listing->contact_email;
					else {
						$listing_owner = get_userdata($listing->post->post_author);
						$listing_owner_email = $listing_owner->user_email;
					}
	
					$headers[] = "From: $contact_name <$contact_email>";
					$headers[] = "Reply-To: $contact_email";
					$headers[] = "Content-Type: text/html";

					$subject = "[" . get_option('blogname') . "] " . sprintf(__('%s contacted you about your listing "%s"', 'ALSP'), $contact_name, $listing->title());
	
					$body = alsp_frontendRender('emails/contact_form.tpl.php',
							array(
									'contact_name' => $contact_name,
									'contact_email' => $contact_email,
									'contact_message' => $contact_message,
									'listing_title' => $listing->title(),
									'listing_url' => get_permalink($listing->post->ID)
							), true);
	
					if (wp_mail($listing_owner->user_email, $subject, $body, $headers)) {
						unset($_POST['contact_name']);
						unset($_POST['contact_email']);
						unset($_POST['contact_message']);
						$success = __('You message was sent successfully!', 'ALSP');
					} else
						$error = esc_attr__("An error occurred and your message wasn't sent!", 'ALSP');
				} else {
					$error = esc_attr__("Anti-bot test wasn't passed!", 'ALSP');
				}
			}
		} else {
			$error = $validation->error_string();
		}
	
		echo json_encode(array('error' => $error, 'success' => $success));
	
		die();
	}
}
?>