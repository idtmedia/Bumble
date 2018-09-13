<?php 


	public $request_by = 'listings_controller';

	public function init($args = array()) {
		global $alsp_instance;
		
		parent::init($args);
	
		if (get_query_var('page'))
			$paged = get_query_var('page');
		elseif (get_query_var('paged'))
			$paged = get_query_var('paged');
		else
			$paged = 1;
		
		$shortcode_atts = array_merge(array(
				'perpage' => 10,
				'onepage' => 0,
				'sticky_featured' => 0,
				'order_by' => 'post_date',
				'order' => 'ASC',
/* 				'order_by' => (isset($_GET['order_by']) && $_GET['order_by'] ? $_GET['order_by'] : 'post_date'),
				'order' => (isset($_GET['order']) && $_GET['order'] ? $_GET['order'] : 'ASC'), */
				'hide_order' => 0,
				'hide_count' => 0,
				'hide_paginator' => 0,
				'show_views_switcher' => 1,
				'listings_view_type' => 'list',
				'listings_view_grid_columns' => 2,
				'listing_thumb_width' => (int)get_option('alsp_listing_thumb_width'),
				'wrap_logo_list_view' => 0,
				'logo_animation_effect' => 6,
				'listing_post_style' => 13,
				'author' => 0,
				'paged' => $paged,
				'ajax_initial_load' => (int)get_option('alsp_ajax_initial_load'),
				'include_categories_children' => 0,
				'related_categories' => 0,
				'related_locations' => 0,
				'related_tags' => 0,
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
				'template' => 'frontend/listings_block.tpl.php',
				'uid' => null,
		), $args);
		$shortcode_atts = apply_filters('alsp_related_shortcode_args', $shortcode_atts, $args);

		$this->args = $shortcode_atts;
		$this->base_url = get_permalink();
		$this->template = $this->args['template'];

		$args = array(
				'post_type' => ALSP_POST_TYPE,
				'post_status' => 'publish',
				'meta_query' => array(array('key' => '_listing_status', 'value' => 'active')),
				'posts_per_page' => $shortcode_atts['perpage'],
				'paged' => $paged,
		);
		if ($shortcode_atts['author'])
			$args['author'] = $shortcode_atts['author'];

		// render just one page
		if ($shortcode_atts['onepage'])
			$args['posts_per_page'] = -1;

		$args = array_merge($args, apply_filters('alsp_order_args', array(), $shortcode_atts, true));
		$args = apply_filters('alsp_search_args', $args, $this->args, $this->args['include_categories_children'], $this->hash);

		if (isset($this->args['post__in'])) {
			$args = array_merge($args, array('post__in' => explode(',', $this->args['post__in'])));
		}
		if (isset($this->args['post__not_in'])) {
			$args = array_merge($args, array('post__not_in' => explode(',', $this->args['post__not_in'])));
		}

		if (!$shortcode_atts['ajax_initial_load']) {
			if (isset($this->args['levels']) && !is_array($this->args['levels'])) {
				if ($levels = array_filter(explode(',', $this->args['levels']), 'trim')) {
					$this->levels_ids = $levels;
					add_filter('posts_where', array($this, 'where_levels_ids'));
				}
			}
	
			if (isset($this->args['levels']) || $this->args['sticky_featured']) {
				add_filter('posts_join', 'join_levels');
				if ($this->args['sticky_featured'])
					add_filter('posts_where', 'where_sticky_featured');
			}
			$this->query = new WP_Query($args);
			//var_dump($this->query->request);
			$this->processQuery(false);

			if ($this->args['sticky_featured']) {
				remove_filter('posts_join', 'join_levels');
				remove_filter('posts_where', 'where_sticky_featured');
			}
	
			if ($this->levels_ids)
				remove_filter('posts_where', array($this, 'where_levels_ids'));
		} else {
			$this->do_initial_load = false;
		}
		
		apply_filters('alsp_frontend_controller_construct', $this);
	}


?>