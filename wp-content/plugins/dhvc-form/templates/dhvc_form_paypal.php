<?php
extract(shortcode_atts(array(
	'item_text'=>'Item',
	'qty_text'=>'Qty',
	'price_text'=>'Price',
	'item_list'=>'',
	'el_class'=> '',
	'input_css'=>'',
), $atts));

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $this->settings['base'].' '. $el_class,$this->settings['base'],$atts );
if(empty($item_list))
	return;
global $dhvc_form;
$operators = array('+','-','*',':');
$items = json_decode(base64_decode($item_list));
$items = (array) apply_filters('dhvc_form_paypal_items_list', $items,$dhvc_form);
?>
<div class="dhvc-form-group<?php echo ' '.$css_class?><?php echo vc_shortcode_custom_css_class($input_css,' ')?>">
	<input type="hidden" name="_dhvc_form_paypal" value="1">
	<div class="dhvc-form-paypal">
		<table class="dhvc-form-paypal-table">
			<thead>
				<tr>
					<th class="paypal-table-label"><?php echo esc_html($item_text) ?></th>
					<th class="paypal-table-qty-text"><?php echo esc_html($qty_text) ?></th>
					<th class="paypal-table-price-text"><?php echo esc_html($price_text) ?></th>
				</tr>
			</thead>
			<tbody>
				<?php $i=0;?>
				<?php foreach ($items as $item):?>
				<?php 
				$i++;
				?>
				<tr>
					<td class="paypal-item-name-value" data-title="<?php echo esc_attr($item_text) ?>">
						<?php echo esc_html($item->label)?>
					</td>
					<td class="paypal-item-qty-value dhvc-form-math" data-value-math="<?php echo trim(esc_attr($item->qty))?>" data-title="<?php echo esc_attr($qty_text)?>">
						<?php echo $item->qty?>
					</td>
					<td class="paypal-item-price-value dhvc-form-math" data-value-math="<?php echo trim(esc_attr($item->price))?>" data-title="<?php echo esc_attr($price_text)?>">
						<?php echo $item->price?>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
			<tfoot>
				<tr class="paypal-order-total">
					<td colspan="2" class="paypal-order-total-text"><?php _e( 'Total', 'dhvc-form' ); ?></td>
					<td data-title="<?php esc_attr_e( 'Total', 'dhvc-form' ); ?>" class="paypal-total-value"></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>