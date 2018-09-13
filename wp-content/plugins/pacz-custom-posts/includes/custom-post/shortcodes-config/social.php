<?php

vc_map(array(
    "name" => esc_html__("Social Networks", "pacz"),
    "base" => "pacz_social_networks",
    'icon' => 'icon-pacz-social-networks vc_pacz_element-icon',
    'description' => esc_html__( 'Adds social network icons.', 'pacz' ),
    "category" => esc_html__('Social', 'pacz'),
    "params" => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", "pacz"),
            "param_name" => "style",
            "value" => array(
                "Square" => "square",
                "Circle" => "circle",
                "Simple" => "simple"
            )
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Skin", "pacz"),
            "param_name" => "skin",
            "value" => array(
                "Dark" => "dark",
                "Light" => "light",
                "Custom" => "custom",
            )
        ),


        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Border Color", "pacz"),
            "param_name" => "border_color",
            "value" => "#ccc",
            "description" => esc_html__("(default: #ccc). Doesn't work with Simple Style", "pacz"),
            "dependency" => array(
                'element' => "skin",
                'value' => array(
                    'custom'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Background Color", "pacz"),
            "param_name" => "bg_color",
            "value" => "",
            "description" => esc_html__("(default: transparent). Doesn't work with Simple Style", "pacz"),
            "dependency" => array(
                'element' => "skin",
                'value' => array(
                    'custom'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Background Hover Color", "pacz"),
            "param_name" => "bg_hover_color",
            "value" => "#232323",
            "description" => esc_html__("(default: #232323). Doesn't work with Simple Style", "pacz"),
            "dependency" => array(
                'element' => "skin",
                'value' => array(
                    'custom'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Icons Color", "pacz"),
            "param_name" => "icon_color",
            "value" => "#ccc",
            "description" => esc_html__("(default: #ccc)", "pacz"),
            "dependency" => array(
                'element' => "skin",
                'value' => array(
                    'custom'
                )
            )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Icons Hover Color", "pacz"),
            "param_name" => "icon_hover_color",
            "value" => "#eee",
            "description" => esc_html__("(default: #eee)", "pacz"),
            "dependency" => array(
                'element' => "skin",
                'value' => array(
                    'custom'
                )
            )
        ),


        array(
            "type" => "range",
            "heading" => esc_html__("Margin", "pacz"),
            "param_name" => "margin",
            "value" => "4",
            "min" => "0",
            "max" => "50",
            "step" => "1",
            "unit" => 'px',
            "description" => esc_html__("How much distance between icons? this margin will be applied to all directions.", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Icons Align", "pacz"),
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
            "heading" => esc_html__("Facebook URL", "pacz"),
            "param_name" => "facebook",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Twitter URL", "pacz"),
            "param_name" => "twitter",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("RSS URL", "pacz"),
            "param_name" => "rss",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Instagram URL", "pacz"),
            "param_name" => "instagram",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Dribbble URL", "pacz"),
            "param_name" => "dribbble",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),
         array(
            "type" => "textfield",
            "heading" => esc_html__("Vimeo URL", "pacz"),
            "param_name" => "vimeo",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),
         array(
            "type" => "textfield",
            "heading" => esc_html__("Spotify URL", "pacz"),
            "param_name" => "spotify",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Pinterest URL", "pacz"),
            "param_name" => "pinterest",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Google Plus URL", "pacz"),
            "param_name" => "google_plus",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Linkedin URL", "pacz"),
            "param_name" => "linkedin",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Youtube URL", "pacz"),
            "param_name" => "youtube",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Tumblr URL", "pacz"),
            "param_name" => "tumblr",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),



        array(
            "type" => "textfield",
            "heading" => esc_html__("Behance URL", "pacz"),
            "param_name" => "behance",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("WhatsApp URL", "pacz"),
            "param_name" => "whatsapp",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("qzone URL", "pacz"),
            "param_name" => "qzone",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("vk.com URL", "pacz"),
            "param_name" => "vkcom",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("IMDb URL", "pacz"),
            "param_name" => "imdb",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Renren URL", "pacz"),
            "param_name" => "renren",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Wechat URL", "pacz"),
            "param_name" => "wechat",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Weibo URL", "pacz"),
            "param_name" => "weibo",
            "value" => "",
            "description" => esc_html__("Fill this textbox with the full URL of your corresponding social netowork. include http:// if left blank this social network icon wont be shown.", "pacz")
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
    "name" => esc_html__("Twitter Feeds", "pacz"),
    "base" => "vc_twitter",
    'icon' => 'icon-pacz-twitter-feeds vc_pacz_element-icon',
    'description' => esc_html__( 'Adds Twitter Feeds.', 'pacz' ),
    "category" => esc_html__('Social', 'pacz'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Twitter name", "pacz"),
            "param_name" => "twitter_name",
            "value" => "",
            "description" => esc_html__("Type in twitter profile name from which load tweets.", "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Tweets count", "pacz"),
            "param_name" => "tweets_count",
            "value" => "5",
            "min" => "1",
            "max" => "30",
            "step" => "1",
            "unit" => 'tweets',
            "description" => esc_html__("How many recent tweets to load.", "pacz")
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__("Add Icon Class Name", "pacz"),
            "param_name" => "twitter_icon",
            "value" => "",
            "description" => esc_html__(" to get the icon class name (or any other font icons library that you have installed in the theme)", "pacz"). wp_kses_post(__("<a target='_blank' href='" . admin_url('tools.php?page=icon-library') . "'>Click here</a>", "pacz")),
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
    "name" => esc_html__("Video player", "pacz"),
    "base" => "vc_video",
    'icon' => 'icon-pacz-video-player vc_pacz_element-icon',
    'description' => esc_html__( 'Youtube, Vimeo,..', 'pacz' ),
    "category" => esc_html__('Social', 'pacz'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Widget Title", "pacz"),
            "param_name" => "title",
            "value" => "",
            "description" => esc_html__("", "pacz")
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Video link", "pacz"),
            "param_name" => "link",
            "value" => "",
			 "description" => esc_html__(" Link to the video. More about supported formats at", "pacz"). __(' <a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">WordPress codex page</a>', "pacz"),
           
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
    "name" => esc_html__("Google Maps", "pacz"),
    "base" => "pacz_gmaps",
    "category" => esc_html__('Social', 'pacz'),
    'icon' => 'icon-pacz-advanced-google-maps vc_pacz_element-icon',
    'description' => esc_html__( 'Powerful Google Maps element.', 'pacz' ),
    "params" => array(
         array(
               "type" => "textfield",
               "heading" => esc_html__("Address : Latitude", "pacz"),
               "param_name" => "latitude",
               "value" => "31.5497",
               "description" => esc_html__('', "pacz")
          ),
          array(
               "type" => "textfield",
               "heading" => esc_html__("Address : Longitude", "pacz"),
               "param_name" => "longitude",
               "value" => "74.3436",
               "description" => esc_html__('', "pacz")
          ),
          array(
               "type" => "textfield",
               "heading" => esc_html__("Address : Full Address Text (shown in tooltip)", "pacz"),
               "param_name" => "address",
               "value" => "Lahore",
               "description" => esc_html__('', "pacz")
          ),

          /*array(
               "type" => "textfield",
               "heading" => esc_html__("Address 2 : Latitude", "pacz"),
               "param_name" => "latitude_2",
               "value" => "",
               "description" => esc_html__('', "pacz")
          ),
          array(
               "type" => "textfield",
               "heading" => esc_html__("Address 2 : Longitude", "pacz"),
               "param_name" => "longitude_2",
               "value" => "",
               "description" => esc_html__('', "pacz")
          ),
          array(
               "type" => "textfield",
               "heading" => esc_html__("Address 2 : Full Address Text (shown in tooltip)", "pacz"),
               "param_name" => "address_2",
               "value" => "",
               "description" => esc_html__('', "pacz")
          ),



          array(
               "type" => "textfield",
               "heading" => esc_html__("Address 3 : Latitude", "pacz"),
               "param_name" => "latitude_3",
               "value" => "",
               "description" => esc_html__('', "pacz")
          ),
          array(
               "type" => "textfield",
               "heading" => esc_html__("Address 3 : Longitude", "pacz"),
               "param_name" => "longitude_3",
               "value" => "",
               "description" => esc_html__('', "pacz")
          ),
          array(
               "type" => "textfield",
               "heading" => esc_html__("Address 3 : Full Address Text (shown in tooltip)", "pacz"),
               "param_name" => "address_3",
               "value" => "",
               "description" => esc_html__('', "pacz")
          ),*/



          array(
               "type" => "upload",
               "heading" => esc_html__("Upload Marker Icon", "pacz"),
               "param_name" => "pin_icon",
               "value" =>  plugin_dir_path( __FILE__ ). '/img/marker.png',
               "description" => esc_html__("If left blank Google Default marker will be used.", "pacz")
          ),
          array(
               "type" => "range",
               "heading" => esc_html__("Map height", "pacz"),
               "param_name" => "height",
               "value" => "500",
               "min" => "1",
               "max" => "1000",
               "step" => "1",
               "unit" => 'px',
               "description" => esc_html__('Enter map height in pixels. Example: 200).', "pacz")
          ),

          /*array(
               "type" => "toggle",
               "heading" => esc_html__("Full Height?", "pacz"),
               "param_name" => "full_height",
               "value" => "false",
               "description" => esc_html__("", "pacz")
          ),*/

         /* array(
               "type" => "toggle",
               "heading" => esc_html__("Parallax Effect?", "pacz"),
               "param_name" => "parallax",
               "value" => "false",
               "description" => esc_html__("If you dont want to have parallax effect in this shortcode disable this option.", "pacz")
          ),*/
          array(
               "type" => "range",
               "heading" => esc_html__("Zoom", "pacz"),
               "param_name" => "zoom",
               "value" => "14",
               "min" => "1",
               "max" => "19",
               "step" => "1",
               "unit" => '',
               "description" => esc_html__('', "pacz")
          ),
          array(
               "type" => "toggle",
               "heading" => esc_html__("Pan Control", "pacz"),
               "param_name" => "pan_control",
               "value" => "true",
               "description" => esc_html__("", "pacz")
          ),
          array(
               "type" => "toggle",
               "heading" => esc_html__("Draggable", "pacz"),
               "param_name" => "draggable",
               "value" => "true",
               "description" => esc_html__("", "pacz")
          ),
          array(
               "type" => "toggle",
               "heading" => esc_html__("Zoom Control", "pacz"),
               "param_name" => "zoom_control",
               "value" => "true",
               "description" => esc_html__("", "pacz")
          ),
          array(
               "type" => "toggle",
               "heading" => esc_html__("Map Type Control", "pacz"),
               "param_name" => "map_type_control",
               "value" => "true",
               "description" => esc_html__("", "pacz")
          ),
          array(
               "type" => "toggle",
               "heading" => esc_html__("Scale Control", "pacz"),
               "param_name" => "scale_control",
               "value" => "true",
               "description" => esc_html__("", "pacz")
          ),

          array(
               "type" => "dropdown",
               "heading" => esc_html__("Modify Google Maps Hue, Saturation, Lightness", "pacz"),
               "param_name" => "modify_coloring",
               "value" => array(
                    esc_html__("No", "pacz") => "false",
                    esc_html__("Yes", "pacz") => "true"
               ),
               "description" => esc_html__("", "pacz")
          ),
          array(
               "type" => "colorpicker",
               "heading" => esc_html__("Hue", "pacz"),
               "param_name" => "hue",
               "value" => "#ff4400",
               "description" => esc_html__("Sets the hue of the feature to match the hue of the color supplied. Note that the saturation and lightness of the feature is conserved, which means, the feature will not perfectly match the color supplied .", "pacz"),
               "dependency" => array(
                    'element' => "modify_coloring",
                    'value' => array(
                         'true'
                    )
               )
          ),
		  array(
               "type" => "textfield",
               "heading" => esc_html__("gamma", "pacz"),
               "param_name" => "gamma",
               "value" => "0.72",
               "description" => esc_html__("Sets the hue of the feature to match the hue of the color supplied. Note that the saturation and lightness of the feature is conserved, which means, the feature will not perfectly match the color supplied .", "pacz"),
               "dependency" => array(
                    'element' => "modify_coloring",
                    'value' => array(
                         'true'
                    )
               )
          ),
          array(
               "type" => "range",
               "heading" => esc_html__("Saturation", "pacz"),
               "param_name" => "saturation",
               "value" => "-68",
               "min" => "-100",
               "max" => "100",
               "step" => "1",
               "unit" => '',
               "description" => esc_html__('Shifts the saturation of colors by a percentage of the original value if decreasing and a percentage of the remaining value if increasing. Valid values: [-100, 100].', "pacz"),
               "dependency" => array(
                    'element' => "modify_coloring",
                    'value' => array(
                         'true'
                    )
               )
          ),
          array(
               "type" => "range",
               "heading" => esc_html__("Lightness", "pacz"),
               "param_name" => "lightness",
               "value" => "-4",
               "min" => "-100",
               "max" => "100",
               "step" => "1",
               "unit" => '',
               "description" => esc_html__('Shifts lightness of colors by a percentage of the original value if decreasing and a percentage of the remaining value if increasing. Valid values: [-100, 100].', "pacz"),
               "dependency" => array(
                    'element' => "modify_coloring",
                    'value' => array(
                         'true'
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
    "base" => "vc_flickr",
    "name" => esc_html__("Flickr Feeds", "pacz"),
    'icon' => 'icon-pacz-flickr-feeds vc_pacz_element-icon',
    'description' => esc_html__( 'Show your Flickr Feeds.', 'pacz' ),
    "category" => esc_html__('Social', 'pacz'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Flickr ID", "pacz"),
            "param_name" => "flickr_id",
            "value" => "",
            "description" => esc_html__('To find your flickID visit http://idgettr.com/  In order to use Flickr Shortcode you should first obtain an API key from http://www.flickr.com/services/api/misc.api_keys.htmlFlickr The App Garden and update the field in Theme settings => Third Party API => Flickr API Key.', "pacz")
        ),
        array(
            "type" => "range",
            "heading" => esc_html__("Number of photos", "pacz"),
            "param_name" => "count",
            "value" => "6",
            "min" => "1",
            "max" => "200",
            "step" => "1",
            "unit" => 'photos'
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("How many photos in one row?", "pacz"),
            "param_name" => "column",
            "value" => array(
                esc_html__("1", "pacz") => "one",
                esc_html__("2", "pacz") => "two",
                esc_html__("3", "pacz") => "three",
                esc_html__("4", "pacz") => "four",
                esc_html__("5", "pacz") => "five",
                esc_html__("6", "pacz") => "six",
                esc_html__("7", "pacz") => "seven",
                esc_html__("8", "pacz") => "eight"
            ),
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
    "base" => "pacz_contact_form",
    "name" => esc_html__("Contact Form", "pacz"),
    'icon' => 'icon-pacz-contact-form vc_pacz_element-icon',
    'description' => esc_html__( 'Adds Contact form element.', 'pacz' ),
    "category" => esc_html__('Social', 'pacz'),
    "params" => array(


        array(
            "type" => "textfield",
            "heading" => esc_html__("Email", "pacz"),
            "param_name" => "email",
            "value" => "",
            "description" => sprintf(esc_html__('Which email would you like the contacts to be sent, if left empty emails will be sent to admin email : "%s"', "pacz"), get_bloginfo('admin_email'))

        ),
       /* array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", "pacz"),
            "param_name" => "style",
            "value" => array(
                esc_html__("Classic", "pacz") => "classic",
                esc_html__("Modern", "pacz") => "modern"
            ),
            "description" => esc_html__("Choose your contact form style", "pacz")
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Skin", "pacz"),
            "param_name" => "skin",
            "value" => array(
                esc_html__("Dark", "pacz") => "dark",
                esc_html__("Light", "pacz") => "light"
            ),
            "description" => esc_html__("Choose your contact form style", "pacz"),
            "dependency" => array(
                'element' => "style",
                'value' => array(
                    'classic'
                )
            )
        ),
        array(
               "type" => "colorpicker",
               "heading" => esc_html__("Skin Color", "pacz"),
               "param_name" => "skin_color",
               "value" => "#000",
               "description" => esc_html__("", "pacz"),
               "dependency" => array(
                    'element' => "style",
                    'value' => array(
                         'modern'
                    )
               )
        ),

        array(
               "type" => "colorpicker",
               "heading" => esc_html__("Button Text Color", "pacz"),
               "param_name" => "btn_text_color",
               "value" => "#000",
               "description" => esc_html__("", "pacz"),
               "dependency" => array(
                    'element' => "style",
                    'value' => array(
                         'modern'
                    )
               )
        ),

        array(
               "type" => "colorpicker",
               "heading" => esc_html__("Button Hover Text Color", "pacz"),
               "param_name" => "btn_hover_text_color",
               "value" => "#fff",
               "description" => esc_html__("", "pacz"),
               "dependency" => array(
                    'element' => "style",
                    'value' => array(
                         'modern'
                    )
               )
        ),

        array(
            "type" => "toggle",
            "heading" => esc_html__("Show Phone Number Field?", "pacz"),
            "param_name" => "phone",
            "value" => "false",
            "description" => esc_html__("", "pacz")
        ),*/
        array(
            "type" => "toggle",
            "heading" => esc_html__("Show Captcha?", "pacz"),
            "param_name" => "captcha",
            "value" => "true",
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
    "base" => "pacz_contact_info",
    "name" => esc_html__("Contact Info", "pacz"),
    'icon' => 'icon-pacz-contact-info vc_pacz_element-icon',
    "category" => esc_html__('Social', 'pacz'),
    'description' => esc_html__( 'Adds Contact info details.', 'pacz' ),
    "params" => array(

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Skin", "pacz"),
            "param_name" => "skin",
            "value" => array(
                esc_html__("Dark", "pacz") => "dark",
                esc_html__("Light", "pacz") => "light",
                esc_html__("Custom", "pacz") => "custom"
            ),
            "description" => esc_html__("Choose your contact form style", "pacz")
        ),
        array(
             "type" => "colorpicker",
             "heading" => esc_html__("Text & Icon Color", "pacz"),
             "param_name" => "text_icon_color",
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
             "heading" => esc_html__("Border Color", "pacz"),
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
            "type" => "textfield",
            "heading" => esc_html__("Name", "pacz"),
            "param_name" => "name",
            "value" => ""
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Cellphone", "pacz"),
            "param_name" => "cellphone",
            "value" => ""
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Phone", "pacz"),
            "param_name" => "phone",
            "value" => ""
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Address", "pacz"),
            "param_name" => "address",
            "value" => ""
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Website", "pacz"),
            "param_name" => "website",
            "value" => ""
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Email", "pacz"),
            "param_name" => "email",
            "value" => ""
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
