<?php
class Ai1wmdi_URL_Curl {

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
	 * cURL handler
	 *
	 * @var resource
	 */
	protected $handler = null;

	/**
	 * cURL options
	 *
	 * @var array
	 */
	protected $options = array();

	/**
	 * cURL headers
	 *
	 * @var array
	 */
	protected $headers = array( 'User-Agent' => 'All-in-One WP Migration' );

	/**
	 * cURL messages
	 *
	 * @var array
	 */
	protected $messages = array(
		// [Informational 1xx]
		100 => '100 Continue',
		101 => '101 Switching Protocols',

		// [Successful 2xx]
		200 => '200 OK',
		201 => '201 Created',
		202 => '202 Accepted',
		203 => '203 Non-Authoritative Information',
		204 => '204 No Content',
		205 => '205 Reset Content',
		206 => '206 Partial Content',

		// [Redirection 3xx]
		300 => '300 Multiple Choices',
		301 => '301 Moved Permanently',
		302 => '302 Found',
		303 => '303 See Other',
		304 => '304 Not Modified',
		305 => '305 Use Proxy',
		306 => '306 (Unused)',
		307 => '307 Temporary Redirect',

		// [Client Error 4xx]
		400 => '400 Bad Request',
		401 => '401 Unauthorized',
		402 => '402 Payment Required',
		403 => '403 Forbidden',
		404 => '404 Not Found',
		405 => '405 Method Not Allowed',
		406 => '406 Not Acceptable',
		407 => '407 Proxy Authentication Required',
		408 => '408 Request Timeout',
		409 => '409 Conflict',
		410 => '410 Gone',
		411 => '411 Length Required',
		412 => '412 Precondition Failed',
		413 => '413 Request Entity Too Large',
		414 => '414 Request-URI Too Long',
		415 => '415 Unsupported Media Type',
		416 => '416 Requested Range Not Satisfiable',
		417 => '417 Expectation Failed',

		// [Server Error 5xx]
		500 => '500 Internal Server Error',
		501 => '501 Not Implemented',
		502 => '502 Bad Gateway',
		503 => '503 Service Unavailable',
		504 => '504 Gateway Timeout',
		505 => '505 HTTP Version Not Supported',
	);

	public function __construct() {
		if ( ! extension_loaded( 'curl' ) ) {
			throw new Ai1wmdi_Error_Exception( __( 'URL Extension requires PHP cURL extension. <a href="https://help.servmask.com/knowledgebase/curl-missing-in-php-installation/" target="_blank">Technical details</a>', AI1WMDI_PLUGIN_NAME ) );
		}

		// Default configuration
		$this->set_option( CURLOPT_HEADER, false );
		$this->set_option( CURLOPT_RETURNTRANSFER, true );
		$this->set_option( CURLOPT_BINARYTRANSFER, true );
		$this->set_option( CURLOPT_FOLLOWLOCATION, true );
		$this->set_option( CURLOPT_SSL_VERIFYHOST, false );
		$this->set_option( CURLOPT_SSL_VERIFYPEER, false );
		$this->set_option( CURLOPT_CONNECTTIMEOUT, 120 );
		$this->set_option( CURLOPT_TIMEOUT, 0 );
	}

	/**
	 * Set scheme
	 *
	 * @param  string $value URL scheme
	 * @return object
	 */
	public function set_scheme( $value ) {
		$this->scheme = $value;
		return $this;
	}

	/**
	 * Get scheme
	 *
	 * @return string
	 */
	public function get_scheme() {
		return $this->scheme;
	}

	/**
	 * Set port
	 *
	 * @param  integer $value URL port
	 * @return object
	 */
	public function set_port( $value ) {
		$this->port = intval( $value );
		return $this;
	}

	/**
	 * Get port
	 *
	 * @return integer
	 */
	public function get_port() {
		return $this->port;
	}

	/**
	 * Set hostname
	 *
	 * @param  string $value URL hostname
	 * @return object
	 */
	public function set_hostname( $value ) {
		$this->hostname = $value;
		return $this;
	}

	/**
	 * Get hostname
	 *
	 * @return string
	 */
	public function get_hostname() {
		return $this->hostname;
	}

	/**
	 * Set username
	 *
	 * @param  string $username URL username
	 * @return object
	 */
	public function set_username( $value ) {
		$this->username = $value;
		return $this;
	}

	/**
	 * Get username
	 *
	 * @return string
	 */
	public function get_username() {
		return $this->username;
	}

	/**
	 * Set password
	 *
	 * @param  string $value URL password
	 * @return object
	 */
	public function set_password( $value ) {
		$this->password = $value;
		return $this;
	}

	/**
	 * Get password
	 *
	 * @return string
	 */
	public function get_password() {
		return $this->password;
	}

	/**
	 * Set path
	 *
	 * @param  string $value URL path
	 * @return object
	 */
	public function set_path( $value ) {
		$this->path = $value;
		return $this;
	}

	/**
	 * Get path
	 *
	 * @return string
	 */
	public function get_path() {
		return $this->path;
	}

	/**
	 * Set query
	 *
	 * @param  string $value URL query
	 * @return object
	 */
	public function set_query( $value ) {
		$this->query = $value;
		return $this;
	}

	/**
	 * Get query
	 *
	 * @return string
	 */
	public function get_query() {
		return $this->query;
	}

	/**
	 * Set cURL option
	 *
	 * @param  mixed  $name  cURL option name
	 * @param  mixed  $value cURL option value
	 * @return object
	 */
	public function set_option( $name, $value ) {
		$this->options[ $name ] = $value;
		return $this;
	}

	/**
	 * Get cURL option
	 *
	 * @param  mixed $name cURL option name
	 * @return mixed
	 */
	public function get_option( $name ) {
		return isset( $this->options[ $name ] ) ? $this->options[ $name ] : null;
	}

	/**
	 * Set cURL header
	 *
	 * @param  string $name  cURL header name
	 * @param  string $value cURL header value
	 * @return object
	 */
	public function set_header( $name, $value ) {
		$this->headers[ $name ] = $value;
		return $this;
	}

	/**
	 * Get cURL header
	 *
	 * @param  string $name cURL header name
	 * @return string
	 */
	public function get_header( $name ) {
		return isset( $this->headers[ $name ] ) ? $this->headers[ $name ] : null;
	}

	/**
	 * Make cURL request
	 *
	 * @param  boolean $parse_as_json JSON parse
	 * @return mixed
	 */
	public function make_request( $parse_as_json = false ) {
		// cURL handler
		$this->handler = curl_init();

		// Set URL address
		if ( $this->get_port() ) {
			$this->set_option( CURLOPT_URL, sprintf(
				'%s://%s:%d%s?%s',
				$this->get_scheme(),
				$this->get_hostname(),
				$this->get_port(),
				$this->get_path(),
				$this->get_query()
			) );
		} else {
			$this->set_option( CURLOPT_URL, sprintf(
				'%s://%s%s?%s',
				$this->get_scheme(),
				$this->get_hostname(),
				$this->get_path(),
				$this->get_query()
			) );
		}

		// Set username and password
		if ( $this->get_username() ) {
			$this->set_option( CURLOPT_USERPWD, sprintf(
				'%s:%s',
				$this->get_username(),
				$this->get_password()
			) );
		}

		// Apply cURL headers
		$http_headers = array();
		foreach ( $this->headers as $name => $value ) {
			$http_headers[] = "$name: $value";
		}

		$this->set_option( CURLOPT_HTTPHEADER, $http_headers );

		// Apply cURL options
		foreach ( $this->options as $name => $value ) {
			curl_setopt( $this->handler, $name, $value );
		}

		// HTTP request
		$response = curl_exec( $this->handler );
		if ( $response === false ) {
			if ( ( $errno = curl_errno( $this->handler ) ) ) {
				throw new Ai1wmdi_Connect_Exception( sprintf( __( 'Unable to connect to URL address. Error code: %s. <a href="https://help.servmask.com/knowledgebase/url-error-codes/#%s" target="_blank">Technical details</a>', AI1WMDI_PLUGIN_NAME ), $errno, $errno ) );
			}
		}

		// HTTP headers
		if ( $this->get_option( CURLOPT_HEADER ) ) {
			$headers  = substr( $response, 0, curl_getinfo( $this->handler, CURLINFO_HEADER_SIZE ) );
			$response = substr( $response, curl_getinfo( $this->handler, CURLINFO_HEADER_SIZE ) );
		}

		// HTTP errors
		$http_code = curl_getinfo( $this->handler, CURLINFO_HTTP_CODE );
		if ( $http_code >= 400 ) {
			if ( isset( $this->messages[ $http_code ] ) ) {
				throw new Ai1wmdi_Error_Exception( sprintf( __( '%s. <a href="https://help.servmask.com/knowledgebase/url-error-codes/#%s" target="_blank">Technical details</a>', AI1WMDI_PLUGIN_NAME ), $this->messages[ $http_code ], $http_code ) );
			} else {
				throw new Ai1wmdi_Error_Exception( sprintf( __( 'Error code: %s. <a href="https://help.servmask.com/knowledgebase/url-error-codes/#%s" target="_blank">Technical details</a>', AI1WMDI_PLUGIN_NAME ), $http_code, $http_code ) );
			}
		}

		// HTTP headers
		if ( $this->get_option( CURLOPT_HEADER ) ) {
			return $this->http_parse_headers( $headers );
		}

		// JSON response
		if ( $parse_as_json ) {
			return json_decode( $response, true );
		}

		return $response;
	}

	/**
	 * Parse HTTP headers
	 *
	 * @param  string $headers HTTP headers
	 * @return array
	 */
	public function http_parse_headers( $headers ) {
		$headers = preg_split( '/(\r|\n)+/', $headers, -1, PREG_SPLIT_NO_EMPTY );

		$parse_headers = array();
		for ( $i = 1; $i < count( $headers ); $i++ ) {
			if ( strpos( $headers[ $i ], ':' ) !== false ) {
				list( $key, $raw_value ) = explode( ':', $headers[ $i ], 2 );

				$key   = trim( $key );
				$value = trim( $raw_value );
				if ( array_key_exists( $key, $parse_headers ) ) {
					// See HTTP RFC Sec 4.2 Paragraph 5
					// http://www.w3.org/Protocols/rfc2616/rfc2616-sec4.html#sec4.2
					// If a header appears more than once, it must also be able to
					// be represented as a single header with a comma-separated
					// list of values.  We transform accordingly.
					$parse_headers[ $key ] .= ',' . $value;
				} else {
					$parse_headers[ $key ] = $value;
				}
			}
		}

		return $parse_headers;
	}

	/**
	 * Destroy cURL handler
	 *
	 * @return void
	 */
	public function __destruct() {
		if ( $this->handler !== null ) {
			curl_close( $this->handler );
		}
	}
}
