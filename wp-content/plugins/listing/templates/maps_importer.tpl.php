<?php w2gm_renderTemplate('admin_header.tpl.php'); ?>

<h2>
	<?php _e('Import From ALSP Google Maps plugin', 'ALSP'); ?>
</h2>

<?php _e('We have found that ALSP Google Maps plugin was installed on your WordPress site. Do you want to import categories, locations, tags, listings or settings from directory? You will not lose any data, everything will be copied from google maps tables.', 'ALSP'); ?>
<br />
<?php _e('Would be better to import all data at once.', 'ALSP'); ?>
<br />
<strong><?php _e('Recommended to make database backup before import.', 'ALSP'); ?></strong>

<form method="POST" action="">
	<table class="form-table">
		<tbody>
			<tr>
				<td>
					<label>
						<input
							name="import_categories"
							type="checkbox"
							checked
							value="1" />
		
						<?php _e('Import maps categories', 'ALSP'); ?>
					</label>
				</td>
			</tr>
			<tr>
				<td>
					<label>
						<input
							name="import_locations"
							type="checkbox"
							checked
							value="1" />
		
						<?php _e('Import maps locations', 'ALSP'); ?>
					</label>
				</td>
			</tr>
			<tr>
				<td>
					<label>
						<input
							name="import_tags"
							type="checkbox"
							checked
							value="1" />
		
						<?php _e('Import maps tags', 'ALSP'); ?>
					</label>
				</td>
			</tr>
			<tr>
				<td>
					<label>
						<input
							name="import_fields"
							type="checkbox"
							checked
							value="1" />
		
						<?php _e('Import maps content fields with fields groups and listings fields data', 'ALSP'); ?>
					</label>
				</td>
			</tr>
			<tr>
				<td>
					<label>
						<input
							name="import_listings"
							type="checkbox"
							checked
							value="1" />
		
						<?php _e('Import maps listings', 'ALSP'); ?>
					</label>
				</td>
			</tr>
			<tr>
				<td>
					<label>
						<input
							name="import_settings"
							type="checkbox"
							checked
							value="1" />
		
						<?php _e('Import similar maps settings', 'ALSP'); ?>
					</label>
				</td>
			</tr>
			<tr>
				<td>
					<label>
						<?php _e('Choose directory level to assume listings from Google Maps plugin', 'ALSP'); ?>
						<select name="import_level">
							<?php
							global $alsp_instance;
							foreach ($alsp_instance->levels->levels_array AS $level)
								echo "<option value=".$level->id.">".$level->name."</option>"; 
							?>
						</select>
					</label>
				</td>
			</tr>
		</tbody>
	</table>
<?php submit_button(__('Import', 'ALSP')); ?>
</form>

<?php w2gm_renderTemplate('admin_footer.tpl.php'); ?>