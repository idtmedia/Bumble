<?php 

class alsp_content_field_price_search extends alsp_content_field_number_search {

	public function renderSearch($random_id, $columns = 2, $price_col = 3) {
		if ($this->mode == 'exact_number')
			alsp_frontendRender('search_fields/fields/price_input_exactnumber.tpl.php', array('search_field' => $this, 'columns' => $columns, 'random_id' => $random_id));
		elseif ($this->mode == 'min_max')
			alsp_frontendRender('search_fields/fields/price_input_minmax.tpl.php', array('search_field' => $this, 'columns' => $columns, 'random_id' => $random_id));
		elseif ($this->mode == 'min_max_slider' || $this->mode == 'range_slider')
			alsp_frontendRender('search_fields/fields/price_input_slider.tpl.php', array('search_field' => $this, 'columns' => $columns, 'price_col' => $price_col, 'random_id' => $random_id));
	}
}
?>