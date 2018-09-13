<?php

add_action('init', 'alsp_register_listing_single_product_type');
function alsp_register_listing_single_product_type() {
	class WC_Product_Listing_Single extends WC_Product {

		public $level_id = null;
		public $raiseup_price = 0;

		public function __construct($product) {
			
			$this->product_type = 'listing_single';

			parent::__construct($product);

			if (get_post_meta($this->id, '_listings_level', true))
				$this->level_id = get_post_meta($this->id, '_listings_level', true);

			if (get_post_meta($this->id, '_raiseup_price', true))
				$this->raiseup_price = get_post_meta($this->id, '_raiseup_price', true);
		}
		
		public function get_virtual($context = 'view') {
			return true;
		}
		
		public function get_downloadable($context = 'view') {
			return true;
		}
	}
}

class alsp_listing_single_product {
	
	public function __construct() {
		add_filter('product_type_selector', array($this, 'add_listing_single_product'));
		add_action('admin_footer', array($this, 'listing_single_custom_js'));
		add_filter('woocommerce_product_data_tabs', array($this, 'hide_attributes_data_panel'));
		add_action('woocommerce_product_options_pricing', array($this, 'add_raiseup_price'));
		add_filter('woocommerce_product_data_panels', array($this, 'new_product_tab_content'));
		add_action('woocommerce_process_product_meta_listing_single', array($this, 'save_listing_single_tab_content'));
		
		add_filter('alsp_create_option', array($this, 'create_price'), 10, 2);
		add_filter('alsp_raiseup_option', array($this, 'raiseup_price'), 10, 2);
		add_filter('alsp_renew_option', array($this, 'renew_price'), 10, 2);
		add_filter('alsp_level_upgrade_option', array($this, 'upgrade_price'), 10, 3);

		add_action('alsp_submitlisting_levels_th', array($this, 'levels_price_front_table_header'), 10, 2);
		add_action('alsp_submitlisting_levels_rows', array($this, 'levels_price_front_table_row'), 10, 3);
		
		add_filter('alsp_level_table_header', array($this, 'levels_price_table_header'));
		add_filter('alsp_level_table_row', array($this, 'levels_price_table_row'), 10, 2);
		
		// Woocommerce Dashboard - Order Details
		add_action('woocommerce_order_item_meta_start', array($this, 'listing_in_order_table'), 10, 3);
		add_action('woocommerce_after_order_itemmeta', array($this, 'listing_in_order_table'), 10, 3);
		add_filter('woocommerce_display_item_meta', array($this, 'listing_in_subscriptions_table'), 10, 3);
		// Woocommerce Checkout
		add_filter('woocommerce_get_item_data', array($this, 'listing_in_checkout'), 10, 2);
		add_action('woocommerce_before_calculate_totals', array($this, 'checkout_listing_raiseup_price'));
		// Woocommerce add order item meta
		add_action('woocommerce_new_order_item', array($this, 'add_order_item_meta'), 10, 3);
		add_action('woocommerce_order_again_cart_item_data', array($this, 'order_again_cart_item_data'), 10, 3);
		// when guest user creates new profile after he created a listing
		add_filter('woocommerce_new_customer_data', array($this, 'update_user_info'));
		// when guest user logs in after he created a listing
		add_filter('woocommerce_checkout_customer_id', array($this, 'reassign_user'));
		// add subscription meta to order
		add_action('woocommerce_checkout_update_order_meta', array($this, 'add_subscription_order_meta'), 10, 2);
		
		add_filter('alsp_listing_creation_front', array($this, 'create_activation_order'));
		add_filter('alsp_listing_renew', array($this, 'renew_listing_order'), 10, 3);
		add_filter('alsp_listing_raiseup', array($this, 'listing_raiseup_order'), 10, 3);
		add_filter('alsp_listing_upgrade', array($this, 'listing_upgrade_order'), 10, 3);

		// add subscription button and process subscription
		add_action('alsp_dashboard_listing_options', array($this, 'add_subscription_button'));
		add_action('alsp_dashboard_controller_construct', array($this, 'create_subscription_onclick'));
		
		//add_filter('woocommerce_payment_complete_order_status', array($this, 'complete_payment'), 10, 2);
		add_action('woocommerce_order_status_completed', array($this, 'complete_status'), 10);
	}

	public function add_listing_single_product($types){
		$types['listing_single'] = __('Listing Single', 'ALSP');
	
		return $types;
	}
	
	public function listing_single_custom_js() {
		if ('product' != get_post_type())
			return;
	
		?><script type='text/javascript'>
				jQuery(document).ready( function($) {
					$('.options_group.pricing').addClass('show_if_listing_single').show();
					$('.options_group.show_if_downloadable').addClass('hide_if_listing_single').hide();
					$('.general_tab').addClass('active').show();
					$('.listings_tab').removeClass('active');
					$('#general_product_data').show();
					$('#listing_single_product_data').hide();
					$('._tax_status_field').parent().addClass('show_if_listing_single');
					if ($('#product-type option:selected').val() == 'listing_single') {
						$('.show_if_listing_single').show();
						$('.hide_if_listing_single').hide();
					}
				});
			</script><?php
	}
	
	public function hide_attributes_data_panel($tabs) {
		// Other default values for 'attribute' are; general, inventory, shipping, linked_product, variations, advanced
		$tabs['inventory']['class'][] = 'hide_if_listing_single';
		$tabs['shipping']['class'][] = 'hide_if_listing_single';
		$tabs['linked_product']['class'][] = 'hide_if_listing_single';
		$tabs['variations']['class'][] = 'hide_if_listing_single';
		$tabs['attribute']['class'][] = 'hide_if_listing_single';
		$tabs['advanced']['class'][] = 'hide_if_listing_single';
	
		$tabs['listings'] = array(
				'label'	=> __('Listings level', 'ALSP'),
				'target' => 'listing_single_product_data',
				'class'	=> array('show_if_listing_single', 'show_if_listing_single', 'advanced_options'),
		);
		return $tabs;
	}

	public function add_raiseup_price() {
		woocommerce_wp_text_input(array('id' => '_raiseup_price', 'label' => __('Listings raise up price', 'ALSP') . ' (' . get_woocommerce_currency_symbol() . ')', 'data_type' => 'price', 'wrapper_class' => 'show_if_listing_single'));
	}
	
	public function new_product_tab_content() {
		global $alsp_instance;
		?>
			<div id="listing_single_product_data" class="panel woocommerce_options_panel">
					<div class="options_group">
						<?php
						$options = array();
						foreach ($alsp_instance->levels->levels_array as $level)
							$options[$level->id] = __('Single listing of level "'.esc_attr($level->name).'"', 'ALSP');
	
						woocommerce_wp_radio(array('id' => '_listings_level', 'options' => $options, 'label' => __('Choose the level of listing for this product type', 'ALSP')));
						?>
					</div>
			</div>
			<?php 
	}

	public function save_listing_single_tab_content($post_id) {
		update_post_meta($post_id, '_listings_level', (isset($_POST['_listings_level']) ? wc_clean($_POST['_listings_level']) : ''));

		update_post_meta($post_id, '_raiseup_price', (isset($_POST['_raiseup_price']) ? wc_clean($_POST['_raiseup_price']) : ''));
	}
	
	public function create_price($link_text, $listing) {
		if ($product = $this->get_product_by_level_id($listing->level->id))
			return  $link_text .' - ' . alsp_format_price(alsp_recalcPrice($product->get_price()));
	}
	
	public function raiseup_price($link_text, $listing) {
		if ($product = $this->get_product_by_level_id($listing->level->id))
			return  $link_text .' - ' . alsp_format_price(alsp_recalcPrice($product->raiseup_price));
	}
	
	public function renew_price($link_text, $listing) {
		if ($product = $this->get_product_by_level_id($listing->level->id))
			return  $link_text .' - ' . alsp_format_price(alsp_recalcPrice($product->get_price()));
	}
	
	public function upgrade_price($link_text, $old_level, $new_level) {
		if ($product = $this->get_product_by_level_id($new_level->id))
			return  $link_text .' - ' . alsp_format_price(alsp_recalcPrice($product->get_price()));
	}
	
	public function levels_price_front_table_header($pre, $post) {
		echo $pre . __('Price', 'ALSP') . $post;
	}

	public function levels_price_front_table_row($level, $pre, $post) {
		if (!($product = $this->get_product_by_level_id($level->id)) || alsp_recalcPrice($product->get_price()) == 0)
			$out = '<span class="alsp-price alsp-payments-free">' . __('FREE', 'ALSP') . '</span>';
		else {
			$out = '<span class="alsp-price">' . $product->get_price_html() . '</span>';
	
			if (!$level->eternal_active_period) {
				if ($level->active_period == 'day' && $level->active_interval == 1)
					$out .= '/ ' . __('daily', 'ALSP');
				elseif ($level->active_period == 'day' && $level->active_interval > 1)
					$out .= '/ ' . $level->active_interval . ' ' . _n('day', 'days', $level->active_interval, 'ALSP');
				elseif ($level->active_period == 'week' && $level->active_interval == 1)
					$out .= '/ ' . __('weekly', 'ALSP');
				elseif ($level->active_period == 'week' && $level->active_interval > 1)
					$out .= '/ ' . $level->active_interval . ' ' . _n('week', 'weeks', $level->active_interval, 'ALSP');
				elseif ($level->active_period == 'month' && $level->active_interval == 1)
					$out .= '/ ' . __('monthly', 'ALSP');
				elseif ($level->active_period == 'month' && $level->active_interval > 1)
					$out .= '/ ' . $level->active_interval . ' ' . _n('month', 'months', $level->active_interval, 'ALSP');
				elseif ($level->active_period == 'year' && $level->active_interval == 1)
					$out .= '/ ' . __('annually', 'ALSP');
				elseif ($level->active_period == 'year' && $level->active_interval > 1)
					$out .= '/ ' . $level->active_interval . ' ' . _n('year', 'years', $level->active_interval, 'ALSP');
			}
		}
	
		echo $pre . $out . $post;
	}
	
	public function levels_price_table_header($columns) {
		$alsp_columns['price'] = __('Price', 'ALSP');
	
		return array_slice($columns, 0, 2, true) + $alsp_columns + array_slice($columns, 2, count($columns)-2, true);
	}
	
	public function levels_price_table_row($items_array, $level) {
		global $ALSP_ADIMN_SETTINGS;
		if (!($product = $this->get_product_by_level_id($level->id)) || ($ALSP_ADIMN_SETTINGS['alsp_payments_free_for_admins'] && current_user_can('manage_options')))
			$alsp_columns['price'] = '<span class="alsp-payments-free">' . __('FREE', 'ALSP') . '</span>';
		else
			$alsp_columns['price'] = $product->get_price_html();
	
		return array_slice($items_array, 0, 1, true) + $alsp_columns + array_slice($items_array, 1, count($items_array)-1, true);;
	}

	// Woocommerce Dashboard
	public function listing_in_order_table($item_id, $item, $order) {
		if (method_exists($item, 'get_product_id') && ($product = wc_get_product($item->get_product_id())) && $product->get_type() == 'listing_single') {
			if ($listing = $this->get_listing_by_item_id($item_id)) {
				$action = wc_get_order_item_meta($item_id, '_alsp_action');

				if (is_user_logged_in() && alsp_current_user_can_edit_listing($listing->post->ID))
					$listing_link = '<a href="' . alsp_get_edit_listing_link($listing->post->ID) . '" title="' . esc_attr('edit listing', 'ALSP') . '">' . $listing->title() . '</a>';
				else
					$listing_link = $listing->title();
				?>
					<p>
						<?php echo __('Directory listing:', 'ALSP') . '&nbsp;' . $listing_link; ?>
						<br />
						<?php if ($action == 'activation'):
						_e('Order for activation of listing', 'ALSP'); ?>
						<br />
						<?php endif; ?>
						<?php if ($action == 'renew'):
						_e('Order for listing renewal', 'ALSP'); ?>
						<br />
						<?php endif; ?>
						<?php if ($action == 'raiseup'):
						_e('Order for listing raise up', 'ALSP'); ?>
						<br />
						<?php endif; ?>
						<?php if ($action == 'upgrade'):
						_e('Order for listing upgrade', 'ALSP'); ?>
						<br />
						<?php endif; ?>
						<?php _e('Status:', 'ALSP');
						if ($listing->status == 'active')
							echo ' <span class="alsp-badge alsp-listing-status-active">' . __('active', 'ALSP') . '</span>';
						elseif ($listing->status == 'expired')
							echo ' <span class="alsp-badge alsp-listing-status-expired">' . __('expired', 'ALSP') . '</span>';
						elseif ($listing->status == 'unpaid')
							echo ' <span class="alsp-badge alsp-listing-status-unpaid">' . __('unpaid', 'ALSP') . '</span>';
						elseif ($listing->status == 'stopped')
							echo ' <span class="alsp-badge alsp-listing-status-stopped">' . __('stopped', 'ALSP') . '</span>';
						?>
						<br />
						<?php _e('Expiration Date:', 'ALSP'); ?>&nbsp;
						<?php if ($listing->level->eternal_active_period) _e('Eternal active period', 'ALSP'); else echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), intval($listing->expiration_date)); ?>
					</p>
					<?php 
			}
		}
	}
	
	public function listing_in_subscriptions_table($html, $item, $args) {
		if (alsp_getValue($_GET, 'post_type') == 'shop_subscription') {
			if (method_exists($item, 'get_product_id') && ($product = wc_get_product($item->get_product_id())) && $product->get_type() == 'listing_single') {
				if ($listing = $this->get_listing_by_item_id($item->get_id())) {
					if ($listing->status == 'active')
						$listing_status = __('active', 'ALSP');
					elseif ($listing->status == 'expired')
						$listing_status = __('expired', 'ALSP');
					elseif ($listing->status == 'unpaid')
						$listing_status = __('unpaid', 'ALSP');
					elseif ($listing->status == 'stopped')
						$listing_status = __('stopped', 'ALSP');
	
					$html .= '<div style="text-align: left;">' .
							__('Directory listing:', 'ALSP') . '&nbsp;' . $listing->title() .
							'<br />' .
							__('Status:', 'ALSP') . '&nbsp;' . $listing_status .
							'<br />' .
							__('Expiration Date:', 'ALSP') . '&nbsp;' .
							(($listing->level->eternal_active_period) ? __('Eternal active period', 'ALSP') : date_i18n(get_option('date_format') . ' ' . get_option('time_format'), intval($listing->expiration_date)));
							'</div>';
				}
			}
		}
		
		return $html;
	}

	public function update_user_info($customer_data) {
		foreach (WC()->cart->cart_contents as $value) {
			$product = $value['data'];
			if (isset($value['_alsp_anonymous_user']) && isset($value['_alsp_listing_id']) && isset($value['_alsp_action']) && $value['_alsp_action'] == 'activation' && $product->get_type() == 'listing_single') {
				$listing = alsp_getListing($value['_alsp_listing_id']);
				if ($listing) {
					$customer_data['ID'] = $listing->post->post_author;
					return $customer_data;
				}
			}
		}

		return $customer_data;
	}
	
	public function reassign_user($user_id) {
		if ($user_id && get_userdata($user_id) !== false) {
			foreach (WC()->cart->cart_contents as $value) {
				$product = $value['data'];
				if (isset($value['_alsp_anonymous_user']) && isset($value['_alsp_listing_id']) && isset($value['_alsp_action']) && $value['_alsp_action'] == 'activation' && $product->get_type() == 'listing_single') {
					$listing = alsp_getListing($value['_alsp_listing_id']);
					if ($listing && $listing->post->post_author != $user_id) {
						$arg = array(
								'ID' => $listing->post->ID,
								'post_author' => $user_id,
						);
						wp_update_post($arg);
					}
				}
			}
		}
		
		return $user_id;
	}

	public function listing_in_checkout($item_data, $cart_item) {
		$product = $cart_item['data'];
		if (isset($cart_item['_alsp_listing_id']) && $product->get_type() == 'listing_single') {
			$listing = alsp_getListing($cart_item['_alsp_listing_id']);
			if ($listing) {
				$item_data[] = array(
						'name' => __('Listing name', 'ALSP'),
						'value' => $listing->title()
				);
				if (isset($cart_item['_alsp_action'])) {
					$item_data[] = array(
							'name' => __('Listing action', 'ALSP'),
							'value' => $cart_item['_alsp_action']
					);
				}

				if (
					class_exists('WC_Subscriptions') &&
					is_checkout() &&
					isset($cart_item['_alsp_action']) &&
					in_array($cart_item['_alsp_action'], array('activation', 'renew', 'upgrade')) &&
					!$listing->level->eternal_active_period
				) {
					$last_subscription = alsp_get_last_subscription_of_listing($listing->post->ID);
					if ($cart_item['_alsp_action'] == 'renew' && $last_subscription && $last_subscription->get_status() == 'active') {
						echo '<div class="alsp-enable-subsciption-option">';
						echo '<strong>' . __('subscription enabled', 'ALSP') . '</strong>';
						echo '</div>';
					} else {
						if (alsp_getValue($_POST, 'alsp_enable_subscription_' . $listing->post->ID) || ($last_subscription && $last_subscription->get_status() == 'active')) {
							$checked = 1;
						} else {
							$checked = 0;
						}
	
						echo '<div class="alsp-enable-subsciption-option">';
						echo '<label><input type="checkbox" name="alsp_enable_subscription_' . $listing->post->ID . '" value="1" ' . checked($checked, 1, false) . " />&nbsp;" . __('enable subscription', 'ALSP') . '</label>';
						echo '</div>';
					}
				}
			}
		}
		
		return $item_data;
	}
	
	public function add_subscription_order_meta($order_id, $data) {
		if (class_exists('WC_Subscriptions')) {
			$order = wc_get_order($order_id);
			if (get_class($order) == 'WC_Order') {
				$items = $order->get_items();
				foreach ($items AS $item_id=>$item) {
					if (is_a($item, 'WC_Order_Item_Product') && ($product = wc_get_product($item->get_product_id())) && $product->get_type() == 'listing_single') {
						if ($listing = $this->get_listing_by_item_id($item_id)) {
							if (alsp_getValue($_POST, 'alsp_enable_subscription_' . $listing->post->ID)) {
								wc_add_order_item_meta($item_id, '_alsp_do_subscription', true);
							}
						}
					}
				}
			}
		}
	}
	
	public function checkout_listing_raiseup_price($cart_object) {
		foreach ($cart_object->cart_contents as $value) {
			$product = $value['data'];
			if (isset($value['_alsp_action']) && $value['_alsp_action'] == 'raiseup' && $product->get_type() == 'listing_single') {
				$value['data']->set_price($value['data']->raiseup_price);
			}
		}
	}
	
	public function add_order_item_meta($item_id, $item, $order_id) {
		if (isset($item->legacy_values['_alsp_listing_id'])) {
			wc_add_order_item_meta($item_id, '_alsp_listing_id', $item->legacy_values['_alsp_listing_id']);
		}
		if (isset($item->legacy_values['_alsp_action'])) {
			wc_add_order_item_meta($item_id, '_alsp_action', $item->legacy_values['_alsp_action']);
		}
	}
	
	public function order_again_cart_item_data($cart_item_data, $item, $order) {
		$items = $order->get_items();
		foreach ($items AS $item_id=>$item) {
			if (is_a($item, 'WC_Order_Item_Product') && ($product = wc_get_product($item->get_product_id())) && $product->get_type() == 'listing_single') {
				$listing_id = wc_get_order_item_meta($item_id, '_alsp_listing_id');
				$action = wc_get_order_item_meta($item_id, '_alsp_action');
				
				if ($listing_id && $action) {
					$cart_item_data = $cart_item_data + array(
							'_alsp_listing_id' => $listing_id,
							'_alsp_action' => $action
					);
				}
			}
		}
		
		return $cart_item_data;
	}
	
	public function create_listing_single_order($listing_id, $level_id, $action = 'activation', $redirect = true) {
		if ($product = $this->get_product_by_level_id($level_id)) {
			$options = array(
					'_alsp_listing_id' => $listing_id,
					'_alsp_action' => $action
			);

			if ($action == 'activation' && !is_user_logged_in()) {
				$options['_alsp_anonymous_user'] = true;
			}

			if (!is_admin() && !defined('DOING_CRON')) {
				WC()->cart->add_to_cart($product->get_id(), 1, 0, array(), $options);
				if ($redirect && ($checkout_url = wc_get_checkout_url())) {
					wp_redirect($checkout_url);
					die();
				}
			} else {
				// on admin dashboard we create new order directly without cart and checkout
				if ($action == 'raiseup') {
					$product->set_price($product->raiseup_price);
				}

				$user_id = get_current_user_id();
				$order = wc_create_order(array('customer_id' => $user_id));

				$order_item_id = $order->add_product($product);
				
				alsp_set_order_address($order, $user_id);
				
				$order->calculate_totals();
				
				wc_add_order_item_meta($order_item_id, '_alsp_listing_id', $listing_id);
				wc_add_order_item_meta($order_item_id, '_alsp_action', $action);
				
				if (!defined('DOING_CRON'))
					alsp_addMessage(__('Complete the order on WooCommerce Orders page.', 'ALSP'));
			}
		}
	}

	public function create_activation_order($listing) {
		if ($listing && ($product = $this->get_product_by_level_id($listing->level->id)) && alsp_recalcPrice($product->get_price()) > 0) {
			update_post_meta($listing->post->ID, '_listing_status', 'unpaid');
			$this->create_listing_single_order($listing->post->ID, $listing->level->id, 'activation');
		}
		return $listing;
	}
	
	public function renew_listing_order($continue, $listing, $continue_invoke_hooks) {
		if ($continue_invoke_hooks[0]) {
			if ($order = alsp_get_last_order_of_listing($listing->post->ID)) {
				if (!$order->is_paid() && $order->get_status() == 'completed') {
					$order_url = $order->get_checkout_payment_url();
					if ($order_url && is_user_logged_in()) {
						wp_redirect($order_url);
						die();
					}
					return false;
				}
			}
	
			if (($product = $this->get_product_by_level_id($listing->level->id)) && alsp_recalcPrice($product->get_price()) > 0) {
				$this->create_listing_single_order($listing->post->ID, $listing->level->id, 'renew');
				$continue_invoke_hooks[0] = false;
				return false;
			}
		}

		return $continue;
	}
	
	public function listing_raiseup_order($continue, $listing, $continue_invoke_hooks) {
		if ($continue_invoke_hooks[0]) {
			if (($product = $this->get_product_by_level_id($listing->level->id)) && alsp_recalcPrice($product->raiseup_price) > 0) {
				$this->create_listing_single_order($listing->post->ID, $listing->level->id, 'raiseup');
				$continue_invoke_hooks[0] = false;
				return false;
			}
		}
		return $continue;
	}

	public function listing_upgrade_order($continue, $listing, $continue_invoke_hooks) {
		if ($continue_invoke_hooks[0]) {
			$new_level_id = get_post_meta($listing->post->ID, '_new_level_id', true);
			if ($new_level_id && ($product = $this->get_product_by_level_id($new_level_id)) && alsp_recalcPrice($product->get_price()) > 0) {
				$this->create_listing_single_order($listing->post->ID, $new_level_id, 'upgrade');
				$continue_invoke_hooks[0] = false;
				return false;
			}
		}
		
		return $continue;
	}

	public function complete_payment($status, $order_id) {
		$this->activate_listing($status, $order_id);
	
		return $status;
	}
	
	public function complete_status($order_id) {
		$this->activate_listing('completed', $order_id);
	}
	
	public function activate_listing($status, $order_id) {
		if ($status == 'completed') {
			$order = wc_get_order($order_id);
			if (get_class($order) == 'WC_Order') {
				$items = $order->get_items();
				foreach ($items AS $item_id=>$item) {
					if (is_a($item, 'WC_Order_Item_Product') && ($product = wc_get_product($item->get_product_id())) && $product->get_type() == 'listing_single') {
						if ($listing = $this->get_listing_by_item_id($item_id)) {
							$action = wc_get_order_item_meta($item_id, '_alsp_action');
							switch ($action) {
								case "activation":
									$listing->processActivate(false);

									if (class_exists('WC_Subscriptions') && wc_get_order_item_meta($item_id, '_alsp_do_subscription')) {
										$this->create_subscription($order_id);
									}
									break;
								case "renew":
									$listing->processActivate(false);
									
									if (class_exists('WC_Subscriptions')) {
										$last_subscription = alsp_get_last_subscription_of_listing($listing->post->ID);
										if (wc_get_order_item_meta($item_id, '_alsp_do_subscription') && (!$last_subscription || $last_subscription->get_status() != 'active')) {
											$this->create_subscription($order_id);
										}
									}
									break;
								case "raiseup":
									$listing->processRaiseUp(false);
									break;
								case "upgrade":
									$new_level_id = get_post_meta($listing->post->ID, '_new_level_id', true);
									$listing->changeLevel($new_level_id, false);
									
									if (class_exists('WC_Subscriptions')) {
										$this->cancel_subscriptions($listing, __('Listing has changed level and the subscription was cancelled. New subscription was created.', 'ALSP'));
										if (wc_get_order_item_meta($item_id, '_alsp_do_subscription')) {
											$this->create_subscription($order_id);
										}
									}

									break;
							}
						}
					}
				}
			}
		}
	}
	
	public function add_subscription_button($listing) {
		if (class_exists('WC_Subscriptions')) {
			if (!$listing->level->eternal_active_period) {
				$last_subscription = alsp_get_last_subscription_of_listing($listing->post->ID);

				if ($listing->status == 'active' && (!$last_subscription || $last_subscription->get_status() == 'trash')) {
					$order = alsp_get_last_order_of_listing($listing->post->ID, array('activation', 'upgrade'));
					if ($order && $order->is_paid() && $order->get_status() == 'completed') {
						$subscription_link = strip_tags(__('add subscription', 'ALSP'));
						echo '<a href="' . alsp_dashboardUrl(array('add_subscription' => '1', 'listing_id' => $listing->post->ID)) . '" class="btn btn-primary btn-sm alsp-dashboard-subscription-btn" title="' . esc_attr($subscription_link) . '"><span class="glyphicon glyphicon-repeat"></span></a>';
					}
				} elseif ($last_subscription && ($subscription_url = $last_subscription->get_view_order_url())) {
					$subscription_link = strip_tags(__('view subscription', 'ALSP'));
					echo '<a href="' . $subscription_url . '" class="btn btn-primary btn-sm alsp-dashboard-subscription-btn" title="' . esc_attr($subscription_link) . '"><span class="glyphicon glyphicon-repeat"></span></a>';
				}
			}
		}
	}
	
	public function create_subscription_onclick() {
		if (class_exists('WC_Subscriptions')) {
			if (alsp_getValue($_GET, 'add_subscription') && ($listing_id = alsp_getValue($_GET, 'listing_id')) && ($listing = alsp_getListing($listing_id))) {
				if ($listing->status == 'active' && !$listing->level->eternal_active_period) {
					$last_subscription = alsp_get_last_subscription_of_listing($listing->post->ID);
				
					if (!$last_subscription || $last_subscription->get_status() == 'trash') {
						$order = alsp_get_last_order_of_listing($listing_id, array('activation', 'upgrade'));
						if ($order && $order->is_paid() && $order->get_status() == 'completed') {
							$this->cancel_subscriptions($listing);

							$this->create_subscription($order->get_id());
							alsp_addMessage(__('Subscription was created sucessfully!', 'ALSP'));
							wp_redirect(alsp_dashboardUrl());
							die();
						}
					} else {
						alsp_addMessage(sprintf(__('Subscription for this listing already exists. You can manage it <a href="%s">here</a>', 'ALSP'), $last_subscription->get_view_order_url()));
					}
				}
			}
		}
	}
	
	public function get_product_by_level_id($level_id) {
		$result = get_posts(array(
				'post_type' => 'product',
				'posts_per_page' => 1,
				'tax_query' => array(array(
						'taxonomy' => 'product_type',
						'field' => 'slug',
						'terms' => array('listing_single'),
						'operator' => 'IN'
				)),
				'meta_query' => array(
						array(
								'key' => '_listings_level',
								'value' => $level_id,
								'type' => 'numeric'
						)
				)
		));
		if ($result)
			return wc_get_product($result[0]->ID);
	}
	
	function get_listing_by_item_id($item_id) {
		$listing_id = wc_get_order_item_meta($item_id, '_alsp_listing_id');
		if ($listing_id) {
			$listing = alsp_getListing($listing_id);
			if ($listing) {
				return $listing;
			}
		}
	}
	
	function create_subscription($order_id) {
		if (class_exists('WC_Subscriptions')) {
			$order = wc_get_order($order_id);
			$items = $order->get_items();
			foreach ($items AS $item_id=>$item) {
				if (is_a($item, 'WC_Order_Item_Product') && ($product = wc_get_product($item->get_product_id())) && $product->get_type() == 'listing_single') {
					$listing_id = wc_get_order_item_meta($item_id, '_alsp_listing_id');

					if (($listing = alsp_getListing($listing_id)) && !$listing->level->eternal_active_period) {
						$args = array(
								'order_id' => $order_id,
								'customer_id' => $listing->post->post_author,
								'billing_period' => $listing->level->active_period,
								'billing_interval' => $listing->level->active_interval,
								'start_date' => gmdate('Y-m-d H:i:s'),
						);
						$subscription = wcs_create_subscription($args);
						if (!is_wp_error($subscription)) {
							$subscription_item_id = $subscription->add_product($product);
							$subscription->set_payment_method(wc_get_payment_gateway_by_order($order));
							wc_add_order_item_meta($subscription_item_id, '_alsp_listing_id', $listing_id);
							wc_add_order_item_meta($subscription_item_id, '_alsp_action', 'renew');
							$subscription->calculate_totals();

							$dates['next_payment'] = gmdate('Y-m-d H:i:s', $listing->expiration_date);
							$subscription->update_dates($dates);
						}
					}
				}
			}
			WC_Subscriptions_Manager::activate_subscriptions_for_order($order);
		}
	}
	
	function cancel_subscriptions($listing, $notice = '') {
		if (class_exists('WC_Subscriptions')) {
			$orders = alsp_get_all_orders_of_listing($listing->post->ID);
			if ($orders) {
				foreach ($orders AS $order) {
					$subscriptions = wcs_get_subscriptions_for_order($order);
					foreach ($subscriptions AS $subscription) {
						if ($subscription->has_status('active')) {
							$subscription->cancel_order($notice);
						}
					}
				}
			}
		}
	}
}
?>