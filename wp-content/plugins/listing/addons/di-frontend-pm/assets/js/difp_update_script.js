jQuery( document ).ready( function() {
					
	function difp_update( custom_str, custom_int ){
		jQuery('#submit').hide();
		jQuery('.difp-ajax-img').show();
		var data = { 
			action: 'difp_update_ajax',
			custom_str : custom_str,
			custom_int : custom_int
			};
		jQuery.post( ajaxurl, data, function (response) {
			if( response['message'].length ) {
				jQuery('#difp-ajax-response').append(response['message'] + '<br />');
			}
			
			if( response['update'] == 'completed' ) {
				//jQuery('#difp-ajax-response').html('Update completed.');
				jQuery('.difp-ajax-img').hide();
				jQuery('#difp-update-warning').hide();
				jQuery('#difp-ajax-response').html(response['message']);
				//document.location.href = 'index.php'; // Redirect to the dashboard
			} else {
				difp_update( response['custom_str'], response['custom_int'] );
			}
		}, 'json')
		.fail(function() {
			jQuery('#difp-ajax-response').html('Refresh this page and try again.');
			jQuery('.difp-ajax-img').hide();
			jQuery('#difp-update-warning').hide();
		})
		.complete(function() {
			//jQuery('.difp-ajax-img').hide();
		});
	}
	// Trigger upgrades on page load
	difp_update( '', 0 );
});

