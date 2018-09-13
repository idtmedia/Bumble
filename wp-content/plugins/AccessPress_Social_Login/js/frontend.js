function apsl_open_in_popup_window(event, url){
    event.preventDefault();
    window.open(url, 'fdadas', 'toolbars=0,width=800,height=600,left=100,top=50,scrollbars=1,resizable=1');
    // parent.close();
}

jQuery(document).ready(function($){

	$('.show-apsl-container').on('click', function(e){
        e.preventDefault();
        $('.apsl-container').slideToggle();
    });

    $('.apsl-link-account-button').click(function(){
        $('.apsl-buttons-wrapper').hide();
        $('.apsl-login-form').show();
        $('.apsl-registration-wrapper').addClass('apsl-login-registration-form');
    });

    $('.apsl-create-account-button').click(function(){
        $('.apsl-buttons-wrapper').hide();
        $('.apsl-registration-form').show();
        $('.apsl-registration-wrapper').addClass('apsl-login-registration-form');
    });

    $('.apsl-back-button').click(function(){
        $('.apsl-buttons-wrapper').show();
        $('.apsl-login-form').hide();
        $('.apsl-registration-form').hide();
        $('.apsl-registration-wrapper').removeClass('apsl-login-registration-form');
    });


    $(':input[name="apsl_complete_registration"]').prop('disabled', true);
    $('#apsl-username-input').on( 'blur', function(e) {
        var $wrapper = $( this ).parent('.apsl-registration-form-wrapper');
        if( ! $wrapper.get(0) ) {
            $wrapper = create_wrapper( this );
        }
        
        $( '.apsl-name-info', $wrapper ).empty();//hhide the message
        //show loading icon
        $( '.apsl-loading', $wrapper ).css( {display:'block'} );
        var user_name = $( this ).val();
        var ajaxurl = apsl_ajax_object.ajax_url;
        $.post( ajaxurl, {
            action: 'apsl_check_username',
            cookie: encodeURIComponent(document.cookie),
            user_name: user_name
            },
            function( resp ) {
                if( resp && resp.code != undefined && resp.code == 'success' ) {
                        show_message( $wrapper, resp.message, 0 );
                        $(':input[name="apsl_complete_registration"]').prop('disabled', false);
                } else {
                    show_message( $wrapper, resp.message, 1 );
                    $(':input[name="apsl_complete_registration"]').prop('disabled', true);
                }

            },
            'json'

        );
    });//end of onblur
    
    function show_message( $wrapper, msg, is_error ) {//hide ajax loader
        
        $( '.apsl-name-info', $wrapper ).removeClass('apsl-available apsl-error');
        
        $( '.apsl-loading', $wrapper ).css( {display:'none'} );
        
        $( '.apsl-name-info', $wrapper ).html( msg );
      
        if( is_error ) {
            $( '.apsl-name-info', $wrapper ).addClass( 'apsl-error' );
        } else {
            $( '.apsl-name-info', $wrapper ).addClass( 'apsl-available' );
        }
    }

    function create_wrapper( element ) {
        var $wrapper = $( element ).parent('.apsl-registration-form-wrapper');
        
        if( ! $wrapper.get(0) ) {
            
            $( element ).wrap( "<div class='apsl-registration-form-wrapper'></div>" );
            
            $wrapper = $( element ).parent('.apsl-registration-form-wrapper');
            $wrapper.append( "<span class='apsl-loading' style='display:none'></span>" );
            $wrapper.append( "<span class='apsl-name-info'></span>" );
        }
        
        return $wrapper;
    }
});