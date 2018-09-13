<?php




add_action( 'admin_notices',  'pacz_detect_check_post_limits' );

function pacz_detect_check_post_limits(){

    $screen = get_current_screen();
    if( $screen->id != 'nav-menus' ) return;

    $currentPostVars_count = pacz_detect_count_post_vars();
        

    $r = array(); //restrictors

    $r['suhosin_post_maxvars'] = ini_get( 'suhosin.post.max_vars' );
    $r['suhosin_request_maxvars'] = ini_get( 'suhosin.request.max_vars' );
    $r['max_input_vars'] = ini_get( 'max_input_vars' );

    if( $r['suhosin_post_maxvars'] != '' ||
        $r['suhosin_request_maxvars'] != '' ||
        $r['max_input_vars'] != '' ){

        if( ( $r['suhosin_post_maxvars'] != '' && $r['suhosin_post_maxvars'] < 1000 ) || 
            ( $r['suhosin_request_maxvars']!= '' && $r['suhosin_request_maxvars'] < 1000 ) ){
            $message[] = esc_html__( "Your server is running Suhosin, and your current maxvars settings may limit the number of menu items you can save." , 'classiadspro' );
        }

        //150 ~ 10 left
        foreach( $r as $key => $val ){
            if( $val > 0 ){
                if( $val - $currentPostVars_count < 150 ){
                    $message[] = esc_html__( "You are approaching the post variable limit imposed by your server configuration.  Exceeding this limit may automatically delete menu items when you save.  Please increase your <strong>max_input_var</strong> directive in php.ini." , 'classiadspro' );
                }
            }
        }

        if( !empty( $message ) ): ?>
        <div class="error">
            <p>
            <h4><?php esc_html_e( 'Menu Item Limit Warning' , 'classiadspro' ); ?></h4>
            <ul>
            <?php foreach( $message as $m ): ?>
                <li><?php echo esc_attr($m); ?></li>
            <?php endforeach; ?>
            </ul>

            <?php
            if( $r['max_input_vars'] != '' ) echo "<strong>max_input_vars</strong> :: ". 
                $r['max_input_vars']. " <br/>";
            if( $r['suhosin_post_maxvars'] != '' ) echo "<strong>suhosin.post.max_vars</strong> :: ".$r['suhosin_post_maxvars']. " <br/>";
            if( $r['suhosin_request_maxvars'] != '' ) echo "<strong>suhosin.request.max_vars</strong> :: ". $r['suhosin_request_maxvars'] ." <br/>";
            
            echo "<br/><strong>".esc_html__( 'Menu Item Post variable count on last save', 'classiadspro' )."</strong> :: ". $currentPostVars_count."<br/>";
            if( $r['max_input_vars'] != '' ){
                $estimate = ( $r['max_input_vars'] - $currentPostVars_count ) / 14;
                if( $estimate < 0 ) $estimate = 0;
                echo "<strong>".esc_html__( 'Approximate remaining menu items' , 'classiadspro' )."</strong> :: " . floor( $estimate );
            };

            ?>

            </p>
        </div>
        <?php endif; 

    }

}
function pacz_detect_count_post_vars() {

    if( isset( $_POST['save_menu'] ) ){

        $count = 0;
        foreach( $_POST as $key => $arr ){
            $count+= count( $arr );
        }

        update_option( 'pacz_detect-post-var-count' , $count );
    }
    else{
        $count = get_option( 'pacz_detect-post-var-count' , 0 );
    }

    return $count;
}