<?php

function blog_classic_style($atts)
{
    global $post, $pacz_settings;
    extract($atts);

    $output = $item_cat = '';

    if ($layout == 'full') {
        $image_width = $grid_width - 40;
    } else {
        $image_width = (($content_width / 100) * $grid_width) - 40;
    }

    $categories = get_the_category();

    foreach ($categories as $category) {
        $item_cat .= 'category-' . $category->slug . ' ';
    }
if(is_home()){
	$image_height = $pacz_settings['blog-single-image-height'];
}

    $post_type = (get_post_format(get_the_id()) == '0' || get_post_format(get_the_id()) == '') ? 'image' : get_post_format(get_the_id());

require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php"; 
if(is_sticky()){
    $output .= '<article id="entry-' . get_the_ID() . '" class="blog-classic-entry sticky-post classic-'.$item_id.' pacz-isotop-item ' . $item_cat . '">';
}else{
	 $output .= '<article id="entry-' . get_the_ID() . '" class="blog-classic-entry classic-'.$item_id.' pacz-isotop-item ' . $item_cat . '">';
}
    switch ($post_type) {



        /* Image Post Type */
        case 'image':
            $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
            //if($cropping == 'true') {
                $image_src = bfi_thumb($image_src_array[0], array(
                'width' => $image_width,
                'height' => $image_height,
                'crop' => true
                ));
            //} else {
                //$image_src = $image_src_array[0];
            //}
            if (has_post_thumbnail()) {
                $output .= '<div class="featured-image" onClick="return true">';
                $output .= '<img alt="' . get_the_title() . '" width="' . $image_width . '" class="item-featured-image" height="' . $image_height . '" title="' . get_the_title() . '" src="' . pacz_thumbnail_image_gen($image_src, $image_width, $image_height) . '" itemprop="image" />';
                $output .= '<div class="hover-overlay"></div>';
                $output .= '</div>';
            }
            break;
        /***********/

        case 'aside':
            /* There is nothing to output */
            break;

        /* Gallery Post Type */
        case 'gallery':
            //$attachment_ids = get_post_meta(get_the_id(), '_gallery_images', true);
            //$output .= '<div class="blog-gallery-type">';
           // $output .= do_shortcode('[pacz_image_slideshow images="' . $attachment_ids . '" margin_bottom="0" image_width="' . $image_width . '" image_height="' . $image_height . '" effect="slide" animation_speed="700" slideshow_speed="7000" pause_on_hover="false" direction_nav="true"]');
           // $output .= '</div>';

            break;
        /***********/

        /* Video Post Type */
        case 'video':

            //$link = get_post_meta($post->ID, '_video_url', true);

           // if ($link) {
              //  global $wp_embed;
              //  $output .= '<div class="pacz-video-wrapper"><div class="pacz-video-container">' . $wp_embed->run_shortcode('[embed]' . $link . '[/embed]') . '</div></div>';
           // }
            break;
        /***********/


        /* Audio Post Type */
        case 'audio':
           /* wp_enqueue_script('jquery-jplayer');
            $audio_id = mt_rand(99, 999);
            $mp3_file = get_post_meta($post->ID, '_mp3_file', true);
            $ogg_file = get_post_meta($post->ID, '_ogg_file', true);
            $iframe   = get_post_meta($post->ID, '_audio_iframe', true);


            if (empty($iframe)) {
                $output .= '<div class="pacz-audio">
				        <div id="jquery_jplayer_' . $audio_id . '" data-mp3="' . $mp3_file . '" data-ogg="' . $ogg_file . '" class="jp-jplayer pacz-blog-audio"></div>
				        <div id="jp_container_' . $audio_id . '" class="jp-audio">
				            <div class="jp-type-single">
				                    <div class="jp-gui jp-interface">
				                        <ul class="jp-controls">
				                            <li><a href="javascript:;" class="jp-play" tabindex="1"><i class="pacz-theme-icon-next-big"></i></a></li>
				                            <li><a href="javascript:;" class="jp-pause" tabindex="1"><i class="pacz-icon-pause"></i></a></li>
				                        </ul>
				                        <div class="jp-progress">
				                            <div class="jp-seek-bar">
				                                <div class="jp-play-bar"></div>
				                            </div>
				                        </div>
				                        <div class="js-volume-wrapper">
				                        <div class="jp-volume-bar">
				                            <div class="inner-value-adjust"><div class="jp-volume-bar-value"></div></div>
				                        </div>
				                        </div>
				                       <div class="clearboth"></div>
				                    </div>
				                </div>
            		</div></div>';
            } else {
                $output .= '<div class="audio-iframe">' . $iframe . '</div>';
            }*/

            break;
        default:
            $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
            if($cropping == 'true') {
                $image_src = bfi_thumb($image_src_array[0], array(
                'width' => $image_width,
                'height' => $image_height,
                'crop' => true
                ));
            } else {
                $image_src = $image_src_array[0];
            }
            if (has_post_thumbnail()) {
                $output .= '<div class="featured-image"><a title="' . get_the_title() . '" href="' . get_permalink() . '">';
                $output .= '<img alt="' . get_the_title() . '" title="' . get_the_title() . '" class="item-featured-image" width="' . $image_width . '" height="' . $image_height . '" src="' . $image_src . '" itemprop="image" />';
                $output .= '<div class="hover-overlay"></div>';
                $output .= '<i class="pacz-theme-icon-plus hover-plus-icon"></i>';
                $output .= '</a></div>';
            }
            break;

    }

    /* Blog Heading */
	
    
    $output .= '<div class="blog-entry-heading">';
    $output .= '<h2 class="blog-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
    $output .= '</div>';
	
	/* Blog Meta */
    
        $output .= '<div class="blog-meta">';
        $output .= '<time datetime="' . get_the_date() . '" itemprop="datePublished" pubdate>';
        $output .= '<a href="' . get_month_link(get_the_time("Y"), get_the_time("m")) . '">' . get_the_date() . '</a>';
        $output .= '</time>';
        //$output .= '<div class="blog-categories">' . get_the_category_list(', ') . '</div>';
		$output .= '<div class="blog-author">'.esc_html__('posted by:', 'classiadspro').'<span>'. get_the_author() .'</span></div>';
		ob_start();
    comments_number(esc_html__('0', 'classiadspro'), esc_html__('1', 'classiadspro'), esc_html__('%', 'classiadspro'));
    $output .= '<a href="' . get_permalink() . '#comments" class="blog-comments">' . ob_get_clean() .'<span>'. esc_html__('Comments', 'classiadspro'). '</span></a>';
	
    //if (function_exists('pacz_love_this')) {
        //ob_start();
       // pacz_love_this();
        //$output .= '<div class="pacz-love-holder">' . ob_get_clean() . '</div>';
    //}
        $output .= '<div class="clearboth"></div></div>';
    
    /***********/




    
    /***********/



$classic_excerpt = 'excerpt';
    if ($classic_excerpt == 'excerpt') {
		$excerpt_length = 370;
        if($excerpt_length != 0) {
            ob_start();
            the_excerpt_max_charlength($excerpt_length);
            $output .= '<div class="blog-excerpt">' . ob_get_clean() . '</div>';
        }

    } else {
        $content = str_replace(']]>', ']]&gt;', apply_filters('the_content', get_the_content()));
        $output .= '<div class="blog-excerpt">' . $content . '</div>';
    }

	$output .= '<div class="blog-readmore-btn"><a class="dynamic-btn" title="'.get_the_title().'" href="'.get_permalink().'">'.esc_html__("Read More","classiadspro").'</a></div>';
    $output .= '</article>';


    return $output;

}
