
(function ( $ ) {
	window.InlineShortcodeView_dhvc_form_steps = window.InlineShortcodeView_vc_tta_tabs.extend( {
		defaultSectionTitle: window.dhvc_form_editor_frontend.step_title
	} );
	window.InlineShortcodeView_dhvc_form_step = window.InlineShortcodeView_vc_tta_section.extend( {
		controls_selector: "#vc_controls-template-dhvc_form_step"
	} )
	
	window.InlineShortcodeView_dhvc_form_datetime = window.InlineShortcodeView.extend( {
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_dhvc_form_datetime.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity(function() {
				vc.frame_window.dhvc_form_iframe.date_time(model_id);
            })
			return this;
		},
		parentChanged: function () {
			window.InlineShortcodeView_dhvc_form_datetime.__super__.parentChanged.call( this );
			vc.frame_window.dhvc_form_iframe.date_time( this.model.get( 'id' ));
		}
	} );
	
	window.InlineShortcodeView_dhvc_form_slider = window.InlineShortcodeView.extend( {
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_dhvc_form_slider.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity(function() {
				vc.frame_window.dhvc_form_iframe.slider(model_id);
            })
			return this;
		},
		parentChanged: function () {
			window.InlineShortcodeView_dhvc_form_slider.__super__.parentChanged.call( this );
			vc.frame_window.dhvc_form_iframe.slider(this.model.get( 'id' ));
		}
	} );
	
	window.InlineShortcodeView_dhvc_form_recaptcha = window.InlineShortcodeView.extend( {
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_dhvc_form_recaptcha.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity(function() {
				vc.frame_window.dhvc_form_iframe.recaptcha(model_id);
            })
			return this;
		},
		parentChanged: function () {
			window.InlineShortcodeView_dhvc_form_recaptcha.__super__.parentChanged.call( this );
			vc.frame_window.dhvc_form_iframe.recaptcha(this.model.get( 'id' ));
		}
	} );
	window.InlineShortcodeView_dhvc_form_color = window.InlineShortcodeView.extend( {
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_dhvc_form_color.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity(function() {
				vc.frame_window.dhvc_form_iframe.minicolor(model_id);
            })
			return this;
		},
		parentChanged: function () {
			window.InlineShortcodeView_dhvc_form_color.__super__.parentChanged.call( this );
			vc.frame_window.dhvc_form_iframe.minicolor(this.model.get( 'id' ));
		}
	} );
	window.InlineShortcodeView_dhvc_form_rate = window.InlineShortcodeView.extend( {
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_dhvc_form_rate.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity(function() {
				vc.frame_window.dhvc_form_iframe.rate(model_id);
            })
			return this;
		},
		parentChanged: function () {
			window.InlineShortcodeView_dhvc_form_rate.__super__.parentChanged.call( this );
			vc.frame_window.dhvc_form_iframe.rate(this.model.get( 'id' ));
		}
	} );
	
	window.InlineShortcodeView_dhvc_form_file = window.InlineShortcodeView.extend( {
		render: function () {
			var model_id = this.model.get( 'id' );
			window.InlineShortcodeView_dhvc_form_file.__super__.render.call( this );
			vc.frame_window.vc_iframe.addActivity(function() {
				vc.frame_window.dhvc_form_iframe.file(model_id);
            })
			return this;
		},
		parentChanged: function () {
			window.InlineShortcodeView_dhvc_form_file.__super__.parentChanged.call( this );
			vc.frame_window.dhvc_form_iframe.file(this.model.get( 'id' ));
		}
	} );
   
    function DHVCFromMapChildEvents(model) {
        vc.events.on("shortcodes:dhvc_form_step:add:parent:" + model.get("id"), function(model) {
            var activeTabIndex, models, parentModel;
            return parentModel = vc.shortcodes.get(model.get("parent_id")), activeTabIndex = parseInt(parentModel.getParam("active_section")), void 0 === activeTabIndex && (activeTabIndex = 1), models = _.pluck(_.sortBy(vc.shortcodes.where({
                parent_id: parentModel.get("id")
            }), function(model) {
                return model.get("order")
            }), "id"), models.indexOf(model.get("id")) === activeTabIndex - 1 && model.set("isActiveSection", !0), model
        })
        vc.events.on("shortcodes:dhvc_form_step:clone:parent:" + model.get("id"), function(model) {
            vc.ttaSectionActivateOnClone && model.set("isActiveSection", !0), vc.ttaSectionActivateOnClone = !1
        })
    };
    vc.events.on("shortcodes:dhvc_form_steps:add", DHVCFromMapChildEvents)
	
})( window.jQuery );