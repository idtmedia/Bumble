<?php
/**
 * Order details
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$order = wc_get_order( $order_id );
	global $wp;
if (is_account_page()) {
	if(class_exists('alsp_plugin')){
		echo do_action('dashboard_panel_html');
	}
?>
 <div class="content-wrapper">
	<?php } ?>
<div class="woo-myaccount-inner-wrap">
<h2 class="pacz-woocommerce-title"><?php esc_html_e( 'Order Details', 'classiadspro' ); ?></h2>
<table class="shop_table order_details">
	<thead>
		<tr>
			<th class="product-name"><?php esc_html_e( 'Product', 'classiadspro' ); ?></th>
			<th class="product-total"><?php esc_html_e( 'Total', 'classiadspro' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach( $order->get_items() as $item_id => $item ) {
				wc_get_template( 'order/order-details-item.php', array(
					'order'   => $order,
					'item_id' => $item_id,
					'item'    => $item,
					'product' => apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item )
				) );
			}
		?>
		<?php do_action( 'woocommerce_order_items_table', $order ); ?>
	</tbody>
	<tfoot>
		<?php
			foreach ( $order->get_order_item_totals() as $key => $total ) {
				?>
				<tr>
					<th scope="row"><?php echo esc_attr($total['label']); ?></th>
					<td><?php echo wp_kses_post($total['value']); ?></td>
				</tr>
				<?php
			}
		?>
	</tfoot>
</table>

<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

<?php wc_get_template( 'order/order-details-customer.php', array( 'order' =>  $order ) ); ?>
</div>
<?php 	global $wp;
	if (is_account_page()) { ?>
</div>
	<?php } ?>