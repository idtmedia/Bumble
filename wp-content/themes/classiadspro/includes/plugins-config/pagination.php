<?php

function pacz_theme_blog_pagenavi( $before = '', $after = '', $blog_query, $paged ) {
    global $wpdb, $wp_query;

    if ( is_single() )
        return;

    $pagenavi_options = array(
        'pages_text' => '',
        'current_text' => '%PAGE_NUMBER%',
        'page_text' => '%PAGE_NUMBER%',
        'dotright_text' => esc_html__( '...', 'classiadspro' ),
        'dotleft_text' => esc_html__( '...', 'classiadspro' ),
        'num_pages' => 4,
        'always_show' => 0,
        'num_larger_page_numbers' => 3,
        'larger_page_numbers_multiple' => 10,
        'use_pagenavi_css' => 0,
    );
    if ( is_archive() || is_search() ) {
        $request = $wp_query->request;
    } else {
        $request = $blog_query->request;
    }

    $posts_per_page = intval( get_query_var( 'posts_per_page' ) );
    global $wp_version;
    if ( ( is_front_page() || is_home() ) && version_compare( $wp_version, "3.1", '>=' ) ) {//fix wordpress 3.1 paged query
        $paged = ( get_query_var( 'paged' ) ) ?intval( get_query_var( 'paged' ) ) : intval( get_query_var( 'page' ) );
    }else {
        $paged = intval( get_query_var( 'paged' ) );
    }
    if ( is_archive() || is_search() ) {
        $numposts = $wp_query->found_posts;
        $max_page = intval( $wp_query->max_num_pages );
    } else {
        $numposts = $blog_query->found_posts;
        $max_page = intval( $blog_query->max_num_pages );
    }


    if ( empty( $paged ) || $paged == 0 )
        $paged = 1;
    $pages_to_show = intval( $pagenavi_options['num_pages'] );
    $larger_page_to_show = intval( $pagenavi_options['num_larger_page_numbers'] );
    $larger_page_multiple = intval( $pagenavi_options['larger_page_numbers_multiple'] );
    $pages_to_show_minus_1 = $pages_to_show - 1;
    $half_page_start = floor( $pages_to_show_minus_1 / 2 );
    $half_page_end = ceil( $pages_to_show_minus_1 / 2 );
    $start_page = $paged - $half_page_start;

    if ( $start_page <= 0 )
        $start_page = 1;

    $end_page = $paged + $half_page_end;
    if ( ( $end_page - $start_page ) != $pages_to_show_minus_1 ) {
        $end_page = $start_page + $pages_to_show_minus_1;
    }

    if ( $end_page > $max_page ) {
        $start_page = $max_page - $pages_to_show_minus_1;
        $end_page = $max_page;
    }

    if ( $start_page <= 0 )
        $start_page = 1;

    $larger_pages_array = array();
    if ( $larger_page_multiple )
        for ( $i = $larger_page_multiple; $i <= $max_page; $i += $larger_page_multiple )
        $larger_pages_array[] = $i;

    if ( $max_page > 1 || intval( $pagenavi_options['always_show'] ) ) {
        $pages_text = str_replace( "%CURRENT_PAGE%", number_format_i18n( $paged ), $pagenavi_options['pages_text'] );
        $pages_text = str_replace( "%TOTAL_PAGES%", number_format_i18n( $max_page ), $pages_text );

        echo '<div class="pacz-pagination">' . "\n";
        ob_start();
        echo previous_posts_link( '' );
        $previous_link = ob_get_clean();
        
      
        echo '<ul>';
        if ( ! empty( $pages_text ) ) {
            echo '<span class="pages">' . $pages_text . '</span>';
        }

        $larger_page_start = 0;
        foreach ( $larger_pages_array as $larger_page ) {
            if ( $larger_page < $start_page && $larger_page_start < $larger_page_to_show ) {
                $page_text = str_replace( "%PAGE_NUMBER%", number_format_i18n( $larger_page ), $pagenavi_options['page_text'] );
                echo '<li><a href="' . esc_url( get_pagenum_link( $larger_page ) ) . '" class="page-number" title="' . $page_text . '">' . $page_text . '</a></li>';
                $larger_page_start++;
            }
        }

        for ( $i = $start_page; $i <= $end_page; $i++ ) {
            if ( $i == $paged ) {
                $current_page_text = str_replace( "%PAGE_NUMBER%", number_format_i18n( $i ), $pagenavi_options['current_text'] );
                echo '<li><span class="current-page">' . $current_page_text . '</span></li>';
            } else {
                $page_text = str_replace( "%PAGE_NUMBER%", number_format_i18n( $i ), $pagenavi_options['page_text'] );
                echo '<li><a href="' . esc_url( get_pagenum_link( $i ) ) . '" class="page-number" title="' . $page_text . '">' . $page_text . '</a></li>';
            }
        }

        $larger_page_end = 0;
        foreach ( $larger_pages_array as $larger_page ) {
            if ( $larger_page > $end_page && $larger_page_end < $larger_page_to_show ) {
                $page_text = str_replace( "%PAGE_NUMBER%", number_format_i18n( $larger_page ), $pagenavi_options['page_text'] );
                echo '<li><a href="' . esc_url( get_pagenum_link( $larger_page ) ) . '" class="page-number" title="' . $page_text . '">'.$page_text.'</a></li>';
                $larger_page_end++;
            }
        }
        echo '</ul>';
        ob_start();
        next_posts_link( '', $max_page );
        $next_link = ob_get_clean();

        if(strlen($previous_link) > 1) {
        echo '<div class="pacz-pagination-previous">';
        echo '<div>'.$previous_link.'</div>';
        echo '</div>';
        }

        if(strlen($next_link) > 1) {
            echo '<div class="pacz-pagination-next">';
            echo '<div>'.$next_link.'</div>';
            echo '</div>';
        }
        echo '</div>' . $after . "\n";

    }
}