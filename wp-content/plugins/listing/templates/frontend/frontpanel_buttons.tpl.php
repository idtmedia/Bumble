<?php global $ALSP_ADIMN_SETTINGS; ?>

<?php

$page_id = get_queried_object_id();
$page_object = get_page( $page_id );
if (strpos($page_object->post_content, '[webdirectory-listing]') && $ALSP_ADIMN_SETTINGS['alsp_single_listing_style'] == 2){ ?>
<?php if (isset($listing)): ?>
	<?php do_action('alsp_directory_frontpanel', (isset($listing)) ? $listing : null); ?>
	<?php if (alsp_show_edit_button($listing->post->ID)): ?>
		<?php if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list']): ?>
		<li>
			<a href="javascript:void(0);" class="add_to_favourites btn" listingid="<?php echo $listing->post->ID; ?>"    data-toggle="tooltip" title="<?php if (alsp_checkQuickList(get_the_ID())) { _e('Remove Bookmark', 'ALSP'); }else{ _e('Add Bookmark', 'ALSP'); } ?>"><span class="pacz-icon-<?php if (alsp_checkQuickList($listing->post->ID)){ echo 'heart';}else{ echo 'heart-o';} ?>"></span></a>
		</li>
	<?php endif; ?>
	<li>
		<a href="#" post-id="<?php echo $listing->post->ID; ?>" class="report-post-link"><i class="pacz-fic4-warning-sign"></i></a>
	</li>
		<li>
			<a class="alsp-edit-listing-link btn" href="<?php echo alsp_get_edit_listing_link($listing->post->ID); ?>" data-toggle="tooltip" title="<?php _e('Edit listing', 'ALSP'); ?>"><span class="pacz-fic3-edit"></span></a>
		</li>
	<?php endif; ?>
	<?php if ($ALSP_ADIMN_SETTINGS['alsp_print_button']): ?>
		<script>
			var window_width = 860;
			var window_height = 800;
			var leftPosition, topPosition;
			(function($) {
				"use strict";
	
				$(function() {
					leftPosition = (window.screen.width / 2) - ((window_width / 2) + 10);
					topPosition = (window.screen.height / 2) - ((window_height / 2) + 50);
				});
			})(jQuery);
		</script>
		<li>
			<a href="javascript:void(0);" class="alsp-print-listing-link btn" onClick="window.open('<?php echo add_query_arg('alsp_action', 'printlisting', get_permalink($listing->post->ID)); ?>', 'print_window', 'height='+window_height+',width='+window_width+',left='+leftPosition+',top='+topPosition+',menubar=yes,scrollbars=yes');"   data-toggle="tooltip" title="<?php _e('Print listing', 'ALSP'); ?>"><span class="pacz-fic3-printer"></span></a>
		</li>
	<?php endif; ?>
	
	<?php if ($ALSP_ADIMN_SETTINGS['alsp_pdf_button']): ?>
		<li>
			<a href="javascript:void(0);" class="alsp-pdf-listing-link btn" onClick="window.open('http://pdfmyurl.com/?url=<?php echo urlencode(add_query_arg('alsp_action', 'pdflisting', get_permalink($listing->post->ID))); ?>');"   data-toggle="tooltip" title="<?php _e('Save listing in PDF', 'ALSP'); ?>"><span class="pacz-fic3-download"></span></a>
		</li>
	<?php endif; ?>
	
<?php endif; ?>
<?php }else{ ?>
<div class="alsp-content">
	<div class="alsp-directory-frontpanel">
		<div class="cz-custom-btn-wrap">
		<?php do_action('alsp_directory_frontpanel', (isset($listing)) ? $listing : null); ?>
	
		<?php if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'): ?>
			<div class="cz-btn-wrap">
				<a class="favourites-link btn" href="<?php echo alsp_directoryUrl(array('alsp_action' => 'myfavourites')); ?>"  data-toggle="tooltip" title="<?php _e('My bookmarks', 'ALSP'); ?>"><span class="glyphicon glyphicon-star"></span></a>
			</div>
		<?php endif; ?>
	
		<?php if (isset($listing)): ?>
			<?php if (alsp_show_edit_button($listing->post->ID)): ?>
			<div class="cz-btn-wrap">
				<a class="alsp-edit-listing-link btn" href="<?php echo alsp_get_edit_listing_link($listing->post->ID); ?>" data-toggle="tooltip" title="<?php _e('Edit listing', 'ALSP'); ?>"><span class="pacz-fic3-edit"></span></a>
			</div>
			<?php endif; ?>
		
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_print_button']): ?>
			<script>
				var window_width = 860;
				var window_height = 800;
				var leftPosition, topPosition;
				(function($) {
					"use strict";
	
					$(function() {
						leftPosition = (window.screen.width / 2) - ((window_width / 2) + 10);
						topPosition = (window.screen.height / 2) - ((window_height / 2) + 50);
					});
				})(jQuery);
			</script>
			<div class="cz-btn-wrap">
				<a href="javascript:void(0);" class="alsp-print-listing-link btn" onClick="window.open('<?php echo add_query_arg('alsp_action', 'printlisting', get_permalink($listing->post->ID)); ?>', 'print_window', 'height='+window_height+',width='+window_width+',left='+leftPosition+',top='+topPosition+',menubar=yes,scrollbars=yes');"   data-toggle="tooltip" title="<?php _e('Print listing', 'ALSP'); ?>"><span class="pacz-fic3-printer"></span></a>
			</div>
			<?php endif; ?>
		
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list']): ?>
			<div class="cz-btn-wrap">
				<a href="javascript:void(0);" class="add_to_favourites btn" listingid="<?php echo $listing->post->ID; ?>"    data-toggle="tooltip" title="<?php if (alsp_checkQuickList(get_the_ID())) { _e('Remove Bookmark', 'ALSP'); }else{ _e('Add Bookmark', 'ALSP'); } ?>"><span class="pacz-icon-<?php if (alsp_checkQuickList($listing->post->ID)){ echo 'heart';}else{ echo 'heart-o';} ?>"></span></a>
			</div>
			<?php endif; ?>
		
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_pdf_button']): ?>
			<div class="cz-btn-wrap">
				<a href="javascript:void(0);" class="alsp-pdf-listing-link btn" onClick="window.open('http://pdfmyurl.com/?url=<?php echo urlencode(add_query_arg('alsp_action', 'pdflisting', get_permalink($listing->post->ID))); ?>');"   data-toggle="tooltip" title="<?php _e('Save listing in PDF', 'ALSP'); ?>"><span class="pacz-fic3-download"></span></a>
			</div>
			<?php endif; ?>
		<?php endif; ?>
		</div>
	</div>
</div>
<?php } ?>