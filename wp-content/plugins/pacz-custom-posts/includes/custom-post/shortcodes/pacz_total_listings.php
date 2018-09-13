<?php
extract( shortcode_atts( array(
			'custom_listing_count' => '',
			'listing_count_text' => '',
			'listing_count_color' => '#444',
			'listing_count_text_color' => '#888',
			'el_class' => '',
		), $atts ) );

		
global $pacz_settings, $classiadspro_dynamic_styles;
$id = uniqid();
$classiadspro_styles = '';
$output = '';
if(class_exists('Classiadspro_Theme')){
	$classiadspro_styles ='
		#pacz-total-listing_count-shortcode-'.$id.' .listing_counter_digit{
			color:'.$listing_count_color.';
			font-size:24px;
		}
		#pacz-total-listing_count-shortcode-'.$id.' .listing_counter_text{
			color:'.$listing_count_text_color.';
			font-size:13px;
			padding-top:5px;
			text-transform:uppercase;
		}
	';
}
$output .= '<div id="pacz-total-listing_count-shortcode-'.$id.'" class="pacz-total-listing-count '.$el_class.'">';
	if(!empty($custom_listing_count)){
		$output .= '<div class="listing_counter_digit">'.$custom_listing_count.'</div>';
	}else{
		$count_posts = wp_count_posts( 'alsp_listing' )->publish;
 
		if ( $count_posts ) {
			
			$output .= '<div class="listing_counter_digit">'.$count_posts.'</div>';
		}
	}
	$output .= '<div class="listing_counter_text">'.$listing_count_text.'</div>';
$output .= '</div>';
echo $output;

// Hidden styles node for head injection after page load through ajax
echo '<div id="ajax-'.$id.'" class="pacz-dynamic-styles">';
echo '<!-- ' . pacz_clean_dynamic_styles($classiadspro_styles) . '-->';
echo '</div>';


// Export styles to json for faster page load
$classiadspro_dynamic_styles[] = array(
  'id' => 'ajax-'.$id ,
  'inject' => $classiadspro_styles
);
