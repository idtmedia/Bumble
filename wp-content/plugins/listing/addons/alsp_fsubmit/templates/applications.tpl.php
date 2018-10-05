<?php
//    echo do_shortcode('[di-frontend-pm]');
    $user_id = get_current_user_id();
    $args = array(
        'post_type'     => 'bidding',
//        'author'        =>  $current_user->ID,
        'orderby'       =>  'post_date',
        'order'         =>  'ASC',
//        'posts_per_page' => 1
    );

//    $user_id = get_current_user_id();
    $args = array(
        'post_type'     => 'alsp_listing',
        'author'        =>  $user_id,
        'orderby'       =>  'post_date',
        'order'         =>  'ASC',
        'posts_per_page' => -1
    );
    $current_user_posts = get_posts( $args );

    $post_array = array();
    if ( count($current_user_posts)>0 ) {
        foreach ( $current_user_posts as $post ) :
            setup_postdata( $post );
            $post_array[] = $post->ID;
//            echo '<br>';
        endforeach;
        wp_reset_postdata();
    }

    $applications = get_posts(array(
        'numberposts'	=> -1,
        'post_type'		=> 'bidding',
        'meta_query'	=> array(
//            'relation'		=> 'AND',
            array(
                'key'	 	=> 'job',
                'value'	  	=> $post_array,
                'compare' 	=> 'IN',
            ),
//            array(
//                'key'	  	=> 'featured',
//                'value'	  	=> '1',
//                'compare' 	=> '=',
//            ),
        ),
    ));
    if ( count($applications)>0 ) {
        foreach ( $applications as $post ) :
            setup_postdata( $post );
            echo $post->post_title;
        endforeach;
        wp_reset_postdata();
    }

?>