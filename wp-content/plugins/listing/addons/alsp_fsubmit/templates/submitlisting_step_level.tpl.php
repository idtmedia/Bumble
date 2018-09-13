<?php global $ALSP_ADIMN_SETTINGS; ?>
<div class="alsp-content">
	<?php if (isset($frontend_controller->args['show_steps']) && $frontend_controller->args['show_steps']): ?>
	<?php if ((count($alsp_instance->levels->levels_array) > 1) || ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_login_mode'] == 1 && !is_user_logged_in())): ?>
	<div class="alsp-submit-section-adv <?php echo $ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style']; ?>">
		<?php $step = 1; ?>

		<?php if (count($alsp_instance->levels->levels_array) > 1): ?>
		<div class="alsp-adv-step alsp-adv-step-active">
			<div class="alsp-adv-circle alsp-adv-circle-active"><?php _e('Step', 'ALSP'); ?> <?php echo $step++; ?></div>
			<?php _e('Choose level', 'ALSP'); ?>
		</div>
		<div class="alsp-adv-line alsp-adv-line-active"></div>
		<?php endif; ?>

		<?php if ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_login_mode'] == 1 && !is_user_logged_in()): ?>
		<div class="alsp-adv-step">
			<div class="alsp-adv-circle"><?php _e('Step', 'ALSP'); ?> <?php echo $step++; ?></div>
			<?php _e('Login', 'ALSP'); ?>
		</div>
		<div class="alsp-adv-line"></div>
		<?php endif; ?>
		
		<div class="alsp-adv-step">
			<div class="alsp-adv-circle"><?php _e('Step', 'ALSP'); ?> <?php echo $step++; ?></div>
			<?php _e('Create listing', 'ALSP'); ?>
		</div>
		
		<?php $step = apply_filters('alsp_create_listings_steps_html', $step); ?>
		
		<div class="clear_float"></div>
	</div>
	<?php endif; ?>
	<?php endif; ?>
	
	<?php if (alsp_is_woo_packages()): ?>
	<div class="pull-left">
		<h3><?php _e("Submit one single listing", "ALSP"); ?></h3>
	</div>
	<div class="alsp-submit-section-adv pull-right">
		<a href="<?php echo alsp_submitUrl(array('listings_packages' => 1)); ?>" class="btn btn-primary"><?php _e('Or select Listings Package &rarr;', 'ALSP'); ?></a>
	</div>
	<div class="clear_float"></div>
	<?php endif; ?>
	
	<div class="alsp-submit-section-adv <?php echo $ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style']; ?>">
		<?php $max_columns_in_row = $frontend_controller->args['columns']; ?>
		<?php $levels_counter = count($alsp_instance->levels->levels_array); ?>
		<?php if ($levels_counter > $max_columns_in_row) $levels_counter = $max_columns_in_row; ?>
		<?php $cols_width = floor(12/$levels_counter); ?>
		<?php $cols_width_percents = (100-1)/$levels_counter; ?>

		<?php $counter = 0; ?>
		<?php $tcounter = 0; ?>
		<?php foreach ($alsp_instance->levels->levels_array AS $level): ?>
		<?php $tcounter++; ?>
		<?php if ($counter == 0): ?>
		<div class="row" style="text-align: center;">
		<?php endif; ?>

			<div class="col-sm-<?php echo $cols_width; ?> alsp-plan-column" style="width: <?php echo $cols_width_percents; ?>%;">
				<div class="alsp-panel alsp-panel-default alsp-text-center alsp-choose-plan <?php if($level->featured_level && $ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] == 'pplan-style-3'): ?> feature-plan-scale <?php endif; ?>">
					<div class="alsp-panel-heading <?php if ($level->featured): ?>alsp-featured<?php endif; ?>">
						<?php if ($level->featured_level && $ALSP_ADIMN_SETTINGS['alsp_pricing_plan_style'] == 'pplan-style-2'): ?>
							<span class="popular-level"><?php _e('most popular', 'ALSP'); ?></span>	
						<?php endif; ?>
						<h3>
							<?php echo $level->name; ?>
						</h3>
						<?php if ($ALSP_ADIMN_SETTINGS['alsp_payments_addon'] != 'alsp_woo_payment'): ?>
							<?php if ($alsp_instance->listings_packages->submitlisting_level_message($level)): ?>
							<div class="alsp-choose-plan-package-number">
								<?php echo $alsp_instance->listings_packages->submitlisting_level_message($level); ?>
							</div>
							<?php endif; ?>
						<?php endif; ?>
						<?php if ($level->description): ?><a class="alsp-hint-icon" href="javascript:void(0);" data-content="<?php echo esc_attr(nl2br($level->description)); ?>" data-html="true" rel="popover" data-placement="bottom" data-trigger="hover"></a><?php endif; ?>
					</div>
					<ul class="alsp-list-group">
						<?php do_action('alsp_submitlisting_levels_rows', $level, '<li class="alsp-list-group-item">', '</li>'); ?>
						<?php alsp_frontendRender(array(ALSP_FSUBMIT_TEMPLATES_PATH, 'level_details.tpl.php'), array('args' => $frontend_controller->args, 'level' => $level)); ?>
						<?php if ($alsp_instance->submit_page_url): ?>
						<?php 
							if ($ALSP_ADIMN_SETTINGS['alsp_payments_addon'] != 'alsp_woo_payment'){
								if ($alsp_instance->listings_packages->submitlisting_level_message($level)){
									$submit_text = esc_html__('Submit Now', 'ALSP');
								}else{
									$submit_text = esc_html__('BUY NOW', 'ALSP');
								}
							}else{
									$submit_text = esc_html__('BUY NOW', 'ALSP');
							}
						?>
						<li class="alsp-list-group-item">
							<a href="<?php echo alsp_submitUrl(array('level' => $level->id)); ?>" class="btn btn-primary pricing dynamic-btn"><?php echo $submit_text; ?></a>
						</li>
						<?php endif; ?>
					</ul>
				</div>          
			</div>

		<?php $counter++; ?>
		<?php if ($counter == $max_columns_in_row || $tcounter == $levels_counter): ?>
		</div>
		<?php endif; ?>
		<?php if ($counter == $max_columns_in_row) $counter = 0; ?>
		<?php endforeach; ?>
	</div>
</div>