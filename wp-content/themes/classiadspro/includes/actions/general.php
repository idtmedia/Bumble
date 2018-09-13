<?php
/**
 *
 *
 * @author  DesignInvento
 * @copyright Copyright (c) DesignInvento
 * @link  http://designinvento.net
 * @since  Version 1.0
 * @package  CLASSIADSPRO Framework
 */


add_action( 'page_title', 'pacz_page_title' );

add_action( 'subfooter_social', 'pacz_subfooter_social' );
add_action( 'theme_breadcrumbs', 'pacz_theme_breadcrumbs' );
add_action( 'subfooter_logos', 'pacz_subfooter_logos' ); 
add_action( 'topfooter_subscribe', 'pacz_topfooter_subscribe' ); 




if ( !function_exists( 'pacz_page_title' ) ) {
	
	function pacz_page_title() {
		global $pacz_settings,$event_id,$post,$page_id,$event;
		
		$post_id = global_get_post_id();

		$title = $breadcrumb = $intro = $fullHeight ='';
		$align = 'left';
		if ($post_id) {
			$template = get_post_meta( $post_id, '_template', true );
			$breadcrumb = get_post_meta( $post_id, '_breadcrumb', true );
			$intro = get_post_meta( $post_id, '_page_title_intro', true );
			$fullHeight = get_post_meta( $post_id, '_page_title_fullHeight', true );
			$align = ($align != '') ? $align : 'center';

			if ( $template == 'no-title' ) return false;
			$title = get_the_title( $post_id );
		}
		if ( get_post_type('alsp_listing')){
			
			$title = esc_html__( 'Search', 'classiadspro' );
		}
		if(is_archive() && $pacz_settings['archive-page-title'] == 0) return false;
		
		if(is_home() && get_option('page_for_posts')){
			
			$title = get_the_title( get_option('page_for_posts', true) );
			
			
		}elseif(is_home()){
			$title = esc_html__( 'OUR Blog', 'classiadspro' );
		}
		if(function_exists( 'is_woocommerce' ) && is_woocommerce() && is_shop() && $pacz_settings['woo-shop-loop-title'] == 0) return false;

		if(function_exists( 'is_woocommerce' ) && is_woocommerce() && is_singular('product') && $pacz_settings['woo-single-show-title'] == 0) return false;

		if(is_singular('post')) {
			if (isset($pacz_settings['page-title-blog']) && $pacz_settings['page-title-blog'] == 0 ) return false;
			if (isset($pacz_settings['page-title-blog']) && $pacz_settings['page-title-blog'] == 1 ) {
				$title = esc_html__( 'Latest News', 'classiadspro' );
			}
		}
		if ( is_search() ) {
			$title = esc_html__( 'Search', 'classiadspro' );
		}
		if ( is_archive() ) {
			if ( is_category() ) {
				$title = sprintf( esc_html__( ' %s', 'classiadspro' ), single_cat_title( '', false ) );
			}
			elseif ( is_tag() ) {
				$title = sprintf( esc_html__( ' %s', 'classiadspro' ), single_tag_title( '', false ) );
			}
			elseif ( is_day() ) {
				$title = sprintf( esc_html__( ' %s', 'classiadspro' ), get_the_time( 'F jS, Y' ) );
			}
			elseif ( is_month() ) {
				$title = sprintf( esc_html__( '%s', 'classiadspro' ), get_the_time( 'F, Y' ) );
			}
			elseif ( is_year() ) {
				$title = sprintf( esc_html__( ' %s', 'classiadspro' ), get_the_time( 'Y' ) );
			}
			elseif ( is_author() ) {
				if ( get_query_var( 'author_name' ) ) {
					$curauth = get_user_by( 'slug', get_query_var( 'author_name' ) );
				}
				else {
					$curauth = get_userdata( get_query_var( 'author' ) );
				}
				$title = sprintf( esc_html__( ' %s', 'classiadspro' ), $curauth->nickname );
			}
			elseif ( is_tax() ) {
				$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
				$title = sprintf( esc_html__( ' %s', 'classiadspro' ), $term->name );
			}
		}

		if ( is_404() ) {
			$title = esc_html__('404 Not Found', 'classiadspro');

		}
		
		
		if ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
			if ( bbp_is_forum_archive() ) {
				$title = bbp_get_forum_archive_title();

			} elseif ( bbp_is_topic_archive() ) {
				$title = bbp_get_topic_archive_title();

			} elseif ( bbp_is_single_view() ) {
				$title = bbp_get_view_title();
			} elseif ( bbp_is_single_forum() ) {

				$forum_id = get_queried_object_id();
				$forum_parent_id = bbp_get_forum_parent_id( $forum_id );

				if ( 0 !== $forum_parent_id )
					$title = array_merge( $item, breadcrumbs_plus_get_parents( $forum_parent_id ) );

				$title = bbp_get_forum_title( $forum_id );
			}
			elseif ( bbp_is_single_topic() ) {
				$topic_id = get_queried_object_id();
				$title = bbp_get_topic_title( $topic_id );
			}

			elseif ( bbp_is_single_user() || bbp_is_single_user_edit() ) {
				$title = bbp_get_displayed_user_field( 'display_name' );
			}
		}


		if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			if(is_single() && isset($pacz_settings['woo-single-title']) && $pacz_settings['woo-single-title'] == 1) {
				$terms = get_the_terms( $post_id, 'product_cat' );
				if(is_array($terms) && $terms != null) {
				foreach ($terms as $term) {
				    $product_category = $term->name;
				    break;
				}
					$title = $product_category;
				} else {
					ob_start();
					woocommerce_page_title();
					$title = ob_get_clean();
				}
			} else {
				ob_start();
				woocommerce_page_title();
				$title = ob_get_clean();
			}


		}

		echo '<section id="pacz-page-title" class="'.$align.'-align" data-intro="'.$intro.'" data-fullHeight="'.$fullHeight.'">';
		echo '<div class="pacz-page-title-bg"></div>';
		echo '<div class="pacz-effect-gradient-layer"></div>';
		echo '<div class="pacz-grid">';
		if ( function_exists( 'is_woocommerce' ) && is_woocommerce() && is_single() ) {
			echo '<h2 class="pacz-page-heading">' . $title . '</h2>';
		} else {
			echo '<h1 class="pacz-page-heading">' . $title . '</h1>';
		}
		

		if ( $pacz_settings['breadcrumb'] != 0 ) {
			if ( $breadcrumb != 'false' ) {
				do_action( 'theme_breadcrumbs');
			}
		}

		echo '<div class="clearboth"></div></div></section>';


	}

}



if(!function_exists('pacz_theme_breadcrumbs')):
function pacz_theme_breadcrumbs() {
        global $pacz_settings, $post;
		$output = '';

		$post_id = global_get_post_id();

		$breadcrumb_skin = (isset($pacz_settings['breadcrumb-skin']) && !empty($pacz_settings['breadcrumb-skin'])) ? $pacz_settings['breadcrumb-skin'].'-skin' : 'dark-skin';
		if($post_id) {
			$enable = get_post_meta($post_id, '_custom_bg', true);
			if ($enable == 'true') {
				$single_breadcrumb = get_post_meta( $post_id, '_breadcrumb_skin', true );
				$breadcrumb_skin = !empty($single_breadcrumb) ?  ($single_breadcrumb . '-skin') : $breadcrumb_skin;
			}
		}


		$delimiter =  ' &#47; ';

        echo '<div id="pacz-breadcrumbs"><div class="pacz-breadcrumbs-inner '.$breadcrumb_skin.'">';

        if ( !is_front_page() ) {
	        echo '<a href="';
	        echo esc_url(home_url('/'));
	        echo '">'.esc_html__('Home', 'classiadspro');
	        echo "</a>" . $delimiter;
        }

        if(function_exists('is_woocommerce') && is_woocommerce() && is_archive()) {
        	$shop_page_id = wc_get_page_id( 'shop' );
			$shop_page    = get_post( $shop_page_id );
			$permalinks   = get_option( 'woocommerce_permalinks' );
        	if ( $shop_page_id && $shop_page ) {
				echo '<a href="' . get_permalink( $shop_page ) . '">' . $shop_page->post_title . '</a> ';
			}
        }

		if(is_singular('news')) {
            echo '<span>'.get_the_title().'</span>';

        } else if ( is_single() && ! is_attachment()) {
		      	
		       if ( get_post_type() == 'product' ) {

					if ( $terms = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ) {

						$main_term = $terms[0];

						$ancestors = get_ancestors( $main_term->term_id, 'product_cat' );

						$ancestors = array_reverse( $ancestors );

						foreach ( $ancestors as $ancestor ) {
							$ancestor = get_term( $ancestor, 'product_cat' );

							if ( ! is_wp_error( $ancestor ) && $ancestor )
								echo '<a href="' . get_term_link( $ancestor->slug, 'product_cat' ) . '">' . $ancestor->name . '</a>' .  $delimiter;
						}

						echo  '<a href="' . get_term_link( $main_term->slug, 'product_cat' ) . '">' . $main_term->name . '</a>' . $delimiter;

					}

					echo  get_the_title();

				} elseif ( get_post_type() != 'post') {

		        	if(function_exists( 'is_bbpress' ) && is_bbpress()) {

		        	} else {
		        		$post_type = get_post_type_object( get_post_type() );
						$slug = $post_type->rewrite;
							echo  '<a href="' . get_post_type_archive_link( get_post_type() ) . '">' . $post_type->labels->singular_name . '</a>' .$delimiter;
						echo get_the_title();
		        	}

				} else {
						$cat = current( get_the_category() );
						echo get_category_parents( $cat, true, $delimiter );
						echo get_the_title();	
				}
		}  elseif ( is_page() && !$post->post_parent ) {

			echo get_the_title();

		} elseif ( is_page() && $post->post_parent ) {

			$parent_id  = $post->post_parent;
			$breadcrumbs = array();

			while ( $parent_id ) {
				$page = get_page( $parent_id );
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title( $page->ID ) . '</a>';
				$parent_id  = $page->post_parent;
			}

			$breadcrumbs = array_reverse( $breadcrumbs );

			foreach ( $breadcrumbs as $crumb )
				echo wp_kses_post($crumb) . '' . $delimiter;

			echo get_the_title();

		} elseif ( is_attachment() ) {

			$parent = get_post( $post->post_parent );
			$cat = get_the_category( $parent->ID );
			$cat = $cat[0];
			/* admin@innodron.com patch: 
	        Fix for Catchable fatal error: Object of class WP_Error could not be converted to string
	        ref: https://wordpress.org/support/topic/catchable-fatal-error-object-of-class-wp_error-could-not-be-converted-to-string-11
		    */
		    echo is_wp_error( $cat_parents = get_category_parents($cat, TRUE, '' . $delimiter . '') ) ? '' : $cat_parents;
		   /* end admin@innodron.com patch */
			echo '<a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a>' . $delimiter;
			echo  get_the_title();

		}	elseif ( is_search() ) {

		echo esc_html__( 'Search results for &ldquo;', 'classiadspro' ) . get_search_query() . '&rdquo;';

		} elseif ( is_tag() ) {

				echo esc_html__( 'Tag &ldquo;', 'classiadspro' ) . single_tag_title('', false) . '&rdquo;';

		} elseif ( is_author() ) {

			$userdata = get_userdata(get_the_author_meta('ID'));
			echo  esc_html__( 'Author:', 'classiadspro' ) . ' ' . $userdata->display_name;

		} elseif ( is_day() ) {

			echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a>' . $delimiter;
			echo '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a>' . $delimiter;
			echo get_the_time( 'd' );

		} elseif ( is_month() ) {

			echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a>' . $delimiter;
			echo get_the_time( 'F' );

		} elseif ( is_year() ) {

			echo  get_the_time( 'Y' );

		} 

		if ( get_query_var( 'paged' ) )
			echo ' (' . esc_html__( 'Page', 'classiadspro' ) . ' ' . get_query_var( 'paged' ) . ')';
		

        if (is_tax()) {
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            echo esc_attr($delimiter) . '<span>'.$term->name.'</span>';
        }
        
        if ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
        	$item = array();

				$post_type_object = get_post_type_object( bbp_get_forum_post_type() );

				if ( !empty( $post_type_object->has_archive ) && !bbp_is_forum_archive() ){
					$item[] = '<a href="' . get_post_type_archive_link( bbp_get_forum_post_type() ) . '">' . bbp_get_forum_archive_title() . '</a>';
				}

				if ( bbp_is_forum_archive() ){
					$item[] = bbp_get_forum_archive_title();
				}

				elseif ( bbp_is_topic_archive() ){
					$item[] = bbp_get_topic_archive_title();
				}

				elseif ( bbp_is_single_view() ){
					$item[] = bbp_get_view_title();
				}

				elseif ( bbp_is_single_topic() ) {

					$topic_id = get_queried_object_id();

					$item = array_merge( $item, pacz_breadcrumbs_get_parents( bbp_get_topic_forum_id( $topic_id ) ) );

					if ( bbp_is_topic_split() || bbp_is_topic_merge() || bbp_is_topic_edit() )
						$item[] = '<a href="' . bbp_get_topic_permalink( $topic_id ) . '">' . bbp_get_topic_title( $topic_id ) . '</a>';
					else
						$item[] = bbp_get_topic_title( $topic_id );

					if ( bbp_is_topic_split() )
						$item[] = esc_html__( 'Split', 'classiadspro' );

					elseif ( bbp_is_topic_merge() )
						$item[] = esc_html__( 'Merge', 'classiadspro' );

					elseif ( bbp_is_topic_edit() )
						$item[] = esc_html__( 'Edit', 'classiadspro' );
				}

				elseif ( bbp_is_single_reply() ) {

					$reply_id = get_queried_object_id();

					$item = array_merge( $item, pacz_breadcrumbs_get_parents( bbp_get_reply_topic_id( $reply_id ) ) );

					if ( !bbp_is_reply_edit() ) {
						$item[] = bbp_get_reply_title( $reply_id );

					} else {
						$item[] = '<a href="' . bbp_get_reply_url( $reply_id ) . '">' . bbp_get_reply_title( $reply_id ) . '</a>' ; 
						$item[] = esc_html__( 'Edit', 'classiadspro' );
					}

				}

				elseif ( bbp_is_single_forum() ) {

					$forum_id = get_queried_object_id();
					$forum_parent_id = bbp_get_forum_parent_id( $forum_id );

					if ( 0 !== $forum_parent_id)
						$item = array_merge( $item, pacz_breadcrumbs_get_parents( $forum_parent_id ) );

					$item[] = bbp_get_forum_title( $forum_id );
				}

				elseif ( bbp_is_single_user() || bbp_is_single_user_edit() ) {

					if ( bbp_is_single_user_edit() ) {
						$item[] = '<a href="' . bbp_get_user_profile_url() . '">' . bbp_get_displayed_user_field( 'display_name' ) . '</a>';
						$item[] = esc_html__( 'Edit', 'classiadspro'  );
					} else {
						$item[] = bbp_get_displayed_user_field( 'display_name' );
					}
				}

				echo implode($delimiter, $item);


        }
	
        echo "</div></div>";
}
endif;


function pacz_breadcrumbs_get_parents( $post_id = '', $separator = '/' ) {

	$parents = array();

	if ( $post_id == 0 )
		return $parents;

	while ( $post_id ) {
		$page = get_page( $post_id );
		$parents[]  = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . get_the_title( $post_id ) . '</a>';
		$post_id = $page->post_parent;
	}

	if ( $parents )
		$parents = array_reverse( $parents );

	return $parents;
}

/*
 * Adding typekit
 */
function pacz_typekit_script() {
  global $pacz_settings;


if(isset($pacz_settings['typekit-id']) && $pacz_settings['typekit-id'] != '') {
  echo '<script type="text/javascript" src="//use.typekit.net/'.$pacz_settings['typekit-id'].'.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>';
}

}

/*-----------------*/


add_action( 'wp_enqueue_scripts', 'pacz_typekit_script');


if ( !function_exists( 'pacz_topfooter_subscribe' ) ) {
	function pacz_topfooter_subscribe() {
		global $pacz_settings;
		$footer_form_style = $pacz_settings['footer_form_style'];
		$output = '';
		$form_id = $pacz_settings['form_id'];
		$dhvc_form_id = $form_id;

		
		
		if($footer_form_style ==1){
			$output .= '<div class="footer-form-style'.$footer_form_style.' subscription-form">';
				if(class_exists('DHVCForm') && !empty($dhvc_form_id)){
					$output .= do_shortcode('[dhvc_form id="'.$dhvc_form_id.'"]'); 
				}else{
					$output .='<p>'.esc_html__('please install and activate DHVC plugin', 'classiadspro').'</p>';
				}
			$output .= '</div>';
		}else if($footer_form_style ==2){
			$output .= '<div class="footer-form-style'.$footer_form_style.' subscription-form">';
				if(class_exists('DHVCForm') && !empty($dhvc_form_id)){
					$output .= do_shortcode('[dhvc_form id="'.$dhvc_form_id.'"]'); 
				}else{
					$output .='<p>'.esc_html__('please install and activate DHVC plugin', 'classiadspro').'</p>';
				}
			$output .= '</div>';
		}else if($footer_form_style ==3){
		$output .= '<div class="footer-form-style'.$footer_form_style.' subscription-form">';
			if(class_exists('DHVCForm') && !empty($dhvc_form_id)){
				$output .= '<div class="title">';
					$output .= '<h5>'.esc_html__('SUBSCRIBE TO OUR NEWSLETTER', 'classiadspro').'</h5>';
				$output .= '</div>';
				$output .= do_shortcode('[dhvc_form id="'.$dhvc_form_id.'"]'); 
			}else{
				$output .='<p>'.esc_html__('please install and activate DHVC plugin', 'classiadspro').'</p>';
			}
		$output .= '</div>';
		}else if($footer_form_style == 4){
			$output .= '<div class="footer-form-style'.$footer_form_style.' subscription-form">';
				if(class_exists('DHVCForm') && !empty($dhvc_form_id)){
					$output .= do_shortcode('[dhvc_form id="'.$dhvc_form_id.'"]'); 
				}else{
					$output .='<p>'.esc_html__('please install and activate DHVC plugin', 'classiadspro').'</p>';
				}
			$output .= '</div>';
		}
		echo '<div class="clearfix">'.$output.'</div>';
		
	}
}




if ( !function_exists( 'pacz_subfooter_logos' ) ) {
	function pacz_subfooter_logos() {
		global $pacz_settings;
		
		$src = isset($pacz_settings['subfooter-logos-src']['url']) ? $pacz_settings['subfooter-logos-src']['url'] : '';

		if(empty($src)) { return false; }

		$link = $pacz_settings['subfooter-logos-link'];

		$output = '';
		$output .= '<div class="pacz-subfooter-logos">';
		$output .= !empty($link) ? '<a href="'.$link.'">' : '';
		$output .= '<img src="'.$src.'" />';
		$output .= !empty($link) ? '</a>' : '';
		$output .= '</div>';


		echo '<div>'.$output.'</div>';
	}
}



if ( !function_exists( 'pacz_subfooter_social' ) ) {
	function pacz_subfooter_social() {
		global $pacz_settings;


		$output = '';

		$output .= '<ul class="pacz-footer-social">';
		
		
		
		if(!empty($pacz_settings['social-facebook'])) {
			$output .= '<li><a class="icon-facebook" target="_blank" href="'.$pacz_settings['social-facebook'].'"><i class="pacz-icon-facebook"></i></a></li>';
		}
		if(!empty($pacz_settings['social-twitter'])) {
			$output .= '<li><a class="icon-twitter" target="_blank" href="'.$pacz_settings['social-twitter'].'"><i class="pacz-icon-twitter"></i></a></li>';
		}
		if(!empty($pacz_settings['social-google-plus'])) {
			$output .= '<li><a class="icon-google-plus" target="_blank" href="'.$pacz_settings['social-google-plus'].'"><i class="pacz-icon-google-plus"></i></a></li>';
		}
		if(!empty($pacz_settings['social-pinterest'])) {
			$output .= '<li><a class="icon-pinterest" target="_blank" href="'.$pacz_settings['social-pinterest'].'"><i class="pacz-icon-pinterest"></i></a></li>';
		}
		if(!empty($pacz_settings['social-instagram'])) {
			$output .= '<li><a class="icon-instagram" target="_blank" href="'.$pacz_settings['social-instagram'].'"><i class="pacz-icon-instagram"></i></a></li>';
		}
		if(!empty($pacz_settings['social-linkedin'])) {
			$output .= '<li><a class="icon-linkedin" target="_blank" href="'.$pacz_settings['social-linkedin'].'"><i class="pacz-icon-linkedin"></i></a></li>';
		}
		if(!empty($pacz_settings['social-dribbble'])) {
			$output .= '<li><a class="icon-dribbble" target="_blank" href="'.$pacz_settings['social-dribbble'].'"><i class="pacz-icon-dribbble"></i></a></li>';
		}
		if(!empty($pacz_settings['social-rss'])) {
			$output .= '<li><a class="icon-rss" target="_blank" href="'.$pacz_settings['social-rss'].'"><i class="pacz-icon-rss"></i></a></li>';
		}
		if(!empty($pacz_settings['social-youtube'])) {
			$output .= '<li><a class="icon-youtube-play" target="_blank" href="'.$pacz_settings['social-youtube'].'"><i class="pacz-icon-youtube-play"></i></a></li>';
		}
		if(!empty($pacz_settings['social-tumblr'])) {
			$output .= '<li><a class="icon-tumblr" target="_blank" href="'.$pacz_settings['social-tumblr'].'"><i class="pacz-icon-tumblr"></i></a></li>';
		}
		if(!empty($pacz_settings['social-behance'])) {
			$output .= '<li><a class="icon-behance" target="_blank" href="'.$pacz_settings['social-behance'].'"><i class="pacz-icon-behance"></i></a></li>';
		}
		if(!empty($pacz_settings['social-whatsapp'])) {
			$output .= '<li><a class="icon-whatsapp" target="_blank" href="'.$pacz_settings['social-whatsapp'].'"><i class="pacz-theme-icon-whatsapp"></i></a></li>';
		}
		if(!empty($pacz_settings['social-vimeo'])) {
			$output .= '<li><a class="icon-vimeo" target="_blank" href="'.$pacz_settings['header-social-vimeo'].'"><i class="pacz-icon-vimeo"></i></a></li>';
		}
		if(!empty($pacz_settings['social-weibo'])) {
			$output .= '<li><a class="icon-weibo" target="_blank" href="'.$pacz_settings['social-weibo'].'"><i class="pacz-icon-weibo"></i></a></li>';
		}
		if(!empty($pacz_settings['social-spotify'])) {
			$output .= '<li><a class="icon-spotify" target="_blank" href="'.$pacz_settings['header-social-spotify'].'"><i class="pacz-icon-spotify"></i></a></li>';
		}
		if(!empty($pacz_settings['social-vkcom'])) {
			$output .= '<li><a class="icon-vk" target="_blank" href="'.$pacz_settings['social-vkcom'].'"><i class="pacz-icon-vk"></i></a></li>';
		}
		if(!empty($pacz_settings['social-qzone'])) {
			$output .= '<li><a class="icon-qzone" target="_blank" href="'.$pacz_settings['social-qzone'].'"><i class="pacz-theme-icon-qzone"></i></a></li>';
		}
		if(!empty($pacz_settings['social-wechat'])) {
			$output .= '<li><a class="icon-wechat" target="_blank" href="'.$pacz_settings['social-wechat'].'"><i class="pacz-icon-wechat"></i></a></li>';
		}
		if(!empty($pacz_settings['social-renren'])) {
			$output .= '<li><a class="icon-renren" target="_blank" href="'.$pacz_settings['social-renren'].'"><i class="pacz-icon-renren"></i></a></li>';
		}
		if(!empty($pacz_settings['social-imdb'])) {
			$output .= '<li><a class="icon-imdb" target="_blank" href="'.$pacz_settings['social-imdb'].'"><i class="pacz-theme-icon-imdb"></i></a></li>';
		}
		
		$output .= '</ul>';

		echo '<div class="social-network-wrapper">'.$output.'</div>';
	}
}







