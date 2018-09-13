<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
function dhvc_form_field_steps_params(){
	return array(
        "name" => __("Form Steps", 'dhvc-form'),
        "base" => "dhvc_form_steps",
		"category" => __("Form Control", 'dhvc-form'),
		"icon" => "icon-dhvc-form-section icon-dhvc-form-textarea",
		'is_container' => true,
		'show_settings_on_create' => false,
		'as_parent' => array(
			'only' => 'dhvc_form_step',
		),
		'description' => __( 'Form steps section', 'dhvc-form' ),
		'custom_markup' => '
			<div class="vc_tta-container" data-vc-action="collapse">
				<div class="vc_general vc_tta vc_tta-tabs vc_tta-color-backend-tabs-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-spacing-1 vc_tta-tabs-position-top vc_tta-controls-align-left">
					<div class="vc_tta-tabs-container">'
						. '<ul class="vc_tta-tabs-list">'
								. '<li class="vc_tta-tab" data-vc-tab data-vc-target-model-id="{{ model_id }}" data-element_type="dhvc_form_step"><a href="javascript:;" data-vc-tabs data-vc-container=".vc_tta" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-target-model-id="{{ model_id }}"><span class="vc_tta-title-text">{{ section_title }}</span></a></li>'
									. '</ul>
					</div>
					<div class="vc_tta-panels vc_clearfix {{container-class}}">
					  {{ content }}
					</div>
				</div>
			</div>
		',
		'js_view' => 'DHVCFormStepsView',
		'default_content' => '
			[dhvc_form_step title="' . sprintf( '%s %d', __( 'Step', 'js_composer' ), 1 ) . '"][/dhvc_form_step]
			[dhvc_form_step title="' . sprintf( '%s %d', __( 'Step', 'js_composer' ), 2 ) . '"][/dhvc_form_step]
		',
		'admin_enqueue_js' => array(
			vc_asset_url( 'lib/vc_tabs/vc-tabs.min.js' ),
		),
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Label", 'dhvc-form'),
                "param_name" => "label",
                'value' => __('Steps', 'dhvc-form'),
            ),
            array(
				'type' => 'textfield',
				'param_name' => 'active_section',
				'heading' => __( 'Active section', 'js_composer' ),
				'value' => 1,
				'description' => __( 'Enter active section number (Note: to have all sections closed on initial load enter non-existing number).', 'dhvc-form' ),
			),
        )
    );
}