<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

//Message CLASS
class Difp_Message
{
    private static $instance;

    public static function init()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    function actions_filters()
    {
        add_action('difp_action_validate_form', array($this, "time_delay_check"), 10, 2);
        add_action('difp_action_validate_form', array($this, "box_full_check"), 10, 2);

        add_action('difp_save_message', array($this, 'recalculate_user_stats'), 20); //after '_difp_participants' meta saved
        add_action('before_delete_post', array($this, 'delete_replies'));
        add_action('before_delete_post', array($this, 'participants_save'));
        add_action('after_delete_post', array($this, 'recalculate_participants_stats'));
    }

    function time_delay_check($where, $errors)
    {

        if ('newmessage' != $where)
            return;

        $delay = absint(difp_get_option('time_delay', 5));

        if (difp_is_user_admin() || !$delay)
            return;

        $args = array(
            'post_type' => 'difp_message',
            'post_status' => array('pending', 'publish'),
            'posts_per_page' => 1,
            'author' => get_current_user_id(),
            'date_query' => array(
                'after' => "-{$delay} minutes"
            )
        );
        if ('threaded' == difp_get_message_view())
            $args['post_parent'] = 0;

        if (get_posts($args)) {
            $errors->add('time_delay', sprintf(__("Please wait at least %s between messages.", 'ALSP'), sprintf(_n('%s minute', '%s minutes', $delay, 'ALSP'), number_format_i18n($delay))));
        }
    }

    function box_full_check($where, $errors)
    {

        if ('newmessage' != $where)
            return;

        if (!$max = difp_get_current_user_max_message_number())
            return;

        if (difp_get_user_message_count('total') >= $max) {
            $errors->add('MgsBoxFull', __("Your message box is full. Please delete some messages.", 'ALSP'));
        }
    }

    function recalculate_user_stats($postid)
    {

        $participants = difp_get_participants($postid);

        if ($participants && is_array($participants)) {
            foreach ($participants as $participant) {
                delete_user_meta($participant, '_difp_user_message_count');
            }
        }
    }


    function delete_replies($message_id)
    {

        if (get_post_type($message_id) != 'difp_message')
            return false;

        if ('threaded' != difp_get_message_view()) {
            return false;
        }
        $args = array(
            'post_type' => 'difp_message',
            'post_status' => 'any',
            'post_parent' => $message_id,
            'posts_per_page' => -1,
            'fields' => 'ids'
        );

        $replies = get_posts($args);

        if ($replies) {
            foreach ($replies as $reply) {
                wp_delete_post($reply);

            }
        }
    }

    function participants_save($message_id)
    {
        if (get_post_type($message_id) != 'difp_message')
            return false;

        $participants = difp_get_participants($message_id);

        if ($participants && is_array($participants)) {
            add_option('_difp_before_delete_post', $participants);
        }
    }

    function recalculate_participants_stats()
    {
        $participants = get_option('_difp_before_delete_post');

        if (false !== $participants) {
            delete_option('_difp_before_delete_post');

            if (is_array($participants)) {
                foreach ($participants as $participant) {
                    delete_user_meta($participant, '_difp_user_message_count');
                }
            }
        }
    }

    function user_message_count($value = 'all', $force = false, $user_id = false)
    {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        if ('show-all' == $value)
            $value = 'total';

        if (!$user_id) {
            if ('all' == $value) {
                return array();
            } else {
                return 0;
            }
        }

        $user_meta = get_user_meta($user_id, '_difp_user_message_count', true);

        if (false === $user_meta || $force || !isset($user_meta['total']) || !isset($user_meta['read']) || !isset($user_meta['unread']) || !isset($user_meta['archive']) || !isset($user_meta['inbox']) || !isset($user_meta['sent'])) {

            $args = array(
                'post_type' => 'difp_message',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => '_difp_participants',
                        'value' => $user_id,
                        'compare' => '='
                    ),
                    array(
                        'key' => '_difp_delete_by_' . $user_id,
                        //'value' => $id,
                        'compare' => 'NOT EXISTS'
                    )

                )
            );

            if ('threaded' == difp_get_message_view()) {
                $args['post_parent'] = 0;
                $args['fields'] = 'ids';
            }
            $messages = get_posts($args);

            $total_count = 0;
            $read_count = 0;
            $unread_count = 0;
            $archive_count = 0;
            $inbox_count = 0;
            $sent_count = 0;

            if ($messages && !is_wp_error($messages)) {

                if ('threaded' == difp_get_message_view()) {
                    $message_ids = $messages;
                } else {
                    $message_ids = array();
                    foreach ($messages as $m) {
                        $message_ids[] = $m->ID;
                    }
                    reset($messages);
                }
                update_postmeta_cache($message_ids); //Update all meta cache in one query

                foreach ($messages as $message) {
                    $total_count++;

                    if ('threaded' == difp_get_message_view()) {
                        $message_id = $message;
                        $from_user = get_post_meta($message_id, '_difp_last_reply_by', true);
                    } else {
                        $message_id = $message->ID;
                        $from_user = $message->post_author;
                    }
                    $to_user_meta = difp_get_participants($message_id);

                    $read_meta = get_post_meta($message_id, '_difp_parent_read_by_' . $user_id, true);
                    $archive_meta = get_post_meta($message_id, '_difp_archived_by_' . $user_id, true);

                    if ($from_user == $user_id) {
                        $sent_count++;

                    } elseif (is_array($to_user_meta) && in_array($user_id, $to_user_meta)) {

                        $inbox_count++;
                    }
                    if ($archive_meta) {

                        $archive_count++;
                    }
                    if ($read_meta) {
                        $read_count++;
                    } else {
                        $unread_count++;
                    }
                }
            }


            $user_meta = array(
                'total' => $total_count,
                'read' => $read_count,
                'unread' => $unread_count,
                'archive' => $archive_count,
                'inbox' => $inbox_count,
                'sent' => $sent_count
            );
            update_user_meta($user_id, '_difp_user_message_count', $user_meta);
        }
        if (isset($user_meta[$value])) {
            return $user_meta[$value];
        }
        if ('all' == $value) {
            return $user_meta;
        } else {
            return 0;
        }

    }

    function user_messages($action = 'messagebox', $user_id = false)
    {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }
        $filter = !empty($_GET['difp-filter']) ? $_GET['difp-filter'] : '';

        $args = array(
            'post_type' => 'difp_message',
            'post_status' => 'publish',
            'posts_per_page' => difp_get_option('messages_page', 15),
            'paged' => !empty($_GET['difppage']) ? absint($_GET['difppage']) : 1,
            //'orderby' => 'post_modified',
            'meta_query' => array(
                array(
                    'key' => '_difp_participants',
                    'value' => $user_id,
                    'compare' => '='
                ),
                array(
                    'key' => '_difp_delete_by_' . $user_id,
                    //'value' => $id,
                    'compare' => 'NOT EXISTS'
                )

            )
        );

        if ('threaded' == difp_get_message_view()) {
            $args['post_parent'] = 0;
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_difp_last_reply_time';
        }
        if (!empty($_GET['difp-search'])) {
            $args['s'] = $_GET['difp-search'];
        }

        switch ($filter) {
            case 'inbox' :
                if ('threaded' == difp_get_message_view()) {
                    $args['meta_query'][] = array(
                        'key' => '_difp_last_reply_by',
                        'value' => $user_id,
                        'compare' => '!='
                    );
                } else {
                    $args['author'] = -$user_id;
                }
                break;
            case 'sent' :
                if ('threaded' == difp_get_message_view()) {
                    $args['meta_query'][] = array(
                        'key' => '_difp_last_reply_by',
                        'value' => $user_id,
                        'compare' => '='
                    );
                } else {
                    $args['author'] = $user_id;
                }
                break;
            case 'archive' :
                $args['meta_query'][] = array(
                    'key' => '_difp_archived_by_' . $user_id,
                    //'value' => $user_id,
                    'compare' => 'EXISTS'
                );
                break;
            case 'read' :
                $args['meta_query'][] = array(
                    'key' => '_difp_parent_read_by_' . $user_id,
                    //'value' => $user_id,
                    'compare' => 'EXISTS'
                );
                break;
            case 'unread' :
                $args['meta_query'][] = array(
                    'key' => '_difp_parent_read_by_' . $user_id,
                    //'value' => $user_id,
                    'compare' => 'NOT EXISTS'
                );
                break;
            default:
                $args = apply_filters('difp_message_query_args_' . $filter, $args);
                break;
        }

        $args = apply_filters('difp_message_query_args', $args);

        if ('threaded' == difp_get_message_view() && apply_filters('difp_thread_show_last_message', true)) {

            $ids = get_posts(wp_parse_args(array('fields' => 'ids'), $args));

            if ($ids = array_filter(array_map('absint', $ids))) {
                global $wpdb;
                $ids = implode(',', $ids);
                $message_ids = $wpdb->get_col("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '_difp_last_reply_id' AND post_id IN ($ids)");

                if ($message_ids = array_filter(array_map('absint', $message_ids))) {
                    $args = array(
                        'post_type' => 'difp_message',
                        'post_status' => 'publish',
                        'posts_per_page' => difp_get_option('messages_page', 15),
                        'post__in' => $message_ids,
                        'order' => isset($args['order']) ? $args['order'] : 'DESC',
                    );
                } else {
                    $args['post__in'] = array(0);
                }
            } else {
                $args['post__in'] = array(0);
            }

        } else {
            //return new WP_Query( $args );
        }
        return new WP_Query($args);

    }


    function bulk_action($action, $ids = null)
    {

        if (null === $ids) {
            $ids = !empty($_POST['difp-message-cb']) ? $_POST['difp-message-cb'] : array();
        }
        if (!$action || !$ids || !is_array($ids)) {
            return '';
        }
        $count = 0;
        foreach ($ids as $id) {
            if ($this->bulk_individual_action($action, absint($id))) {
                $count++;
            }
        }
        $message = '';

        if ($count) {
            delete_user_meta(get_current_user_id(), '_difp_user_message_count');

            $message = sprintf(_n('%s message', '%s messages', $count, 'ALSP'), number_format_i18n($count));
            $message .= ' ';

            if ('delete' == $action) {
                $message .= __('successfully deleted.', 'ALSP');
            } elseif ('mark-as-read' == $action) {
                $message .= __('successfully marked as read.', 'ALSP');
            } elseif ('mark-as-unread' == $action) {
                $message .= __('successfully marked as unread.', 'ALSP');
            } elseif ('archive' == $action) {
                $message .= __('successfully archived.', 'ALSP');
            } elseif ('restore' == $action) {
                $message .= __('successfully restored.', 'ALSP');
            }
            //$message = '<div class="difp-success">'.$message.'</div>';
        }
        return apply_filters('difp_message_bulk_action_message', $message, $count);
    }

    function bulk_individual_action($action, $passed_id)
    {
        $return = false;

        if ('threaded' == difp_get_message_view()) {
            $id = difp_get_parent_id($passed_id);
        } else {
            $id = $passed_id;
        }

        switch ($action) {
            case 'delete':
                if (difp_current_user_can('delete_message', $id)) {
                    $return = add_post_meta($id, '_difp_delete_by_' . get_current_user_id(), time(), true);
                }
                $should_delete_from_db = true;
                foreach (difp_get_participants($id) as $participant) {
                    if (!get_post_meta($id, '_difp_delete_by_' . $participant, true)) {
                        $should_delete_from_db = false;
                        break;
                    }

                }
                if ($should_delete_from_db) {
                    $return = wp_trash_post($id);
                }
                break;
            case 'mark-as-read':
                if (difp_current_user_can('view_message', $id)) {
                    $return = add_post_meta($id, '_difp_parent_read_by_' . get_current_user_id(), time(), true);
                }
                break;
            case 'mark-as-unread':
                if (difp_current_user_can('view_message', $id)) {
                    $return = delete_post_meta($id, '_difp_parent_read_by_' . get_current_user_id());
                }
                break;
            case 'archive':
                if (difp_current_user_can('view_message', $id)) {
                    $return = add_post_meta($id, '_difp_archived_by_' . get_current_user_id(), time(), true);
                }
                break;
            case 'restore':
                if (difp_current_user_can('view_message', $id)) {
                    $return = delete_post_meta($id, '_difp_archived_by_' . get_current_user_id());
                }
                break;
            default:
                $return = apply_filters('difp_message_bulk_individual_action', false, $action, $id, $passed_id);
                break;
        }
        return $return;
    }

    function get_table_bulk_actions()
    {
        $filter = !empty($_GET['difp-filter']) ? $_GET['difp-filter'] : '';

        $actions = array(
            'delete' => __('Delete', 'ALSP'),
            'mark-as-read' => __('Mark as read', 'ALSP'),
            'mark-as-unread' => __('Mark as unread', 'ALSP')
        );

        if ('archive' == $filter) {
            $actions['restore'] = __('Restore', 'ALSP');
        } else {
            $actions['archive'] = __('Archive', 'ALSP');
        }

        return apply_filters('difp_message_table_bulk_actions', $actions);
    }

    function get_table_filters()
    {
        $filters = array(
            'show-all' => __('Show all', 'ALSP'),
            'inbox' => __('Inbox', 'ALSP'),
            'sent' => __('Sent', 'ALSP'),
            'read' => __('Read', 'ALSP'),
            'unread' => __('Unread', 'ALSP'),
            'archive' => __('Archive', 'ALSP')
        );
        return apply_filters('difp_message_table_filters', $filters);
    }

    function get_table_columns()
    {
        $columns = array(
            'difp-cb' => __('Checkbox', 'ALSP'),
            'avatar' => __('Avatar', 'ALSP'),
            'author' => __('Author', 'ALSP'),
            'title' => __('Title', 'ALSP')
        );
        return apply_filters('difp_message_table_columns', $columns);
    }

    function get_column_content($column)
    {
        switch ($column) {

            case has_action("difp_message_table_column_content_{$column}"):

                do_action("difp_message_table_column_content_{$column}");

                break;
            case 'difp-cb' :
                ?>
                <div class="alsp-checkbox">
                    <label>
                        <input type="checkbox" name="difp-message-cb[]" value="<?php echo get_the_ID(); ?>"/>
                        <span class="radio-check-item"></span>
                    </label>
                </div>
                <?php
                break;
            case 'avatar' :
                //$current_user = wp_get_current_user();
                $authorID = get_the_author_meta('ID');
                //$author_name = get_the_author_meta('display_name', $authorID);
                $output = '';
                $author_img_url = get_the_author_meta('pacz_author_avatar_url', $authorID, true);
                $output .= '<div class="author-thumbnail">';
                if (!empty($author_img_url)) {
                    $params = array('width' => 130, 'height' => 130, 'crop' => true);
                    $output .= "<img src='" . bfi_thumb("$author_img_url", $params) . "' alt='' />";
                } else {
                    $avatar_url = pacz_get_avatar_url(get_the_author_meta('user_email', $authorID), $size = '130');
                    $output .= '<img src="' . $avatar_url . '" alt="author" />';
                }
                $output .= '</div>';
                ?>
                <a href="<?php echo difp_query_url('viewmessage', array('difp_id' => get_the_ID())); ?>">
                    <?php
                    echo $output;
                    ?>
                </a>
                <?php
                //echo get_avatar( get_the_author_meta('ID'), 55 );
                break;
            case 'author' :
                ?><a href="<?php echo difp_query_url('viewmessage', array('difp_id' => get_the_ID())); ?>"><span
                        class="difp-message-author"><?php the_author_meta('display_name'); ?></span><span
                        class="difp-message-date"><?php the_time(); ?></span></a><?php
                break;
            case 'title' :
                if (!difp_is_read(true)) {
                    $span = '<span class="difp-unread-classp"><span class="difp-unread-class">' . __("Unread", "ALSP") . '</span></span>';
                    $class = ' difp-strong';
                } else {
                    $span = '';
                    $class = '';
                }
                ?>
                <?php
                //$listing = new alsp_listing();
                $postid = get_post(get_the_ID());
                if ($postid->post_parent != 0) {
                    $currentpost = $postid->post_parent;
                } else {
                    $currentpost = get_the_ID();
                }
                $image = get_post_meta($currentpost, '_listing_id', true);
                $bid = get_post_meta($currentpost, '_listing_bid', true);
                if (isset($bid) && (!empty($bid))) {
                    $bid_wrap = '<span class="message-bid">' . esc_html__('Bid', 'ALSP') . '</span>';
                } else {
                    $bid_wrap = '';
                }
                $image2 = get_post_meta($image, '_thumbnail_id', true);
                $width = 60;
                $height = 60;

                $image_src_array = wp_get_attachment_image_src($image2, 'full');
                $image_src = bfi_thumb($image_src_array[0], array(
                    'width' => $width,
                    'height' => $height,
                    'crop' => true
                ));

                ?>

                <a href="<?php echo difp_query_url('viewmessage', array('difp_id' => get_the_ID())); ?>"><img
                            alt="<?php the_title(); ?>"
                            src="<?php echo pacz_thumbnail_image_gen($image_src, $width, $height); ?>"
                            width="<?php echo $width ?>" height="<?php echo $height ?>"/></a>
            <span class="<?php echo $class; ?>"><a
                        href="<?php echo difp_query_url('viewmessage', array('difp_id' => get_the_ID())); ?>"><?php the_title(); ?></a>
                </span><?php echo $span; ?><?php echo $bid_wrap ?><?php
                break;
            default:
                do_action('difp_message_table_column_content', $column);
                break;
        }
    }


} //END CLASS

add_action('wp_loaded', array(Difp_Message::init(), 'actions_filters'));

