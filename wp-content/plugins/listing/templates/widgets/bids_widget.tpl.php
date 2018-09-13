<?php global $ALSP_ADIMN_SETTINGS; ?>
<?php echo $args['before_widget']; ?>
<?php if (!empty($title))
echo $args['before_title'] . $title . $args['after_title'];
?>
<div class=" alsp-widget alsp_bids_widget"><!-- content class removed pacz -->
	<ul>
		<?php
		$listing = $GLOBALS['listing_id'];
		echo '<li><span class="bid-item-label">'.esc_html__('Total Bids', 'ALSP').'</span><span class="bid-item-value">'.$listing->bidcount().'</span></li>';
		echo '<li><span class="bid-item-label">'.esc_html__('Highest Bid', 'ALSP').'</span><span class="bid-item-value">'.round($listing->highestbid(), 2).'</li>';
		echo '<li><span class="bid-item-label">'.esc_html__('Lowest Bid', 'ALSP').'</span><span class="bid-item-value">'.round($listing->lowestbid(),2).'</li>'; 
		echo '<li><span class="bid-item-label">'.esc_html__('Average Bid', 'ALSP').'</span><span class="bid-item-value">'.round($listing->avgbid(),2).'</li>';
		
		?>
	</ul>
</div>
<?php echo $args['after_widget']; ?>