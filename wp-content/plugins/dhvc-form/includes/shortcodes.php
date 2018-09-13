<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class WPBakeryShortCode_DHVC_Form extends WPBakeryShortCode
{
    protected $_messages;
    
    public function loadTemplate($atts, $content = null)
    {
        global $dhvc_form;
        
        $output = '';
        extract(shortcode_atts(array(
            'id' => ''
        ), $atts));
        if (empty($id))
            return __('No form yet! You should add some...', 'dhvc-form');
        
        $form = get_post($id);
        if (empty($form))
            return __('No form yet! You should add some...', 'dhvc-form');
        
        $dhvc_form = $form;
        
        $method      = get_post_meta($form->ID, '_method', true);
        $action      = '';
        $action_type = get_post_meta($form->ID, '_action_type', true);
        $form_attr_class = array();
        $form_attr_class[] = 'dhvcform dhvcform-'.$form->ID;
        if ($action_type === 'external_url'){
            $action = get_post_meta($form->ID, '_action_url', true);
            $form_attr_class[] = 'dhvcform-action-external-url';
        }else{
        	$form_attr_class[] = 'dhvcform-action-default';
        }
        
        if ($form && $form->post_status === 'publish' && apply_filters('dhvc_form_display', true, $form->ID)) {
         	
            do_action('dhvcform_before_render_form', $form);
            
            wp_enqueue_style('js_composer_front');
            wp_enqueue_style('js_composer_custom_css');
            wp_enqueue_script('dhvc-form-jquery-cookie');
            wp_enqueue_script('dhvc-form');
            
            if($generate_css = dhvc_form_generate_css($form)){
            	$output .= '<style type="text/css">'.$generate_css.'</style>';
            }
            $_message_position = get_post_meta($form->ID, '_message_position', true);
            if(dhvc_form_has_shortcode($form, 'dhvc_form_steps'))
            	$_message_position = 'bottom';
            $output .= '<div id="dhvcform-' . $form->ID . '"  class="dhvc-form-container dhvc-form-icon-pos-' . get_post_meta($form->ID, '_input_icon_position', true) . ' dhvc-form-' . get_post_meta($form->ID, '_form_layout', true) . ' dhvc-form-flat">' . "\n";
            $use_ajax     = true;
            $form_message = '';
            if(!dhvc_form_has_shortcode($form,'dhvc_form_response')){
	            $form_message = '<div class="dhvc-form-message dhvc-form-message-'.$_message_position.'" style="display:none"></div>' . "\n";
            }
            if ($_message_position !== 'bottom') {
                $output .= $form_message;
            }
            
            $output .= '<form novalidate data-scroll_to_msg="' . apply_filters('dhvc_form_attr_scroll_to_msg', 1, $form->ID) . '" data-ajax_reset_submit="' . apply_filters('dhvc_form_attr_ajax_reset_submit', 1, $form->ID) . '" data-popup="' . (get_post_meta($form->ID, '_form_popup', true) ? '1' : '0') . '" autocomplete="off" data-use-ajax="' . (int) $use_ajax . '" method="' . $method . '" class="'.implode(' ', $form_attr_class).'" enctype="' . apply_filters('dhvc_form_attr_enctype', 'multipart/form-data', $form->ID) . '" target="' . apply_filters('dhvc_form_attr_target', '_self', $form->ID) . '" ' . (!empty($action) ? ' action="' . $action . '"' : '') . '>' . "\n";
           
            $output .= '<div class="dhvc-form-inner">' . "\n";
            if(defined('DHVC_FORM_IS_FRONTEND_EDITOR'))
            	$output .= dhvc_form_remove_wpautop(apply_filters('the_content',$form->post_content));
            else
            	$output .= dhvc_form_remove_wpautop(dhvc_form_fixPContent($form->post_content));
            $output .= '</div>';
            
            if (!defined('DHVC_FORM_IS_FRONTEND_EDITOR') && !dhvc_form_has_submit_shortcode($form)) {
                $output .= '<div class="dhvc-form-action">' . "\n";
                $form_button = '<button type="submit" class="button dhvc-form-submit"><span class="dhvc-form-submit-label">' . __('Submit', 'dhvc-form') . '</span><span class="dhvc-form-submit-spinner"></span></button>';
                $form_button = apply_filters('dhvc_form_action', $form_button, $form->ID);
                $output .= $form_button . "\n";
                $output .= '</div>' . "\n";
            }
            if ($_message_position === 'bottom') {
                $output .= $form_message;
            }
            if ($method === 'post') {
            	$output .= '<div style="display: none;">' . "\n";
            	if ($use_ajax) {
            		$output .= '<input type="hidden" name="action" value="dhvc_form_ajax">' . "\n";
            	}
            	if ($action_type === 'default') {
            		$form_action = get_post_meta($form->ID, '_form_action', true);
            		if (in_array($form_action, dhvc_form_get_actions())) {
            			$output .= '<input type="hidden" name="_dhvc_form_action" value="' . $form_action . '">' . "\n";
            		}
            	}
            	if(dhvc_form_has_shortcode($form, 'dhvc_form_steps')){
	            	if(!class_exists('WPBakeryShortCode_VC_Tta_Section'))
	            		VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Tta_Section' );
	            	$output .= '<input type="hidden" id="_dhvc_form_current_step" name="_dhvc_form_current_step" value="1">' . "\n";
	            	$output .= '<input type="hidden" id="_dhvc_form_steps" name="_dhvc_form_steps" value="'.WPBakeryShortCode_VC_Tta_Section::$self_count.'">' . "\n";
            	}
            	$output .= '<input type="hidden" id="_dhvc_form_hidden_fields" name="_dhvc_form_hidden_fields" value="">' . "\n";
            	$output .= '<input type="hidden" name="_dhvc_form_id" value="' . $form->ID . '">' . "\n";
            	$output .= '<input type="hidden" name="_dhvc_form_url" value="' . esc_attr(dhvc_form_get_current_url()) . '">' . "\n";
            	$output .= '<input type="hidden" name="_dhvc_form_referer" value="' . esc_attr(dhvc_form_get_http_referer()) . '">' . "\n";
            	$output .= '<input type="hidden" name="_dhvc_form_post_id" value="' . get_the_ID() . '">' . "\n";
            	$output .= '<input type="hidden" name="_dhvc_form_nonce" value="' . wp_create_nonce('dhvc-form-' . $form->ID) . '">' . "\n";
            	$output .= '</div>' . "\n";
            }
            $output .= '</form>' . "\n";
            $output .= '</div>' . "\n";
            
            $output .= $this->_edit_form_link($id);
            
            do_action('dhvcform_after_render_form', $form);
            return apply_filters('dhvcform_render_form_output', $output, $form);
        }
        return __('No form yet! You should add some...', 'dhvc-form');
    }
    
    protected function _edit_form_link($id)
    {
        if (!apply_filters('dhvc_form_show_edit_form_link', true))
            return;
        
        if (!$form = get_post($id))
            return;
        
        
        $action = '&amp;action=edit';
        
        $form_type_object = get_post_type_object($form->post_type);
        if (!$form_type_object)
            return;
        
        if (!current_user_can('edit_dhvcform', $form->ID))
            return;
        
        $url  = admin_url(sprintf($form_type_object->_edit_link . $action, $form->ID));
        $link = '<div class="edit-link" style="margin-top: 10px; text-align: right;"><a class="post-edit-link" href="' . $url . '">' . __('Edit Form', 'dhvc-form') . '</a></div>';
        return $link;
    }
}

class DHVC_Form_ShortCode extends WPBakeryShortCode
{
    /**
     * Find html template for shortcode output.
     */
    protected function findShortcodeTemplate()
    {
        // Check template path in shortcode's mapping settings
        if (!empty($this->settings['html_template']) && is_file($this->settings('html_template'))) {
            return $this->setTemplate($this->settings['html_template']);
        }
        // Check template in theme directory
        $user_template = vc_manager()->getShortcodesTemplateDir($this->getFilename() . '.php');
        if (is_file($user_template)) {
            return $this->setTemplate($user_template);
        }
        // Check default place
        $default_dir = DHVC_FORM_TEMPLATE_DIR;
        if (is_file($default_dir . $this->getFilename() . '.php')) {
            return $this->setTemplate($default_dir . $this->getFilename() . '.php');
        }
    }
    
    protected function getFileName()
    {
        return $this->shortcode;
    }
    
    protected function loadTemplate($atts, $content = null)
    {
        return parent::loadTemplate($atts, $content);
    }
    
    protected function getControlName($control_name=''){
    	return esc_attr(trim($control_name));
    }
}

class WPBakeryShortCode_DHVC_Form_Text extends DHVC_Form_ShortCode
{
    
}

class WPBakeryShortCode_DHVC_Form_Label extends DHVC_Form_ShortCode
{
    
}
class WPBakeryShortCode_DHVC_Form_Rate extends DHVC_Form_ShortCode
{
    
}
class WPBakeryShortCode_DHVC_Form_Slider extends DHVC_Form_ShortCode
{
    
}
class WPBakeryShortCode_DHVC_Form_Email extends DHVC_Form_ShortCode
{
    
}

class WPBakeryShortCode_DHVC_Form_Password extends DHVC_Form_ShortCode
{
    protected function loadTemplate($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'confirmation' => '',
            'password_field' => ''
        ), $atts), EXTR_SKIP);
        if (!empty($confirmation) && empty($password_field))
            return __('Passwords field name to validate match is required', 'dhvc-form');
        
        return parent::loadTemplate($atts, $content);
    }
}

class WPBakeryShortCode_DHVC_Form_Hidden extends DHVC_Form_ShortCode
{
    
}

class WPBakeryShortCode_DHVC_Form_reCaptcha extends DHVC_Form_ShortCode
{
    public function loadTemplate($atts, $content = null)
    {
        $recaptcha_public_key = dhvc_form_get_option('recaptcha_public_key', false);
        if (!$recaptcha_public_key) {
            return __('ReCaptcha plugin needs a public key to be set in its parameters. Please contact a site administrator.', 'dhvc-form');
        }
        return parent::loadTemplate($atts, $content);
    }
}
class WPBakeryShortCode_DHVC_Form_Captcha extends DHVC_Form_ShortCode
{
    
}
class WPBakeryShortCode_DHVC_Form_DateTime extends DHVC_Form_ShortCode
{
    
}

class WPBakeryShortCode_DHVC_Form_Color extends DHVC_Form_ShortCode
{
    
}

class WPBakeryShortCode_DHVC_Form_Radio extends DHVC_Form_ShortCode
{
    
}
class WPBakeryShortCode_DHVC_Form_Checkbox extends DHVC_Form_ShortCode
{
    
}
class WPBakeryShortCode_DHVC_Form_File extends DHVC_Form_ShortCode
{
    
}
class WPBakeryShortCode_DHVC_Form_Select extends DHVC_Form_ShortCode
{
    
}
class WPBakeryShortCode_DHVC_Form_Multiple_Select extends WPBakeryShortCode_DHVC_Form_Select
{
    protected function getFileName()
    {
        return 'dhvc_form_select';
    }
}
class WPBakeryShortCode_DHVC_Form_Textarea extends DHVC_Form_ShortCode
{
    
}

class WPBakeryShortCode_DHVC_Form_Submit_Button extends DHVC_Form_ShortCode
{
    
}

class WPBakeryShortCode_DHVC_Form_Response extends DHVC_Form_ShortCode
{

}

class WPBakeryShortCode_DHVC_Form_Paypal extends DHVC_Form_ShortCode
{

}

VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Tta_Tabs' );
VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Tta_Section' );

class WPBakeryShortCode_DHVC_Form_Steps extends WPBakeryShortCode_VC_Tta_Tabs{
	protected $controls_list = array(
		'add',
// 		'edit',
// 		'clone',
		'delete',
	);
	public $layout = 'tabs';
	public function getWrapperAttributes() {
		$attributes = array();
		$attributes[] = 'class="' . esc_attr( $this->getTtaContainerClasses() ) . '"';
		$attributes[] = 'data-vc-action="collapse"';
	
		if ( ! empty( $this->atts['el_id'] ) ) {
			$attributes[] = 'id="' . esc_attr( $this->atts['el_id'] ) . '"';
		}
	
		return implode( ' ', $attributes );
	}
	
	public function getParamTabsListTop( $atts, $content ) {
		return $this->getParamTabsList( $atts, $content );
	}
	
	
	protected function findShortcodeTemplate()
	{
		if($this->isInline() || vc_is_page_editable())
			return parent::findShortcodeTemplate();
		// Check template path in shortcode's mapping settings
		if (!empty($this->settings['html_template']) && is_file($this->settings('html_template'))) {
			return $this->setTemplate($this->settings['html_template']);
		}
		// Check template in theme directory
		$user_template = vc_manager()->getShortcodesTemplateDir($this->getFilename() . '.php');
		if (is_file($user_template)) {
			return $this->setTemplate($user_template);
		}
		// Check default place
		$default_dir = DHVC_FORM_TEMPLATE_DIR;
		if (is_file($default_dir . $this->getFilename() . '.php')) {
			return $this->setTemplate($default_dir . $this->getFilename() . '.php');
		}
	}
	public function getFileName()
	{
		if($this->isInline() || vc_is_page_editable())
			return parent::getFileName();
		
		return $this->shortcode;
	}
}

class WPBakeryShortCode_DHVC_Form_Step extends WPBakeryShortCode_VC_Tta_Section{
	public function getParamIcon( $atts, $content ) {
		return null;
	}
	public function getParamIconLeft( $atts, $content ) {
		return null;
	}
	public function getParamIconRight( $atts, $content ) {
		return null;
	}
	
	
   protected function findShortcodeTemplate()
	{
		if($this->isInline() || vc_is_page_editable())
			return parent::findShortcodeTemplate();
		// Check template path in shortcode's mapping settings
		if (!empty($this->settings['html_template']) && is_file($this->settings('html_template'))) {
			return $this->setTemplate($this->settings['html_template']);
		}
		// Check template in theme directory
		$user_template = vc_manager()->getShortcodesTemplateDir($this->getFilename() . '.php');
		if (is_file($user_template)) {
			return $this->setTemplate($user_template);
		}
		// Check default place
		$default_dir = DHVC_FORM_TEMPLATE_DIR;
		if (is_file($default_dir . $this->getFilename() . '.php')) {
			return $this->setTemplate($default_dir . $this->getFilename() . '.php');
		}
	}
	public function getFileName()
	{
		if($this->isInline() || vc_is_page_editable())
			return parent::getFileName();
		
		return $this->shortcode;
	}
}