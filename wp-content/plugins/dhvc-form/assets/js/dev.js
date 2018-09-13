/*
 *DHVC Form Script 
 * @param jQuery
 */
!function( $ ) {
	"use strict"; // jshint ;_;
	
	$(document).ready(function () {
		
		$('[data-auto-open].dhvc-form-popup').each(function(){
			var $this = $(this),
				id = $this.attr('id'),
				open_delay = $this.data('open-delay'),
				auto_close = $this.data('auto-close'),
				close_delay = $this.data('close-delay'),
				one_time = $this.data('one-time'),
				open_timeout,
				close_timeout;
			clearTimeout(open_timeout);
			clearTimeout(close_timeout);
			open_timeout = setTimeout(function(){
				clearTimeout(close_timeout);	
				
				if(one_time){
					if(!$.cookie(id)){
						$('.dhvc-form-pop-overlay').show();
						$('body').addClass('dhvc-form-opening');
						$this.show();
						$.cookie(id,1,{ expires: 360 * 10 , path: "/" });
					}
				}else{
					$.cookie(id,0,{ expires: -1});
					$('.dhvc-form-pop-overlay').show();
					$this.show();
				}
			},open_delay);
			
			if(auto_close){
				close_timeout = setTimeout(function(){
					clearTimeout(open_timeout);
					$('.dhvc-form-pop-overlay').hide();
					$('body').addClass('dhvc-form-opening');
					$this.hide();
					
				},close_delay);
			}
			
		});

		$(document).on('click','[data-toggle="dhvcformpopup"],[rel="dhvcformpopup"]',function(e){
			e.stopPropagation();
			e.preventDefault();
			var href;
			var $this = $(this);
			var $target = $($this.attr('data-target') || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '')); // strip for ie7
			if ($this.is('a')) e.preventDefault();
			$('.dhvc-form-pop-overlay').show();
			$('body').addClass('dhvc-form-opening');
			$target.show();
			$target.off('click').on('click',function(e){
				 if (e.target !== e.currentTarget) return
				$('.dhvc-form-pop-overlay').hide();
				$('body').removeClass('dhvc-form-opening');
				$target.hide();
				
			});
		});
		
		$(document).on('click','.dhvc-form-popup-close',function(e){
			$('.dhvc-form-pop-overlay').hide();
			$('body').removeClass('dhvc-form-opening');
			$(this).closest('.dhvc-form-popup').hide();
		});
		
		
		$('.dhvc-form-slider-control').each(function(){
			var $this = $(this);
			$this.slider({
				 min: $this.data('min'),
			     max: $this.data('max'),
			     step: $this.data('step'),
			     range: ($this.data('type') == 'range' ? true : 'min'),
			     slide: function(event, ui){
			    	 if($this.data('type') == 'range'){
			    		 $this.closest('.dhvc-form-group').find('.dhvc-form-slider-value-from').text(ui.values[0]);
			    		 $this.closest('.dhvc-form-group').find('.dhvc-form-slider-value-to').text(ui.values[1]);
			    		 $this.closest('.dhvc-form-group').find('input[type="hidden"]').val(ui.values[0] + '-' + ui.values[1]).trigger('change');
			    	 }else{
			    		 $this.closest('.dhvc-form-group').find('.dhvc-form-slider-value').text(ui.value);
			    		 $this.closest('.dhvc-form-group').find('input[type="hidden"]').val(ui.value).trigger('change');
			    	 }
			     }
			});
			if($this.data('type') == 'range'){
				$this.slider('values',[0,$this.data('minmax')]);
			}else{
				$this.slider('value',$this.data('value'));
			}
		});
		
		var basename = function(path, suffix) {
		  //  discuss at: http://phpjs.org/functions/basename/
		  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
		  // improved by: Ash Searle (http://hexmen.com/blog/)
		  // improved by: Lincoln Ramsay
		  // improved by: djmix
		  // improved by: Dmitry Gorelenkov
		  //   example 1: basename('/www/site/home.htm', '.htm');
		  //   returns 1: 'home'
		  //   example 2: basename('ecra.php?p=1');
		  //   returns 2: 'ecra.php?p=1'
		  //   example 3: basename('/some/path/');
		  //   returns 3: 'path'
		  //   example 4: basename('/some/path_ext.ext/','.ext');
		  //   returns 4: 'path_ext'

		  var b = path;
		  var lastChar = b.charAt(b.length - 1);

		  if (lastChar === '/' || lastChar === '\\') {
		    b = b.slice(0, -1);
		  }

		  b = b.replace(/^.*[\/\\]/g, '');

		  if (typeof suffix === 'string' && b.substr(b.length - suffix.length) == suffix) {
		    b = b.substr(0, b.length - suffix.length);
		  }

		  return b;
		}

		
		var operators = {
		    '>': function(a, b) { return a > b },
		    '=': function(a, b) { return a == b },
		    '<': function(a, b) { return a < b }
		};
		
		var get_field_val = function(field, form){
			var $form = $(form),
				$this=$(field);
			return $this.is(':checkbox') ? $.map($form.find('[data-conditional-name=' + $this.data('conditional-name') + '].dhvc-form-value:checked'),
	                function (element) {
						return $(element).val();
	            	})
	            : ($this.is(':radio') ? $form.find('[data-conditional-name=' + $this.data('conditional-name') + '].dhvc-form-value:checked').val() : $this.val() );
	       
		}
		
		var conditional_hook = function(e){
			var $this = $(e.currentTarget),
				form = $this.closest('form'),
				container_class = dhvcformL10n.container_class,
				master_container = $this.closest(container_class),
				master_value,
				is_empty,
				conditional_data = $this.data('conditional'),
				conditional_data2=[],
				conditional_current=null;
			
			master_value = get_field_val($this,form);
	       is_empty = $this.is(':checkbox') ? !form.find('[data-conditional-name=' + $this.data('conditional-name') + '].dhvc-form-value:checked').length
                 : ( $this.is(':radio') ? !form.find('[data-conditional-name=' + $this.data('conditional-name') + '].dhvc-form-value:checked').val() : !master_value.length )  ;
	       
	       
	        if(is_empty){
	        	$.each(conditional_data,function(i,conditional){
	        		var elements = conditional.element.split(',');
	        		$.each(elements,function(index,element){
						var $this = form.find('.dhvc-form-control-'+element);
						$this.closest(container_class).addClass('dhvc-form-hidden');
					});
	        	});
	        	$.each(conditional_data,function(i,conditional){
					var elements = conditional.element.split(',');
		        	if(conditional.type == 'is_empty'){
		        		if(conditional.action == 'hide'){
							$.each(elements,function(index,element){
								var $this = form.find('.dhvc-form-control-'+element);
								$this.closest(container_class).addClass('dhvc-form-hidden');
								$this.trigger('change');
							});
						}else{
							$.each(elements,function(index,element){
								var $this = form.find('.dhvc-form-control-'+element);
								$this.closest(container_class).removeClass('dhvc-form-hidden');
								$this.trigger('change');
							});
						}
		        	}
	        	});
	        }else{
	        	if ($.isNumeric(master_value))
		        {
		        	master_value = parseInt(master_value);
		        }
	        	$.each(conditional_data,function(i,conditional){
	        		if(conditional.value == master_value){
	        			conditional_current = conditional;
	        		}else{
	        			conditional_data2.push(conditional);
	        		}
	        	});
	        	if(conditional_current != null){
		        	conditional_data2.push(conditional_current)
		        	conditional_data = conditional_data2;
	        	}
				$.each(conditional_data,function(i,conditional){
					var elements = conditional.element.split(',');
					
					if(master_container.hasClass('dhvc-form-hidden')) {
						$.each(elements,function(index,element){
							var $this = form.find('.dhvc-form-control-'+element);
							$this.closest(container_class).addClass('dhvc-form-hidden');
						});
					}else{
						if(conditional.type == 'not_empty'){
							if(conditional.action == 'hide'){
								$.each(elements,function(index,element){
									var $this = form.find('.dhvc-form-control-'+element);
									$this.closest(container_class).addClass('dhvc-form-hidden');
									$this.trigger('change');
								});
							}else{
								$.each(elements,function(index,element){
									var $this = form.find('.dhvc-form-control-'+element);
									$this.closest(container_class).removeClass('dhvc-form-hidden');
									$this.trigger('change');
								});
							}
						}else if(conditional.type == 'is_empty'){
							
							if(conditional.action == 'hide'){
								$.each(elements,function(index,element){
									var $this = form.find('.dhvc-form-control-'+element);
									$this.closest(container_class).removeClass('dhvc-form-hidden');
									$this.trigger('change');
								});
							}else{
								$.each(elements,function(index,element){
									var $this = form.find('.dhvc-form-control-'+element);
									$this.closest(container_class).addClass('dhvc-form-hidden');
									$this.trigger('change');
								});
							}
						}else{
							if($.isArray(master_value)){
								if($.inArray(conditional.value,master_value) > -1){
									if(conditional.action == 'hide'){
										$.each(elements,function(index,element){
											var $this = form.find('.dhvc-form-control-'+element);
											$this.closest(container_class).addClass('dhvc-form-hidden');
											$this.trigger('change');
										});
									}else{
										$.each(elements,function(index,element){
											var $this = form.find('.dhvc-form-control-'+element);
											$this.closest(container_class).removeClass('dhvc-form-hidden');
											$this.trigger('change');
										});
									}
								}else{
									if(conditional.action == 'hide'){
										$.each(elements,function(index,element){
											var $this = form.find('.dhvc-form-control-'+element);
											$this.closest(container_class).removeClass('dhvc-form-hidden');
											$this.trigger('change');
										});
									}else{
										$.each(elements,function(index,element){
											var $this = form.find('.dhvc-form-control-'+element);
											$this.closest(container_class).addClass('dhvc-form-hidden');
											$this.trigger('change');
										});
									}
								}
							}else{
								
						        if ($.isNumeric(master_value))
						        {
						        	master_value = parseInt(master_value);
						        }
						        if ($.isNumeric(conditional.value) &&  conditional.value !='0')
						        {
						        	conditional.value = parseInt(conditional.value);
						        }
								if(conditional.type != 'not_empty' && conditional.type != 'is_empty' && operators[conditional.type](master_value,conditional.value)){
									
									if(conditional.action == 'hide'){
										$.each(elements,function(index,element){
											var $this = form.find('.dhvc-form-control-'+element);
											$this.closest(container_class).addClass('dhvc-form-hidden');
											$this.trigger('change');
										});
									}else{
										$.each(elements,function(index,element){
											var $this = form.find('.dhvc-form-control-'+element);
											$this.closest(container_class).removeClass('dhvc-form-hidden');
											$this.trigger('change');
										});
									}
								}else{
									if(conditional.action == 'hide'){
										$.each(elements,function(index,element){
											var $this = form.find('.dhvc-form-control-'+element);
											$this.closest(container_class).removeClass('dhvc-form-hidden');
											$this.trigger('change');
										});
									}else{
										$.each(elements,function(index,element){
											var $this = form.find('.dhvc-form-control-'+element);
											$this.closest(container_class).addClass('dhvc-form-hidden');
											$this.trigger('change');
										});
									}
								}
							}
						}
					}
					
				});
	        }
	        return true;
		}
		
		var update_hidden_fields = function(form){
			var $form = $(form);
			var fields = [];
			$form.find('.dhvc-form-value').filter(function(){
				var name = $(this).attr('data-name') || this.name;
				if($.inArray(name,fields) >= 0 || $(this).is(":visible"))
					return false;
				fields.push(name);
				return true;
			})
			$form.find('#_dhvc_form_hidden_fields').val(JSON.stringify(fields))
		}
		
		var conditional_form = function(form,ignore_bind){
			var $form = $(form),
				master_box = $form.find('.dhvc-form-conditional'),
				ignore_bind = ignore_bind || false;
			$.each(master_box,function(){
				var masters = $(this).find('[data-conditional].dhvc-form-value');
				if(false===ignore_bind){
					$(masters).bind('keyup change',function(e){
						conditional_hook(e);
						//var deferred = $.Deferred();
						//deferred.resolve(conditional_hook(e)).done(update_hidden_fields($form));
					});
				}
				$.each(masters,function(){
					var $this = $(this);
					conditional_hook({currentTarget: $this });
					//var deferred = $.Deferred();
					//deferred.resolve(conditional_hook({currentTarget: $this })).done(update_hidden_fields($form));
				});
			});
		};
		
		var form_math = function(form){
			var $form = $(form);
			var maths = [];
			$('.dhvc-form-math',$form).each(function(){
				var match,
					match_value=0,
					$this = $(this);
				var pattern = /\[(.*?)\]/g;
				var operators = $this.data('value-math');
				if(!$.isNumeric(operators)){
					if(operators.replace(/[^.*()\-+\/]+/g, '') === ''){
						var $el = $('[data-field-name=' + operators +']',$form);
						var field_value = parseFloat(get_field_val($el,$form));
						field_value = isNaN(field_value) ? 0 : field_value;
						match_value = field_value;
					}else{
						var fields = operators.split(/[*()\-+\/]/);
						$.each(fields,function(key,field){
							var $el = $('[data-field-name=' + field +']',$form);
							if($el.length){
								var field_value = parseFloat(get_field_val($el,$form));
								field_value = isNaN(field_value) ? 0 : field_value;
								var reg = new RegExp(field, 'g');
								operators = operators.replace(reg,field_value);
							}
						})
						try {
							match_value = parseFloat(eval(operators).toFixed(2));
					     } catch (e) {
					    	 match_value = 0;
					     }
					}
					$this.text(match_value);
					$( document.body ).trigger( 'dhvc_form_math_change', [$form] );
				}
			});
			
		}
		
		$(document.body).on('dhvc_form_math_change', function(event, form) {
			var pp_total = 0,
				$form = $(form);
			$('.paypal-item-price-value',$form).each(function(){
				pp_total +=parseFloat($(this).text());
			})
			$('.paypal-total-value').text(pp_total);
		});

		if($().xdsoftDatetimepicker && 'function' === typeof $.xdsoftDatetimepicker.setLocale){
			$.xdsoftDatetimepicker.setLocale(dhvcformL10n.datetimepicker_lang);
		}
		
		
		var form_submit_loading = function(form,loaded){
			loaded = loaded || false;
			var $form = $(form);
			var submit = $form.find('.dhvc-form-submit');
			var dhvc_button_label = $form.find('.dhvc-form-submit-label');
			var dhvc_ajax_spinner = $form.find('.dhvc-form-submit-spinner');
			if(loaded){
				submit.removeAttr('disabled');
	        	dhvc_button_label.removeClass('dhvc-form-submit-label-hidden');
	        	dhvc_ajax_spinner.hide();
			}else{
				submit.attr('disabled','disabled');
	        	dhvc_button_label.addClass('dhvc-form-submit-label-hidden');
	        	dhvc_ajax_spinner.show();
			}
		}
		
		if($('.dhvc-form-datepicker').length){
			$('.dhvc-form-datepicker').each(function(){
				var _this = $(this);
				_this.xdsoftDatetimepicker({
					format: dhvcformL10n.date_format,
					formatDate: dhvcformL10n.date_format,
					timepicker:false,
					scrollMonth:false,
					dayOfWeekStart: parseInt(dhvcformL10n.dayofweekstart),
					scrollTime:false,
					minDate: _this.data('min-date'),
					maxDate: _this.data('max-date'),
					yearStart: _this.data('year-start'),
					yearEnd: _this.data('year-end'),
					scrollInput:false
				});
			});
			
		}
		
		if($('.dhvc-form-timepicker').length){
			$('.dhvc-form-timepicker').each(function(){
				var _this = $(this);
				_this.xdsoftDatetimepicker({
					format: dhvcformL10n.time_format,
					formatTime: dhvcformL10n.time_format,
					datepicker:false,
					scrollMonth:false,
					scrollTime:true,
					scrollInput:false,
					dayOfWeekStart: parseInt(dhvcformL10n.dayofweekstart),
					minTime: _this.data('min-time'),
					maxTime: _this.data('max-time'),
					minDate: _this.data('min-date'),
					maxDate: _this.data('max-date'),
					yearStart: _this.data('year-start'),
					yearEnd: _this.data('year-end'),
					step: parseInt(dhvcformL10n.time_picker_step)
				});
			});
		}
		
		if($('.dhvc-form-datetimepicker').length){
			$('.dhvc-form-datetimepicker').each(function(){
				var _this = $(this);
				_this.xdsoftDatetimepicker({
					format: dhvcformL10n.date_format +' '+dhvcformL10n.time_format,
					datepicker:true,
					scrollMonth:false,
					scrollTime:true,
					scrollInput:false,
					minTime: _this.data('min-time'),
					maxTime: _this.data('max-time'),
					step: parseInt(dhvcformL10n.time_picker_step)
				});
			});
		}
		
		var initForm = function(form){

			var $form = $( form ),
				submiting=false;
			
			var submitBtn = $form.find('.dhvc-form-submit');
			
			$('.dhvc-form-file',$form).find('input[type=file]').on('change',function(){
				var _val = $(this).val();
				$(this).closest('label').find('.dhvc-form-control').prop('value',basename(_val));
			});
			$('.dhvc-form-file',$form).each(function(){
				$(this).find('input[type="text"]').css({'padding-right':$(this).find('.dhvc-form-file-button').outerWidth(true) + 'px'});
				$(this).find('input[type="text"]').on('click',function(){
					$(this).closest('label').trigger('click');
				});
			});
			
			if($().tooltip)
				$('.dhvc-form-rate .dhvc-form-rate-star',$form).tooltip({ html: true,container:$('body')});
			
			
			var clearResponse = function(form){
				var $form = $( form );
				$form.removeClass( 'invalid spam sent failed' );
				$( '[aria-invalid]', $form ).attr( 'aria-invalid', 'false' );
				$( '.dhvc-form-error', $form ).remove();
				$( '.dhvc-form-control', $form ).removeClass( 'dhvc-form-not-valid' );
				$( '.dhvc-form-message', $form.parent() )
				.hide().empty().removeAttr( 'role' )
				.removeClass('dhvc-form-validation-errors dhvc-form-spam dhvc-form-errors dhvc-form-success');
			}
			
			var refill = function(form, data){
				var $form = $(form);
				var refillCaptcha = function( $form, items ) {
					$.each( items, function( i, n ) {
						$form.find( ':input[name="' + i + '"]' ).val( '' );
						$form.find( 'img.dhvc-form-captcha-img-' + i ).attr( 'src', n );
						var match = /([0-9]+)\.(png|gif|jpeg)$/.exec( n );
						$form.find( 'input:hidden[name="_dhvc_form_captcha_challenge_' + i + '"]' ).attr( 'value', match[ 1 ] );
					} );
				};
				if ( data.captcha ) {
					refillCaptcha( $form, data.captcha );
				}
			}
			
			var notValidTip = function(target, message){
				if(message=='')
					return;
				var $target = $( target );
				$( '.dhvc-form-error', $target ).remove();
				var error = $( '<span role="alert" class="dhvc-form-error"></span>' );
				
				error.text(message);
				
				if ( $target.is( ':radio' ) || $target.is( ':checkbox' ) )
					error.appendTo( $target.parent().parent() );
				else if($target.attr('data-dhvcform-recaptcha')=='recaptcha')
					error.appendTo($target.closest('.dhvc-form-group') );
				else
					error.appendTo( $target.parent().parent());
			}
			
			var form_step_click_init = function(form){
				var $form = $(form);
				$('.dhvc-form-step',$form).on('click',function(e){
					var $this = $(this);
					e.stopPropagation();
					e.preventDefault();
					if(!$this.hasClass('actived'))
						return;
					
					$( '.dhvc-form-message.dhvc-form-success', $form.parent() )
					.hide().empty().removeAttr( 'role' )
					.removeClass('dhvc-form-validation-errors dhvc-form-spam dhvc-form-errors dhvc-form-success');
					
					var current_step = $(this).data('step-index');
					$('.dhvc-form-steps',$form).find('.active').removeClass('active');
					$this.removeClass('actived').addClass('active');
					$('.dhvc-form-step-content',$form).removeClass('active');
					$('.dhvc-form-step-content-'+current_step,$form).addClass('active');
					$('#_dhvc_form_current_step',$form).val(current_step);
				});
			}
			form_step_click_init($form);
			
			var ajaxSuccess = function(data, status, xhr, $form ){
				var $message = $( '.dhvc-form-message', $form.parent() );
				
				switch ( data.status ) {
					case 'validation_failed':
						var firstInvalidFields = null;
						$.each( data.invalid_fields, function( i, n ) {
							if(!firstInvalidFields)
								firstInvalidFields = $(n.into);
							notValidTip( $(n.into), n.reason );
							$( '.dhvc-form-control', $(n.into).closest('.dhvc-form-group') ).addClass( 'dhvc-form-not-valid' );
							$( '[aria-invalid]', $(n.into) ).attr( 'aria-invalid', 'true' );
						} );
						try {
							firstInvalidFields.focus()

							// Manually trigger focusin event; without it, focusin handler isn't called, findLastActive won't have anything to find
							.trigger( "focusin" );
						} catch ( e ) {

							// Ignore IE throwing errors when focusing hidden elements
						}
						
						$message.addClass( 'dhvc-form-validation-errors' );
						
						$form.addClass( 'invalid' );
						
						$( document.body ).trigger( 'dhvc_form_invalid', [$form, data] );
					break;
					case 'success':
						if($form.find('#_dhvc_form_steps').length){
							var step_final = '<div class="dhvc-form-steps-final"></div>';
							$form.find('.dhvc-form-step-contents').append($(step_final));
						}
						if ( data.onOk ) {
							$.each( data.onOk, function( i, n ) { eval( n ) } );
						}
						$message.addClass( 'dhvc-form-success' );
						$( document.body ).trigger( 'dhvc_form_success', [$form, data] );
					break;
					case 'spam':
						$message.addClass( 'dhvc-form-spam' );
						$( document.body ).trigger( 'dhvc_form_spam', [$form, data] );
					break;
					case 'upload_failed':
						$message.addClass( 'dhvc-form-errors' );
						$( document.body ).trigger( 'dhvc_form_upload_failed', [$form, data] );
					break;
					case 'form_not_exist':
						$message.addClass( 'dhvc-form-errors' );
						$( document.body ).trigger( 'dhvc_form_not_exist', [$form, data] );
					break;
					case 'action_failed':
						$message.addClass( 'dhvc-form-errors' );
						$( document.body ).trigger( 'dhvc_form_action_failed', [$form, data] );
					break;
					case 'call_action_failed':
						$message.addClass( 'dhvc-form-errors' );
						$( document.body ).trigger( 'dhvc_form_call_action_failed', [$form, data] );
					break;
					case 'next_step':
						var $current_step_input = $('#_dhvc_form_current_step',$form);
						var $current_step = parseInt($current_step_input.val());
						var $all_steps = parseInt($('#_dhvc_form_steps',$form).val());
						var $next_step = $current_step + 1;
						if($next_step<=$all_steps ){
							$('.dhvc-form-steps',$form).find('.active').removeClass('active');
							$('.dhvc-form-step-'+$current_step,$form).addClass('actived');
							$('.dhvc-form-step-'+$next_step,$form).addClass('active');
							$('.dhvc-form-step-content',$form).removeClass('active');
							$('.dhvc-form-step-content-'+$next_step,$form).addClass('active');
							$('#_dhvc_form_current_step',$form).val($next_step);
						}
					break;
				}

				refill( $form, data );

				$( document.body ).trigger( 'dhvc_form_submit', [$form, data] );

				if ( 'success' === data.status ) {
					$form.each( function() {
						this.reset();
					} );
					
					conditional_form($form,true);
					
					if(data.redirect){
						 window.location = data.redirect;
					}
				}
				if(!data.redirect && data.message!=''){
					$message.html( data.message )
					$message.attr( 'role', 'alert' );
					if($form.find('.dhvc-form-steps-final').length){
						$('.dhvc-form-step-content').each(function(){
							$(this).remove();
						})
						$form.find('.dhvc-form-steps-final').html($message.clone());
						$message.remove();
					}else{
						$message.slideDown( 'fast' );
					}
				}
			}
			
			$form.submit( function( event ) {
				if (submiting || typeof window.FormData !== 'function' ) {
					return;
				}
				submiting = true;
				clearResponse($form);
				
		    	update_hidden_fields($form);
				
				var formData = new FormData( $form.get( 0 ) );
				
				$.ajax( {
					type: 'POST',
					url:dhvcformL10n.ajax_url,
					data: formData,
					dataType: 'json',
					processData: false,
					contentType: false,
					beforeSend: function(){
						$( document.body ).trigger( 'dhvc_form_before_submit', [$form, submitBtn] );
				    	form_submit_loading($form,false);
			        }
				} ).done( function( data, status, xhr ) {
					$( document.body ).trigger( 'dhvc_form_after_submit', [ $(form), submitBtn , data] );
					ajaxSuccess( data, status, xhr, $form );
					submiting = false;
					form_submit_loading($form,true);
				} ).fail( function( xhr, status, error ) {
					submiting = false;
					form_submit_loading($form,true);
				} );
				event.preventDefault();
			} );
		}
		
		$('form.dhvcform').each(function(){
			var $form = $(this);
			form_math($form);
		    $('.dhvc-form-value',$form).bind('keyup change',function(e){
		    	form_math($(this).closest('form'));
			});
		    conditional_form($form);
		    if($form.hasClass('dhvcform-action-default'))
		    	initForm($form);
		});
	});
	
}(window.jQuery);