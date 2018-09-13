<?php global $ALSP_ADIMN_SETTINGS; ?>
<?php echo $args['before_widget']; ?>
<?php if (!empty($title))
echo $args['before_title'] . $title . $args['after_title'];
$listing = $GLOBALS['listing_id'];
//$listing = $GLOBALS['listing_id_resurva'];
//$listing_level_id = get_post_meta($listing, '_new_level_id', true);
//$level_resurva_db = $wpdb->get_col("SELECT `allow_resurva_booking` FROM {$wpdb->alsp_levels} WHERE id = '". $listing_level_id ."'");
//$level_resurva_check = array_filter( array_map( 'absint', $level_resurva_db ));
$frontend_controller = new alsp_frontend_controller();
?>
<div class=" alsp-widget alsp_map_widget"><!-- content class removed pacz -->
	<?php if ($listing->level->google_map && $listing->isMap() && $listing->locations): ?>
							<div id="addresses-widget" class="">
							
								<?php $listing->renderMap($frontend_controller->hash, $ALSP_ADIMN_SETTINGS['alsp_show_directions'], false, $ALSP_ADIMN_SETTINGS['alsp_enable_radius_search_cycle'], $ALSP_ADIMN_SETTINGS['alsp_enable_clusters'], false, false); ?>

							</div>
							<?php endif; ?>
</div>
<?php echo $args['after_widget']; ?>