<?php global $ALSP_ADIMN_SETTINGS; ?>

<div class="alsp-content">
	<?php alsp_renderMessages(); ?>

	<?php if (isset($_GET['level']) && ($level = $alsp_instance->levels->getLevelById($_GET['level']))): ?>
	<?php if (count($alsp_instance->levels->levels_array) > 1): ?>
	<h2><?php echo sprintf(__('Create new listing in level "%s"', 'ALSP'), $level->name); ?></h2>
	<?php endif; ?>

	<?php if ($frontend_controller->args['show_steps']): ?>
	<?php if ((count($alsp_instance->levels->levels_array) > 1) || ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_login_mode'] == 1 && !is_user_logged_in())): ?>
	<div class="alsp-submit-section-adv">
		<?php $step = 1; ?>

		<?php if (count($alsp_instance->levels->levels_array) > 1): ?>
		<div class="alsp-adv-step">
			<div class="alsp-adv-circle alsp-adv-circle-passed"><?php _e('Step', 'ALSP'); ?> <?php echo $step++; ?></div>
			<?php _e('Choose level', 'ALSP'); ?>
		</div>
		<div class="alsp-adv-line alsp-adv-line-passed"></div>
		<?php endif; ?>

		<?php if ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_login_mode'] == 1 && !is_user_logged_in()): ?>
		<div class="alsp-adv-step alsp-adv-step-active">
			<div class="alsp-adv-circle alsp-adv-circle-active"><?php _e('Step', 'ALSP'); ?> <?php echo $step++; ?></div>
			<?php _e('Login', 'ALSP'); ?>
		</div>
		<div class="alsp-adv-line"></div>
		<?php endif; ?>

		<div class="alsp-adv-step">
			<div class="alsp-adv-circle"><?php _e('Step', 'ALSP'); ?> <?php echo $step++; ?></div>
			<?php _e('Create listing', 'ALSP'); ?>
		</div>
		
		<?php $step = apply_filters('alsp_create_listings_steps_html', $step, $level); ?>

		<div class="clear_float"></div>
	</div>
	<?php endif; ?>
	<?php endif; ?>
	<?php endif; ?>

	<div class="alsp-submit-section-adv">
		<?php alsp_login_form(); ?>
	</div>
</div>