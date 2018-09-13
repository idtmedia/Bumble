<?php global $ALSP_ADIMN_SETTINGS; ?>
<?php alsp_frontendRender('admin_header.tpl.php'); ?>
<h2><?php _e('CSV Import'); ?></h2>

<p class="description"><?php _e('On this second step collate CSV headers of columns with existing listings fields', 'ALSP'); ?></p>

<form method="POST" action="">
	<input type="hidden" name="action" value="import_collate">
	<input type="hidden" name="import_type" value="<?php echo esc_attr($import_type); ?>">
	<input type="hidden" name="csv_file_name" value="<?php echo esc_attr($csv_file_name); ?>">
	<input type="hidden" name="images_dir" value="<?php echo esc_attr($images_dir); ?>">
	<input type="hidden" name="columns_separator" value="<?php echo esc_attr($columns_separator); ?>">
	<input type="hidden" name="values_separator" value="<?php echo esc_attr($values_separator); ?>">
	<?php wp_nonce_field(ALSP_PATH, 'alsp_csv_import_nonce');?>
	
	<h3><?php _e('Collate CSV columns', 'ALSP'); ?></h3>
	<table class="form-table">
		<tbody>
			<?php foreach ($headers AS $i=>$column): ?>
			<tr>
				<th scope="row">
					<label><?php echo $column; ?></label>
				</th>
				<td>
					<select name="fields[]">
						<option value=""><?php _e('- Select listings field -', 'ALSP'); ?></option>
						<?php foreach ($collation_fields AS $key=>$field): ?>
						<option value="<?php echo $key; ?>" <?php if ($collated_fields) selected($collated_fields[$i], $key, true); ?>><?php echo $field; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<h3><?php _e('Import settings', 'ALSP'); ?></h3>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php _e('What to do when category/location/tag was not found', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="if_term_not_found"
						type="radio"
						value="create"
						<?php isset($if_term_not_found) ? checked($if_term_not_found, 'create') : checked(true); ?> />
					<?php _e('Create new category/location/tag', 'ALSP'); ?>

					<br />

					<input
						name="if_term_not_found"
						type="radio"
						value="skip"
						<?php isset($if_term_not_found) ? checked($if_term_not_found, 'skip') : ''; ?> />
					<?php _e('Do not do anything', 'ALSP'); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Listings author', 'ALSP'); ?></label>
				</th>
				<td>
					<select name="listings_author">
						<option value="0" <?php isset($listing_author) ? selected($listings_author, 0) : selected(true); ?>><?php _e('As defined in CSV column'); ?></option>
						<?php foreach ($users AS $user): ?>
						<option value="<?php echo $user->ID; ?>" <?php isset($listings_author) ? selected($listings_author, $user->ID) : ''; ?>><?php echo $user->user_login; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Geocode imported listings by address parts', 'ALSP'); ?></label>
					<p class="description">
						<?php _e("Required when you don't have coordinates to import, but need listings map markers.", 'ALSP'); ?>
						<?php printf(__('Check geolocation <a href="%s">response</a>.', 'ALSP'), admin_url('admin.php?page=alsp_debug')); ?>
					</p>
				</th>
				<td>
					<input
						name="do_geocode"
						type="checkbox"
						value="1"
						<?php checked($do_geocode, 1, true); ?> />
				</td>
			</tr>
			<?php if ($ALSP_ADIMN_SETTINGS['alsp_fsubmit_addon'] && $ALSP_ADIMN_SETTINGS['alsp_claim_functionality']): ?>
			<tr>
				<th scope="row">
					<label><?php _e('Configure imported listings as claimable', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="is_claimable"
						type="checkbox"
						value="1"
						<?php checked($is_claimable, 1, true); ?> />
				</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
	
	<?php alsp_frontendRender('csv_manager/import_instructions.tpl.php'); ?>
	
	<?php submit_button(__('Import', 'ALSP'), 'primary', 'submit', false); ?>
	&nbsp;&nbsp;&nbsp;
	<?php submit_button(__('Test import', 'ALSP'), 'secondary', 'tsubmit', false); ?>
</form>

<?php alsp_frontendRender('admin_footer.tpl.php'); ?>