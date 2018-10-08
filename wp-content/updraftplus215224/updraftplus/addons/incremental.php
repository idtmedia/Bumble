<?php
// @codingStandardsIgnoreStart
/*
UpdraftPlus Addon: incremental:Support for incremental backups
Description: Allows UpdraftPlus to schedule incremental file backups, which use much less resources
Version: 1.0
Shop: /shop/incremental/
Latest Change: 1.14.5
*/
// @codingStandardsIgnoreEnd

if (!defined('UPDRAFTPLUS_DIR')) die('No direct access allowed');

/**
 * Warning: this code is still a work in progress and is not yet complete. For this reason it is disabled and will be enabled when complete.
 */
if (!defined('UPDRAFTPLUS_INCREMENTAL_BACKUPS_ADDON')) return;

$updraftplus_addon_incremental = new UpdraftPlus_Addons_Incremental;

class UpdraftPlus_Addons_Incremental {

	/**
	 * Constructor
	 */
	public function __construct() {
		// Priority 11 so that it loads after the filter that adds the backup label
		add_filter('updraftplus_showbackup_date', array($this, 'showbackup_date'), 11, 5);
		add_filter('updraftplus_files_altered_since', array($this, 'files_altered_since'), 10, 2);
		add_filter('updraft_backupnow_options', array($this, 'backupnow_options'), 10, 2);
		add_filter('updraftplus_initial_jobdata', array($this, 'initial_jobdata_incremental_jobdata'), 10, 2);
		add_filter('updraftplus_backup_timestamp', array($this, 'incremental_backup_timestamp'), 10, 1);
		add_filter('updraftplus_include_manifest', array($this, 'incremental_include_manifest'), 10, 1);
		add_filter('updraftplus_incremental_addon_installed', array($this, 'incremental_addon_installed'), 10, 1);
		add_action('updraftplus_incremental_cell', array($this, 'incremental_cell'), 10, 2);
		add_action('updraft_backup_increments', array($this, 'backup_increments'));
		add_action('admin_footer', array($this, 'admin_footer_incremental_backups_js'));
	}

	/**
	 * This function will add to the backup label information on when the last incremental set was created, it will also add to the title the dates for all the incremental sets in this backup.
	 *
	 * @param string  $date          - the date when the backup set was first created
	 * @param array   $backup        - the backup set
	 * @param array   $jobdata       - an array of information relating to the backup job
	 * @param integer $backup_date   - the timestamp of when the backup set was first created
	 * @param boolean $simple_format - a boolean value to indicate if this should be a simple format date
	 *
	 * @return string                - returns a string that is either the original backup date or the string that contains the incremental set data
	 */
	public function showbackup_date($date, $backup, $jobdata, $backup_date, $simple_format) {

		$incremental_sets = !empty($backup['incremental_sets']) ? $backup['incremental_sets'] : array();
		
		// Check here that the backup set has the incremental set and that there is more than one set as we don't want the incremental backup UI showing for every user backup
		if (!empty($incremental_sets) && 1 < count($incremental_sets)) {
			
			$latest_increment = key(array_slice($incremental_sets, -1, 1, true));

			if ($latest_increment > $backup_date) {
				
				$increment_times = '';

				foreach ($incremental_sets as $inc_time => $entities) {
					if ($increment_times) $increment_times .= '; ';
					$increment_times .= get_date_from_gmt(gmdate('Y-m-d H:i:s', $inc_time), 'M d, Y G:i');
				}

				if ($simple_format) {
					return $date.' '.sprintf(__('(latest increment: %s)', 'updraftplus'), get_date_from_gmt(gmdate('Y-m-d H:i:s', $latest_increment), 'M d, Y G:i'));
				} else {
					return '<span title="'.sprintf(__('Increments exist at: %s', 'updraftplus'), $increment_times).'">'.$date.'<br>'.sprintf(__('(latest increment: %s)', 'updraftplus'), get_date_from_gmt(gmdate('Y-m-d H:i:s', $latest_increment), 'M d, Y G:i')).'</span>';
				}
			}
		}
		
		return $date;
	}

	/**
	 * This function will get an return the files_enumerated_at array if it is set otherwise returns an empty array
	 *
	 * @param integer $altered_since - integer for files altered since this time default is -1
	 * @param string  $job_type      - a string to indicate the job type
	 *
	 * @return integer|array         - returns the default integer if this is not a backup job other wise returns the files_enumerated_at array or an empty array if not set
	 */
	public function files_altered_since($altered_since, $job_type) {
		global $updraftplus;

		if ('incremental' !== $job_type) return $altered_since;
		
		$backup_history = UpdraftPlus_Backup_History::get_backup_set_by_nonce($updraftplus->file_nonce);
		$files_enumerated_at = isset($backup_history['files_enumerated_at']) ? $backup_history['files_enumerated_at'] : array();
		
		return is_array($files_enumerated_at) ? $files_enumerated_at : array();
	}

	/**
	 * This function will check to see if the incremental option is set and if so adds it to the backup job options
	 *
	 * @param array $options - the backup job options
	 * @param array $request - the backup request array
	 *
	 * @return array         - returns the modified backup job options
	 */
	public function backupnow_options($options, $request) {
		if (!is_array($options)) return $options;
		
		if (!empty($request['incremental'])) $options['incremental'] = $request['incremental'];
		
		return $options;
	}

	/**
	 * This function will set up the backup job data for when we are starting a incremental backup. It changes the initial jobdata so that UpdraftPlus knows to start a incremental backup job.
	 *
	 * @param array $jobdata - the initial job data that we want to change
	 * @param array $options - options sent from the front end includes backup timestamp and nonce
	 *
	 * @return array         - the modified jobdata
	 */
	public function initial_jobdata_incremental_jobdata($jobdata, $options) {
		
		if (!is_array($jobdata) || empty($options['incremental'])) return $jobdata;
		
		global $updraftplus;
		
		/*
			The initial job data is not set up in a key value array instead it is set up so key "x" is the name of the key and then key "y" is the value.
			e.g array[0] = 'backup_name' array[1] = 'my_backup'
		*/
		$jobtype_key = array_search('job_type', $jobdata) + 1;
		$job_file_entities_key = array_search('job_file_entities', $jobdata) + 1;
		$job_backup_time = array_search('backup_time', $jobdata) + 1;
		$backup_database_key = array_search('backup_database', $jobdata) + 1;

		$backup_history = UpdraftPlus_Backup_History::get_backup_set_by_nonce($updraftplus->file_nonce);
		$possible_backups = $updraftplus->get_backupable_file_entities(true);

		$job_file_entities = $jobdata[$job_file_entities_key];
		$job_backup_files_array = array();

		foreach ($possible_backups as $youwhat => $whichdir) {
			if (isset($job_file_entities[$youwhat]) && isset($backup_history[$youwhat])) {
				$job_file_entities[$youwhat]['index'] = count($backup_history[$youwhat]);
				$job_backup_files_array[$youwhat] = $backup_history[$youwhat];
				$job_backup_files_array[$youwhat.'-size'] = $backup_history[$youwhat.'-size'];

				// Mark each existing file entity as already uploaded
				foreach ($job_backup_files_array[$youwhat] as $index => $file) {
					$new_jobdata_items = $updraftplus->get_uploaded_jobdata_items($file);
					foreach ($new_jobdata_items as $key => $value) {
						array_push($jobdata, $key, $value);
					}
				}
			}
		}

		$db_backups = $jobdata[$backup_database_key];
		
		$db_backup_info = $updraftplus->update_database_jobdata($db_backups, $backup_history);

		$jobdata[$jobtype_key] = 'incremental';
		$jobdata[$job_backup_time] = $backup_history['timestamp'];
		$jobdata[$job_file_entities_key] = $job_file_entities;
		$jobdata[] = 'backup_files_array';
		$jobdata[] = $job_backup_files_array;
		$jobdata[] = 'blog_name';
		$jobdata[] = $db_backup_info['blog_name'];
		$jobdata[$backup_database_key] = $db_backup_info['db_backups'];
		
		return $jobdata;
	}

	/**
	 * This function will filter the passed in timestamp, it will check that this is an incremental run and will return the timestamp from the jobdata so that the increment will be saved in the original backup.
	 *
	 * @param string $timestamp - the backup timestamp
	 *
	 * @return string           - returns the incremental backup timestamp
	 */
	public function incremental_backup_timestamp($timestamp) {
		global $updraftplus;

		if ('incremental' != $updraftplus->jobdata_get('job_type')) return $timestamp;

		$timestamp = $updraftplus->jobdata_get('backup_time');

		return $timestamp;
	}

	/**
	 * This function will filter and return a boolean to indicate if the backup should include a manifest or not
	 *
	 * @param  boolean $include - a boolean to indicate if we should include a manifest in the backup
	 *
	 * @return boolean          - returns a boolean to indicate if we should include a manifest in the backup
	 */
	public function incremental_include_manifest($include) {
		global $updraftplus;

		if ('incremental' != $updraftplus->jobdata_get('job_type')) return $include;
		
		return true;
	}

	/**
	 * This function is called via a filter and returns true to indicate that the incremental addon is installed
	 *
	 * @param boolean $installed - a boolean to filter
	 *
	 * @return boolean            - returns true
	 */
	public function incremental_addon_installed($installed) {
		return true;
	}

	/**
	 * Get a list of incremental backup intervals
	 *
	 * @return Array - keys are used as identifiers in the UI drop-down; values are user-displayed text describing the interval
	 */
	private function get_intervals() {
		return apply_filters('updraftplus_backup_intervals_increments', array(
			'none' => __("None", 'updraftplus'),
			'everyhour' => __("Every hour", 'updraftplus'),
			'every2hours' => sprintf(__("Every %s hours", 'updraftplus'), '2'),
			'every4hours' => sprintf(__("Every %s hours", 'updraftplus'), '4'),
			'every8hours' => sprintf(__("Every %s hours", 'updraftplus'), '8'),
			'twicedaily' => sprintf(__("Every %s hours", 'updraftplus'), '12'),
			'daily' => __("Daily", 'updraftplus'),
			'weekly' => __("Weekly", 'updraftplus'),
			'fortnightly' => __("Fortnightly", 'updraftplus'),
			'monthly' => __("Monthly", 'updraftplus')
		));
	}

	/**
	 * This function is called via the action updraftplus_incremental_cell and will add UI options to schedule incremental backups.
	 *
	 * @param string $selected_interval - the interval that is currently selected
	 *
	 * @return void
	 */
	public function incremental_cell($selected_interval) {
		?>
		<div style="float:left;clear:both;">
		<?php _e('And then add an incremental backup', 'updraftplus'); ?>
		<select id="updraft_interval_increments" name="updraft_interval_increments">
			<?php
			$intervals = $this->get_intervals();
			$selected_interval = UpdraftPlus_Options::get_updraft_option('updraft_interval_increments', 'none');
			foreach ($intervals as $cronsched => $descrip) {
				echo "<option value=\"$cronsched\" ";
				if ($cronsched == $selected_interval) echo 'selected="selected"';
				echo ">".htmlspecialchars($descrip)."</option>\n";
			}
			?>
		</select>
		<?php echo '<a href="' . apply_filters('updraftplus_com_link', "https://updraftplus.com/support/tell-me-more-about-incremental-backups/") . '">' . __('Tell me more', 'updraftplus') . '</a>'; ?>
		</div>
		<?php
	}

	/**
	 * This function will setup and check that an incremental backup can be started.
	 *
	 * @return void
	 */
	public function backup_increments() {
		global $updraftplus;

		if (!$updraftplus->get_semaphore_lock(true, true)) return;
		$running = $updraftplus->is_backup_running();
		if ($running) {
			$updraftplus->log($running);
			return;
		}
		
		$nonce = UpdraftPlus_Backup_History::get_latest_full_backup();
		if (empty($nonce)) return;

		$updraftplus->file_nonce = $nonce;
		add_filter('updraftplus_incremental_backup_file_nonce', array($updraftplus, 'incremental_backup_file_nonce'));

		// Backup would now start but is not yet coded. Also I think when the backup finishes the lock will be released, as the backup does not start yet we manually release.
		error_log("Incremental backup would start now for job: $nonce");

		$updraftplus->semaphore->unlock();
	}

	/**
	 * This function will output any needed js for the incremental backup addon.
	 *
	 * @return void
	 */
	public function admin_footer_incremental_backups_js() {
		?>
		<script>
		jQuery(document).ready(function() {
			<?php
				$intervals = $this->get_intervals();
				$var_int = '';
				foreach ($intervals as $val => $descript) {
					if ($var_int) $var_int .= ', ';
					$var_int .= "$val: \"".esc_js($descript)."\"";
				}
				echo 'var intervals = {'.$var_int."}\n";
			?>
			function updraft_update_incremental_selector() {
				var fileint = jQuery('#updraft-navtab-settings-content select.updraft_interval').val();
				var prevsel = jQuery('#updraft-navtab-settings-content select#updraft_interval_increments').val();

				if ('manual' == fileint) {
					jQuery('#updraft-navtab-settings-content select#updraft_interval_increments').prop('disabled', true);
					jQuery('#updraft_incremental_row').css('opacity', '0.25');
				} else {
					jQuery('#updraft-navtab-settings-content select#updraft_interval_increments').prop('disabled', false);
					jQuery('#updraft_incremental_row').css('opacity', 1);
					var newhtml = '';
					var adding = 1;
					for (var key in intervals) {
						if (key == fileint) { adding = 0; }
						if (1 == adding) {
							var value = intervals[key];
							var sel = '';
							if (prevsel == key) { sel = 'selected="selected" '; }
							newhtml += '<option '+sel+'value="'+key+'">'+value+'</option>';
						}
					}
					jQuery('#updraft-navtab-settings-content select#updraft_interval_increments').html(newhtml);
				}
			}

			jQuery('#updraft-navtab-settings-content select.updraft_interval, #updraft-navtab-settings-content select#updraft_interval_increments').change(function() {
				updraft_update_incremental_selector();
			});
			
			// Set initial values
			updraft_update_incremental_selector();
		});
		</script>
		<?php
	}
}
