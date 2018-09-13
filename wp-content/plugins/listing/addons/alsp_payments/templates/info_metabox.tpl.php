<?php global $ALSP_ADIMN_SETTINGS; ?>
<div id="misc-publishing-actions">
	<?php if ($ALSP_ADIMN_SETTINGS['alsp_enable_taxes']): ?>
	<div class="misc-pub-section">
		<span>
			<?php echo nl2br($ALSP_ADIMN_SETTINGS['alsp_taxes_info']); ?>
		</span>
	</div>
	<?php endif; ?>
	<div class="misc-pub-section">
		<span>
			<b><?php echo $invoice->post->post_title; ?></b>
		</span>
	</div>
	<div class="misc-pub-section">
		<label><?php _e('Invoice ID', 'ALSP'); ?>:</label>
		<span>
			<b><?php echo $invoice->post->ID; ?></b>
		</span>
	</div>
	<?php if ($invoice->post->post_author != get_current_user_id()): ?>
	<div class="misc-pub-section">
		<label><?php _e('Author', 'ALSP'); ?>:</label>
		<span>
			<a href="<?php echo get_edit_user_link($invoice->post->post_author); ?>"><?php echo get_userdata($invoice->post->post_author)->user_login; ?></a>
		</span>
	</div>
	<?php endif; ?>
	<?php if ($billing_info = $invoice->billingInfo()): ?>
	<div class="misc-pub-section">
		<label><?php _e('Bill To', 'ALSP'); ?>:</label>
		<span>
			<?php echo $billing_info; ?>
		</span>
	</div>
	<?php endif; ?>
	<div class="misc-pub-section">
		<label><?php _e('Item', 'ALSP'); ?>:</label>
		<span>
			<?php if (is_object($invoice->item_object)) echo $invoice->item_object->getItemLink(); ?>
		</span>
	</div>
	<?php if ($invoice->item_object->getItemOptions()): ?>
	<div class="misc-pub-section">
		<label><?php _e('Item options', 'ALSP'); ?>:</label>
		<span>
			<b><?php echo $invoice->item_object->getItemOptionsString(); ?></b>
		</span>
	</div>
	<?php endif; ?>
	<div class="misc-pub-section">
		<label><?php _e('Price', 'ALSP'); ?>:</label>
		<span>
			<b><?php echo $invoice->price(); ?></b> <?php echo $invoice->taxesString(); ?>
		</span>
	</div>
	<?php if ($ALSP_ADIMN_SETTINGS['alsp_enable_taxes'] && $ALSP_ADIMN_SETTINGS['alsp_tax_name']): ?>
	<div class="misc-pub-section">
		<label><?php echo $ALSP_ADIMN_SETTINGS['alsp_tax_name']; ?>:</label>
		<span>
			<b><?php echo $invoice->taxesAmount(); ?></b>
		</span>
	</div>
	<div class="misc-pub-section">
		<label><?php _e('Total', 'ALSP'); ?>:</label>
		<span>
			<b><?php echo $invoice->taxesPrice(); ?></b>
		</span>
	</div>
	<?php endif; ?>
	<div class="misc-pub-section">
		<label><?php _e('Status', 'ALSP'); ?>:</label>
		<span>
			<?php if ($invoice->status == 'unpaid')
				echo '<span class="alsp-badge alsp-invoice-status-unpaid">' . __('unpaid', 'ALSP') . '</span>';
			elseif ($invoice->status == 'paid')
				echo '<span class="alsp-badge alsp-invoice-status-paid">' . __('paid', 'ALSP') . '</span>';
			elseif ($invoice->status == 'pending')
				echo '<span class="alsp-badge alsp-invoice-status-pending">' . __('pending', 'ALSP') . '</span>';
			?>
		</span>
		<?php do_action('alsp_invoice_status_option', $invoice); ?>
	</div>
	<?php if ($invoice->gateway): ?>
	<div class="misc-pub-section">
		<label><?php _e('Gateway', 'ALSP'); ?>:</label>
		<span>
			<b><?php echo gatewayName($invoice->gateway); ?></b>
		</span>
	</div>
	<?php endif; ?>
</div>