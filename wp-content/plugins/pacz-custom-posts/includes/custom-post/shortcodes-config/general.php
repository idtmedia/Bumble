<?php

vc_map(array(
    "name" => esc_html__("Custom Box", "pacz"),
    "base" => "pacz_custom_box",
    "as_parent" => array('except' => 'vc_row,pacz_page_section'),
    "content_element" => true,
    "show_settings_on_create" => false,
    "description" => esc_html__("Custom Box For your contents.","pacz"),
    'icon' => 'icon-pacz-custom-box vc_pacz_element-icon',
    "category" => esc_html__('General', 'pacz'),
    "params" => array(

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Border Color", "pacz"),
            "param_name" => "border_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Background Color", "pacz"),
            "param_name" => "bg_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Drop Outer Shadow", "pacz"),
            "param_name" => "drop_shadow",
            "value" => "false"
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
            "type" => "dropdown",
            "heading" => esc_html__("Background Repeat", "pacz"),
            "param_name" => "bg_repeat",
            "width" => 300,
            "value" => array(
                esc_html__('Repeat', "pacz") => "repeat",
                esc_html__('No Repeat', "pacz") => "no-repeat",
                esc_html__('Horizontally repeat', "pacz") => "repeat-x",
                esc_html__('Vertically Repeat', "pacz") => "repeat-y"
            ),
            "description" => esc_html__("", "pacz")
        ),
		
        array(
            "type" => "toggle",
            "heading" => esc_html__("Scale the background image to be as large as possible so that the background area is completely covered by the background image. Some parts of the background image may not be in view within the background positioning area", "pacz"),
            "param_name" => "bg_stretch",
            "value" => "false"
        ),
		
		array(
            "type" => "dropdown",
            "heading" => esc_html__("text align", "pacz"),
            "param_name" => "text_align",
            "value" => array(
                
                esc_html__('Left', "pacz") => "left",
				esc_html__('Center', "pacz") => "center",
                esc_html__('Right', "pacz") => "right"
            ),
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "dropdown",
            "heading" => esc_html__("Position", "pacz"),
            "param_name" => "position",
            "value" => array(
                esc_html__('Relative', "pacz") => "relative",
                esc_html__('Absolute', "pacz") => "absolute",
                esc_html__('Static', "pacz") => "static"
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Padding Top", "pacz"),
            "param_name" => "padding_top",
            "value" => "30",
            "min" => "0",
            "max" => "200",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Padding Bottom", "pacz"),
            "param_name" => "padding_bottom",
            "value" => "30",
            "min" => "0",
            "max" => "200",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Padding Left", "pacz"),
            "param_name" => "padding_left",
            "value" => "20",
            "min" => "0",
            "max" => "200",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Padding Right", "pacz"),
            "param_name" => "padding_right",
            "value" => "20",
            "min" => "0",
            "max" => "200",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Margin Top", "pacz"),
            "param_name" => "margin_top",
            "value" => "20",
            "min" => "-50",
            "max" => "300",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Margin Bottom", "pacz"),
            "param_name" => "margin_bottom",
            "value" => "20",
            "min" => "-50",
            "max" => "300",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Top", "pacz"),
            "param_name" => "top",
            "value" => "0",
            "min" => "-200",
            "max" => "300",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Bottom", "pacz"),
            "param_name" => "bottom",
            "value" => "0",
            "min" => "-200",
            "max" => "300",
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
            "heading" => esc_html__("Z-indexe", "pacz"),
            "param_name" => "z_index",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
		array(
				'type' => 'toggle',
				'param_name' => 'alsp_masonry_grid',
				'value' => "false",
				'heading' => __('Turn Masonary Grid On/Off', 'ALSP'),
				'description' => '',
			),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "pacz")
        )
    ),
    "js_view" => 'VcColumnView'
));

vc_map(array(
    "name" => esc_html__("Image", "pacz"),
    "base" => "pacz_image",
    "category" => esc_html__('General', 'pacz'),
    'description' => esc_html__( 'Adds Image element with many styles.', 'pacz' ),
    'icon' => 'icon-pacz-image vc_pacz_element-icon',
    "params" => array(
        array(
            "type" => "upload",
            "heading" => esc_html__("Upload Your image", "pacz"),
            "param_name" => "src",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("Image Width", "pacz"),
            "param_name" => "image_width",
            "value" => "500",
            "min" => "10",
            "max" => "2600",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Image Height", "pacz"),
            "param_name" => "image_height",
            "value" => "400",
            "min" => "10",
            "max" => "5000",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Image Cropping?", "pacz"),
            "param_name" => "crop",
            "value" => "true",
            "description" => esc_html__("If you dont want to crop your image based on the dimensions you defined above disable this option. Only wdith will be used to give the image container max-width property.", "pacz")
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Image Hover?", "pacz"),
            "param_name" => "hover",
            "value" => "true",
            "description" => esc_html__("If you disable this option the image hover layer including the 'click to open in lightbox' and 'image title' will be removed from this image.", "pacz")
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Image Circular?", "pacz"),
            "param_name" => "circular",
            "value" => "false",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Hover Style", "pacz"),
            "param_name" => "hover_style",
            "width" => 150,
            "value" => array(
                esc_html__('Style 1', "pacz") => "style1",
                esc_html__('Style 2', "pacz") => "style2"
            ),
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "dropdown",
            "heading" => esc_html__("Image float", "pacz"),
            "param_name" => "float",
            "value" => array(
                esc_html__('None', "pacz") => "none",
                esc_html__('Left', "pacz") => "left",
				esc_html__('Right', "pacz") => "right",
            ),
			'save_always' => true,
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Padding Left Right", "pacz"),
            "param_name" => "padding_left_right",
            "value" => "",
            "min" => "0",
            "max" => "50",
            "step" => "1",
            "unit" => 'px',
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Custom URL", "pacz"),
            "param_name" => "custom_url",
            "value" => "",
            "description" => esc_html__("use this option if you want to link to a webpage instead of 'click to open in lightbox'", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Custom LightBox URL", "pacz"),
            "param_name" => "custom_lightbox_url",
            "value" => "",
            "description" => esc_html__("If you want to load custom image, video in lightbox then fill this form with the URL of the image or video(e.g. youtube, vimeo)'", "pacz")
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Lightbox iFrame Mode", "pacz"),
            "param_name" => "lightbox_ifarme",
            "value" => "false",
            "description" => esc_html__("If you are using a custom ligthbox url and the content you would like to show is webpage, google maps or flash content, enable this option.", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Custom URL Target", "pacz"),
            "param_name" => "target",
            "width" => 200,
            "value" => $target_arr,
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Align", "pacz"),
            "param_name" => "align",
            "width" => 150,
            "value" => array(
                esc_html__('Left', "pacz") => "left",
                esc_html__('Right', "pacz") => "right",
                esc_html__('Center', "pacz") => "center"
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Lightbox Group rel", "pacz"),
            "param_name" => "group",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Margin Bottom", "pacz"),
            "param_name" => "margin_bottom",
            "value" => "10",
            "min" => "-50",
            "max" => "300",
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
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "pacz")
        )



    )
));


vc_map(array(
    "name" => esc_html__("Image Box", "pacz"),
    "base" => "pacz_image_box",
    "category" => esc_html__('General', 'pacz'),
    'description' => esc_html__( 'A custom box with image and content.', 'pacz' ),
    'icon' => 'icon-pacz-content-box vc_pacz_element-icon',
    "params" => array(
         array(
            "type" => "textfield",
            "heading" => esc_html__("Box Title", "pacz"),
            "param_name" => "title",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),

         array(
            "type" => "textarea",
            "heading" => esc_html__("Box Description", "pacz"),
            "param_name" => "content",
            "holder" => "div",
            "value" => "",
            "description" => esc_html__("This field accepts HTML tags.", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Media Type", "pacz"),
            "param_name" => "media_type",
            "width" => 150,
            "value" => array(
                esc_html__('Image', "pacz") => "image",
                esc_html__('Video', "pacz") => "video"
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Autoplay?", "pacz"),
            "param_name" => "autoplay",
            "value" => "false",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "media_type",
                'value' => array(
                    'video'
                )
            )
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Video Host?", "pacz"),
            "param_name" => "video_host",
            "width" => 150,
            "value" => array(
                esc_html__('Self Hosted', "pacz") => "self_hosted",
                esc_html__('Social Hosted', "pacz") => "social_hosted"
            ),
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "media_type",
                'value' => array(
                    'video'
                )
            )
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Video Host?", "pacz"),
            "param_name" => "video_host_social",
            "width" => 150,
            "value" => array(
                esc_html__('Youtube', "pacz") => "social_hosted_youtube",
                esc_html__('Vimeo', "pacz") => "social_hosted_vimeo"
            ),
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "video_host",
                'value' => array(
                    'social_hosted'
                )
            )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Video ID?", "pacz"),
            "param_name" => "social_youtube_id",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "video_host_social",
                'value' => array(
                    'social_hosted_youtube'
                )
            )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Video ID?", "pacz"),
            "param_name" => "social_vimeo_id",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "video_host_social",
                'value' => array(
                    'social_hosted_vimeo'
                )
            )
        ),
        array(
            "type" => "upload",
            "heading" => esc_html__("Background Video (.MP4)", "pacz"),
            "param_name" => "mp4",
            "value" => "",
            "description" => esc_html__("Upload your video with .MP4 extension. (Compatibility for Safari and IE9)", "pacz"),
            "dependency" => array(
                'element' => "video_host",
                'value' => array(
                    'self_hosted'
                )
            )
        ),
        array(
            "type" => "upload",
            "heading" => esc_html__("Background Video (.WebM)", "pacz"),
            "param_name" => "webm",
            "value" => "",
            "description" => esc_html__("Upload your video with .WebM extension. (Compatibility for Firefox4, Opera, and Chrome)", "pacz"),
            "dependency" => array(
                'element' => "video_host",
                'value' => array(
                    'self_hosted'
                )
            )
        ),
        array(
            "type" => "upload",
            "heading" => esc_html__("Background Video (.OGV)", "pacz"),
            "param_name" => "ogv",
            "value" => "",
            "description" => esc_html__("Upload preview image for mobile devices", "pacz"),
            "dependency" => array(
                'element' => "video_host",
                'value' => array(
                    'self_hosted'
                )
            )
        ),
        array(
            "type" => "upload",
            "heading" => esc_html__("Preview Image", "pacz"),
            "param_name" => "preview_image",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "video_host",
                'value' => array(
                    'self_hosted'
                )
            )
        ),
        array(
            "type" => "upload",
            "heading" => esc_html__("Upload Your image", "pacz"),
            "param_name" => "src",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "media_type",
                'value' => array(
                    'image'
                )
            )
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Box Width", "pacz"),
            "param_name" => "media_width",
            "value" => "500",
            "min" => "10",
            "max" => "2600",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            // "dependency" => array(
            //     "element" => "media_type",
            //     "value" => array(
            //         "image"
            //     )
            // )
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Image Height", "pacz"),
            "param_name" => "media_height",
            "value" => "400",
            "min" => "10",
            "max" => "5000",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                "element" => "media_type",
                "value" => array(
                    "image"
                )
            )
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Image Cropping?", "pacz"),
            "param_name" => "crop",
            "value" => "true",
            "description" => esc_html__("If you dont want to crop your image based on the dimensions you defined above disable this option. Only wdith will be used to give the image container max-width property.", "pacz"),
            "dependency" => array(
                "element" => "media_type",
                "value" => array(
                    "image"
                )
            )

        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Image Link?", "pacz"),
            "param_name" => "image_link",
            "width" => 200,
            "value" => array(
                esc_html__('Lightbox', "pacz") => "lightbox",
                esc_html__('Url', "pacz") => "url"
            ),
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                "element" => "media_type",
                "value" => array(
                    "image"
                )
            )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Link (optional)", "pacz"),
            "param_name" => "url",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "image_link",
                'value' => array(
                    'url'
                )
            )
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("URL Target", "pacz"),
            "param_name" => "target",
            "width" => 200,
            "value" => $target_arr,
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "image_link",
                'value' => array(
                    'url'
                )
            )
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Align", "pacz"),
            "param_name" => "align",
            "width" => 150,
            "value" => array(
                esc_html__('Left', "pacz") => "left",
                esc_html__('Right', "pacz") => "right",
                esc_html__('Center', "pacz") => "center"
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Box Background Color", "pacz"),
            "param_name" => "bg_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Border Color", "pacz"),
            "param_name" => "border_color",
            "value" => "",
            "description" => esc_html__("If left blank no border will be added.", "pacz"),
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Text Color", "pacz"),
            "param_name" => "text_color",
            "value" => "",
            "description" => esc_html__("This option will apply to title and description", "pacz"),
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Title Color", "pacz"),
            "param_name" => "title_color",
            "value" => "",
            "description" => esc_html__("This option will apply to title and description", "pacz"),
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Title Text Transform", "pacz"),
            "param_name" => "title_text_transform",
            "width" => 150,
            "value" => array(
                esc_html__('Default', "pacz") => "",
                esc_html__('None', "pacz") => "none",
                esc_html__('Uppercase', "pacz") => "uppercase",
                esc_html__('Lowercase', "pacz") => "lowercase",
                esc_html__('Capitalize', "pacz") => "capitalize"
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Title Font Weight", "pacz"),
            "param_name" => "title_font_weight",
            "width" => 150,
            "value" => array(
                esc_html__('Default', "pacz") => "inherit",
                esc_html__('Semi Bold', "pacz") => "600",
                esc_html__('Bold', "pacz") => "bold",
                esc_html__('Bolder', "pacz") => "bolder",
                esc_html__('Normal', "pacz") => "normal",
                esc_html__('Light', "pacz") => "300"
            ),
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'custom'
                )
            )
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Rounded Corners?", "pacz"),
            "param_name" => "rounded_corner",
            "value" => "false",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "media_type",
                'value' => array(
                    'image'
                )
            )
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
if (class_exists('DHVCForm')){
$post_id = 0;
if (isset ( $_GET ['post'] ))
	$post_id = ( int ) $_GET ['post'];
elseif (isset ( $_POST ['post_ID'] ))
	$post_id = ( int ) $_POST ['post_ID'];
elseif (isset ( $_POST ['post_id'] ))
	$post_id = ( int ) $_POST ['post_id'];

//if ((isset ( $_GET ['post_type'] ) && $_GET ['post_type'] === 'dhvcform') || (get_post_type ( $post_id ) === 'dhvcform') || (dhvc_is_editor () && ((isset ( $_GET ['post_type'] ) && $_GET ['post_type'] === 'dhvcform') || (get_post_type ( $post_id ) === 'dhvcform'))) || (dhvc_is_inline () && ((isset ( $_GET ['post_type'] ) && $_GET ['post_type'] === 'dhvcform') || (get_post_type ( $post_id ) === 'dhvcform'))) || (dhvc_is_editable () && ((isset ( $_GET ['post_type'] ) && $_GET ['post_type'] === 'dhvcform') || (get_post_type ( $post_id ) === 'dhvcform')))){
	//if (function_exists ( 'vc_disable_frontend' )) :
		//vc_disable_frontend ();
	// else :
	//	if (class_exists ( 'NewVisualComposer' ))
		//	NewVisualComposer::disableInline ();
	//endif;
//}else{
	$args = array(
		'post_type'=>'dhvcform',
		'posts_per_page'=> -1,
		'post_status'=>'publish',
		'meta_query' => array(
			array(
				'key'     => '_form_popup',
				'compare' => 'NOT EXISTS',
			),
		),
	);
//}
	$forms = get_posts($args);
	$forms_options = array();
	$forms_options['-- Select Form --']='';
	foreach ($forms as $form){
		if(empty($form->post_title))
			$form->post_title = 'No Title';
		$forms_options[$form->post_title] = $form->ID;
	}
	
		 
	
vc_map(array(
    "name" => esc_html__("DHVC Cutom", "pacz"),
    "base" => "pacz_dhvc_form",
    "category" => esc_html__('General', 'pacz'),
    'icon' => 'icon-pacz-chart vc_classifieds_element-icon',
    'description' => esc_html__( 'Custom Form element for DHVC Plugin', 'pacz' ),
    "params" => array(
			array (
				"type" => "dropdown",
				'admin_label'=>true,
				"heading" => esc_html__ ( "Form Type", 'pacz' ),
				"param_name" => "form_type",
				"value" =>array(
					esc_html__('Register Or login Form', "pacz") => "1",
					esc_html__('Subscription Form', "pacz") => "2",
					esc_html__('Contact Form', "pacz") => "3"
				),
			),
			array (
				"type" => "dropdown",
				'admin_label'=>true,
				"heading" => esc_html__ ( "Form Name", 'pacz' ),
				"param_name" => "id",
				"value" => $forms_options
			),
			array (
				"type" => "textfield",
				'admin_label'=>true,
				"heading" => esc_html__ ( "Form Title", 'pacz' ),
				"param_name" => "form_title",
				"value" =>'',
			),
			array (
				"type" => "toggle",
				'admin_label'=>true,
				"heading" => esc_html__ ( "Register link below form ON/Off", 'pacz' ),
				"param_name" => "register_link",
				"value" => 'false',
			),
			array (
				"type" => "toggle",
				'admin_label'=>true,
				"heading" => esc_html__ ( "Turn Social Login ON/Off", 'pacz' ),
				"param_name" => "allow_social_login",
				"value" =>'false',
			),
    )
));
}
/*
vc_map(array(
    "name" => esc_html__("Moving Image", "pacz"),
    "base" => "pacz_moving_image",
    "category" => esc_html__('General', 'pacz'),
    'icon' => 'icon-pacz-moving-image vc_pacz_element-icon',
    'description' => esc_html__( 'Images powered by CSS3 moving animations.', 'pacz' ),
    "params" => array(

        array(
            "type" => "upload",
            "heading" => esc_html__("Upload Your image", "pacz"),
            "param_name" => "src",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", "pacz"),
            "param_name" => "style",
            "value" => $infinite_animation,
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Align", "pacz"),
            "param_name" => "align",
            "width" => 150,
            "value" => array(
                esc_html__('Left', "pacz") => "left",
                esc_html__('Right', "pacz") => "right",
                esc_html__('Center', "pacz") => "center"
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Title & Alt", "pacz"),
            "param_name" => "title",
            "value" => "",
            "description" => esc_html__("For SEO purposes you may need to fill out the title and alt property for this image", "pacz")
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
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "pacz")
        )

    )
));



vc_map(array(
    "name" => esc_html__("Image Gallery", "pacz"),
    "base" => "pacz_gallery",
    'icon' => 'icon-pacz-image-gallery vc_pacz_element-icon',
    'description' => esc_html__( 'Adds images in grids in many styles.', 'pacz' ),
    "category" => esc_html__('General', 'pacz'),
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
            "heading" => esc_html__("Style", "pacz"),
            "param_name" => "style",
            "value" => array(
                "Grid" => "grid",
                "Slider with Thumbnails" => "thumb",
                "Masonry" => "masonry",

            ),
            "description" => esc_html__("Please choose how would you like to show you gallery images?", "pacz")
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Structure", "pacz"),
            "param_name" => "structure",
            "value" => array(
                "Column Base" => "column",
                "scroller" => "scroller"
            ),
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'grid'
                )
            )
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Masonry Style", "pacz"),
            "param_name" => "masonry_style",
            "value" => array(
                "Style 1" => "style1",
                "Style 2" => "style2",
                "Style 3" => "style3",
                "Style 4" => "style4"
            ),
            "description" => esc_html__("Mansory Styles Structure see below image :</br><img src='".PACZ_THEME_ADMIN_ASSETS_URI."/img/gallery-mansory-styles.png' /><br>", 'pacz'),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'masonry'
                )
            )
        ),
        array(
            "heading" => esc_html__("Image Size", 'pacz'),
            "description" => esc_html__("", 'pacz'),
            "param_name" => "image_size",
            "value" => array(
                esc_html__("Resize & Crop", 'pacz') => "crop",
                esc_html__("Original Size", 'pacz') => "full",
                esc_html__("Large Size", 'pacz') => "large",
                esc_html__("Medium Size", 'pacz') => "medium"
            ),
            "type" => "dropdown",
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'grid'
                )
            )
        ),
        array(
            "heading" => esc_html__("Item Spacing", 'pacz'),
            "description" => esc_html__("Space between items.", 'pacz'),
            "param_name" => "item_spacing",
            "value" => "8",
            "min" => "0",
            "max" => "50",
            "step" => "1",
            "unit" => 'px',
            "type" => "range",
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'masonry'
                )
            )
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("How many Columns?", "pacz"),
            "param_name" => "column",
            "value" => "3",
            "min" => "1",
            "max" => "6",
            "step" => "1",
            "unit" => 'column',
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "structure",
                'value' => array(
                    'column'
                )
            )
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Image Dimension", "pacz"),
            "param_name" => "scroller_dimension",
            "value" => "400",
            "min" => "100",
            "max" => "1000",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("This width will be applied to both height and width.", "pacz"),
            "dependency" => array(
                'element' => "structure",
                'value' => array(
                    'scroller'
                )
            )
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("Preview Image Width", "pacz"),
            "param_name" => "thumb_style_width",
            "value" => "700",
            "min" => "100",
            "max" => "1000",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'thumb'
                )
            )
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Preview Image Height", "pacz"),
            "param_name" => "thumb_style_height",
            "value" => "380",
            "min" => "100",
            "max" => "1000",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'thumb'
                )
            )
        ),
        array(
            "heading" => esc_html__("Hover Scenarios", 'pacz'),
            "description" => esc_html__("This is what happens when user hovers over a gallery item.", 'pacz'),
            "param_name" => "hover_scenarios",
            "value" => array(
                esc_html__("Overlay Layer", 'pacz') => "overlay",
                esc_html__("Gradient Layer", 'pacz') => 'gradient'
            ),
            "type" => "dropdown",
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Image Title", "pacz"),
            "param_name" => "enable_title",
            "value" => "true",
            "description" => esc_html__("If you dont want to show image title disable this option.", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'grid'
                )
            )
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("Image Height", "pacz"),
            "param_name" => "height",
            "value" => "500",
            "min" => "100",
            "max" => "1000",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("You can define you gallery image's height from this option. It only works for column structure", "pacz"),
            "dependency" => array(
                'element' => "structure",
                'value' => array(
                    'column'
                ),
            )
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Increase Quality of Image", "pacz"),
            "param_name" => "image_quality",
            "value" => array(
                esc_html__("No Actions", 'pacz') => "1",
                esc_html__("Images 2 times bigger (retina compatible)", 'pacz') => "2",
                esc_html__("Images 3 times bigger (fullwidth row compatible)", 'pacz') => "3"
            ),
            "description" => esc_html__("If you want Gallery images be retina compatible or you just want to use it in fullwidth row, you may consider increasing the image size. This option basically amplifies the image size to not let the browser scale it to fit the column (which is a quality loss).", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'grid'
                )
            )
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Margin Bottom", "pacz"),
            "param_name" => "margin_bottom",
            "value" => "20",
            "min" => "0",
            "max" => "300",
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
        ),
         array(
            'type' => 'item_id',
            'heading' => esc_html__( 'Item ID', 'pacz' ),
            'param_name' => "item_id"
        )

    )
));


*/

vc_map(array(
    "name" => esc_html__("Button", "pacz"),
    "base" => "pacz_button",
    "category" => esc_html__('General', 'pacz'),
    'icon' => 'icon-pacz-button vc_pacz_element-icon',
    'description' => esc_html__( 'Powerful & versatile button shortcode', 'pacz' ),
    "params" => array(
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Button Text", "pacz"),
            "param_name" => "content",
            "rows" => 1,
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", "pacz"),
            "param_name" => "style",
            "value" => array(
                //"Flat" => "flat",
                //"3D" => "three-dimension",
                //"Outline" => "outline",
               // "Line" => "line",
                "Fill" => "fill",
               // "Nudge" => "nudge",
               // "Radius" => "radius",
               // "Fancy Link" => "fancy_link"
            ),
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Corner style", "pacz"),
            "param_name" => "corner_style",
            "value" => array(
                "Pointed" => "pointed",
                "Rounded" => "rounded",
                "Full Rounded" => "full_rounded"
            ),
            "description" => esc_html__("How will your button corners look like?", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'flat',
                    'three-dimension',
                    'outline',
                    'fill',
                    'nudge'
                )
            )
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Size", "pacz"),
            "param_name" => "size",
            "value" => array(
                "Small" => "small",
                "Medium" => "medium",
                "Large" => "large",
                "X Large" => "xlarge",
                "XX Large" => "xxlarge"
            ),
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "dropdown",
            "heading" => esc_html__("display", "pacz"),
            "param_name" => "display",
            "value" => array(
				"Block" => "block",
                "Inline Block" => "inline-block",
                "Inline" => "inline"

            ),
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button Background Color", "pacz"),
            "param_name" => "bg_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'flat',
                    'three-dimension',
					'fill',
                )
            )
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button Background Color on hover", "pacz"),
            "param_name" => "bg_hover_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
					'fill'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button Text Color", "pacz"),
            "param_name" => "txt_color",
            "value" => "#fff",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'flat',
                    'three-dimension',
                    'fancy_link'
                )
            )
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("font size", "pacz"),
            "param_name" => "font_size",
            "value" => "14",
			'min' => "10",
			'min' => "24",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Underline Color", "pacz"),
            "param_name" => "underline_color",
            "value" => "#ddd",
            "description" => esc_html__("This option is for outline style.", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'fancy_link'
                )
            )
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Outline Button Skin", "pacz"),
            "param_name" => "outline_skin",
            "value" => "",
            "description" => esc_html__("This option is for outline style.", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'outline',
                    'line',
                    'fill',
                    'radius'
                )
            )
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Outline Button Hover Text", "pacz"),
            "param_name" => "outline_hover_skin",
            "value" => "#fff",
            "description" => esc_html__("This option is for outline style.", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'outline',
                    'line',
                    'fill'
                )
            )
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Outline Button Border Width", "pacz"),
            "param_name" => "outline_border_width",
            "value" => "2",
            "min" => "1",
            "max" => "5",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'outline',
                    'fill'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Nudge Button Skin", "pacz"),
            "param_name" => "nudge_skin",
            "value" => "#444444",
            "description" => esc_html__("This option is for outline style.", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'nudge'
                )
            )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Add Icon Class Name", "pacz"),
            "param_name" => "icon",
            "value" => "",
            "description" => esc_html__(" to get the icon class name (or any other font icons library that you have installed in the theme)", "pacz"). wp_kses_post(__("<a target='_blank' href='" . admin_url('tools.php?page=icon-library') . "'>Click here</a>", "pacz")),
            "dependency" => array(
                "element" => "style",
                "value" => array(
                    'flat',
                    'three-dimension',
                    'outline',
                    'line',
                    'fill',
                    'nudge',
                    'radius'
                )
            )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Button URL", "pacz"),
            "param_name" => "url",
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
            "heading" => esc_html__("Align", "pacz"),
            "param_name" => "align",
            "width" => 150,
            "value" => array(
                esc_html__('Left', "pacz") => "left",
                esc_html__('Right', "pacz") => "right",
                esc_html__('Center', "pacz") => "center"
            ),
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Button ID", "pacz"),
            "param_name" => "id",
            "value" => "",
            "description" => esc_html__("If your want to use id for this button to refer it in your custom JS, fill this textbox.", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Margin Bottom", "pacz"),
            "param_name" => "margin_bottom",
            "value" => "15",
            "min" => "-30",
            "max" => "500",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Infinite Animations", "pacz"),
            "param_name" => "infinite_animation",
            "value" => $infinite_animation,
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                "element" => "style",
                "value" => array(
                    'flat',
                    'three-dimension',
                    'outline',
                    'line',
                    'fill',
                    'nudge',
                    'radius'
                )
            )
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


vc_map(array(
    "name" => esc_html__("Call to Action", "pacz"),
    "base" => "pacz_call_to_action",
    "category" => esc_html__('General', 'pacz'),
    'icon' => 'icon-pacz-mini-callout-box vc_pacz_element-icon',
    'description' => esc_html__( 'Callout box for important infos.', 'pacz' ),
    "params" => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Layout Style", "pacz"),
            "param_name" => "layout_style",
            "value" => array(
                "Aside 1" => "aside1",
				//"Aside 2" => "aside2",
                "Centered" => "centered",
				//"Modern" => "modern"
            ),

            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Box Border Width", "pacz"),
            "param_name" => "box_border_width",
            "value" => "0",
            "min" => "1",
            "max" => "5",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
        ),
       /* array(
            "type" => "range",
            "heading" => esc_html__("Button Border Width", "pacz"),
            "param_name" => "button_border_width",
            "value" => "2",
            "min" => "1",
            "max" => "5",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Box Background Color", "pacz"),
            "param_name" => "bg_color",
            "value" => "#272e43",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'custom'
                )
            )
        ),*/
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Box Border Color", "pacz"),
            "param_name" => "border_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
        ),
		array(
            "type" => "upload",
            "heading" => esc_html__("Call To Action Image", "pacz"),
            "param_name" => "image",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "layout_style",
                'value' => array(
                    'aside1',
                )
            )
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Image Width", "pacz"),
            "param_name" => "image_width",
            "value" => "370",
            "min" => "0",
            "max" => "370",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
			"dependency" => array(
                'element' => "layout_style",
                'value' => array(
                    'aside1',
                )
            )
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Image Height", "pacz"),
            "param_name" => "image_height",
            "value" => "690",
            "min" => "0",
            "max" => "1000",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
			"dependency" => array(
                'element' => "layout_style",
                'value' => array(
                    'aside1',
                )
            )
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Box offset", "pacz"),
            "param_name" => "box_offset",
            "value" => "180",
            "min" => "0",
            "max" => "500",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("this option will reduce main box height which is equal to image height", "pacz"),
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Image offset", "pacz"),
            "param_name" => "image_offset",
            "value" => "-60",
            "min" => "-200",
            "max" => "200",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("move image up/down", "pacz"),
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Big Text Color for 1st and 3rd field", "pacz"),
            "param_name" => "text_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Big Text Color for 2nd field", "pacz"),
            "param_name" => "text_color2",
            "value" => "",
            "description" => esc_html__("", "pacz"),
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("small Text Color for 1st and 3rd field", "pacz"),
            "param_name" => "small_text_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("small Text Color for 2nd field", "pacz"),
            "param_name" => "small_text_color2",
            "value" => "",
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Bix Text Font Size", "pacz"),
            "param_name" => "text_size",
            "value" => "",
            "min" => "12",
            "max" => "70",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
        ),
		 array(
            "type" => "range",
            "heading" => esc_html__("Small Text Font Size", "pacz"),
            "param_name" => "small_text_size",
            "value" => "",
            "min" => "12",
            "max" => "70",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Font Weight", "pacz"),
            "param_name" => "font_weight",
            "width" => 150,
            "value" => array(
                esc_html__('Default', "pacz") => "inherit",
                esc_html__('Semi Bold', "pacz") => "600",
                esc_html__('Bold', "pacz") => "bold",
                esc_html__('Bolder', "pacz") => "bolder",
                esc_html__('Normal', "pacz") => "normal",
                esc_html__('Light', "pacz") => "300"
            ),
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Text Transform", "pacz"),
            "param_name" => "text_transform",
            "width" => 150,
            "value" => array(
                esc_html__('Default', "pacz") => "uppercase",
                esc_html__('None', "pacz") => "none",
                esc_html__('Uppercase', "pacz") => "uppercase",
                esc_html__('Lowercase', "pacz") => "lowercase",
                esc_html__('Capitalize', "pacz") => "capitalize"
            ),
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Content Big Text field 1", "pacz"),
            "param_name" => "text",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("Content Big Text Field 2", "pacz"),
            "param_name" => "text2",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("Content Big Text field 3", "pacz"),
            "param_name" => "text3",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("Content Text small filed 1", "pacz"),
            "param_name" => "small_text1",
            "value" => "",
            "description" => esc_html__("", "pacz"),
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("Content Text small filed 2", "pacz"),
            "param_name" => "small_text2",
            "value" => "",
            "description" => esc_html__("", "pacz"),
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("Content Text small field 3", "pacz"),
            "param_name" => "small_text3",
            "value" => "",
            "description" => esc_html__("", "pacz"),
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("Content Text field 4", "pacz"),
            "param_name" => "text4",
            "value" => "",
            "description" => esc_html__("", "pacz"),
			"dependency" => array(
                'element' => "layout_style",
                'value' => array(
                    'modern'
                )
            )
        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__("Turn On/Off Buttons", "pacz"),
            "param_name" => "action_btn",
            "value" => "true",
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Button 1 Text", "pacz"),
            "param_name" => "btn1_text",
            "value" => esc_html__("Read More", "pacz"),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Button 1 URL", "pacz"),
            "param_name" => "btn1_url",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("Button 2 Text", "pacz"),
            "param_name" => "btn2_text",
            "value" => esc_html__("Purchase", "pacz"),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Button 2 URL", "pacz"),
            "param_name" => "btn2_url",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "dropdown",
            "heading" => esc_html__("URL Target", "pacz"),
            "param_name" => "target",
            "width" => 150,
            "value" => array(
                esc_html__('Same window', "pacz") => "same",
                esc_html__('New Window', "pacz") => "new",
            ),
            "description" => esc_html__("", "pacz"),
        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Button Width", "pacz"),
            "param_name" => "btn_width",
            "value" => '190',
			'max' => '250',
			'min' => '60',
			"unit" => 'px',
			'step' => '1',   
			"description" => esc_html__("", "pacz"),
        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Button Height", "pacz"),
            "param_name" => "btn_height",
            "value" => '56',
			'max' => '100',
			'min' => '20',
			"unit" => 'px',
			'step' => '1',   
			"description" => esc_html__("", "pacz"),
        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Button Font Size", "pacz"),
            "param_name" => "btn_font_size",
            "value" => '14',
			'max' => '32',
			'min' => '10',
			"unit" => 'px',
			'step' => '1',   
			"description" => esc_html__("", "pacz"),
        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Button Border Radius", "pacz"),
            "param_name" => "btn_radius",
            "value" => '3',
			'max' => '100',
			'min' => '0',
			"unit" => 'px',
			'step' => '1',   
			"description" => esc_html__("", "pacz"),
        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" Gap between Buttons", "pacz"),
            "param_name" => "btn_gutter",
            "value" => '15',
			'max' => '50',
			'min' => '0',
			"unit" => 'px',
			'step' => '1',   
			"description" => esc_html__("", "pacz"),
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("Button Box Shadow", "pacz"),
            "param_name" => "btn_shadow",
            "value" => esc_html__("", "pacz"),
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "dropdown",
            "heading" => esc_html__("Text Transform", "pacz"),
            "param_name" => "btn_text_transform",
            "width" => 150,
            "value" => array(
                esc_html__('Uppercase', "pacz") => "uppercase",
                esc_html__('Lowercase', "pacz") => "lowercase",
                esc_html__('Capitalize', "pacz") => "capitalize",
				esc_html__('None', "pacz") => "none",
            ),
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button 1 text color", "pacz"),
            "param_name" => "btn1_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button 1 text color on hover", "pacz"),
            "param_name" => "btn1_color_hover",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button 1 Background Color", "pacz"),
            "param_name" => "btn1_bg",
            "value" => "",
            "description" => esc_html__("", "pacz"),
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button 1 Background Color on hover", "pacz"),
            "param_name" => "btn1_bg_hover",
            "value" => "",
            "description" => esc_html__("", "pacz"),
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button 2 text color", "pacz"),
            "param_name" => "btn2_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button 2 text color on hover", "pacz"),
            "param_name" => "btn2_color_hover",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button 2 background color", "pacz"),
            "param_name" => "btn2_bg",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button 2 background color on hover", "pacz"),
            "param_name" => "btn2_bg_hover",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "pacz")
        )
    )
));
/*
vc_map(array(
    "name" => esc_html__("Message Box", "pacz"),
    "base" => "pacz_message_box",
    'icon' => 'icon-pacz-message-box vc_pacz_element-icon',
    "category" => esc_html__('General', 'pacz'),
    'description' => esc_html__( 'Message Box with multiple types.', 'pacz' ),
    "params" => array(

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Type", "pacz"),
            "param_name" => "type",
            "value" => array(
                "Love Box" => "love",
                "Hint Box" => "hint",
                "Solution Box" => "solution",
                "Alert Box" => "alert",
                "Confirm Box" => "confirm",
                "Warning Box" => "warning",
                "Star Box" => "star",
                "Built It Yourself" => "generic"
            ),

            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", "pacz"),
            "param_name" => "style",
            "value" => array(
                "Pointed Style" => "pointed",
                "Rounded Style" => "rounded"
            ),

            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Add Box Icon Class Name", "pacz"),
            "param_name" => "icon",
            "value" => "",
            "description" => esc_html__(" to get the icon class name (or any other font icons library that you have installed in the theme)", "pacz"). wp_kses_post(__("<a target='_blank' href='" . admin_url('tools.php?page=icon-library') . "'>Click here</a>", "pacz")),
            "dependency" => array(
                'element' => "type",
                'value' => array(
                    'generic'
                )
            )
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Box Color", "pacz"),
            "param_name" => "box_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "type",
                'value' => array(
                    'generic'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Border Color", "pacz"),
            "param_name" => "border_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "type",
                'value' => array(
                    'generic'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Content Color", "pacz"),
            "param_name" => "content_color",
            "value" => "",
            "description" => esc_html__("This option affects icon, vertical separator and text color.", "pacz"),
            "dependency" => array(
                'element' => "type",
                'value' => array(
                    'generic'
                )
            )
        ),

        array(
            "type" => "textarea_html",
            "holder" => "div",
            "heading" => esc_html__("Write your message in this textarea.", "pacz"),
            "param_name" => "content",
            "value" => esc_html__("", "pacz"),
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
*/
vc_map(array(
    "name" => esc_html__("Icon Box", "pacz"),
    "base" => "pacz_icon_box",
    "category" => esc_html__('General', 'pacz'),
    'icon' => 'icon-pacz-icon-box vc_pacz_element-icon',
    'description' => esc_html__( 'Powerful & versatile Icon Boxes.', 'pacz' ),
    "params" => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Box Style", "pacz"),
            "param_name" => "style",
            "width" => 300,
            "value" => array(
                esc_html__('Style 1', "pacz") => "style1",
                esc_html__('Style 2', "pacz") => "style2",
                esc_html__('Style 3', "pacz") => "style3",
                esc_html__('Style 4', "pacz") => "style4",
                esc_html__('Style 5', "pacz") => "style5",
                esc_html__('Style 6', "pacz") => "style6",
                esc_html__('Style 7', "pacz") => "style7",
				esc_html__('Style 8', "pacz") => "style8",
				esc_html__('Style 9', "pacz") => "style9"
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Icon Type", "pacz"),
            "param_name" => "icon_type",
            "value" => array(
                esc_html__('Icon', "pacz") => "icon",
                esc_html__('Image', "pacz") => "image"
            ),
            "description" => esc_html__("", "pacz"),
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Add Icon Class Name", "pacz"),
            "param_name" => "icon",
            "value" => "",
            "description" => esc_html__(" to get the icon class name (or any other font icons library that you have installed in the theme)", "pacz"). wp_kses_post(__("<a target='_blank' href='" . admin_url('tools.php?page=icon-library') . "'>Click here</a>", "pacz")),
            "dependency" => array(
                'element' => "icon_type",
                'value' => array(
                    'icon'
                )
            )
        ),

        array(
            "type" => "attach_image",
            "heading" => esc_html__("Icon Image", "pacz"),
            "param_name" => "icon_image",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "icon_type",
                'value' => array(
                    'image'
                )
            )
        ),
		array(
            "type" => "attach_image",
            "heading" => esc_html__("Icon Image on hover", "pacz"),
            "param_name" => "icon_image_hover",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "icon_type",
                'value' => array(
                    'image'
                )
            )
        ),
        
        array(
            "type" => "toggle",
            "heading" => esc_html__("Icon Container Frame?", "pacz"),
            "param_name" => "icon_frame",
            "value" => "true",
            "description" => esc_html__("If disabed, icon frame will be removed and box background color will be given to icon color. This option only works for Style 7.", "pacz"),
             "dependency" => array(
                'element' => "style",
                'value' => array(
                    'style7'
                )
            ),
        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__("Icon Container Circle?", "pacz"),
            "param_name" => "rounded",
            "value" => "true",
            "description" => esc_html__("If you disable this option the icon container will not be rounded.", "pacz"),
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Icon Align", "pacz"),
            "param_name" => "icon_align",
            "width" => 300,
            "value" => array(
                esc_html__('Left', "pacz") => "left",
                esc_html__('Right', "pacz") => "right",
                esc_html__('Top (Style7)', "pacz") => "top"
            ),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'style2',
                    'style7'
                )
            ),
            "description" => esc_html__("Please note that this option only works with Style 2 and 7. Top option only works for style 7.", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Icon Size (Style 7 only)", "pacz"),
            "param_name" => "icon_size",
            "value" => array(
                esc_html__('Small', "pacz") => "small",
                esc_html__('Medium (48px)', "pacz") => "medium",
                esc_html__('Large (64px)', "pacz") => "large",
            ),
            "description" => esc_html__("Please note that this option will not work for image type icon.", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'style7'
                )
            )
        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" border width", "pacz"),
            "param_name" => "box_style8_border_width",
            "value" => '1',
			'max' => '5',
			'min' => '0',
			"unit" => 'px',
			'step' => '1',   
			"description" => esc_html__("Please note that this option will not work for image type icon.", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'style8'
                )
            )
        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" border radius", "pacz"),
            "param_name" => "box_style8_border_radius",
            "value" => '0',
			'max' => '10',
			'min' => '0',
			"unit" => 'px',
			'step' => '1',   
			"description" => esc_html__("Please note that this option will not work for image type icon.", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'style8'
                )
            )
        ),
		array(
            "type" => "range",
            "heading" => esc_html__(" box shadow", "pacz"),
            "param_name" => "box_style8_box_shadow",
            "value" => '0',
			'max' => '100',
			'min' => '0',
			'step' => '1',   
			"description" => esc_html__("Please note that this option will not work for image type icon.", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'style8'
                )
            )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Title", "pacz"),
            "param_name" => "title",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "textarea_html",
            "holder" => "div",
            "heading" => esc_html__("Description", "pacz"),
            "param_name" => "content",
            "value" => esc_html__("", "pacz"),
            "description" => esc_html__("Enter your content.", "pacz")
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Read More Text", "pacz"),
            "param_name" => "read_more_txt",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Read More URL", "pacz"),
            "param_name" => "read_more_url",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),

        

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Icon Skin", "pacz"),
            "param_name" => "icon_color",
            "value" => "",
            "description" => esc_html__("Icon color for style 1, style 2, style 3, style 5 means the icon color. For style 4, style 6 and style 7 icon frame fill color.", "pacz")
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Image Icon Background on hover", "pacz"),
            "param_name" => "icon_bg_color_hover",
            "value" => "",
            "description" => esc_html__("Icon color for style 1, style 2, style 3, style 5 means the icon color. For style 4, style 6 and style 7 icon frame fill color.", "pacz")
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Title Color", "pacz"),
            "param_name" => "title_color",
            "value" => "",
            "description" => esc_html__("Optionally you can modify Title color inside this shortcode.", "pacz")
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Paragraph Color", "pacz"),
            "param_name" => "txt_color",
            "value" => "",
            "description" => esc_html__("Optionally you can modify text color inside this shortcode.", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button Skin Color", "pacz"),
            "param_name" => "btn_skin",
            "value" => "",
            "description" => esc_html__("This option is for outline style.", "pacz"),
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button Hover Text Color", "pacz"),
            "param_name" => "btn_hover_skin",
            "value" => "",
            "description" => esc_html__("This option is for outline style.", "pacz"),
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("Paragraph Text Line Height", "pacz"),
            "param_name" => "p_line_height",
            "value" => "26",
            "min" => "0",
            "max" => "50",
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

        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "pacz")
        )
    )
));





/*

vc_map(array(
    "name" => esc_html__("Divider", "pacz"),
    "base" => "pacz_divider",
    "category" => esc_html__('General', 'pacz'),
    'icon' => 'icon-pacz-divider vc_pacz_element-icon',
    'description' => esc_html__( 'Dividers with many styles & options.', 'pacz' ),
    "params" => array(

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", "pacz"),
            "param_name" => "style",
            "value" => array(
                "Line" => 'single',
                "Dotted" => 'dotted',
                "Dashed" => 'dashed',
                "Thick" => 'thick'
            ),
            "description" => esc_html__("Please Choose the style of the line of divider.", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Divider Color (optional)", "pacz"),
            "param_name" => "divider_color",
            "value" => '',
            "description" => esc_html__("This option will not affect fancy divider border color. default color : #e4e4e4", "pacz")
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Divider Width", "pacz"),
            "param_name" => "divider_width",
            "value" => array(
                "Full Width" => "full_width",
                "One Half" => "one_half",
                "One Third" => "one_third",
                "One Fourth" => "one_fourth",
                "Custom Width" => "custom_width"
            ),
            "description" => esc_html__("There are 5 widths you can define for each of your divider styles.", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Divider Custom Width", "pacz"),
            "param_name" => "custom_width",
            "value" => "10",
            "min" => "1",
            "max" => "900",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("Choose any custom width for divider", "pacz"),
            "dependency" => array(
                'element' => "divider_width",
                'value' => array(
                    'custom_width'
                )
            )
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Align", "pacz"),
            "param_name" => "align",
            "value" => array(
                "Center" => "center",
                "Left" => "left",
                "Right" => "right",
            ),
            "dependency" => array(
                'element' => "divider_width",
                'value' => array(
                    'custom_width'
                )
            )
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Divider Thickness", "pacz"),
            "param_name" => "thickness",
            "value" => "2",
            "min" => "1",
            "max" => "20",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'single'
                )
            )
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Padding Top", "pacz"),
            "param_name" => "margin_top",
            "value" => "20",
            "min" => "0",
            "max" => "500",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("How much space would you like to have before divider? this value will be applied to top.", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Padding Bottom", "pacz"),
            "param_name" => "margin_bottom",
            "value" => "20",
            "min" => "0",
            "max" => "500",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("How much space would you like to have after divider? this value will be applied to bottom.", "pacz")
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
    "name" => esc_html__("Table", "pacz"),
    "base" => "pacz_table",
    "category" => esc_html__('General', 'pacz'),
    'icon' => 'icon-pacz-table vc_pacz_element-icon',
    'description' => esc_html__( 'Adds styles to your data tables.', 'pacz' ),
    "params" => array(
        array(
            "type" => "textarea_html",
            "holder" => "div",
            "heading" => esc_html__("Table HTML content. You can use below sample and create your own data tables.", "pacz"),
            "param_name" => "content",
            "value" => '<table width="100%">
<thead>
<tr>
<th>Column 1</th>
<th>Column 2</th>
<th>Column 3</th>
<th>Column 4</th>
</tr>
</thead>
<tbody>
<tr>
<td>Item #1</td>
<td>Description</td>
<td>Subtotal:</td>
<td>$3.00</td>
</tr>
<tr>
<td>Item #2</td>
<td>Description</td>
<td>Discount:</td>
<td>$4.00</td>
</tr>
<tr>
<td>Item #3</td>
<td>Description</td>
<td>Shipping:</td>
<td>$7.00</td>
</tr>
<tr>
<td>Item #4</td>
<td>Description</td>
<td>Tax:</td>
<td>$6.00</td>
</tr>
<tr>
<td><strong>All Items</strong></td>
<td><strong>Description</strong></td>
<td><strong>Your Total:</strong></td>
<td><strong>$20.00</strong></td>
</tr>
</tbody>
</table>',
            "description" => esc_html__("Please paste your table html code here.", "pacz")
        ),


        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "pacz")
        )
    )
));
*/
vc_map(array(
    "name" => esc_html__("Skill Meter", "pacz"),
    "base" => "pacz_skill_meter",
    'icon' => 'icon-pacz-skill-meter vc_pacz_element-icon',
    'description' => esc_html__( 'Show skills in bars by percent.', 'pacz' ),
    "params" => array(

        array(
            "type" => "textfield",
            "heading" => esc_html__("Title", "pacz"),
            "param_name" => "title",
            "value" => "",
            "description" => esc_html__("What skill are you demonstrating?", "pacz")
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("Percent", "pacz"),
            "param_name" => "percent",
            "value" => "50",
            "min" => "0",
            "max" => "100",
            "step" => "1",
            "unit" => '%',
            "description" => esc_html__("How many percent would you like to show from this skill?", "pacz")
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("Progress Bar Height?", "pacz"),
            "param_name" => "height",
            "value" => "17",
            "min" => "5",
            "max" => "50",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Title Color", "pacz"),
            "param_name" => "title_color",
            "value" => '#777',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Progress Bar Background Color", "pacz"),
            "param_name" => "progress_bar_color",
            "value" => $skin_color,
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Track Bar Background Color", "pacz"),
            "param_name" => "track_bar_color",
            "value" => '#eee',
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
    "name" => esc_html__("Chart", "pacz"),
    "base" => "pacz_chart",
    "category" => esc_html__('General', 'pacz'),
    'icon' => 'icon-pacz-chart vc_pacz_element-icon',
    'description' => esc_html__( 'Powerful & versatile Chart element.', 'pacz' ),
    "params" => array(

        array(
            "type" => "range",
            "heading" => esc_html__("Percent", "pacz"),
            "param_name" => "percent",
            "value" => "50",
            "min" => "0",
            "max" => "100",
            "step" => "1",
            "unit" => '%',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Bar Color", "pacz"),
            "param_name" => "bar_color",
            "value" => $skin_color,
            "description" => esc_html__("The color of the circular bar.", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Track Color", "pacz"),
            "param_name" => "track_color",
            "value" => "#fafafa",
            "description" => esc_html__("The color of the track for the bar.", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Line Width", "pacz"),
            "param_name" => "line_width",
            "value" => "15",
            "min" => "1",
            "max" => "20",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("Width of the bar line.", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Bar Size", "pacz"),
            "param_name" => "bar_size",
            "value" => "170",
            "min" => "1",
            "max" => "500",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("The Diameter of the bar.", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Content", "pacz"),
            "param_name" => "content_type",
            "width" => 200,
            "value" => array(
                "Percent" => "percent",
                "Icon" => "icon",
                "Custom Text" => "custom_text"
            ),
            "description" => esc_html__("The content inside the bar. If you choose icon, you should select your icon from below list. if you have selected custom text, then you should fill out the 'custom text' option below.", "pacz")
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Icon Size", "pacz"),
            "param_name" => "icon_size",
            "width" => 200,
            "value" => array(
                "Small (16px)" => "16px",
                "Medium (32px)" => "32px",
                "Large (64px)" => "64px",
                "X Large (128px)" => "128px"
            ),
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "content_type",
                'value' => array(
                    'icon'
                )
            )
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Font Size?", "pacz"),
            "param_name" => "font_size",
            "value" => "18",
            "min" => "15",
            "max" => "50",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "content_type",
                'value' => array(
                    'custom_text',
                    'percent'
                )
            )
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Font Weight", "pacz"),
            "param_name" => "font_weight",
            "width" => 150,
            "value" => array(
                esc_html__('Default', "pacz") => "inherit",
                esc_html__('Semi Bold', "pacz") => "600",
                esc_html__('Bold', "pacz") => "bold",
                esc_html__('Bolder', "pacz") => "bolder",
                esc_html__('Normal', "pacz") => "normal",
                esc_html__('Light', "pacz") => "300"
            ),
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "content_type",
                'value' => array(
                    'custom_text',
                    'percent'
                )
            )
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Add Icon Class Name", "pacz"),
            "param_name" => "icon",
            "value" => "",
            "description" => esc_html__(" to get the icon class name (or any other font icons library that you have installed in the theme)", "pacz"). wp_kses_post(__("<a target='_blank' href='" . admin_url('tools.php?page=icon-library') . "'>Click here</a>", "pacz")),
            "dependency" => array(
                'element' => "content_type",
                'value' => array(
                    'icon'
                )
            )
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Custom Text", "pacz"),
            "param_name" => "custom_text",
            "value" => "",
            "description" => esc_html__("Description will appear below each chart.", "pacz"),
            "dependency" => array(
                'element' => "content_type",
                'value' => array(
                    'custom_text'
                )
            )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Description", "pacz"),
            "param_name" => "desc",
            "value" => "",
            "description" => esc_html__("Description will appear below each chart.", "pacz")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Font Size?", "pacz"),
            "param_name" => "disc_font_size",
            "value" => "18",
            "min" => "15",
            "max" => "50",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "content_type",
                'value' => array(
                    'custom_text',
                    'percent'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Description Color", "pacz"),
            "param_name" => "desc_color",
            "value" => "",
            "description" => esc_html__("The color of the description.", "pacz")
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
    "name" => esc_html__("Padding Divider", "pacz"),
    "base" => "pacz_padding_divider",
   'icon' => 'icon-pacz-padding-space vc_pacz_element-icon',
    "category" => esc_html__('General', 'pacz'),
    'description' => esc_html__( 'Adds space between elements', 'pacz' ),
    "params" => array(
        array(
            "type" => "range",
            "heading" => esc_html__("Padding Size (Px)", "pacz"),
            "param_name" => "size",
            "value" => "40",
            "min" => "0",
            "max" => "500",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("How much space would you like to drop in this specific padding shortcode?", "pacz")
        )
    )
));

vc_map(array(
    "name" => esc_html__("Animated Columns", "pacz"),
    "base" => "pacz_animated_columns",
    "category" => esc_html__('General', 'pacz'),
    'icon' => 'icon-pacz-animated-columns vc_pacz_element-icon',
    'description' => esc_html__( 'Columns with cool animations.', 'pacz' ),
    "params" => array(
        array(
            "type" => "range",
            "heading" => esc_html__("Column Height", "pacz"),
            "param_name" => "column_height",
            "value" => "500",
            "min" => "100",
            "max" => "1200",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("Set the columns height", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("How many Columns in One Row?", "pacz"),
            "param_name" => "column_number",
            "value" => "4",
            "min" => "1",
            "max" => "8",
            "step" => "1",
            "unit" => 'columns',
            "description" => esc_html__("How many columns would you like to show in one row?", "pacz")
        ),
        array(
            "type" => "multiselect",
            "heading" => esc_html__("Choose the Animated Columns", "pacz"),
            "param_name" => "columns",
            "value" => '',
            "options" => $animated_columns,
            "description" => esc_html__("", "pacz")
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
            "description" => esc_html__("Sort retrieved pricing items by parameter.", 'pacz'),
            "param_name" => "orderby",
            "value" => $pacz_orderby,
            "type" => "dropdown"
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Column Styles", "pacz"),
            "param_name" => "style",
            "value" => array(
                "Simple Icon (Icon+Title)" => "simple",
                "Simple Text (Text+Title)" => "simple_text",
                "Full Featured (All)" => "full",
            ),
            "description" => esc_html__("Please choose your columns styles. In each style the feeding content and hover scenarios will be different.", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Columns Border Color", "pacz"),
            "param_name" => "border_color",
            "value" => "",
            "description" => esc_html__("The column box color.", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Columns Hover Border Color", "pacz"),
            "param_name" => "border_hover_color",
            "value" => "",
            "description" => esc_html__("The column box color.", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Columns background Color", "pacz"),
            "param_name" => "bg_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Columns background Hover Color", "pacz"),
            "param_name" => "bg_hover_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Icon Size", "pacz"),
            "param_name" => "icon_size",
            "value" => array(
                esc_html__('16px', "pacz") => "16",
                esc_html__('32px', "pacz") => "32",
                esc_html__('48px', "pacz") => "48",
                esc_html__('64px', "pacz") => "64",
                esc_html__('128px', "pacz") => "128"
            ),
            "description" => esc_html__("Choose the icon sizes.", "pacz")
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Icon / Text Color", "pacz"),
            "param_name" => "icon_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Icon / Text Hover Color", "pacz"),
            "param_name" => "icon_hover_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Text Color (Active)", "pacz"),
            "param_name" => "txt_color",
            "value" => "",
            "description" => esc_html__("This color will be used for title and description normal color. Description will have 70% opacity.", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Text Color (Hover)", "pacz"),
            "param_name" => "txt_hover_color",
            "value" => "",
            "description" => esc_html__("This color will be used for title and description hover color.", "pacz")
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button Color (Active)", "pacz"),
            "param_name" => "btn_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button Color (Hover)", "pacz"),
            "param_name" => "btn_hover_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
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

*/

vc_map(array(
    "name" => esc_html__("Milestones", "pacz"),
    "base" => "pacz_milestone",
    "category" => esc_html__('General', 'pacz'),
    'icon' => 'icon-pacz-milestone vc_pacz_element-icon',
    'description' => esc_html__( 'Milestone numbers to show statistics.', 'pacz' ),
    "params" => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Content Below Numbers?", "pacz"),
            "param_name" => "style",
            "width" => 200,
            "value" => array(
                "Classic" => "classic",
                "Modern" => "modern"
            ),
            "description" => esc_html__("", "pacz")
        ),
		array(
			"type" => "theme_fonts",
			"heading" => esc_html__("Font Family", "pacz"),
			"param_name" => "font_family",
			"value" => "Roboto",
			"description" => esc_html__("You can choose a font for this shortcode, however using non-safe fonts can affect page load and performance.", "pacz")
		),
		
		array(
            "type" => "textfield",
            "heading" => esc_html__("Element width", "pacz"),
            "param_name" => "mile_width",
            "value" => "150",
			"min" => "100",
            "max" => "370",
            "step" => "1",
            "description" => esc_html__("Please choose in which number it should start.", "pacz"),
			"dependency" => array(
                'element' => "style",
                'value' => array(
                    'classic'
                )
            )
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("Element height", "pacz"),
            "param_name" => "mile_height",
            "value" => "150",
			"min" => "100",
            "max" => "370",
            "step" => "1",
            "description" => esc_html__("Please choose in which number it should start.", "pacz")
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("Element Radius", "pacz"),
            "param_name" => "mile_radius",
            "value" => "500",
			"min" => "100",
            "max" => "370",
            "step" => "1",
            "description" => esc_html__("Please choose in which number it should start.", "pacz")
        ),
		array(
            "type" => "toggle",
            "heading" => esc_html__("box shadow", "pacz"),
            "param_name" => "mile_shadow",
            "value" => 'false',
            "description" => esc_html__("Please choose in which number it should start.", "pacz")
        ),
		 array(
            "type" => "colorpicker",
            "heading" => esc_html__("milestone background color", "pacz"),
            "param_name" => "mile_bg_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
        ),
		 array(
            "type" => "colorpicker",
            "heading" => esc_html__("milestone Border color", "pacz"),
            "param_name" => "mile_border_color",
            "value" => "#fff",
            "description" => esc_html__("", "pacz"),
             "dependency" => array(
                'element' => "style",
                'value' => array(
                    'classic',
					'modern'
                )
            )
        ),
		 array(
            "type" => "textfield",
            "heading" => esc_html__("milestone Border Width", "pacz"),
            "param_name" => "mile_border_width",
            "value" => "2",
            "description" => esc_html__("", "pacz"),
             "dependency" => array(
                'element' => "style",
                'value' => array(
                    'classic',
					'modern'
                )
            )
        ),
		array(
            "type" => "dropdown",
            "heading" => esc_html__("Border style", "pacz"),
            "param_name" => "mile_border_style",
            "value" => array(
                esc_html__('solid', "pacz") => "solid",
                esc_html__('dotted', "pacz") => "dotted",
                esc_html__('none', "pacz") => "none"
            ),
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Number Start at", "pacz"),
            "param_name" => "start",
            "value" => "0",
            "min" => "0",
            "max" => "100000",
            "step" => "1",
            "unit" => '',
            "description" => esc_html__("Please choose in which number it should start.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Number Stop at", "pacz"),
            "param_name" => "stop",
            "value" => "100",
            "min" => "0",
            "max" => "100000",
            "step" => "1",
            "unit" => '',
            "description" => esc_html__("Please choose in which number it should Stop.", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Speed", "pacz"),
            "param_name" => "speed",
            "value" => "2000",
            "min" => "0",
            "max" => "10000",
            "step" => "1",
            "unit" => 'ms',
            "description" => esc_html__("Speed of the animation from start to stop in milliseconds.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Number Text Size", "pacz"),
            "param_name" => "number_size",
            "value" => "36",
            "min" => "10",
            "max" => "60",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Content Below Numbers?", "pacz"),
            "param_name" => "type",
            "width" => 200,
            "value" => array(
                "Icon" => "icon",
                "Text" => "text",
                "No Content" => "none"
            ),
            "description" => esc_html__("Using icon or text would you prefer to represent this milestone?", "pacz")
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Add Icon Class Name", "pacz"),
            "param_name" => "icon",
            "value" => "",
            "description" => esc_html__(" to get the icon class name (or any other font icons library that you have installed in the theme)", "pacz"). wp_kses_post(__("<a target='_blank' href='" . admin_url('tools.php?page=icon-library') . "'>Click here</a>", "pacz")),
             "dependency" => array(
                'element' => "type",
                'value' => array(
                    'icon'
                )
            )
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Icon Size?", "pacz"),
            "param_name" => "icon_size",
            "width" => 200,
            "value" => array(
                esc_html__('16px', "pacz") => "16",
                esc_html__('32px', "pacz") => "32",
                esc_html__('48px', "pacz") => "48",
                esc_html__('64px', "pacz") => "64",
                esc_html__('128px', "pacz") => "128"
            ),
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "type",
                'value' => array(
                    'icon'
                )
            )
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Text Below Numbers", "pacz"),
            "param_name" => "text",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "type",
                'value' => array(
                    'text'
                )
            )
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Number Suffix", "pacz"),
            "param_name" => "text_suffix",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'modern'
                )
            )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Number Suffix Text Size", "pacz"),
            "param_name" => "number_suffix_text_size",
            "value" => "16",
            "min" => "10",
            "max" => "60",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'modern'
                )
            )
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Text Size", "pacz"),
            "param_name" => "text_size",
            "value" => "16",
            "min" => "10",
            "max" => "60",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "type",
                'value' => array(
                    'text'
                )
            )
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Numbers Bckground Color", "pacz"),
            "param_name" => "number_background",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Numbers Bckground Color on hover", "pacz"),
            "param_name" => "number_background_hover",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Skin color", "pacz"),
            "param_name" => "color",
            "value" => "#919191",
            "description" => esc_html__("", "pacz")
        ),
		
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Text/Icon Color", "pacz"),
            "param_name" => "text_icon_color",
            "value" => "#fff",
            "description" => esc_html__("", "pacz"),
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
    "name" => esc_html__("Audio Player", "pacz"),
    "base" => "pacz_audio",
    "category" => esc_html__('General', 'pacz'),
    'icon' => 'icon-pacz-audio-player vc_pacz_element-icon',
    'description' => esc_html__( 'Adds player to your audio files.', 'pacz' ),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Audio Title", "pacz"),
            "param_name" => "file_title",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "upload",
            "heading" => esc_html__("Upload MP3 file format", "pacz"),
            "param_name" => "mp3_file",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "upload",
            "heading" => esc_html__("Upload OGG file format", "pacz"),
            "param_name" => "ogg_file",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),


        array(
            "type" => "toggle",
            "heading" => esc_html__("For small container?", "pacz"),
            "param_name" => "small_version",
            "value" => "false",
            "description" => esc_html__("If you want to use this player in a small container enable this option. This option will force player controls to below progress bar.", "pacz")
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
    "name" => esc_html__("Process Steps", "pacz"),
    "base" => "pacz_process_steps",
    "as_parent" => array('only' => 'pacz_step'),
    "content_element" => true,
    'icon' => 'icon-pacz-process-builder vc_pacz_element-icon',
    'description' => esc_html__( 'Adds process steps element.', 'pacz' ),
    "category" => esc_html__('Content', 'pacz'),
    "params" => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Orientation", "pacz"),
            "param_name" => "orientation",
            "value" => array(
                "Vertical" => "vertical",
                "Horizontal" => "horizontal"

            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Skin", "pacz"),
            "param_name" => "skin",
            "value" => array(
                "dark" => "dark",
                "Light" => "light",
                "Custom" => "custom"

            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Background Color?", "pacz"),
            "param_name" => "background_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "skin",
                'value' => array(
                    'custom'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Border Color?", "pacz"),
            "param_name" => "border_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "skin",
                'value' => array(
                    'custom'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Icon Color?", "pacz"),
            "param_name" => "icon_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "skin",
                'value' => array(
                    'custom'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Icon Hover Color?", "pacz"),
            "param_name" => "icon_hover_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "skin",
                'value' => array(
                    'custom'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Title Color?", "pacz"),
            "param_name" => "title_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "skin",
                'value' => array(
                    'custom'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Description Color?", "pacz"),
            "param_name" => "description_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "skin",
                'value' => array(
                    'custom'
                )
            )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "pacz")
        )
    ),
 "js_view" => 'VcColumnView'
));



vc_map(array(
    "name" => esc_html__("Step", "pacz"),
    "base" => "pacz_step",
    "content_element" => true,
    "as_child" => array('only' => 'pacz_process_steps'),
    "is_container" => true,
    'icon' => 'icon-pacz-process-builder vc_pacz_element-icon',
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Title", "pacz"),
            "param_name" => "title",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("Title Font Size?", "pacz"),
            "param_name" => "font_size",
            "value" => "16",
            "min" => "10",
            "max" => "50",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Title Line Height?", "pacz"),
            "param_name" => "line_height",
            "value" => "16",
            "min" => "10",
            "max" => "50",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Title Margin Bottom?", "pacz"),
            "param_name" => "margin_bottom",
            "value" => "10",
            "min" => "5",
            "max" => "25",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Title Font Weight", "pacz"),
            "param_name" => "font_weight",
            "width" => 150,
            "value" => array(
                esc_html__('Default', "pacz") => "inherit",
                esc_html__('Semi Bold', "pacz") => "600",
                esc_html__('Bold', "pacz") => "bold",
                esc_html__('Bolder', "pacz") => "bolder",
                esc_html__('Normal', "pacz") => "normal",
                esc_html__('Light', "pacz") => "300"
            ),
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "textarea",
            "heading" => esc_html__("Short Description", "pacz"),
            "param_name" => "desc",
            "description" => esc_html__("", "pacz")
        ),


        array(
            "type" => "textfield",
            "heading" => esc_html__("Add Icon Class Name", "pacz"),
            "param_name" => "icon",
            "value" => "pacz-li-smile",
            "description" => esc_html__(" to get the icon class name (or any other font icons library that you have installed in the theme)", "pacz"). wp_kses_post(__("<a target='_blank' href='" . admin_url('tools.php?page=icon-library') . "'>Click here</a>", "pacz")),,
        ),
        array(
            'type' => 'item_id',
            'heading' => esc_html__( 'Item ID', 'pacz' ),
            'param_name' => "tab_id"
        )


    ),
    "js_view" => 'VcColumnView'
));




vc_map(array(
    "name" => esc_html__("Icon Text", "pacz"),
    "base" => "pacz_icon_text",
    "category" => esc_html__('General', 'pacz'),
    'icon' => 'icon-pacz-icon-box vc_pacz_element-icon',
    'description' => esc_html__( 'Powerful & versatile Icon Text.', 'pacz' ),
    "params" => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Skin", "pacz"),
            "param_name" => "skin",
            "width" => 300,
            "value" => array(
                esc_html__('Dark', "pacz") => "dark",
                esc_html__('Light', "pacz") => "light",
                esc_html__('Custom', "pacz") => "custom"
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Custom Color?", "pacz"),
            "param_name" => "custom_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "skin",
                'value' => array(
                    'custom'
                )
            )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Default Text", "pacz"),
            "param_name" => "default_txt",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Default Text Font Weight", "pacz"),
            "param_name" => "default_txt_font_weight",
            "width" => 200,
            "default" => 'bold',
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
            "type" => "range",
            "heading" => esc_html__("Default Text Font Size?", "pacz"),
            "param_name" => "font_size",
            "value" => "30",
            "min" => "15",
            "max" => "100",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("On Hover Text", "pacz"),
            "param_name" => "hover_txt",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "heading" => esc_html__("On Hover Text Font Size", "pacz"),
            "param_name" => "hover_font_size",
            "value" => "16",
            "min" => "15",
            "max" => "30",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            'type' => 'range'
        ),
        array(
            "heading" => esc_html__("On Hover Text Line Height", "pacz"),
            "param_name" => "hover_line_height",
            "value" => "18",
            "min" => "15",
            "max" => "50",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            'type' => 'range'
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("On Hover Text Font Weight", "pacz"),
            "param_name" => "hover_txt_font_weight",
            "width" => 200,
            "default" => 'bold',
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
            "type" => "textfield",
            "heading" => esc_html__("Link (optional)", "pacz"),
            "param_name" => "link",
            "value" => "",
            "description" => esc_html__("Will convert the icon to a link.", "pacz")
        ),
         array(
            "type" => "dropdown",
            "heading" => esc_html__("Link Target", "pacz"),
            "param_name" => "target",
            "width" => 200,
            "value" => $target_arr,
            "description" => esc_html__("", "pacz")
        ),


        array(
            "type" => "textfield",
            "heading" => esc_html__("Add Icon Class Name", "pacz"),
            "param_name" => "icon",
            "value" => "",
            "description" => esc_html__(" to get the icon class name (or any other font icons library that you have installed in the theme)", "pacz"). wp_kses_post(__("<a target='_blank' href='" . admin_url('tools.php?page=icon-library') . "'>Click here</a>", "pacz")),
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Icon Size", "pacz"),
            "param_name" => "icon_size",
            "width" => 300,
            "value" => array(
                esc_html__('48px', "pacz") => "48",
                esc_html__('64px', "pacz") => "64",
                esc_html__('128px', "pacz") => "128"
            ),
            "description" => esc_html__("", "pacz")
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
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "pacz")
        )
    )
));

vc_map(array(
    "name" => esc_html__("Secondary Header", "pacz"),
    "base" => "pacz_header",
    "category" => esc_html__('General', 'pacz'),
    "params" => array(

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Menu Location", "pacz"),
            "param_name" => "menu_location",
            "width" => 150,
            "value" => array(
                esc_html__('Primary Navigation', "pacz") => "primary-menu",
                esc_html__('Second Navigation', "pacz") => "second-menu",
                esc_html__('Third Navigation', "pacz") => "third-menu",
                esc_html__('Fourth Navigation', "pacz") => "fourth-menu",
                esc_html__('Fifth Navigation', "pacz") => "fifth-menu",
                esc_html__('Sixth Navigation', "pacz") => "sixth-menu",
                esc_html__('Seventh Navigation', "pacz") => "seventh-menu"
            ),

            "description" => esc_html__("Please choose which menu location you would like to assign to this header.", "pacz")
        ),
         array(
            "type" => "toggle",
            "heading" => esc_html__("Squeeze Header?", "pacz"),
            "param_name" => "squeeze",
            "value" => "true",
            "description" => esc_html__("If you disable this option header height will be in normal height rather than being in sticky state.", "pacz")
        ),

         array(
            "type" => "toggle",
            "heading" => esc_html__("Header Logo?", "pacz"),
            "param_name" => "show_logo",
            "value" => "true",
            "description" => esc_html__("If you dont want to show logo in secondary header, disable this option.", "pacz")
        ),
         array(
            "type" => "toggle",
            "heading" => esc_html__("Header Search Icon?", "pacz"),
            "param_name" => "show_search",
            "value" => "true",
            "description" => esc_html__("If you dont want to show search icon in secondary header, disable this option.", "pacz")
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Header Cart?", "pacz"),
            "param_name" => "show_cart",
            "value" => "true",
            "description" => esc_html__("If you dont want to show cart section in secondary header, disable this option.", "pacz")
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Header Wpml?", "pacz"),
            "param_name" => "show_wpml",
            "value" => "true",
            "description" => esc_html__("If you dont want to show wpml section in secondary header, disable this option.", "pacz")
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__("Header Border Top?", "pacz"),
            "param_name" => "show_border",
            "value" => "true",
            "description" => esc_html__("If you dont want to show border top in secondary header, disable this option.", "pacz")
        ),
         array(
            "type" => "dropdown",
            "heading" => esc_html__("Header Align", "pacz"),
            "param_name" => "align",
            "value" => array(
                esc_html__('Left', "pacz") => "left",
                esc_html__('Center', "pacz") => "center",
                esc_html__('Right', "pacz") => "right",
            ),

            "description" => esc_html__("", "pacz")
        ),
         array(
            "type" => "dropdown",
            "heading" => esc_html__("Header Wideness", "pacz"),
            "param_name" => "wideness",
            "value" => array(
                esc_html__('Boxed Layout', "pacz") => "boxed",
                esc_html__('Screen Wide Full', "pacz") => "full",
            ),

            "description" => esc_html__("", "pacz")
        ),
          array(
            "heading" => esc_html__("Header Custom Height", "pacz"),
            "param_name" => "custom_header_height",
            "value" => "0",
            "min" => "0",
            "max" => "300",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("If you want to inherit from default value you have for regular menu set the option value to zero. Its recommended to use this option when you disable logo for this header.", "pacz"),
            'type' => 'range'
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Background Color?", "pacz"),
            "param_name" => "background_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "group" => "Styling Settings",
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Link Color?", "pacz"),
            "param_name" => "link_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "group" => "Styling Settings",
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Link Hover Color?", "pacz"),
            "param_name" => "link_hover_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "group" => "Styling Settings",
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Border Top Color?", "pacz"),
            "param_name" => "border_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "group" => "Styling Settings",
        ),
        array(
            "heading" => esc_html__("Main Navigation Top Level Font Size", "pacz"),
            "param_name" => "top_level_item_size",
            "value" => "0",
            "min" => "0",
            "max" => "50",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("If you want to inherit from default value you set it for main header set the value to zero.", "pacz"),
            'type' => 'range',
            "group" => "Styling Settings",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "pacz")
        ),
        

    )
));

*/
vc_map(array(
    "name" => esc_html__("Event Countdown", "pacz"),
    "base" => "pacz_countdown",
    "category" => esc_html__('General', 'pacz'),
    'icon' => 'icon-pacz-event-countdown vc_pacz_element-icon',
    'description' => esc_html__( 'Countdown module for your events.', 'pacz' ),
    "params" => array(
		array(
            "heading" => esc_html__("countdown style", "pacz"),
            "param_name" => "countdown_style",
            "value" => array(
                esc_html__("style 1", "pacz") => '1',
                esc_html__("style 2", "pacz") => '2',
                esc_html__("style 3", "pacz") => '3',
				esc_html__("style 4", "pacz") => '4',
				esc_html__("style 5", "pacz") => '5'
            ),
            "type" => "dropdown"
        ),
		array(
            "heading" => esc_html__("Swith layout left to right", "pacz"),
            "param_name" => "switch",
            "value" => array(
                esc_html__("counter on left", "pacz") => 'left',
                esc_html__("counter on right", "pacz") => 'right',
            ),
            "type" => "dropdown",
			"dependency" => array(
                'element' => "countdown_style",
                'value' => array(
                    '5'
                )
            )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Upcoming Event Date", "pacz"),
            "param_name" => "date",
            "value" => "",
            "description" => esc_html__("Please fill this field with expect date. eg : 12/24/2015 12:00:00 => month/day/year hour:minute:second", "pacz")
        ),

        array(
            "heading" => esc_html__("UTC Timezone", "pacz"),
            "param_name" => "offset",
            "value" => array(
                "-12" => "-12",
                "-11" => "-11",
                "-10" => "-10",
                "-9" => "-9",
                "-8" => "-8",
                "-7" => "-7",
                "-6" => "-6",
                "-5" => "-5",
                "-4" => "-4",
                "-3" => "-3",
                "-2" => "-2",
                "-1" => "-1",
                "0" => "0",
                "+1" => "+1",
                "+2" => "+2",
                "+3" => "+3",
                "+4" => "+4",
                "+5" => "+5",
                "+6" => "+6",
                "+7" => "+7",
                "+8" => "+8",
                "+9" => "+9",
                "+10" => "+10",
                "+12" => "+12"
            ),
            "type" => "dropdown"
        ),


        /*array(
            "heading" => esc_html__("Skin", "pacz"),
            "param_name" => "skin",
            "value" => array(
                esc_html__("Dark", "pacz") => 'dark',
                esc_html__("Light", "pacz") => 'light',
                esc_html__("Accent Color", "pacz") => 'accent',
                esc_html__("Custom", "pacz") => 'custom'
            ),
			"dependency" => array(
                'element' => "countdown_style",
                'value' => array(
					'3'
                )
            ),
            "type" => "dropdown"
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Custom Color?", "pacz"),
            "param_name" => "custom_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "skin",
                'value' => array(
                    'custom'
                )
            )
        ),*/
		array(
            "type" => "range",
            "heading" => esc_html__("border width", "pacz"),
            "param_name" => "border_width",
            "value" => "1",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "countdown_style",
                'value' => array(
                    '2',
					'3'
                )
            )
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("border color", "pacz"),
            "param_name" => "border_color",
            "value" => "1",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "countdown_style",
                'value' => array(
                    '2',
					'3'
                )
            )
        ),
		
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Days bg color Color?", "pacz"),
            "param_name" => "days_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "countdown_style",
                'value' => array(
                    '1'
                )
            )
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Hours bg color Color?", "pacz"),
            "param_name" => "hours_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "countdown_style",
                'value' => array(
                    '1'
                )
            )
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Minutes bg color Color?", "pacz"),
            "param_name" => "minutes_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "countdown_style",
                'value' => array(
                    '1'
                )
            )
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Seconds bg color Color?", "pacz"),
            "param_name" => "seconds_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "countdown_style",
                'value' => array(
                    '1'
                )
            )
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("upcoming event title?", "pacz"),
            "param_name" => "upcoming_event_title",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "countdown_style",
                'value' => array(
                    '1',
					'3'
                )
            )
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("upcoming event discription?", "pacz"),
            "param_name" => "upcoming_event_disc",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "countdown_style",
                'value' => array(
                    '1'
                )
            )
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("upcoming event button url?", "pacz"),
            "param_name" => "upcoming_event_url",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "countdown_style",
                'value' => array(
                    '1',
					'3'
                )
            )
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("upcoming event button text?", "pacz"),
            "param_name" => "upcoming_event_btn_text",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "countdown_style",
                'value' => array(
                    '1',
					'3'
                )
            )
        ),
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
    "name" => esc_html__("Widgetized Sidebar", "pacz"),
    "base" => "pacz_custom_sidebar",
    'icon' => 'icon-pacz-custom-sidebar vc_pacz_element-icon',
    'description' => esc_html__( 'Place Widgetized sidebar', 'pacz' ),
    "category" => esc_html__('Structure', 'pacz'),
    "params" => array(
        array(
          'type' => 'widgetised_sidebars',
          'heading' => esc_html__( 'Sidebar', 'pacz' ),
          'param_name' => 'sidebar',
          'description' => esc_html__( 'Select the widget area to be shown in this sidebar.', 'pacz' )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your CSS file.", "pacz")
        )
    )
));
vc_map(array(
    "name" => esc_html__("Registered Users", "pacz"),
    "base" => "pacz_registered_user",
    'icon' => 'vc_pacz_element-icon',
    'description' => esc_html__( 'Total registered users', 'pacz' ),
    "category" => esc_html__('Structure', 'pacz'),
    "params" => array(
		array(
            "type" => "textfield",
            "heading" => esc_html__("Custom User Count", "pacz"),
            "param_name" => "custom_user_count",
            "value" =>  '',
            "description" => esc_html__("you can set custom user counter, leave empty to show dynamic user count", "pacz")
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("User Count Text below digits", "pacz"),
            "param_name" => "user_count_text",
            "value" => ''
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("User Digit Color", "pacz"),
            "param_name" => "user_count_color",
            "value" => "#444",
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("User text Color", "pacz"),
            "param_name" => "user_count_text_color",
            "value" => "#888",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your CSS file.", "pacz")
        )
    )
));
vc_map(array(
    "name" => esc_html__("Total Ads Counter", "pacz"),
    "base" => "pacz_total_listings",
    'icon' => 'vc_pacz_element-icon',
    'description' => esc_html__( 'Total Listings Counter', 'pacz' ),
    "category" => esc_html__('Structure', 'pacz'),
    "params" => array(
		array(
            "type" => "textfield",
            "heading" => esc_html__("Custom Listing Count", "pacz"),
            "param_name" => "custom_listing_count",
            "value" => '',
            "description" => esc_html__("you can set custom listing counter, leave empty to show dynamic user count", "pacz")
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("Listing Count Text below digits", "pacz"),
            "param_name" => "listing_count_text",
            "value" => ''
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Listing Digit Color", "pacz"),
            "param_name" => "listing_count_color",
            "value" => "#444",
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Listing text Color", "pacz"),
            "param_name" => "listing_count_text_color",
            "value" => "#888",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your CSS file.", "pacz")
        )
    )
));
/*
vc_map(array(
    "name" => esc_html__("Flip Box", "pacz"),
    "base" => "pacz_flipbox",
    'icon' => 'icon-pacz-tab-slider vc_pacz_element-icon',
    "category" => esc_html__('General', 'pacz'),
    'description' => esc_html__( 'Flip based boxes.', 'pacz' ),
    'params' => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Flip Direction", "pacz"),
            "param_name" => "flip_direction",
            "width" => 300,
            "value" => array(
                esc_html__('Horizontal', "pacz") => "horizontal",
                esc_html__('Vertical', "pacz") => "vertical"
            ),
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Front Background Color", "pacz"),
            "param_name" => "front_background_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Back Background Color", "pacz"),
            "param_name" => "back_background_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Front Side Opacity?", "pacz"),
            "param_name" => "front_opacity",
            "value" => "1",
            "min" => "0.1",
            "max" => "1",
            "step" => "0.1",
            "unit" => 'alpha',
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Back Side Opacity?", "pacz"),
            "param_name" => "back_opacity",
            "value" => "1",
            "min" => "0.1",
            "max" => "1",
            "step" => "0.1",
            "unit" => 'alpha',
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Front Aligment", "pacz"),
            "param_name" => "front_align",
            "width" => 200,
            "value" => array(
                esc_html__('Left', "pacz") => "left",
                esc_html__('Center', "pacz") => "center",
                esc_html__('Right', "pacz") => "right"
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Back Aligment", "pacz"),
            "param_name" => "back_align",
            "width" => 200,
            "value" => array(
                esc_html__('Left', "pacz") => "left",
                esc_html__('Center', "pacz") => "center",
                esc_html__('Right', "pacz") => "right"
            ),
            "description" => esc_html__("", "pacz")
        ),

        array(
            "heading" => esc_html__("Minimum Height", "pacz"),
            "param_name" => "min_height",
            "value" => "300",
            "min" => "250",
            "max" => "500",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            'type' => 'range'
        ),
        array(
            "heading" => esc_html__("Max Width", "pacz"),
            "param_name" => "max_width",
            "value" => "500",
            "min" => "250",
            "max" => "1000",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            'type' => 'range'
        ),
        array(
            "heading" => esc_html__("Left / Right Padding", "pacz"),
            "param_name" => "box_padding",
            "value" => "20",
            "min" => "10",
            "max" => "100",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            'type' => 'range'
        ),
        array(
            "type" => "toggle",
            "heading" => esc_html__('Border Radius?', 'pacz'),
            "description" => esc_html__("", "pacz"),
            "param_name" => "box_radius",
            "value" => "false"
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Front Title", "pacz"),
            "param_name" => "front_title",
            "value" => "",
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "heading" => esc_html__("Front Title Font Size", "pacz"),
            "param_name" => "front_title_size",
            "value" => "20",
            "min" => "15",
            "max" => "50",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            'type' => 'range'
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Front Title Font Weight", "pacz"),
            "param_name" => "front_title_font_weight",
            "width" => 200,
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
            "type" => "colorpicker",
            "heading" => esc_html__("Front Title Font Color", "pacz"),
            "param_name" => "front_title_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "textarea",
            "heading" => esc_html__("Front Description", "pacz"),
            "param_name" => "front_desc",
            "value" => "",
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "heading" => esc_html__("Front Description Font Size", "pacz"),
            "param_name" => "front_desc_size",
            "value" => "20",
            "min" => "15",
            "max" => "30",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            'type' => 'range'
        ),
        array(
            "heading" => esc_html__("Front Description Line Height", "pacz"),
            "param_name" => "front_desc_line_height",
            "value" => "26",
            "min" => "15",
            "max" => "50",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            'type' => 'range'
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Front Description Font Color", "pacz"),
            "param_name" => "front_desc_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Back Title", "pacz"),
            "param_name" => "back_title",
            "value" => "",
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "heading" => esc_html__("Back Title Font Size", "pacz"),
            "param_name" => "back_title_size",
            "value" => "20",
            "min" => "15",
            "max" => "50",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            'type' => 'range'
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Back Title Font Color", "pacz"),
            "param_name" => "back_title_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Back Title Font Weight", "pacz"),
            "param_name" => "back_title_font_weight",
            "width" => 200,
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
            "type" => "textarea",
            "heading" => esc_html__("Back Description", "pacz"),
            "param_name" => "back_desc",
            "value" => "",
            "description" => esc_html__("", "pacz"),
        ),
        array(
            "heading" => esc_html__("Back Description Font Size", "pacz"),
            "param_name" => "back_desc_size",
            "value" => "20",
            "min" => "15",
            "max" => "30",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            'type' => 'range'
        ),
        array(
            "heading" => esc_html__("Back Description Line Height", "pacz"),
            "param_name" => "back_desc_line_height",
            "value" => "26",
            "min" => "15",
            "max" => "50",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            'type' => 'range'
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Back Description Font Color", "pacz"),
            "param_name" => "back_desc_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Button Text", "pacz"),
            "param_name" => "button_text",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Button Url", "pacz"),
            "param_name" => "button_url",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "heading" => esc_html__("Button Size", 'pacz'),
            "description" => esc_html__("", 'pacz'),
            "param_name" => "button_size",
            "value" => array(
                esc_html__("Small", 'pacz') => "small",
                esc_html__("Medium", 'pacz') => "medium",
                esc_html__("Large", 'pacz') => "large"
            ),
            "type" => "dropdown"
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Button Corner Style", "pacz"),
            "param_name" => "button_corner_style",
            "value" => array(
                "Pointed" => "pointed",
                "Rounded" => "rounded",
                "Full Rounded" => "full_rounded"
            ),
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button Skin Color", "pacz"),
            "param_name" => "btn_skin_1",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button Hover Color", "pacz"),
            "param_name" => "btn_skin_2",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "heading" => esc_html__("Button Alignment", 'pacz'),
            "description" => esc_html__("", 'pacz'),
            "param_name" => "btn_alignment",
            "value" => array(
                esc_html__("Left", 'pacz') => "left",
                esc_html__("Center", 'pacz') => "center",
                esc_html__("Right", 'pacz') => "right"
            ),
            "type" => "dropdown"
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
*/