<h3>
	<?php echo sprintf(__('Send Note to Admin "%s"', 'ALSP'), $alsp_instance->current_listing->title()); ?>
</h3>

<p><?php _e('feel free to send your query', 'ALSP'); ?></p>

<?php 

if(metadata_exists('post', $alsp_instance->current_listing->post->ID, '_notice_to_admin' ) ) {
    $content = get_post_meta( $alsp_instance->current_listing->post->ID, '_notice_to_admin', true );
}else{
	 $content = esc_html__('Your comment here!', 'ALSP');
}
?>



<form action="" method="POST">
	<div class="alsp-submit-section">
		<p class="alsp-submit-section-label"><?php _e('Custom status for listing e.g (Sold, Adopted)', 'ALSP'); ?></p>
		<div class="alsp-submit-section-inside">
			<?php wp_editor($content, '_notice_to_admin', array('media_buttons' => false, 'editor_class' => 'alsp-editor-class')); ?>
			<input class="postmark" name="notice_to_admin_submit" type="submit" value="<?php _e('SAVE', 'ALSP'); ?>"/>
		</div>
	</div>
</form>
