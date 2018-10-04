<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://creativeosc.com
 * @since      1.0.0
 *
 * @package    Job_board
 * @subpackage Job_board/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Job_board
 * @subpackage Job_board/includes
 * @author     Ngo Ngoc Thang <thangnn1510@gmail.com>
 */
class Job_board {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Job_board_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'job_board';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Job_board_Loader. Orchestrates the hooks of the plugin.
	 * - Job_board_i18n. Defines internationalization functionality.
	 * - Job_board_Admin. Defines all hooks for the admin area.
	 * - Job_board_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-job_board-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-job_board-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-job_board-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-job_board-public.php';

		$this->loader = new Job_board_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Job_board_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Job_board_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Job_board_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Job_board_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        $this->loader->add_action( 'init', $plugin_public, 'create_bidding_cpt' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Job_board_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

    public static function post_application($post){
        if (
            ! isset( $post['post_application_nonce'] )
            || ! wp_verify_nonce( $post['post_application_nonce'], 'post_application_action' )
        ) {
            print 'Sorry, your nonce did not verify.';
        } else {
            if(Job_board::check_can_apply($post['contractor'], $post['job'])){
                $my_application = array(
                    'post_title'	=> $post['contractor'],' applied for '.$post['job'],
                    'post_content'	=> $post['apply_message'],
                    'post_type'		=> 'bidding',
                    'post_status'	=> 'publish'
                );
                $post_id = wp_insert_post( $my_application );

                $field_contractor = "field_5bb5cd607e66b";
                $value = $post['contractor'];
                update_field( $field_contractor, $value, $post_id );

                $field_job= "field_5bb5cdd27e66d";
                $value = $post['job'];
                update_field( $field_job, $value, $post_id );

                $field_cost = "field_5bb5cdfd7e66e";
                $value = $post['apply_cost'];
                update_field( $field_cost, $value, $post_id );

                _e('Your application posted successfully');
            }else{
                _e('You have applied for this job already');
            }

        }
    }

    public static function check_can_apply($contractor, $job){
        $contractor_data = get_userdata($contractor);

        $contractor_role = $contractor_data->roles;
        if( $contractor_role[0] != 'contributor') {
            return false;
        }else{
            $args = array(
                'post_type'     => 'bidding',
                'meta_query' => array(
                    'relation'      => 'AND',
                    array(
                        'key' => 'contractor',
                        'value'   => $contractor,
                        'compare' => '=',
                    ),
                    array(
                        'key' => 'job',
                        'value'   => $job,
                        'compare' => '='
                    )
                ));
            $query = new WP_Query( $args );
            return $query->post_count > 0 ? false : true;
        }

    }
}
