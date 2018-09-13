<?php

class DHVCForm_Validation implements ArrayAccess {
	private $invalid_fields = array();
	private $container = array();

	public function __construct() {
		$this->container = array(
			'valid' => true,
			'reason' => array(),
			'idref' => array(),
		);
	}

	public function invalidate( $field, $message, $into = ''  ) {
		$name = $field->get_name();
		$id = $field->get_id();
		if(isset($this->invalid_fields[$name]))
			return;
		$this->invalid_fields[] = array(
			'reason' => $message,
			'idref' => $id,
			'into'=> $into == '' ?  '.dhvc-form-value.dhvc-form-control-'.$name : $into
		);
	}

	public function is_valid( $name = null ) {
		if ( ! empty( $name ) ) {
			return ! isset( $this->invalid_fields[$name] );
		} else {
			return empty( $this->invalid_fields );
		}
	}

	public function get_invalid_fields() {
		return $this->invalid_fields;
	}

	public function offsetSet( $offset, $value ) {
		if ( isset( $this->container[$offset] ) ) {
			$this->container[$offset] = $value;
		}

		if ( 'reason' == $offset && is_array( $value ) ) {
			foreach ( $value as $k => $v ) {
				$this->invalidate( $k, $v );
			}
		}
	}

	public function offsetGet( $offset ) {
		if ( isset( $this->container[$offset] ) ) {
			return $this->container[$offset];
		}
	}

	public function offsetExists( $offset ) {
		return isset( $this->container[$offset] );
	}

	public function offsetUnset( $offset ) {
	}
}
