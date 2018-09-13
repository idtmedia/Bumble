<?php 

add_action('widgets_init', 'alsp_register_search_widget');
function alsp_register_search_widget() {
	register_widget('alsp_search_widget');
}

class alsp_search_widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
				'alsp_search_widget',
				__('ALSP - Search', 'ALSP'),
				array('description' => __( 'Search Form', 'ALSP'),)
		);
		
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
		//add_action('wp_head', array($this, 'enqueue_dynamic_css'), 9999);
	}

	public function widget($args, $instance) {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;
		// Show only on directory pages and only when main search form wasn't displayed
		// also check what and where search sections
		if ((!$instance['visibility'] || !empty($alsp_instance->frontend_controllers)) && ($ALSP_ADIMN_SETTINGS['alsp_show_what_search'] || $ALSP_ADIMN_SETTINGS['alsp_show_where_search'])) {
			if (!empty($alsp_instance->frontend_controllers))
				foreach ($alsp_instance->frontend_controllers AS $shortcode_controllers)
					foreach ($shortcode_controllers AS $controller)
						if (is_object($controller) && $controller->search_form && $instance['search_visibility'])
							return false;
			
			$title = apply_filters('widget_title', $instance['title']);
	
			alsp_frontendRender('widgets/search_widget.tpl.php', array('args' => $args, 'title' => $title, 'uid' => $instance['uid']));
		}
	}

	public function form($instance) {
		$defaults = array('title' => __('Search listings', 'ALSP'), 'uid' => '', 'visibility' => 1, 'search_visibility' => 1);
		$instance = wp_parse_args((array) $instance, $defaults);

		alsp_frontendRender('widgets/search_widget_options.tpl.php', array('widget' => $this, 'instance' =>$instance));
	}
	
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['uid'] = (!empty($new_instance['uid'])) ? strip_tags($new_instance['uid']) : '';
		$instance['visibility'] = (!empty($new_instance['visibility'])) ? strip_tags($new_instance['visibility']) : '';
		$instance['search_visibility'] = (!empty($new_instance['search_visibility'])) ? strip_tags($new_instance['search_visibility']) : '';

		return $instance;
	}
	
	public function wp_enqueue_scripts() {
		global $ALSP_ADIMN_SETTINGS;
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true) && !$current_widget_options['visibility'] && ($ALSP_ADIMN_SETTINGS['alsp_show_what_search'] || $ALSP_ADIMN_SETTINGS['alsp_show_where_search'])) {
				global $alsp_instance, $alsp_fsubmit_instance, $alsp_payments_instance, $alsp_ratings_instance;
		
				$alsp_instance->enqueue_scripts_styles(true);
				if ($alsp_fsubmit_instance)
					$alsp_fsubmit_instance->enqueue_scripts_styles(true);
				if ($alsp_payments_instance)
					$alsp_payments_instance->enqueue_scripts_styles(true);
				if ($alsp_ratings_instance)
					$alsp_ratings_instance->enqueue_scripts_styles(true);
			}
		}
	}
	
	/*public function enqueue_dynamic_css() {
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true) && !$current_widget_options['visibility'] && ($ALSP_ADIMN_SETTINGS['alsp_show_what_search'] || $ALSP_ADIMN_SETTINGS['alsp_show_where_search'])) {
				global $alsp_instance;
					
				$alsp_instance->enqueue_dynamic_css(true);
			}
		}
	}*/
}




add_action('widgets_init', 'alsp_register_categories_widget');
function alsp_register_categories_widget() {
	register_widget('alsp_categories_widget');
}

class alsp_categories_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
			'alsp_categories_widget',
			__('ALSP - Categories', 'ALSP'),
			array('description' => __( 'Categories list', 'ALSP'),)
		);
		
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
		//add_action('wp_head', array($this, 'enqueue_dynamic_css'), 9999);
	}
	
	public function widget($args, $instance) {
		global $alsp_instance;

		if (!$instance['visibility'] || !empty($alsp_instance->frontend_controllers)) {
			$title = apply_filters('widget_title', $instance['title']);
			$style = (isset($instance['style']))? $instance['style']: 1;
			// adapted for WPML
			global $sitepress;
			if ($instance['parent'] && function_exists('wpml_object_id_filter') && $sitepress) {
				if ($tparent = apply_filters('wpml_object_id', $instance['parent'], ALSP_CATEGORIES_TAX))
					$instance['parent'] = $tparent;
			}
	
			alsp_frontendRender('widgets/categories_widget.tpl.php', array('args' => $args, 'title' => $title, 'style' => $style, 'depth' => $instance['depth'], 'counter' => $instance['counter'], 'subcats' => $instance['subcats'], 'parent' => $instance['parent']));
		}
	}
	
	public function form($instance) {
		$defaults = array('title' => __('Categories list', 'ALSP'), 'style' => 1, 'depth' => 1, 'counter' => 0, 'subcats' => 0, 'visibility' => 1, 'parent' => 0);
		$instance = wp_parse_args((array) $instance, $defaults);
		
		alsp_frontendRender('widgets/categories_widget_options.tpl.php', array('widget' => $this, 'instance' => $instance));
	}
	
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['style'] = (!empty($new_instance['style'])) ? strip_tags($new_instance['style']) : '';
		$instance['depth'] = (!empty($new_instance['depth'])) ? strip_tags($new_instance['depth']) : '';
		$instance['counter'] = (!empty($new_instance['counter'])) ? strip_tags($new_instance['counter']) : '';
		$instance['subcats'] = strip_tags($new_instance['subcats']);
		$instance['parent'] = strip_tags($new_instance['parent']);
		$instance['visibility'] = (!empty($new_instance['visibility'])) ? strip_tags($new_instance['visibility']) : '';
	
		return $instance;
	}
	
	public function wp_enqueue_scripts() {
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true) && !$current_widget_options['visibility']) {
				global $alsp_instance, $alsp_fsubmit_instance, $alsp_payments_instance, $alsp_ratings_instance;
	
				$alsp_instance->enqueue_scripts_styles(true);
				if ($alsp_fsubmit_instance)
					$alsp_fsubmit_instance->enqueue_scripts_styles(true);
				if ($alsp_payments_instance)
					$alsp_payments_instance->enqueue_scripts_styles(true);
				if ($alsp_ratings_instance)
					$alsp_ratings_instance->enqueue_scripts_styles(true);
			}
		}
	}

	/*public function enqueue_dynamic_css() {
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true) && !$current_widget_options['visibility']) {
				global $alsp_instance;
				
				$alsp_instance->enqueue_dynamic_css(true);
			}
		}
	}*/
}





add_action('widgets_init', 'alsp_register_locations_widget');
function alsp_register_locations_widget() {
	register_widget('alsp_locations_widget');
}

class alsp_locations_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
			'alsp_locations_widget',
			__('ALSP - Locations', 'ALSP'),
			array('description' => __( 'Locations list', 'ALSP'),)
		);
		
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
		//add_action('wp_head', array($this, 'enqueue_dynamic_css'), 9999);
	}

	public function widget($args, $instance) {
		global $alsp_instance;
		
		if (!$instance['visibility'] || !empty($alsp_instance->frontend_controllers)) {
			$title = apply_filters('widget_title', $instance['title']);
			$style = (isset($instance['style']))? $instance['style']: 1;
			// adapted for WPML
			global $sitepress;
			if ($instance['parent'] && function_exists('wpml_object_id_filter') && $sitepress) {
				if ($tparent = apply_filters('wpml_object_id', $instance['parent'], ALSP_LOCATIONS_TAX))
					$instance['parent'] = $tparent;
			}
	
			alsp_frontendRender('widgets/locations_widget.tpl.php', array('args' => $args, 'title' => $title, 'style' => $style, 'depth' => $instance['depth'], 'counter' => $instance['counter'], 'sublocations' => $instance['sublocations'], 'parent' => $instance['parent']));
		}
	}
	
	public function form($instance) {
		$defaults = array('title' => __('Locations list', 'ALSP'), 'style' => 1, 'depth' => 1, 'counter' => 0, 'sublocations' => 0, 'visibility' => 1, 'parent' => 0);
		$instance = wp_parse_args((array) $instance, $defaults);
		
		alsp_frontendRender('widgets/locations_widget_options.tpl.php', array('widget' => $this, 'instance' => $instance));
	}
	
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['style'] = (!empty($new_instance['style'])) ? strip_tags($new_instance['style']) : '';
		$instance['depth'] = (!empty($new_instance['depth'])) ? strip_tags($new_instance['depth']) : '';
		$instance['counter'] = (!empty($new_instance['counter'])) ? strip_tags($new_instance['counter']) : '';
		$instance['sublocations'] = strip_tags($new_instance['sublocations']);
		$instance['parent'] = strip_tags($new_instance['parent']);
		$instance['visibility'] = (!empty($new_instance['visibility'])) ? strip_tags($new_instance['visibility']) : '';
	
		return $instance;
	}
	
	public function wp_enqueue_scripts() {
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true) && !$current_widget_options['visibility']) {
				global $alsp_instance, $alsp_fsubmit_instance, $alsp_payments_instance, $alsp_ratings_instance;
		
				$alsp_instance->enqueue_scripts_styles(true);
				if ($alsp_fsubmit_instance)
					$alsp_fsubmit_instance->enqueue_scripts_styles(true);
				if ($alsp_payments_instance)
					$alsp_payments_instance->enqueue_scripts_styles(true);
				if ($alsp_ratings_instance)
					$alsp_ratings_instance->enqueue_scripts_styles(true);
			}
		}
	}
	
	/*public function enqueue_dynamic_css() {
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true) && !$current_widget_options['visibility']) {
				global $alsp_instance;
					
				$alsp_instance->enqueue_dynamic_css(true);
			}
		}
	}*/
}






add_action('widgets_init', 'alsp_register_listings_widget');
function alsp_register_listings_widget() {
	register_widget('alsp_listings_widget');
}

class alsp_listings_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
			'alsp_listings_widget',
			__('ALSP - Listings', 'ALSP'),
			array('description' => __( 'Listings', 'ALSP'),)
		);
		
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
	}

	public function widget($args, $instance) {
		global $alsp_instance;

		if (!$instance['visibility'] || !empty($alsp_instance->frontend_controllers)) {
			$title = apply_filters('widget_title', $instance['title']);
			$width = (isset($instance['width']))? $instance['width']: '';
			$height = (isset($instance['height']))? $instance['height']: '';
			$is_slider_view = (isset($instance['is_slider_view']))? $instance['is_slider_view']: 0;
			if ($instance['is_sticky_featured'] || $instance['only_sticky_featured']) {
				add_filter('posts_join', 'join_levels');
				add_filter('posts_orderby', 'orderby_levels', 1);
				if ($instance['only_sticky_featured'])
					add_filter('posts_where', 'where_sticky_featured');
			}
			$query_args = array(
					'post_type' => ALSP_POST_TYPE,
					'post_status' => 'publish',
					'meta_query' => array(array('key' => '_listing_status', 'value' => 'active')),
					'posts_per_page' => $instance['number_of_listings'],
					'orderby' => 'date',
					'order' => 'desc',
			);
			
			$query = new WP_Query($query_args);
			$listings = array();
			while ($query->have_posts()) {
				$query->the_post();

				$listing = new alsp_listing;
				$listing->loadListingFromPost(get_post());
				$listings[get_the_ID()] = $listing;
			}
			//this is reset is really required after the loop ends
			wp_reset_postdata();
			if ($instance['is_sticky_featured']) {
				remove_filter('posts_join', 'join_levels');
				remove_filter('posts_orderby', 'orderby_levels', 1);
				if ($instance['only_sticky_featured'])
					remove_filter('posts_where', 'where_sticky_featured');
			}

			if ($listings)
				alsp_frontendRender('widgets/listings_widget.tpl.php', array('args' => $args, 'title' => $title, 'listings' => $listings, 'is_slider_view' => $is_slider_view, 'width' => $width, 'height' => $height));
		}
	}
	
	public function form($instance) {
		$defaults = array('title' => __('Listings', 'ALSP'), 'number_of_listings' => 5, 'is_sticky_featured' => 0, 'only_sticky_featured' => 0, 'visibility' => 1, 'is_slider_view' => 0, 'width' => 310, 'height' => 220);
		$instance = wp_parse_args((array) $instance, $defaults);
		
		alsp_frontendRender('widgets/listings_widget_options.tpl.php', array('widget' => $this, 'instance' => $instance));
	}
	
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['number_of_listings'] = (!empty($new_instance['number_of_listings'])) ? strip_tags($new_instance['number_of_listings']) : '';
		$instance['is_sticky_featured'] = (!empty($new_instance['is_sticky_featured'])) ? strip_tags($new_instance['is_sticky_featured']) : '';
		$instance['only_sticky_featured'] = (!empty($new_instance['only_sticky_featured'])) ? strip_tags($new_instance['only_sticky_featured']) : '';
		$instance['visibility'] = (!empty($new_instance['visibility'])) ? strip_tags($new_instance['visibility']) : '';
		$instance['is_slider_view'] = (!empty($new_instance['is_slider_view'])) ? strip_tags($new_instance['is_slider_view']) :'';
		$instance['width'] = (!empty($new_instance['width'])) ? strip_tags($new_instance['width']) : '';
		$instance['height'] = (!empty($new_instance['height'])) ? strip_tags($new_instance['height']) : '';
		return $instance;
	}
	
	public function wp_enqueue_scripts() {
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true) && !$current_widget_options['visibility']) {
				global $alsp_instance, $alsp_fsubmit_instance, $alsp_payments_instance, $alsp_ratings_instance;
		
				$alsp_instance->enqueue_scripts_styles(true);
				if ($alsp_fsubmit_instance)
					$alsp_fsubmit_instance->enqueue_scripts_styles(true);
				if ($alsp_payments_instance)
					$alsp_payments_instance->enqueue_scripts_styles(true);
				if ($alsp_ratings_instance)
					$alsp_ratings_instance->enqueue_scripts_styles(true);
			}
		}
	}
}


add_action('widgets_init', 'alsp_register_bids_widget');
function alsp_register_bids_widget() {
	register_widget('alsp_bids_widget');
}

class alsp_bids_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
			'alsp_bids_widget',
			__('ALSP - Bids', 'ALSP'),
			array('description' => __( 'Classiads Bids', 'ALSP'),)
		);
		
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
	}

	public function widget($args, $instance) {
		global $alsp_instance;

		if (!$instance['visibility'] || !empty($alsp_instance->frontend_controllers)) {
			$title = apply_filters('widget_title', $instance['title']);
			
			//if ($listing_id)
				alsp_frontendRender('widgets/bids_widget.tpl.php', array('args' => $args, 'title' => $title,));
		}
	}
	
	public function form($instance) {
		$defaults = array('title' => __('Offers', 'ALSP'), 'visibility' => 1);
		$instance = wp_parse_args((array) $instance, $defaults);
		
		alsp_frontendRender('widgets/bids_widget_options.tpl.php', array('widget' => $this, 'instance' => $instance));
	}
	
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['visibility'] = (!empty($new_instance['visibility'])) ? strip_tags($new_instance['visibility']) : '';
	
		return $instance;
	}
	
	public function wp_enqueue_scripts() {
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true) && !$current_widget_options['visibility']) {
				global $alsp_instance, $alsp_fsubmit_instance, $alsp_payments_instance, $alsp_ratings_instance;
		
				$alsp_instance->enqueue_scripts_styles(true);
				if ($alsp_fsubmit_instance)
					$alsp_fsubmit_instance->enqueue_scripts_styles(true);
				if ($alsp_payments_instance)
					$alsp_payments_instance->enqueue_scripts_styles(true);
				if ($alsp_ratings_instance)
					$alsp_ratings_instance->enqueue_scripts_styles(true);
			}
		}
	}

}

add_action('widgets_init', 'alsp_register_map_widget');
function alsp_register_map_widget() {
	register_widget('alsp_map_widget');
}

class alsp_map_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
			'alsp_map_widget',
			__('ALSP - Map', 'ALSP'),
			array('description' => __( 'Classiads Listing Map', 'ALSP'),)
		);
		
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
	}

	public function widget($args, $instance) {
		global $alsp_instance;

		if (!$instance['visibility'] || !empty($alsp_instance->frontend_controllers)) {
			$title = apply_filters('widget_title', $instance['title']);
			
			//if ($listing_id)
				alsp_frontendRender('widgets/map_widget.tpl.php', array('height' => 220, 'args' => $args, 'title' => $title,));
		}
	}
	
	public function form($instance) {
		$defaults = array('title' => __('Map View', 'ALSP'), 'visibility' => 1);
		$instance = wp_parse_args((array) $instance, $defaults);
		
		alsp_frontendRender('widgets/map_widget_options.tpl.php', array('widget' => $this, 'instance' => $instance));
	}
	
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['visibility'] = 1;
	
		return $instance;
	}
	
	public function wp_enqueue_scripts() {
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true) && !$current_widget_options['visibility']) {
				global $alsp_instance, $alsp_fsubmit_instance, $alsp_payments_instance, $alsp_ratings_instance;
		
				$alsp_instance->enqueue_scripts_styles(true);
				if ($alsp_fsubmit_instance)
					$alsp_fsubmit_instance->enqueue_scripts_styles(true);
				if ($alsp_payments_instance)
					$alsp_payments_instance->enqueue_scripts_styles(true);
				if ($alsp_ratings_instance)
					$alsp_ratings_instance->enqueue_scripts_styles(true);
			}
		}
	}

}

add_action('widgets_init', 'alsp_register_resurva_widget');
function alsp_register_resurva_widget() {
	register_widget('alsp_resurva_widget');
}

class alsp_resurva_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
			'alsp_resurva_widget',
			__('ALSP - Resurva Booking', 'ALSP'),
			array('description' => __( 'Classiads Resurva Booking', 'ALSP'),)
		);
		
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
	}

	public function widget($args, $instance) {
		global $alsp_instance;

		if (!$instance['visibility'] || !empty($alsp_instance->frontend_controllers)) {
			$title = apply_filters('widget_title', $instance['title']);
			
			//if ($listing_id)
				alsp_frontendRender('widgets/resurva_widget.tpl.php', array('args' => $args, 'title' => $title,));
		}
	}
	
	public function form($instance) {
		$defaults = array('title' => __('Resurva Booking', 'ALSP'), 'visibility' => 1);
		$instance = wp_parse_args((array) $instance, $defaults);
		
		alsp_frontendRender('widgets/resurva_widget_options.tpl.php', array('widget' => $this, 'instance' => $instance));
	}
	
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['visibility'] = 1;
	
		return $instance;
	}
	
	public function wp_enqueue_scripts() {
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true) && !$current_widget_options['visibility']) {
				global $alsp_instance, $alsp_fsubmit_instance, $alsp_payments_instance, $alsp_ratings_instance;
		
				$alsp_instance->enqueue_scripts_styles(true);
				if ($alsp_fsubmit_instance)
					$alsp_fsubmit_instance->enqueue_scripts_styles(true);
				if ($alsp_payments_instance)
					$alsp_payments_instance->enqueue_scripts_styles(true);
				if ($alsp_ratings_instance)
					$alsp_ratings_instance->enqueue_scripts_styles(true);
			}
		}
	}

}

add_action('widgets_init', 'alsp_register_social_widget');
function alsp_register_social_widget() {
	register_widget('alsp_social_widget');
}

class alsp_social_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
			'alsp_social_widget',
			__('ALSP - Social', 'ALSP'),
			array('description' => __( 'Social services', 'ALSP'))
		);
		
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
		//add_action('wp_head', array($this, 'enqueue_dynamic_css'), 9999);
	}

	public function widget($args, $instance) {
		global $alsp_instance;
		
		if (!$instance['visibility'] || !empty($alsp_instance->frontend_controllers)) {
			$title = apply_filters('widget_title', $instance['title']);
	
			alsp_frontendRender('widgets/social_widget.tpl.php', array('args' => $args, 'title' => $title, 'instance' => $instance));
		}
	}
	
	public function form($instance) {
		$defaults = array(
				'title' => __('Social accounts', 'ALSP'),
				'facebook' => 'http://www.facebook.com/',
				'is_facebook' => 1,
				'twitter' => 'http://twitter.com/',
				'is_twitter' => 1,
				'google' => 'http://www.google.com/',
				'is_google' => 1,
				'linkedin' => 'http://www.linkedin.com/',
				'is_linkedin' => 1,
				'youtube' => 'http://www.youtube.com/',
				'is_youtube' => 1,
				'rss' => esc_url(add_query_arg('post_type', ALSP_POST_TYPE, site_url('feed'))),
				'is_rss' => 1,
				'visibility' => 1,
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		
		alsp_frontendRender('widgets/social_widget_options.tpl.php', array('widget' => $this, 'instance' => $instance));
	}
	
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['facebook'] = (!empty($new_instance['facebook'])) ? strip_tags($new_instance['facebook']) : '';
		$instance['is_facebook'] = (!empty($new_instance['is_facebook'])) ? strip_tags($new_instance['is_facebook']) : '';
		$instance['twitter'] = (!empty($new_instance['twitter'])) ? strip_tags($new_instance['twitter']) : '';
		$instance['is_twitter'] = (!empty($new_instance['is_twitter'])) ? strip_tags($new_instance['is_twitter']) : '';
		$instance['google'] = (!empty($new_instance['google'])) ? strip_tags($new_instance['google']) : '';
		$instance['is_google'] = (!empty($new_instance['is_google'])) ? strip_tags($new_instance['is_google']) : '';
		$instance['linkedin'] = (!empty($new_instance['linkedin'])) ? strip_tags($new_instance['linkedin']) : '';
		$instance['is_linkedin'] = (!empty($new_instance['is_linkedin'])) ? strip_tags($new_instance['is_linkedin']) : '';
		$instance['youtube'] = (!empty($new_instance['youtube'])) ? strip_tags($new_instance['youtube']) : '';
		$instance['is_youtube'] = (!empty($new_instance['is_youtube'])) ? strip_tags($new_instance['is_youtube']) : '';
		$instance['rss'] = (!empty($new_instance['rss'])) ? strip_tags($new_instance['rss']) : '';
		$instance['is_rss'] = (!empty($new_instance['is_rss'])) ? strip_tags($new_instance['is_rss']) : '';
		$instance['visibility'] = (!empty($new_instance['visibility'])) ? strip_tags($new_instance['visibility']) : '';
	
		return $instance;
	}
	
	public function wp_enqueue_scripts() {
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true) && !$current_widget_options['visibility']) {
				global $alsp_instance, $alsp_fsubmit_instance, $alsp_payments_instance, $alsp_ratings_instance;
		
				$alsp_instance->enqueue_scripts_styles(true);
				if ($alsp_fsubmit_instance)
					$alsp_fsubmit_instance->enqueue_scripts_styles(true);
				if ($alsp_payments_instance)
					$alsp_payments_instance->enqueue_scripts_styles(true);
				if ($alsp_ratings_instance)
					$alsp_ratings_instance->enqueue_scripts_styles(true);
			}
		}
	}
	
	/*public function enqueue_dynamic_css() {
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true) && !$current_widget_options['visibility']) {
				global $alsp_instance;
					
				$alsp_instance->enqueue_dynamic_css(true);
			}
		}
	}*/
}

?>