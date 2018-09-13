<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class DHVCForm_Settings{
	public function __construct(){
		add_action('admin_init', array(&$this,'admin_init'));
		add_action( 'admin_menu', array(&$this,'admin_menu'),25);
	}
	
	public function admin_init(){
		register_setting('dhvc_form','dhvc_form');
	}
	
	public function admin_menu(){
		$page = add_submenu_page('dhvc-form',  __('Settings','dhvc-form'),   __('Settings','dhvc-form'), 'edit_dhvcforms', 'dhvc-form-setting',array(&$this,'render'));
	}
	
	protected function _get_setting_fields(){
		return array(
				'general'=>array(
					'type'=>'heading',
					'label'=>__('General settings','dhvc-form'),
				),
				'allowed_file_extension'=>array(
					'type'=>'textarea',
					'default'=>'zip,rar,tar,7z,jpg,jpeg,png,gif,pdf,doc,docx,ppt,pptx,xls,xlsx',
					'label'=>__('Allowed Files Upload Types','dhvc-form'),
					'help'=>__('Which files are allowed in the attachments? (Separate the extensions by a comma)','dhvc-form'),
				),
				'date_format'=>array(
					'type'=>'text',
					'label'=>__('Date Format','dhvc-form'),
					'default'=>'Y/m/d',
				),
				'time_format'=>array(
					'type'=>'text',
					'label'=>__('Time Format','dhvc-form'),
					'default'=>'H:i',
					'help'=>sprintf('<a href="http://codex.wordpress.org/Formatting_Date_and_Time">%s</a>',__('Documentation on date and time formatting','dhvc-form'))
				),
				'time_picker_step'=>array(
					'type'=>'select',
					'label'=>__('Time picker step','dhvc-form'),
					'default'=>'60',
					'options'=>array(
						'5'=>5,
						'10'=>10,
						'15'=>15,
						'30'=>30,
						'60'=>60,
					),
				),
				'datetimepicker_lang'=>array(
					'type'=>'select',
					'label'=>__('Datetime Picker Language','dhvc-form'),
					'default'=>'en',
					'options'=>apply_filters('datetimepicker_lang',array(
						'ar'=>'Arabic (ar)',
						'az'=>'Azerbaijanian (az)',
						'bg'=>'Bulgarian (bg)',
						'bs'=>'Bosanski (bs)',
						'ca'=>'Català (ca)',
						'ch'=>'Simplified Chinese (ch)',
						'cs'=>'Čeština (cs)',
						'da'=>'Dansk (da)',
						'de'=>'German (de)',
						'el'=>'Ελληνικά (el)',
						'en'=>'English (en)',
						'en-GB'=>'English - British  (en-GB)',
						'es'=>'Spanish (es)',
						'et'=>'Eesti  (et)',
						'eu'=>'Euskara (eu)',
						'fa'=>'Persian (fa)',
						'fi'=>'Finnish - Suomi (fi)',
						'fr'=>'French (fr)',
						'gl'=>'Galego (gl)',
						'he'=>'Hebrew - עברית  (he)',
						'hr'=>'Hrvatski (hr)',
						'hu'=>'Hungarian (hu)',
						'id'=>'Indonesian (id)',
						'it'=>'Italian (it)',
						'ja'=>'Japanese (ja)',
						'ko'=>'Korean 한국어  (ko)',
						'kr'=>'Korean (kr)',
						'lt'=>'Lithuanian - lietuvių  (lt)',
						'lv'=>'Latvian - Latviešu (lv)',
						'mk'=>'Macedonian - Македонски (mk)',
						'mn'=>'Mongolian - Монгол  (mn)',
						'nl'=>'Dutch (nl)',
						'no'=>'Norwegian (no)',
						'pl'=>'Polish (pl)',
						'pt'=>'Portuguese (pt)',
						'pt-BR'=>'Português - Brasil  (pt-BR)',
						'ro'=>'Romanian (ro)',
						'ru'=>'Russian (ru)',
						'se'=>'Swedish (se)',
						'sk'=>'Slovenčina (sk)',
						'sl'=>'Slovenščina (sl)',
						'sq'=>'Albanian - Shqip (sq)',
						'sr'=>'Serbian Cyrillic - Српски (sr)',
						'sr-YU'=>'Serbian - Srpski  (sr-YU)',
						'sv'=>'Svenska (sv)',
						'th'=>'Thai (th)',
						'tr'=>'Turkish (tr)',
						'uk'=>'Ukrainian (uk)',
						'vi'=>'Vietnamese (vi)',
						'zh'=>'Simplified Chinese - 简体中文  (zh)',
						'zh-TW'=>'Traditional Chinese - 繁體中文  (zh-TW)',
					)),
				),
				'container_class'=>array(
					'type'=>'text',
					'label'=>__('Conditional Container Element','dhvc-form'),
					'default'=>'.vc_row-fluid',
				),
				'user'=>array(
						'type'=>'heading',
						'label'=>__('Users page settings','dhvc-form'),
				),
				'user_login'=>array (
						"type" => "select",
						"label" => __ ( "Login page", 'dhvc-form' ),
						"options" => dhvc_form_get_pages(true),
				),
				'user_logout_redirect_to'=>array (
						"type" => "select",
						"label" => __ ( "Logout redirect to page", 'dhvc-form' ),
						"options" => dhvc_form_get_pages(true),
				),
				'user_regiter'=>array (
						"type" => "select",
						"label" => __ ( "Register page", 'dhvc-form' ),
						"options" => dhvc_form_get_pages(true),
				),
				'user_forgotten'=>array (
						"type" => "select",
						"label" => __ ( "Lost password page", 'dhvc-form' ),
						"options" => dhvc_form_get_pages(true),
				),
				'woocommerce_login_page_id'=>array (
					"type" => "select",
					"label" => __ ( "WooCommerce My Account page", 'dhvc-form' ),
					"options" => dhvc_form_get_pages(true),
					'help'=>__('User to override default Login and Register form in WooCommerce My Account page','dhvc-form'),
				),
				'woocommerce_lost_password_page_id'=>array (
					"type" => "select",
					"label" => __ ( "WooCommerce Lost Password page", 'dhvc-form' ),
					"options" => dhvc_form_get_pages(true),
					'help'=>__('User to override default Lost Password form in WooCommerce My Account page','dhvc-form'),
				),
				'email'=>array(
						'type'=>'heading',
						'label'=>__('Email settings','dhvc-form'),
				),
				'email_method'=>array(
						'type'=>'select',
						'label'=>__('Sender method','dhvc-form'),
						'default'=>'default',
						'options'=>array(
							'default'=>__('PHP Mailer','dhvc-form'),
							'smtp'=>__('SMTP','dhvc-form')
						)
				),
				'smtp_host'=>array(
						'type'=>'text',
						'label'=>__('SMTP host','dhvc-form'),
				),
				'smtp_post'=>array(
						'type'=>'text',
						'value'=>25,
						'label'=>__('SMTP port','dhvc-form'),
				),
				'smtp_encryption'=>array(
						'type'=>'select',
						'label'=>__('SMTP encryption','dhvc-form'),
						'options'=>array(
							''=>__('None','dhvc-form'),
							'tls'=>__('TLS','dhvc-form'),
							'ssl'=>__('SSL','dhvc-form')
						),
				),
				'smtp_username'=>array(
						'type'=>'text',
						'label'=>__('SMTP username','dhvc-form'),
				),
				'smtp_password'=>array(
						'type'=>'password',
						'label'=>__('SMTP password','dhvc-form'),
				),
				'recaptcha'=>array(
						'type'=>'heading',
						'label'=>__('reCaptcha settings','dhvc-form'),
						'help'=>__('In order to use the reCAPTCHA element in your form you must <a target="_blank" href="https://www.google.com/recaptcha">sign up</a> for a free account to get your set of API keys.','dhvc-form'),
				),
				'recaptcha_public_key'=>array(
						'type'=>'text',
						'label'=>__('Public key (Site Key)','dhvc-form'),
				),
				'recaptcha_private_key'=>array(
						'type'=>'text',
						'label'=>__('Private key (Secret Key)','dhvc-form'),
				),
				'mailchimp'=>array(
						'type'=>'heading',
						'label'=>__('MailChimp settings','dhvc-form'),
				),
				'mailchimp_api'=>array(
						'type'=>'text',
						'label'=>__('MailChimp API Key','dhvc-form'),
						'help'=>__('Enter your API Key. <a href="http://admin.mailchimp.com/account/api-key-popup" target="_blank">Get your API key</a>','dhvc-form')
				),
				'mailchimp_list'=>array(
						'type'=>'mailchimp_list',
						'label'=>__('MailChimp List','dhvc-form'),
						'options'=>array(''=>__('Nothing Found...','dhvc-form')),
						'help'=>__('After you add your MailChimp API Key above and save it this list will be populated.','dhvc-form')
				),
				'mailchimp_opt_in'=>array(
						'type'=>'checkbox',
						'label'=>__('Enable Double Opt-In','dhvc-form'),
						'help'=>__("Learn more about <a href='http://kb.mailchimp.com/article/how-does-confirmed-optin-or-double-optin-work' target='_blank'>Double Opt-in</a>.",'dhvc-form')
				),
				'mailchimp_welcome_email'=>array(
						'type'=>'checkbox',
						'label'=>__('Send Welcome Email','dhvc-form'),
						'help'=>__("If your Double Opt-in is false and this is true, MailChimp will send your lists Welcome Email if this subscribe succeeds - this will not fire if MailChimp ends up updating an existing subscriber. If Double Opt-in is true, this has no effect. Learn more about <a href='http://blog.mailchimp.com/sending-welcome-emails-with-mailchimp/' target='_blank'>Welcome Emails</a>.",'dhvc-form')
				),
				'mailchimp_group_name'=>array(
						'type'=>'text',
						'label'=>__('Group Name','dhvc-form'),
						'help'=>__('Optional: Enter the name of the group. Learn more about <a href="http://mailchimp.com/features/groups/" target="_blank">Groups</a>','dhvc-form')
				),
				'mailchimp_group'=>array(
						'type'=>'text',
						'label'=>__('Group','dhvc-form'),
						'help'=>__('Optional: Comma delimited list of interest groups to add the email to.','dhvc-form')
				),
				'mailchimp_replace_interests'=>array(
						'type'=>'checkbox',
						'label'=>__('Replace Interests','dhvc-form'),
						'help'=>__("Whether MailChimp will replace the interest groups with the groups provided or add the provided groups to the member's interest groups.",'dhvc-form')
				),
				
		);
	}
	
	public function render(){
		?>
		<div class="wrap">
			<h2><?php echo __('Settings','dhvc-form')?></h2>
			<form action="options.php" method="post">	
				<?php settings_fields('dhvc_form'); ?>
				<table class="form-table">
					<tbody>
						<?php 
						foreach ($this->_get_setting_fields() as $id=>$params): 
						$params = wp_parse_args((array)$params,array(
								'type'=>'',
								'help'=>'',
								'label'=>'',
								'default'=>'',
								'options'=>array()
						));
		
						extract($params);
						?>
						<tr valign="top">
							<?php if($type=='heading'):?>
							<td colspan="2" style="padding: 0;">
								<h3 style="margin-bottom: 0px;"><?php echo $label ?></h3>
								<p><?php echo $help?></p></td>
							<?php else:?>
								<th scope="row"><label for="<?php echo $id ?>"><?php echo $label ?></label></th>
								<?php $this->_render_seting_field($id, $params);?>
							<?php endif;?>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
				<p class="submit">
					<input type="submit" value="<?php echo __('Save Changes','dhvc-form') ?>" class="button button-primary" id="submit" name="submit">
				</p>
			</form>
		</div>
		<?php
	}
	
	protected function _render_seting_field($id,$params){
		$params = wp_parse_args((array)$params,array(
			'type'=>'',
			'help'=>'',
			'label'=>'',
			'default'=>'',
			'help' =>'',
			'options'=>array()
		));
	
		extract($params,EXTR_SKIP);
	
		$name = 'dhvc_form['.$id.']';
	
		echo '<td scope="row">';
		switch ($type){
			case 'text':
				echo '<input type="text" id="'.$id.'" value="'.dhvc_form_get_option($id,$default).'" name="'.$name.'" />';
				if(!empty($help)){
					echo '<p>'.$help.'</p>';
				}
				break;
			case 'textarea':
				echo '<textarea id="'.$id.'" name="'.$name.'" style=" height: 99px;width: 441px;">'.esc_textarea(dhvc_form_get_option($id,$default)).'</textarea>';
				if(!empty($help)){
					echo '<p>'.$help.'</p>';
				}
				break;
			case 'password':
				echo '<input type="password" id="'.$id.'" value="'.dhvc_form_get_option($id,$default).'" name="'.$name.'" />';
				if(!empty($help)){
					echo '<p>'.$help.'</p>';
				}
				break;
			case 'checkbox':
				echo '<input type="checkbox" id="'.$id.'" '.(dhvc_form_get_option($id,$default) == '1' ? ' checked="checked"' : '' ).' value="1" name="'.$name.'">';
				if(!empty($help)){
					echo '<p>'.$help.'</p>';
				}
				break;
			case 'color':
				echo '<input data-default-color="#336CA6" type="text" id="'.$id.'" value="'.dhvc_form_get_option($id,$default).'" name="'.$name.'" />';
				echo '<script type="text/javascript">
								jQuery(document).ready(function($){
								    $("#'.$id.'").wpColorPicker();
								});
							 </script>
							 ';
				break;
				if(!empty($help)){
					echo '<p>'.$help.'</p>';
				}
			case 'select':
				echo '<select id="'.$id.'" name="'.$name.'">';
				foreach ($options as $key=>$value){
					$selected = dhvc_form_get_option($id,$default) == $key ? ' selected="selected"' : '';
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
				}
				echo '</select>';
				if(!empty($help)){
					echo '<p>'.$help.'</p>';
				}
				break;
			case 'mailchimp_list':
				echo '<select id="'.$id.'" name="'.$name.'">';
				if($mailchimp_api = dhvc_form_get_option('mailchimp_api',false)){
					if(!class_exists('MCAPI'))
						require_once DHVC_FORM_DIR.'/includes/MCAPI.class.php';
					$api = new MCAPI($mailchimp_api);
					$lists = $api->lists();
					if ($api->errorCode){
						$options = array(__("Unable to load MailChimp lists, check your API Key.", 'dhvc-form'));
					}else{
						if ($lists['total'] == 0){
							$options = array(__("You have not created any lists at MailChimp",'dhvc-form'));
						}
						$options = array(__('Select a list','dhvc-form'));
						foreach ($lists['data'] as $list){
							$options[$list['id']] = sprintf(__('ID: %1$s - Name: %2$s','dhvc-form'),$list['id'],$list['name']);
						}
					}
				}
				foreach ($options as $key=>$value){
					$selected = dhvc_form_get_option($id,$default) == $key ? ' selected="selected"' : '';
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
				}
				echo '</select>';
				if(!empty($help)){
					echo '<p>'.$help.'</p>';
				}
				break;
			default:
				break;
		}
		echo '</td>';
	}
}
new DHVCForm_Settings();