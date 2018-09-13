<?php 

class alsp_content_field_string_search extends alsp_content_field_search {

	public function renderSearch($random_id, $columns = 2, $textstring = 6) {
		alsp_frontendRender('search_fields/fields/string_textarea_input.tpl.php', array('search_field' => $this, 'columns' => $columns, 'textstring' => $textstring, 'random_id' => $random_id));
	}
	
	public function validateSearch(&$args, $defaults = array(), $include_GET_params = true) {
		$field_index = 'field_' . $this->content_field->slug;

		if ($include_GET_params)
			$value = alsp_getValue($_GET, $field_index, alsp_getValue($defaults, $field_index));
		else
			$value = alsp_getValue($defaults, $field_index);

		if ($value) {
			$this->value = $value;
			$args['meta_query']['relation'] = 'AND';
			$args['meta_query'][] = array(
					'key' => '_content_field_' . $this->content_field->id,
					'value' => $this->value,
					'compare' => 'LIKE'
			);
		}
	}
	
	public function getVCParams() {
		return array(
				array(
						'type' => 'textfield',
						'param_name' => 'field_' . $this->content_field->slug,
						'heading' => $this->content_field->name,
				),
		);
	}
}
?>