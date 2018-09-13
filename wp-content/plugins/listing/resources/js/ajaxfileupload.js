(function($) {
	"use strict";
	
	window.alsp_ajaxImageFileUploadToGallery = function(file_input, callback, crop, process_url, error_file_choose) {
		if ($("#"+file_input).val() != '') {
			alsp_ajax_loader_show();
			
			if (crop)
				process_url = process_url + '&crop=1';
	
			$.alsp_ajaxFileUpload( {
				url: process_url,
				secureuri: false,
				fileElementId: file_input,
				dataType: 'json',
				success: function (data, status) {
					if(typeof(data.error_msg) != 'undefined') {
						if(data.error_msg != '')
							alert(data.error_msg);
						else
							callback(data);
					}
				},
				error: function (data, status, e) {
					alert(e);
				},
				complete: function() {
					alsp_ajax_loader_hide();
				}
			})
			return false;
		} else {
			alert(error_file_choose);
		}
	}


	$.extend({
	    alsp_createUploadIframe: function(id, uri)
		{
				//create frame
	            var frameId = 'jUploadFrame' + id;
	            
	            if(window.ActiveXObject) {
	            	if ($.browser.msie && ($.browser.version=="9.0" || $.browser.version=="10.0")) {
	            		var io = document.createElement("iframe");
		                io.setAttribute("id", frameId);
		                io.setAttribute("name", frameId);
	            	} else {
	                	var io = document.createElement('<iframe id="' + frameId + '" name="' + frameId + '" />');
	            	}
	
	                if(typeof uri== 'boolean'){
	                    io.src = 'javascript:false';
	                }
	                else if(typeof uri== 'string'){
	                    io.src = uri;
	                }
	            }
	            else {
	                var io = document.createElement('iframe');
	                io.id = frameId;
	                io.name = frameId;
	            }
	            io.style.position = 'absolute';
	            io.style.top = '-1000px';
	            io.style.left = '-1000px';
	
	            document.body.appendChild(io);
	
	            return io			
	    },
	    alsp_createUploadForm: function(id, fileElementId, serverPath, allowed_types)
		{
			//create form	
			var formId = 'jUploadForm' + id;
			var fileId = 'jUploadFile' + id;
			var form = jQuery('<form  action="" method="POST" name="' + formId + '" id="' + formId + '" enctype="multipart/form-data"></form>');	
			var oldElement = jQuery('#' + fileElementId);
			var newElement = jQuery(oldElement).clone();
			jQuery(oldElement).attr('id', fileId);
			jQuery(oldElement).before(newElement);
			jQuery(oldElement).appendTo(form);
			jQuery('<input type=hidden name="server_path" value="' + serverPath + '">').appendTo(form);
			jQuery('<input type=hidden name="allowed_types" value="' + allowed_types + '">').appendTo(form);
			//set attributes
			jQuery(form).css('position', 'absolute');
			jQuery(form).css('top', '-1200px');
			jQuery(form).css('left', '-1200px');
			jQuery(form).appendTo('body');		
			return form;
	    },
	
	    alsp_ajaxFileUpload: function(s) {
	        // TODO introduce global settings, allowing the client to modify them for all requests, not only timeout		
	        s = jQuery.extend({}, jQuery.ajaxSettings, s);
	        var id = new Date().getTime()        
			var form = jQuery.alsp_createUploadForm(id, s.fileElementId, s.serverPath, s.allowed_types);
			var io = jQuery.alsp_createUploadIframe(id, s.secureuri);
			var frameId = 'jUploadFrame' + id;
			var formId = 'jUploadForm' + id;		
	        // Watch for a new set of requests
	        if ( s.global && ! jQuery.active++ )
			{
				jQuery.event.trigger( "ajaxStart" );
			}            
	        var requestDone = false;
	        // Create the request object
	        var xml = {}   
	        if ( s.global )
	            jQuery.event.trigger("ajaxSend", [xml, s]);
	        // Wait for a response to come back
	        var uploadCallback = function(isTimeout)
			{			
				var io = document.getElementById(frameId);
	            try 
				{				
					if(io.contentWindow)
					{
						 xml.responseText = io.contentWindow.document.body?io.contentWindow.document.body.innerHTML:null;
	                	 xml.responseXML = io.contentWindow.document.XMLDocument?io.contentWindow.document.XMLDocument:io.contentWindow.document;
						 
					}else if(io.contentDocument)
					{
						 xml.responseText = io.contentDocument.document.body?io.contentDocument.document.body.innerHTML:null;
	                	xml.responseXML = io.contentDocument.document.XMLDocument?io.contentDocument.document.XMLDocument:io.contentDocument.document;
					}						
	            }catch(e)
				{
					jQuery.alsp_handleError(s, xml, null, e);
				}
	            if ( xml || isTimeout == "timeout") 
				{				
	                requestDone = true;
	                var status;
	                try {
	                    status = isTimeout != "timeout" ? "success" : "error";
	                    // Make sure that the request was successful or notmodified
	                    if ( status != "error" )
						{
	                        // process the data (runs the xml through httpData regardless of callback)
	                        var data = jQuery.alsp_uploadHttpData( xml, s.dataType );    
	                        // If a local callback was specified, fire it and pass it the data
	                        if ( s.success )
	                            s.success( data, status );
	    
	                        // Fire the global callback
	                        if( s.global )
	                            jQuery.event.trigger( "ajaxSuccess", [xml, s] );
	                    } else
	                        jQuery.alsp_handleError(s, xml, status);
	                } catch(e) 
					{
	                    status = "error";
	                    jQuery.alsp_handleError(s, xml, status, e);
	                }
	
	                // The request was completed
	                if( s.global )
	                    jQuery.event.trigger( "ajaxComplete", [xml, s] );
	
	                // Handle the global AJAX counter
	                if ( s.global && ! --jQuery.active )
	                    jQuery.event.trigger( "ajaxStop" );
	
	                // Process result
	                if ( s.complete )
	                    s.complete(xml, status);
	
	                jQuery(io).unbind()
	
	                setTimeout(function()
										{	try 
											{
												jQuery(io).remove();
												jQuery(form).remove();	
												
											} catch(e) 
											{
												jQuery.alsp_handleError(s, xml, null, e);
											}									
	
										}, 100)
	
	                xml = null
	
	            }
	        }
	        // Timeout checker
	        if ( s.timeout > 0 ) 
			{
	            setTimeout(function(){
	                // Check to see if the request is still happening
	                if( !requestDone ) uploadCallback( "timeout" );
	            }, s.timeout);
	        }
	        try 
			{
	           // var io = jQuery('#' + frameId);
				var form = jQuery('#' + formId);
				jQuery(form).attr('action', s.url);
				jQuery(form).attr('method', 'POST');
				jQuery(form).attr('target', frameId);
	            if(form.encoding)
				{
	                form.encoding = 'multipart/form-data';				
	            }
	            else
				{				
	                form.enctype = 'multipart/form-data';
	            }			
	            jQuery(form).submit();
	
	        } catch(e) 
			{			
	            jQuery.alsp_handleError(s, xml, null, e);
	        }
	        if(window.attachEvent){
	            document.getElementById(frameId).attachEvent('onload', uploadCallback);
	        }
	        else{
	            document.getElementById(frameId).addEventListener('load', uploadCallback, false);
	        } 		
	        return {abort: function () {}};	
	
	    },
	
	    alsp_uploadHttpData: function( r, type ) {
	        var data = !type;
	        data = type == "xml" || data ? r.responseXML : r.responseText;
	        // If the type is "script", eval it in global context
	        if ( type == "script" )
	            jQuery.globalEval( data );
	        // Get the JavaScript object, if JSON is used.
	        if ( type == "json" )
	            eval( "data = " + data );
	        // evaluate scripts within html
	        if ( type == "html" )
	            jQuery("<div>").html(data).evalScripts();
				//alert($('param', data).each(function(){alert($(this).attr('value'));}));
	        return data;
	    },
	    
	    alsp_handleError: function( s, xhr, status, e ) {
	        // If a local callback was specified, fire it
	        if ( s.error ) {
	            s.error.call( s.context || window, xhr, status, e );
	        }
	
	        // Fire the global callback
	        if ( s.global ) {
	            (s.context ? jQuery(s.context) : jQuery.event).trigger( "ajaxError", [xhr, s, e] );
	        }
	    }
	});
})(jQuery);
