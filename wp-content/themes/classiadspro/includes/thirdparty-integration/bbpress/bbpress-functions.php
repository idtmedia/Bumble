<?php


if(!is_admin()){ add_action('bbp_enqueue_scripts', 'pacz_bbpress_register_assets',15); }


function pacz_bbpress_register_assets() {

	 wp_dequeue_style('bbp-default');
	wp_enqueue_style( 'pacz-theme-bbpress', PACZ_THEME_DIR_URI.'/includes/thirdparty-integration/bbpress/bbpress.css');
}



add_filter('bbp_get_topic_class', 'pacz_bbpress_add_topic_class');
function pacz_bbpress_add_topic_class($classes)
{
	$voices = bbp_get_topic_voice_count() > 1 ? "multi" : "single";

	$classes[] = 'topic-voices-'.$voices;
	return $classes;
}


add_filter('bbp_get_single_forum_description', 'pacz_bbpress_filter_form_message',10,2 );
add_filter('bbp_get_single_topic_description', 'pacz_bbpress_filter_form_message',10,2 );



function pacz_bbpress_filter_form_message( $retstr, $args )
{
	return false;
}


add_filter( 'bbp_no_breadcrumb', '__return_true' );
