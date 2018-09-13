<?php

extract( shortcode_atts( array(
			'el_class' => '',
			'size' => '',
			'sort_by' => '',
			'tag_name' => 's',
			'instagram_id' => '',
			'access_token' => '',
			'count' => 9,
			'column' => ''
		), $atts ) );

wp_enqueue_script( 'instafeed' );

$id = uniqid();

echo '<div id="instagram-feeds-'.$id.'" class="pacz-instagram-feeds '.$el_class.'" data-size="'.$size.'" data-sort="'.$sort_by.'" data-count="'.$count.'" data-userid="'.$instagram_id.'" data-accesstoken="'.$access_token.'" data-column="'.$column.'"></div>';
