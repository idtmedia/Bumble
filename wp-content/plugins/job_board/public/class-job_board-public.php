<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://creativeosc.com
 * @since      1.0.0
 *
 * @package    Job_board
 * @subpackage Job_board/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Job_board
 * @subpackage Job_board/public
 * @author     Ngo Ngoc Thang <thangnn1510@gmail.com>
 */
class Job_board_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Job_board_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Job_board_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/job_board-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Job_board_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Job_board_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/job_board-public.js', array( 'jquery' ), $this->version, false );

	}

    // Register Custom Post Type
    function create_bidding_cpt() {

        $labels = array(
            'name'                  => _x( 'Bidding', 'Post Type General Name', 'bidding' ),
            'singular_name'         => _x( 'bidding', 'Post Type Singular Name', 'bidding' ),
            'menu_name'             => __( 'Bidding', 'bidding' ),
            'name_admin_bar'        => __( 'Bidding', 'bidding' ),
            'archives'              => __( 'Item Archives', 'bidding' ),
            'attributes'            => __( 'Item Attributes', 'bidding' ),
            'parent_item_colon'     => __( 'Parent Item:', 'bidding' ),
            'all_items'             => __( 'All Items', 'bidding' ),
            'add_new_item'          => __( 'Add New Item', 'bidding' ),
            'add_new'               => __( 'Add New', 'bidding' ),
            'new_item'              => __( 'New Item', 'bidding' ),
            'edit_item'             => __( 'Edit Item', 'bidding' ),
            'update_item'           => __( 'Update Item', 'bidding' ),
            'view_item'             => __( 'View Item', 'bidding' ),
            'view_items'            => __( 'View Items', 'bidding' ),
            'search_items'          => __( 'Search Item', 'bidding' ),
            'not_found'             => __( 'Not found', 'bidding' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'bidding' ),
            'featured_image'        => __( 'Featured Image', 'bidding' ),
            'set_featured_image'    => __( 'Set featured image', 'bidding' ),
            'remove_featured_image' => __( 'Remove featured image', 'bidding' ),
            'use_featured_image'    => __( 'Use as featured image', 'bidding' ),
            'insert_into_item'      => __( 'Insert into item', 'bidding' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'bidding' ),
            'items_list'            => __( 'Items list', 'bidding' ),
            'items_list_navigation' => __( 'Items list navigation', 'bidding' ),
            'filter_items_list'     => __( 'Filter items list', 'bidding' ),
        );
        $args = array(
            'label'                 => __( 'bidding', 'bidding' ),
            'description'           => __( 'Bidding', 'bidding' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor' ),
            'taxonomies'            => array(),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type( 'bidding', $args );

    }


}
