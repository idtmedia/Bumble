<?php
class Ai1wmdi_Import_Download {

	public static function execute( $params, $client = null ) {

		// Set completed flag
		$params['completed'] = false;

		// Set URL client
		if ( empty( $client ) ) {
			$client = new Ai1wmdi_URL_Client;
		}

		// Set base URL
		$client->set_base_url( $params['file_url'] );

		// Get archive file
		$archive = fopen( ai1wm_archive_path( $params ), 'ab' );

		if ( ! empty( $params['total_bytes'] ) ) {

			// Set start bytes
			if ( ! isset( $params['start_bytes'] ) ) {
				$params['start_bytes'] = 0;
			}

			// Set end bytes
			if ( ! isset( $params['end_bytes'] ) ) {
				$params['end_bytes'] = AI1WMDI_FILE_CHUNK_SIZE;
			}

			// Set retry
			if ( ! isset( $params['retry'] ) ) {
				$params['retry'] = 0;
			}

			try {

				// Increase number of retries
				$params['retry'] += 1;

				// Download file in chunks
				$client->download_file_chunk( $archive, $params );

			} catch ( Ai1wmdi_Connect_Exception $e ) {
				// Retry 3 times
				if ( $params['retry'] <= 3 ) {
					return $params;
				}

				throw $e;
			}

			// Unset retry counter
			unset( $params['retry'] );

			// Calculate percent
			$percent = (int) ( ( $params['start_bytes'] / $params['total_bytes'] ) * 100 );

			// Set progress
			Ai1wm_Status::progress( $percent );

			// Completed?
			if ( $params['total_bytes'] == $params['start_bytes'] ) {

				// Unset total bytes
				unset( $params['total_bytes'] );

				// Unset start bytes
				unset( $params['start_bytes'] );

				// Unset end bytes
				unset( $params['end_bytes'] );

				// Unset completed flag
				unset( $params['completed'] );

			}
		} else {

			// Try to download the file in one request
			$client->download_file( $archive, $params );

			// Unset completed flag
			unset( $params['completed'] );

		}

		// Closing the archive
		fclose( $archive );

		return $params;
	}
}
