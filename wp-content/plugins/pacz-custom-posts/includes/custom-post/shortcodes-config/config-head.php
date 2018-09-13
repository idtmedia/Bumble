<?php
/**
 * WPBakery Visual Composer Shortcodes settings
 *
 * @package VPBakeryVisualComposer
 *
 */


$posts = $categories = $pages =  $testimonials = $clients = $portfolio_posts = $sharp_posts = $tab_posts = $employees = $causes = $events = $pricing = $animated_columns = $infinite_animation =  $pacz_awesome_icons_list = $pacz_orderby = $pacz_product_orderby = $pacz_product_categories_orderby = $device_visibility = $css_animations = $product_cats = array();


global $pacz_settings;

$skin_color = $pacz_settings['accent-color'];

$target_arr = array( esc_html__( "Same window", "pacz" ) => "_self", esc_html__( "New window", "pacz" ) => "_blank" );


$add_device_visibility = array(
    "type" => "dropdown",
    "heading" => esc_html__("Visibility For devices", "pacz"),
    "param_name" => "visibility",
    "value" => array(
        "All" => '',
        "Hidden on Phones" => "hidden-sm",
        "Hidden on Tablets" => "hidden-tl",
        "Hidden on Desktops" => "hidden-dt",
        "Visible on Phones" => "visible-sm",
        "Visible on Tablets" => "visible-tl",
        "Visible on Desktops" => "visible-dt"
    ),
    "description" => esc_html__("You can make this element invisible for a particular device (screen resolution) or set it to All to be visible for all devices.", "pacz")
);



if(is_admin()) {

$pricing_entries = get_posts( 'post_type=pricing&orderby=title&numberposts=-1&order=ASC&suppress_filters=0' );
if ( $pricing_entries != null && !empty( $pricing_entries ) ) {
    foreach ( $pricing_entries as $key => $entry ) {
        $pricing[$entry->ID] = $entry->post_title;
    }
}
$employees_entries = get_posts( 'post_type=employees&orderby=title&numberposts=-1&order=ASC&suppress_filters=0' );

if ( $employees_entries != null && !empty( $employees_entries ) ) {
    foreach ( $employees_entries as $key => $entry ) {
        $employees[$entry->ID] = $entry->post_title;
    }
}

$causes_entries = get_posts( 'post_type=causes&orderby=title&numberposts=-1&order=ASC&suppress_filters=0' );

if ( $causes_entries != null && !empty( $causes_entries ) ) {
    foreach ( $causes_entries as $key => $entry ) {
        $causes[$entry->ID] = $entry->post_title;
    }
}

$events_entries = get_posts( 'post_type=event&orderby=title&numberposts=-1&order=ASC&suppress_filters=0' );

if ( $events_entries != null && !empty( $events_entries ) ) {
    foreach ( $events_entries as $key => $entry ) {
        $events[$entry->ID] = $entry->post_title;
    }
}

$animated_columns_entries = get_posts( 'post_type=animated-columns&orderby=title&numberposts=-1&order=ASC&suppress_filters=0' );

if ( $animated_columns_entries != null && !empty( $animated_columns_entries ) ) {
    foreach ( $animated_columns_entries as $key => $entry ) {
        $animated_columns[$entry->ID] = $entry->post_title;
    }
}

$portfolio_entries = get_posts( 'post_type=portfolio&orderby=title&numberposts=40&order=ASC&suppress_filters=0' );
foreach ( $portfolio_entries as $key => $entry ) {
    $portfolio_posts[$entry->ID] = $entry->post_title;
}


$clients_entries = get_posts( 'post_type=clients&orderby=title&numberposts=-1&order=ASC&suppress_filters=0' );

if ( $clients_entries != null && !empty( $clients_entries ) ) {
    foreach ( $clients_entries as $key => $entry ) {
        $clients[$entry->ID] = $entry->post_title;
    }
}

$sharp_entries = get_posts( 'post_type=sharp&orderby=title&numberposts=-1&order=ASC&suppress_filters=0' );

if ( $sharp_entries != null && !empty( $sharp_entries ) ) {
    foreach ( $sharp_entries as $key => $entry ) {
        $sharp_posts[$entry->ID] = $entry->post_title;
    }
}

$tab_entries = get_posts( 'post_type=tab_slider&orderby=title&numberposts=-1&order=ASC&suppress_filters=0' );

if ( $tab_entries != null && !empty( $tab_entries ) ) {
    foreach ( $tab_entries as $key => $entry ) {
        $tab_posts[$entry->ID] = $entry->post_title;
    }
}

$testimonials_entries = get_posts( 'post_type=testimonial&orderby=title&numberposts=-1&order=ASC&suppress_filters=0' );

if ( $testimonials_entries != null && !empty( $testimonials_entries ) ) {
    foreach ( $testimonials_entries as $key => $entry ) {
        $testimonials[$entry->ID] = $entry->post_title;
    }
}


$cats_entries = get_categories( 'orderby=name&hide_empty=0&suppress_filters=0' );
foreach ( $cats_entries as $key => $entry ) {
    $categories[$entry->term_id] = $entry->name;
}



$posts_entries = get_posts( 'orderby=title&numberposts=40&order=ASC&suppress_filters=0' );
foreach ( $posts_entries as $key => $entry ) {
    $posts[$entry->ID] = $entry->post_title;
}


$page_entries = get_pages('title_li=&orderby=name&suppress_filters=0');
foreach ($page_entries as $key => $entry) {
    $pages['None']             = "*";
    $pages[$entry->post_title] = $entry->ID;
}

$infinite_animation = array(
    "None" => '',
    "Float Vertically" => "float-vertical",
    "Float Horizontally" => "float-horizontal",
    "Pulse" => "pulse",
    "Tossing" => "tossing",
    "Spin" => 'spin',
    'Flip Horizontally' => 'flip-horizontal'
);


$css_animations = array(
    "None" => '',
    "Fade In" => "fade-in",
    "Scale Up" => "scale-up",
    "Scale Down" => "scale-down",
    "Right to Left" => "right-to-left",
    "Left to Right" => "left-to-right",
    "Bottom to Top" => "bottom-to-top",
    "Top to Bottom" => "top-to-bottom",
    "Flip Horizontally" => "flip-x",
    "Flip Vertically" => "flip-y",
    "Rotate" => "forthy-five-rotate",
);


$pacz_orderby = array(
    esc_html__( "Date", 'pacz' ) => "date",
    esc_html__( "Posts In (manually selected posts)", 'pacz' ) => "post__in",
    esc_html__( 'Menu Order', 'pacz' ) => 'menu_order',
    esc_html__( "post id", 'pacz' ) =>  "id",
    esc_html__( "title", 'pacz' ) =>  "title",
    esc_html__( "Comment Count", 'pacz' ) => "comment_count",
    esc_html__( "Random", 'pacz' ) => "rand",
    esc_html__( "Author", 'pacz' ) => "author",
    esc_html__( "No order", 'pacz' )  =>  "none",
);

$pacz_product_orderby = array(
    esc_html__( "Date", 'pacz' ) => "date",
    esc_html__( "Title", 'pacz' ) => "title",
    esc_html__( "Product ID", 'pacz' ) => "product_id",
    esc_html__( "Name", 'pacz' ) => "name",
    esc_html__( "Price", 'pacz' ) => "price",
    esc_html__( "Sales", 'pacz' ) => "sales",
    esc_html__( "Random", 'pacz' ) => "random",
);
$pacz_product_categories_orderby = array(
    esc_html__( "ID", 'pacz' ) => "id",
    esc_html__( "Count", 'pacz' ) => "count",
    esc_html__( "Name", 'pacz' ) => "name",
    esc_html__( "Slug", 'pacz' ) => "slug",
    esc_html__( "None", 'pacz' ) => "none",
);




}