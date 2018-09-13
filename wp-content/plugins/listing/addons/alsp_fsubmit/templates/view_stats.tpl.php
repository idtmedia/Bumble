<h3><?php echo sprintf(__('Clicks statistics of listing "%s"', 'ALSP'), $alsp_instance->current_listing->title()); ?></h3>

<h4><?php echo sprintf(__('Total clicks: %d', 'ALSP'), (get_post_meta($alsp_instance->current_listing->post->ID, '_total_clicks', true) ? get_post_meta($alsp_instance->current_listing->post->ID, '_total_clicks', true) : 0)); ?></h4>

<?php 
$months_names = array(
	1 => __('January', 'ALSP'),	
	2 => __('February', 'ALSP'),	
	3 => __('March', 'ALSP'),	
	4 => __('April', 'ALSP'),	
	5 => __('May', 'ALSP'),	
	6 => __('June', 'ALSP'),	
	7 => __('July', 'ALSP'),	
	8 => __('August', 'ALSP'),	
	9 => __('September', 'ALSP'),	
	10 => __('October', 'ALSP'),	
	11 => __('November', 'ALSP'),	
	12 => __('December', 'ALSP'),	
);
if ($clicks_data = get_post_meta($alsp_instance->current_listing->post->ID, '_clicks_data', true)) {
	foreach ($clicks_data AS $month_year=>$count) {
		$month_year = explode('-', $month_year);
		$data[$month_year[1]][$month_year[0]] = $count;
	}
	ksort($data);
}
?>

<?php if (isset($data)): ?>
<div>
	<?php foreach ($data AS $year=>$months_counts): ?>
	<h4><?php echo $year; ?></h4>

	<div>
		<canvas id="canvas-<?php echo esc_attr($year); ?>" style="height: 450px;"></canvas>
		<script>
		var chartData_<?php echo esc_attr($year); ?> = {
			labels : ["<?php echo implode('","', $months_names); ?>"],
			datasets : [
				{
					fillColor : "rgba(151,187,205,0.2)",
					strokeColor : "rgba(151,187,205,1)",
					<?php
					foreach ($months_names AS $month_num=>$name)
						if (!isset($months_counts[$month_num]))
							$months_counts[$month_num] = 0;
					ksort($months_counts);
					?>
					data : [<?php echo implode(',', $months_counts); ?>]
				}
			]
		};
	
		(function($) {
			"use strict";

			$(function() {
				var ctx_<?php echo esc_attr($year); ?> = document.getElementById("canvas-<?php echo esc_attr($year); ?>").getContext("2d");
				window.myLine_<?php echo esc_attr($year); ?> = new Chart(ctx_<?php echo esc_attr($year); ?>).Bar(chartData_<?php echo esc_attr($year); ?>, {
					responsive: true
				});
			});
		})(jQuery);
		</script>
	</div>
	<hr />
	<?php endforeach; ?>
</div>
<?php endif; ?>

<a href="<?php echo $frontend_controller->referer; ?>" class="btn btn-primary"><?php _e('Go back ', 'ALSP'); ?></a>