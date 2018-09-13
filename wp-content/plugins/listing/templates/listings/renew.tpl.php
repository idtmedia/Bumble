<?php alsp_frontendRender('admin_header.tpl.php'); ?>
<h2>
	<?php echo apply_filters('alsp_renew_option', __('Renew listing', 'ALSP'), $listing); ?>
</h2>

<p><?php _e('Listing will be renewed and raised up to the top of all lists, those ordered by date.', 'ALSP'); ?></p>

<?php do_action('alsp_renew_html', $listing); ?>

<?php if ($action == 'show'): ?>
<a href="<?php echo admin_url('options.php?page=alsp_renew&listing_id=' . $listing->post->ID . '&renew_action=renew&referer=' . urlencode($referer)); ?>" class="button button-primary"><?php _e('Renew listing', 'ALSP'); ?></a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo $referer; ?>" class="button button-primary"><?php _e('Cancel', 'ALSP'); ?></a>
<?php elseif ($action == 'renew'): ?>
<a href="<?php echo $referer; ?>" class="button button-primary"><?php _e('Go back ', 'ALSP'); ?></a>
<?php endif; ?>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>