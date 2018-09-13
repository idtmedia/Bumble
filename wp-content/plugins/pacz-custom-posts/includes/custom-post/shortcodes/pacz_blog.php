<?php

extract(shortcode_atts(array(
    'style' => 'classic',
    'column' => 3,
	'thumb_column' => '',
    'disable_meta' => 'true',
    'image_height' => '260',
    'image_width' => '350', // Scroller Style Only
    'count' => '',
    'offset' => 0,
    'cat' => '',
    'posts' => '',
    'author' => '',
    'pagination' => 'true',
    'pagination_style' => '2',
    'orderby' => 'date',
    'order' => 'DESC',
    'grid_avatar' => 'true',
    'read_more' => 'false',
    'sortable' => 'false',
    'classic_excerpt' => 'excerpt',
    'magazine_strcutre' => 1,
    'excerpt_length' => 120,
    'cropping' => 'true',
    'slideshow_layout' => 'default',
    'author' => 'true',
    'item_id' => '',
	'autoplay' => 'false',
	'tab_landscape_items' => 3,
	'tab_items' => 2,
	'desktop_items' => 5,
	'autoplay_speed' => 2000,
	'delay' => 1500,
	'item_loop' => 'false',
	'owl_nav' => 'false',
	'gutter_space' => 0,
	'scroll' => 'false',
	'item_row' => 1,
    'el_class' => ''

), $atts));

require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";    

global $pacz_settings, $classiadspro_dynamic_styles;


$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);


$query = array(
    'post_type' => 'post',
    'posts_per_page' => (int) $count,
    'paged' => $paged,
    'suppress_filters' => 0,
	'ignore_sticky_posts' => 1
);

$classiadspro_styles = '';
if ($scroll == 'true') {
	
		$classiadspro_styles .= '
.pacz-blog-container .owl-carousel .owl-item article.one-column,
.pacz-blog-container .owl-carousel .owl-item article.two-column,
.pacz-blog-container .owl-carousel .owl-item article.three-column,
.pacz-blog-container .owl-carousel .owl-item article.four-column,
.pacz-blog-container .owl-carousel .owl-item article.five-column,
.pacz-blog-container .owl-carousel .owl-item article.six-column{width:100% !important;}
    ';
}
$classiadspro_styles = '';
if ($style == 'thumb') {
	$image_width_round = $image_width - 100;
		$classiadspro_styles .= '
.blog-thumb-content{width: -moz-calc(100% - '.$image_width_round.'px);
    width: -webkit-calc(100% - '.$image_width_round.'px);
    width: -o-calc(100% - '.$image_width_round.'px);
    width: calc(100% - '.$image_width_round.'px);
	}
.blog-thumb-content{height:'.$image_height.'px;}
    ';
}

if ($cat) {
    $query['cat'] = $cat;
}
if ($author) {
    $query['author'] = $author;
}
if ($posts) {
    $query['post__in'] = explode(',', $posts);
}
if ($orderby) {
    $query['orderby'] = $orderby;
}
if ($order) {
    $query['order'] = $order;
}

$id = uniqid();

$item_id = (!empty($item_id)) ? $item_id : 1409305847;



if ($offset && $pagination_style != 2) {
    $query['offset'] = $offset;
}

$query['paged'] = $paged;

$r = new WP_Query($query);


if (is_page()) {
    global $post;
    $layout = get_post_meta($post->ID, '_layout', true);
} else {

    if (is_archive()) {
        $layout = $pacz_settings['archive-layout'];
    } else {
        $layout = 'right';
    }


}



$grid_width    = $pacz_settings['grid-width'];
$content_width = $pacz_settings['content-width'];

$atts   = array(
    'layout' => $layout,
	'style' => $style,
    'column' => $column,
    'image_height' => $image_height,
    'disable_meta' => $disable_meta,
	'thumb_column' => $thumb_column,
    'classic_excerpt' => $classic_excerpt,
    'grid_avatar' => $grid_avatar,
    'read_more' => $read_more,
    'grid_width' => $grid_width,
    'content_width' => $content_width,
    'image_width' => $image_width,
    'excerpt_length' => $excerpt_length,
    'cropping' => $cropping,
    'slideshow_layout' => $slideshow_layout,
    'author' => $author,
	'scroll' => $scroll,
    'item_id' => $item_id,
	'item_row' => $item_row
);
$output = '';



if ($style != 'scroller' && $style != 'slideshow') {
    wp_enqueue_script('jquery-isotope');
    wp_enqueue_script('jquery-jplayer');
}

if ($pagination_style == '2') {
    $paginaton_style_class = 'load-button-style';
    wp_enqueue_script('infinitescroll');
} else if ($pagination_style == '3') {
    $paginaton_style_class = 'scroll-load-style';
    wp_enqueue_script('infinitescroll');
} else {
    $paginaton_style_class = 'page-nav-style';
}


if ($sortable == 'true' && !is_archive() && $style != 'scroller' && $style != 'slideshow') {
    $output .= '<header class="pacz-isotop-filter"><ul>';

    $categories_args = array(
        'orderby' => 'name',
        'order' => 'ASC',
        'include' => $cat
    );

    $categories = get_categories($categories_args);
    $output .= '<li><a class="current" data-filter="*" href="#">' . esc_html__('All', 'pacz') . '</a></li>';
    foreach ($categories as $category) {
        $output .= '<li><a data-filter=".category-' . $category->slug . '" href="#">' . $category->name . '</a></li>';
    }

    $output .= '<div class="clearboth"></div></ul>';
    $output .= '<div class="clearboth"></div></header>';
}

$isotope_el_class = ($style != 'scroller' && $style != 'magazine' && $style != 'slideshow') ? 'isotop-enabled pacz-theme-loop ' : '';



switch ($magazine_strcutre) {
	case 1:
		$magazine_style_class = 'mag-one-column';
		break;
	case 2:
		$magazine_style_class = 'mag-two-column-left';
		break;
	case 3:
		$magazine_style_class = 'mag-two-column-right';
		break;

	default:
		$magazine_style_class = 'mag-one-column';
		break;
}



$output .= '<div class="loop-main-wrapper"><section id="pacz-blog-loop-' . $id . '" data-style="' . $style . '" data-uniqid="'.$item_id.'" class="pacz-blog-container clearfix pacz-' . $style . '-wrapper '.$magazine_style_class.' ' . $paginaton_style_class . ' '.$isotope_el_class.' '.$el_class.'">' . "\n";
/*
if ($style == 'scroller' || $style == 'slideshow') {
    $output .= '<div class="pacz-swiper-wrapper">';
}

$i = 0;
if (is_archive()):
    if (have_posts()):
        while (have_posts()):
            the_post();
            $i++;
            switch ($style) {

                case 'classic':
                    $output .= blog_classic_style($atts);
                    break;
                case 'masonry':
                    $output .= blog_masonry_style($atts);
                    break;
                case 'modern':
                    $output .= blog_modern_style($atts);
                    break;
                case 'list':
                    $output .= blog_list_style($atts);
                    break;
                case 'thumb':
                    $output .= blog_thumb_style($atts);
                    break;
                case 'scroller':
                    $output .= blog_scroller_style($atts);
                    break;
                case 'magazine':
                    $output .= blog_magazine_style($atts, $i);
                    break;
                case 'tile':
                    $output .= blog_tile_style($atts, $i);
                    break;
				case 'slideshow':
                    $output .= blog_slideshow_style($atts);
                    break;
                default:
                    $output .= blog_classic_style($atts);
            }
        endwhile;
    endif;
else:
    if ($r->have_posts()):
        while ($r->have_posts()):
            $r->the_post();
            $i++;
            switch ($style) {

                case 'classic':
                    $output .= blog_classic_style($atts);
                    break;
                case 'modern':
                    $output .= blog_modern_style($atts);
                    break;
                case 'masonry':
                    $output .= blog_masonry_style($atts);
                    break;
                case 'list':
                    $output .= blog_list_style($atts);
                    break;
                case 'thumb':
                    $output .= blog_thumb_style($atts);
                    break;
                case 'scroller':
                    $output .= blog_scroller_style($atts);
                    break;
                case 'magazine':
                    $output .= blog_magazine_style($atts, $i);
                    break;
                case 'tile':
                    $output .= blog_tile_style($atts, $i);
                    break;
				case 'slideshow':
                    $output .= blog_slideshow_style($atts);
                    break;
                default:
                    $output .= blog_classic_style($atts);
            }
        endwhile;
    endif;
endif;

if ($style == 'scroller' || $style == 'slideshow') {
    $output .= '</div>';
}

if ($style == 'scroller' || $style == 'slideshow') {
    $output .= '<a class="pacz-swiper-prev blog-scroller-arrows"><i class="pacz-theme-icon-prev-big"></i></a>';
    $output .= '<a class="pacz-swiper-next blog-scroller-arrows"><i class="pacz-theme-icon-next-big"></i></a>';
}*/

if ($scroll == 'true') {
    $output .= '<div class="owl-carousel" data-items="'.$desktop_items.'" data-items-tab-ls="'.$tab_landscape_items.'" data-items-tab="'.$tab_items.'" data-autoplay="'.$autoplay.'" data-gutter="'.$gutter_space.'" data-autoplay-speed="'.$autoplay_speed.'" data-delay="'.$delay.'" data-loop="'.$item_loop.'" data-nav="'.$owl_nav.'">';
}

$i = 0;
if (is_archive()):
    if (have_posts()):
        while (have_posts()):
            the_post();
            $i++;
            switch ($style) {

                case 'classic':
                    $output .= blog_classic_style($atts);
                    break;
                case 'masonry':
                    $output .= blog_masonry_style($atts);
                    break;
                case 'modern':
                    $output .= blog_modern_style($atts);
                    break;
                case 'list':
                    $output .= blog_list_style($atts);
                    break;
                case 'thumb':
                    $output .= blog_thumb_style($atts);
                    break;
                case 'magazine':
                    $output .= blog_magazine_style($atts, $i);
                    break;
                case 'tile':
                    $output .= blog_tile_style($atts, $i);
                    break;
				case 'tile_elegant':
                    $output .= blog_tile_elegant_style($atts, $i);
                    break;
                default:
                    $output .= blog_classic_style($atts);
            }
        endwhile;
    endif;
else:
    if ($r->have_posts()):
        while ($r->have_posts()):
            $r->the_post();
            $i++;
            switch ($style) {

                case 'classic':
                    $output .= blog_classic_style($atts);
                    break;
                case 'modern':
                    $output .= blog_modern_style($atts);
                    break;
                case 'masonry':
                    $output .= blog_masonry_style($atts);
                    break;
                case 'list':
                    $output .= blog_list_style($atts);
                    break;
                case 'thumb':
                    $output .= blog_thumb_style($atts);
                    break;
                case 'magazine':
                    $output .= blog_magazine_style($atts, $i);
                    break;
                case 'tile':
                    $output .= blog_tile_style($atts, $i);
                    break;
				case 'tile_elegant':
                    $output .= blog_tile_elegant_style($atts, $i);
                    break;
                default:
                    $output .= blog_classic_style($atts);
            }
        endwhile;
    endif;
endif;
if ($scroll == 'true') {
    $output .= '</div>';
}
$output .= '</section><div class="clearboth"></div>';


if ($pagination == 'true' && $style != 'scroller' && $style != 'magazine'  && $style != 'slideshow') {
    $output .= '<a class="pacz-loadmore-button" style="display:none;" href="#"><i class="pacz-icon-circle-o-notch"></i><i class="pacz-icon-chevron-down"></i></a>';
    ob_start();
    pacz_theme_blog_pagenavi('', '', $r, $paged);
    $output .= ob_get_clean();
}
$output .= '</div>';
wp_reset_postdata();
echo '<div>'.$output.'</div>';

// Hidden styles node for head injection after page load through ajax
echo '<div id="ajax-'.$id.'" class="pacz-dynamic-styles">';
echo '<!-- ' . pacz_clean_dynamic_styles($classiadspro_styles) . '-->';
echo '</div>';


// Export styles to json for faster page load
$classiadspro_dynamic_styles[] = array(
  'id' => 'ajax-'.$id ,
  'inject' => $classiadspro_styles
);