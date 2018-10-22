<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class DHVCForm_Submission{
	
	private static $instance;
	private static $fields;
	
	private $_posted_data = array();
	private $_status = 'init';
	private $_response = '';
	private $_invalid_fields = array();
	private $_form_id;
	private $_upload_files = array();
	private $_uploaded_files = array();
	private $_hidden_fields = array();
	private $_meta = array();
	
	public static function get_instance($need_setup=false) {
		if ( empty( self::$instance ) ) {
			self::$instance = new self;
			if($need_setup){
				self::$instance->_setup_posted_data();
				self::$instance->_submit();
			}
		}
		return self::$instance;
	}
	
	public function get_form_id(){
		return $this->_form_id;
	}
	
	public function get_status() {
		return $this->_status;
	}
	
	public function is( $status ) {
		return $this->_status == $status;
	}
	
	public function get_response() {
		return $this->_response;
	}
	
	public function get_meta( $name='') {
		if(!empty($name)){
			if ( isset( $this->_meta[$name] ) ) {
				return $this->_meta[$name];
			}else{
				return null;
			}
		}
		return $this->_meta;
	}
	
	public function get_invalid_field( $name ) {
		if ( isset( $this->_invalid_fields[$name] ) ) {
			return $this->_invalid_fields[$name];
		} else {
			return false;
		}
	}
	
	public function get_invalid_fields() {
		return $this->_invalid_fields;
	}
	
	public function get_posted_data( $name = '' ) {
		if ( ! empty( $name ) ) {
			if ( isset( $this->_posted_data[$name] ) ) {
				return $this->_posted_data[$name];
			} else {
				return null;
			}
		}
	
		return $this->_posted_data;
	}
	
	public function uploaded_files() {
		return $this->_uploaded_files;
	}
	
	
	public function add_upload_files($name,$file){
		$this->_upload_files[$name] = $file;
	}
	
	public function get_form_fields(){
		if(empty(self::$fields))
			self::$fields = dhvc_form_get_post_meta('_form_control',$this->_form_id);
		return self::$fields;
	}
	
	public function get_form_field($name){
		$fields = $this->get_form_fields();
		if(isset($fields[$name]))
			return $fields[$name];
		return false;
	}
	
	public function get_on_ok(){
		$additional_setting = get_post_meta($this->_form_id,'_additional_setting',true);
		$additional_setting = dhvc_form_additional_setting('on_sent_ok', $additional_setting,false);
		$additional_setting = apply_filters('dhvc_form_on_sent_ok', $additional_setting, $this);
		if(!empty($additional_setting)){
			return array_map('dhvc_form_strip_quote', $additional_setting );
		}
		return false;
	}
	
	public function get_redirect_url(){
		$on_success = get_post_meta($this->_form_id,'_on_success',true);
		if('redirect'!==$on_success)
			return false;
		$redirect_to = get_post_meta($this->_form_id,'_redirect_to',true);
		$redirect_url = '';
		if($redirect_to === 'to_url'){
			$redirect_url = get_post_meta($this->_form_id,'_url',true);
		}else{
			if($redirect_to === 'to_page'){
				$redirect_url = get_permalink(get_post_meta($this->_form_id,'_page',true));
			}else{
				$redirect_url = get_permalink(get_post_meta($this->_form_id,'_post',true));
			}
		}

		return $redirect_url;
	}
	
	private function _form_step_add_files(){
		$fields =$this->get_form_fields();
		foreach ($fields as $field){
			if('dhvc_form_file'!==$field['tag'])
				continue;
			$name = $field['control_name'];
			$file = isset( $_FILES[$name] ) ? $_FILES[$name] : null;
			if(is_uploaded_file( $file['tmp_name'] ))
				$this->add_upload_files($name, $file);
		}
		return $this->_upload_files();
	}
	
	private function _upload_files(){
		$uploaded_files = array();
		if(!empty($this->_upload_files)){
			if(!dhvc_form_init_uploads())
				return false;
			$uploads_dir = dhvc_form_upload_tmp_dir();
			foreach ((array)$this->_upload_files as $name=>$file){
				$filename = $file['name'];
				$filename = dhvc_form_canonicalize( $filename, 'as-is' );
				$filename = sanitize_file_name( $filename );
				$filename = dhvc_form_antiscript_file_name( $filename );
				$filename = wp_unique_filename( $uploads_dir, $filename );
				
				$new_file = trailingslashit( $uploads_dir ) . $filename;
				
				if ( false === @move_uploaded_file( $file['tmp_name'], $new_file ) ) {
					return false;
				}
				// Set correct file permissions.
				$stat = stat( dirname( $new_file ));
				$perms = $stat['mode'] & 0000666;
				@ chmod( $new_file, $perms );
				
				$uploaded_files[] = $new_file;
				
				if ( empty( $this->_posted_data[$name] ) ) {
					$this->_posted_data[$name] = array(
						'file_name'=>basename( $new_file ),
						'file_url'=>str_replace(dhvc_form_upload_dir('dir'),dhvc_form_upload_dir('url'), $new_file),
					);
				}
			}
		}
		$this->_uploaded_files = $uploaded_files;
		return true;
	}
	
	private function _submit(){
		$current_user = wp_get_current_user();

		$_post_id = isset($_POST['_dhvc_form_post_id']) ? get_the_title($_POST['_dhvc_form_post_id']) : 0;
		
		$_form_action = isset($_POST['_dhvc_form_action']) ? $_POST['_dhvc_form_action'] : false;
		
		$current_step = isset($this->_posted_data['_dhvc_form_current_step']) ? (int)$this->_posted_data['_dhvc_form_current_step'] : 1;
		$all_steps = isset($this->_posted_data['_dhvc_form_steps']) ? (int)$this->_posted_data['_dhvc_form_steps'] : 0;
			
		
		$this->_meta = array(
			'site_url'=> get_site_url(),
			'user_agent' => isset( $_SERVER['HTTP_USER_AGENT'] ) ? substr( $_SERVER['HTTP_USER_AGENT'], 0, 254 ) : '',
			'ip_address'=>dhvc_form_get_user_ip(),
			'user_id'=>isset($current_user->ID) ? $current_user->ID : 0,
			'user_display_name'=>isset( $current_user->ID ) ? $current_user->display_name : '',
			'user_email'=>isset( $current_user->ID ) ? $current_user->user_email : '',
			'user_login'=>isset( $current_user->ID ) ? $current_user->user_login : '' ,
			'form_url'=>isset($_POST['_dhvc_form_url']) ? $_POST['_dhvc_form_url'] : '',
			'form_id'=>$this->_form_id,
			'form_title'=>$this->_form_id ? get_the_title($this->_form_id) : '',
			'post_id'=>$_post_id,
			'post_title'=>$_post_id ? get_the_title($_post_id) : '',
			'referer'=>isset($_POST['_dhvc_form_referer']) ? $_POST['_dhvc_form_referer'] : '',
			'submitted'=>date_i18n(dhvc_form_get_option('date_format','Y/m/d')).' '.date_i18n(dhvc_form_get_option('time_format','H:i')),			
		);
		
		if(!$this->_verify_nonce($this->_form_id)){
			$this->_status = 'action_failed';
			$this->_response = $this->_get_message('action_failed');
			
		}elseif('dhvcform'!==get_post_type($this->_form_id)){
			$this->_status = 'form_not_exist';
			$this->_response = $this->_get_message('form_not_exist');
			
		}elseif (!$this->_validate()){
			$this->_status = 'validation_failed';
			$this->_response = $this->_get_message('validation_error');
		}elseif ($this->_is_spam()){
			$this->_status = 'spam';
			$this->_response = $this->_get_message('spam');
		}elseif ($all_steps <= 1 && !$this->_upload_files()){
			$this->_status = 'upload_failed';
			$this->_response = $this->_get_message('upload_failed');
		}elseif ($all_steps==$current_step && !$this->_form_step_add_files()){
			$this->_status = 'upload_failed';
			$this->_response = $this->_get_message('upload_failed');
		}else{
			if($all_steps > 1 && $current_step < $all_steps){
				$this->_status='next_step';
				$this->_response = '';
			}else{
				if($_form_action && in_array($_form_action, dhvc_form_get_actions())){
					$_action_callback = 'dhvc_form_action_'.$_form_action;
					if(is_callable($_action_callback)){
						$ret = call_user_func($_action_callback,$this->_posted_data);
						if(!$ret['success']){
							$this->_status = 'call_action_failed';
							$this->_response = $ret['message'];
						}else{
							$this->_save_entry();
							$this->_send_mail();
							$on_success = get_post_meta($this->_form_id,'_on_success',true);
							if($on_success==='message')
								$msg = dhvc_form_translate_variable(dhvc_form_get_post_meta('_message',$this->_form_id,''));
							else
								$msg = $this->_get_message('success');
							$this->_status = 'success';
							$this->_response = $msg;
						}
					}
				}else{
					$this->_save_entry();
					$this->_send_mail();
					$on_success = get_post_meta($this->_form_id,'_on_success',true);
					if($on_success==='message')
						$msg = dhvc_form_translate_variable(dhvc_form_get_post_meta('_message',$this->_form_id,''));
					else 
						$msg = $this->_get_message('success');
					$this->_status = 'success';
					$this->_response = $msg;
				}
				do_action( 'dhvc_form_submit_success', $this );
			}
		}
		
		return $this->_status;
	}
	
	private function _send_mail(){
		do_action( 'dhvc_form_before_send_mail', $this );
		//Send notice email
		$notice = get_post_meta($this->_form_id,'_notice',true);
		if($notice){
			$mailer_from = '';
			$notice_email_type = dhvc_form_get_post_meta('_notice_email_type',$this->_form_id,'email_text');
			if($notice_email_type == 'email_field'){
				$notice_variables = dhvc_form_get_post_meta('_notice_variables',$this->_form_id);
				if($notice_variables){
					if(isset($this->_posted_data[$notice_variables]) && dhvc_form_is_email($this->_posted_data[$notice_variables])){
						$mailer_from = trim((string)$this->_posted_data[$notice_variables]);
					}
				}
			}else{
				$mailer_from = trim(dhvc_form_get_post_meta('_notice_email',$this->_form_id,get_option('admin_email')));
			}
			$mailer_from = dhvc_form_translate_variable($mailer_from);
			$mailer_from = apply_filters('dhvc_form_notice_sender_email', $mailer_from, $this);
	
			$FromName = trim(dhvc_form_get_post_meta('_notice_name',$this->_form_id,get_option('blogname')));
			$mailer_from_name = dhvc_form_translate_variable($FromName);
				
			$recipients = dhvc_form_get_post_meta('_notice_recipients',$this->_form_id,true);
				
			$recipients = apply_filters('dhvc_form_notice_recipient_email', $recipients,$this);
				
			$mailer_to = array();
			if(is_array($recipients) && !empty($recipients)){
				foreach ((array)$recipients as $recipient){
					$recipient_email = trim($recipient);
					$recipient_email = dhvc_form_translate_variable($recipient);
					if(dhvc_form_is_email($recipient_email)){
						$mailer_to[] = $recipient_email;
					}
				}
			}
			
			$use_html = dhvc_form_get_post_meta('_notice_html',$this->_form_id,true) ? true : false;
			
			$subject = dhvc_form_get_post_meta('_notice_subject',$this->_form_id,true);
			$mailer_subject = dhvc_form_translate_variable($subject);
				
			$body_template = dhvc_form_get_post_meta('_notice_body',$this->_form_id,true);
			
			$body = dhvc_form_translate_variable($body_template,$use_html);
			$body = apply_filters('dhvc_form_notice_body',$body,$this);
			
			$headers = "From: $mailer_from_name <$mailer_from>\r\n";
				
			$notice_reply_to = dhvc_form_get_post_meta('_notice_reply_to',$this->_form_id,true);
			if(isset($this->_posted_data[$notice_reply_to]))
				$notice_reply_to = $this->_posted_data[$notice_reply_to];
			$notice_reply_to = apply_filters('dhvc_form_notice_reply_to', $notice_reply_to,$this);
			if($notice_reply_to && dhvc_form_is_email($notice_reply_to)){
				$headers .= "Reply-To: $notice_reply_to\r\n";
			}
			if($use_html){
				$body = dhvc_form_htmlize_email_body( $body, $mailer_subject, $this );
				$headers .= "Content-Type: text/html\r\n";
			}
			$headers = apply_filters('dhvc_form_notice_header',$headers,$this);
	
			$attachments = array();
			if(apply_filters('dhvc_form_notice_email_attachments', true))
				$attachments = $this->_uploaded_files;
				
			//send email notice
			$result = dhvc_form_send_email($mailer_to, $mailer_subject, $body, $headers, $attachments);
		}
		if(!$result)
			return false;
		//Send Reply email
		$reply = get_post_meta($this->_form_id,'_reply',true);
		if($reply){
			$recipients = get_post_meta($this->_form_id,'_reply_recipients',true);
			$recipients = apply_filters('dhvc_form_reply_recipient', $recipients,$this);
			$reply_recipients = isset($this->_posted_data[$recipients]) && dhvc_form_is_email($this->_posted_data[$recipients]) ? $this->_posted_data[$recipients] : null;
			
			if($reply_recipients){
				$reply_from = trim(dhvc_form_get_post_meta('_reply_email',$this->_form_id,get_option('admin_email')));
				
				$reply_FromName = trim(dhvc_form_get_post_meta('_reply_name',$this->_form_id,get_option('blogname')));
				$reply_FromName = apply_filters('dhvc_form_reply_from_name', $reply_FromName,$this);
		
				$headers = "From: $reply_FromName <$reply_from>\r\n";
				$use_html = get_post_meta($this->_form_id,'_reply_html',true) ? true : false;
				$subject = get_post_meta($this->_form_id,'_reply_subject',true);
				$subject = apply_filters('dhvc_form_reply_from_subject',$subject,$this);
				$subject = dhvc_form_translate_variable($subject);
				$reply_subject = trim((string)$subject);
		
				$body_template = get_post_meta($this->_form_id,'_reply_body',true);
				
				$body = dhvc_form_translate_variable($body_template,$use_html);
				$body = apply_filters('dhvc_form_reply_body',$body,$this);
					
				$headers = apply_filters('dhvc_form_reply_header',$headers,$this);
					
				if($use_html){
					$body = dhvc_form_htmlize_email_body( $body, $reply_subject, $this );
					$headers .= "Content-Type: text/html\r\n";
				}
				//TODO
				dhvc_form_send_email($reply_recipients, $reply_subject, $body, $headers);
			}
		}
		return true;
	}
	
	private function _save_entry(){
		$save_data = get_post_meta($this->_form_id,'_save_data',true);
		if($save_data){
			global $dhvcform_db;
			$data = array(
				'entry_data'=>maybe_serialize($this->_posted_data),
				'submitted'=> current_time('mysql'),
				'ip_address' => dhvc_form_get_user_ip(),
				'form_id'=>$this->_form_id,
				'post_id' => $this->get_meta('post_id'),
				'form_url' => $this->get_meta('form_url'),
				'referer' => $this->get_meta('referer'),
				'user_id'=>$this->get_meta('user_id')
			);
			return $dhvcform_db->insert_entry_data($data);
		}
		return true;
	}
	
	private function _get_message($key=''){
		return dhvc_form_get_message($key);
	}
	
	private function _setup_posted_data(){
		$posted_data = (array) $_POST;
		$posted_data = array_diff_key( $posted_data, array( '_dhvc_form_nonce' => '','action'=>'' ) );
		$posted_data = $this->_sanitize_posted_data( $posted_data );
		$hidden_fields = stripslashes($_POST['_dhvc_form_hidden_fields']);
		$this->_hidden_fields = (array) apply_filters('dhvc_form_posted_hidden_fields', json_decode($hidden_fields));
		$_form_id = isset($posted_data['_dhvc_form_id']) ? intval($posted_data['_dhvc_form_id']) : 0;
		$this->_form_id = $_form_id;
		
		$fields = $this->get_form_fields();

		foreach ((array)$fields as $field){
			if ( empty( $field['control_name'] ) ) {
				continue;
			}
				
			$name = $field['control_name'];
			$value = '';
				
			if ( isset( $posted_data[$name] ) ) {
				$value = $posted_data[$name];
			}
						
			$posted_data[$name] = $value;
		}
		
		$this->_posted_data = apply_filters( 'dhvc_form_posted_data', $posted_data );
		return $this->_posted_data;
	}
	
	private function _sanitize_posted_data( $value ) {
		if ( is_array( $value ) ) {
			$value = array_map( array( $this, '_sanitize_posted_data' ), $value );
		} elseif ( is_string( $value ) ) {
			$value = wp_check_invalid_utf8( $value );
			$value = wp_kses_no_null( $value );
		}
		
		return $value;
	}
	
	private function _is_spam(){
		$spam = false;
		$user_agent = (string) $this->get_meta( 'user_agent' );
		if ( strlen( $user_agent ) < 2 ) {
			$spam = true;
		}
		if ( $this->_is_blacklisted() ) {
			$spam = true;
		}
		return apply_filters('dhvc_form_spam', $spam, $this);
	}
	
	private function _is_blacklisted(){
		$target = dhvc_form_array_flatten( $this->_posted_data );
		$target[] = $this->get_meta( 'ip_address' );
		$target[] = $this->get_meta( 'user_agent' );
		$target = implode( "\n", $target );
		
		return (bool) apply_filters( 'dhvc_form_submission_is_blacklisted',dhvc_form_blacklist_check( $target ), $this );
	}
	
	private function _validate(){
		if ( $this->_invalid_fields ) {
			return false;
		}
		require_once DHVC_FORM_DIR . '/includes/validation.php';
		$result = new DHVCForm_Validation();
		$fields =$this->get_form_fields();
		foreach ( $fields as $field ) {
			$field = new DHVCForm_Field($field);
			$name = $field->get_name();
			
			//ignore hidden field
			if(in_array($name, $this->_hidden_fields))
				continue;
			
			$base_field = $field->base_type();
			$result = apply_filters( "dhvc_form_validate_{$base_field}", $result, $field );
		}
		$result = apply_filters( 'dhvc_form_validate', $result, $fields );
		
		$this->_invalid_fields = $result->get_invalid_fields();
		return $result->is_valid();
	}
	
	private function _verify_nonce($form_id){
		$_dhvc_form_nonce = isset($_POST['_dhvc_form_nonce']) ? $_POST['_dhvc_form_nonce'] : '';
		return wp_verify_nonce($_dhvc_form_nonce,'dhvc-form-'.$form_id );
	}
	
}
//new DHVCForm_Submission();