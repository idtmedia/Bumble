    var difp_Index = 1;
    function difp_get_by_id(id) { return document.getElementById(id); }
    function difp_create_element(name) { return document.createElement(name); }
    function difp_remove_element(id) {
        var e = difp_get_by_id(id);
        e.parentNode.removeChild(e);
    }
    function difp_add_new_file_field() {
        var maximum = difp_attachment_script.maximum;
        var num_img = jQuery('input[name="difp_upload[]"]').size();
        if((maximum!=0 && num_img<maximum) || maximum==0) {
            var id = 'p-' + difp_Index++;

            var i = difp_create_element('input');
            i.setAttribute('type', 'file');
            i.setAttribute('name', 'difp_upload[]');

            var a = difp_create_element('a');
			a.setAttribute('class', 'difp-attachment-field');
            a.setAttribute('href', '#');
            a.setAttribute('divid', id);
            a.onclick = function() { difp_remove_element(this.getAttribute('divid')); return false; }
            a.appendChild(document.createTextNode(difp_attachment_script.remove));

            var d = difp_create_element('div');
            d.setAttribute('id', id);
            d.setAttribute('style','padding: 4px 0;')

            d.appendChild(i);
            d.appendChild(a);

            difp_get_by_id('difp_upload').appendChild(d);

        } else {
            alert( difp_attachment_script.max_text );
        }
    }
    // Listener: automatically add new file field when the visible ones are full.
	// Listener: automatically hide file field when maximum field reached.
	function difp_listener() {
		if ( jQuery('#difp_upload').length ) {
			difp_add_file_field();
			difp_hide_file_field();
		}
	}
		
    setInterval("difp_listener()", 1000);
    /**
     * Timed: if there are no empty file fields, add new file field.
     */
    function difp_add_file_field() {
        var count = 0;
        jQuery('input[name="difp_upload[]"]').each(function(index) {
            if ( jQuery(this).val() == '' ) {
                count++;
            }
        });
        var maximum = difp_attachment_script.maximum;
        var num_img = jQuery('input[name="difp_upload[]"]').size();
        if (count == 0 && (maximum==0 || (maximum!=0 && num_img<maximum))) {
            difp_add_new_file_field();
        }
    }
	function difp_hide_file_field() {
        var maximum = difp_attachment_script.maximum;
        var num_img = jQuery('input[name="difp_upload[]"]').size();
        if (maximum!=0 && num_img>maximum-1) {
			//alert('maximum');
            jQuery('#difp-attachment-field-add').hide();
			jQuery('#difp-attachment-note').html( difp_attachment_script.max_text );
        } else {
			jQuery('#difp-attachment-field-add').show();
			jQuery('#difp-attachment-note').html('');
		}
    }