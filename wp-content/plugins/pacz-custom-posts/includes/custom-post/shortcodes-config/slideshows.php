<?php
/*
vc_map(array(
    "name" => esc_html__("Fade Text Box", "pacz"),
    "base" => "pacz_fade_txt_box",
    "content_element" => true,
    'icon' => 'icon-pacz-content-box vc_pacz_element-icon',
    "as_parent" => array('only' => 'pacz_fade_txt_item'),
    "category" => esc_html__('Slideshows', 'pacz'),
    'params' => array(
        array(
            "type" => "range",
            "heading" => esc_html__("Item Padding", "pacz"),
            "param_name" => "padding",
            "value" => "20",
            "min" => "5",
            "max" => "500",
            "step" => "1",
            "unit" => 'px',
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Animation Speed", "pacz"),
            "param_name" => "animation_speed",
            "value" => "700",
            "min" => "100",
            "max" => "3000",
            "step" => "1",
            "unit" => 'ms',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "heading" => esc_html__("Slideshow Speed", "pacz"),
            "param_name" => "slideshow_speed",
            "value" => "5000",
            "min" => "0",
            "max" => "50000",
            "step" => "1",
            "unit" => 'ms',
            "description" => esc_html__("If set to zero the autoplay will be disabled, any number above zeo will define the delay between each slide transition.", "pacz"),
            'type' => 'range'
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz")
        )
    ),
    "js_view" => 'VcColumnView'
));

vc_map(array(
    "name" => esc_html__("Fade Text Item", "pacz"),
    "base" => "pacz_fade_txt_item",
    "as_child" => array('only' => 'pacz_fade_txt_box'),
    'icon' => 'icon-pacz-content-box vc_pacz_element-icon',
    "content_element" => true,
    "category" => esc_html__('Slideshows', 'pacz'),
    'params' => array(
        
        array(
            "type" => "textfield",
            "heading" => esc_html__("Text", "pacz"),
            "param_name" => "item_txt",
            "value" => "",
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Font Size", "pacz"),
            "param_name" => "item_text_size",
            "value" => "16",
            "min" => "10",
            "max" => "100",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Font Weight", "pacz"),
            "param_name" => "item_font_weight",
            "value" => array(
                esc_html__('Default', "pacz") => "inherit",
                esc_html__('Light', "pacz") => "300",
                esc_html__('Normal', "pacz") => "normal",
                esc_html__('Bold', "pacz") => "bold",
                esc_html__('Bolder', "pacz") => "bolder",
                esc_html__('Extra Bold', "pacz") => "900",
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Text Align", "pacz"),
            "param_name" => "item_text_align",
            "value" => array(
                esc_html__('Left', "pacz") => "left",
                esc_html__('Center', "pacz") => "center",
                esc_html__('Right', "pacz") => "right"
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Font Color", "pacz"),
            "param_name" => "item_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz")
        )
    )
));


vc_map(array(
    "name" => esc_html__("Image Slideshow", "pacz"),
    "base" => "pacz_image_slideshow",
    'icon' => 'icon-pacz-image-slideshow vc_pacz_element-icon',
    "category" => esc_html__('Slideshows', 'pacz'),
    'description' => esc_html__( 'Simple image slideshow.', 'pacz' ),
    "params" => array(

        array(
            "type" => "attach_images",
            "heading" => esc_html__("Add Images", "pacz"),
            "param_name" => "images",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Slideshow Direction", "pacz"),
            "param_name" => "direction",
            "width" => 300,
            "value" => array(
                esc_html__('horizontal', "pacz") => "horizontal",
                esc_html__('Vertical', "pacz") => "vertical"
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "heading" => esc_html__("Slideshow Align?", 'pacz'),
            "description" => esc_html__("", 'pacz'),
            "param_name" => "slideshow_aligment",
            "value" => array(
                esc_html__("Left", 'pacz') => "left",
                esc_html__("Center", 'pacz') => "none",
                esc_html__("Right", 'pacz') => "right"
            ),
            "type" => "dropdown"
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("Width", "pacz"),
            "param_name" => "image_width",
            "value" => "770",
            "min" => "100",
            "max" => "1380",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Height", "pacz"),
            "param_name" => "image_height",
            "value" => "350",
            "min" => "100",
            "max" => "1000",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("Animation Speed", "pacz"),
            "param_name" => "animation_speed",
            "value" => "700",
            "min" => "100",
            "max" => "3000",
            "step" => "1",
            "unit" => 'ms',
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("Slideshow Speed", "pacz"),
            "param_name" => "slideshow_speed",
            "value" => "7000",
            "min" => "1000",
            "max" => "20000",
            "step" => "1",
            "unit" => 'ms',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Direction Nav", "pacz"),
            "param_name" => "direction_nav",
            "value" => "true",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Pagination", "pacz"),
            "param_name" => "pagination",
            "value" => "false",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Margin Bottom", "pacz"),
            "param_name" => "margin_bottom",
            "value" => "20",
            "min" => "0",
            "max" => "500",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz")
        )

    )
));


vc_map( array(
        "name"      => esc_html__( "Tablet Slideshow", "pacz" ),
        "base"      => "pacz_tablet_slideshow",
        'icon' => 'icon-pacz-image-slideshow vc_pacz_element-icon',
        "category" => esc_html__('Slideshows', 'pacz'),
        'description' => esc_html__( 'Slideshow inside a tablet.', 'pacz' ),
        "params"    => array(
            array(
                "heading" => esc_html__( "Tablet Color", 'pacz' ),
                "description" => esc_html__( "", 'pacz' ),
                "param_name" => "tablet_color",
                "value" => array(
                    esc_html__( "Black", 'pacz' )  =>  "black",
                    esc_html__( "White", 'pacz' ) =>  "white",
                ),
                "type" => "dropdown"
            ),
            array(
                "type" => "attach_images",
                "heading" => esc_html__( "Add Images", "pacz" ),
                "param_name" => "images",
                "value" => "",
                "description" => esc_html__( "", "pacz" )
            ),
            array(
                "type" => "range",
                "heading" => esc_html__( "Animation Speed", "pacz" ),
                "param_name" => "animation_speed",
                "value" => "700",
                "min" => "100",
                "max" => "3000",
                "step" => "1",
                "unit" => 'ms',
                "description" => esc_html__( "", "pacz" )
            ),
            array(
                "type" => "range",
                "heading" => esc_html__( "Slideshow Speed", "pacz" ),
                "param_name" => "slideshow_speed",
                "value" => "7000",
                "min" => "1000",
                "max" => "20000",
                "step" => "1",
                "unit" => 'ms',
                "description" => esc_html__( "", "pacz" )
            ),

            array(
                "type" => "toggle",
                "heading" => esc_html__( "Pause on Hover", "pacz" ),
                "param_name" => "pause_on_hover",
                "value" => "false",
                "description" => esc_html__( "Pause the slideshow when hovering over slider, then resume when no longer hovering", "pacz" )
            ),


            array(
                "type" => "dropdown",
                "heading" => esc_html__( "Viewport Animation", "pacz" ),
                "param_name" => "animation",
                "value" => $css_animations,
                "description" => esc_html__( "Viewport animation will be triggered when this element is being viewed when you scroll page down. you only need to choose the animation style from this option. please note that this only works in moderns. We have disabled this feature in touch devices to increase browsing speed.", "pacz" )
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__( "Extra class name", "pacz" ),
                "param_name" => "el_class",
                "value" => "",
                "description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz" )
            )

        )
    )
);

vc_map( array(
        "name"      => esc_html__( "Mobile Slideshow", "pacz" ),
        "base"      => "pacz_mobile_slideshow",
        'icon' => 'icon-pacz-image-slideshow vc_pacz_element-icon',
        "category" => esc_html__('Slideshows', 'pacz'),
        'description' => esc_html__( 'Slideshow inside a mobile.', 'pacz' ),
        "params"    => array(
            array(
                "heading" => esc_html__( "Orientation", 'pacz' ),
                "description" => esc_html__( "", 'pacz' ),
                "param_name" => "orientation",
                "value" => array(
                    esc_html__( "Landscape", 'pacz' )  =>  "landscape",
                    esc_html__( "Portrait", 'pacz' ) =>  "portrait",
                ),
                "type" => "dropdown"
            ),

            array(
                "heading" => esc_html__( "Tablet Color", 'pacz' ),
                "description" => esc_html__( "", 'pacz' ),
                "param_name" => "mobile_color",
                "value" => array(
                    esc_html__( "Balck", 'pacz' )  =>  "black",
                    esc_html__( "White", 'pacz' ) =>  "white",
                ),
                "type" => "dropdown"
            ),
            array(
                "type" => "attach_images",
                "heading" => esc_html__( "Add Images", "pacz" ),
                "param_name" => "images",
                "value" => "",
                "description" => esc_html__( "", "pacz" )
            ),
            array(
                "type" => "range",
                "heading" => esc_html__( "Animation Speed", "pacz" ),
                "param_name" => "animation_speed",
                "value" => "700",
                "min" => "100",
                "max" => "3000",
                "step" => "1",
                "unit" => 'ms',
                "description" => esc_html__( "", "pacz" )
            ),
            array(
                "type" => "range",
                "heading" => esc_html__( "Slideshow Speed", "pacz" ),
                "param_name" => "slideshow_speed",
                "value" => "7000",
                "min" => "1000",
                "max" => "20000",
                "step" => "1",
                "unit" => 'ms',
                "description" => esc_html__( "", "pacz" )
            ),

            array(
                "type" => "toggle",
                "heading" => esc_html__( "Pause on Hover", "pacz" ),
                "param_name" => "pause_on_hover",
                "value" => "false",
                "description" => esc_html__( "Pause the slideshow when hovering over slider, then resume when no longer hovering", "pacz" )
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__( "Viewport Animation", "pacz" ),
                "param_name" => "animation",
                "value" => $css_animations,
                "description" => esc_html__( "Viewport animation will be triggered when this element is being viewed when you scroll page down. you only need to choose the animation style from this option. please note that this only works in moderns. We have disabled this feature in touch devices to increase browsing speed.", "pacz" )
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__( "Extra class name", "pacz" ),
                "param_name" => "el_class",
                "value" => "",
                "description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz" )
            )

        )
    )
);


vc_map(array(
    "name" => esc_html__("Sharp Slider", "pacz"),
    "base" => "pacz_sharp_slider",
    'icon' => 'icon-pacz-sharp-slider vc_pacz_element-icon',
    "category" => esc_html__('Slideshows', 'pacz'),
    'description' => esc_html__( 'Powerful Sharp Slider.', 'pacz' ),
    "params" => array(
        array(
            "type" => "toggle",
            "heading" => esc_html__("First Element?", "pacz"),
            "param_name" => "first_el",
            "value" => "true",
            "description" => esc_html__("If you are not using this slideshow as first element in content then disable this option. This option only useful when Transparent Header style is enabled in this page, having this option enabled will allow the header skin follow slide item's => header skin.", "pacz")
        ),
        array(
            "type" => "multiselect",
            "heading" => esc_html__("Select specific slides", "pacz"),
            "param_name" => "slides",
            "value" => '',
            "options" => $sharp_posts,
            "description" => esc_html__("", "pacz")
        ),

        array(
            "heading" => esc_html__("Order", 'pacz'),
            "description" => esc_html__("Designates the ascending or descending order of the 'orderby' parameter.", 'pacz'),
            "param_name" => "order",
            "value" => array(
                esc_html__("ASC (ascending order)", 'pacz') => "ASC",
                esc_html__("DESC (descending order)", 'pacz') => "DESC"
            ),
            "type" => "dropdown"
        ),
        array(
            "heading" => esc_html__("Orderby", 'pacz'),
            "description" => esc_html__("Sort retrieved slides items by parameter.", 'pacz'),
            "param_name" => "orderby",
            "value" => $pacz_orderby,
            "type" => "dropdown"
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Full Height?", "pacz"),
            "param_name" => "full_height",
            "value" => "true",
            "description" => esc_html__("If you dont want full screen height slideshow disable this option. If you disable this option set the height of slideshow using below option.", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Slideshow Height", "pacz"),
            "param_name" => "height",
            "value" => "700",
            "min" => "100",
            "max" => "2000",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("This option only works when above option is disabled.", "pacz")
        ),
        array(
            "heading" => esc_html__("Animation Effect", 'pacz'),
            "description" => esc_html__("Note that Horizontal Curtain is reverted to Slide effect for Internet Explorer.", 'pacz'),
            "param_name" => "animation_effect",
            "value" => array(
                esc_html__("Slide", 'pacz') => "slide",
                esc_html__("Slide Vertical", 'pacz') => "vertical_slide",
                esc_html__("Zoom", 'pacz') => "zoom",
                esc_html__("Zoom Out", 'pacz') => "zoom_out",
                esc_html__("Horizontal Curtain", 'pacz') => "horizontal_curtain",
                esc_html__("Fade", 'pacz') => "fade",
                esc_html__("Perspective Flip", 'pacz') => "perspective_flip"
            ),
            "type" => "dropdown"
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Animation Speed", "pacz"),
            "param_name" => "animation_speed",
            "value" => "700",
            "min" => "100",
            "max" => "3000",
            "step" => "1",
            "unit" => 'ms',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Pause Time", "pacz"),
            "param_name" => "slideshow_speed",
            "value" => "7000",
            "min" => "1000",
            "max" => "20000",
            "step" => "1",
            "unit" => 'ms',
            "description" => esc_html__("How long each slide will show.", "pacz")
        ),

        // array(
        //     "type" => "toggle",
        //     "heading" => esc_html__("Direction Nav", "pacz"),
        //     "param_name" => "direction_nav",
        //     "value" => "true",
        //     "description" => esc_html__("", "pacz")
        // ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Direction Nav", "pacz"),
            "param_name" => "direction_nav",
            "width" => 300,
            "value" => array(
                esc_html__('Classic', "pacz") => "classic",
                // esc_html__('Classic Retouched', "pacz") => "classic_retouched",
                esc_html__('Bar', "pacz") => "bar",
                esc_html__('Round', "pacz") => "round",
                esc_html__('Flip', "pacz") => "flip",
                esc_html__('-- No Pagination', "pacz") => "false"
            ),
            "description" => esc_html__("", "pacz"),
            // "dependency" => array(
            //     "element" => "direction_nav",
            //     "value" => array(
            //         "true"
            //     )
            // )
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Pagination", "pacz"),
            "param_name" => "pagination",
            "width" => 300,
            "value" => array(
                esc_html__('-- No Pagination', "pacz") => "",
                esc_html__('Small Stroke', "pacz") => "small_stroke",
                esc_html__('Rounded Underline', "pacz") => "rounded",
                esc_html__('Underline', "pacz") => "underline",
                esc_html__('Square', "pacz") => "square",

            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Parallax", "pacz"),
            "param_name" => "parallax",
            "value" => "false",
            "description" => esc_html__("Add parallax effect to your slider", "pacz")
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Loop?", "pacz"),
            "param_name" => "sharp_slider_loop",
            "value" => "false",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Hash Navigation?", "pacz"),
            "param_name" => "sharp_slider_hash",
            "value" => "false",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz")
        )

    )
));


vc_map(array(
    "name" => esc_html__("Tab Slider", "pacz"),
    "base" => "pacz_tab_slider",
    'icon' => 'icon-pacz-sharp-slider vc_pacz_element-icon',
    "category" => esc_html__('Slideshows', 'pacz'),
    'description' => esc_html__( 'Powerful Tab Slider.', 'pacz' ),
    "params" => array(
        array(
            "type" => "multiselect",
            "heading" => esc_html__("Select specific slides", "pacz"),
            "param_name" => "slides",
            "value" => '',
            "options" => $tab_posts,
            "description" => esc_html__("", "pacz")
        ),
        array(
            "heading" => esc_html__("Order", 'pacz'),
            "description" => esc_html__("Designates the ascending or descending order of the 'orderby' parameter.", 'pacz'),
            "param_name" => "order",
            "value" => array(
                esc_html__("ASC (ascending order)", 'pacz') => "ASC",
                esc_html__("DESC (descending order)", 'pacz') => "DESC"
            ),
            "type" => "dropdown"
        ),
        array(
            "heading" => esc_html__("Orderby", 'pacz'),
            "description" => esc_html__("Sort retrieved slides items by parameter.", 'pacz'),
            "param_name" => "orderby",
            "value" => $pacz_orderby,
            "type" => "dropdown"
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Full Height?", "pacz"),
            "param_name" => "full_height",
            "value" => "true",
            "description" => esc_html__("If you dont want full screen height slideshow disable this option. If you disable this option set the height of slideshow using below option.", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Slideshow Height", "pacz"),
            "param_name" => "height",
            "value" => "700",
            "min" => "100",
            "max" => "2000",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("This option only works when above option is disabled.", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Animation Speed", "pacz"),
            "param_name" => "animation_speed",
            "value" => "700",
            "min" => "100",
            "max" => "3000",
            "step" => "1",
            "unit" => 'ms',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz")
        )

    )
));


vc_map(array(
    "name" => esc_html__("Sharp One Pager", "pacz"),
    "base" => "pacz_sharp_one_pager",
    'icon' => 'icon-pacz-sharp-one-pager vc_pacz_element-icon',
    "category" => esc_html__('Slideshows', 'pacz'),
    'description' => esc_html__( 'Converts Sharp Slider to vertical scroll.', 'pacz' ),
    "params" => array(
        array(
            "type" => "multiselect",
            "heading" => esc_html__("Select specific slides", "pacz"),
            "param_name" => "slides",
            "value" => '',
            "options" => $sharp_posts,
            "description" => esc_html__("", "pacz")
        ),

        array(
            "heading" => esc_html__("Order", 'pacz'),
            "description" => esc_html__("Designates the ascending or descending order of the 'orderby' parameter.", 'pacz'),
            "param_name" => "order",
            "value" => array(
                esc_html__("ASC (ascending order)", 'pacz') => "ASC",
                esc_html__("DESC (descending order)", 'pacz') => "DESC"
            ),
            "type" => "dropdown"
        ),
        array(
            "heading" => esc_html__("Orderby", 'pacz'),
            "description" => esc_html__("Sort retrieved slides items by parameter.", 'pacz'),
            "param_name" => "orderby",
            "value" => $pacz_orderby,
            "type" => "dropdown"
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Pagination?", "pacz"),
            "param_name" => "navigation",
            "value" => "true",
            "description" => esc_html__("", "pacz")
        ),
        
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Pagination Style", "pacz"),
            "param_name" => "pagination",
            "width" => 300,
            "value" => array(
                esc_html__('Square', "pacz") => "square",
                esc_html__('Small Stroke', "pacz") => "small_stroke",
                esc_html__('Rounded Underline', "pacz") => "rounded",
                esc_html__('Underline', "pacz") => "underline",

            ),
            "dependency" => array(
                "element" => "navigation",
                "value" => array(
                    "true"
                )
            ),
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz")
        )
    )
));

vc_map(array(
    "name" => esc_html__("Content Scroller", "pacz"),
    "base" => "vc_content_scroller",
    "as_parent" => array('only' => 'vc_content_scroller_item'),
    "content_element" => true,
    'icon' => 'icon-pacz-image-slideshow vc_pacz_element-icon',
    "category" => esc_html__('Slideshows', 'pacz'),
    'description' => esc_html__( 'Swiper enabled content slideshow.', 'pacz' ),
    "params" => array(
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Border Top and Bottom Color", "pacz"),
            "param_name" => "border_color",
            "value" => "#eee",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Box Background Color", "pacz"),
            "param_name" => "bg_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "upload",
            "heading" => esc_html__("Background Image", "pacz"),
            "param_name" => "bg_image",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Background Attachment", "pacz"),
            "param_name" => "attachment",
            "width" => 150,
            "value" => array(
                esc_html__('Scroll', "pacz") => "scroll",
                esc_html__('Fixed', "pacz") => "fixed"
            ),
            "description" => esc_html__("The background-attachment property sets whether a background image is fixed or scrolls with the rest of the page. <a href='http://www.w3schools.com/CSSref/pr_background-attachment.asp'>Read More</a>", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Background Position", "pacz"),
            "param_name" => "bg_position",
            "width" => 300,
            "value" => array(
                esc_html__('Left Top', "pacz") => "left top",
                esc_html__('Center Top', "pacz") => "center top",
                esc_html__('Right Top', "pacz") => "right top",
                esc_html__('Left Center', "pacz") => "left center",
                esc_html__('Center Center', "pacz") => "center center",
                esc_html__('Right Center', "pacz") => "right center",
                esc_html__('Left Bottom', "pacz") => "left bottom",
                esc_html__('Center Bottom', "pacz") => "center bottom",
                esc_html__('Right Bottom', "pacz") => "right bottom"
            ),
            "description" => esc_html__("First value defines horizontal position and second vertical positioning.", "pacz")
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__('Cover whole background', 'pacz'),
            "description" => esc_html__("Scale the background image to be as large as possible so that the background area is completely covered by the background image. Some parts of the background image may not be in view within the background positioning area.", "pacz"),
            "param_name" => "bg_stretch",
            "value" => "false",
        ),
        array(
            "heading" => esc_html__("Slide Direction", 'pacz'),
            "description" => esc_html__("", 'pacz'),
            "param_name" => "slide_direction",
            "value" => array(
                esc_html__("Horizontal", 'pacz') => "horizontal",
                esc_html__("Vertical", 'pacz') => "vertical"
            ),
            "dependency" => array(
                'element' => "effect",
                'value' => array(
                    'slide'
                )
            ),
            "type" => "dropdown"
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("Animation Speed", "pacz"),
            "param_name" => "animation_speed",
            "value" => "700",
            "min" => "100",
            "max" => "3000",
            "step" => "1",
            "unit" => 'ms',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Slideshow Speed", "pacz"),
            "param_name" => "slideshow_speed",
            "value" => "7000",
            "min" => "1000",
            "max" => "20000",
            "step" => "1",
            "unit" => 'ms',
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "toggle",
            "heading" => esc_html__("Direction Nav", "pacz"),
            "param_name" => "direction_nav",
            "value" => "true",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz")
        )
    ),
     "js_view" => 'VcColumnView'
));

vc_map(array(
    "name" => esc_html__("Content Scroller Item", "pacz"),
    "base" => "vc_content_scroller_item",
     'icon' => 'icon-pacz-image-slideshow vc_pacz_element-icon',
    "content_element" => true,
    "as_child" => array('only' => 'vc_content_scroller'),
    "is_container" => true,

    "params" => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Title", "pacz"),
            "param_name" => "title",
            "description" => esc_html__("Content Scroller section title.", "pacz")
        )
    ),
     "js_view" => 'VcColumnView'
));
*/


vc_map(array(
    "name" => esc_html__("Testimonials", "pacz"),
    "base" => "pacz_testimonials",
    'icon' => 'icon-pacz-testimonial-slideshow vc_pacz_element-icon',
    "category" => esc_html__('Slideshows', 'pacz'),
    'description' => esc_html__( 'Shows Testimonials in multiple styles.', 'pacz' ),
    "params" => array(


        array(
            "heading" => esc_html__("Style", 'pacz'),
            "description" => esc_html__("", 'pacz'),
            "param_name" => "style",
            "value" => array(
                esc_html__("Boxed Style", 'pacz') => "boxed",
                esc_html__("creative", 'pacz') => "creative",
				esc_html__("Modern Style", 'pacz') => "modern",
				esc_html__("Style 1", 'pacz') => "testimonial1",
				esc_html__("Style 2", 'pacz') => "testimonial2",
				esc_html__("Style 3", 'pacz') => "testimonial3",
				esc_html__("Style 4", 'pacz') => "testimonial4",
				esc_html__("Style 5", 'pacz') => "testimonial5",
				esc_html__("Style 6", 'pacz') => "testimonial6"
                
            ),
            "type" => "dropdown"
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Count", "pacz"),
            "param_name" => "count",
            "value" => "4",
            "min" => "-1",
            "max" => "50",
            "step" => "1",
            "unit" => 'testimonial',
            "description" => esc_html__("How many testimonial you would like to show? (-1 means unlimited)", "pacz")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Font Size?", "pacz"),
            "param_name" => "image_width",
            "value" => "90",
            "min" => "0",
            "max" => "570",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("Testimonial author image width", "pacz")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Font Size?", "pacz"),
            "param_name" => "image_height",
            "value" => "90",
            "min" => "0",
            "max" => "570",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("Testimonial author image height", "pacz")
        ),
        array(
            "type" => "multiselect",
            "heading" => esc_html__("Select specific testimonials", "pacz"),
            "param_name" => "testimonials",
            "value" => '',
            "options" => $testimonials,
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "theme_fonts",
            "heading" => esc_html__("Font Family", "pacz"),
            "param_name" => "font_family",
            "value" => "",
            "description" => esc_html__("You can choose a font for this shortcode, however using non-safe fonts can affect page load and performance.", "pacz")
        ),
		
        array(
            "type" => "range",
            "heading" => esc_html__("Font Size?", "pacz"),
            "param_name" => "font_size",
            "value" => "14",
            "min" => "10",
            "max" => "30",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Line Height?", "pacz"),
            "param_name" => "line_height",
            "value" => "26",
            "min" => "15",
            "max" => "50",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Font Color?", "pacz"),
            "param_name" => "font_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'boxed',
                    'modern',
                )
            ),
        ),
        array(
            "type" => "hidden_input",
            "param_name" => "font_type",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),

        /*array(
            "heading" => esc_html__("Skin", 'pacz'),
            "description" => esc_html__("Please note that this option will only work in \"Quotation Style\"", 'pacz'),
            "param_name" => "skin",
            "value" => array(
                esc_html__("Dark", 'pacz') => "dark",
                esc_html__("Light", 'pacz') => "light"
            ),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'quote'
                )
            ),
            "type" => "dropdown"
        ),*/
		array(
            "type" => "toggle",
            "heading" => esc_html__("scroller", "pacz"),
            "param_name" => "scroll",
			"value" => "true",
            "description" => esc_html__("put loop scroller on or off", "pacz"),

        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__("Auto Scroll", "pacz"),
            "param_name" => "autoplay",
            "value" => "false",
            "description" => esc_html__("Auto scroll on or off", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__(" Scroller navigation", "pacz"),
            "param_name" => "owl_nav",
            "value" => "false",
            "description" => esc_html__(" scroll navigation on or off", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__(" Scroller item loop", "pacz"),
            "param_name" => "item_loop",
            "value" => "false",
            "description" => esc_html__(" scroller item  on or off", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller autoplay speed", "pacz"),
            "param_name" => "autoplay_speed",
            "value" => "2000",
			"min" => "0",
			"max" => "10000",
			"step" => "1",
			"unit" => "ms",
            "description" => esc_html__(" scroller autoplay speed", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller autoplay Delay", "pacz"),
            "param_name" => "delay",
            "value" => "1000",
			"min" => "0",
			"max" => "5000",
			"step" => "1",
			"unit" => "ms",
            "description" => esc_html__("Scroller autoplay Delay per slider", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items gutter space", "pacz"),
            "param_name" => "gutter_space",
            "value" => "30",
			"min" => "0",
			"max" => "50",
			"step" => "1",
			"unit" => "px",
            "description" => esc_html__("Scroller items gutter space, defualt is 30px you can set 0 to 100px but not in -ve value", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items for desktop above 1025px", "pacz"),
            "param_name" => "desktop_items",
            "value" => "3",
			"min" => "1",
			"max" => "8",
			"step" => "1",
			"unit" => "items",
            "description" => esc_html__("Scroller items for desktop above 1025px, adjust items according to your layout", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items for tabs landscape from 960px to 1024px", "pacz"),
            "param_name" => "tab_landscape_items",
            "value" => "3",
			"min" => "1",
			"max" => "6",
			"step" => "1",
			"unit" => "items",
            "description" => esc_html__("Scroller items for tabs landscape from 960px to 1024px, adjust items according to your layout", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Scroller items for tabs from 768px to 959px", "pacz"),
            "param_name" => "tab_items",
            "value" => "2",
			"min" => "1",
			"max" => "4",
			"step" => "1",
			"unit" => "items",
            "description" => esc_html__("Scroller items for tabs landscape from 960px to 1024px, adjust items according to your layout", "pacz"),
            "dependency" => array(
                'element' => "scroll",
                'value' => array(
                    'true'
                )
            )

        ),
        array(
            "heading" => esc_html__("Order", 'pacz'),
            "description" => esc_html__("Designates the ascending or descending order of the 'orderby' parameter.", 'pacz'),
            "param_name" => "order",
            "value" => array(
                esc_html__("DESC (descending order)", 'pacz') => "DESC",
                esc_html__("ASC (ascending order)", 'pacz') => "ASC"
            ),
            "type" => "dropdown"
        ),
        array(
            "heading" => esc_html__("Orderby", 'pacz'),
            "description" => esc_html__("Sort retrieved client items by parameter.", 'pacz'),
            "param_name" => "orderby",
            "value" => $pacz_orderby,
            "type" => "dropdown"
        ),



        array(
            "heading" => esc_html__("Slides animation", 'pacz'),
            "description" => esc_html__("", 'pacz'),
            "param_name" => "animation_effect",
            "value" => array(
                esc_html__("Slide", 'pacz') => "slide",
                esc_html__("Fade", 'pacz') => "fade"
            ),
            "type" => "dropdown"
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Viewport Animation", "pacz"),
            "param_name" => "animation",
            "value" => $css_animations,
            "description" => esc_html__("Viewport animation will be triggered when this element is being viewed when you scroll page down. you only need to choose the animation style from this option. please note that this only works in moderns. We have disabled this feature in touch devices to increase browsing speed.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz")
        )

    )
));

/*
vc_map(array(
    "name" => esc_html__("Window Scroller", "pacz"),
    "base" => "pacz_window_scroller",
    'icon' => 'icon-pacz-image-slideshow vc_pacz_element-icon',
    "category" => esc_html__('Slideshows', 'pacz'),
    'description' => esc_html__( 'Vertical widnow scroll in a frame.', 'pacz' ),
    "params" => array(
        array(
            "type" => "upload",
            "heading" => esc_html__("Uplaod Your image", "pacz"),
            "param_name" => "src",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Window Height", "pacz"),
            "param_name" => "height",
            "value" => "300",
            "min" => "100",
            "max" => "1000",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("Animation Speed", "pacz"),
            "param_name" => "speed",
            "value" => "2000",
            "min" => "100",
            "max" => "10000",
            "step" => "1",
            "unit" => 'ms',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Link", "pacz"),
            "param_name" => "link",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Target", "pacz"),
            "param_name" => "target",
            "width" => 200,
            "value" => $target_arr,
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Viewport Animation", "pacz"),
            "param_name" => "animation",
            "value" => $css_animations,
            "description" => esc_html__("Viewport animation will be triggered when this element is being viewed when you scroll page down. you only need to choose the animation style from this option. please note that this only works in moderns. We have disabled this feature in touch devices to increase browsing speed.", "pacz")
        ),
        $add_device_visibility,
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "pacz")
        )



    )
));

vc_map(array(
    "name" => esc_html__("Theatre Slider", "pacz"),
    "base" => "pacz_theatre_slider",
    'icon' => 'vc_pacz_element-icon',
    "category" => esc_html__('Slideshows', 'pacz'),
    'description' => esc_html__( '', 'pacz' ),
    "params" => array(
        array(
            "heading" => esc_html__("Background Style", 'pacz'),
            "description" => esc_html__("", 'pacz'),
            "param_name" => "background_style",
            "value" => array(
                esc_html__("Desktop", 'pacz') => "desktop_style",
                esc_html__("Laptop", 'pacz') => "laptop_style"
            ),
            "type" => "dropdown"
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Slider Max Width", "pacz"),
            "param_name" => "max_width",
            "value" => "900",
            "min" => "320",
            "max" => "920",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "heading" => esc_html__("Video Host", 'pacz'),
            "description" => esc_html__("", 'pacz'),
            "param_name" => "host",
            "value" => array(
                esc_html__("Self Hosted", 'pacz') => "self_hosted",
                esc_html__("Social Hosted", 'pacz') => "social_hosted"
            ),
            "type" => "dropdown"
        ), 
        array(
            "type" => "upload",
            "heading" => esc_html__("MP4 Format", "pacz"),
            "param_name" => "mp4",
            "value" => "",
            "description" => esc_html__("Compatibility for Safari, IE9", "pacz"),
            "dependency" => array(
                'element' => "host",
                'value' => array(
                    'self_hosted'
                )
            )
        ),
        array(
            "type" => "upload",
            "heading" => esc_html__("WebM Format", "pacz"),
            "param_name" => "webm",
            "value" => "",
            "description" => esc_html__("Compatibility for Firefox4, Opera, and Chrome", "pacz"),
            "dependency" => array(
                'element' => "host",
                'value' => array(
                    'self_hosted'
                )
            )
        ),
        array(
            "type" => "upload",
            "heading" => esc_html__("OGV Format", "pacz"),
            "param_name" => "ogv",
            "value" => "",
            "description" => esc_html__("Compatibility for older Firefox and Opera versions", "pacz"),
            "dependency" => array(
                'element' => "host",
                'value' => array(
                    'self_hosted'
                )
            )
        ),
        array(
            "type" => "upload",
            "heading" => esc_html__("Background Video Preview image (and fallback image)", "pacz"),
            "param_name" => "poster_image",
            "value" => "",
            "description" => esc_html__("This Image will shown until video load. in case of video is not supported or did not load the image will remain as fallback.", "pacz"),
            "dependency" => array(
                'element' => "host",
                'value' => array(
                    'self_hosted'
                )
            )
        ),
        array(
            "heading" => esc_html__("Stream Host Website", 'pacz'),
            "description" => esc_html__("", 'pacz'),
            "param_name" => "stream_host_website",
            "value" => array(
                esc_html__("Youtube", 'pacz') => "youtube",
                esc_html__("Vimeo", 'pacz') => "vimeo"
            ),
            "type" => "dropdown",
            "dependency" => array(
                'element' => "host",
                'value' => array(
                    'social_hosted'
                )
            ),
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Show Social Video Controls", "pacz"),
            "param_name" => "video_controls",
            "value" => "true",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "stream_host_website",
                'value' => array(
                    'youtube'
                )
            )
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Autoplay?", "pacz"),
            "param_name" => "autoplay",
            "value" => "false",
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Loop?", "pacz"),
            "param_name" => "loop",
            "value" => "false",
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Video ID", "pacz"),
            "param_name" => "stream_video_id",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "host",
                'value' => array(
                    'social_hosted'
                )
            )
        ),
        array(
            "heading" => esc_html__("Slider Align", 'pacz'),
            "description" => esc_html__("", 'pacz'),
            "param_name" => "align",
            "value" => array(
                esc_html__("Left", 'pacz') => "left",
                esc_html__("Center", 'pacz') => "center",
                esc_html__("Right", 'pacz') => "right"
            ),
            "type" => "dropdown"
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Margin Bottom", "pacz"),
            "param_name" => "margin_bottom",
            "value" => "25",
            "min" => "10",
            "max" => "250",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Viewport Animation", "pacz"),
            "param_name" => "animation",
            "value" => $css_animations,
            "description" => esc_html__("Viewport animation will be triggered when this element is being viewed when you scroll page down. you only need to choose the animation style from this option. please note that this only works in moderns. We have disabled this feature in touch devices to increase browsing speed.", "pacz")
        ),
        $add_device_visibility,
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz")
        )
    )
));
*/