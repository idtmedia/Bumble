<?php global $ALSP_ADIMN_SETTINGS, $wpdb;
$listing = $GLOBALS['listing_id_resurva'];
$listing_level_id = get_post_meta($listing, '_new_level_id', true);
$level_resurva_db = $wpdb->get_col("SELECT `allow_resurva_booking` FROM {$wpdb->alsp_levels} WHERE id = '". $listing_level_id ."'");
$level_resurva_check = array_filter( array_map( 'absint', $level_resurva_db ));
if(!empty($level_resurva_check) && $level_resurva_check[0] == 1):
 ?>
<?php echo $args['before_widget']; ?>
<?php if (!empty($title))
echo $args['before_title'] . $title . $args['after_title'];

$resurva_url = get_post_meta($listing, '_post_resurva_url', true);

?>
<div class=" alsp-widget alsp_resurva_widget"><!-- content class removed pacz -->
	<iframe src="<?php echo $resurva_url; ?>" name="resurva-frame" frameborder="0" width="450" height="450" style="max-width:100%"></iframe>
</div>
<?php echo $args['after_widget']; 
endif;
?>