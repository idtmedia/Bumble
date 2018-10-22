<?php echo do_action('dashboard_panel_html'); ?>
 <div class="content-wrapper">
<div class="alsp-content">
	<?php alsp_renderMessages(); ?>

	

	<div class="alsp-dashboard-tabs-content">
		
		<div class="clearfix"></div>
		<div class="tab-content">
			<div class="tab-pane active">
                <?php
                $user = wp_get_current_user();
                $role = ( array ) $user->roles;
                if ($role[0]=='contributor'&&($_REQUEST['alsp_action']=='')){
                    $url = get_permalink(217).'?alsp_action=my_bids';
//                    if ( wp_redirect( $url ) ) {
//                        exit;
//                    }
                    ?>
                <script>window.location.href = '<?php echo $url; ?>'</script>
                <?php
                    exit;
                }
                ?>
				<?php alsp_frontendRender($frontend_controller->subtemplate, array('frontend_controller' => $frontend_controller)); ?>
			</div>
		</div>
	</div>
</div>
</div>
