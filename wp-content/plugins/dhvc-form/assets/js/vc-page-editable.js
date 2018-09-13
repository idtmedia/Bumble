var dhvc_form_iframe = {}
! function($) {
	dhvc_form_iframe.date_time = function(model_id){
		var $el = $("[data-model-id=" + model_id + "]");
		if($().xdsoftDatetimepicker && 'function' === typeof $.xdsoftDatetimepicker.setLocale)
			$.xdsoftDatetimepicker.setLocale(dhvcformL10n.datetimepicker_lang);
		$el.find('.dhvc-form-datepicker').each(function(){
			var _this = $(this);
			_this.xdsoftDatetimepicker({
				format: dhvcformL10n.date_format,
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
		
		$el.find('.dhvc-form-timepicker').each(function(){
			var _this = $(this);
			_this.xdsoftDatetimepicker({
				format: dhvcformL10n.time_format,
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
		
		$el.find('.dhvc-form-datetimepicker').each(function(){
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
	dhvc_form_iframe.slider = function(model_id){
		var $el = $("[data-model-id=" + model_id + "]");
		$el.find('.dhvc-form-slider-control').each(function(){
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
	}
	dhvc_form_iframe.recaptcha = function(model_id){
		var $el = $("[data-model-id=" + model_id + "]");
		if(typeof grecaptcha != 'undefined'){
			$el.find('.dhvc-form-recaptcha2').each(function(){
				var widget_id = grecaptcha.render( $(this).attr('id'), {
			        'sitekey': dhvcformL10n.recaptcha_public_key,
			        'theme': 'light'
		   		 } );
			});
		}
	}
	
	dhvc_form_iframe.rate = function(model_id){
		var $el = $("[data-model-id=" + model_id + "]");
		$el.find('.dhvc-form-rate .dhvc-form-rate-star').tooltip({ html: true,container:$('body')});
	}
	
	dhvc_form_iframe.file = function(model_id){
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
		var $el = $("[data-model-id=" + model_id + "]");
		$('.dhvc-form-file',$el).find('input[type=file]').on('change',function(){
			var _val = $(this).val();
			$(this).closest('label').find('.dhvc-form-control').prop('value',basename(_val));
		});
		$('.dhvc-form-file',$el).each(function(){
			$(this).find('input[type="text"]').css({'padding-right':$(this).find('.dhvc-form-file-button').outerWidth(true) + 'px'});
			$(this).find('input[type="text"]').on('click',function(){
				$(this).closest('label').trigger('click');
			});
		});
	}
	
	dhvc_form_iframe.minicolor = function(model_id){
		var $el = $("[data-model-id=" + model_id + "]");
		$el.find(".dhvc_form_color input").minicolors({
			theme: 'bootstrap'
		});
	};
}(window.jQuery);