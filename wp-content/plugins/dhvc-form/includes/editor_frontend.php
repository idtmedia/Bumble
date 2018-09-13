<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once vc_path_dir( 'EDITORS_DIR', 'class-vc-frontend-editor.php' );

class DHVCForm_Editor_Frontend extends Vc_Frontend_Editor{
	
	public function init(){
		$this->addHooks();
		if(isset($_GET['dhvc_form_editor']) && 'frontend'===$_GET['dhvc_form_editor']){
			remove_all_actions('admin_notices');
			remove_all_actions('network_admin_notices');
			if ( ! defined( 'DHVC_FORM_IS_FRONTEND_EDITOR' ) ) {
				define( 'DHVC_FORM_IS_FRONTEND_EDITOR', true );
			}
			$this->hookLoadEdit();
		}
	}
	
	public static function getInlineUrl( $url = '', $id = '' ) {
		$the_ID = ( strlen( $id ) > 0 ? $id : get_the_ID() );
		return apply_filters( 'dhvc_form_get_inline_url', admin_url() .
			'edit.php?dhvc_form_editor=frontend&post_id=' .
			$the_ID . '&post_type=' . get_post_type( $the_ID ) .
			( strlen( $url ) > 0 ? '&url=' . rawurlencode( $url ) : '' ) );
	}
	
	function render( $template ) {
		if('editor'===$template)
			dhvc_form_include_editor_template('editor_frontend.tpl.php',array( 'editor' => $this ));
		else 	
			vc_include_template( 'editors/frontend_' . $template . '.tpl.php', array( 'editor' => $this ) );
	}
	
}