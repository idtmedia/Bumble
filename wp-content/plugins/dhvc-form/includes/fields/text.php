<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * 
 * @param DHVCForm_Validation $result
 * @param DHVCForm_Field $field
 */
function dhvc_form_field_text_validation_filter($result, $field){
	$name = $field->get_name();
	$value = isset( $_POST[$name] ) ? trim( wp_unslash( strtr( (string) $_POST[$name], "\n", " " ) ) ) : '';
	if($field->is_required() && ''==$value)
		$result->invalidate($field, dhvc_form_get_message('invalid_required'));
	
	$minlenght = absint($field->attr('minlength'));
	if($minlenght > 0 && strlen($value) < $minlenght)
		$result->invalidate($field, dhvc_form_get_message('invalid_too_short'));
	
	if ( '' !== $value ) {
		
		foreach ($field->get_validator() as $validator){
			switch ($validator){
				case 'dhvc-form-validate-date';
					if(!dhvc_form_is_date($value))
						$result->invalidate($field, dhvc_form_get_message('invalid_date'));
				break;
				case 'dhvc-form-validate-number':
					if(!dhvc_form_is_number($value))
						$result->invalidate($field,dhvc_form_get_message('invalid_number'));
				break;
				case 'dhvc-form-validate-number2':
					if(!dhvc_form_is_number2($value))
						$result->invalidate($field, dhvc_form_get_message('invalid_number2'));
				break;
				case 'dhvc-form-validate-digits':
					if(!dhvc_form_is_digits($value))
						$result->invalidate($field, dhvc_form_get_message('invalid_digits'));
				break;
				case 'dhvc-form-validate-alpha':
					if(!dhvc_form_is_alpha($value))
						$result->invalidate($field, dhvc_form_get_message('invalid_alpha'));
				break;
				case 'dhvc-form-validate-alphanum':
					if(!dhvc_form_is_alphanum($value))
						$result->invalidate($field, dhvc_form_get_message('invalid_alphanum'));
				break;
				case 'dhvc-form-validate-url':
					if(!dhvc_form_is_url($value))
						$result->invalidate($field, dhvc_form_get_message('invalid_url'));
				break;
				case 'dhvc-form-validate-zip':
					if(!dhvc_form_is_zip($value))
						$result->invalidate($field,dhvc_form_get_message('invalid_zip'));
				break;
				case 'dhvc-form-validate-fax':
					if(!dhvc_form_is_fax($value))
						$result->invalidate($field,dhvc_form_get_message('invalid_fax'));
				break;
				default:
					if(!apply_filters('dhvc_form_validation_filter', true, $validator, $value))
						$result->invalidate($field,apply_filters('dhvc_form_validation_filter_message', '', $validator, $value));
				break;
			}
		}
	}
	return $result;
	
}
add_filter( 'dhvc_form_validate_text', 'dhvc_form_field_text_validation_filter', 10, 2 );

function dhvc_form_field_text_params(){
	return array(
	    "name" => __("Form Text", 'dhvc-form'),
	    "base" => "dhvc_form_text",
	    "category" => __("Form Control", 'dhvc-form'),
	    "icon" => "icon-dhvc-form-text",
	    "params" => array(
	        array(
	            "type" => "textfield",
	            "heading" => __("Label", 'dhvc-form'),
	            "param_name" => "control_label",
	            'admin_label' => true
	        ),
	        array(
	            "type" => "dhvc_form_name",
	            "heading" => __("Name", 'dhvc-form'),
	            "param_name" => "control_name",
	            'admin_label' => true,
	            "description" => __('Field name is required.  Please enter single word, no spaces, no start with number. Underscores(_) allowed', 'dhvc-form')
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Default value", 'dhvc-form'),
	            "param_name" => "default_value"
	        ),
	    	array(
	    		"type" => "textfield",
	    		"heading" => __("Minimum length characters", 'dhvc-form'),
	    		"param_name" => "minlength"
	    	),
	        array(
	            "type" => "textfield",
	            "heading" => __("Maximum length characters", 'dhvc-form'),
	            "param_name" => "maxlength"
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Placeholder text", 'dhvc-form'),
	            "param_name" => "placeholder"
	        ),
	    	array (
	    		"type" => "dropdown",
	    		"heading" => __ ( "Icon", 'dhvc-form' ),
	    		"param_name" => "icon",
	    		"param_holder_class" => 'dhvc-form-font-awesome',
	    		"value" => dhvc_form_font_awesome(),
	    		'description' => __ ( 'Select icon add-on for this control.', 'dhvc-form' )
	    	),
	        array(
	            "type" => "textarea",
	            "heading" => __("Help text", 'dhvc-form'),
	            "param_name" => "help_text",
	            'description' => __('This is the help text for this form control.', 'dhvc-form')
	        ),
	        array(
	            "type" => "checkbox",
	            "heading" => __("Required ? ", 'dhvc-form'),
	            "param_name" => "required",
	            "value" => array(
	                __('Yes, please', 'dhvc-form') => '1'
	            )
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Read only ? ", 'dhvc-form'),
	            "param_name" => "readonly",
	            "value" => array(
	                __('No', 'dhvc-form') => 'no',
	                __('Yes', 'dhvc-form') => 'yes'
	            )
	        ),
	        array(
	            "type" => "dhvc_form_validator",
	            "heading" => __("Add validator", 'dhvc-form'),
	            "param_name" => "validator",
	            "dependency" => array(
	                'element' => "readonly",
	                'value' => array(
	                    'no'
	                )
	            )
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Attributes", 'dhvc-form'),
	            "param_name" => "attributes",
	            'description' => __('Add attribute for this form control,eg: <em>onclick="" onchange="" </em> or \'<em>data-*</em>\'  attributes HTML5, not in attributes: <span style="color:#ff0000">type, value, name, required, placeholder, maxlength, id</span>', 'dhvc-form')
	        ),
	        
	        array(
	            'type' => 'textfield',
	            'heading' => __('Extra class name', 'dhvc-form'),
	            'param_name' => 'el_class',
	            'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'dhvc-form')
	        ),
	    	array(
	    		'type' => 'css_editor',
	    		'heading' => __( 'CSS box', 'dhvc-form' ),
	    		'param_name' => 'input_css',
	    		'group' => __( 'Design Options', 'dhvc-form' ),
	    	),
	    )
	);
}