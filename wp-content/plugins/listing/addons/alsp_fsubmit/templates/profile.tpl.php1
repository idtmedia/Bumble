<?php global $ALSP_ADIMN_SETTINGS; ?>

	<div class="row userprofile clearfix">
		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
			<?php

				global $user_ID, $user_identity, $user_level,$wpdb;

				if ($user_ID) {

					if(isset($_POST['profile_pic']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
						if(isset($_POST['your_author_image_url'])){
							$your_image_url = esc_sql($_POST['your_author_image_url']);
						}else{
							$your_image_url = get_user_meta($user_ID, "pacz_author_avatar_url", true);
						}
						$author_avatar_url = get_user_meta($user_ID, "pacz_author_avatar_url", true); 
						if($your_image_url != 'your_author_image_url'){
							update_user_meta( $user_ID, 'pacz_author_avatar_url', $your_image_url );
						}else{
							update_user_meta( $user_ID, 'pacz_author_avatar_url', $author_avatar_url );
						}
					}	
				}	
		
			?>
			<div class="profile-img clearfix">
				<div class="profile-img-inner clearfix">		
				<?php
					require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php"; 
					
					$author_avatar_url = get_user_meta($user_ID, "pacz_author_avatar_url", true); 

					if(!empty($author_avatar_url)) {

						$params = array( 'width' => 370, 'height' => 450, 'crop' => true );

						echo "<img class='pacz-user-avatar' src='" . bfi_thumb( "$author_avatar_url", $params ) . "' alt='' />";

					} else { 

						$avatar_url = pacz_get_avatar_url ( get_the_author_meta('user_email', $user_ID), $size = '370' );
						?>
						<img class="pacz-user-avatar" src="<?php echo $avatar_url; ?>" alt="" />

				<?php } ?>
						
					<div class="author-avatar-btn pull-left">
						<a href="#" class="panel-btn1 choose-author-image"><?php _e('Choose', 'ALSP') ?></a>
					</div>
					<div class="pacz-user-avatar-delete pull-right"><a href="#" class="panel-btn1"><?php _e('Remove', 'ALSP') ?></a></div>
					<div class="clearfix"></div>
					<form class="" action="" id="czform" method="POST" enctype="multipart/form-data">

						<?php if ($user_ID) {

							$user_info = get_userdata($user_ID);

						?>

						
						<input class="pacz-image-url" id="your_image_url" type="text" size="36" name="your_author_image_url" style="display: none;" value="<?php if (isset($your_image_url)){ echo $your_image_url; } ?>" />
						<input class="pacz-image-id" id="your_image_id" type="text" size="36" name="your_author_image_id" style="display: none;" value="your_author_image_id" />
								
						<div class="save-avatar-btn">
							<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
							<input type="hidden" name="submitted" id="submitted" value="true" />
							<div class="clearfix"></div>
							<input class="profile-avatar-btn" name="profile_pic" type="submit" value="<?php _e('SAVE', 'ALSP'); ?>"/>
						</div>

						<?php } else { 

							$pacz_redirect_to = home_url()."/login";//login url

							wp_safe_redirect($pacz_redirect_to);	

						} ?>

					</form>
				</div>
			</div>
			<?php
				
				$user_code_string = esc_attr($frontend_controller->user->user_email);
				$verification_code = md5($user_code_string);
				//if ($user_ID) {
					
					if(isset($_POST['SEND_VCODE']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
						update_user_meta( $user_ID, 'author_vcode', $_POST['author_vcode'] );
						
						$to = esc_attr($frontend_controller->user->user_email);
						$subject = esc_html__('Author Verification', 'ALSP');
						$body = esc_html__('Please Copy your Verification Code : ', 'ALSP'). $_POST['author_vcode'];
						$headers = array('Content-Type: text/html; charset=UTF-8');
						 
						wp_mail( $to, $subject, $body, $headers );
					}
					if(isset($_POST['CONFIRM_VCODE'])) {
						$user_x_email = esc_attr($frontend_controller->user->user_email);
						$dbcode = get_the_author_meta('author_vcode', $user_ID);
						$confirm_code = $_POST['author_vcode_confirm'];
						if($confirm_code == $dbcode){
							update_user_meta( $user_ID, 'author_verified', 'verified');
							update_user_meta( $user_ID, 'author_verified_email', $user_x_email);
							
						}else{
							update_user_meta( $user_ID, 'author_verified', 'unverified');
						}
					}
					$user_new_email = esc_attr($frontend_controller->user->user_email);
					$user_x_verified_email = get_the_author_meta('author_verified_email', $user_ID);
					if($user_new_email != $user_x_verified_email){
						update_user_meta( $user_ID, 'author_verified', 'unverified');
					}
				//}
			?>
			<?php
				$verified_author = get_the_author_meta('author_verified', $user_ID); 
				$verification_code_sent = get_the_author_meta('author_vcode', $user_ID); 
				if($verified_author == 'unverified'){
			?>
			<div class="verified-author-code">
				<form action="" id="authorcodeform" method="POST" enctype="multipart/form-data">
					<input class="" type="hidden" name="author_vcode" value="<?php echo $verification_code; ?>" />
					<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
					<button class="btn form-submit" id="SEND_VCODE" name="SEND_VCODE" type="submit"><?php echo esc_html__('Get Verification Code', 'ALSP'); ?></button>
				</form>
			</div>
			
				<?php }else{ ?>
					<div class="author-verified"><?php echo esc_html__('Verified', 'ALSP'); ?><i class="pacz-icon-check-circle"></i></div>
				<?php } ?>
			<?php if(isset($verification_code_sent) && !empty($verification_code_sent) && $verified_author == 'unverified'){ ?>
			<div class="verified-author-form">
				<form action="" id="authorcodeform2" method="POST" enctype="multipart/form-data">
					<input class="" type=="text" name="author_vcode_confirm" placeholder="<?php esc_html__('Insert Code Here', 'ALSP'); ?>" />
					<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
					<button class="btn form-submit" id="CONFIRM_VCODE" name="CONFIRM_VCODE" type="submit"><?php echo esc_html__('Verify', 'ALSP'); ?></button>
					
				</form>
				
			</div>
			<?php } ?>
		</div>
		<div class="col-lg-9 col-md-8 col-sm-6 col-xs-12">
			<form action="" method="POST" role="form">
			
				<input type="hidden" name="referer" value="<?php echo $frontend_controller->referer; ?>" />
				<input type="hidden" name="rich_editing" value="<?php echo ($frontend_controller->user->rich_editing) ? 1 : 0; ?>" />
				<input type="hidden" name="admin_color" value="<?php echo ($frontend_controller->user->admin_color) ? $frontend_controller->user->admin_color : 'fresh'; ?>" />
				<input type="hidden" name="admin_bar_front" value="<?php echo ($frontend_controller->user->show_admin_bar_front) ? 1 : 0; ?>" />

				<div class="form-group clearfix">
				
					<p>
						<label for="user_login"><?php _e('Username', 'ALSP'); ?></label>
						<input type="text" name="user_login" class="form-control" value="<?php echo esc_attr($frontend_controller->user->user_login); ?>" disabled="disabled" />
					</p>
					<p>
						<label for="first_name"><?php _e('First Name', 'ALSP') ?></label>
						<input type="text" name="first_name" class="form-control" value="<?php echo esc_attr($frontend_controller->user->first_name); ?>" />
					</p>
					<p>
						<label for="last_name"><?php _e('Last Name', 'ALSP') ?></label>
						<input type="text" name="last_name" class="form-control" value="<?php echo esc_attr($frontend_controller->user->last_name); ?>" />
					</p>
					<p>
						<label for="nickname"><?php _e('Nickname', 'ALSP') ?> <span class="description"><?php _e('(required)', 'ALSP'); ?></span></label>
						<input type="text" name="nickname" class="form-control" value="<?php echo esc_attr($frontend_controller->user->nickname); ?>" />
					</p>
					<p>
						<label for="display_name"><?php _e('Display to Public as', 'ALSP') ?></label>
						<select name="display_name" class="form-control">
						<?php
							$public_display = array();
							$public_display['display_username']  = $frontend_controller->user->user_login;
							$public_display['display_nickname']  = $frontend_controller->user->nickname;
							if (!empty($profileuser->first_name))
								$public_display['display_firstname'] = $frontend_controller->user->first_name;

							if (!empty($profileuser->last_name))
								$public_display['display_lastname'] = $frontend_controller->user->last_name;

							if (!empty($profileuser->first_name) && !empty($profileuser->last_name)) {
								$public_display['display_firstlast'] = $frontend_controller->user->first_name . ' ' . $frontend_controller->user->last_name;
								$public_display['display_lastfirst'] = $frontend_controller->user->last_name . ' ' . $frontend_controller->user->first_name;
							}

							if (!in_array($frontend_controller->user->display_name, $public_display)) // Only add this if it isn't duplicated elsewhere
								$public_display = array('display_displayname' => $frontend_controller->user->display_name) + $public_display;

							$public_display = array_map('trim', $public_display);
							$public_display = array_unique($public_display);
							foreach ($public_display as $id => $item) {
						?>
							<option id="<?php echo $id; ?>" value="<?php echo esc_attr($item); ?>"<?php selected($frontend_controller->user->display_name, $item); ?>><?php echo $item; ?></option>
						<?php
							}
						?>
						</select>
					</p>
					<?php if ($ALSP_ADIMN_SETTINGS['frontend_panel_user_type']){ ?>
					<p>
						<label for="user_type"><?php _e('User Type', 'ALSP') ?></label>
						<select name="user_type" class="form-control">
							<?php
							$selected_option = $frontend_controller->user->_user_type;
							if($selected_option == 'dealer'){
								$option_name = esc_html__('Dealer', 'ALSP');
							}else if($selected_option == 'individual'){
								$option_name = esc_html__('Individual', 'ALSP');
							}else if($selected_option == 'agency'){
								$option_name = esc_html__('Agency', 'ALSP');
							}else if($selected_option == 'supplier'){
								$option_name = esc_html__('Supplier', 'ALSP');
							}
							if(isset($selected_option) && !empty($selected_option)){ ?>
								<option value="<?php echo esc_attr($selected_option); ?>"><?php echo $option_name; ?></option>
							<?php }else{ ?>
								<option value=""><?php echo esc_html__('Select User Type', 'ALSP');  ?></option>
							
							<?php } ?>
							<option value="dealer"><?php echo esc_html__('Dealer', 'ALSP') ?></option>
							<option value="individual"><?php echo esc_html__('Individual', 'ALSP') ?></option>
							<option value="agency"><?php echo esc_html__('Agency', 'ALSP') ?></option>
							<option value="supplier"><?php echo esc_html__('Supplier', 'ALSP') ?></option>
						</select>
					</p>
					<?php } ?>
					<p>
						<label for="email"><?php _e('E-mail', 'ALSP'); ?> <span class="description"><?php _e('(required)', 'ALSP'); ?></span></label>
						<input type="text" name="email" class="form-control" value="<?php echo esc_attr($frontend_controller->user->user_email); ?>" />
					</p>
					<?php if ($ALSP_ADIMN_SETTINGS['frontend_panel_user_website']){ ?>
					<p>
						<label for="user_url"><?php _e('Website', 'ALSP'); ?></label>
						<input type="text" name="user_website" class="form-control" value="<?php echo esc_attr($frontend_controller->user->user_website); ?>" />
					</p>
					<?php } ?>
					<?php if ($ALSP_ADIMN_SETTINGS['frontend_panel_user_phone']){ ?>
					<p>
						<label for="user_phone"><?php _e('Phone Number', 'ALSP'); ?></label>
						<input type="text" name="user_phone" class="form-control" value="<?php echo esc_attr($frontend_controller->user->user_phone); ?>" />
					</p>
					<?php } ?>
					<?php if ($ALSP_ADIMN_SETTINGS['frontend_panel_social_links']){ ?>
					<div class="clearfix"></div>
					<p>
						<label for="email"><?php _e('Facebook', 'ALSP'); ?></label>
						<input type="text" name="author_fb" class="form-control" value="<?php echo esc_attr($frontend_controller->user->author_fb); ?>" />
					</p>
					<p>
						<label for="tw"><?php _e('Twitter', 'ALSP'); ?></label>
						<input type="text" name="author_tw" class="form-control" value="<?php echo esc_attr($frontend_controller->user->author_tw); ?>" />
					</p>
					<p>
						<label for="email"><?php _e('Linkedin', 'ALSP'); ?></label>
						<input type="text" name="author_linkedin" class="form-control" value="<?php echo esc_attr($frontend_controller->user->author_linkedin); ?>" />
					</p>
					<p>
						<label for="email"><?php _e('Google Plus', 'ALSP'); ?></label>
						<input type="text" name="author_gplus" class="form-control" value="<?php echo esc_attr($frontend_controller->user->author_gplus); ?>" />
					</p>
					<p>
						<label for="email"><?php _e('Behance', 'ALSP'); ?></label>
						<input type="text" name="author_behance" class="form-control" value="<?php echo esc_attr($frontend_controller->user->author_behance); ?>" />
					</p>
					<p>
						<label for="email"><?php _e('Dribbble', 'ALSP'); ?></label>
						<input type="text" name="author_dribbble" class="form-control" value="<?php echo esc_attr($frontend_controller->user->author_dribbble); ?>" />
					</p>
					<p>
						<label for="email"><?php _e('Instagram', 'ALSP'); ?></label>
						<input type="text" name="author_instagram" class="form-control" value="<?php echo esc_attr($frontend_controller->user->author_instagram); ?>" />
					</p>
					<p>
						<label for="email"><?php _e('YouTube', 'ALSP'); ?></label>
						<input type="text" name="author_ytube" class="form-control" value="<?php echo esc_attr($frontend_controller->user->author_ytube); ?>" />
					</p>
					<p>
						<label for="email"><?php _e('Vimeo', 'ALSP'); ?></label>
						<input type="text" name="author_vimeo" class="form-control" value="<?php echo esc_attr($frontend_controller->user->author_vimeo); ?>" />
					</p>
					<p>
						<label for="email"><?php _e('Flickr', 'ALSP'); ?></label>
						<input type="text" name="author_flickr" class="form-control" value="<?php echo esc_attr($frontend_controller->user->author_flickr); ?>" />
					</p>
					<?php } ?>
					<p>
						<label for="email"><?php _e('Address', 'ALSP'); ?></label>
						<input type="text" name="address" class="form-control" value="<?php echo esc_attr($frontend_controller->user->address); ?>" />
					</p>
					<div class="clearfix"></div>
					<div class="billing-fileds">
					<?php //endif; ?>
						<?php if ($ALSP_ADIMN_SETTINGS['alsp_payments_addon'] == 'alsp_buitin_payment'): ?>
						<h3><?php _e('Billing information', 'ALSP'); ?></h3>
						<p>
							<label for="alsp_billing_name"><?php _e('Full name', 'ALSP'); ?></label>
							<input type="text" name="alsp_billing_name" class="form-control" value="<?php echo esc_attr($frontend_controller->user->alsp_billing_name) ?>" />
						</p>
						<p>
							<label for="alsp_billing_address"><?php _e('Full Address', 'ALSP'); ?></label>
							<textarea name="alsp_billing_address" id="alsp_billing_address" class="form-control" rows="3"><?php echo esc_textarea($frontend_controller->user->alsp_billing_address); ?></textarea>
						</p>
						<?php endif; ?>
					</div>
						 <div class="userpass">
							<label for="pass1"><?php _e('New Password', 'ALSP'); ?></label>
							<div class="user-pass1-wrap">
								<button type="button" class="button button-secondary wp-generate-pw hide-if-no-js"><?php _e('Generate Password', 'ALSP'); ?></button>
								<div class="wp-pwd hide-if-js">
									<span class="password-input-wrapper">
										<input type="password" name="pass1" id="pass1" class="regular-text" value="" autocomplete="off" data-pw="<?php echo esc_attr(wp_generate_password(24)); ?>" aria-describedby="pass-strength-result" />
										<div class="user-pass2-wrap hide-if-js"><input name="pass2" type="password" id="pass2" class="regular-text" value="" autocomplete="off" /></div>
									</span>
									<button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e('Hide password', 'ALSP'); ?>">
										<span class="dashicons dashicons-hidden"></span>
										<span class="text"><?php _e('Hide', 'ALSP'); ?></span>
									</button>
									<button type="button" class="button button-secondary wp-cancel-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e('Cancel password change', 'ALSP'); ?>">
										<span class="text"><?php _e('Cancel', 'ALSP'); ?></span>
									</button>
									<div style="display:none" id="pass-strength-result" aria-live="polite"></div>
								</div>
							</div>
						</div>
					<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr($frontend_controller->user->ID); ?>" />
					<?php require_once(ABSPATH . 'wp-admin/includes/template.php'); ?>
					<?php submit_button(__('Save changes', 'ALSP'), 'btn btn-primary'); ?>
				</div>
				
			</form>
		</div>
	</div>
	<script>
									var image_custom_uploader;
									var $thisItem = '';

									jQuery(document).on('click','.choose-author-image', function(e) {
										e.preventDefault();

										$thisItem = jQuery(this);
										$form = jQuery('#czform');

										//If the uploader object has already been created, reopen the dialog
										if (image_custom_uploader) {
										    image_custom_uploader.open();
										    return;
										}
										var image_custom_uploader = wp.media({
			            title : '',
			            multiple : false,
			            library : { type : 'image'},
			            button : { text : '<?php echo esc_html__('Insert', 'ALSP'); ?>' },
			        });
										

										//When a file is selected, grab the URL and set it as the text field's value
										image_custom_uploader.on('select', function() {
										    attachment = image_custom_uploader.state().get('selection').first().toJSON();
										    var url = '';
										    url = attachment['url'];
										    var attachId = '';
										    attachId = attachment['id'];
											
										   jQuery( "img.pacz-user-avatar" ).attr({
										        src: url
										    });
										  $form.parent().parent().find( ".pacz-image-url" ).attr({
										        value: url
										    });
										    $form.parent().parent().find( ".pacz-image-id" ).attr({
										        value: attachId
										    });
										});

										//Open the uploader dialog
										image_custom_uploader.open();
									});

									jQuery(document).on('click','.pacz-user-avatar-delete', function(e) {
										jQuery(this).parent().parent().find( ".pacz-image-url" ).attr({
										   value: ''
										});
										jQuery(this).parent().parent().find( "img.pacz-user-avatar" ).attr({
										     src: ''
										});
									});
								</script>