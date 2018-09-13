<?php global $ALSP_ADIMN_SETTINGS; ?>

<?php if ($sticky_scroll || $height == '100%'): ?>
<script>
	(function($) {
		"use strict";
	
		$(function() {
			<?php if ($sticky_scroll): ?>
			$("#alsp-maps-canvas-wrapper-<?php echo $map_id; ?>").width($("#alsp-maps-canvas-wrapper-<?php echo $map_id; ?>").parent().width()).css({ 'z-index': 100 });
			
			$("#alsp-maps-canvas-background-<?php echo $map_id; ?>").position().left = $("#alsp-maps-canvas-wrapper-<?php echo $map_id; ?>").position().left;
			$("#alsp-maps-canvas-background-<?php echo $map_id; ?>").position().top = $("#alsp-maps-canvas-wrapper-<?php echo $map_id; ?>").position().top;
			$("#alsp-maps-canvas-background-<?php echo $map_id; ?>").width($("#alsp-maps-canvas-wrapper-<?php echo $map_id; ?>").width());
			$("#alsp-maps-canvas-background-<?php echo $map_id; ?>").height($("#alsp-maps-canvas-wrapper-<?php echo $map_id; ?>").height());
	
			window.a = function() {
				var b = $(document).scrollTop();
				var d = $("#scroller_anchor_<?php echo $map_id; ?>").offset().top-<?php echo $sticky_scroll_toppadding; ?>;
				var c = $("#alsp-maps-canvas-wrapper-<?php echo $map_id; ?>");
				var e = $("#alsp-maps-canvas-background-<?php echo $map_id; ?>");
	
				// .scroller_bottom - this is special class used to restrict the area of scroll of map canvas
				if ($(".scroller_bottom").length)
					var f = $(".scroller_bottom").offset().top-($("#alsp-maps-canvas-<?php echo $map_id; ?>").height()+<?php echo $sticky_scroll_toppadding; ?>);
				else
					var f = $(document).height();
	
				if (b>d && b<f) {
					c.css({ position: "fixed", top: "<?php echo $sticky_scroll_toppadding; ?>px" });
					e.css({ position: "relative" });
				} else {
					if (b<=d) {
						c.css({ position: "relative", top: "" });
						e.css({ position: "absolute" });
					}
					if (b>=f) {
						c.css({ position: "absolute" });
						c.offset({ top: f });
						e.css({ position: "absolute" });
					}
				}
			};
			$(window).scroll(a);
			a();
			$("#alsp-maps-canvas-background-<?php echo $map_id; ?>").css({ position: "absolute" });
			<?php endif; ?>
	
			<?php if ($height == '100%'): ?>
			$('#alsp-maps-canvas-<?php echo $map_id; ?>').height(function(index, height) {
				return window.innerHeight - $('#scroller_anchor_<?php echo $map_id; ?>').outerHeight(true) - <?php echo $sticky_scroll_toppadding; ?>;
			});
			$(window).resize(function(){
				$('#alsp-maps-canvas-<?php echo $map_id; ?>').height(function(index, height) {
					return window.innerHeight - $('#scroller_anchor_<?php echo $map_id; ?>').outerHeight(true) - <?php echo $sticky_scroll_toppadding; ?>;
				});
			});
			<?php endif; ?>
		});
	})(jQuery);
</script>
<?php endif; ?>

<div class="alsp-content">
<?php if (!$static_image): ?>
	<script>
		alsp_map_markers_attrs_array.push(new alsp_map_markers_attrs('<?php echo $map_id; ?>', eval(<?php echo $locations_options; ?>), <?php echo ($enable_radius_cycle) ? 1 : 0; ?>, <?php echo ($enable_clusters) ? 1 : 0; ?>, <?php echo ($show_summary_button) ? 1 : 0; ?>, <?php echo ($show_readmore_button) ? 1 : 0; ?>, <?php echo ($draw_panel) ? 1 : 0; ?>, '<?php echo esc_js($map_style_name); ?>', <?php echo ($enable_full_screen) ? 1 : 0; ?>, <?php echo ($enable_wheel_zoom) ? 1 : 0; ?>, <?php echo ($enable_dragging_touchscreens) ? 1 : 0; ?>, <?php echo ($center_map_onclick) ? 1 : 0; ?>, <?php echo $map_args; ?>));

		<?php if ($search_form): ?>
		(function($) {
			"use strict";

			window.initMapSearchBlock_<?php echo $map_id; ?> = function() {
				if (!alsp_js_objects.is_rtl) {
					var my_placement = 'right';
					var at_placement = 'right-5';
				} else {
					var my_placement = 'left';
					var at_placement = 'left+5';
				}
				$("#alsp-draggable-search-<?php echo $map_id; ?>").show();
				$("#alsp-draggable-search-<?php echo $map_id; ?>").draggable({
					containment: "#alsp-maps-canvas-<?php echo $map_id; ?>",
					scroll: false
				}).position({
					my: my_placement+" bottom",
					at: at_placement+" bottom-15",
					of: "#alsp-maps-canvas-<?php echo $map_id; ?>",
					collision: "none"
				});
			}

			window.addEventListener('orientationchange', initMapSearchBlock_<?php echo $map_id; ?>);
			window.addEventListener('resize', initMapSearchBlock_<?php echo $map_id; ?>);

			$(function() {
				initMapSearchBlock_<?php echo $map_id; ?>();
			});
		})(jQuery);
		<?php endif; ?>
	</script>

	<?php if ($sticky_scroll || $height == '100%'): ?>
	<div id="scroller_anchor_<?php echo $map_id; ?>"></div> 
	<?php endif; ?>

	<div id="alsp-maps-canvas-wrapper-<?php echo $map_id; ?>">
		<?php if ($search_form): ?>
		<div class="alsp-search-map-block" id="alsp-draggable-search-<?php echo $map_id; ?>" style="display: none;">
			<?php
			$search_form = new alsp_search_map_form($map_id);
			echo $search_form->display();
			?>
		</div>
		<?php endif; ?>
		<div id="alsp-maps-canvas-<?php echo $map_id; ?>" class="alsp-maps-canvas" <?php if ($custom_home): ?>data-custom-home="1"<?php endif; ?> data-shortcode-hash="<?php echo $map_id; ?>" style="<?php if ($width) echo 'max-width:' . $width . 'px'; else echo 'width: auto'; ?>; height: <?php if ($height) echo $height; else echo '300'; ?>px"></div>
	</div>

	<?php if ($sticky_scroll): ?>
	<div id="alsp-maps-canvas-background-<?php echo $map_id; ?>" style="position: relative"></div>
	<?php endif; ?>
	
	<?php if ($show_directions): ?>
	<div class="row form-group">
		<?php if ($ALSP_ADIMN_SETTINGS['alsp_directions_functionality'] == 'builtin'): ?>
		<label class="col-md-12 alsp-control-label single-direction-lable"><?php _e('Get directions from:', 'ALSP'); ?></label>
		<script>
			jQuery(document).ready(function($) {
				<?php if ($ALSP_ADIMN_SETTINGS['alsp_address_geocode']): ?>
				jQuery(".alsp-get-location-<?php echo $map_id; ?>").click(function() { alsp_geocodeField(jQuery("#from_direction_<?php echo $map_id; ?>"), "<?php echo esc_js(__('GeoLocation service does not work on your device!', 'ALSP')); ?>"); });
				<?php endif; ?>
			});
		</script>
		<?php if ($ALSP_ADIMN_SETTINGS['alsp_address_geocode']): ?>
		<div class="col-md-12 alsp-has-feedback single-direction-input">
			<span class="alsp-get-location alsp-get-location-<?php echo $map_id; ?> glyphicon glyphicon-screenshot form-control-feedback" title="<?php esc_attr_e('Get my location', 'ALSP'); ?>"></span>
			<input type="text" id="from_direction_<?php echo $map_id; ?>" class="form-control <?php if ($ALSP_ADIMN_SETTINGS['alsp_address_autocomplete']): ?>alsp-field-autocomplete<?php endif; ?>" placeholder="<?php esc_attr_e('Enter address or zip code', 'ALSP'); ?>" />
		</div>
		<?php else: ?>
		<div class="col-md-12 single-direction-input">
			<input type="text" id="from_direction_<?php echo $map_id; ?>" placeholder="<?php esc_attr_e('Enter address or zip code', 'ALSP'); ?>" class="form-control" />
		</div>
		<?php endif; ?>
		<div class="col-md-12">
			<?php $i = 1; ?>
			<?php foreach ($locations_array AS $location): ?>
			<div class="single-direction-options alsp-radio">
				<label>
					<input type="radio" name="select_direction" class="select_direction_<?php echo $map_id; ?>" <?php checked($i, 1); ?> value="<?php esc_attr_e($location->map_coords_1.' '.$location->map_coords_2); ?>" />
					<?php 
					if ($address = $location->getWholeAddress(false))
						echo $address;
					else 
						echo $location->map_coords_1.' '.$location->map_coords_2;
					?>
				</label>
			</div>
			<?php endforeach; ?>
		</div>
		<div class="col-md-12 single-direction-btn">
			<input type="button" class="direction_button front-btn btn btn-primary" id="get_direction_button_<?php echo $map_id; ?>" value="<?php esc_attr_e('Get directions', 'ALSP'); ?>">
		</div>
		<div class="col-md-12">
			<div id="route_<?php echo $map_id; ?>" class="alsp-maps-direction-route"></div>
		</div>
		<?php elseif ($ALSP_ADIMN_SETTINGS['alsp_directions_functionality'] == 'google'): ?>
		<label class="col-md-12 alsp-control-label"><?php _e('directions to:', 'ALSP'); ?></label>
		<form action="//maps.google.com/maps" target="_blank">
			<div class="col-md-12">
				<?php $i = 1; ?>
				<?php foreach ($locations_array AS $location): ?>
				<div class="alsp-radio">
					<label>
						<input type="radio" name="q" class="select_direction_<?php echo $map_id; ?>" <?php checked($i, 1); ?> value="<?php esc_attr_e($location->map_coords_1.' '.$location->map_coords_2); ?>" />
						<?php 
						if ($address = $location->getWholeAddress(false))
							echo $address;
						else 
							echo $location->map_coords_1.' '.$location->map_coords_2;
						?>
					</label>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="col-md-12">
				<input class="btn btn-primary" type="submit" value="<?php esc_attr_e('Get directions', 'ALSP'); ?>" />
			</div>
		</form>
		<?php endif; ?>
	</div>
	<?php endif; ?>
<?php else: ?>
	<img src="https://maps.googleapis.com/maps/api/staticmap?size=795x350&<?php foreach ($locations_array  AS $location) { if ($location->map_coords_1 != 0 && $location->map_coords_2 != 0) { ?>markers=<?php if (ALSP_MAP_ICONS_URL && $location->map_icon_file) { ?>icon:<?php echo ALSP_MAP_ICONS_URL . 'icons/' . urlencode($location->map_icon_file) . '%7C'; }?><?php echo $location->map_coords_1 . ',' . $location->map_coords_2 . '&'; }} ?><?php if ($map_zoom) echo 'zoom=' . $map_zoom; ?><?php if ($ALSP_ADIMN_SETTINGS['alsp_google_api_key']) echo '&key='.$ALSP_ADIMN_SETTINGS['alsp_google_api_key']; ?>" />
<?php endif; ?>
</div>