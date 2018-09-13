<?php

extract(shortcode_atts(array(
    'style' => 'classic',
    'display' => 'recent',
    'category' => '',
    'orderby' => '',
    'order' => '',
    'column' => '4',
    'product_per_page' => '',
    'pagination' => '',
	'autoplay' => 'false',
	'tab_landscape_items' => 1,
	'tab_items' => 1,
	'desktop_items' => 1,
	'autoplay_speed' => 2000,
	'delay' => 1000,
	'item_loop' => 'false',
	'owl_nav' => 'true',
	'gutter_space' => 0,
	'scroll' => 'true',
    'el_class' => ''
), $atts));



require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";    

global $woocommerce_loop, $woocommerce, $pacz_settings, $post, $wp_query, $classiadspro_dynamic_styles;
$classiadspro_styles = '';

if ($scroll == 'true') {
	
		$classiadspro_styles .= '
.woocommerce ul.products.owl-carousel {margin-left: 0;margin-right: 0;}
.woocommerce ul.products.owl-carousel li.product { padding-left: 0;padding-right: 0;}
ul.products.owl-carousel li.product.one-column { width: 100%;}
ul.products.owl-carousel li.product.two-column { width: 100%;}
ul.products.owl-carousel li.product.three-column { width: 100%;}
ul.products.owl-carousel li.product.four-column { width: 100%;}
    ';
}
$output =  '';

$id = uniqid();

$meta_query = '';
if($display == "recent"){
    $meta_query = WC()->query->get_meta_query();
}
if($display == "featured"){
    $meta_query = array(
        array(
            'key'       => '_visibility',
            'value'       => array('catalog', 'visible'),
            'compare'   => 'IN'
        ),
        array(
            'key'       => '_featured',
            'value'       => 'yes'
        )
    );
}
if($display == "top_rated"){
    add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
    $meta_query = WC()->query->get_meta_query();
}

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$args = array(
    'post_type'             => 'product',
    'post_status'           => 'publish',
    'ignore_sticky_posts'   => 1,
    'posts_per_page'        => $product_per_page,
    'orderby'               => $orderby,
    'order'                 => $order,
    'paged'                 => $paged,
    'meta_query'            => $meta_query
);
if($display == "sale"){
    $product_ids_on_sale = woocommerce_get_product_ids_on_sale();
    $meta_query = array();
    $meta_query[] = $woocommerce_loop->query->visibility_meta_query();
    $meta_query[] = $woocommerce_loop->query->stock_status_meta_query();
    $args['meta_query'] = $meta_query;
    $args['post__in'] = $product_ids_on_sale;
}
if($display == "best_selling"){
    $args['meta_key'] = 'total_sales';
    $args['orderby'] = 'meta_value_num';
    $args['meta_query'] = array(
            array(
                'key'       => '_visibility',
                'value'     => array( 'catalog', 'visible' ),
                'compare'   => 'IN'
            )
        );
}

if($display == "product_category"){
    $args['tax_query'] = array(
        array(
            'taxonomy'   => 'product_cat',
            'terms'         => explode(",", $category),
            'field'         => 'slug'
        )
    );
}

$output .= '<div class="woocommerce column-'.$column.' '.$el_class.'">';
if($scroll == 'true'){
	
$output .= '<ul class="products owl-carousel '.$style.'-style" data-items="'.$desktop_items.'" data-items-tab-ls="'.$tab_landscape_items.'" data-items-tab="'.$tab_items.'" data-autoplay="'.$autoplay.'" data-gutter="'.$gutter_space.'" data-autoplay-speed="'.$autoplay_speed.'" data-delay="'.$delay.'" data-loop="'.$item_loop.'" data-nav="'.$owl_nav.'">'; 	
}
else{
	$output .= '<ul class="products isotope-enabled '.$style.'-style">'; 
}

$query = new WP_Query( $args );
if($query->have_posts()):
    while ( $query->have_posts() ) : $query->the_post();
        $product_id = get_the_ID();
        $uid = uniqid();
        $loop_image_size = isset($pacz_settings['woo_loop_image_size']) ? $pacz_settings['woo_loop_image_size'] : 'crop';
        $quality = $pacz_settings['woo-image-quality'] ? $pacz_settings['woo-image-quality'] : 1;
        $grid_width = $pacz_settings['grid-width'];
        $content_width = $pacz_settings['content-width'];
        $height = $pacz_settings['woo-loop-thumb-height'];
        global $product;

        switch ($column) {
            case 4:
                    $classes[] = 'four-column';
                    $width = round($grid_width/4) - 38;
                    $column_width = round($grid_width/4);
                break;
            case 3:
                    $classes[] = 'three-column';
                    $width = round($grid_width/3) - 41;
                    $column_width = round($grid_width/3);
                break;
            case 2:
                    $classes[] = 'two-column';
                    $width = round($grid_width/2) - 49;
                    $column_width = round($grid_width/2);
                break;
            case 1:
                    $classes[] = 'one-column';
                    $width = round($grid_width/1) - 66;
                    $column_width = round($grid_width/1);
                break;

            default:
                    $classes[] = 'three-column';
                    $width = round($grid_width/3) - 36;
                    $column_width = round($grid_width/3);
                break;
        }

        ob_start();
            post_class($classes);



        $output .= '<li style="" '.ob_get_clean().' >';
        $output .= '    <div class="item-holder">';
        $output .= '        <span class="product-loading-icon"></span>';
        /*
        * Product add to card & out of stock badge
        */
        $out_of_stock_badge = '';
if ( ! $product->is_in_stock() ) {

	$pacz_add_to_cart = '<a href="'. apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ).'" title="'. apply_filters( 'out_of_stock_add_to_cart_text', esc_html__( 'READ MORE', 'pacz' ) ).'" class="add_to_cart_button"><i class="pacz-icon-shopping-cart"></i></a>';

	$out_of_stock_badge = '<span class="out-of-stock">'.esc_html__( 'OUT OF STOCK', 'pacz' ).'</span>';
}

        if($style == 'modern'){
            $output .= '<div class="modern-style-holder">';
            $output .= '<div class="modern-hover-holder">';
            $output .= '<a href="'. apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ).'" alt="'. apply_filters( 'out_of_stock_add_to_cart_text', esc_html__( 'READ MORE', 'pacz' ) ).'" class="add_to_cart_button">'.esc_html__( 'PURCHASE', 'pacz' ).'</a>';
            $output .= $out_of_stock_badge;
            if ($product->is_on_sale()) :
            $output .= apply_filters('woocommerce_sale_flash', '<span class="onsale">'.esc_html__( 'SALE', 'pacz' ).'</span>', $post, $product);
            endif;
            $output .= '</div>';
        }
        

        /* Product loop thumbnail */
        if ( has_post_thumbnail() ) {
            switch ($loop_image_size) {
                case 'full':
                    $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
                    $image_output_src = $image_src_array[0];
                    break;
                case 'crop':
                    $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
                    $image_output_src = bfi_thumb($image_src_array[0], array(
                        'width' => $width*$quality,
                        'height' => $height*$quality
                    ));
                    break;            
                case 'large':
                    $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large', true);
                    $image_output_src = $image_src_array[0];
                    break;
                case 'medium':
                    $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium', true);
                    $image_output_src = $image_src_array[0];
                    break;        
                default:
                    $image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
                    $image_output_src = bfi_thumb($image_src_array[0], array(
                        'width' => $width*$quality,
                        'height' => $height*$quality
                    ));
                    break;
            }
			if($style == 'classic'){
                $output .= '<div class="shop-thumb">';          
            }
            $output .= '<a href="'. get_permalink().'" class="product-loop-thumb">';

            $output .= '<img src="'.pacz_thumbnail_image_gen($image_output_src, $width, $height).'" class="product-loop-image" alt="'.get_the_title().'" title="'.get_the_title().'" itemprop="image">';

           /* $product_gallery = get_post_meta( $post->ID, '_product_image_gallery', true );

            if ( !empty( $product_gallery ) ) {

                $gallery = explode( ',', $product_gallery );
                $hover_image_id  = $gallery[0];

                $image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'full', true );
                
                switch ($loop_image_size) {
                case 'full':
                    $image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'full', true);
                    $image_hover_src = $image_src_hover_array[0];
                    break;
                case 'crop':
                    $image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'full', true);
                    $image_hover_src = bfi_thumb($image_src_hover_array[0], array(
                        'width' => $width*$quality,
                        'height' => $height*$quality
                    ));
                    break;            
                case 'large':
                    $image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'large', true);
                    $image_hover_src = $image_src_hover_array[0];
                    break;
                case 'medium':
                    $image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'medium', true);
                    $image_hover_src = $image_src_hover_array[0];
                    break;        
                default:
                    $image_src_hover_array = wp_get_attachment_image_src($hover_image_id, 'full', true);
                    $image_hover_src = bfi_thumb($image_src_hover_array[0], array(
                        'width' => $width*$quality,
                        'height' => $height*$quality
                    ));
                    break;
            }

            $output .= '<img src="'.pacz_thumbnail_image_gen($image_hover_src, $width, $height).'" alt="'.get_the_title().'" class="product-hover-image" title="'.get_the_title().'" >';
            }*/

            $output .= '<div class="hover-overlay"></div>';
			if($style == 'classic'){
            $output .= '<span class="shop-tags-wrap">';
		
				if ($product->is_on_sale()) :
					$output .= apply_filters('woocommerce_sale_flash', '<span class="onsale">'.esc_html__( 'SALE', 'pacz' ).'</span>', $post, $product);
				endif;
				if ($product->is_featured()) :
					$output .= apply_filters('woocommerce_featured_flash', '<span class="onfeatured">'.esc_html__( 'FEATURED', 'pacz' ).'</span>', $post, $product);
				endif;
				$output .= $out_of_stock_badge;
			$output .= '</span>';
			}
            $output .= '</a></div>';            

        }
        $output .='<div class="product-item-details">';

		$output .='<h5><a href="'.get_permalink().'">'.get_the_title().'</a></h5>';
		ob_start();
        do_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
        $output .= ob_get_clean();
		$output .='<div class="product_bottom clearfix">';
			if ( $rating_html = $product->get_rating_html() ) {
					$output .='<div class="product-item-rating">'.$rating_html.'</div>';
			}
			else{
				
				$output .='<span class="product-item-rating"><span class="star-rating"></span></span>';
			}
			if( function_exists('pacz_love_this') ) {
                ob_start();
                pacz_love_this();
                $output .= ob_get_clean();
            }
			if($style == 'classic'){

            if ( ! $product->is_in_stock() ) {
                $pacz_add_to_cart = '<a href="'. apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ).'" title="'. apply_filters( 'out_of_stock_add_to_cart_text', esc_html__( 'READ MORE', 'pacz' ) ).'" class="add_to_cart_button"><i class="pacz-icon-shopping-cart"></i></a>';
            }
            else { 
                switch ( $product->product_type ) {
                case "variable" :
                    $link  = apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
                    $label  = apply_filters( 'variable_add_to_cart_text', esc_html__( 'Select options', 'pacz' ) );
                    $icon_class = 'pacz-theme-icon-plus';
                    break;
                case "grouped" :
                    $link  = apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
                    $label  = apply_filters( 'grouped_add_to_cart_text', esc_html__( 'View options', 'pacz' ) );
                    $icon_class = 'pacz-theme-icon-plus';
                    break;
                case "external" :
                    $link  = apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
                    $label  = apply_filters( 'external_add_to_cart_text', esc_html__( 'Read More', 'pacz' ) );
                    $icon_class = 'pacz-theme-icon-magnifier';
                    break;
                default :
                    $link  = apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
                    $label  = apply_filters( 'add_to_cart_text', esc_html__( 'ADD TO CART', 'pacz' ) );
                    $icon_class = 'pacz-icon-shopping-cart';
                    break;
                }

                if ( $product->product_type != 'external' ) {
                    $pacz_add_to_cart = '<a href="'. $link .'" rel="nofollow" data-product_id="'.$product->id.'" title="'.$label.'" class="add_to_cart_button product_type_'.$product->product_type.'"><i class="'.$icon_class.'"></i></a>';
                }
                else {
                    $pacz_add_to_cart = '';
                }
            }

            $output .= $pacz_add_to_cart;
			}
			$output .='</div>';
		$output .='</div>';
		ob_start();
		do_action( 'woocommerce_after_shop_loop_item' );
        $output .= '    </div>';
        $output .= '</li>';
    endwhile;
endif;
$output .= '</ul>';

if($pagination == "true"){
        $output .= '<nav class="woocommerce-pagination">';
        $output .= pacz_woocommerce_pagination($query->max_num_pages);
        $output .= '</nav>';
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