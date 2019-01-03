<?php


$layout_meta = get_post_meta( $post->ID, '_layout', true );
if(isset($layout_meta) && !empty($layout_meta)){
$layout = $layout_meta;	
}else{
$layout = 'right';	
}
$layout = 'full';

$image_height = $pacz_settings['blog-single-image-height'];
$image_width = pacz_content_width($layout);

$padding = get_post_meta( $post->ID, '_padding', true );
$padding = ($padding == 'true') ? 'no-padding' : '';

$show_featured = get_post_meta( $post->ID, '_featured_image', true );
$show_featured = (isset($show_featured) && !empty($show_featured)) ? $show_featured  : 'true' ;

$show_meta = get_post_meta( $post->ID, '_meta', true );
$show_meta = (isset($show_meta) && !empty($show_meta)) ? $show_meta  : 'true' ;

function social_networks_meta() {
	$image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
	$output  = '<meta property="og:site_name" content="'.get_bloginfo('name').'"/>'. "\n";
	$output .= '<meta property="og:image" content="'.$image_src_array[ 0 ].'"/>'. "\n";
	$output .= '<meta property="og:url" content="'.get_permalink().'"/>'. "\n";
	$output .= '<meta property="og:title" content="'.get_the_title().'"/>'. "\n";
	$output .= '<meta property="og:description" content="'.get_the_excerpt().'"/>'. "\n";
	$output .= '<meta property="og:type" content="article"/>'. "\n";
	echo '<div>'.$output.'</div>';
}
add_action('wp_enqueue_scripts', 'social_networks_meta');

get_header(); ?>

<div id="theme-page" class="pacz-blog-single">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post();
		$post_type = (get_post_format( get_the_id()) == '0' || get_post_format( get_the_id()) == '') ? 'image' : get_post_format( get_the_id());
		$image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
		if(isset($pacz_settings['blog-image-crop']) && $pacz_settings['blog-image-crop'] == 0) {
			$image_src = $image_src_array[ 0 ];
		} else {
			$image_src = bfi_thumb( $image_src_array[ 0 ], array('width' => $image_width, 'height' => $image_height, 'crop'=>true));
		}
	?>
	<div class="pacz-main-wrapper-holder">
	<div class="theme-page-wrapper <?php echo esc_attr($layout); ?>-layout pacz-grid vc_row-fluid <?php echo esc_attr($padding); ?>">
	<div class="theme-inner-wrapper">
			<div class="theme-content <?php echo esc_attr($padding); ?>" id="blog-entry-<?php the_ID(); ?>" <?php post_class(); ?> itemprop="mainContentOfPage">
			<div class="inner-content">
		<?php if($show_featured == 'true') :

			if(isset($pacz_settings['blog-featured-image']) && $pacz_settings['blog-featured-image'] == 1) {

			if($post_type == 'image' || $post_type == 'portfolio') { ?>

					<?php if(has_post_thumbnail()) : ?>
							<div class="featured-image">
								<a href="<?php echo esc_url($image_src_array[ 0 ]); ?>" class="pacz-lightbox"><img alt="<?php the_title(); ?>" title="<?php the_title(); ?>" src="<?php echo pacz_thumbnail_image_gen($image_src, $image_width, $image_height); ?>" height="<?php echo esc_attr($image_height); ?>" width="<?php echo esc_attr($image_width); ?>" itemprop="image" /></a>
							</div>
					<?php endif; ?>

			<?php } elseif($post_type == 'video') {
			

			} elseif($post_type == 'audio') {
		
		 	}else if($post_type == 'gallery') {
				
		 	}
	 	}?>
	 	<?php endif; ?>
 		
		<div class="blog-entry-heading">
			<h2 class="blog-title"><?php the_title() ?></h2>
		</div>
		<?php
        $show_meta = false;
 		if($show_meta == 'true') :
 		/* Meta section */ ?>
			<div class="entry-meta">
				<div class="item-holder">
					<time datetime="<?php the_time( 'F jS, Y' ) ?>" itemprop="datePublished" pubdate>
							<a href="<?php get_month_link( the_time( "Y" ), the_time( "m" ) ) ?>"><?php the_date() ?></a>
					</time>
					<div class="entry-categories"><?php echo esc_html__('Category : ', 'classiadspro'); ?><?php the_category( ', ' ); ?></div>
					<div class="blog-author"><?php echo esc_html__('posted by : ', 'classiadspro')?><span><?php echo get_the_author(); ?></span></div>
					<a href="#comments" class="blog-comments"><?php echo comments_number( '0', '1', '%'); ?><span><?php echo esc_html__('comments', 'classiadspro'); ?></span></a>
					
					<div class="clearboth"></div>
				</div>
			</div>
		<?php endif; ?>
		<?php /* end of meta section */ ?>


		<div class="single-content">
			<?php the_content(); ?>
		</div>
		<?php wp_link_pages('before=<div class="pacz-page-links">&after=</div>'); ?>
		<?php /*<div class="tags-social clearfix">
			<div class="post-tags col-md-6 pull-left"><?php the_tags(); ?></div>
			<?php if($pacz_settings['blog-single-social-share']) : ?>
			<div class="single-social-share-wrap col-md-6 pull-right">
			<ul class="single-social-share">
				<li><a class="facebook-share" data-title="<?php the_title(); ?>" data-url="<?php echo get_permalink(); ?>" href="#"><i class="pacz-icon-facebook"></i></a></li>
				<li><a class="twitter-share" data-title="<?php the_title(); ?>" data-url="<?php echo get_permalink(); ?>" href="#"><i class="pacz-icon-twitter"></i></a></li>
				<li><a class="googleplus-share" data-title="<?php the_title(); ?>" data-url="<?php echo get_permalink(); ?>" href="#"><i class="pacz-icon-google-plus"></i></a></li>
				<li><a class="linkedin-share" data-title="<?php the_title(); ?>" data-url="<?php echo get_permalink(); ?>" href="#"><i class="pacz-icon-linkedin"></i></a></li>
				<?php $image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true ); ?>
				<li><a class="pinterest-share" data-image="<?php echo esc_url($image_src_array[0]); ?>" data-title="<?php the_title(); ?>" data-url="<?php echo get_permalink(); ?>" href="#"><i class="pacz-icon-pinterest"></i></a></li>
			</ul>
			</div>
			<?php endif; ?>
		</div>*/ ?>

		<nav class="pacz-next-prev">
			<div class="pacz-next-prev-wrap"><?php previous_post_link( '%link', esc_html__('Previous classified', 'classiadspro'));  ?></div>
		    <div class="pacz-next-prev-wrap"><?php next_post_link( '%link', esc_html__('Next classified', 'classiadspro')); ?> </div>
		   <div class="clearboth"></div>
		</nav>
		<div class="clearboth"></div>
</div>
<?php //$author_disc = the_author_meta('description'); //if(!empty($author_disc)): ?>

<?php //endif; ?>
<?php /*<div class="inner-content-comments">
<?php
if($pacz_settings['blog-single-comments']) {
		comments_template( '', true );
}

?>
<div class="clearboth"></div>
</div>*/ ?>


</div>
<?php endwhile; ?>


<?php  if($layout != 'full') get_sidebar();  ?>
<div class="clearboth"></div>

</div>
</div>
</div>
</div>
<?php get_footer(); ?>
