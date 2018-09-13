<?php
class Ai1wmdi_Import_Url {

	public static function execute( $params, $client = null ) {

		// Set progress
		Ai1wm_Status::info( __( 'Creating an empty archive...', AI1WMDI_PLUGIN_NAME ) );

		// Set domain
		$domain = parse_url( $params['file_url'], PHP_URL_HOST );

		// Set URL client
		if ( empty( $client ) ) {
			$client = new Ai1wmdi_URL_Client;
		}

		// Rewrite URLs
		switch ( $domain ) {
			case '1drv.ms':
			case 'onedrive.live.com':
				$matches = array();

				// Extract ID from the URL and construct the new URL for the request
				if ( preg_match( '/\/u\/(.+?)(\/|$)/', $params['file_url'], $matches ) ) {
					$params['file_url'] = sprintf( 'https://api.onedrive.com/v1.0/shares/%s/root/content', $matches[1] );
				}

				// Set base URL
				$client->set_base_url( $params['file_url'] );

				// Set file location
				$params['file_url'] = $client->get_file_location();

				break;

			case 'googledrive.com':
			case 'drive.google.com':
			case 'www.googledrive.com':
				$query = array();

				// Parse the query parameters from the URL
				parse_str( parse_url( $params['file_url'], PHP_URL_QUERY ), $query );

				// Determine if the query contains ID
				if ( isset( $query['id'] ) ) {

					// Create a download link for the Google Drive file
					$params['file_url'] = sprintf( 'https://www.drive.google.com/uc?export=download&id=%s', $query['id'] );
				} else {
					$matches = array();

					// Extract ID from the URL and construct the new URL for the request
					if ( preg_match( '/\/d\/(.+?)(\/|$)/', $params['file_url'], $matches ) ) {
						$params['file_url'] = sprintf( 'https://www.drive.google.com/uc?export=download&id=%s', $matches[1] );
					}
				}

				break;

			case 'dropbox.com':
			case 'www.dropbox.com':
				// Set "file_url" with "dl" value equal to one
				$params['file_url'] = str_replace( 'dl=0', 'dl=1', $params['file_url'] );

				break;
		}

		// Set base URL
		$client->set_base_url( $params['file_url'] );

		// Set file size
		$params['total_bytes'] = $client->get_file_size();

		// Create empty archive file
		$archive = new Ai1wm_Compressor( ai1wm_archive_path( $params ) );
		$archive->close();

		// Set progress
		Ai1wm_Status::info( __( 'Done creating an empty archive.', AI1WMDI_PLUGIN_NAME ) );

		return $params;
	}
}
