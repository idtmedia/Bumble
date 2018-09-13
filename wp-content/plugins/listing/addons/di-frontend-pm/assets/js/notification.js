jQuery(document).ready(function(){
		var data = {
					action: 'difp_notification_ajax',
					token: difp_notification_script.nonce
					};
        var difp_ajax_call = function(){
		jQuery.post(difp_notification_script.ajaxurl, data, function(results) {
			jQuery('#difp-notification-bar').html(results);
			if ( jQuery.trim(results).length < 1 )
			{ jQuery('#difp-notification-bar').hide(); }
			else 
			{ jQuery('#difp-notification-bar').show(); }
		});
        }
        setInterval(difp_ajax_call, parseInt(difp_notification_script.interval, 10) );
      });