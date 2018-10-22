<?php
if(get_current_user_role()=='contributor'):
    _e('You dont have permission for accessing this section');
else:
$user_id = get_current_user_id();
$args = array(
    'post_type' => 'alsp_listing',
    'author' => $user_id,
    'orderby' => 'post_date',
    'order' => 'ASC',
    'posts_per_page' => -1
);
$current_user_jobs = get_posts($args);
$post_ids_array = array();

$posts_array = array();
if (count($current_user_jobs) > 0) {
    foreach ($current_user_jobs as $post) :
        setup_postdata($post);
        $post_ids_array[] = $post->ID;
        $posts_array[] = array($post->ID, $post->post_title);
    endforeach;
    wp_reset_postdata();
}
if($_REQUEST['job_id']>0){
    $post_ids_array = array($_REQUEST['job_id']);
}
$job_statuses = array('New','Rejected','Accepted');
?>
<div class="jb-top-search">
    <form action="" method="GET">
        <input type="hidden" name="alsp_action" value="applications" />
        <div class="jb-search jb-search-group-visible">
            <div class="jb-input jb-input-type-half jb-input-type-half-left">
                <label><?php _e('Filter by job'); ?></label>
                <select name="job_id">
                    <option value="">All Jobs</option>
                    <?php foreach ($posts_array as $job): ?>
                        <option value="<?php echo $job[0]; ?>" <?php if($_REQUEST['job_id']==$job[0]) echo 'selected'; ?>><?php echo $job[1]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="jb-input jb-input-type-half jb-input-type-half-left">
                <label><?php _e('Filter by status'); ?></label>
                <select name="job_status">
                    <option value=""><?php _e('All Statuses'); ?></option>
                    <?php foreach($job_statuses as $status): ?>
                     <option value="<?php echo $status; ?>" <?php if($status==$_REQUEST["job_status"]) echo 'selected'; ?>><?php echo $status; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="jb-list-search">
            <input type="submit" value="<?php _e('Apply filter'); ?>">
        </div>
    </form>
</div>
<?php
if($_REQUEST['job_status']!=""){
    $applications = get_posts(array(
        'numberposts' => -1,
        'post_type' => 'bidding',
        'meta_query' => array(
            'relation'		=> 'AND',
            array(
                'key' => 'job',
                'value' => $post_ids_array,
                'compare' => 'IN',
            ),
            array(
                'key'	  	=> 'bid_status',
                'value'	  	=> $_REQUEST['job_status'],
                'compare' 	=> '=',
            ),
        ),
    ));
}else{
    $applications = get_posts(array(
        'posts_per_page' => -1,
        'post_type' => 'bidding',
        'meta_query' => array(
            array(
                'key' => 'job',
                'value' => $post_ids_array,
                'compare' => 'IN',
            ),
        ),
    ));
}

?>
<div class="jb-grid jb-grid-compact">
    <?php if (count($applications) > 0): ?>
        <?php foreach ($applications as $post) : setup_postdata($post); ?>
            <?php
            $contractor = get_field('contractor', $post->ID);
//            var_dump($contractor);
            $job = get_field('job', $post->ID);
            $status = (get_field('bid_status', $post->ID) != '' ) ? get_field('bid_status', $post->ID) : 'New';
            global $current_user;
            global $ALSP_ADIMN_SETTINGS;
            $author_name = get_the_author_meta('display_name', $contractor->ID);
            ?>
            <div class="jb-grid-row jb-manage-item jb-manage-application jb-application-status-<?php echo strtolower($status); ?>"
                 data-id="<?php echo $post->ID; ?>" data-contractor="<?php echo $contractor['display_name']; ?>">
                <div class="jb-grid-col jb-col-1 jb-manage-header-img" style="width:150px">
                    <?php //echo $contractor['user_avatar']; ?>
                    <a href="<?php echo get_author_posts_url($contractor->ID, $contractor['user_nicename']); ?>">
                    <?php
                    $author_img_url = get_the_author_meta('pacz_author_avatar_url', $contractor['ID'], true);
                    if (!empty($author_img_url)) {
                    $params = array('width' => 150, 'height' => 150, 'crop' => false);
                    echo "<img src='" . bfi_thumb("$author_img_url", $params) . "' alt='' />";
                    } else {
                    $avatar_url = pacz_get_avatar_url(get_the_author_meta('user_email', $contractor['ID']), $size = '150');
                    echo '<img src="' . $avatar_url . '" alt="author" />';
                    }
                    ?>
                    </a>
                </div>
                <div class="jb-grid-col jb-col-90" style="width:calc( 100% - 150px )">
                    <div class="jb-manage-header">
                        <h3 class="jb-manage-header-left jb-line-major jb-manage-title">
                            <a href="<?php echo get_author_posts_url($contractor->ID, $contractor['user_nicename']); ?>">
                                <?php echo $contractor['display_name']; ?>
                            </a>
                        </h3>
                        <h4><?php _e('Applied for'); ?>
                                <a href="<?php echo get_permalink($job); ?>"
                                   class="jb-no-text-decoration"><?php echo get_the_title($job); ?></a><br>
                            <?php _e('Bid Amount'); ?>: <span class="bid-amount">$<?php echo get_field('cost', $post->ID); ?></span><br>
                            <?php _e('Bid Status'); ?>: <span class="jb-bid-status"><?php echo $status; ?></span>
                        </h4>
                        <div class="jb-bid-message">
                            <span class="content">
                                <?php if(strlen(get_the_content($post->ID))>150): ?>
                                <div class="jb-short-content">
                                    <?php echo substr(get_the_content($post->ID), 0, 150); ?>
                                </div>
                                <div class="jb-full-content" style="display: none;">
                                    <?php echo get_the_content($post->ID); ?>
                                </div>
                                <button class="jb-show-more"><?php _e('Show More');?></button>
                                <?php else: ?>
                                    <?php echo get_the_content($post->ID); ?>
                                <?php endif; ?>
                            </span>

                        </div>
                        <ul class="jb-manage-header-right">
                            <li>
                                <a href="<?php echo get_author_posts_url($contractor->ID, $contractor['user_nicename']); ?>"><?php _e('View profile'); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo get_permalink($job); ?>"><?php _e('View job'); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="jb-manage-actions-wrap">
                        <span class="jb-manage-actions-left">
                            <span class="jb-glyphs jb-icon-clock"></span>
                                <span class="jb-manage-header-right-item-text">
                            <?php echo date('F d, Y', strtotime($post->post_date)); ?>
                                </span>
                        </span>
                        <span class="jb-manage-actions-right">
                            <div class="popup popup-status-change" data-popup="jb-accept-bid-<?php echo $post->ID; ?>">
                                <div class="popup-inner single-contact">
                                    <div class="alsp-popup-content">
                                        <a class="popup-close" data-popup-close="jb-accept-bid-<?php echo $post->ID; ?>" href="#"><i class="pacz-fic4-error"></i></a>
                                        <h3><?php echo $contractor['user_nicename']; ?></h3>
                                        <p>
                                            <strong><?php _e('APPLIED FOR:')?></strong> <a href="<?php echo get_permalink($job); ?>"><?php echo get_the_title($job); ?></a><br>
                                            <strong><?php _e('BID AMOUNT:'); ?></strong> <span>$<?php echo get_field('cost', $post->ID); ?></span>
                                        </p>
                                        <a href="javascript: void()" class="jb-accept-bid"><?php _e('I accept this offer'); ?></a>
                                        <a class="jb-cancel-btn" data-popup-close="jb-accept-bid-<?php echo $post->ID; ?>" href="#"><?php _e('Cancel'); ?></a>
                                        <p><?php _e('*The contractor will be notified right away'); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="popup popup-status-change" data-popup="jb-reject-bid-<?php echo $post->ID; ?>">
                                <div class="popup-inner single-contact">
                                    <div class="alsp-popup-content">
                                        <a class="popup-close" data-popup-close="jb-reject-bid-<?php echo $post->ID; ?>" href="#"><i class="pacz-fic4-error"></i></a>
                                        <h3><?php echo $contractor['user_nicename']; ?></h3>
                                        <p>
                                            <strong><?php _e('APPLIED FOR:')?></strong> <a href="<?php echo get_permalink($job); ?>"><?php echo get_the_title($job); ?></a><br>
                                            <strong><?php _e('BID AMOUNT:'); ?></strong> <span>$<?php echo get_field('cost', $post->ID); ?></span>
                                        </p>
                                        <a href="javascript: void()" class="jb-reject-bid"><?php _e('Reject this offer'); ?></a>
                                        <a class="jb-cancel-reject-btn" data-popup-close="jb-reject-bid-<?php echo $post->ID; ?>" href="#"><?php _e('Cancel'); ?></a>
                                        <p><?php _e('*The contractor will be notified right away'); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php

                            echo '<div class="popup" data-popup="single_contact_form_'.$post->ID.'">';
                            echo '<div class="popup-inner single-contact">';
                            echo '<div class="alsp-popup-title">'.esc_html__('Send a Message', 'ALSP').'<a class="popup-close" data-popup-close="single_contact_form_'.$post->ID.'" href="#"><i class="pacz-fic4-error"></i></a></div>';
                            echo '<div class="alsp-popup-content">';
                            if($ALSP_ADIMN_SETTINGS['message_system'] == 'instant_messages'){
                                echo '<div class="form-new">';
                                echo do_shortcode('[difp_shortcode_new_message_form to="'.$author_name.'" subject="You have been accepted for the job"]');
                                echo '</div>';
                            }else{
                                echo esc_html__('Messages are currenlty disabled by Site Owner', 'ALSP');
                            }
                            echo'</div>';
                            echo'</div>';
                            echo'</div>';
                            ?>
                            <?php if($status!='Accepted'&&$status!='Rejected'): ?>
                                <a href="javascript: void()" class="jb-accept-btn" data-popup-open="jb-accept-bid-<?php echo $post->ID; ?>"><?php _e('Accept Bid'); ?></a>
                                <a href="javascript: void()" class="jb-reject-btn" data-popup-open="jb-reject-bid-<?php echo $post->ID; ?>"><?php _e('Reject Bid'); ?></a>
                                <p class="jb-accepted-text" style="display: none;"><?php _e('You’ve accepted this bid.'); ?> <a href="javascript: void()" class="message-btn" data-popup-open="single_contact_form_<?php echo $post->ID; ?>"><?php _e('Get Started'); ?></a></p>
                                <p class="jb-rejected-text" style="display: none;"><?php _e('You’ve rejected this bid.'); ?></p>
                            <?php else: ?>
                                <p class="jb-accepted-text"><?php _e('You’ve'); ?> <?php echo $status; ?> <?php _e('this bid.'); ?>  <?php if($status=='Accepted'): ?><a href="javascript: void()" class="message-btn" data-popup-open="single_contact_form_<?php echo $post->ID; ?>"><?php _e('Get Started'); ?></a><?php endif; ?></p>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach;
        wp_reset_postdata(); ?>
    <?php else: ?>
     <div class="jb-grid-row jb-manage-item jb-manage-application">
        <?php _e("No application!"); ?>
     </div>
    <?php endif; ?>
</div>
<div class="jb-paginate-links">
</div>
<script>
    // Init global namespace
    var WPJB = WPJB || {};

    WPJB.Manage = WPJB.Manage || {};

    WPJB.Manage.Apps = {

    };

    WPJB.Manage.Apps.Item = function(item) {
        this.item = item;
        this.element = { };
        this.input = { };

        this.status = new WPJB.Manage.Apps.Item.StatusChange(this.item);
        this.rating = new WPJB.Manage.Apps.Item.Rating(this.item.find(".jb-star-ratings"))
        this.element.more = this.item.find(".jb-manage-actions-more");

        this.input.more = this.item.find(".jb-manage-action-more");

        // check if has more items
        if(this.element.more.find(".jb-manage-action").length < 1) {
            this.input.more.hide();
        }
    };

    WPJB.Manage.Apps.Item.Rating = function(item) {
        this.current_rating = 0;
        this.try_rating = null;

        this.rating = item;

        this.stars = this.rating.find(".jb-star-rating");
        this.loader = this.rating.find(".jb-star-rating-loader");

        this.stars.on( "click", jQuery.proxy( this.rating_click, this ) );
    };

    WPJB.Manage.Apps.Item.Rating.prototype.rating_click = function(e) {
        if(typeof e !== 'undefined') {
            e.preventDefault();
        }

        this.try_rating = parseInt(jQuery(e.target).data("value"));
        this.loader.show();

        jQuery.each(this.stars, jQuery.proxy( this.stars_check, this ));

//        console.log('clicked');

        var data = {
            action: "wpjb_applications_rate",
            application: this.rating.data("id"),
            value: this.try_rating
        };

        jQuery.ajax({
            url: wpjb_manage_apps_lang.ajaxurl,
            type: "post",
            data: data,
            dataType: "json",
            success: jQuery.proxy( this.rating_success, this ),
            error: jQuery.proxy( this.rating_error, this )
        });


    };

    WPJB.Manage.Apps.Item.Rating.prototype.stars_check = function(index, item) {
        if(this.try_rating >= parseInt(jQuery(item).data("value"))) {
            jQuery(item).addClass("jb-star-checked");
        } else {
            jQuery(item).removeClass("jb-star-checked");
        }
    };

    WPJB.Manage.Apps.Item.Rating.prototype.rating_success = function(response) {
        this.loader.hide();
        this.current_rating = this.try_rating;
        this.try_rating = null;
    };

    WPJB.Manage.Apps.Item.StatusChange = function(item) {
        this.id = item.data("id");
        this.contractor = item.data("contractor");

        this.element = { };
        this.element.item = item;
        this.element.button = item.find(".jb-manage-app-status-change");
        this.element.accept_popup_btn = item.find(".jb-accept-btn");
        this.element.cancel_btn = item.find(".jb-cancel-btn");
        this.element.cancel_reject_btn = item.find(".jb-cancel-reject-btn");
        this.element.accept_text = item.find(".jb-accepted-text");
        this.element.reject_text = item.find(".jb-rejected-text");
        this.element.accept = item.find(".jb-accept-bid");
        this.element.reject_popup_btn = item.find(".jb-reject-btn");
        this.element.reject = item.find(".jb-reject-bid");
        this.element.status = item.find(".jb-bid-status");
        this.element.more = item.find(".jb-show-more");
        this.element.shortcontent = item.find(".jb-short-content");
        this.element.fullcontent = item.find(".jb-full-content");
        this.element.button_label = item.find(".jb-application-status-current-label")
        this.element.slider = item.find(".jb-application-change-status");
        this.element.dropdown = item.find(".jb-application-change-status-dropdown");
        this.element.checkbox = item.find(".jb-application-change-status-checkbox");
        this.element.label = item.find(".jb-application-change-status-label");
        this.element.loader = item.find(".jb-application-change-status-loader");
        this.element.submit = item.find(".jb-application-change-status-submit");

        this.element.button.on( "click", jQuery.proxy( this.button_click, this ) );
        this.element.accept.on( "click", jQuery.proxy( this.accept_click, this ) );
        this.element.reject.on( "click", jQuery.proxy( this.reject_click, this ) );
        this.element.dropdown.on( "click", jQuery.proxy( this.dropdown_change, this ) );
        this.element.submit.on( "click", jQuery.proxy( this.submit_click, this ) );
        this.element.more.on( "click", jQuery.proxy( this.more_toggle, this ) );
    };

    WPJB.Manage.Apps.Item.StatusChange.prototype.more_toggle = function(e) {
        if(typeof e != "undefined") {
            e.preventDefault();
        }
//        console.log('fdafs');
//        this.element.slider.slideUp("fast");
        this.element.more.slideUp("fast");
        this.element.shortcontent.slideUp("fast");
        this.element.fullcontent.slideDown("fast");
    };

    WPJB.Manage.Apps.Item.StatusChange.prototype.button_click = function(e) {
        if(typeof e != "undefined") {
            e.preventDefault();
        }

        this.element.slider.slideToggle("fast");
        this.dropdown_change();
    };
    WPJB.Manage.Apps.Item.StatusChange.prototype.accept_click = function(e) {
        if(typeof e != "undefined") {
            e.preventDefault();
        }
//        if(confirm('Please confirm that you will be accepting "'+this.contractor+'" as your contract for this project. This project will now be closed')){
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

            var data = {
                action: "jb_applications_status",
                id: this.id,
                status: 'Accepted',
                notify: 1
            };

            jQuery.ajax({
                url: ajaxurl,
                type: "post",
                dataType: "json",
                data: data,
                success: jQuery.proxy( this.accept_success, this ),
                error: jQuery.proxy( this.submit_error, this )
            });
//        }
    };
    WPJB.Manage.Apps.Item.StatusChange.prototype.accept_success = function(response) {
        this.element.item.removeClass (function (index, className) {
            return (className.match (/(^|\s)jb-application-status-\S+/g) || []).join(' ');
        });
        this.element.cancel_btn.click();
        this.element.status.text( "Accepted");
        this.element.accept_popup_btn.slideUp('fast');
        this.element.reject_popup_btn.slideUp('fast');
        this.element.accept_text.slideDown('fast');
//        this.element.item.removeChild( this.element.reject);
    };

    WPJB.Manage.Apps.Item.StatusChange.prototype.reject_click = function(e) {
        if(typeof e != "undefined") {
            e.preventDefault();
        }

//        if(confirm('Please confirm that you will be rejecting contract of "'+this.contractor+'" for this project.')){
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

            var data = {
                action: "jb_applications_status",
                id: this.id,
                status: 'Rejected',
                notify: 1
            };

            jQuery.ajax({
                url: ajaxurl,
                type: "post",
                dataType: "json",
                data: data,
                success: jQuery.proxy( this.reject_success, this ),
                error: jQuery.proxy( this.submit_error, this )
            });
//        }
    };

    WPJB.Manage.Apps.Item.StatusChange.prototype.reject_success = function(response) {
        this.element.item.removeClass (function (index, className) {
            return (className.match (/(^|\s)jb-application-status-\S+/g) || []).join(' ');
        });
        this.element.cancel_reject_btn.click();
        this.element.status.text( "Rejected");
        this.element.accept_popup_btn.slideUp('fast');
        this.element.reject_popup_btn.slideUp('fast');
        this.element.reject_text.slideDown('fast');
    };

    WPJB.Manage.Apps.Item.StatusChange.prototype.dropdown_change = function(e) {
        if(this.element.dropdown.find("option:selected").data("can-notify") == "1") {
            this.element.checkbox.attr("disabled", false);
            this.element.checkbox.show();
            this.element.label.show();
        }  else {
            this.element.checkbox.attr("disabled", "disabled");
            this.element.checkbox.hide();
            this.element.label.hide();
        }
    };

    WPJB.Manage.Apps.Item.StatusChange.prototype.submit_click = function(e) {
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

        e.preventDefault();

        this.element.loader.removeClass("jb-none");

        var notify = 0;
        if(!this.element.checkbox.is(":disabled") && this.element.checkbox.is(":checked")) {
            notify = 1;
        }

        var data = {
            action: "jb_applications_status",
            id: this.id,
            status: this.element.dropdown.val(),
            notify: notify
        };

        jQuery.ajax({
//            url: wpjb_manage_apps_lang.ajaxurl,
            url: ajaxurl,
            type: "post",
            dataType: "json",
            data: data,
            success: jQuery.proxy( this.submit_success, this ),
            error: jQuery.proxy( this.submit_error, this )
        });
    };

    WPJB.Manage.Apps.Item.StatusChange.prototype.submit_success = function(response) {
        this.element.loader.addClass("jb-none");
        this.element.button_label.text(this.element.dropdown.find("option:selected").text());

        this.element.item.removeClass (function (index, className) {
            return (className.match (/(^|\s)jb-application-status-\S+/g) || []).join(' ');
        });
        console.log(response);
//        this.element.item.addClass("jb-application-status-"+response.status.key);
//        this.element.slider.slideToggle("fast");
        this.element.slider.slideUp("fast");
//        this.element.status.innerHTML = 'Accepted';
//        this.button_click();
    };

    jQuery(function($) {
        $(".jb-manage-application").each(function(index, item) {
            new WPJB.Manage.Apps.Item(jQuery(item));
        });

        $(".jb-button-submit").on("click", function(e) {
            e.preventDefault();
            jQuery(this).closest("form").submit();
        });
    });

</script>
<?php endif; ?>