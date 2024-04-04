<?php

// Important constants
define('PHPSEC_SERVER_IP_ADDRESS', $_SERVER['SERVER_ADDR']);
define('PHPSEC_DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('PHPSEC_REMOTE_ADDRESS', $_SERVER['REMOTE_ADDR']);
define('PHPSEC_PHP_SELF', $_SERVER['PHP_SELF']);

/** 
 * $_SERVER['PHP_AUTH_USER'] contains user information (e.g. HTACCESS)
 * If not set = FALSE
*/
$logged_in_user = (isset($_SERVER['PHP_AUTH_USER'])) ? $_SERVER['PHP_AUTH_USER'] : false;
define('PHPSEC_AUTH_USER', $logged_in_user);


/**
 * PHPsec is a simple security class for PHP8.1 or later
 *
 * @author CVB <clausvb.lamp@mailgw.com>
 * @changed 2024-04-04
**/

class phpSec
{
	protected int $number;

	/**
	 * Property "getRaw" contains SuperGlobals (keys and values)
	 *
	 * If you call "script.php?number=42" then
	 * $phpsec->getRaw['number'] is equal to $_GET['number']
	 * See constructor for more information.
	 */
	public array $getRaw;

	/**
	 * Creates all necessary properties and UNSET() all SuperGlobals
	 *
	 * Params explained: which_type = which_type_of_superglobal, key_names = superglobal_key_names
	 * 
	 * @param string $which_type Lowercase 'get' ($_GET), 'request' ($_REQUEST) or 'post' ($_POST)
	 * @param array $key_names Every SuperGlobal is an array. All SuperGlobals have keys with names
	 * like "number". E.g. "script.php?number=42"
	**/
	public function __construct(protected string $which_type, protected array $key_names)
	{
		switch ($which_type)
		{
			case 'get':
				$superglobal = $_GET;
			break;
			case 'post':
				$superglobal = $_POST;
			break;
			case 'request':
				$superglobal = $_REQUEST;
			break;
			default:
				exit('Critical error: <b>$which_type</b> is not set! $which_type: Lowercase "get", "request" or "post"');
		}

		foreach ($superglobal as $key => $value)
		{
			if (in_array($key, $this->key_names))
			{
				$this->getRaw[$key] = $value;
			}
			else
			{
				// throw warning in error_log
			}
		}

		unset($_SERVER);
		unset($_GET);
		unset($_POST);
		unset($_FILES);
		unset($_COOKIE);
		unset($_SESSION);
		unset($_REQUEST);
		unset($_ENV);

		// !!! This must be in an IF in a future version ... if HARD_SECURTY === TRUE then UNSET !!!

		// PHP 8.1: https://php.watch/versions/8.1/GLOBALS-restrictions
		// unset($GLOBALS) => Fatal error: $GLOBALS can only be modified using (...)
		foreach (array_keys($GLOBALS) as $key)
		{
			unset($GLOBALS[$key]);
		}
	}

	/**
	 * Private method "validateInt" validates and returns an integer
	 *
	 * A string or an integer is expect as param "$could_be_a_string_or_a_number". It
	 * returns "int(42)" if a param "42" (string or integer) is provided.
	 *
	 * @param string $could_be_a_string_or_a_number 42 or "42"
	 *
	 * @return integer Converts a string "42" and returns an integer like "int(42)"
	 */
	private function validateInt($could_be_a_string_or_a_number)
	{
		$this->number = $could_be_a_string_or_a_number; // '42' or 42

		if (is_int($this->number))
		{
			return $this->number;
		}
		else
		{
			// ELSE will throw an expception like:
			// Fatal error: Uncaught TypeError: Cannot assign string to property phpSec::$number of type int
			return false;
		}
	}

	/**
	 * Public method "isInt" validates and returns an integer
	 *
	 * See "validateInt" for more information.
	 *
	 * @param string $could_be_a_string_or_a_number 42 or "42"
	 *
	 * @return integer Converts and returns an integer like "int(42)"
	 */
	public function isInt($could_be_a_string_or_a_number)
	{
		return $this->validateInt($could_be_a_string_or_a_number);
	}

	/**
	 * Get SuperGlobal INTEGER
	**/
	public function getInt($key)
	{
		$this->number = (isset($key) and in_array($key, $this->key_names))
			? $this->getRaw[$key]
			: exit('Key: ' . $key . ' is not set correctly!');

		return $this->validateInt($this->number);
	}

	private function validateMail($mail)
	{
		if (filter_var($mail, FILTER_VALIDATE_EMAIL))
		{
			$mx_hosts = array();

			/*
				$email  = 'name@example.com';
				$domain = strstr($email, '@');
				echo $domain; // Ausgabe: @example.com
				substr with 1 = example.com
			*/
			$hostname = substr(
				strstr($mail, '@'),
				1
			);

			$tested_mail = (getmxrr($hostname, $mx_hosts))
				? $mail
				: exit('Mail is not valid or MX-Record for domain "' . $hostname . '" could not be found.');

			return $tested_mail;
		}
		else
		{
			//return false;
			exit('Mail is not valid or MX-Record for domain "' . $hostname . '" could not be found.');
		}
	}

	/**
	 * Get SuperGlobal Mail
	**/
	public function getMail($key)
	{
		$mail = (isset($key) and in_array($key, $this->key_names))
			? $this->getRaw[$key]
			: exit('Key: ' . $key . ' is not set correctly!');

		return $this->validateMail($mail);
	}


	/**
	 * Method "getChars" clears every character which does not match "[\w]"
	 *
	 * If a SuperGlobal contains "Jörg" this method will return "Jrg".
	 * Every char is replaced which NOT matches (ASCII)Characters
	 * and Underscore.
	 *
	 * @param string $key All SuperGlobals are associative arrays
	 *
	 * @return string Returns a modified string or FALSE
	 */
	public function getChars($key)
	{
		$string = (isset($key) and in_array($key, $this->key_names))
			? $this->getRaw[$key]
			: exit('Key: ' . $key . ' is not set correctly!');

		if (is_string($string))
		{
			// CVB: ^ = NOT | Therefore every char is replaced which NOT matches (ASCII)Characters and Underscore
			$modified_string = preg_replace('/[^[\w]/', '', $string);
			//echo '<pre>modified_string: '; var_dump($modified_string); echo '</pre>';
			return $modified_string;
		}
		else
		{
			return false;
		}
	}

	/**
	 * getAlphanumericalAndSpace /^[:alnum:][:space:]]/
	**/
	public function getAlphanumericalAndSpace($key)
	{
		$string = (isset($key) and in_array($key, $this->key_names))
			? $this->getRaw[$key]
			: exit('Key: ' . $key . ' is not set correctly!');

		if (is_string($string))
		{
			// CVB: ^ = NOT | Therefore every char is replaced which NOT matches (ASCII)Characters or space
			$modified_string = preg_replace('/[^[:alnum:][:space:]]/', '', $string);
			return $modified_string;
		}
		else
		{
			return false;
		}
	}
}
