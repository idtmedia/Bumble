var difp_delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();
jQuery( document ).on( "keyup", "#difp-message-top", function() {
	difp_delay(function(){
			jQuery('#difp-result').hide();
			jQuery('#difp-message-top').addClass('difp-loading-gif');
				var display_name=jQuery('#difp-message-top').val();
				var data = {
						action: 'difp_autosuggestion_ajax',
						searchBy: display_name,
						token: difp_script.nonce
						};
								
	jQuery.post(difp_script.ajaxurl, data, function(results) {
		jQuery('#difp-message-top').removeClass('difp-loading-gif');
		jQuery('#difp-result').html(results);
		if ( results ){
			jQuery('#difp-result').show();
		}
		
		});
	}, 1000 );
});

function difp_fill_autosuggestion(login, display) {
	
	jQuery('#difp-message-to').val( login );
	jQuery('#difp-message-top').val( display );
	jQuery('#difp-result').hide();
}
