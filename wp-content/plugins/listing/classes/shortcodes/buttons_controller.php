<?php 

class alsp_buttons_controller extends alsp_frontend_controller {

	public function init($args = array()) {
		parent::init($args);

		$shortcode_atts = array_merge(array(
				
		), $args);

		$this->args = $shortcode_atts;

		apply_filters('alsp_frontend_controller_construct', $this);
	}

	public function display() {
		$output =  alsp_frontendRender('frontend/frontpanel_buttons.tpl.php', array('frontend_controller' => $this), true);
		wp_reset_postdata();

		return $output;
	}
}

?>