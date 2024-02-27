<?php

/**
 * The class "PHPsec" creates an API between your script and the outside world.
 * It deletes all values/SuperGlobals like $_GET, $_POST and so on.
 * https://www.php.net/manual/de/language.variables.superglobals.php
**/

if (!empty($_GET) and is_array($_GET))
{
	/*
		echo '<pre><a href="https://www.php.net/manual/de/language.variables.superglobals.php" target="_blank">SuperGlobals</a> $_GET: ' . PHP_EOL;
		print_r($_GET);
		echo '</pre>';
	*/
}
else
{
	exit('<h1>How to use correctly</h1><p>Call this file with 3 params like: ' . basename(__FILE__) . '?test=1&name=Daniel&age=42</p><p>Example: <a href="' . basename(__FILE__) . '?test=1&name=Daniel&age=42">Test with params</a></p>');
}

require_once dirname(__FILE__) . '/phpsec.php';

// Create object containing $_GET (keys and values)
$superglobal_names = array('test', 'name', 'age');
$phpsec = new phpSec('get', $superglobal_names);

/**
 * A short example: How to handle a number
 * Age: 10, 27, 42, 62
**/
preg_match('/^([1-5][0-9]|60|61|62)$/', $phpsec->getRaw['age'], $regex_matches);
$tested_age = ($regex_matches[0] == $phpsec->getRaw['age'])
	? $phpsec->getInt('age')
	: exit('Param "age" must be between 10 and 62!');


/**
 * Another short example: How to handle a simple string
 * Name: Daniel, Michelle, Marc-Oliver or Jörg
**/ 
$name_htmlentities = htmlentities($phpsec->getRaw['name'], ENT_HTML5, 'UTF-8');

preg_match('/^([\w&;-]+)$/', $name_htmlentities, $regex_name_matches);
$tested_name = ($regex_name_matches[0] == $name_htmlentities)
	? $name_htmlentities
	: $phpsec->getAlphanumericalAndSpace('name'); // returns all chars matching "[:alnum:]" and "[:space:]"

//echo '<pre>GETRAW: '; var_dump($phpsec->getRaw); echo '</pre>';

require_once 'test_and_docs_phpsec.htm';
