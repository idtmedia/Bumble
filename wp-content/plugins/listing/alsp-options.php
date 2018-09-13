<?php

    /**
     * ReduxFramework Barebones Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "alsp_admin_settings";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $plugin_theme = 'Listing'; // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $plugin_theme,
        // Name that appears at the top of your panel
        'display_version'      => ALSP_VERSION,
        // Version that appears at the top of your panel
        'menu_type'            => 'submenu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Listing Settings', 'redux-framework-demo' ),
        'page_title'           => __( 'Listing Settings', 'redux-framework-demo' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'classiads_settings',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => 'listing_admin_options',
        // Page slug used to denote the panel
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!

        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        //'compiler'             => true,

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'light',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click',
                ),
            ),
        )
    );

    // Panel Intro text -> before the form
   /* if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        $args['intro_text'] = sprintf( __( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'redux-framework-demo' ), $v );
    } else {
        $args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo' );
    }*/

    // Add content after the form.
   // $args['footer_text'] = __( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework-demo' );

    Redux::setArgs( $opt_name, $args );
	
	if(!function_exists('removeDemoModeLink2')){
		function removeDemoModeLink2() { // Be sure to rename this function to something more unique
			if ( class_exists('ReduxFrameworkPlugin') ) {
				remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
			}
			if ( class_exists('ReduxFrameworkPlugin') ) {
				remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
			}
		}
	}
add_action('init', 'removeDemoModeLink2');

/** remove redux menu under the tools **/
add_action( 'admin_menu', 'remove_redux_menu2',12 );
if(!function_exists('remove_redux_menu2')){
	
	function remove_redux_menu2() {
		remove_submenu_page('tools.php','redux-about');
	}
}


    /*
     * ---> END ARGUMENTS
     */

    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'Theme Information 1', 'ALSP' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'ALSP' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => __( 'Theme Information 2', 'ALSP' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'ALSP' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'ALSP' );
   // Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    // -> START Basic Fields
	global $alsp_instance, $alsp_social_services, $alsp_maps_styles, $sitepress;
	$ordering_items = alsp_orderingItems();
	
	$listings_tabs = array(
		array('value' => 'addresses-tab', 'label' => __('Addresses tab', 'ALSP')),
		array('value' => 'comments-tab', 'label' => __('Comments tab', 'ALSP')),
		array('value' => 'videos-tab', 'label' => __('Videos tab', 'ALSP'))
	);

	foreach ($alsp_instance->content_fields->content_fields_groups_array AS $fields_group){
		if ($fields_group->on_tab){
			$listings_tabs[] = array('value' => 'field-group-tab-'.$fields_group->id, 'label' => $fields_group->name);
		}
	}
	$new_listing_tabs = array();
	foreach($listings_tabs as $listItem) {
		$new_listing_tabs[$listItem['value']] = $listItem['label'];
	}


	$map_styles = array(array('value' => 'default', 'label' => 'Default style'));
		foreach ($alsp_maps_styles AS $name=>$style){
			$map_styles[] = array('value' => $name, 'label' => $name);
		}	
			
	$new_map_styles = array();
	foreach($map_styles as $listItem) {
		$new_map_styles[$listItem['value']] = $listItem['label'];
	}
	
	$pages = get_pages();
		$all_pages[] = '0' .'=>'. __('- Select page -', 'ALSP');
		foreach ($pages AS $page)
			$all_pages[] = $page->ID .'=>'. $page->post_title;
			
			//print_r($map_styles);
	// adapted for WPML
			global $sitepress;
			if (function_exists('wpml_object_id_filter') && $sitepress) {
				 $wpml_option = array(
					'type' => 'switch',
					'id' => 'alsp_enable_frontend_translations',
					'title' => __('Enable frontend translations management', 'ALSP'),
					'default' => get_option('alsp_enable_frontend_translations'),
				);
			}else{
				$wpml_option = '';
			}
			
	$country_codes = array();
	$alsp_country_codes = alsp_country_codes();
	foreach ($alsp_country_codes AS $country=>$code){
		$country_codes[] = array('value' => $code, 'label' => $country);
	}	
	$new_country_codes = array();
	foreach($country_codes as $newcode) {
		$new_country_codes[$newcode['value']] = $newcode['label'];
	}
	
	$alsp_social_services = array(
		'facebook' => 'Facebook',
		'twitter' => 'Twitter',
		'google' => 'Google+',
		'linkedin' => 'LinkedIn',
		'digg' => 'Digg',
		'reddit' => 'Reddit',
		'pinterest' => 'Pinterest',
		'tumblr' => 'Tumblr',
		'stumbleupon' => 'StumbleUpon',
		'email' => 'Email'
	);
		//$map_stylesfinal = array_merge($map_styles,$map_styles2);

    Redux::setSection( $opt_name, array(
        'title' => __( 'Listing Settings', 'ALSP' ),
        'id'    => 'listing_addon_main_section',
        'desc'  => '',
        'icon'  => 'pacz-icon-home'
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Rating Settings', 'ALSP' ),
        'desc'       => '',
        'id'         => 'rating_addon_section',
		'subsection'       => true,
        'fields' => array(
			array(
				'type' => 'switch',
				'id' => 'alsp_ratings_addon',
				'title' => __('Ratings addon', 'ALSP'),
				'desc' => __('Ability to place ratings for listings, then manage these ratings by listings owners, also ability to rate comments/reviews.', 'ALSP'),
				"default" => false,
			),
			array(
				'type' => 'select',
				'id' => 'alsp_ratting_type',
				'title' => __('Rating addon type', 'ALSP'),
				'desc' => __('Since classiads v5.4 a new rating system has been introduced with review option. please select which one you want to use from old or new ratting system', 'ALSP'),
				"options" => array(
					'old' => esc_html__('Old rating system', 'ALSP'),
					'new' => esc_html__('New rating system', 'ALSP'),
				),
				'default' => 'old'
			),
		)
	));
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Ajax Settings', 'ALSP' ),
        'desc'       => '',
        'id'         => 'listing_ajax_section',
		'subsection'       => true,
        'fields' => array(
			array(
				'type' => 'switch',
				'id' => 'alsp_ajax_load',
				'title' => __('Use AJAX loading', 'ALSP'),
				'disc' => __('Load maps and listings using AJAX when click on search button, sorting buttons, pagination buttons.', 'ALSP'),
				"default" => false,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_ajax_initial_load',
				'title' => __('Initial AJAX loading', 'ALSP'),
				'desc' => __('Initially load listings only after the page was completely loaded (not recommended).', 'ALSP'),
				"default" => false,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_show_more_button',
				'desc' => __('Display "Show More Listings" button instead of default paginator', 'ALSP'),
				"default" => true,
			),
		),
	) );
	Redux::setSection( $opt_name, array(
		'id' => 'title_slugs',
		'title' => __('Titles, Slugs & Permalinks', 'ALSP'),
		'subsection'       => true,
		'fields' => array(
			array(
				'type' => 'text',
				'id' => alsp_get_wpml_dependent_option_name('alsp_directory_title'), // adapted for WPML
				'title' => __('Listing title', 'ALSP'),
				'desc' =>  alsp_get_wpml_dependent_option_description(),
				'default' => 'Listings',  // adapted for WPML
			),
			array(
				'type' => 'text',
				'id' => 'alsp_listing_slug',
				'title' => __('Listing slug', 'ALSP'),
				'default' => 'listings',
			),
			array(
				'type' => 'text',
				'id' => 'alsp_category_slug',
				'title' => __('Category slug', 'ALSP'),
				'default' => 'listings-category',
			),
			array(
				'type' => 'text',
				'id' => 'alsp_location_slug',
				'title' => __('Location slug', 'ALSP'),
				'default' => 'listings-place',
			),
			array(
				'type' => 'text',
				'id' => 'alsp_tag_slug',
				'title' => __('Tag slug', 'ALSP'),
				'default' => 'listings-tag',
			),
			array(
				'type' => 'radio',
				'id' => 'alsp_permalinks_structure',
				'title' => __('Listings permalinks structure', 'ALSP'),
				'desc' => __('<b>/%postname%/</b> works only when directory page is not front page.<br /><b>/%post_id%/%postname%/</b> will not work when the same structure was enabled for native WP posts.', 'ALSP'),
				'default' => 'postname',
				'options' => array(
					'postname' => __('/%postname%/', 'ALSP'),	
					'post_id' => __('/%post_id%/%postname%/', 'ALSP'),	
					'listing_slug' => __('/%listing_slug%/%postname%/', 'ALSP'),	
					'category_slug' => __('/%listing_slug%/%category%/%postname%/', 'ALSP'),	
					'location_slug' => __('/%listing_slug%/%location%/%postname%/', 'ALSP'),	
					'tag_slug' => __('/%listing_slug%/%tag%/%postname%/', 'ALSP'),	
				),
			),
		),
	) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Payment Settings', 'ALSP' ),
        'desc'       => '',
        'id'         => 'listing_addon_section',
        'fields' => array(
			array(
				'type' => 'select',
				'id' => 'alsp_payments_addon',
				'title' => __('Payments addon', 'ALSP'),
				'desc' => __('Includes payments processing and invoices management functionality into directory/classifieds website.', 'ALSP'),
				"options" => array(
					'alsp_buitin_payment' => esc_html__('Builin Payment System', 'ALSP'),
					'alsp_woo_payment' => esc_html__('Woocomerce  Payment System', 'ALSP'),
					'alsp_no_payment' => esc_html__('Disabled', 'ALSP'),
				),
				'default' => 'alsp_buitin_payment'
			),
				array(
					'type' => 'switch',
					'id' => 'alsp_woocommerce_frontend_links',
					'title' => __('Show WooCommerce Menus in front-end user panel', 'ALSP'),
					'default' => true,
					'required' => array('alsp_payments_addon', 'equals', 'alsp_woo_payment'),
				),
				array(
					'type' => 'radio',
					'id' => 'alsp_woocommerce_mode',
					'title' => __('Products to sell', 'ALSP'),
					'required' => array('alsp_payments_addon', 'equals', 'alsp_woo_payment'),
					'options' => array(
						'single' =>__('only single listings', 'ALSP'),
						'packages' =>__('only packages of listings', 'ALSP'),
						'both' =>__('both products, packages and single listings', 'ALSP'),
					),
					'default' => 'both',
					
				),
						array(
							'type' => 'select',
							'id' => 'alsp_payments_currency',
							'title' => __('Currency', 'ALSP'),
							'options' => array(
								'USD' => __('US Dollars ($)', 'ALSP'),
								'EUR' => __('Euros (€)', 'ALSP'),
								'GBP' => __('Pounds Sterling (£)', 'ALSP'),
								'AUD' => __('Australian Dollars ($)', 'ALSP'),
								'BRL' => __('Brazilian Real (R$)', 'ALSP'),
								'CAD' => __('Canadian Dollars ($)', 'ALSP'),
								'CZK' => __('Czech Koruna (Kč)', 'ALSP'),
								'DKK' => __('Danish Krone (kr)', 'ALSP'),
								'HKD' => __('Hong Kong Dollar ($)', 'ALSP'),
								'HUF' => __('Hungarian Forint (Ft)', 'ALSP'),
								'ILS' => __('Israeli Shekel (₪)', 'ALSP'),
								'JPY' => __('Japanese Yen (¥)', 'ALSP'),
								'MYR' => __('Malaysian Ringgits (RM)', 'ALSP'),
								'MXN' => __('Mexican Peso ($)', 'ALSP'),
								'NZD' => __('New Zealand Dollar ($)', 'ALSP'),
								'NOK' => __('Norwegian Krone (kr)', 'ALSP'),
								'PHP' => __('Philippine Pesos (P)', 'ALSP'),
								'PLN' => __('Polish Zloty (zł)', 'ALSP'),
								'SGD' => __('Singapore Dollar ($)', 'ALSP'),
								'SEK' => __('Swedish Krona (kr)', 'ALSP'),
								'CHF' => __('Swiss Franc (Fr)', 'ALSP'),
								'TWD' => __('Taiwan New Dollar ($)', 'ALSP'),
								'THB' => __('Thai Baht (฿)', 'ALSP'),
								'TRY', 'label' => __('Turkish Lira (₤)', 'ALSP'),
							),
							'default' => 'USD',
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment')
						),
						array(
							'type' => 'text',
							'id' => 'alsp_payments_symbol_code',
							'title' => __('Currency symbol or code', 'ALSP'),
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'default' => '',
						),
						array(
							'type' => 'radio',
							'id' => 'alsp_payments_symbol_position',
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'title' => __('Currency symbol or code position', 'ALSP'),
							'options' => array(
								'1' => __('$1.00', 'ALSP'),
								'2' => __('$ 1.00', 'ALSP'),
								'3' => __('1.00$', 'ALSP'),
								'4' => __('1.00 $', 'ALSP'),
							),
							'default' => '1',
						),
						array(
							'type' => 'radio',
							'id' => 'alsp_payments_decimal_separator',
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'title' => __('Decimal separator', 'ALSP'),
							'options' => array(
								'.' => __('dot', 'ALSP'),
								',' => __('comma', 'ALSP'),
							),
							'default' => '.',
						),
						array(
							'type' => 'switch',
							'id' => 'alsp_hide_decimals',
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'title' => __('Hide decimals in levels price table', 'ALSP'),
							'default' => false,
						),
						array(
							'type' => 'radio',
							'id' => 'alsp_payments_thousands_separator',
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'title' => __('Thousands separator', 'ALSP'),
							'options' => array(
								'' => __('no separator', 'ALSP'),
								'.' => __('dot', 'ALSP'),
								',' => __('comma', 'ALSP'),
								'space' => __('space', 'ALSP'),
							),
							'default' => ',',
						),
				array(
							'type' => 'switch',
							'id' => 'alsp_enable_taxes',
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'title' => __('Enable taxes', 'ALSP'),
							'default' => false,
						),
						array(
							'type' => 'textarea',
							'id' => 'alsp_taxes_info',
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'title' => __('Selling company information', 'ALSP'),
							'default' => '',
						),
						array(
							'type' => 'text',
							'id' => 'alsp_tax_name',
							'title' => __('Tax name', 'ALSP'),
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'desc' => __('abbreviation, e.g. "VAT"', 'ALSP'),
							'default' => '',
						),
						array(
							'type' => 'text',
							'id' => 'alsp_tax_rate',
							'title' => __('Tax rate', 'ALSP'),
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'desc' => __('In percents', 'ALSP'),
							'default' => '',
						),
						array(
							'type' => 'radio',
							'id' => 'alsp_taxes_mode',
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'title' => __('Include or exclude value added taxes', 'ALSP'),
							'desc' => __('Do you want prices on the website to be quoted including or excluding value added taxes?', 'ALSP'),
							'options' => array(
								'include' => __('Include', 'ALSP'),
								'exclude' => __('Exclude', 'ALSP'),
							),
							'default' => 'exclude',
						),
				array(
							'type' => 'switch',
							'id' => 'alsp_allow_bank',
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'title' => __('Allow bank transfer', 'ALSP'),
							'default' => false,
						),
						array(
							'type' => 'textarea',
							'id' => 'alsp_bank_info',
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'title' => __('Bank transfer information', 'ALSP'),
							'default' => '',
						),
				array(
							'type' => 'text',
							'id' => 'alsp_paypal_email',
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'title' => __('PayPal Business email', 'ALSP'),
							'default' => '',
						),
						array(
							'type' => 'switch',
							'id' => 'alsp_paypal_single',
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'title' => __('Allow single payment By PayPal', 'ALSP'),
							'default' => false,
						),
						array(
							'type' => 'switch',
							'id' => 'alsp_paypal_subscriptions',
							'title' => __('Allow subscriptions By PayPal', 'ALSP'),
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'desc' => __('Only for listings with limited active period', 'ALSP'),
							'default' => false,
						),
						array(
							'type' => 'switch',
							'id' => 'alsp_paypal_test',
							'title' => __('PayPal Sandbox mode', 'ALSP'),
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'desc' => sprintf(__('You must have a <a href="%s" target="_blank">PayPal Sandbox</a> account setup before using this feature. <a href="%s">IPN URL</a>', 'ALSP'), 'http://developer.paypal.com/', site_url('ipn_token/'.ipn_token().'/gateway/paypal')),
							'default' => false,
						),
				
				
				array(
							'type' => 'text',
							'id' => 'alsp_stripe_test_secret',
							'title' => __('Stripe Test secret key', 'ALSP'),
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'default' => '',
						),
						array(
							'type' => 'text',
							'id' => 'alsp_stripe_test_public',
							'title' => __('Stripe Test publishable key', 'ALSP'),
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'default' => '',
						),
						array(
							'type' => 'text',
							'id' => 'alsp_stripe_live_secret',
							'title' => __('Stripe Live secret key', 'ALSP'),
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'default' => '',
						),
						array(
							'type' => 'text',
							'id' => 'alsp_stripe_live_public',
							'title' => __('Stripe Live publishable key', 'ALSP'),
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'default' => '',
						),
						array(
							'type' => 'switch',
							'id' => 'alsp_stripe_test',
							'title' => __('Stripe Sandbox mode', 'ALSP'),
							'required' => array('alsp_payments_addon', 'equals', 'alsp_buitin_payment'),
							'desc' => __('You can only use <a href="http://stripe.com/" target="_blank">Stripe</a> in test mode until you activate your account.', 'ALSP'),
							'default' => false,
						),
						array(
							'type' => 'switch',
							'id' => 'alsp_payments_free_for_admins',
							'title' => __('Any services are Free for administrators', 'ALSP'),
							'default' => false,
							
						),
			
			$wpml_option
		)
	) );
	Redux::setSection( $opt_name, array(
        'title' => __( 'Front-end Submission', 'ALSP' ),
        'desc'  => '',
        'id' => 'front_end_submission_settings',
		'icon'  => 'pacz-icon-dashboard',
        'fields' => array(
			array(
				'type' => 'switch',
				'id' => 'alsp_fsubmit_addon',
				'title' => __('Frontend submission & dashboard addon', 'ALSP'),
				'desc' => __('Allow users to submit new listings at the frontend side of your site, also provides users dashboard functionality.', 'ALSP'),
				"default" => false,
			),
			array(
				'type' => 'radio',
				'id' => 'alsp_fsubmit_login_mode',
				'title' => __('Frontend submission login mode', 'ALSP'),
				'options' => array(
					'1' => __('login required', 'ALSP'),
					'2' => __('necessary to fill in contact form', 'ALSP'),
					'3' => __('not necessary to fill in contact form', 'ALSP'),
					'4' => __('do not show contact form', 'ALSP'),
				),
				'default' => '1',
			
			),
			array(
				'type' => 'select',
				'id' => 'alsp_fsubmit_default_status',
				'title' => __('Post status after frontend submit', 'ALSP'),
				'options' => array(
					'1' => __('Pending Review', 'ALSP'),
					'2' => __('Draft', 'ALSP'),
					'3' => __('Published', 'ALSP'),
				),
				'default' => '1',
			),
			array(
				'type' => 'select',
				'id' => 'alsp_fsubmit_edit_status',
				'title' => __('Post status after listing was modified', 'ALSP'),
				'options' => array(

					'1' => __('Pending Review', 'ALSP'),
					'2' => __('Draft', 'ALSP'),
					'3' => __('Published', 'ALSP'),
				),
				'default' => '1',
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_fsubmit_button',
				'title' => __('Enable submit listing button', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'restrict_non_admin',
				'title' => __('Ristrict User To Access WordPress Back-end', 'ALSP'),
				'desc' => __('Restrict all user roles other than Admin to access WordPess Dahboard e.g subscriber, editor,contributor, customer etc', 'ALSP') .  alsp_get_wpml_dependent_option_description(),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_hide_admin_bar',
				'title' => __('Hide top admin bar at the frontend for regular users and do not allow them to see dashboard at all', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_allow_edit_profile',
				'title' => __('Allow users to manage own profile at the frontend dashboard', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_tags',
				'title' => __('Enable listings tags input at the frontend', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'select',
				'id' => alsp_get_wpml_dependent_option_name('alsp_tospage'), // adapted for WPML
				'title' => __('Require Terms of Services on submission page?', 'ALSP'),
				'desc' => __('If yes, create a WordPress page containing your TOS agreement and assign it using the dropdown above.', 'ALSP') .  alsp_get_wpml_dependent_option_description(),
				'data' => 'pages',
				'default' => '', // adapted for WPML
			),
			array(
				'type' => 'select',
				'id' => alsp_get_wpml_dependent_option_name('alsp_submit_login_page'), // adapted for WPML
				'title' => __('Use custom login page for listings submission process', 'ALSP'),
				'desc' => __('You may use any 3rd party plugin to make custom login page and assign it with submission process using the dropdown above.', 'ALSP') .  alsp_get_wpml_dependent_option_description(),
				'data' => 'pages',
				'default' => '', // adapted for WPML
			),
			array(
				'type' => 'select',
				'id' => alsp_get_wpml_dependent_option_name('alsp_dashboard_login_page'), // adapted for WPML
				'title' => __('Use custom login page for login into dashboard', 'ALSP'),
				'desc' => __('You may use any 3rd party plugin to make custom login page and assign it with login into dashboard using the dropdown above.', 'ALSP') .  alsp_get_wpml_dependent_option_description(),
				'data' => 'pages',
				'default' => '', // adapted for WPML
			),
			array(
					'type' => 'switch',
					'id' => 'alsp_claim_functionality',
					'title' => __('Enable claim functionality', 'ALSP'),
					'default' => false,
				),
				array(
					'type' => 'switch',
					'id' => 'alsp_claim_approval',
					'title' => __('Approval of claim required', 'ALSP'),
					'desc' => __('In other case claim will be processed immediately without any notifications', 'ALSP'),
					'default' => false,
				),
				array(
					'type' => 'radio',
					'id' => 'alsp_after_claim',
					'title' => __('What will be with listing status after successful approval?', 'ALSP'),
					'desc' => __('When set to expired - renewal may be payment option', 'ALSP'),
					'options' => array(
						'active' =>__('just approval', 'ALSP'),
						'expired' =>__('expired status', 'ALSP'),
					),
					'default' => 'active',
				),
				array(
					'type' => 'switch',
					'id' => 'alsp_hide_claim_contact_form',
					'title' => __('Hide contact form on claimable listings', 'ALSP'),
					'default' => false,
				),
				array(
					'type' => 'switch',
					'id' => 'alsp_hide_claim_metabox',
					'title' => __('Hide claim metabox at the frontend dashboard', 'ALSP'),
					'default' => false,
				),
		
		)
	));
	Redux::setSection( $opt_name, array(
        'title' => __( 'Front-end User Panel', 'ALSP' ),
        'desc'  => '',
        'id' => 'front_end_panel_settings',
		'icon'  => 'pacz-icon-dashboard',
        'fields' => array(
			array(
				'type' => 'media',
				'id' => 'user_panel_logo',
				'url' => false,
				'title' => __('Dashboard logo', 'ALSP'),
				'default' => '',
			),
			array(
				'type' => 'switch',
				'id' => 'frontend_panel_user_type',
				'title' => __('User Type option on Front-end Panel', 'ALSP'),
				"default" => true,
			),
			array(
				'type' => 'switch',
				'id' => 'frontend_panel_user_email',
				'title' => __('User Email option on Front-End', 'ALSP'),
				"default" => true,
			),
			array(
				'type' => 'switch',
				'id' => 'frontend_panel_user_phone',
				'title' => __('User Phone option on Front-End', 'ALSP'),
				"default" => true,
			),
			array(
				'type' => 'switch',
				'id' => 'frontend_panel_user_address',
				'title' => __('User Address option on Front-End', 'ALSP'),
				"default" => true,
			),
			array(
				'type' => 'switch',
				'id' => 'frontend_panel_user_website',
				'title' => __('User Website option on Front-End', 'ALSP'),
				"default" => true,
			),
			array(
				'type' => 'switch',
				'id' => 'frontend_panel_social_links',
				'title' => __('Social media Links in user panel and front-end', 'ALSP'),
				'desc' => __('by turning it off social media links will be removed from author page and widgets', 'ALSP'),
				"default" => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_favourites_list',
				'title' => __('Enable bookmarks list', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'author_profile_view',
				'title' => __('Author profile view link in sidebar widget', 'ALSP'),
				'desc' => __('', 'ALSP'),
				"default" => true,
			),
		)
	) );
	Redux::setSection( $opt_name, array(
        'title' => __( 'User Panel Skin', 'ALSP' ),
        'desc'  => '',
        'id' => 'front_end_panel_skin',
		'icon'  => 'pacz-icon-dashboard',
        'fields' => array(
			array(
				'id' => 'panel_link_color',
				'type' => 'nav_color',
				'title' => esc_html__('User Panel Menu Color', 'ALSP'),
				'regular' => true,
				'hover' => true,
				'bg' => true,
				'bg-hover' => true,
				'default' => array(
					'regular' => '#ffffff',
					'hover' => '#fff',
					'bg' => '#3d51b2',
					'bg-hover' => '#77c04b',
				)
			),
			array(
				'id' => 'panel_sub_link_color',
				'type' => 'nav_color',
				'title' => esc_html__('User Panel Sub Menu Color', 'ALSP'),
				'regular' => true,
				'hover' => true,
				'bg' => true,
				'bg-hover' => true,
				'default' => array(
					'regular' => '#ffffff',
					'hover' => '#fff',
					'bg' => '#3d51b2',
					'bg-hover' => '#77c04b',
				)
			),
			array(
				'id' => 'panel_link_border',
				'type' => 'color_rgba',
				'title' => esc_html__('User Panel Menu Border Bottom Color', 'ALSP'),
				'default' => '#333333',
				//'validate' => 'color',
			),
			array(
				'id' => 'panel_logo_bg_color',
				'type' => 'color',
				'title' => esc_html__('Panel Logo Background', 'ALSP'),
				'default' => '#333333',
				'validate' => 'color',
			),
			array(
				'id' => 'panel_bg_color',
				'type' => 'color',
				'title' => esc_html__('Panel Background', 'ALSP'),
				'default' => '#333333',
				'validate' => 'color',
			),
			array(
				'id' => 'panel_header_bg_color',
				'type' => 'color',
				'title' => esc_html__('Panel header Background', 'ALSP'),
				'default' => '#333333',
				'validate' => 'color',
			),
			array(
				'id' => 'panel_header_link_color',
				'type' => 'link_color',
				'title' => esc_html__('Panel header Link Color', 'ALSP'),
				'regular' => true,
				'hover' => true,
				'default' => array(
					'regular' => '#999999',
					'hover' => '#c32026',
				)
			),
		)
	) );
	Redux::setSection( $opt_name, array(
        'title' => __( 'Listings', 'ALSP' ),
        'id'    => 'listing_settings_section',
        'desc'  => '',
        'icon'  => 'pacz-icon-edit'
    ) );
	Redux::setSection( $opt_name, array(
      'id' => 'listings',
		'title' => __('Listings settings', 'ALSP'),   
		'subsection' => true,
		'fields' => array(
			array(
				'type' => 'switch',
				'id' => 'alsp_listings_on_index',
				'title' => __('Show listings on index', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'select',
				'id' => 'alsp_listing_post_style',
				'title' => __('Listing Style', 'ALSP'),
				'options' => array(
												
					'1' => __('style 1 Elca', 'ALSP'),

					'2' => __('style 2 Emo ', 'ALSP'),
												
					'3' => __('style 3 Lemo', 'ALSP'),
												
					'4' => __('style 4 Max', 'ALSP'),
												
					'5' => __('style 5 default', 'ALSP'),
												
					'6' => __('style 6 Exo', 'ALSP'),
												
					'7' => __('style 7 Exotic', 'ALSP'),
												
					'8' => __('style 8 Snow', 'ALSP'),
												
					'9' => __('style 9 Zee', 'ALSP'),
												
					'10' => __('style 10 Ultra', 'ALSP'),
												
					'11' => __('style 11 Mintox', 'ALSP'),
												
					'12' => __('style 12 Solic', 'ALSP'),
												
					'13' => __('style 13 Zoco', 'ALSP'),
					
					'14' => __('style 14 Fantro', 'ALSP'),
					
					'15' => __('style 15 Directy', 'ALSP'),

				),
				'default' => '10',
			),
			array(
				'type' => 'select',
				'id' => 'alsp_listing_listview_post_style',
				'title' => __('Listing List View Style', 'ALSP'),
				'options' => array(
					'listview_default' => __('List View Style (Default)', 'ALSP'),
					'listview_ultra' => __('List View Style (Ultra)', 'ALSP'),
				),
				'default' => 'listview_ultra',
			),
			array(
				'type' => 'select',
				'id' => 'view_switther_panel_style',
				'title' => __('View Switcher and Sorting Panel Style', 'ALSP'),
				'options' => array(
					'1' => __('style 1 Default', 'ALSP'),
					'2' => __('style 2 Fantro ', 'ALSP'),
				),
				'default' => '1',
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_grid_masonry_display',
				'title' => __('Turn on Masonry layout for grid styles', 'ALSP'),
				'desc' => '',
				'default' => true,
			),
			array(
				'type' => 'text',
				'id' => 'alsp_listings_number_index',
				'title' => __('Number of listings on index page', 'ALSP'),
				'default' => 6,
				'validation' => 'required|numeric',
			),
			array(
				'type' => 'text',
				'id' => 'alsp_listings_number_excerpt',
				'title' => __('Number of listings on excerpt pages (categories, locations, tags, search results)', 'ALSP'),
				'default' => 6,
				'validation' => 'required|numeric',
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_listing_responsive_grid',
				'title' => __('Responsive listing grid 2collumn', 'ALSP'),
				'desc' => '',
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'price_decimal',
				'title' => __('Turn On decimal for price field', 'ALSP'),
				'desc' => '',
				'default' => true,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_grid_padding',
				'title' => __('Padding Between grid items', 'ALSP'),
				'min' => 0,
				'max' => 50,
				'default' => 15,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_grid_margin_bottom',
				'title' => __('Grid items Margin Bottom', 'ALSP'),
				'min' => 0,
				'max' => 50,
				'default' => 30,
			),
			array(
				'type' => 'select',
				'id' => 'price_symb',
				'title' => __('Currency Sybmbol location', 'ALSP'),
				'desc' => __('Currency Sybmbol location on listing'),
				'options' => array(
					'pre' => __('Pre', 'ALSP'),
					'post' => __('Post ', 'ALSP'),
				),
				'default' => 'list',
			)
		),
	) );
	Redux::setSection( $opt_name, array(
        'id' => 'social_sharing_section',
		'subsection' => true,
		'title' => __('Social Sharing', 'ALSP'),
		'fields' => array(
			array(
											'type' => 'image_select',
											'id' => 'alsp_share_buttons_style',
											'title' => __('Buttons style', 'ALSP'),
									 		'options' => array(
									 			'arbenta' => array(
									 				'alt' =>__('Arbenta', 'ALSP'),
									 				'img' => ALSP_RESOURCES_URL . 'images/social/arbenta/Facebook.png'
									 			),
									 			'flat' => array(
													'alt' =>__('Flat', 'ALSP'),
									 				'img' => ALSP_RESOURCES_URL . 'images/social/flat/Facebook.png'
									 			),
									 			'somacro' => array(
													'alt' =>__('Somacro', 'ALSP'),
									 				'img' => ALSP_RESOURCES_URL . 'images/social/somacro/Facebook.png'
									 			),
												// pacz addition
												'pacz' => array(
													'alt' =>__('pacz', 'ALSP'),
									 				'img' => ALSP_RESOURCES_URL . 'images/social/pacz/Facebook.png'
									 			),
									 		),
											'default' => 'pacz',
										),
										array(
											'type' => 'sorter',
											'id' => 'alsp_share_buttons',
											'title' => __('Include and order buttons', 'ALSP'),
									 		'options' => array(
												'enabled' => array(
													'facebook' => __('Facebook', 'ALSP'),
													'twitter' => __('Twitter', 'ALSP'),
													'google' => __('Google', 'ALSP'),
													'linkedin' => __('LinkedIn', 'ALSP'),
													'digg' => __('Digg', 'ALSP'),
													'reddit' => __('Reddit', 'ALSP'),
													'pinterest' => __('Pinterest', 'ALSP'),
													'tumblr' => __('Tumblr', 'ALSP'),
													'stumbleupon' => __('StumbleUpon', 'ALSP'),
													'email' => __('Email', 'ALSP')
												),
												'disabled' => array(
													'vk' => __('VK', 'ALSP'),
												)
											)
										),
										array(
											'type' => 'switch',
											'id' => 'alsp_share_counter',
											'title' => __('Enable counter', 'ALSP'),
											'default' => false,
										),
										array(
											'type' => 'radio',
											'id' => 'alsp_share_buttons_place',
											'title' => __('Buttons place', 'ALSP'),
											'options' => array(
												'title' =>__('After title', 'ALSP'),
												'before_content' =>__('Before text content', 'ALSP'),
												'after_content' =>__('After text content', 'ALSP'),
											),
											'default' => 'after_content'
										),
										array(
											'type' => 'slider',
											'id' => 'alsp_share_buttons_width',
											'title' => __('Social buttons width (in pixels)', 'ALSP'),
											'default' => 39,
									 		'min' => 24,
									 		'max' => 64,
										),
		),
	) );
	Redux::setSection( $opt_name, array(
        'id' => 'breadcrumbs',
		'subsection' => true,
		'title' => __('Breadcrumbs settings', 'ALSP'),
		'fields' => array(
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_breadcrumbs',
				'title' => __('Enable breadcrumbs', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_hide_home_link_breadcrumb',
				'title' => __('Hide home link in breadcrumbs', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'radio',
				'id' => 'alsp_breadcrumbs_mode',
				'title' => __('Breadcrumbs mode on listing single page', 'ALSP'),
				'default' => 'title',
				'options' => array(
					'title' => __('%listing title%', 'ALSP'),	
					'category' => __('%category% » %listing title%', 'ALSP'),	
					'location' => __('%location% » %listing title%', 'ALSP'),	
				),
			),
		),
	) );
	
	Redux::setSection( $opt_name, array(
        'id' => 'otherads_by_user',
		'title' => __('OTher Ads by Same user', 'ALSP'),
		'subsection' => true,
		'fields' => array(
			array(
				'type' => 'switch',
				'id' => 'single_listing_other_ads_byuser',
				'title' => __('Enable Other Ads', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'slider',
				'id' => 'single_listing_othoradd_limit',
				'title' => __('Number of ads from same auhtor to show on single listing and author page', 'ALSP'),
				'min' => 1,
				'max' => 20,
				'default' => 4,
			),
			array(
				'type' => 'switch',
				'id' => 'single_listing_otherads_viewshitcher',
				'title' => __('Other Ads View Swither', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'hide_ordering_single_listing_otherads',
				'title' => __('Hide ordering links on other ads at single listing and author page', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'slider',
				'id' => 'single_listing_otherads_gridview_col',
				'title' => __('Other ads column for grid view on single listing and author page', 'ALSP'),
				'min' => 1,
				'max' => 4,
				'default' => 2,
			),
			array(
				'type' => 'select',
				'id' => 'single_listing_otherads_view_type',
				'title' => __('Listing view type for other ads by same user at single listing and author page', 'ALSP'),
				'desc' => __('Below custom width and height will work only if custom option is selected, Otherwise post pre-defined values will be set to the listing thumbnail'),
				'options' => array(
					'list' => __('List', 'ALSP'),
					'grid' => __('Grid ', 'ALSP'),
				),
				'default' => 'list',
			),
		),
	) );
	
	Redux::setSection( $opt_name, array(
        'id' => 'logos',
		'title' => __('Listings logos & images', 'ALSP'),
		'subsection' => true,
		'fields' => array(
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_lighbox_gallery',
				'title' => __('Enable lightbox on images gallery', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_nologo',
				'title' => __('Enable default logo image', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'media',
				'id' => 'alsp_nologo_url',
				'url' => false,
				'title' => __('Default logo image', 'ALSP'),
				'desc' => __('This image will appear when listing owner did not upload own logo.', 'ALSP'),
				'default' => '',
			),
			array(
				'type' => 'select',
				'id' => 'listing_image_width_height',
				'title' => __('Listing Thumbnail Width Default/Custom', 'ALSP'),
				'desc' => __('Below custom width and height will work only if custom option is selected, Otherwise post pre-defined values will be set to the listing thumbnail'),
				'options' => array(
					'1' => __('Default', 'ALSP'),
					'2' => __('Custom ', 'ALSP'),
				),
				'default' => 1,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_logo_width',
				'title' => __('Images width', 'ALSP'),
				'desc' => __(''),
				'min' => 100,
				'max' => 800,
				'default' => 270,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_logo_height',
				'title' => __('Images height', 'ALSP'),
				'desc' => __(''),
				'min' => 100,
				'max' => 800,
				'default' => 220,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_logo_width_listview',
				'title' => __('Images width on List View', 'ALSP'),
				'desc' => __(''),
				'min' => 100,
				'max' => 800,
				'default' => 130,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_logo_height_listview',
				'title' => __('Images height on List View', 'ALSP'),
				'desc' => __(''),
				'min' => 100,
				'max' => 800,
				'default' => 130,
			),
		),
	) );
	Redux::setSection( $opt_name, array(
		'id' => 'single_listing_page',
		'title' => __('Single Listing Page', 'ALSP'),
		'subsection' => true,
		'fields' => array(
			array(
				'type' => 'select',
				'id' => 'alsp_single_listing_style',
				'title' => __('Single Listing Page Style', 'ALSP'),
				'options' => array(
					'1' => __('style 1 Default', 'ALSP'),
					'2' => __('style 2 Ultra ', 'ALSP'),
				),
				'default' => '2',
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_listing_bidding',
				'title' => __('Enable bidding option on front-end', 'ALSP'),
				'desc' => '',
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_listing_contact',
				'title' => __('Enable contact option on front-end', 'ALSP'),
				'desc' => '',
				'default' => true,
			),
			array(
				'type' => 'select',
				'id' => 'message_system',
				'title' => __('Single Listing Contact form Type', 'ALSP'),
				'required' => array('alsp_listing_contact', '!=', false),
				'options' => array(
					'instant_messages' => __('Instant Messaging System', 'ALSP'),
					'email_messages' => __('Email contact Form', 'ALSP'),
				),
				'default' => 'instant_messages',
			),
										
			array(
				'type' => 'switch',
				'id' => 'alsp_listing_contact_form',
				'required' => array('message_system', 'equals', 'email_messages'),
				'title' => __('Enable contact form on listing page', 'ALSP'),
				'desc' => __('Contact Form 7 or standard form will be displayed on each listing page', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_custom_contact_email',
				'required' => array('alsp_listing_contact_form', '!=', false),
				'title' => __('Allow custom contact emails', 'ALSP'),
				'desc' => __('When enabled users may set up custom contact emails, otherwise messages will be sent directly to authors emails', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'text',
				'id' => alsp_get_wpml_dependent_option_name('alsp_listing_contact_form_7'),
				'title' => __('Contact Form 7 shortcode', 'ALSP'),
				'desc' => __('This will work only when Contact Form 7 plugin enabled, otherwise standard contact form will be displayed.', 'ALSP') .  alsp_get_wpml_dependent_option_description(),
				'default' => '',
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_print_button',
				'title' => __('Show print listing button', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_pdf_button',
				'title' => __('Show listing in PDF button', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_change_expiration_date',
				'title' => __('Allow regular users to change listings expiration dates', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_hide_comments_number_on_index',
				'title' => __('Hide comments number on index and excerpt pages', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'radio',
				'id' => 'alsp_listings_comments_mode',
				'title' => __('Listings comments mode', 'ALSP'),
				'default' => 'disabled',
				'options' => array(
					'enabled' => __('Always enabled', 'ALSP'),
					'disabled' => __('Always disabled', 'ALSP'),
					'wp_settings' => __('As configured in WP settings', 'ALSP'),	
				),
			),
			array(
				'type' => 'radio',
				'id' => 'alsp_listings_comments_position',
				'title' => __('Listings comments Position', 'ALSP'),
				'default' => 'intab',
				'options' => array(
					'intab' => __('In Tabs', 'ALSP'),
					'notab' => __('Out Side of Tabs', 'ALSP'),
				),
			),
			array(
				'type' => 'switch',
				'id' => 'single_listing_tab',
				'title' => __('Turn on Tabs at single listing page', 'ALSP'),
				'desc' => __('Turn Tabs on/Off at single listing page', 'ALSP'),
				'default' => 1,
			),
			array(
				'type' => 'switch',
				'id' => 'map_on_single_listing_tab',
				'title' => __('Show map on single listing', 'ALSP'),
				'desc' => __('Turn map on/Off at single listing page', 'ALSP'),
				'default' => 1,
			),
			array(
				'type' => 'radio',
				'id' => 'alsp_listings_map_position',
				'title' => __('Listings Map Position', 'ALSP'),
				'default' => 'intab',
				'options' => array(
					'intab' => __('In Tabs', 'ALSP'),
					'notab' => __('Out Side of Tabs', 'ALSP'),
				),
			),
			array(
				'type' => 'radio',
				'id' => 'alsp_listings_video_position',
				'title' => __('Listings Video Position', 'ALSP'),
				'default' => 'intab',
				'options' => array(
					'intab' => __('In Tabs', 'ALSP'),
					'notab' => __('Out Side of Tabs', 'ALSP'),
				),
			),
										
			array(
				'type' => 'sorter',
				'id' => 'alsp-listings-tabs-order', // alsp-listings-tabs-order converted from alsp_listings_tabs_order
				'title' => __('Priority of opening of listing tabs', 'ALSP'),
					'options' => array(
					'enabled' => $new_listing_tabs,
					'disabled' => array(
					'' =>  __("empty option(don't remove)", "ALSP"),
					)
				),
				'desc' => __('Set up priority of tabs those are opened by default. If any listing does not have any tab - next tab in the order will be opened by default.', 'ALSP'),
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_stats',
				'title' => __('Enable statistics functionality', 'ALSP'),
				'default' => true,
			),
		)
	) );
	Redux::setSection( $opt_name, array(
        'id' => 'single_listing_slider',
		'title' => __('Single Listing Slider', 'ALSP'),
		'subsection' => true,
		'fields' => array(
			array(
				'type' => 'switch',
				'id' => 'alsp_100_single_logo_width',
				'title' => __('100% width of images gallery on single listing page', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_single_logo_width',
				'title' => __('Images gallery width on single listing page (in pixels)', 'ALSP'),
				'desc' => __('This option needed only when 100% width of images gallery is switched off'),
				'min' => 100,
				'max' => 2550,
				'default' => 770,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_single_logo_height',
				'title' => __('Images gallery Height on single listing page (in pixels)', 'ALSP'),
				'desc' => __('This option needed only when 100% width of images gallery is switched off'),
				'min' => 100,
				'max' => 800,
				'default' => 480,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_single_listing_owl_loop',
				'title' => __('Enable Carousel Loop on single listing slider', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_single_listing_owl_autoplay',
				'title' => __('Enable Carousel Autoplay on single listing slider', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_single_listing_owl_nav',
				'title' => __('Enable Carousel Navigation on single listing slider', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_single_listing_owl_autowidth',
				'title' => __('Enable Carousel Auto Width on single listing slider', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_single_listing_owl_center',
				'title' => __('Center Carousel items on single listing slider', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'text',
				'id' => 'alsp_single_listing_owl_desktop_items',
				'title' => __('Carousel items on single listing slider (Above 1025px)', 'ALSP'),
				'default' => 4,
			),
			array(
				'type' => 'text',
				'id' => 'alsp_single_listing_owl_tab_lanscape_items',
				'title' => __('Carousel items on single listing slider (Tablet Landscape 960px - 1024px)', 'ALSP'),
				'default' => 3,
			),
			array(
				'type' => 'text',
				'id' => 'alsp_single_listing_owl_tab_items',
				'title' => __('Carousel items on single listing slider (Tablet 700px to 959px)', 'ALSP'),
				'default' => 2,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_single_listing_owl_autoplaySpeed',
				'title' => __('Autoplay speed for single listing slider', 'ALSP'),
				'min' => 100,
				'max' => 6000,
				'default' => 1000,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_single_listing_owl_autoplayGutter',
				'title' => __('Margen between items on single listing slider', 'ALSP'),
				'min' => 0,
				'max' => 100,
				'default' => 5,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_single_listing_owl_autoplayDelay',
				'title' => __('Autoplay Delay for single listing slider', 'ALSP'),
				'min' => 100,
				'max' => 6000,
				'default' => 1000,
			),
		)
	) );
	Redux::setSection( $opt_name, array(
        'id' => 'excerpts',
		'title' => __('description & Excerpt settings', 'ALSP'),
		'subsection' => true,
		'fields' => array(
			array(
				'type' => 'text',
				'id' => 'alsp_listing_title_font',
				'title' => __('Listing Title font size', 'ALSP'),
				'default' => 16,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_description',
				'title' => __('Enable description field', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_summary',
				'title' => __('Enable summary field', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'text',
				'id' => 'alsp_excerpt_length',
				'title' => __('Excerpt max length', 'ALSP'),
				'desc' => __('Insert the number of letters you want to show in the listings excerpts', 'ALSP'),
				'default' => 80,
				'validation' => 'required|numeric',
			),
			array(
				'type' => 'text',
				'id' => 'max_title_length',
				'title' => __('Listing Title max length', 'ALSP'),
				'desc' => __('Insert the number of letters you want to show in the listings excerpts', 'ALSP'),
				'default' => 20,
				'validation' => 'required|numeric',
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_cropped_content_as_excerpt',
				'title' => __('Use cropped content as excerpt', 'ALSP'),
				'desc' => __('When excerpt field is empty - use cropped main content', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_strip_excerpt',
				'title' => __('Strip HTML from excerpt', 'ALSP'),
				'desc' => __('Check the box if you want to strip HTML from the excerpt content only', 'ALSP'),
				'default' => true,
			),
		),
	) );
	Redux::setSection( $opt_name, array(
        'title' => __( 'Page and views', 'ALSP' ),
        'id'    => 'page_views_settings_section',
        'desc'  => '',
        'icon'  => 'pacz-theme-icon-multipage'
    ) );
	Redux::setSection( $opt_name, array(
        'id' => 'excerpt_views',
		'title' => __('Archive pages', 'ALSP'),
		'subsection' => true,
		'fields' => array(
			array(
				'type' => 'switch',
				'id' => 'alsp_views_switcher',
				'title' => __('Enable views switcher', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'radio',
				'id' => 'alsp_views_switcher_default',
				'title' => __('Listings view by default', 'ALSP'),
				'desc' => __('Do not forget that selected view will be stored in cookies', 'ALSP'),
				'default' => 'grid',
				'options' => array(
					'list' => __('List view', 'ALSP'),
					'grid' => __('Grid view', 'ALSP'),
				),
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_views_switcher_grid_columns',
				'title' => __('Number of columns for listings Grid View', 'ALSP'),
				'min' => 1,
				'max' => 4,
				'default' => 4,
			),
		),
	) );
	
	Redux::setSection( $opt_name, array(
        'id' => 'categories',
		'title' => __('Categories settings', 'ALSP'),
		'subsection' => true,
		'fields' => array(
			array(
				'type' => 'select',
				'id' => 'alsp_categories_style',
				'title' => __('Categories Default Style', 'ALSP'),
				'options' => array(
					'1' => __('style 1', 'ALSP'),
					'2' => __('style 2', 'ALSP'),
					'3' => __('style 3', 'ALSP'),
				),
				'default' => '3',
			),
			array(
				'type' => 'select',
				'id' => 'cat_icon_type',
				'title' => __('Categories Icon Style', 'ALSP'),
				'options' => array(
					'1' => __('Font Icon', 'ALSP'),
					'2' => __('Image Icon', 'ALSP'),
					'3' => __('SVG Icon', 'ALSP'),
				),
				'default' => 2,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_show_categories_index',
				'title' => __('Show categories list on index and excerpt pages?', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_categories_nesting_level',
				'title' => __('Categories nesting level', 'ALSP'),
				'min' => 1,
				'max' => 2,
				'default' => 1,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_categories_columns',
				'title' => __('Categories columns number', 'ALSP'),
				'min' => 1,
				'max' => 4,
				'default' => 1,
			),
			array(
				'type' => 'text',
				'id' => 'alsp_subcategories_items',
				'title' => __('Show subcategories items number', 'ALSP'),
				'desc' => __('Leave 0 to show all subcategories', 'ALSP'),
				'default' => 0,
				'validation' => 'numeric',
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_show_category_count',
				'title' => __('Show category listings count?', 'ALSP'),
				'default' => false,
			),
		),
	) );
	
	Redux::setSection( $opt_name, array(
        'id' => 'locations',
			'title' => __('Locations settings', 'ALSP'),
			'subsection' => true,
			'fields' => array(
			array(
				'type' => 'switch',
				'id' => 'alsp_show_locations_index',
				'title' => __('Show locations list on index and excerpt pages?', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_locations_nesting_level',
				'title' => __('Locations nesting level', 'ALSP'),
				'min' => 1,
				'max' => 2,
				'default' => 1,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_locations_columns',
				'title' => __('Locations columns number', 'ALSP'),
				'min' => 1,
				'max' => 4,
				'default' => 2,
			),
			array(
				'type' => 'text',
				'id' => 'alsp_sublocations_items',
				'title' => __('Show sublocations items number', 'ALSP'),
				'desc' => __('Leave 0 to show all sublocations', 'ALSP'),
				'default' => 0,
				'validation' => 'numeric',
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_show_location_count',
				'title' => __('Show location listings count?', 'ALSP'),
				'default' => false,
			),
		),
	) );
	
	Redux::setSection( $opt_name, array(
        'id' => 'sorting',
		'title' => __('Sorting settings', 'ALSP'),
		'subsection' => true,
		'fields' => array(
			array(
				'type' => 'switch',
				'id' => 'alsp_show_orderby_links',
				'title' => __('Show order by links block', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_orderby_date',
				'title' => __('Allow sorting by date', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_orderby_title',
				'title' => __('Allow sorting by title', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_orderby_distance',
				'title' => __('Allow sorting by distance when search by radius', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'select',
				'id' => 'alsp_default_orderby',
				'title' => __('Default order by', 'ALSP'),
				'options' => $ordering_items,
				'default' => 'post_date',
			),
			array(
				'type' => 'select',
				'id' => 'alsp_default_order',
				'title' => __('Default order direction', 'ALSP'),
				'options' => array(
					'ASC' => __('Ascending', 'ALSP'),
					'DESC' => __('Descending', 'ALSP'),
				),
				'default' => 'DESC',
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_orderby_exclude_null',
				'title' => __('Exclude listings with empty values from sorted results', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_orderby_sticky_featured',
				'title' => __('Sticky and featured listings always will be on top', 'ALSP'),
				'desc' => __('When switched off - sticky and featured listings will be on top only when listings were sorted by date.', 'ALSP'),
				'default' => false,
			),
		),
	) );
	
	Redux::setSection( $opt_name, array(
        'id' => 'Pricing',
		'title' => __('Pricing Plan settings', 'ALSP'),
		'subsection' => true,
		'fields' => array(									
			array(
				'type' => 'select',
				'id' => 'alsp_pricing_plan_style',
				'title' => __('Pricing Plan Style', 'ALSP'),
				'options' => array(
					'pplan-style-1' => __('style 1', 'ALSP'),
					'pplan-style-2' => __('style 2', 'ALSP'),
					'pplan-style-3' => __('style 3', 'ALSP'),
				),
				'default' => 'pplan-style-3',
			),
		),
	) );
	
	Redux::setSection( $opt_name, array(
        'id' => 'search',
		'title' => __('Search settings', 'ALSP'),
		'icon'  => 'pacz-fic1-search-1',
		'fields' => array(
			array(
				'type' => 'select',
				'id' => 'search-form-style',
				'title' => __('Search Form Style', 'ALSP'),
				'options' => array(
					'1' => __('Style1', 'ALSP'),
					'2' => __('Style2', 'ALSP'),
					'3' => __('Style3', 'ALSP'),
				),
				'default' => 1,
			),
										
			array(
				'type' => 'slider',
				'id' => 'alsp_search_style3_mtop',
				'title' => __('Search Style 3 Margin Top', 'ALSP'),
				'min' => '-300',
				'max' => 300,
				'default' => '-110',
			),							
			array(
				'type' => 'switch',
				'id' => 'alsp_search_style3_shadow',
				'title' => __('Turn Search Style 3 shaow On/Off', 'ALSP'),
				'desc' => '',
				'default' => false,
			),
			array(
				'type' => 'slider',
				'id' => 'keyword_field_width',
				'title' => __('Search Form KeyWordField Width', 'ALSP'),
				'min' => 0,
				'max' => 100,
				'default' => 25,
			),
			array(
				'type' => 'slider',
				'id' => 'category_field_width',
				'title' => __('Search Form Category Field Width', 'ALSP'),
				'min' => '0',
				'max' => 100,
				'default' => 25,
			),
			array(
				'type' => 'slider',
				'id' => 'location_field_width',
				'title' => __('Search Form Location Field Width', 'ALSP'),
									 		'min' => '0',
									 		'max' => 100,
				'default' => 25,
			),
			array(
				'type' => 'slider',
				'id' => 'address_field_width',
				'title' => __('Search Form Address Field Width', 'ALSP'),
				'min' => '0',
				'max' => 100,
				'default' => 25,
			),
			array(
				'type' => 'slider',
				'id' => 'radius_field_width',
				'title' => __('Search Form Radius Width', 'ALSP'),
				'min' => '0',
				'max' => 100,
				'default' => 25,
			),
			array(
				'type' => 'slider',
				'id' => 'button_field_width',
				'title' => __('Search Form Button Width', 'ALSP'),
				'min' => '0',
				'max' => 100,
				'default' => 25,
			),
			array(
				'type' => 'slider',
				'id' => 'button_field_margin_top',
				'title' => __('Search Form Button Margin Top', 'ALSP'),
				'desc' => __('Search Form Button Margin Top in PX (May be required if button is not in first row)', 'ALSP'),
				'min' => 0,
				'max' => 50,
				'default' => 0,
			),
			array(
				'type' => 'slider',
				'id' => 'gap_in_fields',
				'title' => __('Gap between Search Fields', 'ALSP'),
				'min' => '0',
				'max' => 100,
				'default' => 10,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_main_search',
				'title' => __('Display search block in main part of page?', 'ALSP'),
				'desc' => __('Note, that search widget is independent from this setting and this widget renders on each page where main search block was hidden', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'advanced_search_opean_on_archive',
				'title' => __('Advanced search always opened on archive pages', 'ALSP'),
				'desc' => __('this option will effect search page, index page, category and location archive pages', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'switch',
				'id' => 'advanced_open_widget',
				'title' => __('Turn On Advanced Open by Default in sidebar Widget', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_show_what_search',
				'title' => __('Show "What search" section?', 'ALSP'),
				'desc' => __('This setting is actual for both: main search block and widget', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_show_where_search',
				'title' => __('Show "Where search" section?', 'ALSP'),
				'desc' => __('This setting is actual for both: main search block and widget', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_show_keywords_search',
				'title' => __('Show keywords search?', 'ALSP'),
				'desc' => __('This setting is actual for both: main search block and widget', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_show_locations_search',
				'title' => __('Show locations search?', 'ALSP'),
				'desc' => __('This setting is actual for both: main search block and widget', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_show_address_search',
				'title' => __('Show address search?', 'ALSP'),
				'desc' => __('This setting is actual for both: main search block and widget', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_show_location_count_in_search',
				'title' => __('Show listings counts in locations search dropboxes?', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_show_categories_search',
				'title' => __('Show categories search?', 'ALSP'),
				'desc' => __('This setting is actual for both: main search block and widget', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_show_category_count_in_search',
				'title' => __('Show listings counts in categories search dropboxes?', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_show_radius_search',
				'title' => __('Show locations radius search?', 'ALSP'),
				'desc' => __('This setting is actual for both: main search block and widget', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'radio',
				'id' => 'alsp_miles_kilometers_in_search',
				'title' => __('Dimension in radius search', 'ALSP'),
				'desc' => __('This setting is actual for both: main search block and widget', 'ALSP'),
				'options' => array(
					'miles' => __('miles', 'ALSP'),
					'kilometers' => __('kilometers', 'ALSP'),
				),
				'default' => 'miles',
			),
			array(
				'type' => 'text',
				'id' => 'alsp_radius_search_min',
				'title' => __('Minimum radius search', 'ALSP'),
				'default' => 0,
				'validation' => 'required|numeric',
			),
			array(
				'type' => 'text',
				'id' => 'alsp_radius_search_max',
				'title' => __('Maximum radius search', 'ALSP'),
				'default' => 10,
				'validation' => 'required|numeric',
			),
			array(
				'type' => 'text',
				'id' => 'alsp_radius_search_default',
				'title' => __('Default radius search', 'ALSP'),
				'default' => 0,
				'validation' => 'required|numeric',
			),
		),
	) );
	Redux::setSection( $opt_name, array(
        'id' => 'search-header',
		'title' => __('Header Search', 'ALSP'),
		'subsection' => true,
		'fields' => array(
			array(
				'type' => 'slider',
				'id' => 'keyword_field_width_header',
				'title' => __('Header Search Form KeyWordField Width', 'ALSP'),
				'min' => '0',
				'max' => 100,
				'default' => 25,
			),
			array(
				'type' => 'slider',
				'id' => 'category_field_width_header',
				'title' => __('Header Search Form Category Field Width', 'ALSP'),
				'min' => '0',
				'max' => 100,
				'default' => 25,
			),
			array(
				'type' => 'slider',
				'id' => 'location_field_width_header',
				'title' => __('Header Search Form Location Field Width', 'ALSP'),
									 		'min' => '0',
									 		'max' => 100,
				'default' => 25,
			),
			array(
				'type' => 'slider',
				'id' => 'button_field_width_header',
				'title' => __(' Header Search Form Button Width', 'ALSP'),
				'min' => '0',
				'max' => 100,
				'default' => 25,
			),
		),
	) );
	Redux::setSection( $opt_name, array(
        'title' => __( 'Map Settings', 'ALSP' ),
        'id'    => 'map_settings_section',
        'desc'  => '',
        'icon'  => 'pacz-icon-map-marker'
    ) );
	Redux::setSection( $opt_name, array(
        'id' => 'maps',
		'title' => __('General', 'ALSP'),
		'subsection' => true,
		'fields' => array(
			array(
				'type' => 'text',
				'id' => 'alsp_google_api_key',
				'title' => __('Google browser API key', 'ALSP'),
				'desc' => sprintf(__('get your Google API key <a href="%s" target="_blank">here</a>, following APIs must be enabled in the console: Google Maps JavaScript API, Google Static Maps API and Google Maps Directions API.', 'ALSP'), 'https://code.google.com/apis/console'),
				'default' => '',
			),
			array(
				'type' => 'text',
				'id' => 'alsp_google_api_key_server',
				'title' => __('Google server API key', 'ALSP'),
				'desc' => sprintf(__('get your Google API key <a href="%s" target="_blank">here</a>, following APIs must be enabled in the console: Google Maps Geocoding API for radius search functionality.', 'ALSP'), 'https://code.google.com/apis/console'),
				'default' => '',
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_map_on_index',
				'title' => __('Show map on index page?', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_map_on_excerpt',
				'title' => __('Show map on excerpt page?', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'select',
				'id' => 'alsp_address_autocomplete_code',
				'title' => __('Restriction of address fields for the default country (autocomplete and search)', 'ALSP'),
				'options' => $new_country_codes,
				'default' => '0',
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_show_directions',
				'title' => __('Show directions panel for individual listing map?', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'radio',
				'id' => 'alsp_directions_functionality',
				'title' => __('Directions functionality', 'ALSP'),
				'options' => array(
					'builtin' =>__('Built-in routing', 'ALSP'),
					'google' =>__('Link to Google Maps', 'ALSP'),
				),
				'default' => 'builtin',
											
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_default_map_zoom',
				'title' => __('Default Google Maps zoom level (for submission page)', 'ALSP'),
				'min' => 1,
				'max' => 19,
				'default' => 11,
			),
			array(
				'type' => 'select',
				'id' => 'alsp_map_style',
				'title' => __('Google Maps style', 'ALSP'),
				'options' => $new_map_styles,
				'default' => 'default',
			),
			array(
				'type' => 'text',
				'id' => 'alsp_default_map_height',
				'title' => __('Default map height (in pixels)', 'ALSP'),
				'default' => 450,
				'validation' => 'required|numeric',
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_radius_search_cycle',
				'title' => __('Show cycle during radius search?', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_clusters',
				'title' => __('Enable clusters of map markers?', 'ALSP'),
				'default' => false,
			),
		),
	) );
	
	Redux::setSection( $opt_name, array(
        'id' => 'maps_controls',
		'title' => __('Maps controls settings', 'ALSP'),
		'subsection' => true,
		'fields' => array(
		array(
				'type' => 'switch',
				'id' => 'alsp_enable_draw_panel',
				'title' => __('Enable Draw Panel', 'ALSP'),
				'desc' => __('Very important: MySQL version must be 5.6.1 and higher or MySQL server variable "thread stack" must be 256K and higher. Ask your hoster about it if "Draw Area" does not work.', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_full_screen',
				'title' => __('Enable full screen button', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_wheel_zoom',
				'title' => __('Enable zoom by mouse wheel', 'ALSP'),
				'desc' => __('For desktops', 'ALSP'),
				'default' => false,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_dragging_touchscreens',
				'title' => __('Enable map dragging on touch screen devices', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_center_map_onclick',
				'title' => __('Center map on marker click', 'ALSP'),
				'default' => true,
			),
		),
	) );
	
	Redux::setSection( $opt_name, array(
        'id' => 'addresses',
		'title' => __('Addresses settings', 'ALSP'),
		'subsection' => true,
		'fields' => array(
			array(
				'type' => 'text',
				'id' => 'alsp_default_geocoding_location',
				'title' => __('Default country/state for correct geocoding', 'ALSP'),
				'desc' => __('This value needed when you build local diirectory, all your listings place in one local area - country or state. You do not want to set countries or states in the search, so this hidden string will be automatically added to the address for correct geocoding when you create/edit listings.', 'ALSP'),
				'default' => '',
			),
			array(
				'type' => 'sorter',
				'id' => 'alsp-addresses-order',
				'title' => __('Order of address lines on single listing page', 'ALSP'),
				'options' => array(
					'enabled' => array(
						'line-1' => __('Address Line 1', 'ALSP'),
						'comma1' => __('-- Comma (,) --', 'ALSP'),
						'space1' => __('-- Space ( ) --', 'ALSP'),
						'line-2' => __('Address Line 2', 'ALSP'),
						'comma2' => __('-- Comma (,) --', 'ALSP'),
						'space2' => __('-- Space ( ) --', 'ALSP'),
						'location' => __('Selected location', 'ALSP'),
						'comma3' => __('-- Comma (,) --', 'ALSP'),
						'space3' => __('-- Space ( ) --', 'ALSP'),
						'zip' => __('Zip code or postal index', 'ALSP'),
						'break1' => __('-- Line Break --', 'ALSP'),
						'break2' => __('-- Line Break --', 'ALSP'),
					),
					'disabled' => array()
				),
				'desc' => __('Order address elements as you wish, commas and spaces help to build address line.'),
											//'default' => get_option('alsp_addresses_order'),
			),
			array(
				'type' => 'sorter',
				'id' => 'alsp-addresses-order_ongrid',
				'title' => __('Order of address lines on grid and list view', 'ALSP'),
				'options' => array(
					'enabled' => array(
						'line-1' => __('Address Line 1', 'ALSP'),
						'comma1' => __('-- Comma (,) --', 'ALSP'),
						'space1' => __('-- Space ( ) --', 'ALSP'),
						'line-2' => __('Address Line 2', 'ALSP'),
						'comma2' => __('-- Comma (,) --', 'ALSP'),
						'space2' => __('-- Space ( ) --', 'ALSP'),
						'location' => __('Selected location', 'ALSP'),
						'comma3' => __('-- Comma (,) --', 'ALSP'),
						'space3' => __('-- Space ( ) --', 'ALSP'),
						'zip' => __('Zip code or postal index', 'ALSP'),
						'break1' => __('-- Line Break --', 'ALSP'),
						'break2' => __('-- Line Break --', 'ALSP'),
					),
					'disabled' => array()
				),
				'desc' => __('Order address elements as you wish, commas and spaces help to build address line.'),
											//'default' => get_option('alsp_addresses_order'),
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_address_line_1',
				'title' => __('Enable address line 1 field', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_address_line_2',
				'title' => __('Enable address line 2 field', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_postal_index',
				'title' => __('Enable zip code', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_additional_info',
				'title' => __('Enable additional info field', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_manual_coords',
				'title' => __('Enable manual coordinates fields', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_address_autocomplete',
				'title' => __('Enable autocomplete on addresses fields', 'ALSP'),
				'default' => true,
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_address_geocode',
				'title' => __('Enable "Get my location" button on addresses fields', 'ALSP'),
				'default' => false,
			),
		),
	) );
	
	Redux::setSection( $opt_name, array(
        'id' => 'markers',
		'title' => __('Map markers & InfoWindow', 'ALSP'),
		'subsection' => true,
		'fields' => array(
			array(
				'type' => 'radio',
				'id' => 'alsp_map_markers_type',
				'title' => __('Type of Map Markers', 'ALSP'),
				'options' => array(
					'icons' => __('Font Awesome icons (recommended)', 'ALSP'),
					'images' => __('PNG images', 'ALSP'),
				),
				'default' => 'icons',
			),
			array(
				'type' => 'color',
				'id' => 'alsp_default_marker_color',
				'title' => __('Default Map Marker color', 'ALSP'),
				'default' => '#2393ba',
				'desc' => __('For Font Awesome icons.', 'ALSP'),
			),
			array(
				'type' => 'text',
				'id' => 'alsp_default_marker_icon',
				'title' => __('Default Map Marker icon'),
				'desc' => __('For Font Awesome icons.', 'ALSP'),
				'default' => 'pacz-icon-map-marker',
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_map_marker_width',
				'title' => __('Map marker width (in pixels)', 'ALSP'),
				'desc' => __('For PNG images.', 'ALSP'),
				'default' => 48,
				'min' => 10,
				'max' => 100,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_map_marker_height',
				'title' => __('Map marker height (in pixels)', 'ALSP'),
				'desc' => __('For PNG images.', 'ALSP'),
				'default' => 48,
				'min' => 10,
				'max' => 100,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_map_marker_anchor_x',
				'title' => __('Map marker anchor horizontal position (in pixels)', 'ALSP'),
				'desc' => __('For PNG images.', 'ALSP'),
				'default' => 24,
				'min' => 0,
				'max' => 100,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_map_marker_anchor_y',
				'title' => __('Map marker anchor vertical position (in pixels)', 'ALSP'),
				'desc' => __('For PNG images.', 'ALSP'),
				'default' => 48,
				'min' => 0,
				'max' => 100,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_map_infowindow_width',
				'title' => __('Map InfoWindow width (in pixels)', 'ALSP'),
				'default' => 270,
				'min' => 100,
				'max' => 600,
				'step' => 10,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_map_infowindow_offset',
				'title' => __('Map InfoWindow vertical position above marker (in pixels)', 'ALSP'),
				'default' => 50,
				'min' => 30,
				'max' => 120,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_map_infowindow_logo_width',
				'title' => __('Map InfoWindow logo width (in pixels)', 'ALSP'),
				'default' => 250,
				'min' => 40,
				'max' => 370,
				'step' => 1,
			),
			array(
				'type' => 'slider',
				'id' => 'alsp_map_infowindow_logo_height',
				'title' => __('Map InfoWindow logo height (in pixels)', 'ALSP'),
				'default' => 150,
				'min' => 40,
				'max' => 370,
				'step' => 1,
			),
		),
	) );
	
	Redux::setSection( $opt_name, array(
        'id' => 'notifications',
		'title' => __('Email notifications', 'ALSP'),
		'icon'  => 'pacz-theme-icon-email',
		'fields' => array(
			array(
				'type' => 'text',
				'id' => 'alsp_send_expiration_notification_days',
				'title' => __('Days before pre-expiration notification will be sent', 'ALSP'),
				'default' => '',
			),
			array(
				'type' => 'text',
				'id' => 'alsp_admin_notifications_email',
				'title' => __('This email will be used for notifications to admin and in "From" field. Required to send emails.', 'ALSP'),
				'default' => '',
			),
			array(
				'type' => 'textarea',
				'id' => 'alsp_preexpiration_notification',
				'title' => __('Pre-expiration notification', 'ALSP'),
				'default' => '',
			),
			array(
				'type' => 'textarea',
				'id' => 'alsp_expiration_notification',
				'title' => __('Expiration notification', 'ALSP'),
				'default' => '',
			),
			array(
				'type' => 'textarea',
				'id' => 'alsp_newuser_notification',
				'title' => __('Registration of new user notification', 'ALSP'),
				'desc' => __('You can use following parameters, #password_set_link, #username, #blogname', 'ALSP'),
				'default' => '',
			),
			array(
				'type' => 'textarea',
				'id' => 'alsp_newlisting_admin_notification',
				'title' => __('Notification to admin about new listing creation', 'ALSP'),
				'default' => '',
			),
			array(
				'type' => 'textarea',
				'id' => 'alsp_pending_approval_notification',
				'title' => __('Notification to author about listing Submission and pending approval', 'ALSP'),
				'default' => '',
			),
			array(
				'type' => 'textarea',
				'id' => 'alsp_approval_notification',
				'title' => __('Notification to author about successful listing approval', 'ALSP'),
				'default' => '',
			),
			array(
				'type' => 'textarea',
				'id' => 'alsp_claim_notification',
				'title' => __('Notification of claim to current listing owner', 'ALSP'),
				'default' => '',
			),
			array(
				'type' => 'textarea',
				'id' => 'alsp_claim_approval_notification',
				'title' => __('Notification of successful approval of claim', 'ALSP'),
				'default' => '',
			),
				array(
				'type' => 'textarea',
				'id' => 'alsp_claim_decline_notification',
				'title' => __('Notification of claim decline', 'ALSP'),
				'default' => '',
			),
		),
	) );
	
	/*Redux::setSection( $opt_name, array(
        'id' => 'js_css',
		'title' => __('JavaScript & CSS', 'ALSP'),
		'desc' => __('Do not touch these settings if you do not know what they mean. It may cause lots of problems.', 'ALSP'),
		'fields' => array(
			array(
				'type' => 'switch',
				'id' => 'alsp_images_lightbox',
				'title' => __('Include lightbox slideshow library?', 'ALSP'),
				'desc' =>  __('Some themes and 3rd party plugins include own Lighbox library - this may cause conflicts.', 'ALSP'),
				'default' => get_option('alsp_images_lightbox'),
			),
			array(
				'type' => 'switch',
				'id' => 'alsp_notinclude_jqueryui_css',
				'title' => __('Do not include jQuery UI CSS', 'ALSP'),
									 		'desc' =>  __('Some themes and 3rd party plugins include own jQuery UI CSS - this may cause conflicts in styles.', 'ALSP'),
				'default' => get_option('alsp_notinclude_jqueryui_css'),
			),
		),
	) );*/
	
	Redux::setSection( $opt_name, array(
		'id' => 'recaptcha',
		'title' => __('reCaptcha settings', 'ALSP'),
		'icon' => 'pacz-li-refresh',
		'fields' => array(
			array(
				'type' => 'switch',
				'id' => 'alsp_enable_recaptcha',
				'title' => __('Enable reCaptcha', 'ALSP'),
				'default' => '',
			),
			array(
				'type' => 'text',
				'id' => 'alsp_recaptcha_public_key',
				'title' => __('reCaptcha public key', 'ALSP'),
				'desc' => sprintf(__('get your reCAPTCHA API Keys <a href="%s" target="_blank">here</a>', 'ALSP'), 'http://www.google.com/recaptcha'),
				'default' => '',
			),
			array(
				'type' => 'text',
				'id' => 'alsp_recaptcha_private_key',
				'title' => __('reCaptcha private key', 'ALSP'),
				'default' => '',
			),
		),
	) );
	
	global $sitepress;
	if (function_exists('wpml_object_id_filter') && $sitepress) {
		Redux::setSection( $opt_name, array(
			'id' => 'wpml-selction',
			'title' => __('WPML Option', 'ALSP'),
			'icon' => 'pacz-li-refresh',
			'fields' => array(
				array(
					'type' => 'switch',
					'id' => 'alsp_map_language_from_wpml',
					'title' => __('Force WPML language on maps', 'W2GM'),
					'desc' => __("Ignore the browser's language setting and force it to display information in a particular WPML language", 'ALSP'),
					'default' => false,
				),
			),
		) );
	}

    /*
     * <--- END SECTIONS
     */
	 

