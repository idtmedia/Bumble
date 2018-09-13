<form method="POST" action="<?php the_permalink($listing->post->ID); ?>#contact-tab" id="alsp_contact_form">
	<input type="hidden" name="listing_id" id="alsp_listing_id" value="<?php echo $listing->post->ID; ?>" />
	<input type="hidden" name="contact_nonce" id="alsp_contact_nonce" value="<?php print wp_create_nonce('alsp_contact_nonce'); ?>" />
	<h3><?php _e('Send message to listing owner', 'ALSP'); ?></h3>
	<h5 id="alsp_contact_warning" style="display: none; color: red;"></h5>
	<div class="alsp-contact-form">
		<?php if (is_user_logged_in()): ?>
		<p>
			<?php printf(__('You are currently logged in as %s. Your message will be sent using your logged in name and email.', 'ALSP'), wp_get_current_user()->user_login); ?>
			<input type="hidden" name="contact_name" id="alsp_contact_name" />
			<input type="hidden" name="contact_email" id="alsp_contact_email" />
		</p>
		<?php else: ?>
		<p>
			<label for="contact_name"><?php _e('Contact Name', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
			<input type="text" name="contact_name" id="alsp_contact_name" class="form-control" value="<?php echo esc_attr(alsp_getValue($_POST, 'contact_name')); ?>" size="35" />
		</p>
		<p>
			<label for="contact_email"><?php _e("Contact Email", "ALSP"); ?><span class="alsp-red-asterisk">*</span></label>
			<input type="text" name="contact_email" id="alsp_contact_email" class="form-control" value="<?php echo esc_attr(alsp_getValue($_POST, 'contact_email')); ?>" size="35" />
		</p>
		<?php endif; ?>
		<p>
			<label for="contact_message"><?php _e("Your message", "ALSP"); ?><span class="alsp-red-asterisk">*</span></label>
			<textarea name="contact_message" id="alsp_contact_message" class="form-control" rows="6"><?php echo esc_textarea(alsp_getValue($_POST, 'contact_message')); ?></textarea>
		</p>
		
		<?php echo alsp_recaptcha(); ?>
		
		<input type="submit" name="submit" class="alsp-send-message-button btn btn-primary" value="<?php esc_attr_e('Send message', 'ALSP'); ?>" />
	</div>
</form>