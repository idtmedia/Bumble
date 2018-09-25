<?php global $ALSP_ADIMN_SETTINGS; ?>

<div class="alsp-submit-listing-wrap row clearfix">
	<div class="cz-creat-listing col-md-8 col-sm-12 col-xs-12">
		<div class="cz-creat-listing-inner clearfix">
			<?php alsp_renderMessages(); ?>

			<?php if (count($alsp_instance->levels->levels_array) > 1): ?>
			<h2>
<?php
_e('POST YOUR JOB','ALSP');
//echo sprintf(apply_filters('alsp_create_option', __('Create new listing in level "%s"', 'ALSP'), $alsp_instance->current_listing), $alsp_instance->current_listing->level->name); ?></h2>
			<?php endif; ?>

			<?php if (alsp_is_woo_active() && alsp_is_woo_packages() && count($alsp_instance->levels->levels_array) == 1): ?>
			<h2><?php echo apply_filters('alsp_create_option', __('Create new listing', 'ALSP'), $alsp_instance->current_listing); ?></h2>
			<?php
			$packages_manager = new alsp_listings_packages_manager;
			if (!$packages_manager->can_user_create_listing_in_level($alsp_instance->current_listing->level->id)): ?>
			<p><?php _e("Add package to cart, then submit your listing. Listing will become active after payment.", "ALSP"); ?></p>
			<?php alsp_frontendRender(array(ALSP_FSUBMIT_TEMPLATES_PATH, 'listings_packages.tpl.php'), array('frontend_controller' => $frontend_controller, 'hide_navigation' => true)); ?>
			<?php endif; ?>
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
				<div class="alsp-adv-step">
					<div class="alsp-adv-circle alsp-adv-circle-passed"><?php _e('Step', 'ALSP'); ?> <?php echo $step++; ?></div>
					<?php _e('Login', 'ALSP'); ?>
				</div>
				<div class="alsp-adv-line alsp-adv-line-passed"></div>
				<?php endif; ?>

				<div class="alsp-adv-step alsp-adv-step-active">
					<div class="alsp-adv-circle alsp-adv-circle-active"><?php _e('Step', 'ALSP'); ?> <?php echo $step++; ?></div>
					<?php _e('Create listing', 'ALSP'); ?>
				</div>

				<?php $step = apply_filters('alsp_create_listings_steps_html', $step, $alsp_instance->current_listing->level); ?>

				<div class="clear_float"></div>
			</div>
			<?php endif; ?>
			<?php endif; ?>

			<form action="<?php echo alsp_submitUrl(array('level' => $alsp_instance->current_listing->level->id)); ?>" method="POST">
				<input type="hidden" name="listing_id" value="<?php echo $alsp_instance->current_listing->post->ID; ?>" />
				<input type="hidden" name="listing_id_hash" value="<?php echo md5($alsp_instance->current_listing->post->ID . wp_salt()); ?>" />
				<?php wp_nonce_field('alsp_submit', '_submit_nonce'); ?>

				<?php if (!is_user_logged_in() && ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_login_mode'] == 2 || $ALSP_ADIMN_SETTINGS['alsp_fsubmit_login_mode'] == 3)): ?>
				<div class="alsp-submit-section">
					<p class="alsp-submit-section-label field-section-lable"><?php _e('Contact info', 'ALSP'); ?></p>
					<div class="alsp-submit-section-inside field-wrapper">
						<label class="alsp-fsubmit-contact"><?php _e('Contact Name', 'ALSP'); ?><?php if ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_login_mode'] == 2): ?><span class="alsp-red-asterisk">*</span><?php endif; ?></label>
						<input type="text" name="alsp_user_contact_name" value="<?php echo esc_attr($frontend_controller->alsp_user_contact_name); ?>" class="form-control" style="width: 100%;" />

						<label class="alsp-fsubmit-contact"><?php _e('Contact Email', 'ALSP'); ?><?php if ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_login_mode'] == 2): ?><span class="alsp-red-asterisk">*</span><?php endif; ?></label>
						<input type="text" name="alsp_user_contact_email" value="<?php echo esc_attr($frontend_controller->alsp_user_contact_email); ?>" class="form-control" style="width: 100%;" />
					</div>
				</div>
				<?php endif; ?>
				<div class="row clearfix">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="alsp-submit-section">
							<p class="alsp-submit-section-label field-section-lable"><?php _e('Listing Details', 'ALSP'); ?></p>
							<div class="alsp-submit-section-inside field-wrapper">

								<p class="alsp-submit-section-label alsp-submit-field-title"><?php _e('Listing title', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></p>
								<input type="text" name="post_title" style="width: 100%" class="form-control" value="<?php if ($alsp_instance->current_listing->post->post_title != __('Auto Draft', 'ALSP')) echo esc_attr($alsp_instance->current_listing->post->post_title); ?>" />

								<?php if ($ALSP_ADIMN_SETTINGS['alsp_listing_contact_form'] && $ALSP_ADIMN_SETTINGS['alsp_custom_contact_email']): ?>
									<p class="contact-email-meta alsp-submit-field-title"><?php _e('Contact email ', 'ALSP'); ?> ( <?php _e("if empty author email will be used.", 'ALSP'); ?> )</p>
									<?php $alsp_instance->listings_manager->listingContactEmailMetabox($alsp_instance->current_listing->post); ?>
								<?php endif; ?>

								<?php if ($ALSP_ADIMN_SETTINGS['alsp_enable_tags']): ?>
									<p class="alsp-submit-section-label alsp-submit-field-title"><?php echo $alsp_instance->content_fields->getContentFieldBySlug('listing_tags')->name; ?> <i>(<?php _e('select existing or type new', 'ALSP'); ?>)</i></p>
									<?php alsp_tags_selectbox($alsp_instance->current_listing->post->ID); ?>
									<?php if ($alsp_instance->content_fields->getContentFieldBySlug('listing_tags')->description): ?><p class="description"><?php echo $alsp_instance->content_fields->getContentFieldBySlug('listing_tags')->description; ?></p><?php endif; ?>
								<?php endif; ?>

								<?php if ($alsp_instance->current_listing->level->allow_resurva_booking): ?>
									<p class="alsp-submit-section-label alsp-submit-field-title"><?php echo _e('Add Resurva Booking Url', 'ALSP'); ?></i></p>
									<input type="text" name="post_resurva_url" style="width: 100%" class="form-control" value="<?php echo get_post_meta($alsp_instance->current_listing->post->ID, '_post_resurva_url', true); ?>" placeholder="<?php echo esc_html__('Resurva Booking Url', 'ALSP'); ?>" />
								<?php endif; ?>
								<?php if (!$alsp_instance->current_listing->level->eternal_active_period && ($ALSP_ADIMN_SETTINGS['alsp_change_expiration_date'] || current_user_can('manage_options'))): ?>
									<p class="alsp-submit-section-label alsp-submit-field-title"><?php _e('Listing expiration date', 'ALSP'); ?></p>
									<?php $alsp_instance->listings_manager->listingExpirationDateMetabox($alsp_instance->current_listing->post); ?>
								<?php endif; ?>

								<?php if ($ALSP_ADIMN_SETTINGS['alsp_claim_functionality'] && !$ALSP_ADIMN_SETTINGS['alsp_hide_claim_metabox']): ?>
									<p class="alsp-submit-section-label alsp-submit-field-title"><?php _e('Listing claim', 'ALSP'); ?></p>
									<?php $alsp_instance->listings_manager->listingClaimMetabox($alsp_instance->current_listing->post); ?>
								<?php endif; ?>

								<?php if ($alsp_instance->current_listing->level->categories_number > 0 || $alsp_instance->current_listing->level->unlimited_categories): ?>
									<p class="alsp-submit-section-label alsp-submit-field-title"><?php echo $alsp_instance->content_fields->getContentFieldBySlug('categories_list')->name; ?><?php if ($alsp_instance->content_fields->getContentFieldBySlug('categories_list')->is_required): ?><span class="alsp-red-asterisk">*</span><?php endif; ?></p>
									<div class="submit-cat-hide-expand"><a href="javascript:void(0);" class="alsp-expand-terms"><?php _e('Expand All', 'ALSP'); ?></a> | <a href="javascript:void(0);" class="alsp-collapse-terms"><?php _e('Collapse All', 'ALSP'); ?></a></div>
									<div class="alsp-categories-tree-panel alsp-editor-class" id="<?php echo ALSP_CATEGORIES_TAX; ?>-all">
										<?php alsp_terms_checklist($alsp_instance->current_listing->post->ID); ?>
									</div>
									<?php if ($alsp_instance->content_fields->getContentFieldBySlug('categories_list')->description): ?><p class="description"><?php echo $alsp_instance->content_fields->getContentFieldBySlug('categories_list')->description; ?></p><?php endif; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>

				<div class="alsp-submit-section">
					<p class="alsp-submit-section-label field-section-lable"><?php _e('Listing Extra Details', 'ALSP'); ?></p>
					<div class="alsp-submit-section-inside field-wrapper">
						<?php if ($alsp_instance->content_fields->isNotCoreContentFields() && !$alsp_instance->current_listing->post->price): ?>
							<?php $alsp_instance->content_fields_manager->contentFieldsMetabox($alsp_instance->current_listing->post); ?>
						<?php endif; ?>

						<?php if (post_type_supports(ALSP_POST_TYPE, 'editor')): ?>
							<p class="alsp-submit-section-label alsp-submit-field-title"><?php echo $alsp_instance->content_fields->getContentFieldBySlug('content')->name; ?><?php if ($alsp_instance->content_fields->getContentFieldBySlug('content')->is_required): ?><span class="alsp-red-asterisk">*</span><?php endif; ?></p>
							<?php wp_editor($alsp_instance->current_listing->post->post_content, 'post_content', array('media_buttons' => false, 'editor_class' => 'alsp-editor-class')); ?>
							<?php if ($alsp_instance->content_fields->getContentFieldBySlug('content')->description): ?><p class="description"><?php echo $alsp_instance->content_fields->getContentFieldBySlug('content')->description; ?></p><?php endif; ?>
						<?php endif; ?>

						<?php if (post_type_supports(ALSP_POST_TYPE, 'excerpt')): ?>
							<p class="alsp-submit-section-label alsp-submit-field-title"><?php echo $alsp_instance->content_fields->getContentFieldBySlug('summary')->name; ?><?php if ($alsp_instance->content_fields->getContentFieldBySlug('summary')->is_required): ?><span class="alsp-red-asterisk">*</span><?php endif; ?></p>
							<textarea name="post_excerpt" class="alsp-editor-class form-control" rows="4"><?php echo esc_textarea($alsp_instance->current_listing->post->post_excerpt)?></textarea>
							<?php if ($alsp_instance->content_fields->getContentFieldBySlug('summary')->description): ?><p class="description"><?php echo $alsp_instance->content_fields->getContentFieldBySlug('summary')->description; ?></p><?php endif; ?>
						<?php endif; ?>
					</div>

				</div>

				<?php do_action('alsp_create_listing_metaboxes_pre', $alsp_instance->current_listing); ?>

				<?php if ($alsp_instance->current_listing->level->images_number > 0 || $alsp_instance->current_listing->level->videos_number > 0): ?>
					<div class="alsp-submit-section">
						<p class="alsp-submit-section-label field-section-lable"><?php _e('Listing Media', 'ALSP'); ?></p>
						<div class="alsp-submit-images-wrap clearfix">
							<div class="alsp-submit-section-inside field-wrapper clearfix">
								<?php $alsp_instance->media_manager->mediaMetabox(); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<?php if ($alsp_instance->current_listing->level->locations_number > 0): ?>
					<div class="alsp-submit-section">
						<div class="alsp-submit-location-wrap">
							<p class="col-md-12 alsp-submit-section-label field-section-lable"><?php _e('Listing locations', 'ALSP'); ?><?php if ($alsp_instance->content_fields->getContentFieldBySlug('address')->is_required): ?><span class="alsp-red-asterisk">*</span><?php endif; ?></p>
							<div class="alsp-submit-section-inside field-wrapper">
								<?php $alsp_instance->locations_manager->listingLocationsMetabox($alsp_instance->current_listing->post); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php do_action('alsp_create_listing_metaboxes_post', $alsp_instance->current_listing); ?>

				<?php if ($ALSP_ADIMN_SETTINGS['alsp_enable_recaptcha']): ?>
				<div class="alsp-submit-section-adv">
					<?php echo alsp_recaptcha(); ?>
				</div>
				<?php endif; ?>

				<?php
				if ($tos_page = alsp_get_wpml_dependent_option('alsp_tospage')) : ?>
				<div class="col-md-12 alsp-submit-section-adv">
					<label><input type="checkbox" name="alsp_tospage" value="1" /> <?php echo esc_html__('I agree to the ', 'ALSP'); ?>  <a href="<?php echo get_permalink($tos_page); ?>" target="_blank"><?php echo __('Terms of Services', 'ALSP'); ?></a></label>
				</div>
				<?php endif; ?>

				<?php require_once(ABSPATH . 'wp-admin/includes/template.php'); ?>
				<?php submit_button(__('Submit new listing', 'ALSP'), 'btn')?>
			</form>
		</div>
	</div>
</div>
