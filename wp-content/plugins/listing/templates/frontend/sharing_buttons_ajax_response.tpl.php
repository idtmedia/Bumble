<?php global $ALSP_ADIMN_SETTINGS; ?>

<?php global $alsp_social_services; ?>
<script>
	(function($) {
		"use strict";
	
		$(function() {
			$('.alsp-share-button [data-toggle="alsp-tooltip"]').tooltip();
		});
	})(jQuery);
</script>
<?php foreach ($ALSP_ADIMN_SETTINGS['alsp_share_buttons']['enabled'] AS $button): ?>
<div class="alsp-share-button">
	<?php alsp_renderSharingButton($post_id, $button); ?>
</div>
<?php endforeach; ?>