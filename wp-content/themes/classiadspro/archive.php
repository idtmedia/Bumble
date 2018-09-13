<?php 


$layout = $pacz_settings['archive-layout'];
$columns = $pacz_settings['archive-columns'];
$loop_style = $pacz_settings['archive-loop-style'];


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
			<div class="theme-content" itemprop="mainContentOfPage">
			<?php 
			/* Run the blog loop shortcode to output the posts. */
			if(function_exists('custom_vc_init') && class_exists('WPBakeryShortCode')){
			echo do_shortcode( '[pacz_blog order="DESC" orderby="date" style="'.$blog_style.'" column="'.$column.'"]' );
			
			}else{
				
				$id = uniqid();
				$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);

					$count = '';
					$query = array(
						'post_type' => 'post',
						'posts_per_page' => (int) $count,
						'paged' => $paged,
						'suppress_filters' => 0,
						'ignore_sticky_posts' => 1
					);
				

				$query['paged'] = $paged;

				$r = new WP_Query($query);

				$grid_width    = $pacz_settings['grid-width'];
				$content_width = $pacz_settings['content-width'];
				$item_id = (!empty($item_id)) ? $item_id : 1409305847;
				$atts   = array(
					'layout' => 'right',
					'style' => 'classic',
					'column' => 'one',
					'image_height' => 380,
					'disable_meta' => 'false',
					'thumb_column' => 1,
					'classic_excerpt' => 200,
					'grid_avatar' => 'true',
					'read_more' => 'true',
					'grid_width' => $grid_width,
					'content_width' => $content_width,
					'image_width' => 740,
					'excerpt_length' => 200,
					'cropping' => 'true',
					'author' => 'false',
					'scroll' => 'false',
					'item_id' => $item_id,
					'item_row' => 1
				);
				$classic_excerpt = 'excerpt';
				echo '<div class="loop-main-wrapper"><section id="pacz-blog-loop-' . $id . '"  class="pacz-blog-container clearfix pacz-classic-wrapper">' . "\n";

				$i = 0;

					if (have_posts()):
						while (have_posts()):
							the_post();
							$i++;
									echo blog_classic_style($atts);

						endwhile;
					endif;
					
				echo '</section><div class="clearboth"></div></div>';
				pacz_theme_blog_pagenavi('', '', $r, $paged);	
				
			}
			
			?>
					<div class="clearboth"></div>
		</div>
		<?php if($layout != 'full') get_sidebar(); ?>	
		<div class="clearboth"></div>	
		</div>
		</div>
		<div class="clearboth"></div>
	</div>	
</div>

<?php get_footer(); ?>