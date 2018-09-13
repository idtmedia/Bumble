<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 *
 * @package This template is overrided by theme
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $pacz_settings, $post;


// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ){
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ){
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ){
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;



$grid_width = $pacz_settings['grid-width'];
$content_width = $pacz_settings['content-width'];
$height = $pacz_settings['woo-loop-thumb-height'];
$quality = $pacz_settings['woo-image-quality'] ? $pacz_settings['woo-image-quality'] : 1;

// Sets the shop loop columns from theme options.
if(is_archive()) {
	$layout = $pacz_settings['woo-shop-layout'];
	if($layout == 'full') {
		$classes[] = 'four-column';
		$width = round($grid_width/3) - 36;
		$column_width = round($grid_width/3);
	} else {
		$classes[] = 'two-column';
		$width = round((($content_width / 100) * $grid_width)/2) - 36;
		$column_width = round($grid_width/2);
	}
} else {
	switch ($woocommerce_loop['columns']) {

	case 4:
			$classes[] = 'four-column';
			$width = round($grid_width/4) - 38;
			$column_width = round($grid_width/4);
		break;
	case 3:
			$classes[] = 'three-column';
			$width = round($grid_width/3) - 41;
			$column_width = round($grid_width/3);
		break;
	case 2:
			$classes[] = 'two-column';
			$width = round($grid_width/2) - 49;
			$column_width = round($grid_width/2);
		break;
	case 1:
			$classes[] = 'one-column';
			$width = $grid_width - 66;
			$column_width = $grid_width;
		break;

	default:
			$classes[] = 'three-column';
			$width = round($grid_width/3) - 36;
			$column_width = round($grid_width/3);
		break;
}

}


/*
* Product add to card & out of stock badge
*/
$out_of_stock_badge = '';
if ( ! $product->is_in_stock() ) {
	$id = method_exists( $product, 'get_id' ) ? $product->get_id() : $product->id;
	$pacz_add_to_cart = '<a href="'. apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $id ) ).'" title="'. apply_filters( 'out_of_stock_add_to_cart_text', esc_html__( 'READ MORE', 'classiadspro' ) ).'" class="add_to_cart_button"><i class="pacz-icon-shopping-cart"></i></a>';

	$out_of_stock_badge = '<span class="out-of-stock">'.esc_html__( 'OUT OF STOCK', 'classiadspro' ).'</span>';
}
else { ?>

	<?php
	$id = method_exists( $product, 'get_id' ) ? $product->get_id() : $product->id;
	switch ( $product->get_type() ) {
	case "variable" :
		$link  = apply_filters( 'variable_add_to_cart_url', get_permalink( $id ) );
		$label  = apply_filters( 'variable_add_to_cart_text', esc_html__( 'Select options', 'classiadspro' ) );
		$icon_class = 'pacz-icon-shopping-cart';
		break;
	case "grouped" :
		$link  = apply_filters( 'grouped_add_to_cart_url', get_permalink( $id ) );
		$label  = apply_filters( 'grouped_add_to_cart_text', esc_html__( 'View options', 'classiadspro' ) );
		$icon_class = 'pacz-icon-shopping-cart';
		break;
	case "external" :
		$link  = apply_filters( 'external_add_to_cart_url', get_permalink( $id ) );
		$label  = apply_filters( 'external_add_to_cart_text', esc_html__( 'Read More', 'classiadspro' ) );
		$icon_class = 'pacz-icon-shopping-cart';
		break;
	default :
		$link  = apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
		$label  = apply_filters( 'add_to_cart_text', esc_html__( 'ADD TO CART', 'classiadspro' ) );
		$icon_class = 'pacz-icon-shopping-cart';
		break;
	}

	if ( $product->get_type() != 'external' ) {
		$id = method_exists( $product, 'get_id' ) ? $product->get_id() : $product->id;
		$pacz_add_to_cart = '<a href="'. $link .'" rel="nofollow" data-product_id="'.$id.'" title="'.$label.'" class="add_to_cart_button product_type_'.$product->get_type().'"><i class="'.$icon_class.'"></i>'.esc_html__('purchase', 'classiadspro').'</a>';
	}
	else {
		$pacz_add_to_cart = '';
	}
}





?>
<li <?php post_class( $classes ); ?> style="max-width:<?php echo esc_attr($column_width); ?>px">
	<div class="item-holder">

	<?php //do_action( 'woocommerce_before_shop_loop_item' ); ?>

		<span class="product-loading-icon"></span>

		<?php
			$loop_image_size = isset($pacz_settings['woo_loop_image_size']) ? $pacz_settings['woo_loop_image_size'] : 'crop';

		/* Porduct loop thumbnail */
		if ( has_post_thumbnail() ) {
			switch ($loop_image_size) {
		        case 'full':
		            $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
		            $image_output_src = $image_src_array[0];
		            break;
		        case 'crop':
		            $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
		            $image_output_src = bfi_thumb($image_src_array[0], array(
		                'width' => $width*$quality,
		                'height' => $height*$quality
		            ));
		            break;            
		        case 'large':
		            $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large', true);
		            $image_output_src = $image_src_array[0];
		            break;
		        case 'medium':
		            $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium', true);
		            $image_output_src = $image_src_array[0];
		            break;        
		        default:
		            $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
		            $image_output_src = bfi_thumb($image_src_array[0], array(
		                'width' => $width*$quality,
		                'height' => $height*$quality
		            ));
		            break;
		    }

			echo '<div class="shop-thumb"><div class="product-loop-thumb">';

			echo '<img src="'.pacz_thumbnail_image_gen($image_output_src, $width, $height).'" class="product-loop-image" alt="'.get_the_title().'" title="'.get_the_title().'" itemprop="image"/>';
			
			echo '<div class="hover-overlay"><div class="hover-overlay-inner">';
				if ( $rating_html = wc_get_rating_html( $product->get_average_rating() ) ) {
					echo '<div class="product-item-rating">'.$rating_html.'</div>';
			}
			else{
				
				echo '<span class="product-item-rating"><span class="star-rating"></span></span>';
			}
			echo '<div>'.$pacz_add_to_cart.'</div>';
			echo '</div></div>';
			echo '<span class="shop-tags-wrap">';
		
			if ($product->is_on_sale()) :
			 echo apply_filters('woocommerce_sale_flash', '<span class="onsale">'.esc_html__( 'SALE', 'classiadspro' ).'</span>', $post, $product);
			endif;
			if ($product->is_featured()) :
			 echo apply_filters('woocommerce_featured_flash', '<span class="onfeatured">'.esc_html__( 'FEATURED', 'classiadspro' ).'</span>', $post, $product);
			endif;
			$product_gallery = get_post_meta( $post->ID, '_product_image_gallery', true );
			echo '<div>'.$out_of_stock_badge.'</div>';
		echo '</span>';
			

			/* if ( !empty( $product_gallery ) ) {

				$gallery = explode( ',', $product_gallery );
				$hover_image_id  = $gallery[0];

				$image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'full', true );
				
				switch ($loop_image_size) {
		        case 'full':
		            $image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'full', true);
		            $image_hover_src = $image_src_hover_array[0];
		            break;
		        case 'crop':
		            $image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'full', true);
		            $image_hover_src = bfi_thumb($image_src_hover_array[0], array(
		                'width' => $width*$quality,
		                'height' => $height*$quality
		            ));
		            break;            
		        case 'large':
		            $image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'large', true);
		            $image_hover_src = $image_src_hover_array[0];
		            break;
		        case 'medium':
		            $image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'medium', true);
		            $image_hover_src = $image_src_hover_array[0];
		            break;        
		        default:
		            $image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'full', true);
		            $image_hover_src = bfi_thumb($image_src_hover_array[0], array(
		              'width' => $width*$quality,
		              'height' => $height*$quality
		            ));
		            break;
		    }

				//echo '<img src="'.pacz_thumbnail_image_gen($image_hover_src, $width, $height).'" alt="'.get_the_title().'" class="product-hover-image" title="'.get_the_title().'" >';
			}*/


		} else {

			//echo '<img src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="'.$width*$quality.'" height="'.$height*$quality.'" />';

		}

		
		echo '</div></div>';
		?>



		<?php //do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
		<div class="product-item-details">

			<h5><a href="<?php echo get_permalink();?>"><?php the_title(); ?></a></h5>
			
			
		<div class="product_bottom clearfix">
			<?php do_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 ); ?>
			<?php if( function_exists('pacz_love_this') ) {
				echo pacz_love_this();
			}
			?>
			
			
			</div>
		</div>



	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
</div>
</li>


