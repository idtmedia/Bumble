<?php

class alsp_pmpro {

	public function __construct() {
		//add_action('init', array($this, 'pmpro_levels_array'));
		add_filter('pmpro_get_membership_level_for_user', array($this, 'check_level_price'));
		add_action('pmpro_checkout_after_level_cost', array($this, 'level_description'));
		add_action('pmpro_member_action_links_after', array($this, 'buy_more_link'));
		add_action('pmpro_membership_level_after_other_settings', array($this, 'level_settings'));
		add_action('pmpro_save_membership_level', array($this, 'save_level_settings'), 10, 1);
		add_action('pmpro_after_membership_level_profile_fields', array($this, 'user_profile_fields'), 10, 1);
		add_filter("pmpro_pages_shortcode_levels", array($this, 'pages_shortcode_levels'));
		add_filter("wp", array($this, 'scripts_styles'));
	}
	
	public function check_level_price($level) {
		//var_dump($level);
		
		return $level;
	}
	
	/* public function pmpro_levels_array() {
		global $current_user;
		
		//var_dump($current_user->membership_level);
	} */
	
	public function buy_more_link() {
		global $current_user;
		?>
		<a style="font-size: 1.5em;" href="<?php echo pmpro_url("checkout", "?level=" . $current_user->membership_level->id . "&buymore=1", "https")?>"><?php _e("Buy more listings", "ALSP");?></a>
		<?php 
	}
	
	public function level_description() {
		global $alsp_instance, $pmpro_level;

		?>
		<table id="alsp_directory_listings" class="pmpro_checkout top1em" width="100%" cellpadding="0" cellspacing="0" border="0">
			<thead>
				<tr>
					<th><?php _e('Directory listings available', 'ALSP'); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
					<?php foreach ($alsp_instance->levels->levels_array as $level): ?>
						<div>
							<label><?php echo $level->name; ?>:</label>
							<label><?php echo getPMPROlistingsNumberByLevel($pmpro_level->id, $level->id); ?></label>
						</div>
					<?php endforeach; ?>
					</td>
				</tr>
			</tbody>
		</table>
		<?php 
	}

	public function level_settings() {
		global $alsp_instance, $wpdb;

		if (isset($_REQUEST['edit']))
			$edit = $_REQUEST['edit'];	
		else
			$edit = false;

		$alsp_pmpro_levels = get_option('alsp_pmpro_levels');
		?>
		<script>
		jQuery(document).ready(function($) {
			$("input[name*='alsp_level_unlimited_']").each( function() {
				levelUnlimitedChange($(this));
			});

			$("input[name*='alsp_level_unlimited_']").change( function() {
				levelUnlimitedChange($(this));
			});

			function levelUnlimitedChange(checkbox) {
				if (checkbox.is(':checked'))
					checkbox.parent().parent().find(".alsp_level_value").attr('disabled', 'true');
				else
					checkbox.parent().parent().find(".alsp_level_value").removeAttr('disabled');
			}
		});
		</script>
		<h3 class="topborder"><?php _e('Directory Settings', 'ALSP');?></h3>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row" valign="top"><label><?php _e('Listings levels', 'ALSP');?>:</label></th>
					<td>
						<?php
						if ($edit) {
							$pmpro_level = $wpdb->get_row("SELECT * FROM $wpdb->pmpro_membership_levels WHERE id = '$edit' LIMIT 1", OBJECT);
							$pmpro_level_id = $pmpro_level->id;
						} else 
							$pmpro_level_id = 0;

						echo "<ul>";
						foreach ($alsp_instance->levels->levels_array as $level) {
							echo "<li>";
							echo "<span>";
							echo "<input name='alsp_level_{$level->id}' class='alsp_level_value' type='text' size='2' value='".(isset($alsp_pmpro_levels[$pmpro_level_id][$level->id]) ? $alsp_pmpro_levels[$pmpro_level_id][$level->id]['value'] : 0)."' />";
							_e(' or ', 'ALSP');
							echo "<label><input name='alsp_level_unlimited_{$level->id}' type='checkbox' class='unlimited_listings' value='1' ".(isset($alsp_pmpro_levels[$pmpro_level_id][$level->id]) ? checked($alsp_pmpro_levels[$pmpro_level_id][$level->id]['unlimited'], 1, false) : 'checked="checked"')." />" . __('unlimited', 'ALSP') . '</label> ';
							echo "- {$level->name}";
							echo "</span>";
							echo "</li>";
						}
						echo "</ul>";
						?>
						<small><?php _e('Enter number of allowed directory listings for this membership level or set unlimited.', 'ALSP');?></small>
					</td>
				</tr>
			</tbody>
		</table>
		<?php 
	}
	
	public function save_level_settings($saveid) {
		global $alsp_instance, $msg, $msgt;
		
		$validation = new alsp_form_validation();
		foreach ($alsp_instance->levels->levels_array as $level) {
			$validation->set_rules('alsp_level_'.$level->id, __('Listings number', 'ALSP'), 'numeric');
			$validation->set_rules('alsp_level_unlimited_'.$level->id, __('Listings unlimited', 'ALSP'), 'is_checked');
		}
		if ($validation->run()) {
			$result = get_option('alsp_pmpro_levels') ? get_option('alsp_pmpro_levels') : array();
			foreach ($alsp_instance->levels->levels_array as $level) {
				$result[$saveid][$level->id]['value'] = alsp_getValue($validation->result_array(), 'alsp_level_'.$level->id, 0);
				$result[$saveid][$level->id]['unlimited'] = alsp_getValue($validation->result_array(), 'alsp_level_unlimited_'.$level->id);
			}
			update_option('alsp_pmpro_levels', $result);
		} else {
			$msg = -1;
			$msgt = sprintf(__("Error updating membership level: %s", 'ALSP'), $validation->error_string());
		}
	}

	public function user_profile_fields($user) {
var_dump($user);
		?>
		<table class="form-table">
			<tr>
				<th><label for="membership_level"><?php _e("Available directory listings", "ALSP"); ?></label></th>
				<td>
		<?php 
		if (!get_user_meta($user, 'alsp_pmpro_level_listings')) {
			if (!pmpro_getMembershipLevelForUser())
				_e('Level');
		}
		?>
				</td>
			</tr>
		</table>
		<?php 
		var_dump(get_user_meta($user, 'alsp_pmpro_level_listings'));
		var_dump(get_option('alsp_pmpro_levels'));
	}
	
	public function pages_shortcode_levels() {
		$alsp_pmpro_levels = get_option('alsp_pmpro_levels') ? get_option('alsp_pmpro_levels') : array();

		return alsp_frontendRender(array(ALSP_FSUBMIT_TEMPLATES_PATH, 'pmpro/levels.tpl.php'), array('alsp_pmpro_levels' => $alsp_pmpro_levels), true);
	}
	
	public function scripts_styles() {
		global $post;
		if (!empty($post->post_content) && strpos($post->post_content, "[pmpro_levels]") !== false)
			add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
	}
	public function enqueue_scripts_styles() {
		global $alsp_instance, $alsp_payments_instance, $alsp_ratings_instance;
	
		$alsp_instance->enqueue_scripts_styles(true);
		$this->enqueue_scripts_styles(true);
		if ($alsp_payments_instance)
			$alsp_payments_instance->enqueue_scripts_styles(true);
		if ($alsp_ratings_instance)
			$alsp_ratings_instance->enqueue_scripts_styles(true);
	}
}

?>