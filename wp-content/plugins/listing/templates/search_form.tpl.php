<?php global $ALSP_ADIMN_SETTINGS; ?>
<?php

if($search_form_type != 1 && $search_form_type != 2 && $search_form_type != 3){ ?>
	<form action="<?php echo $search_url; ?>" class="search-form-style-header1 alsp-content alsp-search-form">
	<?php 
	if(class_exists('Mobile_Detect')){
		$detect_mobile = new Mobile_Detect();
		if(!$detect_mobile->isMobile()){
			do_action( 'nav_listing_btn' );
		}
	}
	?>
	<?php
	global $wp_rewrite;
		if (!$wp_rewrite->using_permalinks() && $alsp_instance->index_page_id && (get_option('show_on_front') != 'page' || get_option('page_on_front') != $alsp_instance->index_page_id)): ?>
			<input type="hidden" name="page_id" value="<?php echo $alsp_instance->index_page_id; ?>" />
		<?php endif; ?>
		<?php if ($alsp_instance->index_page_id): ?>
			<input type="hidden" name="alsp_action" value="search" />
		<?php else: ?>
			<input type="hidden" name="s" value="search" />
		<?php endif; ?>
		<?php if ($hash): ?>
			<input type="hidden" name="hash" value="<?php echo $hash; ?>" />
		<?php endif; ?>
		<?php if ($controller): ?>
			<input type="hidden" name="controller" value="<?php echo $controller; ?>" />
		<?php endif; ?>
		<?php
		// adapted for WPML
		global $sitepress;
		if (function_exists('wpml_object_id_filter') && $sitepress):
			if ($sitepress->get_option('language_negotiation_type') == 3): ?>
				<input type="hidden" name="lang" value="<?php echo $sitepress->get_current_language(); ?>" />
			<?php endif; ?>
		<?php endif; ?>
		<?php
			$location_field_width = $ALSP_ADIMN_SETTINGS['location_field_width_header'];
			$category_field_width = $ALSP_ADIMN_SETTINGS['category_field_width_header'];
			$keyword_field_width = $ALSP_ADIMN_SETTINGS['keyword_field_width_header'];
			$button_field_width = $ALSP_ADIMN_SETTINGS['button_field_width_header'];


		?>
	<div class="alsp-search-overlay alsp-container-fluid">
		<div class="search-wrap row clearfix">
			<?php if(!$detect_mobile->isMobile()){ ?>
					<div class="search-button search-element-col pull-right">
						<button type="submit" name="submit" class="cz-submit-btn btn btn-primary" /><i class="pacz-fic4-magnifying-glass"></i></button>
					</div>
			<?php } ?>
					<!-- keyword fileds -->
				<?php if ($ALSP_ADIMN_SETTINGS['alsp_show_keywords_search']){ ?>
					<div class="keyword-search search-element-col pull-right" style="width:<?php echo $keyword_field_width ?>%; padding:0;">
						<input id="keyword_field" type="text" name="what_search" class="form-control" size="38" placeholder="<?php esc_attr_e('Enter keywords', 'ALSP'); ?>" value="<?php if (isset($_GET['what_search'])) echo esc_attr(stripslashes($_GET['what_search'])); ?>" />
					</div>
				<?php } ?>
				<?php if ($ALSP_ADIMN_SETTINGS['alsp_show_categories_search'] && alsp_is_anyone_in_taxonomy(ALSP_CATEGORIES_TAX)){ ?>
				<?php
					if (get_query_var('category-alsp') && ($category_object = alsp_get_term_by_path(get_query_var('category-alsp'))))
						$term_id = $category_object->term_id;
					elseif (isset($_GET['categories']) && is_numeric($_GET['categories']))
						$term_id = $_GET['categories'];
					else 
						$term_id = 0;
				?>
				<div class="search-element-col pull-right" style="width:<?php echo $category_field_width ?>%; padding:0;">
					<?php alsp_tax_dropdowns_init(ALSP_CATEGORIES_TAX, 'categories', $term_id, $ALSP_ADIMN_SETTINGS['alsp_show_category_count_in_search'], array(), array(
						__('Category', 'ALSP'),
						__('Subcategory', 'ALSP'),
						__('Subcategory', 'ALSP'),
						__('Subcategory', 'ALSP')
						)
					);
					?>
				</div>
				<?php } ?>
				<!-- locations and address fileds -->
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_show_locations_search'] && alsp_is_anyone_in_taxonomy(ALSP_LOCATIONS_TAX)){ ?>
			<?php
			if (get_query_var('location-alsp') && ($location_object = alsp_get_term_by_path(get_query_var('location-alsp'))))
				$term_id = $location_object->term_id;
			elseif (isset($_GET['location_id']) && is_numeric($_GET['location_id']))
				$term_id = $_GET['location_id'];
			else 
				$term_id = 0; 
			
			if(is_rtl()){
				$field_gap = '0 0 0 10px';
			}else{
				$field_gap = '0 10px 0 0';
			}
			?>
			<div class="search-element-col pull-right" style="width:<?php echo $location_field_width ?>%; padding:<?php echo $field_gap; ?>;">
				<?php alsp_tax_dropdowns_init(ALSP_LOCATIONS_TAX, 'location_id', $term_id, $ALSP_ADIMN_SETTINGS['alsp_show_location_count_in_search'], array(), $alsp_instance->locations_levels->getSelectionsArray()); ?>
			</div>
			<?php } //location field end ?>
				
			<?php if($detect_mobile->isMobile()){ ?>
				<div class="search-button search-element-col pull-right">
					<button type="submit" name="submit" class="cz-submit-btn btn btn-primary" /><i class="pacz-fic4-magnifying-glass"></i></button>
				</div>
			<?php } ?>
		
		</div>
	</div>
	</form>
<?php
	
}else{
	
// body form

global $post, $wp_rewrite, $sitepress;

	$search_style = $ALSP_ADIMN_SETTINGS['search-form-style'];
	
	$archive_form_field = false;
	$widget_form_field = false;
	$custom_form_field = false;
	foreach ($alsp_instance->search_fields->search_fields_array AS $search_field){
				if ($search_field->content_field->on_search_form_archive) {
					$archive_form_field = true;
					break;
				}
	}
	foreach ($alsp_instance->search_fields->search_fields_array AS $search_field){
				if ($search_field->content_field->on_search_form_widget) {
					$widget_form_field = true;
					break;
				}
	}
	foreach ($alsp_instance->search_fields->search_fields_array AS $search_field){
				if ($search_field->content_field->on_search_form) {
					$custom_form_field = true;
					break;
				}
	}
	
	
	$is_advanced_search_panel = 0;
	foreach ($alsp_instance->search_fields->search_fields_array AS $search_field)
		if ($search_form_type == 1 && $custom_form_field == true && $search_field->content_field->advanced_search_form) {
			$is_advanced_search_panel = 1;
		}elseif($search_form_type == 2 && $archive_form_field == true && $search_field->content_field->advanced_search_form) {
			$is_advanced_search_panel = 1;
		}elseif($search_form_type == 3 && $widget_form_field == true && $search_field->content_field->advanced_search_form) {
			$is_advanced_search_panel = 1;		
		}
				

	echo '<form action="'.$search_url.'" class="search-form-style'.$search_style.' alsp-content alsp-search-form">';
		
		if (!$wp_rewrite->using_permalinks() && $alsp_instance->index_page_id && (get_option('show_on_front') != 'page' || get_option('page_on_front') != $alsp_instance->index_page_id)){
			echo '<input type="hidden" name="page_id" value="'.$alsp_instance->index_page_id.'" />';
		}
		if ($alsp_instance->index_page_id){
			echo '<input type="hidden" name="alsp_action" value="search" />';
		}else{
			echo '<input type="hidden" name="s" value="search" />';
		}
		if ($hash){
			echo '<input type="hidden" name="hash" value="'.$hash.'" />';
		}
		if ($controller){
			echo '<input type="hidden" name="controller" value="'.$controller.'" />';
		}
		// adapted for WPML
		if (function_exists('wpml_object_id_filter') && $sitepress){
			if ($sitepress->get_option('language_negotiation_type') == 3){
				echo '<input type="hidden" name="lang" value="'.$sitepress->get_current_language().'" />';
			}
		}

		echo '<div class="alsp-search-overlay alsp-container-fluid">';
			echo '<div class="search-wrap row clearfix" style="margin-left:-'.$gap_in_fields.'px; margin-right:-'.$gap_in_fields.'px;">';
				if($ALSP_ADIMN_SETTINGS['search-form-style'] == 2 && !has_shortcode($post->post_content, 'webdirectory')){
					echo '<h5>'.esc_html__('SEARCH LINSTINGS', 'ALSP').'</h5>';
				}
				if ($ALSP_ADIMN_SETTINGS['alsp_show_keywords_search']){
					if(isset($_GET['what_search'])){
						$get_what_search = esc_attr(stripslashes($_GET['what_search']));
					}else{
						$get_what_search = '';
					}
					echo '<div class="keyword-search search-element-col pull-left" style="width:'.$keyword_field_width.'%; padding:0 '.$gap_in_fields.'px;">';
						echo '<input type="text" name="what_search" class="form-control" size="38" placeholder="'.esc_html__('Enter keywords', 'ALSP').'" value="'.$get_what_search.'" />';
					echo '</div>';
				}
				if ($ALSP_ADIMN_SETTINGS['alsp_show_categories_search'] && alsp_is_anyone_in_taxonomy(ALSP_CATEGORIES_TAX)){
				
					if (get_query_var('category-alsp') && ($category_object = alsp_get_term_by_path(get_query_var('category-alsp')))){
						$term_id = $category_object->term_id;
					}elseif (isset($_GET['categories']) && is_numeric($_GET['categories'])){
						$term_id = $_GET['categories'];
					}else{
						$term_id = 0;
					}
					
					echo '<div class="search-element-col pull-left" style="width:'.$category_field_width.'%; padding:0 '.$gap_in_fields.'px;">';
						alsp_tax_dropdowns_init(ALSP_CATEGORIES_TAX, 'categories', $term_id, $ALSP_ADIMN_SETTINGS['alsp_show_category_count_in_search'], array(), array());
					echo '</div>';
				}
			
				//locations filed
				
				if ($ALSP_ADIMN_SETTINGS['alsp_show_locations_search'] && alsp_is_anyone_in_taxonomy(ALSP_LOCATIONS_TAX)){
			
					if (get_query_var('location-alsp') && ($location_object = alsp_get_term_by_path(get_query_var('location-alsp')))){
						$term_id = $location_object->term_id;
					}elseif (isset($_GET['location_id']) && is_numeric($_GET['location_id'])){
						$term_id = $_GET['location_id'];
					}else{
						$term_id = 0;
					}
					
					echo '<div class="search-element-col pull-left" style="width:'.$location_field_width.'%; padding:0 '.$gap_in_fields.'px;">';
						alsp_tax_dropdowns_init(ALSP_LOCATIONS_TAX, 'location_id', $term_id, $ALSP_ADIMN_SETTINGS['alsp_show_location_count_in_search'], array(), $alsp_instance->locations_levels->getSelectionsArray());
					echo '</div>';
				}
				
				//address filed
				
				if ($ALSP_ADIMN_SETTINGS['alsp_show_address_search']){
					if ($ALSP_ADIMN_SETTINGS['alsp_address_geocode']){
						if ($ALSP_ADIMN_SETTINGS['alsp_address_autocomplete']){ 
							$autocomplete = 'alsp-field-autocomplete';
						}else{
							$autocomplete = '';
						}
						
						
						?>
						<script>
							(function($) {
								"use strict";

								$(function() {
									$(".alsp-get-location-<?php echo $random_id; ?>").click(function() { alsp_geocodeField($("#address_<?php echo $random_id; ?>"), "<?php echo esc_js(__('GeoLocation service does not work on your device!', 'ALSP')); ?>"); });
								});
							})(jQuery);
						</script>
						<?php
						echo '<div class="search-element-col alsp-has-feedback pull-left" style="width:'.$address_field_width.'%; padding:0 '.$gap_in_fields.'px;">'; ?>
							<input type="text" name="address" id="address_<?php echo $random_id; ?>" class="form-control <?php echo $autocomplete ?>" placeholder="<?php echo esc_html__('Enter address or zip code', 'ALSP'); ?>" value="<?php echo esc_attr(stripslashes(alsp_getValue($_GET, 'address', alsp_getValue($args, 'address')))); ?>" />	
							<span class="alsp-get-location alsp-get-location-<?php echo $random_id; ?> glyphicon glyphicon-screenshot form-control-feedback" title="<?php echo esc_html__('Get my location', 'ALSP'); ?>"></span>
						<?php 
						echo '</div>';
					}else{
						if (isset($_GET['address'])){ 
							$get_address = esc_attr(stripslashes($_GET['address']));
						}else{
							$get_address = '';
						}
						echo '<div class="search-element-col pull-left" style="width:'.$address_field_width.'%; padding:0 '.$gap_in_fields.'px;">';
							echo '<input type="text" name="address" id="address_'.$random_id.'" class="form-control" placeholder="'.esc_html__('Enter address or zip code', 'ALSP').'" value="'.$get_address.'" />';
						echo '</div>';
					}
				}
				if ($is_advanced_search_panel == 1 && $search_form_type == 3){
					echo '<script>
						(function($) {
							"use strict";
			
							$(function() {
								$("#alsp-advanced-search-label_'.$random_id.'").click(function(){
									if ($("#alsp_advanced_search_fields_'.$random_id.'").is(":hidden")) {
										$("#use_advanced_'.$random_id.'").val(1);
										$("#alsp_advanced_search_fields_'.$random_id.'").show();
									} else {
										$("#use_advanced_'.$random_id.'").val(0);
										$("#alsp_advanced_search_fields_'.$random_id.'").hide();
									}
								});
							});
						})(jQuery);
					</script>';
					echo '<a id="alsp-advanced-search-label_'.$random_id.'" class="alsp-advanced-search-label" href="javascript: void(0);">'. _e('Advanced search', 'ALSP').'</a>';
			
				}
				
				if ($ALSP_ADIMN_SETTINGS['alsp_show_radius_search']){ 
					if (isset($_GET['radius']) && is_numeric($_GET['radius']))
				$radius = $_GET['radius'];
			else
				$radius = $ALSP_ADIMN_SETTINGS['alsp_radius_search_default'];
			?>
			<script>
				(function($) {
					"use strict";

					$(function() {
						$('#radius_slider_<?php echo $random_id; ?>').slider({
							<?php if (function_exists('is_rtl') && is_rtl()): ?>
							isRTL: true,
							<?php endif; ?>
							min: parseInt(slider_params.min),
							max: parseInt(slider_params.max),
							range: "min",
							value: $("#radius_<?php echo $random_id; ?>").val(),
							slide: function(event, ui) {
								$("#radius_label_<?php echo $random_id; ?>").html(ui.value);
								$("#radius_<?php echo $random_id; ?>").val(ui.value);
							}
						});
					});
				})(jQuery);
			</script>
			<?php
					echo '<div class="cz-areaalider search-element-col pull-left" style="width:'.$radius_field_width.'%; padding:0 '.$gap_in_fields.'px;">';
						echo '<div class="form-group alsp-jquery-ui-slider">';
							echo '<div class="alsp-search-radius-label">';
								echo _e('Search in radius', 'ALSP');
								echo ' <strong id="radius_label_'.$random_id.'">'.$radius.'</strong> ';
								if ($ALSP_ADIMN_SETTINGS['alsp_miles_kilometers_in_search'] == 'miles'){
									echo _e('miles', 'ALSP');
								}else{
									_e('kilometers', 'ALSP');
								}	
							echo '</div>';
							echo '<div class="pacz-radius-slider">'; ?>
								<div id="radius_slider_<?php echo $random_id; ?>"></div>
								<input type="hidden" name="radius" id="radius_<?php echo $random_id; ?>" value="<?php echo $radius; ?>" />
						<?php	echo '</div>';
						echo '</div>';
					echo '</div>';
				}
				
				$is_advanced_search_panel = 0;
				foreach ($alsp_instance->search_fields->search_fields_array AS $search_field){
					if ($search_form_type == 1 && $custom_form_field == true && $search_field->content_field->advanced_search_form) {
						$is_advanced_search_panel = 1;
					}elseif($search_form_type == 2 && $archive_form_field == true && $search_field->content_field->advanced_search_form) {
						$is_advanced_search_panel = 1;
					}elseif($search_form_type == 3 && $widget_form_field == true && $search_field->content_field->advanced_search_form) {
						$is_advanced_search_panel = 1;		
					}
				}
				if($search_form_type == 2 && $archive_form_field == true){
					$alsp_instance->search_fields->render_content_fields($random_id, $advanced_open); 
				}elseif($search_form_type == 1 && $custom_form_field == true){
					$alsp_instance->search_fields->render_content_fields($random_id, $advanced_open); 
				}elseif($search_form_type == 3 && $widget_form_field == true){
					$alsp_instance->search_fields->render_content_fields($random_id, $advanced_open); 
				}
				echo '<div class="search-button search-element-col pull-right" style="width:'.$button_field_width.'%; padding:0 '.$gap_in_fields.'px; margin-top:'.$search_button_margin_top.'px;">';
					echo '<input type="submit" name="submit" class="cz-submit-btn btn btn-primary" value="'.esc_html__('Search', 'ALSP').'" />';
				echo '</div>';
				echo '<div class="clear_float"></div>';
			echo '</div>';
		echo '</div>';
		if ($is_advanced_search_panel == 1 && ($search_form_type == 1 || $search_form_type == 2)){
			echo '<script>
				(function($) {
					"use strict";
					$(function() {
						$("#alsp-advanced-search-label_'.$random_id.'").click(function(){
							if ($("#alsp_advanced_search_fields_'.$random_id.'").is(":hidden")) {
								$("#use_advanced_'.$random_id.'").val(1);
								$("#alsp_advanced_search_fields_'.$random_id.'").show();
							} else {
								$("#use_advanced_'.$random_id.'").val(0);
								$("#alsp_advanced_search_fields_'.$random_id.'").hide();
							}
						});
					});
				})(jQuery);
			</script>';
			?>
			<a id="alsp-advanced-search-label_<?php echo $random_id; ?>" class="alsp-advanced-search-label" href="javascript: void(0);"><?php echo _e('Advanced search', 'ALSP'); ?></a>
			<?php
		}
	echo '</form>';

 } // end form type
 
 
 