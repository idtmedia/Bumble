<?php global $ALSP_ADIMN_SETTINGS; ?>

	<?php

    if(get_current_user_role()!='contributor'){
        echo'<div class="listing-counts-wrap clearfix">';
        echo'<div class="total-listing-count col-lg-3 col-md-6 col-sm-6 col-xs-12">';
        echo'<div class="total-listing-count-item">';
        echo '<i class="total pacz-fic3-list"></i>';
        echo '<span class="listing-conut-main"><span class="listing-number">'.$frontend_controller->listings_count.'</span>'.esc_html__('Total Listing', 'ALSP').'</span>';
        echo'</div>';
        echo'</div>';
        echo'<div class="total-listing-count col-lg-3 col-md-6 col-sm-6 col-xs-12">';
        echo'<div class="total-listing-count-item">';
        echo '<i class="active pacz-fic4-tick"></i>';
        echo '<span class="listing-conut-main"><span class="listing-number">'.$frontend_controller->listings_count2.'</span>'.esc_html__('Active Listing', 'ALSP').'</span>';
        echo'</div>';
        echo'</div>';
        echo'<div class="total-listing-count col-lg-3 col-md-6 col-sm-6 col-xs-12">';
        echo'<div class="total-listing-count-item">';
        echo '<i class="expired pacz-fic4-warning-1"></i>';
        echo '<span class="listing-conut-main"><span class="listing-number">'.$frontend_controller->listings_count3.'</span>'.esc_html__('Expired Listing', 'ALSP').'</span>';
        echo'</div>';
        echo'</div>';
        echo'<div class="total-listing-count col-lg-3 col-md-6 col-sm-6 col-xs-12">';
        echo'<div class="total-listing-count-item">';
        echo '<i class="pending pacz-fic-clock-4"></i>';
        echo '<span class="listing-conut-main"><span class="listing-number">'.$frontend_controller->listings_count4.'</span>'.esc_html__('Pending Aprroval', 'ALSP').'</span>';
        echo'</div>';
        echo'</div>';
        echo'</div>';
    }


	?>
	
	
	
	<?php if ($frontend_controller->listings): ?>
		<?php
		
        if(get_current_user_role()!='contributor'):
		 //echo $frontend_controller->listings_count3;
		?>
            <a class="view-bids" href="?alsp_action=applications" title="<?php _e('VIEW ALL BIDS'); ?>"><?php _e('VIEW ALL BIDS'); ?> (<?php echo get_total_bids(); ?>)</a>
        <?php endif; ?>
		<div class="alsp-table alsp-table-striped clearfix">
				<div class="row clearfix">
		<?php while ($frontend_controller->query->have_posts()): ?>
			<?php $frontend_controller->query->the_post(); ?>
			<?php 
				$listing = $frontend_controller->listings[get_the_ID()]; 
				require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php"; 
				$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
				$image_src = bfi_thumb($image_src_array[0], array(
					'width' => 480,
					'height' => 380,
					'crop' => true
				));
			?>
			<div class="userpanel-item-wrap">
			<div class="td-listing-wrapper">
				
				<div class="td_listings_thumb"><img src="<?php echo pacz_thumbnail_image_gen($image_src, 480, 380); ?>" alt=""/></div>
				<div class="td_listings_content">
					<div class="td_listings_status">
						<?php
						if ($listing->status == 'active' && $listing->post->post_status != 'pending' && $listing->post->post_status  != 'draft' )
							echo '<span class="alsp-badge alsp-listing-status-active">' . __('active', 'ALSP') . '</span>';
						elseif ($listing->status == 'expired')
							echo '<span class="alsp-badge alsp-listing-status-expired">' . __('expired', 'ALSP') . '</span>';
						elseif ($listing->status == 'unpaid')
							echo '<span class="alsp-badge alsp-listing-status-unpaid">' . __('unpaid', 'ALSP') . '</span>';
						elseif ($listing->status == 'stopped')
							echo '<span class="alsp-badge alsp-listing-status-stopped">' . __('stopped', 'ALSP') . '</span>';
						elseif ($listing->post->post_status == 'pending')
							echo '<span class="alsp-badge alsp-listing-status-stopped">' . __('pending', 'ALSP') . '</span>';
						elseif ($listing->post->post_status == 'draft') 
							echo '<span class="alsp-badge alsp-listing-status-stopped">' . __('draft', 'ALSP') . '</span>';
						do_action('alsp_listing_status_option', $listing);
						?>
					</div>
					<div class="td_listings_title">
						<h5>
						<?php
						if (alsp_current_user_can_edit_listing($listing->post->ID))
							echo '<a href="' . alsp_get_edit_listing_link($listing->post->ID) . '">' . $listing->title() . '</a>';
						else
							echo $listing->title();
						do_action('alsp_dashboard_listing_title', $listing);
						?>
						<?php if ($listing->post->post_status == 'pending') echo ' - ' . __('Pending', 'ALSP'); ?>
						<?php if ($listing->post->post_status == 'draft') echo ' - ' . __('Draft', 'ALSP'); ?>
						<?php if ($listing->claim && $listing->claim->isClaimed()) echo '<div>' . $listing->claim->getClaimMessage() . ($listing->claim->isOption() ? ' <a href="' . alsp_dashboardUrl(array('listing_id' => $listing->post->ID, 'alsp_action' => 'process_claim')) . '">' . __('here', 'ALSP') . '</a>' : '') . '</div>'; ?>
						</h5>
					</div>
					<?php 
					// adapted for WPML
					global $sitepress;
					if (function_exists('wpml_object_id_filter') && $sitepress && $ALSP_ADIMN_SETTINGS['alsp_enable_frontend_translations'] && ($languages = $sitepress->get_active_languages()) && count($languages) > 1): ?>
					<div class="td_listings_translations">
					<?php if (alsp_current_user_can_edit_listing($listing->post->ID)):
						global $sitepress;
						$trid = $sitepress->get_element_trid($listing->post->ID, 'post_' . ALSP_POST_TYPE);
						$translations = $sitepress->get_element_translations($trid); ?>
						<?php foreach ($languages AS $lang_code=>$lang): ?>
						<?php if ($lang_code != ICL_LANGUAGE_CODE && apply_filters('wpml_object_id', $alsp_instance->dashboard_page_id, 'page', false, $lang_code)): ?>
						<?php $lang_details = $sitepress->get_language_details($lang_code); ?>
						<?php do_action('wpml_switch_language', $lang_code); ?>
						<?php if (isset($translations[$lang_code])): ?>
						<a style="text-decoration:none" title="<?php echo sprintf(__('Edit the %s translation', 'sitepress'), $lang_details['display_name']); ?>" href="<?php echo add_query_arg(array('alsp_action' => 'edit_listing', 'listing_id' => apply_filters('wpml_object_id', $listing->post->ID, ALSP_POST_TYPE, true, $lang_code)), get_permalink(apply_filters('wpml_object_id', $alsp_instance->dashboard_page_id, 'page', true, $lang_code))); ?>">
							<img src="<?php echo ICL_PLUGIN_URL; ?>/res/img/edit_translation.png" alt="<?php esc_attr_e(__('edit translation', 'ALSP')); ?>" />
						</a>&nbsp;&nbsp;
						<?php else: ?>
						<a style="text-decoration:none" title="<?php echo sprintf(__('Add translation to %s', 'sitepress'), $lang_details['display_name']); ?>" href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'add_translation', 'listing_id' => $listing->post->ID, 'to_lang' => $lang_code)); ?>">
							<img src="<?php echo ICL_PLUGIN_URL; ?>/res/img/add_translation.png" alt="<?php esc_attr_e(__('add translation', 'ALSP')); ?>" />
						</a>&nbsp;&nbsp;
						<?php endif; ?>
						<?php endif; ?>
						<?php endforeach; ?>
						<?php do_action('wpml_switch_language', ICL_LANGUAGE_CODE); ?>
					<?php endif; ?>
					</div>
					<?php endif; ?>
					<div class="td_listings_level">
						<?php 
//							if ($listing->level->isUpgradable()):
//								echo '<a href="' . alsp_dashboardUrl(array('alsp_action' => 'upgrade_listing', 'listing_id' => $listing->post->ID)) . '" title="' . esc_attr__('Change level', 'ALSP') . '">';
									echo $listing->level->name;
//									if ($listing->level->isUpgradable()){
//										echo ' <i class="pacz-icon-cog"></i>';
//									}
						?>
<!--								</a>-->
						<?php //endif; ?>
					</div>
					<div class="td_listings_date">
						<?php
						if ($listing->level->eternal_active_period)
							_e('Eternal active period', 'ALSP');
						else
							echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), intval($listing->expiration_date));
						
						//if ($listing->expiration_date > time())
							//echo '<br />' . human_time_diff(time(), $listing->expiration_date) . '&nbsp;' . __('left', 'ALSP');
						?>
					</div>
				</div>
				<div class="td_listings_bottom clearfix">
				<div class="td_listings_id"><span class="pacz-fic4-bookmark-white"></span><span class="id-label"><?php echo esc_html__('AD ID', 'ALSP').' :'; ?></span><?php echo $listing->post->ID; ?></div>
				<div class="td_listings_options">
					<?php if (alsp_current_user_can_edit_listing($listing->post->ID)){ ?>
					
					<div class="dropdown show">
						  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?PHP echo esc_html__('options', 'ALSP'); ?>
						  </a>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
							<a href="<?php echo alsp_get_edit_listing_link($listing->post->ID); ?>" class=""><span class="pacz-fic3-edit"></span><?php esc_attr_e('edit listing', 'ALSP'); ?></a>
							<a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'delete_listing', 'listing_id' => $listing->post->ID)); ?>" class=""><span class="pacz-flaticon-trash27"></span><?php esc_attr_e('delete listing', 'ALSP'); ?></a>
							<?php
							if ($listing->level->raiseup_enabled && $listing->status == 'active' && $listing->post->post_status == 'publish') {
								$raise_up_link = strip_tags(apply_filters('alsp_raiseup_option', __('raise up listing', 'ALSP'), $listing));
								echo '<a href="' . alsp_dashboardUrl(array('alsp_action' => 'raiseup_listing', 'listing_id' => $listing->post->ID)) . '" class=""><span class="pacz-fic3-arrows"></span>' . esc_attr($raise_up_link) . '</a>';
							}?>
							<?php
							if ($listing->status == 'expired') {
								$renew_link = strip_tags(apply_filters('alsp_renew_option', __('renew listing', 'ALSP'), $listing));
								echo '<a href="' . alsp_dashboardUrl(array('alsp_action' => 'renew_listing', 'listing_id' => $listing->post->ID)) . '" class="" title=""><span class="pacz-icon-refresh"></span>' . esc_attr($renew_link) . '</a>';
							}?>
							<?php
							if ($ALSP_ADIMN_SETTINGS['alsp_enable_stats']) {
								echo '<a href="' . alsp_dashboardUrl(array('alsp_action' => 'view_stats', 'listing_id' => $listing->post->ID)) . '" class=""><span class="pacz-icon-signal"></span>' . esc_attr__('view clicks stats', 'ALSP') . '</a>';
							}?>
							<?php
							if ($listing->status == 'active' && $listing->post->post_status == 'publish') {
								echo '<a href="' . get_permalink($listing->post->ID) . '" class=""><span class="pacz-li-view"></span>' . esc_attr__('view listing', 'ALSP') . '</a>';
							}?>
							<?php
							//if ($listing->status == 'active' && $listing->post->post_status == 'publish') {
								echo '<a href="' . alsp_dashboardUrl(array('alsp_action' => 'change_status', 'listing_id' => $listing->post->ID)) . '" class=""><span class="pacz-li-settings"></span>' . esc_attr__('Change Status', 'ALSP') . '</a>';
							//}?>
							<a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'notice_to_admin', 'listing_id' => $listing->post->ID)); ?>" class=""><span class="pacz-li-notepad"></span><?php esc_attr_e('Note to Admin', 'ALSP'); ?></a>
							<?php do_action('alsp_dashboard_listing_options', $listing); ?>
						 </div>
					</div>
					<?php }else{ ?>
					<div class="dropdown show">
						  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?PHP echo esc_html__('options', 'ALSP'); ?>
						  </a>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
							<a href="<?php echo alsp_get_edit_listing_link($listing->post->ID); ?>" class=""><span class="pacz-fic3-edit"></span><?php esc_attr_e('edit listing', 'ALSP'); ?></a>
							<a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'delete_listing', 'listing_id' => $listing->post->ID)); ?>" class=""><span class="pacz-flaticon-trash27"></span><?php esc_attr_e('delete listing', 'ALSP'); ?></a>
							<a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'notice_to_admin', 'listing_id' => $listing->post->ID)); ?>" class=""><span class="pacz-li-notepad"></span><?php esc_attr_e('Note Admin', 'ALSP'); ?></a>
							<?php do_action('alsp_dashboard_listing_options', $listing); ?>
						 </div>
					</div>
					
					<?php } ?>
				</div>
                    <div class="td_listings_level clearfix">
                        <?php
                        if($listing->level->name=='Free Plan'):
                            if ($listing->level->isUpgradable()):
                                echo '<a class="feature-listing" href="' . alsp_dashboardUrl(array('alsp_action' => 'upgrade_listing', 'listing_id' => $listing->post->ID)) . '" title="' . esc_attr__('Change level', 'ALSP') . '">';
                                _e('Feature Your Listing');
    //                            if ($listing->level->isUpgradable()){
    //                                echo ' <i class="pacz-icon-cog"></i>';
    //                            }
                                ?>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
				</div>
			</div>
			</div>
		<?php endwhile; ?>
		</div>
		</div>
		<?php alsp_renderPaginator($frontend_controller->query, '', false); ?>
		<?php endif; ?>