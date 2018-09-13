<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="woo-thankyou-page">
<?php if ( $order ) : ?>

	<?php if ( $order->has_status( 'failed' ) ) : ?>

		<p><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'classiadspro' ); ?></p>

		<p><?php
			if ( is_user_logged_in() )
				esc_html_e( 'Please attempt your purchase again or go to your account page.', 'classiadspro' );
			else
				esc_html_e( 'Please attempt your purchase again.', 'classiadspro' );
		?></p>

		<p>
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'classiadspro' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>" class="button pay"><?php esc_html_e( 'My Account', 'classiadspro' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>

		<p class="woocommerce-thanks-text"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', wp_kses_post(__( '<i class="pacz-theme-icon-tick"></i> Thank you. Your order has been received.', 'classiadspro' ), $order )); ?></p>

		<ul class="order_details">
			<li class="order">
				<?php esc_html_e( 'Order:', 'classiadspro' ); ?>
				<strong><?php echo esc_attr($order->get_order_number()); ?></strong>
			</li>
			<li class="date">
				<?php esc_html_e( 'Date:', 'classiadspro' ); ?>
				<strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
			</li>
			<li class="total">
				<?php esc_html_e( 'Total:', 'classiadspro' ); ?>
				<?php echo '<strong>'.$order->get_formatted_order_total() .'</strong>'; ?>
			</li>
			<?php if ( $order->get_payment_method_title() ) : ?>
			<li class="method">
				<?php esc_html_e( 'Payment method:', 'classiadspro' ); ?>
				<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
			</li>
			<?php endif; ?>
		</ul>
		<div class="clear"></div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
	<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

<?php else : ?>

	<p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', wp_kses_post(__( 'Thank you. Your order has been received.', 'classiadspro' ), null )); ?></p>

<?php endif; ?>
</div>