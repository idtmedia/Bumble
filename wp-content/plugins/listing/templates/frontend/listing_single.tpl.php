<?php global $ALSP_ADIMN_SETTINGS; ?>

		<?php 
		
$layoutpost_id = global_get_post_id();

$layout = get_post_meta($layoutpost_id, '_layout', true );
$padding = get_post_meta($layoutpost_id, '_padding', true );
global $post, $alsp_dynamic_styles;
$alsp_styles = '';
$id = uniqid();

	if(class_exists('Mobile_Detect')){
		$detect_mobile = new Mobile_Detect();
	}
	

			if($ALSP_ADIMN_SETTINGS['alsp_single_listing_style'] == 2 ){ ?>
					
		<div class="single-listing single-style2 alsp-content">
			
			<?php alsp_renderMessages(); ?>

			<?php if ($frontend_controller->listings): ?>
			<?php while ($frontend_controller->query->have_posts()): ?>
				<?php $frontend_controller->query->the_post(); ?>
				<?php $listing = $frontend_controller->listings[get_the_ID()]; ?>
				<?php
					$authorID = get_the_author_meta( 'ID' );
					$GLOBALS['authorID2'] = $authorID;
					$GLOBALS['listing_id'] = $frontend_controller->listings[get_the_ID()];
					$GLOBALS['listing_id_resurva'] = $listing->post->ID;
					$image_number = count($listing->images);
					if($image_number == 1){
						$desktop_items = 1;
						$tabt_ls_items = 1;
						$tab_items = 1;
						$loop = false;
						$nav = false;
					}elseif($image_number == 2){
						$desktop_items = 2;
						$tabt_ls_items = 2;
						$tab_items = 2;
						$loop = false;
						$nav = false;
						
						$alsp_styles .= '
								.owl-item:nth-child(odd){text-align:right;}
								.owl-item:nth-child(even){text-align:left;}
								.alsp-single-listing-logo-wrap.style2 .owl-item a{text-align:center;}
							';
					}elseif($image_number == 3){
						$desktop_items = 3;
						$tabt_ls_items = 3;
						$tab_items = 2;
						$loop = false;
						$nav = false;
					}elseif($image_number >= 4){
						$desktop_items = (isset($ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_desktop_items']))? $ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_desktop_items']: 4;
						$tabt_ls_items = (isset($ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_tab_lanscape_items']))? $ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_tab_lanscape_items']: 3;
						$tab_items = (isset($ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_tab_items']))? $ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_tab_items']: 2;
						$loop = (isset($ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_loop']))? $ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_loop']: true;
						$nav = (isset($ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_nav']))? $ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_nav']: true;
						$autoplay = (isset($ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_autoplay']))? $ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_autoplay']: true;
						$autowidth = (isset($ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_autowidth']))? $ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_autowidth']: false;
						$autoplaySpeed = (isset($ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_autoplaySpeed ']))? $ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_autoplaySpeed ']: 1000;
						$autoplayGutter = (isset($ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_autoplayGutter']))? $ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_autoplayGutter']: 5;
						$autoplayDelay = (isset($ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_autoplayDelay']))? $ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_autoplayDelay']: 1000;
						$center = (isset($ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_center']))? $ALSP_ADIMN_SETTINGS['alsp_single_listing_owl_center']: false;
					}
					if(!$detect_mobile->isMobile()){
						$owl_lazy = 'owl-lazy';
						$owl_loading = 'owl-loading';
					}else{
						$owl_lazy = '';
						$owl_loading = '';
					}
				?>
				<div class="listing-top-content">
					<?php if ($listing->logo_image && (!get_option('alsp_exclude_logo_from_listing') || count($listing->images) > 1)): ?>
							<div class="alsp-listing-logo-wrap alsp-single-listing-logo-wrap style2" id="images">
								
								<div class="single-listing-scroller  bgwhite shadow-1">
									<!-- declare a slideshow -->
										
										<div class="owl-carousel owl-carousel-single hide-owl <?php echo $owl_loading; ?>" data-items="<?php echo $desktop_items; ?>" data-items-tab-ls="<?php echo $tabt_ls_items; ?>" data-items-tab="<?php echo $tab_items; ?>" data-autoplay="<?php echo $autoplay; ?>" data-autowidth="<?php echo $autowidth; ?>" data-center="<?php echo $center; ?>" data-loop="<?php echo $loop; ?>" data-nav="<?php echo $nav; ?>" data-delay="1000" data-autoplay-speed="1000" data-gutter="5">
									
										<?php
										$images = array();
										
										$full_with_image = $ALSP_ADIMN_SETTINGS['alsp_100_single_logo_width'];
										if($full_with_image){
											$width = '';
											$height = '';
										}elseif($image_number <= 4){
											$width = '';
											$height = $ALSP_ADIMN_SETTINGS['alsp_single_logo_height'];
										}else{
											$width = $ALSP_ADIMN_SETTINGS['alsp_single_logo_width'];
											$height = $ALSP_ADIMN_SETTINGS['alsp_single_logo_height'];
										}
										
										require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php"; 
										foreach ($listing->images AS $attachment_id=>$image):
											$image_number = count($listing->images);
											if (!get_option('alsp_exclude_logo_from_listing') || $listing->logo_image != $attachment_id) {
												$image_src_array = wp_get_attachment_image_src($attachment_id, 'full');
												$image_src       = bfi_thumb($image_src_array[0], array(
													'width' => $width,
													'height' => $height,
													'crop' => true
												));
											
												if ($ALSP_ADIMN_SETTINGS['alsp_enable_lighbox_gallery']){
													if($detect_mobile->isMobile()){
														$images = '<a href="' . $image_src_array[0] . '" data-lightbox="listing_images" title="' . esc_attr($image['post_title']) . '"><img class="" src="' . pacz_thumbnail_image_gen($image_src, $width, $height) . '" width="'.$width.'" height="'.$height.'"  alt="' . esc_attr($image['post_title']) . '"/><i class="pacz-fic4-zoom-out"></i></a>';
													}else{
														$images = '<a href="' . $image_src_array[0] . '" data-lightbox="listing_images" title="' . esc_attr($image['post_title']) . '"><img class="owl-lazy" data-src="' . pacz_thumbnail_image_gen($image_src, $width, $height) . '" width="'.$width.'" height="'.$height.'"  alt="' . esc_attr($image['post_title']) . '"/><i class="pacz-fic4-zoom-out"></i></a>';
													}
												}else{
													if($detect_mobile->isMobile()){
														$images = '<img class="" src="' . pacz_thumbnail_image_gen($image_src, $width, $height) . '" width="'.$width.'" height="'.$height.'"  alt="' . esc_attr($image['post_title']) . '"/>';
													}else{
														$images = '<img class="owl-lazy" data-src="' . pacz_thumbnail_image_gen($image_src, $width, $height) . '" width="'.$width.'" height="'.$height.'"  alt="' . esc_attr($image['post_title']) . '"/>';
													}
												}	
											}
											echo $images;
										endforeach;
										?>
									</div>
								</div>
							</div>
						<?php elseif(!isset($listing->logo_image) && !get_option('alsp_exclude_logo_from_listing')): ?>	
							<div class="alsp-listing-logo-wrap alsp-single-listing-logo-wrap" id="images">
								<?php
									$images = array();	
									$full_with_image = $ALSP_ADIMN_SETTINGS['alsp_100_single_logo_width'];
									if($full_with_image){
										$width = '';
										$height = '';
									}else{
										$width = $ALSP_ADIMN_SETTINGS['alsp_single_logo_width'];
										$height = $ALSP_ADIMN_SETTINGS['alsp_single_logo_height'];
									}
									$image_src_array = wp_get_attachment_image_src($attachment_id, 'full');
									$image_src = bfi_thumb($image_src_array[0], array(
										'width' => $width,
										'height' => $height,
										'crop' => true
									));
									$images = '<img src="' . pacz_thumbnail_image_gen($image_src, $width, $height) . '" alt="' . esc_attr($image['post_title']) . '"/>';
									echo $images;
								?>
							</div>
							<div class="clearfix"></div>
						<?php endif; ?>
				</div>
					<div class="listing-header-wrap">
						<div class="pacz-grid">
							<?php if ($listing->title()): ?>
								<?php 
									$authorID = get_the_author_meta( 'ID' );
									$author_verified = get_the_author_meta('author_verified', $authorID);
									if ( $author_verified == 'verified' ){
										$author_verified_icon = '<span class="verified-ad-tag"><i class="author-verified pacz-icon-check-circle"></i>'.esc_html__('verified ad', 'ALSP').'</span>';
									} else {
										$author_verified_icon = '<span class="unverified-ad-tag"><i class="author-unverified pacz-icon-check-circle"></i>'.esc_html__('unverified ad', 'ALSP').'</span>';
									}

								?>
								<header class="alsp-listing-header clearfix">
									<?php if ($frontend_controller->breadcrumbs): ?>
										<ul class="alsp-breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
											<?php echo $frontend_controller->getBreadCrumbs(); ?>
										</ul>
									<?php endif; ?>
									<h2 itemprop="name"><?php echo $listing->title(); ?><?php echo $author_verified_icon; ?></h2>
									<div class="price">
                                        <label><?php _e('Budget'); ?></label>
										<?php
										
											global $wpdb;
											$field_ids = $wpdb->get_results('SELECT id, type, slug FROM '.$wpdb->prefix.'alsp_content_fields');
											foreach( $field_ids as $field_id ) {
												$singlefield_id = $field_id->id;
												if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){			
													$listing->renderContentField($singlefield_id);
												}				
											}
										?>
									</div>
									<?php 
										global $direviews_plugin;
										if ( method_exists( $direviews_plugin, 'get_average_rating' ) ) {
											$rating = $direviews_plugin->get_average_rating( $listing->post->ID);
										}
										if (!empty($rating)):
									?>
									<div class="listing-rating">
										<span class="rating-numbers"><?php echo get_average_listing_rating(); ?></span>
										<span class="rating-stars"><?php echo display_average_listing_rating(); ?></span>
									</div>
									<?php endif; ?>
								</header>
								<div class="listing-metas-single clearfix">
										
									
									<div class="alsp-listing-date" datetime="<?php echo date("Y-m-d", mysql2date('U', $listing->post->post_date)); ?>T<?php echo date("H:i", mysql2date('U', $listing->post->post_date)); ?>"><i class="pacz-fic3-clock-circular-outline"></i><?php echo get_the_date(); ?></div>
									<div class="listing-views"><i class="pacz-fic3-medical"></i><?php echo sprintf(__('Views: %d', 'ALSP'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)); ?></div>
									<div class="listing-id"><i class="pacz-fic4-bookmark-white"></i><?php echo esc_html__('Ad ID', 'ALSP').': '.$listing->post->ID; ?></div>
									<div class="listing-cat-single">
									<?php
										
										$terms = get_the_terms($listing->post->ID, ALSP_CATEGORIES_TAX);
										global $pacz_settings, $accent_color;
										if(is_array($terms)){
											foreach ($terms AS $key=>$term):
												if(alsp_getCategorycolor($term->term_id)){
													$cat_bg_color = alsp_getCategorycolor($term->term_id);
												}else{
													$cat_bg_color = $pacz_settings['accent-color'];
												}
												$term_link = get_term_link( $term );
												if ($term->parent == 0){ 
													echo '<a class="alsp-cat" style="background-color:'.$cat_bg_color.';" href="' . $term_link. '" title="'.$term->name.'">'.$term->name.'</a>';
												}
											endforeach;	
										}
									?>
									
									</div>
								</div>
								<div class="single-listing-btns">
									<ul class="clearfix">
										<?php if ($ALSP_ADIMN_SETTINGS['alsp_share_buttons']['enabled']): ?>
											<li class="sharing-poppover">
												<?php 
													echo '<a class="alsp-sharing-btn" data-popup-open="single_sharing_data" href="#">'.esc_html__('Share Listing', 'ALSP').'</a>';
													echo '<div class="popup" data-popup="single_sharing_data">';
														echo '<div class="popup-inner single-contact">';
															echo '<div class="alsp-popup-title">'.esc_html__('Share This Listing', 'ALSP').'<a class="popup-close" data-popup-close="single_sharing_data" href="#"><i class="pacz-fic4-error"></i></a></div>';
															echo '<div class="alsp-popup-content">';
																alsp_frontendRender('frontend/sharing_buttons_ajax_call.tpl.php', array('post_id' => $listing->post->ID));
															echo'</div>';
														echo'</div>';
													echo'</div>';
												?>
											</li>
										<?php endif; ?>
										
										
										<?php alsp_frontendRender('frontend/frontpanel_buttons.tpl.php', array('listing' => $listing)); ?>
										
									</ul>
									
								</div>
								<div class="clearfix"></div>
							<?php endif; ?>
								</div>
							</div>
						
				<div class="pacz-grid">
				<div id="<?php echo $listing->post->post_name; ?>" class="row" itemscope itemtype="http://schema.org/LocalBusiness">
					<div class="theme-content">


					<article id="post-<?php the_ID(); ?>" class="alsp-listing">
						<div class="listing-main-content clearfix">
							
						<div class="alsp-single-listing-text-content-wrap">


                            <?php
                            echo '<p class="message">';
                            if ($_POST['post_application_nonce'] != "") {
                                Job_board::post_application($_POST);
                            }
                            echo '</p>';
                            //Show time count down
                           /* $duration = get_post_meta( get_the_ID(), '_content_field_38', true );
                            if($duration>0) {
                                switch ($duration) {
                                    case 1:
                                        $life_time = 259200;
                                        break;
                                    case 2:
                                        $life_time = 604800;
                                        break;
                                    case 3:
                                        $life_time = 1209600;
                                        break;
                                    case 4:
                                    default:
                                        $life_time = 2592000;
                                        break;
                                }
                                $expiration_date_time = get_the_time('U') + $life_time;
                                //

                            }*/

                            $expiration_date_time = get_post_meta( get_the_ID(), '_expiration_date', true );
//                            echo $expiration_date_time;
                            ?>
                            <!-- Display the countdown timer in an element -->
                            <div class="alsp-field alsp-field-output-block alsp-field-output-block-string alsp-field-output-block-37">
                            <span class="alsp-field-caption">
                                            <span class="alsp-field-name"><?php _e('THIS JOB WILL EXPIRE IN'); ?>:</span>
                                </span>
                                                    <span class="alsp-field-content" id="time-countdown">
                            	</span>
                            </div>

                            <script>
                                // Set the date we're counting down to
                                //                            var countDownDate = new Date("Jan 5, 2019 15:37:25").getTime();
                                var countDownDate = new Date("<?php echo date('M d, Y H:i:s', $expiration_date_time) ?>").getTime();
                                console.log(countDownDate);

                                // Update the count down every 1 second
                                var x = setInterval(function() {

                                    // Get todays date and time
                                    var now = new Date().getTime();
//                                    console.log(now);
                                    // Find the distance between now and the count down date
                                    var distance = countDownDate - now;

                                    // Time calculations for days, hours, minutes and seconds
                                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                    // Display the result in the element with id="demo"
                                    document.getElementById("time-countdown").innerHTML = days + "d " + hours + "h "
                                        + minutes + "m " + seconds + "s ";

                                    // If the count down is finished, write some text
                                    if (distance < 0) {
                                        clearInterval(x);
                                        document.getElementById("time-countdown").innerHTML = "EXPIRED";
                                    }
                                }, 1000);
                            </script>
							<?php if ($ALSP_ADIMN_SETTINGS['alsp_share_buttons']['enabled'] && $ALSP_ADIMN_SETTINGS['alsp_share_buttons_place'] == 'before_content'): ?>
							<?php alsp_frontendRender('frontend/sharing_buttons_ajax_call.tpl.php', array('post_id' => $listing->post->ID)); ?>
							<?php endif; ?>
						
							<?php do_action('alsp_listing_pre_content_html', $listing); ?>
					
							<?php $listing->renderContentFields(true); ?>
							<?php $listing->renderContentFields_ingroup(true); ?>
							<?php do_action('alsp_listing_post_content_html', $listing); ?>
							
						</div>
						<?php if($ALSP_ADIMN_SETTINGS['single_listing_tab']): ?>
						<script>
							(function($) {
								"use strict";
	
								$(function() {
									<?php if ($ALSP_ADIMN_SETTINGS['alsp-listings-tabs-order']['enabled']): 
									
									$tab_ordering = $ALSP_ADIMN_SETTINGS['alsp-listings-tabs-order']['enabled'];
									?>
									if (1==2) var x = 1;
									<?php foreach ($tab_ordering as $key=>$value): ?>
									else if ($('#<?php echo $key; ?>').length)
										alsp_show_tab($('.alsp-listing-tabs a[data-tab="#<?php echo $key; ?>"]'));
									<?php endforeach; ?>
									<?php else: ?>
									alsp_show_tab($('.alsp-listing-tabs a:first'));
									<?php endif; ?>
								});
							})(jQuery);
						</script>
						

						<?php 
						
						if (
							($fields_groups = $listing->getFieldsGroupsOnTabs())
							|| ($listing->level->google_map && $listing->isMap() && $listing->locations)
							|| (alsp_comments_open())
							|| ($listing->level->videos_number && $listing->videos)
							|| ($ALSP_ADIMN_SETTINGS['alsp_listing_contact_form'] && (!$listing->is_claimable || !$ALSP_ADIMN_SETTINGS['alsp_hide_claim_contact_form']))
							): ?>
						<?php if($detect_mobile->isMobile()){ ?>
							<ul class="alsp-listing-tabs nav navbar-nav clearfix" role="tablist">
								<?php if ($ALSP_ADIMN_SETTINGS['map_on_single_listing_tab'] && $listing->level->google_map && $listing->isMap() && $listing->locations): ?>
								<li><a href="javascript: void(0);" data-tab="#addresses-tab" role="tab"><i class="pacz-icon-home"></i><?php _e('Map Views', 'ALSP'); ?></a></li>
								<?php endif; ?>
								<?php if (alsp_comments_open() && $ALSP_ADIMN_SETTINGS['alsp_listings_comments_position'] == 'intab'): ?>
								<li><a href="javascript: void(0);" data-tab="#comments-tab" role="tab"><i class="pacz-icon-comments-o"></i><?php echo _n('Comment', 'Comments', $listing->post->comment_count, 'ALSP'); ?> (<?php echo $listing->post->comment_count; ?>)</a></li>
								<?php endif; ?>
								<?php if ($listing->level->videos_number && $listing->videos && $ALSP_ADIMN_SETTINGS['alsp_listings_video_position'] == 'intab'): ?>
								<li><a href="javascript: void(0);" data-tab="#videos-tab" role="tab"><i class="pacz-icon-play"></i><?php echo _n('Video', 'Videos', count($listing->videos), 'ALSP'); ?> (<?php echo count($listing->videos); ?>)</a></li>
								<?php endif; ?>
								<?php
								foreach ($fields_groups AS $fields_group): ?>
								<li><a href="javascript: void(0);" data-tab="#field-group-tab-<?php echo $fields_group->id; ?>" role="tab"><?php echo $fields_group->name; ?></a></li>
								<?php endforeach; ?>
							</ul>
							
						<?php }else{ ?>
						<ul class="alsp-listing-tabs nav nav-tabs clearfix" role="tablist">
							<?php if ($ALSP_ADIMN_SETTINGS['map_on_single_listing_tab'] && $listing->level->google_map && $listing->isMap() && $listing->locations && $ALSP_ADIMN_SETTINGS['alsp_listings_map_position'] == 'intab'): ?>
							<li><a href="javascript: void(0);" data-tab="#addresses-tab" data-toggle="alsp-tab" role="tab"><i class="pacz-icon-home"></i><?php _e('Map Views', 'ALSP'); ?></a></li>
							<?php endif; ?>
							<?php if (alsp_comments_open() && $ALSP_ADIMN_SETTINGS['alsp_listings_comments_position'] == 'intab'): ?>
							<li><a href="javascript: void(0);" data-tab="#comments-tab" data-toggle="alsp-tab" role="tab"><i class="pacz-icon-comments-o"></i><?php echo _n('Comment', 'Comments', $listing->post->comment_count, 'ALSP'); ?> (<?php echo $listing->post->comment_count; ?>)</a></li>
							<?php endif; ?>
							<?php if ($listing->level->videos_number && $listing->videos): ?>
							<li><a href="javascript: void(0);" data-tab="#videos-tab" data-toggle="alsp-tab" role="tab"><i class="pacz-icon-play"></i><?php echo _n('Video', 'Videos', count($listing->videos), 'ALSP'); ?> (<?php echo count($listing->videos); ?>)</a></li>
							<?php endif; ?>
							<?php
							foreach ($fields_groups AS $fields_group): ?>
							<li><a href="javascript: void(0);" data-tab="#field-group-tab-<?php echo $fields_group->id; ?>" data-toggle="alsp-tab" role="tab"><?php echo $fields_group->name; ?></a></li>
							<?php endforeach; ?>
						</ul>
						<?php } ?>
						<div class="tab-content">
							<?php if ($listing->level->google_map && $listing->isMap() && $listing->locations): ?>
							<div id="addresses-tab" class="tab-pane fade" role="tabpanel">
							
								<?php $listing->renderMap($frontend_controller->hash, $ALSP_ADIMN_SETTINGS['alsp_show_directions'], false, $ALSP_ADIMN_SETTINGS['alsp_enable_radius_search_cycle'], $ALSP_ADIMN_SETTINGS['alsp_enable_clusters'], false, false); ?>
							</div>
							<?php endif; ?>

							<?php if (alsp_comments_open() && $ALSP_ADIMN_SETTINGS['alsp_listings_comments_position'] == 'intab'): ?>
							<div id="comments-tab" class="tab-pane fade" role="tabpanel">
								<?php comments_template( '', true ); ?>
							</div>
							<?php endif; ?>

							<?php if ($listing->level->videos_number && $listing->videos): ?>
							<div id="videos-tab" class="tab-pane fade" role="tabpanel">
							<?php foreach ($listing->videos AS $video): ?>
									<?php if (strlen($video['id']) == 11): ?>
										<iframe width="100%" height="400" class="alsp-video-iframe fitvidsignore" src="//www.youtube.com/embed/<?php echo $video['id']; ?>" frameborder="0" allowfullscreen></iframe>
									<?php elseif (strlen($video['id']) == 9): ?>
										<iframe width="100%" height="400" class="alsp-video-iframe fitvidsignore" src="https://player.vimeo.com/video/<?php echo $video['id']; ?>?color=d1d1d1&title=0&byline=0&portrait=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
									<?php endif; ?>
							<?php endforeach; ?>
							</div>
							<?php endif; ?>

							
							<?php foreach ($fields_groups AS $fields_group): ?>
							<div id="field-group-tab-<?php echo $fields_group->id; ?>" class="tab-pane fade" role="tabpanel">
								<?php echo $fields_group->renderOutput($listing); ?>
							</div>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
						<?php endif; ?>
						<?php if ($listing->level->videos_number && $listing->videos && $ALSP_ADIMN_SETTINGS['alsp_listings_video_position'] == 'notab'): ?>
							<div id="videos-notab" class="notab">
							<span class="alsp-video-field-name"><?php echo esc_html__('Videos', 'ALSP'); ?></span>
							<?php foreach ($listing->videos AS $video): ?>
									<?php if (strlen($video['id']) == 11): ?>
										<iframe width="100%" height="400" class="alsp-video-iframe fitvidsignore" src="//www.youtube.com/embed/<?php echo $video['id']; ?>" frameborder="0" allowfullscreen></iframe>
									<?php elseif (strlen($video['id']) == 9): ?>
										<iframe width="100%" height="400" class="alsp-video-iframe fitvidsignore" src="https://player.vimeo.com/video/<?php echo $video['id']; ?>?color=d1d1d1&title=0&byline=0&portrait=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
									<?php endif; ?>
							<?php endforeach; ?>
							</div>
						<?php endif; ?>
						<?php if ($ALSP_ADIMN_SETTINGS['map_on_single_listing_tab'] && $listing->level->google_map && $listing->isMap() && $listing->locations && $ALSP_ADIMN_SETTINGS['alsp_listings_map_position'] == 'notab'): ?>
							<div class="single-map">
								<?php $listing->renderMap($frontend_controller->hash, $ALSP_ADIMN_SETTINGS['alsp_show_directions'], false, $ALSP_ADIMN_SETTINGS['alsp_enable_radius_search_cycle'], $ALSP_ADIMN_SETTINGS['alsp_enable_clusters'], false, false); ?>
							</div>
						<?php endif; ?>
						
						<?php require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php"; ?>
						<?php 
							$authorID = get_the_author_meta( 'ID' );
							$author_img_url = get_user_meta($authorID, "pacz_author_avatar_url", true); 
						?>
						<?php if (alsp_comments_open() && $ALSP_ADIMN_SETTINGS['alsp_listings_comments_position'] == 'notab'): ?>
							<div id="comments-reviews">
								<?php comments_template( '', true ); ?>
							</div>
						<?php endif; ?>
						
					</article>
				
				<?php
				/* Run the blog loop shortcode to output the posts. */
			
				$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
				$authorID = get_the_author_meta( 'ID' );
				$authoruser = get_the_author_meta( 'user_nicename' );
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
				if($ALSP_ADIMN_SETTINGS['single_listing_other_ads_byuser']){
				echo '<div class="similar-author-ads">';
					echo do_shortcode('[webdirectory-listings perpage="'.$single_listing_othoradd_limit.'" show_views_switcher="'.$single_listing_otherads_viewshitcher.'" hide_order="'.$hide_ordering_single_listing_otherads.'" hide_paginator="1" order_by="post_date" order="DESC" hide_count="1" listings_view_type="'.$single_listing_otherads_view_type.'" listings_view_grid_columns="'.$single_listing_otherads_gridview_col.'" author="'.$authorID.'"]');
				echo '</div>';
				}
			?>
			<?php 
			if($ALSP_ADIMN_SETTINGS['alsp_listing_contact']){
				
				echo '<div class="popup" data-popup="single_contact_form">';
					echo '<div class="popup-inner single-contact">';
						echo '<div class="alsp-popup-title">'.esc_html__('Send Message', 'ALSP').'<a class="popup-close" data-popup-close="single_contact_form" href="#"><i class="pacz-fic4-error"></i></a></div>';
						echo '<div class="alsp-popup-content">';
							global $current_user;
							
							$listing_owner = get_userdata($listing->post->post_author);
							if( is_user_logged_in() && $current_user->ID == $authorID) {
								echo esc_html__('You can not send message on your own lisitng', 'ALSP');
							}elseif(!is_user_logged_in()) {
								echo esc_html__('Login Required', 'ALSP');
							}elseif( current_user_can('administrator')) {
								echo esc_html__('Administrator can not send message from front-end', 'ALSP');
							}else{
								if($ALSP_ADIMN_SETTINGS['message_system'] == 'instant_messages'){
									echo '<div class="form-new">';
									echo do_shortcode('[difp_shortcode_new_message_form to="'.$authoruser.'" listing_id="'.$listing->post->ID.'" subject="'.$listing->title().'"]');
									
									echo '</div>';
								}elseif($ALSP_ADIMN_SETTINGS['message_system'] == 'email_messages'){
									if ($ALSP_ADIMN_SETTINGS['alsp_listing_contact_form'] && (!$listing->is_claimable || !$ALSP_ADIMN_SETTINGS['alsp_hide_claim_contact_form']) && ($listing_owner = get_userdata($listing->post->post_author)) && $listing_owner->user_email){
											
										if (defined('WPCF7_VERSION') && alsp_get_wpml_dependent_option('alsp_listing_contact_form_7')){
											echo do_shortcode(alsp_get_wpml_dependent_option('alsp_listing_contact_form_7'));
										}else{
											alsp_frontendRender('frontend/contact_form.tpl.php', array('listing' => $listing)); 
												
										}
											
									}
								}else{
									echo esc_html__('Messages are currenlty disabled by Site Owner', 'ALSP');
								}
							}
						echo'</div>';
					echo'</div>';
				echo'</div>';
			}
			if($ALSP_ADIMN_SETTINGS['alsp_listing_bidding']){
				echo '<div class="popup" data-popup="single_contact_form_bid">';
					echo '<div class="popup-inner single-contact">';
						echo '<div class="alsp-popup-title">'.esc_html__('SUBMIT YOUR BID FOR THIS PROJECT', 'ALSP').'<a class="popup-close" data-popup-close="single_contact_form_bid" href="#"><i class="pacz-fic4-error"></i></a></div>';
						echo '<div class="alsp-popup-content">';
							global $current_user;
							$listing_owner = get_userdata($listing->post->post_author);
							if( is_user_logged_in() && $current_user->ID == $authorID) {
								echo esc_html__('You can not send application on your own job', 'ALSP');
							}elseif(!is_user_logged_in()) {
								echo esc_html__('Login Required', '');
							}elseif( current_user_can('administrator')) {
								echo esc_html__('Administrator can not send application from front-end', 'ALSP');
							}else{
//								echo '<div class="form-new bidding-form">'.do_shortcode('[difp_shortcode_new_bidding_form to="'.$authoruser.'" listing_id="'.$listing->post->ID.'" subject="'.$listing->title().'"]').'</div>';
								echo '<div class="form-new bidding-form">'.do_shortcode('[bidding_form job_id='.$listing->post->ID.']').'</div>';
							}
						echo'</div>';
					echo'</div>';
				echo'</div>';
			}
				?>
			
				<div id="myModal" class="modal fade" role="dialog">
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-body">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
						<?php if ($ALSP_ADIMN_SETTINGS['alsp_listing_contact_form'] && (!$listing->is_claimable || !$ALSP_ADIMN_SETTINGS['alsp_hide_claim_contact_form']) && ($listing_owner = get_userdata($listing->post->post_author)) && $listing_owner->user_email): ?>
							<div id="contact-tab" class="tab-pane" role="tabpanel">
							<?php if (defined('WPCF7_VERSION') && alsp_get_wpml_dependent_option('alsp_listing_contact_form_7')): ?>
								<?php echo do_shortcode(alsp_get_wpml_dependent_option('alsp_listing_contact_form_7')); ?>
							<?php else: ?>
								<?php alsp_frontendRender('frontend/contact_form.tpl.php', array('listing' => $listing)); ?>
							<?php endif; ?>
							</div>
							<?php endif; ?>
					  </div>
					</div>
					</div>
				  </div>
				
			<?php endwhile; wp_reset_query(); endif; ?>
			
			</div>
			<?php if($layout != 'full') get_sidebar(); ?>
		</div>	
		</div>		
		</div>	
		<?php 
			// Hidden styles node for head injection after page load through ajax
			echo '<div id="ajax-'.$id.'" class="alsp-dynamic-styles">';
			echo '</div>';

			// Export styles to json for faster page load
			$alsp_dynamic_styles[] = array(
			  'id' => 'ajax-'.$id ,
			  'inject' => $alsp_styles
			);
		?>
		<?php }else{ ?>
		<div class="single-listing alsp-content single-style-default">
			<?php alsp_renderMessages(); ?>

			<?php if ($frontend_controller->listings): ?>
			<?php while ($frontend_controller->query->have_posts()): ?>
				<?php $frontend_controller->query->the_post(); ?>
				<?php $listing = $frontend_controller->listings[get_the_ID()]; ?>
				<?php
					$GLOBALS['listing_id'] = $frontend_controller->listings[get_the_ID()];
					$authorID = get_the_author_meta( 'ID' );
					$GLOBALS['authorID2'] = $authorID;
					$GLOBALS['listing_id_resurva'] = $listing->post->ID;
				?>
				

				<div id="<?php echo $listing->post->post_name; ?>" itemscope itemtype="http://schema.org/LocalBusiness">
					

					<article id="post-<?php the_ID(); ?>" class="alsp-listing">
						<div class="listing-main-content clearfix">
							<?php if ($listing->title()): ?>
								<header class="alsp-listing-header clearfix">
									<h2 itemprop="name"><?php echo $listing->title(); ?></h2>			
								</header>
								<div class="listing-metas-single clearfix">
									<div class="listing-cat-single">
									<?php
										
										$terms = get_the_terms($listing->post->ID, ALSP_CATEGORIES_TAX);
										global $pacz_settings, $accent_color;
										if(is_array($terms)){
											foreach ($terms AS $key=>$term):
												if(alsp_getCategorycolor($term->term_id)){
													$cat_bg_color = alsp_getCategorycolor($term->term_id);
												}else{
													$cat_bg_color = $pacz_settings['accent-color'];
												}
												$term_link = get_term_link( $term );
												if ($term->parent == 0){ 
													echo '<a class="alsp-cat" style="background-color:'.$cat_bg_color.';" href="' . $term_link. '" title="'.$term->name.'">'.$term->name.'</a>';
												}
											endforeach;	
										}
									?>
									
									</div>	
									<div class="single-location-address">
										<i class="pacz-fic3-pin-1"></i>
										<?php foreach ($listing->locations AS $location): echo $location->getWholeAddress(); endforeach; ?>
									</div>	
									<div class="alsp-listing-date" datetime="<?php echo date("Y-m-d", mysql2date('U', $listing->post->post_date)); ?>T<?php echo date("H:i", mysql2date('U', $listing->post->post_date)); ?>"><i class="pacz-fic3-clock-circular-outline"></i><?php echo get_the_date(); ?></div>
									<div class="listing-views"><i class="pacz-fic3-medical"></i><?php echo sprintf(__('Views: %d', 'ALSP'), (get_post_meta($listing->post->ID, '_total_clicks', true) ? get_post_meta($listing->post->ID, '_total_clicks', true) : 0)); ?></div>
								</div>
								<div class="single-listing-btns">
									<?php alsp_frontendRender('frontend/frontpanel_buttons.tpl.php', array('listing' => $listing)); ?>
								</div>
								<div class="clearfix"></div>
							<?php endif; ?>
						</div>	
						<?php if ($listing->logo_image && (!get_option('alsp_exclude_logo_from_listing') || count($listing->images) > 1)): ?>
							<div class="alsp-listing-logo-wrap alsp-single-listing-logo-wrap" id="images">
								<div class="price">
									<?php
										global $wpdb;
										$field_ids = $wpdb->get_results('SELECT id, type, slug FROM '.$wpdb->prefix.'alsp_content_fields');
										foreach( $field_ids as $field_id ) {
											$singlefield_id = $field_id->id;
											if($field_id->type == 'price' && ($field_id->slug == 'price' || $field_id->slug == 'Price') ){			
												$listing->renderContentField($singlefield_id);
											}				
										}	
									?>
								</div>
								
								<div class="single-listing-scroller  bgwhite shadow-1">
									<!-- declare a slideshow -->
								<?php if ($ALSP_ADIMN_SETTINGS['alsp_enable_lighbox_gallery']){ ?>
									<div class="cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-timeout="0" data-cycle-slides="a" data-cycle-pager="#adv-custom-pager" data-cycle-pager-template="<a href='{{href}}'><img src='{{href}}'></a>">
								<?php }else{ ?>
									<div class="cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-timeout="0" data-cycle-slides="img" data-cycle-pager="#adv-custom-pager" data-cycle-pager-template="<a href='#'><img src='{{src}}'></a>">
								<?php } ?>
										<?php
										$images = array();
										
										$full_with_image = $ALSP_ADIMN_SETTINGS['alsp_100_single_logo_width'];
										if($full_with_image){
											$width = '';
											$height = '';
										}else{
											$width = $ALSP_ADIMN_SETTINGS['alsp_single_logo_width'];
											$height = $ALSP_ADIMN_SETTINGS['alsp_single_logo_height'];
										}
										require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php"; 
										foreach ($listing->images AS $attachment_id=>$image):
											if (!get_option('alsp_exclude_logo_from_listing') || $listing->logo_image != $attachment_id) {
												$image_src_array = wp_get_attachment_image_src($attachment_id, 'full');
												$image_src       = bfi_thumb($image_src_array[0], array(
													'width' => $width,
													'height' => $height,
													'crop' => true
												));
										
											if ($ALSP_ADIMN_SETTINGS['alsp_enable_lighbox_gallery'])
												$images = '<a href="' . $image_src_array[0] . '" data-lightbox="listing_images" title="' . esc_attr($image['post_title']) . '"><img src="' . pacz_thumbnail_image_gen($image_src, $width, $height) . '" alt="' . esc_attr($image['post_title']) . '" width="'.$width.'" height="'.$height.'"/><i class="pacz-flaticon-magnification3"></i></a>';
											else
												$images = '<img src="' . pacz_thumbnail_image_gen($image_src, $width, $height) . '" alt="' . esc_attr($image['post_title']) . '" width="'.$width.'" height="'.$height.'"/>';
												
											}
											echo $images;
										endforeach;
										?>
									</div>
										
									<!-- empty element for pager links -->
									<?php if(count($listing->images) > 1): ?>
										<div id="adv-custom-pager" class="center external"></div>
									<?php endif; ?>
								</div>
							</div>
						<?php elseif(!isset($listing->logo_image) && !get_option('alsp_exclude_logo_from_listing')): ?>	
							<div class="alsp-listing-logo-wrap alsp-single-listing-logo-wrap" id="images">
								<?php
									$images = array();	
									$full_with_image = $ALSP_ADIMN_SETTINGS['alsp_100_single_logo_width'];
									if($full_with_image){
										$width = '';
										$height = '';
									}else{
										$width = $ALSP_ADIMN_SETTINGS['alsp_single_logo_width'];
										$height = $ALSP_ADIMN_SETTINGS['alsp_single_logo_height'];
									}
									$image_src_array = wp_get_attachment_image_src($attachment_id, 'full');
									$image_src = bfi_thumb($image_src_array[0], array(
										'width' => $width,
										'height' => $height,
										'crop' => true
									));
									$images = '<img src="' . pacz_thumbnail_image_gen($image_src, $width, $height) . '" alt="' . esc_attr($image['post_title']) . '"/>';
									echo $images;
								?>
							</div>
							<div class="clearfix"></div>
						<?php endif; ?>
						<div class="alsp-single-listing-text-content-wrap">
							<?php if ($ALSP_ADIMN_SETTINGS['alsp_share_buttons'] && $ALSP_ADIMN_SETTINGS['alsp_share_buttons_place'] == 'before_content'): ?>
							<?php alsp_frontendRender('frontend/sharing_buttons_ajax_call.tpl.php', array('post_id' => $listing->post->ID)); ?>
							<?php endif; ?>
						
							<?php do_action('alsp_listing_pre_content_html', $listing); ?>
							<div class="content-field-block">
								<?php $listing->renderContentFields(true); ?>
							</div>
							<?php $listing->renderContentFields_ingroup(true); ?>
							<?php do_action('alsp_listing_post_content_html', $listing); ?>
							
							<?php if (get_option('alsp_share_buttons') && get_option('alsp_share_buttons_place') == 'after_content'): ?>
							<?php alsp_frontendRender('frontend/sharing_buttons_ajax_call.tpl.php', array('post_id' => $listing->post->ID)); ?>
							<?php endif; ?>
						</div>
						<?php if($ALSP_ADIMN_SETTINGS['single_listing_tab']): ?>
						<script>
							(function($) {
								"use strict";
	
								$(function() {
									<?php if ($ALSP_ADIMN_SETTINGS['alsp-listings-tabs-order']['enabled']): 
									
									$tab_ordering = $ALSP_ADIMN_SETTINGS['alsp-listings-tabs-order']['enabled'];
									?>
									if (1==2) var x = 1;
									<?php foreach ($tab_ordering as $key=>$value): ?>
									else if ($('#<?php echo $key; ?>').length)
										alsp_show_tab($('.alsp-listing-tabs a[data-tab="#<?php echo $key; ?>"]'));
									<?php endforeach; ?>
									<?php else: ?>
									alsp_show_tab($('.alsp-listing-tabs a:first'));
									<?php endif; ?>
								});
							})(jQuery);
						</script>
						

						<?php 
						
						if (
							($fields_groups = $listing->getFieldsGroupsOnTabs())
							|| ($listing->level->google_map && $listing->isMap() && $listing->locations)
							|| (alsp_comments_open())
							|| ($listing->level->videos_number && $listing->videos)
							|| ($ALSP_ADIMN_SETTINGS['alsp_listing_contact_form'] && (!$listing->is_claimable || !$ALSP_ADIMN_SETTINGS['alsp_hide_claim_contact_form']))
							): ?>
						<?php if($detect_mobile->isMobile()){ ?>
							<ul class="alsp-listing-tabs nav navbar-nav clearfix" role="tablist">
								<?php if ($ALSP_ADIMN_SETTINGS['map_on_single_listing_tab'] && $listing->level->google_map && $listing->isMap() && $listing->locations): ?>
								<li><a href="javascript: void(0);" data-tab="#addresses-tab" role="tab"><i class="pacz-icon-home"></i><?php _e('Map Views', 'ALSP'); ?></a></li>
								<?php endif; ?>
								<?php if (alsp_comments_open() && $ALSP_ADIMN_SETTINGS['alsp_listings_comments_position'] == 'intab'): ?>
								<li><a href="javascript: void(0);" data-tab="#comments-tab" role="tab"><i class="pacz-icon-comments-o"></i><?php echo _n('Comment', 'Comments', $listing->post->comment_count, 'ALSP'); ?> (<?php echo $listing->post->comment_count; ?>)</a></li>
								<?php endif; ?>
								<?php if ($listing->level->videos_number && $listing->videos && $ALSP_ADIMN_SETTINGS['alsp_listings_video_position'] == 'intab'): ?>
								<li><a href="javascript: void(0);" data-tab="#videos-tab" role="tab"><i class="pacz-icon-play"></i><?php echo _n('Video', 'Videos', count($listing->videos), 'ALSP'); ?> (<?php echo count($listing->videos); ?>)</a></li>
								<?php endif; ?>
								<?php
								foreach ($fields_groups AS $fields_group): ?>
								<li><a href="javascript: void(0);" data-tab="#field-group-tab-<?php echo $fields_group->id; ?>" role="tab"><?php echo $fields_group->name; ?></a></li>
								<?php endforeach; ?>
							</ul>
							
						<?php }else{ ?>
						<ul class="alsp-listing-tabs nav nav-tabs clearfix" role="tablist">
							<?php if ($ALSP_ADIMN_SETTINGS['map_on_single_listing_tab'] && $listing->level->google_map && $listing->isMap() && $listing->locations && $ALSP_ADIMN_SETTINGS['alsp_listings_map_position'] == 'intab'): ?>
							<li><a href="javascript: void(0);" data-tab="#addresses-tab" data-toggle="alsp-tab" role="tab"><i class="pacz-icon-home"></i><?php _e('Map Views', 'ALSP'); ?></a></li>
							<?php endif; ?>
							<?php if (alsp_comments_open() && $ALSP_ADIMN_SETTINGS['alsp_listings_comments_position'] == 'intab'): ?>
							<li><a href="javascript: void(0);" data-tab="#comments-tab" data-toggle="alsp-tab" role="tab"><i class="pacz-icon-comments-o"></i><?php echo _n('Comment', 'Comments', $listing->post->comment_count, 'ALSP'); ?> (<?php echo $listing->post->comment_count; ?>)</a></li>
							<?php endif; ?>
							<?php if ($listing->level->videos_number && $listing->videos): ?>
							<li><a href="javascript: void(0);" data-tab="#videos-tab" data-toggle="alsp-tab" role="tab"><i class="pacz-icon-play"></i><?php echo _n('Video', 'Videos', count($listing->videos), 'ALSP'); ?> (<?php echo count($listing->videos); ?>)</a></li>
							<?php endif; ?>
							<?php
							foreach ($fields_groups AS $fields_group): ?>
							<li><a href="javascript: void(0);" data-tab="#field-group-tab-<?php echo $fields_group->id; ?>" data-toggle="alsp-tab" role="tab"><?php echo $fields_group->name; ?></a></li>
							<?php endforeach; ?>
						</ul>
						<?php } ?>
						<div class="tab-content">
							<?php if ($listing->level->google_map && $listing->isMap() && $listing->locations): ?>
							<div id="addresses-tab" class="tab-pane fade" role="tabpanel">
							
								<?php $listing->renderMap($frontend_controller->hash, $ALSP_ADIMN_SETTINGS['alsp_show_directions'], false, $ALSP_ADIMN_SETTINGS['alsp_enable_radius_search_cycle'], $ALSP_ADIMN_SETTINGS['alsp_enable_clusters'], false, false); ?>
							</div>
							<?php endif; ?>

							<?php if (alsp_comments_open() && $ALSP_ADIMN_SETTINGS['alsp_listings_comments_position'] == 'intab'): ?>
							<div id="comments-tab" class="tab-pane fade" role="tabpanel">
								<?php comments_template( '', true ); ?>
							</div>
							<?php endif; ?>

							<?php if ($listing->level->videos_number && $listing->videos): ?>
							<div id="videos-tab" class="tab-pane fade" role="tabpanel">
							<?php foreach ($listing->videos AS $video): ?>
									<?php if (strlen($video['id']) == 11): ?>
										<iframe width="100%" height="400" class="alsp-video-iframe fitvidsignore" src="//www.youtube.com/embed/<?php echo $video['id']; ?>" frameborder="0" allowfullscreen></iframe>
									<?php elseif (strlen($video['id']) == 9): ?>
										<iframe width="100%" height="400" class="alsp-video-iframe fitvidsignore" src="https://player.vimeo.com/video/<?php echo $video['id']; ?>?color=d1d1d1&title=0&byline=0&portrait=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
									<?php endif; ?>
							<?php endforeach; ?>
							</div>
							<?php endif; ?>

							
							<?php foreach ($fields_groups AS $fields_group): ?>
							<div id="field-group-tab-<?php echo $fields_group->id; ?>" class="tab-pane fade" role="tabpanel">
								<?php echo $fields_group->renderOutput($listing); ?>
							</div>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
						<?php endif; ?>
						<?php if ($listing->level->videos_number && $listing->videos && $ALSP_ADIMN_SETTINGS['alsp_listings_video_position'] == 'notab'): ?>
							<div id="videos-notab" class="notab">
							<span class="alsp-video-field-name"><?php echo esc_html__('Videos', 'ALSP'); ?></span>
							<?php foreach ($listing->videos AS $video): ?>
									<?php if (strlen($video['id']) == 11): ?>
										<iframe width="100%" height="400" class="alsp-video-iframe fitvidsignore" src="//www.youtube.com/embed/<?php echo $video['id']; ?>" frameborder="0" allowfullscreen></iframe>
									<?php elseif (strlen($video['id']) == 9): ?>
										<iframe width="100%" height="400" class="alsp-video-iframe fitvidsignore" src="https://player.vimeo.com/video/<?php echo $video['id']; ?>?color=d1d1d1&title=0&byline=0&portrait=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
									<?php endif; ?>
							<?php endforeach; ?>
							</div>
						<?php endif; ?>
						<?php if ($ALSP_ADIMN_SETTINGS['map_on_single_listing_tab'] && $listing->level->google_map && $listing->isMap() && $listing->locations && $ALSP_ADIMN_SETTINGS['alsp_listings_map_position'] == 'notab'): ?>
							<div class="single-map notabs">
								<span class="alsp-video-field-name"><?php echo esc_html__('Map View', 'ALSP'); ?></span>
								<?php $listing->renderMap($frontend_controller->hash, $ALSP_ADIMN_SETTINGS['alsp_show_directions'], false, $ALSP_ADIMN_SETTINGS['alsp_enable_radius_search_cycle'], $ALSP_ADIMN_SETTINGS['alsp_enable_clusters'], false, false); ?>
							</div>
						<?php endif; ?>
						
						<?php require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php"; ?>
						<?php 
							$authorID = get_the_author_meta( 'ID' );
							$author_img_url = get_user_meta($authorID, "pacz_author_avatar_url", true); 
						?>
						<?php if (alsp_comments_open() && $ALSP_ADIMN_SETTINGS['alsp_listings_comments_position'] == 'notab'): ?>
							<div id="comments-reviews">
								<?php comments_template( '', true ); ?>
							</div>
						<?php endif; ?>
					</article>
					
				</div>
				<?php
				$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
				$authorID = get_the_author_meta( 'ID' );
				$authoruser = get_the_author_meta( 'user_nicename' );
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
				if($ALSP_ADIMN_SETTINGS['single_listing_other_ads_byuser']){
				echo '<div class="similar-author-ads">';
					echo do_shortcode('[webdirectory-listings perpage="'.$single_listing_othoradd_limit.'" show_views_switcher="'.$single_listing_otherads_viewshitcher.'" hide_order="'.$hide_ordering_single_listing_otherads.'" hide_paginator="1" order_by="post_date" order="DESC" hide_count="1" listings_view_type="'.$single_listing_otherads_view_type.'" listings_view_grid_columns="'.$single_listing_otherads_gridview_col.'" author="'.$authorID.'"]');
				echo '</div>';
				}
			?>
			<?php 
			
			echo '<div class="popup" data-popup="single_contact_form">';
				echo '<div class="popup-inner single-contact">';
					echo '<div class="alsp-popup-title">'.esc_html__('Send Message', 'ALSP').'<a class="popup-close" data-popup-close="single_contact_form" href="#"><i class="pacz-fic4-error"></i></a></div>';
					echo '<div class="alsp-popup-content">';
						global $current_user;
						
						$listing_owner = get_userdata($listing->post->post_author);
						if( is_user_logged_in() && $current_user->ID == $authorID) {
							echo esc_html__('You can not send message on your own lisitng', 'ALSP');
						}elseif(!is_user_logged_in()) {
							echo esc_html__('Login Required', 'ALSP');
						}elseif( current_user_can('administrator')) {
							echo esc_html__('Administrator can not send message from front-end', 'ALSP');
						}else{
							if($ALSP_ADIMN_SETTINGS['message_system'] == 'instant_messages'){
								echo '<div class="form-new">';
								echo do_shortcode('[difp_shortcode_new_message_form to="{current-post-author}" listing_id="'.$listing->post->ID.'" subject="'.$listing->title().'"]');
								echo '</div>';
							}elseif($ALSP_ADIMN_SETTINGS['message_system'] == 'email_messages'){
								if ($ALSP_ADIMN_SETTINGS['alsp_listing_contact_form'] && (!$listing->is_claimable || !$ALSP_ADIMN_SETTINGS['alsp_hide_claim_contact_form']) && ($listing_owner = get_userdata($listing->post->post_author)) && $listing_owner->user_email){
										
									if (defined('WPCF7_VERSION') && alsp_get_wpml_dependent_option('alsp_listing_contact_form_7')){
										echo do_shortcode(alsp_get_wpml_dependent_option('alsp_listing_contact_form_7'));
									}else{
										alsp_frontendRender('frontend/contact_form.tpl.php', array('listing' => $listing)); 
											
									}
										
								}
							}else{
								echo esc_html__('Messages are currenlty disabled by Site Owner', 'ALSP');
							}
						}
					echo'</div>';
				echo'</div>';
			echo'</div>';
			echo '<div class="popup" data-popup="single_contact_form_bid">';
				echo '<div class="popup-inner single-contact">';
					echo '<div class="alsp-popup-title">'.esc_html__('Send Your Bid', 'ALSP').'<a class="popup-close" data-popup-close="single_contact_form_bid" href="#"><i class="pacz-fic4-error"></i></a></div>';
					echo '<div class="alsp-popup-content">';
						global $current_user;
						$listing_owner = get_userdata($listing->post->post_author);
						if( is_user_logged_in() && $current_user->ID == $authorID) {
							echo esc_html__('You can not send message on your own lisitng', '');
						}elseif(!is_user_logged_in()) {
							echo esc_html__('Login Required', 'ALSP');
						}elseif( current_user_can('administrator')) {
							echo esc_html__('Administrator can not send message from front-end', 'ALSP');
						}else{
							echo '<div class="form-new bidding-form">'.do_shortcode('[difp_shortcode_new_bidding_form to="{current-post-author}" listing_id="'.$listing->post->ID.'" subject="'.$listing->title().'"]').'</div>';
						}
					echo'</div>';
				echo'</div>';
			echo'</div>';
			
		?>
				<div id="myModal" class="modal fade" role="dialog">
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-body">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
						<?php if ($ALSP_ADIMN_SETTINGS['alsp_listing_contact_form'] && (!$listing->is_claimable || !$ALSP_ADIMN_SETTINGS['alsp_hide_claim_contact_form']) && ($listing_owner = get_userdata($listing->post->post_author)) && $listing_owner->user_email): ?>
							<div id="contact-tab" class="tab-pane" role="tabpanel">
							<?php if (defined('WPCF7_VERSION') && alsp_get_wpml_dependent_option('alsp_listing_contact_form_7')): ?>
								<?php echo do_shortcode(alsp_get_wpml_dependent_option('alsp_listing_contact_form_7')); ?>
							<?php else: ?>
								<?php alsp_frontendRender('frontend/contact_form.tpl.php', array('listing' => $listing)); ?>
							<?php endif; ?>
							</div>
							<?php endif; ?>
					  </div>
					</div>

				  </div>
				</div>
			<?php endwhile; endif; ?>
		</div>
		<?php } ?>
		