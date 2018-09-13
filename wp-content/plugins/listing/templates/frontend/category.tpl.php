<?php global $ALSP_ADIMN_SETTINGS; ?>
		<?php $frontend_controller->args['scroll'] = 0 ?>
		<div class="listings cat-archive">
			<div class="map-listings">
				<?php if ($ALSP_ADIMN_SETTINGS['alsp_map_on_excerpt']): ?>
					<?php $frontend_controller->google_map->display(false, false, $ALSP_ADIMN_SETTINGS['alsp_enable_radius_search_cycle'], $ALSP_ADIMN_SETTINGS['alsp_enable_clusters'], true, true, false, $ALSP_ADIMN_SETTINGS['alsp_default_map_height'], false, 10, $ALSP_ADIMN_SETTINGS['alsp_map_style'], false, $ALSP_ADIMN_SETTINGS['alsp_enable_draw_panel'], false, $ALSP_ADIMN_SETTINGS['alsp_enable_full_screen'], $ALSP_ADIMN_SETTINGS['alsp_enable_wheel_zoom'], $ALSP_ADIMN_SETTINGS['alsp_enable_dragging_touchscreens'], $ALSP_ADIMN_SETTINGS['alsp_center_map_onclick']); ?>
				<?php endif; ?>
			</div>
			
			<?php
			if ($ALSP_ADIMN_SETTINGS['alsp_main_search']){
				$advanced_open = $ALSP_ADIMN_SETTINGS['advanced_search_opean_on_archive'];
				$keyword_field_width = (isset($ALSP_ADIMN_SETTINGS['keyword_field_width']))? $ALSP_ADIMN_SETTINGS['keyword_field_width'] : 25;
				$category_field_width = (isset($ALSP_ADIMN_SETTINGS['category_field_width']))? $ALSP_ADIMN_SETTINGS['category_field_width'] : 25;
				$location_field_width = (isset($ALSP_ADIMN_SETTINGS['location_field_width']))? $ALSP_ADIMN_SETTINGS['location_field_width'] : 25;
				$address_field_width = (isset($ALSP_ADIMN_SETTINGS['address_field_width']))? $ALSP_ADIMN_SETTINGS['address_field_width'] : 25;
				$radius_field_width = (isset($ALSP_ADIMN_SETTINGS['radius_field_width']))? $ALSP_ADIMN_SETTINGS['radius_field_width'] : 25;
				$button_field_width = (isset($ALSP_ADIMN_SETTINGS['button_field_width']))? $ALSP_ADIMN_SETTINGS['button_field_width'] : 25;
				$search_button_margin_top = (isset($ALSP_ADIMN_SETTINGS['button_field_margin_top']))? $ALSP_ADIMN_SETTINGS['button_field_margin_top'] : 0;
				$gap_in_fields = (isset($ALSP_ADIMN_SETTINGS['gap_in_fields']))? $ALSP_ADIMN_SETTINGS['gap_in_fields'] : 10;
				$search_form_type = 2;
				?>
			<div class="main-search-bar">
				<?php $frontend_controller->search_form->display($advanced_open, $keyword_field_width, $category_field_width, $location_field_width, $address_field_width, $radius_field_width, $button_field_width, $search_button_margin_top, $gap_in_fields, $search_form_type); ?>
			</div>
			<?php } ?>
			<?php alsp_renderMessages(); ?>

			<?php  alsp_renderSubCategories(get_query_var('category-alsp'), $ALSP_ADIMN_SETTINGS['alsp_categories_columns'], $ALSP_ADIMN_SETTINGS['alsp_show_category_count']); ?>

			
			
			<?php alsp_frontendRender('frontend/listings_block.tpl.php', array('frontend_controller' => $frontend_controller)); ?>
		</div>