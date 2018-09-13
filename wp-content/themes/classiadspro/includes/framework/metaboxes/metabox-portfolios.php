<?php

$config  = array(
  'title' => sprintf( '%s Portfolio Options', PACZ_THEME_NAME ),
  'id' => 'pacz-metaboxes-tabs',
  'pages' => array(
    'portfolio'
  ),
  'callback' => '',
  'context' => 'normal',
  'priority' => 'core'
);
$options = array(

   /* array(
    "name" => esc_html__( "Page Elements", "classiadspro" ),
    "subtitle" => esc_html__( "", "classiadspro" ),
      "desc" => esc_html__( "Depending on your need you can change this page's general layout", "classiadspro" ),
    "id" => "_template",
    "default" => '',
    "placeholder" => 'true',
    "width" => 400,
    "options" => array(
          "no-header" => esc_html__('Remove Header', "classiadspro"),
          "no-title" => esc_html__('Remove Page Title', "classiadspro"),
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
*/
 /* array(
    "name" => esc_html__("Stick Template?", "classiadspro" ),
        "subtitle" => esc_html__( "If enabled this option page will have no padding after header and before footer.", "classiadspro" ),
    "desc" => esc_html__( "Use this option if you need to use header slideshow or use a callout box before footer.", "classiadspro" ),
    "id" => "_padding",
    "default" => 'false',
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
    /*  array(
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
        "default" => "120",
        "min" => "0",
        "max" => "5000",
        "step" => "1",
        "unit" => 'px',
        "type" => "range"
    ),

  array(
    "name" => esc_html__( "Portfolio Loop Overlay Logo", "classiadspro" ),
    "subtitle" => esc_html__( "Optionally you can upload a logo to appear on portfolio loop images.", "classiadspro" ),
    "desc" => esc_html__( "Its width should not be larger than 300px and height relative to the loop image heights. so try to adjust it as you need.", "classiadspro" ),
    "id" => "_portfolio_item_logo",
    "preview" => true,
    "default" => "",
    "type" => "upload"
  ),
*/
  array(
    "name" => esc_html__( "Gallery Images", "classiadspro" ),
    "subtitle" => esc_html__( "Add Images for the gallery post type", "classiadspro" ),
    "desc" => esc_html__( "You can re-arrange images by drag and drop as well as deleting images.", "classiadspro" ),
    "id" => "_gallery_images",
    "default" => '',
    "type" => "gallery"
  ),


  array(
    "name" => esc_html__( "Video URL", "classiadspro" ),
    "subtitle" => esc_html__( "URL to the video site to feed from.", "classiadspro" ),
    "desc" => esc_html__( "", "classiadspro" ),
    "id" => "_video_url",
    "type" => "text"
  ),

  array(
    "name" => esc_html__( "Upload MP3 File", "classiadspro" ),
    "desc" => esc_html__( "Upload MP3 your file or paste the full URL for external files. This file formate needed for Safari, Internet Explorer, Chrome. ", "classiadspro" ),
    "id" => "_mp3_file",
    "preview" => false,
    "default" => "",
    "type" => "upload"
  ),

  array(
    "name" => esc_html__( "Upload OGG File", "classiadspro" ),
    "desc" => esc_html__( "Upload OGG your file or paste the full URL for external files. This file formate needed for Firefox, Opera, Chrome. ", "classiadspro" ),
    "id" => "_ogg_file",
    "preview" => false,
    "default" => "",
    "type" => "upload"
  ),


  array(
    "name" => esc_html__( "Ajax Description", "classiadspro" ),
    "desc" => esc_html__( "You are allowed to use HTML tags as well as shortcodes.", "classiadspro" ),
    "subtitle" => esc_html__( "Short description for ajax content. This content will be shown if you have enabled ajax feature for your portfolio loop.", "classiadspro" ),
    "id" => "_portfolio_short_desc",
    "default" => '',
    "type" => "editor"
  ),

/*

  array(
    "name" => esc_html__( "Masonry Image size", "classiadspro" ),
    "desc" => esc_html__( "Make your hand picked image sizes.", "classiadspro" ),
    "subtitle" => esc_html__( "Masonry loop style image size.", "classiadspro" ),
    "id" => "_masonry_img_size",
    "default" => 'two_x_two_x',
    "width" => 250,
    "options" => array(
      //"regular" => 'Regular',
      //"wide" => 'Wide',
      //"tall" => 'Tall',
      //"wide_tall" => 'Wide & Tall',
      "x_x" => esc_html__('X * X', 'classiadspro'),
      "two_x_x" => esc_html__('2X * X', 'classiadspro'),
      "three_x_x" => esc_html__('3X * X', 'classiadspro'),
      "four_x_x" => esc_html__('4X * X', 'classiadspro'),
      "x_two_x" => esc_html__('X * 2X', 'classiadspro'),
      "two_x_two_x" => esc_html__('2X * 2X (Regular)', 'classiadspro'),
      "two_x_four_x" => esc_html__('2X * 4X (Tall)', 'classiadspro'),
      "three_x_two_x" => esc_html__('3X * 2X', 'classiadspro'),
      "four_x_two_x" => esc_html__('4X * 2X (Wide)', 'classiadspro'),
      "four_x_four_x" => esc_html__('4X * 4X (Wide & Tall)', 'classiadspro'),
    ),
    "type" => "select"
  ),
*/
  array(
    "name" => esc_html__( "Show Featured Image in Single Post?", "classiadspro" ),
    "desc" => esc_html__( "Please note that this option will disable featured image, video player (when video post type chosen) and gallery slideshow (when gallery post type chosen).", "classiadspro" ),
    "id" => "_single_featured",
    "default" => "true",
    "type" => "toggle"
  ),


  array(
    "name" => esc_html__( "Custom URL", "classiadspro" ),
    "desc" => esc_html__( "If you may choose to change the permalink to a page, post or external URL. If left empty the single post permalink will be used instead.", "classiadspro" ),
    "subtitle" => esc_html__( "External link other than the single post.", "classiadspro" ),
    "id" => "_portfolio_permalink",
    "default" => "",
    "type" => "superlink"
  ),

  /*array(
    "name" => esc_html__( "Previous & Next Arrows?", "classiadspro" ),
    "desc" => esc_html__( "Using this option you can turn on/off the navigation arrows when viewing the portfolio single page.", "classiadspro" ),
    "id" => "_portfolio_meta_next_prev",
    "default" => "true",
    "type" => "toggle"
  ),*/

  /*array(
    "name" => esc_html__( "Related Projects?", "classiadspro" ),
    "desc" => esc_html__( "", "classiadspro" ),
    "id" => "_portfolio_related_project",
    "default" => "false",
    "type" => "toggle"
  ),*/

);
new pacz_metaboxesGenerator( $config, $options );
