<?php 

class alsp_content_field_search {
	public $value;

	public $content_field;
	
	public function assignContentField($content_field) {
		$this->content_field = $content_field;
	}
	
	public function convertSearchOptions() {
		if ($this->content_field->search_options) {
			$unserialized_options = unserialize($this->content_field->search_options);
			if (count($unserialized_options) > 1 || $unserialized_options != array('')) {
				$this->content_field->search_options = $unserialized_options;
				if (method_exists($this, 'buildSearchOptions'))
					$this->buildSearchOptions();
				return $this->content_field->search_options;
			}
		}
		return array();
	}
	
	public function getBaseUrlArgs(&$args) {
		$field_index = 'field_' . $this->content_field->slug;
	
		if (isset($_GET[$field_index]) && $_GET[$field_index])
			$args[$field_index] = $_GET[$field_index];
	}
	
	public function getVCParams() {
		return array();
	}
}
?>