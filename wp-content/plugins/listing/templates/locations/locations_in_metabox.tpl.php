<?php global $ALSP_ADIMN_SETTINGS; ?>

		<div class="alsp-location-in-metabox-wrap clearfix">
		<div class="alsp-location-in-metabox clearfix">
			<?php $uID = rand(1, 10000); ?>
			<input type="hidden" name="alsp_location[<?php echo $uID;?>]" value="1" />
			<div class="alsp-location-metabox-dropdown alsp-submit-field-title">
			<?php
			if (alsp_is_anyone_in_taxonomy(ALSP_LOCATIONS_TAX)) {
				alsp_tax_dropdowns_meta_init(
					ALSP_LOCATIONS_TAX,
					null,
					$location->selected_location,
					false,
					$locations_levels->getNamesArray(),
					$locations_levels->getSelectionsArray(),
					$uID,
					$listing->level->locations,
					false
				);
			}
			?>
			</div>
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_address_geocode']): ?>
			<script>
				(function($) {
					"use strict";

					$(function() {
						$(".alsp-get-location-<?php echo $uID; ?>").click(function() { alsp_geocodeField($("#address_line_<?php echo $uID; ?>"), "<?php echo esc_js(__('GeoLocation service does not work on your device!', 'ALSP')); ?>"); });
					});
				})(jQuery);
			</script>
			<?php endif; ?>
			<div class="location-input form-group alsp-location-input alsp-address-line-1-wrapper" <?php if (!$ALSP_ADIMN_SETTINGS['alsp_enable_address_line_1']): ?>style="display: none;"<?php endif; ?>>
				<label class="alsp-control-label alsp-submit-field-title">
					<?php _e('Address line 1', 'ALSP'); ?>
				</label>
				<?php if ($ALSP_ADIMN_SETTINGS['alsp_address_geocode']): ?>
				<div class=" alsp-has-feedback">
					<input type="text" id="address_line_<?php echo $uID;?>" name="address_line_1[<?php echo $uID;?>]" class="alsp-address-line-1 form-control <?php if ($ALSP_ADIMN_SETTINGS['alsp_address_autocomplete']): ?>alsp-field-autocomplete<?php endif; ?>" value="<?php echo esc_attr($location->address_line_1); ?>" />
					<span class="alsp-get-location alsp-get-location-<?php echo $uID; ?> glyphicon glyphicon-screenshot form-control-feedback" title="<?php esc_attr_e('Get my location', 'ALSP'); ?>"></span>
				</div>
				<?php else: ?>
				<div class="">
					<input type="text" id="address_line_<?php echo $uID;?>" name="address_line_1[<?php echo $uID;?>]" class="alsp-address-line-1 form-control" value="<?php echo esc_attr($location->address_line_1); ?>" />
				</div>
				<?php endif; ?>
			</div>

			<div class="location-input form-group alsp-location-input alsp-address-line-2-wrapper" <?php if (!$ALSP_ADIMN_SETTINGS['alsp_enable_address_line_2']): ?>style="display: none;"<?php endif; ?>>
				<label class="alsp-control-label alsp-submit-field-title">
					<?php _e('Address line 2', 'ALSP'); ?>
				</label>
				<div class="">
					<input type="text" name="address_line_2[<?php echo $uID;?>]" class="alsp-address-line-2 form-control" value="<?php echo esc_attr($location->address_line_2); ?>" />
				</div>
			</div>

			<div class="location-input form-group alsp-location-input alsp-zip-or-postal-index-wrapper" <?php if (!$ALSP_ADIMN_SETTINGS['alsp_enable_postal_index']): ?>style="display: none;"<?php endif; ?>>
				<label class="alsp-control-label alsp-submit-field-title">
					<?php _e('Zip code', 'ALSP'); ?>
				</label>
				<div class="">
					<input type="text" name="zip_or_postal_index[<?php echo $uID;?>]" class="alsp-zip-or-postal-index form-control" value="<?php echo esc_attr($location->zip_or_postal_index); ?>" />
				</div>
			</div>

			<div class="location-input form-group alsp-location-input alsp-additional-info-wrapper" <?php if (!$ALSP_ADIMN_SETTINGS['alsp_enable_additional_info']): ?>style="display: none;"<?php endif; ?>>
				<label class=" alsp-control-label alsp-submit-field-title">
					<?php _e('Additional info', 'ALSP'); ?>
				</label>
				<div class="">
					<textarea name="additional_info[<?php echo $uID;?>]" class="alsp-additional-info form-control" rows="2"><?php echo esc_textarea($location->additional_info); ?></textarea>
				</div>
			</div>
			<?php if ($listing->level->google_map): ?>

				<div class="location-input-one-half alsp-manual-coords-wrapper clearfix" <?php if (!$ALSP_ADIMN_SETTINGS['alsp_enable_manual_coords']): ?>style="display: none;"<?php endif; ?>>
					<!-- manual_coords - required in google_maps.js -->
					<div class="checkbox alsp-location-input">
						<label class="">
							<input type="checkbox" name="manual_coords[<?php echo $uID;?>]" value="1" class="alsp-manual-coords" <?php if ($location->manual_coords) echo 'checked'; ?> /> <?php _e('Enter coordinates manually', 'ALSP'); ?><span class="radio-check-item"></span>
						</label>
					</div>
					<!-- alsp-manual-coords-block - position required for jquery selector -->
					<div class="alsp-manual-coords-block" <?php if (!$location->manual_coords) echo 'style="display: none;"'; ?>>
						<div class="alsp-location-input">
							<label class=" alsp-control-label">
								<?php _e('Latitude', 'ALSP'); ?>
							</label>
							<!-- map_coords_1 - required in google_maps.js -->
							<div class="">
								<input type="text" name="map_coords_1[<?php echo $uID;?>]" class="alsp-map-coords-1 form-control" value="<?php echo esc_attr($location->map_coords_1); ?>">
							</div>
						</div>

						<div class="alsp-location-input">
							<label class=" alsp-control-label">
								<?php _e('Longitude', 'ALSP'); ?>
							</label>
							<!-- map_coords_2 - required in google_maps.js -->
							<div class="">
								<input type="text" name="map_coords_2[<?php echo $uID;?>]" class="alsp-map-coords-2 form-control" value="<?php echo esc_attr($location->map_coords_2); ?>">
							</div>
						</div>
					</div>
				</div>
				<?php if ($listing->level->google_map_markers): ?>
				<div class="location-input-one-half alsp-location-input input-market">
					<div class="input-map-marker">
						<a class="select_map_icon" href="javascript: void(0);"><?php _e('Select Marker Icon', 'ALSP'); ?></a>
						<input type="hidden" name="map_icon_file[<?php echo $uID;?>]" class="alsp-map-icon-file" value="<?php if (isset($location->map_icon_manually_selected)) echo esc_attr($location->map_icon_file); ?>">
					</div>
				</div>
			<?php endif; ?>
			<?php endif; ?>
			<a href="javascript: void(0);" <?php if (!$delete_location_link) echo 'style="display:none;"'; ?> class="delete_location"><i class="pacz-icon-minus-circle"></i></a>
		</div>

	</div>