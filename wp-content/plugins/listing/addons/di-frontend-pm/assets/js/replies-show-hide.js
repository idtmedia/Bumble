jQuery(document).ready(function(){
		jQuery(".difp-hide-if-js").hide();
		jQuery(".difp-message-title").click(function () {
			//open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
			jQuery(this).next('.difp-message-content').slideToggle(500);
		});
		jQuery(".difp-message-toggle-all").click(function () {
			//open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
			jQuery('.difp-message-content').slideToggle(500);
		});

});