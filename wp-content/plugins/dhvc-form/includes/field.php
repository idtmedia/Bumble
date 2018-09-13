<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class DHVCForm_Field {
	
	private $field;
	
	public function __construct($field){
		$this->field = $field;
	}
	
	public function is_required(){
		return isset($this->field['required']) && '1'===$this->field['required'];
	}
	
	public function base_type(){
		return str_replace('dhvc_form_', '', $this->field['tag']);
	}
	
	public function get_name(){
		return esc_attr(trim($this->field['control_name']));
	}
	
	public function get_id(){
		return 'dhvc_form_control_'.$this->get_name();
	}
	
	public function get_validator(){
		$validator = isset($this->field['validator']) ? explode(',', $this->field['validator']) : array();
		return $validator;
	}
	
	public function get_attrs(){
		return $this->field;
	}
	
	public function attr($attr=''){
		if(''==$attr || !isset($this->field[$attr]))
			return false; 
		return $this->field[$attr];
	}
}