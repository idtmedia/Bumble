<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class DHVCForm_Metabox {
	public function __construct(){
		add_action( 'add_meta_boxes', array( &$this, 'remove_meta_boxes' ), 1000 );
		add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ), 30 );
		add_action ( 'save_post', array (&$this,'save_meta_boxes' ), 1, 2 );
	}
	
	public function remove_meta_boxes(){
		remove_meta_box( 'vc_teaser', 'dhvcform' , 'side' );
		remove_meta_box( 'commentsdiv', 'dhvcform' , 'normal' );
		remove_meta_box( 'commentstatusdiv', 'dhvcform' , 'normal' );
		remove_meta_box( 'slugdiv', 'dhvcform' , 'normal' );
		remove_meta_box('mymetabox_revslider_0', 'dhvcform', 'normal');
	}
	
	public function save_meta_boxes($post_id, $post){
		// $post_id and $post are required
		if ( empty( $post_id ) || empty( $post ) ) {
			return;
		}
		
		// Dont' save meta boxes for revisions or autosaves
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}
		
		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events
		if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
			return;
		}
		
		// Check user has permission to edit
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		// Check the post type
		if ('dhvcform'!==$post->post_type ) {
			return;
		}
		
		foreach ((array)$this->_get_tabs() as $key=>$tab){
			$call_fnc = '_'.$key.'_setting';
			if(is_callable(array($this,$call_fnc))){
				$settings = call_user_func(array($this,$call_fnc));
				foreach ($settings as $meta_box){
					if(isset($meta_box['name'])){
						$meta_name = false !== strpos($meta_box['name'], 'dhvc_form_messages') ? 'dhvc_form_messages': $meta_box['name'];
						$meta_value = isset($_POST[$meta_name]) ? $_POST[$meta_name] : null;
						if(is_array($meta_value)){
							$meta_value = array_map( 'sanitize_text_field', (array) $meta_value ) ;
							if(false === strpos($meta_box['name'], 'dhvc_form_messages'))
								$meta_value = array_filter($meta_value);
						}
						if (empty( $meta_value ) && false === strpos($meta_box['name'], 'dhvc_form_messages') ) {
							delete_post_meta( $post_id, '_'.$meta_name );
						} elseif($meta_value !== null) {
							update_post_meta( $post_id, '_'.$meta_name , $meta_value );
						}
					}
				}
			}
		}
		
	}
	
	protected function _get_form_acition_options(){
		$actions = dhvc_form_get_actions();
		$options = array('');
		foreach ($actions as $action){
			$options[$action] = ucfirst($action);
		}
		return $options;
	}
	
	public function add_meta_boxes(){
		add_meta_box( 'dhvcform-options', __( 'Form Options', 'dhvc-form' ), array($this,'render_with_tabs'), 'dhvcform', 'normal', 'high' );
	}
	
	private function _general_setting(){
		return array(
			array (
				"type" => "heading",
				"label"=>__('General','dhvc-form')
			),
			array (
				"type" => "checkbox",
				"label" => __ ( "Save Submitted Form to Data ?", 'dhvc-form' ),
				"name" => "save_data",
				"cbvalue" =>1,
				'description' => __('If checked, the submitted form data will be saved to your database.','dhvc-form')
			),
// 			array (
// 				"type" => "checkbox",
// 				"label" => __ ( "Use Form AJAX ? ", 'dhvc-form' ),
// 				"name" => "use_ajax",
// 				'description'=>__('You can not upload file if use form AJAX','dhvc-form'),
// 				"cbvalue" =>1
// 			),
			array (
				"type" => "select",
				"label" => __ ( "Action Type", 'dhvc-form' ),
				"name" => "action_type",
				"options" => array (
					'default'=>__ ( 'Default', 'dhvc-form' ),
					'external_url'=>__ ( 'External URL', 'dhvc-form' )
				)
			),
			array (
				"type" => "text",
				"label" => __ ( "Enter URL", 'dhvc-form' ),
				"name" => "action_url",
				"dependency" => array ('element' => "action_type",'value' => array ('external_url')),
				'description' => __('Enter a action URL.','dhvc-form')
			),
			array (
				"type" => "select",
				"label" => __ ( "Use form action", 'dhvc-form' ),
				"name" => "form_action",
				"options"=>$this->_get_form_acition_options()
			),
			array (
				"type" => "checklist",
				"label" => __ ( "Mailpoet subscribers to These Lists", 'dhvc-form' ),
				"name" => "mailpoet",
				"options" => dhvc_form_get_mailpoet_subscribers_list(),
			),
			array (
				"type" => "checklist",
				"label" => __ ( "Mymail subscribers to These Lists", 'dhvc-form' ),
				"name" => "mymail",
				"options" => dhvc_form_get_mymail_subscribers_list(),
			),
			array (
				"type" => "checkbox",
				"label" => __ ( "Mymail Double Opt In ", 'dhvc-form' ),
				"name" => "mymail_double_opt_in",
				'description'=>__('Users have to confirm their subscription','dhvc-form'),
				"cbvalue" =>1
			),
			array (
				"type" => "select",
				"label" => __ ( "Method", 'dhvc-form' ),
				"name" => "method",
				"options" => array (
					'post'=>__ ( 'Post', 'dhvc-form' ),
					'get'=>__ ( 'Get', 'dhvc-form' )
				)
			),
			array (
				"type" => "heading",
				"label"=>__('Successful submit settings','dhvc-form')
			),
			array (
				"type" => "select",
				"label" => __ ( "On successful submit", 'dhvc-form' ),
				"name" => "on_success",
				"options" => array (
					'message'=>__ ( 'Display a message', 'dhvc-form' ),
					'redirect'=>__ ( 'Redirect to another page', 'dhvc-form' )
				)
			),
			array (
				"type" => "textarea_variable",
				"label" => __ ( "Message", 'dhvc-form' ),
				"name" => "message",
				"value"=>'Your message has been sent. Thanks!',
				"dependency" => array ('element' => "on_success",'value' => array ('message')),
				'description' =>  __('This is the text or HTML that is displayed when the form is successfully submitted','dhvc-form')
			),
			array (
				"type" => "select",
				"label" => __ ( "Message Position", 'dhvc-form' ),
				"name" => "message_position",
				'description' =>  __('You can use "Form Response" shortcode to locating response message box anywhere','dhvc-form'),
				"options"=>array(
					'top'=>__('Top','dhvc-form'),
					'bottom'=>__('Bottom','dhvc-form')
				),
			),
			array (
				"type" => "select",
				"label" => __ ( "Redirect to", 'dhvc-form' ),
				"name" => "redirect_to",
				"dependency" => array ('element' => "on_success",'value' => array ('redirect')),
				"options" => array (
					'to_page'=>__ ( 'Page', 'dhvc-form' ),
					'to_post'=>__ ( 'Post', 'dhvc-form' ),
					'to_url'=>__ ( 'Url', 'dhvc-form' )
				),
				"description"=>__('When the form is successfully submitted you can redirect the user to post, page or URL.','dhvc-form'),
			),
			array (
				"type" => "select",
				"label" => __ ( "Select page", 'dhvc-form' ),
				"name" => "page",
				"options" => dhvc_form_get_pages(),
				"dependency" => array ('element' => "redirect_to",'value' => array ('to_page')),
			),
			array (
				"type" => "select",
				"label" => __ ( "Select post", 'dhvc-form' ),
				"name" => "post",
				"options" => dhvc_form_get_posts(),
				"dependency" => array ('element' => "redirect_to",'value' => array ('to_post')),
			),
			array (
				"type" => "text",
				"label" => __ ( "Enter URL", 'dhvc-form' ),
				"name" => "url",
				"dependency" => array ('element' => "redirect_to",'value' => array ('to_url')),
			),
				
			array (
				"type" => "heading",
				"label"=>__('Form popup settings','dhvc-form')
			),
			array (
				"type" => "checkbox",
				"label" => __ ( "Display the form in a popup ?", 'dhvc-form' ),
				"name" => "form_popup",
				"cbvalue" =>1
			),
			array (
				"type" => "labelpopup",
				"name" => 'form_popup_labelpopup',
				"label" => __ ('Set data-toggle="dhvcformpopup" on a controller element, like a button, along with a data-target="#dhvcformpopup-{form_ID}" or href="#dhvcformpopup-{form_ID}" to target a specific form popup to toggle.', 'dhvc-form' ),
			),
			array (
				"type" => "checkbox",
				"label" => __ ( "Show popup title ?", 'dhvc-form' ),
				"name" => "form_popup_title",
				"cbvalue" =>1
			),
			array (
				'type' => 'text',
				'label' => __ ( 'Form popup width (px)', 'dhvc-form' ),
				'name' => 'form_popup_width',
				'value'=>600,
			),
			array (
				"type" => "checkbox",
				"label" => __ ( "Auto open popup ?", 'dhvc-form' ),
				"name" => "form_popup_auto_open",
				"cbvalue" =>1,
				"description"=>__('If selected, form popup will auto open when load page.','dhvc-form'),
			),
			array (
				'type' => 'text',
				'label' => __ ( 'Popup open delay (ms)', 'dhvc-form' ),
				'name' => 'form_popup_auto_open_delay',
				'value'=>2000,
				"description"=>__('Time delay for open popup.','dhvc-form'),
			),
			array (
				"type" => "checkbox",
				"label" => __ ( "Auto close popup ?", 'dhvc-form' ),
				"name" => "form_popup_auto_close",
				"cbvalue" =>1,
				"description"=>__('If selected, form popup will auto close.','dhvc-form'),
			),
			array (
				'type' => 'text',
				'label' => __ ( 'Popup close delay (ms)', 'dhvc-form' ),
				'name' => 'form_popup_auto_close_delay',
				'value'=>10000,
				"description"=>__('Time delay for close popup.','dhvc-form'),
			),
			array (
				"type" => "checkbox",
				"label" => __ ( "Only one time ?", 'dhvc-form' ),
				"name" => "form_popup_one",
				"cbvalue" =>1,
				"description"=>__('If selected,form will opens only on the first visit your site.','dhvc-form'),
			),
		);
	}
	
	private function _mail_setting(){
		return array(
			array (
				"type" => "heading",
				"label"=>__('Notifications email settings','dhvc-form')
			),
			array (
				"type" => "checkbox",
				"label" => __ ( "Send form data via email ?", 'dhvc-form' ),
				"name" => "notice",
				"cbvalue" =>1
			),
			array (
				'type' => 'text',
				'label' => __ ( 'Sender Name', 'dhvc-form' ),
				'name' => 'notice_name',
				'value'=>get_bloginfo('name'),
				"dependency" => array ('element' => "notice",'not_empty' => true),
			),
			array (
				'type' => 'select',
				'label' => __ ( 'Sender Email Type', 'dhvc-form' ),
				'name' => 'notice_email_type',
				'value'=>'email_text',
				'options'=>array(
					'email_text'=>__ ( 'Email', 'dhvc-form' ),
					'email_field'=>__ ( 'Email Field', 'dhvc-form' ),
				),
				"dependency" => array ('element' => "notice",'not_empty' => true),
			),
			array (
				'type' => 'text',
				'label' => __ ( 'Sender Email', 'dhvc-form' ),
				'name' => 'notice_email',
				'value'=>get_bloginfo('admin_email'),
				"dependency" => array ('element' => "notice",'not_empty' => true),
			),
			array (
				'type' => 'select_recipient',
				'label' => __ ( 'Sender Field', 'dhvc-form' ),
				'name' => 'notice_variables',
				"description"=>__('The form must have at least one Email Address element to use this feature.','dhvc-form')
			),
			array (
				'type' => 'recipient',
				'label' => __ ( 'Recipients', 'dhvc-form' ),
				'name' => 'notice_recipients',
				'value'=>get_bloginfo('admin_email'),
				"dependency" => array ('element' => "notice",'not_empty' => true),
				"description"=>__('Add email address(es) which the submitted form data will be sent to.','dhvc-form')
			),
			array (
				'type' => 'select_recipient',
				'label' => __ ( 'Reply To', 'dhvc-form' ),
				'name' => 'notice_reply_to',
				"description"=>__('The form must have at least one Email Address element to use this feature.','dhvc-form')
			),
			array (
				'type' => 'input_variable',
				'label' => __ ( 'Email subject', 'dhvc-form' ),
				'name' => 'notice_subject',
				"dependency" => array ('element' => "notice",'not_empty' => true),
				'value'=>__('New form submission','dhvc-form')
			),
			array (
				'type' => 'textarea_variable',
				'label' => __ ( 'Email body', 'dhvc-form' ),
				'name' => 'notice_body',
				'value'=>'[form_body]',
				"description"=>__("Use the label [form_body] to insert the form data in the email body. To use form control in email. please enter form control variables <strong>[form_control_name]</strong> in email.",'dhvc-form')
			),
			array (
				"type" => "checkbox",
				"label" => __ ( "Use HTML content type ?", 'dhvc-form' ),
				"name" => "notice_html",
				"cbvalue" =>1
			),
			array (
				"type" => "heading",
				"label"=>__('Autoreply email settings','dhvc-form')
			),
			array (
				"type" => "checkbox",
				"label" => __ ( "Send autoreply email ?", 'dhvc-form' ),
				"name" => "reply",
				"cbvalue" => 1
			),
			array (
				'type' => 'text',
				'label' => __ ( 'Sender Name', 'dhvc-form' ),
				'name' => 'reply_name',
				'value'=>get_bloginfo('name'),
				"dependency" => array ('element' => "reply",'not_empty' => true),
			),
			array (
				'type' => 'text',
				'label' => __ ( 'Sender Email', 'dhvc-form' ),
				'name' => 'reply_email',
				'value'=>get_bloginfo('admin_email'),
				"dependency" => array ('element' => "reply",'not_empty' => true),
			),
			array (
				'type' => 'select_recipient',
				'label' => __ ( 'Recipients', 'dhvc-form' ),
				'name' => 'reply_recipients',
				"description"=>__('The form must have at least one Email Address element to use this feature.','dhvc-form')
			),
			array (
				'type' => 'input_variable',
				'label' => __ ( 'Email subject', 'dhvc-form' ),
				'name' => 'reply_subject',
				"dependency" => array ('element' => "reply",'not_empty' => true),
				'value'=>__('Just Confirming','dhvc-form')
			),
			array (
				'type' => 'textarea_variable',
				'label' => __ ( 'Email body', 'dhvc-form' ),
				'name' => 'reply_body',
				"dependency" => array ('element' => "reply",'not_empty' => true),
				'value'=>__('This is just a confirmation message. We have received you reply.','dhvc-form'),
				"description"=>__("Use the label [form_body] to insert the form data in the email body. To use form control in email. please enter form control variables <strong>[form_control_name]</strong> in email.",'dhvc-form')
			),
			array (
				"type" => "checkbox",
				"label" => __ ( "Use HTML content type ?", 'dhvc-form' ),
				"name" => "reply_html",
				"cbvalue" =>1
			),
		);
	}
	
	private function _style_setting(){
		return array(
			array (
				"type" => "heading",
				"label"=>__('Style settings','dhvc-form')
			),
			array (
				"type" => "select",
				"label" => __ ( "Form layout", 'dhvc-form' ),
				"name" => "form_layout",
				"options" => array (
					'vertical'=>__ ( 'Vertical', 'dhvc-form' ),
					'horizontal'=>__ ( 'Horizontal', 'dhvc-form' ),
				),
			),
			array (
				"type" => "select",
				"label" => __ ( "Input icon position", 'dhvc-form' ),
				"name" => "input_icon_position",
				"options" => array (
					'right'=>__ ( 'Right', 'dhvc-form' ),
					'left'=>__ ( 'Left', 'dhvc-form' ),
				),
			),
			array (
				'type' => 'color',
				'label' => __ ( 'Label Color', 'dhvc-form' ),
				'name' => 'label_color',
			),
			array (
				'type' => 'color',
				'label' => __ ( 'Input Placeholder Text Color', 'dhvc-form' ),
				'name' => 'placeholder_color',
			),
			array (
				'type' => 'text',
				'label' => __ ( 'Input Height (example enter:40px)', 'dhvc-form' ),
				'name' => 'input_height',
			),
			array (
				'type' => 'color',
				'label' => __ ( 'Input Background Color', 'dhvc-form' ),
				'name' => 'input_bg_color',
			),
			array (
				'type' => 'color',
				'label' => __ ( 'Input Text Color', 'dhvc-form' ),
				'name' => 'input_text_color',
			),
			array (
				'type' => 'color',
				'label' => __ ( 'Input border color', 'dhvc-form' ),
				'name' => 'input_border_color',
			),
			array (
				'type' => 'text',
				'label' => __ ( 'Input border Size (example enter:1px)', 'dhvc-form' ),
				'name' => 'input_border_size',
			),
			array (
				'type' => 'color',
				'label' => __ ( 'Input hover border color', 'dhvc-form' ),
				'name' => 'input_hover_border_color',
			),
			array (
				'type' => 'color',
				'label' => __ ( 'Input focus border color', 'dhvc-form' ),
				'name' => 'input_focus_border_color',
			),
			array (
				'type' => 'text',
				'label' => __ ( 'Button Height (example enter:40px)', 'dhvc-form' ),
				'name' => 'button_height',
			),
			array (
				'type' => 'color',
				'label' => __ ( 'Button background color', 'dhvc-form' ),
				'name' => 'button_bg_color',
			),
			array (
				'type' => 'color',
				'label' => __ ( 'Seps control color', 'dhvc-form' ),
				'name' => 'steps_control_color',
			),
		);
	}
	
	private function _additional_setting(){
		return array(
			array (
				"type" => "heading",
				"label"=>__('Additional settings','dhvc-form')
			),
			array(
				'type'=>'textarea',
				'label'=>__('Additional Settings','dhvc-form'),
				"description"=>__('Trigger with form AJAX.','dhvc-form'),
				'name'=>'additional_setting'
			),
		);
	}
	
	private function _message_setting(){
		$default_messages = dhvc_form_get_messages();
		$settings = array();
		$settings[] = array (
			"type" => "heading",
			"label"=>__('Messagess settings','dhvc-form')
		);
		foreach ($default_messages as $key=>$message){
			$label = 'On '.ucwords(implode(' ', explode('_', $key)));
			$settings[] = array (
				'type' => 'text',
				'label' => $label,
				'name' =>'dhvc_form_messages['.$key.']',
				'value'=>$message
			);
		}
		return $settings;
	}
	
	private function _payment_setting(){
		return array(
			array (
				"type" => "heading",
				"label"=>__('PayPal Settings','dhvc-form')
			),
			array (
				'type' => 'text',
				'label' => __ ( 'PayPal Email', 'dhvc-form' ),
				'name' => 'paypal_email',
			),
			array (
				'type' => 'select',
				'label' => __ ( 'PayPal Currency', 'dhvc-form' ),
				'name' => 'paypal_currency',
				'value'=>'USD',
				'options'=>dhvc_form_get_currencies()
			),
			array (
				"type" => "checkbox",
				"label" => __ ( "PayPal sandbox", 'dhvc-form' ),
				"name" => "paypal_sandbox",
				"cbvalue" => 1,
				'description'=>sprintf(__('PayPal sandbox can be used to test payments. Sign up for a <a href="%s" target="_blank">developer account</a>.','dhvc-form'),'https://developer.paypal.com/')
			),
			array (
				'type' => 'text',
				'label' => __ ( 'PayPal Cancel URL', 'dhvc-form' ),
				'name' => 'paypal_cancel_url',
				'description'=>__('Optional','dhvc-form')
			),
			array (
				'type' => 'text',
				'label' => __ ( 'PayPal Return URL', 'dhvc-form' ),
				'name' => 'paypal_return_url',
				'description'=>__('Optional','dhvc-form')
			),
			array (
				"type" => "heading",
				"label"=>__('Paypal checkout','dhvc-form')
			),
			array (
				"type" => "checkbox",
				"label" => __ ( "Submit form to paypal checkout", 'dhvc-form' ),
				"name" => "paypal_checkout",
				"cbvalue" => 1
			),
			array (
				'type' => 'text',
				'label' => __ ( 'Order Description', 'dhvc-form' ),
				'name' => 'paypal_order_description',
				'description'=>__('Optional, if left blank customer will be able to enter their own description at checkout','dhvc-form')
			),
			array (
				'type' => 'text',
				'label' => __ ( 'Order Price', 'dhvc-form' ),
				'name' => 'paypal_order_price',
				'description'=>__('Optional, if left blank customer will be able to enter their own price at checkout','dhvc-form')
			),
			array (
				'type' => 'text',
				'label' => __ ( 'Order ID', 'dhvc-form' ),
				'name' => 'paypal_order_id',
				'description'=>__('Optional','dhvc-form')
			),
		);
	}
	
	private function _get_tabs(){
		return apply_filters('dhvc_form_meta_box_tabs', array(
			'general'=>array(
				'label'=>__("General",'dhvc-form')
			),
			'mail'=>array(
				'label'=>__("Mail",'dhvc-form')
			),
			'style'=>array(
				'label'=>__("Style",'dhvc-form')
			),
			'message'=>array(
				'label'=>__("Messages",'dhvc-form')
			),
			'payment'=>array(
				'label'=>__("Payments",'dhvc-form')
			),
			'additional'=>array(
				'label'=>__("Additional",'dhvc-form')
			),
		));
	}
	
	public function render_with_tabs(){
		
		$tabs_content = '';
		?>
		<div class="dhvcform_options">
			<h2 class="nav-tab-wrapper dhvcform-nav-tab-wrapper" style="padding: 0px;">
				<?php $i = 1;?>
				<?php foreach ((array)$this->_get_tabs() as $key=>$tab):?>
					<a class="nav-tab<?php echo ($i==1) ? ' nav-tab-active':''?>" href="<?php echo '#dhvcform_meta_box_'.esc_attr($key)?>">
						<?php echo esc_html($tab['label'])?>
					</a>
				<?php 
				$call_fnc = '_'.$key.'_setting';
				if(is_callable(array($this,$call_fnc))){
					$settings = call_user_func(array($this,$call_fnc));
					$tabs_content .='<div id="dhvcform_meta_box_'.$key.'" class="dhvcform-tab-panel" '.($i==1 ? '':' style="display:none"' ).'>';
					foreach ($settings as $setting){
						ob_start();
						$this->_render_metabox_field($setting);
						$tabs_content .= ob_get_clean();
					}
					$tabs_content .='</div>';
				}
				?>
				
				<?php $i++;?>
				<?php endforeach;?>
			</h2>
			<div class="nav-tab-content dhvcform-tab-content">
				<?php echo $tabs_content?>
			</div>
		</div>
		<?php
	}
	
	public function render(){
		?>
		<div class="dhvcform_options">
			<?php 
			foreach ($this->_get_meta_boxs_fields() as $meta_box){
				$this->_render_metabox_field($meta_box);
			}	
			?>
		</div>
		<?php
	}
	
	protected function _render_metabox_field($field){
		global $post;
	
		if(!isset($field['type']))
			echo '';
	
		$field['name']          = isset( $field['name'] ) ? $field['name'] : '';
		$value_name = false !== strpos($field['name'], 'dhvc_form_messages') ? '_dhvc_form_messages':'_'.$field['name'];
		$value = get_post_meta( $post->ID, $value_name, true );
		$field['value']         = isset( $field['value'] ) ? $field['value'] : '';
		
		if($value){
			if('_dhvc_form_messages'===$value_name){
				$field_name = str_replace(array('dhvc_form_messages[',']'),'', $field['name']);
				$field['value'] = isset($value[$field_name]) ? $value[$field_name] : '';
			}else{
				$field['value'] = $value;
			}
		}
	
		$field['id'] 			= isset( $field['id'] ) ? $field['id'] : $field['name'];
		$field['description'] 	= isset($field['description']) ? $field['description'] : '';
		$field['label'] 		= isset( $field['label'] ) ? $field['label'] : '';
		$field['placeholder']   = isset( $field['placeholder'] ) ? $field['placeholder'] : $field['label'];
		$field['dependency']    = isset($field['dependency']) ? $field['dependency'] : array();
		$data_dependency = '';
		switch ($field['type']){
			case 'heading':
				echo '<h3>'.esc_html($field['label']).'</h3>';
				break;
			case 'labelpopup':
				echo '<p '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field ">';
				echo $field['label'].__('Example:','dhvc-form').'<br><strong><em>'.esc_html('<button type="button" data-toggle="dhvcformpopup" data-target="#dhvcformpopup-'.get_the_ID().'">'.__('Launch form popup','dhvc-form').'</button>').'</strong></em>';
				echo '</p>';
				break;
			case 'input_variable':
				echo '<p '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field "><label for="' . esc_attr( $field['id'] ) . '">' . ( $field['label'] ) . '</label>';
				echo '<select onchange="dhvc_form_select_variable(this)" class="dhvc-form-select-variable">';
				echo '<option value="">'.__('Insert variable...','dhvc-form').'</option>';
				foreach (dhvc_form_get_variables() as $label=>$key){
					echo '<option value="'.esc_attr($key).'">'.esc_html($label).'</option>';
				}
				echo  '</select>';
				echo '<input type="text" class="input_text" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" /> ';
					
				if ( ! empty( $field['description'] ) ) {
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . ( $field['description'] ) . '</span>';
					}
				}
				echo '</p>';
				break;
			case 'text':
				echo '<p '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field "><label for="' . esc_attr( $field['id'] ) . '">' . ( $field['label'] ) . '</label><input type="text" class="input_text" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" /> ';
					
				if ( ! empty( $field['description'] ) ) {
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . ( $field['description'] ) . '</span>';
					}
				}
				echo '</p>';
				break;
			case 'color':
				wp_enqueue_style( 'wp-color-picker');
				wp_enqueue_script( 'wp-color-picker'); 
				
				echo '<p '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field "><label for="' . esc_attr( $field['id'] ) . '">' . ( $field['label'] ) . '</label><input data-default-color="'.esc_attr( $field['value'] ).'" type="text" class="input_text" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" /> ';
				if ( ! empty( $field['description'] ) ) {
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . ( $field['description'] ) . '</span>';
					}
				}
				echo '<script type="text/javascript">
						jQuery(document).ready(function($){
						    $("#'.$field['id'].'").wpColorPicker();
						});
					 </script>
					 ';
				echo '</p>';
				break;
			case 'hidden':
				echo '<input type="hidden" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) .  '" /> ';
				break;
			case 'textarea_variable':
				echo '<p  '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field "><label for="' . esc_attr( $field['id'] ) . '">' . ( $field['label'] ) . '</label>';
				echo '<select onchange="dhvc_form_select_variable(this)" class="dhvc-form-select-variable">';
				echo '<option value="">'.__('Insert variable...','dhvc-form').'</option>';
				foreach (dhvc_form_get_variables() as $label=>$key){
					echo '<option value="'.esc_attr($key).'">'.esc_html($label).'</option>';
				}
				echo  '</select>';
				echo '<textarea name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" rows="5" cols="20">' . esc_textarea( $field['value'] ) . '</textarea> ';
	
				if ( ! empty( $field['description'] ) ) {
	
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . ( $field['description'] ) . '</span>';
					}
	
				}
				echo '</p>';
				break;
			case 'textarea':
				echo '<p  '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field "><label for="' . esc_attr( $field['id'] ) . '">' . ( $field['label'] ) . '</label><textarea name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" rows="5" cols="20">' . esc_textarea( $field['value'] ) . '</textarea> ';
	
				if ( ! empty( $field['description'] ) ) {
	
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . ( $field['description'] ) . '</span>';
					}
	
				}
				echo '</p>';
				break;
			case 'recipient':
				echo '<div  '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field "><label for="' . esc_attr( $field['id'] ) . '">' . ( $field['label'] ) . '</label>';
				//echo '<textarea name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" rows="5" cols="20">' . esc_textarea( $field['value'] ) . '</textarea> ';
	
				$values = (array)$field['value'];
				echo '<table  cellspacing="0" data-name="' . esc_attr( $field['name'] ) . '" class="dhvc-form-recipient-lists">';
				echo '<thead><tr><td>'.__('Email','dhvc-form').'</td><td></td></tr></thead>';
				echo '<tbody>';
				foreach ($values as $val){
					echo '<tr>';
					echo '<td>';
					echo '<input type="text" name="' . esc_attr( $field['name'] ) . '[]" value="'.esc_attr($val).'" />';
					echo '</td>';
					echo '<td>';
					echo '<a href="#" class="button" onclick="return dhvc_form_recipient_remove(this)">'.__('Remove','dhvc-form').'</a>';
					echo '</td>';
					echo '</tr>';
				}
				echo '<thead><tr><td><a href="#" class="button" onclick="return dhvc_form_recipient_add(this)">'.__('Add','dhvc-form').'</a></td><td></td></tr></thead>';
				echo '</tbody>';
				echo '</table>';
				if ( ! empty( $field['description'] ) ) {
	
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . ( $field['description'] ) . '</span>';
					}
	
				}
				echo '</div>';
				break;
					
			case 'checkbox':
	
				$field['cbvalue']       = isset( $field['cbvalue'] ) ? $field['cbvalue'] : 'yes';
	
				echo '<p '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field"><label for="' . esc_attr( $field['id'] ) . '">' . ( $field['label'] ) . '</label><input class="checkbox" type="checkbox" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['cbvalue'] ) . '" ' . checked( $field['value'], $field['cbvalue'], false ) . ' /> ';
	
				if ( ! empty( $field['description'] ) ) echo '<span class="description">' . ( $field['description'] ) . '</span>';
	
				echo '</p>';
				break;
			case 'checklist':
				$field['options']       = isset( $field['options'] ) ? $field['options'] : array();
	
				echo '<p '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field"><label for="' . esc_attr( $field['id'] ) . '">' . ( $field['label'] ) . '</label>';
	
				foreach ( $field['options'] as $key => $value ) {
					echo '<input class="checkbox" type="checkbox" '.(in_array(esc_attr($key), $field['value']) ? 'checked':'').' name="' . esc_attr( $field['name'] ) . '[]" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $key ) . '"  /> '.esc_html( $value ) .'<br/>';
	
				}
	
	
				if ( ! empty( $field['description'] ) ) {
	
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . ( $field['description'] ) . '</span>';
					}
	
				}
				echo '</p>';
				break;
			case 'select':
				$field['options']       = isset( $field['options'] ) ? $field['options'] : array();
	
				echo '<p '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field"><label for="' . esc_attr( $field['id'] ) . '">' . ( $field['label'] ) . '</label><select id="' . esc_attr( $field['id'] ) . '" name="' . esc_attr( $field['id'] ) . '">';
	
				foreach ( $field['options'] as $key => $value ) {
	
					echo '<option value="' . esc_attr( $key ) . '" ' . selected( esc_attr( $field['value'] ), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
	
				}
	
				echo '</select> ';
	
				if ( ! empty( $field['description'] ) ) {
	
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . ( $field['description'] ) . '</span>';
					}
	
				}
				echo '</p>';
				break;
			case 'select_recipient':
				$form_control = get_post_meta($post->ID,'_form_control',true);
				if($form_control){
					$form_control_arr = $form_control;
					if(is_array($form_control_arr) && !empty($form_control_arr)){
						$options = array();
						foreach ($form_control_arr as $control){
							if($control['tag'] == 'dhvc_form_email'){
								$option_label = !empty($control['control_label']) ? $control['control_label'] : $control['control_name'];
								if(!empty($control['control_name']))
									$options[$control['control_name']] = $option_label;
							}
						}
						$field['options']       = $options;
	
						echo '<p '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field"><label for="' . esc_attr( $field['id'] ) . '">' . ( $field['label'] ) . '</label>';
						if(!empty($options)){
							echo '<select id="' . esc_attr( $field['id'] ) . '" name="' . esc_attr( $field['id'] ) . '">';
							echo '<option value="" ></option>';
							foreach ( $field['options'] as $key => $value ) {
									
								echo '<option value="' . esc_attr( $key ) . '" ' . selected( esc_attr( $field['value'] ), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
									
							}
								
							echo '</select> ';
						}
	
						if ( ! empty( $field['description'] ) ) {
	
							if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
								echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
							} else {
								echo '<span class="description">' . ( $field['description'] ) . '</span>';
							}
	
						}
						echo '</p>';
					}
				}
				break;
			case 'radio':
				$field['options']       = isset( $field['options'] ) ? $field['options'] : array();
				echo '<fieldset '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field"><legend>' . ( $field['label'] ) . '</legend><ul class="dhvc-form-meta-radios">';
	
				foreach ( $field['options'] as $key => $value ) {
	
					echo '<li><label><input
				        		name="' . esc_attr( $field['name'] ) . '"
				        		value="' . esc_attr( $key ) . '"
				        		type="radio"
								class="radio"
				        		' . checked( esc_attr( $field['value'] ), esc_attr( $key ), false ) . '
				        		/> ' . esc_html( $value ) . '</label>
				    	</li>';
				}
				echo '</ul>';
	
				if ( ! empty( $field['description'] ) ) {
	
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' .DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . ( $field['description'] ) . '</span>';
					}
	
				}
				echo '</fieldset>';
				break;
					
			default:
				break;
		}
	
	}
}

new DHVCForm_Metabox();