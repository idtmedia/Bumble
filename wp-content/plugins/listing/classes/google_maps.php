<?php

class alsp_google_maps {
	public $args;
	public $map_id;
	
	public $map_zoom;
	public $locations_array = array();
	public $locations_option_array = array();

	public static $map_content_fields;

	public function __construct($args = array()) {
		$this->args = $args;
	}
	
	public function setUniqueId($unique_id) {
		$this->map_id = $unique_id;
	}

	public function collectLocations($listing) {
		global $alsp_instance, $alsp_address_locations, $alsp_tax_terms_locations, $ALSP_ADIMN_SETTINGS;
		if (count($listing->locations) == 1)
			$this->map_zoom = $listing->map_zoom;

		foreach ($listing->locations AS $location) {
			if ((!$alsp_address_locations || in_array($location->id, $alsp_address_locations)) && (!$alsp_tax_terms_locations || in_array($location->selected_location, $alsp_tax_terms_locations))) {
				if (($location->map_coords_1 && $location->map_coords_1 != '0.000000') || ($location->map_coords_2 && $location->map_coords_2 != '0.000000')) {
					$logo_image = '';
					if ($listing->level->logo_enabled) {
						if ($listing->logo_image) {
							require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";
							$width= $ALSP_ADIMN_SETTINGS['alsp_map_infowindow_logo_width'];
							$height= $ALSP_ADIMN_SETTINGS['alsp_map_infowindow_logo_height'];
							$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
							$image_src = bfi_thumb($image_src_array[0], array(
								'width' => $width,
								'height' => $height,
								'crop' => true
							));
							//$src = wp_get_attachment_image_src($listing->logo_image, array(,));
							$logo_image = '<img alt="'.$listing->title().'" src="'. pacz_thumbnail_image_gen($image_src, $width, $height).'" width="'.$width.'" height="'.$height.'" />';
							//$logo_image = $src[0];
						} elseif ($ALSP_ADIMN_SETTINGS['alsp_enable_nologo'] && $ALSP_ADIMN_SETTINGS['alsp_nologo_url']) {
							$logo_image = $ALSP_ADIMN_SETTINGS['alsp_nologo_url'];
						}
					}
	
					$listing_link = '';
					if ($listing->level->listings_own_page)
						$listing_link = get_permalink($listing->post->ID);
	
					if ($alsp_instance->content_fields->getMapContentFields())
						$content_fields_output = $listing->setMapContentFields($alsp_instance->content_fields->getMapContentFields(), $location);
					else 
						$content_fields_output = '';
	
					$this->locations_array[] = $location;
					$this->locations_option_array[] = array(
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
							($listing->level->nofollow) ? 1 : 0,
					);
				}
			}
		}

		if ($this->locations_option_array)
			return true;
		else
			return false;
	}
	
	public function collectLocationsForAjax($listing) {	
		global $alsp_address_locations, $alsp_tax_terms_locations;

		foreach ($listing->locations AS $location) {
			if ((!$alsp_address_locations || in_array($location->id, $alsp_address_locations))  && (!$alsp_tax_terms_locations || in_array($location->selected_location, $alsp_tax_terms_locations))) {
				if (($location->map_coords_1 && $location->map_coords_1 != '0.000000') || ($location->map_coords_2 && $location->map_coords_2 != '0.000000')) {
					$this->locations_array[] = $location;
					$this->locations_option_array[] = array(
							$location->id,
							$location->map_coords_1,
							$location->map_coords_2,
							$location->map_icon_file,
							$location->map_icon_color,
							null,
							null,
							null,
							null,
							null,
							null,
							null,
					);
				}
			}
		}
		if ($this->locations_option_array)
			return true;
		else
			return false;
	}

	public function display($show_directions = true, $static_image = false, $enable_radius_cycle = true, $enable_clusters = true, $show_summary_button = true, $show_readmore_button = true, $width = false, $height = false, $sticky_scroll = false, $sticky_scroll_toppadding = 10, $map_style_name = 'default', $search_form = false, $draw_panel = false, $custom_home = false, $enable_full_screen = true, $enable_wheel_zoom = true, $enable_dragging_touchscreens = true, $center_map_onclick = false) {
		//if ($this->locations_option_array || $this->is_ajax_markers_management()) {
			$locations_options = json_encode($this->locations_option_array);
			$map_args = json_encode($this->args);
			alsp_frontendRender('google_map.tpl.php',
					array(
							'locations_options' => $locations_options,
							'locations_array' => $this->locations_array,
							'show_directions' => $show_directions,
							'static_image' => $static_image,
							'enable_radius_cycle' => $enable_radius_cycle,
							'enable_clusters' => $enable_clusters,
							'map_zoom' => $this->map_zoom,
							'show_summary_button' => $show_summary_button,
							'show_readmore_button' => $show_readmore_button,
							'map_style_name' => $map_style_name,
							'search_form' => $search_form,
							'draw_panel' => $draw_panel,
							'custom_home' => $custom_home,
							'width' => $width,
							'height' => $height,
							'sticky_scroll' => $sticky_scroll,
							'sticky_scroll_toppadding' => $sticky_scroll_toppadding,
							'enable_full_screen' => $enable_full_screen,
							'enable_wheel_zoom' => $enable_wheel_zoom,
							'enable_dragging_touchscreens' => $enable_dragging_touchscreens,
							'center_map_onclick' => $center_map_onclick,
							'map_id' => $this->map_id,
							'map_args' => $map_args
					));
			wp_enqueue_script('google_maps_infobox');
		//}
	}
	
	public function is_ajax_markers_management() {
		if (isset($this->args['ajax_loading']) && $this->args['ajax_loading'] && ((isset($this->args['start_address']) && $this->args['start_address']) || ((isset($this->args['start_latitude']) && $this->args['start_latitude']) && (isset($this->args['start_longitude']) && $this->args['start_longitude']))))
			return true;
		else
			return false;
	}
}

?>