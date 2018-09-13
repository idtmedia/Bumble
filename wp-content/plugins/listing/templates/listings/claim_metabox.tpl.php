<p><?php _e("By checking this option you allow registered users to claim this listing.", 'ALSP'); ?></p>

<div class="alsp-content">
	<div class="checkbox">
		<label>
			<input type="checkbox" name="is_claimable" value=1 <?php checked(1, $listing->is_claimable, true); ?> />
			<?php _e('Allow claim', 'ALSP'); ?>
		</label>
	</div>
</div>
	
<?php do_action('alsp_claim_metabox_html', $listing); ?>