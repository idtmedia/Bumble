<p><?php _e("Add Resurva Booking url", 'ALSP'); ?></p>

<div class="alsp-content">
	<div class="input">
		<label>
			<input type="text" name="post_resurva_url" style="width: 100%" class="form-control" value="<?php echo get_post_meta($alsp_instance->current_listing->post->ID, '_post_resurva_url', true); ?>" placeholder="<?php echo esc_html__('Resurva Booking Url', 'ALSP'); ?>" />
			<?php _e('Resurva Booking url', 'ALSP'); ?>
		</label>
	</div>
</div>
	
<?php do_action('alsp_claim_metabox_html', $listing); ?>