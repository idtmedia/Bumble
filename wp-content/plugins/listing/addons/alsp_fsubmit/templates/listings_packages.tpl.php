<?php global $ALSP_ADIMN_SETTINGS; ?>

<?php 
global $alsp_instance, $product;

$packages = $alsp_instance->listings_package_product->get_all_packages();

?>

<div class="alsp-content">
	<div class="alsp-submit-section-adv woo-packages <?php echo $ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style']; ?>">
		<?php if ($packages): ?>
			<?php $max_columns_in_row = 3; ?>
			<?php $levels_counter = count($packages); ?>
			<?php if ($levels_counter > $max_columns_in_row) $levels_counter = $max_columns_in_row; ?>
			<?php $cols_width = floor(12/$levels_counter); ?>
			<?php $cols_width_percents = (100-1)/$levels_counter; ?>
	
			<?php $counter = 0; ?>
			<?php $tcounter = 0; ?>
			<?php foreach ($packages AS $package): ?>
			<?php $tcounter++; ?>
			<?php if ($counter == 0): ?>
			<div class="row" style="text-align: center;">
			<?php endif; ?>
	
				<div class="col-sm-<?php echo $cols_width; ?> alsp-plan-column" style="width: <?php echo $cols_width_percents; ?>%; max-width: 800px;">
					<div class="alsp-panel alsp-panel-default alsp-text-center alsp-choose-plan <?php echo $package->get_listings_feature_package(); ?>">
						<div class="alsp-panel-heading">
							<h3>
								<?php echo $package->get_title(); ?>
							</h3>
							<?php if ($package->get_description()): ?><a class="alsp-hint-icon" href="javascript:void(0);" data-content="<?php echo esc_attr(nl2br($package->post->post_content)); ?>" data-html="true" rel="popover" data-placement="bottom" data-trigger="hover"></a><?php endif; ?>
						</div>
						<ul class="alsp-list-group">
							<li class="alsp-list-group-item">
								<?php
								if ($package->get_price() == 0)
									$cost_text = '<span class="alsp-price alsp-payments-free">' . __('FREE', 'ALSP') . '</span>';
								else
									$cost_text = '<span class="alsp-price">' . $package->get_price_html() . '</span>';
		 
								echo $cost_text;
								?>
								
							</li>
							<?php foreach ($alsp_instance->levels->levels_array AS $alsp_level): ?>
							<li class="alsp-list-group-item">
								
								<?php echo $alsp_level->name; ?> <?php _e('listings', 'ALSP'); ?>:
								<strong><?php echo $package->get_listings_number_by_level($alsp_level->id); ?></strong>
								<a class="alsp-hint-icon" href="javascript:void(0);" data-content="<?php echo esc_attr('
									<div class="alsp-panel alsp-panel-default alsp-text-center alsp-choose-plan">
										<div class="alsp-panel-heading ' . (($alsp_level->featured) ? 'alsp-featured' : '') . '">
											<h3>' . $alsp_level->name . '</h3>
										</div>
										<ul class="alsp-list-group">
										<li class="alsp-list-group-item">
											'. __('Active period', 'ALSP') .':
											'. $alsp_level->getActivePeriodString() . '
										</li>
										' . alsp_frontendRender(array(ALSP_FSUBMIT_TEMPLATES_PATH, 'level_details.tpl.php'), array('args' => array('show_period' => 0,'show_sticky' => 1,'show_featured' => 1,'show_categories' => 1,'show_locations' => 1,'show_maps' => 1,'show_images' => 1,'show_videos' => 1,'columns_same_height' => 1,), 'level' => $alsp_level), true) . '
										</ul>
									</div>'); ?>" data-html="true" rel="popover" data-placement="auto right" data-trigger="hover"></a>
							</li>
							<?php endforeach; ?>
							<li class="alsp-list-group-item">
								<?php
								echo apply_filters('woocommerce_loop_add_to_cart_link',
										sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="btn btn-primary ajax_add_to_cart %s product_type_%s">%s</a>',
												esc_url($package->add_to_cart_url()),
												esc_attr($package->get_id()),
												esc_attr($package->get_sku()),
												$package->is_purchasable() ? 'add_to_cart_button' : '',
												esc_attr($package->get_type()),
												esc_html($package->add_to_cart_text())
										),
										$package);
								?>
							</li>
						</ul>
					</div>          
				</div>
	
			<?php $counter++; ?>
			<?php if ($counter == $max_columns_in_row || $tcounter == $levels_counter): ?>
			</div>
			<?php endif; ?>
			<?php if ($counter == $max_columns_in_row) $counter = 0; ?>
			<?php endforeach; ?>
		<?php else: ?>
			<p><?php _e("There aren't any listings packagess", "ALSP"); ?></p>
		<?php endif; ?>
	</div>

	<?php if (!isset($hide_navigation) || !$hide_navigation): ?>
	<div class="alsp-submit-section-adv clearfix">
		<?php if (count($alsp_instance->levels->levels_array) > 1): ?>
		<a href="<?php echo alsp_submitUrl(); ?>" class="btn btn-primary back-to-plan-btn"><?php _e('&larr; Return to Levels Table', 'ALSP');?></a>
		<?php endif; ?>
		<a href="<?php echo alsp_directoryUrl(); ?>" class="btn btn-primary back-to-home-btn"><?php _e('&larr; Return to Home', 'ALSP');?></a>
	</div>
	<?php endif; ?>
</div>
