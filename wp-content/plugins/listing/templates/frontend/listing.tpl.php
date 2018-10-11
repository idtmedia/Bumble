<?php global $ALSP_ADIMN_SETTINGS; ?>

<?php
if ($listing->level->featured){
	$is_featured =  'featured-ad';
}else{
	$is_featured =  'normal';
}
if($is_featured != 'featured-ad'){
	$no_featured = 'no_featured_tag';
}else{
	$no_featured = '';
}
	require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";

		if ($ALSP_ADIMN_SETTINGS['listing_image_width_height'] == 1){
			if(get_option('listing_style_to_show') == 'show_list_style'){

					$width= 130;
					$height= 130;
					$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
//					$image_src = bfi_thumb($image_src_array[0], array(
//						'width' => $width,
//						'height' => $height,
//						'crop' => false
//					));
                if($image_src_array!=""){
                    $image_src =  $image_src_array[0];
                }else{
                    $image_src = "";
                }
//                    var_dump($image_src_array);

			}elseif(get_option('listing_style_to_show') == 'show_grid_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 1){
				$width= 360;
					$height= 390;
					$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
					$image_src = bfi_thumb($image_src_array[0], array(
						'width' => $width,
						'height' => $height,
						'crop' => false
					));
			}elseif(get_option('listing_style_to_show') == 'show_grid_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 2){
				$width= 350;
					$height= 300;
					$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
					$image_src = bfi_thumb($image_src_array[0], array(
						'width' => $width,
						'height' => $height,
						'crop' => false
					));
			}elseif(get_option('listing_style_to_show') == 'show_grid_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 3){
				$width= 360;
					$height= 290;
					$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
					$image_src = bfi_thumb($image_src_array[0], array(
						'width' => $width,
						'height' => $height,
						'crop' => false
					));
			}elseif(get_option('listing_style_to_show') == 'show_grid_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 4){
				$width= 350;
					$height= 280;
					$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
					$image_src = bfi_thumb($image_src_array[0], array(
						'width' => $width,
						'height' => $height,
						'crop' => false
					));
			}elseif(get_option('listing_style_to_show') == 'show_grid_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 5){
				$width= 370;
					$height= 260;
					$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
					$image_src = bfi_thumb($image_src_array[0], array(
						'width' => $width,
						'height' => $height,
						'crop' => false
					));
			}elseif(get_option('listing_style_to_show') == 'show_grid_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 6){
				$width= 370;
					$height= 450;
					$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
					$image_src = bfi_thumb($image_src_array[0], array(
						'width' => $width,
						'height' => $height,
						'crop' => false
					));
			}elseif(get_option('listing_style_to_show') == 'show_grid_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 7){
				$width= 370;
					$height= 380;
					$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
					$image_src = bfi_thumb($image_src_array[0], array(
						'width' => $width,
						'height' => $height,
						'crop' => false
					));
			}elseif(get_option('listing_style_to_show') == 'show_grid_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 8){
				$width= 370;
					$height= 270;
					$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
					$image_src = bfi_thumb($image_src_array[0], array(
						'width' => $width,
						'height' => $height,
						'crop' => false
					));
			}elseif(get_option('listing_style_to_show') == 'show_grid_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 9){
				$width= 350;
					$height= 240;
					$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
					$image_src = bfi_thumb($image_src_array[0], array(
						'width' => $width,
						'height' => $height,
						'crop' => false
					));
			}elseif(get_option('listing_style_to_show') == 'show_grid_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 10){
				$width= 370;
					$height= 260;
					$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
					$image_src = bfi_thumb($image_src_array[0], array(
						'width' => $width,
						'height' => $height,
						'crop' => false
					));
			}elseif(get_option('listing_style_to_show') == 'show_grid_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 11){
				$width= 270;
					$height= 220;
					$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
					$image_src = bfi_thumb($image_src_array[0], array(
						'width' => $width,
						'height' => $height,
						'crop' => false
					));
			}elseif(get_option('listing_style_to_show') == 'show_grid_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 12){
				$width= 270;
					$height= 220;
					$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
					$image_src = bfi_thumb($image_src_array[0], array(
						'width' => $width,
						'height' => $height,
						'crop' => false
					));
			}elseif(get_option('listing_style_to_show') == 'show_grid_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 13){
				$width= 270;
					$height= 270;
					$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
					$image_src = bfi_thumb($image_src_array[0], array(
						'width' => $width,
						'height' => $height,
						'crop' => false
					));
			}elseif(get_option('listing_style_to_show') == 'show_grid_style' && $ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 14){
				$width= 290;
					$height= 190;
					$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
					$image_src = bfi_thumb($image_src_array[0], array(
						'width' => $width,
						'height' => $height,
						'crop' => false
					));
			}elseif(get_option('listing_style_to_show') == 'show_grid_style'){
				$width= 370;
					$height= 260;
					$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
					$image_src = bfi_thumb($image_src_array[0], array(
						'width' => $width,
						'height' => $height,
						'crop' => false
					));
			}

		}else{

			if(get_option('listing_style_to_show') == 'show_list_style'){

				$width= $ALSP_ADIMN_SETTINGS['alsp_logo_width_listview'];
				$height= $ALSP_ADIMN_SETTINGS['alsp_logo_height_listview'];
				$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
				$image_src       = bfi_thumb($image_src_array[0], array(
					'width' => $width,
					'height' => $width,
					'crop' => false
				));

			}elseif(get_option('listing_style_to_show') == 'show_grid_style'){
				$option_element = get_option('main_block_hash');
				$width_value = get_option('listing_image_width_'.$option_element);
				$height_value = get_option('listing_image_height_'.$option_element);
				$width = $width_value;
				$height= $height_value;
				$image_src_array = wp_get_attachment_image_src($listing->logo_image, 'full');
				$image_src = bfi_thumb($image_src_array[0], array(
					'width' => $width,
					'height' => $height,
					'crop' => false
				));
			}

		}




/*price*/
global $term, $icon_image, $wpdb, $wpdb, $pacz_settings;
$field_ids = $wpdb->get_results('SELECT id, type, slug FROM '.$wpdb->prefix.'alsp_content_fields');

if(class_exists('Classiadspro_Theme')){
$id = uniqid();
global $alsp_dynamic_styles;
$alsp_styles = '';
$alsp_styles .= '
.listing-post-style-listview_default .alsp-listing-text-content-wrap,
.listing-post-style-listview_ultra .alsp-listing-text-content-wrap {
    width:calc(100% - '.$width.'px);
	float:left;
}
.listing-post-style-listview_default figure,
.listing-post-style-listview_ultra figure{
	width:'.$width.'px;
	float:left;
}
';
}


global $direviews_plugin;
if ( method_exists( $direviews_plugin, 'get_average_rating' ) ) {
	$rating = $direviews_plugin->get_average_rating( $listing->post->ID);
}

 if ($listing->level->listings_own_page){
 $alsp_listings_own_page = 'alsp-listings-own-page';
 }else{
	$alsp_listings_own_page = '';
 }

 /* cat icon */

	$terms = get_the_terms($listing->post->ID, ALSP_CATEGORIES_TAX);
	if(is_array($terms)){
		foreach ($terms AS $key=>$term){
			if($ALSP_ADIMN_SETTINGS['cat_icon_type'] == 1){
				if($cat_color_set = alsp_getCategorycolor($term->term_id)){
					$cat_color = 'style="background-color:'.$cat_color_set.';"';
				}else{
					$cat_color = 'style="background-color:'.$pacz_settings['accent-color'].';"';
				}
				$icon_file = alsp_getCategoryMarkerIcon($term->term_id);
				$icon = '<span class="font-icon" '.$cat_color.'><span class="cat-icon '.$icon_file.'"></span></span>';
				if($icon_file){
					$cat_icon =  $icon;
				}else{
					$cat_icon = '';
				}
			}elseif($ALSP_ADIMN_SETTINGS['cat_icon_type'] == 2){
				$icon_file = alsp_getCategoryIcon2($term->term_id);
				$icon = '<img class="alsp-field-icon" src="' . ALSP_CATEGORIES_ICONS_URL . $icon_file . '" alt="listing cat" />';
				if($icon_file){
					$cat_icon =  $icon;
				}else{
					$cat_icon = '';
				}

			}elseif($ALSP_ADIMN_SETTINGS['cat_icon_type'] == 3){
				$icon_file = get_term_meta ($term->term_id, 'category-svg-icon-id', true);
					$icon = '<span class="cat-icon svg_icon">'.$icon_file.'</span>';
				if($icon_file){
					$cat_icon =  $icon;
				}else{
					$cat_icon = '';
				}

			}else{
				if($cat_color_set = alsp_getCategorycolor($term->term_id)){
					$cat_color = 'style="background-color:'.$cat_color_set.';"';
				}else{
					$cat_color = 'style="background-color:'.$pacz_settings['accent-color'].';"';
				}
				$icon_file = alsp_getCategoryMarkerIcon($term->term_id);
				$icon = '<span class="font-icon" '.$cat_color.'><span class="cat-icon '.$icon_file.'"></span></span>';
				if($icon_file){
					$cat_icon =  $icon;
				}else{
					$cat_icon = '';
				}
			}
		}
	}

 /* fav icon */

if (alsp_checkQuickList($listing->post->ID)){
	$hear_icon = 'heart';
}else{
	$hear_icon = 'heart-o';
}

/* nofollow */

	if($listing->level->nofollow){
		$nofollow = 'rel="nofollow"';
	}else{
	$nofollow = '';
	}

							$authorID = get_the_author_meta( 'ID' );
							if ( gearside_is_user_online($authorID) ){
								$author_log_status = '<span class="author-active"></span>';
							} else {
								$author_log_status = '<span class="author-in-active"></span>';
							}
							$author_verified = get_the_author_meta('author_verified', $authorID);
							if ( $author_verified == 'verified' ){
								$author_verified_icon = '<span class="author-verified pacz-icon-check-circle"></span>';
							} else {
								$author_verified_icon = '<span class="author-unverified pacz-icon-check-circle"></span>';
							}
								$author_img_url = get_user_meta($authorID, "pacz_author_avatar_url", true);
/* listing title */
	$title_limit = $ALSP_ADIMN_SETTINGS['max_title_length'];
	if (!$listing->level->listings_own_page){
		$listing_title = '<h2 itemprop="name">'.$listing->title().'</h2>';
	}else{
		$listing_title = '<h2><a href="'.get_permalink().'" title="'.esc_attr($listing->title()).'" '.$nofollow.'>'.substr($listing->title(), 0, $title_limit).'</a>'.$author_verified_icon.'</h2>';
	}
$frontend_controller = new alsp_listings_controller();



$output = '';
		if(get_option('listing_style_to_show') == 'show_grid_style'){
			if($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 1){
				// style one elca
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					if ($alsp_instance->getShortcodeProperty('webdirectory', 'is_favourites') && alsp_checkQuickList($listing->post->ID)){
						echo '<div class="alsp-remove-from-favourites-list" listingid="'.the_ID().'" title="'.esc_attr(__('Remove from favourites list', 'ALSP')).'"></div>';
					}
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. $image_src .'" width="'.$width.'" height="'.$height.'" /></a>';
					echo '<div class="listing-logo-overlay"><a href="'.get_permalink().'"></a></div>';
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo '<a href="javascript:void(0);" class="add_to_favourites btn" listingid="'.$listing->post->ID.'"><span class="pacz-icon-'.$hear_icon.'"></span></a>';
					}
					echo '<span class="listing-cat-icon1">'.$cat_icon.'</span>';
				echo '</figure>';

				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad">'.esc_html__('Featured', 'ALSP').'</span>';
					}
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';

					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}
						}
					echo '</div>';
					do_action('alsp_listing_title_html', $listing);
				echo '</div>';
			}else if($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 2){
				//style 2 emo
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					if ($alsp_instance->getShortcodeProperty('webdirectory', 'is_favourites') && alsp_checkQuickList($listing->post->ID)){
						echo '<div class="alsp-remove-from-favourites-list" listingid="'.the_ID().'" title="'.esc_attr(__('Remove from favourites list', 'ALSP')).'"></div>';
					}
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. $image_src .'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo '<a href="javascript:void(0);" class="add_to_favourites btn" listingid="'.$listing->post->ID.'"><span class="pacz-icon-'.$hear_icon.'"></span></a>';
					}
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad">'.esc_html__('Featured', 'ALSP').'</span>';
					}
				echo '</figure>';

				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
					$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
					foreach ($terms as $term){
						echo '<div class="category">';
							echo '<a class="listing-cat" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						echo '</div>';
					}
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}
						}
					echo '</div>';
				echo '</div>';
			}else if($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 3){
				//style 3 lemo
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					if ($alsp_instance->getShortcodeProperty('webdirectory', 'is_favourites') && alsp_checkQuickList($listing->post->ID)){
						echo '<div class="alsp-remove-from-favourites-list" listingid="'.the_ID().'" title="'.esc_attr(__('Remove from favourites list', 'ALSP')).'"></div>';
					}
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. $image_src .'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad"><i class="pacz-icon-star"></i></span>';
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}
						}
					echo '</div>';
				echo '</figure>';

				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
					$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
					foreach ($terms as $term){
						echo '<div class="category">';
							echo '<a class="listing-cat" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						echo '</div>';
					}
					do_action('alsp_listing_title_html', $listing);
				echo '</div>';

			}else if($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 4){
				//style 4 max
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					if ($alsp_instance->getShortcodeProperty('webdirectory', 'is_favourites') && alsp_checkQuickList($listing->post->ID)){
						echo '<div class="alsp-remove-from-favourites-list" listingid="'.the_ID().'" title="'.esc_attr(__('Remove from favourites list', 'ALSP')).'"></div>';
					}
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. $image_src .'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo '<a href="javascript:void(0);" class="add_to_favourites btn" listingid="'.$listing->post->ID.'"><span class="pacz-icon-'.$hear_icon.'"></span></a>';
					}
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad"><i class="pacz-icon-star"></i></span>';
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}

				echo '</figure>';

				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					global $pacz_settings, $accent_color;
					$cat_bg_color = $pacz_settings['accent-color'];

					$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
					foreach ($terms as $term){
						if(alsp_getCategorycolor($term->term_id)){
							$category_bg = alsp_getCategorycolor($term->term_id);
						}else{
							$category_bg = $cat_bg_color;
						}
						echo '<div class="category">';
							echo '<a class="listing-cat" style="background-color:'.$category_bg.';" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						echo '</div>';
					}
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}
						}
					echo '</div>';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';

				echo '</div>';

			}elseif($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 5){
				// style 10 ultra
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					if ($alsp_instance->getShortcodeProperty('webdirectory', 'is_favourites') && alsp_checkQuickList($listing->post->ID)){
						echo '<div class="alsp-remove-from-favourites-list" listingid="'.get_the_ID().'" title="'.esc_attr(__('Remove from favourites list', 'ALSP')).'"><i class="pacz-fic4-error"></i></div>';
					}
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. $image_src .'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo '<a href="javascript:void(0);" class="add_to_favourites btn" listingid="'.$listing->post->ID.'"><span class="pacz-icon-'.$hear_icon.'"></span></a>';
					}
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad">'.esc_html__('Featured', 'ALSP').'</span>';
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}
				echo '</figure>';

				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<div class="listng-author-img">';
							if(!empty($author_img_url)) {
								$params = array( 'width' => 60, 'height' => 60, 'crop' => false );
								echo "<img src='" . bfi_thumb( "$author_img_url", $params ) . "' width='70' height='70' alt='author' />";
							} else {
								$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $authorID), $size = '60' );
								echo '<img src="'.$avatar_url.'" alt="author" width="'.$size.'" height="'.$size.'" />';
							}
							echo $author_log_status;
					echo '</div>';
					echo '<div class="cat-wrapper">';
						$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
						foreach ($terms as $term){
							echo '<a class="listing-cat" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						}
						if(count(wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX)) > 0){
							$terms2 = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => $term->term_id, 'order' => 'ASC' ) );

							foreach ($terms2 as $term){
								echo '<span class="cat-seperator"> > </span>';
								echo '<a class="listing-cat child" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
							}
						}
					echo '</div>';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
					echo '<div class="listing-content-fields">';

						global $wpdb;
							$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'excerpt'){
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}
								if($field_id->type != 'excerpt' && $field_id->type != 'content' && $field_id->type != 'address' && $field_id->type != 'categories' && $field_id->type != 'price' && ($field_id->slug != 'price' || $field_id->slug != 'Price') ){
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}
							}
					echo '</div>';
					echo '<p class="listing-location">';
						echo '<i class="pacz-fic3-pin-1"></i>';
						foreach ($listing->locations AS $location){
							echo '<span class="alsp-location" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';
								if ($location->map_coords_1 && $location->map_coords_2){
									echo '<span class="alsp-show-on-map" data-location-id="'. $location->id.'">';
								}
								echo $location->getWholeAddress_ongrid();
								if ($location->map_coords_1 && $location->map_coords_2){
									echo '</span>';
								}
							echo '</span>';
						}
					echo '</p>';
					echo '<div class="listing-bottom-metas clearfix">';
						echo '<p class="listing-views">'.sprintf(__('Views: %d', 'ALSP'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)).'</p>';
						echo '<div class="price">';
							$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}
							}
						echo '</div>';
					echo '</div>';
				echo '</div>';
			}elseif($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 6){
				// style 6 exo
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					if ($alsp_instance->getShortcodeProperty('webdirectory', 'is_favourites') && alsp_checkQuickList($listing->post->ID)){
						echo '<div class="alsp-remove-from-favourites-list" listingid="'.$listing->post->ID.'" title="'.esc_attr(__('Remove from favourites list', 'ALSP')).'"></div>';
					}
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. $image_src .'" width="'.$width.'" height="'.$height.'" /></a>';
					echo '<div class="listing-logo-overlay"><a href="'.get_permalink().'"></a></div>';
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo '<a href="javascript:void(0);" class="add_to_favourites btn" listingid="'.$listing->post->ID.'"><span class="pacz-icon-'.$hear_icon.'"></span></a>';
					}
				echo '</figure>';

				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<span class="listing-cat-icon1">'.$cat_icon.'</span>';
					do_action('alsp_listing_title_html', $listing);
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad">'.esc_html__('Featured', 'ALSP').'</span>';
					}
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}
						}
					echo '</div>';

				echo '</div>';
			}elseif($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 7){

				//style 7 exotic
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					if ($alsp_instance->getShortcodeProperty('webdirectory', 'is_favourites') && alsp_checkQuickList($listing->post->ID)){
						echo '<div class="alsp-remove-from-favourites-list" listingid="'.the_ID().'" title="'.esc_attr(__('Remove from favourites list', 'ALSP')).'"></div>';
					}
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. $image_src .'" width="'.$width.'" height="'.$height.'" /></a>';
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}
						}
					echo '</div>';
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad"><i class="pacz-icon-star"></i></span>';
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}

				echo '</figure>';

				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
					foreach ($terms as $term){
						echo '<div class="category">';
							echo '<a class="listing-cat" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						echo '</div>';
					}
					do_action('alsp_listing_title_html', $listing);
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
				echo '</div>';
			}elseif($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 8){
				//style 8 snow
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.' alsp-anim-style-6">';
					if ($alsp_instance->getShortcodeProperty('webdirectory', 'is_favourites') && alsp_checkQuickList($listing->post->ID)){
						echo '<div class="alsp-remove-from-favourites-list" listingid="'.the_ID().'" title="'.esc_attr(__('Remove from favourites list', 'ALSP')).'"></div>';
					}
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. $image_src .'" width="'.$width.'" height="'.$height.'" /></a>';
					echo '<div class="listing-logo-overlay"></div>';
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad"><i class="pacz-icon-star"></i></span>';
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}
					echo '<figcaption>';
					echo '<a class="listing8-overlay-link" href="'.get_permalink().'"></a>';
					echo '<div class="alsp-figcaption">';
						echo '<div class="alsp-figcaption-middle">';
							echo '<ul class="alsp-figcaption-options">';
								echo '<li class="alsp-listing-figcaption-option">';
										$terms = get_the_terms($listing->post->ID, ALSP_CATEGORIES_TAX);
										if(is_array($terms)){
										foreach ($terms AS $key=>$term):
											$icon_file = alsp_getCategoryIcon2($term->term_id);
													$icon = '<img class="alsp-field-icon" src="' . ALSP_CATEGORIES_ICONS_URL . $icon_file . '" alt="listing cat" />';
											if($icon_file){
											echo $icon;
											}
										endforeach;
										}
								echo '</li>';
								echo '<li class="alsp-listing-figcaption-option">';
									foreach ($listing->locations AS $location){
										echo '<span class="alsp-location" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';
											if ($location->map_coords_1 && $location->map_coords_2){
												echo '<span class="alsp-show-on-map" data-location-id="'.$location->id.'">';
											}
											echo $location->getWholeAddress_ongrid();
											if ($location->map_coords_1 && $location->map_coords_2){
												echo '</span>';
											}
										echo '</span>';
									}
								echo '</li>';
							echo '</ul>';
						echo '</div>';
					echo '</div>';
				echo '</figcaption>';
				echo '</figure>';
				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					global $pacz_settings, $accent_color;
					$cat_bg_color = $pacz_settings['accent-color'];
					$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
					foreach ($terms as $term){
						if(alsp_getCategorycolor($term->term_id)){
							$category_bg = alsp_getCategorycolor($term->term_id);
						}else{
							$category_bg = $cat_bg_color;
						}
						echo '<div class="category">';
							echo '<a class="listing-cat" style="background-color:'.$category_bg.';" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						echo '</div>';
					}
					do_action('alsp_listing_title_html', $listing);
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
				echo '</div>';
				echo '<div class="listing-bottom-content clearfix">';
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}
						}
					echo '</div>';
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo '<a href="javascript:void(0);" class="add_to_favourites btn" listingid="'.$listing->post->ID.'"><span class="pacz-icon-'.$hear_icon.'"></span></a>';
					}
					echo '<p class="listing-views">'. sprintf(__('Views: %d', 'ALSP'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)).'</p>';
				echo '</div>';
			}elseif($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 9){
				// style 9 zee
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					if ($alsp_instance->getShortcodeProperty('webdirectory', 'is_favourites') && alsp_checkQuickList($listing->post->ID)){
						echo '<div class="alsp-remove-from-favourites-list" listingid="'.the_ID().'" title="'.esc_attr(__('Remove from favourites list', 'ALSP')).'"></div>';
					}
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. $image_src .'" width="'.$width.'" height="'.$height.'" /></a>';
					echo '<div class="listing-logo-overlay"></div>';
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad"><i class="pacz-icon-star"></i></span>';
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}
						}
					echo '</div>';
					if(metadata_exists('post', $listing->post->ID, '_listing_mark_as' ) ) {
						$content = get_post_meta($listing->post->ID, '_listing_mark_as', true );
						echo '<div class="listing_marked_as '.$no_featured.'">';
							echo '<p>' . $content . '</p>';
						echo '</div>';
					}
				echo '</figure>';

				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<div class="listng-author-img">';
						if(!empty($author_img_url)) {
							$params = array( 'width' => 60, 'height' => 60, 'crop' => false );
							echo "<img src='" . bfi_thumb( "$author_img_url", $params ) . "' width='70' height='70' alt='author' />";
						} else {
							$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $authorID), $size = '60' );
							echo '<img src="'.$avatar_url.'" alt="author" width="'.$size.'" height="'.$size.'" />';
						}
						echo $author_log_status;
					echo '</div>';
				$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
					global $pacz_settings, $accent_color;
					$cat_bg_color = $pacz_settings['accent-color'];

					$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
					foreach ($terms as $term){
						if(alsp_getCategorycolor($term->term_id)){
							$category_bg = alsp_getCategorycolor($term->term_id);
						}else{
							$category_bg = $cat_bg_color;
						}
						echo '<div class="category">';
							echo '<a class="listing-cat" style="background-color:'.$category_bg.';" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						echo '</div>';
					}
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
						echo '<div class="listing-metas clearfix">';
							if (!empty($rating) && $ALSP_ADIMN_SETTINGS['alsp_ratting_type'] == 'new'){
								echo '<div class="listing-rating grid-rating">';
									echo '<span class="rating-numbers">'.get_average_listing_rating().'</span>';
									echo '<span class="rating-stars">'.display_total_listing_rating().'</span>';
								echo '</div>';
							}elseif($ALSP_ADIMN_SETTINGS['alsp_ratting_type'] == 'old'){
								do_action('alsp_listing_title_html', $listing);
							}
							echo '<em class="alsp-listing-date" itemprop="dateCreated" datetime="'.date("Y-m-d", mysql2date('U', $listing->post->post_date)).'T'.date("H:i", mysql2date('U', $listing->post->post_date)).'">'. get_the_date().'</em>';
							//echo '<p class="listing-views"><i class="pacz-fic3-medical"></i>'.sprintf(__('Views: %d', 'ALSP'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)).'</p>';
							if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
								echo '<a href="javascript:void(0);" class="add_to_favourites btn" listingid="'.$listing->post->ID.'"><span class="pacz-icon-'.$hear_icon.'"></span></a>';
							}
						echo '</div>';
					echo '</header>';
					global $wpdb;
					$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'excerpt'){
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}
						}
					echo '<p class="listing-location">';
						echo '<i class="pacz-fic3-pin-1"></i>';
						foreach ($listing->locations AS $location){
							echo '<span class="alsp-location" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';
								if ($location->map_coords_1 && $location->map_coords_2){
									echo '<span class="alsp-show-on-map" data-location-id="'.$location->id.'">';
								}
									echo $location->getWholeAddress_ongrid();
								if ($location->map_coords_1 && $location->map_coords_2){
									echo '</span>';
								}
							echo '</span>';
						}
					echo '</p>';
				echo '</div>';
			}elseif($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 10){
				// style 10 ultra
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					if ($alsp_instance->getShortcodeProperty('webdirectory', 'is_favourites') && alsp_checkQuickList($listing->post->ID)){
						echo '<div class="alsp-remove-from-favourites-list" listingid="'.the_ID().'" title="'.esc_attr(__('Remove from favourites list', 'ALSP')).'"></div>';
					}
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. $image_src .'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo '<a href="javascript:void(0);" class="add_to_favourites btn" listingid="'.$listing->post->ID.'"><span class="pacz-icon-'.$hear_icon.'"></span></a>';
					}
					if (!empty($rating) && $ALSP_ADIMN_SETTINGS['alsp_ratting_type'] == 'new'){
						echo '<div class="listing-rating grid-rating">';
							echo '<span class="rating-numbers">'.get_average_listing_rating().'</span>';
							echo '<span class="rating-stars">'.display_total_listing_rating().'</span>';
						echo '</div>';
					}
					if(metadata_exists('post', $listing->post->ID, '_listing_mark_as' ) ) {
						$content = get_post_meta($listing->post->ID, '_listing_mark_as', true );
						echo '<div class="listing_marked_as '.$no_featured.'">';
							echo '<p>' . $content . '</p>';
						echo '</div>';
					}
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad">'.esc_html__('Featured', 'ALSP').'</span>';
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}
				echo '</figure>';

				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<div class="listng-author-img">';
							if(!empty($author_img_url)) {
								$params = array( 'width' => 60, 'height' => 60, 'crop' => false );
								echo "<img src='" . bfi_thumb( "$author_img_url", $params ) . "' width='70' height='70' alt='author' />";
							} else {
								$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $authorID), $size = '60' );
								echo '<img src="'.$avatar_url.'" alt="author" width="'.$size.'" height="'.$size.'" />';
							}
							echo $author_log_status;
					echo '</div>';
					echo '<div class="cat-wrapper">';
						$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
						foreach ($terms as $term){
							echo '<a class="listing-cat" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						}
						if(count(wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX)) > 0){
							$terms2 = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => $term->term_id, 'order' => 'ASC' ) );

							foreach ($terms2 as $term){
								echo '<span class="cat-seperator"> > </span>';
								echo '<a class="listing-cat child" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
							}
						}
					echo '</div>';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
						//echo $frontend_controller->args['listing_post_style'];
						//$f = $frontend_controller->processQuery();

					echo '</header>';
					echo '<p class="listing-location">';
						echo '<i class="pacz-fic3-pin-1"></i>';
						foreach ($listing->locations AS $location){
							echo '<span class="alsp-location" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';
								if ($location->map_coords_1 && $location->map_coords_2){
									echo '<span class="alsp-show-on-map" data-location-id="'. $location->id.'">';
								}
								echo $location->getWholeAddress_ongrid();
								if ($location->map_coords_1 && $location->map_coords_2){
									echo '</span>';
								}
							echo '</span>';
						}
					echo '</p>';
					echo '<div class="listing-bottom-metas clearfix">';
						echo '<p class="listing-views">'.sprintf(__('Views: %d', 'ALSP'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)).'</p>';
						echo '<div class="price">';
							$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}
							}
						echo '</div>';
					echo '</div>';
				echo '</div>';
			}elseif($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 11){
				// style 11 Mintox
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					if ($alsp_instance->getShortcodeProperty('webdirectory', 'is_favourites') && alsp_checkQuickList($listing->post->ID)){
						echo '<div class="alsp-remove-from-favourites-list" listingid="'.the_ID().'" title="'.esc_attr(__('Remove from favourites list', 'ALSP')).'"></div>';
					}
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. $image_src .'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad">'.esc_html__('Featured', 'ALSP').'</span>';
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}
					echo '<div class="price">';
							$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}
							}
					echo '</div>';
				echo '</figure>';

				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<header class="alsp-listing-header">';
						echo '<span class="listing-cat-icon1">'.$cat_icon.'</span>';
						echo $listing_title;
					echo '</header>';
				echo '</div>';
			}elseif($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 12){
				// style 11 Mintox
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					if ($alsp_instance->getShortcodeProperty('webdirectory', 'is_favourites') && alsp_checkQuickList($listing->post->ID)){
						echo '<div class="alsp-remove-from-favourites-list" listingid="'.the_ID().'" title="'.esc_attr(__('Remove from favourites list', 'ALSP')).'"></div>';
					}
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. $image_src .'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad">'.esc_html__('Featured', 'ALSP').'</span>';
					}
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo '<a href="javascript:void(0);" class="add_to_favourites btn" listingid="'.$listing->post->ID.'"><span class="pacz-icon-'.$hear_icon.'"></span></a>';
					}
					echo '<span class="listing-cat-icon1">'.$cat_icon.'</span>';
				echo '</figure>';

				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
					echo '<div class="cat-wrapper">';
						$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
						foreach ($terms as $term){
							echo '<a class="listing-cat" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						}
					echo '</div>';
					echo '<div class="price">';
							$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}
							}
					echo '</div>';
				echo '</div>';
			}elseif($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 13){
				// style 11 zoco
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					if ($alsp_instance->getShortcodeProperty('webdirectory', 'is_favourites') && alsp_checkQuickList($listing->post->ID)){
						echo '<div class="alsp-remove-from-favourites-list" listingid="'.the_ID().'" title="'.esc_attr(__('Remove from favourites list', 'ALSP')).'"></div>';
					}
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. $image_src .'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad">'.esc_html__('Featured', 'ALSP').'</span>';
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}
					echo '<div class="price">';
							$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}
							}
					echo '</div>';
				echo '</figure>';

				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<div class="listing-content-left">';
						echo '<header class="alsp-listing-header">';
							echo $listing_title;
						echo '</header>';
						echo '<div class="cat-wrapper">';
							$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
							foreach ($terms as $term){
								echo '<a class="listing-cat" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
							}
						echo '</div>';
					echo '</div>';
					echo '<div class="listing-content-right">';
						echo '<span class="listing-cat-icon1">'.$cat_icon.'</span>';
					echo '</div>';
				echo '</div>';
			}elseif($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 14){
				// style 14 fantro
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. $image_src .'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad">'.esc_html__('Featured', 'ALSP').'</span>';
					}
					if(metadata_exists('post', $listing->post->ID, '_listing_mark_as' ) ) {
						$content = get_post_meta($listing->post->ID, '_listing_mark_as', true );
						echo '<div class="listing_marked_as '.$no_featured.'">';
							echo '<p>' . $content . '</p>';
						echo '</div>';
					}
					if (!empty($rating) && $ALSP_ADIMN_SETTINGS['alsp_ratting_type'] == 'new'){
						echo '<div class="listing-rating grid-rating">';
							echo '<span class="rating-numbers">'.get_average_listing_rating().'</span>';
							echo '<span class="rating-stars">'.display_total_listing_rating().'</span>';
						echo '</div>';
					}
				echo '</figure>';

				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<div class="listng-author-img">';
							if(!empty($author_img_url)) {
								$params = array( 'width' => 44, 'height' => 44, 'crop' => false );
								echo "<img src='" . bfi_thumb( "$author_img_url", $params ) . "' width='70' height='70' alt='author' />";
							} else {
								$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $authorID), $size = '44' );
								echo '<img src="'.$avatar_url.'" alt="author" width="'.$size.'" height="'.$size.'" />';
							}
							echo $author_log_status;
					echo '</div>';
					echo '<div class="cat-wrapper">';
						$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
						foreach ($terms as $term){
							echo '<a class="listing-cat" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						}
						if(count(wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX)) > 0){
							$terms2 = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => $term->term_id, 'order' => 'ASC' ) );

							foreach ($terms2 as $term){

								echo '<a class="listing-cat child" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.substr($term->name, 0, 12).'</a>';
							}
						}
					echo '</div>';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
					echo '</header>';
				echo '</div>';
				echo '<div class="listing-bottom-metas clearfix">';
						echo '<p class="listing-location">';
							//echo '<i class="pacz-fic3-pin-1"></i>';
							foreach ($listing->locations AS $location){
								echo '<span class="alsp-location" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';
									if ($location->map_coords_1 && $location->map_coords_2){
										echo '<span class="alsp-show-on-map" data-location-id="'. $location->id.'">';
									}
									echo $location->getWholeAddress_ongrid();
									if ($location->map_coords_1 && $location->map_coords_2){
										echo '</span>';
									}
								echo '</span>';
							}
						echo '</p>';
						//echo '<p class="listing-views">'.sprintf(__('Views: %d', 'ALSP'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)).'</p>';
						echo '<div class="price">';
							$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}
							}

						echo '</div>';
				echo '</div>';
			}elseif($ALSP_ADIMN_SETTINGS['alsp_listing_post_style'] == 15){
				if (alsp_checkQuickList($listing->post->ID)){
					$hear_icon15 = 'bookmark';
				}else{
					$hear_icon15 = 'bookmark-o';
				}
				// style Directo
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. $image_src .'" width="'.$width.'" height="'.$height.'" /></a>';
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad">'.esc_html__('Featured', 'ALSP').'</span>';
					}
					if(metadata_exists('post', $listing->post->ID, '_listing_mark_as' ) ) {
						$content = get_post_meta($listing->post->ID, '_listing_mark_as', true );
						echo '<div class="listing_marked_as '.$no_featured.'">';
							echo '<p>' . $content . '</p>';
						echo '</div>';
					}
				echo '</figure>';

				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					echo '<div class="listng-author-img">';
							if(!empty($author_img_url)) {
								$params = array( 'width' => 44, 'height' => 44, 'crop' => false );
								echo "<img src='" . bfi_thumb( "$author_img_url", $params ) . "' width='70' height='70' alt='author' />";
							} else {
								$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $authorID), $size = '44' );
								echo '<img src="'.$avatar_url.'" alt="author" width="'.$size.'" height="'.$size.'" />';
							}
							echo $author_log_status;
					echo '</div>';
					/*echo '<div class="cat-wrapper">';
						$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
						foreach ($terms as $term){
							echo '<a class="listing-cat" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						}
						if(count(wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX)) > 0){
							$terms2 = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => $term->term_id, 'order' => 'ASC' ) );

							foreach ($terms2 as $term){

								echo '<a class="listing-cat child" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.substr($term->name, 0, 12).'</a>';
							}
						}
					echo '</div>';*/
					echo '<header class="alsp-listing-header">';
						echo '<span class="listing-cat-icon1">'.$cat_icon.'</span>';
						echo $listing_title;
					echo '</header>';
					if (!empty($rating) && $ALSP_ADIMN_SETTINGS['alsp_ratting_type'] == 'new'){
						echo '<div class="listing-rating grid-rating">';
							echo '<span class="rating-numbers">'.get_average_listing_rating().'</span>';
							echo '<span class="rating-stars">'.display_average_listing_rating().'</span>';
						echo '</div>';
					}
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
						echo '<a href="javascript:void(0);" class="add_to_favourites btn" listingid="'.$listing->post->ID.'"><span class="pacz-icon-'.$hear_icon15.'">'.esc_html__('Save', 'ALSP').'</span></a>';
					}
					global $wpdb;
					$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'excerpt'){
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}
						}
				echo '</div>';
				echo '<div class="listing-bottom-metas clearfix">';
						echo '<p class="listing-location">';
							//echo '<i class="pacz-fic3-pin-1"></i>';
							foreach ($listing->locations AS $location){
								echo '<span class="alsp-location" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';
									if ($location->map_coords_1 && $location->map_coords_2){
										echo '<span class="alsp-show-on-map" data-location-id="'. $location->id.'">';
									}
									echo $location->getWholeAddress_ongrid();
									if ($location->map_coords_1 && $location->map_coords_2){
										echo '</span>';
									}
								echo '</span>';
							}
						echo '</p>';
						//echo '<p class="listing-views">'.sprintf(__('Views: %d', 'ALSP'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)).'</p>';
						echo '<div class="price">';
							$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
							foreach( $field_ids as $field_id ) {
								$singlefield_id = $field_id->id;
								if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){
									if($field_id->on_exerpt_page == 1){
										$listing->renderContentField($singlefield_id);
									}
								}
							}

						echo '</div>';
				echo '</div>';
			}
		}elseif(get_option('listing_style_to_show') == 'show_list_style'){
			if($ALSP_ADIMN_SETTINGS['alsp_listing_listview_post_style'] == 'listview_default'){
				// style list default
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. $image_src .'" width="'.$width.'" height="'.$height.'" /></a>';
					echo '<div class="listing-logo-overlay"></div>';
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad"><i class="pacz-icon-star"></i></span>';
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}

				echo '</figure>';

				echo '<div class="clearfix alsp-listing-text-content-wrap">';
					global $pacz_settings, $accent_color;
					$cat_bg_color = $pacz_settings['accent-color'];
					$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
					foreach ($terms as $term){
						if(alsp_getCategorycolor($term->term_id)){
							$category_bg = alsp_getCategorycolor($term->term_id);
						}else{
							$category_bg = $cat_bg_color;
						}
						echo '<div class="category">';
							echo '<a class="listing-cat" style="background-color:'.$category_bg.';" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						echo '</div>';
					}
					do_action('alsp_listing_title_html', $listing);
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}
						}
					echo '</div>';
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
						echo '<div class="listing-metas clearfix">';
							echo '<p class="listing-location">';
								echo '<i class="pacz-fic3-pin-1"></i>';
								foreach ($listing->locations AS $location){
									echo '<span class="alsp-location" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';
										if ($location->map_coords_1 && $location->map_coords_2){
											echo '<span class="alsp-show-on-map" data-location-id="'.$location->id.'">';
										}
											echo $location->getWholeAddress_ongrid();
										if ($location->map_coords_1 && $location->map_coords_2){
											echo '</span>';
										}
									echo '</span>';
								}
							echo '</p>';
							echo '<em class="alsp-listing-date" itemprop="dateCreated" datetime="'.date("Y-m-d", mysql2date('U', $listing->post->post_date)).'T'.date("H:i", mysql2date('U', $listing->post->post_date)).'"><i class="pacz-fic3-clock-circular-outline"></i>'. get_the_date().'</em>';
							echo '<p class="listing-views"><i class="pacz-fic3-medical"></i>'.sprintf(__('Views: %d', 'ALSP'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)).'</p>';
							if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
								echo '<a href="javascript:void(0);" class="add_to_favourites btn" listingid="'.$listing->post->ID.'"><span class="pacz-icon-'.$hear_icon.'"></span></a>';
							}
						echo '</div>';
					echo '</header>';
				echo '</div>';
			}elseif($ALSP_ADIMN_SETTINGS['alsp_listing_listview_post_style'] == 'listview_ultra'){
				// style list default
				echo '<figure class="alsp-listing-logo '.$alsp_listings_own_page.'">';
					echo '<a href="'.get_permalink().'"><img alt="'.$listing->title().'" src="'. $image_src .'" width="'.$width.'" height="'.$height.'" /></a>';
					echo '<div class="listing-logo-overlay"></div>';
					if ($is_featured == 'featured-ad'){
						echo '<span class="featured-ad">'.esc_html__('Featured', 'ALSP').'</span>';
					}
					if ($listing->level->sticky){
						echo '<div class="alsp-sticky-icon"></div>';
					}

				echo '</figure>';

					echo '<div class="clearfix alsp-listing-text-content-wrap">';
						echo '<div class="cat-wrapper">';
						$terms = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => '0', 'order' => 'ASC' ) );
						foreach ($terms as $term){
							echo '<a class="listing-cat" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
						}
						if(count(wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX)) > 0){
							$terms2 = wp_get_post_terms($listing->post->ID, ALSP_CATEGORIES_TAX, array( 'parent' => $term->term_id, 'order' => 'ASC' ) );

							foreach ($terms2 as $term){
								echo '<span class="cat-seperator"> > </span>';
								echo '<a class="listing-cat child" href="'.get_term_link($term, ALSP_CATEGORIES_TAX).'" rel="tag">'.$term->name.'</a>';
							}
						}
					echo '</div>';
					if (!empty($rating) && $ALSP_ADIMN_SETTINGS['alsp_ratting_type'] == 'new'){
						echo '<div class="listing-rating grid-rating">';
							echo '<span class="rating-numbers">'.get_average_listing_rating().'</span>';
							echo '<span class="rating-stars">'.display_total_listing_rating().'</span>';
						echo '</div>';
					}elseif($ALSP_ADIMN_SETTINGS['alsp_ratting_type'] == 'old'){
						do_action('alsp_listing_title_html', $listing);
					}
					echo '<div class="price">';
						$field_ids = $wpdb->get_results('SELECT id, type, slug, on_exerpt_page FROM '.$wpdb->prefix.'alsp_content_fields');
						foreach( $field_ids as $field_id ) {
							$singlefield_id = $field_id->id;
							if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){
								if($field_id->on_exerpt_page == 1){
									$listing->renderContentField($singlefield_id);
								}
							}
						}
					echo '</div>';
					if ($ALSP_ADIMN_SETTINGS['alsp_favourites_list'] && $alsp_instance->action != 'myfavourites'){
								echo '<a href="javascript:void(0);" class="add_to_favourites btn" listingid="'.$listing->post->ID.'"><span class="pacz-icon-'.$hear_icon.'"></span></a>';
							}
					echo '<header class="alsp-listing-header">';
						echo $listing_title;
						echo '<div class="listing-metas clearfix">';
							echo '<p class="listing-location">';
								echo '<i class="pacz-fic3-pin-1"></i>';
								foreach ($listing->locations AS $location){
									echo '<span class="alsp-location" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';
										if ($location->map_coords_1 && $location->map_coords_2){
											echo '<span class="alsp-show-on-map" data-location-id="'.$location->id.'">';
										}
											echo $location->getWholeAddress_ongrid();
										if ($location->map_coords_1 && $location->map_coords_2){
											echo '</span>';
										}
									echo '</span>';
								}
							echo '</p>';
							echo '<em class="alsp-listing-date" itemprop="dateCreated" datetime="'.date("Y-m-d", mysql2date('U', $listing->post->post_date)).'T'.date("H:i", mysql2date('U', $listing->post->post_date)).'"><i class="pacz-fic3-clock-circular-outline"></i>'. get_the_date().'</em>';
							echo '<p class="listing-views"><i class="pacz-fic3-medical"></i>'.sprintf(__('Views: %d', 'ALSP'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)).'</p>';

						echo '</div>';
					echo '</header>';
				echo '</div>';
			}else{

			}
		}

	// Hidden styles node for head injection after page load through ajax
echo '<div id="ajax-'.$id.'" class="alsp-dynamic-styles">';
echo '</div>';


// Export styles to json for faster page load
$alsp_dynamic_styles[] = array(
  'id' => 'ajax-'.$id ,
  'inject' => $alsp_styles
);

