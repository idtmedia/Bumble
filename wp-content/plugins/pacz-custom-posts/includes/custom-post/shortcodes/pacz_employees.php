<?php

extract(shortcode_atts(array(
    'count' => 4,
    'column' => 1,
    'style' => 'grid',
    'dimension' => 370,
	'dimensionh' => '',
    'employees' => '256',
    'animation' => '',
    'scroll' => 'true',
    'description' => 'false',
    'el_class' => '',
    'offset' => '',
    'autoplay' => 'false',
	'tab_landscape_items' =>3,
	'tab_items' => 2,
	'desktop_items' => 3,
	'autoplay_speed' => 2000,
	'delay' => 1000,
	'item_loop' => 'false',
	'owl_nav' => 'false',
	'gutter_space' => 30,
	'hover_style' => '1',
    'full_width_image' => 'false',
    'orderby' => 'date',
    'order' => 'DESC'
), $atts));

require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";    

$id     = uniqid();
$output = $image_width = '';

$scroll_stuff = array(
    '',
    '',
    '',
    '',
    ''
);


if($full_width_image == 'true'){
    $image_width = 'width:100%;';
}



$query = array(
    'post_type' => 'employees',
    'showposts' => $count
);

if ($employees) {
    $query['post__in'] = explode(',', $employees);
}
if ($offset) {
    $query['offset'] = $offset;
}
if ($orderby) {
    $query['orderby'] = $orderby;
}
if ($order) {
    $query['order'] = $order;
}

$loop = new WP_Query($query);

$animation_css = ($animation != '') ? ' pacz-animate-element ' . $animation . ' ' : '';

/*if ($style == 'column' || $style == 'column_rounded'):
    $image_dimension = $column_css = '';
    switch ($column) {
        case 1:
            $image_dimension = 550;
            $column_css      = 'one';
            break;
        case 2:
            $image_dimension = 508;
            $column_css      = 'two';
            break;
        case 3:
            $image_dimension = 500;
            $column_css      = 'three';
            break;
        case 4:
            $image_dimension = 500;
            $column_css      = 'four';
            break;
        case 5:
            $image_dimension = 300;
            $column_css      = 'five';
            break;
    }


    $output .= '<div id="employees-' . $id . '" class="pacz-employees pacz-shortcode ' . $el_class . ' ' . $column_css . '-column ' . $style . '-style"><ul>';

    $i = 0;
    while ($loop->have_posts()):
        $loop->the_post();
        $i++;

        $facebook        = get_post_meta(get_the_ID(), '_facebook', true);
        $linkedin        = get_post_meta(get_the_ID(), '_linkedin', true);
        $twitter         = get_post_meta(get_the_ID(), '_twitter', true);
        $email           = get_post_meta(get_the_ID(), '_email', true);
        $website         = get_post_meta(get_the_ID(), '_website', true);
        $pinterest       = get_post_meta(get_the_ID(), '_pinterest', true);
        $googleplus      = get_post_meta(get_the_ID(), '_googleplus', true);
        $instagram       = get_post_meta(get_the_ID(), '_instagram', true);
        $dribbble        = get_post_meta(get_the_ID(), '_dribbble', true);
        $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
        $image_src       = bfi_thumb($image_src_array[0], array(
            'width' => $image_dimension,
            'height' => $image_dimension,
            'crop' => true
        ));

        $first_column = '';

        $output .= '<li class="pacz-employee-item"><div class="employee-item-wrapper">';


        $output .= '<div class="team-thumbnail ' . $animation_css . '" onClick="return true"><img alt="' . get_the_title() . '" style="'.$image_width.'" title="' . get_the_title() . '" src="' . pacz_thumbnail_image_gen($image_src, $image_dimension, $image_dimension) . '" />';
        $output .= '<div class="hover-overlay"></div>';
        $output .= '</div>';

        $output .= '<div class="team-info-wrapper">';
        $output .= '<h5 class="team-member-name">' . get_the_title() . '</h5>';
        $output .= '<span class="team-member-position">' . get_post_meta(get_the_ID(), '_position', true) . '</span>';

        if ($description == 'true') {
            $content = get_post_meta(get_the_ID(), '_desc', true);
            $content = str_replace(']]>', ']]&gt;', apply_filters('the_content', $content));
            $output .= '<span class="team-member-desc">' . $content . '</span>';
        }
		if ($image_dimension > 200) {
            $output .= '<ul class="pacz-employeee-networks">';
            if (!empty($email)) {
                $output .= '<li><a href="mailto:' . antispambot($email) . '" title="' . esc_html__('Get In Touch With', 'pacz') . ' ' . get_the_title() . '"><i class="pacz-icon-envelope-o"></i></a></li>';
            }
            if (!empty($facebook)) {
                $output .= '<li><a href="' . $facebook . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Facebook"><i class="pacz-icon-facebook"></i></a></li>';
            }
            if (!empty($website)) {
                $output .= '<li><a href="' . $website . '" title="' . get_the_title() . ' ' . esc_html__('Website', 'pacz') . '"><i class="pacz-icon-globe"></i></a></li>';
            }
            if (!empty($dribbble)) {
                $output .= '<li><a href="' . $dribbble . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Dribbble"><i class="pacz-icon-dribbble"></i></a></li>';
            }
            if (!empty($instagram)) {
                $output .= '<li><a href="' . $instagram . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Instagram"><i class="pacz-icon-instagram"></i></a></li>';
            }
            if (!empty($twitter)) {
                $output .= '<li><a href="' . $twitter . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Twitter"><i class="pacz-icon-twitter"></i></a></li>';
            }
            if (!empty($googleplus)) {
                $output .= '<li><a href="' . $googleplus . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Google Plus"><i class="pacz-icon-google-plus"></i></a></li>';
            }
            if (!empty($pinterest)) {
                $output .= '<li><a href="' . $pinterest . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Pinterest"><i class="pacz-icon-pinterest"></i></a></li>';
            }
            if (!empty($linkedin)) {
                $output .= '<li><a href="' . $linkedin . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Linked In"><i class="pacz-icon-linkedin"></i></a></li>';
            }
            $output .= '</ul>';
        }
        

        $output .= '</div></div></li>';



        if ($i % $column == 0) {
            $output .= '<li class="clearboth"></li>';
        }
    endwhile;
    wp_reset_postdata();

    $output .= '</ul><div class="clearboth"></div></div>';
*/
   


    $output .= '<div id="employees-' . $id . '" class="pacz-employees"><div class="owl-carousel" data-items="'.$desktop_items.'" data-items-tab-ls="'.$tab_landscape_items.'" data-items-tab="'.$tab_items.'" data-autoplay="'.$autoplay.'" data-gutter="'.$gutter_space.'" data-autoplay-speed="'.$autoplay_speed.'" data-delay="'.$delay.'" data-loop="'.$item_loop.'" data-nav="'.$owl_nav.'">';

    while ($loop->have_posts()):
        $loop->the_post();

        $facebook        = get_post_meta(get_the_ID(), '_facebook', true);
        $linkedin        = get_post_meta(get_the_ID(), '_linkedin', true);
        $twitter         = get_post_meta(get_the_ID(), '_twitter', true);
        $email           = get_post_meta(get_the_ID(), '_email', true);
        $website         = get_post_meta(get_the_ID(), '_website', true);
        $pinterest       = get_post_meta(get_the_ID(), '_pinterest', true);
        $googleplus      = get_post_meta(get_the_ID(), '_googleplus', true);
        $instagram       = get_post_meta(get_the_ID(), '_instagram', true);
        $dribbble        = get_post_meta(get_the_ID(), '_dribbble', true);
        $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
        $image_src       = bfi_thumb($image_src_array[0], array(
            'width' => $dimension,
            'height' => $dimensionh,
            'crop' => true
        ));

        $output .= $style == 'grid' ? '<div class="pacz-employee-item">' : '<div class="pacz-employee-item owl-item">';
        $output .= '<img alt="' . get_the_title() . '" style="'.$image_width.'" title="' . get_the_title() . '" src="' . pacz_thumbnail_image_gen($image_src, $dimension, $dimensionh) . '" />';
        if($hover_style == 1){
		$output .= '<div class="hover_style1 hover-overlay">';
		
		$output .= '<div class="team-info-wrapper"><div class="team-info-holder">';
        $output .= '<span class="team-member-name">' . get_the_title() . '</span>';
        $output .= '<span class="team-member-position">' . get_post_meta(get_the_ID(), '_position', true) . '</span>';
        if ($dimension > 200) {
            $output .= '<ul class="pacz-employeee-networks">';
            if (!empty($email)) {
                $output .= '<li><a href="mailto:' . antispambot($email) . '" title="' . esc_html__('Get In Touch With', 'pacz') . ' ' . get_the_title() . '"><i class="pacz-icon-envelope-o"></i></a></li>';
            }
            if (!empty($facebook)) {
                $output .= '<li><a href="' . $facebook . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Facebook"><i class="pacz-icon-facebook"></i></a></li>';
            }
            if (!empty($website)) {
                $output .= '<li><a href="' . $website . '" title="' . get_the_title() . ' ' . esc_html__('Website', 'pacz') . '"><i class="pacz-icon-globe"></i></a></li>';
            }
            if (!empty($dribbble)) {
                $output .= '<li><a href="' . $dribbble . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Dribbble"><i class="pacz-icon-dribbble"></i></a></li>';
            }
            if (!empty($instagram)) {
                $output .= '<li><a href="' . $instagram . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Instagram"><i class="pacz-icon-instagram"></i></a></li>';
            }
            if (!empty($twitter)) {
                $output .= '<li><a href="' . $twitter . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Twitter"><i class="pacz-icon-twitter"></i></a></li>';
            }
            if (!empty($googleplus)) {
                $output .= '<li><a href="' . $googleplus . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Google Plus"><i class="pacz-icon-google-plus"></i></a></li>';
            }
            if (!empty($pinterest)) {
                $output .= '<li><a href="' . $pinterest . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Pinterest"><i class="pacz-icon-pinterest"></i></a></li>';
            }
            if (!empty($linkedin)) {
                $output .= '<li><a href="' . $linkedin . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Linked In"><i class="pacz-icon-linkedin"></i></a></li>';
            }
            $output .= '</ul>';
        }
		$output .= '</div></div></div>';
		}
		if($hover_style == 2){
		$output .= '<div class="hover_style2 team-info-wrapper"><div class="team-info-holder">';
        $output .= '<span class="team-member-name">' . get_the_title() . '</span>';
        $output .= '<span class="team-member-position">' . get_post_meta(get_the_ID(), '_position', true) . '</span>';
        if ($dimension > 200) {
            $output .= '<ul class="pacz-employeee-networks">';
            if (!empty($email)) {
                $output .= '<li><a href="mailto:' . antispambot($email) . '" title="' . esc_html__('Get In Touch With', 'pacz') . ' ' . get_the_title() . '"><i class="pacz-icon-envelope-o"></i></a></li>';
            }
            if (!empty($facebook)) {
                $output .= '<li><a href="' . $facebook . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Facebook"><i class="pacz-icon-facebook"></i></a></li>';
            }
            if (!empty($website)) {
                $output .= '<li><a href="' . $website . '" title="' . get_the_title() . ' ' . esc_html__('Website', 'pacz') . '"><i class="pacz-icon-globe"></i></a></li>';
            }
            if (!empty($dribbble)) {
                $output .= '<li><a href="' . $dribbble . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Dribbble"><i class="pacz-icon-dribbble"></i></a></li>';
            }
            if (!empty($instagram)) {
                $output .= '<li><a href="' . $instagram . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Instagram"><i class="pacz-icon-instagram"></i></a></li>';
            }
            if (!empty($twitter)) {
                $output .= '<li><a href="' . $twitter . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Twitter"><i class="pacz-icon-twitter"></i></a></li>';
            }
            if (!empty($googleplus)) {
                $output .= '<li><a href="' . $googleplus . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Google Plus"><i class="pacz-icon-google-plus"></i></a></li>';
            }
            if (!empty($pinterest)) {
                $output .= '<li><a href="' . $pinterest . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Pinterest"><i class="pacz-icon-pinterest"></i></a></li>';
            }
            if (!empty($linkedin)) {
                $output .= '<li><a href="' . $linkedin . '" title="' . get_the_title() . ' ' . esc_html__('On', 'pacz') . ' Linked In"><i class="pacz-icon-linkedin"></i></a></li>';
            }
            $output .= '</ul>';
        }
		$output .= '</div></div>';
		}
        
        $output .= '</div>';
    endwhile;
    wp_reset_postdata();

    $output .= '</div></div>';



echo '<div>'.$output.'</div>';
