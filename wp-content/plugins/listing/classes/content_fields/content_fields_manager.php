<?php

class alsp_content_fields_manager {
	public $menu_page_hook;
	
	public function __construct() {
		global $pagenow;

		if ($pagenow == 'post-new.php' || $pagenow == 'post.php' || $pagenow == 'admin-ajax.php') {
			add_action('add_meta_boxes', array($this, 'addContentFieldsMetabox'));
		}
		
		add_action('admin_menu', array($this, 'menu'));

		add_action('delete_term_taxonomy', array($this, 'renew_assigned_categories'));
	}
	
	public function menu() {
		$this->menu_page_hook = add_submenu_page('classiads_settings',
			__('Content fields', 'ALSP'),
			__('Content fields', 'ALSP'),
			'administrator',
			'alsp_content_fields',
			array($this, 'alsp_content_fields')
		);
	}
	
	public function alsp_content_fields() {
		if (isset($_GET['action']) && $_GET['action'] == 'add') {
			$this->addOrEditContentField();
		} elseif (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['field_id'])) {
			$this->addOrEditContentField($_GET['field_id']);
		} elseif (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['field_id'])) {
			$this->deleteContentField($_GET['field_id']);
		} elseif (isset($_GET['action']) && $_GET['action'] == 'configure' && isset($_GET['field_id'])) {
			$this->configureContentField($_GET['field_id']);
		} elseif (isset($_GET['action']) && $_GET['action'] == 'add_group') {
			$this->addOrEditContentFieldsGroup();
		} elseif (isset($_GET['action']) && $_GET['action'] == 'edit_group' && isset($_GET['group_id'])) {
			$this->addOrEditContentFieldsGroup($_GET['group_id']);
		} elseif (isset($_GET['action']) && $_GET['action'] == 'delete_group' && isset($_GET['group_id'])) {
			$this->deleteContentFieldsGroup($_GET['group_id']);
		} elseif (!isset($_GET['action'])) {
			$this->showContentFieldsTable();
		}
	}
	
	public function showContentFieldsTable() {
		wp_enqueue_script('jquery-ui-sortable');
		$content_fields = new alsp_content_fields;

		if (isset($_POST['content_fields_order']) && $content_fields->saveOrderAndGroupsRelations())
			alsp_addMessage(__('Content fields order and relations were updated!', 'ALSP'), 'updated');

		$content_fields_table = new alsp_manage_content_fields_table();
		$content_fields_table->prepareItems($content_fields);

		$content_fields_groups_table = new alsp_manage_content_fields_groups_table();
		$content_fields_groups_table->prepareItems($content_fields);
		
		alsp_frontendRender('content_fields/content_fields_table.tpl.php', array('content_fields_table' => $content_fields_table, 'content_fields_groups_table' => $content_fields_groups_table, 'fields_types_names' => $content_fields->fields_types_names));
	}
	
	public function addOrEditContentField($field_id = null) {
		global $alsp_instance;
	
		$content_fields = $alsp_instance->content_fields;
	
		if (!$content_field = $content_fields->getContentFieldById($field_id)) {
			// this will be new field
			if (isset($_POST['type']) && $_POST['type']) {
				// load dummy content field by its type from $_POST
				$field_class_name = 'alsp_content_field_' . $_POST['type'];
				if (class_exists($field_class_name)) {
					$content_field = new $field_class_name;
				}
			} else 
				$content_field = new alsp_content_field();
		}

		if (alsp_getValue($_POST, 'submit') && wp_verify_nonce($_POST['alsp_content_fields_nonce'], ALSP_PATH)) {
			$validation = $content_field->validation();

			if ($validation->run()) {
				if ($content_field->id) {
					if ($content_fields->saveContentFieldFromArray($field_id, $validation->result_array())) {
						alsp_addMessage(__('Content field was updated successfully!', 'ALSP'));
					}
				} else {
					if ($content_fields->createContentFieldFromArray($validation->result_array())) {
						alsp_addMessage(__('Content field was created succcessfully!', 'ALSP'));
					}
				}
				$this->showContentFieldsTable();
			} else {
				$content_field->buildContentFieldFromArray($validation->result_array());
				alsp_addMessage($validation->error_string(), 'error');
	
				alsp_frontendRender('content_fields/add_edit_content_field.tpl.php', array('content_fields' => $content_fields, 'content_field' => $content_field, 'field_id' => $field_id, 'fields_types_names' => $content_fields->fields_types_names));
			}
		} else {
			alsp_frontendRender('content_fields/add_edit_content_field.tpl.php', array('content_fields' => $content_fields, 'content_field' => $content_field, 'field_id' => $field_id, 'fields_types_names' => $content_fields->fields_types_names));
		}
	}

	public function addOrEditContentFieldsGroup($group_id = null) {
		global $alsp_instance;
	
		$content_fields = $alsp_instance->content_fields;
	
		if (!$content_fields_group = $content_fields->getContentFieldsGroupById($group_id)) {
			// this will be new fields group
			$content_fields_group = new alsp_content_fields_group();
		}

		if (alsp_getValue($_POST, 'submit') && wp_verify_nonce($_POST['alsp_content_fields_nonce'], ALSP_PATH)) {
			$validation = $content_fields_group->validation();

			if ($validation->run()) {
				if ($content_fields_group->id) {
					if ($content_fields->saveContentFieldsGroupFromArray($group_id, $validation->result_array())) {
						alsp_addMessage(__('Content fields group was updated successfully!', 'ALSP'));
					}
				} else {
					if ($content_fields->createContentFieldsGroupFromArray($validation->result_array())) {
						alsp_addMessage(__('Content fields group was created succcessfully!', 'ALSP'));
					}
				}
				$this->showContentFieldsTable();
			} else {
				$content_fields->buildContentFieldsGroupFromArray($validation->result_array());
				alsp_addMessage($validation->error_string(), 'error');
	
				alsp_frontendRender('content_fields/add_edit_content_fields_group.tpl.php', array('content_fields' => $content_fields, 'content_fields_group' => $content_fields_group, 'group_id' => $group_id));
			}
		} else {
			alsp_frontendRender('content_fields/add_edit_content_fields_group.tpl.php', array('content_fields' => $content_fields, 'content_fields_group' => $content_fields_group, 'group_id' => $group_id));
		}
	}

	public function configureContentField($field_id) {
		global $alsp_instance;
	
		if (($content_field = $alsp_instance->content_fields->getContentFieldById($field_id)) && $content_field->isConfigurationPage())
			$content_field->configure();
		else {
			alsp_addMessage(esc_attr__("This content field can't be configured", 'ALSP'), 'error');
			$this->showContentFieldsTable();
		}
	}

	public function deleteContentField($field_id) {
		global $alsp_instance;
	
		$content_fields = $alsp_instance->content_fields;
		// core fields can't be deleted
		if (($content_field = $content_fields->getContentFieldById($field_id)) && !$content_field->is_core_field) {
			if (alsp_getValue($_POST, 'submit')) {
				if ($content_fields->deleteContentField($field_id))
					alsp_addMessage(__('Content field was deleted successfully!', 'ALSP'));
	
				$this->showContentFieldsTable();
			} else
				alsp_frontendRender('delete_question.tpl.php', array('heading' => __('Delete content field', 'ALSP'), 'question' => sprintf(__('Are you sure you want delete "%s" content field?', 'ALSP'), $content_field->name), 'item_name' => $content_field->name));
		} else
			$this->showContentFieldsTable();
	}

	public function deleteContentFieldsGroup($group_id) {
		global $alsp_instance;
	
		$content_fields = $alsp_instance->content_fields;
		if ($content_fields_group = $content_fields->getContentFieldsGroupById($group_id)) {
			if (alsp_getValue($_POST, 'submit')) {
				if ($content_fields->deleteContentFieldsGroup($group_id))
					alsp_addMessage(__('Content fields group was deleted successfully!', 'ALSP'));
	
				$this->showContentFieldsTable();
			} else
				alsp_frontendRender('delete_question.tpl.php', array('heading' => __('Delete content fields group', 'ALSP'), 'question' => sprintf(__('Are you sure you want delete "%s" content fields group?', 'ALSP'), $content_fields_group->name), 'item_name' => $content_fields_group->name));
		} else
			$this->showContentFieldsTable();
	}

	public function addContentFieldsMetabox($post_type) {
		if ($post_type == ALSP_POST_TYPE) {
			global $alsp_instance;
			
			if ($alsp_instance->content_fields->isNotCoreContentFields())
				add_meta_box('alsp_content_fields',
						__('Content fields', 'ALSP'),
						array($this, 'contentFieldsMetabox'),
						ALSP_POST_TYPE,
						'normal',
						'high');
		}
	}
	
	public function contentFieldsMetabox($post) {
		global $alsp_instance;

		if ($listing = alsp_getCurrentListingInAdmin()) {
			$content_fields = $listing->content_fields + $alsp_instance->content_fields->content_fields_array;

			// now need to order content fields by their order_num values, because after merge the order is broken
			$order_keys = array_keys($alsp_instance->content_fields->content_fields_array);
			$ordered_content_fields = array();
			foreach($order_keys as $key) {
				if(array_key_exists($key, $content_fields)) {
					$ordered_content_fields[$key] = $content_fields[$key];
					unset($content_fields[$key]);
				}
			}
			$content_fields = array();
			foreach ($ordered_content_fields AS &$content_field)
				if ($content_field->is_core_field || !$listing->level->content_fields || in_array($content_field->id, $listing->level->content_fields))
					$content_fields[] = $content_field;
		} else
			$content_fields = $alsp_instance->content_fields->content_fields_array;
		alsp_frontendRender('content_fields/content_fields_metabox.tpl.php', array('content_fields' => $content_fields));
	}

	/**
	 * This action called before directory category item would be deleted,
	 * refresh categories array, those assigned with content fields.
	 * 
	 * @param int $tt_id - term taxonomy id
	 */
	public function renew_assigned_categories($tt_id) {
		if ($term = get_term_by('term_taxonomy_id', $tt_id, ALSP_CATEGORIES_TAX)) {
			global $wpdb;
			$content_fields = $wpdb->get_results("SELECT * FROM {$wpdb->alsp_content_fields}", ARRAY_A);
			foreach ($content_fields AS $content_field) {
				if ($content_field['categories']) {
					$unserialized_categories = unserialize($content_field['categories']);
					if (count($unserialized_categories) > 1 || $unserialized_categories != array(''))
						if (($key = array_search($term->term_id, $unserialized_categories)) !== FALSE) {
							unset($unserialized_categories[$key]);
							$wpdb->update($wpdb->alsp_content_fields, array('categories' => serialize($unserialized_categories)), array('id' => $content_field['id']));
						}
				}
			}
		}
	}
}

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class alsp_manage_content_fields_table extends WP_List_Table {

	public function __construct() {
		parent::__construct(array(
				'singular' => __('content field', 'ALSP'),
				'plural' => __('content fields', 'ALSP'),
				'ajax' => false
		));
	}

	public function get_columns() {
		$columns = array(
				'id' => __('ID', 'ALSP'),
				'field_name' => __('Name', 'ALSP'),
				'field_type' => __('Field type', 'ALSP'),
				'required' => __('Required', 'ALSP'),
				'icon_image' => __('Icon image', 'ALSP'),
				'in_pages' => __('Visibility', 'ALSP'),
				'group_id' => __('Group', 'ALSP'),
		);
		$columns = apply_filters('alsp_content_field_table_header', $columns);

		return $columns;
	}

	public function getItems($content_fields_object) {
		$items_array = array();
		foreach ($content_fields_object->content_fields_array as $id=>$content_field) {
			$items_array[$id] = array(
					'id' => $content_field->id,
					'is_core_field' => $content_field->is_core_field,
					'field_name' => $content_field->name,
					'field_type' => $content_field->type,
					'required' => $content_field->is_required,
					'can_be_required' => $content_field->canBeRequired(),
					'is_configuration_page' => $content_field->isConfigurationPage(),
					'is_search_configuration_page' => $content_field->isSearchConfigurationPage(),
					'icon_image' => $content_field->icon_image,
					'on_exerpt_page' => $content_field->on_exerpt_page,
					'on_listing_page' => $content_field->on_listing_page,
					'on_search_form' => $content_field->on_search_form,
					'on_map' => $content_field->on_map,
					'group_id' => $content_field->group_id,
			);
			$items_array[$id] = apply_filters('alsp_content_field_table_row', $items_array[$id], $content_field);
		}
		return $items_array;
	}

	public function prepareItems($content_fields_object) {
		$this->_column_headers = array($this->get_columns(), array(), array());

		$this->items = $this->getItems($content_fields_object);
	}

	public function column_field_name($item) {
		$actions['edit'] = sprintf('<a href="?page=%s&action=%s&field_id=%d">' . __('Edit', 'ALSP') . '</a>', $_GET['page'], 'edit', $item['id']);
		if ($item['is_configuration_page'])
			$actions['configure'] = sprintf('<a href="?page=%s&action=%s&field_id=%d">' . __('Configure', 'ALSP') . '</a>', $_GET['page'], 'configure', $item['id']);
		if ($item['is_search_configuration_page'])
			$actions['search_configure'] = sprintf('<a href="?page=%s&action=%s&field_id=%d">' . __('Configure search', 'ALSP') . '</a>', $_GET['page'], 'configure_search', $item['id']);

		$actions = apply_filters('alsp_content_fields_column_options', $actions, $item);

		if (!$item['is_core_field'])
			$actions['delete'] = sprintf('<a href="?page=%s&action=%s&field_id=%d">' . __('Delete', 'ALSP') . '</a>', $_GET['page'], 'delete', $item['id']);
		return sprintf('%1$s %2$s', sprintf('<a href="?page=%s&action=%s&field_id=%d">' . $item['field_name'] . '</a><input type="hidden" class="content_field_weight_id" value="%d" />', $_GET['page'], 'edit', $item['id'], $item['id']), $this->row_actions($actions));
	}

	public function column_field_type($item) {
		global $alsp_instance;

		return $alsp_instance->content_fields->fields_types_names[$item['field_type']];
	}

	public function column_required($item) {
		if ($item['can_be_required'])
			if ($item['required'])
				return '<img src="' . ALSP_RESOURCES_URL . 'images/accept.png" />';
			else
				return '<img src="' . ALSP_RESOURCES_URL . 'images/delete.png" />';
		else
			return ' ';
	}

	public function column_icon_image($item) {
		if ($item['icon_image'])
			return '<span class="alsp-icon-tag fa ' . $item['icon_image'] . '"></span>';
		else
			return ' ';
	}

	public function column_in_pages($item) {
		$html = array();
		if ($item['on_exerpt_page'])
			$html[] = __('On excerpt', 'ALSP');
		if ($item['on_listing_page'])
			$html[] = __('On listing', 'ALSP');
		if ($item['on_map'])
			$html[] = __('In map marker InfoWindow', 'ALSP');
		if ($item['on_search_form'])
			$html_array[] = __('On search form', 'ALSP');
		
		$html = apply_filters('alsp_content_fields_in_pages_options', $html, $item);
		
		if ($html)
			return implode('<br />', $html);
		else
			return ' ';
	}
	
	public function column_group_id($item) {
		global $alsp_instance;

		echo '<select name="group_id_' . $item['id'] . '">';
		echo '<option value=0>' . __('- Without group -', 'ALSP') . '</option>';
		foreach ($alsp_instance->content_fields->content_fields_groups_array AS $group)
			echo '<option value=' . $group->id . ' ' . selected($item['group_id'], $group->id) . '>' . $group->name . '</option>';
		echo '</select>';
	}

	public function column_default($item, $column_name) {
		switch($column_name) {
			default:
				return $item[$column_name];
		}
	}

	public function no_items() {
		__('No content fields found.', 'ALSP');
	}
}

class alsp_manage_content_fields_groups_table extends WP_List_Table {

	public function __construct() {
		parent::__construct(array(
				'singular' => __('content fields group', 'ALSP'),
				'plural' => __('content fields groups', 'ALSP'),
				'ajax' => false
		));
	}

	public function get_columns() {
		$columns = array(
				'group_name' => __('Name', 'ALSP'),
				'on_tab' => __('On tab', 'ALSP'),
				'hide_anonymous' => __('Hide from anonymous', 'ALSP'),
		);
		$columns = apply_filters('alsp_content_field_table_header', $columns);

		return $columns;
	}

	public function getItems($content_fields_object) {
		$items_array = array();
		foreach ($content_fields_object->content_fields_groups_array as $id=>$content_fields_group) {
			$items_array[$id] = array(
					'id' => $content_fields_group->id,
					'group_name' => $content_fields_group->name,
					'on_tab' => $content_fields_group->on_tab,
					'group_style' => $content_fields_group->group_style,
					'hide_anonymous' => $content_fields_group->hide_anonymous,
			);
		}
		return $items_array;
	}

	public function prepareItems($content_fields_object) {
		$this->_column_headers = array($this->get_columns(), array(), array());

		$this->items = $this->getItems($content_fields_object);
	}

	public function column_group_name($item) {
		$actions['edit'] = sprintf('<a href="?page=%s&action=%s&group_id=%d">' . __('Edit', 'ALSP') . '</a>', $_GET['page'], 'edit_group', $item['id']);
		$actions['delete'] = sprintf('<a href="?page=%s&action=%s&group_id=%d">' . __('Delete', 'ALSP') . '</a>', $_GET['page'], 'delete_group', $item['id']);
		return sprintf('%1$s %2$s', sprintf('<a href="?page=%s&action=%s&group_id=%d">' . $item['group_name'] . '</a>', $_GET['page'], 'edit_group', $item['id']), $this->row_actions($actions));
	}

	public function column_on_tab($item) {
		if ($item['on_tab'])
			return '<img src="' . ALSP_RESOURCES_URL . 'images/accept.png" />';
		else
			return '<img src="' . ALSP_RESOURCES_URL . 'images/delete.png" />';
	}

	public function column_hide_anonymous($item) {
		if ($item['hide_anonymous'])
			return '<img src="' . ALSP_RESOURCES_URL . 'images/accept.png" />';
		else
			return '<img src="' . ALSP_RESOURCES_URL . 'images/delete.png" />';
	}

	public function column_default($item, $column_name) {
		switch($column_name) {
			default:
				return $item[$column_name];
		}
	}

	public function no_items() {
		__('No content fields groups found.', 'ALSP');
	}
}
?>