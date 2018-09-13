<?php


	
if (!function_exists('global_get_post_id')) {
     function global_get_post_id()
     {
          if(function_exists('is_woocommerce') && is_woocommerce() && is_shop()) {

              return wc_get_page_id( 'shop' );

          } else if(is_singular()) {

            global $post;

            return $post->ID;

          }else {

            return false;
          }
     }
}


add_filter( 'locale', 'pacz_theme_localized' );
function pacz_theme_localized( $locale ) {
      if ( isset( $_GET['l'] ) )
      {
          return esc_attr( $_GET['l'] );
      }
      return $locale;
}


add_action('after_setup_theme', 'pacz_theme_langauge');

function pacz_theme_langauge(){
    load_theme_textdomain('classiadspro', get_stylesheet_directory() . '/languages');
}



/* 
Adds shortcodes dynamic css into footer.php
*/
if (!function_exists('pacz_dynamic_css_injection')) {
     function pacz_dynamic_css_injection()
     {

      global $classiadspro_json, $classiadspro_styles;  
    
    echo '<script type="text/javascript">';
    

    $backslash_styles = str_replace('\\', '\\\\', $classiadspro_styles);
    $clean_styles = preg_replace('!\s+!', ' ', $backslash_styles);
    $clean_styles_w = str_replace("'", "\"", $clean_styles);
    $is_admin_bar = is_admin_bar_showing() ? 'true' : 'false';
    $classiadspro_json_encode = json_encode($classiadspro_json);
    echo '  
    php = {
        hasAdminbar: '.$is_admin_bar.',
        json: ('.$classiadspro_json_encode.' != null) ? '.$classiadspro_json_encode.' : "",
        styles:  \''.$clean_styles_w.'\'
      };
      
    var styleTag = document.createElement("style"),
      head = document.getElementsByTagName("head")[0];

    styleTag.type = "text/css";
    styleTag.innerHTML = php.styles;
    head.appendChild(styleTag);
    </script>';

    

     }
}

add_action('wp_enqueue_scripts', 'pacz_dynamic_css_injection');
/*-----------------*/


function pacz_clean_dynamic_styles($value) {

  $clean_styles = preg_replace('!\s+!', ' ', $value);
  $clean_styles_w = str_replace("'", "\"", $clean_styles);

  return $clean_styles_w;

}

function pacz_clean_init_styles($value) {

  $backslash_styles = str_replace('\\', '\\\\', $value);
  $clean_styles = preg_replace('!\s+!', ' ', $backslash_styles);
  $clean_styles_w = str_replace("'", "\"", $clean_styles);

  return $clean_styles_w;

}



/*
 * Convert theme settings to a globaly accessible vaiable throught the theme.
 */
if (!function_exists('pacz_set_accent_color_global')) {
      function pacz_set_accent_color_global()
      {
            
            global $pacz_settings;
            
            if (isset($_GET['skin'])) {
                  
                  $GLOBALS['pacz_accent_color'] = "#" . $_GET['skin'];
                  
            } else {
                  
                  $GLOBALS['pacz_accent_color'] = isset($pacz_settings['accent-color']) ? $pacz_settings['accent-color'] : '#16a085';
                  
            }
            
      }
}

add_action('wp_loaded', 'pacz_set_accent_color_global');
/*-----------------*/




function pacz_thumbnail_image_gen($image, $width, $height) {
   $default = includes_url() . 'images/media/default.png';
   if(($image == $default) || empty($image)) {
	   
		if(class_exists('alsp_plugin')){
			global $ALSP_ADIMN_SETTINGS;
			 $nologo_url = $ALSP_ADIMN_SETTINGS['alsp_nologo_url']['url'];
			if(isset($nologo_url)){
			$default_url = $ALSP_ADIMN_SETTINGS['alsp_nologo_url']['url'];
			}else{
				$default_url = PACZ_THEME_IMAGES . '/dummy-images/dummy-'.mt_rand(1,7).'.png';
			}
		}else{
			$default_url = PACZ_THEME_IMAGES . '/dummy-images/dummy-'.mt_rand(1,7).'.png';
		}	

      if(!empty($width) && !empty($height)) {
         $image = bfi_thumb($default_url, array(
          'width' => $width,
          'height' => $height,
          'crop' => true
          ));
          return $image; 
      }
      return $default_url;
   } else {
      return $image;
   }

}


if (!function_exists('pacz_get_shop_id')) {
     function pacz_get_shop_id()
     {
          if(function_exists('is_woocommerce') && is_woocommerce() && is_archive()) {

              return wc_get_page_id( 'shop' );

          } else {

            return false;
          }
     }
}

if (!function_exists('pacz_is_woo_archive')) {
     function pacz_is_woo_archive()
     {
          if(function_exists('is_woocommerce') && is_woocommerce() && is_archive()) {

              return wc_get_page_id( 'shop' );

          } else {

            return false;
          }
     }
}


if (!function_exists('global_get_post_id')) {
     function global_get_post_id()
     {
          if(function_exists('is_woocommerce') && is_woocommerce() && is_shop()) {

              return wc_get_page_id( 'shop' );

          } else if(is_singular() || is_home()) {

            global $post;

            return $post->ID;

          }else {

            return false;
          }
     }
}



/*
 * Fixes empty p tags without changing autop functionality.
 */

if (!function_exists('pacz_shortcode_empty_paragraph_fix')) {
      function pacz_shortcode_empty_paragraph_fix($content)
      {
            $array = array(
                  '<p>[' => '[',
                  ']</p>' => ']',
                  ']<br />' => ']'
            );
            
            $content = strtr($content, $array);
            
            return $content;
      }
}
add_filter('the_content', 'pacz_shortcode_empty_paragraph_fix');
/*-----------------*/


// Register your custom function to override some LayerSlider data
add_action('layerslider_ready', 'my_layerslider_overrides');
function my_layerslider_overrides() {

    // Disable auto-updates
    $GLOBALS['lsAutoUpdateBox'] = false;
}


/*
 * Adds WP ajax library path.
 */
if (!function_exists('pacz_add_ajax_library')) {
      function pacz_add_ajax_library()
      {
            echo '<script type="text/javascript">';
            echo 'var ajaxurl = "' . admin_url('admin-ajax.php') . '"';
            echo '</script>';
            
      }
}

add_action('wp_enqueue_scripts', 'pacz_add_ajax_library');
/*-----------------*/



/*
 * Adds Debugging tool for support, outputs theme name and version.
 */
if (!function_exists('pacz_theme_debugging_info')) {
      function pacz_theme_debugging_info()
      {
            
            $theme_data = wp_get_theme();
            echo '<meta name="generator" content="' . wp_get_theme() . ' ' . $theme_data['Version'] . '" />' . "\n";
            
      }
}
add_action('wp_enqueue_scripts', 'pacz_theme_debugging_info');
/*-----------------*/



/*
Removes version paramerters from scripts and styles.
*/
if (!function_exists('pacz_remove_wp_ver_css_js')) {
      function pacz_remove_wp_ver_css_js($src)
      {
            global $pacz_settings;
            if ($pacz_settings['remove-js-css-ver']) {
                  if (strpos($src, 'ver='))
                        $src = remove_query_arg('ver', $src);
            }
            return $src;
      }
}
add_filter('style_loader_src', 'pacz_remove_wp_ver_css_js', 9999);
add_filter('script_loader_src', 'pacz_remove_wp_ver_css_js', 9999);



/*
 * Converts Hex value to RGBA if needed.
 */
if (!function_exists('pacz_convert_rgba')) {
      function pacz_convert_rgba($colour, $alpha)
      {
            if (!empty($colour)) {
                  if ($alpha >= 0.95) {
                        return $colour; // If alpha is equal 1 no need to convert to RGBA, so we are ok with it. :)
                  } else {
                        if ($colour[0] == '#') {
                              $colour = substr($colour, 1);
                        }
                        if (strlen($colour) == 6) {
                              list($r, $g, $b) = array(
                                    $colour[0] . $colour[1],
                                    $colour[2] . $colour[3],
                                    $colour[4] . $colour[5]
                              );
                        } elseif (strlen($colour) == 3) {
                              list($r, $g, $b) = array(
                                    $colour[0] . $colour[0],
                                    $colour[1] . $colour[1],
                                    $colour[2] . $colour[2]
                              );
                        } else {
                              return false;
                        }
                        $r      = hexdec($r);
                        $g      = hexdec($g);
                        $b      = hexdec($b);
                        $output = array(
                              'red' => $r,
                              'green' => $g,
                              'blue' => $b
                        );
                        
                        return 'rgba(' . implode($output, ',') . ',' . $alpha . ')';
                  }
            }
      }
}
/*-----------------*/



/*
 * Converts given php native time() to human time. needful to twitter widget.
 */
if (!function_exists('pacz_ago')) {
      function pacz_ago($time)
      {
             $periods = array(
               esc_html__("second", 'classiadspro'),
               esc_html__("minute", 'classiadspro'),
               esc_html__("hour", 'classiadspro'),
               esc_html__("day", 'classiadspro'),
               esc_html__("week", 'classiadspro'),
               esc_html__("month", 'classiadspro'),
               esc_html__("year", 'classiadspro'),
               esc_html__("decade", 'classiadspro')
          );
          $lengths = array(
               "60",
               "60",
               "24",
               "7",
               "4.35",
               "12",
               "10"
          );
          
          $now = time();
          
          $difference = $now - $time;
          $tense      = esc_html__("ago", 'classiadspro');
          
          for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
               $difference /= $lengths[$j];
          }
          
          $difference = round($difference);
          
          if ($difference != 1) {
               $periods[$j] .= "s";
          }
          
          return "$difference $periods[$j] {$tense} ";
      }
}
/*-----------------*/





/*
 * Darken given hex value by defined classiadspro.
 */
if (!function_exists('pacz_hex_darker')) {
      function pacz_hex_darker($hex, $classiadspro = 30)
      {
            $new_hex = '';
            if ($hex == '' || $classiadspro == '') {
                  return false;
            }
            
            $hex = str_replace('#', '', $hex);
            
            $base['R'] = hexdec($hex{0} . $hex{1});
            $base['G'] = hexdec($hex{2} . $hex{3});
            $base['B'] = hexdec($hex{4} . $hex{5});
            
            
            foreach ($base as $k => $v) {
                  $amount      = $v / 100;
                  $amount      = round($amount * $classiadspro);
                  $new_decimal = $v - $amount;
                  
                  $new_hex_component = dechex($new_decimal);
                  if (strlen($new_hex_component) < 2) {
                        $new_hex_component = "0" . $new_hex_component;
                  }
                  $new_hex .= $new_hex_component;
            }
            
            return '#' . $new_hex;
      }
}
/*-----------------*/


/**
 * Content Width Calculator
 *
 * Retrieves the content width based on $grid-width
 *
 * @param string  $layout param
 */
if (!function_exists('pacz_content_width')) {
      function pacz_content_width($layout = 'full')
      {
            
            global $pacz_settings;
            
            if ($layout == 'full') {
                  
                  return $pacz_settings['grid-width'] - 40;
            } else {
                  
                  return round(($pacz_settings['content-width'] / 100) * $pacz_settings['grid-width']) - 40;
            }
      }
}
/*-----------------*/




/**
 * returns filter WP_query in related portfolio posts.
 *
 * @param (int)   post ID of the current post
 * @param (int)   Posts count
 * @param (bool)  Checks if filter based on category or tags.
 * @return WP_query query object
 */
if (!function_exists('pacz_get_related_posts')) {
      function pacz_get_related_posts($post_id, $count = 4, $cat = true)
      {
            $query = new WP_Query();
            
            if ($cat == true) {
                  $args  = '';
                  $args  = wp_parse_args($args, array(
                        'post__not_in' => array(
                              $post_id
                        ),
                        'category__in' => wp_get_post_categories($post_id),
                        'showposts' => $count,
                        'ignore_sticky_posts' => 0
                  ));
                  $query = new WP_Query($args);
                  
            } else {
                  
                  $tags   = wp_get_post_tags($post_id);
                  $tagIDs = array();
                  
                  $tagcount = count($tags);
                  
                  for ($i = 0; $i < $tagcount; $i++) {
                        $tagIDs[$i] = $tags[$i]->term_id;
                  }
                  
                  $query = new WP_Query(array(
                        'tag__in' => $tagIDs,
                        'post__not_in' => array(
                              $post_id
                        ),
                        'showposts' => $count,
                        'ignore_sticky_posts' => 0
                  ));
                  
            }
            
            return $query;
      }
}
/*-----------------*/





/**
 * Get custom sidebars from theme options.
 *
 * @return list of sidebars in array.
 */
if (!function_exists('pacz_get_custom_sidebar')) {
      function pacz_get_custom_sidebar()
      {
            $options               = array();
            $custom_sidebars       = get_option('pacz_settings');
            $custom_sidebars_array = isset($custom_sidebars['custom-sidebar']) ? $custom_sidebars['custom-sidebar'] : null;
            if ($custom_sidebars_array != null) {
                  foreach ($custom_sidebars_array as $key => $value) {
                        $options[$value] = $value;
                  }
            }
            return $options;
            
      }
}



/**
 * Get attachment ID from given URL
 *
 * @return attachment ID.
 */
if (!function_exists('pacz_get_attachment_id_from_url')) {
      function pacz_get_attachment_id_from_url($attachment_url = '')
      {
            
            global $wpdb;
            $attachment_id = false;
            
            // If there is no url, return.
            if ('' == $attachment_url)
                  return;
            
            // Get the upload directory paths
            $upload_dir_paths = wp_upload_dir();
            
            // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
            if (false !== strpos($attachment_url, $upload_dir_paths['baseurl'])) {
                  
                  // If this is the URL of an auto-generated thumbnail, get the URL of the original image
                  $attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);
                  
                  // Remove the upload path base directory from the attachment URL
                  $attachment_url = str_replace($upload_dir_paths['baseurl'] . '/', '', $attachment_url);
                  
                  // Finally, run a custom database query to get the attachment ID from the modified attachment URL
                  $attachment_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
                  
            }
            
            return $attachment_id;
      }
}
/*-----------------*/






function pacz_get_fontfamily( $element_name, $id, $font_family, $font_type ) {
    $output = '';
    global $classiadspro_styles;
    if ( $font_type == 'google' ) {
        if ( !function_exists( "my_strstr" ) ) {
            function my_strstr( $haystack, $needle, $before_needle = false ) {
                if ( !$before_needle ) return strstr( $haystack, $needle );
                else return substr( $haystack, 0, strpos( $haystack, $needle ) );
            }
        }
        wp_enqueue_style( $font_family, '//fonts.googleapis.com/css?family=' .$font_family.':100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic,100,200,300,400,500,600,700,800,900' , false, false, 'all' );
        $format_name = strpos( $font_family, ':' );
        if ( $format_name !== false ) {
            $google_font =  my_strstr( str_replace( '+', ' ', $font_family ), ':', true );
        } else {
            $google_font = str_replace( '+', ' ', $font_family );
        }
        $classiadspro_styles .= $element_name.$id.' {font-family: "'.$google_font.'"}';

    } else if ( $font_type == 'fontface' ) {

            $stylesheet = FONTFACE_DIR.'/fontface_stylesheet.css';
            $font_dir = FONTFACE_URI;
            if ( file_exists( $stylesheet ) ) {
                $file_content = wp_remote_get( $stylesheet );
                if ( preg_match( "/@font-face\s*{[^}]*?font-family\s*:\s*('|\")$font_family\\1.*?}/is", $file_content, $match ) ) {
                    $fontface_style = preg_replace( "/url\s*\(\s*['|\"]\s*/is", "\\0$font_dir/", $match[0] )."\n";
                }
                $classiadspro_styles .= "\n" . $fontface_style ."\n";
                $classiadspro_styles .= $element_name.$id.' {font-family: "'.$font_family.'"}';
            }

        } else if ( $font_type == 'safefont' ) {
            $classiadspro_styles .= $element_name.$id.' {font-family: '.$font_family.' !important}';
        }

    return $output;
}


/* 
Uses get_the_excerpt() to print an excerpt by specifying a maximium number of characters. 
*/
function the_excerpt_max_charlength($charlength) {
      $excerpt = get_the_excerpt();
      $charlength++;

      if ( mb_strlen( $excerpt ) > $charlength ) {
            $subex = mb_substr( $excerpt, 0, $charlength - 5 );
            $exwords = explode( ' ', $subex );
            $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
            if ( $excut < 0 ) {
                  echo mb_substr( $subex, 0, $excut );
            } else {
                  echo mb_substr( $excerpt, 0, $charlength - 5 );
            }
            echo '...';
      } else {
            echo wp_kses_post($excerpt);
      }
}






if (!function_exists('pacz_get_shop_id')) {
     function pacz_get_shop_id()
     {
          if(function_exists('is_woocommerce') && is_woocommerce() && is_archive()) {

              return wc_get_page_id( 'shop' );

          } else {

            return false;
          }
     }
}

if (!function_exists('pacz_is_shop')) {
     function pacz_is_shop()
     {
          if(function_exists('is_woocommerce') && is_woocommerce() && is_archive()) {

              return true;

          } else {

            return false;
          }
     }
}


if (!function_exists('global_get_post_id')) {
     function global_get_post_id()
     {
          if(function_exists('is_woocommerce') && is_woocommerce() && is_shop()) {

              return wc_get_page_id( 'shop' );

          } else if(is_singular() || is_home()) {

            global $post;

            return $post->ID;

          }else {

            return false;
          }
     }
}


/**
 * Adding font icons in HTML document to prevent issues when using CDN
 */
if (!function_exists('pacz_enqueue_font_icons')) {
  function pacz_enqueue_font_icons() {
      
      $styles_dir = PACZ_THEME_DIR_URI . '/styles';
      $output = "

      @font-face {
        font-family: 'PaczWPTokens';
        src: url('{$styles_dir}/pacz-icons/PaczWPTokens.eot');
        src: url('{$styles_dir}/pacz-icons/PaczWPTokens.eot?#iefix') format('embedded-opentype'), 
        url('{$styles_dir}/pacz-icons/PaczWPTokens.woff') format('woff'), 
        url('{$styles_dir}/pacz-icons/PaczWPTokens.ttf') format('truetype'), 
        url('{$styles_dir}/pacz-icons/PaczWPTokens.svg#PaczWPTokens') format('svg');
        font-weight: 400;
        font-style: normal;
      }

      @font-face {
        font-family: 'FontAwesome';
        src:url('{$styles_dir}/awesome-icons/fontawesome-webfont.eot?v=4.2');
        src:url('{$styles_dir}/awesome-icons/fontawesome-webfont.eot?#iefix&v=4.2') format('embedded-opentype'),
        url('{$styles_dir}/awesome-icons/fontawesome-webfont.woff?v=4.2') format('woff'),
        url('{$styles_dir}/awesome-icons/fontawesome-webfont.ttf?v=4.2') format('truetype'), 
        url('{$styles_dir}/awesome-icons/fontawesome-webfont.svg#FontAwesome') format('svg');;
        font-weight: normal;
        font-style: normal;
      }

      @font-face {
        font-family: 'star';
        src: url('{$styles_dir}/woocommerce-fonts/star.eot');
        src: url('{$styles_dir}/woocommerce-fonts/star.eot?#iefix') format('embedded-opentype'), 
        url('{$styles_dir}/woocommerce-fonts/star.woff') format('woff'), 
        url('{$styles_dir}/woocommerce-fonts/star.ttf') format('truetype'), 
        url('{$styles_dir}/woocommerce-fonts/star.svg#star') format('svg');
        font-weight: normal;
        font-style: normal;
      }

      @font-face {
        font-family: 'WooCommerce';
        src: url('{$styles_dir}/woocommerce-fonts/WooCommerce.eot');
        src: url('{$styles_dir}/woocommerce-fonts/WooCommerce.eot?#iefix') format('embedded-opentype'), 
        url('{$styles_dir}/woocommerce-fonts/WooCommerce.woff') format('woff'), 
        url('{$styles_dir}/woocommerce-fonts/WooCommerce.ttf') format('truetype'), 
        url('{$styles_dir}/woocommerce-fonts/WooCommerce.svg#WooCommerce') format('svg');
        font-weight: normal;
        font-style: normal;
      }

      @font-face {
        font-family: 'Flaticon';
        src: url('{$styles_dir}/line-icon-set/flaticon.eot');
        src: url('{$styles_dir}/line-icon-set/flaticon.eot#iefix') format('embedded-opentype'),
        url('{$styles_dir}/line-icon-set/flaticon.woff') format('woff'),
        url('{$styles_dir}/line-icon-set/flaticon.ttf') format('truetype'),
        url('{$styles_dir}/line-icon-set/flaticon.svg') format('svg');
        font-weight: normal;
        font-style: normal;
      }
	  
	   @font-face {
        font-family: 'pacz-fic1';
        src: url('{$styles_dir}/flaticon/collection1/pacz-fic1.eot');
        src: url('{$styles_dir}/flaticon/collection1/pacz-fic1.eot#iefix') format('embedded-opentype'),
        url('{$styles_dir}/flaticon/collection1/pacz-fic1.woff') format('woff'),
        url('{$styles_dir}/flaticon/collection1/pacz-fic1.ttf') format('truetype'),
        url('{$styles_dir}/flaticon/collection1/pacz-fic1.svg') format('svg');
        font-weight: normal;
        font-style: normal;
      }
	  
	   @font-face {
        font-family: 'pacz-fic2';
        src: url('{$styles_dir}/flaticon/collection2/pacz-fic2.eot');
        src: url('{$styles_dir}/flaticon/collection2/pacz-fic2.eot#iefix') format('embedded-opentype'),
        url('{$styles_dir}/flaticon/collection2/pacz-fic2.woff') format('woff'),
        url('{$styles_dir}/flaticon/collection2/pacz-fic2.ttf') format('truetype'),
        url('{$styles_dir}/flaticon/collection2/pacz-fic2.svg') format('svg');
        font-weight: normal;
        font-style: normal;
      }
	  
	   @font-face {
        font-family: 'pacz-fic3';
        src: url('{$styles_dir}/flaticon/collection3/pacz-fic3.eot');
        src: url('{$styles_dir}/flaticon/collection3/pacz-fic3.eot#iefix') format('embedded-opentype'),
        url('{$styles_dir}/flaticon/collection3/pacz-fic3.woff') format('woff'),
        url('{$styles_dir}/flaticon/collection3/pacz-fic3.ttf') format('truetype'),
        url('{$styles_dir}/flaticon/collection3/pacz-fic3.svg') format('svg');
        font-weight: normal;
        font-style: normal;
      }
	  
	   @font-face {
        font-family: 'pacz-fic4';
        src: url('{$styles_dir}/flaticon/collection4/pacz-fic4.eot');
        src: url('{$styles_dir}/flaticon/collection4/pacz-fic4.eot#iefix') format('embedded-opentype'),
        url('{$styles_dir}/flaticon/collection4/pacz-fic4.woff') format('woff'),
        url('{$styles_dir}/flaticon/collection4/pacz-fic4.ttf') format('truetype'),
        url('{$styles_dir}/flaticon/collection4/pacz-fic4.svg') format('svg');
        font-weight: normal;
        font-style: normal;
      }
	  
	   @font-face {
        font-family: 'pacz-fic';
        src: url('{$styles_dir}/flaticon/custom/pacz-fic.eot');
        src: url('{$styles_dir}/flaticon/custom/pacz-fic.eot#iefix') format('embedded-opentype'),
        url('{$styles_dir}/flaticon/custom/pacz-fic.woff') format('woff'),
        url('{$styles_dir}/flaticon/custom/pacz-fic.ttf') format('truetype'),
        url('{$styles_dir}/flaticon/custom/pacz-fic.svg') format('svg');
        font-weight: normal;
        font-style: normal;
      }

      @font-face {
        font-family: 'Pe-icon-line';
        src:url('{$styles_dir}/pe-line-icons/Pe-icon-line.eot?lqevop');
        src:url('{$styles_dir}/pe-line-icons/Pe-icon-line.eot?#iefixlqevop') format('embedded-opentype'),
          url('{$styles_dir}/pe-line-icons/Pe-icon-line.woff?lqevop') format('woff'),
          url('{$styles_dir}/pe-line-icons/Pe-icon-line.ttf?lqevop') format('truetype'),
          url('{$styles_dir}/pe-line-icons/Pe-icon-line.svg?lqevop#Pe-icon-line') format('svg');
        font-weight: normal;
        font-style: normal;
      }
	   @font-face {
        font-family: 'Glyphicons Halflings';
        src:url('{$styles_dir}/fonts/glyphicons-halflings-regular.eot');
        src:url('{$styles_dir}/fonts/glyphicons-halflings-regular.eot?#iefix') format('embedded-opentype'),
          url('{$styles_dir}/fonts/glyphicons-halflings-regular.woff2') format('woff2'),
          url('{$styles_dir}/fonts/glyphicons-halflings-regular.woff') format('woff'),
          url('{$styles_dir}/fonts/glyphicons-halflings-regular.ttf') format('truetype'),
		  url('{$styles_dir}/fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular') format('svg');
        font-weight: normal;
        font-style: normal;
      }
";
      return $output;
  }
}
//////////////////////////////////////////////////////////////////////////
// 
//  Global JSON object to collect all DOM related data
//  todo - move here all VC shortcode settings
//
//////////////////////////////////////////////////////////////////////////

if(!function_exists('create_global_json')){
function create_global_json() {
    $classiadspro_json = array();
    global $classiadspro_json;
}
}
create_global_json();

if(!function_exists('create_global_dynamic_styles')){
function create_global_dynamic_styles() {
    $classiadspro_dynamic_styles = array();
    global $classiadspro_dynamic_styles;
}
}
create_global_dynamic_styles();

/**
 * @param $path
 * @return mixed
 */
function path_convert($path) {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $path = str_replace('/', '\\', $path);
    }
    else {
        $path = str_replace('\\', '/', $path);
    }
    return $path;
}