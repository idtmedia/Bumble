<?php global $ALSP_ADIMN_SETTINGS; ?>
<?php echo $args['before_widget']; ?>
<?php if (!empty($title))
echo $args['before_title'] . $title . $args['after_title'];
?>
<div class="alsp-content alsp-widget alsp_search_widget">
	<?php
	$search_form = new alsp_search_form($uid);
				$advanced_open = $ALSP_ADIMN_SETTINGS['advanced_open_widget'];
				$keyword_field_width = (isset($ALSP_ADIMN_SETTINGS['keyword_field_width']))? $ALSP_ADIMN_SETTINGS['keyword_field_width'] : 100;
				$category_field_width = (isset($ALSP_ADIMN_SETTINGS['category_field_width']))? $ALSP_ADIMN_SETTINGS['category_field_width'] : 100;
				$location_field_width = (isset($ALSP_ADIMN_SETTINGS['location_field_width']))? $ALSP_ADIMN_SETTINGS['location_field_width'] : 100;
				$address_field_width = (isset($ALSP_ADIMN_SETTINGS['address_field_width']))? $ALSP_ADIMN_SETTINGS['address_field_width'] : 100;
				$radius_field_width = (isset($ALSP_ADIMN_SETTINGS['radius_field_width']))? $ALSP_ADIMN_SETTINGS['radius_field_width'] : 100;
				$button_field_width = (isset($ALSP_ADIMN_SETTINGS['button_field_width']))? $ALSP_ADIMN_SETTINGS['button_field_width'] : 100;
				$gap_in_fields = (isset($ALSP_ADIMN_SETTINGS['gap_in_fields']))? $ALSP_ADIMN_SETTINGS['gap_in_fields'] : 0;
				$search_form_type = 3;
	$search_form->display($advanced_open, $keyword_field_width, $category_field_width, $location_field_width, $address_field_width, $radius_field_width, $button_field_width,  $gap_in_fields, $search_form_type);
	?>
</div>
<?php echo $args['after_widget']; ?>