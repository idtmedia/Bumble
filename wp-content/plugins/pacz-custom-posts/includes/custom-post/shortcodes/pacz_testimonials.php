<?php

extract(shortcode_atts(array(
    'style' => 'testimonial1',
    'count' => 10,
    'orderby' => 'date',
    'testimonials' => '',
    'order' => 'DESC',
    'skin' => 'dark',
	'image_width' => '90',
	'image_height' => '90',
    "el_class" => '',
    'font_family' => '',
    'font_size' => '14',
    'line_height' => '26',
    'font_color' => '',
    'font_type' => '',
    'animation' => '',
	'border_radius' => '100',
	'border_bottom' => '3',
    'animation_effect' => 'slide',
	'autoplay' => 'false',
		'tab_landscape_items' =>'' ,
		'tab_items' =>'' ,
		'desktop_items' =>'' ,
		'autoplay_speed' => 2000,
		'delay' => 1000,
		'gutter_space' =>'30',
		'item_loop' => 'false',
		'owl_nav' => 'false',
		'scroll' => 'true',
), $atts));

$id = uniqid();

require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";    

$animation_css = ($animation != '') ? (' pacz-animate-element ' . $animation . ' ') : '';

$output = $final_output = $color = '';

$query = array(
    'post_type' => 'testimonial',
    'showposts' => $count
);

// Get global JSON contructor object for styles and create local variable
global $classiadspro_dynamic_styles, $pacz_settings, $accent_color;
$classiadspro_styles = '';
$before_font_size = $image_height / 5;
if ($style == 'testimonial1' ) {
	$image_width = 100;
	$image_height = 100;
}else if ($style == 'testimonial2' ) {
	$image_width = 90;
	$image_height = 90;
}else if ($style == 'testimonial3' ) {
	$image_width = 90;
	$image_height = 90;
}else if ($style == 'testimonial4' && $desktop_items != 1 ) {
	$image_width = 90;
	$image_height = 90;
}else if ($style == 'testimonial4' && $desktop_items == 1 ) {
	$image_width = 140;
	$image_height = 140;
}else if ($style == 'testimonial5' ) {
	$image_width = 90;
	$image_height = 90;
}else if ($style == 'testimonial6' ) {
	$image_width = 100;
	$image_height = 100;
}
if ($style == 'testimonial2' || $style == 'testimonial3' && $desktop_items == 1 ) {
	
    $classiadspro_styles .= '
 #testimonial-main-'.$id.'.testimonial-main{padding:0 20%;}
 @media handheld, only screen and (max-width: 480px) {
	#testimonial-main-'.$id.'.testimonial-main{padding:0;} 
 }
	';
}
if ($style == 'testimonial1' ) {
	
    $classiadspro_styles .= '
       .testi-thumb{width:'.$image_width.'px;}
	   .testimonial-content{width:100%;height: 100%;overflow: auto;padding:20px 10%;margin:0;position:relative;}
	';
}
if ($style == 'testimonial4' ) {
	
    $classiadspro_styles .= '
       .testi-thumb{width:'.$image_width.'px;}
	   .testimonial-content{width:100%;height: 100%;overflow: auto;padding:20px 10%;margin:0;position:relative;}
	';
}
if ($style == 'testimonial4'  ) {
	
    $classiadspro_styles .= '
       .testi-thumb{width:'.$image_width.'px;}
	   .testimonial-content{width:100%;height: 100%;overflow: auto;padding:20px 10%;margin:0;position:relative;}
	';
}
if ($style == 'testimonial4' && $desktop_items == 1 ) {
	
    $classiadspro_styles .= '
	#testimonial-'.$id.'.testimonial4-style .slide{width:80%;margin:0 auto;}
	#testimonial-'.$id.'.testimonial4-style .testi-thumb{
		width:'.$image_width.'px;
		border:10px solid #fff;
		border-radius:50%;
		-webkit-box-shadow: 0 0 10px rgba(0,0,0,.1);
		-moz-box-shadow: 0 0 10px rgba(0,0,0,.1);
		box-shadow: 0 0 10px rgba(0,0,0,.1);
		left:-70px;
		}
	#testimonial-'.$id.'.testimonial4-style  .testimonial-content{padding:30px 10% 0 15%;margin:0;position:relative;}
	#testimonial-'.$id.'.testimonial4-style .slide .author-details {padding-left: 22%;}	   
	#testimonial-'.$id.'.testimonial4-style .slide .author-details::before {left: 31%;}
	#testimonial-'.$id.'.testimonial4-style .owl-controls { margin-top: 40px;}
	
	@media handheld, only screen and (min-width:601px) and (max-width: 959px) {
		#testimonial-'.$id.'.testimonial4-style .slide .author-details {padding-left: 30%;}	   
		#testimonial-'.$id.'.testimonial4-style .slide .author-details::before {left: 27%;}
	}
	
	@media handheld, only screen and (min-width:320px) and (max-width: 600px) {
		#testimonial-'.$id.'.testimonial4-style .slide .author-details {padding-left:75px;}	   
		#testimonial-'.$id.'.testimonial4-style .slide .author-details::before {left: 20px;font-size:24px;line-height:24px;}
		#testimonial-'.$id.'.testimonial4-style .slide .testimonial-author{font-size:13px;}
		#testimonial-'.$id.'.testimonial4-style .testi-thumb{
		width:'.$image_width.'px;
		border:10px solid #fff;
		border-radius:50%;
		-webkit-box-shadow: 0 0 10px rgba(0,0,0,.1);
		-moz-box-shadow: 0 0 10px rgba(0,0,0,.1);
		box-shadow: 0 0 10px rgba(0,0,0,.1);
		left:0;
		right:0;
		top:-90px;
		}
		.testimonial4-style .owl-item {
			padding: 100px 0 0;
		}
		
	}
	';
}
if ($style == 'testimonial6' ) {
	
    $classiadspro_styles .= '
       .testi-thumb{float:left; width:'.$image_width.'px;}
	   .testimonial-content{float:left;
		width:-moz-calc(100% - '.$image_width.'px);
		width: -webkit-calc(100% - '.$image_width.'px);
		width: -o-calc(100% - '.$image_width.'px);
		width: calc(100% - '.$image_width.'px);
		height: calc('.$image_height.'px - 90px);
		overflow: auto;
		padding:0 10%;
		margin:45px 0;
		background:#fff;
		position:relative;
		}
        .pacz-testimonial.boxed-style .testimonial-content:before,
		.pacz-testimonial.boxed-style .testimonial-content:after{font-size:'.$before_font_size.'px;position:absolute;}
		.pacz-testimonial.boxed-style .owl-nav{top:0;}
        ';
}
if ( $style == 'modern') {
	
    $classiadspro_styles .= '
		.pacz-testimonial.modern-style .owl-item{padding-bottom:50px;}
		.pacz-testimonial.modern-style .slide{padding:50px 30px 40px;background:#fff;position:relative;}
       .testi-thumb{ float:right;width:100px;position:absolute;bottom:-50px;right:30px;border-radius:50%;overflow:hidden;}
	   .testimonial-content{
		width: 100%;
		height: 100%;
		margin-bottom:30px;
		position:relative;
		}
		.author-details{float:left;}
		.testimonial-quote{font-size:'.$font_size.';}
        .pacz-testimonial.modern-style .testimonial-content:before{display:none;}
		.pacz-testimonial.modern-style .testimonial-content:after{font-size:36px;position:absolute;bottom:-25px;right:25px;}
		.testimonial-author{display:inline-block !important;padding-right:10px;font-size:16px;text-transform:capitalize;}
		.pacz-testimonial.modern-style .owl-nav{top:-12px;}
        ';
}
if ( $style == 'creative') {
	
    $classiadspro_styles .= '
		
		.owl-item{}
		.slide{padding:30px;background:#fff;position:relative;border-bottom:'.$border_bottom.'px solid;}
       .testi-thumb{float:none; width:150px;margin:0 auto 30px;}
	   .testi-thumb img{border-radius:'.$border_radius.'px;}
	   .testimonial-content{
		float:none;
		width:100%;
		height: 100%;
		padding:0;
		position:relative;
		}
		.author-details{margin-top:0;}
		.testimonial-quote{font-size:'.$font_size.';padding:50px 0;}
		.pacz-testimonial.creative-style .testimonial-content:before{font-size:24px;position:absolute;left:0;}
		.pacz-testimonial.creative-style .testimonial-content:after{font-size:24px;position:absolute;right:0;bottom:0;}
		.testimonial-author{display:block !important;font-size:16px;text-transform:capitalize;}
        ';
}
if ($testimonials) {
    $query['post__in'] = explode(',', $testimonials);
}

if ($orderby) {
    $query['orderby'] = $orderby;
}

if ($order) {
    $query['order'] = $order;
}

$loop = new WP_Query($query);

$output .= '<div id="testimonial-'.$id.'" class="pacz-testimonial ' . $style . '-style ' . $animation_css . ' ' . $el_class . '"><div class="owl-carousel" data-items="'.$desktop_items.'" data-items-tab-ls="'.$tab_landscape_items.'" data-items-tab="'.$tab_items.'" data-autoplay="'.$autoplay.'" data-gutter="'.$gutter_space.'" data-autoplay-speed="'.$autoplay_speed.'" data-delay="'.$delay.'" data-loop="'.$item_loop.'" data-nav="'.$owl_nav.'" data-style="'.$style.'">';

while ($loop->have_posts()):
    $loop->the_post();
    $url     = get_post_meta(get_the_ID(), '_url', true);
    $company = get_post_meta(get_the_ID(), '_company', true);
	$position = get_post_meta(get_the_ID(), '_position', true);

    $content_color = ($style == 'testimonial1' || $style == 'testimonial6' || $style == 'modern') ? ('color:'.$font_color.';') : '' ;
    
    if ($style == 'testimonial1') {
        $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
        $image_src       = bfi_thumb($image_src_array[0], array(
            'width' => $image_width,
            'height' => $image_height,
            'crop' => true
        ));
        $output .= '<div class="slide clearfix">';
		$output .= '<div class="testimonial-content clearfix">';
        $output .= '<div class="testimonial-quote" style="font-size:'.$font_size.'px; line-height:'.$line_height.'px; '.$content_color.'">' . get_post_meta(get_the_ID(), '_desc', true);
        $output .= '</div>';
		$output .= '<div class="testi-bottom-left pull-left clearfix">';
		$output .= '<div class="testi-thumb pull-right">';
		$output .= '<img class="testimonial-image" src="' . pacz_thumbnail_image_gen($image_src, $image_width, $image_height) . '" alt="' . strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '" />';
        $output .= '</div>';
		$output .= '</div>';
		$output .= '<div class="testi-bottom-right pull-left clearfix">';
        $output .= '<p class="testimonial-author">' . strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '</p>';
		$output .= '<div class="author-details pull-left">';
		$output .= !empty($position) ? ('<span class="testimonial-position">' . strip_tags(get_post_meta(get_the_ID(), '_position', true)) . ' '.esc_html__(',', 'pacz').'</span>') : '';
		$output .= !empty($company) ? ('<a target="_blank" ' . (!empty($url) ? ('href="' . $url . '"') : '') . ' class="testimonial-company">' . strip_tags($company) . '</a>') : '';
        $output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
        $output .= '</div>';
    }else if ($style == 'testimonial2') {
        $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
        $image_src       = bfi_thumb($image_src_array[0], array(
            'width' => $image_width,
            'height' => $image_height,
            'crop' => true
        ));
        $output .= '<div class="slide clearfix">';
		$output .= '<div class="testi-thumb">';
		$output .= '<img class="testimonial-image" src="' . pacz_thumbnail_image_gen($image_src, $image_width, $image_height) . '" alt="' . strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '" />';
        $output .= '</div>';
		 $output .= ($style == 'modern') ? '<h5 class="testimonial-author" style="color:'.$font_color.'">'. strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '</h5>' : '<h5 class="testimonial-author">' . strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '</h5>';
		$output .= '<div class="author-details">';
		$output .= !empty($position) ? ('<span class="testimonial-position">' . strip_tags(get_post_meta(get_the_ID(), '_position', true)) . ' '.esc_html__(',', 'pacz').'</span>') : '';
		$output .= !empty($company) ? ('<a target="_blank" ' . (!empty($url) ? ('href="' . $url . '"') : '') . ' class="testimonial-company">' . strip_tags($company) . '</a>') : '';
        $output .= '</div>';
		$output .= '<div class="testimonial-content">';
        $output .= '<div class="testimonial-quote" style="font-size:'.$font_size.'px; line-height:'.$line_height.'px; '.$content_color.'">' . get_post_meta(get_the_ID(), '_desc', true);
        $output .= '</div>';
		$output .= '</div>';
        $output .= '</div>';
    }else if ($style == 'testimonial3') {
        $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
        $image_src       = bfi_thumb($image_src_array[0], array(
            'width' => $image_width,
            'height' => $image_height,
            'crop' => true
        ));
        $output .= '<div class="slide clearfix">';
		$output .= '<div class="testi-thumb">';
		$output .= '<img class="testimonial-image" src="' . pacz_thumbnail_image_gen($image_src, $image_width, $image_height) . '" alt="' . strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '" />';
        $output .= '</div>';
		$output .= '<div class="author-details">';
		 $output .= ($style == 'modern') ? '<h5 class="testimonial-author" style="color:'.$font_color.'">'. strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '</h5>' : '<h5 class="testimonial-author">' . strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '</h5>';
		$output .= !empty($position) ? ('<span class="testimonial-position">' . strip_tags(get_post_meta(get_the_ID(), '_position', true)) . ' '.esc_html__(',', 'pacz').'</span>') : '';
		$output .= !empty($company) ? ('<a target="_blank" ' . (!empty($url) ? ('href="' . $url . '"') : '') . ' class="testimonial-company">' . strip_tags($company) . '</a>') : '';
        $output .= '</div>';
		$output .= '<div class="testimonial-content">';
        $output .= '<div class="testimonial-quote" style="font-size:'.$font_size.'px; line-height:'.$line_height.'px; '.$content_color.'">' . get_post_meta(get_the_ID(), '_desc', true);
        $output .= '</div>';
		$output .= '</div>';
        $output .= '</div>';
    }else if ($style == 'testimonial4') {
        $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
        $image_src       = bfi_thumb($image_src_array[0], array(
            'width' => $image_width,
            'height' => $image_height,
            'crop' => true
        ));
        $output .= '<div class="slide clearfix">';
		$output .= '<div class="testi-thumb">';
		$output .= '<img class="testimonial-image" src="' . pacz_thumbnail_image_gen($image_src, $image_width, $image_height) . '" alt="' . strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '" />';
        $output .= '</div>';
		$output .= '<div class="author-details">';
		 $output .= ($style == 'modern') ? '<h5 class="testimonial-author" style="color:'.$font_color.'">'. strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '</h5>' : '<h5 class="testimonial-author">' . strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '</h5>';
		$output .= !empty($position) ? ('<span class="testimonial-position">' . strip_tags(get_post_meta(get_the_ID(), '_position', true)) . ' '.esc_html__(',', 'pacz').'</span>') : '';
		$output .= !empty($company) ? ('<a target="_blank" ' . (!empty($url) ? ('href="' . $url . '"') : '') . ' class="testimonial-company">' . strip_tags($company) . '</a>') : '';
        $output .= '</div>';
		$output .= '<div class="testimonial-content">';
        $output .= '<div class="testimonial-quote" style="font-size:'.$font_size.'px; line-height:'.$line_height.'px; '.$content_color.'">' . get_post_meta(get_the_ID(), '_desc', true);
        $output .= '</div>';
		$output .= '</div>';
        $output .= '</div>';
    }else if ($style == 'modern') {
        $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
        $image_src       = bfi_thumb($image_src_array[0], array(
            'width' => 100,
            'height' => 100,
            'crop' => true
        ));
        $output .= '<div class="slide clearfix">';
		
		$output .= '<div class="testimonial-content">';
        $output .= '<div class="testimonial-quote" style="font-size:'.$font_size.'px; line-height:'.$line_height.'px; '.$content_color.'">' . get_post_meta(get_the_ID(), '_desc', true);
        $output .= '</div></div>';

		$output .= '<div class="author-details">';
		$output .= ($style == 'modern') ? '<h5 class="testimonial-author" style="color:'.$font_color.'">'. strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '</h5>' : '<h5 class="testimonial-author">' . strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '</h5>';
		$output .= !empty($position) ? ('<span class="testimonial-position">' . strip_tags(get_post_meta(get_the_ID(), '_position', true)) . ' '.esc_html__(',', 'pacz').'</span>') : '';
		$output .= !empty($company) ? ('<a target="_blank" ' . (!empty($url) ? ('href="' . $url . '"') : '') . ' class="testimonial-company">' . strip_tags($company) . '</a>') : '';
        $output .= '</div>';
		$output .= '<div class="testi-thumb">';
		$output .= '<img class="testimonial-image" src="' . pacz_thumbnail_image_gen($image_src, 100, 100) . '" alt="' . strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '" />';
        $output .= '</div>';
		$output .= '<div class="clearboth"></div>';
        $output .= '</div>';
    }else if ($style == 'creative') {
        $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
        $image_src       = bfi_thumb($image_src_array[0], array(
            'width' => 150,
            'height' => 150,
            'crop' => true
        ));
        $output .= '<div class="slide clearfix">';
		$output .= '<div class="testi-thumb">';
		$output .= '<img class="testimonial-image" src="' . pacz_thumbnail_image_gen($image_src, 120, 120) . '" alt="' . strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '" />';
        $output .= '</div>';
		$output .= '<div class="testimonial-content">';
        $output .= '<div class="testimonial-quote" style="font-size:'.$font_size.'px; line-height:'.$line_height.'px; '.$content_color.'">' . get_post_meta(get_the_ID(), '_desc', true);
        $output .= '</div>';
		$output .= '</div><div class="clearboth"></div>';
		
		$output .= '<div class="author-details">';
		$output .= ($style == 'modern') ? '<h5 class="testimonial-author" style="color:'.$font_color.'">'. strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '</h5>' : '<h5 class="testimonial-author">' . strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '</h5>';
		$output .= !empty($position) ? ('<span class="testimonial-position">' . strip_tags(get_post_meta(get_the_ID(), '_position', true)) . ' '.esc_html__(',', 'pacz').'</span>') : '';
		$output .= !empty($company) ? ('<a target="_blank" ' . (!empty($url) ? ('href="' . $url . '"') : '') . ' class="testimonial-company">' . strip_tags($company) . '</a>') : '';
        $output .= '</div>';
        $output .= '</div>';
    }else{
        
        $output .= '<div class="swiper-slide">';
        $output .= '<div class="testimonial-quote" style="font-size:'.$font_size.'px; line-height:'.$line_height.'px; '.$content_color.'">' . get_post_meta(get_the_ID(), '_desc', true) . '</div>';
        $output .= '<div class="testimonial-footer-note">';
        $output .= '<span class="testimonial-author">' . strip_tags(get_post_meta(get_the_ID(), '_author', true)) . '</span>';
        $output .= !empty($company) ? ('<a target="_blank" ' . (!empty($url) ? ('href="' . $url . '"') : '') . ' class="testimonial-company">' . strip_tags($company) . '</a>') : '';
        $output .= '</div>';
        $output .= '</div>';
        
    }
endwhile;

wp_reset_query();
$output .= '</div></div>';


echo '<div id="testimonial-main-'.$id.'" class="testimonial-main">'.$output.'</div>';




// Hidden styles node for head injection after page load through ajax
echo '<div id="ajax-'.$id.'" class="pacz-dynamic-styles">';
echo '<!-- ' . pacz_clean_dynamic_styles($classiadspro_styles) . '-->';
echo '</div>';


// Export styles to json for faster page load
$classiadspro_dynamic_styles[] = array(
  'id' => 'ajax-'.$id ,
  'inject' => $classiadspro_styles
);

