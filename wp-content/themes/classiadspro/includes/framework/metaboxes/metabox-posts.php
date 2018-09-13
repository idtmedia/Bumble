<?php

$config  = array(
  'title' => sprintf( '%s Posts Options', PACZ_THEME_NAME ),
  'id' => 'pacz-metaboxes-tabs',
  'pages' => array(
    'post'
  ),
  'callback' => '',
  'context' => 'normal',
  'priority' => 'core'
);
$options = array(

  array(
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

  array(
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

  array(
    "name" => esc_html__("Featured Image?", "classiadspro" ),
    "subtitle" => esc_html__( "", "classiadspro" ),
    "desc" => esc_html__( "If you do not want to set a featured image (in case of sound post type : Audio player, in case of video post type : Video Player) kindly disable it here.", "classiadspro" ),
    "id" => "_featured_image",
    "default" => 'true',
    "type" => "toggle"
  ),

  array(
    "name" => esc_html__("Show Meta?", "classiadspro" ),
    "subtitle" => esc_html__( "", "classiadspro" ),
    "desc" => esc_html__( "If you do not want to set a metabox kindly disable it here.", "classiadspro" ),
    "id" => "_meta",
    "default" => 'true',
    "type" => "toggle"
  ),

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
    "name" => esc_html__( "Soundcloud", "classiadspro" ),
    "desc" => esc_html__( "You can get both iframe or shortcode for wordpress from soundcould share=>embed popup. both formats are acceptable.", "classiadspro" ),
    "subtitle" => esc_html__( "Paste embed iframe or Wordpress shortcode.", "classiadspro" ),
    "id" => "_audio_iframe",
    "preview" => false,
    "default" => "",
    "type" => "textarea"
  )
);
new pacz_metaboxesGenerator( $config, $options );
