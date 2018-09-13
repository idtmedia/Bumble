<?php

class classiadsproLovePost {

	function __construct() {
		add_action( 'wp_ajax_pacz_love_post', array( &$this, 'pacz_love_post' ) );
		add_action( 'wp_ajax_nopriv_pacz_love_post', array( &$this, 'pacz_love_post' ) );
	}



	function pacz_love_post( $post_id ) {

		if ( isset( $_POST['post_id'] ) ) {
			$post_id = str_replace( 'pacz-love-', '', $_POST['post_id'] );
			echo '<div>'.$this->love_post( $post_id, 'update' ).'</div>';
		}
		else {
			$post_id = str_replace( 'pacz-love-', '', $_POST['post_id'] );
			echo '<div>'.$this->love_post( $post_id, 'get' ).'</div>';
		}

		exit;
	}


	function love_post( $post_id, $action = 'get' ) {
		if ( !is_numeric( $post_id ) ) return;
		$post_type = get_post_type($post_id);
		$cookie_string = 'pacz_classiadspro_love_'.$post_type.'_'. $post_id;
		switch ( $action ) {

		case 'get':
			$love_count = get_post_meta( $post_id, '_pacz_post_love', true );
			if ( !$love_count ) {
				$love_count = 0;
				add_post_meta( $post_id, '_pacz_post_love', $love_count, true );
			}

			return '<span class="pacz-love-count">'. $love_count .'</span>';
			break;

		case 'update':
			$love_count = get_post_meta( $post_id, '_pacz_post_love', true );
			
			if ( isset( $_COOKIE['pacz_classiadspro_love_'.$post_type.'_'. $post_id] ) ) return $love_count;

			$love_count++;
			update_post_meta( $post_id, '_pacz_post_love', $love_count );
			setcookie($cookie_string, $post_id, time()*20, '/' );

			return $love_count;
			break;

		}
	}


	function send_love() {
		global $post;
		$post_type = get_post_type( $post->ID);
		$output = $this->love_post( $post->ID );
		$class = '';
		if ( isset( $_COOKIE['pacz_classiadspro_love_'.$post_type.'_'. $post->ID] ) ) {
			$class = 'item-loved';
			$loveicon = 'pacz-icon-heart';
		}else if( !isset( $_COOKIE['pacz_classiadspro_love_'.$post_type.'_'. $post->ID] ) ){
			$class = '';
			$loveicon = 'pacz-icon-heart-o';
		}

		return '<span class="pacz-love-this '. $class .'" id="pacz-love-'. $post->ID .'"><i class="'.$loveicon.'"></i> '. $output .'</span>';
	}

}


global $pacz_love_this;
$pacz_love_this = new classiadsproLovePost();

function pacz_love_this( $return = '' ) {

	global $pacz_love_this;

	if ( $return == 'return' ) {
		return $pacz_love_this->send_love();
	} else {
		echo '<div class="love-main">'.$pacz_love_this->send_love().'</div>';
	}

}

?>
