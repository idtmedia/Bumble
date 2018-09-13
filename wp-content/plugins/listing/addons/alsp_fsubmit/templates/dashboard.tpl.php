<?php echo do_action('dashboard_panel_html'); ?>
 <div class="content-wrapper">
<div class="alsp-content">
	<?php alsp_renderMessages(); ?>

	

	<div class="alsp-dashboard-tabs-content">
		
		<div class="clearfix"></div>
		<div class="tab-content">
			<div class="tab-pane active">
				<?php alsp_frontendRender($frontend_controller->subtemplate, array('frontend_controller' => $frontend_controller)); ?>
			</div>
		</div>
	</div>
</div>
</div>
