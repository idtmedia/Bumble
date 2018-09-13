<?php
function alsp_tax_dropdowns_init($tax = 'category', $field_name = null, $term_id = null, $count = true, $labels = array(), $titles = array(), $uID = null) {
	// unique ID need when we place some dropdowns groups on one page
	if (!$uID)
		$uID = rand(1, 10000);

	global $ALSP_ADIMN_SETTINGS;
	if($cat_maker_icon = alsp_getCategoryMarkerIcon($term_id)){
		$icon_image = '<span class="cat-icon '.$cat_maker_icon.'"></span>';
	}else{
		$icon_image ='';
	}
	
	$localized_data[$uID] = array(
			'labels' => $labels,
			'titles' => $titles,
			'icons' => $icon_image
	);
	echo "<script> alsp_js_objects['tax_search_dropdowns_" . $uID . "'] = " . json_encode($localized_data) . "</script>";

	if (!is_null($term_id) && $term_id != 0) {
		$chain = array();
		$parent_id = $term_id;
		while ($parent_id != 0) {
			if ($term = get_term($parent_id, $tax)) {
				$chain[] = $term->term_id;
				$parent_id = $term->parent;
			} else
				break;
		}
	}
	
	$path_chain = array();
	$chain[] = 0;
	$chain = array_reverse($chain);
	$level_num = 1;

	if (!$field_name) {
		$field_name = 'selected_tax[' . $uID . ']';
		$path_field_name = 'selected_tax_path[' . $uID . ']';
	} else {
		$path_field_name = $field_name . '_path';
	}
	if($tax == 'alsp-category'){
		$term_title = esc_html__('Category', 'ALSP');
	}else if($tax == 'alsp-location'){
		$term_title = esc_html__('Location', 'ALSP');
	}
	
	if($tax == 'alsp-category' && $ALSP_ADIMN_SETTINGS['alsp_show_category_count_in_search']){
		$show_count = 1;
	}elseif($tax == 'alsp-location' && $ALSP_ADIMN_SETTINGS['alsp_show_location_count_in_search']){
		$show_count = 1;
	}else{
		$show_count = 0;
	}

	echo '<div id="alsp-tax-dropdowns-search-wrap-' . $uID . '" class="' . $tax . ' cs_count_' . (int)$count . ' alsp-tax-dropdowns-search-wrap">';
	echo '<input type="hidden" name="' . $field_name . '" id="selected_tax[' . $uID . ']" class="selected_tax_' . $tax . '" value="' . $term_id . '" />';
	if($tax == 'alsp-category'){
		if (isset($_GET['categories']) && $_GET['categories'] != '0' && is_numeric($_GET['categories'])){
			$term_idf = get_term_by('id', $_GET['categories'], $tax);
			$term_title = $term_idf->name;
		}else{
			$term_title = esc_html__('Category', 'ALSP');
		}
	}elseif($tax == 'alsp-location'){
		if (isset($_GET['location_id']) && $_GET['location_id'] != '0' && is_numeric($_GET['location_id'])){
			$term_idf = get_term_by('id', $_GET['location_id'], $tax);
			$term_title = $term_idf->name;
		}else{
			$term_title = esc_html__('Location', 'ALSP');
		}
	}
	$args = array(
    'show_option_none'   => $term_title,
	'option_none_value'     => 0, // string
    'taxonomy'           => $tax,
    'id'                 => 'tax-type',
	'hierarchical' => true,
    'echo'               => false,
	'hide_empty' => false,
	'show_count'=> $show_count,
	'class' => $term_id,
);

$cat_dropdown = wp_dropdown_categories( $args );

$cat_dropdown = preg_replace( 
        '^' . preg_quote( '<select ' ) . '^', 
        '<select id="chainlist_' . $level_num . '_' . $uID . '" class="cs-select alsp-location-input pacz-select2"',
		
        $cat_dropdown
    );

echo $cat_dropdown;
	echo '<input type="hidden" name="' . $path_field_name . '" id="selected_tax_path[' . $uID . ']" class="selected_tax_path_' . $tax . '" value="' . implode(', ', $path_chain) . '" />';
	echo '</div>';

}
function alsp_tax_dropdowns_meta_init($tax = 'category', $field_name = null, $term_id = null, $count = true, $labels = array(), $titles = array(), $uID = null, $exact_terms = array(), $hide_empty = false) {
	// unique ID need when we place some dropdowns groups on one page
	if (!$uID)
		$uID = rand(1, 10000);

	$localized_data[$uID] = array(
			'labels' => $labels,
			'titles' => $titles
	);
	echo "<script>alsp_js_objects['tax_dropdowns_" . $uID . "'] = " . json_encode($localized_data) . "</script>";

	if (!is_null($term_id) && $term_id != 0) {
		$chain = array();
		$parent_id = $term_id;
		while ($parent_id != 0) {
			if ($term = get_term($parent_id, $tax)) {
				$chain[] = $term->term_id;
				$parent_id = $term->parent;
			} else
				break;
		}
	}
	$path_chain = array();
	$chain[] = 0;
	$chain = array_reverse($chain);

	if (!$field_name) {
		$field_name = 'selected_tax[' . $uID . ']';
		$path_field_name = 'selected_tax_path[' . $uID . ']';
	} else {
		$path_field_name = $field_name . '_path';
	}

	echo '<div id="alsp-tax-dropdowns-wrap-' . $uID . '" class="' . $tax . ' cs_count_' . (int)$count . ' cs_hide_empty_' . (int)$hide_empty . ' alsp-tax-dropdowns-wrap">';
	echo '<input type="hidden" name="' . $field_name . '" id="selected_tax[' . $uID . ']" class="selected_tax_' . $tax . '" value="' . $term_id . '" />';
	echo '<input type="hidden" id="exact_terms[' . $uID . ']" value="' . addslashes(implode(',', $exact_terms)) . '" />';
	foreach ($chain AS $key=>$term_id) {
		if ($count) {
			// there is a wp bug with pad_counts in get_terms function - so we use this construction
			$terms = wp_list_filter(get_categories(array('taxonomy' => $tax, 'pad_counts' => true, 'hide_empty' => $hide_empty)), array('parent' => $term_id));
		} else {
			$terms = get_categories(array('taxonomy' => $tax, 'pad_counts' => true, 'hide_empty' => $hide_empty, 'parent' => $term_id));
		}

		if (!empty($terms)) {
			foreach ($terms AS $id=>$term) {
				if ($exact_terms && (!in_array($term->term_id, $exact_terms) && !in_array($term->slug, $exact_terms))) {
					unset($terms[$id]);
				}
			}

			// when selected exact sub-categories of non-root category
			if (empty($terms) && !empty($exact_terms)) {
				if ($count) {
					// there is a wp bug with pad_counts in get_terms function - so we use this construction
					$terms = wp_list_filter(get_categories(array('taxonomy' => $tax, 'include' => $exact_terms, 'pad_counts' => true, 'hide_empty' => $hide_empty)));
				} else {
					$terms = get_categories(array('taxonomy' => $tax, 'include' => $exact_terms, 'pad_counts' => true, 'hide_empty' => $hide_empty));
				}
			}

			if (!empty($terms)) {
				$level_num = $key + 1;
				echo '<div id="wrap_chainlist_' . $level_num . '_' .$uID . '" class="alsp-row alsp-form-group alsp-location-input">';
	
					if (isset($labels[$key]))
						echo '<label class="alsp-col-md-2 alsp-control-label" for="chainlist_' . $level_num . '_' . $uID . '">' . $labels[$key] . '</label>';
	
					if (isset($labels[$key]))
					echo '<div class="alsp-col-md-10">';
					else
					echo '<div class="alsp-col-md-12">';
						echo '<select id="chainlist_' . $level_num . '_' . $uID . '" class="alsp-form-control pacz-select2">';
						echo '<option value="">- ' . ((isset($titles[$key])) ? $titles[$key] : __('Select term', 'ALSP')) . ' -</option>';
						foreach ($terms AS $term) {
							if ($count)
								$term_count = " ($term->count)";
							else
								 $term_count = '';
							if (isset($chain[$key+1]) && $term->term_id == $chain[$key+1]) {
								$selected = 'selected';
								$path_chain[] = $term->name;
							} else
								$selected = '';
							echo '<option id="' . $term->slug . '" value="' . $term->term_id . '" ' . $selected . '>' . $term->name . $term_count . '</option>';
						}
						echo '</select>';
					echo '</div>';
				echo '</div>';
			}
		}
		echo '<input type="hidden" name="' . $path_field_name . '" id="selected_tax_path[' . $uID . ']" class="selected_tax_path_' . $tax . '" value="' . implode(', ', $path_chain) . '" />';
	}
	echo '</div>';
}

function alsp_tax_dropdowns_updateterms() {
	$parentid = alsp_getValue($_POST, 'parentid');
	$next_level = alsp_getValue($_POST, 'next_level');
	$tax = alsp_getValue($_POST, 'tax');
	$count = alsp_getValue($_POST, 'count');
	$hide_empty = alsp_getValue($_POST, 'hide_empty');
	$exact_terms = array_filter(explode(',', alsp_getValue($_POST, 'exact_terms')));
	if (!$label = alsp_getValue($_POST, 'label'))
		$label = '';
	if (!$title = alsp_getValue($_POST, 'title'))
		$title = __('Select term', 'ALSP');
	$uID = alsp_getValue($_POST, 'uID');
	
	if ($hide_empty == 'cs_hide_empty_1') {
		$hide_empty = true;
	} else {
		$hide_empty = false;
	}

	if ($count == 'cs_count_1') {
		// there is a wp bug with pad_counts in get_terms function - so we use this construction
		$terms = wp_list_filter(get_categories(array('taxonomy' => $tax, 'pad_counts' => true, 'hide_empty' => $hide_empty)), array('parent' => $parentid));
	} else {
		$terms = get_categories(array('taxonomy' => $tax, 'pad_counts' => true, 'hide_empty' => $hide_empty, 'parent' => $parentid));
	}
	if (!empty($terms)) {
		foreach ($terms AS $id=>$term) {
			if ($exact_terms && (!in_array($term->term_id, $exact_terms) && !in_array($term->slug, $exact_terms))) {
				unset($terms[$id]);
			}
		}

		if (!empty($terms)) {
			echo '<div id="wrap_chainlist_' . $next_level . '_' . $uID . '" class="alsp-row alsp-form-group alsp-location-input">';
	
				if ($label)
					echo '<label class="alsp-col-md-2 alsp-control-label" for="chainlist_' . $next_level . '_' . $uID . '">' . $label . '</label>';
	
				if ($label)
				echo '<div class="alsp-col-md-10">';
				else 
				echo '<div class="alsp-col-md-12">';
					echo '<select id="chainlist_' . $next_level . '_' . $uID . '" class="alsp-form-control pacz-select2">';
					echo '<option value="">- ' . $title . ' -</option>';
					foreach ($terms as $term) {
						if (!$exact_terms || (in_array($term->term_id, $exact_terms) || in_array($term->slug, $exact_terms))) {
							if ($count == 'cs_count_1') {
								$term_count = " ($term->count)";
							} else { $term_count = '';
							}
							echo '<option id="' . $term->slug . '" value="' . $term->term_id . '">' . $term->name . $term_count . '</option>';
						}
					}
			
					echo '</select>';
				echo '</div>';
			echo '</div>';
		}
	}
	die();
}

function alsp_renderOptionsTerms($tax, $parent, $selected_terms, $level = 0) {
	$terms = get_terms($tax, array('parent' => $parent, 'hide_empty' => false));

	foreach ($terms AS $term) {
		echo '<option value="' . $term->term_id . '" ' . (($selected_terms && (in_array($term->term_id, $selected_terms) || in_array($term->slug, $selected_terms))) ? 'selected' : '') . '>' . (str_repeat('&nbsp;&nbsp;&nbsp;', $level)) . $term->name . '</option>';
		alsp_renderOptionsTerms($tax, $term->term_id, $selected_terms, $level+1);
	}
	return $terms;
}
function alsp_termsSelectList($name, $tax = 'category', $selected_terms = array()) {
	echo '<select multiple="multiple" name="' . $name . '[]" class="selected_terms_list alsp-form-control alsp-form-group" style="height: 300px">';
	echo '<option value="" ' . ((!$selected_terms) ? 'selected' : '') . '>' . __('- Select All -', 'ALSP') . '</option>';

	alsp_renderOptionsTerms($tax, 0, $selected_terms);

	echo '</select>';
}


function alsp_recaptcha() {
	global $ALSP_ADIMN_SETTINGS;
	if ($ALSP_ADIMN_SETTINGS['alsp_enable_recaptcha'] && $ALSP_ADIMN_SETTINGS['alsp_recaptcha_public_key'] && $ALSP_ADIMN_SETTINGS['alsp_recaptcha_private_key']) {
		return '<div class="g-recaptcha" data-sitekey="'.$ALSP_ADIMN_SETTINGS['alsp_recaptcha_public_key'].'"></div>';
	}
}

function alsp_is_recaptcha_passed() {
	global $ALSP_ADIMN_SETTINGS;
	if ($ALSP_ADIMN_SETTINGS['alsp_enable_recaptcha'] && $ALSP_ADIMN_SETTINGS['alsp_recaptcha_public_key'] && $ALSP_ADIMN_SETTINGS['alsp_recaptcha_private_key']) {
		if (isset($_POST['g-recaptcha-response']))
			$captcha = $_POST['g-recaptcha-response'];
		else
			return false;
		
		$response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret=".$ALSP_ADIMN_SETTINGS['alsp_recaptcha_private_key']."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
		if (!is_wp_error($response)) {
			$body = wp_remote_retrieve_body($response);
			$json = json_decode($body);
			if ($json->success === false)
				return false;
			else
				return true;
		} else
			return false;
	} else
		return true;
}

function alsp_orderLinks($base_url, $defaults = array(), $return = false, $shortcode_hash = null) {
	global $alsp_instance;
	global $ALSP_ADIMN_SETTINGS;
	if (isset($_GET['order_by']) && $_GET['order_by']) {
		$order_by = $_GET['order_by'];
		$order = alsp_getValue($_GET, 'order', 'ASC');
	} else {
		if (isset($defaults['order_by']) && $defaults['order_by']) {
			$order_by = $defaults['order_by'];
			$order = alsp_getValue($defaults, 'order', 'ASC');
		} else {
			$order_by = 'post_date';
			$order = 'DESC';
		}
	}

	$ordering['array'] = array();
	if ($ALSP_ADIMN_SETTINGS['alsp_orderby_date'])
		$ordering['array']['post_date'] = __('Date', 'ALSP');
	if ($ALSP_ADIMN_SETTINGS['alsp_orderby_title'])
		$ordering['array']['title'] = __('Title', 'ALSP');

	$exact_categories = array();
	if (!empty($defaults['categories'])) {
		$exact_categories = array_filter(explode(',', $defaults['categories']));
	}
	if ($current_category = alsp_is_category()) {
		$exact_categories[] = $current_category->term_id;
	}
	$content_fields = $alsp_instance->content_fields->getOrderingContentFields();
	foreach ($content_fields AS $content_field) {
		if ($exact_categories && $content_field->categories) {
			if (array_intersect($content_field->categories, $exact_categories)) {
				$ordering['array'][$content_field->slug] = $content_field->name;
			}
		} else {
			$ordering['array'][$content_field->slug] = $content_field->name;
		}
	}
	
	$ordering['links'] = array();
	$ordering['struct'] = array();
	foreach ($ordering['array'] AS $field_slug=>$field_name) {
		$class = '';
		$next_order = 'DESC';
		if ($order_by == $field_slug) {
			if ($order == 'ASC') {
				$class = 'ascending';
				$next_order = 'ASC';
				$url = esc_url(add_query_arg(array('order_by' => $field_slug, 'order' => $next_order), $base_url));
			} elseif ($order == 'DESC') {
				$class = 'descending';
				$next_order = 'DESC';
				$url = esc_url(add_query_arg('order_by', $field_slug, $base_url));
			}
		} else {
			if ($field_slug == 'title') {
				$next_order = 'ASC';
				$url = esc_url(add_query_arg(array('order_by' => $field_slug, 'order' => $next_order), $base_url));
			} else
				$url = esc_url(add_query_arg('order_by', $field_slug, $base_url));
		}

		$ordering['links'][$field_slug] = '<a class="' . $class . '" href="' . $url . '" rel="nofollow">' .$field_name . '</a>';
		$ordering['struct'][$field_slug] = array('class' => $class, 'url' => $url, 'field_name' => $field_name, 'order' => $next_order);
	}

	$ordering = apply_filters('alsp_ordering_options', $ordering, $base_url, $defaults, $shortcode_hash);

	if ($return)
		return $ordering;
	else
		echo __('Order by: ', 'ALSP') . implode(' | ', $ordering['links']);
}

function alsp_orderingItems() {
	global $alsp_instance;

	$ordering = array('post_date' => __('Date', 'ALSP'), 'title' => __('Title', 'ALSP'), 'rand' => __('Random', 'ALSP'));
	if(!empty($alsp_instance->content_fields)){
		$content_fields = $alsp_instance->content_fields->getOrderingContentFields();
	}else{
		$content_fields = array();
	}
	//$content_fields = $alsp_instance->content_fields->getOrderingContentFields();
	foreach ($content_fields AS $content_field)
		$ordering[$content_field->slug] = $content_field->name;
	$ordering = apply_filters('alsp_default_orderby_options', $ordering);
	$ordering_items = array();
	foreach ($ordering AS $field_slug=>$field_name)
		$ordering_items[] = array('value' => $field_slug, 'label' => $field_name);
	
	$new_listing_ordering = array();
	foreach($ordering_items as $listItem) {
		$new_listing_ordering[$listItem['value']] = $listItem['label'];
	}
	return $new_listing_ordering;
}

function alsp_renderSubCategories($parent_category_slug = '', $columns = 2, $count = false) {
	if ($parent_category = alsp_get_term_by_path($parent_category_slug))
		$parent_category_id = $parent_category->term_id;
	else
		$parent_category_id = 0;
	
	alsp_renderAllCategories($parent_category_id, 1, $columns, $count);
}

function alsp_renderSubLocations($parent_location_slug = '', $columns = 2, $count = false) {
	if ($parent_location = alsp_get_term_by_path($parent_location_slug))
		$parent_location_id = $parent_location->term_id;
	else
		$parent_location_id = 0;
	
	alsp_renderAllLocations($parent_location_id, 1, $columns, $count);
}

function alsp_terms_checklist($post_id) {
	if ($terms = get_categories(array('taxonomy' => ALSP_CATEGORIES_TAX, 'pad_counts' => true, 'hide_empty' => false, 'parent' => 0))) {
		$checked_categories_ids = array();
		$checked_categories = wp_get_object_terms($post_id, ALSP_CATEGORIES_TAX);
		foreach ($checked_categories AS $term)
			$checked_categories_ids[] = $term->term_id;

		echo '<ul id="alsp-categorychecklist" class="alsp-categorychecklist">';
		foreach ($terms AS $term) {
			$checked = '';
			if (in_array($term->term_id, $checked_categories_ids))
				$checked = 'checked';
				
			echo '
<li id="' . ALSP_CATEGORIES_TAX . '-' . $term->term_id . '">';
			echo '<label class="alsp-parent-cat selectit"><input type="checkbox" ' . $checked . ' id="in-' . ALSP_CATEGORIES_TAX . '-' . $term->term_id . '" name="tax_input[' . ALSP_CATEGORIES_TAX . '][]" value="' . $term->term_id . '"> ' . $term->name . '<span class="radio-check-item"></span></label>';
			echo _alsp_terms_checklist($term->term_id, $checked_categories_ids);
			echo '</li>';
		}
		echo '</ul>';
	}
}
function _alsp_terms_checklist($parent = 0, $checked_categories_ids = array()) {
	$html = '';
	if ($terms = get_categories(array('taxonomy' => ALSP_CATEGORIES_TAX, 'pad_counts' => true, 'hide_empty' => false, 'parent' => $parent))) {
		$html .= '<ul class="children">';
		foreach ($terms AS $term) {
			$checked = '';
			if (in_array($term->term_id, $checked_categories_ids))
				$checked = 'checked';

			$html .= '
<li id="' . ALSP_CATEGORIES_TAX . '-' . $term->term_id . '">';
			$html .= '<label class="selectit"><input type="checkbox" ' . $checked . ' id="in-' . ALSP_CATEGORIES_TAX . '-' . $term->term_id . '" name="tax_input[' . ALSP_CATEGORIES_TAX . '][]" value="' . $term->term_id . '"> ' . $term->name . '<span class="radio-check-item"></span></label>';
			$html .= _alsp_terms_checklist($term->term_id);
			$html .= '</li>';
		}
		$html .= '</ul>';
	}
	return $html;
}

function alsp_tags_selectbox($post_id) {
	$terms = get_categories(array('taxonomy' => ALSP_TAGS_TAX, 'pad_counts' => true, 'hide_empty' => false));
	$checked_tags_ids = array();
	$checked_tags_names = array();
	$checked_tags = wp_get_object_terms($post_id, ALSP_TAGS_TAX);
	foreach ($checked_tags AS $term) {
		$checked_tags_ids[] = $term->term_id;
		$checked_tags_names[] = $term->name;
	}

	echo '<select name="' . ALSP_TAGS_TAX . '[]" multiple="multiple" class="alsp-tokenizer">';
	foreach ($terms AS $term) {
		$checked = '';
		if (in_array($term->term_id, $checked_tags_ids))
			$checked = 'selected';
		echo '<option value="' . esc_attr($term->name) . '" ' . $checked . '>' . $term->name . '</option>';
	}
	echo '</select>';
}

function alsp_categoriesOfLevels($allowed_levels = array()) {
	global $alsp_instance;
	
	$allowed_categories = array();
	foreach ((array) $allowed_levels AS $level_id) {
		if (isset($alsp_instance->levels->levels_array[$level_id])) {
			$level = $alsp_instance->levels->levels_array[$level_id];
			$allowed_categories = array_merge($allowed_categories, $level->categories);
		}
	}
	
	return $allowed_categories;
}

function alsp_renderAllCategories($parent = 0, $depth = 2, $columns = 2, $count = false, $subcats = 0, $cat_style = 1, $cat_icon_type = 1, $scroll = 0, $desktop_items = 3, $tab_landscape_items = 3, $tab_items = 2, $autoplay = true, $loop = true, $owl_nav = 'false', $delay = 1000, $autoplay_speed = 1000, $gutter = 30, $allowed_levels = array(), $exact_categories = array()) {
	global $ALSP_ADIMN_SETTINGS;
	
	if ($depth > 2){
		$depth = 2;
	}elseif($depth == 0 || !is_numeric($depth)){
		$depth = 1;
	}
	if ($columns > 4){
		$columns = 4;
	}elseif ($columns == 0 || !is_numeric($columns)){
		$columns = 'inline';
	}
	$cat_icon_type_set = (isset($cat_icon_type )) ? $ALSP_ADIMN_SETTINGS['cat_icon_type'] : '';
	$allowed_categories = implode(',', alsp_categoriesOfLevels($allowed_levels));
	$cat_style = $cat_style;
	// we use array_merge with empty array because we need to flush keys in terms array
	if ($count){
		$terms = array_merge(
			// there is a wp bug with pad_counts in get_terms function - so we use this construction
			wp_list_filter(
				get_categories(array(
					'taxonomy' => ALSP_CATEGORIES_TAX,
					'pad_counts' => true,
					'hide_empty' => false,
					// filter terms by listings levels
					'include' => $allowed_categories,
				)),
				array('parent' => $parent)
			), array());
	}else{
		$terms = array_merge(
			get_categories(array(
				'taxonomy' => ALSP_CATEGORIES_TAX,
				'pad_counts' => false,
				'hide_empty' => false,
				'parent' => $parent,
				// filter terms by listings levels
				'include' => $allowed_categories,
			)), array());
	}
	global $post;
	if ($terms) {
		echo '<div class="cat-style-'.$cat_style.' alsp-content alsp-categories-columns alsp-categories-columns-' . $columns . '">';
		
			if ($owl_nav == 'true') {
				echo '<div class="cat-scroll-header">'.esc_html__('Browse category', 'ALSP').'</div>';
			}
			
			$terms_count = count($terms);
			$counter = 0;
			$tcounter = 0;
			if($scroll == 1){
				echo '<div class="alsp-categories-row owl-carousel" data-items="'.$desktop_items.'" data-items-tab-ls="'. $tab_landscape_items.'" data-items-tab="'. $tab_items.'" data-autoplay="'.$autoplay.'" data-loop="true" data-nav="'.$owl_nav.'" data-delay="'.$delay.'" data-autoplay-speed="'.$autoplay_speed.'" data-gutter="'.$gutter.'">';
			}
			
			foreach ($terms AS $key=>$term) {
				$term_children = get_term_children($term->term_id, ALSP_CATEGORIES_TAX);
			
				$term_children_slugs = array();
				if (is_array($term_children)){
					foreach ($term_children AS $term_id) {
						$term_child = get_term($term_id, ALSP_CATEGORIES_TAX);
						$term_children_slugs[] = $term_child->slug;
					}
				}
				if (!$exact_categories || (in_array($term->term_id, $exact_categories) || in_array($term->slug, $exact_categories)) || (is_array($term_children) && (array_intersect($exact_categories, $term_children) || array_intersect($exact_categories, $term_children_slugs)))) {
				
					$tcounter++;
					$image_id = get_term_meta ($term->term_id, 'category-image-id', true);
					$bg_image = wp_get_attachment_image_src( $image_id, 'full' );
					
					if ($count){
						if ($cat_style == 5){
							$term_count = $term->count.' '. esc_html__('ads', 'ALSP');
						}elseif($cat_style == 6){
							$term_count = $term->count;
						}else{
							$term_count = " ($term->count)";
						}
					}else{
						$term_count = '';
					}
				
					if($cat_color_set = alsp_getCategorycolor($term->term_id)){
						if($cat_style == 6){
							$cat_color = 'style="background-color:'.$cat_color_set.';"';
						}else{
							$cat_color = 'style="color:'.$cat_color_set.';"';	
						}
					}else{
						if($cat_style == 6){
							global $pacz_settings;
							$cat_color = $pacz_settings['accent-color'];
						}else{
							$cat_color = '';
						}
					}
					if($cat_icon_type_set == 1){
						if($cat_maker_icon = alsp_getCategoryMarkerIcon($term->term_id)){
							$icon_image = '<span class="cat-icon font-icon '.$cat_maker_icon.'" '.$cat_color.'></span>';
						}else{
							$icon_image = '<span class="cat-icon empty-icon"></span>';
						}
					
					}elseif($cat_icon_type_set == 2) {
						if ($icon_file = alsp_getCategoryIcon($term->term_id)){
							if ($cat_style == 2){
								$icon_image = '<span class="cat-icon" style="background-image:url('.esc_url($bg_image[0]).');"><img class="alsp-field-icon" src="' . ALSP_CATEGORIES_ICONS_URL . $icon_file . '" alt="'.$term->name.'" /></span>';
							}else{
								$icon_image = '<span class="cat-icon"><img class="alsp-field-icon" src="' . ALSP_CATEGORIES_ICONS_URL . $icon_file . '" alt="'.$term->name.'" /></span>';
							}
						}else{
							$icon_image = '<span class="cat-icon empty-icon image_icon "></span>';
						}
					}elseif($cat_icon_type_set == 3){
						$icon_image_code = get_term_meta ($term->term_id, 'category-svg-icon-id', true);
						$icon_image = '<span class="cat-icon svg_icon">'.$icon_image_code.'</span>';
					}else{
						$icon_image = '<span class="cat-icon empty-icon"></span>';
					}
					if ( count( get_term_children( $term->term_id, ALSP_CATEGORIES_TAX ) ) > 0 ) {
						$more_cat_icon = '<i class="pacz-fic4-more" data-popup-open="' . $term->term_id .'"></i>';
					}else{
						$more_cat_icon = '';
					}
				 
					if ($counter == 0 && $scroll == 0){
						echo '<div class="alsp-categories-row ' . (($columns == 1) ? 'alsp-categories-row-one-column': '') . ' clearfix">';
					}
					/* -----category wrapper column Div ----*/
					echo '<div class="alsp-categories-column alsp-categories-column-' . $columns . '">';
						
						/* -----category wrapper div ----*/
						echo '<div class="alsp-categories-column-wrapper clearfix">';		
							if ($cat_style == 1){
								echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $icon_image . $term->name .'<span class="categories-count">'.$term_count. '</span></a></div>';
							}elseif ($cat_style == 2){
								echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $icon_image . $term->name .'<span class="categories-count">'.$term_count. '</span></a></div>';
							}elseif ($cat_style == 3){
								echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $icon_image .'<span class="categories-name">'. $term->name .'</span><span class="categories-count">'.$term_count. '</span></a></div>';
							}elseif ($cat_style == 4){
								echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $icon_image . $term->name .'<span class="categories-count">'.$term_count. '</span></a></div>';
							}elseif ($cat_style == 5){
								echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $icon_image . $term->name .'<span class="categories-count">'.$term_count. $more_cat_icon.'</span></a></div>';
							}elseif ($cat_style == 6){
								echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $icon_image .'<span class="categories-name">'. $term->name .'</span><span class="categories-count">'.$term_count. '</span></a></div>';
							}elseif ($cat_style == 7){
								echo '<div class="cat-7-icon">' . $icon_image .'</div>';
								echo '<div class="cat-7-content">';
									echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '"><span class="categories-name">'. $term->name .'</span><span class="categories-count">'.$term_count. '</span></a></div>';
									echo _alsp_renderAllCategories($term->term_id, $depth, 1, $count, $subcats, $allowed_categories, $exact_categories);
								echo '</div>';
							}elseif ($cat_style == 8){
								echo '<div class="alsp-categories-root"><a href="' . get_term_link($term) . '" title="' . $term->name . '">' . $icon_image .'<span class="categories-name">'. $term->name .'</span><span class="categories-count">'.$term_count. '</span></a></div>';
							}
							if ($cat_style == 3 || $cat_style == 6){
								echo _alsp_renderAllCategories($term->term_id, $depth, 1, $count, $subcats, $cat_style, $allowed_categories, $exact_categories);
							}
						echo '</div>';
						/* -----End category wrapper div ----*/
						$counter++;
						/* -----Start popup----*/
						if ($cat_style == 3 || $cat_style == 5 || $cat_style == 6 || $cat_style == 7){
							echo '<div class="popup" data-popup="' . $term->term_id . '">';
								echo '<div class="popup-inner">';
									echo '<div class="sub-level-cat"><div class="categories-title">'.esc_html__('Select your Category', 'ALSP').'<a class="popup-close" data-popup-close="' . $term->term_id . '" href="#"><i class="pacz-fic4-error"></i></a></div><ul class="cat-sub-main-ul clearfix">';
										
											wp_list_categories( array(
												'orderby'            => 'name',
												'show_count'         => true,
												'use_desc_for_title' => false,
												'child_of'           => $term->term_id,
												'hide_empty' => false,
												'taxonomy'           => ALSP_CATEGORIES_TAX,
												'title_li' => ''
											) ); 
											 
									echo '</ul></div>';
								echo '</div>';
							echo '</div>';
						}
						/* -----End popup----*/
					echo '</div>';
					/* -----End category wrapper column Div ----*/
					if ($counter == 0 && $scroll == 0){
						echo '</<div>';
					}
					/* -----End category  ----*/
				}
			} //End Foreach
			if($scroll == 1){
				echo '</div>';
			}
			/*End Scroller*/
			
		echo '</div></div>';
		/*End Parent divs*/
	}
}
function _alsp_renderAllCategories($parent = 0, $depth = 2, $level = 0, $count = false, $subcats = 0, $cat_style = 1, $allowed_categories = array(), $exact_categories = array()) {
	if ($count)
		// there is a wp bug with pad_counts in get_terms function - so we use this construction
		$terms = wp_list_filter(
				get_categories(array(
						'taxonomy' => ALSP_CATEGORIES_TAX,
						'pad_counts' => true,
						'hide_empty' => false,
						// filter terms by listings levels
						'include' => $allowed_categories,
				)),
				array('parent' => $parent)
		);
	else
		$terms = get_categories(array(
				'taxonomy' => ALSP_CATEGORIES_TAX,
				'pad_counts' => true,
				'hide_empty' => false,
				'parent' => $parent,
				// filter terms by listings levels
				'include' => $allowed_categories,
		));

	$html = '';
	if ($terms && ($depth == 0 || !is_numeric($depth) || $depth > $level)) {
		$level++;
		$counter = 0;
		$html .= '<div class="subcategories">';
		$html .= '<ul>';
		foreach ($terms AS $term) {
			if (!$exact_categories || (in_array($term->term_id, $exact_categories) || in_array($term->slug, $exact_categories))) {
				if ($count)
					$term_count = " ($term->count)";
				else
					$term_count = '';
	
				if ($icon_file = alsp_getCategoryIcon($term->term_id))
					$icon_image = '<img class="alsp-field-icon" src="' . ALSP_CATEGORIES_ICONS_URL . $icon_file . '" />';
				else
					$icon_image = '';
	
				$counter++;
				if($cat_style == 6){
					if ($subcats != 0 && ($counter == $subcats || $counter > $subcats) ) {
						$html .= '<li>';
						$html .='<a class="view-all-btn" data-popup-open="' . $parent . '" href="#">' . __('View all', 'ALSP') .'</a>';
						$html .= '</li>';
						break;
					} else{
						  if ( count( get_term_children( $term->term_id, ALSP_CATEGORIES_TAX ) ) > 0 ) {
						/* pacz customized*/
						$html .= '<li><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .' <span>'. $term_count . '</span></a>';
							
						$html .='</li>';
						  }else{
							$html .= '<li><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .' <span>'. $term_count . '</span></a></li>';  
						  }
					}
				}else{
					if ($subcats != 0 && $counter > $subcats) {
						$html .= '<li>';
						$html .='<a class="view-all-btn" data-popup-open="' . $parent . '" href="#">' . __('View all', 'ALSP') .'</a>';
						$html .= '</li>';
						break;
					} else{
						  if ( count( get_term_children( $term->term_id, ALSP_CATEGORIES_TAX ) ) > 0 ) {
						/* pacz customized*/
						$html .= '<li><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .' <span>'. $term_count . '</span></a>';
							
						$html .='</li>';
						  }else{
							$html .= '<li><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .' <span>'. $term_count . '</span></a></li>';  
						  }
					}
				}
			}
		}
		$html .= '</ul>';
			
		$html .= '</div>';
	}
	return $html;
}

function alsp_renderAllLocations($parent = 0, $location_style = 0, $depth = 2, $columns = 1, $count = 0, $max_sublocations = 0, $location_bg = '#333', $location_bg_image = '', $gradientbg1 = '', $gradientbg2 = '', $opacity1 = '', $opacity2 = '', $gradient_angle = '', $location_width = 30, $location_height = 300, $location_padding = 15, $exact_locations = array()) {
	

	$id = uniqid();

$responsive_width = $location_width;
$responsive_height = $location_height / 2;
global $alsp_dynamic_styles;
$alsp_styles = '';
if ( $location_padding  ) {
   $alsp_styles .= '
	    .alsp-masonry-grid{
			margin:-'.$location_padding.'px;
			box-sizing: border-box;
		}
		.alsp-masonry-grid:after,.alsp-masonry-grid:before{
			clear:both;
			content:"";
			display:table;
		}
        ';
}
if ( $location_style) {
	$opacitybg1 = '0.'.$opacity1;
	$opacitybg2 = '0.'.$opacity2;
	$gradient_bg_color1 = pacz_convert_rgba($gradientbg1, $opacitybg1);
	$gradient_bg_color2 = pacz_convert_rgba($gradientbg2, $opacitybg2);
    $alsp_styles .= '
.alsp-locations-column-wrapper{background-size:cover !important;}	
.alsp-locations-column-wrapper-inner{transition:all 0.5s ease;}
#loaction-styles'.$id.'.location-style1 .alsp-locations-column-wrapper:hover .alsp-locations-column-wrapper-inner,
#loaction-styles'.$id.'.location-style2 .alsp-locations-column-wrapper:hover .alsp-locations-column-wrapper-inner,
#loaction-styles'.$id.'.location-style3 .alsp-locations-column-wrapper:hover .alsp-locations-column-wrapper-inner,
#loaction-styles'.$id.'.location-style5 .alsp-locations-column-wrapper:hover .alsp-locations-column-wrapper-inner,
#loaction-styles'.$id.'.location-style6 .alsp-locations-column-wrapper:hover .alsp-locations-column-wrapper-inner,
#loaction-styles'.$id.'.location-style7 .alsp-locations-column-wrapper:hover .alsp-locations-column-wrapper-inner {
	background: -webkit-linear-gradient('.$gradient_angle.'deg, '.$gradient_bg_color1.', '.$gradient_bg_color2.') !important;
	background: -moz-linear-gradient('.$gradient_angle.'deg, '.$gradient_bg_color1.', '.$gradient_bg_color2.') !important;
	background: -o-linear-gradient('.$gradient_angle.'deg, '.$gradient_bg_color1.', '.$gradient_bg_color2.') !important;
	background: -ms-linear-gradient('.$gradient_angle.'deg, '.$gradient_bg_color1.', '.$gradient_bg_color2.') !important;
	background: linear-gradient('.$gradient_angle.'deg, '.$gradient_bg_color1.', '.$gradient_bg_color2.') !important;
	transition:all 2.5s ease;
}

    ';
}
if(!empty($location_bg_image)){
				$locationbg = 'url('.$location_bg_image.')';
			}else{
				$locationbg = $location_bg;
			}
$gradient_bg_color3 = 'rgba(0,0,0,0)';
$gradient_bg_color4 = 'rgba(0,0,0,0)';
$alsp_styles .= '
#loaction-styles'.$id.'.alsp-locations-columns.location-style1 .alsp-locations-column-wrapper,
#loaction-styles'.$id.'.alsp-locations-columns.location-style2 .alsp-locations-column-wrapper,
#loaction-styles'.$id.'.alsp-locations-columns.location-style3 .alsp-locations-column-wrapper,
#loaction-styles'.$id.'.alsp-locations-columns.location-style5 .alsp-locations-column-wrapper,
#loaction-styles'.$id.'.alsp-locations-columns.location-style6 .alsp-locations-column-wrapper,
#loaction-styles'.$id.'.alsp-locations-columns.location-style7 .alsp-locations-column-wrapper{ 
	background:'.$locationbg.';
	height:100%;
	
}
#loaction-styles'.$id.'.alsp-locations-columns.location-style10 .alsp-locations-column-wrapper .alsp-locations-column-holder{ 
	background:'.$locationbg.';
	height:100%;
	transform:scale(1);
	transition:all 0.3s ease;
}
#loaction-styles'.$id.'.alsp-locations-columns.location-style10 .alsp-locations-column-wrapper{
	overflow:hidden;
	height:100%;
}
#loaction-styles'.$id.'.alsp-locations-columns.location-style10 .alsp-locations-column-wrapper .alsp-locations-column-holder .alsp-locations-column-wrapper-inner{
	transform:scale(1);
	height:100%;
	text-align:center;
}
#loaction-styles'.$id.'.alsp-locations-columns.location-style10 .alsp-locations-column-wrapper:hover .alsp-locations-column-holder .alsp-locations-column-wrapper-inner{
	transform:scale(1);
	height:100%;
	text-align:center;
}
#loaction-styles'.$id.'.location-style1.grid-item,
#loaction-styles'.$id.'.location-style2.grid-item,
#loaction-styles'.$id.'.location-style3.grid-item,
#loaction-styles'.$id.'.location-style5.grid-item,
#loaction-styles'.$id.'.location-style6.grid-item,
#loaction-styles'.$id.'.location-style7.grid-item,
#loaction-styles'.$id.'.location-style10.grid-item{
	width:'.$location_width.'%;
	height:'.$location_height.'px;
	float:left;
}
.location-style4.alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a:before,
.listings.location-archive .alsp-locations-columns .alsp-locations-column-wrapper  .alsp-locations-root a:before{
	background-image: url("'.ALSP_RESOURCES_URL .'images/alsp-location-icon.png");
}
.widget #loaction-styles'.$id.'.grid-item{
	width:100% !important;
	height:100% !important;
}
@media screen and (max-width:480px) {

}
.widget #loaction-styles'.$id.'.location-style1 .alsp-locations-column-wrapper .alsp-locations-column-wrapper-inner,
.widget #loaction-styles'.$id.'.location-style2 .alsp-locations-column-wrapper .alsp-locations-column-wrapper-inner,
.widget #loaction-styles'.$id.'.location-style3 .alsp-locations-column-wrapper .alsp-locations-column-wrapper-inner,
.widget #loaction-styles'.$id.'.location-style4 .alsp-locations-column-wrapper .alsp-locations-column-wrapper-inner,
.widget #loaction-styles'.$id.' .alsp-locations-column-wrapper{
	background: -webkit-linear-gradient(0deg, '.$gradient_bg_color3.', '.$gradient_bg_color4.') !important;
	background: -moz-linear-gradient(0deg, '.$gradient_bg_color3.', '.$gradient_bg_color4.') !important;
	background: -o-linear-gradient(0deg, '.$gradient_bg_color3.', '.$gradient_bg_color4.') !important;
	background: -ms-linear-gradient(0deg, '.$gradient_bg_color3.', '.$gradient_bg_color4.') !important;
	background: linear-gradient(0deg, '.$gradient_bg_color3.', '.$gradient_bg_color4.') !important;
	transition:all 2.5s ease;
}
.widget #loaction-styles'.$id.'{padding:0 !important;}
.alsp-masonry-grid .grid-sizer{
	width:'.$location_width.'%;
}

#loaction-styles'.$id.'.alsp-locations-columns.location-style10 .alsp-locations-column-wrapper:hover .alsp-locations-column-holder{
	transform:scale(1.05);
	transition:all 0.3s ease;
}
    ';

	if ($depth > 2)
		$depth = 2;
	if ($depth == 0 || !is_numeric($depth))
		$depth = 1;
	if ($columns > 4)
		$columns = 4;
	if ($columns == 0 || !is_numeric($columns))
		$columns = 1;

	// we use array_merge with empty array because we need to flush keys in terms array
	if ($count)
		$terms = array_merge(
			// there is a wp bug with pad_counts in get_terms function - so we use this construction
			wp_list_filter(
					get_categories(array(
							'taxonomy' => ALSP_LOCATIONS_TAX,
							'pad_counts' => true,
							'hide_empty' => false,
					)),
					array('parent' => $parent)
			), array());
	else
		$terms = array_merge(
			get_categories(array(
					'taxonomy' => ALSP_LOCATIONS_TAX,
					'pad_counts' => true,
					'hide_empty' => false,
					'parent' => $parent,
			)), array());
	 
	 global $post;
	if ($terms && $location_style != 0 && (!has_shortcode($post->post_content, 'webdirectory')) && (!has_shortcode($post->post_content, 'webdirectory-listing'))) {
		//echo '<div class="grid-sizer"></div>';
		echo '<div id="loaction-styles'.$id.'" class="location-style'.$location_style.' grid-item alsp-locations-columns alsp-locations-columns-' . $columns . ' clearfix"  style="padding:'.$location_padding.'px;">';
		$terms_count = count($terms);
		$counter = 0;
		$tcounter = 0;
		
		foreach ($terms AS $key=>$term) {
			$term_children = get_term_children($term->term_id, ALSP_LOCATIONS_TAX);
			$term_children_slugs = array();
			
			if (is_array($term_children))
				foreach ($term_children AS $term_id) {
					$term_child = get_term($term_id, ALSP_LOCATIONS_TAX);
					$term_children_slugs[] = $term_child->slug;
				}
			if (!$exact_locations || (in_array($term->term_id, $exact_locations) || in_array($term->slug, $exact_locations)) || (is_array($term_children) && (array_intersect($exact_locations, $term_children) || array_intersect($exact_locations, $term_children_slugs)))) {
				$tcounter++;
				if ($counter == 0)
					
				if ($count && $location_style != 2)
					$term_count = " ($term->count)";
				elseif ($count )
					$term_count = " $term->count";
				else	
					$term_count = '';
	
				if ($icon_file = alsp_getLocationIcon($term->term_id))
					if($location_style == 7){
						$icon_image = '';
					}else{
						$icon_image = '<span class="location-icon"><i class="pacz-icon-map-marker"></i></span>';
					}
				else
					$icon_image = '';
				
				echo '<div class="alsp-locations-column-wrapper">';
				if($location_style == 10){
					echo '<div class="alsp-locations-column-holder">';
				}
				echo '<div class="alsp-locations-column-wrapper-inner" style=""><i class="location-plus-icon pacz-fic4-more" data-popup-open="' . $term->term_id . '"></i>';
				
				if($location_style == 1){
					echo '<div class="alsp-locations-root"><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .'<span class="location-count">'.$term_count . '</span></a></div>';
				} elseif($location_style == 2 || $location_style == 3){
					echo '<div class="alsp-locations-root"><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '"><span class="location-count">'.$term_count . esc_html__(' ads', 'alsp').'</span><span class="loaction-name">' . $icon_image . $term->name .'</span></a></div>';
				}else{
					echo '<div class="alsp-locations-root"><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .'<span class="location-count">'.$term_count . '</span></a></div>';
				}
				echo '<div class="popup" data-popup="' . $term->term_id . '">';
							echo '<div class="popup-inner">';
								echo '<div class="sub-level-cat"><div class="categories-title">'.esc_html__('Select your Location', 'ALSP').'<a class="popup-close" data-popup-close="' . $term->term_id . '" href="#"><i class="pacz-fic4-error"></i></a></div><ul class="loc-sub-main-ul clearfix">';
									
										wp_list_categories( array(
											'orderby' => 'name',
											'show_count' => true,
											'use_desc_for_title' => false,
											'child_of' => $term->term_id,
											'hide_empty' => false,
											'taxonomy' => ALSP_LOCATIONS_TAX,
											'title_li' => ''
										) ); 
										 
								echo '</ul>';
							echo '</div>';
							
						echo '</div>';
				echo '</div>';
				echo _alsp_renderAllLocations($term->term_id, $depth, 1, $count, $max_sublocations, $exact_locations);
				
				
				echo '</div>';
				if($location_style == 10){
					echo '</div>';
				}
				echo '</div>';
				
	
				$counter++;
				if ($counter == $columns)
					
				if ($tcounter == $terms_count && $counter != $columns) {
					while ($counter != $columns) {
						echo '<div class="alsp-locations-column alsp-locations-column-' . $columns . ' alsp-locations-column-hidden"></div>';
						$counter++;
					}
					echo '</div>';
					
				}
				if ($counter == $columns) $counter = 0;
			}
			
		}
		echo '</div>';
		
	}else{
		echo '<div class="grid-sizer"></div>';
		echo '<div class=" grid-item alsp-locations-columns alsp-locations-columns-' . $columns . ' clearfix" >';
		$terms_count = count($terms);
		$counter = 0;
		$tcounter = 0;
		
		foreach ($terms AS $key=>$term) {
			$term_children = get_term_children($term->term_id, ALSP_LOCATIONS_TAX);
			$term_children_slugs = array();
			
			if (is_array($term_children))
				foreach ($term_children AS $term_id) {
					$term_child = get_term($term_id, ALSP_LOCATIONS_TAX);
					$term_children_slugs[] = $term_child->slug;
				}
			if (!$exact_locations || (in_array($term->term_id, $exact_locations) || in_array($term->slug, $exact_locations)) || (is_array($term_children) && (array_intersect($exact_locations, $term_children) || array_intersect($exact_locations, $term_children_slugs)))) {
				$tcounter++;
				//if ($counter == 0)
					
				if ($location_style != 2){
					$term_count = " ($term->count)";
				}else{
					$term_count = "$term->count";
				}
	
				if ($icon_file = alsp_getLocationIcon($term->term_id))
					$icon_image = '<span class="location-icon"><img class="alsp-field-icon" src="' . ALSP_LOCATIONS_ICONS_URL . $icon_file . '" /></span>';
				else
					$icon_image = '';
				
				echo '<div class="alsp-locations-column-wrapper"><div class="alsp-locations-column-wrapper-inner">';
				if($location_style == 1){
					echo '<div class="alsp-locations-root"><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .'<span class="location-count">'.$term_count . '</span></a></div>';
				} elseif($location_style == 2 || $location_style == 3){
					echo '<div class="alsp-locations-root"><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '"><span class="location-count">'.$term_count . esc_html__(' ads', 'alsp').'</span><span class="loaction-name">' . $icon_image . $term->name .'</span></a></div>';
				}else{
					echo '<div class="alsp-locations-root"><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name .'<span class="location-count">'.$term_count . '</span></a></div>';
				}
				echo _alsp_renderAllLocations($term->term_id, $depth, 1, $count, $max_sublocations, $exact_locations);
				echo '</div></div>';
	
				$counter++;
				if ($counter == $columns)
					
				if ($tcounter == $terms_count && $counter != $columns) {
					while ($counter != $columns) {
						echo '<div class="alsp-locations-column alsp-locations-column-' . $columns . ' alsp-locations-column-hidden"></div>';
						$counter++;
					}
					echo '</div>';
					
				}
				if ($counter == $columns) $counter = 0;
			}
		}
		echo '</div>';
	}
// Hidden styles node for head injection after page load through ajax
echo '<div id="ajax-'.$id.'" class="alsp-dynamic-styles">';
echo '</div>';


// Export styles to json for faster page load
$alsp_dynamic_styles[] = array(
  'id' => 'ajax-'.$id ,
  'inject' => $alsp_styles
);
	
}
function _alsp_renderAllLocations($parent = 0, $depth = 2, $level = 0, $count = false, $max_sublocations = 0, $location_bg = '#333', $loaction_width = 30, $location_height = 300, $exact_locations = array()) {
	if ($count)
		// there is a wp bug with pad_counts in get_terms function - so we use this construction
		$terms = wp_list_filter(
				get_categories(array(
						'taxonomy' => ALSP_LOCATIONS_TAX,
						'pad_counts' => true,
						'hide_empty' => false,
				)),
				array('parent' => $parent)
		);
	else
		$terms = get_categories(array(
				'taxonomy' => ALSP_LOCATIONS_TAX,
				'pad_counts' => true,
				'hide_empty' => false,
				'parent' => $parent,
		));

	$html = '';
	if ($terms && ($depth == 0 || !is_numeric($depth) || $depth > $level)) {
		$level++;
		$counter = 0;
		$html .= '<div class="sublocations">';
		$html .= '<ul>';
		foreach ($terms AS $term) {
			if (!$exact_locations || (in_array($term->term_id, $exact_locations) || in_array($term->slug, $exact_locations))) {
				if ($count)
					$term_count = " ($term->count)";
				else
					$term_count = '';
	
				if ($icon_file = alsp_getLocationIcon($term->term_id))
					$icon_image = '<img class="alsp-field-icon" src="' . ALSP_LOCATIONS_ICONS_URL . $icon_file . '" />';
				else
					$icon_image = '';
	
				$counter++;
				if ($max_sublocations != 0 && $counter > $max_sublocations) {
					$html .= '<li><a href="' . get_term_link(intval($parent), ALSP_LOCATIONS_TAX) . '">' . __('View all sublocations ->', 'ALSP') . '</a></li>';
					break;
				} else
					$html .= '<li><a href="' . get_term_link($term) . '" title="' . $term->name .$term_count . '">' . $icon_image . $term->name . $term_count . '</a></li>';
			}
		}
		$html .= '</ul>';
		$html .= '</div>';
	}
	return $html;
}

function alsp_getCategoryIcon($term_id) {
	global $alsp_instance;
	
	if ($icon_file = $alsp_instance->categories_manager->getCategoryIconFile($term_id))
		return $icon_file;
}

function alsp_getCategoryIcon2($term_id) {
	global $alsp_instance;
	
	if ($icon_file = $alsp_instance->categories_manager->getCategoryIconFile2($term_id))
		return $icon_file;
}
function alsp_getCategorycolor($term_id) {
	global $alsp_instance;
	
	if ($cat_bg_color = $alsp_instance->categories_manager->getCategoryMarkerColor($term_id))
		return $cat_bg_color;
}
function alsp_getCategoryMarkerIcon($term_id) {
	global $alsp_instance;
	
	if ($cat_maker_icon = $alsp_instance->categories_manager->getCategoryMarkerIcon($term_id))
		return $cat_maker_icon;
}
function alsp_getLocationIcon($term_id) {
	global $alsp_instance;
	
	if ($icon_file = $alsp_instance->locations_manager->getLocationIconFile($term_id))
		return $icon_file;
}

function alsp_show_404() {
	status_header(404);
	nocache_headers();
	include(get_404_template());
	exit;
}

function alsp_login_form($args = array()) {
	$defaults = array(
			'redirect' => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], // Default redirect is back to the current page
			'form_id' => 'loginform',
			'label_username' => __( 'Username' ),
			'label_password' => __( 'Password' ),
			'label_remember' => __( 'Remember Me' ),
			'label_log_in' => __( 'Log In' ),
			'id_username' => 'user_login',
			'id_password' => 'user_pass',
			'id_remember' => 'rememberme',
			'id_submit' => 'wp-submit',
			'remember' => true,
			'value_username' => '',
			'value_remember' => false, // Set this to true to default the "Remember me" checkbox to checked
	);
	$args = wp_parse_args($args, apply_filters( 'login_form_defaults', $defaults));
	
	echo '<div class="alsp-content">';
	
	echo '
		<form name="' . $args['form_id'] . '" id="' . $args['form_id'] . '" action="' . esc_url( site_url( 'wp-login.php', 'login_post' ) ) . '" method="post" class="alsp_login_form" role="form">
			' . apply_filters( 'login_form_top', '', $args ) . '
			<p class="form-group">
				<label for="' . esc_attr( $args['id_username'] ) . '">' . esc_html( $args['label_username'] ) . '</label>
				<input type="text" name="log" id="' . esc_attr( $args['id_username'] ) . '" class="form-control" value="' . esc_attr( $args['value_username'] ) . '" />
			</p>
			<p class="login-password">
				<label for="' . esc_attr( $args['id_password'] ) . '">' . esc_html( $args['label_password'] ) . '</label>
				<input type="password" name="pwd" id="' . esc_attr( $args['id_password'] ) . '" class="form-control" value="" />
			</p>
			' . apply_filters( 'login_form_middle', '', $args ) . '
			' . ( $args['remember'] ? '<p class="checkbox"><label><input name="rememberme" type="checkbox" id="' . esc_attr( $args['id_remember'] ) . '" value="forever"' . ( $args['value_remember'] ? ' checked="checked"' : '' ) . ' /> ' . esc_html( $args['label_remember'] ) . '</label></p>' : '' ) . '
			<p class="login-submit">
				<input type="submit" name="wp-submit" id="' . esc_attr( $args['id_submit'] ) . '" class="btn btn-primary" value="' . esc_attr( $args['label_log_in'] ) . '" />
				<input type="hidden" name="redirect_to" value="' . esc_url( $args['redirect'] ) . '" />
			</p>
			' . apply_filters( 'login_form_bottom', '', $args ) . '
		</form>';

	do_action('login_form');
	do_action('login_footer');
	echo '<p id="nav">';
	if (get_option('users_can_register'))
		echo '<a href="' . esc_url( wp_registration_url() ) . '" rel="nofollow">' . __('Register', 'ALSP') . '</a> | ';

	echo '<a title="' . esc_attr__('Password Lost and Found', 'ALSP') . '" href="' . esc_url( wp_lostpassword_url() ) . '">' . __('Lost your password?', 'ALSP') . '</a>';
	echo '</p>';

	echo '</div>';
}


if (!function_exists('alsp_renderPaginator')) {
	function alsp_renderPaginator($query, $hash = null, $show_more_button = false) {
		if (get_class($query) == 'WP_Query') {
			if (get_query_var('page'))
				$paged = get_query_var('page');
			elseif (get_query_var('paged'))
				$paged = get_query_var('paged');
			else
				$paged = 1;

			$total_pages = $query->max_num_pages;
			$total_lines = ceil($total_pages/10);
		
			if ($total_pages > 1){
				$current_page = max(1, $paged);
				$current_line = floor(($current_page-1)/10) + 1;
		
				$previous_page = $current_page - 1;
				$next_page = $current_page + 1;
				$previous_line_page = floor(($current_page-1)/10)*10;
				$next_line_page = ceil($current_page/10)*10 + 1;
				
				if (!$show_more_button) {
					echo '<div class="alsp-pagination-wrapper">';
					echo '<ul class="pagination">';
					if ($total_pages > 10 && $current_page > 10)
						echo '<li class="alsp-inactive previous_line"><a href="' . get_pagenum_link($previous_line_page) . '" title="' . esc_attr__('Previous Line', 'ALSP') . '" data-page=' . $previous_line_page . ' data-controller-hash=' . $hash . '><<</a></li>' ;
			
					if ($total_pages > 3 && $current_page > 1)
						echo '<li class="alsp-inactive previous"><a href="' . get_pagenum_link($previous_page) . '" title="' . esc_attr__('Previous Page', 'ALSP') . '" data-page=' . $previous_page . ' data-controller-hash=' . $hash . '><</i></a></li>' ;
			
					$count = ($current_line-1)*10;
					$end = ($total_pages < $current_line*10) ? $total_pages : $current_line*10;
					while ($count < $end) {
						$count = $count + 1;
						if ($count == $current_page)
							echo '<li class="active"><a href="' . get_pagenum_link($count) . '">' . $count . '</a></li>' ;
						else
							echo '<li class="alsp-inactive"><a href="' . get_pagenum_link($count) . '" data-page=' . $count . ' data-controller-hash=' . $hash . '>' . $count . '</a></li>' ;
					}
			
					if ($total_pages > 3 && $current_page < $total_pages)
						echo '<li class="alsp-inactive next"><a href="' . get_pagenum_link($next_page) . '" title="' . esc_attr__('Next Page', 'ALSP') . '" data-page=' . $next_page . ' data-controller-hash=' . $hash . '>></i></a></li>' ;
			
					if ($total_pages > 10 && $current_line < $total_lines)
						echo '<li class="alsp-inactive next_line"><a href="' . get_pagenum_link($next_line_page) . '" title="' . esc_attr__('Next Line', 'ALSP') . '" data-page=' . $next_line_page . ' data-controller-hash=' . $hash . '>>></a></li>' ;
			
					echo '</ul>';
					echo '</div>';
				} else {
					echo '<button class="btn btn-primary btn-lg btn-block alsp-show-more-button pacz-new-btn-4" data-controller-hash="' . $hash . '">' . __('Load More', 'ALSP') . '</button>';
				}
			}
		}
	}
}

function alsp_renderSharingButton($post_id, $button) {
	global $alsp_social_services, $ALSP_ADIMN_SETTINGS;
	$post_title = urlencode(get_the_title($post_id));
	$thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), array(200, 200));
	$post_thumbnail = urlencode($thumb_url[0]);
	if (get_post_type($post_id) == ALSP_POST_TYPE) {
		$listing = new alsp_listing;
		if ($listing->loadListingFromPost($post_id))
			$post_title = urlencode($listing->title());
	}
	$post_url = urlencode(get_permalink($post_id));

	if ($ALSP_ADIMN_SETTINGS['alsp_share_buttons']['enabled']) {
		$share_url = false;
		$share_counter = false;
		switch ($button) {
			case 'Facebook':
				$share_url = 'http://www.facebook.com/sharer.php?u=' . $post_url;
				if ($ALSP_ADIMN_SETTINGS['alsp_share_counter']) {
					$response = wp_remote_get('https://api.facebook.com/restserver.php?method=links.getStats&format=json&urls=' . $post_url);
					if (!is_wp_error($response)) {
						$body = wp_remote_retrieve_body($response);
						$json = json_decode($body);
						$share_counter = (isset($json[0]->total_count)) ? intval($json[0]->total_count) : 0;
					}
				}
			break;
			case 'Twitter':
				$share_url = 'http://twitter.com/share?url=' . $post_url . '&amp;text=' . $post_title;
				if ($ALSP_ADIMN_SETTINGS['alsp_share_counter']) {
					$response = wp_remote_get('https://urls.api.twitter.com/1/urls/count.json?url=' . $post_url);
					if (!is_wp_error($response)) {
						$body = wp_remote_retrieve_body($response);
						$json = json_decode($body);
						$share_counter = (isset($json->count)) ? intval($json->count) : 0;
					}
				}
			break;
			case 'Google':
				$share_url = 'https://plus.google.com/share?url=' . $post_url;
				if ($ALSP_ADIMN_SETTINGS['alsp_share_counter']) {
					$args = array(
				            'method' => 'POST',
				            'headers' => array(
				                'Content-Type' => 'application/json'
				            ),
				            'body' => json_encode(array(
				                'method' => 'pos.plusones.get',
				                'id' => 'p',
				                'method' => 'pos.plusones.get',
				                'jsonrpc' => '2.0',
				                'key' => 'p',
				                'apiVersion' => 'v1',
				                'params' => array(
				                    'nolog' => true,
				                    'id' => $post_url,
				                    'source' => 'widget',
				                    'userId' => '@viewer',
				                    'groupId' => '@self'
				                ) 
				             )),          
				            'sslverify'=>false
				        ); 
				    $response = wp_remote_post("https://clients6.google.com/rpc", $args);
					if (!is_wp_error($response)) {
						$body = wp_remote_retrieve_body($response);
						$json = json_decode($body);
						$share_counter = (isset($json->result->metadata->globalCounts->count)) ? intval($json->result->metadata->globalCounts->count) : 0;
					}
				}
			break;
			case 'Digg':
				$share_url = 'http://www.digg.com/submit?url=' . $post_url;
			break;
			case 'Reddit':
				$share_url = 'http://reddit.com/submit?url=' . $post_url . '&amp;title=' . $post_title;
				if ($ALSP_ADIMN_SETTINGS['alsp_share_counter']) {
					$response = wp_remote_get('https://www.reddit.com/api/info.json?url=' . $post_url);
					if (!is_wp_error($response)) {
						$body = wp_remote_retrieve_body($response);
						$json = json_decode($body);
						$share_counter = (isset($json->data->children[0]->data->score)) ? intval($json->data->children[0]->data->score) : 0;
					}
				}
			break;
			case 'Linkedin':
				$share_url = 'http://www.linkedin.com/shareArticle?mini=true&amp;url=' . $post_url;
				if ($ALSP_ADIMN_SETTINGS['alsp_share_counter']) {
					$response = wp_remote_get('https://www.linkedin.com/countserv/count/share?url=' . $post_url . '&format=json');
					if (!is_wp_error($response)) {
						$body = wp_remote_retrieve_body($response);
						$json = json_decode($body);
						$share_counter = (isset($json->count)) ? intval($json->count) : 0;
					}
				}
			break;
			case 'Pinterest':
				$share_url = 'https://www.pinterest.com/pin/create/button/?url=' . $post_url . '&amp;media=' . $post_thumbnail . '&amp;description=' . $post_title;
				if ($ALSP_ADIMN_SETTINGS['alsp_share_counter']) {
					$response = wp_remote_get('https://api.pinterest.com/v1/urls/count.json?url=' . $post_url);
					if (!is_wp_error($response)) {
						$body = preg_replace('/^receiveCount\((.*)\)$/', "\\1", $response['body']);
						$json = json_decode($body);
						$share_counter = (isset($json->count)) ? intval($json->count) : 0;
					}
				}
			break;
			case 'Stumbleupon':
				$share_url = 'http://www.stumbleupon.com/submit?url=' . $post_url . '&amp;title=' . $post_title;
				if ($ALSP_ADIMN_SETTINGS['alsp_share_counter']) {
					$response = wp_remote_get('https://www.stumbleupon.com/services/1.01/badge.getinfo?url=' . $post_url);
					if (!is_wp_error($response)) {
						$body = wp_remote_retrieve_body($response);
						$json = json_decode($body);
						$share_counter = (isset($json->result->views)) ? intval($json->result->views) : 0;
					}
				}
			break;
			case 'Tumblr':
				$share_url = 'http://www.tumblr.com/share/link?url=' . str_replace('http://', '', str_replace('https://', '', $post_url)) . '&amp;name=' . $post_title;
			break;
			case 'vk':
				$share_url = 'http://vkontakte.ru/share.php?url=' . $post_url;
				if ($ALSP_ADIMN_SETTINGS['alsp_share_counter']) {
					$response = wp_remote_get('https://vkontakte.ru/share.php?act=count&index=1&url=' . $post_url);
					if (!is_wp_error($response)) {
						$tmp = array();
						preg_match('/^VK.Share.count\(1, (\d+)\);$/i', $response['body'], $tmp);
						$share_counter = (isset($tmp[1])) ? intval($tmp[1]) : 0;
					}
				}
			break;
			case 'Email':
				$share_url = 'mailto:?Subject=' . $post_title . '&amp;Body=' . $post_url;
			break;
		}

		//if ($share_url !== false) {
			echo '<a href="'.$share_url.'" data-toggle="alsp-tooltip" title="'.sprintf(__('Share on %s', 'ALSP'), $button).'" target="_blank"><img src="'.ALSP_RESOURCES_URL.'images/social/'.$ALSP_ADIMN_SETTINGS['alsp_share_buttons_style'].'/'.$button.'.png" /></a>';
			if ($ALSP_ADIMN_SETTINGS['alsp_share_counter'] && $share_counter !== false)
				echo '<span class="alsp-share-count">'.number_format($share_counter).'</span>';
		//}
	}
}

?>