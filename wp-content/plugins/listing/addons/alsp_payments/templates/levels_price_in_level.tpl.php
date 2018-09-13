<?php global $ALSP_ADIMN_SETTINGS; ?>
<tr>
				<th scope="row">
					<label><?php _e('Listings price', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="price"
						type="text"
						size="5"
						value="<?php if (isset($level->price)) echo $level->price; ?>" /> <?php echo $ALSP_ADIMN_SETTINGS['alsp_payments_symbol_code']; ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php _e('Listings raise up price', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="raiseup_price"
						type="text"
						size="5"
						value="<?php if (isset($level->raiseup_price)) echo $level->raiseup_price; ?>" /> <?php echo $ALSP_ADIMN_SETTINGS['alsp_payments_symbol_code']; ?>
				</td>
			</tr>