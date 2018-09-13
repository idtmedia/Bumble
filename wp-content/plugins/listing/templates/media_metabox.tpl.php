<?php if ($listing->level->images_number): 
require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php"; 
?>
<script>
	var images_number = <?php echo $listing->level->images_number; ?>;

	(function($) {
		"use strict";

		window.alsp_image_attachment_tpl = function(attachment_id, uploaded_file, title) {
			
			var image_attachment_tpl = '<div class="alsp-attached-item">' +
				'<input type="hidden" name="attached_image_id[]" value="'+attachment_id+'" />' +
				'<a href="'+uploaded_file+'" data-lightbox="listing_images" class="alsp-attached-item-img">' +
				'<img src="'+uploaded_file+'" alt="" />' +
				'</a>' +
				'<div class="thumb-links clearfix">' +
				<?php if ($listing->level->logo_enabled): ?>
					'<div class="alsp-attached-item-logo alsp-radio checkbox">' +
						'<label>' +
							'<input type="radio" name="attached_image_as_logo" value="`+attachment_id+`">' +
							'<span class="radio-check-item"></span>' +
						'</label>' +
					'</div>' +
					<?php endif; ?>
					'<div class="alsp-attached-item-delete fa fa-trash-o" title="<?php esc_attr_e("remove", "ALSP"); ?>"></div>' +
				'</div>' +
				'</div>';

			return image_attachment_tpl;
		};

		window.alsp_check_images_attachments_number = function() {
			if (images_number > $("#alsp-images-upload-wrapper .alsp-attached-item").length) {
				<?php if (is_admin()): ?>
				$("#alsp-admin-upload-functions").show();
				<?php else: ?>
				$(".alsp-upload-item").show();
				<?php endif; ?>
			} else {
				<?php if (is_admin()): ?>
				$("#alsp-admin-upload-functions").hide();
				<?php else: ?>
				$(".alsp-upload-item").hide();
				<?php endif; ?>
			}
		}

		$(function() {
			alsp_check_images_attachments_number();

			$("#alsp-attached-images-wrapper").on("click", ".alsp-attached-item-delete", function() {
				$(this).parents(".alsp-attached-item").remove();
	
				alsp_check_images_attachments_number();
			});

			<?php if (!is_admin()): ?>
			$(document).on("click", ".alsp-upload-item-button", function(e){
				e.preventDefault();
			
				$(this).parent().find("input").click();
			});

			$('.alsp-upload-item').fileupload({
				sequentialUploads: true,
				dataType: 'json',
				url: '<?php echo admin_url('admin-ajax.php?action=alsp_upload_image&post_id='.$listing->post->ID.'&_wpnonce='.wp_create_nonce('upload_images')); ?>',
				dropZone: $('.alsp-drop-attached-item'),
				add: function (e, data) {
					var jqXHR = data.submit();
				},
				send: function (e, data) {
					alsp_add_iloader_on_element($(this).find(".alsp-drop-attached-item"));
				},
				done: function(e, data) {
					var result = data.result;
					if (result.uploaded_file) {
						$(this).before(alsp_image_attachment_tpl(result.attachment_id, result.uploaded_file, data.files[0].name));
						alsp_custom_input_controls();
					} else {
						$(this).find(".alsp-drop-attached-item").append("<p>"+result.error_msg+"</p>");
					}
					$(this).find(".alsp-drop-zone").show();
					alsp_delete_iloader_from_element($(this).find(".alsp-drop-attached-item"));

					alsp_check_images_attachments_number();
					
					if ($('.alsp-attached-item').length != 0) {
						$('.alsp-upload-item').removeClass('full');
					}else{
						$('.alsp-upload-item').addClass('full');
					}
				}
			});
			<?php endif; ?>
		});
		$(function() {
			if ($('.alsp-attached-item').length != 0) {
				$('.alsp-upload-item').removeClass('full');
			}else{
				$('.alsp-upload-item').addClass('full');
			}
		});
	})(jQuery);
</script>

<div id="alsp-images-upload-wrapper col-md-12" class="alsp-content">
	<p class="alsp-submit-section-label alsp-submit-field-title"><?php _e('Listing images', 'ALSP'); ?></p>
	<div id="alsp-attached-images-wrapper" class="clearfix">
		<?php foreach ($listing->images AS $attachment_id=>$attachment): ?>
		<?php $src = wp_get_attachment_image_src($attachment_id, array(250, 250)); ?>
		<?php $src_full = wp_get_attachment_image_src($attachment_id, 'full');
				require_once PACZ_THEME_PLUGINS_CONFIG . "/image-cropping.php"; 
				$image_src_array = wp_get_attachment_image_src($attachment_id, 'full');
				$image_src  = bfi_thumb($image_src_array[0], array(
					'width' => 132,
					'height' => 102,
					'crop' => true
				));
		?>
		<div class="alsp-attached-item">
			
			<input type="hidden" name="attached_image_id[]" value="<?php echo $attachment_id; ?>" />
			<a href="<?php echo $src_full[0]; ?>" data-lightbox="listing_images" class="alsp-attached-item-img"><img src="<?php echo pacz_thumbnail_image_gen($image_src, 100, 70); ?>" width="250" height="250" alt="<?php echo esc_attr_e($attachment['post_title']); ?>" /></a>
			<div class="thumb-links clearfix">
			<?php if ($listing->level->logo_enabled): ?>
			<div class="alsp-attached-item-logo alsp-radio checkbox">
				<label title="<?php _e("Set as Thumbnail Image", "ALSP"); ?>">
					<input type="radio" name="attached_image_as_logo" value="<?php echo $attachment_id; ?>" <?php checked($listing->logo_image, $attachment_id); ?>>
					<span class="radio-check-item"></span>
				</label>
			</div>
			<?php endif; ?>
			<div class="alsp-attached-item-delete fa fa-trash-o" title="<?php _e("delete", "ALSP"); ?>"></div>
		</div>
		</div>
		<?php endforeach; ?>
		<?php if (!is_admin()): ?>
		<div class="alsp-upload-item full">
			<div class="alsp-drop-attached-item">
				<div class="alsp-drop-zone">
					<div class="dropzone-content">
						<span class="drophere"><?php _e("Drop here", "ALSP"); ?></span>
						<button class="alsp-upload-item-button btn btn-primary"><?php _e("Browse", "ALSP"); ?></button>
						<input type="file" name="browse_file" multiple />
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<div class="alsp-clearfix"></div>

	<?php if (is_admin() && current_user_can('upload_files')): ?>
	<script>
		(function($) {
			"use strict";
		
			$(function() {
				$('#alsp-admin-upload-image').click(function(event) {
					event.preventDefault();
			
					var frame = wp.media({
						title : '<?php echo esc_js(sprintf(__('Upload image (%d maximum)', 'ALSP'), $listing->level->images_number)); ?>',
						multiple : true,
						library : { type : 'image'},
						button : { text : '<?php echo esc_js(__('Insert', 'ALSP')); ?>'},
					});
					frame.on('select', function() {
						var selection = frame.state().get('selection');
						selection.each(function(attachment) {
							attachment = attachment.toJSON();
							if (attachment.type == 'image') {
								if (images_number > $("#alsp-attached-images-wrapper .alsp-attached-item").length) {
									alsp_ajax_loader_show();

									$.ajax({
										type: "POST",
										url: alsp_js_objects.ajaxurl,
										dataType: 'json',
										data: {
											'action': 'alsp_upload_media_image',
											'attachment_id': attachment.id,
											'post_id': <?php echo $listing->post->ID; ?>,
											'_wpnonce': '<?php echo wp_create_nonce('upload_images'); ?>',
										},
										attachment_id: attachment.id,
										attachment_url: attachment.sizes.full.url,
										attachment_title: attachment.title,
										success: function (response_from_the_action_function){
										$("#alsp-attached-images-wrapper").append(alsp_image_attachment_tpl(this.attachment_id, this.attachment_url, this.attachment_title));
										alsp_check_images_attachments_number();
										
										alsp_ajax_loader_hide();
										}
									});
								}
							}
						});
					});
					frame.open();
				});
			});
		})(jQuery);
	</script>
	<div id="alsp-admin-upload-functions">
		<div class="alsp-upload-option">
			<input
				type="button"
				id="alsp-admin-upload-image"
				class="btn btn-primary"
				value="<?php esc_attr_e('Upload image', 'ALSP'); ?>" />
		</div>
	</div>
	<?php endif; ?>
</div>
<?php endif; ?>


<?php if ($listing->level->videos_number): ?>
<script>
	var videos_number = <?php echo $listing->level->videos_number; ?>;

	(function($) {
		"use strict";

		window.alsp_video_attachment_tpl = function(video_id, image_url) {
			var video_attachment_tpl = `
				<div class="alsp-attached-item">
				<input type="hidden" name="attached_video_id[]" value="`+video_id+`" />
				<div class="alsp-attached-item-img" style="background-image: url(`+image_url+`)"></div>
				<div class="alsp-attached-item-delete alsp-fa alsp-fa-trash-o" title="<?php _e("delete", "ALSP"); ?>"></div>
			</div>`;

			return video_attachment_tpl;
		};

		window.alsp_check_videos_attachments_number = function() {
			if (videos_number > $("#alsp-attached-videos-wrapper .alsp-attached-item").length) {
				$(".alsp-attach-videos-functions").show();
			} else {
				$(".alsp-attach-videos-functions").hide();
			}
		}

		$(function() {
			alsp_check_videos_attachments_number();

			$("#alsp-attached-videos-wrapper").on("click", ".alsp-attached-item-delete", function() {
				$(this).parents(".alsp-attached-item").remove();
	
				alsp_check_videos_attachments_number();
			});
		});
	})(jQuery);
</script>

<div id="alsp-video-attach-wrapper" class="alsp-content">
	<p class="alsp-submit-section-label alsp-submit-field-title"><?php _e("Listing videos", "ALSP"); ?></p>
	
	<div id="alsp-attached-videos-wrapper">
		<?php foreach ($listing->videos AS $video): ?>
		<div class="alsp-attached-item">
			<input type="hidden" name="attached_video_id[]" value="<?php echo $video['id']; ?>" />
			<?php
			if (strlen($video['id']) == 11) {
				$image_url = "http://i.ytimg.com/vi/" . $video['id'] . "/0.jpg";
			} elseif (strlen($video['id']) == 8 || strlen($video['id']) == 9) {
				$data = file_get_contents("http://vimeo.com/api/v2/video/" . $video['id'] . ".json");
				$data = json_decode($data);
				$image_url = $data[0]->thumbnail_medium;
			} ?>
			<div class="alsp-attached-item-img" style="background-image: url('<?php echo $image_url; ?>')"></div>
			<div class="alsp-attached-item-delete fa fa-trash-o" title="<?php _e("delete", "ALSP"); ?>"></div>
		</div>
		<?php endforeach; ?>
	</div>
	<div class="alsp-clearfix"></div>

	<script>
		(function($) {
			"use strict";
		
			window.attachVideo = function() {
				if ($("#alsp-attach-video-input").val()) {
					var regExp_youtube = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
					var regExp_vimeo = /https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)/;
					var matches_youtube = $("#alsp-attach-video-input").val().match(regExp_youtube);
					var matches_vimeo = $("#alsp-attach-video-input").val().match(regExp_vimeo);
					if (matches_youtube && matches_youtube[2].length == 11) {
						var video_id = matches_youtube[2];
						var image_url = 'http://i.ytimg.com/vi/'+video_id+'/0.jpg';
						$("#alsp-attached-videos-wrapper").append(alsp_video_attachment_tpl(video_id, image_url));

						alsp_check_videos_attachments_number();
					} else if (matches_vimeo && (matches_vimeo[3].length == 8 || matches_vimeo[3].length == 9)) {
						var video_id = matches_vimeo[3];
						var url = "//vimeo.com/api/v2/video/" + video_id + ".json?callback=showVimeoThumb";
					    var script = document.createElement('script');
					    script.src = url;
					    $("#alsp-attach-videos-functions").before(script);
					} else {
						alert("<?php esc_attr_e('Wrong URL or this video is unavailable', 'ALSP'); ?>");
					}
				}
			};

			window.showVimeoThumb = function(data){
				var video_id = data[0].id;
			    var image_url = data[0].thumbnail_medium;
			    $("#alsp-attached-videos-wrapper").append(alsp_video_attachment_tpl(video_id, image_url));

			    alsp_check_videos_attachments_number();
			};
		})(jQuery);
	</script>
	<div id="alsp-attach-videos-functions">
		<div class="alsp-upload-option">
			<p><?php _e('Enter full YouTube or Vimeo video link', 'ALSP'); ?></p>
		</div>
		<div class="alsp-upload-option">
			<input type="text" id="alsp-attach-video-input" class="alsp-form-control" placeholder="https://youtu.be/XXXXXXXXXXXX" />
		</div>
		<div class="alsp-upload-option">
			<input
				type="button"
				class="btn btn-primary"
				onclick="return attachVideo(); "
				value="<?php esc_attr_e('Attach video', 'ALSP'); ?>" />
		</div>
	</div>
</div>
<?php endif; ?>