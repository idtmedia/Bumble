<?php alsp_frontendRender('admin_header.tpl.php'); ?>
<h2>
	<?php echo apply_filters('alsp_raiseup_option', sprintf(__('Raise up listing "%s"', 'ALSP'), $listing->title()), $listing); ?>
</h2>

<p><?php _e('Listing will be raised up to the top of all lists, those ordered by date.', 'ALSP'); ?></p>
<p><?php _e('Note, that listing will not stick on top, so new listings and other listings, those were raised up later, will place higher.', 'ALSP'); ?></p>

<?php do_action('alsp_raise_up_html', $listing); ?>

<?php if ($action == 'show'): ?>
<a href="<?php echo admin_url('options.php?page=alsp_raise_up&listing_id=' . $listing->post->ID . '&raiseup_action=raiseup&referer=' . urlencode($referer)); ?>" class="button button-primary"><?php _e('Raise up', 'ALSP'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo $referer; ?>" class="button button-primary"><?php _e('Cancel', 'ALSP'); ?></a>
<?php elseif ($action == 'raiseup'): ?>
<a href="<?php echo $referer; ?>" class="button button-primary"><?php _e('Go back ', 'ALSP'); ?></a>
<?php endif; ?>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>