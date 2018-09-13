! function($) {
	window.DHVCFormStepsView = window.VcBackendTtaTabsView.extend({
        defaultSectionTitle: window.dhvc_form_vc_custom_view.step_title,
        addSection: function(prepend) {
            var newTabTitle, params;
            var tabs_count = this.$el.find('.vc_tta-tabs-list [data-element_type=dhvc_form_step]').length
            return newTabTitle = this.defaultSectionTitle, params = {
                shortcode: "dhvc_form_step",
                params: {
                    title: newTabTitle + ' ' + tabs_count
                },
                parent_id: this.model.get("id"),
                order: _.isBoolean(prepend) && prepend ? vc.add_element_block_view.getFirstPositionIndex() : vc.shortcodes.getNextOrder(),
                prepend: prepend
            }, vc.shortcodes.create(params)
        },
    });
	window.DHVCFormStepView = window.VcBackendTtaSectionView.extend();
}(window.jQuery);