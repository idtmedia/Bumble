<h3>
	<?php echo sprintf(__('Change status of listing "%s"', 'ALSP'), $alsp_instance->current_listing->title()); ?>
</h3>

<p><?php _e('You can change listing status as private or public', 'ALSP'); ?></p>
<?php $listing_status = get_post_meta($alsp_instance->current_listing->post->ID, '_listing_status', true);  ?>
<?php do_action('alsp_renew_html', $alsp_instance->current_listing); ?>
<?php if($listing_status == 'active' && $alsp_instance->current_listing->post->post_status == 'publish'){ ?>
<a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'change_status', 'listing_id' => $alsp_instance->current_listing->post->ID, 'status_action' => 'private', 'referer' => urlencode($frontend_controller->referer))); ?>" class="btn btn-primary"><?php _e('Private listing', 'ALSP'); ?></a>
<?php }elseif($listing_status == 'active' && $alsp_instance->current_listing->post->post_status == 'private'){ ?>
<a href="<?php echo alsp_dashboardUrl(array('alsp_action' => 'change_status', 'listing_id' => $alsp_instance->current_listing->post->ID, 'status_action' => 'publish', 'referer' => urlencode($frontend_controller->referer))); ?>" class="btn btn-primary"><?php _e('publish listing', 'ALSP'); ?></a>
<?php } ?>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo $frontend_controller->referer; ?>" class="btn btn-primary"><?php _e('Cancel', 'ALSP'); ?></a>
<?php 

if(metadata_exists('post', $alsp_instance->current_listing->post->ID, '_listing_mark_as' ) ) {
    $meta_value = get_post_meta( $alsp_instance->current_listing->post->ID, '_listing_mark_as', true );
}else{
	 $meta_value = '';
}
?>

<h3 style="margin-top:50px;">
	<?php echo sprintf(__('Add Custom Status "%s"', 'ALSP'), $alsp_instance->current_listing->title()); ?>
</h3>

<form action="" method="POST">
	<div class="alsp-submit-section">
		<p class="alsp-submit-section-label"><?php _e('Custom status for listing e.g (Sold, Adopted)', 'ALSP'); ?></p>
		<div class="alsp-submit-section-inside">
			<input type="text" name="post_markas" style="width: 70%" class="form-control" placeholder="<?php echo esc_html__('Add Listing Status', 'ALSP') ?>" value="<?php echo $meta_value; ?>" />
			<input class="postmark" name="post_markas_submit" type="submit" value="<?php _e('SAVE', 'ALSP'); ?>"/>
		</div>
	</div>
</form>
