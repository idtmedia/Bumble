<?php

// This library was taken from codeigniter framework v2.1.4
add_action('init', 'alsp_register_error_messages');
function alsp_register_error_messages() {
	global $wp_error_messages;

	$wp_error_messages = array(
			'required'	=> __('The %s field is required.', 'ALSP'),
			'isset' => __('The %s field must have a value.', 'ALSP'),
			'valid_date' => __('The %s field must contain a valid date.', 'ALSP'),
			'valid_email' => __('The %s field must contain a valid email address.', 'ALSP'),
			'valid_emails' => __('The %s field must contain all valid email addresses.', 'ALSP'),
			'valid_url' => __('The %s field must contain a valid URL.', 'ALSP'),
			'valid_ip' => __('The %s field must contain a valid IP.', 'ALSP'),
			'min_length' => __('The %s field must be at least %s characters in length.', 'ALSP'),
			'max_length' => __('The %s field can not exceed %s characters in length.', 'ALSP'),
			'exact_length' => __('The %s field must be exactly %s characters in length.', 'ALSP'),
			'alpha' => __('The %s field may only contain alphabetical characters.', 'ALSP'),
			'alpha_numeric' => __('The %s field may only contain alpha-numeric characters.', 'ALSP'),
			'alpha_dash' => __('The %s field may only contain alpha-numeric characters, underscores, and dashes.', 'ALSP'),
			'numeric' => __('The %s field must contain only numbers.', 'ALSP'),
			'is_numeric' => __('The %s field must contain only numeric characters.', 'ALSP'),
			'integer' => __('The %s field must contain an integer.', 'ALSP'),
			'regex_match' => __('The %s field is not in the correct format.', 'ALSP'),
			'matches' => __('The %s field does not match the %s field.', 'ALSP'),
			'is_unique' => __('The %s field must contain a unique value.', 'ALSP'),
			'is_natural' => __('The %s field must contain only positive numbers.', 'ALSP'),
			'is_natural_no_zero' => __('The %s field must contain a number greater than zero.', 'ALSP'),
			'decimal' => __('The %s field must contain a decimal number.', 'ALSP'),
			'less_than' => __('The %s field must contain a number less than %s.', 'ALSP'),
			'greater_than' => __('The %s field must contain a number greater than %s.', 'ALSP'),
	);
}

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Form Validation Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Validation
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/alsp_form_validation.html
 */
class alsp_form_validation {

	protected $_field_data			= array();
	//protected $_config_rules		= array();
	protected $_error_array			= array();
	protected $_error_messages		= array();
	protected $_error_prefix		= '<p>';
	protected $_error_suffix		= '</p>';
	protected $error_string			= '';
	protected $_safe_form_data		= FALSE;

	public function __construct() {
		global $wp_error_messages;

		$this->_error_messages = array_merge($this->_error_messages, $wp_error_messages);
	}

	/**
	 * List of never allowed strings
	 *
	 * @var array
	 * @access protected
	 */
	protected $_never_allowed_str = array(
			'document.cookie'	=> '[removed]',
			'document.write'	=> '[removed]',
			'.parentNode'		=> '[removed]',
			'.innerHTML'		=> '[removed]',
			'window.location'	=> '[removed]',
			'-moz-binding'		=> '[removed]',
			'<!--'				=> '&lt;!--',
			'-->'				=> '--&gt;',
			'<![CDATA['			=> '&lt;![CDATA[',
			'<comment>'			=> '&lt;comment&gt;'
	);
	
	/* never allowed, regex replacement */
	/**
	 * List of never allowed regex replacement
	 *
	 * @var array
	 * @access protected
	 */
	protected $_never_allowed_regex = array(
			'javascript\s*:',
			'expression\s*(\(|&\#40;)', // CSS and IE
			'vbscript\s*:', // IE, surprise!
			'Redirect\s+302',
			"([\"'])?data\s*:[^\\1]*?base64[^\\1]*?,[^\\1]*?\\1?"
	);

	/**
	 * Set Rules
	 *
	 * This function takes an array of field names and validation
	 * rules as input, validates the info, and stores it
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @return	void
	 */
	public function set_rules($field, $label = '', $rules = '')
	{
		// No reason to set rules if we have no POST data
		if (count($_POST) == 0)
		{
			return $this;
		}

		// If an array was passed via the first parameter instead of indidual string
		// values we cycle through it and recursively call this function.
		if (is_array($field))
		{
			foreach ($field as $row)
			{
				// Houston, we have a problem...
				if ( ! isset($row['field']) OR ! isset($row['rules']))
				{
					continue;
				}

				// If the field label wasn't passed we use the field name
				$label = ( ! isset($row['label'])) ? $row['field'] : $row['label'];

				// Here we go!
				$this->set_rules($row['field'], $label, $row['rules']);
			}
			return $this;
		}

		// No fields? Nothing to do...
		if ( ! is_string($field) OR  ! is_string($rules) OR $field == '')
		{
			return $this;
		}

		// If the field label wasn't passed we use the field name
		$label = ($label == '') ? $field : $label;

		// Is the field name an array?  We test for the existence of a bracket "[" in
		// the field name to determine this.  If it is an array, we break it apart
		// into its components so that we can fetch the corresponding POST data later
		if (strpos($field, '[') !== FALSE AND preg_match_all('/\[(.*?)\]/', $field, $matches))
		{
			// Note: Due to a bug in current() that affects some versions
			// of PHP we can not pass function call directly into it
			$x = explode('[', $field);
			$indexes[] = current($x);

			for ($i = 0; $i < count($matches['0']); $i++)
			{
				if ($matches['1'][$i] != '')
				{
					$indexes[] = $matches['1'][$i];
				}
			}

			$is_array = TRUE;
		}
		else
		{
			$indexes	= array();
			$is_array	= FALSE;
		}

		// Build our master array
		$this->_field_data[$field] = array(
			'field'				=> $field,
			'label'				=> $label,
			'rules'				=> $rules,
			'is_array'			=> $is_array,
			'keys'				=> $indexes,
			'postdata'			=> NULL,
			'error'				=> ''
		);

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Error Message
	 *
	 * Lets users set their own error messages on the fly.  Note:  The key
	 * name has to match the  function name that it corresponds to.
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	public function set_message($lang, $val = '')
	{
		if ( ! is_array($lang))
		{
			$lang = array($lang => $val);
		}

		$this->_error_messages = array_merge($this->_error_messages, $lang);

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set The Error Delimiter
	 *
	 * Permits a prefix/suffix to be added to each error message
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	public function set_error_delimiters($prefix = '<p>', $suffix = '</p>')
	{
		$this->_error_prefix = $prefix;
		$this->_error_suffix = $suffix;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Error Message
	 *
	 * Gets the error message associated with a particular field
	 *
	 * @access	public
	 * @param	string	the field name
	 * @return	void
	 */
	public function error($field = '', $prefix = '', $suffix = '')
	{
		if ( ! isset($this->_field_data[$field]['error']) OR $this->_field_data[$field]['error'] == '')
		{
			return '';
		}

		if ($prefix == '')
		{
			$prefix = $this->_error_prefix;
		}

		if ($suffix == '')
		{
			$suffix = $this->_error_suffix;
		}

		return $prefix.$this->_field_data[$field]['error'].$suffix;
	}

	// --------------------------------------------------------------------

	/**
	 * Error String
	 *
	 * Returns the error messages as a string, wrapped in the error delimiters
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	str
	 */
	public function error_string($prefix = '', $suffix = '')
	{
		// No errrors, validation passes!
		if (count($this->_error_array) === 0)
		{
			return '';
		}

		if ($prefix == '')
		{
			$prefix = $this->_error_prefix;
		}

		if ($suffix == '')
		{
			$suffix = $this->_error_suffix;
		}

		// Generate the error string
		$str = '';
		foreach ($this->_error_array as $val)
		{
			if ($val != '')
			{
				$str .= $prefix.$val.$suffix."\n";
			}
		}

		return $str;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Error Array
	 *
	 * Returns the error messages as a string, wrapped in the error delimiters
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	str
	 */
	public function error_array()
	{
		// No errrors, validation passes!
		if (count($this->_error_array) === 0)
		{
			return array();
		}

		return $this->_error_array;
	}

	// --------------------------------------------------------------------

	/**
	 * Run the Validator
	 *
	 * This function does all the work.
	 *
	 * @access	public
	 * @return	bool
	 */
	public function run($group = '')
	{
		// Do we even have any data to process?  Mm?
		if (count($_POST) == 0)
		{
			return FALSE;
		}

		// Does the _field_data array containing the validation rules exist?
		// If not, we look to see if they were assigned via a config file
		if (count($this->_field_data) == 0)
		{
			// No validation rules?  We're done...
			/* if (count($this->_config_rules) == 0)
			{
				return FALSE;
			} */

			// Is there a validation rule for the particular URI being accessed?
			/* $uri = ($group == '') ? trim($this->CI->uri->ruri_string(), '/') : $group;

			if ($uri != '' AND isset($this->_config_rules[$uri]))
			{
				$this->set_rules($this->_config_rules[$uri]);
			}
			else
			{
				$this->set_rules($this->_config_rules);
			} */

			// We're we able to set the rules correctly?
			if (count($this->_field_data) == 0)
			{
				//log_message('debug', "Unable to find validation rules");
				return FALSE;
			}
		}

		// Load the language file containing error messages
		//$this->CI->lang->load('alsp_form_validation');

		// Cycle through the rules for each field, match the
		// corresponding $_POST item and test for errors
		foreach ($this->_field_data as $field => $row)
		{
			// Fetch the data from the corresponding $_POST array and cache it in the _field_data array.
			// Depending on whether the field name is an array or a string will determine where we get it from.

			if ($row['is_array'] == TRUE)
			{
				$this->_field_data[$field]['postdata'] = $this->_reduce_array($_POST, $row['keys']);
			}
			else
			{
				if (isset($_POST[$field])/*  AND $_POST[$field] != "" */)
				{
					$this->_field_data[$field]['postdata'] = $_POST[$field];
				}
			}

			$this->_execute($row, explode('|', $row['rules']), $this->_field_data[$field]['postdata']);
		}

		// Did we end up with any errors?
		$total_errors = count($this->_error_array);

		if ($total_errors > 0)
		{
			$this->_safe_form_data = TRUE;
		}

		// Now we need to re-set the POST data with the new, processed data
		$this->_reset_post_array();

		// No errors, validation passes!
		if ($total_errors == 0)
		{
			return TRUE;
		}

		// Validation fails
		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Traverse a multidimensional $_POST array index until the data is found
	 *
	 * @access	private
	 * @param	array
	 * @param	array
	 * @param	integer
	 * @return	mixed
	 */
	protected function _reduce_array($array, $keys, $i = 0)
	{
		if (is_array($array))
		{
			if (isset($keys[$i]))
			{
				if (isset($array[$keys[$i]]))
				{
					$array = $this->_reduce_array($array[$keys[$i]], $keys, ($i+1));
				}
				else
				{
					return NULL;
				}
			}
			else
			{
				return $array;
			}
		}

		return $array;
	}

	// --------------------------------------------------------------------

	/**
	 * Re-populate the _POST array with our finalized and processed data
	 *
	 * @access	private
	 * @return	null
	 */
	protected function _reset_post_array()
	{
		foreach ($this->_field_data as $field => $row)
		{
			if ( ! is_null($row['postdata']))
			{
				if ($row['is_array'] == FALSE)
				{
					if (isset($_POST[$row['field']]))
					{
						$_POST[$row['field']] = $this->prep_for_form($row['postdata']);
					}
				}
				else
				{
					// start with a reference
					$post_ref =& $_POST;

					// before we assign values, make a reference to the right POST key
					if (count($row['keys']) == 1)
					{
						$post_ref =& $post_ref[current($row['keys'])];
					}
					else
					{
						foreach ($row['keys'] as $val)
						{
							$post_ref =& $post_ref[$val];
						}
					}

					if (is_array($row['postdata']))
					{
						$array = array();
						foreach ($row['postdata'] as $k => $v)
						{
							$array[$k] = $this->prep_for_form($v);
						}

						$post_ref = $array;
					}
					else
					{
						$post_ref = $this->prep_for_form($row['postdata']);
					}
				}
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Executes the Validation routines
	 *
	 * @access	private
	 * @param	array
	 * @param	array
	 * @param	mixed
	 * @param	integer
	 * @return	mixed
	 */
	protected function _execute($row, $rules, $postdata = NULL, $cycles = 0)
	{
		// If the $_POST data is an array we will run a recursive call
		if (is_array($postdata))
		{
			foreach ($postdata as $key => $val)
			{
				// we may insert ANY value in input keys - so we have to pass $key instead of $cycles
				$this->_execute($row, $rules, $val, $key);
				
				//$this->_execute($row, $rules, $val, $cycles);
				//$cycles++;
			}

			return;
		}

		// --------------------------------------------------------------------

		// If the field is blank, but NOT required, no further tests are necessary
		$callback = FALSE;
		if ( ! in_array('required', $rules) AND is_null($postdata) AND !in_array('is_checked', $rules))
		{
			// Before we bail out, does the rule contain a callback?
			if (preg_match("/(callback_\w+(\[.*?\])?)/", implode(' ', $rules), $match))
			{
				$callback = TRUE;
				$rules = (array('1' => $match[1]));
			}
			else
			{
				return;
			}
		}

		// --------------------------------------------------------------------

		// Isset Test. Typically this rule will only apply to checkboxes.
		if (is_null($postdata) AND $callback == FALSE)
		{
			if (in_array('isset', $rules, TRUE) OR in_array('required', $rules))
			{
				// Set the message type
				$type = (in_array('required', $rules)) ? 'required' : 'isset';

				if ( ! isset($this->_error_messages[$type]))
				{
					/* if (FALSE === ($line = $this->CI->lang->line($type)))
					{
						$line = 'The field was not set';
					} */
				}
				else
				{
					$line = $this->_error_messages[$type];
				}

				// Build the error message
				$message = sprintf($line, $this->_translate_fieldname($row['label']));

				// Save the error message
				$this->_field_data[$row['field']]['error'] = $message;

				if ( ! isset($this->_error_array[$row['field']]))
				{
					$this->_error_array[$row['field']] = $message;
				}
			} else {
				// Set 0 for the unchecked checkbox
				if (in_array('is_checked', $rules)) {
					$this->_field_data[$row['field']]['postdata'] = 0;
				}
			}

			return;
		}

		// --------------------------------------------------------------------

		// Cycle through each rule and run it
		foreach ($rules As $rule)
		{
			$_in_array = FALSE;

			// We set the $postdata variable with the current data in our master array so that
			// each cycle of the loop is dealing with the processed data from the last cycle
			if ($row['is_array'] == TRUE AND is_array($this->_field_data[$row['field']]['postdata']))
			{
				// We shouldn't need this safety, but just in case there isn't an array index
				// associated with this cycle we'll bail out
				if ( ! isset($this->_field_data[$row['field']]['postdata'][$cycles]))
				{
					continue;
				}

				$postdata = $this->_field_data[$row['field']]['postdata'][$cycles];
				$_in_array = TRUE;
			}
			else
			{
				$postdata = $this->_field_data[$row['field']]['postdata'];
			}

			// --------------------------------------------------------------------

			// Is the rule a callback?
			$callback = FALSE;
			if (substr($rule, 0, 9) == 'callback_')
			{
				$rule = substr($rule, 9);
				$callback = TRUE;
			}

			// Strip the parameter (if exists) from the rule
			// Rules can contain a parameter: max_length[5]
			$param = FALSE;
			if (preg_match("/(.*?)\[(.*)\]/", $rule, $match))
			{
				$rule	= $match[1];
				$param	= $match[2];
			}

			// Call the function that corresponds to the rule
			/* if ($callback === TRUE)
			{
				if ( ! method_exists($this->CI, $rule))
				{
					continue;
				}

				// Run the function and grab the result
				$result = $this->CI->$rule($postdata, $param);

				// Re-assign the result to the master data array
				if ($_in_array == TRUE)
				{
					$this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
				}
				else
				{
					$this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
				}

				// If the field isn't required and we just processed a callback we'll move on...
				if ( ! in_array('required', $rules, TRUE) AND $result !== FALSE)
				{
					continue;
				}
			}
			else
			{ */
				if ( ! method_exists($this, $rule))
				{
					// If our own wrapper function doesn't exist we see if a native PHP function does.
					// Users can use any native PHP function call that has one param.
					if (function_exists($rule))
					{
						$result = $rule($postdata);

						if ($_in_array == TRUE)
						{
							$this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
						}
						else
						{
							$this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
						}
					}
					else
					{
						//log_message('debug', "Unable to find validation rule: ".$rule);
					}

					continue;
				}

				$result = $this->$rule($postdata, $param);

				if ($rule == 'is_checked') {
					//// Set 1 for the checked checkbox
					if ($_in_array == TRUE)
					{
						$this->_field_data[$row['field']]['postdata'][$cycles] = 1;
					}
					else
					{
						$this->_field_data[$row['field']]['postdata'] = 1;
					}
				} else {
					if ($_in_array == TRUE)
					{
						$this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
					}
					else
					{
						$this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
					}
				}
			//}

			// Did the rule test negatively?  If so, grab the error.
			if ($result === FALSE)
			{
				if ( ! isset($this->_error_messages[$rule]))
				{
					/* if (FALSE === ($line = $this->CI->lang->line($rule)))
					{
						$line = 'Unable to access an error message corresponding to your field name.';
					} */
				}
				else
				{
					$line = $this->_error_messages[$rule];
				}

				// Is the parameter we are inserting into the error message the name
				// of another field?  If so we need to grab its "field label"
				if (isset($this->_field_data[$param]) AND isset($this->_field_data[$param]['label']))
				{
					$param = $this->_translate_fieldname($this->_field_data[$param]['label']);
				}

				// Build the error message
				$message = sprintf($line, $this->_translate_fieldname($row['label']), $param);

				// Save the error message
				$this->_field_data[$row['field']]['error'] = $message;

				if ( ! isset($this->_error_array[$row['field']]))
				{
					$this->_error_array[$row['field']] = $message;
				}

				return;
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Translate a field name
	 *
	 * @access	private
	 * @param	string	the field name
	 * @return	string
	 */
	protected function _translate_fieldname($fieldname)
	{
		// Do we need to translate the field name?
		// We look for the prefix lang: to determine this
		if (substr($fieldname, 0, 5) == 'lang:')
		{
			// Grab the variable
			$line = substr($fieldname, 5);

			// Were we able to translate the field name?  If not we use $line
			/* if (FALSE === ($fieldname = $this->CI->lang->line($line)))
			{
				return $line;
			} */
		}

		return $fieldname;
	}

	// --------------------------------------------------------------------

	/**
	 * Get the value from a form
	 *
	 * Permits you to repopulate a form field with the value it was submitted
	 * with, or, if that value doesn't exist, with the default
	 *
	 * @access	public
	 * @param	string	the field name
	 * @param	string
	 * @return	void
	 */
	public function set_value($field = '', $default = '')
	{
		if ( ! isset($this->_field_data[$field]))
		{
			return $default;
		}

		// If the data is an array output them one at a time.
		//     E.g: form_input('name[]', set_value('name[]');
		if (is_array($this->_field_data[$field]['postdata']))
		{
			return array_shift($this->_field_data[$field]['postdata']);
		}

		return $this->_field_data[$field]['postdata'];
	}

	// --------------------------------------------------------------------

	/**
	 * Set Select
	 *
	 * Enables pull-down lists to be set to the value the user
	 * selected in the event of an error
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	public function set_select($field = '', $value = '', $default = FALSE)
	{
		if ( ! isset($this->_field_data[$field]) OR ! isset($this->_field_data[$field]['postdata']))
		{
			if ($default === TRUE AND count($this->_field_data) === 0)
			{
				return ' selected="selected"';
			}
			return '';
		}

		$field = $this->_field_data[$field]['postdata'];

		if (is_array($field))
		{
			if ( ! in_array($value, $field))
			{
				return '';
			}
		}
		else
		{
			if (($field == '' OR $value == '') OR ($field != $value))
			{
				return '';
			}
		}

		return ' selected="selected"';
	}

	// --------------------------------------------------------------------

	/**
	 * Set Radio
	 *
	 * Enables radio buttons to be set to the value the user
	 * selected in the event of an error
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	public function set_radio($field = '', $value = '', $default = FALSE)
	{
		if ( ! isset($this->_field_data[$field]) OR ! isset($this->_field_data[$field]['postdata']))
		{
			if ($default === TRUE AND count($this->_field_data) === 0)
			{
				return ' checked="checked"';
			}
			return '';
		}

		$field = $this->_field_data[$field]['postdata'];

		if (is_array($field))
		{
			if ( ! in_array($value, $field))
			{
				return '';
			}
		}
		else
		{
			if (($field == '' OR $value == '') OR ($field != $value))
			{
				return '';
			}
		}

		return ' checked="checked"';
	}

	// --------------------------------------------------------------------

	/**
	 * Set Checkbox
	 *
	 * Enables checkboxes to be set to the value the user
	 * selected in the event of an error
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	public function set_checkbox($field = '', $value = '', $default = FALSE)
	{
		if ( ! isset($this->_field_data[$field]) OR ! isset($this->_field_data[$field]['postdata']))
		{
			if ($default === TRUE AND count($this->_field_data) === 0)
			{
				return ' checked="checked"';
			}
			return '';
		}

		$field = $this->_field_data[$field]['postdata'];

		if (is_array($field))
		{
			if ( ! in_array($value, $field))
			{
				return '';
			}
		}
		else
		{
			if (($field == '' OR $value == '') OR ($field != $value))
			{
				return '';
			}
		}

		return ' checked="checked"';
	}

	// --------------------------------------------------------------------

	/**
	 * Required
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function required($str)
	{
		if ( ! is_array($str))
		{
			return (trim($str) == '') ? FALSE : TRUE;
		}
		else
		{
			return ( ! empty($str));
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Selected (required analog for select boxes)
	 * is the select box item was selected - else it is -1 value
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function selected($str)
	{
		return ($str == -1) ? FALSE : TRUE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Is checkbox was checked 1, else 0
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function is_checked($str)
	{
		return ($str === null) ? 0 : 1;
	}

	// --------------------------------------------------------------------

	/**
	 * Performs a Regular Expression match test.
	 *
	 * @access	public
	 * @param	string
	 * @param	regex
	 * @return	bool
	 */
	public function regex_match($str, $regex)
	{
		if ( ! preg_match($regex, $str))
		{
			return FALSE;
		}

		return  TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Match one field to another
	 *
	 * @access	public
	 * @param	string
	 * @param	field
	 * @return	bool
	 */
	public function matches($str, $field)
	{
		if ( ! isset($_POST[$field]))
		{
			return FALSE;
		}

		$field = $_POST[$field];

		return ($str !== $field) ? FALSE : TRUE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Match one field to another
	 *
	 * @access	public
	 * @param	string
	 * @param	field
	 * @return	bool
	 */
	/* public function is_unique($str, $field)
	{
		list($table, $field)=explode('.', $field);
		$query = $this->CI->db->limit(1)->get_where($table, array($field => $str));
		
		return $query->num_rows() === 0;
    } */

	// --------------------------------------------------------------------

	/**
	 * Minimum Length
	 *
	 * @access	public
	 * @param	string
	 * @param	value
	 * @return	bool
	 */
	public function min_length($str, $val)
	{
		if (preg_match("/[^0-9]/", $val))
		{
			return FALSE;
		}

		if (function_exists('mb_strlen'))
		{
			return (mb_strlen($str) < $val) ? FALSE : TRUE;
		}

		return (strlen($str) < $val) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Max Length
	 *
	 * @access	public
	 * @param	string
	 * @param	value
	 * @return	bool
	 */
	public function max_length($str, $val)
	{
		if (preg_match("/[^0-9]/", $val))
		{
			return FALSE;
		}

		if (function_exists('mb_strlen'))
		{
			return (mb_strlen($str) > $val) ? FALSE : TRUE;
		}

		return (strlen($str) > $val) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Exact Length
	 *
	 * @access	public
	 * @param	string
	 * @param	value
	 * @return	bool
	 */
	public function exact_length($str, $val)
	{
		if (preg_match("/[^0-9]/", $val))
		{
			return FALSE;
		}

		if (function_exists('mb_strlen'))
		{
			return (mb_strlen($str) != $val) ? FALSE : TRUE;
		}

		return (strlen($str) != $val) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------
	
	public function valid_date($timestamp) {
		return ($timestamp == '' || (
				(string) (int) $timestamp === $timestamp)
				&& ($timestamp <= PHP_INT_MAX)
				&& ($timestamp >= ~PHP_INT_MAX)
		);
	}
	
	
	
	// --------------------------------------------------------------------

	/**
	 * Valid Email
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function valid_email($str)
	{
		/* if ($str != '') {
			return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
		} else {
			return true;
		} */
		return ($str == '' || (filter_var($str, FILTER_VALIDATE_EMAIL) !== FALSE));
	}

	// --------------------------------------------------------------------

	/**
	 * Valid Emails
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function valid_emails($str)
	{
		if (strpos($str, ',') === FALSE)
		{
			return $this->valid_email(trim($str));
		}

		foreach (explode(',', $str) as $email)
		{
			if (trim($email) != '' && $this->valid_email(trim($email)) === FALSE)
			{
				return FALSE;
			}
		}

		return TRUE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Valid URL
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function valid_url($str, $prepare_url = true)
	{
		if ($str == '') {
			return true;
		}

		if ($prepare_url) {
			if (!preg_match("~^(?:f|ht)tps?://~i", $str)) {
				$str = "http://" . $str;
			}
		}
		return (filter_var($str, FILTER_VALIDATE_URL) !== FALSE);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Validate IP Address
	 *
	 * @access	public
	 * @param	string
	 * @param	string "ipv4" or "ipv6" to validate a specific ip format
	 * @return	string
	 */
	public function valid_ip($ip, $which = '')
	{
		//return $this->CI->input->valid_ip($ip, $which);
		
		
		$which = strtolower($which);
		
		// First check if filter_var is available
		if (is_callable('filter_var'))
		{
			switch ($which) {
				case 'ipv4':
					$flag = FILTER_FLAG_IPV4;
					break;
				case 'ipv6':
					$flag = FILTER_FLAG_IPV6;
					break;
				default:
					$flag = '';
					break;
			}
		
			return (bool) filter_var($ip, FILTER_VALIDATE_IP, $flag);
		}
		
		if ($which !== 'ipv6' && $which !== 'ipv4')
		{
			if (strpos($ip, ':') !== FALSE)
			{
				$which = 'ipv6';
			}
			elseif (strpos($ip, '.') !== FALSE)
			{
				$which = 'ipv4';
			}
			else
			{
				return FALSE;
			}
		}
		
		$func = '_valid_'.$which;
		return $this->$func($ip);
	}
	
	protected function _valid_ipv4($ip)
	{
		$ip_segments = explode('.', $ip);
	
		// Always 4 segments needed
		if (count($ip_segments) !== 4)
		{
			return FALSE;
		}
		// IP can not start with 0
		if ($ip_segments[0][0] == '0')
		{
			return FALSE;
		}
	
		// Check each segment
		foreach ($ip_segments as $segment)
		{
			// IP segments must be digits and can not be
			// longer than 3 digits or greater then 255
			if ($segment == '' OR preg_match("/[^0-9]/", $segment) OR $segment > 255 OR strlen($segment) > 3)
			{
				return FALSE;
			}
		}
	
		return TRUE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Validate IPv6 Address
	 *
	 * @access	protected
	 * @param	string
	 * @return	bool
	 */
	protected function _valid_ipv6($str)
	{
		// 8 groups, separated by :
		// 0-ffff per group
		// one set of consecutive 0 groups can be collapsed to ::
	
		$groups = 8;
		$collapsed = FALSE;
	
		$chunks = array_filter(
				preg_split('/(:{1,2})/', $str, NULL, PREG_SPLIT_DELIM_CAPTURE)
		);
	
		// Rule out easy nonsense
		if (current($chunks) == ':' OR end($chunks) == ':')
		{
			return FALSE;
		}
	
		// PHP supports IPv4-mapped IPv6 addresses, so we'll expect those as well
		if (strpos(end($chunks), '.') !== FALSE)
		{
			$ipv4 = array_pop($chunks);
	
			if ( ! $this->_valid_ipv4($ipv4))
			{
				return FALSE;
			}
	
			$groups--;
		}
	
		while ($seg = array_pop($chunks))
		{
			if ($seg[0] == ':')
			{
				if (--$groups == 0)
				{
					return FALSE;	// too many groups
				}
	
				if (strlen($seg) > 2)
				{
					return FALSE;	// long separator
				}
	
				if ($seg == '::')
				{
					if ($collapsed)
					{
						return FALSE;	// multiple collapsed
					}
	
					$collapsed = TRUE;
				}
			}
			elseif (preg_match("/[^0-9a-f]/i", $seg) OR strlen($seg) > 4)
			{
				return FALSE; // invalid segment
			}
		}
	
		return $collapsed OR $groups == 1;
	}

	// --------------------------------------------------------------------

	/**
	 * Alpha
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function alpha($str)
	{
		if ($str != '')
			return ( ! preg_match("/^([a-z])+$/i", $str)) ? FALSE : TRUE;
		else
			return true;
		 
	}

	// --------------------------------------------------------------------

	/**
	 * Alpha-numeric
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function alpha_numeric($str)
	{
		if ($str != '')
			return ( ! preg_match("/^([a-z0-9])+$/i", $str)) ? FALSE : TRUE;
		else 
			return true;
	}

	// --------------------------------------------------------------------

	/**
	 * Alpha-numeric with underscores and dashes
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function alpha_dash($str)
	{
		if ($str != '')
			return ( ! preg_match("/^([-a-z0-9_-])+$/i", $str)) ? FALSE : TRUE;
		else 
			return true;
	}

	// --------------------------------------------------------------------

	/**
	 * Numeric
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function numeric($str)
	{
		if ($str != '')
			return (bool)preg_match( '/^[\-+]?[0-9]*\.?[0-9]+$/', $str);
		else
			return true;

	}

	// --------------------------------------------------------------------

	/**
	 * Is Numeric
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function is_numeric($str)
	{
		if ($str != '')
        	return ( ! is_numeric($str)) ? FALSE : TRUE;
        else 
			return true;
	}

	// --------------------------------------------------------------------

	/**
	 * Integer
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function integer($str)
	{
		if ($str != '')
			return (bool)preg_match( '/^[\-+]?[0-9]+$/', $str);
		else 
			return true;
	}

	// --------------------------------------------------------------------

	/**
	 * Decimal number
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function decimal($str)
	{
		if ($str != '')
			return (bool) preg_match('/^[\-+]?[0-9]+\.[0-9]+$/', $str);
		else
			return true;
	}

	// --------------------------------------------------------------------

	/**
	 * Greather than
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function greater_than($str, $min)
	{
		if ($str != '') {
			if ( ! is_numeric($str))
			{
				return FALSE;
			}
			return $str > $min;
		} else
			return true;
	}

	// --------------------------------------------------------------------

	/**
	 * Less than
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function less_than($str, $max)
	{
		if ($str != '') {
			if ( ! is_numeric($str))
			{
				return FALSE;
			}
			return $str < $max;
		} else
			return true;
	}

	// --------------------------------------------------------------------

	/**
	 * Is a Natural number  (0,1,2,3, etc.)
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function is_natural($str)
	{
		if ($str != '')
			return (bool) preg_match( '/^[0-9]+$/', $str);
		else
			return true;
	}

	// --------------------------------------------------------------------

	/**
	 * Is a Natural number, but not a zero  (1,2,3, etc.)
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function is_natural_no_zero($str)
	{
		if ($str != '') {
			if ( ! preg_match( '/^[0-9]+$/', $str))
			{
				return FALSE;
			}
	
			if ($str == 0)
			{
				return FALSE;
			}
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Valid Base64
	 *
	 * Tests a string for characters outside of the Base64 alphabet
	 * as defined by RFC 2045 http://www.faqs.org/rfcs/rfc2045
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function valid_base64($str)
	{
		if ($str != '')
			return (bool) ! preg_match('/[^a-zA-Z0-9\/\+=]/', $str);
		else
			return true;
	}

	// --------------------------------------------------------------------

	/**
	 * Prep data for form
	 *
	 * This function allows HTML to be safely shown in a form.
	 * Special characters are converted.
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function prep_for_form($data = '')
	{
		if (is_array($data))
		{
			foreach ($data as $key => $val)
			{
				$data[$key] = $this->prep_for_form($val);
			}

			return $data;
		}

		if ($this->_safe_form_data == FALSE OR $data === '')
		{
			return $data;
		}

		return str_replace(array("'", '"', '<', '>'), array("&#39;", "&quot;", '&lt;', '&gt;'), stripslashes($data));
	}

	// --------------------------------------------------------------------

	/**
	 * Prep URL
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function prep_url($str = '')
	{
		if ($str == 'http://' OR $str == '')
		{
			return '';
		}

		if (substr($str, 0, 7) != 'http://' && substr($str, 0, 8) != 'https://')
		{
			$str = 'http://'.$str;
		}

		return $str;
	}


	// --------------------------------------------------------------------

	/**
	 * Convert PHP tags to entities
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function encode_php_tags($str)
	{
		return str_replace(array('<?php', '<?PHP', '<?', '?>'),  array('&lt;?php', '&lt;?PHP', '&lt;?', '?&gt;'), $str);
	}
	
	
	// --------------------------------------------------------------------
	
	/**
	 * returns fields and validation output in array
	 *
	 * @return array
	 */
	function result_array($field_name = null)
	{
		if (!$field_name) {
			$result = array();
			foreach ($this->_field_data as $field => $value)
			{
				$result[$field] = stripslashes_deep($value['postdata']);
			}
			return $result;
		} else
			return stripslashes_deep($this->_field_data[$field_name]['postdata']);
	}

	
	/**
	 * set error message manually
	 * @param string $field
	 * @param string $message
	 */
	function setError($field, $message) {
		$this->_error_array[$field] = $message;
	}

}
// END Form Validation Class

/* End of file alsp_form_validation.php */
/* Location: ./system/libraries/alsp_form_validation.php */
