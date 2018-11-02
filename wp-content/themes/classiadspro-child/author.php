<?php
/**
 * Template name: Profile Page
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classiads
 * @since classiads 1.2.2
 */


if (class_exists('alsp_plugin')):
    global $ALSP_ADIMN_SETTINGS;
    $layout = $pacz_settings['archive-layout'];
    $columns = $pacz_settings['archive-columns'];
    $loop_style = $pacz_settings['archive-loop-style'];

    $author = get_user_by('slug', get_query_var('author_name'));
    $authorID = $author->ID;

    $author_img_url = get_the_author_meta('pacz_author_avatar_url', $authorID, true);
    $author_name = get_query_var('author_name');
    $description = get_the_author_meta('description', $authorID);
    if ($ALSP_ADIMN_SETTINGS['frontend_panel_user_phone']) {
        $phone_number = get_the_author_meta('user_phone', $authorID);
    }
    $author_email = get_the_author_meta('email', $authorID);
    if ($ALSP_ADIMN_SETTINGS['frontend_panel_user_website']) {
        $author_website = get_the_author_meta('user_website', $authorID);
    }
    if ($ALSP_ADIMN_SETTINGS['frontend_panel_user_address']) {
        $author_address = get_the_author_meta('address', $authorID);
    }
    if ($ALSP_ADIMN_SETTINGS['frontend_panel_user_type']) {
        $author_type = get_the_author_meta('_user_type', $authorID);
    }
    $author_verified = get_the_author_meta('author_verified', $authorID);

    //$email_id = $instance['email_id'];
    $registered = date_i18n("M m, Y", strtotime(get_the_author_meta('user_registered', $authorID)));
    if ($ALSP_ADIMN_SETTINGS['frontend_panel_social_links']) {
        $author_fb = get_the_author_meta('author_fb', $authorID);
        $author_tw = get_the_author_meta('author_tw', $authorID);
        $author_ytube = get_the_author_meta('author_ytube', $authorID);
        $author_vimeo = get_the_author_meta('author_vimeo', $authorID);
        $author_flickr = get_the_author_meta('author_flickr', $authorID);
        $author_linkedin = get_the_author_meta('author_linkedin', $authorID);
        $author_gplus = get_the_author_meta('author_gplus', $authorID);
        $author_instagram = get_the_author_meta('author_instagram', $authorID);
        $author_behance = get_the_author_meta('author_behance', $authorID);
        $author_dribbble = get_the_author_meta('author_dribbble', $authorID);
    }

    if (gearside_is_user_online($authorID)) {
        $author_log_status = '<span class="author-active"></span>';
    } else {
        //$author_log_status = ( gearside_user_last_online($authorID) )? '<small>Last Seen: <br /><em>' . date('M j, Y @ g:ia', gearside_user_last_online($authorID)) . '</em></small>' : ''; //Return the user's "Last Seen" date, or return empty if that user has never logged in.
        $author_log_status = '<span class="author-in-active"></span>';
    }
    global $product;
    require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php";
    $output = '';


// ********* Get all products and variations and sort alphbetically, return in array (title, sku, id)*******
    function get_woocommerce_product_list()
    {
        $full_product_list = array();
        $loop = new WP_Query(array('post_type' => array('product', 'product_variation'), 'posts_per_page' => -1));

        while ($loop->have_posts()) : $loop->the_post();
            $theid = get_the_ID();
            $product = new WC_Product($theid);
            // its a variable product
            if (get_post_type() == 'product_variation') {
                $parent_id = wp_get_post_parent_id($theid);
                $sku = get_post_meta($theid, '_sku', true);
                $thetitle = get_the_title($parent_id);

                // ****** Some error checking for product database *******
                // check if variation sku is set
                if ($sku == '') {
                    if ($parent_id == 0) {
                        // Remove unexpected orphaned variations.. set to auto-draft
                        $false_post = array();
                        $false_post['ID'] = $theid;
                        $false_post['post_status'] = 'auto-draft';
                        wp_update_post($false_post);
                        if (function_exists(add_to_debug)) add_to_debug('false post_type set to auto-draft. id=' . $theid);
                    } else {
                        // there's no sku for this variation > copy parent sku to variation sku
                        // & remove the parent sku so the parent check below triggers
                        $sku = get_post_meta($parent_id, '_sku', true);
                        if (function_exists(add_to_debug)) add_to_debug('empty sku id=' . $theid . 'parent=' . $parent_id . 'setting sku to ' . $sku);
                        update_post_meta($theid, '_sku', $sku);
                        update_post_meta($parent_id, '_sku', '');
                    }
                }
                // ****************** end error checking *****************

                // its a simple product
            } else {
                $sku = get_post_meta($theid, '_sku', true);
                $thetitle = get_the_title();
            }
            // add product to array but don't add the parent of product variations
            if (!empty($sku)) $full_product_list[] = array($thetitle, $sku, $theid);
        endwhile;
        wp_reset_query();
        // sort into alphabetical order, by title
        sort($full_product_list);
        return $full_product_list;
    }

    if (empty($layout)) {
        $layout = 'right';
    }
    $blog_style = '';
    $column = '';
    get_header(); ?>
    <div id="theme-page">
    <div class="pacz-main-wrapper-holder">
        <div class="theme-page-wrapper pacz-main-wrapper <?php echo esc_attr($layout); ?>-layout pacz-grid vc_row-fluid">
            <div class="inner-page-wrapper">
                <div class="theme-content  author-page" itemprop="mainContentOfPage">
                    <?php
                    echo '<div class="popup" data-popup="single_contact_form">';
                    echo '<div class="popup-inner single-contact">';
                    echo '<div class="alsp-popup-title">' . esc_html__('Send a Message', 'ALSP') . '<a class="popup-close" data-popup-close="single_contact_form" href="#"><i class="pacz-fic4-error"></i></a></div>';
                    echo '<div class="alsp-popup-content">';
                    global $current_user;

                    if (is_user_logged_in() && $current_user->ID == $authorID) {
                        echo esc_html__('You can not send message on your own', 'ALSP');
                    } elseif (!is_user_logged_in()) {
                        echo '<a href="'.get_permalink(100).'">'.esc_html__('Login Required', 'ALSP').'</a>';
                    } elseif (current_user_can('administrator')) {
                        echo esc_html__('Administrator can not send message from front-end', 'ALSP');
                    } else {
                        if ($ALSP_ADIMN_SETTINGS['message_system'] == 'instant_messages') {
                            echo '<div class="form-new">';
                            echo do_shortcode('[difp_shortcode_new_message_form to="' . $author_name . '" subject=""]');
                            echo '</div>';
                        }/*elseif($ALSP_ADIMN_SETTINGS['message_system'] == 'email_messages'){
                            if ($ALSP_ADIMN_SETTINGS['alsp_listing_contact_form'] && (!$listing->is_claimable || !$ALSP_ADIMN_SETTINGS['alsp_hide_claim_contact_form']) && ($listing_owner = get_userdata($listing->post->post_author)) && $listing_owner->user_email){

                                if (defined('WPCF7_VERSION') && alsp_get_wpml_dependent_option('alsp_listing_contact_form_7')){
                                    echo do_shortcode(alsp_get_wpml_dependent_option('alsp_listing_contact_form_7'));
                                }else{
                                    alsp_frontendRender('frontend/contact_form.tpl.php', array('listing' => $listing));

                                }

                            }
                        }*/ else {
                            echo esc_html__('Messages are currenlty disabled by Site Owner', 'ALSP');
                        }
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    ?>

                    <div class="author-detail-section clearfix">
                        <?php
                        //					$output .='<div class="author-detail-section clearfix">';
                        $output .= '<div class="author-thumbnail">';
                        if (!empty($author_img_url)) {
                            $params = array('width' => 300, 'height' => 370, 'crop' => true);
                            $output .= "<img src='" . bfi_thumb("$author_img_url", $params) . "' alt='' />";
                        } else {
                            $avatar_url = pacz_get_avatar_url(get_the_author_meta('user_email', $authorID), $size = '300');
                            $output .= '<img src="' . $avatar_url . '" alt="author" />';
                        }
                        $output .= '<div class="author-btns style2">
                                        <div class="author-btn-holder">
                                            <a class="" data-popup-open="single_contact_form" href="#">' . _('Send a message') . '</a>
                                        </div>
                                    </div>';
                        $output .= '</div>';
                        ?>

                        <?php
                        $output .= '<div class="author-content-section">';
                        $output .= '<div class="author-title">' . $author_name . $author_log_status . '</div>';
                        $output .= '<p class="author-reg-date">' . esc_html__('Member since', 'classiadspro') . ' ' . $registered . '</p>';
                        if ($author_verified == 'verified') {
                            $output .= '<span class="author_verifed ">' . esc_html__('Verified', 'classiadspro') . '</span>';
                        } else {
                            $output .= '<span class="author_unverifed ">' . esc_html__('Unverified', 'classiadspro') . '</span>';
                        }
                        if ($ALSP_ADIMN_SETTINGS['frontend_panel_user_type']) {
                            if (isset($author_type) && !empty($author_type)) {
                                if ($author_type == 'dealer') {
                                    $author_type = esc_html__('Dealer', 'classiadspro');
                                } else if ($author_type == 'individual') {
                                    $author_type = esc_html__('Individual', 'classiadspro');
                                } else if ($author_type == 'agency') {
                                    $author_type = esc_html__('Agency', 'classiadspro');
                                } else if ($author_type == 'supplier') {
                                    $author_type = esc_html__('Supplier', 'classiadspro');
                                }
                                $output .= '<span class="author_type ">' . $author_type . '</span>';
                            }
                        }
                        if (class_exists('alsp_plugin')) {
                            $output .= '<div class="author-details">';
                            if ($ALSP_ADIMN_SETTINGS['frontend_panel_user_phone']) {
                                $output .= '<p class=" clearfix"><span class="author-info-title">' . esc_html__('Mobile ', 'classiadspro') . '</span><span class="author-info-content">' . $phone_number . '</span></p>';
                            }
                            if ($ALSP_ADIMN_SETTINGS['frontend_panel_user_email']) {
                                $output .= '<p class=" clearfix"><span class="author-info-title">' . esc_html__('Email ', 'classiadspro') . '</span><span class="author-info-content">' . $author_email . '</span></p>';
                            }
                            if ($ALSP_ADIMN_SETTINGS['frontend_panel_user_website']) {
                                $output .= '<p class=" clearfix"><span class="author-info-title">' . esc_html__('Website ', 'classiadspro') . '</span><span class="author-info-content">' . $author_website . '</span></p>';
                            }
                            if ($ALSP_ADIMN_SETTINGS['frontend_panel_user_address']) {
                                $output .= '<p class=" clearfix"><span class="author-info-title">' . esc_html__('Address ', 'classiadspro') . '</span><span class="author-info-content">' . $author_address . '</span></p>';
                            }
                            if ($ALSP_ADIMN_SETTINGS['frontend_panel_social_links']) {
                                $output .= '<div class="author-details-info clearfix"><span class="author-info-title">' . esc_html__('Follow Me ', 'classiadspro') . '</span>';
                                $output .= '<ul class="author-info-content">';

                                if (!empty($author_fb)) {
                                    $output .= '<li><a href="' . $author_fb . '" target_blank><i class="pacz-icon-facebook"></i></a></li>';
                                }
                                if (!empty($author_tw)) {
                                    $output .= '<li><a href="' . $author_tw . '" target_blank><i class="pacz-icon-twitter"></i></a></li>';
                                }
                                if (!empty($author_gplus)) {
                                    $output .= '<li><a href="' . $author_gplus . '" target_blank><i class="pacz-icon-google-plus"></i></a></li>';
                                }
                                if (!empty($author_linkedin)) {
                                    $output .= '<li><a href="' . $author_linkedin . '" target_blank><i class="pacz-icon-linkedin"></i></a></li>';
                                }
                                if (!empty($author_ytube)) {
                                    $output .= '<li><a href="' . $author_ytube . '" target_blank><i class="pacz-icon-youtube"></i></a></li>';
                                }
                                if (!empty($author_vimeo)) {
                                    $output .= '<li><a href="' . $author_vimeo . '" target_blank><i class="pacz-icon-vimeo-square"></i></a></li>';
                                }
                                if (!empty($author_instagram)) {
                                    $output .= '<li><a href="' . $author_instagram . '" target_blank><i class="pacz-icon-instagram"></i></a></li>';
                                }
                                if (!empty($author_flickr)) {
                                    $output .= '<li><a href="' . $author_flickr . '" target_blank><i class="pacz-icon-flickr"></i></a></li>';
                                }
                                if (!empty($author_behance)) {
                                    $output .= '<li><a href="' . $author_behance . '" target_blank><i class="pacz-icon-behance"></i></a></li>';
                                }
                                if (!empty($author_dribbble)) {
                                    $output .= '<li><a href="' . $author_dribbble . '" target_blank><i class="pacz-icon-dribbble"></i></a></li>';
                                }

                                $output .= '</ul>';
                                $output .= '</div>';
                            }
                            $output .= '</div>';
                        }
                        $output .= '</div>';
                        //					$output .='</div>';
                        echo $output;

                        $contractor_data = get_userdata($authorID);
                        $contractor_role = $contractor_data->roles;
                        //                        echo $contractor_role[0];
                        if ($contractor_role[0] == 'contributor'):
                            ?>
                            <div class="clearfix"></div>
                            <div id="biography">
                                <section>
                                    <div class="single-post-fancy-title comments-heading-label"><span>Biography</span>
                                    </div>
                                    <div><?php echo $description; ?></div>
                                </section>
                            </div>
                            <div id="comments-reviews">
                                <section id="comments">
                                    <?php
                                    echo '<p class="message">';
                                    if ($_POST['post_review_nonce'] != "") {
                                        Rating_Contractor::post_review($_POST);
                                    }
                                    echo '</p>';
                                    $args = array(
                                        'post_type' => 'ratingcontractor',
                                        'meta_key' => 'contractor',
                                        'meta_value' => $authorID
                                    );
                                    $loop = new WP_Query($args);
                                    ?>
                                    <div class="single-post-fancy-title comments-heading-label"><span>User Reviews <span
                                                    class="comments_numbers">(<?php echo $loop->post_count; ?>
                                                )</span></span></div>
                                    <ul class="pacz-commentlist">
                                        <?php
                                        while ($loop->have_posts()) : $loop->the_post();
                                            ?>
                                            <li class="comment byuser comment-author-designinvento even thread-even depth-1"
                                                id="li-comment-48">
                                                <div class="pacz-single-comment userresponse clearfix" id="comment-48">
                                                    <div class="gravatar">
                                                        <div class="author-img">
                                                            <?php
                                                            $rater = get_field('rater');
                                                            if ($rater) {
                                                                $user_info = get_userdata($rater['ID']);
                                                                $author_img_url = get_the_author_meta('pacz_author_avatar_url', $user_info->ID, true);
                                                                if (!empty($author_img_url)) {
                                                                    $params = array('width' => 300, 'height' => 300, 'crop' => true);
                                                                    echo "<img src='" . bfi_thumb("$author_img_url", $params) . "' alt='' />";
                                                                } else {
                                                                    $avatar_url = pacz_get_avatar_url(get_the_author_meta('user_email', get_field('rater')), $size = '300');
                                                                    echo '<img src="' . $avatar_url . '" alt="author" />';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="comment-meta-main">
                                                        <div class="comment-meta">
                                                            <p class="dirrater_title"><?php the_title(); ?></p>
                                                            <div class="review_rate"
                                                                 data-dirrater="<?php the_field('score'); ?>"
                                                                 title=""></div>
                                                            <span class="comment-author"><?php
                                                                $job = get_field('job');
                                                                if ($rater) {
                                                                    $user_info = get_userdata($rater['ID']);
                                                                    echo $user_info->display_name;
                                                                }
                                                                ?><?php _e('review for'); ?><?php echo get_the_title($job->ID); ?></span>
                                                            <time class="comment-time"><?php the_date(); ?></time>
                                                            <span class="comment-reply">
                                                        </span>
                                                        </div>
                                                        <div class="clearboth"></div>
                                                        <div class="comment-content">
                                                            <p><?php the_content(); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php
                                        endwhile;
                                        ?>
                                    </ul>
                                    <?php if (is_user_logged_in()):
//                                    if (Rating_Contractor::check_reviewable(get_current_user_id(), $authorID)):
                                        ?>
                                        <?php
                                        $args1 = array(
                                            'post_type' => 'ratingcontractor',
                                            'post_per_page' => -1,
                                            'meta_query' => array(
                                                'relation' => 'AND',
                                                array(
                                                    'key' => 'rater',
                                                    'value' => get_current_user_id(),
                                                    'compare' => '=',
                                                ),
                                                array(
                                                    'key' => 'contractor',
                                                    'value' => $authorID,
                                                    'compare' => '=',
                                                ),
                                            ),
                                        );
                                        $reviews = get_posts($args1);
                                        $jobs_rated = array();
                                        if (count($reviews) > 0) {
                                            foreach ($reviews as $review) {
                                                setup_postdata($review);
                                                $job = get_field('job', $review->ID);
                                                $jobs_rated[] = $job->ID;
                                            }
                                        }
                                        $args2 = array(
                                            'post_type' => 'alsp_listing',
                                            'posts_per_page' => -1,
                                            'author' => get_current_user_id()
                                        );
                                        $jobs = get_posts($args2);
                                        $jobs_owned = array();
                                        if (count($jobs) > 0) {
                                            foreach ($jobs as $post) {
                                                setup_postdata($post);
                                                $jobs_owned[] = $post->ID;
                                            }
                                        }
//                                    var_dump($jobs_owned);
                                        if (count($jobs_owned) > 0):
                                            $args3 = array(
                                                'post_type' => 'bidding',
                                                'posts_per_page' => -1,
                                                'meta_query' => array(
                                                    'relation' => 'AND',
                                                    array(
                                                        'key' => 'job',
                                                        'value' => $jobs_rated,
                                                        'compare' => 'NOT IN',
                                                    ),
                                                    array(
                                                        'key' => 'job',
                                                        'value' => $jobs_owned,
                                                        'compare' => 'IN',
                                                    ),
                                                    array(
                                                        'key' => 'bid_status',
                                                        'value' => 'Completed',
                                                        'compare' => '=',
                                                    ),
                                                    array(
                                                        'key' => 'contractor',
                                                        'value' => $authorID,
                                                        'compare' => '=',
                                                    ),
                                                ),
                                            );
                                            $jobs = get_posts($args3);
                                            ?>
                                            <?php if (count($jobs) > 0): ?>
                                            <div class="inner-content">

                                                <div id="respond" class="comment-respond">
                                                    <h3 id="reply-title" class="comment-reply-title">
                                                        <div class="single-post-fancy-title">
                                                            <h5>Post New Review</h5>
                                                        </div>
                                                    </h3>
                                                    <form action="" method="post" id="commentform" class="comment-form">
                                                        <div id="new_rating_wrapper" style="cursor: pointer;">
                                                            <label for="new_listing_rating">Your Rating</label>
                                                            <div id="new_listing_rating" data-dirrater="4"
                                                                 data-assets_path="http://classiads.designinvento.net/classiads-ultra/wp-content/plugins/listing/addons/di-reviews/includes//images">
                                                                Exceptional
                                                            </div>
                                                        </div>
                                                        <p class="">
                                                            <label for="dirrater_title">Select job for rating:</label>

                                                            <select name="job">
                                                                <?php foreach ($jobs as $post) : setup_postdata($post); ?>
                                                                    <?php
                                                                    $job = get_field('job', $post->ID);
                                                                    ?>
                                                                    <option value="<?php echo $job->ID; ?>"><?php echo get_the_title($job); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>

                                                        </p>
                                                        <p class="dir--title">
                                                            <label for="dirrater_title">Title of your review:</label>
                                                            <input type="text" id="dirrater_title" name="dirrater_title"
                                                                   value="" placeholder="Review Title" size="25">
                                                        </p>

                                                        <p class="dir_message_field"><label for="comment">Your
                                                                Review</label>
                                                            <textarea id="comment" name="comment" cols="45" rows="3"
                                                                      aria-required="true" required="required"
                                                                      placeholder="Review "></textarea></p>


                                                        <p class="form-submit"><input name="submit" type="submit"
                                                                                      id="submit" class="submit"
                                                                                      value="Submit Review">
                                                            <input type="hidden" name="rated_by"
                                                                   value="<?php echo get_current_user_id(); ?>"/>
                                                            <input type="hidden" name="contractor"
                                                                   value="<?php echo $authorID; ?>"/>
                                                            <?php wp_nonce_field('post_review_action', 'post_review_nonce'); ?>
                                                        </p>
                                                    </form>
                                                </div>
                                                <!-- #respond -->
                                            </div>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                        <?php //endif; ?>
                                    <?php endif; ?>
                                </section>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                    /* Run the blog loop shortcode to output the posts. */
                    if (class_exists('WPBakeryShortCode') && class_exists('alsp_plugin') && $ALSP_ADIMN_SETTINGS['single_listing_other_ads_byuser']) {
                        $author = get_user_by('slug', get_query_var('author_name'));
                        $authorID = $author->ID;
                        $single_listing_othoradd_limitv = $ALSP_ADIMN_SETTINGS['single_listing_othoradd_limit'];
                        $single_listing_otherads_viewshitcherv = $ALSP_ADIMN_SETTINGS['single_listing_otherads_viewshitcher'];
                        $hide_ordering_single_listing_otheradsv = $ALSP_ADIMN_SETTINGS['hide_ordering_single_listing_otherads'];
                        $single_listing_otherads_view_typev = $ALSP_ADIMN_SETTINGS['single_listing_otherads_view_type'];
                        $single_listing_otherads_gridview_colv = $ALSP_ADIMN_SETTINGS['single_listing_otherads_gridview_col'];
                        if (isset($single_listing_othoradd_limitv)) {
                            $single_listing_othoradd_limit = $ALSP_ADIMN_SETTINGS['single_listing_othoradd_limit'];
                        } else {
                            $single_listing_othoradd_limit = 4;
                        }
                        if (isset($single_listing_otherads_viewshitcherv)) {
                            $single_listing_otherads_viewshitcher = $ALSP_ADIMN_SETTINGS['single_listing_otherads_viewshitcher'];
                        } else {
                            $single_listing_otherads_viewshitcher = 0;
                        }
                        if (isset($hide_ordering_single_listing_otheradsv)) {
                            $hide_ordering_single_listing_otherads = $ALSP_ADIMN_SETTINGS['hide_ordering_single_listing_otherads'];
                        } else {
                            $hide_ordering_single_listing_otherads = 1;
                        }
                        if (isset($single_listing_otherads_view_typev)) {
                            $single_listing_otherads_view_type = $single_listing_otherads_view_typev;
                        } else {
                            $single_listing_otherads_view_type = 'list';
                        }
                        if (isset($single_listing_otherads_gridview_colv)) {
                            $single_listing_otherads_gridview_col = $ALSP_ADIMN_SETTINGS['single_listing_otherads_gridview_col'];
                        } else {
                            $single_listing_otherads_gridview_col = 2;
                        }
                        echo do_shortcode('[webdirectory-listings perpage="' . $single_listing_othoradd_limit . '" show_views_switcher="' . $single_listing_otherads_viewshitcher . '" hide_order="' . $hide_ordering_single_listing_otherads . '" hide_paginator="1" order_by="post_date" order="DESC" hide_count="1" listings_view_type="' . $single_listing_otherads_view_type . '" listings_view_grid_columns="' . $single_listing_otherads_gridview_col . '" author="' . $authorID . '"]');

                    }
                    ?>

                    <div class="clearboth"></div>

                </div>
                <?php if ($layout != 'full') get_sidebar(); ?>
            </div>

            <div class="clearboth"></div>
        </div>
    </div>
<?php endif; ?>
<?php get_footer(); ?>