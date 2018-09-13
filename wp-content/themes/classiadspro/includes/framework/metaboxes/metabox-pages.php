<?php
$config  = array(
    'title' => sprintf('%s Page Options', PACZ_THEME_NAME),
    'id' => 'pacz-page-metabox',
    'pages' => array(
        'page'
    ),
    'callback' => '',
    'context' => 'normal',
    'priority' => 'core'
);
$options = array(
    array(
        "name" => esc_html__("Page Elements", "classiadspro"),
        "subtitle" => esc_html__("", "classiadspro"),
        "desc" => esc_html__("Depending on your need you can change this page's general layout", "classiadspro"),
        "id" => "_template",
        "default" => 'pagetitle-on',
        "placeholder" => 'true',
        "width" => 400,
        "options" => array(
          "no-header" => esc_html__('Remove Header', "classiadspro"),
          "no-title" => esc_html__('No Page Title', "classiadspro"),
		  "pagetitle-on" => esc_html__('Page Title on', "classiadspro"),
          "no-header-title" => esc_html__('Remove Header & Page Title', "classiadspro"),
          "no-title-footer" => esc_html__('Remove Page Title & Footer', "classiadspro"),
          "no-title-sub-footer" => esc_html__('Remove Page Title & Sub Footer', "classiadspro"),
          "no-title-footer-sub-footer" => esc_html__('Remove Page Title & Footer & Sub Footer', "classiadspro"),
          "no-footer-only" => esc_html__('Remove Footer', "classiadspro"),
          "no-sub-footer" => esc_html__('Remove Sub Footer', "classiadspro"),
          "no-footer" => esc_html__('Remove Footer & Sub Footer', "classiadspro"),
          "no-footer-title" => esc_html__('Remove Footer & Page Title', "classiadspro"),
          "no-sub-footer-title" => esc_html__('Remove Footer & Sub Footer & Page Title', "classiadspro"),
          "no-header-footer" => esc_html__('Remove Header & Footer & Sub Footer', "classiadspro"),
          "no-header-title-only-footer" => esc_html__('Remove Header & Page Title & Footer', "classiadspro"),
          "no-header-title-footer" => esc_html__('Remove Header & Page Title & Footer & Sub Footer', "classiadspro")
        ),
        "type" => "select"
    ),

   array(
        "name" => esc_html__("Stick Template?", "classiadspro"),
        "subtitle" => esc_html__("If enabled this option page will have no padding after header and before footer.", "classiadspro"),
        "desc" => esc_html__("Use this option if you need to use header slideshow or use a callout box before footer.", "classiadspro"),
        "id" => "_padding",
        "default" => 'true',
        "type" => "toggle"
    ),
    array(
        "name" => esc_html__("Header Toolbar?", "classiadspro"),
        "subtitle" => esc_html__("", "classiadspro"),
        "desc" => esc_html__("", "classiadspro"),
        "id" => "_header_toolbar",
        "default" => 'true',
        "type" => "toggle"
    ),
    array(
        "name" => esc_html__("Breadcrumb", "classiadspro"),
        "subtitle" => esc_html__("If you dont want to show breadcrumb disable this option.", "classiadspro"),
        "desc" => esc_html__("Breadcrumb is useful for SEO purposes and helps your site visitors to know where exactly they are relative to your sitemap from homepage. So its also good for UX.", "classiadspro"),
        "id" => "_breadcrumb",
        "default" => 'false',
        "type" => "toggle"
    ),
    array(
        "name" => esc_html__("Page Pre-loader", "classiadspro"),
        "subtitle" => esc_html__("adds a preloading overlay until the page is ready to be viewed.", "classiadspro"),
        "desc" => esc_html__("Please use this option when your have alot of images, slideshows and content.", "classiadspro"),
        "id" => "_preloader",
        "default" => 'false',
        "type" => "toggle"
    ),
    array(
        "name" => esc_html__("Header Style", "classiadspro"),
        "subtitle" => esc_html__("Defines how header appear in top.", "classiadspro"),
        "desc" => esc_html__("", "classiadspro"),
        "id" => "_header_style",
        "default" => 'block',
        "placeholder" => 'true',
        "width" => 400,
        "options" => array(
            "block" => esc_html__('Block module', "classiadspro"),
            "transparent" => esc_html__('Transparent Layer', "classiadspro")
        ),
        "type" => "select"
    ),
    array(
        "name" => esc_html__("Transparent Header Style Skin", "classiadspro"),
        "subtitle" => esc_html__("", "classiadspro"),
        "desc" => esc_html__("", "classiadspro"),
        "id" => "_trans_header_skin",
        "default" => 'light',
        "placeholder" => 'false',
        "width" => 400,
        "options" => array(
            "light" => esc_html__('Light', "classiadspro"),
            "dark" => esc_html__('Dark', "classiadspro")
        ),
        "type" => "select"
    ),
    array(
        "name" => esc_html__("Transparent Header Style Sticky Scroll Offset", "classiadspro"),
        "subtitle" => esc_html__("", "classiadspro"),
        "desc" => esc_html__("zero means window height which is relative to the device screen height. any value bigger than 0 will set the sticky header to user defined value.", "classiadspro"),
        "id" => "_trans_header_offset",
        "default" => "1",
        "min" => "0",
        "max" => "5000",
        "step" => "1",
        "unit" => 'px',
        "type" => "range"
    ),
    array(
        "name" => esc_html__("Main Navigation Location", "classiadspro"),
        "subtitle" => esc_html__("Choose which menu location to be used in this page.", "classiadspro"),
        "desc" => esc_html__("If left blank, Primary Menu will be used. You should first create menu and then assign to menu locations  by goining to appearence then menu", "classiadspro"),
        "id" => "_menu_location",
        "default" => '',
        "placeholder" => 'true',
        "width" => 400,
        "options" => array(
            "primary-menu" => esc_html__('Primary Navigation', "classiadspro"),
            "second-menu" => esc_html__('Second Navigation', "classiadspro"),
            "third-menu" => esc_html__('Third Navigation', "classiadspro"),
            "fourth-menu" => esc_html__('Fourth Navigation', "classiadspro"),
            "fifth-menu" => esc_html__('Fifth Navigation', "classiadspro"),
            "sixth-menu" => esc_html__('Sixth Navigation', "classiadspro"),
            "seventh-menu" => esc_html__('Seventh Navigation', "classiadspro")
        ),
        "type" => "select"
    ),
   /* array(
        "name" => esc_html__("Quick Contact", "classiadspro"),
        "subtitle" => esc_html__("You can enable or disable Quick Contact Form using this option.", "classiadspro"),
        "desc" => esc_html__("", "classiadspro"),
        "id" => "_quick_contact",
        "default" => 'global',
        "placeholder" => 'true',
        "width" => 400,
        "options" => array(
            "global" => esc_html__('Override from Theme Settings', "classiadspro"),
            "enabled" => esc_html__('Enabled', "classiadspro"),
            "disabled" => esc_html__('Disabled', "classiadspro"),
        ),
        "type" => "select"
    ),
    array(
        "name" => esc_html__("Quick Contact Skin", "classiadspro"),
        "subtitle" => esc_html__("", "classiadspro"),
        "desc" => esc_html__("", "classiadspro"),
        "id" => "_quick_contact_skin",
        "default" => 'dark',
        "placeholder" => 'false',
        "width" => 400,
        "options" => array(
            "light" => esc_html__('Light', "classiadspro"),
            "dark" => esc_html__('Dark', "classiadspro")
        ),
        "type" => "select"
    ),*/
  
);
new pacz_metaboxesGenerator($config, $options);
