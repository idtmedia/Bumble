<?php global $ALSP_ADIMN_SETTINGS; ?>
<?php if ($ALSP_ADIMN_SETTINGS['alsp_share_buttons']['enabled']): ?>
<div class="alsp-share-buttons">
	<script>
		(function($) {
			"use strict";
	
			$(function() {
				$('.alsp-share-buttons').addClass('alsp-ajax-loading');
				$.ajax({
					type: "POST",
					url: alsp_js_objects.ajaxurl,
					data: {'action': 'alsp_get_sharing_buttons', 'post_id': <?php echo $post_id; ?>},
					dataType: 'html',
					success: function(response_from_the_action_function){
						if (response_from_the_action_function != 0)
							$('.alsp-share-buttons').html(response_from_the_action_function);
					},
					complete: function() {
						$('.alsp-share-buttons').removeClass('alsp-ajax-loading').css('height', 'auto');
					}
				});
			});
		})(jQuery);
	</script>
</div>
<?php endif; ?>