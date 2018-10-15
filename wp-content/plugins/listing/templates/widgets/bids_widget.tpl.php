<?php global $ALSP_ADIMN_SETTINGS; ?>
<?php echo $args['before_widget']; ?>
<?php if (!empty($title))
echo $args['before_title'] . $title . $args['after_title'];
?>
<div class=" alsp-widget alsp_bids_widget"><!-- content class removed pacz -->
	<ul>
		<?php
		$listing = $GLOBALS['listing_id'];
        $posts = get_posts(array(
            'numberposts'	=> -1,
            'post_type'		=> 'bidding',
            'meta_key'		=> 'job',
            'meta_value'	=> $listing->post->ID
        ));
        $total_bid = count($posts);
        $highestbid = 0;
        $lowestbid = 0;
        $total_cost = 0;
        $i = 0;
        foreach ( $posts as $post ) : setup_postdata( $post );
            if($i==0){
                $lowestbid = get_field('cost',$post->ID);
            }else{
                if(get_field('cost',$post->ID)<$lowestbid) $lowestbid = get_field('cost',$post->ID);
            }
            if(get_field('cost',$post->ID)>$highestbid) $highestbid = get_field('cost',$post->ID);
            $total_cost += get_field('cost',$post->ID);
            $i++;
        endforeach;
        if($total_bid>0){
            $avgbid = $total_cost/$total_bid;
        }
        wp_reset_postdata();

		echo '<li><span class="bid-item-label">'.esc_html__('Total Bids', 'ALSP').'</span><span class="bid-item-value">'.$total_bid.'</span></li>';
		echo '<li><span class="bid-item-label">'.esc_html__('Highest Bid', 'ALSP').'</span><span class="bid-item-value">$'.number_format($highestbid, 2).'</li>';
		echo '<li><span class="bid-item-label">'.esc_html__('Lowest Bid', 'ALSP').'</span><span class="bid-item-value">$'.number_format($lowestbid,2).'</li>';
		echo '<li><span class="bid-item-label">'.esc_html__('Average Bid', 'ALSP').'</span><span class="bid-item-value">$'.number_format($avgbid,2).'</li>';
//		echo '<li><span class="bid-item-label">'.esc_html__('Total Bids', 'ALSP').'</span><span class="bid-item-value">'.$listing->bidcount().'</span></li>';
//		echo '<li><span class="bid-item-label">'.esc_html__('Highest Bid', 'ALSP').'</span><span class="bid-item-value">'.round($listing->highestbid(), 2).'</li>';
//		echo '<li><span class="bid-item-label">'.esc_html__('Lowest Bid', 'ALSP').'</span><span class="bid-item-value">'.round($listing->lowestbid(),2).'</li>';
//		echo '<li><span class="bid-item-label">'.esc_html__('Average Bid', 'ALSP').'</span><span class="bid-item-value">'.round($listing->avgbid(),2).'</li>';
		
		?>
	</ul>
</div>
<?php echo $args['after_widget']; ?>