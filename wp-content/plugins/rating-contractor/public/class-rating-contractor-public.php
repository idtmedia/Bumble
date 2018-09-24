<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://creativeosc.com
 * @since      1.0.0
 *
 * @package    Rating_Contractor
 * @subpackage Rating_Contractor/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rating_Contractor
 * @subpackage Rating_Contractor/public
 * @author     Ngo Ngoc Thang <thangnn1510@gmail.com>
 */
class Rating_Contractor_Public {

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
		 * defined in Rating_Contractor_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rating_Contractor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rating-contractor-public.css', array(), $this->version, 'all' );

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
		 * defined in Rating_Contractor_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rating_Contractor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rating-contractor-public.js', array( 'jquery' ), $this->version, false );

	}
	
	function create_ratingcontractor_cpt() {

		$labels = array(
			'name' => __( 'Rating contractor', 'Post Type General Name', 'rating-Contractor' ),
			'singular_name' => __( 'Rating contractor', 'Post Type Singular Name', 'rating-Contractor' ),
			'menu_name' => __( 'Rating contractor', 'rating-Contractor' ),
			'name_admin_bar' => __( 'Rating contractor', 'rating-Contractor' ),
			'archives' => __( 'Rating contractor Archives', 'rating-Contractor' ),
			'attributes' => __( 'Rating contractor Attributes', 'rating-Contractor' ),
			'parent_item_colon' => __( 'Parent Rating contractor:', 'rating-Contractor' ),
			'all_items' => __( 'All Rating contractor', 'rating-Contractor' ),
			'add_new_item' => __( 'Add New Rating contractor', 'rating-Contractor' ),
			'add_new' => __( 'Add New', 'rating-Contractor' ),
			'new_item' => __( 'New Rating contractor', 'rating-Contractor' ),
			'edit_item' => __( 'Edit Rating contractor', 'rating-Contractor' ),
			'update_item' => __( 'Update Rating contractor', 'rating-Contractor' ),
			'view_item' => __( 'View Rating contractor', 'rating-Contractor' ),
			'view_items' => __( 'View Rating contractor', 'rating-Contractor' ),
			'search_items' => __( 'Search Rating contractor', 'rating-Contractor' ),
			'not_found' => __( 'Not found', 'rating-Contractor' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'rating-Contractor' ),
			'featured_image' => __( 'Featured Image', 'rating-Contractor' ),
			'set_featured_image' => __( 'Set featured image', 'rating-Contractor' ),
			'remove_featured_image' => __( 'Remove featured image', 'rating-Contractor' ),
			'use_featured_image' => __( 'Use as featured image', 'rating-Contractor' ),
			'insert_into_item' => __( 'Insert into Rating contractor', 'rating-Contractor' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Rating contractor', 'rating-Contractor' ),
			'items_list' => __( 'Rating contractor list', 'rating-Contractor' ),
			'items_list_navigation' => __( 'Rating contractor list navigation', 'rating-Contractor' ),
			'filter_items_list' => __( 'Filter Rating contractor list', 'rating-Contractor' ),
		);
		$args = array(
			'label' => __( 'Rating contractor', 'rating-Contractor' ),
			'description' => __( 'Rating contractor', 'rating-Contractor' ),
			'labels' => $labels,
			'menu_icon' => '',
			'supports' => array('title', 'editor' ),
			'taxonomies' => array(),
			'public' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 5,
			'show_in_admin_bar' => true,
			'show_in_nav_menus' => false,
			'can_export' => true,
			'has_archive' => false,
			'hierarchical' => false,
			'exclude_from_search' => false,
			'show_in_rest' => false,
			'publicly_queryable' => true,
			'capability_type' => 'post',
		);
		register_post_type( 'ratingcontractor', $args );

	}


}
