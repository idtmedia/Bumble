<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.1
 *
 * @package This template is overrided by theme
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop, $woocommerce, $pacz_settings;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ){
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ){
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}


$grid_width = $pacz_settings['grid-width'];
$content_width = $pacz_settings['content-width'];
$height = $pacz_settings['woo-loop-thumb-height'];

$width = round($grid_width/4) - 38;
$column_width = round($grid_width/4);

?>
<li class="product-category product four-column" style="max-width:<?php echo esc_attr($column_width); ?>px">
	<div class="item-holder">
	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

	<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">

		<?php
	        $small_thumbnail_size   = apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' );
	        $thumbnail_id           = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );


	        if ( $thumbnail_id ) {

	            $image = wp_get_attachment_image_src( $thumbnail_id, 'full');
	            $image = bfi_thumb( $image[ 0 ], array('width' => $width*2, 'height' => $height*2, 'crop' => false));

	        } else {

	            $image = bfi_thumb(PACZ_THEME_IMAGES . '/dark-empty-thumb.png', array('width' => $width*2, 'height' => $height*2, 'crop' => false));

	        }

	        if ( $image )
	            echo '<img src="' . $image . '" alt="' . $category->name . '" width="'.($width*2).'" height="'.($height*2).'" />';
		?>

		<h4><span>
			<?php
				echo esc_attr($category->name);

				if ( $category->count > 0 )
					echo apply_filters( 'woocommerce_subcategory_count_html', ' <span class="count">' . $category->count . ' '.esc_html__('Items', 'classiadspro').'</span>', $category );
			?>
		</span>
		</h4>

		<?php
			/**
			 * woocommerce_after_subcategory_title hook
			 */
			do_action( 'woocommerce_after_subcategory_title', $category );
		?>

	</a>

	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>
</div>
</li>