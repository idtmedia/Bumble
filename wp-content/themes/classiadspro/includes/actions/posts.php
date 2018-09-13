<?php
/**
 *
 * @author  Muhammad Asif
 * @copyright Copyright (c) Muhammad Asif
 * @link  http://designinvento.net
 * @since  Version 2.0
 * @package  CLASSIADSPRO Framework
 */


add_action('blog_related_posts', 'pacz_blog_related_posts');





if ( !function_exists( 'pacz_blog_related_posts' ) ) {
	function pacz_blog_related_posts( $layout ) {
		global $post, $pacz_settings;

		if($pacz_settings['blog-single-related-posts'] == 0 ) return;

		$output = '';
		$width = 259;
		$height = 161;

		if ( $layout == 'full' ) {
			$showposts = 4;
			$column_css = 'four-column';
		} else {
			$showposts = 3;
			$column_css = 'three-column';
		}

		$related = pacz_get_related_posts( $post->ID, $showposts, true );
		if ( $related->have_posts() ) {
				$output .= '<section class="blog-similar-posts">';

				$output .=  '<div class="single-post-fancy-title"><span>'.esc_html__( 'Related Posts', 'classiadspro' ).'</span></div>';

				$output .= '<ul class="'.$column_css.'">';
				while ( $related->have_posts() ) {
					$related->the_post();
					$post_type = get_post_format( get_the_id()) ? get_post_format( get_the_id()) : 'image';
					$output .= '<li><div class="item-holder">';
					$output .= '<a class="pacz-similiar-thumbnail" href="' . get_permalink() . '" title="' . get_the_title() . '">';
					if ( has_post_thumbnail() ) {
						$image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
						$image_src = bfi_thumb( $image_src_array[ 0 ], array('width' => $width, 'height' => $height, 'crop'=>true));
						$output .= '<img width="'.$width.'" height="'.$height.'" src="' .pacz_thumbnail_image_gen($image_src, $width, $height) . '" alt="' . get_the_title() . '" />';
					}

					$output .= '<i class="pacz-icon-plus post-hover-icon"></i><div class="hover-overlay"></div></a>';
					$output .= '<a href="'.get_permalink().'" class="pacz-similiar-title">'.get_the_title().'</a>';

					$output .= '</div></li>';

				}
				$output .= '</ul>';
				$output .= '<div class="clearboth"></div></section>';
			}
		wp_reset_postdata();
		echo '<div>'.$output.'</div>';
	}
	/*-----------------*/
}

