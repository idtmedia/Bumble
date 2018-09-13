<?php 

class alsp_categories_controller extends alsp_frontend_controller {

	public function init($args = array()) {
		global $alsp_instance, $ALSP_ADIMN_SETTINGS;
		
		parent::init($args);

		$shortcode_atts = array_merge(array(
				'custom_home' => 0,
				'parent' => 0,
				'depth' => 1,
				'columns' => 1,
				'count' => 1,
				'subcats' => 0,
				'levels' => array(),
				'categories' => array(),
				'cat_style' => 1,
				'cat_icon_type' => 1,
				'scroll' => 0, //cz custom
				'desktop_items' => 5, //cz custom
				'tab_landscape_items' => '3' , //cz custom
				'tab_items' => '2' , //cz custom
				'autoplay' => 'false' , //cz custom
				'loop' => 'false' , //cz custom
				'owl_nav' => 'false' , //cz custom
				'delay' => '1000' , //cz custom
				'autoplay_speed' => '1000' , //cz custom
				'gutter' => '30' , //cz custom
		), $args);
		$this->args = $shortcode_atts;

		if ($this->args['custom_home']) {
			if ($alsp_instance->getShortcodeProperty('webdirectory', 'is_category')) {
				$category = $alsp_instance->getShortcodeProperty('webdirectory', 'category');
				$this->args['parent'] = $category->term_id;
			}

			$this->args['depth'] = alsp_getValue($args, 'depth', $ALSP_ADIMN_SETTINGS['alsp_categories_nesting_level']);
			$this->args['columns'] = alsp_getValue($args, 'columns', $ALSP_ADIMN_SETTINGS['alsp_categories_columns']);
			$this->args['count'] = alsp_getValue($args, 'count', $ALSP_ADIMN_SETTINGS['alsp_show_category_count']);
			$this->args['subcats'] = alsp_getValue($args, 'subcats', $ALSP_ADIMN_SETTINGS['alsp_subcategories_items']);
			$this->args['cat_style'] = alsp_getValue($args, 'cat_style', $ALSP_ADIMN_SETTINGS['alsp_categories_style']);
			$this->args['cat_icon_type'] = alsp_getValue($args, 'cat_icon_type', $ALSP_ADIMN_SETTINGS['cat_icon_type']);
			$this->args['scroll'] = alsp_getValue($args, 'scroll');
			$this->args['desktop_items'] = alsp_getValue($args, 'desktop_items');
			$this->args['tab_landscape_items'] = alsp_getValue($args, 'tab_landscape_items');
			$this->args['tab_items'] = alsp_getValue($args, 'tab_items');
			$this->args['autoplay'] = alsp_getValue($args, 'autoplay');
			$this->args['loop'] = alsp_getValue($args, 'loop');
			$this->args['owl_nav'] = alsp_getValue($args, 'owl_nav');
			$this->args['delay'] = alsp_getValue($args, 'delay');
			$this->args['autoplay_speed'] = alsp_getValue($args, 'autoplay_speed');
			$this->args['gutter'] = alsp_getValue($args, 'gutter');
		}
			
			
		if (isset($this->args['levels']) && !is_array($this->args['levels']))
			if ($levels = array_filter(explode(',', $this->args['levels']), 'trim'))
				$this->args['levels'] = $levels;

		if (isset($this->args['categories']) && !is_array($this->args['categories']))
			if ($categories = array_filter(explode(',', $this->args['categories']), 'trim'))
				$this->args['categories'] = $categories;

		apply_filters('alsp_frontend_controller_construct', $this);
	}

	public function display() {
		ob_start();
		alsp_renderAllCategories($this->args['parent'], $this->args['depth'], $this->args['columns'], $this->args['count'], $this->args['subcats'], $this->args['cat_style'], $this->args['cat_icon_type'], $this->args['scroll'], $this->args['desktop_items'], $this->args['tab_landscape_items'], $this->args['tab_items'], $this->args['autoplay'], $this->args['loop'], $this->args['owl_nav'], $this->args['delay'], $this->args['autoplay_speed'], $this->args['gutter'], $this->args['levels'], $this->args['categories']);
		$output = ob_get_clean();

		return $output;
	}
}

?>