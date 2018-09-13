<?php
global $pacz_settings;
$title  = $el_position = $el_class = '';
extract( shortcode_atts( array(
            'title' => '',
            "container_bg_color" => '#fafafa',
             "orientation" => 'horizontal', // horizental, vertical
             "style" => 'style1',
            'el_class' => '',
        ), $atts ) );
$output = '';

$id = uniqid();

$output = '<ul class="pacz-tabs-tabs">';
if ( preg_match_all( "/(.?)\[(vc_tab)\b(.*?)(?:(\/))?\]/s", $content, $matches ) ) {
        for ( $i = 0; $i < count( $matches[ 0 ] ); $i++ ) {
            $matches[ 3 ][ $i ] = shortcode_parse_atts( $matches[ 3 ][ $i ] );
        }
        for ( $i = 0; $i < count( $matches[ 0 ] ); $i++ ) {
            $icon = isset($matches[ 3 ][ $i ][ 'icon' ]) ? $matches[ 3 ][ $i ][ 'icon' ] : '';
            $icon_color = isset($matches[ 3 ][ $i ][ 'icon_color' ]) ? $matches[ 3 ][ $i ][ 'icon_color' ] : '';
            if($icon == '') {
                $output .= '<li><a href="#'. $matches[ 3 ][ $i ][ 'tab_id' ] .'">' . $matches[ 3 ][ $i ][ 'title' ] . '</a></li>';
            } else {
                if(!empty( $icon )) {
                    $icon = (strpos($icon, 'pacz-') !== FALSE) ? ( $icon ) : ( 'pacz-'.$icon);    
                } else {
                    $icon = '';
                }
                $output .= '<li class="tab-with-icon"><a href="#'. $matches[ 3 ][ $i ][ 'tab_id' ] .'"><i style="color:'.$icon_color.'" class="' . $icon . '"></i>' . $matches[ 3 ][ $i ][ 'title' ] . '</a></li>';
            }
            
        }
}

$output .= '</ul>';
$output .= '<div class="pacz-tabs-panes">';
$output .= "\n\t\t\t".wpb_js_remove_wpautop( $content );
$output .= '<div class="clearboth"></div></div>';

echo '<div id="pacz-tabs-'.$id.'" class="pacz-tabs '.$orientation.'-style '.$style.'-tabs ' . $el_class . '">' . $output . '<div class="clearboth"></div></div>';


// Get global JSON contructor object for styles and create local variable
global $classiadspro_dynamic_styles;
$classiadspro_styles = '';
    
if($style != 'style3') {
$classiadspro_styles .= '
                #pacz-tabs-'.$id.' .pacz-tabs-tabs li.ui-state-active > a, #pacz-tabs-'.$id.' .pacz-tabs-panes .inner-box{
                    background-color: '.$container_bg_color.';
                }';
}
if($style == 'style1'){
$classiadspro_styles .= '
                #pacz-tabs-'.$id.' .pacz-tabs-tabs li.ui-state-active a, #pacz-tabs-'.$id.' .pacz-tabs-tabs li.ui-state-active a i{
                    color: '.$pacz_settings['accent-color'].' !important;
                }';  
}

// Hidden styles node for head injection after page load through ajax
echo '<div id="ajax-'.$id.'" class="pacz-dynamic-styles">';
echo '<!-- ' . pacz_clean_dynamic_styles($classiadspro_styles) . '-->';
echo '</div>';


// Export styles to json for faster page load
$classiadspro_dynamic_styles[] = array(
  'id' => 'ajax-'.$id ,
  'inject' => $classiadspro_styles
);
