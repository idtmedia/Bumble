<?php

define('ALSP_INVOICE_TYPE', 'alsp_invoice');

define('ALSP_PAYMENTS_PATH', plugin_dir_path(__FILE__));

function alsp_payments_loadPaths() {
	define('ALSP_PAYMENTS_TEMPLATES_PATH',  ALSP_PAYMENTS_PATH . 'templates/');

	if (!defined('ALSP_THEME_MODE'))
		define('ALSP_PAYMENTS_RESOURCES_URL', plugins_url('/', __FILE__) . 'resources/');
}
add_action('init', 'alsp_payments_loadPaths', 0);

include_once ALSP_PAYMENTS_PATH . 'classes/invoice.php';

class alsp_payments_plugin {
	
	public function __construct() {
		register_activation_hook(__FILE__, array($this, 'activation'));
	}
	
	public function activation() {
		include_once(ABSPATH . 'wp-admin/includes/plugin.php');
		if (!defined('ALSP_VERSION') && version_compare(ALSP_VERSION, '1.2.0', '<=')) {
			deactivate_plugins(basename(__FILE__)); // Deactivate ourself
			wp_die("ALSP Ads Listing System Plugin v1.2.0 or greater required.");
		}
	}

	public function init() {
		global $alsp_instance;
		
		if (!get_option('alsp_installed_payments'))
			alsp_install_payments();
		add_action('alsp_version_upgrade', 'alsp_upgrade_payments');

		add_action('init', array($this, 'register_invoice_type'));
		add_action('load-post-new.php', array($this, 'disable_new_invoices_page'));
		// remove links on all pages - 2 hooks needed
		add_action('admin_menu', array($this, 'disable_new_invoices_link'));
		add_action('admin_head', array($this, 'disable_new_invoices_link'));

		//add_filter('alsp_build_settings', array($this, 'plugin_settings'));
		
		add_filter('manage_'.ALSP_INVOICE_TYPE.'_posts_columns', array($this, 'add_invoices_table_columns'));
		add_filter('manage_'.ALSP_INVOICE_TYPE.'_posts_custom_column', array($this, 'manage_invoices_table_rows'), 10, 2);
		add_filter('post_row_actions', array($this, 'remove_row_actions'), 10, 2);
		add_action('wp_before_admin_bar_render', array($this, 'remove_create_invoice_link'));

		add_action('admin_init', array($this, 'remove_metaboxes'));
		add_action('add_meta_boxes', array($this, 'add_invoice_info_metabox'));
		add_action('add_meta_boxes', array($this, 'add_invoice_payment_metabox'));
		add_action('add_meta_boxes', array($this, 'add_invoice_log_metabox'));
		add_action('add_meta_boxes', array($this, 'add_invoice_actions_metabox'));

		add_filter('template_include', array($this, 'print_invoice_template'), 100000);
		
		$this->loadPricesByLevels();
		add_filter('alsp_levels_loading', array($this, 'loadPricesByLevels'), 10, 2);

		add_filter('alsp_level_html', array($this, 'levels_price_in_level_html'));
		add_filter('alsp_level_validation', array($this, 'levels_price_in_level_validation'));
		add_filter('alsp_level_create_edit_args', array($this, 'levels_price_in_level_create_add'), 1, 2);
		add_filter('alsp_level_table_header', array($this, 'levels_price_table_header'));
		add_filter('alsp_level_table_row', array($this, 'levels_price_table_row'), 10, 2);

		add_action('alsp_submitlisting_levels_th', array($this, 'levels_price_front_table_header'), 10, 2);
		add_action('alsp_submitlisting_levels_rows', array($this, 'levels_price_front_table_row'), 10, 3);
		
		add_filter('alsp_level_upgrade_meta', array($this, 'levels_upgrade_meta'), 10, 2);
		add_action('alsp_upgrade_meta_html', array($this, 'levels_upgrade_meta_html'), 10, 2);
		
		add_filter('alsp_create_listings_steps_html', array($this, 'pay_invoice_step'), 10, 2);

		add_filter('alsp_create_option', array($this, 'create_price'), 10, 2);
		add_filter('alsp_raiseup_option', array($this, 'raiseup_price'), 10, 2);
		add_filter('alsp_renew_option', array($this, 'renew_price'), 10, 2);
		add_filter('alsp_level_upgrade_option', array($this, 'upgrade_price'), 10, 3);
		
		add_action('admin_init', array($this, 'invoice_actions'));
		add_action('get_header', array($this, 'invoice_actions'));
		
		add_action('alsp_invoice_status_option', array($this, 'apply_payment_link'));
		add_action('init', array($this, 'apply_payment'));
		
		add_filter('query_vars', array($this, 'alsp_payments_query_vars'));
		
		// This is really strange thing, that users may see ANY attachments (including invoices) owned by other users, so we need this hack
		add_filter('pre_get_posts', array($this, 'prevent_users_see_other_invoices'));
		
		add_filter('bulk_actions-edit-'.ALSP_INVOICE_TYPE, array($this, 'remove_bulk_actions'));
		
		add_action('alsp_dashboard_links', array($this, 'add_invoices_dashboard_link'));
		add_action('alsp_dashboard_links2', array($this, 'add_invoices_dashboard_link2'));
		add_filter('alsp_frontend_controller_construct', array($this, 'handle_dashboard_controller'));
		add_filter('alsp_get_edit_invoice_link', array($this, 'edit_invoices_links'), 10, 2);

		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
	}
	
	/**
	 * check is there template in one of these paths:
	 * - themes/theme/alsp-plugin/templates/alsp_payments/
	 * - plugins/alsp/templates/alsp_payments/
	 * 
	 */
	public function check_custom_template($template, $args) {
		if (is_array($template)) {
			$template_path = $template[0];
			$template_file = $template[1];
				
			if ($template_path == ALSP_PAYMENTS_TEMPLATES_PATH && ($fsubmit_template = alsp_isFrontPart('alsp_payments/' . $template_file))) {
				return $fsubmit_template;
			}
		}
		return $template;
	}
	
	public function add_invoices_table_columns($columns) {
		$alsp_columns['item'] = __('Item', 'ALSP');
		$alsp_columns['price'] = __('Price', 'ALSP');
		$alsp_columns['payment'] = __('Payment', 'ALSP');

		$columns['title'] = __('Invoice', 'ALSP');
		
		unset($columns['cb']);

		return array_slice($columns, 0, 1, true) + $alsp_columns + array_slice($columns, 1, count($columns)-1, true);
	}
	
	public function manage_invoices_table_rows($column, $invoice_id) {
		switch ($column) {
			case "item":
				if (($invoice = getInvoiceByID($invoice_id)) && is_object($invoice->item_object))
					echo $invoice->item_object->getItemLink();
				break;
			case "price":
				if ($invoice = getInvoiceByID($invoice_id))
					echo $invoice->price();
				break;
			case "payment":
				if ($invoice = getInvoiceByID($invoice_id))
					if ($invoice->status == 'unpaid') {
						echo '<span class="alsp-badge alsp-invoice-status-unpaid">' . __('unpaid', 'ALSP') . '</span>';
						if (alsp_current_user_can_edit_listing($invoice->post->ID) && current_user_can('edit_published_posts'))
							echo '<br /><a href="' . alsp_get_edit_invoice_link($invoice_id) . '"><img src="' . ALSP_PAYMENTS_RESOURCES_URL . 'images/money_add.png' . '" class="alsp-field-icon" />' . __('pay invoice', 'ALSP') . '</a>';
					} elseif ($invoice->status == 'paid') {
						echo '<span class="alsp-badge alsp-invoice-status-paid">' . __('paid', 'ALSP') . '</span>';
						if ($invoice->gateway)
							echo '<br /><b>' . gatewayName($invoice->gateway) . '</b>';
					} elseif ($invoice->status == 'pending') {
						echo '<span class="alsp-badge alsp-invoice-status-pending">' . __('pending', 'ALSP') . '</span>';
						if ($invoice->gateway)
							echo '<br /><b>' . gatewayName($invoice->gateway) . '</b>';
					}
				break;
		}
	}
	
	public function remove_row_actions($actions, $post) {
		if ($post->post_type == ALSP_INVOICE_TYPE) {
			unset($actions['inline hide-if-no-js']);
			unset($actions['view']);
			//unset($actions['trash']);
		}
		return $actions;
	}
	
	public function remove_create_invoice_link() {
		global $wp_admin_bar;

		$wp_admin_bar->remove_menu('new-alsp_invoice');
	}
	
	public function remove_metaboxes() {
		remove_meta_box('submitdiv', ALSP_INVOICE_TYPE, 'side');
		remove_meta_box('slugdiv', ALSP_INVOICE_TYPE, 'normal');
		remove_meta_box('authordiv', ALSP_INVOICE_TYPE, 'normal');
	}
	
	public function add_invoice_info_metabox($post_type) {
		if ($post_type == ALSP_INVOICE_TYPE) {
			add_meta_box('alsp_invoice_info',
					__('Invoice Info', 'ALSP'),
					array($this, 'invoice_info_metabox'),
					ALSP_INVOICE_TYPE,
					'normal',
					'high');
		}
	}
	
	public function invoice_info_metabox($post) {
		$invoice = getInvoiceByID($post->ID);
		alsp_frontendRender(array(ALSP_PAYMENTS_TEMPLATES_PATH, 'info_metabox.tpl.php'), array('invoice' => $invoice));
	}
	
	public function add_invoice_log_metabox($post_type) {
		global $post;

		if ($post_type == ALSP_INVOICE_TYPE) {
			if ($post && ($invoice = getInvoiceByID($post->ID)) && $invoice->log) {
				add_meta_box('alsp_invoice_log',
						__('Invoice Log', 'ALSP'),
						array($this, 'invoice_log_metabox'),
						ALSP_INVOICE_TYPE,
						'normal',
						'high');
			}
		}
	}
	
	public function invoice_log_metabox($post) {
		$invoice = getInvoiceByID($post->ID);
		alsp_frontendRender(array(ALSP_PAYMENTS_TEMPLATES_PATH, 'log_metabox.tpl.php'), array('invoice' => $invoice));
	}

	public function add_invoice_payment_metabox($post_type) {
		global $post, $ALSP_ADIMN_SETTINGS;

		if ($post_type == ALSP_INVOICE_TYPE) {
			if ($ALSP_ADIMN_SETTINGS['alsp_paypal_email'] || $ALSP_ADIMN_SETTINGS['alsp_allow_bank'] || (($ALSP_ADIMN_SETTINGS['alsp_stripe_test'] && $ALSP_ADIMN_SETTINGS['alsp_stripe_test_secret'] && $ALSP_ADIMN_SETTINGS['alsp_stripe_test_public']) || ($ALSP_ADIMN_SETTINGS['alsp_stripe_live_secret'] && $ALSP_ADIMN_SETTINGS['alsp_stripe_live_public'])) || (($ALSP_ADIMN_SETTINGS['alsp_authorize_test'] && $ALSP_ADIMN_SETTINGS['alsp_authorize_test_loginid'] && $ALSP_ADIMN_SETTINGS['alsp_authorize_test_transactionid']) || ($ALSP_ADIMN_SETTINGS['alsp_authorize_live_loginid'] && $ALSP_ADIMN_SETTINGS['alsp_authorize_live_transactionid']))) {
				if ($post && ($invoice = getInvoiceByID($post->ID)) && $invoice->status == 'unpaid' && !$invoice->gateway) {
					add_meta_box('alsp_invoice_payment',
							__('Invoice Payment - choose payment gateway', 'ALSP'),
							array($this, 'invoice_payment_metabox'),
							ALSP_INVOICE_TYPE,
							'normal',
							'high');
				}
			}
		}
	}
	
	public function invoice_payment_metabox($post) {
		$invoice = getInvoiceByID($post->ID);
		
		$paypal = new alsp_paypal();
		$paypal_subscription = new alsp_paypal_subscription();
		$bank_transfer = new alsp_bank_transfer();
		$stripe = new alsp_stripe();
		
		alsp_frontendRender(array(ALSP_PAYMENTS_TEMPLATES_PATH, 'payment_metabox.tpl.php'), array('invoice' => $invoice, 'paypal' => $paypal, 'paypal_subscription' => $paypal_subscription, 'bank_transfer' => $bank_transfer, 'stripe' => $stripe));
	}

	public function add_invoice_actions_metabox($post_type) {
		if ($post_type == ALSP_INVOICE_TYPE) {
			add_meta_box('alsp_invoice_actions',
					__('Invoice actions', 'ALSP'),
					array($this, 'invoice_actions_metabox'),
					ALSP_INVOICE_TYPE,
					'side',
					'high');
		}
	}
	
	public function invoice_actions_metabox($post) {
		$invoice = getInvoiceByID($post->ID);
		alsp_frontendRender(array(ALSP_PAYMENTS_TEMPLATES_PATH, 'actions_metabox.tpl.php'), array('invoice' => $invoice));
	}

	public function register_invoice_type() {
		$args = array(
			'labels' => array(
				'name' => __('Listing invoices', 'ALSP'),
				'singular_name' => __('Listing invoice', 'ALSP'),
				'edit_item' => __('View Invoice', 'ALSP'),
				'search_items' => __('Search invoices', 'ALSP'),
				'not_found' =>  __('No invoices found', 'ALSP'),
				'not_found_in_trash' => __('No invoices found in trash', 'ALSP')
			),
			'has_archive' => true,
			'description' => __('Listing invoices', 'ALSP'),
			'show_ui' => true,
			'supports' => array('author'),
			'menu_icon' => ALSP_PAYMENTS_RESOURCES_URL . 'images/dollar.png',
		);
		register_post_type(ALSP_INVOICE_TYPE, $args);
	}
	
	function disable_new_invoices_page() {
		if (isset($_GET['post_type']) && $_GET['post_type'] == ALSP_INVOICE_TYPE)
			wp_die("You ain't allowed to do that!");
	}
	function disable_new_invoices_link() {
		global $submenu;
		unset($submenu['edit.php?post_type=' . ALSP_INVOICE_TYPE][10]);

		if (function_exists('get_current_screen')) {
			$screen = get_current_screen();
			if ($screen && $screen->post_type == ALSP_INVOICE_TYPE)
				echo '<style type="text/css">.add-new-h2, h1 .page-title-action { display:none; }</style>';
		}
	}
	
	public function loadPricesByLevels($level = null, $array = array()) {
		global $alsp_instance, $wpdb;

		if (!$array) {
			$array = $wpdb->get_results("SELECT * FROM {$wpdb->alsp_levels} ORDER BY order_num", ARRAY_A);

			foreach ($array AS $row) {
				$alsp_instance->levels->levels_array[$row['id']]->price = $row['price'];
				$alsp_instance->levels->levels_array[$row['id']]->raiseup_price = $row['raiseup_price'];
				
				if (is_object($level) && $level->id == $row['id']) {
					$level->price = $row['price'];
					$level->raiseup_price = $row['raiseup_price'];
				}
			}
		} else {
			$level->price = $array['price'];
			$level->raiseup_price = $array['raiseup_price'];
		}
		
		return $level;
	}
	
	public function levels_price_in_level_html($level) {
		alsp_frontendRender(array(ALSP_PAYMENTS_PATH, 'templates/levels_price_in_level.tpl.php'), array('level' => $level));
	}
	
	public function levels_price_in_level_validation($validation) {
		$validation->set_rules('price', __('Listings price', 'ALSP'), 'is_numeric');
		$validation->set_rules('raiseup_price', __('Listings raise up price', 'ALSP'), 'is_numeric');
		
		return $validation;
	}
	
	public function levels_price_in_level_create_add($insert_update_args, $array) {
		$insert_update_args['price'] = alsp_getValue($array, 'price', 0);
		$insert_update_args['raiseup_price'] = alsp_getValue($array, 'raiseup_price', 0);
		return $insert_update_args;
	}
	
	public function levels_price_table_header($columns) {
		$alsp_columns['price'] = __('Price', 'ALSP');
		
		return array_slice($columns, 0, 2, true) + $alsp_columns + array_slice($columns, 2, count($columns)-2, true);
	}

	public function levels_price_table_row($items_array, $level) {
		$alsp_columns['price'] = formatPrice($level->price);
		
		return array_slice($items_array, 0, 1, true) + $alsp_columns + array_slice($items_array, 1, count($items_array)-1, true);
	}
	
	public function levels_price_front_table_header($pre, $post) {
		echo $pre . __('Price', 'ALSP') . $post;
	}

	public function levels_price_front_table_row($level, $pre, $post) {
		global $ALSP_ADIMN_SETTINGS;
			$thousands_separator = $ALSP_ADIMN_SETTINGS['alsp_payments_thousands_separator'];
			if ($thousands_separator == 'space')
				$thousands_separator = ' ';

			$value = explode('.', number_format($level->price, 2, '.', $thousands_separator));
			if($ALSP_ADIMN_SETTINGS['alsp_hide_decimals'] == false){
				$cents = array_pop($value);
			}else{
				$cents = '';
			}
			$price = implode('.', $value);
		if ($level->price == 0){
			$out = '<span class="alsp-price alsp-payments-free">' . __('0', 'ALSP') . '<span class="alsp-price-cents">' . $cents . '</span></span>';
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
			
		}else {
			$thousands_separator = $ALSP_ADIMN_SETTINGS['alsp_payments_thousands_separator'];
			if ($thousands_separator == 'space')
				$thousands_separator = ' ';

			$value = explode('.', number_format($level->price, 2, '.', $thousands_separator));
			if($ALSP_ADIMN_SETTINGS['alsp_hide_decimals'] == false){
				$cents = array_pop($value);
			}else{
				$cents = '';
			}
			$price = implode('.', $value);
			if ($ALSP_ADIMN_SETTINGS['alsp_hide_decimals'] == false){
				$out = $price . '<span class="alsp-price-cents">' . $cents . '</span>';
			}else{
				$out = (round($price));
			}
			switch ($ALSP_ADIMN_SETTINGS['alsp_payments_symbol_position']) {
				case 1:
					$out = $ALSP_ADIMN_SETTINGS['alsp_payments_symbol_code'] . $out;
					break;
				case 2:
					$out = $ALSP_ADIMN_SETTINGS['alsp_payments_symbol_code'] . ' ' . $out;
					break;
				case 3:
					$out = $out . $ALSP_ADIMN_SETTINGS['alsp_payments_symbol_code'];
					break;
				case 4:
					$out = $out . ' ' . $ALSP_ADIMN_SETTINGS['alsp_payments_symbol_code'];
					break;
			}
			$out = '<span class="alsp-price">' . $out . '</span>';
			
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
	
	public function levels_upgrade_meta($upgrade_meta, $level) {
		global $alsp_instance;

		if (alsp_getValue($_GET, 'page') == 'alsp_manage_upgrades') {
			$results = array();
			foreach ($alsp_instance->levels->levels_array AS $_level) {
				if (($price = alsp_getValue($_POST, 'level_price_' . $level->id . '_' . $_level->id)) && is_numeric($price))
					$results[$_level->id]['price'] = $price;
				else
					$results[$_level->id]['price'] = 0;
			}
	
			foreach ($upgrade_meta AS $level_id=>$meta)
				if (isset($results[$level_id]))
					$upgrade_meta[$level_id] = $results[$level_id] + $upgrade_meta[$level_id];
		}

		return $upgrade_meta;
	}
	
	public function levels_upgrade_meta_html($level1, $level2) {
		global $ALSP_ADIMN_SETTINGS;
		if (isset($level1->upgrade_meta[$level2->id]) && isset($level1->upgrade_meta[$level2->id]['price']))
			$price = $level1->upgrade_meta[$level2->id]['price'];
		else
			$price = 0;

		echo $ALSP_ADIMN_SETTINGS['alsp_payments_symbol_code'] . '<input type="text" size="4" name="level_price_' . $level1->id . '_' . $level2->id . '" value="' . esc_attr($price) . '" /><br />';
	}
	
	public function pay_invoice_step($step, $level = null) {
		if ($level && recalcPrice($level->price)) {
			echo '<div class="alsp-adv-line"></div>';
			echo '<div class="alsp-adv-step">';
			echo '<div class="alsp-adv-circle">' . __('Step', 'ALSP') . $step++ . '</div>';
			echo __('Pay Invoice', 'ALSP');
			echo '</div>';
		}
		return $step++;
	}
	
	public function create_price($link_text, $listing) {
		return  $link_text .' - ' . formatPrice(recalcPrice($listing->level->price));
	}

	public function raiseup_price($link_text, $listing) {
		return  $link_text .' - ' . formatPrice(recalcPrice($listing->level->raiseup_price));
	}

	public function renew_price($link_text, $listing) {
		return  $link_text .' - ' . formatPrice(recalcPrice($listing->level->price));
	}

	public function upgrade_price($link_text, $old_level, $new_level) {
		return  $link_text .' - ' . (isset($old_level->upgrade_meta[$new_level->id]) ? formatPrice(recalcPrice($old_level->upgrade_meta[$new_level->id]['price'])) : formatPrice(0));
	}

	public function print_invoice_template($template) {
		global $alsp_instance;

		if (is_page($alsp_instance->index_page_id) && $alsp_instance->action == 'alsp_print_invoice' && isset($_GET['invoice_id']) && is_numeric($_GET['invoice_id'])) {
			if (alsp_current_user_can_edit_listing($_GET['invoice_id'])) {
				if (!($template = alsp_isFrontPart('invoice_print.tpl.php')) && !($template = alsp_isFrontPart('invoice_print-custom.tpl.php'))) {
					$template = ALSP_PAYMENTS_TEMPLATES_PATH . 'invoice_print.tpl.php';
				}
			} else
				wp_die('You are not able to access this page!');
		}
		return $template;
	}

	public function invoice_actions() {
		global $ALSP_ADIMN_SETTINGS;
		if (isset($_GET['post']) && is_numeric($_GET['post']) && alsp_current_user_can_edit_listing($_GET['post'])) {
			$invoice_id = $_GET['post'];
			if (($post = get_post($invoice_id)) && $post->post_type == ALSP_INVOICE_TYPE && ($invoice = getInvoiceByID($invoice_id))) {
				$redirect = false;
				if (isset($_GET['alsp_gateway']) && !$invoice->gateway) {
					switch ($_GET['alsp_gateway']) {
						case 'paypal':
							if ($ALSP_ADIMN_SETTINGS['alsp_paypal_email'] && $ALSP_ADIMN_SETTINGS['alsp_paypal_single'])
								$gateway = $_GET['alsp_gateway'];
							break;
						case 'paypal_subscription':
							if ($ALSP_ADIMN_SETTINGS['alsp_paypal_email'] && $ALSP_ADIMN_SETTINGS['alsp_paypal_subscriptions'] && $invoice->is_subscription)
								$gateway = $_GET['alsp_gateway'];
							break;
						case 'stripe':
							if (($ALSP_ADIMN_SETTINGS['alsp_stripe_test'] && $ALSP_ADIMN_SETTINGS['alsp_stripe_test_secret'] && $ALSP_ADIMN_SETTINGS['alsp_stripe_test_public']) || ($ALSP_ADIMN_SETTINGS['alsp_stripe_live_secret'] && $ALSP_ADIMN_SETTINGS['alsp_stripe_live_public']))
								$gateway = $_GET['alsp_gateway'];
							break;
						case 'bank_transfer':
							if ($ALSP_ADIMN_SETTINGS['alsp_allow_bank'])
								$gateway = $_GET['alsp_gateway'];
							break;
					}
					if (isset($gateway)) {
						$invoice->setStatus('pending');
						$invoice->setGateway($gateway);

						$gateway = $invoice->getGatewayObject();
						$invoice->logMessage(sprintf(__('Payment gateway was selected: %s', 'ALSP'), $gateway->name()));
						alsp_addMessage(__('Payment gateway was selected!', 'ALSP'));
						$gateway->submitPayment($invoice);
						$redirect = true;
					}
				}
	
				if (isset($_GET['invoice_action']) && $_GET['invoice_action'] == 'reset_gateway' && $invoice->gateway) {
					$invoice->setStatus('unpaid');
					$invoice->setGateway('');
					$invoice->logMessage(__('Payment gateway was reset', 'ALSP'));
					alsp_addMessage(__('Payment gateway was reset!', 'ALSP'));
					$redirect = true;
				}
				
				if (isset($_GET['invoice_action']) && $_GET['invoice_action'] == 'set_paid' && $invoice->status != 'paid' && current_user_can('edit_others_posts')) {
					if ($invoice->item_object->complete()) {
						$invoice->setStatus('paid');
						$invoice->logMessage(__('Invoice was manually set as paid', 'ALSP'));
						alsp_addMessage(__('Invoice was manually set as paid!', 'ALSP'));
					} else 
						alsp_addMessage(__('An error has occured!', 'ALSP'), 'error');
					$redirect = true;
				}

				if ($redirect) {
					wp_redirect(alsp_get_edit_invoice_link($invoice_id, 'redirect'));
					die();
				}
			}
		}
	}
	
	public function alsp_payments_query_vars($vars) {
		$vars[] = 'ipn_token';
		$vars[] = 'gateway';

		return $vars;
	}
	
	public function prevent_users_see_other_invoices($wp_query) {
		global $current_user;
		if (is_admin() && !current_user_can('edit_others_posts') && isset($wp_query->query_vars['post_type']) && $wp_query->query_vars['post_type'] == ALSP_INVOICE_TYPE) {
			$wp_query->set('author', $current_user->ID);
			add_filter('views_edit-'.ALSP_INVOICE_TYPE, array($this, 'remove_invoices_counts'));
		}
	}
	public function remove_invoices_counts($views) {
		return array();
	}

	public function remove_bulk_actions($actions) {
		return array();
	}
	
	public function process_invoices_query($frontend_controller) {
		global $alsp_instance;

		if ($alsp_instance->action == 'invoices') {
			if (get_query_var('page'))
				$paged = get_query_var('page');
			elseif (get_query_var('paged'))
				$paged = get_query_var('paged');
			else
				$paged = 1;
		} else
			$paged = -1;

		$args = array(
				'post_type' => ALSP_INVOICE_TYPE,
				'author' => get_current_user_id(),
				'paged' => $paged,
				'posts_per_page' => 10,
		);
		$frontend_controller->invoices_query = new WP_Query($args);
		wp_reset_postdata();
	}
	
	public function add_invoices_dashboard_link($frontend_controller) {
		global $alsp_instance;
		$this->process_invoices_query($frontend_controller);

		echo '<li ' . (($frontend_controller->active_tab == 'invoices') ? 'class="active"' : '') . '><a href="' . alsp_dashboardUrl(array('alsp_action' => 'invoices')) . '">' . __('Invoices', 'ALSP'). ' (' . $frontend_controller->invoices_query->found_posts . ')</a></li>';
	}
	//public function add_invoices_dashboard_link2($frontend_controller) {
	//	global $alsp_instance;
	//	$this->process_invoices_query($frontend_controller);

	//	echo '<a href="' . alsp_dashboardUrl(array('alsp_action' => 'invoices')) . '">' . __('Invoices', 'ALSP'). ' (' . $frontend_controller->invoices_query->found_posts . ')</a>';
	//}
	public function handle_dashboard_controller($frontend_controller) {
		global $alsp_instance;

		if (get_class($frontend_controller) == 'alsp_dashboard_controller') {
			if (!is_user_logged_in())
				$this->template = ALSP_FSUBMIT_TEMPLATES_PATH . 'login_form.tpl.php';
			else {
				if ($alsp_instance->action == 'invoices') {
					$this->process_invoices_query($frontend_controller);
		
					$frontend_controller->invoices = array();
					while ($frontend_controller->invoices_query->have_posts()) {
						$frontend_controller->invoices_query->the_post();
						
						$invoice = getInvoiceByID(get_the_ID());
						$frontend_controller->invoices[get_the_ID()] = $invoice;
					}
					// this is reset is really required after the loop ends
					wp_reset_postdata();
					
					$frontend_controller->template = ALSP_FSUBMIT_TEMPLATES_PATH . 'dashboard.tpl.php';
					$frontend_controller->subtemplate = ALSP_PAYMENTS_TEMPLATES_PATH . 'invoices_dashboard.tpl.php';
					$frontend_controller->active_tab = 'invoices';
				} elseif ($alsp_instance->action == 'view_invoice' && isset($_GET['post']) && is_numeric($_GET['post']) && alsp_current_user_can_edit_listing($_GET['post'])) {
					if ($frontend_controller->invoice = getInvoiceByID($_GET['post'])) {
						$frontend_controller->paypal = new alsp_paypal();
						$frontend_controller->paypal_subscription = new alsp_paypal_subscription();
						$frontend_controller->bank_transfer = new alsp_bank_transfer();
						$frontend_controller->stripe = new alsp_stripe();
		
						$frontend_controller->template = ALSP_FSUBMIT_TEMPLATES_PATH . 'dashboard.tpl.php';
						$frontend_controller->subtemplate = ALSP_PAYMENTS_TEMPLATES_PATH . 'view_invoice_dashboard.tpl.php';
						$frontend_controller->active_tab = 'invoices';
					}
				}
			}
		}

		return $frontend_controller;
	}
	
	public function edit_invoices_links($url, $post_id) {
		global $alsp_instance;

		if (!is_admin() && $alsp_instance->dashboard_page_url && ($post = get_post($post_id)) && $post->post_type == ALSP_INVOICE_TYPE)
			return alsp_dashboardUrl(array('alsp_action' => 'view_invoice', 'post' => $post_id));
		
		return $url;
	}

	public function enqueue_scripts_styles($load_scripts_styles = false) {
		global $alsp_instance, $alsp_payments_enqueued;
		if ((is_admin() || $alsp_instance->frontend_controllers || $load_scripts_styles) && !$alsp_payments_enqueued) {
			if (!(function_exists('is_rtl') && is_rtl()))
				wp_register_style('alsp_payments', ALSP_PAYMENTS_RESOURCES_URL . 'css/payments.css');
			else 
				wp_register_style('alsp_payments', ALSP_PAYMENTS_RESOURCES_URL . 'css/payments-rtl.css');
	
			wp_enqueue_style('alsp_payments');
			if (is_file(ALSP_PAYMENTS_RESOURCES_URL . 'css/payments-custom.css'))
				wp_register_style('alsp_payments-custom', ALSP_PAYMENTS_RESOURCES_URL . 'css/payments-custom.css');
	
			wp_enqueue_style('alsp_payments-custom');

			$alsp_payments_enqueued = true;
		}
	}


	function apply_payment_link($invoice) {
		global $alsp_instance;

		if ($listing = $invoice->item_object->getItem() ) {
			switch ($invoice->item_object->name) {
				case 'listing':
					$level_id = $listing->level->id;
					$action = __("activate", "ALSP");
					break;
				case 'listing_raiseup':
					$level_id = $listing->level->id;
					$action = __("raise up", "ALSP");
					break;
				case 'listing_upgrade':
					$level_id = get_post_meta($listing->post->ID, '_new_level_id', true);
					$action = __("upgrade", "ALSP");
					break;
			}
			
			if ($invoice->status != 'paid') {
				if ($alsp_instance->listings_packages->can_user_create_listing_in_level($level_id)) {
					echo "<br />";
					echo $alsp_instance->listings_packages->available_listings_descr($level_id, $action);
					echo ". ";
					echo __('You can', 'ALSP') . ' <a href="' . wp_nonce_url(add_query_arg('apply_listing_payment', $listing->post->ID), 'alsp_invoice_apply', '_nonce') . '">' . __('apply payment', 'ALSP') . '</a>.';
				}
			}
		}
	}
	
	function apply_payment() {
		global $alsp_instance;
	
		if (isset($_GET['apply_listing_payment']) && is_numeric($_GET['apply_listing_payment']) && isset($_GET['post']) && is_numeric($_GET['post'])) {
			if (isset($_GET['_nonce']) && wp_verify_nonce($_GET['_nonce'], 'alsp_invoice_apply')) {
				if ($invoice = getInvoiceByID($_GET['post'])) {
					$listing = $invoice->item_object->getItem();
					switch ($invoice->item_object->name) {
						case 'listing':
							$level_id = $listing->level->id;
							break;
						case 'listing_raiseup':
							$level_id = $listing->level->id;
							break;
						case 'listing_upgrade':
							$level_id = get_post_meta($listing->post->ID, '_new_level_id', true);
							break;
					}
					
					if ($alsp_instance->listings_packages->can_user_create_listing_in_level($level_id)) {
						if ($invoice->item_object->complete()) {
							$invoice->setStatus('paid');
							$invoice->logMessage(__('Payment applied from user listings package.', 'ALSP'));
	
							$alsp_instance->listings_packages->process_listing_creation_for_user($listing->level->id);
							
							wp_redirect(remove_query_arg('apply_listing_payment'));
							die();
						}
					}
				}
			}
		}
	}
}

function recalcPrice($price) {
	global $ALSP_ADIMN_SETTINGS;
	// if any services are free for admins - show 0 price
	if ($ALSP_ADIMN_SETTINGS['alsp_payments_free_for_admins'] && current_user_can('manage_options')) {
		return 0;
	} else
		return $price;
}

function formatPrice($value = 0) {
	global $ALSP_ADIMN_SETTINGS;
	if ($value == 0) {
		$out = '<span class="alsp-payments-free">' . __('0', 'ALSP') . '</span>';
	} else {
		$decimal_separator = $ALSP_ADIMN_SETTINGS['alsp_payments_decimal_separator'];

		$thousands_separator = $ALSP_ADIMN_SETTINGS['alsp_payments_thousands_separator'];
		if ($thousands_separator == 'space')
			$thousands_separator = ' ';

		$value = number_format($value, 2, $decimal_separator, $thousands_separator); 

		$out = '$ '.$value;
		switch ($ALSP_ADIMN_SETTINGS['alsp_payments_symbol_position']) {
			case 1:
				$out = $ALSP_ADIMN_SETTINGS['alsp_payments_symbol_code'] . $value;
				break;
			case 2:
				$out = $ALSP_ADIMN_SETTINGS['alsp_payments_symbol_code'] . ' ' . $value;
				break;
			case 3:
				$out = $value . $ALSP_ADIMN_SETTINGS['alsp_payments_symbol_code'];
				break;
			case 4:
				$out = $value . ' ' . $ALSP_ADIMN_SETTINGS['alsp_payments_symbol_code'];
				break;
		}
	}
	return $out;
}



function alsp_install_payments() {
	global $wpdb;

	// there may be possible bug in WP, on some servers it doesn't allow to execute more than one SQL query in one request
	$wpdb->query("ALTER TABLE {$wpdb->alsp_levels} ADD `price` FLOAT( 2 ) NOT NULL DEFAULT '0' AFTER `order_num`");
	if (array_search('price', $wpdb->get_col("DESC {$wpdb->alsp_levels}"))) {
		$wpdb->query("ALTER TABLE {$wpdb->alsp_levels} ADD `raiseup_price` FLOAT( 2 ) NOT NULL DEFAULT '0' AFTER `price`");
		if (array_search('raiseup_price', $wpdb->get_col("DESC {$wpdb->alsp_levels}"))) {
			add_option('alsp_payments_free_for_admins', 0);
			add_option('alsp_payments_currency', 'USD');
			add_option('alsp_payments_symbol_code', '$');
			add_option('alsp_payments_symbol_position', 1);
			add_option('alsp_payments_decimal_separator', ',');
			add_option('alsp_payments_thousands_separator', 'space');
			add_option('alsp_allow_bank', 1);
			add_option('alsp_bank_info', '');
			add_option('alsp_paypal_email', '');
			add_option('alsp_paypal_subscriptions', 1);
			add_option('alsp_paypal_test', 0);
			
			alsp_upgrade_payments('1.6.0');
			alsp_upgrade_payments('1.8.0');
			alsp_upgrade_payments('1.9.0');
			alsp_upgrade_payments('1.9.4');
			
			add_option('alsp_installed_payments', 1);
		}
	}
}

function alsp_upgrade_payments($new_version) {
	if ($new_version == '1.6.0') {
		add_option('alsp_stripe_test_secret', '');
		add_option('alsp_stripe_test_public', '');
		add_option('alsp_stripe_live_secret', '');
		add_option('alsp_stripe_live_public', '');
		add_option('alsp_stripe_test', 1);
	}

	if ($new_version == '1.8.0') {
		add_option('alsp_paypal_single', 1);
	}

	if ($new_version == '1.9.0') {
		add_option('alsp_enable_taxes', 0);
		add_option('alsp_taxes_info', '');
		add_option('alsp_tax_name', '');
		add_option('alsp_tax_rate', 0);
		add_option('alsp_taxes_mode', 'include');
	}
	
	if ($new_version == '1.9.4') {
		add_option('alsp_hide_decimals', 0);
	}
	
}

function alsp_get_edit_invoice_link($invoice_id, $context = 'display') {
	if (alsp_current_user_can_edit_listing($invoice_id)) {
		return apply_filters('alsp_get_edit_invoice_link', get_edit_post_link($invoice_id, $context), $invoice_id);
	}
}

global $alsp_payments_instance;

$alsp_payments_instance = new alsp_payments_plugin();
$alsp_payments_instance->init();

?>
