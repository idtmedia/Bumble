<?php global $ALSP_ADIMN_SETTINGS; 
require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php"; 
?>
<?php echo $args['before_widget']; ?>
<?php if (!empty($title))
echo $args['before_title'] . $title . $args['after_title'];
if($is_slider_view){	
?>
<div class=" alsp-widget alsp_recent_listings_widget"><!-- content class removed pacz -->
	<ul class="owl-carousel owl-on-grid clearfix" data-items="1" data-items-tab-ls="1" data-items-tab="1" data-autoplay="true" data-autowidth="false" data-center="false" data-loop="true" data-nav="true" data-delay="1000" data-autoplay-speed="1000" data-gutter="0">
		<?php foreach ($listings AS $listing): ?>
		<li class="alsp-widget-listing <?php if ($listing->level->featured): ?>alsp-featured<?php endif; ?>">
			<div class="alsp-widget-listing-logo">
				<?php 
					$img = wp_get_attachment_image_src($listing->logo_image, 'full');
					$img_src  = bfi_thumb($img[0], array(
							'width' => $width,
							'height' => $height,
							'crop' => true
					));
				?>
			<?php if ($listing->level->listings_own_page): ?>
				<a href="<?php echo get_permalink($listing->post->ID); ?>" title="<?php echo esc_attr($listing->title()); ?>" <?php if ($listing->level->nofollow): ?>rel="nofollow"<?php endif; ?>>
					<img src="<?php echo pacz_thumbnail_image_gen($img_src, $width, $height); ?>" alt="listing logo" width="<?php echo $width; ?>" height="<?php echo $height; ?>" /><!-- width removed pacz -->
				</a>
			<?php else: ?>
				<img src="<?php echo $img_src; ?>" alt="listing logo" /><!-- width removed pacz -->
			<?php endif; ?>
			
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
			
			</div>
	
			<div class="alsp-widget-listing-title">
				<?php if (!$listing->level->listings_own_page): ?>
				<?php echo $listing->title(); ?>
				<?php else: ?>
				<a href="<?php echo get_permalink($listing->post->ID); ?>" title="<?php echo esc_attr($listing->title()); ?>" <?php if ($listing->level->nofollow): ?>rel="nofollow"<?php endif; ?>><?php echo $listing->title(); ?></a>
				<?php endif; ?>
				<br />
				<?php echo human_time_diff(mysql2date('U', $listing->post->post_date), time()); ?> <?php _e('ago', 'ALSP'); ?>
				
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<?php }else{ ?>
<div class=" alsp-widget alsp_recent_listings_widget"><!-- content class removed pacz -->
	<ul class="clearfix">
		<?php foreach ($listings AS $listing): ?>
		<li class="alsp-widget-listing <?php if ($listing->level->featured): ?>alsp-featured<?php endif; ?>">
			<div class="alsp-widget-listing-logo">
			<?php if ($listing->logo_image && ($img = wp_get_attachment_image_src($listing->logo_image))): ?>
				<?php 
				$img = wp_get_attachment_image_src($listing->logo_image, 'full');
					$img_src  = bfi_thumb($img[0], array(
							'width' => $img[2],
							'height' => $img[2],
							'crop' => true
					));
				$img_width = $img[2]; ?>
			<?php else: ?>
				<?php 
				$img_width = '150';
				$img = $ALSP_ADIMN_SETTINGS['alsp_nologo_url']['url'];
					$img_src  = bfi_thumb($img, array(
							'width' => $img_width,
							'height' => $img_width,
							'crop' => true
					));
				?>
			<?php endif; ?>
			<?php if ($listing->level->listings_own_page): ?>
				<a href="<?php echo get_permalink($listing->post->ID); ?>" title="<?php echo esc_attr($listing->title()); ?>" <?php if ($listing->level->nofollow): ?>rel="nofollow"<?php endif; ?>>
					<img src="<?php echo pacz_thumbnail_image_gen($img_src, $img_width, $img_width); ?>" alt="listing logo" width="<?php echo $img_width; ?>" height="<?php echo $img_width; ?>" /><!-- width removed pacz -->
					<div class="listing-widget-hover-overlay"><i class="pacz-icon-share"></i></div>
				</a>
			<?php else: ?>
				<img src="<?php echo $img_src; ?>" alt="listing logo" /><!-- width removed pacz -->
			<?php endif; ?>
			</div>
	
			<div class="alsp-widget-listing-title">
				<?php if (!$listing->level->listings_own_page): ?>
				<?php echo $listing->title(); ?>
				<?php else: ?>
				<a href="<?php echo get_permalink($listing->post->ID); ?>" title="<?php echo esc_attr($listing->title()); ?>" <?php if ($listing->level->nofollow): ?>rel="nofollow"<?php endif; ?>><?php echo $listing->title(); ?></a>
				<?php endif; ?>
				<br />
				<?php echo human_time_diff(mysql2date('U', $listing->post->post_date), time()); ?> <?php _e('ago', 'ALSP'); ?>
				
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<?php } ?>
<?php echo $args['after_widget']; ?>