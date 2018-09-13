<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( difp_is_pro() )
	return;
	
class Difp_Pro_Info
  {
	private static $instance;
	
	public static function init()
        {
            if(!self::$instance instanceof self) {
                self::$instance = new self;
            }
            return self::$instance;
        }
	
    function actions_filters()
    	{
			add_filter( 'difp_admin_settings_tabs', array($this, 'admin_settings_tabs' ) );
			add_filter( 'difp_settings_fields', array($this, 'settings_fields' ) );
			add_action('difp_admin_settings_field_output_oa_admins', array($this, 'field_output_oa_admins' ) );
			add_action('difp_admin_settings_field_output_rtr_block', array($this, 'field_output_rtr_block' ) );
    	}
	
	function email_legends( $where = 'newmessage', $post = '', $value = 'description', $user_email = '' ){
		$legends = array(
			'subject' => array(
				'description' => __('Subject', 'ALSP')
				),
			'message' => array(
				'description' => __('Full Message', 'ALSP')
				),
			'message_url' => array(
				'description' => __('URL of message', 'ALSP'),
				'where' => array( 'newmessage', 'reply' )
				),
			'announcement_url' => array(
				'description' => __('URL of announcement', 'ALSP'),
				'where' => 'announcement'
				),
			'sender' => array(
				'description' => __('Sender', 'ALSP')
				),
			'receiver' => array(
				'description' => __('Receiver', 'ALSP')
				),
			'site_title' => array(
				'description' => __('Website title', 'ALSP')
				),
			'site_url' => array(
				'description' => __('Website URL', 'ALSP')
				),
			);
		
		$ret = array();
		foreach( $legends as $k => $legend ) {
		
				if ( empty($legend['where']) )
					$legend['where'] = array( 'newmessage', 'reply', 'announcement' );
				
				if( is_array($legend['where'])){
					if ( ! in_array(  $where, $legend['where'] )){
						continue;
					}
				} else {
					if ( $where != $legend['where'] ){
						continue;
					}
				}
				if( 'description' == $value ) {
					$ret[$k] = '<code>{{' . $k . '}}</code> = ' . $legend['description'];
				}
		}
		return $ret;
	}
	
	function admin_settings_tabs( $tabs ) {
		
		$tabs['email_piping'] =  array(
				'section_title'		=> __('Email Piping', 'ALSP'),
				'section_page'		=> 'difp_settings_emails',
				'section_callback'	=> array($this, 'section_callback' ),
				'priority'			=> 53,
				'tab_output'		=> false
				);		
		$tabs['eb_newmessage'] =  array(
				'section_title'		=> __('New Message email', 'ALSP'),
				'section_page'		=> 'difp_settings_emails',
				'section_callback'	=> array($this, 'section_callback' ),
				'priority'			=> 55,
				'tab_output'		=> false
				);
		$tabs['eb_reply'] =  array(
				'section_title'		=> __('Reply Message email', 'ALSP'),
				'section_page'		=> 'difp_settings_emails',
				'section_callback'	=> array($this, 'section_callback' ),
				'priority'			=> 65,
				'tab_output'		=> false
				);
		$tabs['eb_announcement'] =  array(
				'section_title'		=> __('Announcement email', 'ALSP'),
				'section_page'		=> 'difp_settings_emails',
				'section_callback'	=> array($this, 'section_callback' ),
				'priority'			=> 75,
				'tab_output'		=> false
				);
		$tabs['mr_multiple_recipients'] =  array(
				'section_title'			=> __('Multiple Recipients', 'ALSP'),
				'section_page'		=> 'difp_settings_recipient',
				'section_callback'	=> array($this, 'section_callback' ),
				'priority'			=> 10,
				'tab_output'		=> false
				);
		$tabs['oa_admins'] =  array(
				'section_title'			=> __('Only Admins', 'ALSP'),
				'section_page'		=> 'difp_settings_recipient',
				'section_callback'	=> array($this, 'section_callback' ),
				'priority'			=> 15,
				'tab_output'		=> false
				);
		$tabs['rtr_block'] =  array(
				'section_title'			=> __('Role to Role Block', 'ALSP'),
				'section_page'		=> 'difp_settings_security',
				'section_callback'	=> array($this, 'section_callback' ),
				'priority'			=> 35,
				'tab_output'		=> false
				);
				
		return $tabs;
	}
	
	function section_callback( $section ){
		
		static $added = false;
		
		if( ! $added ){ ?>
		<script type="text/javascript">
		jQuery(document).ready(function(){	
			jQuery( ".difp_admin_div_need_pro" ).each(function() {
				jQuery(this).css({
							height: jQuery(this).next('table').height(), 
							width: jQuery(this).next('table').width()
						});
				jQuery(this).show();
			});

		});
		</script>
		<style type="text/css">
			.difp_admin_div_need_pro {
				cursor: pointer;
				background:#ffffff url('<?php echo DIFP_PLUGIN_URL . 'assets/images/pro_only.png'; ?>') no-repeat center center;
				-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
				filter: alpha(opacity=50);
				opacity: 0.5;
				position: absolute;
				z-index: 99;
				display: none;
			}
		</style><?php
		$added = true;
		}
		
		echo '<div class="notice notice-warning inline"><p>'.sprintf(__('Following features only available in PRO version. <a href="%s" target="_blank">Upgrade to PRO</a>'), esc_url('https://www.shamimsplugins.com/products/ALSP-pro/?utm_campaign=admin&utm_source=pro_features&utm_medium=links')). '</p></div>';
		?><div class="difp_admin_div_need_pro" onclick="window.open('https://www.shamimsplugins.com/products/ALSP-pro/?utm_campaign=admin&utm_source=pro_features&utm_medium=image');"></div><?php
		
	}
	
	function settings_fields( $fields )
		{	
			
			$fields['ep_enable'] =   array(
				'type'	=>	'checkbox',
				'class'	=> '',
				'section'	=> 'email_piping',
				'value' => difp_get_option('ep_enable', 0 ),
				//'description' => __( 'Can users send message to other users.', 'ALSP' ),
				'label' => __( 'Enable', 'ALSP' ),
				'cb_label' => __( 'Enable email piping?', 'ALSP' )
				);
			$fields['ep_email'] =   array(
				'type'	=>	'email',
				'section'	=> 'email_piping',
				'value' => difp_get_option('ep_email', get_bloginfo('admin_email') ),
				'description' => __( 'Use this email as email piping.', 'ALSP' ),
				'label' => __( 'Piping Email', 'ALSP' )
				);
			$fields['ep_clean_reply'] =   array(
				'type'	=>	'checkbox',
				'class'	=> '',
				'section'	=> 'email_piping',
				'value' => difp_get_option('ep_clean_reply', 1 ),
				'label' => __( 'Clean reply quote', 'ALSP' ),
				'cb_label' => __( 'Clean reply quote from email?', 'ALSP' )
				);
			$templates = array(
				'default'	=> __( 'Default', 'ALSP' ),
				);
			
			$fields['eb_newmessage_template'] =   array(
				'section'	=> 'eb_newmessage',
				'value' => difp_get_option('eb_newmessage_template', 'default'),
				'label' => __( 'New message email template', 'ALSP' ),
				'type'	=>	'select',
				//'description' => __( 'Admin alwayes have Wp Editor.', 'ALSP' ),
				'options'	=> apply_filters( 'difp_eb_templates', $templates, 'newmessage' ),
				);
			$fields['eb_newmessage_subject'] =   array(
				'section'	=> 'eb_newmessage',
				'value' => difp_get_option('eb_newmessage_subject', ''),
				'label' => __( 'New message subject.', 'ALSP' )
				);
			$fields['eb_newmessage_content'] =   array(
				'type' => 'teeny',
				'section'	=> 'eb_newmessage',
				'value' => difp_get_option('eb_newmessage_content', ''),
				'description' => implode( '<br />', $this->email_legends() ),
				'label' => __( 'New message content.', 'ALSP' )
				);
			$fields['eb_newmessage_attachment'] =   array(
				'type'	=>	'checkbox',
				'class'	=> '',
				'section'	=> 'eb_newmessage',
				'value' => difp_get_option('eb_newmessage_attachment', 0 ),
				'label' => __( 'Send Attachments', 'ALSP' ),
				'cb_label' => __( 'Send attachments with new message email?', 'ALSP' )
				);
			$fields['eb_reply_template'] =   array(
				'section'	=> 'eb_reply',
				'value' => difp_get_option('eb_reply_template', 'default'),
				'label' => __( 'Reply message email template', 'ALSP' ),
				'type'	=>	'select',
				//'description' => __( 'Admin alwayes have Wp Editor.', 'ALSP' ),
				'options'	=> apply_filters( 'difp_eb_templates', $templates, 'reply' ),
				);
			$fields['eb_reply_subject'] =   array(
				'section'	=> 'eb_reply',
				'value' => difp_get_option('eb_reply_subject', ''),
				'label' => __( 'Reply subject.', 'ALSP' )
				);
			$fields['eb_reply_content'] =   array(
				'type' => 'teeny',
				'section'	=> 'eb_reply',
				'value' => difp_get_option('eb_reply_content', ''),
				'description' => implode( '<br />', $this->email_legends( 'reply' ) ),
				'label' => __( 'Reply content.', 'ALSP' )
				);
			$fields['eb_reply_attachment'] =   array(
				'type'	=>	'checkbox',
				'class'	=> '',
				'section'	=> 'eb_reply',
				'value' => difp_get_option('eb_reply_attachment', 0 ),
				'label' => __( 'Send Attachments', 'ALSP' ),
				'cb_label' => __( 'Send attachments with reply message email?', 'ALSP' )
				);
			$fields['eb_announcement_interval'] =   array(
				'type' => 'number',
				'section'	=> 'eb_announcement',
				'value' => difp_get_option('eb_announcement_interval', 60 ),
				'label' => __( 'Sending Interval.', 'ALSP' ),
				'description' => __( 'Announcement sending Interval in minutes.', 'ALSP' )
				);
			$fields['eb_announcement_email_per_interval'] =   array(
				'type' => 'number',
				'section'	=> 'eb_announcement',
				'value' => difp_get_option('eb_announcement_email_per_interval', 100 ),
				'label' => __( 'Emails send per interval.', 'ALSP' ),
				'description' => __( 'Announcement emails send per interval.', 'ALSP' )
				);
			$fields['eb_announcement_template'] =   array(
				'section'	=> 'eb_announcement',
				'value' => difp_get_option('eb_announcement_template', 'default'),
				'label' => __( 'Announcement email template', 'ALSP' ),
				'type'	=>	'select',
				//'description' => __( 'Admin alwayes have Wp Editor.', 'ALSP' ),
				'options'	=> apply_filters( 'difp_eb_templates', $templates, 'announcement' ),
				);
			$fields['eb_announcement_subject'] =   array(
				'section'	=> 'eb_announcement',
				'value' => difp_get_option('eb_announcement_subject', ''),
				'label' => __( 'Announcement subject.', 'ALSP' )
				);
			$fields['eb_announcement_content'] =   array(
				'type' => 'teeny',
				'section'	=> 'eb_announcement',
				'value' => difp_get_option('eb_announcement_content', ''),
				'description' => implode( '<br />', $this->email_legends( 'announcement' ) ),
				'label' => __( 'Announcement content.', 'ALSP' )
				);
			$fields['eb_announcement_attachment'] =   array(
				'type'	=>	'checkbox',
				'class'	=> '',
				'section'	=> 'eb_announcement',
				'value' => difp_get_option('eb_announcement_attachment', 0 ),
				'label' => __( 'Send Attachments', 'ALSP' ),
				'cb_label' => __( 'Send attachments with announcement email?', 'ALSP' )
				);
			$fields['mr-max-recipients'] =   array(
				'type'	=>	'number',
				'section'	=> 'mr_multiple_recipients',
				'value' => difp_get_option('mr-max-recipients', 5 ),
				'description' => __( 'Maximum recipients per message.', 'ALSP' ),
				'label' => __( 'Max recipients', 'ALSP' )
				);
			$fields['mr-message'] =   array(
				'type'	=>	'select',
				'section'	=> 'mr_multiple_recipients',
				'value' => difp_get_option('mr-message', 'same-message' ),
				'description' => __( 'How message will be sent to recipients', 'ALSP' ),
				'label' => __( 'Message type', 'ALSP' ),
				'options' => array(
					'same-message' => __( 'Same Message', 'ALSP' ),
					'separate-message' => __( 'Separate Message', 'ALSP' )
					)
				);
			$fields['read_receipt'] =   array(
				'type'	=>	'checkbox',
				'class'	=> '',
				'section'	=> 'mr_multiple_recipients',
				'value' => difp_get_option('read_receipt', 1 ),
				'label' => __( 'Read Receipt', 'ALSP' ),
				'cb_label' => __( 'Show read receipt bottom of every message?', 'ALSP' )
				);
			$fields['oa-can-send-to-admin'] =   array(
				'type'	=>	'checkbox',
				'class'	=> '',
				'section'	=> 'oa_admins',
				'value' => difp_get_option('oa-can-send-to-admin', 1 ),
				'description' => __( 'Can users send message to admin.', 'ALSP' ),
				'label' => __( 'Can send to admin', 'ALSP' )
				);
			$fields['oa_admins'] =   array(
				'type'	=>	'oa_admins',
				'section'	=> 'oa_admins',
				'value' => difp_get_option('oa_admins', array()),
				'description' => __( 'Do not forget to save.', 'ALSP' ),
				'label' => __( 'Admins', 'ALSP' )
				);
			$fields['oa_admins_frontend'] =   array(
				'type'	=>	'select',
				'section'	=> 'oa_admins',
				'value' => difp_get_option('oa_admins_frontend', 'dropdown' ),
				'description' => __( 'Select how you want to see in frontend.', 'ALSP' ),
				'label' => __( 'Show in front end as', 'ALSP' ),
				'options'	=> array(
					'dropdown'	=> __( 'Dropdown', 'ALSP' ),
					'radio'	=> __( 'Radio Button', 'ALSP' )
					)
				);
			$fields['rtr_block'] =   array(
				'type'	=>	'rtr_block',
				'section'	=> 'rtr_block',
				'value' => difp_get_option('rtr_block', array()),
				'description' => __( 'Do not forget to save.', 'ALSP' ),
				);
								
			return $fields;
			
		}
		
		function field_output_oa_admins( $field ){
		
		?>
			<div>
				<span><input type="text" placeholder="<?php esc_attr_e( 'Display as', 'ALSP' ); ?>" value=""/></span>
				<span><input type="text" placeholder="<?php esc_attr_e( 'Username', 'ALSP' ); ?>" value=""/></span>
				<span><input type="button" class="button button-small" value="<?php esc_attr_e( 'Remove', 'ALSP' ); ?>" /></span>
			</div>
			<div><input type="button" class="button" value="<?php esc_attr_e( 'Add More', 'ALSP' ); ?>" /></div>
		<?php
		
		}
		function field_output_rtr_block( $field ){
		
		?>
			<table>
				<th><?php _e( 'From Role', 'ALSP' );?></th>
				<th><?php _e( 'To Role', 'ALSP' );?></th>
				<th><?php _e( 'Block For', 'ALSP' );?></th>
				<th><?php _e( 'Remove', 'ALSP' );?></th>
			</table>
			
			<div>
				<span><select><option value=""><?php _e( 'Select Role', 'ALSP' ); ?></option></select></span>
				<span><select><option value=""><?php _e( 'Select Role', 'ALSP' ); ?></option></select></span>
				<span><select><option value=""><?php _e( 'Select For', 'ALSP' ); ?></option></select></span>
				<span><input type="button" class="button button-small" value="<?php esc_attr_e( 'Remove', 'ALSP' ); ?>" /></span>
			</div>
			<div><input type="button" class="button" value="<?php esc_attr_e( 'Add More', 'ALSP' ); ?>" /></div>
		<?php
		
		}
		
		function to_use_wp_online_translation(){
			__( 'Send Message to admin', 'ALSP' );
		}
		
  } //END CLASS

add_action('admin_init', array(Difp_Pro_Info::init(), 'actions_filters'));

