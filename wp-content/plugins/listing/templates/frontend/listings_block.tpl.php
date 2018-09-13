<?php
		$GLOBALS['view_switcher_status'] = 'off'; $GLOBALS['listing_view_style'] ='off'; 
			if ($frontend_controller->args['listings_view_type'] == 'list'){
				$GLOBALS['view_switcher_type'] = 'list';
			}else{
				$GLOBALS['view_switcher_type'] = 'grid';
			}
			
			if(($frontend_controller->args['listings_view_type'] == 'grid' && !isset($_COOKIE['alsp_listings_view_'.$frontend_controller->hash])) || (isset($_COOKIE['alsp_listings_view_'.$frontend_controller->hash]) && $_COOKIE['alsp_listings_view_'.$frontend_controller->hash] == 'grid')){
				$listing_style_to_show = 'show_grid_style';
				update_option('listing_style_to_show', $listing_style_to_show);
			}elseif(($frontend_controller->args['listings_view_type'] == 'grid' && !isset($_COOKIE['alsp_listings_view_'.$frontend_controller->hash])) || (isset($_COOKIE['alsp_listings_view_'.$frontend_controller->hash]) && $_COOKIE['alsp_listings_view_'.$frontend_controller->hash] == 'list')){
				$listing_style_to_show = 'show_list_style';
				update_option('listing_style_to_show', $listing_style_to_show);
			}elseif(($frontend_controller->args['listings_view_type'] == 'list' && !isset($_COOKIE['alsp_listings_view_'.$frontend_controller->hash])) || (isset($_COOKIE['alsp_listings_view_'.$frontend_controller->hash]) && $_COOKIE['alsp_listings_view_'.$frontend_controller->hash] == 'list')){
				$listing_style_to_show = 'show_list_style';
				update_option('listing_style_to_show', $listing_style_to_show);
			}elseif(($frontend_controller->args['listings_view_type'] == 'list' && !isset($_COOKIE['alsp_listings_view_'.$frontend_controller->hash])) || (isset($_COOKIE['alsp_listings_view_'.$frontend_controller->hash]) && $_COOKIE['alsp_listings_view_'.$frontend_controller->hash] == 'grid')){
				$listing_style_to_show = 'show_grid_style';
				update_option('listing_style_to_show', $listing_style_to_show);
			}
		global $ALSP_ADIMN_SETTINGS;
		$detect = new Mobile_Detect;
		if($ALSP_ADIMN_SETTINGS['alsp_grid_masonry_display'] && $listing_style_to_show == 'show_grid_style' && !$detect->isMobile()){
			$masonry = 'masonry';
			$isotope_el_class = 'isotop-enabled pacz-theme-loop ';
		}else{
			$masonry = '';
			$isotope_el_class = '';
		}
?>

		<?php if (!isset($frontend_controller->custom_home) || !$frontend_controller->custom_home || ($frontend_controller->custom_home && $ALSP_ADIMN_SETTINGS['alsp_listings_on_index'])): ?>
		<div class="alsp-content listing-parent pacz-loop-main-wrapper <?php if($ALSP_ADIMN_SETTINGS['alsp_grid_masonry_display'] && $listing_style_to_show == 'show_grid_style') echo 'pacz-loop-main-wrapper2'; ?>" style="margin:0 -15px;" id="alsp-controller-<?php echo $frontend_controller->hash; ?>" data-controller-hash="<?php echo $frontend_controller->hash; ?>" <?php if (isset($frontend_controller->custom_home) && $frontend_controller->custom_home): ?>data-custom-home="1"<?php endif; ?>>
			<?php 
			
			//$GLOBALS['listing_style_to_show'] = $listing_style_to_show;
			$view_swither_panel_style = (isset($ALSP_ADIMN_SETTINGS['view_switther_panel_style']))? $ALSP_ADIMN_SETTINGS['view_switther_panel_style'] : 1;
			if($view_swither_panel_style == 1){ 
				$view_swither_panel_style_class = 'view_swither_panel_style1';
			}elseif($view_swither_panel_style == 2){
				$view_swither_panel_style_class = 'view_swither_panel_style2';
			}else{
				$view_swither_panel_style_class = 'view_swither_panel_style1';
			}
			
			if(isset($frontend_controller->args['listing_order_by_txt']) && (!empty($frontend_controller->args['listing_order_by_txt']))){
				$order_by_txt = $frontend_controller->args['listing_order_by_txt'];
			}else{
				$order_by_txt = esc_html__('Sort By', 'ALSP');
			}
			$grid_padding = $ALSP_ADIMN_SETTINGS['alsp_grid_padding'];
			$alsp_grid_margin_bottom = $ALSP_ADIMN_SETTINGS['alsp_grid_margin_bottom'];
			 if($ALSP_ADIMN_SETTINGS['alsp_listing_responsive_grid']){
				$alsp_responsive_col = 'responsive-2col';
			 }else{
				$alsp_responsive_col = '';
			 }
			 if($frontend_controller->args['scroll'] == 1){
				 $carousel = 'carousel-active';
			 }else{
				 $carousel = 'no-carousel';
			 }
			 
			?>
			<script>
			alsp_controller_args_array['<?php echo $frontend_controller->hash; ?>'] = <?php echo json_encode(array_merge(array('controller' => $frontend_controller->request_by, 'base_url' => $frontend_controller->base_url), $frontend_controller->args)); ?>;
			</script>
			<?php if ($frontend_controller->do_initial_load): ?>
				<?php if (get_option('listing_style_to_show') == 'show_grid_style'): ?>
				
				<div class="alsp-container-fluid alsp-listings-block alsp-listings-grid alsp-listings-grid-<?php echo $frontend_controller->args['listings_view_grid_columns']; ?> <?php if($frontend_controller->args['scroll'] == 0) { echo $masonry; } ?>">
				<?php else: ?>
					<div class="alsp-container-fluid alsp-listings-block cz-listview">
				<?php endif; ?>
				<?php if ($frontend_controller->query->found_posts && $frontend_controller->args['scroll'] == 0 && !$frontend_controller->args['hide_order'] ): ?>
				<div class="row alsp-listings-block-header">
					<?php if (!$frontend_controller->args['hide_count']): ?>
					<div class="alsp-found-listings">
						<?php echo sprintf(_n('Found <span class="alsp-badge">%d</span> listing', 'Found <span class="alsp-badge">%d</span> listings', $frontend_controller->query->found_posts, 'ALSP'), $frontend_controller->query->found_posts); ?>
					</div>
					<?php endif; ?>
					<div class="<?php echo $view_swither_panel_style_class; ?> alsp-options-links clearfix">
						<?php if(!$frontend_controller->args['hide_order']): ?>
						<?php $ordering = alsp_orderLinks($frontend_controller->base_url, $frontend_controller->args, true, $frontend_controller->hash); ?>
						<?php if ($ordering['struct']):?>
							<div class="alsp-orderby-links-label"><?php echo $order_by_txt.':'; ?></div>
							<div class="alsp-orderby-links btn-group" role="group">
								<?php foreach ($ordering['struct'] AS $field_slug=>$link): ?>
								<a class="btn btn-default <?php if ($link['class']): ?>btn-primary<?php endif; ?>" href="<?php echo $link['url']; ?>" data-controller-hash="<?php echo $frontend_controller->hash; ?>" data-orderby="<?php echo $field_slug; ?>" data-order="<?php echo $link['order']; ?>" rel="nofollow">
									<?php if ($link['class']): ?>
									<span class="glyphicon glyphicon-arrow-<?php if ($link['class'] == 'ascending'): ?>up<?php elseif ($link['class'] == 'descending'): ?>down<?php endif; ?>" aria-hidden="true"></span>
									<?php endif; ?>
									<span class="order-before-main"><span class="order-before-inner"></span></span>
									<?php echo $link['field_name']; ?>
								</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
						<?php endif; ?>
						
						<?php if ($frontend_controller->args['show_views_switcher']): $GLOBALS['view_switcher_status'] = 'on'; ?>
						<div class="alsp-views-links pull-right">
							<div class="btn-group" role="group">
								<a class="btn <?php if (($frontend_controller->args['listings_view_type'] == 'list' && !isset($_COOKIE['alsp_listings_view_'.$frontend_controller->hash])) || (isset($_COOKIE['alsp_listings_view_'.$frontend_controller->hash]) && $_COOKIE['alsp_listings_view_'.$frontend_controller->hash] == 'list')): $GLOBALS['listing_view_style'] ='list'; update_option('listing_view_style', 'list'); ?>btn-primary<?php else: ?>btn-default<?php endif; ?> alsp-list-view-btn" href="javascript: void(0);" title="<?php _e('List View', 'ALSP'); ?>" data-shortcode-hash="<?php echo $frontend_controller->hash; ?>">
									<?php if($view_swither_panel_style == 1) { ?><span class="pacz-fic3-list-4" aria-hidden="true"></span> <?php }else{ ?> <span class="pacz-icon-list" aria-hidden="true"></span> <?php } ?>
								</a>
								<a class="btn <?php if (($frontend_controller->args['listings_view_type'] == 'grid' && !isset($_COOKIE['alsp_listings_view_'.$frontend_controller->hash])) || (isset($_COOKIE['alsp_listings_view_'.$frontend_controller->hash]) && $_COOKIE['alsp_listings_view_'.$frontend_controller->hash] == 'grid')): $GLOBALS['listing_view_style'] ='grid'; update_option('listing_view_style', 'grid'); ?>btn-primary<?php else: ?>btn-default<?php endif; ?> alsp-grid-view-btn" href="javascript: void(0);" title="<?php _e('Grid View', 'ALSP'); ?>" data-shortcode-hash="<?php echo $frontend_controller->hash; ?>" data-columns=<?php echo $frontend_controller->args['listings_view_grid_columns']; ?>>
									<span class="pacz-fic3-3x3-grid" aria-hidden="true"></span>
								</a>
							</div>
						</div>
						<?php endif; ?>
					</div>
					</div>
					<?php else: ?>
						<?php if ( $frontend_controller->args['scroll'] == 1 && $frontend_controller->args['owl_nav'] == 'true' ): ?>
							<div class="alsp-listings-block-header">
								<div class="alsp-options-links">
									<h5 class="premium-listing-text"><?php _e('PREMIUM', 'ALSP'); ?> <span><?php _e('ADVERTISEMENT', 'ALSP'); ?></span></h5>
								</div>
							</div>
						<?php endif; ?>
				<?php endif; ?>
				<?php if ($frontend_controller->listings): ?>
				
					<div class="alsp-listings-block-content <?php echo $carousel; ?>  <?php if($frontend_controller->args['scroll'] == 0){ echo $isotope_el_class; } ?> clearfix" <?php if (get_option('listing_style_to_show') == 'show_grid_style'){ ?> style="margin-left:-<?php echo $grid_padding; ?>px; margin-right: -<?php echo $grid_padding; ?>px;" <?php } ?> <?php if($ALSP_ADIMN_SETTINGS['alsp_grid_masonry_display']){ ?> data-style="masonry" data-uniqid="<?php echo $frontend_controller->hash; } ?>">
						<?php if ($frontend_controller->args['scroll'] == 1){ ?><!--cz custom -->
						<div class="owl-carousel owl-on-grid" data-items="<?php echo $frontend_controller->args['desktop_items']; ?>" data-items-tab-ls="<?php echo $frontend_controller->args['tab_landscape_items']; ?>" data-items-tab="<?php echo $frontend_controller->args['tab_items']; ?>" data-autoplay="<?php echo $frontend_controller->args['autoplay']; ?>" data-gutter="<?php echo $frontend_controller->args['gutter']; ?>" data-autowidth="false" data-center="false" data-autoplay-speed="<?php echo $frontend_controller->args['autoplay_speed']; ?>" data-delay="<?php echo $frontend_controller->args['delay']; ?>" data-loop="<?php echo $frontend_controller->args['loop']; ?>" data-nav="<?php echo $frontend_controller->args['owl_nav']; ?>">
						<?php } ?>
						<?php if(get_option('listing_style_to_show') == 'show_list_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_listview_post_style'] == 'listview_ultra'){ ?>
								<div class="listing-list-view-inner-wrap">
							<?php } ?>
						<?php while ($frontend_controller->query->have_posts()): ?>
						<?php $frontend_controller->query->the_post();
							$listing_image_width = (isset($frontend_controller->args['listing_image_width']))? $frontend_controller->args['listing_image_width']: $ALSP_ADIMN_SETTINGS['alsp_logo_width'];
							$listing_image_height = (isset($frontend_controller->args['listing_image_height']))? $frontend_controller->args['listing_image_height']: $ALSP_ADIMN_SETTINGS['alsp_logo_height'];
							update_option('listing_image_width_'.$frontend_controller->hash, $listing_image_width);
							update_option('listing_image_height_'.$frontend_controller->hash, $listing_image_height);
							update_option('main_block_hash', $frontend_controller->hash);
						?>
							
						<article id="post-<?php the_ID(); ?>" class="<?php if ($frontend_controller->args['scroll'] == 1){ echo 'listing-scroll'; } ?> row alsp-listing <?php if($ALSP_ADIMN_SETTINGS['alsp_grid_masonry_display']){ ?> pacz-isotop-item isotop-item masonry-<?php echo $frontend_controller->hash; } ?> <?php  echo $alsp_responsive_col; ?> listing-post-style-<?php if (get_option('listing_style_to_show') == 'show_grid_style'){ echo $ALSP_ADIMN_SETTINGS['alsp_listing_post_style']; }else{ echo $ALSP_ADIMN_SETTINGS['alsp_listing_listview_post_style']; } ?> <?php if ($frontend_controller->listings[get_the_ID()]->level->featured) { echo 'alsp-featured';} ?> <?php if ($frontend_controller->listings[get_the_ID()]->level->sticky) echo 'alsp-sticky'; ?> clearfix" <?php if (get_option('listing_style_to_show') == 'show_grid_style'){ ?> style="padding-left:<?php echo $grid_padding; ?>px; padding-right: <?php echo $grid_padding; ?>px; margin-bottom: <?php echo $alsp_grid_margin_bottom; ?>px;" <?php } ?>>
							<div class="listing-wrapper clearfix">
							<?php $frontend_controller->listings[get_the_ID()]->display(); ?>
							</div>
						</article>
						<?php endwhile; ?>
						<?php if(get_option('listing_style_to_show') == 'show_list_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_listview_post_style'] == 'listview_ultra'){ ?>
								</div>
							<?php } ?>
						<?php if ($frontend_controller->args['scroll'] == 1){ ?><!--cz custom -->
						</div>
						<?php } ?>
					</div>

					<?php if (!$frontend_controller->args['hide_paginator']): ?>
					<?php alsp_renderPaginator($frontend_controller->query, $frontend_controller->hash, $ALSP_ADIMN_SETTINGS['alsp_show_more_button']); ?>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>