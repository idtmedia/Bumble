<?php
/**
* Class and Function List:
* Function list:
* - init()
* - constants()
* - widgets()
* - supports()
* - functions()
* - language()
* - add_metaboxes()
* - admin()
* - post_types()
* - pacz_theme_enqueue_scripts()
* - pacz_preloader_script() 
*/
function classiadspro_load_textdomain() {
    load_theme_textdomain( 'classiadspro', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'classiadspro_load_textdomain' );
$theme = new Classiadspro_Theme();
$theme->init(array(
		"theme_name" => "Classiadspro",
		"theme_slug" => "classiadspro",
));

class Classiadspro_Theme
{
		function init($options)
		{
				$this->pacz_constants($options);
				$this->pacz_functions();
				$this->pacz_admin();
				
				add_action('init', array(&$this,
						'pacz_add_metaboxes',
				));
				
				add_action('after_setup_theme', array(&$this,
						'pacz_supports',
				));
				add_action('widgets_init', array(&$this,
						'pacz_widgets',
				));
				//include_once PACZ_THEME_DIR . '/header-builder/class-mkhb-main.php';
				
				
		}
		
		function pacz_constants($options)
		{		
				$pacz_parent_theme = get_file_data(
			get_template_directory() . '/style.css',
			array( 'Asset Version' ),
			get_template()
		);
				define("PACZ_THEME_DIR", get_template_directory());
				define("PACZ_THEME_DIR_URI", get_template_directory_uri());
				define("PACZ_THEME_NAME", $options["theme_name"]);
				define("CLASSIADSPRO_THEME_OPTIONS_BUILD", $options["theme_name"] . '_options_build');
				define("PACZ_THEME_SLUG", $options["theme_slug"]);
				define("PACZ_THEME_STYLES", PACZ_THEME_DIR_URI . "/styles/css");
				define("PACZ_THEME_IMAGES", PACZ_THEME_DIR_URI . "/images");
				define("PACZ_THEME_JS", PACZ_THEME_DIR_URI . "/js");
				define("PACZ_THEME_INCLUDES", PACZ_THEME_DIR . "/includes");
				define("PACZ_THEME_FRAMEWORK", PACZ_THEME_INCLUDES . "/framework");
				define("PACZ_THEME_ACTIONS", PACZ_THEME_INCLUDES . "/actions");
				define("PACZ_THEME_PLUGINS_CONFIG", PACZ_THEME_INCLUDES . "/plugins-config");
				define("PACZ_THEME_PLUGINS_CONFIG_URI", PACZ_THEME_DIR_URI . "/includes/plugins-config");
				define('PACZ_THEME_METABOXES', PACZ_THEME_FRAMEWORK . '/metaboxes');
				define('PACZ_THEME_ADMIN_URI', PACZ_THEME_DIR_URI . '/includes');
				define('PACZ_THEME_ADMIN_ASSETS_URI', PACZ_THEME_DIR_URI . '/includes/assets');
				define( 'THEME_VERSION', $pacz_parent_theme[0] );
		}
		
		function pacz_widgets()
		{
				require_once (trailingslashit( get_template_directory() ).'includes/custom-post/widgets/widgets-popular-posts.php');
				require_once (trailingslashit( get_template_directory() )."includes/custom-post/widgets/widgets-recent-posts.php");
				require_once (trailingslashit( get_template_directory() )."includes/custom-post/widgets/widgets-video.php");
				require_once (trailingslashit( get_template_directory() )."includes/custom-post/widgets/widgets-comments.php");
				require_once (trailingslashit( get_template_directory() )."includes/custom-post/widgets/widgets-custom-menu.php");
				require_once (trailingslashit( get_template_directory() )."includes/custom-post/widgets/widgets-image.php");
				require_once (trailingslashit( get_template_directory() )."includes/custom-post/widgets/widgets-about.php");
				require_once (trailingslashit( get_template_directory() )."includes/custom-post/widgets/widgets-flickr-feeds.php");
				require_once (trailingslashit( get_template_directory() )."includes/custom-post/widgets/widgets-author.php");
				require_once (trailingslashit( get_template_directory() )."includes/custom-post/widgets/widgets-social-networks.php");
				require_once (trailingslashit( get_template_directory() )."includes/custom-post/widgets/widgets-subscription.php");

				register_widget("Classiadspro_Widget_Popular_Posts");
				register_widget("Classiadspro_Widget_Recent_Posts");
				register_widget("Classiadspro_Widget_Video");
				register_widget("Classiadspro_Widget_Flickr_Feeds");
				register_widget("Classiadspro_WP_Widget_Recent_Comments");
				register_widget("Classiadspro_WP_Nav_Menu_Widget");
				register_widget("Classiadspro_Widget_Image");
				register_widget("Classiadspro_Widget_About");
				register_widget("Classiadspro_Widget_Author");
				register_widget("Classiadspro_Widget_Social");
				register_widget("Classiadspro_Widget_Subscription_Form");
		}
		
		function pacz_supports()
		{
				global $pacz_settings;
				$content_width = '';
				if (!isset($content_width)) {
						$content_width = $pacz_settings['grid-width'];
				}
				
				if (function_exists('add_theme_support')) {
						add_theme_support('menus');
						add_theme_support('automatic-feed-links');
						add_theme_support('editor-style');
						add_theme_support( 'title-tag' );
						add_theme_support( 'custom-header' );
						add_theme_support( 'custom-background' );
						/* Add Woocmmerce support */
						add_theme_support('woocommerce');
						
						add_theme_support('post-formats', array(
								'image',
								'video',
								'quote',
								'link'
						));
						register_nav_menus(array(
								'primary-menu' => 'Primary Navigation',
								'second-menu' => 'Second Navigation',
								'third-menu' => 'Third Navigation',
								'fourth-menu' => 'Fourth Navigation',
								'fifth-menu' => 'Fifth Navigation',
								'sixth-menu' => 'Sixth Navigation',
								'seventh-menu' => 'Seventh Navigation',
						));
						
						add_theme_support('post-thumbnails');
				}
		}
		
		function pacz_functions()
		{
				require_once PACZ_THEME_FRAMEWORK . "/ReduxCore/framework.php";
				require_once PACZ_THEME_FRAMEWORK . "/ReduxCore/options-config.php";
				require_once PACZ_THEME_FRAMEWORK . "/general.php";
				require_once PACZ_THEME_FRAMEWORK . "/woocommerce.php";
				require_once PACZ_THEME_PLUGINS_CONFIG . "/ajax-search.php";
				require_once PACZ_THEME_PLUGINS_CONFIG . "/wp-nav-custom-walker.php";
				require_once PACZ_THEME_FRAMEWORK . '/sidebar-generator.php';
				require_once PACZ_THEME_PLUGINS_CONFIG . "/pagination.php";
				require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";
				//require_once PACZ_THEME_FRAMEWORK . "/dynamic-helper.php";
				//require_once PACZ_THEME_FRAMEWORK . "/dynamic.php";
				require_once PACZ_THEME_PLUGINS_CONFIG . "/tgm-plugin-activation/request-plugins.php";
				
				require_once PACZ_THEME_PLUGINS_CONFIG . "/love-this.php";
				//require_once PACZ_THEME_FRAMEWORK . "/theme-skin.php";
				require_once PACZ_THEME_FRAMEWORK . "/Mobile_Detect.php";
				require_once PACZ_THEME_INCLUDES . "/thirdparty-integration/wpml-fix/pacz-wpml.php";
				
				/*
				Theme elements hooks
				*/
				require_once (trailingslashit( get_template_directory() )."includes/actions/header.php");
				require_once (trailingslashit( get_template_directory() )."includes/actions/posts.php");
				require_once (trailingslashit( get_template_directory() )."includes/actions/general.php");
				//require_once (trailingslashit( get_template_directory() )."includes/actions/admin_menu.php");
				
				/* Blog Styles @since V1.0 */
				require_once (trailingslashit( get_template_directory() )."includes/custom-post/blog-styles/classic.php");
				
				/* Blog Styles @since V1.0 */
				require_once (trailingslashit( get_template_directory() )."includes/custom-post/blog-styles/thumb.php");
				require_once (trailingslashit( get_template_directory() )."includes/custom-post/blog-styles/tile.php");
				require_once (trailingslashit( get_template_directory() )."includes/custom-post/blog-styles/tile-elegant.php");
				require_once (trailingslashit( get_template_directory() )."includes/custom-post/blog-styles/scroller.php");
				require_once (trailingslashit( get_template_directory() )."includes/custom-post/blog-styles/masonry.php");
				//require_once (trailingslashit( get_template_directory() )."importer/function.php");
				//require_once (trailingslashit( get_template_directory() )."demo-templates/install-template2.php");
				if(is_admin()){
					//require_once (trailingslashit( get_template_directory() )."importer/importer.inc.php");
					//require get_template_directory() .'/radium-one-click-demo-install/init.php';
				}
				
		}
		
		
		function pacz_add_metaboxes()
		{
				require_once PACZ_THEME_FRAMEWORK . '/metabox-generator.php';
				require_once PACZ_THEME_METABOXES . '/metabox-layout.php';
				require_once PACZ_THEME_METABOXES . '/metabox-posts.php';
				require_once PACZ_THEME_METABOXES . '/metabox-employee.php';
				require_once PACZ_THEME_METABOXES . '/metabox-pages.php';
				require_once PACZ_THEME_METABOXES . '/metabox-clients.php';
				require_once PACZ_THEME_METABOXES . '/metabox-testimonials.php';
				include_once PACZ_THEME_METABOXES . '/metabox-skinning.php';
				include_once PACZ_THEME_METABOXES . '/metabox-woo.php';
		}
		
		function pacz_admin()
		{
				if (is_admin()) {
						
						require_once PACZ_THEME_FRAMEWORK . '/admin.php';
						require_once PACZ_THEME_PLUGINS_CONFIG . '/mega-menu.php';
						require_once PACZ_THEME_FRAMEWORK . '/icon-library.php';
						
				}
		}
		
		
}

function pacz_theme_enqueue_scripts()
{
		if (!is_admin()) {
				
				global $pacz_settings;
				$theme_data = wp_get_theme("classiadspro");
				
				wp_enqueue_script('jquery-ui-tabs');
				wp_register_script('jquery-jplayer', PACZ_THEME_JS . '/jquery.jplayer.min.js', array(
						'jquery'
				) , $theme_data['Version'], true);
				wp_register_script('instafeed', PACZ_THEME_JS . '/instafeed.min.js', array(
						'jquery'
				) , $theme_data['Version'], true);
				if ( ! wp_script_is( 'bootstrap', 'enqueued' ) ) {
				wp_enqueue_script('bootstrap', PACZ_THEME_JS . '/bootstrap.min.js', array(
						'jquery'
				) , $theme_data['Version'], true);
				}
				if ( ! wp_script_is( 'select2', 'enqueued' ) ) {
				wp_enqueue_script('select2', PACZ_THEME_JS . '/select2.min.js', array(
						'jquery'
				) , $theme_data['Version'], true);
				}
				if ( ! wp_script_is( 'owl.carousel', 'enqueued' ) ) {
				wp_enqueue_script('owl.carousel', PACZ_THEME_JS . '/owl.carousel.min.js', array(
						'jquery'
				) , $theme_data['Version'], true);
				}
				wp_enqueue_script('pacz-triger', PACZ_THEME_JS . '/triger.min.js', array(
						'jquery'
				) , $theme_data['Version'], true);
				wp_enqueue_script('pacz-theme-plugins', PACZ_THEME_JS . '/plugins.min.js', array(
						'jquery'
				) , $theme_data['Version'], true);
				if ($pacz_settings['minify-js']) {
					wp_enqueue_script('pacz-theme-scripts', PACZ_THEME_JS . '/theme-scripts.min.js', array(
							'jquery'
					) , $theme_data['Version'], true);
				}else{
					wp_enqueue_script('pacz-theme-scripts', PACZ_THEME_JS . '/theme-scripts.js', array(
						'jquery'
					) , $theme_data['Version'], true);
				}
				$custom_js_file = get_stylesheet_directory() . '/custom.js';
				$custom_js_file_uri = get_stylesheet_directory_uri() . '/custom.js';
				
				if (file_exists($custom_js_file)) {
						wp_enqueue_script('pacz-custom-js', $custom_js_file_uri, array(
								'jquery'
						) , $theme_data['Version'], true);
				}
				if (is_rtl() ) {
				  wp_enqueue_script('pacz-vc-rtl-fix', PACZ_THEME_JS . '/vc-rtl-fix.min.js', array(
								'jquery'
						) , $theme_data['Version'], true);
				}
				
				if (is_singular()) {
						wp_enqueue_script('comment-reply');
				}
				if($pacz_settings['minify-css']){
					$css_min = '.min';
				}else{
					$css_min = '';
				}
				if ( ! wp_style_is( 'bootstrap', 'enqueued' ) ) {
					wp_enqueue_style('bootstrap', PACZ_THEME_STYLES . '/bootstrap.min.css', false, $theme_data['Version'], 'all');
				}
				wp_enqueue_style('pacz-styles-default', PACZ_THEME_STYLES . '/styles' . $css_min . '.css', false, $theme_data['Version'], 'all');
				wp_enqueue_style('pacz-styles', PACZ_THEME_STYLES . '/pacz-styles' . $css_min . '.css', false, $theme_data['Version'], 'all');
				wp_enqueue_style('pacz-blog', PACZ_THEME_STYLES . '/pacz-blog' . $css_min . '.css', false, $theme_data['Version'], 'all');
				if(!class_exists('Classiadspro_Static_Files')){
					wp_enqueue_style('pacz-dynamic-css', PACZ_THEME_STYLES . '/classiadspro-dynamic.css', false, $theme_data['Version'], 'all');
					wp_add_inline_style('pacz-dynamic-css', pacz_enqueue_font_icons());
				}
				wp_enqueue_style('pacz-common-shortcode', PACZ_THEME_STYLES . '/shortcode/common-shortcode' . $css_min . '.css', false, $theme_data['Version'], 'all');
				wp_enqueue_style('pacz-fonticon-custom', PACZ_THEME_STYLES . '/fonticon-custom.min.css', false, $theme_data['Version'], 'all');
				
		}
}

add_action('wp_enqueue_scripts', 'pacz_theme_enqueue_scripts', 1);


/*==========================
 This snippet contains utility functions to create/update and pull data from the active user transient.
 Copy these contents to functions.php
 ===========================*/
//Update user online status
add_action('init', 'gearside_users_status_init');
add_action('admin_init', 'gearside_users_status_init');
function gearside_users_status_init(){
	$logged_in_users = get_transient('users_status'); //Get the active users from the transient.
	$user = wp_get_current_user(); //Get the current user's data
	//Update the user if they are not on the list, or if they have not been online in the last 900 seconds (15 minutes)
	if ( !isset($logged_in_users[$user->ID]['last']) || $logged_in_users[$user->ID]['last'] <= time()-900 ){
		$logged_in_users[$user->ID] = array(
			'id' => $user->ID,
			'username' => $user->user_login,
			'last' => time(),
		);
		set_transient('users_status', $logged_in_users, 900); //Set this transient to expire 15 minutes after it is created.
	}
}
//Check if a user has been online in the last 15 minutes
function gearside_is_user_online($id){	
	$logged_in_users = get_transient('users_status'); //Get the active users from the transient.
	
	return isset($logged_in_users[$id]['last']) && $logged_in_users[$id]['last'] > time()-900; //Return boolean if the user has been online in the last 900 seconds (15 minutes).
}
//Check when a user was last online.
function gearside_user_last_online($id){
	$logged_in_users = get_transient('users_status'); //Get the active users from the transient.
	
	//Determine if the user has ever been logged in (and return their last active date if so).
	if ( isset($logged_in_users[$id]['last']) ){
		return $logged_in_users[$id]['last'];
	} else {
		return false;
	}
}

/*==========================
 This snippet shows how to add a column to the Users admin page with each users' last active date.
 Copy these contents to functions.php
 ===========================*/
 
 //Add columns to user listings
add_filter('manage_users_columns', 'gearside_user_columns_head');
function gearside_user_columns_head($defaults){
    $defaults['status'] = 'Status';
    return $defaults;
}
add_action('manage_users_custom_column', 'gearside_user_columns_content', 15, 3);
function gearside_user_columns_content($value='', $column_name, $id){
    if ( $column_name == 'status' ){
		if ( gearside_is_user_online($id) ){
			return '<strong style="color: green;">Online Now</strong>';
		} else {
			return ( gearside_user_last_online($id) )? '<small>Last Seen: <br /><em>' . date('M j, Y @ g:ia', gearside_user_last_online($id)) . '</em></small>' : ''; //Return the user's "Last Seen" date, or return empty if that user has never logged in.
		}
	}
}

/*==========================
 This snippet shows how to add an active user count to the WordPress Dashboard.
 Copy these contents to functions.php
 ===========================*/
//Active Users Metabox
add_action('wp_dashboard_setup', 'gearside_activeusers_metabox');
function gearside_activeusers_metabox(){
	global $wp_meta_boxes;
	wp_add_dashboard_widget('gearside_activeusers', 'Active Users', 'dashboard_gearside_activeusers');
}
function dashboard_gearside_activeusers(){
		$user_count = count_users();
		$users_plural = ( $user_count['total_users'] == 1 )? 'User' : 'Users'; //Determine singular/plural tense
		echo '<div><a href="users.php">' . $user_count['total_users'] . ' ' . $users_plural . '</a> <small>(' . gearside_online_users('count') . ' currently active)</small></div>';
}
//Get a count of online users, or an array of online user IDs.
//Pass 'count' (or nothing) as the parameter to simply return a count, otherwise it will return an array of online user data.
function gearside_online_users($return='count'){
	$logged_in_users = get_transient('users_status');
	
	//If no users are online
	if ( empty($logged_in_users) ){
		return ( $return == 'count' )? 0 : false; //If requesting a count return 0, if requesting user data return false.
	}
	
	$user_online_count = 0;
	$online_users = array();
	foreach ( $logged_in_users as $user ){
		if ( !empty($user['username']) && isset($user['last']) && $user['last'] > time()-900 ){ //If the user has been online in the last 900 seconds, add them to the array and increase the online count.
			$online_users[] = $user;
			$user_online_count++;
		}
	}
	return ( $return == 'count' )? $user_online_count : $online_users; //Return either an integer count, or an array of all online user data.

}


function pacz_preloader_script()
{
		
		if (!global_get_post_id()) {
				return false;
		}
		
		$preloader = get_post_meta(global_get_post_id() , '_preloader', true);
		
		if ($preloader == 'true') {
				wp_enqueue_script('QueryLoader', PACZ_THEME_JS . '/jquery.queryloader2-min.js', array(
						'jquery'
				) , false, false);
		}
}
// wp-content/plugins/user-emails/user-emails.php
 
/**
 * redefine new user notification function
 *
 * emails new users their login info
 *
 * @author  Joe Sexton <joe@webtipblog.com>
 * @param   integer $user_id user id
 * @param   string $plaintext_pass optional password
 */

 
/**
 * wpmail_content_type
 * allow html emails
 *
 * @author Joe Sexton <joe@webtipblog.com>
 * @return string
 */
function wpmail_content_type() {
 
    return 'text/html';
}

add_action('wp_enqueue_scripts', 'pacz_preloader_script', 1);

/* header script */

add_action('wp_enqueue_scripts', 'pacz_header_scripts', 1);
function pacz_header_scripts() { 
global $pacz_settings, $pacz_accent_color, $post, $classiadspro_json,$level_num,$uID;
 $post_id = global_get_post_id();



?>

<script type="text/javascript">

        // Declare theme scripts namespace
        var classiadspro = {};
        var php = {};

        var pacz_images_dir = "<?php echo esc_url(PACZ_THEME_IMAGES); ?>",
        pacz_theme_dir = "<?php echo esc_url(PACZ_THEME_DIR_URI); ?>",
        pacz_theme_js_path = "<?php echo esc_url(PACZ_THEME_JS);  ?>",
		pacz_captcha_placeholder = "<?php echo esc_html_e('Enter Captcha', 'classiadspro') ?>",
		pacz_captcha_invalid_txt = "<?php echo esc_html_e('Invalid. Try again.', 'classiadspro') ?>",
		pacz_header_toolbar = "<?php (get_post_meta( $post_id, '_header_toolbar', true ) =='true') ?  get_post_meta( $post_id, '_header_toolbar', true ) : $pacz_settings['header-toolbar']; ?>",
        pacz_captcha_correct_txt = "<?php echo esc_html_e('Captcha correct.', 'classiadspro') ?>",
        pacz_nav_res_width = <?php echo esc_js($pacz_settings['res-nav-width']); ?>,
        pacz_header_sticky = <?php echo (get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'sticky-header', true ) : $pacz_settings['sticky-header']; ?>,
        pacz_grid_width = <?php echo esc_js($pacz_settings['grid-width']); ?>,
        pacz_preloader_logo = "<?php echo esc_url($pacz_settings['preloader-logo']['url']); ?>",
        pacz_header_padding = <?php echo esc_js($pacz_settings['header-padding']); ?>,
        pacz_accent_color = "<?php echo esc_attr($pacz_accent_color); ?>",
        pacz_squeeze_header = <?php echo isset($pacz_settings['squeeze-sticky-header']) ? $pacz_settings['squeeze-sticky-header'] : 1; ?>,
        pacz_logo_height = <?php echo ($pacz_settings['logo']['height']) ? $pacz_settings['logo']['height'] : 50; ?>,
        pacz_preloader_txt_color = "<?php echo ($pacz_settings['preloader-txt-color']) ? $pacz_settings['preloader-txt-color'] : '#fff'; ?>",
        pacz_preloader_bg_color = "<?php echo ($pacz_settings['preloader-bg-color']) ? $pacz_settings['preloader-bg-color'] : '#272e43'; ?>";
        pacz_preloader_bar_color = "<?php echo (isset($pacz_settings['preloader-bar-color'])) && (!empty($pacz_settings['preloader-bar-color'])) ? $pacz_settings['preloader-bar-color'] : $pacz_accent_color ; ?>",
        pacz_no_more_posts = "<?php echo esc_html_e('No More Posts', 'classiadspro'); ?>";
        pacz_header_structure = "<?php echo ((get_post_meta( $post_id, '_custom_bg', true ) == 'true') ? get_post_meta( $post_id, 'header-structure', true ) : $pacz_settings['header-structure']) ?>";
        pacz_boxed_header = "<?php echo ($pacz_settings['boxed-header']) ?>";
		pacz_footer_mailchimp_listid = "<?php echo ($pacz_settings['footer_mailchimp_listid']) ?>";
		pacz_login_url = "<?php echo home_url('/login/'); ?>"
        <?php if($post_id) {
            $pacz_header_trans_offset = get_post_meta($post_id, '_trans_header_offset', true ) ? get_post_meta($post_id, '_trans_header_offset', true ) : 0;
        ?> var pacz_header_trans_offset = <?php echo esc_attr($pacz_header_trans_offset); ?>;
        <?php } ?>
		<?php if(is_rtl()){ ?>
			pacz_owl_rtl =  <?php echo 'true'; ?>;
			
		<?php }else{ ?>
			pacz_owl_rtl =  <?php echo 'false'; ?>;
		<?php } ?>
</script>

<?php }

/* footer scripts */
add_action('wp_footer', 'pacz_footer_elements', 1);
function pacz_footer_elements() { 
global $pacz_settings, $pacz_accent_color, $post, $classiadspro_json;
 $post_id = global_get_post_id();


?>
<?php if($pacz_settings['custom-js']) : ?>
	<script type="text/javascript">
	<?php echo esc_js($pacz_settings['custom-js']); ?>
	</script>

<?php endif; ?>

<?php
	global $classiadspro_dynamic_styles;

	$classiadspro_dynamic_styles_ids = array();
	$classiadspro_dynamic_styles_inject = '';
	if(!empty($classiadspro_dynamic_styles)){
		$classiadspro_styles_length = count($classiadspro_dynamic_styles);
	}else{
		$classiadspro_styles_length = 0;
	}
	if ($classiadspro_styles_length > 0) {
		foreach ($classiadspro_dynamic_styles as $key => $val) { 
			$classiadspro_dynamic_styles_ids[] = $val["id"]; 
			$classiadspro_dynamic_styles_inject .= $val["inject"];
		};
	}

?>
<script type="text/javascript">
	window.$ = jQuery

	var dynamic_styles = '<?php echo pacz_clean_init_styles($classiadspro_dynamic_styles_inject); ?>';
	var dynamic_styles_ids = (<?php echo json_encode($classiadspro_dynamic_styles_ids); ?> != null) ? <?php echo json_encode($classiadspro_dynamic_styles_ids); ?> : [];

	var styleTag = document.createElement('style'),
		head = document.getElementsByTagName('head')[0];

	styleTag.type = 'text/css';
	styleTag.setAttribute('data-ajax', '');
	styleTag.innerHTML = dynamic_styles;
	head.appendChild(styleTag);


	$('.pacz-dynamic-styles').each(function() {
		$(this).remove();
	});

	function ajaxStylesInjector() {
		$('.pacz-dynamic-styles').each(function() {
			var $this = $(this),
				id = $this.attr('id'),
				commentedStyles = $this.html();
				styles = commentedStyles
						 .replace('<!--', '')
						 .replace('-->', '');

			if(dynamic_styles_ids.indexOf(id) === -1) {
				$('style[data-ajax]').append(styles);
				$this.remove();
			}

			dynamic_styles_ids.push(id);
		});
	};
</script>



<?php }

function is_contractor(){
//    return true;
	if(is_user_logged_in()){
		$user = wp_get_current_user();
		$role = ( array ) $user->roles;
		return ($role[0]=='contributor');
	}else{
		return false;
	}	
}

 ?>
