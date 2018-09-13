<?php 

class alsp_map_controller extends alsp_frontend_controller {
	public function init($args = array()) {
		global $ALSP_ADIMN_SETTINGS;
		global $alsp_instance;
		
		parent::init($args);

		$shortcode_atts = array_merge(array(
				'custom_home' => 0,
				'num' => -1,
				'width' => '',
				'height' => 400,
				'radius_cycle' => 1,
				'clusters' => 0,
				'sticky_scroll' => 0,
				'sticky_scroll_toppadding' => 10,
				'show_summary_button' => 0,
				'show_readmore_button' => 1,
				'sticky_featured' => 0,
				'ajax_loading' => 0,
				'ajax_markers_loading' => 0,
				'geolocation' => 0,
				'address' => '',
				'radius' => 0,
				'start_address' => '',
				'start_latitude' => '',
				'start_longitude' => '',
				'start_zoom' => '',
				'map_style' => 'default',
				'include_categories_children' => 0,
				'search_on_map' => 0,
				'draw_panel' => 1,
				'author' => 0,
				'enable_full_screen' => 1,
				'enable_wheel_zoom' => 1,
				'enable_dragging_touchscreens' => 1,
				'center_map_onclick' => 0,
				'related_categories' => 0,
				'related_locations' => 0,
				'related_tags' => 0,
				'uid' => null,
		), $args);
		$shortcode_atts = apply_filters('alsp_related_shortcode_args', $shortcode_atts, $args);
		$this->args = $shortcode_atts;
		
		if ($this->args['custom_home'] || ($this->args['uid'] && $alsp_instance->getListingsShortcodeByuID($this->args['uid'])))
			return false;

		$args = array(
				'post_type' => ALSP_POST_TYPE,
				'post_status' => 'publish',
				'meta_query' => array(array('key' => '_listing_status', 'value' => 'active')),
				'posts_per_page' => ($shortcode_atts['num'] ? $shortcode_atts['num'] : -1),
		);
		if ($shortcode_atts['author'])
			$args['author'] = $shortcode_atts['author'];

		$args = apply_filters('alsp_search_args', $args, $this->args, $this->args['include_categories_children'], $this->hash);

		if (isset($this->args['post__in'])) {
			$args = array_merge($args, array('post__in' => explode(',', $this->args['post__in'])));
		}
		if (isset($this->args['post__not_in'])) {
			$args = array_merge($args, array('post__not_in' => explode(',', $this->args['post__not_in'])));
		}

		if (isset($this->args['levels']) && !is_array($this->args['levels'])) {
			if ($levels = array_filter(explode(',', $this->args['levels']), 'trim')) {
				$this->levels_ids = $levels;
				add_filter('posts_join', 'join_levels');
				add_filter('posts_where', array($this, 'where_levels_ids'));
			}
		}
		
		if ($this->args['sticky_featured']) {
			add_filter('posts_join', 'join_levels');
			add_filter('posts_where', 'where_sticky_featured');
		}

		if (isset($this->args['neLat']) && isset($this->args['neLng']) && isset($this->args['swLat']) && isset($this->args['swLng'])) {
			$y1 = $this->args['neLat'];
			$y2 = $this->args['swLat'];
			// when zoom level 2 - there may be problems with neLng and swLng of bounds
			if ($this->args['neLng'] > $this->args['swLng']) {
				$x1 = $this->args['neLng'];
				$x2 = $this->args['swLng'];
			} else {
				$x1 = 180;
				$x2 = -180;
			}
			
			global $wpdb;
			$results = $wpdb->get_results($wpdb->prepare(
				"SELECT DISTINCT
					post_id FROM {$wpdb->alsp_locations_relationships} AS alsp_lr
				WHERE MBRContains(
				GeomFromText('Polygon((%f %f,%f %f,%f %f,%f %f,%f %f))'),
				GeomFromText(CONCAT('POINT(',alsp_lr.map_coords_1,' ',alsp_lr.map_coords_2,')')))", $y2, $x2, $y2, $x1, $y1, $x1, $y1, $x2, $y2, $x2), ARRAY_A);

			$post_ids = array();
			foreach ($results AS $row)
				$post_ids[] = $row['post_id'];
			$post_ids = array_unique($post_ids);

			if ($post_ids) {
				if (isset($args['post__in'])) {
					$args['post__in'] = array_intersect($args['post__in'], $post_ids);
					if (empty($args['post__in']))
						// Do not show any listings
						$args['post__in'] = array(0);
				} else
					$args['post__in'] = $post_ids;
			} else
				// Do not show any listings
				$args['post__in'] = array(0);
		}
		
		if (isset($this->args['geo_poly']) && $this->args['geo_poly']) {
			$geo_poly = $this->args['geo_poly'];
			$sql_polygon = array();
			foreach ($geo_poly AS $vertex)
				$sql_polygon[] = $vertex['lat'] . ' ' . $vertex['lng'];
			$sql_polygon[] = $sql_polygon[0];

			global $wpdb, $alsp_address_locations;
			if (function_exists('mysql_get_server_info') && version_compare(preg_replace('#[^0-9\.]#', '', mysql_get_server_info()), '5.6.1', '<')) {
				// below 5.6.1 version
				$thread_stack = @$wpdb->get_row("SELECT @@global.thread_stack", ARRAY_A);
				if ($thread_stack && $thread_stack['@@global.thread_stack'] <= 131072)
					@$wpdb->query("SET @@global.thread_stack = " . 256*1024);

				if (!$wpdb->get_row("SHOW FUNCTION STATUS WHERE name='GISWithin'", ARRAY_A))
					$o = $wpdb->query("CREATE FUNCTION GISWithin(pt POINT, mp MULTIPOLYGON) RETURNS INT(1) DETERMINISTIC
BEGIN
			
DECLARE str, xy TEXT;
DECLARE x, y, p1x, p1y, p2x, p2y, m, xinters DECIMAL(16, 13) DEFAULT 0;
DECLARE counter INT DEFAULT 0;
DECLARE p, pb, pe INT DEFAULT 0;
			
SELECT MBRWithin(pt, mp) INTO p;
IF p != 1 OR ISNULL(p) THEN
RETURN p;
END IF;
			
SELECT X(pt), Y(pt), ASTEXT(mp) INTO x, y, str;
SET str = REPLACE(str, 'POLYGON((','');
SET str = REPLACE(str, '))', '');
SET str = CONCAT(str, ',');
			
SET pb = 1;
SET pe = LOCATE(',', str);
SET xy = SUBSTRING(str, pb, pe - pb);
SET p = INSTR(xy, ' ');
SET p1x = SUBSTRING(xy, 1, p - 1);
SET p1y = SUBSTRING(xy, p + 1);
SET str = CONCAT(str, xy, ',');
			
WHILE pe > 0 DO
SET xy = SUBSTRING(str, pb, pe - pb);
SET p = INSTR(xy, ' ');
SET p2x = SUBSTRING(xy, 1, p - 1);
SET p2y = SUBSTRING(xy, p + 1);
IF p1y < p2y THEN SET m = p1y; ELSE SET m = p2y; END IF;
IF y > m THEN
IF p1y > p2y THEN SET m = p1y; ELSE SET m = p2y; END IF;
IF y <= m THEN
IF p1x > p2x THEN SET m = p1x; ELSE SET m = p2x; END IF;
IF x <= m THEN
IF p1y != p2y THEN
SET xinters = (y - p1y) * (p2x - p1x) / (p2y - p1y) + p1x;
END IF;
IF p1x = p2x OR x <= xinters THEN
SET counter = counter + 1;
END IF;
END IF;
END IF;
END IF;
SET p1x = p2x;
SET p1y = p2y;
SET pb = pe + 1;
SET pe = LOCATE(',', str, pb);
END WHILE;
			
RETURN counter % 2;
			
END;
");
				$results = $wpdb->get_results("SELECT id, post_id FROM {$wpdb->alsp_locations_relationships} AS alsp_lr
				WHERE GISWithin(
				GeomFromText(CONCAT('POINT(',alsp_lr.map_coords_1,' ',alsp_lr.map_coords_2,')')), PolygonFromText('POLYGON((" . implode(', ', $sql_polygon) . "))'))", ARRAY_A);
			} else {
				// 5.6.1 version or higher
				$results = $wpdb->get_results("SELECT id, post_id FROM {$wpdb->alsp_locations_relationships} AS alsp_lr
				WHERE ST_Contains(
				PolygonFromText('POLYGON((" . implode(', ', $sql_polygon) . "))'), GeomFromText(CONCAT('POINT(',alsp_lr.map_coords_1,' ',alsp_lr.map_coords_2,')')))", ARRAY_A);
			}

			$post_ids = array();
			$alsp_address_locations = array();
			foreach ($results AS $row) {
				$post_ids[] = $row['post_id'];
				$alsp_address_locations[] = $row['id'];
			}
			$post_ids = array_unique($post_ids);
			
			if ($post_ids) {
				if (isset($args['post__in'])) {
					$args['post__in'] = array_intersect($args['post__in'], $post_ids);
					if (empty($args['post__in']))
						// Do not show any listings
						$args['post__in'] = array(0);
				} else
					$args['post__in'] = $post_ids;
			} else
				// Do not show any listings
				$args['post__in'] = array(0);
		}

		$this->google_map = new alsp_google_maps($this->args);
		$this->google_map->setUniqueId($this->hash);

		if (!$this->google_map->is_ajax_markers_management()) {
			$this->query = new WP_Query($args);
			//var_dump($this->query->request);
			$this->processQuery($this->args['ajax_markers_loading']);
		}
		
		if ($this->args['sticky_featured']) {
			remove_filter('posts_join', 'join_levels');
			remove_filter('posts_where', 'where_sticky_featured');
		}

		if ($this->levels_ids) {
			remove_filter('posts_join', 'join_levels');
			remove_filter('posts_where', array($this, 'where_levels_ids'));
		}
		
		apply_filters('alsp_frontend_controller_construct', $this);
	}
	
	public function processQuery($is_ajax_map = false, $map_args = array()) {
		while ($this->query->have_posts()) {
			$this->query->the_post();

			$listing = new alsp_listing;
			if (!$is_ajax_map) {
				$listing->loadListingForMap(get_post());
				$this->google_map->collectLocations($listing);
			} else {
				$listing->loadListingForAjaxMap(get_post());
				$this->google_map->collectLocationsForAjax($listing);
			}

			$this->listings[get_the_ID()] = $listing;
		}

		global $alsp_address_locations, $alsp_tax_terms_locations;
		// empty this global arrays - there may be some google maps on one page with different arguments
		$alsp_address_locations = array();
		$alsp_tax_terms_locations = array();

		// this is reset is really required after the loop ends
		wp_reset_postdata();
	}
	
	public function where_levels_ids($where = '') {
		if ($this->levels_ids)
			$where .= " AND (alsp_levels.id IN (" . implode(',', $this->levels_ids) . "))";
		return $where;
	}

	public function display() {
		global $ALSP_ADIMN_SETTINGS;
		global $alsp_instance;

		$width = false;
		$height = $ALSP_ADIMN_SETTINGS['alsp_default_map_height'];
		if (isset($this->args['width']))
			$width = $this->args['width'];
		if (isset($this->args['height']))
			$height = $this->args['height'];

		ob_start();
		if ($this->args['custom_home'] || ($this->args['uid'] && $listings_controller = $alsp_instance->getListingsShortcodeByuID($this->args['uid']))) {
			if ($directory_controller = $alsp_instance->getShortcodeProperty('webdirectory')) {
				// the map shortcode on custom home

				$show_summary_button = true;
				$show_readmore_button = true;
				if ($directory_controller->is_single) {
					$show_summary_button = false;
					$show_readmore_button = false;
				}

				// Google map may be disabled for index or excerpt pages in directory settings, so we need to check does this object exist in main shortcode.
				if ($directory_controller->google_map)
					$directory_controller->google_map->display(
							false,
							false,
							$ALSP_ADIMN_SETTINGS['alsp_enable_radius_search_cycle'],
							$ALSP_ADIMN_SETTINGS['alsp_enable_clusters'],
							$show_summary_button,
							$show_readmore_button,
							$width,
							$height,
							$this->args['sticky_scroll'],
							$this->args['sticky_scroll_toppadding'],
							$ALSP_ADIMN_SETTINGS['alsp_map_style'],
							$ALSP_ADIMN_SETTINGS['alsp_search_on_map'],
							$ALSP_ADIMN_SETTINGS['alsp_enable_draw_panel'],
							$this->args['custom_home'],
							$ALSP_ADIMN_SETTINGS['alsp_enable_full_screen'],
							$ALSP_ADIMN_SETTINGS['alsp_enable_wheel_zoom'],
							$ALSP_ADIMN_SETTINGS['alsp_enable_dragging_touchscreens'],
							$ALSP_ADIMN_SETTINGS['alsp_center_map_onclick']
					);
			} elseif (isset($listings_controller) && $listings_controller) {
				// the map shortcode connected with listings shortcode

				$show_summary_button = true;
				$show_readmore_button = true;
				if (!$listings_controller->google_map) {
					$listings_controller->google_map = new alsp_google_maps($this->args);
					$listings_controller->google_map->setUniqueId($this->hash);
					foreach ($listings_controller->listings AS $listing)
						$listings_controller->google_map->collectLocations($listing);
				}
				$listings_controller->google_map->display(
						false,
						false,
						$this->args['radius_cycle'],
						$this->args['clusters'],
						$show_summary_button,
						$show_readmore_button,
						$width,
						$height,
						$this->args['sticky_scroll'],
						$this->args['sticky_scroll_toppadding'],
						$this->args['map_style'],
						$this->args['search_on_map'],
						$this->args['draw_panel'],
						$this->args['custom_home'],
						$this->args['enable_full_screen'],
						$this->args['enable_wheel_zoom'],
						$this->args['enable_dragging_touchscreens'],
						$this->args['center_map_onclick']
				);
			} else {
				// the map shortcode has uID, but listings shortcode does not exist

				$show_summary_button = false;
				$show_readmore_button = true;
				$google_map = new alsp_google_maps($this->args);
				$google_map->setUniqueId($this->hash);
				$google_map->display(
						false,
						false,
						$this->args['radius_cycle'],
						$this->args['clusters'],
						$show_summary_button,
						$show_readmore_button,
						$width,
						$height,
						$this->args['sticky_scroll'],
						$this->args['sticky_scroll_toppadding'],
						$this->args['map_style'],
						$this->args['search_on_map'],
						$this->args['draw_panel'],
						$this->args['custom_home'],
						$this->args['enable_full_screen'],
						$this->args['enable_wheel_zoom'],
						$this->args['enable_dragging_touchscreens'],
						$this->args['center_map_onclick']
				);
			}
		} else 
			// standard behaviour of map shortcode
			$this->google_map->display(
					false, // hide directions
					false, // static image
					$this->args['radius_cycle'],
					$this->args['clusters'],
					$this->args['show_summary_button'],
					$this->args['show_readmore_button'],
					$width,
					$height,
					$this->args['sticky_scroll'],
					$this->args['sticky_scroll_toppadding'],
					$this->args['map_style'],
					$this->args['search_on_map'],
					$this->args['draw_panel'],
					$this->args['custom_home'],
					$this->args['enable_full_screen'],
					$this->args['enable_wheel_zoom'],
					$this->args['enable_dragging_touchscreens'],
					$this->args['center_map_onclick']
			);

		$output = ob_get_clean();

		wp_reset_postdata();
	
		return $output;
	}
}

?>