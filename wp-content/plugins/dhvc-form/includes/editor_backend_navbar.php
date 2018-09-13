<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once vc_path_dir( 'EDITORS_DIR', 'navbar/class-vc-navbar.php' );
/**
 * Renders navigation bar for Editors.
 */
class DHVCForm_Editor_Backend_Navbar extends Vc_Navbar {
	protected $controls = array(
		'add_element',
		'templates',
		'save_backend',
		'custom_css',
		'frontend',
		'fullscreen',
		'windowed',
	);
	
	public function getControlFrontend() {
		if(dhvc_form_is_enable_editor_frontend())
			return '<li class="vc_pull-right">'
			. '<a href="'.DHVCForm_Editor_Frontend::getInlineUrl().'" class="vc_btn vc_btn-primary vc_btn-sm vc_navbar-btn" id="wpb-edit-inline">' . __( 'Frontend Builder (beta)', 'dhvc-form' ) . '</a>'
				. '</li>';
		return '';
	}
	
	public function getControlTemplates() {
		return '<li><a href="javascript:;" class="vc_icon-btn vc_templates-button vc_navbar-border-right"  id="dh_popup_templates-editor-button" title="'
			. __( 'Templates', 'dhvc-form' ) . '"><i class="vc-composer-icon vc-c-icon-add_template"></i></a></li>';
	}
	
	public function getControlPreviewTemplate() {
		return '<li class="vc_pull-right">'
			. '<a href="#" class="vc_btn vc_btn-grey vc_btn-sm vc_navbar-btn" data-vc-navbar-control="preview">' . __( 'Preview', 'dhvc-form' ) . '</a>'
				. '</li>';
	}
	
	public function getControlSaveBackend() {
		return '<li class="vc_pull-right vc_save-backend">'
			. '<a class="vc_btn vc_btn-sm vc_navbar-btn vc_btn-primary vc_control-save" id="wpb-save-post">' . __( 'Update', 'dhvc-form' ) . '</a>'
				. '</li>';
	}
}
