<?php 

$alsp_color_schemes = array(
		/*'default' => array(
				'alsp_links_color' => '#2393ba',
				'alsp_links_hover_color' => '#2a6496',
				'alsp_button_1_color' => '#2393ba',
				'alsp_button_2_color' => '#1f82a5',
				'alsp_button_text_color' => '#FFFFFF',
				'alsp_search_1_color' => '#bafefe',
				'alsp_search_2_color' => '#47c6c6',
				'alsp_search_text_color' => '#FFFFFF',
				'alsp_categories_1_color' => '#CEE6F3',
				'alsp_categories_2_color' => '#DEEEF7',
				'alsp_categories_text_color' => '#2393ba',
				'alsp_locations_1_color' => '#CEE6F3',
				'alsp_locations_2_color' => '#DEEEF7',
				'alsp_locations_text_color' => '#2393ba',
				'alsp_primary_color' => '#111111',
				'alsp_featured_color' => '#e1ffff',
				'alsp_jquery_ui_schemas' => 'redmond',
		),*/
		
);
global $alsp_color_schemes;

/* foreach ($alsp_color_schemes['default'] AS $setting_name=>$setting_value) {
	$func_name = 'alsp_affect_setting_' . $setting_name;
	eval("function $func_name(\$scheme) { global \$alsp_color_schemes; return \$alsp_color_schemes[\$scheme]['$setting_name']; }");
	VP_ALSP_Security::instance()->whitelist_function($func_name);
} */

function alsp_affect_setting_alsp_links_color($scheme) {
	global $alsp_color_schemes;
	return $alsp_color_schemes[$scheme]['alsp_links_color'];
}
VP_ALSP_Security::instance()->whitelist_function('alsp_affect_setting_alsp_links_color');

function alsp_affect_setting_alsp_links_hover_color($scheme) {
	global $alsp_color_schemes;
	return $alsp_color_schemes[$scheme]['alsp_links_hover_color'];
}
VP_ALSP_Security::instance()->whitelist_function('alsp_affect_setting_alsp_links_hover_color');

function alsp_affect_setting_alsp_button_1_color($scheme) {
	global $alsp_color_schemes;
	return $alsp_color_schemes[$scheme]['alsp_button_1_color'];
}
VP_ALSP_Security::instance()->whitelist_function('alsp_affect_setting_alsp_button_1_color');

function alsp_affect_setting_alsp_button_2_color($scheme) {
	global $alsp_color_schemes;
	return $alsp_color_schemes[$scheme]['alsp_button_2_color'];
}
VP_ALSP_Security::instance()->whitelist_function('alsp_affect_setting_alsp_button_2_color');

function alsp_affect_setting_alsp_button_text_color($scheme) {
	global $alsp_color_schemes;
	return $alsp_color_schemes[$scheme]['alsp_button_text_color'];
}
VP_ALSP_Security::instance()->whitelist_function('alsp_affect_setting_alsp_button_text_color');

function alsp_affect_setting_alsp_search_1_color($scheme) {
	global $alsp_color_schemes;
	return $alsp_color_schemes[$scheme]['alsp_search_1_color'];
}
VP_ALSP_Security::instance()->whitelist_function('alsp_affect_setting_alsp_search_1_color');

function alsp_affect_setting_alsp_search_2_color($scheme) {
	global $alsp_color_schemes;
	return $alsp_color_schemes[$scheme]['alsp_search_2_color'];
}
VP_ALSP_Security::instance()->whitelist_function('alsp_affect_setting_alsp_search_2_color');

function alsp_affect_setting_alsp_search_text_color($scheme) {
	global $alsp_color_schemes;
	return $alsp_color_schemes[$scheme]['alsp_search_text_color'];
}
VP_ALSP_Security::instance()->whitelist_function('alsp_affect_setting_alsp_search_text_color');

function alsp_affect_setting_alsp_categories_1_color($scheme) {
	global $alsp_color_schemes;
	return $alsp_color_schemes[$scheme]['alsp_categories_1_color'];
}
VP_ALSP_Security::instance()->whitelist_function('alsp_affect_setting_alsp_categories_1_color');

function alsp_affect_setting_alsp_categories_2_color($scheme) {
	global $alsp_color_schemes;
	return $alsp_color_schemes[$scheme]['alsp_categories_2_color'];
}
VP_ALSP_Security::instance()->whitelist_function('alsp_affect_setting_alsp_categories_2_color');

function alsp_affect_setting_alsp_categories_text_color($scheme) {
	global $alsp_color_schemes;
	return $alsp_color_schemes[$scheme]['alsp_categories_text_color'];
}
VP_ALSP_Security::instance()->whitelist_function('alsp_affect_setting_alsp_categories_text_color');

function alsp_affect_setting_alsp_locations_1_color($scheme) {
	global $alsp_color_schemes;
	return $alsp_color_schemes[$scheme]['alsp_locations_1_color'];
}
VP_ALSP_Security::instance()->whitelist_function('alsp_affect_setting_alsp_locations_1_color');

function alsp_affect_setting_alsp_locations_2_color($scheme) {
	global $alsp_color_schemes;
	return $alsp_color_schemes[$scheme]['alsp_locations_2_color'];
}
VP_ALSP_Security::instance()->whitelist_function('alsp_affect_setting_alsp_locations_2_color');

function alsp_affect_setting_alsp_locations_text_color($scheme) {
	global $alsp_color_schemes;
	return $alsp_color_schemes[$scheme]['alsp_locations_text_color'];
}
VP_ALSP_Security::instance()->whitelist_function('alsp_affect_setting_alsp_locations_text_color');

function alsp_affect_setting_alsp_primary_color($scheme) {
	global $alsp_color_schemes;
	return $alsp_color_schemes[$scheme]['alsp_primary_color'];
}
VP_ALSP_Security::instance()->whitelist_function('alsp_affect_setting_alsp_primary_color');

function alsp_affect_setting_alsp_featured_color($scheme) {
	global $alsp_color_schemes;
	return $alsp_color_schemes[$scheme]['alsp_featured_color'];
}
VP_ALSP_Security::instance()->whitelist_function('alsp_affect_setting_alsp_featured_color');

function alsp_affect_setting_alsp_jquery_ui_schemas($scheme) {
	global $alsp_color_schemes;
	return $alsp_color_schemes[$scheme]['alsp_jquery_ui_schemas'];
}
VP_ALSP_Security::instance()->whitelist_function('alsp_affect_setting_alsp_jquery_ui_schemas');

function alsp_get_dynamic_option($option_name) {
	global $alsp_color_schemes;

	if (isset($_COOKIE['alsp_compare_palettes']) && $_COOKIE['alsp_compare_palettes']) {
		$scheme = $_COOKIE['alsp_compare_palettes'];
		if (isset($alsp_color_schemes[$scheme][$option_name]))
			return $alsp_color_schemes[$scheme][$option_name];
		else 
			return get_option($option_name);
	} else
		return get_option($option_name);
}

?>