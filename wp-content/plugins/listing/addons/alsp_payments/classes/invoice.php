<?php

include_once ALSP_PAYMENTS_PATH . 'classes/items/item_listing.php';
include_once ALSP_PAYMENTS_PATH . 'classes/items/item_listing_raiseup.php';
include_once ALSP_PAYMENTS_PATH . 'classes/items/item_listing_upgrade.php';

include_once ALSP_PAYMENTS_PATH . 'classes/gateways/payment_gateway.php';
include_once ALSP_PAYMENTS_PATH . 'classes/gateways/paypal.php';
include_once ALSP_PAYMENTS_PATH . 'classes/gateways/paypal_subscription.php';
include_once ALSP_PAYMENTS_PATH . 'classes/gateways/bank_transfer.php';
include_once ALSP_PAYMENTS_PATH . 'classes/gateways/stripe.php';

class alsp_invoice {
	public $post;
	public $item;
	public $item_object;
	public $price;
	public $status; // paid, unpaid, pending
	public $gateway;
	public $is_subscription = false;
	public $log = array();
	
	public function init() {
		//$meta = unserialize(preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $this->post->post_content));
		$meta = unserialize($this->post->post_content);
		$this->item = $meta['item'];
		$this->price = floatval($meta['price']);
		$this->status = $meta['status'];
		$this->gateway = $meta['gateway'];
		if (isset($meta['is_subscription']))
			$this->is_subscription = $meta['is_subscription'];
		$this->log = $meta['log'];
		
		$item_id = $this->post->post_parent;
		
		$item_class = 'alsp_item_' . $this->item;
		if (class_exists($item_class))
			$this->item_object = new $item_class($item_id);
	}
	
	public function price() {
		return formatPrice($this->price);
	}

	public function setPrice($price) {
		$this->price = $price;
		$this->update();
	}

	public function setStatus($status) {
		if (in_array($status, array('unpaid', 'paid', 'pending')))
			$this->status = $status;
		$this->update();
	}

	public function setGateway($gateway) {
		$this->gateway = $gateway;
		$this->update();
	}
	
	public function logMessage($message) {
		$this->log[time()] = $message;
		$this->update();
	}
	
	public function update() {
		$post_content = array(
			'item' => $this->item,
			'is_subscription' => $this->is_subscription,
			'price' => $this->price,
			'status' => $this->status,
			'gateway' => $this->gateway,
			'log' => $this->log
		);
		
		$postarr = array(
			'ID' => $this->post->ID,
			'post_content' => serialize($post_content),
		);
		return wp_update_post($postarr, true);
	}
	
	public function getGatewayObject() {
		$gateway_class = 'alsp_' . $this->gateway;
		if (class_exists($gateway_class))
			return new $gateway_class();
	}
	
	public function taxesString() {
		global $ALSP_ADIMN_SETTINGS;
		if ($ALSP_ADIMN_SETTINGS['alsp_enable_taxes'] && $ALSP_ADIMN_SETTINGS['alsp_tax_rate'] && $ALSP_ADIMN_SETTINGS['alsp_tax_name'])
			if ($ALSP_ADIMN_SETTINGS['alsp_taxes_mode'] == 'include')
				return '(' . __('including', 'ALSP') . ' ' . $ALSP_ADIMN_SETTINGS['alsp_tax_rate'] . '% ' . $ALSP_ADIMN_SETTINGS['alsp_tax_name'] . ')';
			elseif ($ALSP_ADIMN_SETTINGS['alsp_taxes_mode'] == 'exclude')
				return '(' . __('excluding', 'ALSP') . ' ' . $ALSP_ADIMN_SETTINGS['alsp_tax_rate'] . '% ' . $ALSP_ADIMN_SETTINGS['alsp_tax_name'] . ')';
	}
	
	public function taxesPrice($format_price =  true) {
		global $ALSP_ADIMN_SETTINGS;
		if ($ALSP_ADIMN_SETTINGS['alsp_enable_taxes'] && $ALSP_ADIMN_SETTINGS['alsp_tax_rate'] && $ALSP_ADIMN_SETTINGS['alsp_taxes_mode'] == 'exclude')
			$price = $this->price + $this->taxesAmount(false);
		else 
			$price = $this->price;

		if ($format_price)
			return formatPrice($price);
		else
			return round($price, 2);
	}
	
	public function taxesAmount($format_price =  true) {
		global $ALSP_ADIMN_SETTINGS;
		if ($ALSP_ADIMN_SETTINGS['alsp_enable_taxes'] && $ALSP_ADIMN_SETTINGS['alsp_tax_rate']) {
			$taxes_amount = $this->price*($ALSP_ADIMN_SETTINGS['alsp_tax_rate']/100);
			if ($format_price)
				return formatPrice($taxes_amount);
			else
				return $taxes_amount;
		} else
			return 0;
	}
	
	public function billingInfo() {
		$info = '';
		if (get_the_author_meta('alsp_billing_name', $this->post->post_author) || get_the_author_meta('alsp_billing_address', $this->post->post_author)) {
			$info .= get_the_author_meta('alsp_billing_name', $this->post->post_author) . '<br />';
			$info .= nl2br(get_the_author_meta('alsp_billing_address', $this->post->post_author));
		}
		return $info;
	}
}

function getInvoiceByID($invoice_id) {
	if ($post = get_post($invoice_id)) {
		$invoice = new alsp_invoice();
		$invoice->post = $post;
		
		$invoice->init();
		return $invoice;
	} else
		return false;
}

function gatewayName($gateway) {
	switch ($gateway) {
		case 'paypal':
			return __('PayPal', 'ALSP');
			break;
		case 'paypal_subscription':
			return __('PayPal subscription', 'ALSP');
			break;
		case 'bank_transfer':
			return __('Bank transfer', 'ALSP');
			break;
		case 'stripe':
			return __('Stripe', 'ALSP');
			break;
		case 'authorize':
			return __('AuthorizeNet', 'ALSP');
			break;
	}
}

function alsp_create_invoice($item, $title, $is_subscription, $price, $item_id, $author_id) {
	$post_content = array(
			'item' => $item,
			'is_subscription' => $is_subscription,
			'price' => $price,
			'status' => 'unpaid',
			'gateway' => '',
			'log' => array(time() => __('Invoice created', 'ALSP'))
	);

	$new_invoice_args = array(
			'post_title' => $title,
			'post_type' => ALSP_INVOICE_TYPE,
			'post_status' => 'publish',
			'post_parent' => $item_id,
			'post_author' => $author_id,
			'post_content' => serialize($post_content)
	);
	return wp_insert_post($new_invoice_args);
}

function alsp_create_transaction($gateway, $invoice_id, $payment_status, $txn_id, $mc_gross, $mc_fee, $mc_currency, $quantity, $data) {
	$transaction_args = array(
			'gateway' => $gateway,
			'payment_status' => $payment_status,
			'mc_gross' => $mc_gross,
			'mc_fee' => $mc_fee,
			'mc_currency' => $mc_currency,
			'quantity' => $quantity,
			'data' => $data
	);
	return add_post_meta($invoice_id, '_alsp_transaction_' . $txn_id, serialize($transaction_args));
}

function is_unique_transaction($txn_id) {
	$args = array(
	    'post_type' => ALSP_INVOICE_TYPE,
	    'meta_key' => '_alsp_transaction_' . $txn_id
	);
	$dbResult = new WP_Query($args);
	return !($dbResult->have_posts());
}

?>