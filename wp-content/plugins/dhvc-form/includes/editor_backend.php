<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once vc_path_dir( 'EDITORS_DIR', 'class-vc-backend-editor.php' );

class DHVCForm_Editor_Backend extends Vc_Backend_Editor {
	protected static $post_type = 'dhvcform';
	protected $templates_editor = false;
	protected static $predefined_templates = false;
	
	public function editorEnabled() {
		return true;
	}
	
	public function renderEditor( $post = null ) {
		/**
		 * TODO: setter/getter for $post
		 */
		if ( ! is_object( $post ) || 'WP_Post' !== get_class( $post ) || ! isset( $post->ID ) ) {
			return false;
		}
		$this->post = $post;
		$post_custom_css = strip_tags( get_post_meta( $post->ID, '_wpb_post_custom_css', true ) );
		$this->post_custom_css = $post_custom_css;
		dhvc_form_include_editor_template( 'editor_backend.tpl.php', array(
			'editor' => $this,
			'post' => $this->post,
		) );
		add_action( 'admin_footer', array(
			$this,
			'renderEditorFooter',
		) );
		do_action( 'vc_backend_editor_render' );
	
		return true;
	}
	
	public function renderEditorFooter() {
		dhvc_form_include_editor_template( 'editor_backend_footer.tpl.php', array(
			'editor' => $this,
			'post' => $this->post,
		) );
		do_action( 'vc_backend_editor_footer_render' );
	}
	
	public function registerBackendJavascript() {
		parent::registerBackendJavascript();
		wp_register_script('dhvc_form_vc_edit_form',DHVC_FORM_URL.'/assets/js/vc-edit-form.js',array('vc-backend-min-js'),DHVC_FORM_VERSION,true);
		wp_register_script('dhvc_form_vc_custom_view',DHVC_FORM_URL.'/assets/js/vc-custom-view.js',array('vc-backend-min-js'),DHVC_FORM_VERSION,true);
		wp_register_style('dhvc_form_vc',DHVC_FORM_URL.'/assets/css/vc.css');
	}
	
	public function enqueueJs() {
		parent::enqueueJs();
		wp_enqueue_script( 'dhvc_form_vc_edit_form' );
		wp_localize_script('dhvc_form_vc_custom_view', 'dhvc_form_vc_custom_view', array(
			'step_title'=>__('Step','dhvc_form')
		));
		wp_enqueue_script('dhvc_form_vc_custom_view');
		wp_enqueue_style('dhvc_form_vc');
	}
	
	public function isValidPostType( $type = '' ) {
		$type = ! empty( $type ) ? $type : get_post_type();
		return $this->editorEnabled() && $this->postType() === $type;
	}
	
	public static function postType() {
		return self::$post_type;
	}
}