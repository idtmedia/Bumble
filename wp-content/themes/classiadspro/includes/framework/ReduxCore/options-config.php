<?php

    /**
     * ReduxFramework Barebones Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "pacz_settings";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

     $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'submenu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_html__( 'Theme Settings', 'classiadspro' ),
        'page_title'           => esc_html__( 'Theme Settings', 'classiadspro' ),
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
        'page_slug'            => 'theme_settings',
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
	

    /*
     * ---> END ARGUMENTS
     */

    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'Theme Information 1', 'classiadspro' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'classiadspro' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => __( 'Theme Information 2', 'classiadspro' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'classiadspro' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'classiadspro' );
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

	
	  Redux::setSection( $opt_name, array(
		'title' => esc_html__('General Settings', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'icon' => 'el-icon-globe-alt',
		'fields' => array(
			array(
				'id' => 'grid-width',
				'type' => 'slider',
				'title' => esc_html__('Main grid Width', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				"default" => "1170",
				"min" => "960",
				"step" => "1",
				"max" => "1380",
			),
			array(
				'id' => 'content-width',
				'type' => 'slider',
				'title' => esc_html__('Content Width', 'classiadspro'),
				'subtitle' => esc_html__('Using this option you can define the width of the content.', 'classiadspro'),
				'desc' => esc_html__('please note that this option is in percent, lets say if you set it 60%, sidebar will occupy 40% of the main content space.', 'classiadspro'),
				"default" => "67",
				"min" => "50",
				"step" => "1",
				"max" => "80",
			),
			array(
				'id' => 'pages-layout',
				'type' => 'image_select',
				'title' => esc_html__('Pages Layout', 'classiadspro'),
				'subtitle' => esc_html__('Defines Pages layout.', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'options' => array(
					'left' => array('alt' => '1 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/left_layout.png'),
					'right' => array('alt' => '2 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/right_layout.png'),
					'full' => array('alt' => '3 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/full_layout.png'),
				),
				'default' => 'right'
			),
			array(
				'id' => 'error_page',
				'type' => 'select',
				'title' => esc_html__('404 Page template', 'classiadspro'),
				'subtitle' => esc_html__('Defines 404 Pages template.', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'options' => array(
					'1' => esc_html__('style 1.', 'classiadspro'),
					'2' => esc_html__('style 2.', 'classiadspro'),
				),
				'default' => '1'
			),
			array(
				'id' => 'error-layout',
				'type' => 'image_select',
				'title' => esc_html__('404 Page Layout', 'classiadspro'),
				'subtitle' => esc_html__('Defines Pages layout.', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'options' => array(
					'left' => array('alt' => '1 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/left_layout.png'),
					'right' => array('alt' => '2 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/right_layout.png'),
					'full' => array('alt' => '3 Column', 'img' =>   PACZ_THEME_ADMIN_ASSETS_URI . '/img/full_layout.png'),
				),
				'default' => 'full'
			),
			array(
				'id' => 'error_page_small_text',
				'type' => 'textarea',
				'title' => esc_html__('404 Page small text', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('small text message to show at 404 page', 'classiadspro'),
				'default' => esc_html__('Far far away, behind the word mountains, far from the countries Vokalia and there live the blind texts. Sepraed. they live in Boo marksgrove right at the coast of the Semantics, a large language ocean A small river named Duden flows by their place and su plies it.', "classiadspro")
			),
			array(
				'id' => 'search-layout',
				'type' => 'image_select',
				'title' => esc_html__('search page Layout', 'classiadspro'),
				'subtitle' => esc_html__('Defines search Page layout.', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'options' => array(
					'left' => array('alt' => '1 Column', 'img' =>  PACZ_THEME_ADMIN_ASSETS_URI . '/img/left_layout.png'),
					'right' => array('alt' => '2 Column', 'img' =>  PACZ_THEME_ADMIN_ASSETS_URI . '/img/right_layout.png'),
					'full' => array('alt' => '3 Column', 'img' =>  PACZ_THEME_ADMIN_ASSETS_URI . '/img/full_layout.png'),
				),
				'default' => 'full'
			),
			array(
				'id' => 'sidebar_content_radius',
				'type' => 'slider',
				'title' => esc_html__('Sidebar and Content Area Radius', 'classiadspro'),
				'subtitle' => '',
				"default" => 0,
				"min" => "0",
				"step" => "1",
				"max" => "25",
				"unit" => "px",
			),
			array(
				'id' => 'breadcrumb',
				'type' => 'switch',
				'title' => esc_html__('Breadcrumb', 'classiadspro'),
				'subtitle' => esc_html__('Breadcrumbs will appear horizontally across the top of all pages below header.', 'classiadspro'),
				'desc' => esc_html__('Using this option you can disable breadcrumbs throughout the site.', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'smooth-scroll',
				'type' => 'switch',
				'title' => esc_html__('Smooth Scroll', 'classiadspro'),
				'subtitle' => esc_html__('Adds easing movement in page scroll and modifys browser native scrollbar', 'classiadspro'),
				'desc' => esc_html__('If you don\'t want this feature just disable it from this option.', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'pages-comments',
				'type' => 'switch',
				'title' => esc_html__('Page Comments', 'classiadspro'),
				'subtitle' => esc_html__('Option to globally enable/disable comments in pages.', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'custom-sidebar',
				'type' => 'multi_text',
				'title' => esc_html__('Custom Sidebars', 'classiadspro'),
				'validate' => 'no_special_chars',
				'subtitle' => esc_html__('Will create custom widget areas to help you make custom sidebars in pages & posts.', 'classiadspro'),
				'desc' => esc_html__('No Special characters please! eg: "contact page 3"', 'classiadspro')
			),
			array(
				'id' => 'typekit-id',
				'type' => 'text',
				'title' => esc_html__('Typekit Kit ID', 'classiadspro'),
				'desc' => esc_html__("If you want to use typekit in your site simply enter The Type Kit ID you get from Typekit site.", 'classiadspro'). __("<a target='_blank' href='http://help.typekit.com/customer/portal/articles/6840-using-typekit-with-wordpress-com'>Read More</a>", "classiadspro"),
				'subtitle' => esc_html__("", 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'remove-js-css-ver',
				'type' => 'switch',
				'title' => esc_html__('Remove query string from Static Files', 'classiadspro'),
				'subtitle' => esc_html__('Removes "ver" query string from JS and CSS files.', 'classiadspro'),
				'desc' => __('For More info Please <a href="https://developers.google.com/speed/docs/best-practices/caching#LeverageProxyCaching">Read Here</a>.', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
		),
	));
	 Redux::setSection( $opt_name, array(
		'title' => esc_html__('Header', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'icon' => 'el-icon-website',
	));
	 Redux::setSection( $opt_name, array(
		'title' => esc_html__('Header Background', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'subsection' => true,
		'icon' => 'el-icon-website',
		'fields' => array(
			array(
				'id' => 'header-bg',
				'type' => 'bg_selector',
				'title' => esc_html__('Header Background', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'preset' => false,
				'default' => array(
					'url' => '',
					'color' => '#ffffff',
					'position' => '',
					'repeat' => 'repeat',
					'attachment' => 'scroll',
					'cover' => '',
				)
			),
			array(
				'id' => 'header-bottom-border',
				'type' => 'color',
				'title' => esc_html__('Header Bottom Border Color', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '',
				'validate' => 'color',
			),
			array(
				'id' => 'toolbar-bg',
				'type' => 'bg_selector',
				'title' => esc_html__('Header Toolbar Background', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'preset' => false,
				'default' => array(
					'url' => '',
					'color' => '#fff',
					'position' => '',
					'repeat' => 'repeat',
					'attachment' => 'scroll',
					'cover' => '',
				)
			),
		)
	));
	 Redux::setSection( $opt_name, array(
		'title' => esc_html__('Header Skins', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'subsection' => true,
		'icon' => 'el-icon-website',
		'fields' => array(
			array(
				'id' => 'main-nav-top-color',
				'type' => 'nav_color',
				'title' => esc_html__('Main Navigation Top Level', 'classiadspro'),
				'subtitle' => esc_html__('Will affect main navigation top level links', 'classiadspro'),
				'regular' => true,
				'hover' => true,
				'bg' => true,
				'bg-hover' => true,
				'default' => array(
					'regular' => '#333333',
					'hover' => '#c32026',
					'bg' => '',
					'bg-hover' => '',
				)
			),
			array(
				'id' => 'main-nav-sub-bg',
				'type' => 'color',
				'title' => esc_html__('Main Navigation Sub Level Background Color', 'classiadspro'),
				'subtitle' => esc_html__('This value will affect Sub level background color including mega menu.', 'classiadspro'),
				'default' => '#f5f5f5',
				'validate' => 'color',
			),

			array(
				'id' => 'main-nav-sub-color',
				'type' => 'nav_color',
				'title' => esc_html__('Main Navigation Sub Level', 'classiadspro'),
				'subtitle' => esc_html__('all sub level menus ans sidebar links.', 'classiadspro'),
				'regular' => true,
				'hover' => true,
				'bg' => true,
				'bg-hover' => true,
				'bg-active' => true,
				'default' => array(
					'regular' => '#333',
					'hover' => '#fff',
					'bg' => '',
					'bg-hover' => '#c32026',
					'bg-active' => '#222',
				)
			),
			array(
				'id' => 'navigation-border-top',
				'type' => 'switch',
				'title' => esc_html__('Show Main Navigation Border Top?', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				"default" => 0,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'toolbar-border-top',
				'type' => 'switch',
				'title' => esc_html__('Show Toolbar Border Top?', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				"default" => 0,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			
			array(
				'id' => 'toolbar-border-bottom-color',
				'type' => 'color',
				'title' => esc_html__('Header Toolbar Border Bottom Color', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '#eee',
				'validate' => 'color',
			),
			array(
				'id' => 'toolbar-text-color',
				'type' => 'color',
				'title' => esc_html__('Header Toolbar Text Color', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '#999999',
				'validate' => 'color',
			),
			array(
				'id' => 'toolbar-phone-email-icon-color',
				'type' => 'color',
				'title' => esc_html__('Header Toolbar Phone & Email Icon Color', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '#ffffff',
				'validate' => 'color',
			),
			array(
				'id' => 'toolbar-link-color',
				'type' => 'nav_color',
				'title' => esc_html__('Header Toolbar Link Color', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'regular' => true,
				'hover' => true,
				'default' => array(
					'regular' => '#999999',
					'hover' => '#c32026'
				)
			),
			array(
				'id' => 'toolbar-social-link-color',
				'type' => 'nav_color',
				'title' => esc_html__('Header Toolbar Social Network Link Color', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'regular' => true,
				'hover' => true,
				'bg' => true,
				'bg-hover' => true,
				'default' => array(
					'regular' => '#ffffff',
					'hover' => '#c32026',
					'bg-hover' => '#c32026',
				)
			),
			array(
				'id' => 'toolbar-social-link-color-bg',
				'type' => 'color_rgba',
				'title' => esc_html__('toolbar Social links background ', 'classiadspro'),
				'subtitle' => esc_html__('you can use rgba color ', 'classiadspro'),
				'default' => array(
				'color' =>'#eee',
				'alpha'     => 1,
				)
			),
			array(
				'id' => 'header-search-icon-color',
				'type' => 'color',
				'title' => esc_html__('Header Search Icon Color', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '#333333',
				'validate' => 'color',
			),
			array(
				'id' => 'header_cart_link_color',
				'type' => 'nav_color',
				'title' => esc_html__('Header cart Link Color', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'regular' => true,
				'hover' => true,
				'bg' => true,
				'bg-hover' => true,
				'default' => array(
					'regular' => '#ffffff',
					'hover' => '#fff',
					'bg' => '#c32026',
					'bg-hover' => '#c32026',
				)
			),
			array(
				'id' => 'listing-header-btn-color',
				'type' => 'nav_color',
				'title' => esc_html__('Header listing button colors', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
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
			)
		)
	));
	 Redux::setSection( $opt_name, array(
		'title' => esc_html__('Toolbar Contact info ', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'subsection' => true,
		'icon' => 'el-icon-website',
		'fields' => array(
			array(
				"title" => esc_html__("Header contact", "classiadspro"),
				"desc" => esc_html__("", "classiadspro"),
				"id" => "header-contact-select",
				"default" => 'header_toolbar',
				"options" => array(
					"header_toolbar" => esc_html__('Header Toolbar', "classiadspro"),
					"disabled" => esc_html__('Disabled', "classiadspro")
				),
				"type" => "select"
			),
			array(
				'id' => 'header-contact-align',
				'type' => 'select',
				'title' => esc_html__('Header Toolbar contact Align', 'classiadspro'),
				'subtitle' => esc_html__('if logo location is toolbar selected ', 'classiadspro'),
				'desc' => esc_html__('Please note that this option does not work for vertical header style. Use below option instead', 'classiadspro'),
				'options' => array('left' => 'Left', 'center' => 'Center', 'right' => 'Right'), //Must provide key => value pairs for radio options
				'default' => 'right'
			),
			array(
				'id' => 'header-toolbar-phone',
				'type' => 'text',
				'required' => array('header-toolbar', 'equals', '1'),
				'title' => esc_html__('Header Toolbar Phone Number', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'header-toolbar-phone-icon',
				'type' => 'text',
				'required' => array('header-toolbar', 'equals', '1'),
				'title' => esc_html__('Header Toolbar Phone Icon', 'classiadspro'),
				'desc' => esc_html__("This option will give you the ability to add any icon you want to use for front of the email address.  to get the icon class name.", 'classiadspro'),
				'subtitle' => esc_html__("", 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'header-toolbar-email',
				'type' => 'text',
				'required' => array('header-toolbar', 'equals', '1'),
				'title' => esc_html__('Header Toolbar Email Address', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'header-toolbar-email-icon',
				'type' => 'text',
				'required' => array('header-toolbar', 'equals', '1'),
				'title' => esc_html__('Header Toolbar Email Icon', 'classiadspro'),
				'desc' => esc_html__("This option will give you the ability to add any icon you want to use for front of the email address.  to get the icon class name.", 'classiadspro'),
				'subtitle' => esc_html__("", 'classiadspro'),
				'default' => '',
			),
		)
	));
	 Redux::setSection( $opt_name, array(
		'title' => esc_html__('Header Social Networks', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'subsection' => true,
		'icon' => 'el-icon-website',
		'fields' => array(
			array(
				"title" => esc_html__("Header Social Networks", "classiadspro"),
				"desc" => esc_html__("", "classiadspro"),
				"id" => "header-social-select",
				"default" => 'header_toolbar',
				"options" => array(
					"header_toolbar" => esc_html__('Header Toolbar', "classiadspro"),
					"header_section" => esc_html__('Header Section', "classiadspro"),
					"disabled" => esc_html__('Disabled', "classiadspro")
				),
				"type" => "select"
			),
			array(
				'id' => 'header-social-align',
				'type' => 'select',
				'title' => esc_html__('Header Toolbar SAocial Align', 'classiadspro'),
				'subtitle' => esc_html__('if logo location is toolbar selected ', 'classiadspro'),
				'desc' => esc_html__('Please note that this option does not work for vertical header style. Use below option instead', 'classiadspro'),
				'options' => array('left' => 'Left', 'center' => 'Center', 'right' => 'Right'), //Must provide key => value pairs for radio options
				'default' => 'left'
			),
			array(
				'id' => 'header-social-facebook',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('Facebook', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'header-social-twitter',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('Twitter', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'header-social-rss',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('RSS', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'header-social-dribbble',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('Dribbble', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'header-social-pinterest',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('Pinterest', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'header-social-instagram',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('Instagram', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'header-social-google-plus',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('Google Plus', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'header-social-linkedin',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('Linkedin', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'header-social-youtube',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('Youtube', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'header-social-vimeo',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('Vimeo', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'header-social-spotify',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('Spotify', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'header-social-tumblr',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('Tumblr', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'header-social-behance',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('Behance', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'header-social-WhatsApp',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('WhatsApp', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'header-social-qzone',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('qzone', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'header-social-vkcom',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('vk.com', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'header-social-imdb',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('IMDb', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'header-social-renren',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('Renren', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'header-social-weibo',
				'required' => array('header-social-select', 'equals', array( 'header_toolbar', 'header_section' )),
				'type' => 'text',
				'title' => esc_html__('Weibo', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header Social Networks', 'classiadspro'),
				'default' => '',
			),
		)
	));
	 Redux::setSection( $opt_name, array(
		'title' => esc_html__('Header Login Register', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'subsection' => true,
		'icon' => 'el-icon-website',
		'fields' => array(
			array(
				'id' => 'pacz-logreg-header-btn',
				'type' => 'switch',
				'title' => esc_html__('add login and register button in top header', 'classiadspro'),
				'desc' => __('', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
            array(
                'id'         => 'pacz-login-slug',
                'type'       => 'text',
                'title'      => 'Login Page Slug',
                'subtitle'   => 'set login page slug according to your login page',
                "default" 	 => 'login',
            ),
			array(
                'id'         => 'pacz-register-slug',
                'type'       => 'text',
                'title'      => 'Register Page Slug',
                'subtitle'   => 'set Register page slug according to your register page',
                "default" 	 => 'register',
            ),
			array(
                'id'         => 'pacz-forgot-slug',
                'type'       => 'text',
                'title'      => 'Forgot password Page Slug',
                'subtitle'   => 'set Forgot Password page slug according to your Forgot Password page',
                "default" 	 => 'forget-password',
            ),
			array(
				"title" => esc_html__("Longin/Registered Button Location", "classiadspro"),
				"desc" => esc_html__("", "classiadspro"),
				"id" => "header-login-reg-location",
				"default" => 'header_toolbar',
				"options" => array(
					"header_toolbar" => esc_html__('Header Toolbar', "classiadspro"),
					"header_section" => esc_html__('Header Section', "classiadspro"),
					"disabled" => esc_html__('Disabled', "classiadspro"),
				),
				"type" => "select"
			),
			array(
				"title" => esc_html__("Longin/Registered Button Style", "classiadspro"),
				"desc" => esc_html__("Choose button style", "classiadspro"),
				"id" => "pacz-logreg-style",
				"default" => '1',
				"options" => array(
					"1" => esc_html__('Button Style 1', "classiadspro"),
					"2" => esc_html__('Button Style 2', "classiadspro"),
				),
				"type" => "select"
			),
			array(
				'id' => 'log-reg-btn-align',
				'type' => 'select',
				'title' => esc_html__('Longin/Registered Button Align on Toolbar', 'classiadspro'),
				'subtitle' => esc_html__('if logo location is toolbar selected ', 'classiadspro'),
				'desc' => esc_html__('Please note that this option does not work for vertical header style. Use below option instead', 'classiadspro'),
				'options' => array('left' => 'Left', 'center' => 'Center', 'right' => 'Right'), //Must provide key => value pairs for radio options
				'default' => 'right'
			),
		)
	));
	 Redux::setSection( $opt_name, array(
		'title' => esc_html__('Header Toolbar', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'subsection' => true,
		'icon' => 'el-icon-website',
		'fields' => array(
			array(
				'id' => 'header-toolbar',
				'type' => 'switch',
				'title' => esc_html__('Header Toolbar', 'classiadspro'),
				'subtitle' => esc_html__('Enable/Disable Header Toolbar', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				"default" => 0,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'toolbar-grid',
				'type' => 'switch',
				'required' => array('header-toolbar', 'equals', '1'),
				'title' => esc_html__('Header Toolbar in grid', 'classiadspro'),
				'subtitle' => esc_html__('Enable/Disable Header Toolbar', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				"default" => 0,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				"title" => esc_html__("Header Toolbar Custom Menu", "classiadspro"),
				"desc" => esc_html__("", "classiadspro"),
				'required' => array('header-toolbar', 'equals', '1'),
				"id" => "toolbar-custom-menu",
				"default" => '',
				"data" => 'menus',
				"type" => "select"
			),
		
		)
	));
	 Redux::setSection( $opt_name, array(
		'title' => esc_html__('Header Logo', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'subsection' => true,
		'icon' => 'el-icon-website',
		'fields' => array(
			array(
				"title" => esc_html__("Header logo location", "classiadspro"),
				"desc" => esc_html__("", "classiadspro"),
				"id" => "header-logo-location",
				"default" => 'header_section',
				"options" => array(
					"header_toolbar" => esc_html__('Header Toolbar', "classiadspro"),
					"header_section" => esc_html__('Header Section', "classiadspro"),
				),
				"type" => "select"
			),
			array(
				'id' => 'header-logo-align',
				'type' => 'select',
				'title' => esc_html__('Header Toolbar Logo Align', 'classiadspro'),
				'subtitle' => esc_html__('if logo location is toolbar selected ', 'classiadspro'),
				'desc' => esc_html__('Please note that this option does not work for vertical header style. Use below option instead', 'classiadspro'),
				'options' => array('left' => 'Left', 'center' => 'Center', 'right' => 'Right'), //Must provide key => value pairs for radio options
				'default' => 'left'
			),
			array(
				'id' => 'logo',
				'type' => 'media',
				'url' => false,
				'title' => esc_html__('Upload Logo', 'classiadspro'),
				'mode' => false,
				'desc' => esc_html__('', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => false,
			),

			array(
				'id' => 'logo-retina',
				'type' => 'media',
				'url' => false,
				'title' => esc_html__('Upload Retina Logo', 'classiadspro'),
				'mode' => false,
				'desc' => esc_html__('Please note that the image you are uploading should be exactly 2x size of the original logo you have uploaded in above option.', 'classiadspro'),
				'subtitle' => esc_html__('Use this option if you want your logo appear crystal clean in retina devices(eg. macbook retina, ipad, iphone).', 'classiadspro'),
				'default' => false,
			),

			array(
				'id' => 'preloader-logo',
				'type' => 'media',
				'url' => false,
				'title' => esc_html__('Pre-loader Overlay Logo', 'classiadspro'),
				'mode' => false,
				'desc' => esc_html__('This logo will be viewed in the pre-loader overlay. This overlay can be enabled form page meta option and mostly used for heavy pages with alot of content and images.', 'classiadspro'),
				'subtitle' => esc_html__('Image size is up to you.', 'classiadspro'),
				'default' => false,
			),

			array(
				'id' => 'mobile-logo',
				'type' => 'media',
				'url' => false,
				'title' => esc_html__('Upload Mobile Logo', 'classiadspro'),
				'mode' => false,
				'subtitle' => esc_html__('This option comes handly when your logo is just too long for a mobile device and you would like to upload a shorter and smaller logo just to fit the header area.', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'default' => false,
			),

			array(
				'id' => 'mobile-logo-retina',
				'type' => 'media',
				'url' => false,
				'title' => esc_html__('Upload Mobile Retina Logo', 'classiadspro'),
				'mode' => false,
				'desc' => esc_html__('Please note that the image you are uploading should be exactly 2x size of the original logo you have uploaded in above option (Upload Mobile Logo).', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => false,
			),
		)
	));
	 Redux::setSection( $opt_name, array(
		'title' => esc_html__('Header Listing Button', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'subsection' => true,
		'icon' => 'el-icon-website',
		'fields' => array(
			array(
				"title" => esc_html__("Listing Button Location", "classiadspro"),
				"desc" => esc_html__("", "classiadspro"),
				"id" => "listing-btn-location",
				"default" => 'header_section',
				"options" => array(
					"header_toolbar" => esc_html__('Header Toolbar', "classiadspro"),
					"header_section" => esc_html__('Header Section', "classiadspro"),
				),
				"type" => "select"
			),
			array(
				"title" => esc_html__("Listing Button Style", "classiadspro"),
				"desc" => esc_html__("", "classiadspro"),
				"id" => "listing_btn_style",
				"default" => 'header_section',
				"options" => array(
					"1" => esc_html__('Listing Button Style 1 ( Default )', "classiadspro"),
					"2" => esc_html__('Listing Button Style 2 ( Ultra )', "classiadspro"),
				),
				"type" => "select"
			),
			array(
				'id' => 'listing-btn-align',
				'type' => 'select',
				'title' => esc_html__('Header Listing Button Align', 'classiadspro'),
				'subtitle' => esc_html__('if logo location is toolbar selected ', 'classiadspro'),
				'desc' => esc_html__('Please note that this option does not work for vertical header style. Use below option instead', 'classiadspro'),
				'options' => array('left' => 'Left', 'center' => 'Center', 'right' => 'Right'), //Must provide key => value pairs for radio options
				'default' => 'right'
			),
			array(
				'id' => 'listing-btn-url',
				'type' => 'text',
				'title' => esc_html__('Header New Listing Button Url ', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Header New Listing Button url', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'listing-btn-text',
				'type' => 'text',
				'title' => esc_html__('Header New Listing Button Text', 'classiadspro'),
				'desc' => esc_html__('button text', 'classiadspro'),
				'subtitle' => esc_html__('Header New Listing Button', 'classiadspro'),
				'default' => '',
			),
		)
	));
	 Redux::setSection( $opt_name, array(
		'title' => esc_html__('Header Layout', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'subsection' => true,
		'icon' => 'el-icon-website',
		'fields' => array(
			array(
				'id' => 'res-nav-width',
				'type' => 'slider',
				'title' => esc_html__('Main Navigation Responsive Width', 'classiadspro'),
				'subtitle' => esc_html__('The width Main navigation converts to responsive mode.', 'classiadspro'),
				'desc' => esc_html__('Navigation item can vary from site to site and it totally depends on you to define a the best width Main Navigation convert to responsive mode. you can find the right value by just resizing the window to find the best fit coresponding to navigation items.', 'classiadspro'),
				"default" => "1170",
				"min" => "600",
				"step" => "1",
				"max" => "1380",
			),
			array(
				'id' => 'preset_header_style',
				'type' => 'select',
				'title' => esc_html__('Header Styles', 'classiadspro'),
				'subtitle' => esc_html__('Select Preset Header or Build your own', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'options' => array('preset_header' => 'Preset Headers', 'custom_header' => 'Custom Header'), //Must provide key => value pairs for radio options 
				'default' => 'preset_header',
			),
			array(
				'id' => 'preset_headers',
				'type' => 'select',
				'title' => esc_html__('Preset Header Styles', 'classiadspro'),
				'subtitle' => esc_html__('Select Preset Header', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'options' => array('1' => 'header1', '2' => 'Header2', '3' => 'Header3', '4' => 'Header4', '5' => 'Header5', '6' => 'Header6', '7' => 'Header7', '8' => 'Header8',  '9' => 'Header9',  '10' => 'Header10', '11' => 'custom header', '12' => 'Fantro' ), //Must provide key => value pairs for radio options 
				'default' => '1',
			),
			array(
				'id' => 'header-structure',
				'type' => 'select',
				'title' => esc_html__('Header Structure', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'options' => array('standard' => 'Standard', 'margin' => 'Margin', 'vertical' => 'Vertical'), //Must provide key => value pairs for radio options 
				'default' => 'standard',
			),
			array(
				'id' => 'header-location',
				'type' => 'select',
				'required' => array('header-structure', 'equals', 'standard'),
				'title' => esc_html__('Header Location', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('Whether stay at the top or bottom of the screen.', 'classiadspro'),
				'options' => array('top' => 'Top', 'bottom' => 'Bottom'), //Must provide key => value pairs for radio options
				'default' => 'top'
			),

			array(
				'id' => 'vertical-header-state',
				'type' => 'select',
				'required' => array('header-structure', 'equals', 'vertical'),
				'title' => esc_html__('Vertical Header State', 'classiadspro'),
				'subtitle' => esc_html__('Choose vertical header defaut state.', 'classiadspro'),
				'desc' => esc_html__('If condensed header chosen, header will be narrow by default and by clicking burger icon it will be expanded to reveal logo and navigation.', 'classiadspro'),
				'options' => array('condensed' => 'Expandable', 'expanded' => 'Always Open'), //Must provide key => value pairs for radio options
				'default' => 'expanded'
			),
			
			array(
				'id' => 'header-vertical-width',
				'type' => 'slider',
				'required' => array('header-structure', 'equals', 'vertical'),
				'title' => esc_html__('Header Vertical Width?', 'classiadspro'),
				'subtitle' => esc_html__('Default : 280px', 'classiadspro'),
				'desc' => esc_html__('Using this option you can increase or decrease header width.', 'classiadspro'),
				"default" => "280",
				"min" => "200",
				"step" => "1",
				"max" => "500",
			),
			array(
				'id' => 'header-padding',
				'type' => 'slider',
				'title' => esc_html__('Header Padding', 'classiadspro'),
				'subtitle' => esc_html__('Top & Bottom. default : 30px', 'classiadspro'),
				'desc' => esc_html__('Using this option you can increase or decrease header padding from its top and bottom.', 'classiadspro'),
				"default" => "34",
				"min" => "0",
				"step" => "1",
				"max" => "200",
			),
			array(
				'id' => 'header-padding-vertical',
				'type' => 'slider',
				'required' => array('header-structure', 'equals', 'vertical'),
				'title' => esc_html__('Header Padding', 'classiadspro'),
				'subtitle' => esc_html__('Left & Right. default : 30px', 'classiadspro'),
				'desc' => esc_html__('Using this option you can increase or decrease header padding from its top and bottom.', 'classiadspro'),
				"default" => "30",
				"min" => "0",
				"step" => "1",
				"max" => "100",
			),
			array(
				'id' => 'header-align',
				'type' => 'select',
				'title' => esc_html__('Header Align', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('Please note that this option does not work for vertical header style. Use below option instead', 'classiadspro'),
				'options' => array('left' => 'Left', 'center' => 'Center', 'right' => 'Right'), //Must provide key => value pairs for radio options
				'default' => 'left'
			),
			array(
				'id' => 'nav-alignment', 
				'type' => 'select',
				'title' => esc_html__('Vertical Header Menu Align', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'options' => array('left' => 'Left', 'center' => 'Center', 'right' => 'Right'), 
				'default' => 'left',
			),
			array(
				'id' => 'boxed-header',
				'type' => 'switch',
				'title' => esc_html__('Boxed Header', 'classiadspro'),
				'subtitle' => esc_html__('Full screen wide header content or inside main grid?.', 'classiadspro'),
				'desc' => esc_html__('If you want the cotent be stretched screen wide, disable this option.', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'header-grid',
				'type' => 'switch',
				'title' => esc_html__('header in grid', 'classiadspro'),
				'subtitle' => esc_html__('Will make header stay in top of browser while scrolling down', 'classiadspro'),
				'desc' => esc_html__('If you don\'t want this feature just disable it from this option.', 'classiadspro'),
				"default" => 0,
				'off' => 'Disable',
				'on' => 'Enable',
				
			),
			array(
				"title" => esc_html__( "in grid header margin top", "classiadspro" ),
				"desc" => esc_html__( "", "classiadspro" ),
				"id" => "header-grid-margin-top",
				"default" => "30",
				"min" => "0",
				"max" => "50",
				"step" => "1",
				"unit" => 'px',
				"type" => "slider"
			),
			array(
				"title" => esc_html__( "Header toolbar Height", "classiadspro" ),
				"desc" => esc_html__( "", "classiadspro" ),
				"id" => "toolbar_height",
				"default" => "110",
				"min" => "0",
				"max" => "200",
				"step" => "1",
				"unit" => 'px',
				"type" => "slider"
			),
			array(
				'id' => 'sticky-header',
				'type' => 'switch',
				'title' => esc_html__('Sticky Header', 'classiadspro'),
				'subtitle' => esc_html__('Will make header stay in top of browser while scrolling down', 'classiadspro'),
				'desc' => esc_html__('If you don\'t want this feature just disable it from this option.', 'classiadspro'),
				"default" => 0,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'squeeze-sticky-header',
				'type' => 'switch',
				'title' => esc_html__('Squeeze Sticky Header', 'classiadspro'),
				'subtitle' => esc_html__('This option to give you the control on whether to squeeze the sticky header or keep it same height as none-sticky.', 'classiadspro'),
				'desc' => esc_html__('Disable this option if you dont want this feature.', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				"title" => esc_html__("Main Navigation Hover Style", "classiadspro"),
				"desc" => esc_html__("", "classiadspro"),
				"id" => "header-hover-style",
				"default" => 'primary-menu',
				"options" => array(
					"1" => esc_html__('Style 1', "classiadspro"),
					"2" => esc_html__('Disabled', "classiadspro")
				),
				"type" => "select"
			),
			array(
				'id' => 'header-border-top',
				'type' => 'switch',
				'title' => esc_html__('Show Header Border Top?', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				"default" => 0,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'header-search',
				'type' => 'switch',
				'title' => esc_html__('Header Search Form', 'classiadspro'),
				'subtitle' => esc_html__('Will stay on right hand of main navigation.', 'classiadspro'),
				'desc' => esc_html__('If you don\'t want this feature just disable it from this option.', 'classiadspro'),
				"default" => 0,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'header-search-location',
				'type' => 'select',
				'required' => array(array('header-align', 'equals', 'center'),array('header-search', 'equals', '1')),
				'title' => esc_html__('Header Search Location', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'options' => array('left' => 'Left', 'right' => 'Right'), //Must provide key => value pairs for radio options
				'default' => 'right'
			),
			array(
				'id' => 'header-wpml',
				'type' => 'switch',
				'title' => esc_html__('Header Wpml Language Selector', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('If you don\'t want this feature just disable it from this option.', 'classiadspro'),
				"default" => 0,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'page-title-pages',
				'type' => 'switch',
				'title' => esc_html__('Page Title : Pages', 'classiadspro'),
				'subtitle' => esc_html__('This option will affect Pages.', 'classiadspro'),
				'desc' => esc_html__('If you don\'t want to show page title section (title, breadcrumb) in Pages disable this option. this option will not affect archive, search, 404, category templates as well as blog and portfolio single posts.', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				"title" => esc_html__("Main Navigation for Logged In User", "classiadspro"),
				"desc" => esc_html__("Please choose the menu location that you would like to show as global main navigation for logged in users.", "classiadspro"),
				"id" => "loggedin_menu",
				"default" => 'primary-menu',
				"options" => array(
					"primary-menu" => esc_html__('Primary Navigation', "classiadspro"),
					"second-menu" => esc_html__('Second Navigation', "classiadspro"),
					"third-menu" => esc_html__('Third Navigation', "classiadspro"),
					"fourth-menu" => esc_html__('Fourth Navigation', "classiadspro"),
					"fifth-menu" => esc_html__('Fifth Navigation', "classiadspro"),
					"sixth-menu" => esc_html__('Sixth Navigation', "classiadspro"),
					"seventh-menu" => esc_html__('Seventh Navigation', "classiadspro"),
				),
				"type" => "select"
			),
		)
	));

	 Redux::setSection( $opt_name, array(
		'title' => esc_html__('Footer', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'icon' => 'el-icon-photo',
		'fields' => array(

			array(
				'id' => 'footer',
				'type' => 'switch',
				'title' => esc_html__('Footer', 'classiadspro'),
				'subtitle' => esc_html__('Will be located after content. Please note that sub footer will not be affected by this option.', 'classiadspro'),
				'desc' => esc_html__('If you don\'t want to have footer section you can disable it.', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'footer-layout',
				'required' => array('footer', 'equals', '1'),
				'type' => 'image_select',
				'title' => esc_html__('Footer Widget Area Columns', 'classiadspro'),
				'subtitle' => esc_html__('Defines in which strcuture footer widget areas would be divided', 'classiadspro'),
				'desc' => esc_html__('Please choose your footer widget area column strucutre.', 'classiadspro'),
				'options' => array(
					'1' => array('alt' => '1 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/column_1.png'),
					'2' => array('alt' => '2 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/column_2.png'),
					'3' => array('alt' => '3 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/column_3.png'),
					'4' => array('alt' => '4 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/column_4.png'),
					'5' => array('alt' => '5 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/column_5.png'),
					'6' => array('alt' => '6 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/column_6.png'),
					'half_sub_half' => array('alt' => 'Half Sub Half Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/column_half_sub_half.png'),
					'half_sub_third' => array('alt' => 'Half Sub Third Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/column_half_sub_third.png'),
					'third_sub_third' => array('alt' => 'Third Sub Third Column', 'img' =>  PACZ_THEME_ADMIN_ASSETS_URI . '/img/column_third_sub_third.png'),
					'third_sub_fourth' => array('alt' => 'Third Sub Fourth Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/column_third_sub_fourth.png'),
					'sub_half_half' => array('alt' => 'Sub Half Half Column', 'img' =>  PACZ_THEME_ADMIN_ASSETS_URI . '/img/column_sub_half_half.png'),
					'sub_third_half' => array('alt' => 'Sub Third Half Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/column_sub_third_half.png'),
					'sub_third_third' => array('alt' => 'Sub Third Third Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/column_sub_third_third.png'),
					'sub_fourth_third' => array('alt' => 'Sub Fourth Third Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/column_sub_fourth_third.png'),

				),
				'default' => 'half_sub_half'
			),
			array(
				'id' => 'top-footer',
				'type' => 'switch',
				'title' => esc_html__('Top Footer', 'classiadspro'),
				'subtitle' => esc_html__('Locates below footer.', 'classiadspro'),
				'desc' => esc_html__('If you don\'t want to have Top footer section you can disable it.', 'classiadspro'),
				"default" => 0,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				"title" => esc_html__("footer subscription form styles", "classiadspro"),
				'required' => array('top-footer', 'equals', '1'),
				"desc" => esc_html__("Please choose the menu location that you would like to show as global main navigation for logged in users.", "classiadspro"),
				"id" => "footer_form_style",
				"default" => '',
				"options" => array(
					"1" => esc_html__('Style 1', "classiadspro"),
					"2" => esc_html__('Style 2', "classiadspro"),
					"3" => esc_html__('Style 3', "classiadspro"),
					"4" => esc_html__('Style 4', "classiadspro"),
				),
				"type" => "select"
			),
			array(
				'id' => 'footer_top_logo',
				'type' => 'media',
				'url' => true,
				'required' => array('footer_form_style', 'equals', '4'),
				'title' => esc_html__('Upload Top Footer Logo', 'classiadspro'),
				'mode' => false,
				'desc' => '',
				'subtitle' => '',
				'default' => false,
			),
			array (
				"type" => "text",
				"title" => esc_html__ ( "Form id", 'classiadspro' ),
				"id" => "form_id",
				"default" => '2015',
			),
			array(
				'id' => 'footer_mailchimp_listid',
				'type' => 'text',
				'required' => array('top-footer', 'equals', '1'),
				'title' => esc_html__('Mailchimp id', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => '',
				'default' => 'http://designsvilla.us10.list-manage.com/subscribe/post?u=8d6fd5258003daa5d449677a9&amp;id=fb984af59f'
			),
			array(
				'id' => 'sub-footer',
				'type' => 'switch',
				'title' => esc_html__('Sub Footer', 'classiadspro'),
				'subtitle' => esc_html__('Locates below footer.', 'classiadspro'),
				'desc' => esc_html__('If you don\'t want to have sub footer section you can disable it.', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'back-to-top',
				'type' => 'switch',
				'title' => esc_html__('Sub Footer Back to Top Button', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				"default" => 0,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				"title" => esc_html__("footer back to top button style", "classiadspro"),
				'required' => array('sub-footer', 'equals', '1'),
				"desc" => esc_html__("", "classiadspro"),
				"id" => "back_to_top_style",
				"default" => '1',
				"options" => array(
					"1" => esc_html__('Style 1', "classiadspro"),
					"2" => esc_html__('Style 2', "classiadspro"),
					"3" => esc_html__('Style 3', "classiadspro"),
					"4" => esc_html__('Style 4', "classiadspro"),
				),
				"type" => "select"
			),
			array(
				'id' => 'footer_sell_btn',
				'type' => 'switch',
				'title' => esc_html__('Footer Sell Button', 'classiadspro'),
				'subtitle' => '',
				'desc' => '',
				"default" => 0,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'sell_btn_text',
				'type' => 'text',
				'title' => 'Footer Sell Button Text',
				'subtitle' => '',
				'desc' => '',
				'default' => esc_html__('Sell', 'classiadspro')
			),
			array(
				'id' => 'footer-copyright',
				'type' => 'textarea',
				'required' => array('sub-footer', 'equals', '1'),
				'title' => esc_html__('Sub Footer Copyright text', 'classiadspro'),
				'subtitle' => esc_html__('You may write your site copyright information.', 'classiadspro'),
				'desc' => '',
				'default' => 'Copyright All Rights Reserved'
			),
			array(
				'id' => 'subfooter-logos-src',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'media',
				'url' => true,
				'title' => esc_html__('Sub Footer Right Section Logo Image', 'classiadspro'),
				'mode' => false,
				'desc' => esc_html__('', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => false,
			),
			array(
				'id' => 'subfooter-logos-link',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('Sub Footer Right Section Logo Link', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '',
			),
			array(
				"title" => esc_html__("Footer Social Location", "classiadspro"),
				"desc" => esc_html__("Please choose the Social Network location for footer. location top will show social networks links with subscription form if form style 3 is selected, location bottom and will show icons on sub-footer and both with show icons on both locations ", "classiadspro"),
				"id" => "footer-social-location",
				"default" => '2',
				"options" => array(
					"1" => esc_html__('Top', "classiadspro"),
					"2" => esc_html__('Bottom', "classiadspro"),
					"3" => esc_html__('Both', "classiadspro"),
				),
				"type" => "select"
			),
			array(
				'id' => 'social-facebook',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('Facebook', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'social-twitter',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('Twitter', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'social-rss',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('RSS', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'social-dribbble',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('Dribbble', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'social-pinterest',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('Pinterest', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'social-instagram',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('Instagram', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'social-google-plus',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('Google Plus', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'social-linkedin',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('Linkedin', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'social-youtube',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('Youtube', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'social-vimeo',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('Vimeo', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'social-spotify',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('Spotify', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'social-tumblr',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('Tumblr', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'social-behance',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('Behance', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'social-whatsapp',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('WhatsApp', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'social-wechat',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('Wechat', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'social-qzone',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('qzone', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'social-vkcom',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('vk.com', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'social-imdb',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('IMDb', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'social-renren',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('Renren', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'social-weibo',
				'required' => array('sub-footer', 'equals', '1'),
				'type' => 'text',
				'title' => esc_html__('Weibo', 'classiadspro'),
				'desc' => esc_html__('Including http://', 'classiadspro'),
				'subtitle' => esc_html__('Sub Footer Social Networks', 'classiadspro'),
				'default' => '',
			),

		),
	));

	 Redux::setSection( $opt_name, array(
		'title' => esc_html__('Typography', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'icon' => 'el-icon-font',
		'fields' => array(

			array(
				'id' => 'body-font',
				'type' => 'typography',
				'title' => esc_html__('Body Font', 'classiadspro'),
				'compiler' => true, // Use if you want to hook in your own CSS compiler
				'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
				'font-backup' => true, // Select a backup non-google font in addition to a google font
				'font-style' => false, // Includes font-style and weight. Can use font-style or font-weight to declare
				'subsets' => true, // Only appears if google is true and subsets not set to false
				'font-size' => true,
				'line-height' => false,
				'color' => false,
				'preview' => true, // Disable the previewer
				'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
				'units' => 'px', // Defaults to px
				'subtitle' => esc_html__('Choose your body font properties.', 'classiadspro'),
				'default' => array(
					'font-family' => 'Montserrat',
					'google' => true,
					'font-size' => '14px',
				),
			),

			array(
				'id' => 'heading-font',
				'type' => 'typography',
				'title' => esc_html__('Headings Font', 'classiadspro'),
				'compiler' => false, // Use if you want to hook in your own CSS compiler
				'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
				'font-backup' => false, // Select a backup non-google font in addition to a google font
				'font-style' => false, // Includes font-style and weight. Can use font-style or font-weight to declare
				'subsets' => true, // Only appears if google is true and subsets not set to false
				'font-size' => false,
				'line-height' => false,
				'color' => false,
				'preview' => false, // Disable the previewer
				'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
				'units' => 'px', // Defaults to px
				'subtitle' => esc_html__('Choose your Heading fonts properties. <br>(will affect H1, H2, H3, H4, H5, H6)', 'classiadspro'),
				'default' => array(
					'font-family' => 'Montserrat',
					'google' => true,
					'font-weight' => '700',
				),
			),

			array(
				'id' => 'widget-title',
				'type' => 'typography',
				'title' => esc_html__('Widgets Title', 'classiadspro'),
				'compiler' => false, // Use if you want to hook in your own CSS compiler
				'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
				'font-backup' => false, // Select a backup non-google font in addition to a google font
				'font-style' => false, // Includes font-style and weight. Can use font-style or font-weight to declare
				'subsets' => true, // Only appears if google is true and subsets not set to false
				'font-size' => true,
				'line-height' => false,
				'color' => false,
				'preview' => false, // Disable the previewer
				'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
				'units' => 'px', // Defaults to px
				'subtitle' => esc_html__('This will apply to all widget areas title including footer, sidebar and side dashboard', 'classiadspro'),
				'default' => array(
					'font-family' => 'Montserrat',
					'google' => true,
					'font-size' => '14px',
					'font-weight' => 'bold',
				),
			),

			array(
				'id' => 'page-title-size',
				'type' => 'slider',
				'title' => esc_html__('Page Title Text Size', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				"default" => "36",
				"min" => "12",
				"step" => "1",
				"max" => "100",
			),
			array(
				'id' => 'p-text-size',
				'type' => 'slider',
				'title' => esc_html__('Paragraph Text Size', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				"default" => "14",
				"min" => "12",
				"step" => "1",
				"max" => "100",
			),
			array(
				'id' => 'p-line-height',
				'type' => 'slider',
				'title' => esc_html__('Paragraph Line Height', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				"default" => "28",
				"min" => "12",
				"step" => "1",
				"max" => "100",
			),
			array(
				'id' => 'footer-p-text-size',
				'type' => 'slider',
				'title' => esc_html__('Footer Paragraph Text Size', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				"default" => "12",
				"min" => "12",
				"step" => "1",
				"max" => "100",
			),
			array(
				'id' => 'main-nav-font',
				'type' => 'typography',
				'title' => esc_html__('Main Navigation Top level', 'classiadspro'),
				'compiler' => false, // Use if you want to hook in your own CSS compiler
				'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
				'font-backup' => false, // Select a backup non-google font in addition to a google font
				'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
				'subsets' => false, // Only appears if google is true and subsets not set to false
				'font-size' => true,
				'line-height' => false,
				'color' => false,
				'preview' => false, // Disable the previewer
				'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
				'units' => 'px', // Defaults to px
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => array(
					'font-family' => 'Montserrat',
					'google' => true,
					'font-size' => '13px',
					'font-weight' => '400',
				),
			),
			
			array(
				'id' => 'main-nav-item-space',
				'type' => 'slider',
				'title' => esc_html__('Main Menu Items Gutter Space', 'classiadspro'),
				'subtitle' => esc_html__('Left & Right. default : 17px', 'classiadspro'),
				'desc' => esc_html__('This Value will be applied as padding to left and right of the item.', 'classiadspro'),
				"default" => "15",
				"min" => "0",
				"step" => "1",
				"max" => "100",
			),
			array(
				'id' => 'vertical-nav-item-space',
				'type' => 'slider',
				'required' => array('header-structure', 'equals', 'vertical'),
				'title' => esc_html__('Main Menu Items Top & Bottom Padding', 'classiadspro'),
				'subtitle' => esc_html__('Top & Bottom. default : 10px', 'classiadspro'),
				'desc' => esc_html__('This Value will be applied as padding to top and bottom of the item.', 'classiadspro'),
				"default" => "10",
				"min" => "0",
				"step" => "1",
				"max" => "25",
			),
			array(
				'id' => 'main-nav-top-transform',
				'type' => 'button_set',
				'title' => esc_html__('Main Menu Top Level Text Transform', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'options' => array('uppercase' => 'Uppercase', 'capitalize' => 'Capitalize', 'lowercase' => 'Lower Case'), 
				'default' => 'uppercase',
			),

			array(
				'id' => 'sub-nav-top-size',
				'type' => 'slider',
				'title' => esc_html__('Main Menu Sub Level Font Size', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				"default" => "13", 
				"min" => "10",
				"step" => "1",
				"max" => "50",
			),
			array(
				'id' => 'sub-nav-top-transform',
				'type' => 'button_set',
				'title' => esc_html__('Main Menu Sub Level Text Transform', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'options' => array('uppercase' => 'Uppercase', 'capitalize' => 'Capitalize', 'lowercase' => 'Lower Case'), 
				'default' => 'capitalize',
			),
			array(
				'id' => 'sub-nav-top-weight',
				'type' => 'button_set',
				'title' => esc_html__('Main Menu Sub Level Font Weight', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'options' => array('lighter' => 'Light (300)', 'normal' => 'Normal (400)', '500' => '500', '600' => '600', 'bold' => 'Bold (700)', 'bolder' => 'Bolder', '8000' => 'Extra Bold (800)', '900' => '900'), 
				'default' => 'normal',
			),
			array(
				'id' => 'toolbar-font',
				'type' => 'typography',
				'title' => esc_html__('Toolbar Font', 'classiadspro'),
				'compiler' => true, // Use if you want to hook in your own CSS compiler
				'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
				'font-backup' => false, // Select a backup non-google font in addition to a google font
				'font-style' => false, // Includes font-style and weight. Can use font-style or font-weight to declare
				'subsets' => false, // Only appears if google is true and subsets not set to false
				'font-size' => true,
				'line-height' => false,
				'color' => false,
				'preview' => true, // Disable the previewer
				'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
				'units' => 'px', // Defaults to px
				'subtitle' => esc_html__('Choose your header toolbar font properties.', 'classiadspro'),
				'default' => array(
					'font-family' => 'Montserrat',
					'google' => true,
					'font-size' => '13px',
					'font-weight' => '400',
				),
			),
			array(
				'id' => 'typekit-info',
				'type' => 'info',
				'style' => 'warning',
				'desc' => esc_html__("Note: Adobe Typekit is a premium service", 'classiadspro'). __(" ", 'classiadspro'),
				'subtitle' => esc_html__("", 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'typekit-font-family',
				'type' => 'text',
				'title' => esc_html__('Choose a Typekit Font', 'classiadspro'),
				'desc' => esc_html__("Type the name of the font family you have picked from typekit library.", 'classiadspro'),
				'subtitle' => esc_html__("", 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'typekit-element-names',
				'type' => 'text',
				'title' => esc_html__('Add Typekit Elements Class Names.', 'classiadspro'),
				'desc' => esc_html__("Add class names you want the Typekit apply the above font family. Add Class, ID or tag names (e.g. : body, p, #custom-id, .custom-class).", 'classiadspro'),
				'subtitle' => esc_html__("", 'classiadspro'),
				'default' => '',
			),
		),
	));

	 Redux::setSection( $opt_name, array(
		'title' => esc_html__('Skin', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'icon' => 'el-icon-tint',
		'fields' => array(

			array(
				'id' => 'accent-color',
				'type' => 'color',
				'title' => esc_html__('Accent Color', 'classiadspro'),
				'subtitle' => esc_html__('Main color scheme. Choose a vivid and bold color.', 'classiadspro'),
				'default' => '#c32026',
				'validate' => 'color',
			),

			array(
				'id' => 'body-txt-color',
				'type' => 'color',
				'title' => esc_html__('Body text Color', 'classiadspro'),
				'subtitle' => esc_html__('Will affect all texts if no color is defined for them.', 'classiadspro'),
				'default' => '#999999',
				'validate' => 'color',
			),
			array(
				'id' => 'heading-color',
				'type' => 'color',
				'title' => esc_html__('Headings Color', 'classiadspro'),
				'subtitle' => esc_html__('Will affect all headings (h1,h2,h3,h4,h5,h6)', 'classiadspro'),
				'default' => '#333333',
				'validate' => 'color',
			),
			array(
				'id' => 'link-color',
				'type' => 'link_color',
				'title' => esc_html__('Links Color', 'classiadspro'),
				'subtitle' => esc_html__('Will affect all links color.', 'classiadspro'),
				'regular' => true,
				'hover' => true,
				'default' => array(
					'regular' => '#999999',
					'hover' => '',
				)
			),

			array(
				'id' => 'page-title-color',
				'type' => 'color',
				'title' => esc_html__('Page Title', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '#ffffff',
				'validate' => 'color',
			),

			array(
				'id' => 'sidebar-title-color',
				'type' => 'color',
				'title' => esc_html__('Sidebar Widget Title', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '#333333',
				'validate' => 'color',
			),

			array(
				'id' => 'sidebar-txt-color',
				'type' => 'color',
				'title' => esc_html__('Sidebar Widget Texts', 'classiadspro'),
				'subtitle' => esc_html__('Will affect all texts in sidebar widget (unless there is a color value for the specific option in theme styles)', 'classiadspro'),
				'default' => '#999999',
				'validate' => 'color',
			),

			array(
				'id' => 'sidebar-link-color',
				'type' => 'link_color',
				'title' => esc_html__('Sidebar Widget Links', 'classiadspro'),
				'subtitle' => esc_html__('Will affect all links in sidebar section.', 'classiadspro'),
				'regular' => true,
				'hover' => true,
				'default' => array(
					'regular' => '#999999',
					'hover' => '#c32026',
				)
			),

			array(
				'id' => 'footer-title-color',
				'type' => 'color',
				'title' => esc_html__('Footer Widget Title', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '#ffffff',
				'validate' => 'color',
			),

			array(
				'id' => 'footer-txt-color',
				'type' => 'color',
				'title' => esc_html__('Footer Widget Texts', 'classiadspro'),
				'subtitle' => esc_html__('Will affect all texts in footer widget (unless there is a color value for the specific option in theme styles)', 'classiadspro'),
				'default' => '#999999',
				'validate' => 'color',
			),

			array(
				'id' => 'footer-link-color',
				'type' => 'link_color',
				'title' => esc_html__('Footer Widget Links', 'classiadspro'),
				'subtitle' => esc_html__('Will affect all links in footer section.', 'classiadspro'),
				'regular' => true,
				'hover' => true,
				'default' => array(
					'regular' => '#999999',
					'hover' => '#c32026',
				)
			),
			array(
				'id' => 'footer-recent-lisitng-border-color',
				'type' => 'color',
				'title' => esc_html__('Footer recent Posts border Bottom', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'regular' => true,
				'hover' => true,
				'default' => '#999999',
				'validate' => 'color',
			),
			array(
				'id' => 'sub-footer-border-top',
				'type' => 'switch',
				'title' => esc_html__('Show Sub Footer Border Top?', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				"default" => 0,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'sub-footer-border-top-color',
				'type' => 'color_rgba',
				'title' => esc_html__('Sub-Footer border top color', 'classiadspro'),
				'subtitle' => '',
				'color' => '',
				'alpha' => 1,
			),
			array(
				'id' => 'footer-col-border',
				'type' => 'switch',
				'title' => esc_html__('Show Border Right to Footer Collumns?', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'footer-col-border-color',
				'type' => 'color',
				'required' => array('footer-col-border', 'equals', '1'),
				'title' => esc_html__('Footer Collumn Border Color', 'classiadspro'),
				'subtitle' => esc_html__('Will affect all social network icons in sub footer. you can set its active and hover values.', 'classiadspro'),
				'default' => '#2e2e2e',
				'validate' => 'color',
				
			),
			array(
				'id' => 'footer-social-color',
				'type' => 'nav_color',
				'title' => esc_html__('Sub-Footer Social Networks Color', 'classiadspro'),
				'subtitle' => esc_html__('Will affect all social network icons in sub footer. you can set its active and hover values.', 'classiadspro'),
				'regular' => true,
				'hover' => true,
				'bg' => true,
				'bg-hover' => true,
				'default' => array(
					'regular' => '#999999',
					'hover' => '#c32026',
					'bg' => '',
					'bg-hover' => '',
				)
				
			),
			
			array(
				'id' => 'footer-socket-color',
				'type' => 'color',
				'title' => esc_html__('Sub-Footer Copyright Color', 'classiadspro'),
				'subtitle' => esc_html__('Will affect sub footer left side copyright text.', 'classiadspro'),
				'default' => '#999999',
				'validate' => 'color',
			),
			array(
				'id' => 'preloader-txt-color',
				'type' => 'color',
				'title' => esc_html__('Preloader Text Color', 'classiadspro'),
				'subtitle' => esc_html__('Will affect global site preloader text color.', 'classiadspro'),
				'default' => '#ffffff',
				'validate' => 'color',
			),

			array(
				'id' => 'preloader-bg-color',
				'type' => 'color',
				'title' => esc_html__('Preloader Backgroud Color', 'classiadspro'),
				'subtitle' => esc_html__('Will affect global site preloader Background color.', 'classiadspro'),
				'default' => '#333333',
				'validate' => 'color',
			),
			
			array(
				'id' => 'preloader-bar-color',
				'type' => 'color',
				'title' => esc_html__('Preloader Bar Color', 'classiadspro'),
				'subtitle' => esc_html__('Will affect global site preloader Bar color.', 'classiadspro'),
				'default' => '',
				'validate' => 'color',
			),
			array(
				'id' => 'btn-hover',
				'type' => 'color',
				'title' => esc_html__('Buttons hover color', 'classiadspro'),
				'subtitle' => esc_html__('setting will effect all dynamic buttons', 'classiadspro'),
				'default' => '#3e5c92',
				'validate' => 'color',
			),
			array(
				'id' => 'subs-btn-hover',
				'type' => 'color',
				'title' => esc_html__('Subscription Button hover color', 'classiadspro'),
				'subtitle' => esc_html__('setting will effect all dynamic buttons', 'classiadspro'),
				'default' => '#3e5c92',
				'validate' => 'color',
			),
			array(
				'id' => 'breadcrumb-skin',
				'type' => 'select',
				'title' => esc_html__('Breadcrumb Skin', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'options' => array(
					'light' => 'Light',
					'custom' => 'Custom',

				),
				'default' => 'light',
			),
			array(
				'id' => 'breadcrumb-skin-custom',
				'type' => 'nav_color',
				'title' => esc_html__('Breadcrumb Custom Skin Color', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'regular' => true,
				'hover' => true,
				'default' => array(
					'regular' => '#ffffff',
					'hover' => '#ffffff'
				)
			),

			array(
				'id' => 'custom-css',
				'type' => 'ace_editor',
				'title' => esc_html__('Custom CSS', 'classiadspro'),
				'subtitle' => esc_html__('Add some quick css into this box.', 'classiadspro'),
				'desc' => esc_html__('For larger scale css modifications use custom.css file in theme root or consider using a child theme.', 'classiadspro'),
				'mode' => 'css',
				'theme' => 'monokai',
				'default' => "",
			),
			array(
				'id' => 'custom-js',
				'type' => 'ace_editor',
				'title' => esc_html__('Custom JS', 'classiadspro'),
				'subtitle' => esc_html__('Script will be placed in an script tag in document footer', 'classiadspro'),
				'mode' => 'javascript',
				'theme' => 'chrome',
				'desc' => 'For larger scale css modifications js custom.js file in theme root or consider using a child theme.',
				'default' => "",
			),



		),
	));

	 Redux::setSection( $opt_name, array(
		'title' => esc_html__('Backgrounds', 'classiadspro'),
		'desc' => esc_html__('In this section you will customize your website backgrounds.', 'classiadspro'),
		'icon' => 'el-icon-brush',
		'fields' => array(

			array(
				'id' => 'body-layout',
				'type' => 'button_set',
				'title' => esc_html__('Site Layout', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('Boxed layout best works on standart header style.', 'classiadspro'),
				'options' => array('full' => 'Full Width', 'boxed' => 'Boxed'), //Must provide key => value pairs for radio options
				'default' => 'full',
			),

			array(
				'id' => 'body-bg',
				'type' => 'bg_selector',
				'required' => array('body-layout', 'equals', 'boxed'),
				'title' => esc_html__('Body Background', 'classiadspro'),
				'subtitle' => esc_html__('Affects body background Properties, use this option when boxed layout is chosen.', 'classiadspro'),
				'preset' => false,
				'default' => array(
					'url' => '',
					'color' => '#f9fafc',
					'position' => '',
					'repeat' => 'repeat',
					'attachment' => 'scroll',
					'cover' => '',
				)
			),	
			array(
				'id' => 'main-searchbar-bg-color',
				'type' => 'color_rgba',
				
				'title' => esc_html__('Main search bar background color', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => array(
				'color' =>'#f2f4f8',
				'alpha'     => 1,
				)
			),
			
			array(
				'id' => 'main-searchbar-border-color',
				'type' => 'color',
				'title' => esc_html__('Main search bar background color', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '#f2f4f8',
				'validate' => 'color',
			),
			array(
				'id' => 'page-title-bg',
				'type' => 'bg_selector',
				'title' => esc_html__('Page Title Background', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'preset' => false,
				'border' => true,
				'default' => array(
					'url' => '',
					'color' => '#333333',
					'position' => '',
					'repeat' => 'repeat',
					'attachment' => 'scroll',
					'cover' => '',
					'border' => '#333333',
				)
			),

			array(
				'id' => 'page-bg',
				'type' => 'bg_selector',
				'title' => esc_html__('Page Background', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'preset' => false,
				'default' => array(
					'url' => '',
					'color' => '#f9f9f9',
					'position' => '',
					'repeat' => 'repeat',
					'attachment' => 'scroll',
					'cover' => '',
				)
			),

			array(
				'id' => 'footer-bg',
				'type' => 'bg_selector',
				'title' => esc_html__('Footer Background', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'preset' => false,
				'default' => array(
					'url' => '',
					'color' => '#222222',
					'position' => '',
					'repeat' => 'repeat',
					'attachment' => 'scroll',
					'cover' => '',
				)
			),

			array(
				'id' => 'sub-footer-bg',
				'type' => 'color',
				'title' => esc_html__('Sub Footer Background Color', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '#222222',
				'validate' => 'color',
			),
			array(
				'id' => 'top-footer-bg',
				'type' => 'color',
				'title' => esc_html__('Top Footer Background Color', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '#eee',
				'validate' => 'color',
			),

			

		),
	));

	 Redux::setSection( $opt_name, array(
		'title' => esc_html__('Blog', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'icon' => 'el-icon-pencil',
		'fields' => array(

			array(
				'id' => 'page-title-blog',
				'type' => 'switch',
				'title' => esc_html__('Page Title : Blog Posts', 'classiadspro'),
				'subtitle' => esc_html__('This option will affect Blog single posts.', 'classiadspro'),
				'desc' => esc_html__('If you don\'t want to show page title section (title, breadcrumb) in blog single posts disable this option.', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			array(
				'id' => 'blog-featured-image',
				'type' => 'switch',
				'title' => esc_html__('Blog Single Featured image, audio, video ', 'classiadspro'),
				'subtitle' => esc_html__('Will completely disable Featued Image, Video and Audio players from blog single post.', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'blog-image-crop',
				'type' => 'switch',
				'title' => esc_html__('Featured image hard cropping', 'classiadspro'),
				'subtitle' => esc_html__('This option will affect single blog post featrued image.', 'classiadspro'),
				'desc' => esc_html__('If you want to disable automatic image cropping for featured image, disable this option. The original image size will be used. However it will be responsive and fit to container.', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'blog-single-image-height',
				'required' => array('blog-image-crop', 'equals', '1'),
				'type' => 'slider',
				'title' => esc_html__('Single Post Featured Image Height', 'classiadspro'),
				'subtitle' => esc_html__('This height applies to featured image and gallery post type slideshow..', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				"default" => "380",
				"min" => "100",
				"step" => "1",
				"max" => "1000",
			),

			array(
				'id' => 'blog-single-about-author',
				'type' => 'switch',
				'title' => esc_html__('About Author Section', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'blog-single-social-share',
				'type' => 'switch',
				'title' => esc_html__('Blog Single Social Share', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'blog-single-comments',
				'type' => 'switch',
				'title' => esc_html__('Comments', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'archive-layout',
				'type' => 'image_select',
				'title' => esc_html__('Archive Layout', 'classiadspro'),
				'subtitle' => esc_html__('Defines archive loop layout.', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'options' => array(
					'left' => array('alt' => '1 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/left_layout.png'),
					'right' => array('alt' => '2 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/right_layout.png'),
					'full' => array('alt' => '3 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/full_layout.png'),
				),
				'default' => 'right'
			),
			array(
				'id' => 'archive-columns',
				'type' => 'slider',
				'title' => esc_html__('Archive columns', 'classiadspro'),
				'subtitle' => esc_html__('Defines archive loop layout.', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'min' => '1',
				'max' => '4',
				'default' => '2'
			),
			array(
				'id' => 'archive-loop-style',
				'type' => 'select',
				'title' => esc_html__('Archive Loop Style', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'options' => array(
					'tile' => esc_html__('Tile', 'classiadspro'),
					'classic' => esc_html__('Classic', 'classiadspro'),
					'thumb' => esc_html__('Thumb', 'classiadspro'),
					'masonry' => esc_html__('Masonry', 'classiadspro'),
				),
				'default' => 'classic',
			),
			array(
				'id' => 'archive-page-title',
				'type' => 'switch',
				'title' => esc_html__('Archive Loop Page Title', 'classiadspro'),
				'subtitle' => esc_html__('Using this option you can enable/disable page title section (including breadcrumbs)', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

		),
	));

	 Redux::setSection( $opt_name, array(
		'title' => esc_html__('Woocommerce', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'icon' => 'el-icon-shopping-cart',
		'fields' => array(
			array(
				'id' => 'woo-shop-layout',
				'type' => 'image_select',
				'title' => esc_html__('Shop Layout', 'classiadspro'),
				'subtitle' => esc_html__('Defines shop loop layout.', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'options' => array(
					'left' => array('alt' => '1 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/left_layout.png'),
					'right' => array('alt' => '2 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/right_layout.png'),
					'full' => array('alt' => '3 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/full_layout.png'),
				),
				'default' => 'right'
			),

			array(
				'id' => 'woo-loop-thumb-height',
				'type' => 'slider',
				'title' => esc_html__('Product Loop Image Height', 'classiadspro'),
				'subtitle' => esc_html__('Using this option you can change the product loop image height.', 'classiadspro'),
				'desc' => esc_html__('default : 330', 'classiadspro'),
				"default" => "380",
				"min" => "100",
				"step" => "1",
				"max" => "1000",
			),
		    array(
		        "title" => esc_html__("Shop Loop Image Size", 'classiadspro'),
		        "id" => "woo_loop_image_size",
		        "default" => "crop",
		        "options" => array(
		            "crop" => esc_html__("Resize & Crop", 'classiadspro'),
		            "full" => esc_html__("Original Size", 'classiadspro'),
		            "large" => esc_html__("Large Size", 'classiadspro'),
		            "medium" => esc_html__("Medium Size", 'classiadspro'),
		        ),
		        "type" => "select"
		    ),
			array(
				'id' => 'woo-single-thumb-height',
				'type' => 'slider',
				'title' => esc_html__('Single Product Image Height', 'classiadspro'),
				'subtitle' => esc_html__('Using this option you can change the single product image height.', 'classiadspro'),
				'desc' => esc_html__('default : 400', 'classiadspro'),
				"default" => "400",
				"min" => "100",
				"step" => "1",
				"max" => "1000",
			),
		    array(
		        "title" => esc_html__("Shop Single Product Image Size", 'classiadspro'),
		        "id" => "woo_single_image_size",
		        "default" => "crop",
		        "options" => array(
		            "crop" => esc_html__("Resize & Crop", 'classiadspro'),
		            "full" => esc_html__("Original Size", 'classiadspro'),
		            "large" => esc_html__("Large Size", 'classiadspro'),
		            "medium" => esc_html__("Medium Size", 'classiadspro'),
		        ),
		        "type" => "select"
		    ),

			array(
				'id' => 'woo-single-layout',
				'type' => 'image_select',
				'title' => esc_html__('Single Layout', 'classiadspro'),
				'subtitle' => esc_html__('Defines shop single product layout.', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'options' => array(
					'left' => array('alt' => '1 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/left_layout.png'),
					'right' => array('alt' => '2 Column', 'img' => PACZ_THEME_ADMIN_ASSETS_URI . '/img/right_layout.png'),
					'full' => array('alt' => '3 Column', 'img' =>  PACZ_THEME_ADMIN_ASSETS_URI . '/img/full_layout.png'),
				),
				'default' => 'right'
			),

			array(
				'id' => 'checkout-box',
				'type' => 'switch',
				'title' => esc_html__('Header Checkout/Shopping Box', 'classiadspro'),
				'subtitle' => esc_html__('Using This option you can remove header shopping box from header.', 'classiadspro'),
				"default" => 0,
				'on' => 'Enable',
				'off' => 'Disable',
			),
			
			array(
				"title" => esc_html__("Header Checkout/Shopping Box Location", "classiadspro"),
				"desc" => esc_html__("", "classiadspro"),
				'required' => array('checkout-box', 'equals', 1),
				"id" => "checkout-box-location",
				"default" => 'disabled',
				"options" => array(
					"header_toolbar" => esc_html__('Header Toolbar', "classiadspro"),
					"header_section" => esc_html__('Header Section', "classiadspro"),
					"disabled" => esc_html__('Disabled', "classiadspro"),
				),
				"type" => "select"
			),
			
			array(
				'id' => 'checkout-box-align',
				'type' => 'button_set',
				'title' => esc_html__('checkout box align on toolbal', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'options' => array('left' => 'Left', 'right' => 'Right', 'center' => 'Center'), //Must provide key => value pairs for radio options
				'default' => 'right'
			),
			
			array(
				'id' => 'woo-image-quality',
				'type' => 'button_set',
				'title' => esc_html__('Product Loops image quality', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'options' => array('1' => 'Normal Size', '2' => 'Retina Compatible'), //Must provide key => value pairs for radio options
				'default' => '1'
			),

			array(
				'id' => 'woo-single-title',
				'type' => 'switch',
				'title' => esc_html__('Show Product Category as Product Single Title.', 'classiadspro'),
				'subtitle' => esc_html__('If you want to show product category(if multiple only first will be used) as single product page title enable this option. having this option disabled shop page title will be used.', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'woo-single-show-title',
				'type' => 'switch',
				'title' => esc_html__('Woocommerce Single Product Page Title', 'classiadspro'),
				'subtitle' => esc_html__('Using this option you can disable/enable single product page title (including breadcrumbs).', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

			array(
				'id' => 'woo-shop-loop-title',
				'type' => 'switch',
				'title' => esc_html__('Woocommerce Shop Loop Page Title', 'classiadspro'),
				'subtitle' => esc_html__('Using this option you can disable/enable Shop product Loop title (including breadcrumbs).', 'classiadspro'),
				"default" => 1,
				'on' => 'Enable',
				'off' => 'Disable',
			),

		),
	));

	 Redux::setSection( $opt_name, array(
		'title' => esc_html__('Third Party API', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'icon' => 'el-icon-puzzle',
		'fields' => array(
			array(
				'id' => 'gmapapi',
				'type' => 'text',
				'title' => esc_html__('Google maps Api Key', 'classiadspro'),
				'desc' => esc_html__('please generate your own api key to make map work you can generate a key here https://developers.google.com/maps/documentation/javascript/get-api-key', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '',
			),
			array(
				'id' => 'twitter-consumer-key',
				'type' => 'text',
				'title' => esc_html__('Twitter Consumer Key', 'classiadspro'),
				'desc' => __('<ol style="list-style-type:decimal !important;">
					<li>Go to "<a href="https://dev.twitter.com/apps">https://dev.twitter.com/apps</a>," login with your twitter account and click "Create a new application".</li>
					<li>Fill out the required fields, accept the rules of the road, and then click on the "Create your Twitter application" button. You will not need a callback URL for this app, so feel free to leave it blank.</li>
					<li>Once the app has been created, click the "Create my access token" button.</li>
					<li>You are done! You will need the following data later on:</ol>', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'twitter-consumer-secret',
				'type' => 'text',
				'title' => esc_html__('Twitter Consumer Secret', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'twitter-access-token',
				'type' => 'text',
				'title' => esc_html__('Twitter Access Token', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'twitter-access-token-secret',
				'type' => 'text',
				'title' => esc_html__('Twitter Access Token Secret', 'classiadspro'),
				'desc' => esc_html__('', 'classiadspro'),
				'subtitle' => esc_html__('', 'classiadspro'),
				'default' => '',
			),

			array(
				'id' => 'flickr-api-key',
				'type' => 'text',
				'title' => esc_html__('Flickr API Key', 'classiadspro'),
				'desc' => __('You can obtain your API key from <a href="http://www.flickr.com/services/api/misc.api_keys.html">Flickr The App Garden</a>', 'classiadspro'),
				'subtitle' => esc_html__('You will need to fill this field if you want to use flickr widget or shrotcode', 'classiadspro'),
				'default' => '',
			),

		),
	));
	Redux::setSection( $opt_name, array(
		'title' => esc_html__('Manage Theme Speed', 'classiadspro'),
		'desc' => esc_html__('', 'classiadspro'),
		'icon' => 'el-icon-cogs',
		'fields' => array(
			array(
				'id' => 'minify-js',
				'type' => 'switch',
				'title' => esc_html__('Minify Java Script Files', 'classiadspro'),
				'subtitle' => esc_html__('Minifies file to decrease the file size by 40%', 'classiadspro'),
				'desc' => esc_html__('You can enable JS minification using this option. This option will only pickup the pre-minified JS files(theme-scripts-min.js & plugins.js). So use this option if you did not hack the JS files.', 'classiadspro'),
				"default" => false,
			),

			array(
				'id' => 'minify-css',
				'type' => 'switch',
				'title' => esc_html__('Minify CSS Files', 'classiadspro'),
				'subtitle' => esc_html__('Minifies file to decrease the file size by 40%', 'classiadspro'),
				'desc' => esc_html__('You can enable CSS minification using this option. This option will only pickup the pre-minified CSS files. So use this option if you did not hack the CSS files.', 'classiadspro'),
				"default" => false,
			),

			array(
				'id' => 'remove-js-css-ver',
				'type' => 'switch',
				'title' => esc_html__('Remove query string from Static Files', 'classiadspro'),
				'subtitle' => esc_html__('Removes "ver" query string from JS and CSS files.', 'classiadspro'),
				'desc' => __('For More info Please <a href="https://developers.google.com/speed/docs/best-practices/caching#LeverageProxyCaching">Read Here</a>.', 'classiadspro'),
				"default" => true,
			),

		),
	));
     Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'Import / Export', 'classiadspro' ),
        'desc'   => esc_html__( 'Import and Export your Redux Framework settings from file, text or URL.', 'classiadspro' ),
        'icon'   => 'el el-refresh',
        'fields' => array(
            array(
                'id'         => 'opt-import-export',
                'type'       => 'import_export',
                'title'      => 'Import Export',
                'subtitle'   => 'Save and restore your Redux options',
                'full_width' => false,
            ),
        ),
    ));

                 Redux::setSection( $opt_name, array(
                    'type' => 'divide',
                ));

    /*
     * <--- END SECTIONS
     */
	 

