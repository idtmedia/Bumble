<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class DHVCForm_Post_Types
{
    public static function init()
    {
        add_action('init', array(__CLASS__, 'register_post_types'), 5);
    }
    
    public static function register_post_types()
    {
        if (!is_blog_installed() || post_type_exists('dhvcform')) {
            return;
        }
        
        register_post_type("dhvcform", apply_filters('dhvc_form_register_post_type', array(
            'labels' => array(
                'name' => __('Forms', 'dhvc-form'),
                'singular_name' => __('Form', 'dhvc-form'),
                'menu_name' => _x('Forms', 'Admin menu name', 'dhvc-form'),
                'add_new' => __('Add Form', 'dhvc-form'),
                'add_new_item' => __('Add New Form', 'dhvc-form'),
                'edit' => __('Edit', 'dhvc-form'),
                'edit_item' => __('Edit Form', 'dhvc-form'),
                'new_item' => __('New Form', 'dhvc-form'),
                'view' => __('View Form', 'dhvc-form'),
                'view_item' => __('View Form', 'dhvc-form'),
                'search_items' => __('Search Forms', 'dhvc-form'),
                'not_found' => __('No Forms found', 'dhvc-form'),
                'not_found_in_trash' => __('No Forms found in trash', 'dhvc-form'),
                'parent' => __('Parent Form', 'dhvc-form')
            ),
            'description' => __('This is where you can add new form.', 'dhvc-form'),
            'public' => isset($_GET['vc_editable']) && 'true' === $_GET['vc_editable'] ? true : false,
            'has_archive' => false,
            'show_in_nav_menus' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => isset($_GET['vc_editable']) && 'true' === $_GET['vc_editable'] ? true : false,
            'show_ui' => true,
            'show_in_menu' => 'dhvc-form',
            'query_var' => true,
            'capability_type' => 'dhvcform',
        	'map_meta_cap'=> true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array( 'title','editor')
        )));
    }
}
DHVCForm_Post_Types::init();