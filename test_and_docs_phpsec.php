<?php

/**
 * $_GET: Array
 * (
 *     [test] => 1
 *     [name] => Daniel
 *     [age] => 99
 *     [some_evil_attack] => php://filter/convert.iconv.UTF8.CSISO2022KR|convert.base64-encode|convert.iconv.UTF8.UTF7
 * )
 *
 * GETRAW: array(3) {
 *   ["test"]=>
 *   string(1) "1"
 *   ["name"]=>
 *   string(6) "Daniel"
 *   ["age"]=>
 *   string(2) "99"
 * }
**/

if (!empty($_GET) and is_array($_GET))
{
	echo '<pre><a href="https://www.php.net/manual/de/language.variables.superglobals.php" target="_blank">SuperGlobal</a> $_GET: ' . PHP_EOL;
	print_r($_GET);
	echo '</pre>';
}
else
{
	exit('<h1>How to use correctly</h1><p>Call this file 3 params like: ' . basename(__FILE__) . '?test=1&name=Daniel&age=99</p>');
}

require_once(dirname(__FILE__) . '/phpsec.php');

/**
 * The class "PHPsec" deletes all values
 * https://www.php.net/manual/de/language.variables.superglobals.php
**/
$api = array('test', 'name', 'age');
$phpsec = new phpSec('get', $api);

$test_number = $phpsec->isInt('5');

echo '<pre>GETRAW: '; var_dump($phpsec->getRaw); echo '</pre>';