<?php

extract( shortcode_atts( array(
			'offers_title' => 'Offers',
			'offers' => '',
			'table_number' => 4,
			'tables' => '',
			'orderby'=> 'date',
			'order'=> 'DESC',
			'skin' => 'light', // dark, light
			'style' => 'classic',
			'modern_bg_color' => '',
			'el_class' =>'',
			'animation' => '',
		), $atts ) );

$query = array(
	'post_type'=>'pricing',
	'showposts' => $table_number,
);

if ( $tables ) {
	$query['post__in'] = explode( ',', $tables );
}
if ( $orderby ) {
	$query['orderby'] = $orderby;
}
if ( $order ) {
	$query['order'] = $order;
}


	if ( $table_number == 4 ) {
		$table_css = 'four-table';
	} else if ( $table_number == 3 ) {
		$table_css = 'three-table';
	} else if ( $table_number == 2 ) {
		$table_css = 'two-table';
	} else if ( $table_number == 1 ) {
		$table_css = 'one-table';
	}

$r = new WP_Query( $query );
global $post,
$pacz_accent_color;



$animation_css = ( $animation != '' ) ? ' pacz-animate-element ' . $animation . ' ' : '';
$has_offer = ( strlen( $content ) > 5 ) ? 'has-pricing-offer' : '';




$output = '<div class="pacz-shortcode pacz-pricing-table '.$has_offer.' '.$skin.' '.$style.'-style '.$el_class.'">';
if ( strlen( $content ) > 5 ) {
	$output .= '<div class="pacz-pricing-offer-grid">';
	$output .= '<div class="pacz-offers">'.wpb_js_remove_wpautop( $content ).'</div>';
	$output .= '</div>';
}
$output .= '<ul class="pacz-pricing-cols">';
while ( $r->have_posts() ) : $r->the_post();

$featured = get_post_meta( $post->ID, 'featured', true );
if ( $featured == 'true' ) {
	$featured_css = 'featured-plan';
}

$featured_css = ($featured == 'true') ? 'featured-plan' : '';
$column_skin = get_post_meta( $post->ID, 'skin', true );
$skin_color = (!empty($column_skin)) ? $column_skin : $pacz_accent_color;
$pricing_bg = ($style == 'classic') ? 'style="background-color:'.pacz_convert_rgba($skin_color, 0.6).';"' : 'style="background-color:'.$skin_color.';"';
$button_skin = ($skin == 'dark') ? ' outline_skin="#ffffff" outline_hover_skin="#444444" ' : ' outline_skin="#6e6c69" outline_hover_skin="#ffffff" ';


$output .= '<li class="pacz-pricing-col '.$featured_css.' '.$table_css.$animation_css.'">';
$output .='<div class="pacz-pricing-plan">'.get_the_title().'</div>';
$output .='<div class="pacz-pricing-price" '.$pricing_bg.'><span>'.get_post_meta( $post->ID, '_price', true ).'</span></div>';
$output .='<div class="pacz-pricing-features">'.get_post_meta( $post->ID, '_features', true ).'</div>';
$output .='<div class="pacz-pricing-button">
                        '.do_shortcode( '[pacz_button style="outline" outline_border_width="2" '.$button_skin.' size="medium" target="_self" align="center" url="'.get_post_meta( $post->ID, '_btn_url', true ).'"]'.get_post_meta( $post->ID, '_btn_text', true ).'[/pacz_button]' ).'
                  </div>';
$output .='</li>';

endwhile;
$output .= '</ul></div>';

wp_reset_postdata();
echo '<div>'.$output.'</div>';
