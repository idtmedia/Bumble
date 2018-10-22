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
//            'relation'		=> 'AND',
            array(
                'key' => 'job',
                'value' => $post_ids_array,
                'compare' => 'IN',
            ),
//            array(
//                'key'	  	=> 'featured',
//                'value'	  	=> '1',
//                'compare' 	=> '=',
//            ),
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
                            <a href="javascript: void()" class="jb-accept-bid"><?php _e('Accept Bid'); ?></a>
                            <a href="javascript: void()" class="jb-reject-bid"><?php _e('Reject Bid'); ?></a>
                            <!--<a href="?alsp_action=applications&view=<?php /*echo $post->ID; */?>"
                               class="jb-manage-action jb-no-320-760"><span class="jb-glyphs jb-icon-eye"></span>View</a>
                            <a href="#" class="jb-manage-action jb-manage-app-status-change">
                                <span class="jb-glyphs jb-icon-down-open"></span>
                                Status —
                                <strong class="jb-application-status-current-label"><?php /*echo $status; */?></strong>
                            </a>-->
                        </span>
                    </div>
                </div>
                <!--<div style="clear: both; overflow: hidden"></div>
                <div class="jb-application-change-status jb-filter-applications" style="display: none">
                    <select name="job_id" class="jb-application-change-status-dropdown" style="display: inline-block">
                        <option value="New" data-can-notify="">New</option>
                        <option value="Read" data-can-notify="">Read</option>
                        <option value="Rejected" data-can-notify="1">Rejected</option>
                        <option value="Accepted" data-can-notify="1">Accepted</option>
                    </select>
                    <input style="display: inline-block" type="checkbox" value="1" class="jb-application-change-status-checkbox" id="jb-application-status-<?php /*echo $post->ID; */?>">
                    <label style="display: inline-block" class="jb-application-change-status-label" for="jb-application-status-<?php /*echo $post->ID; */?>">Notify applicant via email</label>
                    <span style="display: inline-block" class="jb-glyphs jb-icon-spinner jb-animate-spin jb-none jb-application-change-status-loader"></span>
                    <a style="display: inline-block" href="#" class="jb-button jb-application-change-status-submit" style="float:right">Change</a>
                </div>-->
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

        console.log('clicked');

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
        this.element.accept = item.find(".jb-accept-bid");
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
        if(confirm('Please confirm that you will be accepting "'+this.contractor+'" as your contract for this project. This project will now be closed')){
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
        }
    };
    WPJB.Manage.Apps.Item.StatusChange.prototype.accept_success = function(response) {
        this.element.item.removeClass (function (index, className) {
            return (className.match (/(^|\s)jb-application-status-\S+/g) || []).join(' ');
        });
        this.element.status.text( "Accepted");
    };

    WPJB.Manage.Apps.Item.StatusChange.prototype.reject_click = function(e) {
        if(typeof e != "undefined") {
            e.preventDefault();
        }

        if(confirm('Please confirm that you will be rejecting contract of "'+this.contractor+'" for this project.')){
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
        }
    };

    WPJB.Manage.Apps.Item.StatusChange.prototype.reject_success = function(response) {
        this.element.item.removeClass (function (index, className) {
            return (className.match (/(^|\s)jb-application-status-\S+/g) || []).join(' ');
        });
        this.element.status.text( "Rejected");
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