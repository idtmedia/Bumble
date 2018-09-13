<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Difp_Shortcodes
  {
	private static $instance;
	
	public static function init()
        {
            if(!self::$instance instanceof self) {
                self::$instance = new self;
            }
            return self::$instance;
        }
	
    function actions_filters()
    	{
			//ADD SHORTCODES
			add_shortcode( 'di-frontend-pm', array(difp_main_class::init(), 'main_shortcode_output' )); //for DesignInvento Messaging System
			add_shortcode( 'difp_shortcode_new_message_count', array($this, 'new_message_count' ) );
			add_shortcode( 'difp_shortcode_message_to', array($this, 'message_to') );
			add_shortcode( 'difp_shortcode_new_announcement_count', array($this, 'new_announcement_count' ) );
			add_shortcode( 'difp_shortcode_new_message_form', array($this, 'new_message_form') );
			add_shortcode( 'difp_shortcode_new_bidding_form', array($this, 'new_bidding_form') );

    	}
	
	function new_message_count(){
		return difp_get_new_message_button();
	}
	
	function new_announcement_count( $atts = array(), $content = null, $tag = '' ){
		$atts = array_change_key_case((array)$atts, CASE_LOWER);
		$atts = shortcode_atts( array(
				'show_bracket'		=> '1',
				'hide_if_zero'		=> '1',
				'ajax'				=> '1',
				'class'				=> 'difp-font-red',
			), $atts, $tag );
		return difp_get_new_announcement_button( $atts );
	}
	
	function message_to( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				'to'		=> '{current-post-author}',
				'subject'		=> '{current-post-title}',
				'listing_id'		=> '44365',
				//'listing_bid'		=> '{current-post-bid}',
				'text'		=> __('Contact','ALSP' ),
				'class'		=> 'difp-button'
			), $atts, 'difp_shortcode_message_to' );
			
			if( '{current-post-author}' == $atts['to'] ){
				$atts['to'] = get_the_author_meta('user_nicename');
			} elseif( '{current-author}' == $atts['to'] ){
				if( $nicename = difp_get_userdata( get_query_var( 'author_name' ), 'user_nicename' ) ){
					$atts['to'] = $nicename;
				} elseif( $nicename = difp_get_userdata( get_query_var( 'author' ), 'user_nicename', 'id' ) ){
					$atts['to'] = $nicename;
				}
				unset( $nicename );
			} else {
				$atts['to'] = esc_html( $atts['to'] );
			}
			
			if( '{current-post-title}' == $atts['subject'] ){
				$atts['subject'] = urlencode( get_the_title() );
			} elseif( ! empty( $atts['subject'] ) ) {
				$atts['subject'] = urlencode( $atts['subject'] );
			} else {
				$atts['subject'] = false;
			}
			
			if( empty( $atts['to'] ) )
				return '';
	
		return '<a href="' . difp_query_url('newmessage', array( 'difp_to' => $atts['to'], 'message_title' => $atts['subject'], 'message_post_id' =>  $atts['listing_id'], 'message_bid' =>  $atts['listing_bid']) ) . '" class="' . esc_attr( $atts['class'] ) . '">' . esc_html( $atts['text'] ) . '</a>';
	}
	
	function new_message_form( $atts, $content = null ){
		$atts = shortcode_atts( array(
				'to' => '{current-post-author}',
				'subject' => '',
				'listing_id' => '{current-post-id}',
				'enable_ajax'		=> 'true',
				'heading'		=> __('Contact','ALSP' )
			), $atts, 'difp_shortcode_new_message_form' );
			
			if( '{current-post-author}' == $atts['to'] ){
				$atts['to'] = get_the_author_meta('user_nicename');
			} elseif( '{current-author}' == $atts['to'] ){
				if( $nicename = difp_get_userdata( get_query_var( 'author_name' ), 'user_nicename' ) ){
					$atts['to'] = $nicename;
				} elseif( $nicename = difp_get_userdata( get_query_var( 'author' ), 'user_nicename', 'id' ) ){
					$atts['to'] = $nicename;
				}
				unset( $nicename );
			} else {
				$atts['to'] = esc_html( $atts['to'] );
			}
			
			if( '{current-post-title}' == $atts['subject'] ){
				$atts['subject'] = get_the_title();
			}
			if( '{current-post-id}' == $atts['listing_id'] ){
				
				$atts['listing_id'] = '{current-post-id}';
			}
			extract( $atts );
			
			//if( ! difp_current_user_can('send_new_message_to', $to ) )
				//return '';
			
			if( ! empty( $enable_ajax )){
				wp_enqueue_script( 'difp-shortcode-newmessage' );
				add_filter( 'difp_form_submit_button', array( $this, 'show_ajax_img'), 10, 2 );
			}
			
			$template = difp_locate_template( 'shortcode_newmessage_form.php');
	  
		  ob_start();
		  include( $template );
		  return ob_get_clean();
	}
	function new_bidding_form( $atts, $content = null ){
		$atts = shortcode_atts( array(
				'to'		=> '{current-post-author}',
				'subject' => '',
				'listing_id' => '{current-post-id}',
				'listing_bid' => '',
				'enable_ajax'		=> true,
				//'heading'		=> __('Contact','ALSP' )
			), $atts, 'difp_shortcode_new_bidding_form' );
			
			if( '{current-post-author}' == $atts['to'] ){
				$atts['to'] = get_the_author_meta('user_nicename');
			} elseif( '{current-author}' == $atts['to'] ){
				if( $nicename = difp_get_userdata( get_query_var( 'author_name' ), 'user_nicename' ) ){
					$atts['to'] = $nicename;
				} elseif( $nicename = difp_get_userdata( get_query_var( 'author' ), 'user_nicename', 'id' ) ){
					$atts['to'] = $nicename;
				}
				unset( $nicename );
			} else {
				$atts['to'] = esc_html( $atts['to'] );
			}
			
			if( '{current-post-title}' == $atts['subject'] ){
				$atts['subject'] = get_the_title();
			}
			if( '{current-post-id}' == $atts['listing_id'] ){
				//$page = get_post_ID_by_title(, OBJECT, 'alsp-listing');
				$atts['listing_id'] = get_the_ID();
			}
			extract( $atts );
			
			if( ! difp_current_user_can('send_new_message_to', $to ) )
				return '';
			
			if( ! empty( $enable_ajax )){
				wp_enqueue_script( 'difp-shortcode-newbidding' );
				add_filter( 'difp_form_submit_button', array( $this, 'show_ajax_img'), 10, 2 );
			}
			
			$template = difp_locate_template( 'shortcode_newbidding_form.php');
	  
		  ob_start();
		  include( $template );
		  return ob_get_clean();
	}
	function show_ajax_img( $button, $where ){
		if( 'shortcode-newmesseage' == $where ){
			$button = $button . '<img src="'. DIFP_PLUGIN_URL . 'assets/images/loading.gif" class="difp-ajax-img" style="display:none;"/>';
		}
		if( 'shortcode-newbidding' == $where ){
			$button = $button . '<img src="'. DIFP_PLUGIN_URL . 'assets/images/loading.gif" class="difp-ajax-img" style="display:none;"/>';
		}
		return $button;
	}
	
 } //END CLASS

add_action('init', array(Difp_Shortcodes::init(), 'actions_filters'));
