jQuery(document).ready(function(){
		
		jQuery( '.difp-form' ).on( "click", ".difp-button", function(e) {
			e.preventDefault();
			
			jQuery('.difp-button').prop('disabled', true);
			jQuery('.difp-ajax-response').html('');
			
			jQuery('.difp-ajax-img').show();
			
		var data = jQuery(this.form).serialize().replace(/&token=[^&;]*/,'&token=' + difp_shortcode_newmessage.token) + '&difp_action=shortcode-newmessage';

		jQuery.post( difp_shortcode_newmessage.ajaxurl, data, function(response) {
			jQuery('.difp-ajax-response').html(response['info']);
			if( response['difp_return'] == 'success' ){
				jQuery('.ALSP-form').hide();
			}
			
		}, 'json')
			.fail(function() {
					 jQuery('.difp-ajax-response').html('Refresh this page and try again.');
			})
			.complete(function() {
					 jQuery('.difp-ajax-img').hide();
					 jQuery('.difp-button').prop('disabled', false);
			});;
      });
});

