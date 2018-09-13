<?php

class alsp_item_listing_upgrade extends alsp_item_listing {
	
	public function getItemOptions() {
		global $alsp_instance;

		if ($listing = $this->getItem()) {
			$old_level_id = get_post_meta($listing->post->ID, '_old_level_id', true);
			$old_level = $alsp_instance->levels->levels_array[$old_level_id];

			$new_level_id = get_post_meta($listing->post->ID, '_new_level_id', true);
			$new_level = $alsp_instance->levels->levels_array[$new_level_id];
			
			return sprintf(__("From '%s' to '%s' level", 'ALSP'), $old_level->name, $new_level->name);
		} else
			return __("N/A", 'ALSP');
	}
	
	public function getItemOptionsString() {
		global $alsp_instance;

		if ($listing = $this->getItem()) {
			$old_level_id = get_post_meta($listing->post->ID, '_old_level_id', true);
			$old_level = $alsp_instance->levels->levels_array[$old_level_id];

			$new_level_id = get_post_meta($listing->post->ID, '_new_level_id', true);
			$new_level = $alsp_instance->levels->levels_array[$new_level_id];
			
			return sprintf(__("From '%s' to '%s' level", 'ALSP'), $old_level->name, $new_level->name);
		} else
			return __("N/A", 'ALSP');
	}

	public function complete() {
		if ($listing = $this->getItem()) {
			delete_post_meta($listing->post->ID, '_listing_upgrade_invoice');
			$new_level_id = get_post_meta($listing->post->ID, '_new_level_id', true);
			return $listing->changeLevel($new_level_id, false);
		}
	}
}

function alsp_delete_invoice_meta($post_id) {
	if (get_post_type($post_id) == ALSP_INVOICE_TYPE) {
		delete_post_meta($post_id, '_listing_upgrade_invoice');
	}
}
add_action('delete_post', 'alsp_delete_invoice_meta');

function alsp_create_upgrade_listing_invoice($continue, $listing) {
	$new_level_id = get_post_meta($listing->post->ID, '_new_level_id', true);
	if (recalcPrice($listing->level->upgrade_meta[$new_level_id]['price']) > 0) {
		if (!($invoice_id = get_post_meta($listing->post->ID, '_listing_upgrade_invoice', true)) || !($invoice = getInvoiceByID($invoice_id))) {
			$invoice_args = array(
					'item' => 'listing_upgrade',
					'title' => sprintf(__('Invoice for upgrade of listing: %s', 'ALSP'), $listing->title()),
					'is_subscription' => false,
					'price' => $listing->level->upgrade_meta[$new_level_id]['price'],
					'item_id' => $listing->post->ID,
					'author_id' => $listing->post->post_author
			);
			if ($invoice_id = call_user_func_array('alsp_create_invoice', $invoice_args)) {
				alsp_addMessage(sprintf(__('New invoice was created successfully, listing "%s" will be upgraded after payment', 'ALSP'), $listing->title()));
				update_post_meta($listing->post->ID, '_listing_upgrade_invoice', $invoice_id);
				return false;
			}
		} else {
			$invoice->setPrice($listing->level->upgrade_meta[$new_level_id]['price']);
		}
	} else {
		// When there is already existed invoice, but new level will be free - just remove this invoice
		if ($invoice_id = get_post_meta($listing->post->ID, '_listing_upgrade_invoice', true))
			wp_delete_post($invoice_id);

		return $continue;
	}
}
add_filter('alsp_listing_upgrade', 'alsp_create_upgrade_listing_invoice', 10, 2);

?>