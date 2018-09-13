<?php global $ALSP_ADIMN_SETTINGS; ?>
<?php


global $post;
 if($ALSP_ADIMN_SETTINGS['search-form-style'] == 2 && has_shortcode($post->post_content, 'webdirectory')){
	$search_style = 'search-form-style1';
}else{
	$search_style = $ALSP_ADIMN_SETTINGS['search-form-style'];
} ?>
<?php if ($ALSP_ADIMN_SETTINGS['alsp_show_what_search'] || $ALSP_ADIMN_SETTINGS['alsp_show_where_search']): ?>
	<form action="<?php echo $search_url; ?>" class="search-form-style<?php echo $search_style ?> alsp-content alsp-search-form">
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

		<div class="alsp-search-overlay alsp-container-fluid">
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_show_what_search']): ?>
				<div class="search-wrap row clearfix" style="margin-left:-<?php echo $gap_in_fields;; ?>px;margin-right:-<?php echo $gap_in_fields; ?>px;">
				<?php global $post;
					if($ALSP_ADIMN_SETTINGS['search-form-style'] == 2 && !has_shortcode($post->post_content, 'webdirectory')): ?>
						<h5><?php echo esc_html__('SEARCH LINSTINGS', 'alsp'); ?></h5>
				<?php endif; ?>
				<?php if (($ALSP_ADIMN_SETTINGS['alsp_show_categories_search'] && alsp_is_anyone_in_taxonomy(ALSP_CATEGORIES_TAX)) && $ALSP_ADIMN_SETTINGS['alsp_show_keywords_search']) $col_md = 6; else $col_md = 12; ?>
				
				<?php do_action('pre_search_what_form_html', $random_id); ?>
			
				<?php if ($ALSP_ADIMN_SETTINGS['alsp_show_keywords_search']): ?>
					<div class="keyword-search search-element-col pull-left" style="width:<?php echo $keyword_field_width ?>%; padding:0 <?php echo $gap_in_fields; ?>px;">
						<input type="text" name="what_search" class="form-control" size="38" placeholder="<?php esc_attr_e('Enter keywords', 'ALSP'); ?>" value="<?php if (isset($_GET['what_search'])) echo esc_attr(stripslashes($_GET['what_search'])); ?>" />
					</div>
				<?php endif; ?>
				<?php if ($ALSP_ADIMN_SETTINGS['alsp_show_categories_search'] && alsp_is_anyone_in_taxonomy(ALSP_CATEGORIES_TAX)): ?>
				<?php
					if (get_query_var('category-alsp') && ($category_object = alsp_get_term_by_path(get_query_var('category-alsp'))))
						$term_id = $category_object->term_id;
					elseif (isset($_GET['categories']) && is_numeric($_GET['categories']))
						$term_id = $_GET['categories'];
					else 
						$term_id = 0;
				?>
				<div class="search-element-col pull-left" style="width:<?php echo $category_field_width ?>%; padding:0 <?php echo $gap_in_fields; ?>px;">
					<?php alsp_tax_dropdowns_init(ALSP_CATEGORIES_TAX, 'categories', $term_id, $ALSP_ADIMN_SETTINGS['alsp_show_category_count_in_search'], array(), array(
						__('Category', 'ALSP'),
						__('Subcategory', 'ALSP'),
						__('Subcategory', 'ALSP'),
						__('Subcategory', 'ALSP')
						)
					);
					?>
				</div>
			<?php endif; ?>
			
			<!-- locations and address fileds -->
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_show_locations_search'] && alsp_is_anyone_in_taxonomy(ALSP_LOCATIONS_TAX)): ?>
			<?php
			if (get_query_var('location-alsp') && ($location_object = alsp_get_term_by_path(get_query_var('location-alsp'))))
				$term_id = $location_object->term_id;
			elseif (isset($_GET['location_id']) && is_numeric($_GET['location_id']))
				$term_id = $_GET['location_id'];
			else 
				$term_id = 0; ?>
			<div class="search-element-col pull-left" style="width:<?php echo $location_field_width ?>%; padding:0 <?php echo $gap_in_fields; ?>px;">
				<?php alsp_tax_dropdowns_init(ALSP_LOCATIONS_TAX, 'location_id', $term_id, $ALSP_ADIMN_SETTINGS['alsp_show_location_count_in_search'], array(), $alsp_instance->locations_levels->getSelectionsArray()); ?>
			</div>
			<?php endif; ?>
			<?php
			global $post;
			//if (!has_shortcode($post->post_content, 'webdirectory')): ?>
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_show_address_search']): ?>
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_address_geocode']): ?>
			<script>
				(function($) {
					"use strict";

					$(function() {
						$(".alsp-get-location-<?php echo $random_id; ?>").click(function() { alsp_geocodeField($("#address_<?php echo $random_id; ?>"), "<?php echo esc_js(__('GeoLocation service does not work on your device!', 'ALSP')); ?>"); });
					});
				})(jQuery);
			</script>
			<div class="search-element-col alsp-has-feedback pull-left" style="width:<?php echo $address_field_width ?>%; padding:0 <?php echo $gap_in_fields; ?>px;">
				<span class="alsp-get-location alsp-get-location-<?php echo $random_id; ?> glyphicon glyphicon-screenshot form-control-feedback" title="<?php esc_attr_e('Get my location', 'ALSP'); ?>"></span>
				<input type="text" name="address" id="address_<?php echo $random_id; ?>" class="form-control <?php if ($ALSP_ADIMN_SETTINGS['alsp_address_autocomplete']): ?>alsp-field-autocomplete<?php endif; ?>" placeholder="<?php esc_attr_e('Enter address or zip code', 'ALSP'); ?>" value="<?php if (isset($_GET['address'])) echo esc_attr(stripslashes($_GET['address'])); ?>" />
				
			</div>
			<?php else: ?>
			<div class="search-element-col pull-left" style="width:<?php echo $address_field_width ?>%; padding:0 <?php echo $gap_in_fields; ?>px;">
				<input type="text" name="address" id="address_<?php echo $random_id; ?>" class="form-control" placeholder="<?php esc_attr_e('Enter address or zip code', 'ALSP'); ?>" value="<?php if (isset($_GET['address'])) echo esc_attr(stripslashes($_GET['address'])); ?>" />
			</div>
			<?php endif; ?>
			<?php endif; ?>

			<?php if ($ALSP_ADIMN_SETTINGS['alsp_show_radius_search']): ?>
			<?php 
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
			
			 if ($ALSP_ADIMN_SETTINGS['alsp_show_where_search']): ?>
		<div class="cz-areaalider search-element-col pull-right" style="width:<?php echo $radius_field_width ?>%; padding:0 <?php echo $gap_in_fields; ?>px;">
			
			<div class="form-group alsp-jquery-ui-slider">
				<div class="alsp-search-radius-label">
					<?php _e('Search in radius', 'ALSP'); ?>
					<strong id="radius_label_<?php echo $random_id; ?>"><?php echo $radius; ?></strong>
					<?php if ($ALSP_ADIMN_SETTINGS['alsp_miles_kilometers_in_search'] == 'miles') _e('miles', 'ALSP'); else _e('kilometers', 'ALSP'); ?>
				</div>
				<div class="pacz-radius-slider">
					<div id="radius_slider_<?php echo $random_id; ?>"></div>
					<input type="hidden" name="radius" id="radius_<?php echo $random_id; ?>" value="<?php echo $radius; ?>" />
				</div>
			</div>
			<?php endif; ?>
		
			<?php do_action('post_search_where_form_html', $random_id); ?>
		</div>
		
			
			
	<?php endif; ?>
	<?php endif; ?>		
		
	<?php $alsp_instance->search_fields->render_content_fields($random_id, $advanced_open); ?>
		

		<?php do_action('post_search_what_form_html', $random_id); ?>
	<?php //endif; ?>

	

		<?php do_action('post_search_form_html', $random_id); ?>
			<?php
			$is_advanced_search_panel = false;
			foreach ($alsp_instance->search_fields->search_fields_array AS $search_field)
				if ($search_field->content_field->advanced_search_form) {
					$is_advanced_search_panel = true;
					break;
				}
			?>
			<?php if (!$is_advanced_search_panel){ ?>
			<div class="search-button search-element-col pull-right" style="width:<?php echo $button_field_width ?>%; padding:0 <?php echo $gap_in_fields; ?>px;">
				<input type="submit" name="submit" class="cz-submit-btn btn btn-primary" value="<?php esc_attr_e('Search', 'ALSP'); ?>" />
			</div>
			<?php } ?>
			
			

			<?php do_action('buttons_search_form_html', $random_id); ?>
		
		</div>
	</div>
			<?php if ($is_advanced_search_panel): ?>
				<script>
					(function($) {
						"use strict";
		
						$(function() {
							$("#alsp-advanced-search-label_<?php echo $random_id; ?>").click(function(){
								if ($("#alsp_advanced_search_fields_<?php echo $random_id; ?>").is(":hidden")) {
									$("#use_advanced_<?php echo $random_id; ?>").val(1);
									$("#alsp_advanced_search_fields_<?php echo $random_id; ?>").show();
								} else {
									$("#use_advanced_<?php echo $random_id; ?>").val(0);
									$("#alsp_advanced_search_fields_<?php echo $random_id; ?>").hide();
								}
							});
						});
					})(jQuery);
				</script>
			
				<a id="alsp-advanced-search-label_<?php echo $random_id; ?>" class="alsp-advanced-search-label" href="javascript: void(0);"><?php _e('Advanced search', 'ALSP'); ?></a>
			
			<?php endif; ?>
	</form>
<?php endif; ?>
