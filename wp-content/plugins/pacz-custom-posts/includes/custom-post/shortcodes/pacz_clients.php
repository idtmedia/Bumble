<?php

extract( shortcode_atts( array(
			'count'=> 10,
			'bg_color' => '',
			'client_style' => '1',
			'style' => 'column',
			'column' => '1',
            'dimension' => '120', // specific for grid style
            'item_height' => '120', // specific for column style
			'border_color' => '',
			'border' => 1,
			'border_width' => '0',
			'orderby'=> 'date',
			'scroll' => 'true',
			'clinet_shadow' => 'false',
			'hover_state' => 'false',
			'target' => '_self',
			'clients' => '',
			'height' => '',
			'order'=> 'DESC',
			'el_class' => '',
			'autoplay' => 'false',
		'tab_landscape_items' => 3,
		'tab_items' => 2,
		'desktop_items' => 5,
		'autoplay_speed' => 2000,
		'delay' => 1000,
		'gutter_space' =>30,
		'item_loop' => 'false',
		'owl_nav' => 'false',
			'cover' => 'false'
		), $atts ) );

$scroll_stuff = array('','','','', '');

$query = array(
	'post_type' => 'clients',
	'showposts' => $count,
);

if ( $clients ) {
	$query['post__in'] = explode( ',', $clients );
}
if ( $orderby ) {
	$query['orderby'] = $orderby;
}
if ( $order ) {
	$query['order'] = $order;
}



$loop = new WP_Query( $query );

$bg_color = !empty( $bg_color ) ? ( 'background-color:'.$bg_color.';' ) : '';
$border_color_item = !empty( $border_color ) ? ( 'border-color:'.$border_color.';' ) : 'border-color:transparent;';

$id = uniqid();
$output = $column_css = $dimension_style = $container_border = '';

// Get global JSON contructor object for styles and create local variable
global $classiadspro_dynamic_styles;
$classiadspro_styles = '';

if ( $client_style == 2 && $border == 0 ) {
	$classiadspro_styles .= '

		#clients-shortcode-'.$id.' ul li {border-right:none !important;border-top:none !important;}
	
	';
}
if ( $client_style == 2 ) {
    $classiadspro_styles .= '
		#clients-shortcode-'.$id.' ul li {}
		#clients-shortcode-'.$id.' ul li .client-logo{max-width:100%;}
		#clients-shortcode-'.$id.' ul li a{display:block;height:inherit;text-align:center;}
		.pacz-clients-shortcode.column-style .client-logo{max-width:100%;width:auto;position:absolute;left:0;right:0;top:50%;transform:translateY(-50%);margin:0 auto;}
	    #clients-shortcode-'.$id.' ul li:last-child .flip-wrapper {
            border-right-width: '.$border_width.'px !important;
        }
        #clients-shortcode-'.$id.' .client-item-wrapper{
			border-width: '.$border_width.'px;
    	}

        #clients-shortcode-'.$id.' ul li:last-child .flip-wrapper {
            border-right-width: '.$border_width.'px !important;
        }
		#clients-shortcode-'.$id.' ul li {border-right:1px solid #eee;border-top:1px solid #eee;}
		#clients-shortcode-'.$id.' ul li:nth-child(5),
		#clients-shortcode-'.$id.' ul li:nth-child(10),
		#clients-shortcode-'.$id.' ul li:nth-child(15){border-right:none;}
		#clients-shortcode-'.$id.' ul li:nth-child(1),
		#clients-shortcode-'.$id.' ul li:nth-child(2),
		#clients-shortcode-'.$id.' ul li:nth-child(3),
		#clients-shortcode-'.$id.' ul li:nth-child(4),
		#clients-shortcode-'.$id.' ul li:nth-child(5){border-top:none;}
		#clients-shortcode-'.$id.' ul li .client-item-wrapper:hover{box-shadow:none;}
		
		@media handheld, only screen and (max-width: 767px) {
		#clients-shortcode-'.$id.' ul li {border-right:none;border-top:none;}
		}
        ';
}
if ( $client_style == 1 ) {
	$classiadspro_styles .= '
	.pacz-clients-shortcode.column-style.client-style1 .client-logo{max-width:100%;width:auto;position:absolute;top:50%;left:0;right:0;transform:translateY(-50%);margin:0 auto;}
	
	';
}
if ( $style == 'grid' ) {
    $classiadspro_styles .= '
	    #clients-shortcode-'.$id.' ul li:last-child .flip-wrapper {
            border-right-width: '.$border_width.'px !important;
        }
        #clients-shortcode-'.$id.' .client-item-wrapper{
			border-width: '.$border_width.'px;
    	}

        #clients-shortcode-'.$id.' ul li:last-child .flip-wrapper {
            border-right-width: '.$border_width.'px !important;
        }
        ';
}else{
	$classiadspro_styles .= '
        #clients-shortcode-'.$id.'.column-style .client-item .client-item-wrapper {
            border-width:'.$border_width.'px;
        }
.client-item-wrapper a .client-logo{
		background-size:cover;		
	}

.client-item-wrapper:hover{	
				
				
	}
        ';
}
if ( $clinet_shadow == 'true' ) {
	$classiadspro_styles .= '
	.client-item-wrapper:hover{	
	-webkit-box-shadow: 0 0 15px rgba(0,0,0,.15);
	-moz-box-shadow: 0 0 15px rgba(0,0,0,.15);
	box-shadow: 0 0 15px rgba(0,0,0,.15);			
	}
	';
}
if($scroll == 'true'){
	$column = '1';
	$scroll_class = 'owl-carousel';
	$scroll_data = 'data-items="'.$desktop_items.'" data-items-tab-ls="'.$tab_landscape_items.'" data-items-tab="'.$tab_items.'" data-autoplay="'.$autoplay.'" data-gutter="'.$gutter_space.'" data-autoplay-speed="'.$autoplay_speed.'" data-delay="'.$delay.'" data-loop="'.$item_loop.'" data-nav="'.$owl_nav.'"';
}else{
	$scroll_class = '';
	$scroll_data = '';
}

if($style == 'column') {
	switch ( $column ) {
		case 1:
			$column_css = 'one-column';
			break;
		case 2:
			$column_css = 'two-column';
			break;
		case 3:
			$column_css = 'three-column';
			break;
		case 4:
			$column_css = 'four-column';
			break;
		case 5:
			$column_css = 'five-column';
			break;
		case 6:
			$column_css = 'six-column';
			break;
		default : 
			$column_css = 'four-column';
		}
	$dimension = $item_height;
	$item_height = !empty( $item_height ) ? ( 'height:'.$item_height.'px;' ) : ( ' height:180px;' );
	$container_border = !empty( $border_color ) ? ( 'style="border-left:'.$border_width.'px solid '.$border_color.'; border-top:'.$border_width.'px solid '.$border_color.';" ' ) : '';

}
if(empty($url)){
	$url = '#';
}
$output .= '<div id="clients-shortcode-'.$id.'" class="pacz-clients-shortcode '.$column_css.' column-style client-style'.$client_style.' bg-cover-'.$cover.' '.$el_class.'">';
$output .= '<div class="">';

$output .= '<ul class="'.$scroll_class.'" '.$scroll_data.' '.$container_border.' >';


while ( $loop->have_posts() ):
	$loop->the_post();
$url = get_post_meta( get_the_ID(), '_url', true );
$company = get_post_meta( get_the_ID(), '_company', true );
$image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );

if($client_style == 1){
$output .= '<li class="client-item '.$scroll_stuff[3].'" onClick="return true"><div class="client-item-wrapper" style="'.$border_color_item.'">';
$output .= '<a style="'.$dimension_style.$item_height.$bg_color.' display:block;text-align:center;" target="'.$target.'" href="'.$url.'">';
$output .= '<img title="'.$company.'" class="client-logo" src="'.pacz_thumbnail_image_gen($image_src_array[0], false, false).'" alt="client"/>';


if($hover_state == 'true' && !empty($company)) {
	$output .= '<div class="clients-info">';
	$output .= '<div class="clients-info-holder" style="height:'.$dimension.'px;">';
	$output .= '<span class="client-company">'.$company.'</span>';
	$output .= do_shortcode('[pacz_divider style="single" divider_color="rgba(255,255,255,0.4)" divider_width="custom_width" custom_width="35" align="center" thickness="2" margin_top="10" margin_bottom="0"]');
	$output .= '</div></div>';
}

$output .='</a>';
$output .= '</div></li>';
}else if($client_style == 2){
	$output .= '<li class="client-item '.$scroll_stuff[3].'" onClick="return true"><div class="client-item-wrapper" style="'.$border_color_item.';'.$item_height.'">';
	$output .= !empty( $url ) ? '<a target="'.$target.'" href="'.$url.'">' : '';
	$output .= '<img title="'.$company.'" class="client-logo" src="'.pacz_thumbnail_image_gen($image_src_array[0], false, false).'"/>';


	if($hover_state == 'true' && !empty($company)) {
		$output .= '<div class="clients-info">';
		$output .= '<div class="clients-info-holder" style="height:'.$dimension.'px;">';
		$output .= '<span class="client-company">'.$company.'</span>';
		$output .= do_shortcode('[pacz_divider style="single" divider_color="rgba(255,255,255,0.4)" divider_width="custom_width" custom_width="35" align="center" thickness="2" margin_top="10" margin_bottom="0"]');
		$output .= '</div></div>';
	}

	$output .= !empty( $url ) ? '</a>' : '';
	$output .= '</div></li>';
}
endwhile;
wp_reset_postdata();

$output .= '</ul><div class="clearboth"></div></div></div>';


echo '<div>'.$output.'</div>';

// Hidden styles node for head injection after page load through ajax
echo '<div id="ajax-'.$id.'" class="pacz-dynamic-styles">';
echo '<!-- ' . pacz_clean_dynamic_styles($classiadspro_styles) . '-->';
echo '</div>';


// Export styles to json for faster page load
$classiadspro_dynamic_styles[] = array(
  'id' => 'ajax-'.$id ,
  'inject' => $classiadspro_styles
);
