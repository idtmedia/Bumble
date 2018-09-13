<?php
extract( shortcode_atts( array(
			'custom_user_count' => '',
			'user_count_text' => '',
			'user_count_color' => '#444',
			'user_count_text_color' => '#888',
			'el_class' => '',
		), $atts ) );

global $pacz_settings, $classiadspro_dynamic_styles;
$id = uniqid();
$classiadspro_styles = '';
$output = '';

if(class_exists('Classiadspro_Theme')){
	$classiadspro_styles ='
		#pacz-registered-users-shortcode-'.$id.' .user_counter_digit{
			color:'.$user_count_color.';
			font-size:24px;
		}
		#pacz-registered-users-shortcode-'.$id.' .user_counter_text{
			color:'.$user_count_text_color.';
			font-size:13px;
			padding-top:5px;
			text-transform:uppercase;
		}
	';
}
$output .= '<div id="pacz-registered-users-shortcode-'.$id.'" class="pacz-registered-users '.$el_class.'">';
	if(!empty($custom_user_count)){
		$output .= '<div class="user_counter_digit">'.$custom_user_count.'</div>';
	}else{
		$usercount = count_users();
		$result = $usercount['total_users']; 
		$output .= '<div class="user_counter_digit">'. $result .'</div>';
	}
	$output .= '<div class="user_counter_text">'.$user_count_text.'</div>';
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