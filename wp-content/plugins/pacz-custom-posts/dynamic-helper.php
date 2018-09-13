<?php
function classiadspro_head_hook(){
	global $classiadspro_shortcode_order, $is_header_shortcode_added;

}

add_action('wp_head', 'classiadspro_head_hook', 1);



/**
 * Collect Shortcode dynamic styles and using javascript inject them to <head>
 */
if (!function_exists('classiadspro_dynamic_styles')) {
    function classiadspro_dynamic_styles() {
	global $app_dynamic_styles;
	
	$post_id = global_get_post_id();

	$saved_styles = get_post_meta($post_id, '_dynamic_styles', true);
	
	$saved_styles_build = get_post_meta($post_id, '_theme_options_build', true);
	$theme_option_build = get_option(CLASSIADSPRO_THEME_OPTIONS_BUILD);

	$styles =  unserialize(base64_decode(get_post_meta($post_id, '_dynamic_styles', true)));

	if (empty($styles)) {
		$css = '';
		if(is_array($app_dynamic_styles) && !empty($app_dynamic_styles)) {
	        foreach ($app_dynamic_styles as $style) {
	            $css .= $style['inject'];
	        }
    	}
        $css = preg_replace('/\r|\n|\t/', '', $css);
        echo "<style type='text/css'>" . $css . "</style>";
    }

	if(empty($saved_styles) || $saved_styles_build != $theme_option_build) {
		update_post_meta($post_id, '_dynamic_styles', base64_encode(serialize(($app_dynamic_styles))));
		update_post_meta($post_id, '_theme_options_build', $theme_option_build);
	}
    }
    
    //Apply custom styles before runing other javascripts as they might be based on those styles as well. So setting priority as one!
    add_action('wp_footer', 'classiadspro_dynamic_styles', 1);
}