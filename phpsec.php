<?php

// Important constants
define('PHPSEC_SERVER_IP_ADDRESS', $_SERVER['SERVER_ADDR']);

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
	 * @param $superglobal: lowercase 'get' or 'post'
	**/
	public function __construct(protected string $superglobal, protected array $api)
	{
		foreach ($_GET as $key => $value)
		{
			if (in_array($key, $this->api))
			{
				$this->getRaw[$key] = $value;
			}
			else
			{
				// throw warning in error_log
			}
		}

		unset($_GET);
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
}