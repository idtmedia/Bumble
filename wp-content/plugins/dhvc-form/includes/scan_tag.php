<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class DHVCForm_Scan_Tag {
	private $_scanned_fields = array();
	
	public function __construct($content){
		preg_replace_callback('/' . $this->_field_regex() . '/s',array( $this, '_scan_field_callback' ),$content);
	}
	
	public function get_scaned_fields(){
		return $this->_scanned_fields;
	}
	
	private function _field_regex(){
		$tagnames = array_keys(dhvc_form_get_fields());
		$tagregexp = join( '|', array_map( 'preg_quote', $tagnames ) );
		return '(\[?)'
			. '\[(' . $tagregexp . ')(?:[\r\n\t ](.*?))?(?:[\r\n\t ](\/))?\]'
				. '(?:([^[]*?)\[\/\2\])?'
					. '(\]?)';
	}
	
	private function _scan_field_callback($m){
		// allow [[foo]] syntax for escaping a tag
		if ( $m[1] == '[' && $m[6] == ']' ) {
			return substr( $m[0], 1, -1 );
		}
	
		$field_tag = $m[2];
		$field_attr = (array) shortcode_parse_atts( $m[3] );
		$name = isset($field_attr['control_name']) ? trim($field_attr['control_name']) : '';
		if($field_tag=='dhvc_form_paypal')
			$name = '_dhvc_form_paypal_field';
		if(empty($name))
			return $m[0];
		$field_attr['tag'] = $field_tag;
		$this->_scanned_fields[$name] = $field_attr;
	
		return $m[0];
	}
	
}