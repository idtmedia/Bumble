<?php alsp_frontendRender('admin_header.tpl.php'); ?>

<h2>
	<?php
	if ($level_id)
		_e('Edit level', 'ALSP');
	else
		_e('Create new level', 'ALSP');
	?>
</h2>

<script>
(function($) {
	"use strict";

	$(function() {
		$("#eternal_active_period").click( function() {
			if ($('#eternal_active_period').is(':checked')) {
				$('#active_interval').attr('disabled', true);
				$('#active_period').attr('disabled', true);
				$('#change_level_id').attr('disabled', true);
		    } else {
		    	$('#active_interval').removeAttr('disabled');
		    	$('#active_period').removeAttr('disabled');
				$('#change_level_id').removeAttr('disabled');
		    }
		});
	
		$("#unlimited_categories").click( function() {
			if ($("#unlimited_categories").is(':checked')) {
				$("#categories_number").attr('disabled', true);
			} else {
				$("#categories_number").removeAttr('disabled');
			}
		});
	});
})(jQuery);
</script>

<form method="POST" action="">
	<?php wp_nonce_field(ALSP_PATH, 'alsp_levels_nonce');?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php _e('Level name', 'ALSP'); ?><span class="alsp-red-asterisk">*</span></label>
				</th>
				<td>
					<input
						name="name"
						type="text"
						class="regular-text"
						value="<?php echo esc_attr($level->name); ?>" />
					<?php alsp_wpml_translation_complete_notice(); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Level description', 'ALSP'); ?></label>
				</th>
				<td>
					<textarea
						name="description"
						cols="60"
						rows="4" ><?php echo esc_textarea($level->description); ?></textarea>
					<p class="description"><?php _e("Describe this level's advantages and options as much easier for users as you can", 'ALSP'); ?></p>
					<?php alsp_wpml_translation_complete_notice(); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Active period', 'ALSP'); ?></label>
				</th>
				<td>
					<select name="active_interval" id="active_interval" <?php disabled($level->eternal_active_period); ?> >
						<option value="1" <?php if ($level->active_interval == 1) echo 'selected'; ?> >1</option>
						<option value="2" <?php if ($level->active_interval == 2) echo 'selected'; ?> >2</option>
						<option value="3" <?php if ($level->active_interval == 3) echo 'selected'; ?> >3</option>
						<option value="4" <?php if ($level->active_interval == 4) echo 'selected'; ?> >4</option>
						<option value="5" <?php if ($level->active_interval == 5) echo 'selected'; ?> >5</option>
						<option value="6" <?php if ($level->active_interval == 6) echo 'selected'; ?> >6</option>
						<option value="7" <?php if ($level->active_interval == 7) echo 'selected'; ?> >7</option>
						<option value="8" <?php if ($level->active_interval == 8) echo 'selected'; ?> >8</option>
						<option value="9" <?php if ($level->active_interval == 9) echo 'selected'; ?> >9</option>
						<option value="10" <?php if ($level->active_interval == 10) echo 'selected'; ?> >10</option>
						<option value="11" <?php if ($level->active_interval == 11) echo 'selected'; ?> >11</option>
						<option value="12" <?php if ($level->active_interval == 12) echo 'selected'; ?> >12</option>
						<option value="13" <?php if ($level->active_interval == 13) echo 'selected'; ?> >13</option>
						<option value="14" <?php if ($level->active_interval == 14) echo 'selected'; ?> >14</option>
						<option value="15" <?php if ($level->active_interval == 15) echo 'selected'; ?> >15</option>
						<option value="16" <?php if ($level->active_interval == 16) echo 'selected'; ?> >16</option>
						<option value="17" <?php if ($level->active_interval == 17) echo 'selected'; ?> >17</option>
						<option value="18" <?php if ($level->active_interval == 18) echo 'selected'; ?> >18</option>
						<option value="19" <?php if ($level->active_interval == 19) echo 'selected'; ?> >19</option>
						<option value="20" <?php if ($level->active_interval == 20) echo 'selected'; ?> >20</option>
						<option value="21" <?php if ($level->active_interval == 21) echo 'selected'; ?> >21</option>
						<option value="22" <?php if ($level->active_interval == 22) echo 'selected'; ?> >22</option>
						<option value="23" <?php if ($level->active_interval == 23) echo 'selected'; ?> >23</option>
						<option value="24" <?php if ($level->active_interval == 24) echo 'selected'; ?> >24</option>
						<option value="25" <?php if ($level->active_interval == 25) echo 'selected'; ?> >25</option>
						<option value="26" <?php if ($level->active_interval == 26) echo 'selected'; ?> >26</option>
						<option value="27" <?php if ($level->active_interval == 27) echo 'selected'; ?> >27</option>
						<option value="28" <?php if ($level->active_interval == 28) echo 'selected'; ?> >28</option>
						<option value="29" <?php if ($level->active_interval == 29) echo 'selected'; ?> >29</option>
						<option value="30" <?php if ($level->active_interval == 30) echo 'selected'; ?> >30</option>
						<option value="31" <?php if ($level->active_interval == 31) echo 'selected'; ?> >31</option>
					</select>
					&nbsp;
					<select name="active_period" id="active_period" <?php disabled($level->eternal_active_period); ?> >
						<option value="day" <?php if ($level->active_period == 'day') echo 'selected'; ?> ><?php _e("day(s)", "ALSP"); ?></option>
						<option value="week" <?php if ($level->active_period == 'week') echo 'selected'; ?> ><?php _e("week(s)", "ALSP"); ?></option>
						<option value="month" <?php if ($level->active_period == 'month') echo 'selected'; ?> ><?php _e("month(s)", "ALSP"); ?></option>
						<option value="year" <?php if ($level->active_period == 'year') echo 'selected'; ?> ><?php _e("year(s)", "ALSP"); ?></option>
					</select>
					<p class="description">
						<?php _e("During this period the listing will have active status.", 'ALSP'); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Eternal active period', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="eternal_active_period"
						type="checkbox"
						value="1"
						id="eternal_active_period"
						<?php checked($level->eternal_active_period); ?> />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Change level after expiration', 'ALSP'); ?></label>
				</th>
				<td>
					<select name="change_level_id" id="change_level_id" <?php disabled($level->eternal_active_period); ?> >
						<option value="0" <?php if ($level->change_level_id == 0) echo 'selected'; ?> >- <?php _e("Just suspend", "ALSP"); ?> -</option>
						<?php foreach ($alsp_instance->levels->levels_array AS $new_level): ?>
						<?php if ($level->id != $new_level->id): ?>
						<option value="<?php echo $new_level->id; ?>" <?php if ($level->change_level_id == $new_level->id) echo 'selected'; ?> ><?php echo $new_level->name; ?></option>
						<?php endif; ?>
						<?php endforeach; ?>
					</select>
					<p class="description">
						<?php _e("After expiration listing will change level automatically. (builtin payment only)", 'ALSP'); ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Number of listings in package', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						id="listings_in_package"
						name="listings_in_package"
						type="text"
						size="1"
						value="<?php echo $level->listings_in_package; ?>" />
					<p class="description"><?php _e("Enter more than 1 to allow users get packages of listings. Users will be able to use listings from their package to renew, raise up and upgrade existing listings. (Builtin payments Method only)", 'ALSP'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Ability to raise up listings', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="raiseup_enabled"
						type="checkbox"
						value="1"
						<?php checked($level->raiseup_enabled); ?> />
					<p class="description"><?php _e("This option may be payment", 'ALSP'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Sticky listings', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="sticky"
						type="checkbox"
						value="1"
						<?php checked($level->sticky); ?> />
					<p class="description"><?php _e("Listings of this level will be always on top", 'ALSP'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Featured listings', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="featured"
						type="checkbox"
						value="1"
						<?php checked($level->featured); ?> />
					<p class="description"><?php _e("Listings of this level will be marked as featured", 'ALSP'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Do listings have own single pages?', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="listings_own_page"
						type="checkbox"
						value="1"
						<?php checked($level->listings_own_page); ?> />
					<p class="description"><?php _e("When unchecked - listings info will be shown only on excerpt pages, without own detailed pages.", 'ALSP'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Enable nofollow attribute for links to single listings pages', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="nofollow"
						type="checkbox"
						value="1"
						<?php checked($level->nofollow); ?> />
					<p class="description"><a href="https://support.google.com/webmasters/answer/96569"><?php _e("Description from Google Webmaster Tools", 'ALSP'); ?></a></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Enable google map', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="google_map"
						type="checkbox"
						value="1"
						<?php checked($level->google_map); ?> />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Enable listing logo', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="logo_enabled"
						type="checkbox"
						value="1"
						<?php checked($level->logo_enabled); ?> />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Make This Level Featured/Popular', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="featured_level"
						type="checkbox"
						value="1"
						<?php checked($level->featured_level); ?> />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Allow Resurva Booking', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="allow_resurva_booking"
						type="checkbox"
						value="1"
						<?php checked($level->allow_resurva_booking); ?> />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Images number available', 'ALSP'); ?>
				</th>
				<td>
					<input
						name="images_number"
						type="text"
						size="1"
						value="<?php echo esc_attr($level->images_number); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Videos number available', 'ALSP'); ?>
				</th>
				<td>
					<input
						name="videos_number"
						type="text"
						size="1"
						value="<?php echo esc_attr($level->videos_number); ?>" />
				</td>
			</tr>
			
			<?php do_action('alsp_level_html', $level); ?>
			
			<tr>
				<th scope="row">
					<label><?php _e('Locations number available', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="locations_number"
						type="text"
						size="1"
						value="<?php echo $level->locations_number; ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Custom markers on google map', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="google_map_markers"
						type="checkbox"
						value="1"
						<?php checked($level->google_map_markers); ?> />
				</td>
			</tr>
			
			<tr>
				<th scope="row">
					<label><?php _e('Categories number available', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="categories_number"
						id="categories_number"
						type="text"
						size="1"
						value="<?php echo esc_attr($level->categories_number); ?>"
						<?php disabled($level->unlimited_categories); ?> />

					<input
						name="unlimited_categories"
						id="unlimited_categories"
						type="checkbox"
						value="1"
						<?php checked($level->unlimited_categories); ?> />
					<?php _e('unlimited categories', 'ALSP'); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Assigned categories', 'ALSP'); ?></label>
					<?php echo alsp_get_wpml_dependent_option_description(); ?>
				</th>
				<td>
					<p class="description"><?php _e('You may define some special categories, those would be available for this level', 'ALSP'); ?></p>
					<?php alsp_termsSelectList('categories_list', ALSP_CATEGORIES_TAX, $level->categories); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Assigned locations', 'ALSP'); ?></label>
					<?php echo alsp_get_wpml_dependent_option_description(); ?>
				</th>
				<td>
					<p class="description"><?php _e('You may define some special locations, those would be available for this level', 'ALSP'); ?></p>
					<?php alsp_termsSelectList('locations_list', ALSP_LOCATIONS_TAX, $level->locations); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Assigned content fields', 'ALSP'); ?></label>
				</th>
				<td>
					<p class="description"><?php _e('You may define some special content fields, those would be available for this level', 'ALSP'); ?></p>
					<select multiple="multiple" name="content_fields_list[]" class="selected_terms_list alsp-form-control alsp-form-group" style="height: 300px">
					<option value="" <?php echo (!$level->content_fields) ? 'selected' : ''; ?>><?php _e('- Select All -', 'ALSP'); ?></option>
					<?php foreach ($content_fields AS $field): ?>
					<?php if (!$field->is_core_field): ?>
					<option value="<?php echo $field->id; ?>" <?php echo ($level->content_fields && in_array($field->id, $level->content_fields)) ? 'selected' : ''; ?>><?php echo $field->name; ?></option>
					<?php endif; ?>
					<?php endforeach; ?>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php
	if ($level_id)
		submit_button(__('Save changes', 'ALSP'));
	else
		submit_button(__('Create level', 'ALSP'));
	?>
</form>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>