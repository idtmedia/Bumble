<?php

/*
* Add your own functions here. You can also copy some of the theme functions into this file. 
* Wordpress will use those functions instead of the original functions then.
*/
/* enqueue parent stylesheet */
function pacz_enqueue_styles()
{

    $parent_style = 'parent-style';

    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style), time()
    );
}

add_action('wp_enqueue_scripts', 'pacz_enqueue_styles');

add_action('wp_head', 'font_stye_addddd', 100);

function font_stye_addddd()
{
    echo "<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet'>";
    echo "<style>";
    echo "
	
header#pacz-header {
    position: absolute;
    top: 0;
}
.promo_section_text .styles-section-title.styles-selector {
		color: #43434c;
		font-size: 19px;
		font-family: 'Open Sans', sans-serif;
		font-weight: 600;
	}
	.promo_section_text .styles-section-title.styles-selector a{
	color:#e8500e;
	}
	#theme-page .pacz-custom-heading h4 {
		color: #333333;
		font-size: 33px;
	}
	h3{
	font-size:24px;
	margin-bottom:10px;
	}
	p{
	line-height:24px;
	}
	nav#pacz-main-navigation li.logreg-header.right {
		line-height: 102px!important;
		height: auto!important;
	}
	nav#pacz-main-navigation li.logreg-header.right ul li a {
		line-height: normal!important;
		letter-spacing: normal!important;
	}
	div#footer_top_sections .wpb_wrapper {
		background: #fff;
		padding: 10px;
	}
	div#footer_top_sections {
		padding-bottom: 140px!important;
	}
	div#footer_top_sections img {
		max-height: 92px;
		width: auto;
	}
	div#footer_top_sections h3 {
		font-size: 22px;
	}
	.call_to_action .vc_general {
		background-color: transparent!important;
	}
	.call_to_action .vc_general h2 {
		color: #fff!important;
		font-size: 27px;
		    margin-bottom: 0;
	}
	.call_to_action .vc_general .vc_cta3_content-container {
		display: flex!important;
		align-items: center;
		justify-content: space-between;
	}
	.call_to_action .vc_general a.vc_general.vc_btn3 {
    background: #ff0000!important;
    letter-spacing: 2px;
    font-weight: 700;
    font-size: 15px;
	padding: 16px 42px;
}
#comments {
    padding-top: 0;
}
.call_to_action .vc_cta3-container {
    margin-bottom: 0;
}
.author-displayname,span.author-nicename {
    color: #fff !important;
}
nav#pacz-main-navigation li.listing-btn.right {
    height: auto;
    line-height: 101px;
}
span.pacz-footer-copyright {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
}
.footer-btoom_1 h3 {
    color: #fff;
}
#sub-footer .pacz-footer-social li a {
     padding: 0;
    width: auto;
    height: auto;
    margin-right: 4px;
}
.pacz-footer-social li i {
    font-size: 32px;
    line-height: 47px;
}
.footer_bot_3 a {
    font-size: 24px;
    color: #fbd143!important;
    font-weight: 600;
}
.social-network-wrapper{
height:36px;
}
div#sub-footer {
    padding-bottom: 26px;
}
html body #sub-footer .pacz-footer-social li a i:hover, html body #sub-footer .pacz-footer-social li a:hover {
    background-color: #0000!important;
    color: #fff!important;
    border-radius: 0!important;
    background: transparent!important;
}
.how_we_work .wpb_column.vc_column_container.vc_col-sm-4{

position:relative}
.how_we_work .wpb_column.vc_column_container.vc_col-sm-4:nth-child(1):after{
    content: '';
    background: url(http://pwmhosting.ca/bumble/wp-content/themes/classiadspro-child/img/one_two.png) no-repeat center center;
    /* display: block; */
    position: absolute;
    top: 15px;
    right: -27%;
    display: block;
    /* z-index: 9; */
    width: 192px;
    height: 50px;
}
.how_we_work .wpb_column.vc_column_container.vc_col-sm-4:nth-child(2):after{
    content: '';
    background: url(http://pwmhosting.ca/bumble/wp-content/themes/classiadspro-child/img/two_to_three.png) no-repeat center center;
    position: absolute;
    top: 15px;
    right: -13%;
    display: block;
    width: 192px;
    height: 50px;
}
header#pacz-header {
    position: relative;
    top: 0;
}
#pacz-main-navigation > ul > li.menu-item > a, .pacz-vertical-menu li.menu-item > a {
    color: #000;
    background-color: ;
}
.home #pacz-main-navigation > ul > li.menu-item > a, .pacz-vertical-menu li.menu-item > a {
    color: #fff;
}
#pacz-main-navigation > ul > li.menu-item{
height:auto!important;
}
li.pacz-header-logo {
    max-height: 78px;
}
ul#menu-main li.pacz-header-logo a {
    line-height: 78px!important;
    height: 78px!important;
    display: block;
}
.home li.pacz-header-logo {
    max-height:none;
}
.home ul#menu-main li.pacz-header-logo a {
    line-height: auto!important;
    height: auto!important;
    display: block;
}
#pacz-page-title {
	padding-top: 99px !important;
    height: 238px !important;
}
#pacz-page-title.left-align .pacz-page-heading {
    background: #ef114c;
    padding: 5px 20px 2px;
}
#pacz-main-navigation ul .logreg-header.right .pacz-register-2 {
	background: #ef114c;
	line-height: 34px !important;
	margin-left: 10px;
	color: #fff !important;
}
#pacz-main-navigation ul .logreg-header.right .pacz-login-2.clearfix {
    background: #000;
    line-height: 34px !important;
}
nav#pacz-main-navigation li.listing-btn.right {
    height: auto!important;
    line-height: 101px!important;
}
.listing-btn .listing-header-btn,.pacz-login-2.clearfix,.pacz-register-2{
font-weight:700;
font-size:14px;
}
.home header#pacz-header {
    box-shadow: 0 0 0 transparent;
}
.pacz-header-mainnavbar .pacz-grid.clearfix {
    width: 100%!important;
    max-width: 100%!important;
    padding-left: 30px!important;
    padding-right: 30px!important;
}
.user-panel-main .sidebar-menu li a {
    background-color: #ee2f2f;
}
.user-panel-main .sidebar-menu li a {
    background-color: #fad03d!important;
   color:#000!important;
}
.user-panel-main .sidebar-menu li a:hover {
    color: #fff!important;
    background-color: #ee2f2f!important;
}
.main-header .sidebar-toggle, .main-header .sidebar-toggle:hover {
    background: #ee2f2f;
}
nav#pacz-main-navigation ul ul.sub-menu li, nav#pacz-main-navigation ul ul.sub-menu li a {
    line-height: normal!important;
    height: auto!important;
    color: #000;
    font-weight: 700;
    padding-top: 5px;
    padding-bottom: 5px;
    text-transform: uppercase;
}
nav#pacz-main-navigation ul ul.sub-menu li a:hover{
color:#000!important;
}
.alsp-single-listing-logo-wrap.style2 .owl-item a i{
background-color: transparent;
}
.main-navigation-ul > li.menu-item ul.sub-menu:after {
    background: #f5f5f5;
}
.alsp-popup-title, .popup-inner .sub-level-cat .categories-title {
    background: #fad03d;
}
.main-header {
    background: #333333;
}
header.main-header a.logo {
    overflow: visible;
}
header.main-header a.logo img {
    max-width: 128px!important;
    position: relative;
    z-index: 9999999999;
}
	";
    echo "</style>";
}

add_role(
    'contractor',
    __('Contractor'),
    array(
        'read' => true,  // true allows this capability
        'edit_posts' => true,
    )
);

//remove_role('constractor');

// add a link to the WP Toolbar
/* function Edit_listing_custom_toolbar_link($wp_admin_bar) {
global $ALSP_ADIMN_SETTINGS;
if ($frontend_controller->listings):
			while ($frontend_controller->query->have_posts()):
				$frontend_controller->query->the_post();
				 $listing = $frontend_controller->listings[get_the_ID()];
 
endwhile;
endif;
	$args = array(
		'id' => 'sing_listing',
		'title' => 'Edit Listing', 
		'href' => get_permalink(). $listing->post->ID, 
		'meta' => array(
			'class' => 'single_listanig'
			)
	);
	$wp_admin_bar->add_node($args);
}
add_action('admin_bar_menu', 'Edit_listing_custom_toolbar_link', 999); 

 add_shortcode('imageforemail','daynamic_image_for_email');

function daynamic_image_for_email(){
	$html = "Hello HTML LInk";
	return $html;
}
*/


add_filter('wp_new_user_notification_email', 'custom_wp_new_user_notification_email', 10, 3);

function custom_wp_new_user_notification_email($wp_new_user_notification_email, $user, $blogname)
{
    $wp_new_user_notification_email['subject'] = sprintf('[%s] New user %s test registered.', $blogname, $user->user_login);
    $wp_new_user_notification_email['message'] = sprintf("%s ( %s ) test has registerd to your blog %s.", $user->user_login, $user->user_email, $blogname);
    return $wp_new_user_notification_email;
}

/*add_action('wp', 'unpublish_expired_listings_hourly');
function unpublish_expired_listings_hourly()
{
    if (!wp_next_scheduled('unpublish_expired_listings')) {
        wp_schedule_event(time(), 'hourly', 'unpublish_expired_listings');
    }
}

add_action('unpublish_expired_listings', 'unpublish_expired_listings_callback');

//https://wordpress.stackexchange.com/questions/152786/posts-to-expire-deleted-after-a-date
function unpublish_expired_listings_callback()
{
    $args = array(
        'post_type' => 'alsp_listing',
        'posts_per_page' => -1
    );

    $listings = new WP_Query($args);
    if ($listings->have_posts()):
        while ($listings->have_posts()): $listings->the_post();

            $duration = get_post_meta(get_the_ID(), '_content_field_38', true);
            if ($duration > 0) {
                switch ($duration) {
                    case 1:
                        $life_time = 259200;
                        break;
                    case 2:
                        $life_time = 604800;
                        break;
                    case 3:
                        $life_time = 1209600;
                        break;
                    case 4:
                    default:
                        $life_time = 2592000;
                        break;
                }
                $expiration_date_time = get_the_time('U') + $life_time;
                if ($expiration_date_time < time()) {
//                    $post = array('ID' => get_the_ID(), 'post_status' => 'draft');
//                    wp_update_post($post);
//                    $status = array('expired');
                    update_post_meta(get_the_ID(), '_listing_status', 'expired');
                }
            }
        endwhile;
    endif;
}*/

//Add new customer fields: city, country, zip code

// Add User Contact Methods
function createiveosc_user_contact_methods($createiveosc_user_contact)
{
    $createiveosc_user_contact['city'] = __('City', 'classiadspro-child');
    $createiveosc_user_contact['postalcode'] = __('Postal Code', 'classiadspro-child');
    $createiveosc_user_contact['state'] = __('State', 'classiadspro-child');
    $createiveosc_user_contact['country'] = __('Country', 'classiadspro-child');

    return $createiveosc_user_contact;
}

add_filter('user_contactmethods', 'createiveosc_user_contact_methods');

/*function creativeosc_get_email(){
    if(isset($_POST['cvf_action']) && $_POST['cvf_action'] == 'get_email' && ( $_POST['postalcode']!="" )) {
        // echo $_POST['postalcode'];
        // $responses = wp_remote_get('https://represent.opennorth.ca/postcodes/L5G4L3/');
        if( is_wp_error( $request ) ) {
            echo 'not found';
        }else{
            $request = wp_remote_get( 'https://represent.opennorth.ca/postcodes/'.$_POST['postalcode'].'/' );
            $body = wp_remote_retrieve_body( $request );
            $data = json_decode( $body );
            if( ! empty( $data ) ) {
                $email = array();
                foreach( $data->representatives_centroid as $centroid ) {
                    $email[] = $centroid->email;
                }
                echo implode(',', $email);
            }
        }

    }
    // Always exit to avoid further execution
    exit();
}
add_action('wp_ajax_creativeosc_get_email', 'creativeosc_get_email');
add_action('wp_ajax_nopriv_creativeosc_get_email', 'creativeosc_get_email');*/

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = '167.114.84.132';//default return Montreal/Quebec
//    return '167.114.84.132';
    return $ipaddress;
}

function get_current_address(){
    $data = array();
    $ip_address = get_client_ip();
    $geo_data = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip_address));
    $data['city'] = $geo_data['geoplugin_city'];
    $data['state'] = $geo_data['geoplugin_region'];
    $data['state_code'] = $geo_data['geoplugin_regionCode'];
    return $data;
}

function get_current_city_state(){
    $current_address = get_current_address();
    $current_city_state = $current_address['city'].', '. $current_address['state_code'];
    return $current_city_state;
}

function get_amount_matched_location(){
    $current_address = get_current_address();
    $args = array(
       'role' => 'Contributor',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key'     => 'city',
//                'value'   => 'Montreal',
                'value'   => $current_address['city'],
                'compare' => '='
            ),
            array(
                'key'     => 'state',
//                'value'   => 'Quebec',
                'value'   =>  $current_address['state'],
                'compare' => '='
            )
        )
    );

    $contractors = new WP_User_Query( $args );

    return $contractors->get_total();
}

/*
     * Add columns to exhibition post list
     */
function add_acf_columns ( $columns ) {
    return array_merge ( $columns, array (
        'contractor' => __ ( 'Contractor' ),
        'rater'   => __ ( 'Rated By' ),
        'score'   => __ ( 'Score' ),
    ) );
}
add_filter ( 'manage_ratingcontractor_posts_columns', 'add_acf_columns' );

/*
* Add columns to ratingcontractor post list
*/
function exhibition_custom_column ( $column, $post_id ) {

    switch ( $column ) {
        case 'contractor':
            $user_info = get_userdata(get_post_meta ( $post_id, 'contractor', true ));
            echo $user_info->user_login;
            break;
        case 'rater':
            $user_info = get_userdata(get_post_meta ( $post_id, 'rater', true ));
            echo $user_info->user_login;
            //echo get_post_meta ( $post_id, 'rater', true );
            break;
        case 'score':
            echo get_post_meta ( $post_id, 'score', true );
            break;
    }
}
add_action ( 'manage_ratingcontractor_posts_custom_column', 'exhibition_custom_column', 10, 2 );

function get_current_user_role() {
    if(is_user_logged_in()) {
        $user = wp_get_current_user();
        $role = (array) $user->roles;
        return $role[0];
    }
    else {
        return false;
    }
}

add_action( 'user_register', 'creativeosc_user_register' );
function creativeosc_user_register( $user_id ) {
    if ( ! empty( $_POST['address'] ) ) {
        update_user_meta( $user_id, 'address', $_POST['address'] );
    }
    if ( ! empty( $_POST['city'] ) ) {
        update_user_meta( $user_id, 'city', $_POST['city'] );
    }
    if ( ! empty( $_POST['state'] ) ) {
        update_user_meta( $user_id, 'state', $_POST['state'] );
    }
    if ( ! empty( $_POST['postalcode'] ) ) {
        update_user_meta( $user_id, 'postalcode', $_POST['postalcode'] );
    }
    if ( ! empty( $_POST['country'] ) ) {
        update_user_meta( $user_id, 'country', $_POST['country'] );
    }
}

// remove wp version param from any enqueued scripts
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );

function creativeosc_jb_applications_status(){
//    var_dump($_POST);
    if(isset($_POST['action']) && $_POST['action'] == 'jb_applications_status' && $_POST['id']>0) {
        $bid_id = $_POST['id'];
        $job = get_field('job', $bid_id);
        $contractor = get_field('contractor', $bid_id);
        $bid_status = $_POST['status'];
        update_field('bid_status', $bid_status, $bid_id );
        if($bid_status=='Accepted'){
            update_post_meta($job->ID, '_listing_status', 'expired');
            WP_Mail::init()
                ->to($contractor['user_email'])//$contractor['user_email']
                ->subject('Your application has been accepted in '.get_bloginfo('name'))
                ->template( get_stylesheet_directory(). '/emails/application-status.html' , [
                    'job' => $job->post_title,
                    'dashboard_link' => alsp_dashboardUrl(array('alsp_action' => 'messages')),
                ])
                ->send();
        }

        return true;

    }else{
        return false;
    }
    // Always exit to avoid further execution
    exit();
}
add_action('wp_ajax_jb_applications_status', 'creativeosc_jb_applications_status');
add_action('wp_ajax_nopriv_jb_applications_status', 'creativeosc_jb_applications_status');

/**
 * @snippet       WooCommerce Only one product in cart
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode    https://businessbloomer.com/?p=560
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 3.4.3
 */

/* Clear cart data before adding new */
// before addto cart, only allow 1 item in a cart
/*add_filter( 'woocommerce_add_to_cart_validation', 'woo_custom_add_to_cart_before' );

function woo_custom_add_to_cart_before( $cart_item_data ) {

    global $woocommerce;
    $woocommerce->cart->empty_cart();

    // Do nothing with the data and return
    return true;
}*/

add_filter( 'woocommerce_thankyou_order_received_text', 'avia_thank_you' );
function avia_thank_you() {
    $added_text = '<p class="woocommerce-thanks-text">'._('Your order has been successfully placed - your job posting will now appear first on all listings.').'</p>';
    return $added_text ;
}