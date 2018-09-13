<div class="alsp-rating" <?php if ($meta_tags && $listing->avg_rating->ratings_count): ?>itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"<?php endif; ?>>
	<?php if ($meta_tags && $listing->avg_rating->ratings_count): ?>
	<meta itemprop="reviewCount" content="<?php echo get_comments_number(); ?>" />
	<meta itemprop="ratingValue" content="<?php echo $listing->avg_rating->avg_value; ?>" />
	<meta itemprop="ratingCount" content="<?php echo $listing->avg_rating->ratings_count; ?>" />
	<?php endif; ?>
	<?php if (!is_admin() || (defined('DOING_AJAX') && DOING_AJAX)): ?>
	<script>
		(function($) {
			"use strict";

			$(function() {
				<?php if ($active): ?>
				$("#rater-<?php echo $listing->post->ID; ?>-active").rater({postHref: '<?php echo admin_url('admin-ajax.php?action=alsp_save_rating&post_id='.$listing->post->ID.'&_wpnonce='.wp_create_nonce('save_rating')); ?>'});
				<?php endif; ?>

				if (!alsp_js_objects.is_rtl)
					var rplacement = 'right';
				else
					var rplacement = 'left';
				$('body').tooltip({
					placement: rplacement,
					selector: '[data-toggle="alsp-tooltip"]'
				});
			});
		})(jQuery);
	</script>
	<?php endif; ?>
	<div id="rater-<?php echo $listing->post->ID; ?><?php if ($active): ?>-active<?php endif; ?>" class="stat">
		<div class="statVal">
			<span>
				<?php // pacz modified ?>
				<!--<span class="ui-rater" data-toggle="alsp-tooltip" title="<?php //printf(__('Average: %s (%s)', 'ALSP'), $listing->avg_rating->avg_value, sprintf(_n('%d vote', '%d votes', $listing->avg_rating->ratings_count, 'ALSP'), $listing->avg_rating->ratings_count)); ?>">-->
				<span class="ui-rater" data-toggle="alsp-tooltip">
					<span class="ui-rater-starsOff" style="width:100px;">
						<span class="ui-rater-starsOn" style="width: <?php echo $listing->avg_rating->avg_value*20; ?>px"></span>
					</span>
					<?php if ($show_avg): ?>
					<span class="ui-rater-avgvalue">
						<span class="ui-rater-rating"><?php echo $listing->avg_rating->avg_value; ?></span>
					</span>
					<?php endif; ?>
				</span>
			</span>
		</div>
	</div>
</div>