/*!
 * jQuery blockUI plugin
 * Version 2.66.0-2013.10.09
 * Requires jQuery v1.7 or later
 *
 * Examples at: http://malsup.com/jquery/block/
 * Copyright (c) 2007-2013 M. Alsup
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Thanks to Amir-Hossein Sobhi for some excellent contributions!
 */(function(){"use strict";function e(e){function a(i,a){var l,h,m=i==window,g=a&&a.message!==undefined?a.message:undefined;a=e.extend({},e.blockUI.defaults,a||{});if(a.ignoreIfBlocked&&e(i).data("blockUI.isBlocked"))return;a.overlayCSS=e.extend({},e.blockUI.defaults.overlayCSS,a.overlayCSS||{});l=e.extend({},e.blockUI.defaults.css,a.css||{});a.onOverlayClick&&(a.overlayCSS.cursor="pointer");h=e.extend({},e.blockUI.defaults.themedCSS,a.themedCSS||{});g=g===undefined?a.message:g;m&&o&&f(window,{fadeOut:0});if(g&&typeof g!="string"&&(g.parentNode||g.jquery)){var y=g.jquery?g[0]:g,b={};e(i).data("blockUI.history",b);b.el=y;b.parent=y.parentNode;b.display=y.style.display;b.position=y.style.position;b.parent&&b.parent.removeChild(y)}e(i).data("blockUI.onUnblock",a.onUnblock);var w=a.baseZ,E,S,x,T;n||a.forceIframe?E=e('<iframe class="blockUI" style="z-index:'+w++ +';display:none;border:none;margin:0;padding:0;position:absolute;width:100%;height:100%;top:0;left:0" src="'+a.iframeSrc+'"></iframe>'):E=e('<div class="blockUI" style="display:none"></div>');a.theme?S=e('<div class="blockUI blockOverlay ui-widget-overlay" style="z-index:'+w++ +';display:none"></div>'):S=e('<div class="blockUI blockOverlay" style="z-index:'+w++ +';display:none;border:none;margin:0;padding:0;width:100%;height:100%;top:0;left:0"></div>');if(a.theme&&m){T='<div class="blockUI '+a.blockMsgClass+' blockPage ui-dialog ui-widget ui-corner-all" style="z-index:'+(w+10)+';display:none;position:fixed">';a.title&&(T+='<div class="ui-widget-header ui-dialog-titlebar ui-corner-all blockTitle">'+(a.title||"&nbsp;")+"</div>");T+='<div class="ui-widget-content ui-dialog-content"></div>';T+="</div>"}else if(a.theme){T='<div class="blockUI '+a.blockMsgClass+' blockElement ui-dialog ui-widget ui-corner-all" style="z-index:'+(w+10)+';display:none;position:absolute">';a.title&&(T+='<div class="ui-widget-header ui-dialog-titlebar ui-corner-all blockTitle">'+(a.title||"&nbsp;")+"</div>");T+='<div class="ui-widget-content ui-dialog-content"></div>';T+="</div>"}else m?T='<div class="blockUI '+a.blockMsgClass+' blockPage" style="z-index:'+(w+10)+';display:none;position:fixed"></div>':T='<div class="blockUI '+a.blockMsgClass+' blockElement" style="z-index:'+(w+10)+';display:none;position:absolute"></div>';x=e(T);if(g)if(a.theme){x.css(h);x.addClass("ui-widget-content")}else x.css(l);a.theme||S.css(a.overlayCSS);S.css("position",m?"fixed":"absolute");(n||a.forceIframe)&&E.css("opacity",0);var N=[E,S,x],C=m?e("body"):e(i);e.each(N,function(){this.appendTo(C)});a.theme&&a.draggable&&e.fn.draggable&&x.draggable({handle:".ui-dialog-titlebar",cancel:"li"});var k=s&&(!e.support.boxModel||e("object,embed",m?null:i).length>0);if(r||k){m&&a.allowBodyStretch&&e.support.boxModel&&e("html,body").css("height","100%");if((r||!e.support.boxModel)&&!m)var L=v(i,"borderTopWidth"),A=v(i,"borderLeftWidth"),O=L?"(0 - "+L+")":0,M=A?"(0 - "+A+")":0;e.each(N,function(e,t){var n=t[0].style;n.position="absolute";if(e<2){m?n.setExpression("height","Math.max(document.body.scrollHeight, document.body.offsetHeight) - (jQuery.support.boxModel?0:"+a.quirksmodeOffsetHack+') + "px"'):n.setExpression("height",'this.parentNode.offsetHeight + "px"');m?n.setExpression("width",'jQuery.support.boxModel && document.documentElement.clientWidth || document.body.clientWidth + "px"'):n.setExpression("width",'this.parentNode.offsetWidth + "px"');M&&n.setExpression("left",M);O&&n.setExpression("top",O)}else if(a.centerY){m&&n.setExpression("top",'(document.documentElement.clientHeight || document.body.clientHeight) / 2 - (this.offsetHeight / 2) + (blah = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "px"');n.marginTop=0}else if(!a.centerY&&m){var r=a.css&&a.css.top?parseInt(a.css.top,10):0,i="((document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "+r+') + "px"';n.setExpression("top",i)}})}if(g){a.theme?x.find(".ui-widget-content").append(g):x.append(g);(g.jquery||g.nodeType)&&e(g).show()}(n||a.forceIframe)&&a.showOverlay&&E.show();if(a.fadeIn){var _=a.onBlock?a.onBlock:t,D=a.showOverlay&&!g?_:t,P=g?_:t;a.showOverlay&&S._fadeIn(a.fadeIn,D);g&&x._fadeIn(a.fadeIn,P)}else{a.showOverlay&&S.show();g&&x.show();a.onBlock&&a.onBlock()}c(1,i,a);if(m){o=x[0];u=e(a.focusableElements,o);a.focusInput&&setTimeout(p,20)}else d(x[0],a.centerX,a.centerY);if(a.timeout){var H=setTimeout(function(){m?e.unblockUI(a):e(i).unblock(a)},a.timeout);e(i).data("blockUI.timeout",H)}}function f(t,n){var r,i=t==window,s=e(t),a=s.data("blockUI.history"),f=s.data("blockUI.timeout");if(f){clearTimeout(f);s.removeData("blockUI.timeout")}n=e.extend({},e.blockUI.defaults,n||{});c(0,t,n);if(n.onUnblock===null){n.onUnblock=s.data("blockUI.onUnblock");s.removeData("blockUI.onUnblock")}var h;i?h=e("body").children().filter(".blockUI").add("body > .blockUI"):h=s.find(">.blockUI");if(n.cursorReset){h.length>1&&(h[1].style.cursor=n.cursorReset);h.length>2&&(h[2].style.cursor=n.cursorReset)}i&&(o=u=null);if(n.fadeOut){r=h.length;h.stop().fadeOut(n.fadeOut,function(){--r===0&&l(h,a,n,t)})}else l(h,a,n,t)}function l(t,n,r,i){var s=e(i);if(s.data("blockUI.isBlocked"))return;t.each(function(e,t){this.parentNode&&this.parentNode.removeChild(this)});if(n&&n.el){n.el.style.display=n.display;n.el.style.position=n.position;n.parent&&n.parent.appendChild(n.el);s.removeData("blockUI.history")}s.data("blockUI.static")&&s.css("position","static");typeof r.onUnblock=="function"&&r.onUnblock(i,r);var o=e(document.body),u=o.width(),a=o[0].style.width;o.width(u-1).width(u);o[0].style.width=a}function c(t,n,r){var i=n==window,s=e(n);if(!t&&(i&&!o||!i&&!s.data("blockUI.isBlocked")))return;s.data("blockUI.isBlocked",t);if(!i||!r.bindEvents||t&&!r.showOverlay)return;var u="mousedown mouseup keydown keypress keyup touchstart touchend touchmove";t?e(document).bind(u,r,h):e(document).unbind(u,h)}function h(t){if(t.type==="keydown"&&t.keyCode&&t.keyCode==9&&o&&t.data.constrainTabKey){var n=u,r=!t.shiftKey&&t.target===n[n.length-1],i=t.shiftKey&&t.target===n[0];if(r||i){setTimeout(function(){p(i)},10);return!1}}var s=t.data,a=e(t.target);a.hasClass("blockOverlay")&&s.onOverlayClick&&s.onOverlayClick(t);return a.parents("div."+s.blockMsgClass).length>0?!0:a.parents().children().filter("div.blockUI").length===0}function p(e){if(!u)return;var t=u[e===!0?u.length-1:0];t&&t.focus()}function d(e,t,n){var r=e.parentNode,i=e.style,s=(r.offsetWidth-e.offsetWidth)/2-v(r,"borderLeftWidth"),o=(r.offsetHeight-e.offsetHeight)/2-v(r,"borderTopWidth");t&&(i.left=s>0?s+"px":"0");n&&(i.top=o>0?o+"px":"0")}function v(t,n){return parseInt(e.css(t,n),10)||0}e.fn._fadeIn=e.fn.fadeIn;var t=e.noop||function(){},n=/MSIE/.test(navigator.userAgent),r=/MSIE 6.0/.test(navigator.userAgent)&&!/MSIE 8.0/.test(navigator.userAgent),i=document.documentMode||0,s=e.isFunction(document.createElement("div").style.setExpression);e.blockUI=function(e){a(window,e)};e.unblockUI=function(e){f(window,e)};e.growlUI=function(t,n,r,i){var s=e('<div class="growlUI"></div>');t&&s.append("<h1>"+t+"</h1>");n&&s.append("<h2>"+n+"</h2>");r===undefined&&(r=3e3);var o=function(t){t=t||{};e.blockUI({message:s,fadeIn:typeof t.fadeIn!="undefined"?t.fadeIn:700,fadeOut:typeof t.fadeOut!="undefined"?t.fadeOut:1e3,timeout:typeof t.timeout!="undefined"?t.timeout:r,centerY:!1,showOverlay:!1,onUnblock:i,css:e.blockUI.defaults.growlCSS})};o();var u=s.css("opacity");s.mouseover(function(){o({fadeIn:0,timeout:3e4});var t=e(".blockMsg");t.stop();t.fadeTo(300,1)}).mouseout(function(){e(".blockMsg").fadeOut(1e3)})};e.fn.block=function(t){if(this[0]===window){e.blockUI(t);return this}var n=e.extend({},e.blockUI.defaults,t||{});this.each(function(){var t=e(this);if(n.ignoreIfBlocked&&t.data("blockUI.isBlocked"))return;t.unblock({fadeOut:0})});return this.each(function(){if(e.css(this,"position")=="static"){this.style.position="relative";e(this).data("blockUI.static",!0)}this.style.zoom=1;a(this,t)})};e.fn.unblock=function(t){if(this[0]===window){e.unblockUI(t);return this}return this.each(function(){f(this,t)})};e.blockUI.version=2.66;e.blockUI.defaults={message:"<h1>Please wait...</h1>",title:null,draggable:!0,theme:!1,css:{padding:0,margin:0,width:"30%",top:"40%",left:"35%",textAlign:"center",color:"#000",border:"3px solid #aaa",backgroundColor:"#fff",cursor:"wait"},themedCSS:{width:"30%",top:"40%",left:"35%"},overlayCSS:{backgroundColor:"#000",opacity:.6,cursor:"wait"},cursorReset:"default",growlCSS:{width:"350px",top:"10px",left:"",right:"10px",border:"none",padding:"5px",opacity:.6,cursor:"default",color:"#fff",backgroundColor:"#000","-webkit-border-radius":"10px","-moz-border-radius":"10px","border-radius":"10px"},iframeSrc:/^https/i.test(window.location.href||"")?"javascript:false":"about:blank",forceIframe:!1,baseZ:1e3,centerX:!0,centerY:!0,allowBodyStretch:!0,bindEvents:!0,constrainTabKey:!0,fadeIn:200,fadeOut:400,timeout:0,showOverlay:!0,focusInput:!0,focusableElements:":input:enabled:visible",onBlock:null,onUnblock:null,onOverlayClick:null,quirksmodeOffsetHack:4,blockMsgClass:"blockMsg",ignoreIfBlocked:!1};var o=null,u=[]}typeof define=="function"&&define.amd&&define.amd.jQuery?define(["jquery"],e):e(jQuery)})();

function dhvc_form_select_variable(element){
	var select = jQuery(element);
	var field = select.next()[0];
	var value = select.val();
	if(value != ''){
		//IE support
        if (document.selection)
        {
        	field.focus();
            sel = document.selection.createRange();
            sel.text = value;
        }

        //Mozilla/Firefox/Netscape 7+ support
        else if (field.selectionStart || field.selectionStart == '0')
        {
            var startPos = field.selectionStart;
            var endPos = field.selectionEnd;
            field.value = field.value.substring(0, startPos)+ value + field.value.substring(endPos, field.value.length);
        }

        else
        {
        	field.value += value;
        }
	}
	select.focus();
	select.val('');
}

function dhvc_form_select_validator(element){
	var $this = jQuery(element);
	var field = $this.next('input');
	var v = $this.val();
	if(jQuery.isArray(v) && v.length){
		field.val(v.join(',')).attr('value',v.join(','));
	}else{
		field.val('').attr('value','');
	}
}

function dhvc_form_recipient_remove(element){
	var element = jQuery(element);
	element.closest('tr').remove();
	return false;
}

function dhvc_form_recipient_add(element){
	var element = jQuery(element);
	var recipient_table = element.closest('table');
	var name = recipient_table.data('name') + '[]';
	var tmpl = jQuery(dhvc_form_admin.recipient_tmpl);
	tmpl.find('input').attr('name',name);
	recipient_table.append(tmpl);
	return false;
}

function dhvc_form_option_remove(element){
	var $this = jQuery(element);
	$this.closest('tr').remove();
	return false;
}

function dhvc_form_option_add(element){
	var $this = jQuery(element);
	var option_list = $this.closest('.dhvc-form-option-list'),
		option_table = option_list.find('table tbody');
	var tmpl = jQuery(dhvc_form_admin.option_tmpl);
	tmpl.find('input#is_default').attr('type',option_list.data('option-type'));
	option_table.append(tmpl);
	return false;
}

function dhvc_form_conditional_add(element){
	var $this = jQuery(element);
	var conditional_list = $this.closest('.dhvc-form-conditional-list'),
		conditional_table = conditional_list.find('table tbody');
	
	conditional_table.append(dhvc_form_admin.conditional_tmpl);
	return false;
}

function dhvc_form_conditional_remove(element){
	var $this = jQuery(element);
	$this.closest('tr').remove();
	return false;
}

function dhvc_form_paypal_list_remove(element){
	var $this = jQuery(element);
	$this.closest('tr').remove();
	return false;
}

function dhvc_form_paypal_list_add(element){
	var $this = jQuery(element);
	var $list = $this.closest('.dhvc-form-paypal-item-list'),
		$list_table = $list.find('table tbody');
	
	$list_table.append(dhvc_form_admin.paypal_list_tmpl);
	return false;
}


function dhvc_form_conditional_select_type(select){
	var $this = jQuery(select);
	var tr = $this.closest('tr');
	if($this.val() == 'not_empty' || $this.val() == 'is_empty'){
		tr.find('#conditional-value').attr('disabled','disabled');
	}else{
		tr.find('#conditional-value').removeAttr('disabled');
	}
	return false;
}

function dhvc_form_rate_option_add(element){
	var $this = jQuery(element);
	var rate_option_list = $this.closest('.dhvc-form-rate-option-list'),
		rate_option = rate_option_list.find('table tbody');
	var tmpl = jQuery(dhvc_form_admin.rate_option_tmpl);
	tmpl.find('#rate-label').val('Option');
	tmpl.find('#rate-value').val((rate_option.find('tr').length + 1 ) ).closest('td').find('span').text((rate_option.find('tr').length + 1 ));
	rate_option.append(tmpl);
	return false;
}

function dhvc_form_rate_option_remove(element){
	var $this = jQuery(element);	

	var rate_option_list = $this.closest('.dhvc-form-rate-option-list');
	$this.closest('tr').remove();
	var rate_option = rate_option_list.find('table tbody');
	var n = rate_option.find('tr').length;
	if(n > 0){
		 rate_option.find('tr').each(function(i,el){
			 var value = i + 1;
			 jQuery(this).find('#rate-value').val(value).closest('td').find('span').text(value);
		 });
	}
	return false;
}
(function ($) {
	
	$('.dhvcform_options .nav-tab').on('click',function(e){
		e.stopPropagation();
		e.preventDefault();
		var _this = $(this),
			selector = _this.attr('data-target');
		if (!selector) {
			selector = _this.attr('href');
			selector = selector && selector.replace(/.*(?=#[^\s]*$)/, ''); // strip for ie7
		}
		_this.closest('.dhvcform-nav-tab-wrapper').find('.nav-tab-active').removeClass('nav-tab-active');
		_this.addClass('nav-tab-active').trigger('dhvcform_admin_tab_change');
		$('.dhvcform-tab-content').find('.dhvcform-tab-panel').hide();
		$('.dhvcform-tab-content').find(selector).show();
		
	});
	
	$('.dhvcform_options .nav-tab').on('dhvcform_admin_tab_change',function(){
		setting_email($('#email_method'));
		notice_email_type($('select#notice_email_type'));
		notice_email_type($('select#notice_email_type'));
		setting_notice($('input#notice'));
		setting_reply($('input#reply'));
		setting_action($('select#action_type'));
		setting_on_success($('select#on_success'));
		setting_redirect_to($('select#redirect_to'));
		form_action($('select#form_action'));
		setting_popup($('input#form_popup'));
		setting_form_popup_auto_open($('input#form_popup_auto_open'));
	});
	
	var setting_email = function(select){
		var smtp_arr = ['smtp_host','smtp_post','smtp_encryption','smtp_username','smtp_password'];
		if(select.val() == 'default'){
			$.each(smtp_arr,function(index,value){
				$('#'+value).closest('tr').hide();
			});
		}else{
			$.each(smtp_arr,function(index,value){
				$('#'+value).closest('tr').show();
			});
		}
	}
	setting_email($('#email_method'));
	$(document).on('change','#email_method',function(){
		setting_email($(this));
	});
	
	//sender email select
	var notice_email_type = function(select){
		if(select.is(':hidden'))
			return;
		
		var notice_email_field = $('p.notice_email_field');
		var notice_variables_field = $('p.notice_variables_field');
		notice_email_field.hide();
		notice_variables_field.hide();
		if(select.val() == 'email_text'){
			notice_email_field.show();
		}else if(select.val() == 'email_field'){
			notice_variables_field.show();
		}
	}
	notice_email_type($('select#notice_email_type'));
	$(document).on('change','select#notice_email_type',function(){
		notice_email_type($(this));
	})
	
	var setting_notice = function(checkbox){
		var notice_arr  = ['notice_name_field','notice_email_type_field','notice_variables_field','notice_email_field','notice_recipients_field','notice_reply_to_field','notice_subject_field','notice_body_field','notice_html_field'];
		$.each(notice_arr,function(index,value){
			$('.'+value).hide();
		});
		if(checkbox.is(':checked')){
			$.each(notice_arr,function(index,value){
				$('.'+value).show();
			});
		}
		notice_email_type($('select#notice_email_type'));
	}
	setting_notice($('input#notice'));
	$(document).on('click','input#notice',function(){
		setting_notice($(this));
	});
	
	
	var setting_reply = function(checkbox){
		var notice_arr  = ['reply_name_field','reply_email_field','reply_recipients_field','reply_subject_field','reply_body_field','reply_html_field'];
		$.each(notice_arr,function(index,value){
			$('p.'+value).hide();
		});
		if(checkbox.is(':checked')){
			$.each(notice_arr,function(index,value){
				$('p.'+value).show();
			});
		}
	}
	setting_reply($('input#reply'));
	$(document).on('click','input#reply',function(){
		setting_reply($(this));
	});
	
	var setting_action = function(select){
		if(select.val() == 'default'){
			$('p.action_url_field').hide();
			$('p.form_action_field').show();
		}else{
			$('p.form_action_field').hide();
			$('p.action_url_field').show();
		}
	}
	setting_action($('select#action_type'));
	$(document).on('change','select#action_type',function(){
		setting_action($(this));
	});
	var setting_on_success = function(select){
		var message_field = $('p.message_field');
		var message_position_field = $('p.message_position_field');
		var redirect_to_field = $('p.redirect_to_field');
		redirect_to_field.hide();
		message_field.hide();
		message_position_field.hide();
		if(select.val() == 'redirect'){
			redirect_to_field.show();
			$('select#redirect_to').trigger('change');
		}else{
			message_field.show();
			message_position_field.show();
			var page_field = $('p.page_field');
			var post_field = $('p.post_field');
			var url_field  = $('p.url_field');
			page_field.hide();
			post_field.hide();
			url_field.hide();
			
		}
		
	}
	setting_on_success($('select#on_success'));
	$(document).on('change','select#on_success',function(){
		setting_on_success($(this));
	})
	
	var setting_redirect_to = function(select){
		if(select.is(':hidden'))
			return;
		
		var page_field = $('p.page_field');
		var post_field = $('p.post_field');
		var url_field  = $('p.url_field');
		page_field.hide();
		post_field.hide();
		url_field.hide();
		if(select.val() == 'to_page'){
			page_field.show();
		}else if(select.val() == 'to_post'){
			post_field.show();
		}else{
			url_field.show();
		}
	}
	
	setting_redirect_to($('select#redirect_to'));
	$(document).on('change','select#redirect_to',function(){
		setting_redirect_to($(this));
	})
	
	//form action select
	var form_action = function(select){
		if(select.is(':hidden'))
			return;
		
		var mailpoet_field = $('p.mailpoet_field');
			mailpoet_field.hide(),
			mymail_field = $('p.mymail_field'),
			mymail_double_opt_in = $('p.mymail_double_opt_in_field');
			mailpoet_field.hide();
			mymail_field.hide();
			mymail_double_opt_in.hide();
		if(select.val() == 'mailpoet'){
			mailpoet_field.show();
		}else if(select.val() == 'mymail'){
			mymail_field.show();
			mymail_double_opt_in.show();
		}
	}
	
	form_action($('select#form_action'));
	$(document).on('change','select#form_action',function(){
		form_action($(this));
	})
	
	var setting_popup = function(checkbox){
		var popup_arr  = ['form_popup_title_field','form_popup_width_field','form_popup_labelpopup_field','form_popup_auto_open_field','form_popup_auto_open_delay_field','form_popup_auto_close_field','form_popup_auto_close_delay_field','form_popup_one_field'];
		$.each(popup_arr,function(index,value){
			$('p.'+value).hide();
		});
		if(checkbox.is(':checked')){
			$.each(popup_arr,function(index,value){
				$('p.'+value).show();
			});
		}
	}
	setting_popup($('input#form_popup'));
	$(document).on('click','input#form_popup',function(){
		setting_popup($(this));
	});
	
	var setting_form_popup_auto_open = function(checkbox){
		if(checkbox.is(':hidden'))
			return;
		
		var show_arr = ['form_popup_auto_open_delay_field','form_popup_auto_close_field','form_popup_auto_close_delay_field','form_popup_one_field'];
		if(checkbox.is(':checked')){
			$.each(show_arr,function(index,value){
				$('p.'+value).show();
			});
		}else{
			$.each(show_arr,function(index,value){
				$('p.'+value).hide();
			});
		}
	}
	setting_form_popup_auto_open($('input#form_popup_auto_open'));
	$(document).on('click','input#form_popup_auto_open',function(){
		setting_form_popup_auto_open($(this));
	});
	
	
	$(document).on('click','.dhvc-form-entry-list .submitdelete',function(){
		return confirm(dhvc_form_admin.delete_confirm);
	});
	
	$(document).on('click','a#dhvc_form_submitdelete',function(){
		return confirm(dhvc_form_admin.delete_confirm);
	});
	
	$('.dhvc-form-action,.dhvc-form-action2').click(function(){
		var action = $(this).closest('.bulkactions').find('select');
		if ($(this).closest('form').find('input[name="entry[]"]:checked').length > 0) {
			if (action.val() == 'delete') {
				return confirm(dhvc_form_admin.delete_confirm);
			}
		} else {
			return false;
		}
	});
	
	$('.dhvc-form-entry-select-action').change(function(){
		$('#dhvc_form_entry').submit();
	});
	
	$('#dhvcform-actions input, #dhvcform-actions a').click(function(){
		window.onbeforeunload = '';
	});
	
	$('#entry_note_form #add_note').click(function(e){
		$('#entry_note_form  #action').val('add_note');
		$('#entry_note_box').block({ message: null, overlayCSS: { background: '#fff url(' + dhvc_form_admin.plugin_url + '/assets/images/ajax-loader.gif) no-repeat center', opacity: 0.6 } });
		
		$.post(window.location,$('#entry_note_form').serialize(),function(){
			window.location = window.location.href;
		});
		return false;
	});
	
	$('#entry_note_form #delete_note').click(function(e){
		$('#entry_note_form  #action').val('delete_note');
		$('#entry_note_form  #note_id').val($(this).data('note-id'));
		$('#entry_note_box').block({ message: null, overlayCSS: { background: '#fff url(' + dhvc_form_admin.plugin_url + '/assets/images/ajax-loader.gif) no-repeat center', opacity: 0.6 } });
		
		$.post(window.location,$('#entry_note_form').serialize(),function(){
			window.location = window.location.href;
		});
		return false;
	});
	
})(window.jQuery);