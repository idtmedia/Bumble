<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>
<div class="shop-cart-wrap clearfix">
<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<div class="shop_table cart">
	<div>
		<ul class="cart-header clearfix">
			<li class="product-name"><?php esc_html_e( 'Product', 'classiadspro' ); ?></li>
			<li class="product-price"><?php esc_html_e( 'Price', 'classiadspro' ); ?></li>
			<li class="product-quantity"><?php esc_html_e( 'Quantity', 'classiadspro' ); ?></li>
			<li class="product-subtotal"><?php esc_html_e( 'Total', 'classiadspro' ); ?></li>
			<li class="product-remove"><?php esc_html_e( 'Remove', 'classiadspro' ); ?></li>
		</ul>
	</div>
	<div>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<ul class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?> clearfix">

					<li class="product-thumbnail">
						<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $_product->is_visible() )
								echo '<div>'.$thumbnail.'</div>';
							else
								printf( '<a href="%s">%s</a>', $_product->get_permalink( $cart_item ), $thumbnail );
						?>
					</li>

					<li class="product-name">
						<?php
							if ( ! $_product->is_visible() )
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
							else
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', $_product->get_permalink( $cart_item ), $_product->get_title() ), $cart_item, $cart_item_key );

							// Meta data
							echo wc_get_formatted_cart_item_data( $cart_item );

               				// Backorder notification
               				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
               					echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'classiadspro' ) . '</p>';
						?>
					</li>

					<li class="product-price">
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
					</li>

					<li class="product-quantity">
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0'
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
						?>
					</li>

					<li class="product-subtotal">
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</li>
					<li class="product-remove">
						<?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s"><i class="pacz-icon-close"></i></a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_html__( 'Remove this item', 'classiadspro' ) ), $cart_item_key );
						?>
					</li>
				</ul>
				<?php
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<div class="coupon-wrap clearfix">
			<div class="actions clearfix">

				<?php if ( WC()->cart->coupons_enabled() ) { ?>
					<div class="coupon clearfix">

						<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_html_e( 'Coupon code', 'classiadspro' ); ?>" />
						<input type="submit" class="button" name="apply_coupon" value="<?php esc_html_e( 'Apply Coupon', 'classiadspro' ); ?>" />

						<?php do_action( 'woocommerce_cart_coupon' ); ?>

					</div>
				<?php } ?>
				<div class="cart-update-wrap clearfix">
					<input type="submit" class="button" name="update_cart" value="<?php esc_html_e( 'Update Cart', 'classiadspro' ); ?>" />
				</div>
				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</div>
</div>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<div class="cart-collaterals clearfix">

	<?php do_action( 'woocommerce_cart_collaterals' ); ?>

</div>
</div>
<?php do_action( 'woocommerce_after_cart' ); ?>
