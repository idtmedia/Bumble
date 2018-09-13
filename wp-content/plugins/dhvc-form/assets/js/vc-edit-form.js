(function ($) {
	if(_.isUndefined(window.vc)) window.vc = {};
	if(_.isUndefined(vc.edit_form_callbacks)) vc.edit_form_callbacks = [];
	vc.edit_form_callbacks.push(function() {
		var model = this.$el;
		var conditional_list = model.find('.dhvc-form-conditional-list');
		if(conditional_list.length){
			var conditionals = [];
			conditional_list.find('table tbody tr').each(function(){
				var $this = $(this);
				var conditional = {};
				if($this.find('#conditional-element').val() != ''){
					conditional['type'] = $this.find('#conditional-type').val();
					conditional['value'] = $this.find('#conditional-value').val();
					conditional['action'] = $this.find('#conditional-action').val();
					conditional['element'] = $this.find('#conditional-element').val();
					conditionals.push(conditional);
				}
			});
			if(_.isEmpty(conditionals)){
				this.params.conditional='';
			}else{
				var conditionals_json = JSON.stringify(conditionals);
				this.params.conditional = base64_encode(conditionals_json);
			}
		}
		
		var rate_option_list = model.find('.dhvc-form-rate-option-list');
		if(rate_option_list.length){
			var rate_options = [];
			rate_option_list.find('table tbody tr').each(function(){
				var $this = $(this);
				var rate_option = {};
				rate_option['label'] = $this.find('#rate-label').val();
				rate_option['value'] = $this.find('#rate-value').val();
				rate_options.push(rate_option);
			});
			if(_.isEmpty(rate_options)){
				this.params.rate_option='';
			}else{
				var rate_options_json = JSON.stringify(rate_options);
				this.params.rate_option = base64_encode(rate_options_json);
			}
		}
		
		var paypal_list = model.find('.dhvc-form-paypal-item-list');
		if(paypal_list.length){
			var paypal_items = [];
			paypal_list.find('table tbody tr').each(function(){
				var $this = $(this);
				var paypal_item = {};
				paypal_item['label'] = $this.find('#label').val();
				paypal_item['qty'] = $this.find('#qty').val();
				paypal_item['price'] = $this.find('#price').val();
				paypal_items.push(paypal_item);
			});
			if(_.isEmpty(paypal_items)){
				this.params.item_list='';
			}else{
				var paypal_items_json = JSON.stringify(paypal_items);
				this.params.item_list = base64_encode(paypal_items_json);
			}
		}
		
		var option_list = model.find('.dhvc-form-option-list');
		if(option_list.length){
			var options = [];
			option_list.find('table tbody tr').each(function(){
				var $this = $(this);
				var option = {};
				option['is_default'] = 0;
				if($this.find('#is_default').is(':checked')){
					option['is_default'] = 1;
				}
				option['label'] = $this.find('#label').val();
				option['value'] = $this.find('#value').val();
				options.push(option);
			});
			if(_.isEmpty(options)){
				this.params.options='';
			}else{
				var options_json = JSON.stringify(options);
				this.params.options = base64_encode(options_json);
			}
		}
	});
})(window.jQuery);