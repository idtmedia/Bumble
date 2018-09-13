<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Difp_Form'))
{
  class Difp_Form
  {
 	private static $instance;
	
	private $priority = 0;
	
	public static function init()
        {
            if(!self::$instance instanceof self) {
                self::$instance = new self;
            }
            return self::$instance;
        }
		
    function actions_filters()
    {
    }
	
	public function form_fields( $where = 'newmessage' )
{
	if($where == 'shortcode-newbidding'){
		$type ='hidden';
	}else{
		$type ='text';
	}
	$fields = array(
				'message_to' => array(
					'label'       => __( 'To', 'ALSP' ),
					//'description' => __( 'Name of the receipent you want to send message.', 'ALSP' ),
					'type'        => 'message_to',
					'required'    => true,
					'placeholder' => __( 'Name of the receipent.', 'ALSP' ),
					'noscript-placeholder' => __( 'Username of the receipent.', 'ALSP' ),
					'value' => '',
					'id' => 'difp-message-to',
					'name' => 'message_to',
					'class' => 'input-text',
					'suggestion' => (difp_get_option('hide_autosuggest') != '1' || difp_is_user_admin() ),
					'priority'    => 5
				),
				'message_title' => array(
					'label'       => __( 'Subject', 'ALSP' ),
					//'description' => __( 'Enter your message subject here', 'ALSP' ),
					'type'        => $type,
					'required'    => true,
					'placeholder' => __( 'Subject', 'ALSP' ),
					'minlength'	=> 5,
					'maxlength' => 100,
					'disabled' => false,
					'value' => '',
					'id' => 'message_title',
					'name' => 'message_title',
					'class' => 'input-text',
					'priority'    => 10,
					'where'	=> array( 'newmessage', 'shortcode-newmessage', 'shortcode-newbidding' )
				),
				'message_post_id' => array(
					//'label'       => __( 'Subject', 'ALSP' ),
					//'description' => __( 'Enter your message subject here', 'ALSP' ),
					'type'        => 'hidden',
					//'required'    => true,
					//'placeholder' => __( 'Subject', 'ALSP' ),
					//'minlength'	=> 5,
					//'maxlength' => 100,
					'disabled' => false,
					'value' => '',
					'id' => ' ',
					'name' => 'message_post_id',
					'class' => 'input-text',
					'priority'    => 10,
					'where'	=> array( 'newmessage', 'shortcode-newmessage', 'shortcode-newbidding' )
				),
				'message_bid' => array(
					'label'       => __( 'Your Bid', 'ALSP' ),
					'description' => __( 'Enter Your Bidding Amount here', 'ALSP' ),
					'type'        => 'text',
					'required'    => '',
					'placeholder' => __( 'Bidding Amount', 'ALSP' ),
					//'minlength'	=> 5,
					//'maxlength' => 100,
					'disabled' => false,
					'value' => '',
					'id' => 'message_bid',
					'name' => 'message_bid',
					'class' => 'input-text',
					'priority'    => 10,
					'where'	=> 'shortcode-newbidding',
				),
				'message_content' => array(
					'label'       => __( 'Message', 'ALSP' ),
					'type'        => ( 'shortcode-newmessage' == $where ||'shortcode-newbidding' == $where ) ? 'textarea' : difp_get_option('editor_type','wp_editor'),
					//Ajax form submit creating problem with wp_editor
					'required'    => true,
					'minlength'	=> '',
					'maxlength' => 5000,
					'placeholder' => '',
					'priority'    => 15,
					'value'     => '',
					'where'	=> array( 'newmessage', 'reply', 'shortcode-newmessage', 'shortcode-newbidding' )
				),
				'shortcode-message-to' => array(
					'type'        => 'shortcode-message-to',
					'name' => 'message_to',
					'value'    => '',
					'where'    => array('shortcode-newmessage', 'shortcode-newbidding')
				),
				'wp_token' => array(
					'type'        => 'wp_token',
					'name'        => 'token',
					'value'    => wp_create_nonce('difp_message'),
					'token-action'    => 'difp_message',
					'where'    => array('shortcode-newmessage', 'shortcode-newbidding')
				),
				'token' => array(
					'type'        => 'token',
					'value'    => difp_create_nonce('difp_message'),
					'token-action'    => 'difp_message',
					'where'    => array( 'newmessage', 'reply' )
				),
				'difp_parent_id' => array(
					'type'        => 'difp_parent_id',
					'value'    	=> 0,
					'priority'    => 30,
					'where'	=> array( 'reply' )
				),
				'allow_messages' => array(
					'type'        => 'checkbox',
					'value'    => difp_get_user_option( 'allow_messages', 1),
					'cb_label'    => __("Allow others to send me messages?", 'ALSP'),
					'where'    => 'settings'
				),
				'allow_emails' => array(
					'type'        => 'checkbox',
					'value'    => difp_get_user_option( 'allow_emails', 1),
					'cb_label'    => __("Email me when I get new messages?", 'ALSP'),
					'where'    => 'settings'
				),
				'allow_ann' => array(
					'type'        => 'checkbox',
					'value'    => difp_get_user_option( 'allow_ann', 1),
					'cb_label'    => __("Email me when new announcement is published?", 'ALSP'),
					'where'    => 'settings'
				),
				'settings_token' => array(
					'type'        => 'token',
					'value'    => difp_create_nonce('settings'),
					'token-action'    => 'settings',
					'where'    => 'settings'
				),
					
				);
			if ( '1' == difp_get_option('allow_attachment', 1)) {
				$fields['difp_upload'] = array(
					'type'        => 'file',
					'value'    => '',
					'priority'    => 20,
					'where'    => array( 'newmessage', 'reply' )
				);
			}
				
		$fields = apply_filters( 'difp_form_fields', $fields );

		
		foreach ( $fields as $key => $field )
		{
			if ( empty($field['where']) )
				$field['where'] = array( 'newmessage' );
			
			if( is_array($field['where'])){
				if ( ! in_array(  $where, $field['where'] )){
					unset($fields[$key]);
					continue;
				}
			} else {
				if ( $where != $field['where'] ){
					unset($fields[$key]);
					continue;
				}
			}
			$this->priority += 2;
			
			$defaults = array(
					'label'	=> '',
					'key'		=> $key,
					'type'		=> 'text',
					'name'		=> $key,
					'class'		=> '',
					'id'		=> $key,
					'value'		=> '',
					'placeholder'=> '',
					'priority'	=> $this->priority
					);
			$fields[$key] = wp_parse_args( $field, $defaults);
		}
		
		$fields = apply_filters( 'difp_form_fields_after_process', $fields );

		uasort( $fields, 'difp_sort_by_priority' );

		return $fields;
}
	
function field_output( $field, $errors )
	{
		 if ( $errors->get_error_message( $field['id'] ) ) : ?>
		<div class="difp-error">
		<?php echo $errors->get_error_message( $field['id'] ); ?>
		<?php $errors->remove($field['id']); ?>
		</div>
		<?php endif;
		$attrib = ''; 
		if ( ! empty( $field['required'] ) ) $attrib .= 'required = "required" ';
		if ( ! empty( $field['readonly'] ) ) $attrib .= 'readonly = "readonly" ';
		if ( ! empty( $field['disabled'] ) ) $attrib .= 'disabled = "disabled" ';
		if ( ! empty( $field['minlength'] ) ) $attrib .= 'minlength = "' . absint( $field['minlength'] ) . '" ';
		if ( ! empty( $field['maxlength'] ) ) $attrib .= 'maxlength = "' . absint( $field['maxlength'] ) . '" ';
		 
		if ( ! empty( $field['class'] ) ){
			$field['class'] = explode( ' ', $field['class'] );
			$field['class'] = array_map( 'sanitize_html_class', $field['class'] );
			$field['class'] = implode( ' ', array_filter( $field['class'] ) );
		}
		
		?><div class="difp-form-field"><?php if ( !empty($field['label']) ) { ?>
			<div class="difp-label"><label for="<?php echo esc_attr( $field['id'] ); ?>"><?php echo esc_html( $field['label'] ) ; ?>: <?php if ( ! empty( $field['required'] ) ) : ?><span class="required">*</span><?php endif; ?></label></div>
			<?php } ?>
			<div class="difp-field"><?php
			
		switch( $field['type'] ) {
		
				case has_action( 'difp_form_field_output_' . $field['type'] ):
				
				do_action( 'difp_form_field_output_' . $field['type'], $field, $errors );
				
				break;
			
				case 'text' :
				case 'email' :
				case 'url' :
				case 'number' :
				case 'hidden' :
				case 'submit' :
					?><input id="<?php esc_attr_e( $field['id'] ); ?>" class="<?php echo $field['class']; ?>" type="<?php esc_attr_e( $field['type'] ); ?>" name="<?php esc_attr_e( $field['name'] ); ?>" placeholder="<?php esc_attr_e( $field['placeholder'] ); ?>" value="<?php esc_attr_e( $field['posted-value' ] ); ?>" <?php echo $attrib; ?> /><?php

					break;
				case 'message_to' :
					
					if( isset( $_REQUEST['difp_to'] ) ) {
						$to = $_REQUEST['difp_to'];
					} else {
						$to = (isset($_REQUEST['to']))? $_REQUEST['to']:'';
					}
					
					if( ! empty( $field['posted-value' ] ) ) {
						$message_to = difp_get_userdata( $field['posted-value' ], 'user_nicename' );
						$message_top = difp_get_userdata( $message_to, 'display_name' );
					} elseif( $to ){
						$support = array(
							'nicename' 	=> true,
							'id' 		=> true,
							'email' 	=> true,
							'login' 	=> true
							);
						
						$support = apply_filters( 'difp_message_to_support', $support );
							
						if ( !empty( $support['nicename'] ) && $user = difp_get_userdata( $to, 'user_nicename' ) ) {
							$message_to = $user;
							$message_top = difp_get_userdata( $user, 'display_name');
						} elseif( is_numeric( $to ) && !empty( $support['id'] ) && $user = difp_get_userdata( $to, 'user_nicename', 'id' ) ) {
							$message_to = $user;
							$message_top = difp_get_userdata( $user, 'display_name');
						} elseif ( is_email( $to ) && !empty( $support['email'] ) && $user = difp_get_userdata( $to, 'user_nicename', 'email' ) ) {
							$message_to = $user;
							$message_top = difp_get_userdata( $user, 'display_name');
						} elseif ( !empty( $support['login'] ) && $user = difp_get_userdata( $to, 'user_nicename', 'login' ) ) {
							$message_to = $user;
							$message_top = difp_get_userdata( $user, 'display_name');
						} else {
							$message_to = '';
							$message_top = '';
						}
					} else {
						$message_to = '';
						$message_top = '';
					}

						if( ! empty($field['suggestion'])) : ?>
							<?php wp_enqueue_script( 'difp-script' ); ?>
							
							<input type="hidden" name="message_to" id="difp-message-to" autocomplete="off" value="<?php echo esc_attr( $message_to ); ?>" />
							
							<input type="text" class="<?php echo $field['class']; ?>" name="message_top" id="difp-message-top" autocomplete="off" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>" value="<?php echo esc_attr( $message_top ); ?>" />
							<div id="difp-result"></div>
							
						<?php else : ?>
							
							<input type="text" class="<?php echo $field['class']; ?>" name="message_to" id="difp-message-top" placeholder="<?php echo esc_attr( $field['noscript-placeholder'] ); ?>" autocomplete="off" value="<?php echo esc_attr( $message_to ); ?>" />
							
						<?php endif;

					break;
				case "textarea" :

							?><textarea id="<?php esc_attr_e( $field['id'] ); ?>" class="<?php echo $field['class']; ?>" cols="50" name="<?php esc_attr_e( $field['name'] ); ?>" placeholder="<?php esc_attr_e( $field['placeholder'] ); ?>" <?php echo $attrib; ?>><?php echo esc_textarea( $field['posted-value' ] ); ?></textarea><?php

					break;
					
				case "wp_editor" :
						
						wp_editor( wp_kses_post( $field['posted-value' ] ), $field['id'], array( 'textarea_name' => $field['name'], 'editor_class' => $field['class'], 'media_buttons' => false) );

					break;
				case "teeny" :
				
							wp_editor( wp_kses_post( $field['posted-value' ] ), $field['id'], array( 'textarea_name' => $field['name'], 'editor_class' => $field['class'], 'teeny' => true, 'media_buttons' => false) );

					break;
					
				case "checkbox" :

							if( ! empty( $field['multiple' ] ) ) {
								foreach( $field['options' ] as $key => $name ) {
								?><label><input id="<?php esc_attr_e( $field['id'] ); ?>" class="<?php echo $field['class']; ?>" name="<?php esc_attr_e( $field['name'] ); ?>[]" type="checkbox" value="<?php esc_attr_e( $key ); ?>" <?php if( in_array( $key, $field['posted-value' ] ) ) { echo 'checked="checked"';} ?> /> <?php esc_attr_e( $name ); ?></label><br /><?php
								}
							} else {

							?><label><input id="<?php esc_attr_e( $field['id'] ); ?>" class="<?php echo $field['class']; ?>" name="<?php esc_attr_e( $field['name'] ); ?>" type="checkbox" value="1" <?php checked( '1', $field['posted-value' ] ); ?> /> <?php esc_attr_e( $field['cb_label'] ); ?></label><?php
							}

					break;
					
				case "select" :

							?><select id="<?php esc_attr_e( $field['id'] ); ?>" class="<?php echo $field['class']; ?>" name="<?php esc_attr_e( $field['name'] ); ?>" <?php echo $attrib; ?>><?php
									foreach( $field['options'] as $key => $name ) {
										?><option value="<?php esc_attr_e( $key ); ?>" <?php selected( $field['posted-value' ], $key ); ?>><?php esc_attr_e( $name ); ?></option><?php }
							?></select><?php
					break;
				
				case "radio" :

						foreach( $field['options'] as $key => $name ) {
							?><label><input type="radio" class="<?php echo $field['class']; ?>" name="<?php esc_attr_e( $field['name'] ); ?>" value="<?php esc_attr_e( $key ); ?>" <?php checked( $field['posted-value' ], $key ); ?> /> <?php esc_attr_e( $name ); ?></label><br /><?php }
					break;
					
				case 'token' :
				case 'wp_token' :
				case 'shortcode-message-to' :
					?><input id="<?php esc_attr_e( $field['id'] ); ?>" class="<?php echo $field['class']; ?>" type="hidden" name="<?php esc_attr_e( $field['name'] ); ?>" value="<?php esc_attr_e( $field['value' ] ); ?>" <?php echo $attrib; ?> /><?php

					break;
				case 'difp_parent_id' :
					?><input id="<?php esc_attr_e( $field['id'] ); ?>" class="<?php echo $field['class']; ?>" type="hidden" name="<?php esc_attr_e( $field['name'] ); ?>" value="<?php esc_attr_e( $field['posted-value' ] ); ?>" <?php echo $attrib; ?> /><?php

					break;
					
				case 'file' :
					wp_enqueue_script( 'difp-attachment-script' );
					?>
						<div id="difp_upload">
							<div id="p-0">
								<input id="<?php esc_attr_e( $field['id'] ); ?>" class="<?php echo $field['class']; ?>" type="file" name="<?php esc_attr_e( $field['name'] ); ?>[]" /><a href="#" onclick="difp_remove_element('p-0'); return false;" class="difp-attachment-field"><?php echo __('Remove', 'ALSP') ; ?></a>
							</div>
						</div>
						<a id="difp-attachment-field-add" href="#" onclick="difp_add_new_file_field(); return false;"><?php echo __('Add new field', 'ALSP') ; ?></a>
						<div id="difp-attachment-note"></div>
						
							<?php
			
					break;
					
				case "action_hook" :

						$field['hook'] = empty($field['hook'] ) ? $field['key'] : $field['hook'] ;
		
						do_action($field['hook'], $field );
						
					break;
				case "function" :
					$field['function'] = empty($field['function'] ) ? $field['key'] : $field['function'];
		
					if(is_callable($field['function']))
					call_user_func($field['function'], $field );
					
				default :
						printf(__('No Function or Hook defined for %s field type', 'ALSP'), $field['type'] );
					
					break;
				
				}
			
		if ( ! empty($field['description']) ) {
			?><div class="description"><?php echo  wp_kses_post( $field['description'] ); ?></div><?php
		}

				?></div></div><?php 
	}
	
	public function validate( $field, $errors )
		{
			if( ! empty( $field['required']) && empty($field['posted-value']) )
			{
				$errors->add($field['id'], ! empty($field['error-message'] ) ? $field['error-message'] : sprintf(__("%s required.", "ALSP"), esc_html( $field['label'] )));
			} 
			elseif( (! empty( $field['readonly']) || ! empty( $field['disabled']) /* || $field['type'] == 'hidden' */ ) && $field['value'] != $field['posted-value'] )
			{
				$errors->add($field['id'], ! empty($field['error-message'] ) ? $field['error-message'] : sprintf(__("%s can not be changed.", "ALSP"), esc_html( $field['label'] )));
			} 
			elseif( ! empty( $field['minlength']) && strlen($field['posted-value']) < absint($field['minlength']) )
			{
				$errors->add($field['id'], ! empty($field['error-message'] ) ? $field['error-message'] : sprintf(__("%s minlength %d.", "ALSP"), esc_html( $field['label'] ), absint($field['minlength'])));
			} 
			elseif( ! empty( $field['maxlength']) && strlen($field['posted-value']) > absint($field['maxlength']) )
			{
				$errors->add($field['id'], ! empty($field['error-message'] ) ? $field['error-message'] : sprintf(__("%s maxlength %d.", "ALSP"), esc_html( $field['label'] ), absint($field['maxlength'])));
			}
		
		}
	
	function field_validate( $field, $errors )
	{
			$this->validate( $field, $errors );
			
		switch( $field['type'] ) {
				
				case has_action( 'difp_form_field_validate_' . $field['type'] ):
				do_action( 'difp_form_field_validate_' . $field['type'], $field, $errors );
				break;
		
				case 'email' :
					if( ! is_email($field['posted-value']) )
						{
							$errors->add($field['id'], ! empty($field['error-message'] ) ? $field['error-message'] : sprintf(__("Please provide valid email address for %s.", "ALSP"), esc_html( $field['label'] )));
						}
				break;
				case 'number' :
					if( ! is_numeric($field['posted-value']) )
						{
							$errors->add($field['id'], ! empty($field['error-message'] ) ? $field['error-message'] : sprintf(__("%s is not a valid number.", "ALSP"), esc_html( $field['label'] )));
						}
				break;
				case 'token':
					if (!difp_verify_nonce( $field['posted-value'], $field['token-action'])) {
        				$errors->add( $field['id'], __("Invalid Token. Please try again!", 'ALSP'));
					}
				break;
				case 'wp_token':
					if (!wp_verify_nonce( $field['posted-value'], $field['token-action'])) {
        				$errors->add( $field['id'], __("Invalid Token. Please try again!", 'ALSP'));
					}
				break;
				case 'message_to' :
				case 'shortcode-message-to' :
					if (!empty($_POST['message_to'])) {
					  	$preTo = $_POST['message_to'];
					 } else {
					  	$preTo = ( isset( $_POST['message_top'] ) ) ? $_POST['message_top']: ''; 
					 }
					  
					  $preTo = apply_filters( 'difp_preto_filter', $preTo ); //return user_nicename
					  
					  if( is_array( $preTo ) ) {
					  $_POST['message_to_id'] = array();
					  
					  	foreach ( $preTo as $pre ) {
							$to = difp_get_userdata( $pre );
							
							if( $to && get_current_user_id() != $to) {
								$_POST['message_to_id'][] = $to;
								if ( difp_get_user_option( 'allow_messages', 1, $to ) != '1') {
									$errors->add( $field['id'] , sprintf(__("%s does not want to receive messages!", 'ALSP'), difp_get_userdata( $to, 'display_name', 'id')));
								}
							} else {
								$errors->add( $field['id'] , sprintf(__('Invalid receiver "%s".', "ALSP"), $pre ) );
							}
						}
					  } else {
					  	$to = $_POST['message_to_id'] = difp_get_userdata( $preTo ); //return ID;
						if (difp_get_user_option( 'allow_messages', 1, $to ) != '1') {
							$errors->add( $field['id'] , sprintf(__("%s does not want to receive messages!", 'ALSP'), difp_get_userdata( $to, 'display_name', 'id')));
						}
						if( get_current_user_id() == $to ) {
							$errors->add( $field['id'] , __('You can not message yourself!', 'ALSP'));
						}
					  }
					  
					  if ( empty($_POST['message_to_id'])) {
							$errors->add( $field['id'] , __('You must enter a valid recipient!', 'ALSP'));
						}

					break;
				case 'difp_parent_id' :
					 if ( empty($field['posted-value']) || $field['posted-value'] != absint($field['posted-value']) || difp_get_parent_id( $field['posted-value'] ) != $field['posted-value'] ) {
					 		$errors->add( $field['id'] , __("Invalid parent ID!", 'ALSP'));
					 } elseif ( ! in_array( get_current_user_id(), difp_get_participants( $field['posted-value'] ) ) ) {
						  	$errors->add( $field['id'] , __("You do not have permission to send this message!", 'ALSP'));
						}
		
					break;
					
				case "checkbox" :
						if( ! empty( $field['multiple' ] ) ) {
							$value = $_POST[$field['name']] = is_array( $field['posted-value'] ) ? $field['posted-value'] : array();
							foreach( $value as $p_value ) {
								if( ! array_key_exists( $p_value, $field['options'] ) ) {
									$errors->add($field['id'], ! empty($field['error-message'] ) ? $field['error-message'] : sprintf(__("Invalid value for %s.", "ALSP"), esc_html( $field['label'] )));
								}
							}
						} else {
							$_POST[$field['name']] = !empty( $_POST[$field['name']] ) ? 1 : 0;
						}

					break;
					
				case "radio" :
				case "select" :

						if( ! array_key_exists( $field['posted-value'], $field['options'] ) ) {
							$errors->add($field['id'], ! empty($field['error-message'] ) ? $field['error-message'] : sprintf(__("Invalid value for %s.", "ALSP"), esc_html( $field['label'] )));
							}
					break;
				
				case "file" :
					$mime = get_allowed_mime_types();

					$size_limit = (int) wp_convert_hr_to_bytes(difp_get_option('attachment_size','4MB'));
					$fields = (int) difp_get_option('attachment_no', 4);
				
					for ($i = 0; $i < $fields; $i++) {
						$tmp_name = isset( $_FILES[$field['name']]['tmp_name'][$i] ) ? basename( $_FILES[$field['name']]['tmp_name'][$i] ) : '' ;
						$file_name = isset( $_FILES[$field['name']]['name'][$i] ) ? basename( $_FILES[$field['name']]['name'][$i] ) : '' ;
				
						//if file is uploaded
						if ( $tmp_name ) {
							$attach_type = wp_check_filetype( $file_name );
							$attach_size = $_FILES[$field['name']]['size'][$i];
				
							//check file size
							if ( $attach_size > $size_limit ) {
								$errors->add('AttachmentSize', sprintf(__( "Attachment (%s) file is too big", 'ALSP' ), esc_html($file_name) ));
							}
				
							//check file type
							if ( !in_array( $attach_type['type'], $mime ) ) {
								$errors->add('AttachmentType', sprintf(__( "Invalid attachment file type. Allowed Types are (%s)", 'ALSP' ),implode(', ',array_keys($mime))));
							}
						} // if $filename
					}// endfor
					break;
					
				default :
					
					do_action( 'difp_form_field_validate', $field, $errors );
	
					break;
				
				}
			
	}
	
	
public function form_field_output( $where = 'newmessage', $errors= '', $value = array() )
{
	$fields = $this->form_fields( $where );
	
	if( ! is_wp_error($errors) )
		$errors = difp_errors();
	
	if( isset( $_GET['difp_id'] ) ){
		$id = absint( $_GET['difp_id'] );
	} else {
		$id = !empty($_GET['id']) ? absint($_GET['id']) : 0;
	}
	  
		$form_attr = array(
			'method' => 'post',
			'class' => 'difp-form'
			);
		
		if( 'settings' == $where ) {
			$form_attr['action'] = difp_query_url( 'settings' );
		} elseif( 'newmessage' == $where ) {
			$form_attr['action'] = difp_query_url( 'newmessage' );
		} elseif( 'reply' == $where && $id ) {
			$form_attr['action'] = difp_query_url( 'viewmessage', array( 'difp_id' => $id ) );
		} else {
			$form_attr['action'] = esc_url( add_query_arg( false, false ) );
		}
		
		if( isset( $fields['difp_upload']) ) {
			$form_attr['enctype'] = 'multipart/form-data';
		}
		
		$form_attr = apply_filters( 'difp_form_attribute', $form_attr, $where );
		
		$attr = array();
		foreach ( $form_attr as $k => $v ) {
			$attr[] = $k . '="' . $v . '"';
		}
		
	ob_start();

		echo '<div class="ALSP-form">';
		echo '<form ';
		echo implode( ' ', $attr );
		echo '>';

		do_action( 'difp_before_form_fields', $where, $errors );

		foreach ( $fields as $key => $field ) {
			$type = ! empty( $field['type'] ) ? $field['type'] : 'text';
			$defaults = array(
								'key'		=> $key,
								'type'		=> $type,
								'name'		=> $key,
								'class'		=> 'input-'. $type,
								'id'		=> $key,
								'value'		=> ''
								);
			$field = wp_parse_args( $field, $defaults);
			if( array_key_exists( $field['name'], $value ) ) {
				$field['value'] = $value[$field['name']];
			}
			$field['posted-value'] = isset( $_REQUEST[$field['name']] ) ? stripslashes_deep( $_REQUEST[$field['name']] ) : $field['value'];
			
			$field = apply_filters( 'difp_filter_form_field_before_output', $field, $where );
			
			if ( has_action( 'difp_form_field_init_output_' . $field['type'] ) ) {
				do_action( 'difp_form_field_init_output_' . $field['type'], $field, $errors );
			} else {
				call_user_func( array( $this, 'field_output' ), $field, $errors );
			} 
		}

		do_action( 'difp_after_form_fields', $where, $errors );
		
		echo difp_error($errors);
		
		if( 'settings' == $where ) {
			$button_val = __('Save Changes', 'ALSP');
		} elseif( 'reply' == $where ) {
			$button_val = __('Reply', 'ALSP');
		} else {
			$button_val = __('Send Message', 'ALSP');
		}
		echo apply_filters( 'difp_form_submit_button', '<button type="submit" class="difp-button" name="difp_action" value="'. esc_attr( $where ) .'">'. esc_html( $button_val ).'</button>', $where );
		
        echo '</form>';
		echo '</div>';
		
		return apply_filters('difp_filter_form_output', ob_get_clean() );
	}

public function validate_form_field( $where = 'newmessage' )
{
		$fields = $this->form_fields( $where );
	
		$errors = difp_errors();

		foreach ( $fields as $key => $field ) {
			$defaults = array(
								'key' => $key,
								'type' => ! empty( $field['type'] ) ? $field['type'] : 'text',
								'name' => $key,
								'id' => $key,
								'value' => ''
								);
			$field = wp_parse_args( $field, $defaults);
			$field['posted-value'] = isset( $_POST[$field['name']] ) ? $_POST[$field['name']] : '';

			if ( has_action( 'difp_form_field_init_validate_' . $field['type'] ) ) {
				do_action( 'difp_form_field_init_validate_' . $field['type'], $field, $errors );
			} else {
				call_user_func( array( $this, 'field_validate' ), $field, $errors);
			}
			$fields[$key] = $field;
		}
		
		do_action('difp_action_validate_form', $where, $errors, $fields );
		
		if(count($errors->get_error_codes())==0){
			//No Errors
			do_action('difp_action_form_validated', $where, $fields);
		} else {
		}
		
		return $errors;
	}
		
	
  } //END CLASS
} //ENDIF

