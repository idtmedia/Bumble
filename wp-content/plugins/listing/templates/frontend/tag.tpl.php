<?php global $ALSP_ADIMN_SETTINGS; ?>
		<div class="alsp-content">
			<?php alsp_renderMessages(); ?>
			
			<?php alsp_frontendRender('frontend/frontpanel_buttons.tpl.php'); ?>

			<?php if ($frontend_controller->getPageTitle()): ?>
			<header>
				<h2>
					<?php echo $frontend_controller->getPageTitle(); ?>
				</h2>

				<?php if ($frontend_controller->breadcrumbs): ?>
				<ol class="alsp-breadcrumbs">
					<?php echo $frontend_controller->getBreadCrumbs(); ?>
				</ol>
				<?php endif; ?>

				<?php if (term_description($frontend_controller->tag->term_id, ALSP_TAGS_TAX)): ?>
				<div class="archive-meta"><?php echo term_description($frontend_controller->tag->term_id, ALSP_TAGS_TAX); ?></div>
				<?php endif; ?>
			</header>
			<?php endif; ?>

			<?php
			if ($ALSP_ADIMN_SETTINGS['alsp_main_search'])
				$frontend_controller->search_form->display();
			?>

			<?php if ($ALSP_ADIMN_SETTINGS['alsp_show_categories_index']): ?>
			<?php alsp_renderAllCategories(0, $ALSP_ADIMN_SETTINGS['alsp_categories_nesting_level'], $ALSP_ADIMN_SETTINGS['alsp_categories_columns'], $ALSP_ADIMN_SETTINGS['alsp_show_category_count'], $ALSP_ADIMN_SETTINGS['alsp_subcategories_items']); ?>
			<?php endif; ?>
			
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_show_locations_index']): ?>
			<div>
			<?php alsp_renderAllLocations(0, $ALSP_ADIMN_SETTINGS['alsp_locations_nesting_level'], $ALSP_ADIMN_SETTINGS['alsp_locations_columns'], $ALSP_ADIMN_SETTINGS['alsp_show_location_count'], $ALSP_ADIMN_SETTINGS['alsp_sublocations_items']); ?>
			<?php endif; ?>
			</div>
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_map_on_excerpt']): ?>
			<?php $frontend_controller->google_map->display(false, false, $ALSP_ADIMN_SETTINGS['alsp_enable_radius_search_cycle'], $ALSP_ADIMN_SETTINGS['alsp_enable_clusters'], true, true, false, $ALSP_ADIMN_SETTINGS['alsp_default_map_height'], false, 10, $ALSP_ADIMN_SETTINGS['alsp_map_style'], $ALSP_ADIMN_SETTINGS['alsp_search_on_map'], $ALSP_ADIMN_SETTINGS['alsp_enable_draw_panel'], false, $ALSP_ADIMN_SETTINGS['alsp_enable_full_screen'], $ALSP_ADIMN_SETTINGS['alsp_enable_wheel_zoom'], $ALSP_ADIMN_SETTINGS['alsp_enable_dragging_touchscreens'], $ALSP_ADIMN_SETTINGS['alsp_center_map_onclick']); ?>
			<?php endif; ?>

			<?php alsp_frontendRender('frontend/listings_block.tpl.php', array('frontend_controller' => $frontend_controller)); ?>
		</div>