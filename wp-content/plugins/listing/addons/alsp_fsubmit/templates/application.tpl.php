<?php if(is_user_logged_in()):
    $application = get_post($_REQUEST['view']);
    $contractor = get_field('contractor', $application->ID);
    $job = get_field('job', $application->ID);
    $status = (get_field('bid_status', $application->ID) != '' ) ? get_field('bid_status', $application->ID) : 'New';

    $file = get_field('attachment', $application->ID);
    ?>
<div class="jb jb-page-job-application">
    <div class="jb-breadcrumb">
        <span class="jb-glyphs jb-icon-home"></span> <a href="./">Dashboard</a>
        <span class="jb-glyphs jb-icon-right-open"></span> <a href="?alsp_action=applications">Applications</a>
        <span class="jb-glyphs jb-icon-right-open"></span> <a href="<?php echo get_author_posts_url($contractor->ID, $contractor['user_nicename']); ?>">
            <?php echo $contractor['display_name']; ?>
        </a>
    </div>
    <div class="jb-grid jb-grid-compact">
        <div class="jb-grid-row jb-manage-item jb-manage-application" data-id="<?php echo $application->ID; ?>">
            <div class="jb-grid-col jb-col-1 jb-manage-header-img" style="width:80px">
                <?php //echo $contractor['user_avatar']; ?>
                <a href="<?php echo get_author_posts_url($contractor->ID, $contractor['user_nicename']); ?>">
                    <?php
                    $author_img_url = get_the_author_meta('pacz_author_avatar_url', $contractor['ID'], true);
                    if (!empty($author_img_url)) {
                        $params = array('width' => 100, 'height' => 100, 'crop' => true);
                        echo "<img src='" . bfi_thumb("$author_img_url", $params) . "' alt='' />";
                    } else {
                        $avatar_url = pacz_get_avatar_url(get_the_author_meta('user_email', $contractor['ID']), $size = '100');
                        echo '<img src="' . $avatar_url . '" alt="author" />';
                    }
                    ?>
            </div>
            <div class="jb-grid-col jb-col-90" style="width:calc( 100% - 80px )">
                <div class="jb-manage-header">
               <span class="jb-manage-header-left jb-line-major jb-manage-title">
               <strong style="font-size:1.2em">
               <a href="<?php echo get_author_posts_url($contractor->ID, $contractor['user_nicename']); ?>">
                                <?php echo $contractor['display_name']; ?>
                            </a>                                                    </strong>
               </span>
                    <ul class="jb-manage-header-right">
                        <li>
                            <span class="jb-glyphs jb-icon-briefcase"></span>
                            <span class="jb-manage-header-right-item-text">
                     <a href="<?php echo get_permalink($job); ?>" class="jb-no-text-decoration"><?php echo get_the_title($job); ?></a>
                     </span>
                        </li>
                    </ul>
                </div>
                <div class="jb-manage-actions-wrap">
               <span class="jb-manage-actions-left">
               <a href="#" class="jb-manage-action jb-manage-app-status-change">
               <span class="jb-glyphs jb-icon-down-open"></span>
               Status —
               <strong class="jb-application-status-current-label"><?php echo $status; ?></strong>
               </a>
               </span>
                </div>
            </div>
            <div style="clear: both; overflow: hidden"></div>
            <div class="jb-application-change-status jb-filter-applications" style="display: none">
                <select name="job_id" class="jb-application-change-status-dropdown" style="display: inline-block">
                    <option value="New" <?php if($status =='New') echo 'selected'; ?> data-can-notify="">New</option>
                    <option value="Read" <?php if($status =='Read') echo 'selected'; ?> data-can-notify="">Read</option>
                    <option value="Rejected" <?php if($status =='Rejected') echo 'selected'; ?> data-can-notify="1">Rejected</option>
                    <option value="Accepted" <?php if($status =='Accepted') echo 'selected'; ?> data-can-notify="1">Accepted</option>
                </select>
                <input type="checkbox" value="1" class="jb-application-change-status-checkbox" id="jb-application-status-<?php echo $application->ID; ?>">
                <label class="jb-application-change-status-label" for="jb-application-status-<?php echo $application->ID; ?>">Notify applicant via email</label>
                <span class="jb-glyphs jb-icon-spinner jb-animate-spin jb-none jb-application-change-status-loader"></span>
                <a href="#" class="jb-button jb-application-change-status-submit" style="float:right">Change</a>
            </div>
        </div>
    </div>
    <div class="jb-grid jb-grid-job-application-details">
        <?php if( $file ): ?>
        <div class="jb-grid-row">
            <div class="jb-col-30">
                Applicant attachment
            </div>
            <div class="jb-col-65 jb-glyphs jb-icon-link-ext-alt">
                <a href="<?php echo $file['url']; ?>" alt="<?php echo $file['filename']; ?>" target="_blank">View attachment</a>
            </div>
        </div>
        <?php endif; ?>
        <div class="jb-grid-row">
            <div class="jb-col-30">
                Date Sent
            </div>
            <div class="jb-col-65 jb-glyphs jb-icon-clock">
                <?php echo $application->post_date; ?>
            </div>
        </div>
    </div>
    <div class="jb-text-box">
        <h3>Message</h3>
        <div class="jb-text">
            <?php echo $job->post_content; ?>
        </div>
    </div>
    <!--<div class="jb-application-change-status ">
        <a href="#" class="jb-button jb-glyphs jb-icon-left" title="Older" style="cursor: not-allowed"></a>
        <span class=""><strong>1</strong> / 1</span>
        <a href="#" class="jb-button jb-glyphs jb-icon-right" title="Newer" style="cursor: not-allowed"></a>
    </div>-->
</div>
<?php else: ?>
    <?php _e('You dont have permission for accessing this page'); ?>
<?php endif; ?>
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

        this.element = { };
        this.element.item = item;
        this.element.button = item.find(".jb-manage-app-status-change");
        this.element.button_label = item.find(".jb-application-status-current-label")
        this.element.slider = item.find(".jb-application-change-status");
        this.element.dropdown = item.find(".jb-application-change-status-dropdown");
        this.element.checkbox = item.find(".jb-application-change-status-checkbox");
        this.element.label = item.find(".jb-application-change-status-label");
        this.element.loader = item.find(".jb-application-change-status-loader");
        this.element.submit = item.find(".jb-application-change-status-submit");

        this.element.button.on( "click", jQuery.proxy( this.button_click, this ) );
        this.element.dropdown.on( "click", jQuery.proxy( this.dropdown_change, this ) );
        this.element.submit.on( "click", jQuery.proxy( this.submit_click, this ) );
    };

    WPJB.Manage.Apps.Item.StatusChange.prototype.button_click = function(e) {
        if(typeof e != "undefined") {
            e.preventDefault();
        }

        this.element.slider.slideToggle("fast");
        this.dropdown_change();
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

        console.log('clicked');

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
//        console.log(response)
//        this.element.item.addClass("jb-application-status-"+response.status.key);
//        this.element.slider.slideToggle("fast");
        this.element.slider.slideUp("fast");
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