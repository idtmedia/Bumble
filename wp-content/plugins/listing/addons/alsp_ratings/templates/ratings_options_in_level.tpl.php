<tr>
				<th scope="row">
					<label><?php _e('Ratings', 'ALSP'); ?></label>
				</th>
				<td>
					<input
						name="ratings_enabled"
						type="checkbox"
						value="1"
						<?php if (isset($level->ratings_enabled)) checked($level->ratings_enabled, 1, true); ?> />
				</td>
			</tr>