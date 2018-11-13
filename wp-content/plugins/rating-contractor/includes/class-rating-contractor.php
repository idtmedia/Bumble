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
 * @package    Rating_Contractor
 * @subpackage Rating_Contractor/includes
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
 * @package    Rating_Contractor
 * @subpackage Rating_Contractor/includes
 * @author     Ngo Ngoc Thang <thangnn1510@gmail.com>
 */
class Rating_Contractor {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Rating_Contractor_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		$this->plugin_name = 'rating-contractor';

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
	 * - Rating_Contractor_Loader. Orchestrates the hooks of the plugin.
	 * - Rating_Contractor_i18n. Defines internationalization functionality.
	 * - Rating_Contractor_Admin. Defines all hooks for the admin area.
	 * - Rating_Contractor_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rating-contractor-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rating-contractor-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-rating-contractor-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-rating-contractor-public.php';

		$this->loader = new Rating_Contractor_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Rating_Contractor_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Rating_Contractor_i18n();

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

		$plugin_admin = new Rating_Contractor_Admin( $this->get_plugin_name(), $this->get_version() );

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

		$plugin_public = new Rating_Contractor_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'create_ratingcontractor_cpt' );

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
	 * @return    Rating_Contractor_Loader    Orchestrates the hooks of the plugin.
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

	public static function post_review($post){
        if (
            ! isset( $post['post_review_nonce'] )
            || ! wp_verify_nonce( $post['post_review_nonce'], 'post_review_action' )
        ) {
            print 'Sorry, your nonce did not verify.';
        } else {
            if(Rating_Contractor::check_reviewable($post['rated_by'], $post['contractor'], $post['job'])){
                $my_review = array(
                    'post_title'	=> $post['dirrater_title'],
                    'post_content'	=> $post['comment'],
                    'post_type'		=> 'ratingcontractor',
                    'post_status'	=> 'publish'
                );
                $post_id = wp_insert_post( $my_review );

                $field_rater = "field_5ba877a62cb82";
                $value = $post['dirrater'];
                update_field( $field_rater, $value, $post_id );

                $field_user = "field_5ba876ea8c940";
                $value = $post['rated_by'];
                update_field( $field_user, $value, $post_id );

                $field_contractor = "field_5ba876b28c93f";
                $value = $post['contractor'];
                update_field( $field_contractor, $value, $post_id );

                $field_job = "field_5bc6d88ad894d";
                $value = array($post['job']);
//                var_dump($value);
                update_field( $field_job, $value, $post_id );

                _e('Thank-you for using Bumble Bidz');
            }else{
                _e('You have reviewed the contractor for the job already');
            }

        }
    }

    public static function check_reviewable($user, $contractor, $job){
        $contractor_data = get_userdata($contractor);

        $contractor_role = $contractor_data->roles;
        if($job==0) return false;
        if(!in_array(get_current_user_role(), array('subscriber', 'administrator'))){
	        return false;
        }elseif( $contractor_role[0] != 'contributor') {
            return false;
        }else{
            $args = array(
                'post_type'     => 'ratingcontractor',
                'meta_query' => array(
                    'relation'      => 'AND',
//                    array(
//                        'key' => 'job',
//                        'value'   => array($job),
//                        'compare' => 'in',
//                    ),
                    array(
                        'key' => 'contractor',
                        'value'   => $contractor,
                        'compare' => '=',
                    ),
                    array(
                        'key' => 'rater',
                        'value'   => $user,
                        'compare' => '='
                    )
                ));
            $posts = get_posts( $args );
            if(count($posts)>0){
                foreach ($posts as $post){
                    setup_postdata($post);
                    $job_data = get_field('job', $post->ID);
                    if($job_data->ID == $job){
                        return false;
                    }
                }
                return true;
            }else{
                return true;
            }
//            return count($posts) > 0 ? false : true;
        }

    }
}
