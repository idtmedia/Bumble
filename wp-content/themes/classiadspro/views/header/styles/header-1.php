<?php 
/**
 * template part for Header. views/header/styles
 *
 * @author      Artbees
 * @package     jupiter/views
 * @version     5.0.0
 */
global $woocommerce, $mk_options;

    /*
    * These options comes from header shortcode and will only be used to override the header options through shortcode.
    */
    $header_class = array(
        'sh_id' => isset($view_params['id']) ? $view_params['id'] : Mk_Static_Files::shortcode_id(),
        'is_shortcode' => isset($view_params['is_shortcode']) ? $view_params['is_shortcode'] : false,
        'sh_toolbar' => isset($view_params['toolbar']) ? esc_attr( $view_params['toolbar'] ) : '',
        'sh_is_transparent' => isset($view_params['is_transparent']) ? $view_params['is_transparent'] : '',
        'sh_header_style' => isset($view_params['header_styles']) ? esc_attr( $view_params['header_styles'] ) : '',
        'sh_header_align' => isset($view_params['header_align']) ? esc_attr( $view_params['header_align'] ) : '',
        'sh_hover_styles' => isset($view_params['hover_styles']) ? esc_attr( $view_params['hover_styles'] ) : esc_attr( $mk_options['main_nav_hover'] ),
        'el_class' => isset($view_params['el_class']) ? esc_attr( $view_params['el_class'] ) : '',
    );
    
    $is_transparent = (isset($view_params['is_transparent'])) ? ($view_params['is_transparent'] == 'false' ? false : is_header_transparent()) : is_header_transparent();
    $is_shortcode = $header_class['is_shortcode'];
    $menu_location = isset($view_params['menu_location']) ? esc_attr( $view_params['menu_location'] ) : '';
    
    $show_logo = isset($view_params['logo']) ? $view_params['logo'] : false;
    $seconday_show_logo = isset($view_params['burger_icon']) ? $view_params['burger_icon'] : false;
    $show_cart = isset($view_params['woo_cart']) ? $view_params['woo_cart'] : false;
    $search_icon = isset($view_params['search_icon']) ? $view_params['search_icon'] : false;

?> 
<?php if(is_header_and_title_show($is_shortcode)) : ?>
    <header <?php echo get_header_json_data($is_shortcode, $header_class['sh_header_style']); ?> <?php echo mk_get_header_class($header_class); ?> <?php echo get_schema_markup('header'); ?>>
        <?php if (is_header_show($is_shortcode)): ?>
            <div class="mk-header-holder">
                <?php if ( is_header_toolbar_show() === 'true' && $is_shortcode === false ) {
                    mk_get_header_view( 'holders', 'toolbar' ); 
                } ?>
                <div class="mk-header-inner add-header-height">

                    <div class="mk-header-bg <?php echo mk_get_bg_cover_class($mk_options['header_size']); ?>"></div>

                    <?php if (is_header_toolbar_show($is_shortcode) == 'true') { ?>
                        <div class="mk-toolbar-resposnive-icon"><?php Mk_SVG_Icons::get_svg_icon_by_class_name(true, 'mk-icon-chevron-down'); ?></div>
                    <?php } ?>

                    <?php if($mk_options['header_grid'] == 'true'){ ?>
                            <div class="mk-grid header-grid">
                    <?php } ?>

                            <div class="mk-header-nav-container one-row-style menu-hover-style-<?php echo esc_attr( $header_class['sh_hover_styles'] ); ?>" <?php echo get_schema_markup('nav'); ?>>
                                <?php
                                    mk_get_header_view('master', 'main-nav', ['menu_location' => $menu_location, 'logo_middle' => $mk_options['logo_in_middle']]);
                                    
                                    if ( ( $mk_options['header_search_location'] === 'beside_nav' || $mk_options['header_search_location'] === 'fullscreen_search' ) && $search_icon != 'false' ) { 
                                        mk_get_header_view( 'global', 'nav-side-search', ['header_style' => 1] );
                                    }
                                    
                                    if ( $woocommerce && $mk_options['woocommerce_catalog'] === 'false' && $mk_options['shopping_cart'] === 'true' && $show_cart != 'false' ) { 
                                        mk_get_header_view( 'master', 'checkout', ['header_style' => 1] );
                                    }
                                    
                                    if ( ! empty( $mk_options['seondary_header_for_all'] ) && $mk_options['seondary_header_for_all'] === 'true' && $seconday_show_logo != 'false' ) {
                                        mk_get_header_view( 'global', 'secondary-menu-burger-icon', ['is_shortcode' => $is_shortcode, 'header_style' => 1] );
                                    }
                                ?>
                            </div>
                            <?php    
                                mk_get_header_view('global', 'main-menu-burger-icon', ['header_style' => 1]);                            
                                if ( ! empty( $mk_options['hide_header_logo'] ) && $mk_options['hide_header_logo'] === 'true' && $show_logo != 'false' ) { 
                                    mk_get_header_view( 'master', 'logo' );
                                }
                            ?>

                    <?php if($mk_options['header_grid'] == 'true'){ ?>
                        </div>
                    <?php } ?>

                    <div class="mk-header-right">
                        <?php
                            do_action('header_right_before');
                            
                            if ( ! empty( $mk_options['header_start_tour_text'] ) ) {
                                mk_get_header_view('master', 'start-tour');
                            }
                            
                            if ( ! empty( $mk_options['header_search_location'] ) && $mk_options['header_search_location'] === 'header' ) {
                                mk_get_header_view('global', 'search', ['location' => 'header']);
                            }
                            
                            if ( ! empty( $mk_options['header_social_location'] ) && $mk_options['header_social_location'] === 'header' ) {
                                mk_get_header_view('global', 'social', ['location' => 'header']);
                            }
                            
                            do_action('header_right_after');
                        ?>
                    </div>

                </div>
                <?php mk_get_header_view('global', 'responsive-menu', ['menu_location' => $menu_location, 'is_shortcode' => $is_shortcode]); ?>        
            </div>
        <?php endif;// End for option to disable header ?>

        <?php mk_get_header_view('global', 'header-sticky-padding', ['is_shortcode' => $is_shortcode]); ?>
        <?php if(!$is_transparent) mk_get_view('layout', 'title', false, ['is_shortcode' => $is_shortcode]); ?>
        
    </header>
<?php endif; // End to disale whole header