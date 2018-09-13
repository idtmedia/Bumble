<?php

vc_map(array(
    "name" => esc_html__("Text block", "pacz"),
    "base" => "vc_column_text",
    "wrapper_class" => "clearfix",
    "category" => esc_html__('Typography', 'pacz'),
    'icon' => 'icon-pacz-text-block vc_pacz_element-icon',
     'description' => esc_html__( 'A block of text with WYSIWYG editor', 'pacz' ),
    "params" => array(

        array(
            "type" => "textarea_html",
            "holder" => "div",
            "heading" => esc_html__("Text", "pacz"),
            "param_name" => "content",
            "value" => esc_html__("", "pacz"),
            "description" => esc_html__("Enter your content.", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Tablet & Mobile Align.", "pacz"),
            "param_name" => "responsive_align",
            "value" => array(
                esc_html__('Center', "pacz") => "center",
                esc_html__('Left', "pacz") => "left",
                esc_html__('Right', "pacz") => "right",
            ),
            "description" => esc_html__("In some cases your text align for text may not look good in tablet and mobile devices. you can control align for tablet portrait and all mobile devices using this option. It will be center align by default!", "pacz")
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
    "name" => esc_html__("Fancy Title", "pacz"),
    "base" => "pacz_fancy_title",
    'icon' => 'icon-pacz-fancy-title vc_pacz_element-icon',
    "category" => esc_html__('Typography', 'pacz'),
    'description' => esc_html__( 'Advanced headings with cool styles.', 'pacz' ),
    "params" => array(

        array(
            "type" => "textarea_html",
            "holder" => "div",
            "heading" => esc_html__("Content.", "pacz"),
            "param_name" => "content",
            "value" => esc_html__("", "pacz"),
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("Prefix Text", "pacz"),
            "param_name" => "prefix_text",
            "value" => esc_html__("", "pacz"),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", "pacz"),
            "param_name" => "style",
            "value" => array(
                "Simple Title" => "simple",
				"Stroke" => "stroke",
                "WIth Background" => "with_bg",
                "Standard" => "standard",
                "Avantgarde" => "avantgarde",
                "Alternative" => "alt",
                "Underline" => "underline"
            ),
            "description" => esc_html__("Please note that Alternative style will work only in page content and page sections with solid backgrounds.", "pacz")
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Padding Top And Bottom", "pacz"),
            "param_name" => "padding_top_bottom",
            "value" => "",
            "min" => "0",
            "max" => "100",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("Title padding", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'with_bg'
                )
            ),
        ),
		array(
            "type" => "range",
            "heading" => esc_html__("Padding Left and Right", "pacz"),
            "param_name" => "padding_left_right",
            "value" => "",
            "min" => "0",
            "max" => "100",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("Title padding", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'with_bg'
                )
            ),
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("Title Background", "pacz"),
            "param_name" => "bg_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'with_bg'
                )
            ),
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
                    'stroke'
                )
            )
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Tag Name", "pacz"),
            "param_name" => "tag_name",
            "value" => array(
                "h3" => "h3",
                "h2" => "h2",
                "h4" => "h4",
                "h5" => "h5",
                "h6" => "h6",
                "h1" => "h1"
            ),
            "description" => esc_html__("For SEO reasons you might need to define your titles tag names according to priority. Please note that H1 can only be used once in a page due to the SEO reasons. So try to use lower than H2 to meet SEO best practices.", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Stroke Style Border Width", "pacz"),
            "param_name" => "border_width",
            "value" => "3",
            "min" => "1",
            "max" => "5",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("Changes border thickness. Please note that this option only works for Stroke style.", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'stroke',
                    'standard',
                    'avantgarde',
                    'alt',
                    'underline'
                )
            ),
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Stroke Style Border Color", "pacz"),
            "param_name" => "border_color",
            "value" => "",
            "description" => esc_html__("If left blank given text color will be applied to border color. Please note that this option only works for Stroke style.", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'stroke'
                )
            ),
        ),
		array(
            "type" => "dropdown",
            "heading" => esc_html__("display.", "pacz"),
            "param_name" => "display",
            "value" => array(
                esc_html__('block', "pacz") => "block",
                esc_html__('inline block', "pacz") => "inline-block",
                esc_html__('inline', "pacz") => "inline",
				esc_html__('table cell', "pacz") => "table-cell",
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Font Size", "pacz"),
            "param_name" => "size",
            "value" => "14",
            "min" => "12",
            "max" => "100",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Text Line Height", "pacz"),
            "param_name" => "line_height",
            "value" => "24",
            "min" => "12",
            "max" => "100",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("Please note that this value should be more than font size. if less than font size line height value will be 100% to prevent reading issues.", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Text Color", "pacz"),
            "param_name" => "color",
            "value" => "#393836",
            "description" => esc_html__("", "pacz")
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
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Text Transform", "pacz"),
            "param_name" => "text_transform",
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
            "type" => "range",
            "heading" => esc_html__("Letter Spacing", "pacz"),
            "param_name" => "letter_spacing",
            "value" => "0",
            "min" => "0",
            "max" => "10",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("Space between each character.", "pacz")
        ),


        array(
            "type" => "theme_fonts",
            "heading" => esc_html__("Font Family", "pacz"),
            "param_name" => "font_family",
            "value" => "",
            "description" => esc_html__("You can choose a font for this shortcode, however using non-safe fonts can affect page load and performance.", "pacz")
        ),
        array(
            "type" => "hidden_input",
            "param_name" => "font_type",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Margin Top", "pacz"),
            "param_name" => "margin_top",
            "value" => "10",
            "min" => "0",
            "max" => "500",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Margin Bottom", "pacz"),
            "param_name" => "margin_bottom",
            "value" => "10",
            "min" => "0",
            "max" => "500",
            "step" => "1",
            "unit" => 'px',
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
            "type" => "dropdown",
            "heading" => esc_html__("Tablet & Mobile Align.", "pacz"),
            "param_name" => "responsive_align",
            "value" => array(
                esc_html__('Center', "pacz") => "center",
                esc_html__('Left', "pacz") => "left",
                esc_html__('Right', "pacz") => "right",
            ),
            "description" => esc_html__("In some cases your text align for text may not look good in tablet and mobile devices. you can control align for tablet portrait and all mobile devices using this option. It will be center align by default!", "pacz")
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
    "name" => esc_html__("Custom heading", "pacz"),
    "base" => "pacz_custom_heading",
    'icon' => 'icon-pacz-message-box vc_pacz_element-icon',
    "category" => esc_html__('Typography', 'pacz'),
    'description' => esc_html__( 'custom heading Box with multiple types.', 'pacz' ),
    "params" => array(
		array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", "pacz"),
            "param_name" => "style",
            "value" => array(
                esc_html__('Style1', "pacz") => "1",
                esc_html__('Style2', "pacz") => "2",
                esc_html__('style3', "pacz") => "3",
				esc_html__('style4', "pacz") => "4",
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Insert your heading part1 here", "pacz"),
            "param_name" => "custom_heading_text1",
            "value" => '',
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("Insert your heading part2 here", "pacz"),
            "param_name" => "custom_heading_text2",
            "value" => '',
            "description" => esc_html__("", "pacz")
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("Insert your heading part3 here", "pacz"),
            "param_name" => "custom_heading_text3",
            "value" => '',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "textarea",
            "heading" => esc_html__("Small text below heading", "pacz"),
            "param_name" => "custom_text_below_title",
            "value" => '',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("heading custom color", "pacz"),
            "param_name" => "custom_heading_color",
            "value" => '',
            "description" => esc_html__("custom heading color will effect heading field 1 and 3 leave blank for default color", "pacz")
        ),
		array(
            "type" => "colorpicker",
            "heading" => esc_html__("heading custom color", "pacz"),
            "param_name" => "custom_text_color",
            "value" => '',
            "description" => esc_html__("custom heading color will effect text bellow heading leave blank for default color", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz")
        ),

    )
));


vc_map(array(
    "name" => esc_html__("Fancy Text", "pacz"),
    "base" => "pacz_fancy_text",
    "category" => esc_html__('Typography', 'pacz'),
    'icon' => 'icon-pacz-title-box vc_pacz_element-icon',
    'description' => esc_html__( 'Adds title text into a highlight box.', 'pacz' ),
    "params" => array(

        array(
            "type" => "textarea_html",
            "rows" => 2,
            "holder" => "div",
            "heading" => esc_html__("Content.", "pacz"),
            "param_name" => "content",
            "value" => esc_html__("", "pacz"),
            "description" => esc_html__("Allowed Tags [em] [del] [i] [b] [strong] [u] [span] [small] [large] [sub] [sup]. Please note that [p] tags will be striped out.", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Text Color", "pacz"),
            "param_name" => "color",
            "value" => "#393836",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Hightlight Background Color", "pacz"),
            "param_name" => "highlight_color",
            "value" => "#000",
            "description" => esc_html__("The Hightlight Background color. you can change color opacity from below option.", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Hightlight Color Opacity", "pacz"),
            "param_name" => "highlight_opacity",
            "value" => "0.3",
            "min" => "0",
            "max" => "1",
            "step" => "0.01",
            "unit" => 'px',
            "description" => esc_html__("The Opacity of the hightlight background", "pacz")
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("Font Size", "pacz"),
            "param_name" => "size",
            "value" => "18",
            "min" => "12",
            "max" => "70",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Line Height (Important)", "pacz"),
            "param_name" => "line_height",
            "value" => "34",
            "min" => "12",
            "max" => "500",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("Since every font family with differnt sizes need different line heights to get a nice looking highlighted titles you should set them manually. as a hint generally (font-size * 2) - 2 works in many cases, but you may need to give more space in between, so we opened your hands with this option. :) ", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Font Weight", "pacz"),
            "param_name" => "font_weight",
            "width" => 150,
            "value" => array(
                esc_html__('Default', "pacz") => "inherit",
                esc_html__('Medium', "pacz") => "500",
                esc_html__('Semi Bold', "pacz") => "600",
                esc_html__('Bold', "pacz") => "bold",
                esc_html__('Bolder', "pacz") => "bolder",
                esc_html__('Normal', "pacz") => "normal",
                esc_html__('Light', "pacz") => "300"
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Margin Top", "pacz"),
            "param_name" => "margin_top",
            "value" => "0",
            "min" => "-40",
            "max" => "500",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("In some ocasions you may on need to define a top margin for this title.", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Margin Buttom", "pacz"),
            "param_name" => "margin_bottom",
            "value" => "18",
            "min" => "0",
            "max" => "500",
            "step" => "1",
            "unit" => 'px',
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
            "type" => "hidden_input",
            "param_name" => "font_type",
            "value" => "",
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
                esc_html__('Center', "pacz") => "center",
                esc_html__('Justify', "pacz") => "justify"
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
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz")
        )

    )
));

/*
vc_map(array(
    "name" => esc_html__("Blockquote", "pacz"),
    "base" => "pacz_blockquote",
    "category" => esc_html__('Typography', 'pacz'),
    'icon' => 'icon-pacz-blockquote vc_pacz_element-icon',
    'description' => esc_html__( 'Blockquote modules', 'pacz' ),
    "params" => array(


        array(
            "type" => "textarea_html",
            "holder" => "div",
            "heading" => esc_html__("Blockquote Message", "pacz"),
            "param_name" => "content",
            "value" => esc_html__("", "pacz"),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", "pacz"),
            "param_name" => "style",
            "width" => 150,
            "value" => array(
                esc_html__('Classic', "pacz") => "classic",
                esc_html__('Modern', "pacz") => "modern"
            ),
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
    "name" => esc_html__("Dropcaps", "pacz"),
    "base" => "pacz_dropcaps",
    'icon' => 'icon-pacz-dropcaps vc_pacz_element-icon',
    "category" => esc_html__('Typography', 'pacz'),
    'description' => esc_html__( 'Dropcaps element shortcode.', 'pacz' ),
    "params" => array(

        array(
            "type" => "textfield",
            "heading" => esc_html__("Dropcaps Character", "pacz"),
            "param_name" => "char",
            "value" => esc_html__("", "pacz"),
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", "pacz"),
            "param_name" => "style",
            "width" => 150,
            "value" => array(
                esc_html__('Square Default Color', "pacz") => "square-default",
                esc_html__('Circle default Color', "pacz") => "circle-default",
                esc_html__('Square Custom Color', "pacz") => "square-custom",
                esc_html__('Circle Custom Color', "pacz") => "circle-custom"
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Fill Color", "pacz"),
            "param_name" => "fill_color",
            "value" => $skin_color,
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'square-custom',
                    'circle-custom'
                )
            )
        ),
        array(
            "type" => "textarea_html",
            "holder" => "div",
            "heading" => esc_html__("Paragraph", "pacz"),
            "param_name" => "content",
            "value" => esc_html__("", "pacz"),
            "description" => esc_html__("Enter your content.", "pacz")
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
    "name" => esc_html__("Gradient Text", "pacz"),
    "base" => "pacz_gradient_text",
    'icon' => '',
    "category" => esc_html__('Typography', 'pacz'),
    'description' => esc_html__( '', 'pacz' ),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Gradient Text", "pacz"),
            "param_name" => "text",
            "value" => esc_html__("", "pacz"),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Align.", "pacz"),
            "param_name" => "text_align",
            "value" => array(
                esc_html__('Left', "pacz") => "left",
                esc_html__('Center', "pacz") => "center",
                esc_html__('Right', "pacz") => "right",
            ),
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
            "type" => "hidden_input",
            "param_name" => "font_type",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Font Size", "pacz"),
            "param_name" => "font_size",
            "value" => "14",
            "min" => "12",
            "max" => "100",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz")
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
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Gradient Style Orientation", "pacz"),
            "param_name" => "gradient_style",
            "width" => 150,
            "value" => array(
                esc_html__('Vertical ', "pacz") => "vertical",
                esc_html__('Horizontal →', "pacz") => "horizontal",
                esc_html__('Radial ○', "pacz") => "radial",
            ),
            "description" => esc_html__("Choose the orientation of gradient style", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Start Color", "pacz"),
            "param_name" => "start_color",
            "value" => $skin_color,
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("End Color", "pacz"),
            "param_name" => "end_color",
            "value" => $skin_color,
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

vc_map(array(
    "name" => esc_html__("Highlight Text", "pacz"),
    "base" => "pacz_highlight",
    'icon' => 'icon-pacz-highlight vc_pacz_element-icon',
    "category" => esc_html__('Typography', 'pacz'),
    'description' => esc_html__( 'adds highlight to an inline text.', 'pacz' ),
    "params" => array(

        array(
            "type" => "textfield",
            "heading" => esc_html__("Highlight Text", "pacz"),
            "param_name" => "text",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", "pacz"),
            "param_name" => "style",
            "width" => 150,
            "value" => array(
                esc_html__('Default Color', "pacz") => "default",
                esc_html__('Custom Color', "pacz") => "custom"
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Fill Color", "pacz"),
            "param_name" => "fill_color",
            "value" => $skin_color,
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
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
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz")
        )

    )
));


vc_map(array(
    "name" => esc_html__("Custom List", "pacz"),
    "base" => "pacz_custom_list",
    "category" => esc_html__('Typography', 'pacz'),
    'icon' => 'icon-pacz-custom-list vc_pacz_element-icon',
    'description' => esc_html__( 'Powerful list styles with icons.', 'pacz' ),
    "params" => array(
        array(
            "type" => "textarea_html",
            "holder" => "div",
            "heading" => esc_html__("Add your unordered list into this textarea. Allowed Tags : [ul][li][strong][i][em][u][b][a][small]", "pacz"),
            "param_name" => "content",
            "value" => "<ul><li>List Item</li><li>List Item</li><li>List Item</li><li>List Item</li><li>List Item</li></ul>",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Add Icon Character Code", "pacz"),
            "param_name" => "style",
            "value" => "",
             "description" => esc_html__(" to get the icon class name (or any other font icons library that you have installed in the theme)", "pacz"). wp_kses_post(__("<a target='_blank' href='" . admin_url('tools.php?page=icon-library') . "'>Click here</a>", "pacz")),
        ),


        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Icons Color", "pacz"),
            "param_name" => "icon_color",
            "value" => $skin_color,
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("Margin Bottom", "pacz"),
            "param_name" => "margin_bottom",
            "value" => "30",
            "min" => "-30",
            "max" => "500",
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
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "pacz")
        )

    )
));


vc_map(array(
    "name" => esc_html__("Font icons", "pacz"),
    "base" => "pacz_font_icons",
    'icon' => 'icon-pacz-font-icon vc_pacz_element-icon',
    "category" => esc_html__('Typography', 'pacz'),
    'description' => esc_html__( 'Advanced font icon element', 'pacz' ),
    "params" => array(

        array(
            "type" => "textfield",
            "heading" => esc_html__("Add Icon Class Name", "pacz"),
            "param_name" => "icon",
            "value" => "",
             "description" => esc_html__(" to get the icon class name (or any other font icons library that you have installed in the theme)", "pacz"). wp_kses_post(__("<a target='_blank' href='" . admin_url('tools.php?page=icon-library') . "'>Click here</a>", "pacz")),
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", "pacz"),
            "param_name" => "style",
            "value" => array(
                "default" => "default",
                "Filled" => "filled",
                "Generic (customise yourself)" => "custom"
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Icon Color", "pacz"),
            "param_name" => "color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'custom',
                    'filled'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Background Color", "pacz"),
            "param_name" => "bg_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'custom'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Frame Border Color", "pacz"),
            "param_name" => "border_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'custom'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Icon Hover Color", "pacz"),
            "param_name" => "hover_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'custom'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Background Hover Color", "pacz"),
            "param_name" => "bg_hover_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'custom'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Frame Border Hover Color", "pacz"),
            "param_name" => "border_hover_color",
            "value" => "",
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'custom'
                )
            )
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Icon Size", "pacz"),
            "param_name" => "size",
            "value" => array(
                "16px" => "small",
                "32px" => "medium",
                "48px" => "large",
                "64px" => "x-large",
                "128px" => "xx-large",
                "256px" => "xxx-large"
            ),
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "toggle",
            "heading" => esc_html__("Remove Frame from icon?", "pacz"),
            "param_name" => "remove_frame",
            "value" => "false",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("Frame Border Width", "pacz"),
            "param_name" => "border_width",
            "value" => "2",
            "min" => "1",
            "max" => "20",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'custom',
                    'default'
                )
            )
        ),

        array(
            "type" => "range",
            "heading" => esc_html__("Horizontal Padding", "pacz"),
            "param_name" => "padding_horizental",
            "value" => "4",
            "min" => "0",
            "max" => "200",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("You can give padding to the icon. this padding will be applied to left and right side of the icon", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Vertical Padding", "pacz"),
            "param_name" => "padding_vertical",
            "value" => "4",
            "min" => "0",
            "max" => "200",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("You can give padding to the icon. this padding will be applied to top and bottom of them icon", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Icon Align", "pacz"),
            "param_name" => "align",
            "width" => 150,
            "value" => array(
                esc_html__('No Align', "pacz") => "none",
                esc_html__('Left', "pacz") => "left",
                esc_html__('Right', "pacz") => "right",
                esc_html__('Center', "pacz") => "center"
            ),
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Link", "pacz"),
            "param_name" => "link",
            "value" => "",
            "description" => esc_html__("You can optionally link your icon. please provide full URL including http://", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Infinite Animations", "pacz"),
            "param_name" => "infinite_animation",
            "value" => $infinite_animation,
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

vc_map(array(
    "name" => esc_html__("Toggle", "pacz"),
    "base" => "pacz_toggle",
    "wrapper_class" => "clearfix",
    'icon' => 'icon-pacz-toggle vc_pacz_element-icon',
    "category" => esc_html__('Typography', 'pacz'),
    'description' => esc_html__( 'Expandable toggle element', 'pacz' ),
    "params" => array(

        array(
            "type" => "textfield",
            "heading" => esc_html__("Toggle Title", "pacz"),
            "param_name" => "title",
            "value" => ""
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Add Icon Class Name (Icon For title)", "pacz"),
            "param_name" => "icon",
            "value" => "",
             "description" => esc_html__(" to get the icon class name (or any other font icons library that you have installed in the theme)", "pacz"). wp_kses_post(__("<a target='_blank' href='" . admin_url('tools.php?page=icon-library') . "'>Click here</a>", "pacz")),
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Custom Icon Color", "pacz"),
            "param_name" => "icon_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "textarea_html",
            "holder" => "div",
            "heading" => esc_html__("Toggle Content.", "pacz"),
            "param_name" => "content",
            "value" => esc_html__("", "pacz")
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Pane Background Color", "pacz"),
            "param_name" => "pane_bg",
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


$tab_id_1 = time() . '-1-' . rand(0, 100);
$tab_id_2 = time() . '-2-' . rand(0, 100);
vc_map(array(
    "name" => esc_html__("Tabs", "pacz"),
    "base" => "vc_tabs",
    "show_settings_on_create" => false,
    "is_container" => true,
    'icon' => 'icon-pacz-tabs vc_pacz_element-icon',
    "category" => esc_html__('Content', 'pacz'),
    'description' => esc_html__( 'Tabbed content', 'pacz' ),
    "params" => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", "pacz"),
            "param_name" => "style",
            "value" => array(
                "Style 1" => "style1",
                "Style 2" => "style2",
                "Style 3" => "style3",
            ),
            "description" => esc_html__("Choose your tabs style.", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Orientation", "pacz"),
            "param_name" => "orientation",
            "value" => array(
                "Horizontal" => "horizontal",
                "Vertical" => "vertical"

            ),
             "dependency" => array(
                'element' => "style",
                'value' => array(
                    'style1',
                    'style2'
                )
            ),
            "description" => esc_html__("Choose tabs orientation. Please note that this option will only work for style 1 and 2.", "pacz")
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Container Background Color", "pacz"),
            "param_name" => "container_bg_color",
            "value" => "#fafafa",
            "description" => esc_html__("", "pacz")
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "pacz")
        )
    ),
    "custom_markup" => '
  <div class="wpb_tabs_holder wpb_holder vc_container_for_children">
  <ul class="tabs_controls">
  </ul>
  %content%
  </div>',
    'default_content' => '
  [vc_tab title="' . esc_html__('Tab 1', 'pacz') . '" tab_id="' . $tab_id_1 . '"][/vc_tab]
  [vc_tab title="' . esc_html__('Tab 2', 'pacz') . '" tab_id="' . $tab_id_2 . '"][/vc_tab]
  ',
    "js_view" => ('VcTabsView')
));



vc_map(array(
    "name" => esc_html__("Tab", "pacz"),
    "base" => "vc_tab",
    "allowed_container_element" => 'vc_row',
    "is_container" => true,
    "content_element" => false,
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Title", "pacz"),
            "param_name" => "title",
            "description" => esc_html__("Tab title.", "pacz")
        ),


        array(
            "type" => "textfield",
            "heading" => esc_html__("Add Icon Class Name", "pacz"),
            "param_name" => "icon",
            "value" => "",
             "description" => esc_html__(" to get the icon class name (or any other font icons library that you have installed in the theme)", "pacz"). wp_kses_post(__("<a target='_blank' href='" . admin_url('tools.php?page=icon-library') . "'>Click here</a>", "pacz")),
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Custom Icon Color", "pacz"),
            "param_name" => "icon_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        )

    ),
    'js_view' => ('VcTabView')
));


vc_map(array(
    "name" => esc_html__("Accordion", "pacz"),
    "base" => "vc_accordions",
    "show_settings_on_create" => false,
    "is_container" => true,
    'icon' => 'icon-pacz-accordion vc_pacz_element-icon',
    'description' => esc_html__( 'Collapsible content panels', 'pacz' ),
    "category" => esc_html__('Content', 'pacz'),
    "params" => array(
        array(
                "type" => "dropdown",
                "heading" => esc_html__( "Style", "pacz" ),
                "param_name" => "style",
                "width" => 150,
                "value" => array(  esc_html__( 'Simple', "pacz" ) => "simple" , esc_html__( 'Boxed', "pacz" ) => "boxed"),
                "description" => esc_html__( "", "pacz" )
            ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Container Background Color", "pacz"),
            "param_name" => "container_bg_color",
            "value" => "#fafafa",
            "description" => esc_html__("", "pacz")
        ),


        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "pacz"),
            "param_name" => "el_class",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "pacz")
        )
    ),
    "custom_markup" => '
  <div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
  %content%
  </div>
  <div class="tab_controls">
  <a class="add_tab" title="' . esc_html__( 'Add section', 'pacz' ) . '"><span class="vc_icon"></span> <span class="tab-label">' . esc_html__( 'Add section', 'pacz' ) . '</span></a>
  </div>
  ',
    'default_content' => '
  [vc_accordion_tab title="' . esc_html__('Section 1', "pacz") . '"][/vc_accordion_tab]
  [vc_accordion_tab title="' . esc_html__('Section 2', "pacz") . '"][/vc_accordion_tab]
  ',
    'js_view' => 'VcAccordionView'
));
vc_map(array(
    "name" => esc_html__("Accordion Section", "pacz"),
    "base" => "vc_accordion_tab",
    "allowed_container_element" => 'vc_row',
    "is_container" => true,
    "content_element" => false,
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Title", "pacz"),
            "param_name" => "title",
            "description" => esc_html__("Accordion section title.", "pacz")
        ),


        array(
            "type" => "textfield",
            "heading" => esc_html__("Add Icon Class Name (optional)", "pacz"),
            "param_name" => "icon",
            "value" => "",
             "description" => esc_html__(" to get the icon class name (or any other font icons library that you have installed in the theme)", "pacz"). wp_kses_post(__("<a target='_blank' href='" . admin_url('tools.php?page=icon-library') . "'>Click here</a>", "pacz")),
        ),

        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Custom Icon Color", "pacz"),
            "param_name" => "icon_color",
            "value" => "",
            "description" => esc_html__("", "pacz")
        )
    ),
    'js_view' => 'VcAccordionTabView'
));
*/
