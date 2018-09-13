<?php

global $alsp_wpml_dependent_options;
$alsp_wpml_dependent_options[] = 'alsp_listing_contact_form_7';
$alsp_wpml_dependent_options[] = 'alsp_directory_title';

class alsp_settings_manager {
	public function __construct() {
		add_action('init', array($this, 'plugin_settings'));
		add_action('vp_alsp_option_after_ajax_save', array($this, 'save_option'), 10, 3);
	}
	
	public function plugin_settings() {
		global $alsp_instance, $alsp_social_services, $alsp_maps_styles, $sitepress;

		if ($alsp_instance->index_page_id === 0 && isset($_GET['action']) && $_GET['action'] == 'directory_page_installation') {
			$page = array('post_status' => 'publish', 'post_title' => __('ALSP Listing', 'ALSP'), 'post_type' => 'page', 'post_content' => '[webdirectory]', 'comment_status' => 'closed');
			if (wp_insert_post($page))
				alsp_addMessage(__('"ALSP Listing" page with [webdirectory] shortcode was successfully created, thank you!'));
		}

		$ordering_items = alsp_orderingItems();
		
		$alsp_social_services = array(
			'facebook' => array('value' => 'facebook', 'label' => __('Facebook', 'ALSP')),
			'twitter' => array('value' => 'twitter', 'label' => __('Twitter', 'ALSP')),
			'google' => array('value' => 'google', 'label' => __('Google', 'ALSP')),
			'linkedin' => array('value' => 'linkedin', 'label' => __('LinkedIn', 'ALSP')),
			'digg' => array('value' => 'digg', 'label' => __('Digg', 'ALSP')),
			'reddit' => array('value' => 'reddit', 'label' => __('Reddit', 'ALSP')),
			'pinterest' => array('value' => 'pinterest', 'label' => __('Pinterest', 'ALSP')),
			'tumblr' => array('value' => 'tumblr', 'label' => __('Tumblr', 'ALSP')),
			'stumbleupon' => array('value' => 'stumbleupon', 'label' => __('StumbleUpon', 'ALSP')),
			'vk' => array('value' => 'vk', 'label' => __('VK', 'ALSP')),
			'email' => array('value' => 'email', 'label' => __('Email', 'ALSP')),
		);

		$listings_tabs = array(
				array('value' => 'addresses-tab', 'label' => __('Addresses tab', 'ALSP')),
				array('value' => 'comments-tab', 'label' => __('Comments tab', 'ALSP')),
				array('value' => 'videos-tab', 'label' => __('Videos tab', 'ALSP')),
				array('value' => 'contact-tab', 'label' => __('Contact tab', 'ALSP')));
		foreach ($alsp_instance->content_fields->content_fields_groups_array AS $fields_group)
			if ($fields_group->on_tab)
				$listings_tabs[] = array('value' => 'field-group-tab-'.$fields_group->id, 'label' => $fields_group->name);
			
		$map_styles = array(array('value' => 'default', 'label' => 'Default style'));
		foreach ($alsp_maps_styles AS $name=>$style)
			$map_styles[] = array('value' => $name, 'label' => $name);
		
	}
}
// adapted for WPML
function alsp_get_wpml_dependent_option_name($option) {
	global $alsp_wpml_dependent_options, $sitepress;

	if (in_array($option, $alsp_wpml_dependent_options))
		if (function_exists('wpml_object_id_filter') && $sitepress)
			if ($sitepress->get_default_language() != ICL_LANGUAGE_CODE)
				if (get_option($option.'_'.ICL_LANGUAGE_CODE) !== false)
					return $option.'_'.ICL_LANGUAGE_CODE;

	return $option;
}
function alsp_get_wpml_dependent_option($option) {
	global $ALSP_ADIMN_SETTINGS;
	return $ALSP_ADIMN_SETTINGS[alsp_get_wpml_dependent_option_name($option)];
}
function alsp_get_wpml_dependent_option_description() {
	global $sitepress;
	return ((function_exists('wpml_object_id_filter') && $sitepress) ? sprintf(__('%s This is multilingual option, each language may have own value.', 'ALSP'), '<br /><img src="'.ALSP_RESOURCES_URL . 'images/multilang.png" /><br />') : '');
}

