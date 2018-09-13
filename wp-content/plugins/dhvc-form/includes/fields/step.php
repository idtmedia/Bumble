<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function dhvc_form_field_step_params(){
		require_once vc_path_dir( 'CONFIG_DIR', 'content/vc-icon-element.php' );
		$icons_params = vc_map_integrate_shortcode( vc_icon_element_params(), 'i_', '', array(
			'include_only_regex' => '/^(type|icon_\w*)/',
			// we need only type, icon_fontawesome, icon_blabla..., NOT color and etc
		));
		if ( is_array( $icons_params ) && ! empty( $icons_params ) ) {
			foreach ( $icons_params as $key => $param ) {
				if ( is_array( $param ) && ! empty( $param ) ) {
					if ( isset( $param['admin_label'] ) ) {
						// remove admin label
						unset( $icons_params[ $key ]['admin_label'] );
					}
				}
			}
		}
	return array(
        "name" => __("Step", 'dhvc-form'),
        "base" => "dhvc_form_step",
		"category" => __("Form Control", 'dhvc-form'),
		"icon" => "icon-dhvc-form-section icon-dhvc-form-textarea",
		'allowed_container_element' => 'vc_row',
		'is_container' => true,
		'show_settings_on_create' => false,
		'as_child' => array(
			'only' => 'dhvc_form_steps',
		),
		'description' => __( 'Step content for Form Steps', 'js_composer' ),
		'js_view' => 'DHVCFormStepView',
		'custom_markup' => '
			<div class="vc_tta-panel-heading">
			    <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left"><a href="javascript:;" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-accordion data-vc-container=".vc_tta-container"><span class="vc_tta-title-text">{{ section_title }}</span><i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i></a></h4>
			</div>
			<div class="vc_tta-panel-body">
				{{ editor_controls }}
				<div class="{{ container-class }}">
				{{ content }}
				</div>
			</div>',
		'default_content' => '',
        "params" => array_merge(
        	array(
        		array(
        			"type" => "textfield",
        			"heading" => __("Title", 'dhvc-form'),
        			"param_name" => "title",
        			'value' => __('Step', 'dhvc-form'),
        		),
        	),
        	$icons_params
        )
    );
}