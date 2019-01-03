<?php
/* template name: Classified */

$post_id = global_get_post_id();

$layout = get_post_meta($post_id, '_layout', true );
$padding = get_post_meta($post_id, '_padding', true );
global $post, $ALSP_ADIMN_SETTINGS;
if(empty($layout)) {
	$layout = 'right';
	
}

$padding = ($padding == 'true') ? 'no-padding' : '';

get_header(); 
if(has_shortcode($post->post_content, 'webdirectory-listing') && $ALSP_ADIMN_SETTINGS['alsp_single_listing_style'] == 2){ ?>

	<div id="theme-page">
		<div class="pacz-main-wrapper-holder">
			<div class="theme-page-wrapper pacz-main-wrapper <?php echo esc_attr($layout); ?>-layout <?php echo esc_attr($padding); ?> vc_row-fluid">
				<div class="inner-page-wrapper">
					<div class="theme-content-full <?php echo esc_attr($padding); ?>" itemprop="mainContentOfPage">
					
					<?php 
						/* Hook to add content before content */	
						do_action('page_add_before_content');
					?>

						<?php if ( have_posts() ) while ( have_posts() ) : the_post();
							global $pacz_settings;
						 ?>
								<?php the_content();?>
								<div class="clearboth"></div>
								<?php wp_link_pages('before=<div id="pacz-page-links">'.esc_html__('Pages:', 'classiadspro').'&after=</div>'); ?>

								<?php
								if(isset($pacz_settings['pages-comments']) && $pacz_settings['pages-comments'] == 1) {
									comments_template( '', true ); 	
								}
								?>
						<?php endwhile; ?>

					<?php 
						/* Hook to add content after content */	
						do_action('page_add_after_content'); 
					?>

					</div>
				<div class="clearboth"></div>	
				</div>
				<div class="clearboth"></div>
			</div>
		</div>
	</div>
<?php }else{ ?>
	<div id="theme-page">
		<div class="pacz-main-wrapper-holder">
			<div class="theme-page-wrapper pacz-main-wrapper <?php echo esc_attr($layout); ?>-layout <?php echo esc_attr($padding); ?> pacz-grid vc_row-fluid">
				<div class="inner-page-wrapper">
					<div class="theme-content <?php echo esc_attr($padding); ?>" itemprop="mainContentOfPage">
					
					<?php 
						/* Hook to add content before content */	
						do_action('page_add_before_content');
					?>

						<?php if ( have_posts() ) while ( have_posts() ) : the_post();
							global $pacz_settings;
						 ?>
								<?php the_content();?>
								<div class="clearboth"></div>
								<?php wp_link_pages('before=<div id="pacz-page-links">'.esc_html__('Pages:', 'classiadspro').'&after=</div>'); ?>

								<?php
								if(isset($pacz_settings['pages-comments']) && $pacz_settings['pages-comments'] == 1) {
									comments_template( '', true ); 	
								}
								?>
						<?php endwhile; ?>

					<?php 
						/* Hook to add content after content */	
						do_action('page_add_after_content'); 
					?>

					</div>
				<?php if($layout != 'full') get_sidebar(); ?>	
				<div class="clearboth"></div>	
				</div>
				<div class="clearboth"></div>
			</div>
		</div>
	</div>
<?php } ?>
<?php get_footer(); ?>