<?php
class DHVCForm_DB {
	
	protected static $_instance = null;
	
	public function __construct(){
		
	}
	
	public function get_form_entry_data_table_name(){
		global $wpdb;
		return $wpdb->prefix . 'dhvc_form_entry_data';
	}
	
	public function get_form_entry_note_table_name(){
		global $wpdb;
		return $wpdb->prefix . 'dhvc_form_entry_note';
	}
	
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function create_table(){
		// Create the database table
		global $wpdb;
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		$form_entry_data_table = $this->get_form_entry_data_table_name();
		$form_entry_note_table = $this->get_form_entry_note_table_name();
		
		$collate = '';
		
		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( ! empty($wpdb->charset ) ) {
				$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if ( ! empty($wpdb->collate ) ) {
				$collate .= " COLLATE $wpdb->collate";
			}
		}
		
		$sql = "CREATE TABLE $form_entry_data_table (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			form_id bigint(20) UNSIGNED NOT NULL,
			post_id bigint(20) UNSIGNED NOT NULL,
			user_id bigint(20) UNSIGNED NOT NULL,
			form_url varchar(512) NOT NULL,
        	referer varchar(512) NOT NULL,
			entry_data longtext NOT NULL,
			readed tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
			submitted datetime NOT NULL,
			ip_address varchar(32) NOT NULL,
			PRIMARY KEY  (id)
		) " . $collate . ";";
		dbDelta($sql);
		
		$sql = "CREATE TABLE $form_entry_note_table (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			entry_id bigint(20) UNSIGNED NOT NULL,
			user_id bigint(20) UNSIGNED NOT NULL,
			message text NOT NULL,
			created datetime NOT NULL,
			PRIMARY KEY  (id)
		) " . $collate . ";";
		
		dbDelta($sql);
	}
	
	public function drop_table(){
		// Remove the forms tables
		global $wpdb;
		$wpdb->query('DROP TABLE IF EXISTS ' . $this->get_form_entry_data_table_name());
		$wpdb->query('DROP TABLE IF EXISTS ' . $this->get_form_entry_note_table_name());
	}
	
	public function insert_entry_data($data){
		global $wpdb;
		return $wpdb->insert( $this->get_form_entry_data_table_name(), $data);
	}
	
	public function insert_entry_note($data){
		global $wpdb;
		return $wpdb->insert( $this->get_form_entry_note_table_name(), $data);
	}
	
	public function get_entries($form_id = 0,$orderby='submitted',$order='desc',$limit = 10,$offset=0){
		global $wpdb;
		$sql = "";
		$sql .= "SELECT * FROM `" . $this->get_form_entry_data_table_name() . "` `entries` ";
		if($form_id > 0){
			$sql .= "WHERE `entries`.`form_id` = $form_id ";
		}
		
		$sql .="ORDER BY `$orderby` $order ";
		if($limit > 0)
			$sql .="LIMIT $limit OFFSET $offset ";
		
		return $wpdb->get_results($sql);
	}
	
	public function get_entry_notes($entry_id = 0,$orderby='created',$order='desc'){
		global $wpdb;
		$sql = "";
		$sql .= "SELECT * FROM `" . $this->get_form_entry_note_table_name() . "` `notes` ";
		$sql .= "WHERE `notes`.`entry_id` = $entry_id ";
		$sql .="ORDER BY `$orderby` $order ";
		return $wpdb->get_results($sql);
	}
	
	public function get_entry($entry_id=0){
		global $wpdb;
		$sql = "";
		$sql .= "SELECT * FROM `" . $this->get_form_entry_data_table_name() . "` `entries` ";
		if($entry_id > 0){
			$sql .= "WHERE `entries`.`id` = $entry_id ";
		}
		return $wpdb->get_row($sql);
	}
	
	public function get_entry_note($note_id=0){
		global $wpdb;
		$sql = "";
		$sql .= "SELECT * FROM `" . $this->get_form_entry_note_table_name() . "` `notes` ";
		$sql .= " WHERE `notes`.`id` = $note_id ";
		return $wpdb->get_row($sql);
	}
	
	public function get_entries_count($form_id=0){
		global $wpdb;
		$sql = "";
		$sql .= "SELECT COUNT(*) FROM `" . $this->get_form_entry_data_table_name() . "`";
		if($form_id > 0){
			$sql .= "WHERE `form_id` = $form_id";
		}
		return $wpdb->get_var($sql);
	}
	
	public function read_entry($entry_ids){
		global $wpdb;
		$count = 0;
		foreach ((array) $entry_ids as $entry_id) {
			$sql = "UPDATE " . $this->get_form_entry_data_table_name() . " SET `readed` = 1 WHERE id = %d";
			$result = $wpdb->query($wpdb->prepare($sql, $entry_id));
			$count += (int) $result;
		}
		return $count;
	}
	
	public function unread_entry($entry_ids){
		global $wpdb;
		$count = 0;
		foreach ((array) $entry_ids as $entry_id) {
			$sql = "UPDATE " . $this->get_form_entry_data_table_name() . " SET `readed` = 0 WHERE id = %d";
			$result = $wpdb->query($wpdb->prepare($sql, $entry_id));
			$count += (int) $result;
		}
		return $count;
	}
	public function delete_entry($entry_ids){
		global $wpdb;
		$count = 0;
		foreach ((array) $entry_ids as $entry_id) {
			$sql = "DELETE FROM " .  $this->get_form_entry_data_table_name() . " WHERE id = %d";
			$result = $wpdb->query($wpdb->prepare($sql, $entry_id));
			$count += (int) $result;
		}
		return $count;
	}
	
	public function delete_entry_note($note_id){
		global $wpdb;
		$count = 0;
		$sql = "DELETE FROM " .  $this->get_form_entry_note_table_name() . " WHERE id = %d";
		$result = $wpdb->query($wpdb->prepare($sql, $note_id));
		return $result;
	}
	
	public function delete_entry_by_form($form_id){
		global $wpdb;
		$sql = "DELETE FROM " .  $this->get_form_entry_data_table_name() . " WHERE form_id = %d";
		return $wpdb->query($wpdb->prepare($sql, $form_id));
	}
}

global $dhvcform_db;
$dhvcform_db = DHVCForm_DB::instance();