<?php
class Ai1wmdi_URL_Client {

	/**
	 * URL scheme
	 *
	 * @var string
	 */
	protected $scheme = null;

	/**
	 * URL port
	 *
	 * @var integer
	 */
	protected $port = null;

	/**
	 * URL hostname
	 *
	 * @var string
	 */
	protected $hostname = null;

	/**
	 * URL username
	 *
	 * @var string
	 */
	protected $username = null;

	/**
	 * URL password
	 *
	 * @var string
	 */
	protected $password = null;

	/**
	 * URL path
	 *
	 * @var string
	 */
	protected $path = null;

	/**
	 * URL query
	 *
	 * @var string
	 */
	protected $query = null;

	/**
	 * Set base URL
	 *
	 * @param $url URL string
	 */
	public function set_base_url( $url ) {
		$this->scheme   = parse_url( $url, PHP_URL_SCHEME );
		$this->port     = parse_url( $url, PHP_URL_PORT );
		$this->hostname = parse_url( $url, PHP_URL_HOST );
		$this->username = parse_url( $url, PHP_URL_USER );
		$this->password = parse_url( $url, PHP_URL_PASS );
		$this->path     = parse_url( $url, PHP_URL_PATH );
		$this->query    = parse_url( $url, PHP_URL_QUERY );
	}

	/**
	 * Get file meta
	 *
	 * @param  object $adapter URL HTTP client
	 * @return array
	 */
	public function get_file_meta( $adapter = null ) {
		if ( is_null( $adapter ) ) {
			$adapter = new Ai1wmdi_URL_Curl;
		}

		$adapter->set_scheme( $this->scheme );
		$adapter->set_port( $this->port );
		$adapter->set_hostname( $this->hostname );
		$adapter->set_username( $this->username );
		$adapter->set_password( $this->password );
		$adapter->set_path( $this->path );
		$adapter->set_query( $this->query );
		$adapter->set_option( CURLOPT_HEADER, true );
		$adapter->set_option( CURLOPT_NOBODY, true );

		try {
			$response = $adapter->make_request();
		} catch ( Ai1wmdi_Error_Exception $e ) {
			throw $e;
		}

		return $response;
	}

	/**
	 * Get file size
	 *
	 * @param  object  $adapter URL HTTP client
	 * @return integer
	 */
	public function get_file_size( $adapter = null ) {
		if ( is_null( $adapter ) ) {
			$adapter = new Ai1wmdi_URL_Curl;
		}

		$adapter->set_scheme( $this->scheme );
		$adapter->set_port( $this->port );
		$adapter->set_hostname( $this->hostname );
		$adapter->set_username( $this->username );
		$adapter->set_password( $this->password );
		$adapter->set_path( $this->path );
		$adapter->set_query( $this->query );
		$adapter->set_option( CURLOPT_HEADER, true );
		$adapter->set_option( CURLOPT_NOBODY, true );

		try {
			$response = $adapter->make_request();
		} catch ( Ai1wmdi_Error_Exception $e ) {
			throw $e;
		}

		// Get headers
		$headers = array_change_key_case( $response );

		// Get file size
		if ( isset( $headers['accept-ranges'] ) && isset( $headers['content-length'] ) ) {
			if ( $headers['accept-ranges'] === 'bytes' ) {
				return (int) $headers['content-length'];
			}
		}
	}

	/**
	 * Get file location
	 *
	 * @param  object $adapter URL HTTP client
	 * @return string
	 */
	public function get_file_location( $adapter = null ) {
		if ( is_null( $adapter ) ) {
			$adapter = new Ai1wmdi_URL_Curl;
		}

		$adapter->set_scheme( $this->scheme );
		$adapter->set_port( $this->port );
		$adapter->set_hostname( $this->hostname );
		$adapter->set_username( $this->username );
		$adapter->set_password( $this->password );
		$adapter->set_path( $this->path );
		$adapter->set_query( $this->query );
		$adapter->set_option( CURLOPT_HEADER, true );
		$adapter->set_option( CURLOPT_NOBODY, true );

		try {
			$response = $adapter->make_request();
		} catch ( Ai1wmdi_Error_Exception $e ) {
			throw $e;
		}

		// Get headers
		$headers = array_change_key_case( $response );

		// Get file size
		if ( isset( $headers['location'] ) ) {
			return (string) $headers['location'];
		}
	}

	/**
	 * Download file
	 *
	 * @param  resource $file_stream File stream
	 * @param  array    $params      File parameters
	 * @param  object   $adapter     URL HTTP client
	 * @return void
	 */
	public function download_file( $file_stream, &$params = array(), $adapter = null ) {
		if ( is_null( $adapter ) ) {
			$adapter = new Ai1wmdi_URL_Curl;
		}

		$adapter->set_scheme( $this->scheme );
		$adapter->set_port( $this->port );
		$adapter->set_hostname( $this->hostname );
		$adapter->set_username( $this->username );
		$adapter->set_password( $this->password );
		$adapter->set_path( $this->path );
		$adapter->set_query( $this->query );
		$adapter->set_option( CURLOPT_RETURNTRANSFER, true );
		$adapter->set_option( CURLOPT_FILE, $file_stream );
		$adapter->set_option( CURLOPT_PROGRESSFUNCTION, array( $this, 'download_progress' ) );
		$adapter->set_option( CURLOPT_NOPROGRESS, false );

		try {
			$adapter->make_request();
		} catch ( Ai1wmdi_Error_Exception $e ) {
			throw $e;
		}
	}

	/**
	 * Function to track the download progress
	 *
	 * @param resource $resource   File stream
	 * @param integer  $file_size  File size
	 * @param integer  $downloaded Downloaded size
	 */
	public function download_progress( $resource, $file_size, $downloaded ) {
		// Check if filesize is passed
		if ( $file_size ) {
			// Calculate the percentage
			$percent = (int) ( ( $downloaded / $file_size ) * 100 );

			// Set progress
			Ai1wm_Status::progress( $percent );
		} else {
			// Set progress
			Ai1wm_Status::info( __( 'Downloading the archive..', AI1WMDI_PLUGIN_NAME ) );
		}
	}

	/**
	 * Download file in chunks
	 *
	 * @param  resource $file_stream File stream
	 * @param  array    $params      File parameters
	 * @param  object   $adapter     URL HTTP client
	 * @return void
	 */
	public function download_file_chunk( $file_stream, &$params = array(), $adapter = null ) {
		if ( is_null( $adapter ) ) {
			$adapter = new Ai1wmdi_URL_Curl;
		}

		$adapter->set_scheme( $this->scheme );
		$adapter->set_port( $this->port );
		$adapter->set_hostname( $this->hostname );
		$adapter->set_username( $this->username );
		$adapter->set_password( $this->password );
		$adapter->set_path( $this->path );
		$adapter->set_query( $this->query );
		$adapter->set_option( CURLOPT_RANGE, sprintf( '%d-%d', $params['start_bytes'], $params['end_bytes'] ) );

		try {
			$chunk_data = $adapter->make_request();
		} catch ( Ai1wmdi_Error_Exception $e ) {
			throw $e;
		}

		// Copy chunk data into file stream
		if ( fwrite( $file_stream, $chunk_data ) === false ) {
			throw new Ai1wmdi_Error_Exception( __( 'Unable to save the file from URL address', AI1WMDI_PLUGIN_NAME ) );
		}

		// Next start bytes
		if ( $params['total_bytes'] < ( $params['start_bytes'] + AI1WMDI_FILE_CHUNK_SIZE ) ) {
			$params['start_bytes'] = $params['total_bytes'];
		} else {
			$params['start_bytes'] = $params['end_bytes'] + 1;
		}

		// Next end bytes
		if ( $params['total_bytes'] < ( $params['end_bytes'] + AI1WMDI_FILE_CHUNK_SIZE ) ) {
			$params['end_bytes'] = $params['total_bytes'];
		} else {
			$params['end_bytes'] += AI1WMDI_FILE_CHUNK_SIZE;
		}
	}
}
