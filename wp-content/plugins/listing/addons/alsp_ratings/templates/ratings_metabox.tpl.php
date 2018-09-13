<?php if (get_option('alsp_manage_ratings') || current_user_can('edit_others_posts')): ?>
<script>
	jQuery(document).ready(function($) {
		$("#flush_all").on('click', function() {
			if (confirm('<?php echo esc_js(__('Are you sure you want to flush all ratings of this listing?', 'ALSP')); ?>')) {
				alsp_ajax_loader_show();
				$.ajax({
					type: "POST",
					url: alsp_js_objects.ajaxurl,
					data: {'action': 'alsp_flush_ratings', 'post_id': <?php echo $listing->post->ID; ?>},
					success: function(){
						$(".ratings_counts").html('0');
						$(".flush_avarage").css({width: 0});
					},
					complete: function() {
						alsp_ajax_loader_hide();
					}
				});
			    
			}
		});
	});
</script>
<?php endif; ?>
<div class="alsp-content ratings_metabox">
	<div class="stat">
		<div class="admin_avg_value"><?php echo _e('Average', 'ALSP'); ?></div>
		<div class="statValMetabox">
			<span class="ui-rater">
				<span class="ui-rater-starsOff" style="width:100px;"><span class="ui-rater-starsOn flush_avarage" style="width: <?php echo $listing->avg_rating->avg_value*20?>px"></span></span> <span class="avg_value">&nbsp;&nbsp; - &nbsp;&nbsp;<span class="ratings_counts"><?php echo $listing->avg_rating->avg_value; ?></span> (<span class="ui-rater-rateCount ratings_counts"><?php echo $listing->avg_rating->ratings_count; ?></span>)</span>
			</span>
		</div>
		<div class="clear_float"></div>
	</div>
	<br />
	<?php foreach ($total_counts AS $rating=>$counts): ?>
	<div class="stat">
		<div class="admin_avg_value"><?php echo $rating; ?> <?php echo _n('Star ', 'Stars', $rating, 'ALSP'); ?></div>
		<div class="statVal">
			<span class="ui-rater">
				<span class="ui-rater-starsOff" style="width:100px;"><span class="ui-rater-starsOn" style="width: <?php echo $rating*20?>px"></span></span> <span class="avg_value">&nbsp;&nbsp; - &nbsp;&nbsp;<span class="ratings_counts"><?php echo $counts; ?></span></span>
			</span>
		</div>
	</div>
	<?php endforeach; ?>
	
	<?php if (get_option('alsp_manage_ratings') || current_user_can('edit_others_posts')): ?>
	<br />
	<input id="flush_all" type="button" class="btn btn-primary" onClick="" value="<?php esc_attr_e('Flush all ratings', 'ALSP'); ?>" />
	<?php endif; ?>
</div>