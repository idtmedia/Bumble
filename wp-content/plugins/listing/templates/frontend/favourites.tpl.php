<?php global $ALSP_ADIMN_SETTINGS; ?>
		<div class="alsp-content my-fav_wrap">	
			<div class="alsp-container-fluid alsp-listings-block alsp-listings-grid alsp-listings-grid-<?php echo $frontend_controller->args['listings_view_grid_columns']; ?>">
				<div class="alsp-listings-block-content clearfix">
					<div class="alsp-container-fluid alsp-listings-block clearfix">
						<div class="row alsp-listings-block-header">
							<div class="alsp-found-listings">
								<?php echo sprintf(_n('Found <span class="alsp-badge">%d</span> listing', 'Found <span class="alsp-badge">%d</span> listings', $frontend_controller->query->found_posts, 'ALSP'), $frontend_controller->query->found_posts); ?>
							</div>
						</div>
						<?php if ($frontend_controller->listings): ?>
							<?php while ($frontend_controller->query->have_posts()): ?>
							<?php $frontend_controller->query->the_post(); ?>
							<article id="post-<?php the_ID(); ?>" class="row alsp-listing listing-post-style-<?php if (get_option('listing_style_to_show') == 'show_grid_style'){ echo $ALSP_ADIMN_SETTINGS['alsp_listing_post_style']; }else{ echo $ALSP_ADIMN_SETTINGS['alsp_listing_listview_post_style']; } ?> <?php if ($frontend_controller->listings[get_the_ID()]->level->featured) { echo 'alsp-featured'; $GLOBALS['is_featured'] ='featured-ad';}else{ $GLOBALS['is_featured'] ='normal'; } ?> <?php if ($frontend_controller->listings[get_the_ID()]->level->sticky) echo 'alsp-sticky'; ?> clearfix">
									<div class="listing-wrapper clearfix">
									<?php $frontend_controller->listings[get_the_ID()]->display(); ?>
									</div>
								</article>
							<?php endwhile; ?>
							<div class="alsp-content clearfix"></div>
							<div class="alsp-content">
								<?php alsp_renderPaginator($frontend_controller->query, $frontend_controller->hash, 0); ?>
							</div>
							
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>