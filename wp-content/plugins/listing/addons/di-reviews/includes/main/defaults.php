<?php return array
	(
		'cleanup' => array
			(
				'switch' => array('switch_not_available'),
			),

		'checks' => array
			(
				'counter' => array('is_numeric', 'not_empty'),
			),

		'processor' => array
			(
				// callback signature: (array $input, DiRP $processor)

				'preupdate' => array
					(
						// callbacks to run before update process
						// cleanup and validation has been performed on data
					),
				'postupdate' => array
					(
						// callbacks to run post update
					),
			),

		'errors' => array
			(
				'is_numeric' => esc_html__('Numeric value required.', 'comments-ratings'),
				'not_empty' => esc_html__('Field is required.', 'comments-ratings'),
			),

		'callbacks' => array
			(
			// cleanup callbacks
				'switch_not_available' => 'direviews_cleanup_switch_not_available',

			// validation callbacks
				'is_numeric' => 'direviews_validate_is_numeric',
				'not_empty' => 'direviews_validate_not_empty'
			)

	); # config
