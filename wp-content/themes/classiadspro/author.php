<?php
/**
 * Template name: Profile Page
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiads
 * @since classiads 1.2.2
 */


if(class_exists('alsp_plugin')):
global $ALSP_ADIMN_SETTINGS;
$layout = $pacz_settings['archive-layout'];
$columns = $pacz_settings['archive-columns'];
$loop_style = $pacz_settings['archive-loop-style'];
	
		$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
		$authorID = $author->ID;
		
		$author_img_url = get_the_author_meta('pacz_author_avatar_url', $authorID, true); 
		$author_name = get_the_author_meta('display_name', $authorID);
		if($ALSP_ADIMN_SETTINGS['frontend_panel_user_phone']){ $phone_number = get_the_author_meta('user_phone', $authorID); }
		$author_email = get_the_author_meta('email', $authorID);
		if($ALSP_ADIMN_SETTINGS['frontend_panel_user_website']){ $author_website = get_the_author_meta('user_website', $authorID); }
		if($ALSP_ADIMN_SETTINGS['frontend_panel_user_address']){ $author_address = get_the_author_meta('address', $authorID); }
		if($ALSP_ADIMN_SETTINGS['frontend_panel_user_type']){ $author_type = get_the_author_meta('_user_type', $authorID); }
		$author_verified = get_the_author_meta('author_verified', $authorID);
		
		//$email_id = $instance['email_id'];
		$registered = date_i18n( "M m, Y", strtotime( get_the_author_meta( 'user_registered', $authorID ) ) );
		if($ALSP_ADIMN_SETTINGS['frontend_panel_social_links']){
			$author_fb = get_the_author_meta('author_fb', $authorID);
			$author_tw = get_the_author_meta('author_tw', $authorID);
			$author_ytube = get_the_author_meta('author_ytube', $authorID);
			$author_vimeo = get_the_author_meta('author_vimeo', $authorID);
			$author_flickr = get_the_author_meta('author_flickr', $authorID);
			$author_linkedin = get_the_author_meta('author_linkedin', $authorID);
			$author_gplus = get_the_author_meta('author_gplus', $authorID);
			$author_instagram = get_the_author_meta('author_instagram', $authorID);
			$author_behance = get_the_author_meta('author_behance', $authorID);
			$author_dribbble = get_the_author_meta('author_dribbble', $authorID);
		}
		
		if ( gearside_is_user_online($authorID) ){
			$author_log_status = '<span class="author-active"></span>';
		} else {
			//$author_log_status = ( gearside_user_last_online($authorID) )? '<small>Last Seen: <br /><em>' . date('M j, Y @ g:ia', gearside_user_last_online($authorID)) . '</em></small>' : ''; //Return the user's "Last Seen" date, or return empty if that user has never logged in.
			$author_log_status = '<span class="author-in-active"></span>';
		}
		global $product;
		require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";
		$output = '';


// ********* Get all products and variations and sort alphbetically, return in array (title, sku, id)*******
function get_woocommerce_product_list() {
	$full_product_list = array();
	$loop = new WP_Query( array( 'post_type' => array('product', 'product_variation'), 'posts_per_page' => -1 ) );
 
	while ( $loop->have_posts() ) : $loop->the_post();
		$theid = get_the_ID();
		$product = new WC_Product($theid);
		// its a variable product
		if( get_post_type() == 'product_variation' ){
			$parent_id = wp_get_post_parent_id($theid );
			$sku = get_post_meta($theid, '_sku', true );
			$thetitle = get_the_title( $parent_id);
 
    // ****** Some error checking for product database *******
            // check if variation sku is set
            if ($sku == '') {
                if ($parent_id == 0) {
            		// Remove unexpected orphaned variations.. set to auto-draft
            		$false_post = array();
                    $false_post['ID'] = $theid;
                    $false_post['post_status'] = 'auto-draft';
                    wp_update_post( $false_post );
                    if (function_exists(add_to_debug)) add_to_debug('false post_type set to auto-draft. id='.$theid);
                } else {
                    // there's no sku for this variation > copy parent sku to variation sku
                    // & remove the parent sku so the parent check below triggers
                    $sku = get_post_meta($parent_id, '_sku', true );
                    if (function_exists(add_to_debug)) add_to_debug('empty sku id='.$theid.'parent='.$parent_id.'setting sku to '.$sku);
                    update_post_meta($theid, '_sku', $sku );
                    update_post_meta($parent_id, '_sku', '' );
                }
            }
 	// ****************** end error checking *****************
 
        // its a simple product
        } else {
            $sku = get_post_meta($theid, '_sku', true );
            $thetitle = get_the_title();
        }
        // add product to array but don't add the parent of product variations
        if (!empty($sku)) $full_product_list[] = array($thetitle, $sku, $theid);
    endwhile; wp_reset_query();
    // sort into alphabetical order, by title
    sort($full_product_list);
    return $full_product_list;
}
if(empty($layout)) {
	$layout = 'right';
}
$blog_style = '';
$column = '';
get_header(); ?>
<div id="theme-page">
	<div class="pacz-main-wrapper-holder">
		<div class="theme-page-wrapper pacz-main-wrapper <?php echo esc_attr($layout); ?>-layout pacz-grid vc_row-fluid">
			<div class="inner-page-wrapper">
				<div class="theme-content  author-page" itemprop="mainContentOfPage">
					<?php
					$output .='<div class="author-detail-section clearfix">';
						$output .='<div class="author-thumbnail">';
							if(!empty($author_img_url)) {
								$params = array( 'width' => 300, 'height' => 370, 'crop' => true );
								$output .= "<img src='" . bfi_thumb( "$author_img_url", $params ) . "' alt='' />";
							} else { 
								$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $authorID), $size = '300' );
								$output .='<img src="'.$avatar_url.'" alt="author" />';
							}
						$output .='</div>';
						$output .='<div class="author-content-section">';
							$output .='<div class="author-title">'.$author_name.$author_log_status.'</div>';
							$output .='<p class="author-reg-date">'. esc_html__('Member since', 'classiadspro').' '.$registered.'</p>';
							if($author_verified == 'verified'){
								$output .='<span class="author_verifed ">'. esc_html__('Verified', 'classiadspro').'</span>';
							}else{
								$output .='<span class="author_unverifed ">'. esc_html__('Unverified', 'classiadspro').'</span>';
							}
							if($ALSP_ADIMN_SETTINGS['frontend_panel_user_type']){
								if(isset($author_type) && !empty($author_type)){
									if($author_type == 'dealer'){
									$author_type = esc_html__('Dealer', 'classiadspro');
									}else if($author_type == 'individual'){
										$author_type = esc_html__('Individual', 'classiadspro');
									}else if($author_type == 'agency'){
										$author_type = esc_html__('Agency', 'classiadspro');
									}else if($author_type == 'supplier'){
										$author_type = esc_html__('Supplier', 'classiadspro');
									}
									$output .='<span class="author_type ">'. $author_type.'</span>';
								}
							}
							if(class_exists('alsp_plugin')){
								$output .='<div class="author-details">';
									if($ALSP_ADIMN_SETTINGS['frontend_panel_user_phone']){ $output .='<p class=" clearfix"><span class="author-info-title">'.esc_html__('Mobile ', 'classiadspro').'</span><span class="author-info-content">'.$phone_number.'</span></p>'; }
									if($ALSP_ADIMN_SETTINGS['frontend_panel_user_email']){ $output .='<p class=" clearfix"><span class="author-info-title">'.esc_html__('Email ', 'classiadspro').'</span><span class="author-info-content">'.$author_email.'</span></p>'; }
									if($ALSP_ADIMN_SETTINGS['frontend_panel_user_website']){ $output .='<p class=" clearfix"><span class="author-info-title">'.esc_html__('Website ', 'classiadspro').'</span><span class="author-info-content">'.$author_website.'</span></p>'; }
									if($ALSP_ADIMN_SETTINGS['frontend_panel_user_address']){ $output .='<p class=" clearfix"><span class="author-info-title">'.esc_html__('Address ', 'classiadspro').'</span><span class="author-info-content">'.$author_address.'</span></p>'; }
									if($ALSP_ADIMN_SETTINGS['frontend_panel_social_links']){
										$output .='<div class="author-details-info clearfix"><span class="author-info-title">'.esc_html__('Follow Me ', 'classiadspro').'</span>';
											$output .='<ul class="author-info-content">';
											
												if(!empty($author_fb)){
													$output .='<li><a href="'.$author_fb.'" target_blank><i class="pacz-icon-facebook"></i></a></li>';
												}
												if(!empty($author_tw)){
													$output .='<li><a href="'.$author_tw.'" target_blank><i class="pacz-icon-twitter"></i></a></li>';
												}
												if(!empty($author_gplus)){
													$output .='<li><a href="'.$author_gplus.'" target_blank><i class="pacz-icon-google-plus"></i></a></li>';
												}
												if(!empty($author_linkedin)){
													$output .='<li><a href="'.$author_linkedin.'" target_blank><i class="pacz-icon-linkedin"></i></a></li>';
												}
												if(!empty($author_ytube)){
													$output .='<li><a href="'.$author_ytube.'" target_blank><i class="pacz-icon-youtube"></i></a></li>';
												}
												if(!empty($author_vimeo)){
													$output .='<li><a href="'.$author_vimeo.'" target_blank><i class="pacz-icon-vimeo-square"></i></a></li>';
												}
												if(!empty($author_instagram)){
													$output .='<li><a href="'.$author_instagram.'" target_blank><i class="pacz-icon-instagram"></i></a></li>';
												}
												if(!empty($author_flickr)){
													$output .='<li><a href="'.$author_flickr.'" target_blank><i class="pacz-icon-flickr"></i></a></li>';
												}
												if(!empty($author_behance)){
													$output .='<li><a href="'.$author_behance.'" target_blank><i class="pacz-icon-behance"></i></a></li>';
												}
												if(!empty($author_dribbble)){
													$output .='<li><a href="'.$author_dribbble.'" target_blank><i class="pacz-icon-dribbble"></i></a></li>';
												}
											
											$output .='</ul>';
										$output .='</div>';
									}	
								$output .='</div>';
							}
						$output .='</div>';
					$output .='</div>';
					echo $output;
			/* Run the blog loop shortcode to output the posts. */
			if(class_exists('WPBakeryShortCode') &&  class_exists('alsp_plugin') && $ALSP_ADIMN_SETTINGS['single_listing_other_ads_byuser']){
				$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
				$authorID = $author->ID;
				$single_listing_othoradd_limitv = $ALSP_ADIMN_SETTINGS['single_listing_othoradd_limit'];
				$single_listing_otherads_viewshitcherv = $ALSP_ADIMN_SETTINGS['single_listing_otherads_viewshitcher'];
				$hide_ordering_single_listing_otheradsv = $ALSP_ADIMN_SETTINGS['hide_ordering_single_listing_otherads'];
				$single_listing_otherads_view_typev = $ALSP_ADIMN_SETTINGS['single_listing_otherads_view_type'];
				$single_listing_otherads_gridview_colv = $ALSP_ADIMN_SETTINGS['single_listing_otherads_gridview_col'];
				if(isset($single_listing_othoradd_limitv)){
					$single_listing_othoradd_limit = $ALSP_ADIMN_SETTINGS['single_listing_othoradd_limit'];
				}else{
					$single_listing_othoradd_limit = 4;
				}
				if(isset($single_listing_otherads_viewshitcherv)){
					$single_listing_otherads_viewshitcher = $ALSP_ADIMN_SETTINGS['single_listing_otherads_viewshitcher'];
				}else{
					$single_listing_otherads_viewshitcher = 0;
				}
				if(isset($hide_ordering_single_listing_otheradsv)){
					$hide_ordering_single_listing_otherads = $ALSP_ADIMN_SETTINGS['hide_ordering_single_listing_otherads'];
				}else{
					$hide_ordering_single_listing_otherads = 1;
				}
				if(isset($single_listing_otherads_view_typev)){
					$single_listing_otherads_view_type = $single_listing_otherads_view_typev;
				}else{
					$single_listing_otherads_view_type = 'list';
				}
				if(isset($single_listing_otherads_gridview_colv)){
					$single_listing_otherads_gridview_col = $ALSP_ADIMN_SETTINGS['single_listing_otherads_gridview_col'];
				}else{
					$single_listing_otherads_gridview_col = 2;
				}
				echo do_shortcode('[webdirectory-listings perpage="'.$single_listing_othoradd_limit.'" show_views_switcher="'.$single_listing_otherads_viewshitcher.'" hide_order="'.$hide_ordering_single_listing_otherads.'" hide_paginator="1" order_by="post_date" order="DESC" hide_count="1" listings_view_type="'.$single_listing_otherads_view_type.'" listings_view_grid_columns="'.$single_listing_otherads_gridview_col.'" author="'.$authorID.'"]');
				
			}
			?>
			
<div class="clearboth"></div>	
		
		</div>
		<?php if($layout != 'full') get_sidebar(); ?>	
		</div>
		
		<div class="clearboth"></div>
	</div>	
</div>
<?php endif; ?>
<?php get_footer(); ?>