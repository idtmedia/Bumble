<?php
if(!is_contractor()):
    _e('You dont have permission for accessing this section');
else:
    $user_id = get_current_user_id();
    if($_REQUEST['job_status']!=""){
        $applications = get_posts(array(
            'numberposts' => -1,
            'post_type' => 'bidding',
            'meta_query' => array(
                'relation'		=> 'AND',
                array(
                    'key' => 'contractor',
                    'value' => $user_id,
                    'compare' => '=',
                ),
                array(
                    'key'	  	=> 'bid_status',
                    'value'	  	=> $_REQUEST['job_status'],
                    'compare' 	=> '=',
                ),
            ),
        ));
    }else {
        $applications = get_posts(array(
            'posts_per_page' => -1,
            'post_type' => 'bidding',
            'meta_query' => array(
                array(
                    'key' => 'contractor',
                    'value' => $user_id,
                    'compare' => '=',
                ),
            ),
        ));
    }
    $job_statuses = array('New','Rejected','Accepted');
?>

    <div class="jb-top-search">
    <form action="" method="GET">
        <input type="hidden" name="alsp_action" value="my_bids" />
        <div class="jb-search jb-search-group-visible">
            <!--<div class="jb-input jb-input-type-half jb-input-type-half-left">
                <label><?php /*_e('Filter by job'); */?></label>
                <select name="job_id">
                    <option value="">All Jobs</option>
                    <?php /*foreach ($posts_array as $job): */?>
                        <option value="<?php /*echo $job[0]; */?>" <?php /*if($_REQUEST['job_id']==$job[0]) echo 'selected'; */?>><?php /*echo $job[1]; */?></option>
                    <?php /*endforeach; */?>
                </select>
            </div>-->
            <div class="jb-input">
                <label><?php _e('Filter by status'); ?></label>
                <select name="job_status">
                    <option value=""><?php _e('All Statuses'); ?></option>
                    <?php foreach($job_statuses as $status): ?>
                        <option value="<?php echo $status; ?>" <?php if($status==$_REQUEST["job_status"]) echo 'selected'; ?>><?php echo $status; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="jb-list-search">
                <input type="submit" value="<?php _e('Apply filter'); ?>">
            </div>
        </div>
    </form>
    </div>
    <div class="jb-grid jb-grid-compact">
        <?php if (count($applications) > 0): ?>
            <?php foreach ($applications as $post) : setup_postdata($post); ?>
                <?php
                $contractor = get_field('contractor', $post->ID);
                $job = get_field('job', $post->ID);
                $status = (get_field('bid_status', $post->ID) != '' ) ? get_field('bid_status', $post->ID) : 'New';
                ?>
                <div class="jb-grid-row jb-manage-item jb-manage-application jb-application-status-<?php echo strtolower($status); ?>"
                     data-id="<?php echo $post->ID; ?>" data-contractor="<?php echo $contractor['display_name']; ?>">
                    <div class="jb-grid-col jb-col-1 jb-manage-header-img" style="width:150px">
                        <?php $media = get_the_post_thumbnail($job->ID, 'thumbnail'); ?>
                        <a href="<?php echo get_permalink($job); ?>">
                            <?php echo get_the_post_thumbnail($job->ID, 'thumbnail'); ?>
                        </a>
                    </div>
                    <div class="jb-grid-col jb-col-90" style="width:calc( 100% - 150px )">
                        <div class="jb-manage-header">
                            <h3 class="jb-manage-header-left jb-line-major jb-manage-title">
                                <a href="<?php echo get_permalink($job); ?>"
                                   class="jb-no-text-decoration"><?php echo get_the_title($job); ?></a>
                            </h3>
                            <h4>
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
<?php
endif;