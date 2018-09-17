<?php

if (!defined('ABSPATH')) { exit; }

class gdrts_rating_item {
    public $item_id;
    public $entity;
    public $name;
    public $id;
    public $latest;

    public $meta;
    public $data = null;

    public $error = false;

    private $backup_meta;

    public function __construct($data) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

        if ($this->item_id > 0 && is_null($this->data)) {
            $this->data = gdrts_load_object_data($this->entity, $this->name, $this->id);
        }
    }

    public function __get($name) {
        if (isset($this->meta[$name])) {
            return $this->meta[$name];
        } else {
            return null;
        }
    }

    public static function get_instance($item_id = null, $entity = null, $name = null, $id = null) {
        if (is_null($item_id) || $item_id == 0) {
            $item_id = gdrts_cache()->get_item_id($entity, $name, $id);

            if ($item_id === false || is_null($item_id)) {
                return false;
            }
        }

        $item_id = intval($item_id);

        $data = gdrts_cache()->get('item', $item_id);

        if ($data === false) {
            $item = gdrts_db()->get_item($item_id);

            if (isset($item->item_id) && $item->item_id > 0) {
                $data = array(
                    'item_id' => $item_id,
                    'entity' => $item->entity,
                    'name' => $item->name,
                    'id' => intval($item->id),
                    'latest' => intval(mysql2date('G', $item->latest)),
                    'meta' => gdrts_db()->get_item_meta($item_id)
                );

                gdrts_cache()->add('item', $item_id, $data);
            } else {
                $data = array('item_id' => $item_id, 'error' => true);
            }
        }

        return new gdrts_rating_item($data);
    }

    public function prepare_save() {
        $this->backup_meta = $this->meta;
    }

    public function save($update_latest = true) {
        foreach ($this->meta as $key => $value) {
            if (is_array($this->backup_meta) && isset($this->backup_meta[$key])) {
                gdrts_db()->update_meta('item', $this->item_id, $key, $value, $this->backup_meta[$key]);
            } else {
                gdrts_db()->add_meta('item', $this->item_id, $key, $value, true);
            }
        }

        if (is_array($this->backup_meta)) {
            foreach ($this->backup_meta as $key => $value) {
                if (!isset($this->meta[$key])) {
                    gdrts_db()->delete_meta('item', $this->item_id, $key);
                }
            }
        }

        if ($update_latest) {
            gdrts_db()->update_item_latest($this->item_id);
        }

        gdrts_cache()->delete('item', $this->item_id);
    }

    public function set($name, $value) {
        $this->meta[$name] = $value;
    }

    public function un_set($name) {
        if (isset($this->meta[$name])) {
            unset($this->meta[$name]);
        }
    }

    public function getfix($prefix, $name, $default = '') {
        if (isset($this->period->{$name})) {
            return $this->period->{$name};
        }

        return $this->get($prefix.$name, $default);
    }

    public function get($name, $default = '') {
        $value = $this->{$name};

        if (is_null($value)) {
            $value = $default;
        }

        return $value;
    }

    public function get_meta($name, $default = false) {
        if (isset($this->meta[$name])) {
            return $this->meta[$name];
        } else {
            return $default;
        }
    }

    public function get_meta_prefixed($prefix, $with_prefix = false) {
        $meta = array();

        foreach ($this->meta as $key => $value) {
            if (substr($key, 0, strlen($prefix)) == $prefix) {
                $new = $with_prefix ? $key : substr($key, strlen($prefix));
                $meta[$new] = $value;
            }
        }

        return $meta;
    }

    public function get_method_data($method, $series = null) {
        $key = is_null($series) ? $method.'_' : $method.'-'.$series.'_';

        return $this->get_meta_prefixed($key);
    }

    public function item_data() {
        return array(
            'entity' => $this->entity,
            'name' => $this->name,
            'id' => $this->id,
            'item_id' => $this->item_id,
            'nonce' => wp_create_nonce($this->nonce_key())
        );
    }

    public function nonce_key() {
        return 'gdrts_item_'.$this->entity.'_'.$this->name.'_'.$this->id;
    }

    public function rating_classes() {
        return array(
            'gdrts-item-entity-'.$this->entity,
            'gdrts-item-name-'.$this->name,
            'gdrts-item-id-'.$this->id,
            'gdrts-item-itemid-'.$this->item_id
        );
    }

    public function update_meta($meta = array()) {
        if (!empty($meta)) {
            $this->prepare_save();

            foreach ($meta as $key => $value) {
                $this->meta[$key] = $value;
            }

            $this->save(false);
        }
    }

    public function title() {
        return $this->data->get_title();
    }

    public function url() {
        return $this->data->get_url();
    }

    public function author_id() {
        return $this->data->get_author_id();
    }

    public function thumbnail($size = 'thumbnail', $attr = array()) {
        if ($this->data->has_thumbnail()) {
            return $this->data->get_thumbnail($size, $attr);
        }

        return '';
    }

    public function thumbnail_url($size = 'thumbnail') {
        if ($this->data->has_thumbnail()) {
            return $this->data->thumbnail_url($size);
        }

        return '';
    }

    public function date_published($format = 'c') {
        return $this->data->get_date_published($format);
    }

    public function date_modified($format = 'c') {
        return $this->data->get_date_modified($format);
    }

    public function users_who_voted($method, $series = null, $args = array()) {
        return gdrts_db()->get_users_who_voted_for_item($this->item_id, $method, $series, $args);
    }
}

class gdrts_item_post extends gdrts_item_data {
    public function __construct($entity, $name, $id) {
        parent::__construct($entity, $name, $id);

        $this->object = get_post($this->id);
    }

    public function get_title() {
        $title = $this->id;

        if (isset($this->object->post_title) && !empty($this->object->post_title)) {
            $title = get_the_title($this->object);
        }

        return apply_filters('gdrts_item_post_get_title', $title, $this);
    }

    public function get_author_id() {
        $author_id = 0;

        if (isset($this->object->post_author) && !empty($this->object->post_author)) {
            $author_id = $this->object->post_author;
        }
        
        return apply_filters('gdrts_item_post_get_author_id', $author_id, $this);
    }

    public function get_url() {
        return apply_filters('gdrts_item_post_get_url', get_permalink($this->id), $this);
    }

    public function get_date_published($format = 'c') {
        if ($format == '') {
            $format = get_option('date_format');
        }

        return apply_filters('gdrts_item_post_get_date_published', mysql2date($format, $this->object->post_date), $this, $format);
    }

    public function get_date_modified($format = 'c') {
        if ($format == '') {
            $format = get_option('date_format');
        }

        return apply_filters('gdrts_item_post_get_date_published', mysql2date($format, $this->object->post_modified), $this, $format);
    }

    public function has_thumbnail() {
        return apply_filters('gdrts_item_post_has_thumbnail', has_post_thumbnail($this->id), $this);
    }

    public function get_thumbnail($size = 'thumbnail', $attr = array()) {
        return apply_filters('gdrts_item_post_get_thumbnail', get_the_post_thumbnail($this->id, $size, $attr), $this, $size, $attr);
    }

    public function get_thumbnail_url($size = 'thumbnail') {
        return apply_filters('gdrts_item_post_get_thumbnail_url', d4p_get_thumbnail_url($this->id, $size), $this, $size);
    }
}

class gdrts_item_comment extends gdrts_item_data {
    public function __construct($entity, $name, $id) {
        parent::__construct($entity, $name, $id);

        $this->object = get_comment($this->id);
    }

    public function get_title() {
        return apply_filters('gdrts_item_comment_get_title', sprintf(__("%s on %s", "gd-rating-system"),
            get_comment_author($this->object),
            get_the_title($this->object->comment_post_ID)
        ), $this);
    }

    public function get_author_id() {
        $author_id = 0;

        if (isset($this->object->user_id) && !empty($this->object->user_id)) {
            $author_id = $this->object->user_id;
        }
        
        return apply_filters('gdrts_item_comment_get_author_id', $author_id, $this);
    }

    public function get_url() {
        return apply_filters('gdrts_item_comment_get_url', get_comment_link($this->id), $this);
    }

    public function get_date_published($format = 'c') {
        if ($format == '') {
            $format = get_option('date_format');
        }

        return apply_filters('gdrts_item_comment_get_date_published', mysql2date($format, $this->object->comment_date), $this, $format);
    }

    public function get_date_modified($format = 'c') {
        if ($format == '') {
            $format = get_option('date_format');
        }

        return apply_filters('gdrts_item_comment_get_date_modified', mysql2date($format, $this->object->comment_date), $this, $format);
    }

    public function has_thumbnail() {
        return apply_filters('gdrts_item_comment_has_thumbnail', has_post_thumbnail($this->object->comment_post_ID), $this);
    }

    public function get_thumbnail($size = 'thumbnail', $attr = array()) {
        return apply_filters('gdrts_item_comment_get_thumbnail', get_the_post_thumbnail($this->object->comment_post_ID, $size, $attr), $this, $size, $attr);
    }

    public function get_thumbnail_url($size = 'thumbnail') {
        return apply_filters('gdrts_item_comment_get_thumbnail_url', d4p_get_thumbnail_url($this->object->comment_post_ID, $size), $this, $size);
    }
}

class gdrts_item_user extends gdrts_item_data {
    public function __construct($entity, $name, $id) {
        parent::__construct($entity, $name, $id);

        $this->object = get_user_by('id', $this->id);
    }

    public function get_title() {
        return apply_filters('gdrts_item_user_get_title', $this->object->display_name, $this);
    }

    public function get_author_id() {
        return apply_filters('gdrts_item_user_get_author_id', $this->id, $this);
    }

    public function get_url() {
        return apply_filters('gdrts_item_user_get_url', '', $this);
    }

    public function get_date_published($format = 'c') {
        if ($format == '') {
            $format = get_option('date_format');
        }

        return apply_filters('gdrts_item_user_get_date_published', mysql2date($format, $this->object->user_registered), $this, $format);
    }

    public function get_date_modified($format = 'c') {
        if ($format == '') {
            $format = get_option('date_format');
        }

        return apply_filters('gdrts_item_user_get_date_modified', mysql2date($format, $this->object->user_registered), $this, $format);
    }

    public function has_thumbnail() {
        return apply_filters('gdrts_item_user_has_thumbnail', true, $this);
    }

    public function get_thumbnail($size = 'thumbnail', $attr = array()) {
        $size = intval($size);

        if ($size == 0) {
            $size = 96;
        }

        return apply_filters('gdrts_item_user_get_thumbnail', get_avatar($this->id, $size, '', $this->get_title(), $attr), $this, $size, $attr);
    }

    public function get_thumbnail_url($size = 'thumbnail') {
        $size = intval($size);

        if ($size == 0) {
            $size = 96;
        }

        return apply_filters('gdrts_item_user_get_thumbnail_url', get_avatar_url($this->id, array('size' => $size)), $this, $size);
    }
}

class gdrts_item_term extends gdrts_item_data {
    public function __construct($entity, $name, $id) {
        parent::__construct($entity, $name, $id);

        $this->object = get_term_by('id', $this->id, $this->name);
    }

    public function get_title() {
        return apply_filters('gdrts_item_term_get_title', $this->object->name, $this);
    }

    public function get_author_id() {
        return apply_filters('gdrts_item_term_get_author_id', 0, $this);
    }

    public function get_url() {
        return apply_filters('gdrts_item_term_get_url', get_term_link($this->object), $this);
    }

    public function get_date_published($format = 'c') {
        return apply_filters('gdrts_item_term_get_date_published', null, $this, $format);
    }

    public function get_date_modified($format = 'c') {
        return apply_filters('gdrts_item_term_get_date_modified', null, $this, $format);
    }

    public function has_thumbnail() {
        return apply_filters('gdrts_item_term_has_thumbnail', false, $this);
    }

    public function get_thumbnail($size = 'thumbnail', $attr = array()) {
        return apply_filters('gdrts_item_term_get_thumbnail', '', $this, $size, $attr);
    }

    public function get_thumbnail_url($size = 'thumbnail') {
        return apply_filters('gdrts_item_term_get_thumbnail_url', '', $this, $size);
    }
}

class gdrts_item_custom extends gdrts_item_data {
    public function is_valid() {
        return true;
    }

    public function get_title() {
        return apply_filters('gdrts_item_custom_get_title', '', $this);
    }

    public function get_author_id() {
        return apply_filters('gdrts_item_custom_get_author_id', 0, $this);
    }

    public function get_url() {
        return apply_filters('gdrts_item_custom_get_url', '', $this);
    }

    public function get_date_published($format = 'c') {
        return apply_filters('gdrts_item_custom_get_date_published', null, $this, $format);
    }

    public function get_date_modified($format = 'c') {
        return apply_filters('gdrts_item_custom_get_date_modified', null, $this, $format);
    }

    public function has_thumbnail() {
        return apply_filters('gdrts_item_custom_has_thumbnail', false, $this);
    }

    public function get_thumbnail($size = 'thumbnail', $attr = array()) {
        return apply_filters('gdrts_item_custom_get_thumbnail', '', $this, $size, $attr);
    }

    public function get_thumbnail_url($size = 'thumbnail') {
        return apply_filters('gdrts_item_custom_get_thumbnail_url', '', $this, $size);
    }
}
