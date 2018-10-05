<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function difp_plugin_activate()
{

    _deprecated_function(__FUNCTION__, '4.4');
    //Deprecated in 4.4
    //Move inside Di_Frontend_Pm class

}

function difp_get_option($option, $default = '', $section = 'DIFP_admin_options')
{

    $options = get_option($section);

    $is_default = false;

    if (isset($options[$option])) {
        $value = $options[$option];
    } else {
        $value = $default;
        $is_default = true;
    }

    return apply_filters('difp_get_option', $value, $option, $default, $is_default);
}

function difp_update_option($option, $value = '', $section = 'DIFP_admin_options')
{

    if (empty($option))
        return false;
    if (!is_array($option))
        $option = array($option => $value);

    $options = get_option($section);

    if (!is_array($options))
        $options = array();

    return update_option($section, wp_parse_args($option, $options));
}

function difp_get_user_option($option, $default = '', $userid = '', $section = 'DIFP_user_options')
{

    $options = get_user_option($section, $userid); //if $userid = '' current user option will be return

    $is_default = false;

    if (isset($options[$option])) {
        $value = $options[$option];
    } else {
        $value = $default;
        $is_default = true;
    }

    return apply_filters('difp_get_user_option', $value, $option, $default, $userid, $is_default);
}

if (!function_exists('difp_get_plugin_caps')) :

    function difp_get_plugin_caps($edit_published = false, $for = 'both')
    {
        $message_caps = array(
            'delete_published_difp_messages' => 1,
            'delete_private_difp_messages' => 1,
            'delete_others_difp_messages' => 1,
            'delete_difp_messages' => 1,
            'publish_difp_messages' => 1,
            'read_private_difp_messages' => 1,
            'edit_private_difp_messages' => 1,
            'edit_others_difp_messages' => 1,
            'edit_difp_messages' => 1,
            'create_difp_messages' => 1,
        );

        $announcement_caps = array(
            'delete_published_difp_announcements' => 1,
            'delete_private_difp_announcements' => 1,
            'delete_others_difp_announcements' => 1,
            'delete_difp_announcements' => 1,
            'publish_difp_announcements' => 1,
            'read_private_difp_announcements' => 1,
            'edit_private_difp_announcements' => 1,
            'edit_others_difp_announcements' => 1,
            'edit_difp_announcements' => 1,
            'create_difp_announcements' => 1,
        );

        if ('difp_message' == $for) {
            $caps = $message_caps;
            if ($edit_published) {
                $caps['edit_published_difp_messages'] = 1;
            }
        } elseif ('difp_announcement' == $for) {
            $caps = $announcement_caps;
            if ($edit_published) {
                $caps['edit_published_difp_announcements'] = 1;
            }
        } else {
            $caps = array_merge($message_caps, $announcement_caps);
            if ($edit_published) {
                $caps['edit_published_difp_messages'] = 1;
                $caps['edit_published_difp_announcements'] = 1;
            }
        }
        return $caps;
    }

endif;

if (!function_exists('difp_add_caps_to_roles')) :

    function difp_add_caps_to_roles($roles = array('administrator', 'editor'), $edit_published = true)
    {

        if (!is_array($roles))
            $roles = array();

        $caps = difp_get_plugin_caps($edit_published);

        foreach ($roles as $role) {
            $role_obj = get_role($role);
            if (!$role_obj)
                continue;

            foreach ($caps as $cap => $val) {
                if ($val)
                    $role_obj->add_cap($cap);
            }
        }
    }

endif;

if (defined('WP_UNINSTALL_PLUGIN')) return;

add_action('after_setup_theme', 'difp_include_require_files');

function difp_include_require_files()
{

    $difp_files = array(
        'announcement' => DIFP_PLUGIN_DIR . 'includes/class-difp-announcement.php',
        'attachment' => DIFP_PLUGIN_DIR . 'includes/class-difp-attachment.php',
        'cpt' => DIFP_PLUGIN_DIR . 'includes/class-difp-cpt.php',
        'directory' => DIFP_PLUGIN_DIR . 'includes/class-difp-directory.php',
        'email' => DIFP_PLUGIN_DIR . 'includes/class-difp-emails.php',
        'form' => DIFP_PLUGIN_DIR . 'includes/class-difp-form.php',
        'menu' => DIFP_PLUGIN_DIR . 'includes/class-difp-menu.php',
        'message' => DIFP_PLUGIN_DIR . 'includes/class-difp-message.php',
        'shortcodes' => DIFP_PLUGIN_DIR . 'includes/class-difp-shortcodes.php',
        'main' => DIFP_PLUGIN_DIR . 'includes/difp-class.php',
        'widgets' => DIFP_PLUGIN_DIR . 'includes/difp-widgets.php'
    );
    if (defined('DOING_AJAX') && DOING_AJAX) {
        $difp_files['ajax'] = DIFP_PLUGIN_DIR . 'includes/class-difp-ajax.php';
    }

    if (is_admin()) {
        $difp_files['settings'] = DIFP_PLUGIN_DIR . 'admin/class-difp-admin-settings.php';
        $difp_files['update'] = DIFP_PLUGIN_DIR . 'admin/class-difp-update.php';
        $difp_files['pro-info'] = DIFP_PLUGIN_DIR . 'admin/class-difp-pro-info.php';
    }

    $difp_files = apply_filters('difp_include_files', $difp_files);

    foreach ($difp_files as $difp_file) {
        require_once($difp_file);
    }
}

function difp_plugin_update()
{

    _deprecated_function(__FUNCTION__, '4.9', 'Difp_Update class');

    $prev_ver = difp_get_option('plugin_version', '4.1');

    if (version_compare($prev_ver, DIFP_PLUGIN_VERSION, '!=')) {

        do_action('difp_plugin_update', $prev_ver);

        difp_update_option('plugin_version', DIFP_PLUGIN_VERSION);
    }

}

function difp_plugin_update_from_first($prev_ver)
{

    if (is_admin() && '4.1' == $prev_ver) { //any previous version of 4.1 also return 4.1
        difp_plugin_activate();
    }

}

add_action('difp_plugin_update', 'difp_plugin_update_from_first');

//add_action('after_setup_theme', 'difp_translation');

//function difp_translation()
//{
//SETUP TEXT DOMAIN FOR TRANSLATIONS
//load_plugin_textdomain('ALSP', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
//}

add_action('wp_enqueue_scripts', 'difp_enqueue_scripts');

function difp_enqueue_scripts()
{

    wp_register_style('difp-common-style', DIFP_PLUGIN_URL . 'assets/css/common-style.css');
    wp_register_style('difp-style', DIFP_PLUGIN_URL . 'assets/css/style.css');

    if (difp_page_id()) {
        if (is_page(difp_page_id()) || is_single(difp_page_id())) {
            wp_enqueue_style('difp-style');
        }
    } else {
        wp_enqueue_style('difp-style');
    }
    wp_enqueue_style('difp-common-style');
    $custom_css = trim(stripslashes(difp_get_option('custom_css')));
    if ($custom_css) {
        wp_add_inline_style('difp-common-style', $custom_css);
    }

    wp_register_script('difp-script', DIFP_PLUGIN_URL . 'assets/js/script.js', array('jquery'), '3.1', true);
    wp_localize_script('difp-script', 'difp_script',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('difp-autosuggestion')
        )
    );

    wp_register_script('difp-notification-script', DIFP_PLUGIN_URL . 'assets/js/notification.js', array('jquery'), '3.1', true);
    wp_localize_script('difp-notification-script', 'difp_notification_script',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('difp-notification'),
            'interval' => apply_filters('difp_filter_ajax_notification_interval', MINUTE_IN_SECONDS * 1000)
        )
    );


    wp_register_script('difp-replies-show-hide', DIFP_PLUGIN_URL . 'assets/js/replies-show-hide.js', array('jquery'), '3.1', true);

    wp_register_script('difp-attachment-script', DIFP_PLUGIN_URL . 'assets/js/attachment.js', array('jquery'), '4.9', true);
    wp_localize_script('difp-attachment-script', 'difp_attachment_script',
        array(
            'remove' => esc_js(__('Remove', 'ALSP')),
            'maximum' => esc_js(difp_get_option('attachment_no', 4)),
            'max_text' => esc_js(sprintf(__('Maximum %s allowed', 'ALSP'), sprintf(_n('%s file', '%s files', difp_get_option('attachment_no', 4), 'ALSP'), number_format_i18n(difp_get_option('attachment_no', 4)))))

        )
    );
    wp_register_script('difp-shortcode-newmessage', DIFP_PLUGIN_URL . 'assets/js/shortcode-newmessage.js', array('jquery'), '4.9', true);
    wp_localize_script('difp-shortcode-newmessage', 'difp_shortcode_newmessage',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'token' => wp_create_nonce('difp_message')
        )
    );
    wp_register_script('difp-shortcode-newbidding', DIFP_PLUGIN_URL . 'assets/js/shortcode-newbidding.js', array('jquery'), '4.9', true);
    wp_localize_script('difp-shortcode-newbidding', 'difp_shortcode_newbidding',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'token' => wp_create_nonce('difp_message')
        )
    );
}

function difp_page_id()
{

    return (int)apply_filters('difp_page_id_filter', difp_get_option('page_id', 0));
}

function difp_action_url($action = '', $arg = array())
{

    return difp_query_url($action, $arg);
}

function difp_query_url($action, $arg = array())
{

    $args = array('difpaction' => $action);
    $args = array_merge($args, $arg);

    if (difp_page_id()) {
        $url = esc_url(add_query_arg($args, get_permalink(difp_page_id())));
    } else {
        $url = esc_url(add_query_arg($args));
    }

    return apply_filters('difp_query_url_filter', $url, $args);
}

if (!function_exists('difp_create_nonce')) :
    /**
     * Creates a token usable in a form
     * return nonce with time
     * @return string
     */
    function difp_create_nonce($action = -1)
    {
        $time = time();
        $nonce = wp_create_nonce($time . $action);
        return $nonce . '-' . $time;
    }

endif;

if (!function_exists('difp_verify_nonce')) :
    /**
     * Check if a token is valid. Mark it as used
     * @param string $_nonce The token
     * @return bool
     */
    function difp_verify_nonce($_nonce, $action = -1)
    {

        //Extract timestamp and nonce part of $_nonce
        $parts = explode('-', $_nonce);

        // bad formatted onetime-nonce
        if (empty($parts[0]) || empty($parts[1]))
            return false;

        $nonce = $parts[0]; // Original nonce generated by WordPress.
        $generated = $parts[1]; //Time when generated

        $expire = (int)$generated + HOUR_IN_SECONDS; //We want these nonces to have a short lifespan
        $time = time();

        //Verify the nonce part and check that it has not expired
        if (!wp_verify_nonce($nonce, $generated . $action) || $time > $expire)
            return false;

        //Get used nonces
        $used_nonces = get_option('_difp_used_nonces');

        if (!is_array($used_nonces))
            $used_nonces = array();

        //Nonce already used.
        if (isset($used_nonces[$nonce]))
            return false;

        foreach ($used_nonces as $nonces => $timestamp) {
            if ($timestamp < $time) {
                //This nonce has expired, so we don't need to keep it any longer
                unset($used_nonces[$nonces]);
            }
        }

        //Add nonce to used nonces
        $used_nonces[$nonce] = $expire;
        update_option('_difp_used_nonces', $used_nonces, 'no');
        return true;
    }
endif;

function difp_error($wp_error)
{
    if (!is_wp_error($wp_error)) {
        return '';
    }
    if (count($wp_error->get_error_messages()) == 0) {
        return '';
    }
    $errors = $wp_error->get_error_messages();
    if (is_admin())
        $html = '<div id="message" class="error">';
    else
        $html = '<div class="difp-wp-error">';
    foreach ($errors as $error) {
        $html .= '<strong>' . __('Error', 'ALSP') . ': </strong>' . esc_html($error) . '<br />';
    }
    $html .= '</div>';
    return $html;
}

function difp_get_new_message_number()
{

    return difp_get_user_message_count('unread');
}

function difp_get_new_message_button()
{
    if (difp_get_new_message_number()) {
        $newmgs = '';
        //$newmgs = " <span class='difp-font-red'>";
        $newmgs .= difp_get_new_message_number();
        //$newmgs .='</span>)';
    } else {
        $newmgs = '';
    }

    return $newmgs;
}

function difp_get_new_announcement_number()
{

    return difp_get_user_announcement_count('unread');
}

function difp_get_new_announcement_button()
{
    if (difp_get_new_announcement_number()) {
        $newmgs = " (<span class='difp-font-red'>";
        $newmgs .= difp_get_new_announcement_number();
        $newmgs .= '</span>)';
    } else {
        $newmgs = '';
    }

    return $newmgs;
}

function difp_is_user_blocked($login = '')
{
    global $user_login;
    if (!$login && $user_login)
        $login = $user_login;

    if ($login) {
        $wpusers = explode(',', difp_get_option('have_permission'));

        $wpusers = array_map('trim', $wpusers);

        if (in_array($login, $wpusers))
            return true;
    } //User not logged in
    return false;
}

function difp_is_user_whitelisted($login = '')
{
    global $user_login;
    if (!$login && $user_login)
        $login = $user_login;

    if ($login) {
        $wpusers = explode(',', difp_get_option('whitelist_username'));

        $wpusers = array_map('trim', $wpusers);

        if (in_array($login, $wpusers))
            return true;
    } //User not logged in
    return false;
}

function difp_get_userdata($data, $need = 'ID', $type = 'slug')
{
    if (!$data)
        return '';

    $type = strtolower($type);

    if ('user_nicename' == $type)
        $type = 'slug';

    if (!in_array($type, array('id', 'slug', 'email', 'login')))
        return '';

    $user = get_user_by($type, $data);

    if ($user && in_array($need, array('ID', 'user_login', 'display_name', 'user_email', 'user_nicename', 'user_registered')))
        return $user->$need;
    else
        return '';
}

function difp_get_user_message_count($value = 'all', $force = false, $user_id = false)
{
    return Difp_Message::init()->user_message_count($value, $force, $user_id);
}

function difp_get_user_announcement_count($value = 'all', $force = false, $user_id = false)
{
    return Difp_Announcement::init()->get_user_announcement_count($value, $force, $user_id);
}

function difp_get_message($id)
{
    $post = get_post($id);

    if ($post && in_array(get_post_type($post), array('difp_message', 'difp_announcement'))) {
        return $post;
    } else {
        return null;
    }

}

function difp_get_replies($id)
{
    $args = array(
        'post_type' => 'difp_message',
        'post_status' => 'publish',
        'post_parent' => $id,
        'posts_per_page' => -1,
        'order' => 'ASC'
    );

    $args = apply_filters('difp_filter_get_replies', $args);

    return new WP_Query($args);
}

function difp_get_attachments($post_id = 0, $fields = '')
{

    if (!$post_id) {
        $post_id = get_the_ID();
    }

    if (!$post_id) {
        return array();
    }
    $args = array(
        'post_type' => 'attachment',
        'posts_per_page' => -1,
        'post_status' => array('publish', 'inherit'),
        'post_parent' => $post_id,
        'fields' => $fields,
    );

    $args = apply_filters('difp_filter_get_attachments', $args);

    return get_posts($args);
}

function difp_get_message_with_replies($id)
{

    $args = array(
        'post_type' => 'difp_message',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'ASC'
    );

    if ('threaded' == difp_get_message_view()) {
        $args['post_parent'] = difp_get_parent_id($id);
        $args['difp_include_parent'] = true;
    } else {
        $args['post__in'] = array($id);
    }

    $args = apply_filters('difp_filter_get_message_with_replies', $args);

    return new WP_Query($args);
}

add_filter('posts_where', 'difp_posts_where', 10, 2);

function difp_posts_where($where, $q)
{

    global $wpdb;

    if (true === $q->get('difp_include_parent') && $q->get('post_parent')) {
        $where .= $wpdb->prepare(" OR ( $wpdb->posts.ID = %d AND $wpdb->posts.post_status = %s )", $q->get('post_parent'), $q->get('post_status'));
    }

    return $where;
}

function difp_get_parent_id($id)
{

    if (!$id)
        return 0;

    do {
        $parent = $id;
    } while ($id = wp_get_post_parent_id($id));
    // climb up the hierarchy until we reach parent = 0

    return $parent;

}

add_filter('the_time', 'difp_format_date', 10, 2);

function difp_format_date($date, $d = '')
{
    global $post;

    if (is_admin() || !in_array(get_post_type(), apply_filters('difp_post_types_for_time', array('difp_message', 'difp_announcement'))))
        return $date;


    if ('0000-00-00 00:00:00' === $post->post_date) {
        $h_time = __('Unpublished', 'ALSP');
    } else {
        $m_time = $post->post_date;
        $time = strtotime($post->post_date_gmt);

        if ((abs($t_diff = time() - $time)) < DAY_IN_SECONDS) {
            $h_time = sprintf(__('%s ago', 'ALSP'), human_time_diff($time));
        } else {
            $h_time = mysql2date(get_option('date_format') . ' ' . get_option('time_format'), $m_time);
        }
    }


    return apply_filters('difp_formate_date', $h_time, $date, $d);
}

function difp_output_filter($string, $title = false)
{
    $string = stripslashes($string);

    if ($title) {
        $html = apply_filters('difp_filter_display_title', $string);
    } else {
        $html = apply_filters('difp_filter_display_message', $string);
    }

    return $html;
}

function difp_sort_by_priority($a, $b)
{
    if (!isset($a['priority']) || !isset($b['priority']) || $a['priority'] === $b['priority']) {
        return 0;
    }
    return ($a['priority'] < $b['priority']) ? -1 : 1;
}


function difp_pagination($total = null, $per_page = null, $list_class = 'difp-pagination')
{

    $filter = !empty($_GET['difp-filter']) ? $_GET['difp-filter'] : 'total';

    if (null === $total) {
        $total = difp_get_user_message_count($filter);
    }
    if (null === $per_page) {
        $per_page = difp_get_option('messages_page', 15);
    }

    $last = ceil(absint($total) / absint($per_page));

    if ($last <= 1)
        return;

    //$numPgs = $total_message / difp_get_option('messages_page',50);
    $page = (!empty($_GET['difppage'])) ? absint($_GET['difppage']) : 1;
    $links = (isset($_GET['links'])) ? absint($_GET['links']) : 2;

    $start = (($page - $links) > 0) ? $page - $links : 1;
    $end = (($page + $links) < $last) ? $page + $links : $last;

    $html = '<div class="difp-align-centre"><ul class="' . $list_class . '">';

    $class = ($page == 1) ? "disabled" : "";
    $html .= '<li class="' . $class . '"><a href="' . esc_url(add_query_arg('difppage', ($page - 1))) . '">&laquo;</a></li>';

    if ($start > 1) {
        $html .= '<li><a href="' . esc_url(add_query_arg('difppage', 1)) . '">' . number_format_i18n(1) . '</a></li>';
        $html .= '<li class="disabled"><span>...</span></li>';
    }

    for ($i = $start; $i <= $end; $i++) {
        $class = ($page == $i) ? "active" : "";
        $html .= '<li class="' . $class . '"><a href="' . esc_url(add_query_arg('difppage', $i)) . '">' . number_format_i18n($i) . '</a></li>';
    }

    if ($end < $last) {
        $html .= '<li class="disabled"><span>...</span></li>';
        $html .= '<li><a href="' . esc_url(add_query_arg('difppage', $last)) . '">' . number_format_i18n($last) . '</a></li>';
    }

    $class = ($page == $last) ? "disabled" : "";
    $html .= '<li class="' . $class . '"><a href="' . esc_url(add_query_arg('difppage', ($page + 1))) . '">&raquo;</a></li>';

    $html .= '</ul></div>';

    return $html;
}

function difp_is_user_admin()
{

    $admin_cap = apply_filters('difp_admin_cap', 'manage_options');

    return current_user_can($admin_cap);
}

function difp_current_user_can($cap, $id = false)
{
    $can = false;

    if (!is_user_logged_in() || difp_is_user_blocked()) {
        return apply_filters('difp_current_user_can', $can, $cap, $id);
    }
    $no_role_access = apply_filters('difp_no_role_access', false, $cap, $id);
    $roles = wp_get_current_user()->roles;

    switch ($cap) {
        case 'access_message':
            if (difp_is_user_whitelisted() || array_intersect(difp_get_option('userrole_access', array()), $roles) || (!$roles && $no_role_access)) {
                $can = true;
            }
            break;
        case 'send_new_message' :
            if (difp_is_user_whitelisted() || array_intersect(difp_get_option('userrole_new_message', array()), $roles) || (!$roles && $no_role_access)) {
                $can = true;
            }
            break;
        case 'send_new_message_to' :
            // $id == user_nicename
            if ($id && $id != difp_get_userdata(get_current_user_id(), 'user_nicename', 'id') && difp_current_user_can('access_message') && difp_current_user_can('send_new_message') && difp_get_user_option('allow_messages', 1, difp_get_userdata($id))) {
                $can = true;
            }
            break;
        case 'send_reply' :
            if (!$id || (!in_array(get_current_user_id(), difp_get_participants($id)) && !difp_is_user_admin()) || get_post_status($id) != 'publish') {

            } elseif (difp_is_user_whitelisted() || difp_is_user_admin() || array_intersect(difp_get_option('userrole_reply', array()), $roles) || (!$roles && $no_role_access)) {
                $can = true;
            }
            break;
        case 'view_message' :
            if ($id && ((in_array(get_current_user_id(), difp_get_participants($id)) && get_post_status($id) == 'publish') || difp_is_user_admin())) {
                $can = true;
            }
            break;
        case 'delete_message' : //only for himself
            if ($id && in_array(get_current_user_id(), difp_get_participants($id)) && get_post_status($id) == 'publish') {
                $can = true;
            }
            break;
        case 'access_directory' :
            if (difp_is_user_admin() || !difp_get_option('hide_directory', 0)) {
                $can = true;
            }
            break;
        case 'view_announcement' :
            if ($id && (((array_intersect(difp_get_participant_roles($id), $roles) || (!$roles && $no_role_access)) && get_post_status($id) == 'publish') || difp_is_user_admin() || get_post_field('post_author', $id) == get_current_user_id())) {
                $can = true;
            }
            break;
        default :
            $can = apply_filters('difp_current_user_can_' . $cap, $can, $cap, $id);
            break;
    }
    return apply_filters('difp_current_user_can', $can, $cap, $id);
}

function difp_is_read($parent = false, $post_id = false, $user_id = false)
{
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    if (!$post_id || !$user_id) {
        return false;
    }
    if ($parent) {
        if ('threaded' == difp_get_message_view()) {
            return get_post_meta(difp_get_parent_id($post_id), '_difp_parent_read_by_' . $user_id, true);
        } else {
            return get_post_meta($post_id, '_difp_parent_read_by_' . $user_id, true);
        }
    }
    $read_by = get_post_meta($post_id, '_difp_read_by', true);


    if (is_array($read_by) && in_array($user_id, $read_by)) {
        return true;
    }

    return false;
}

function difp_make_read($parent = false, $post_id = false, $user_id = false)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    if (!$post_id || !$user_id) {
        return false;
    }
    if ($parent) {
        if ('threaded' == difp_get_message_view()) {
            $return = add_post_meta(difp_get_parent_id($post_id), '_difp_parent_read_by_' . $user_id, time(), true);
        } else {
            $return = add_post_meta($post_id, '_difp_parent_read_by_' . $user_id, time(), true);
        }
        if ($return) {
            delete_user_meta($user_id, '_difp_user_message_count');
            return true;
        } else {
            return false;
        }
    }
    $read_by = get_post_meta($post_id, '_difp_read_by', true);

    if (!is_array($read_by)) {
        $read_by = array();
    }
    if (in_array($user_id, $read_by)) {
        return false;
    }
    $read_by[time()] = $user_id;

    return update_post_meta($post_id, '_difp_read_by', $read_by);

}

function difp_get_the_excerpt($count = 100, $excerpt = false)
{
    if (false === $excerpt)
        $excerpt = get_the_excerpt();
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = wp_strip_all_tags($excerpt);
    $excerpt = substr($excerpt, 0, $count);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = $excerpt . ' ...';

    return apply_filters('difp_get_the_excerpt', $excerpt, $count);
}

function difp_get_current_user_max_message_number()
{
    $roles = wp_get_current_user()->roles;

    $count_array = array();

    if ($roles && is_array($roles)) {
        foreach ($roles as $role) {
            $count = difp_get_option("message_box_{$role}", 50);
            if (!$count) {
                return 0;
            }
            $count_array[] = $count;
        }
    }
    if ($count_array) {
        return max($count_array);
    } else {
        return 0; //FIX ME. 0 = unlimited !!!!
    }
}

function difp_wp_mail_from($from_email)
{

    $email = difp_get_option('from_email', get_bloginfo('admin_email'));

    if (is_email($email)) {
        return $email;
    }
    return $from_email;

}

function difp_wp_mail_from_name($from_name)
{

    $name = stripslashes(difp_get_option('from_name', wp_specialchars_decode(get_bloginfo('name'), ENT_QUOTES)));

    if ($name) {
        return $name;
    }
    return $from_name;

}

function difp_wp_mail_content_type($content_type)
{

    $type = difp_get_option('email_content_type', 'plain_text');

    if ('html' == $type) {
        return 'text/html';
    } elseif ('plain_text' == $type) {
        return 'text/plain';
    }
    return $content_type;

}

function difp_add_email_filters($for = 'message')
{

    //add_filter( 'wp_mail_from', 'difp_wp_mail_from', 10, 1 );
    //add_filter( 'wp_mail_from_name', 'difp_wp_mail_from_name', 10, 1 );
    //add_filter( 'wp_mail_content_type', 'difp_wp_mail_content_type', 10, 1 );

    do_action('difp_action_after_add_email_filters', $for);
}

function difp_remove_email_filters($for = 'message')
{

    //remove_filter( 'wp_mail_from', 'difp_wp_mail_from', 10, 1 );
    //remove_filter( 'wp_mail_from_name', 'difp_wp_mail_from_name', 10, 1 );
    //remove_filter( 'wp_mail_content_type', 'difp_wp_mail_content_type', 10, 1 );

    do_action('difp_action_after_remove_email_filters', $for);
}

function difp_send_message($message = null, $override = array())
{
    if (null === $message) {
        $message = $_POST;
    }

    if (!empty($message['difp_parent_id'])) {
        $message['post_parent'] = absint($message['difp_parent_id']);
        $message['post_status'] = difp_get_option('reply_post_status', 'publish');
        $message['message_title'] = __('RE:', 'ALSP') . ' ' . get_the_title($message['post_parent']);
        if ('threaded' != difp_get_message_view())
            $message['message_to_id'] = difp_get_participants($message['post_parent']);
    } else {
        $message['post_status'] = difp_get_option('parent_post_status', 'publish');
        $message['post_parent'] = 0;
    }

    $message['message_post_id'] = (isset($message['message_post_id'])) ? $message['message_post_id'] : '';
    $message['message_bid'] = (isset($message['message_bid'])) ? $message['message_bid'] : '';

    $message = apply_filters('difp_filter_message_before_send', $message);

    if (empty($message['message_title']) || empty($message['message_content'])) {
        return false;
    }
    // Create post array
    $post = array(
        'post_title' => $message['message_title'],
        'post_content' => $message['message_content'],
        'post_status' => $message['post_status'],
        'post_parent' => $message['post_parent'],
        'listing_id' => $message['message_post_id'],
        'listing_bid' => $message['message_bid'],
        'post_type' => 'difp_message'
    );

    if ($override && is_array($override)) {
        $post = wp_parse_args($override, $post);
    }

    $post = apply_filters('difp_filter_message_after_override', $post);
    $listing_id = $post['listing_id'];
    $listing_bid = $post['listing_bid'];
    // Insert the message into the database
    $message_id = wp_insert_post($post);
    if (isset($message['message_post_id'])) {
        add_post_meta($message_id, '_listing_id', $listing_id);
    }
    if (isset($message['message_bid'])) {
        add_post_meta($message_id, '_listing_bid', $listing_bid);
        add_post_meta($message['message_post_id'], '_listing_bidpost', $listing_bid);
    }
    if (!$message_id || is_wp_error($message_id)) {
        return false;
    }
    $inserted_message = get_post($message_id);

    if ($inserted_message->post_parent) {

        if ('threaded' == difp_get_message_view()) {
            if (!in_array($inserted_message->post_author, difp_get_participants($inserted_message->post_parent))) {
                add_post_meta($inserted_message->post_parent, '_difp_participants', $inserted_message->post_author);
                difp_make_read(true, $message_id, $inserted_message->post_author);
            }

            $participants = difp_get_participants($inserted_message->post_parent);

            foreach ($participants as $participant) {
                if ($participant != $inserted_message->post_author) {
                    delete_post_meta($inserted_message->post_parent, '_difp_parent_read_by_' . $participant);
                    delete_user_meta($participant, '_difp_user_message_count');
                }
            }
        }
    }
    if (!$inserted_message->post_parent || ($inserted_message->post_parent && 'threaded' != difp_get_message_view())) {
        if (!empty($message['message_to_id'])) { //FRONT END message_to return id of participants
            if (is_array($message['message_to_id'])) {
                foreach ($message['message_to_id'] as $participant) {

                    if (!in_array($participant, difp_get_participants($message_id))) {
                        add_post_meta($message_id, '_difp_participants', $participant);
                        delete_user_meta($participant, '_difp_user_message_count');
                    }
                }
            } else {
                if (!in_array($message['message_to_id'], difp_get_participants($message_id))) {
                    add_post_meta($message_id, '_difp_participants', $message['message_to_id']);
                    delete_user_meta($message['message_to_id'], '_difp_user_message_count');
                }
            }
        }
        if (!in_array($inserted_message->post_author, difp_get_participants($message_id))) {
            add_post_meta($message_id, '_difp_participants', $inserted_message->post_author);
            delete_user_meta($inserted_message->post_author, '_difp_user_message_count');
        }

        difp_make_read(true, $message_id, $inserted_message->post_author);
    }

    do_action('difp_action_message_after_send', $message_id, $message, $inserted_message);

    return $message_id;
}

add_action('transition_post_status', 'difp_send_message_transition_post_status', 10, 3);

function difp_send_message_transition_post_status($new_status, $old_status, $post)
{
    if ('difp_message' != $post->post_type || $old_status === $new_status) {
        return;
    }

    if ('publish' == $new_status && 'threaded' == difp_get_message_view()) {
        if ($post->post_parent) {
            update_post_meta($post->post_parent, '_difp_last_reply_by', $post->post_author);
            update_post_meta($post->post_parent, '_difp_last_reply_id', $post->ID);
            update_post_meta($post->post_parent, '_difp_last_reply_time', strtotime($post->post_date_gmt));
        } else {
            add_post_meta($post->ID, '_difp_last_reply_by', $post->post_author, true);
            add_post_meta($post->ID, '_difp_last_reply_id', $post->ID, true);
            add_post_meta($post->ID, '_difp_last_reply_time', strtotime($post->post_date_gmt), true);
        }

    } elseif ('publish' == $old_status && 'threaded' == difp_get_message_view()) {
        if ($post->post_parent) {
            $child_args = array(
                'post_type' => 'difp_message',
                'post_status' => 'publish',
                'posts_per_page' => 1,
                'post_parent' => $post->post_parent
            );
            $child = get_posts($child_args);

            if ($child && !empty($child[0])) {
                update_post_meta($post->post_parent, '_difp_last_reply_by', $child[0]->post_author);
                update_post_meta($post->post_parent, '_difp_last_reply_id', $child[0]->ID);
                update_post_meta($post->post_parent, '_difp_last_reply_time', strtotime($child[0]->post_date_gmt));
            } else {
                $parent_post = get_post($post->post_parent);

                update_post_meta($parent_post->ID, '_difp_last_reply_by', $parent_post->post_author);
                update_post_meta($parent_post->ID, '_difp_last_reply_id', $parent_post->ID);
                update_post_meta($parent_post->ID, '_difp_last_reply_time', strtotime($parent_post->post_date_gmt));
            }
        }
    }
    if ('publish' == $new_status || 'publish' == $old_status) {

        $participants = difp_get_participants($post->ID);

        foreach ($participants as $participant) {
            delete_user_meta($participant, '_difp_user_message_count');
        }
    }
}

function difp_backticker_encode($text)
{
    $text = $text[1];
    $text = str_replace('&amp;lt;', '&lt;', $text);
    $text = str_replace('&amp;gt;', '&gt;', $text);
    $text = htmlspecialchars($text, ENT_QUOTES);
    $text = preg_replace("|\n+|", "\n", $text);
    $text = nl2br($text);
    $text = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $text);
    $text = preg_replace("/^ /", '&nbsp;', $text);
    $text = preg_replace("/(?<=&nbsp;| |\n) /", '&nbsp;', $text);

    return "<code>$text</code>";
}

function difp_backticker_display_code($text)
{
    //$text = preg_replace_callback("|`(.*?)`|", "difp_backticker_encode", $text);
    $text = preg_replace_callback('!`(?:\r\n|\n|\r|)(.*?)(?:\r\n|\n|\r|)`!ims', "difp_backticker_encode", $text);
    $text = str_replace('<code></code>', '`', $text);
    return $text;
}

function difp_backticker_code_input_filter($message)
{

    $message['message_content'] = difp_backticker_display_code($message['message_content']);

    return $message;
}

add_filter('difp_filter_message_before_send', 'difp_backticker_code_input_filter', 5);

function difp_autosuggestion_ajax()
{
    _deprecated_function(__FUNCTION__, '4.4', 'Difp_Ajax class');

    global $user_ID;

    if (difp_get_option('hide_autosuggest') == '1' && !difp_is_user_admin())
        die();

    if (check_ajax_referer('difp-autosuggestion', 'token', false)) {

        $searchq = $_POST['searchBy'];


        $args = array(
            'search' => "*{$searchq}*",
            'search_columns' => array('display_name'),
            'exclude' => array($user_ID),
            'number' => 5,
            'orderby' => 'display_name',
            'order' => 'ASC',
            'fields' => array('display_name', 'user_nicename')
        );

        $args = apply_filters('difp_autosuggestion_arguments', $args);

        // The Query
        $user_query = new WP_User_Query($args);

        if (strlen($searchq) > 0) {
            echo "<ul>";
            if (!empty($user_query->results)) {
                foreach ($user_query->results as $user) {

                    ?>
                    <li><a href="#"
                           onClick="difp_fill_autosuggestion('<?php echo $user->user_nicename; ?>','<?php echo $user->display_name; ?>');return false;"><?php echo $user->display_name; ?></a>
                    </li>
                    <?php

                }
            } else
                echo "<li>" . __("No matches found", 'ALSP') . "</li>";
            echo "</ul>";
        }
    }
    die();
}

//add_action('wp_ajax_difp_autosuggestion_ajax','difp_autosuggestion_ajax');	

function difp_footer_credit()
{
    $style = '';
    if (difp_get_option('hide_branding', 0) == 1) {
        $style = " style='display: none'";
    }
    echo "<div{$style}><a href='#' target='_blank'>Designinvento Messages</a></div>";
}

add_action('difp_footer_note', 'difp_footer_credit');

function difp_notification()
{
    if (!difp_current_user_can('access_message'))
        return '';
    if (difp_get_option('hide_notification', 0) == 1)
        return '';

    $unread_count = difp_get_new_message_number();
    $sm = sprintf(_n('%s unread message', '%s unread messages', $unread_count, 'ALSP'), number_format_i18n($unread_count));

    $show = '';

    $unread_ann_count = difp_get_user_announcement_count('unread');
    $sa = sprintf(_n('%s unread announcement', '%s unread announcements', $unread_ann_count, 'ALSP'), number_format_i18n($unread_ann_count));

    if ($unread_count || $unread_ann_count) {
        $show = __("You have", 'ALSP');

        if ($unread_count)
            $show .= "<a href='" . difp_query_url('messagebox') . "'> $sm</a>";

        if ($unread_count && $unread_ann_count)
            $show .= ' ' . __('and', 'ALSP');

        if ($unread_ann_count)
            $show .= "<a href='" . difp_query_url('announcements') . "'> $sa</a>";

    }
    return apply_filters('difp_header_notification', $show);
}


function difp_notification_div()
{
    if (!difp_current_user_can('access_message'))
        return;
    if (difp_get_option('hide_notification', 0) == 1)
        return;

    wp_enqueue_script('difp-notification-script');
    $notification = difp_notification();
    if ($notification)
        echo "<div id='difp-notification-bar'>$notification</div>";
    else
        echo "<div id='difp-notification-bar' style='display: none'></div>";
}

//add_action('wp_head', 'difp_notification_div', 99 );

function difp_notification_ajax()
{
    _deprecated_function(__FUNCTION__, '4.4', 'Difp_Ajax class');

    if (check_ajax_referer('difp-notification', 'token', false)) {

        $notification = difp_notification();
        if ($notification)
            echo $notification;
    }
    wp_die();
}

//add_action('wp_ajax_difp_notification_ajax','difp_notification_ajax');
//add_action('wp_ajax_nopriv_difp_notification_ajax','difp_notification_ajax');

function difp_auth_redirect()
{
    if (!difp_page_id() || (!is_page(difp_page_id()) && !is_single(difp_page_id()))) {
        return;
    }

    do_action('difp_template_redirect');

    if (apply_filters('difp_using_auth_redirect', false)) {
        auth_redirect();
    }
}

add_action('template_redirect', 'difp_auth_redirect', 99);

add_filter('auth_redirect_scheme', 'difp_auth_redirect_scheme');
function difp_auth_redirect_scheme($scheme)
{

    if (is_admin() || !difp_page_id() || (!is_page(difp_page_id()) && !is_single(difp_page_id()))) {
        return $scheme;
    }

    return 'logged_in';
}

add_filter('map_meta_cap', 'difp_map_meta_cap', 10, 4);

function difp_map_meta_cap($caps, $cap, $user_id, $args)
{

    $our_caps = array('read_difp_message', 'edit_difp_message', 'delete_difp_message', 'read_difp_announcement', 'edit_difp_announcement', 'delete_difp_announcement');

    /* If editing, deleting, or reading a message or announcement, get the post and post type object. */
    if (in_array($cap, $our_caps)) {
        $post = get_post($args[0]);
        $post_type = get_post_type_object($post->post_type);

        /* Set an empty array for the caps. */
        $caps = array();
    } else {
        return $caps;
    }

    /* If editing a message or announcement, assign the required capability. */
    if ('edit_difp_message' == $cap || 'edit_difp_announcement' == $cap) {
        if ($user_id == $post->post_author)
            $caps[] = $post_type->cap->edit_posts;
        else
            $caps[] = $post_type->cap->edit_others_posts;
    } /* If deleting a message or announcement, assign the required capability. */
    elseif ('delete_difp_message' == $cap || 'delete_difp_announcement' == $cap) {
        if ($user_id == $post->post_author)
            $caps[] = $post_type->cap->delete_posts;
        else
            $caps[] = $post_type->cap->delete_others_posts;
    } /* If reading a private message or announcement, assign the required capability. */
    elseif ('read_difp_message' == $cap || 'read_difp_announcement' == $cap) {

        if ('private' != $post->post_status)
            $caps[] = 'read';
        elseif ($user_id == $post->post_author)
            $caps[] = 'read';
        else
            $caps[] = $post_type->cap->read_private_posts;
    }

    /* Return the capabilities required by the user. */
    return $caps;
}

function difp_array_trim($array)
{

    if (!is_array($array))
        return trim($array);

    return array_map('difp_array_trim', $array);
}

function difp_is_pro()
{
    return file_exists(DIFP_PLUGIN_DIR . 'pro/pro-features.php');
}

function difp_errors()
{
    static $errors; // Will hold global variable safely
    return isset($errors) ? $errors : ($errors = new WP_Error());
}

function difp_success()
{
    static $success; // Will hold global variable safely
    return isset($success) ? $success : ($success = new WP_Error());
}

function difp_info_output()
{

    /*
    // If conditions are met and errors exist:
    if(!difp_info()->get_error_codes()) return;

    $success = array();
    $info = array();
    $errors = array();

    // Loop error codes and display errors
    foreach( difp_info()->get_error_codes() as $code ){

        $data = difp_info()->get_error_data($code);
        // Display stuff here
        if( 'success' == $data ) {
            $success[] = difp_info()->get_error_message($code);
        } elseif( 'info' == $data ){
            $info[] = difp_info()->get_error_message($code);
        } else {
            $errors[] = difp_info()->get_error_message($code);
        }
    }
    */

    $html = '';

    if (difp_success()->get_error_messages()) {
        $html .= '<div class="difp-success">';
        foreach (difp_success()->get_error_messages() as $s) {
            $html .= esc_html($s) . '<br />';
        }
        $html .= '</div>';
    }

    if (difp_errors()->get_error_messages()) {
        $html .= '<div class="difp-wp-error">';
        foreach (difp_errors()->get_error_messages() as $e) {
            $html .= '<strong>' . __('Error', 'ALSP') . ': </strong>' . esc_html($e) . '<br />';
        }
        $html .= '</div>';
    }

    return $html;
}

function difp_locate_template($template_names, $load = false, $require_once = true)
{

    $locations = array();
    $locations[10] = trailingslashit(STYLESHEETPATH) . 'di-frontend-pm/';
    $locations[20] = trailingslashit(TEMPLATEPATH) . 'di-frontend-pm/';
    $locations[30] = DIFP_PLUGIN_DIR . 'pro/templates/';
    $locations[40] = DIFP_PLUGIN_DIR . 'templates/';

    $locations = apply_filters('difp_template_locations', $locations);

    // sort the $locations based on priority
    ksort($locations, SORT_NUMERIC);

    $template = '';

    if (!is_array($template_names))
        $template_names = explode(',', $template_names);

    foreach ($template_names as $template_name) {

        $template_name = trim($template_name);

        if (empty($template_name))
            continue;

        if (strpos($template_name, '../') !== false || strpos($template_name, '..\\') !== false)
            continue;

        foreach ($locations as $location) {
            if (file_exists($location . $template_name)) {
                $template = $location . $template_name;
                break 2;
            }
        }

    }

    if ((true == $load) && !empty($template))
        load_template($template, $require_once);

    return apply_filters('difp_locate_template', $template, $template_names, $load, $require_once);
}


add_action('wp_loaded', 'difp_form_posted', 20); //After Email hook

function difp_form_posted()
{
    $action = !empty($_POST['difp_action']) ? $_POST['difp_action'] : '';

    if (!$action)
        return;

    if (!difp_current_user_can('access_message'))
        return;

    switch ($action) {
        case has_action("difp_posted_action_{$action}"):
            do_action("difp_posted_action_{$action}");
            break;
        case 'newmessage' :
            if (!difp_current_user_can('send_new_message')) {
                difp_errors()->add('permission', __("You do not have permission to send new message!", 'ALSP'));
                break;
            }

            Difp_Form::init()->validate_form_field();
            if (count(difp_errors()->get_error_messages()) == 0) {
                if ($message_id = difp_send_message()) {
                    $message = get_post($message_id);

                    if ('publish' == $message->post_status) {
                        difp_success()->add('publish', __("Message successfully sent.", 'ALSP'));
                    } else {
                        difp_success()->add('pending', __("Message successfully sent and waiting for admin moderation.", 'ALSP'));
                    }
                } else {
                    difp_errors()->add('undefined', __("Something wrong. Please try again.", 'ALSP'));
                }
            }

            break;
        case 'shortcode-newmessage' :
            if (!difp_current_user_can('send_new_message')) {
                difp_errors()->add('permission', __("You do not have permission to send new message!", 'ALSP'));
                break;
            }

            Difp_Form::init()->validate_form_field('shortcode-newmessage');
            Difp_Form::init()->validate_form_field('shortcode-newbidding');
            if (count(difp_errors()->get_error_messages()) == 0) {
                if ($message_id = difp_send_message()) {
                    $message = get_post($message_id);

                    if ('publish' == $message->post_status) {
                        difp_success()->add('publish', __("Message successfully sent.", 'ALSP'));
                    } else {
                        difp_success()->add('pending', __("Message successfully sent and waiting for admin moderation.", 'ALSP'));
                    }
                } else {
                    difp_errors()->add('undefined', __("Something wrong. Please try again.", 'ALSP'));
                }
            }

            break;
        case 'reply' :

            if (isset($_GET['difp_id'])) {
                $pID = absint($_GET['difp_id']);
            } else {
                $pID = !empty($_GET['id']) ? absint($_GET['id']) : 0;
            }
            $parent_id = difp_get_parent_id($pID);

            if (!difp_current_user_can('send_reply', $parent_id)) {
                difp_errors()->add('permission', __("You do not have permission to send reply to this message!", 'ALSP'));
                break;
            }

            Difp_Form::init()->validate_form_field('reply');
            if (count(difp_errors()->get_error_messages()) == 0) {
                if ($message_id = difp_send_message()) {
                    $message = get_post($message_id);

                    if ('publish' == $message->post_status) {
                        difp_success()->add('publish', __("Message successfully sent.", 'ALSP'));
                    } else {
                        difp_success()->add('pending', __("Message successfully sent and waiting for admin moderation.", 'ALSP'));
                    }
                } else {
                    difp_errors()->add('undefined', __("Something wrong. Please try again.", 'ALSP'));
                }
            }

            break;
        case 'bulk_action' :
            $posted_bulk_action = !empty($_POST['difp-bulk-action']) ? $_POST['difp-bulk-action'] : '';
            if (!$posted_bulk_action)
                break;

            $token = !empty($_POST['token']) ? $_POST['token'] : '';

            if (!difp_verify_nonce($token, 'bulk_action')) {
                difp_errors()->add('token', __("Invalid Token. Please try again!", 'ALSP'));
                break;
            }

            if ($bulk_action_return = Difp_Message::init()->bulk_action($posted_bulk_action)) {
                difp_success()->add('success', $bulk_action_return);
            }
            break;
        case 'announcement_bulk_action' :
            $posted_bulk_action = !empty($_POST['difp-bulk-action']) ? $_POST['difp-bulk-action'] : '';
            if (!$posted_bulk_action)
                break;

            $token = !empty($_POST['token']) ? $_POST['token'] : '';

            if (!difp_verify_nonce($token, 'announcement_bulk_action')) {
                difp_errors()->add('token', __("Invalid Token. Please try again!", 'ALSP'));
                break;
            }

            if ($bulk_action_return = Difp_Announcement::init()->bulk_action($posted_bulk_action)) {
                difp_success()->add('success', $bulk_action_return);
            }
            break;
        case 'settings' :

            add_action('difp_action_form_validated', 'difp_user_settings_save', 10, 2);

            Difp_Form::init()->validate_form_field('settings');

            if (count(difp_errors()->get_error_messages()) == 0) {
                difp_success()->add('saved', __("Settings successfully saved.", 'ALSP'));
            }

            break;
        default:
            do_action("difp_posted_action");
            break;

    }

    if (defined('DOING_AJAX') && DOING_AJAX) {
        $response = array();
        if (count(difp_errors()->get_error_messages()) > 0) {
            $response['difp_return'] = 'error';
        } elseif (count(difp_success()->get_error_messages()) > 0) {
            $response['difp_return'] = 'success';
        } else {
            $response['difp_return'] = '';
        }
        $response['info'] = difp_info_output();

        wp_send_json($response);
    } elseif (!empty($_POST['difp_redirect'])) {
        wp_redirect($_POST['difp_redirect']);
        /* exit; */
    }
}

function difp_user_settings_save($where, $fields)
{
    if ('settings' != $where)
        return;

    if (!$fields || !is_array($fields))
        return;

    $settings = array();

    foreach ($fields as $field) {
        $settings[$field['name']] = $field['posted-value'];
    }
    $settings = apply_filters('difp_filter_user_settings_before_save', $settings);

    update_user_option(get_current_user_id(), 'DIFP_user_options', $settings);
}

function difp_get_participants($message_id)
{
    if (empty($message_id) || !is_numeric($message_id))
        return array();

    if ('threaded' == difp_get_message_view()) {
        $message_id = difp_get_parent_id($message_id);
    }
    $participants = get_post_meta($message_id, '_difp_participants');

    if (!$participants)
        $participants = get_post_meta($message_id, '_participants');

    return $participants;
}

function difp_get_participant_roles($announcement_id)
{
    if (empty($announcement_id) || !is_numeric($announcement_id))
        return array();

    $roles = get_post_meta($announcement_id, '_difp_participant_roles');

    if (!$roles)
        $roles = get_post_meta($announcement_id, '_participant_roles');

    return $roles;
}

function difp_get_message_view()
{
    $message_view = difp_get_option('message_view', 'threaded');
    $message_view = apply_filters('difp_get_message_view', $message_view);

    if (!$message_view || !in_array($message_view, array('threaded', 'individual')))
        $message_view = 'threaded';

    return $message_view;
}

