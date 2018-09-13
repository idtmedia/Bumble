
<?php global $ALSP_ADIMN_SETTINGS; ?>
<?php if (alsp_get_dynamic_option('alsp_listing_title_font')): ?>
header.alsp-listing-header h2 {
	font-size: <?php echo alsp_get_dynamic_option('alsp_listing_title_font'); ?>px;
}
<?php endif; ?>
<?php if ($ALSP_ADIMN_SETTINGS['alsp_search_style3_mtop']): ?>
.search-form-style3.alsp-content.alsp-search-form {
    margin-top: <?php echo $ALSP_ADIMN_SETTINGS['alsp_search_style3_mtop']; ?>px !important;
}
<?php endif; ?>
<?php if (!$ALSP_ADIMN_SETTINGS['alsp_search_style3_shadow']): ?>
.search-wrap {
    box-shadow:none;
}
<?php endif; ?>
<?php if (alsp_get_dynamic_option('alsp_listings_bottom_margin') >= 0): ?>
.alsp-listings-block article.alsp-listing {
	margin-bottom: <?php echo alsp_get_dynamic_option('alsp_listings_bottom_margin'); ?>px;
}
<?php endif; ?>
<?php 
$page_id = get_queried_object_id();
		$page_object = get_page( $page_id );
		if (strpos($page_object->post_content, '[webdirectory-listing]')){
?>
#theme-page .theme-page-wrapper .inner-page-wrapper .vc_row #pacz-sidebar {
    padding-left: 15px;
	padding-right:15px;
}
		<?php } ?>


<?php if (alsp_get_dynamic_option('alsp_share_buttons_width')): ?>
.alsp-content .alsp-share-button img {
	max-width: <?php echo get_option('alsp_share_buttons_width'); ?>px;
}
.alsp-content .alsp-share-buttons {
	height: <?php echo get_option('alsp_share_buttons_width')+10; ?>px;
}
<?php endif; ?>

<?php if (!$ALSP_ADIMN_SETTINGS['alsp_100_single_logo_width']): ?>
/* It works with devices width more than 800 pixels. */
@media screen and (min-width: 800px) {
	.alsp-single-listing-logo-wrap {
		
		
		margin: 0 20px 20px 0;
	}
	.rtl .alsp-single-listing-logo-wrap {
		float: right;
		margin: 0 0 20px 20px;
	}
	/* temporarily */
	/*.alsp-single-listing-text-content-wrap {
		margin-left: <?php echo $ALSP_ADIMN_SETTINGS['alsp_single_logo_width']+20; ?>px;
	}*/
}
<?php endif; ?>

<?php if ($ALSP_ADIMN_SETTINGS['alsp_hide_search_on_map_mobile']): ?>
/* It works with devices width less than 800 pixels. */
@media screen and (max-width: 800px) {
	.alsp-search-map-block {
		display: none !important;
	}
}
<?php endif; ?>

<?php if ($ALSP_ADIMN_SETTINGS['alsp_big_slide_bg_mode']): ?>
article.alsp-listing .alsp-single-listing-logo-wrap .alsp-big-slide {
	background-size: <?php echo $ALSP_ADIMN_SETTINGS['alsp_big_slide_bg_mode']; ?>;
}
<?php endif; ?>
