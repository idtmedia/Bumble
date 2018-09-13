<?php echo $args['before_widget']; ?>
<?php if (!empty($title))
echo $args['before_title'] . $title . $args['after_title'];
?>
<?php if (isset($style) && $style == 1){ ?>
<div class="alsp-widget alsp-locations-widget clearfix">
<?php }else{ ?>
	<div class="alsp-widget alsp-locations-widget style2 clearfix">	
<?php } ?>
	<?php alsp_renderAllLocations($parent, $depth, 1, $counter, $sublocations); ?>
</div>
<?php echo $args['after_widget']; ?>