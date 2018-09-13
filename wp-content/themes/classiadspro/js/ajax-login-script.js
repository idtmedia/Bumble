jQuery(document).ready(function($) {

    

    // Perform AJAX login on form submit
    $('form#pacz-login').on('submit', function(e){
        $('form#pacz-login p.status').show().text(ajax_login_object.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('form#pacz-login #username').val(), 
                'password': $('form#pacz-login #password').val(), 
                'security': $('form#pacz-login #security').val() },
            success: function(data){
                $('form#pacz-login p.status').text(data.message);
                if (data.loggedin == true){
                    document.location.href = ajax_login_object.redirecturl;
                }
            }
        });
        e.preventDefault();
    });

});