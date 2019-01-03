<?php 


$pacz_settings = $GLOBALS['pacz_settings'];
$template = '';
if(global_get_post_id()) {
	$template = get_post_meta( global_get_post_id(), '_template', true );

}
$footer_social_location = $pacz_settings['footer-social-location'];
$back_to_top = $pacz_settings['back-to-top'];
$footer_form_style = $pacz_settings['footer_form_style'];
$footer_top_logo = $pacz_settings['footer_top_logo']['url'];
$top_footer = $pacz_settings['top-footer'];
$back_to_top_style = $pacz_settings['back_to_top_style'];
$footer_sell_btn = (isset($pacz_settings['footer_sell_btn']))? $pacz_settings['footer_sell_btn']: '';
$sell_btn_text = (isset($pacz_settings['sell_btn_text']))? $pacz_settings['sell_btn_text']: '';
if($template != 'no-footer' && $template != 'no-header-footer' && $template != 'no-header-title-footer' && $template !='no-sub-footer-title' && $template !='no-title-footer-sub-footer') :

if($pacz_settings['footer'] == true && $template != 'no-footer-only' && $template != 'no-footer-title' && $template != 'no-header-title-only-footer' && $template != 'no-title-footer') : ?>
<section id="pacz-footer">
<?php if($top_footer == 1){?>
<?php if($footer_form_style == 1){?>
<div class="footer-top footer-subs-style<?php echo esc_attr($footer_form_style); ?>">
	
	<div class="pacz-grid">
		<div class="row clearfix">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<?php do_action('topfooter_subscribe'); ?>
			</div>
		</div>
	</div>
</div>
<?php }else if($footer_form_style == 2){ ?>
<div class="footer-top footer-subs-style<?php echo esc_attr($footer_form_style); ?> pacz-grid">
	
	<div class="pacz-grid">
		<div class="clearfix">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<?php do_action('topfooter_subscribe'); ?>
			</div>
		</div>
	</div>
</div>
<?php }else if($footer_form_style == 3){ 
	if($footer_social_location == 1 || $footer_social_location == 3){
?>
<div class="footer-top footer-subs-style<?php echo esc_attr($footer_form_style); ?>">
	
	<div class="pacz-grid">
		<div class="row clearfix">
			<div class="footer-social-container col-md-6 col-sm-12 col-xs-12">
				<?php do_action('subfooter_social'); ?>
			</div>
			<div class="footer-subs-container col-md-6 col-sm-12 col-xs-12">
				<?php do_action('topfooter_subscribe'); ?>
			</div>
		</div>
	</div>
</div>
<?php }else{ ?>

<div class="footer-top footer-subs-style<?php echo esc_attr($footer_form_style); ?>">
	<div class="pacz-grid">
		<div class="row clearfix">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<?php do_action('topfooter_subscribe'); ?>
			</div>
		</div>
	</div>
</div>
	
	
<?php } }else if($footer_form_style == 4){ ?>
<div class="footer-top footer-subs-style<?php echo esc_attr($footer_form_style); ?>">
	
	<div class="pacz-grid">
		<div class="clearfix">
			<?php if(isset($footer_top_logo) && (!empty($footer_top_logo))){ ?>
			<div class="col-md-6 col-sm-4 col-xs-12">
				<a class="footer-logo-top" href="<?php echo esc_url(home_url( '/' )); ?>" title="<?php echo get_bloginfo( 'name' ); ?>">
					<img src="<?php echo esc_url($footer_top_logo); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" />
				</a>
			</div>
			<div class="col-md-6 col-sm-8 col-xs-12">
				<?php do_action('topfooter_subscribe'); ?>
			</div>
			<?php }else{ ?>
					<div class="col-md-12 col-sm-12 col-xs-12">
				<?php do_action('topfooter_subscribe'); ?>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php } }?>
<div class="footer-wrapper pacz-grid">
<div class="pacz-padding-wrapper">
<?php

$footer_column = $pacz_settings['footer-layout'];

if(is_numeric($footer_column)):
	switch ( $footer_column ):
		case 1:
		$class = '';
			break;
		case 2:
			$class = 'pacz-col-1-2';
			break;
		case 3:
			$class = 'pacz-col-1-3';
			break;
		case 4:
			$class = 'pacz-col-1-4';
			break;
		case 5:
			$class = 'pacz-col-1-5';
			break;
		case 6:
			$class = 'pacz-col-1-6';
			break;		
	endswitch;
	for( $i=1; $i<=$footer_column; $i++ ):
?>
<?php if($i == $footer_column): ?>
<div class="<?php echo esc_attr($class); ?>"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
<?php else:?>
			<div class="<?php echo esc_attr($class); ?>"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
<?php endif;		
endfor; 

else : 

switch($footer_column):
		case 'third_sub_third':
?>
		<div class="pacz-col-1-3"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
		<div class="pacz-col-2-3">
			<div class="pacz-col-1-3"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
			<div class="pacz-col-1-3"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
			<div class="pacz-col-1-3"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
		</div>
<?php
			break;
		case 'sub_third_third':
?>
		<div class="pacz-col-2-3">
			<div class="pacz-col-1-3"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
			<div class="pacz-col-1-3"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
			<div class="pacz-col-1-3"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
		</div>
		<div class="pacz-col-1-3"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
<?php
			break;
		case 'third_sub_fourth':
?>
		<div class="pacz-col-1-3"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
		<div class="pacz-col-2-3 last">
			<div class="pacz-col-1-4"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
			<div class="pacz-col-1-4"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
			<div class="pacz-col-1-4"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
			<div class="pacz-col-1-4"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
		</div>
<?php
			break;
		case 'sub_fourth_third':
?>
		<div class="pacz-col-2-3">
			<div class="pacz-col-1-4"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
			<div class="pacz-col-1-4"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
			<div class="pacz-col-1-4"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
			<div class="pacz-col-1-4"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
		</div>
		<div class="pacz-col-1-3"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
<?php
			break;
		case 'half_sub_half':
?>
		<div class="pacz-col-1-2"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
		<div class="pacz-col-1-2">
			<div class="ex-padding-right pacz-col-1-2"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
			<div class="ex-padding-left pacz-col-1-2"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
		</div>
<?php
			break;
		case 'half_sub_third':
?>
		<div class="pacz-col-1-2"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
		<div class="pacz-col-1-2">
			<div class="pacz-col-1-3"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
			<div class="pacz-col-1-3"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
			<div class="pacz-col-1-3"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
		</div>
<?php
			break;
		case 'sub_half_half':
?>
		<div class="pacz-col-1-2">
			<div class="pacz-col-1-2"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
			<div class="pacz-col-1-2"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
		</div>
		<div class="pacz-col-1-2"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
<?php
			break;
		case 'sub_third_half':
?>
		<div class="pacz-col-1-2">
			<div class="pacz-col-1-3"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
			<div class="pacz-col-1-3"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
			<div class="pacz-col-1-3"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
		</div>
		<div class="pacz-col-1-2"><?php pacz_sidebar_generator( 'get_footer_sidebar'); ?></div>
<?php
			break;
	endswitch;
endif;?> 
<div class="clearboth"></div>      
</div>
</div>
<?php if($back_to_top == 1 && $back_to_top_style == 4){ ?>
	<div class="pacz-grid goto-top-btn backtotop-style2 position-style2">
		<a href="#" class="pacz-go-top"><?php echo esc_html__('back to top', 'classiadspro'); ?><i class="pacz-icon-long-arrow-up"></i></a>
	</div>
	
<?php } ?>
<?php if($footer_sell_btn == 1){ 
	if(class_exists('alsp_plugin') && get_option('alsp_fsubmit_button')){
		$sell_url = alsp_submitUrl();
	}else{
		$sell_url = '';
	}
?>
	<div class="footer-sell-btn pacz-grid">
		<a href="<?php echo esc_url($sell_url); ?>" class="pacz-footer-sell-btn"><?php echo esc_html($sell_btn_text); ?></a>
	</div>
<?php } ?>
<div class="clearboth"></div>
<?php endif;?>
<?php global $pacz_settings; ?>
<?php if ( $pacz_settings['sub-footer'] == true && $template != 'no-sub-footer' && $template != 'no-title-sub-footer') { ?>
<div id="sub-footer">
	<div class="pacz-grid">
		<div class="item-holder clearfix">
		<?php 
			$allowed_tags = array(
				'strong' => '',
				'li' => '',
				'span' => '',
				'a' => array(
				   'href' => array(),
				   'title' =>''
				)
			);
		?>
    	<span class="pacz-footer-copyright">
			<div class="footer-btoom_1">
				<h3><?php _e('Follow us','classiadspro'); ?></h3>
				<?php  do_action('subfooter_social');?>
			</div>			
				<?php echo $pacz_settings['footer-copyright']; ?>
			
		</span>
<div class="hide">
    	<?php do_action('subfooter_logos'); ?>
		<?php if($footer_social_location == 2 || $footer_social_location == 3){ do_action('subfooter_social'); }?>


</div>
	</div>
	</div>
	<div class="clearboth"></div>
</div>
<?php } ?>

</section>




<?php endif; ?>

</div><!-- End boxed layout -->
<?php if($back_to_top == 1){ ?>
		<?php if($back_to_top_style == 1): ?>

	<div class="pacz-grid goto-top-btn">
		<a href="#" class="pacz-go-top"><i class="pacz-icon-angle-up"></i></a>
	</div>
	<?php elseif($back_to_top_style == 2): ?>
	<div class="pacz-grid goto-top-btn backtotop-style2">
		<a href="#" class="pacz-go-top"><?php echo esc_html__('back to top', 'classiadspro'); ?><i class="pacz-icon-long-arrow-up"></i></a>
	</div>
	
<?php endif; ?>


<?php } ?>
</div><!-- End Theme main Wrapper -->


<?php 
if($pacz_settings['header-location'] == 'bottom') {
$header_padding_type = $pacz_settings['sticky-header'] ? 'sticky-header' : 'none-sticky-header'; ?>
<div class="bottom-header-padding <?php echo esc_attr($header_padding_type) ?>"></div>
<?php 
}
?>


<?php if($back_to_top == 1 && $back_to_top_style == 3){ ?>
		<div class="goto-top-btn">
		<a href="#" class="pacz-go-top"><i class="pacz-icon-angle-up"></i></a>
	</div>
	
<?php } ?>

<?php wp_footer(); ?>
<?php if(is_front_page()): ?>
<script>
    // Note: This example requires that you consent to location sharing when
    // prompted by your browser. If you see the error "The Geolocation service
    // failed.", it means you probably did not give permission for the browser to
    // locate you.
    function initMap() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var geocoder = new google.maps.Geocoder;
                geocoder.geocode({'location': pos}, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            var city = [];
                            for (var i=0; i<results[0].address_components.length; i++)
                            {
                                if (results[0].address_components[i].types[0] == "locality") {
                                    //this is the object you are looking for City
                                    city = results[0].address_components[i];
                                }
                                if (results[0].address_components[i].types[0] == "administrative_area_level_1") {
                                    //this is the object you are looking for State
                                    region = results[0].address_components[i];
                                }
                                if (results[0].address_components[i].types[0] == "country") {
                                    //this is the object you are looking for
                                    country = results[0].address_components[i];
                                }
                            }
                            if (!city.long_name){
                                city.long_name = 'Dollard-Des Ormeaux';
                                city.short_name = 'Dollard-Des Ormeaux';
                            }
                            jQuery(document).ready(function(){
                                jQuery('#current-location').html('<?php echo get_current_city_state(); ?>');
                                jQuery('#contractors-amount').html('<?php echo get_amount_matched_location(); ?>');
                                var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>/';
                                var data = {
                                 'action': 'creativeosc_get_city_jobs',
                                 'cvf_action': 'get_city_jobs',
                                 'city_long': city.long_name,
                                 'city_short': city.short_name
                                 };
                                 jQuery.ajax({
                                     type:"POST",
                                     url: ajaxurl,
                                     data: data,
                                     success:function(result){
                                         if( result !="" && result!="no result" ){
                                             jQuery('#city_projects').html(result);
                                         }
                                     },
                                     error: function(errorThrown){
                                         console.log(errorThrown);
                                     }
                                 });
                            });
                        } else {
                            console.log('No results found');
                        }
                    } else {
                        console.log('Geocoder failed due to: ' + status);
                    }

                });

            }, function() {
            });
        } else {
            // Browser doesn't support Geolocation
            console.log('Browser does not support GEO Location')
        }
    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0Pq-kEkLm-xs_gcOPjLl6XBj6BZCKs-E&callback=initMap" />

<script>
    jQuery(document).ready(function(){
        jQuery('#current-location').html('<?php echo get_current_city_state(); ?>');
        jQuery('#contractors-amount').html('<?php echo get_amount_matched_location(); ?>');
    });
</script>
<?php endif; ?>
</body>
</html>
