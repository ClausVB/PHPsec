<?php

// Important constants
define('PHPSEC_SERVER_IP_ADDRESS', $_SERVER['SERVER_ADDR']);
define('PHPSEC_DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

/**
 * PHPsec is a simple security class for PHP8.1 or later
 *
 * @author clausvb.lamp@mailgw.com
**/

class phpSec
{
	protected int $number;
	public array $getRaw;

	/**
	 * Creates all necessary properties and UNSET all SuperGlobals
	 * which = which_type_of_superglobal, key_names = superglobal_key_names
	 * @param $which_type: Lowercase 'get', 'request' or 'post'
	 * @param $key_names: Every SuperGlobal is an array. All SuperGlobals have keys with names
	 * like "script.php?x=99", name = x
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


		// !!! This must be in an IF in a future version ... if HARD_SECURTY === false then UNSET !!!

		// PHP 8.1: https://php.watch/versions/8.1/GLOBALS-restrictions
		// unset($GLOBALS) => Fatal error: $GLOBALS can only be modified using (...)
		foreach (array_keys($GLOBALS) as $key)
		{
			unset($GLOBALS[$key]);
		}
	}

	/**
	 * Checks if a given parameter is an INTEGER
	**/
	public function isInt($could_be_a_string_or_a_number)
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
	 * getChars
	**/
	public function getChars($string)
	{
		if (is_string($string))
		{
			preg_replace('/[^[\w]/', '', $modified_string);
			return $modified_string;
		}
		else
		{
			// ELSE will throw an expception like:
			// Fatal error: Uncaught TypeError: Cannot assign string to property phpSec::$number of type int
			return false;
		}
	}

	/**
	 * getAlphanumericalAndSpace /^[:alnum:][:space:]]/
	**/
	public function getAlphanumericalAndSpace($string)
	{
		if (is_string($string))
		{
			// CVB: ^ = NOT | Therefore every char is replaced which NOT matches (ASCII)Characters or space
			preg_replace('/[^[:alnum:][:space:]]/', '', $modified_string);
			return $modified_string;
		}
		else
		{
			// ELSE will throw an expception like:
			// Fatal error: Uncaught TypeError: Cannot assign string to property phpSec::$number of type int
			return false;
		}
	}
}