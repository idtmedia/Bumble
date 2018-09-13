<?php 

class alsp_content_field_checkbox_search extends alsp_content_field_select_search {
	public function renderSearch($random_id, $columns = 2, $checkbox = 6) {
		alsp_frontendRender('search_fields/fields/select_checkbox_radio_input.tpl.php', array('search_field' => $this, 'columns' => $columns, 'checkbox' => $checkbox, 'random_id' => $random_id));
	}
}
?>