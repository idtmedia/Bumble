<?php
/**
 * External product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 *
 * @package This template is overrided by theme
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

<p class="cart">
	<a href="<?php echo esc_url( $product_url ); ?>" rel="nofollow" class="single_add_to_cart_button button alt"><i class="pacz-icon-shopping-cart"></i><?php echo esc_attr($button_text); ?></a>
</p>

<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>