<?php

/* template name: Contractors */

//$layout = $pacz_settings['archive-layout'];
//$columns = $pacz_settings['archive-columns'];
//$loop_style = $pacz_settings['archive-loop-style'];


//if(empty($layout)) {
//	$layout = 'left';
//}
//$blog_style = '';
//$column = '';
global $ALSP_ADIMN_SETTINGS;
$frontend_controller = new alsp_directory_controller();

$frontend_controller->init();
get_header();
$hash = $frontend_controller->hash;
?>

    <div id="theme-page">
        <div class="pacz-main-wrapper-holder">
            <div class="theme-page-wrapper pacz-main-wrapper <?php echo esc_attr($layout); ?>-layout pacz-grid vc_row-fluid">
                <div class="inner-page-wrapper">
                    <div class="theme-content" itemprop="mainContentOfPage">
                        <div class="vc-row-content vc_row wpb_row vc_row-fluid"
                             style="padding-top:0px;padding-bottom:0px; margin-top:0px; margin-bottom:100px; top:0px; bottom:0px; z-index:; margin-left:px; margin-right:px; box-shadow:;  overflow:; position:relative;">
                            <div class="wpb_column vc_column_container vc_col-sm-12">
                                <div class="vc_column-inner ">
                                    <div class="wpb_wrapper">
                                        <div class="listings listing-archive alsp-content">
                                           <!-- <div class="main-search-bar">
                                                <form action=""
                                                      class="search-form-style3" method="GET">
                                                    <input type="hidden" name="action" value="search">
                                                    <div class="alsp-search-overlay alsp-container-fluid">
                                                        <div class="search-wrap row clearfix"
                                                             style="margin-left:-10px; margin-right:-10px;">
                                                            <div class="keyword-search search-element-col pull-left"
                                                                 style="width:25%; padding:0 10px;"><input type="text"
                                                                   name="what_search"
                                                                   class="form-control"
                                                                   size="38"
                                                                   placeholder="Enter keywords"
                                                                   value="<?php /*echo $_REQUEST['what_search']; */?>">
                                                            </div>

                                                            <div class="search-button search-element-col pull-right"
                                                                 style="width:25%; padding:0 10px; margin-top:15px;">
                                                                <input type="submit" name="submit"
                                                                       class="cz-submit-btn btn btn-primary"
                                                                       value="Search"></div>
                                                            <div class="clear_float"></div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>-->


                                            <div class="alsp-content listing-parent pacz-loop-main-wrapper pacz-loop-main-wrapper2"
                                                 style="margin:0 -15px;"
                                                 id="alsp-controller-<?php echo $hash; ?>"
                                                 data-controller-hash="<?php echo $hash; ?>">
                                                <?php $per_page = 30; ?>
                                                <script>
                                                    alsp_controller_args_array['<?php echo $hash; ?>'] = {
                                                        "controller": "contractor_controller",
                                                        "base_url": "<?php echo get_site_url(); ?>/contractors",
                                                        "perpage": "<?php echo $per_page; ?>",
                                                        "paged": 1,
                                                        "listings_view_grid_columns": 4,
                                                        "logo_animation_effect": 6
                                                    };
                                                </script>

                                                <div class="alsp-container-fluid alsp-listings-block alsp-listings-grid alsp-listings-grid-4 masonry">


                                                    <div class="alsp-listings-block-content no-carousel  isotop-enabled pacz-theme-loop  clearfix isotope"
                                                         style="margin-left: -15px; margin-right: -15px; position: relative; "
                                                         data-style="masonry"
                                                    data-uniqid="<?php echo $hash; ?>">
                                                        <?php
                                                        $args = array( 'role' => 'Contributor', 'number' => $per_page );
                                                         if($_REQUEST['action']=='search'){
                                                             $args = array(
                                                                 'role' => 'Contributor',
                                                                 'search'         => "{$_REQUEST['what_search']}",
                                                                 'number' => $per_page
                                                             );
                                                         }
                                                        $contractor_query = new WP_User_Query( $args );
                                                         // User Loop
                                                         if ( ! empty( $contractor_query->get_results() ) ):
                                                             foreach ( $contractor_query->get_results() as $contractor ):
                                                                 $contractorID = $contractor->ID;
                                                                 $contractor_img_url = get_the_author_meta('pacz_author_avatar_url', $contractorID, true);
                                                                 $contractor_name = get_the_author_meta('display_name', $contractorID);
                                                                 $contractor_address =      get_the_author_meta('address', $contractorID, true)
                                                                                            .', '.get_the_author_meta('city', $contractorID, true)
                                                                                            .', '.get_the_author_meta('state', $contractorID, true)
                                                                                            .', '.get_the_author_meta('postalcode', $contractorID, true)
                                                                                            .', '.get_the_author_meta('country', $contractorID, true);
                                                                 ?>

                                                                 <article
                                                                          class="row alsp-listing  pacz-isotop-item isotop-item masonry-<?php echo $hash; ?> responsive-2col listing-post-style-10  clearfix isotope-item"
                                                                          style="padding-left: 15px; padding-right: 15px; margin-bottom: 30px; ">
                                                                     <div class="listing-wrapper clearfix">

                                                                         <figure class="alsp-listing-logo alsp-listings-own-page">
                                                                             <a href="<?php echo get_site_url().'/author/'.$contractor->user_login; ?>">
                                                                                 <?php if (!empty($contractor_img_url)) {
                                                                                 $params = array('width' => 300, 'height' => 370, 'crop' => false);
                                                                                 ?>
                                                                             <img
                                                                             alt="<?php echo $contractor_name; ?>"
                                                                             src="<?php echo $contractor_img_url //bfi_thumb("$contractor_img_url", $params); ?>"
                                                                             width="370" height="260">

                                                                             <?php
                                                                                 } else {
                                                                                 $avatar_url = pacz_get_avatar_url(get_the_author_meta('user_email', $contractorID), $size = '300'); ?>
                                                                                     <img
                                                                                             alt="<?php echo $contractor_name; ?>"
                                                                                             src="<?php echo $avatar_url; ?>"
                                                                                             width="370" height="260">
                                                                                 <?php
                                                                                 } ?>
                                                                                </a></figure>
                                                                         <div class="clearfix alsp-listing-text-content-wrap">
                                                                             <header class="alsp-listing-header"><h2><a
                                                                                             href="<?php echo get_site_url().'/author/'.$contractor->user_login; ?>"
                                                                                             title="<?php echo $contractor_name; ?>"><?php echo $contractor_name; ?>

                                                                                     </a>
                                                                                     <!--<span
                                                                                             class="author-unverified pacz-icon-check-circle"></span>-->
                                                                                     <?php
                                                                                     if ( gearside_is_user_online($contractorID) ){
                                                                                         echo '<span class="author-active"></span>';
                                                                                     } else {
                                                                                         echo '<span class="author-in-active"></span>';
                                                                                     }
                                                                                     ?>
                                                                                 </h2></header>
                                                                             <p class="listing-location"><i
                                                                                         class="pacz-fic3-pin-1"></i><span
                                                                                         class="alsp-location" itemprop="address"
                                                                                         itemscope=""
                                                                                         itemtype="http://schema.org/PostalAddress"><span
                                                                                             class="alsp-show-on-map"
                                                                                             data-location-id=""><span
                                                                                                 itemprop="streetAddress"><?php echo $contractor_address; ?></span></span>
                                                                             </p>
                                                                         </div>
                                                                     </div>
                                                                 </article>
                                                        <?php
                                                             endforeach;
                                                         else:
                                                             echo 'No contractors found.';
                                                         endif;
                                                        ?>
                                                    </div>
                                                    <?php if(count($contractor_query->get_results())>$per_page): ?>
                                                    <button class="btn btn-primary btn-lg btn-block alsp-show-more-button pacz-new-btn-4"
                                                            data-controller-hash="<?php echo $hash; ?>">Load More
                                                    </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearboth"></div>
                </div>
            </div>
            <div class="clearboth"></div>
        </div>
    </div>

<?php get_footer(); ?>