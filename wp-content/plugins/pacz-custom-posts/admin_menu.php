<?php 

class pacz_admin_menu {
	

	public function __construct() {

		add_action('admin_menu', array($this, 'menu'));
	}
	public function menu() {
		
		add_menu_page(
			esc_html__( 'Classiads Dashborad', 'classiads' ),
			esc_html__( 'Classiads Options', 'classiads' ),
			'manage_options',
			'classiads_settings',
			array($this, 'classiads_dashboard'),
			'',
			0
		);
		add_submenu_page(
			'classiads_settings',
			esc_html__( 'Classiads Dashborad', 'classiads' ),
			esc_html__( 'Classiads Options', 'classiads' ),
			'manage_options',
			'classiads_settings',
			array($this, 'classiads_dashboard'),
			'',
			0
		);
		
		add_submenu_page('classiads_settings', 'Icon Library', 'Icon Library', 'manage_options', 'icon-library', 'icon_library_submenu_page_callback', '', 30);

		if(class_exists('alsp_plugin')){
			$new_content_filed = new alsp_content_fields_manager();
			$new_listing_level = new alsp_levels_manager();
			$new_location_level = new alsp_locations_levels_manager();
			$new_csv_import = new alsp_csv_manager();
			$new_report_abuse = new Di_Report_Abuse();
			
			
			$new_listing_level_menu = $new_listing_level->menu();
			echo $new_listing_level_menu;
			$new_location_level_menu = $new_location_level->menu();
			echo $new_location_level_menu;
			$new_content_filed_menu = $new_content_filed->menu();
			echo $new_content_filed_menu;
			$new_csv_import_menu = $new_csv_import->menu();
			echo $new_csv_import_menu;
			$new_report_abuse_menu = $new_report_abuse->admin_menu();
			echo $new_report_abuse_menu;
		}
	}
	public function classiads_dashboard(){
	}
	
}
new pacz_admin_menu();