<?php

function blog_tile_style( $atts, $i) {
	global $post;
	extract( $atts );

	switch ( $column ) {
			case 1 :
			if ( $layout=='full' ) {
				//$image_width = round($grid_width - 87);
			}else {
				//$image_width = round((($content_width / 100) * $grid_width) - 87);
			}
			$pacz_column_css = 'one-column';
		break;
		case 2 :
			if ( $layout=='full' ) {
				//$image_width = round($grid_width/2 - 67);
			}else {
				//$image_width = round((($content_width / 100) * $grid_width)/2 - 67);
			}
			$pacz_column_css = 'two-column';
		break;

		case 3 :
			//$image_width = $grid_width/3 - 64;
			$pacz_column_css = 'three-column';
		break;

		case 4 :
			//$image_width = $grid_width/4 - 49;
			$pacz_column_css = 'four-column';
		break;
		default :
			//$image_width = $grid_width/3 - 64;
			$pacz_column_css = 'three-column';
		break;
	}

	$output = $blog_heading = '';

	$post_type = (get_post_format( get_the_id()) == '0' || get_post_format( get_the_id()) == '') ? 'image' : get_post_format( get_the_id());



//if($i%2 != 0 && $item_row == 2) {
	$output .='<article id="entry-'.get_the_ID().'" class="blog-tile-entry tile-'.$item_id.' pacz-isotop-item '.$pacz_column_css.' '.$post_type.'-post-type">';
//}
	$output .= '<div class="item-holder">';


	/* Blog Heading */
	$blog_heading .= '<div class="blog-entry-heading">';
	$blog_heading .= '<h5 class="blog-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h5>';
	$blog_heading .= '</div>';
	/***********/

	if($post_type == 'audio') {
		$output .= $blog_heading;
	}


	switch ($post_type) {


		/* Image Post Type */
		case 'image':
		$image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
		if($cropping == 'true') {
                $image_src = bfi_thumb($image_src_array[0], array(
                'width' => $image_width,
                'height' => $image_height,
                'crop' => true
                ));
            } else {
                $image_src = $image_src_array[0];
            }
		if ( has_post_thumbnail() ) {
			$output .='<div class="featured-image"><div class="grid-image-inner">';
				$output .='<img alt="'.get_the_title().'" class="item-featured-image" width="'.$image_width.'" height="'.$image_height.'" title="'.get_the_title().'" src="'.pacz_thumbnail_image_gen($image_src, $image_width, $image_height).'" itemprop="image" />';
				$output .='<div class="hover-overlay"></div>';
			$output .='</div></div>';
		}
			break;
		/***********/

		case 'aside':
			/* There is nothing to output */
		break;


		/* Gallery Post Type */
		case 'gallery':
			$attachment_ids = get_post_meta( get_the_id(), '_gallery_images', true );
			$output .='<div class="blog-gallery-type">';
			$output .= do_shortcode( '[pacz_image_slideshow images="'.$attachment_ids.'" margin_bottom="0" image_width="'.$image_width.'" image_height="'.$image_height.'" resposnive="true" effect="slide" animation_speed="700" slideshow_speed="7000" pause_on_hover="false" direction_nav="true"]' );
			$output .='</div>';

			break;
		/***********/



		/* Video Post Type */
		case 'video' :

		$link = get_post_meta( $post->ID, '_video_url', true );

		if ( $link) {
			global $wp_embed;
			$output .= '<div class="pacz-video-wrapper"><div class="pacz-video-container">'.$wp_embed->run_shortcode( '[embed]'.$link.'[/embed]' ).'</div></div>';
		}
		break;
		/***********/


		/* Audio Post Type */
		case 'audio' :
		$audio_id = mt_rand( 99, 999 );
		$mp3_file  = get_post_meta( $post->ID, '_mp3_file', true );
		$ogg_file  = get_post_meta( $post->ID, '_ogg_file', true );
		$iframe  = get_post_meta( $post->ID, '_audio_iframe', true );


		if(empty($iframe)) {
		$output .= '<div class="pacz-audio">
				        <div id="jquery_jplayer_'.$audio_id.'" data-mp3="'.$mp3_file.'" data-ogg="'.$ogg_file.'" class="jp-jplayer pacz-blog-audio"></div>
				        <div id="jp_container_'.$audio_id.'" class="jp-audio">
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
        	$output .= '<div class="audio-iframe">'.$iframe.'</div>';
        }

		break;

		default :
		$image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
		if($cropping == 'true') {
                $image_src = bfi_thumb($image_src_array[0], array(
                'width' => $image_width,
                'height' => $image_height,
                'crop' => true
                ));
            } else {
                $image_src = $image_src_array[0];
            }
		if ( has_post_thumbnail() ) {
			$output .='<div class="featured-image"><a href="'.get_permalink().'">';
				$output .='<img alt="'.get_the_title().'" width="'.$image_width.'" class="item-featured-image" height="'.$image_height.'" title="'.get_the_title().'" src="'.$image_src.'" itemprop="image" />';
				$output .='<div class="hover-overlay"></div>';
				$output .= '<i class="pacz-theme-icon-plus hover-plus-icon-xsmall"></i>';
			$output .='</a></div>';
		}
		break;
	}
	/*
	if($author != 'false') {
	global $user;
		$output .= '<div class="blog-avatar">'.get_avatar( get_the_author_meta('email'), '50',false ,get_the_author_meta('display_name', $user['ID'])).'</div>';
	}*/

	if($post_type != 'audio') {
		$output .= $blog_heading;
	}
	/* Blog Meta */
	if($disable_meta != 'false') {
		//$output .= '<div class="blog-meta">';
			$output .='<span class="metatime" itemprop="datePublished">';
			$output .='<a href="'.get_month_link( get_the_time( "Y" ), get_the_time( "m" ) ).'">'.get_the_date().'</a>';
			$output .='</span>';
			//$output .='<div class="blog-categories">'.get_the_category_list( ', ' ).'</div>';
			/*if($column != 4) {
				ob_start();
				comments_number(esc_html__( '0', 'classiadspro' ), esc_html__( '1', 'classiadspro' ), esc_html__( '%', 'classiadspro' ));
				$output .= '<a href="'.get_permalink().'#comments" class="blog-comments"><i class="pacz-icon-comment"></i> '.ob_get_clean().'</a>';

				if( function_exists('pacz_love_this') ) {
					ob_start();
					pacz_love_this();
					$output .= '<div class="pacz-love-holder">'.ob_get_clean().'</div>';
				}
			}*/
		//$output .= '<div class="clearboth"></div></div>';
	}
	/***********/
	if($excerpt_length != 0) {
		ob_start();
	    the_excerpt_max_charlength($excerpt_length);
	    $output .= '<div class="blog-excerpt">' . ob_get_clean() . '</div>';
	}
	$output .= '<div class="blog-readmore-btn"><a class="dynamic-btn" title="'.get_the_title().'" href="'.get_permalink().'">'.esc_html__("Read More","classiadspro").'<i class="pacz-icon-long-arrow-right"></i></a></div>';
	$output .='</div>';
	//if($i%2 == 0 && $item_row == 2) {
	$output .='</article>';
	//}
	return $output;
}
