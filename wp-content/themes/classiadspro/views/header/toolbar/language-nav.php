<?php

/**
 * Template part for header toolbar WPML/Polylang Language Switcher. views/header/toolbar
 *
 * @author Artbees
 * @package jupiter/views
 * @since 5.0.0
 * @since 5.9.3 Renamed file.
 */

$languages = icl_get_languages( 'skip_missing=0&orderby=id' );
$output    = '';

if ( is_array( $languages ) ) {

	$output .= '<div class="mk-language-nav"><a href="#">' . Mk_SVG_Icons::get_svg_icon_by_class_name( false, 'mk-icon-globe', 16 ) . __( 'Languages', 'mk_framework' ) . '</a>';
	$output .= '<div class="mk-language-nav-sub-wrapper"><div class="mk-language-nav-sub">';
	$output .= "<ul class='mk-language-navigation'>";

	foreach ( $languages as $lang ) {
		$output .= "<li class='language_" . esc_attr( $lang['language_code'] ) . "'><a href='" . esc_url( $lang['url'] ) . "'>";
		$output .= "<span class='mk-lang-flag'><img title='" . esc_attr( $lang['native_name'] ) . "' src='" . esc_url( $lang['country_flag_url'] ) . "' /></span>";
		$output .= "<span class='mk-lang-name'>" . esc_html( $lang['native_name'] ) . '</span>';
		$output .= '</a></li>';
	}

	$output .= '</ul></div></div></div>';
}

echo $output;
