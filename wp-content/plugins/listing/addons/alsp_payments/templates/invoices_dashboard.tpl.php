<?php if ($frontend_controller->invoices): ?>
		<div class="alsp-table alsp-table-striped">
			<ul>
				<li class="td_invoices_title"><?php _e('Invoice', 'ALSP'); ?></li>
				<li class="td_invoices_item"><?php _e('Item', 'ALSP'); ?></li>
				<li class="td_invoices_price"><?php _e('Price', 'ALSP'); ?></li>
				<li class="td_invoices_payment"><?php _e('Payment', 'ALSP'); ?></li>
				<li class="td_invoices_date"><?php _e('Creation date', 'ALSP'); ?></li>
			</ul>
		<?php while ($frontend_controller->invoices_query->have_posts()): ?>
			<?php $frontend_controller->invoices_query->the_post(); ?>
			<?php $invoice = $frontend_controller->invoices[get_the_ID()]; ?>
			<ul>
				<li class="td_invoices_title">
					<?php
					if (alsp_current_user_can_edit_listing($invoice->post->ID))
						echo '<a href="' . alsp_get_edit_invoice_link($invoice->post->ID) . '">' . $invoice->post->post_title . '</a>';
					else
						echo $invoice->post->post_title;
					?>
				</li>
				<li class="td_invoices_item"><?php if (is_object($invoice->item_object)) echo $invoice->item_object->getItemLink(); ?></li>
				<li class="td_invoices_price"><?php echo $invoice->price(); ?></li>
				<li class="td_invoices_payment">
					<?php
					if ($invoice->status == 'unpaid') {
						echo '<span class="alsp-badge alsp-invoice-status-unpaid">' . __('unpaid', 'ALSP') . '</span>';
						if (alsp_current_user_can_edit_listing($invoice->post->ID))
							echo '<br /><a href="' . alsp_get_edit_invoice_link($invoice->post->ID) . '"><img src="' . ALSP_PAYMENTS_RESOURCES_URL . 'images/money_add.png' . '" class="alsp-field-icon" />' . __('pay invoice', 'ALSP') . '</a>';
					} elseif ($invoice->status == 'paid') {
						echo '<span class="alsp-badge alsp-invoice-status-paid">' . __('paid', 'ALSP') . '</span>';
						if ($invoice->gateway)
							echo '<br /><b>' . gatewayName($invoice->gateway) . '</b>';
					} elseif ($invoice->status == 'pending') {
						echo '<span class="alsp-badge alsp-invoice-status-pending">' . __('pending', 'ALSP') . '</span>';
						if ($invoice->gateway)
							echo '<br /><b>' . gatewayName($invoice->gateway) . '</b>';
					}
					?>
				</li>
				<li class="td_invoices_date"><?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($invoice->post->post_date)); ?></li>
			</ul>
		<?php endwhile; ?>
		</div>
		<?php alsp_renderPaginator($frontend_controller->invoices_query, '', false); ?>
	<?php endif; ?>