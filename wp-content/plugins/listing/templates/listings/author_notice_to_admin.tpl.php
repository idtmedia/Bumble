<?php alsp_frontendRender('admin_header.tpl.php'); ?>
<div class="admin-note-from-author">
<h2>
	<?php _e('Note from Listing Author', 'ALSP'); ?>
</h2>
<?php 
if(metadata_exists('post', $listing->post->ID, '_notice_to_admin' ) ) {
						$content = get_post_meta($listing->post->ID, '_notice_to_admin', true );
						echo '<p>' . $content . '</p>';
					}
?>
</div>
<?php alsp_frontendRender('admin_footer.tpl.php'); ?>