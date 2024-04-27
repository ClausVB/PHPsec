# PHPsec: A simple PHP-security-class to handle SuperGlobals

According to Google and W3techs 79.2% of website rely on PHP.

In my thirty year career I've encourtered security risks in all aspects of IT (companies).

tldr: Answer the following question: Safe or unsafe?
```
include $_GET['filename'];
```
Unsafe? You have come to the right place.

> "5 PHP Security Breaches That’s Common, But Barely Talked About. Nearly 82% of the web servers have deployed PHP as a server side scripting language, according to W3techs."
[Source: brainvire.com](https://www.brainvire.com/5-php-security-breaches-thats-common-barely-talked/)

## Prerequisites

Can I speek freely? You need a brain to use this class. IT-Security is a big and complex issue. Using this class has no value if your server allows 1000 GET-params or standard queries (URLs) of 8K like this:

```
your-domain.net/index.php?param=php://filter/convert.iconv.UTF8.CSISO2022KR|convert.base64-encode|convert.iconv.UTF8.UTF7|convert.iconv.SE2.UTF-16
```
Source: https://github.com/php/php-src/issues/10453

Your Apache (webserver) and PHP.INI should limit such requests depending on your project. A brain is needed.

PHPsec is for small projects with any kind of <a href="https://www.w3schools.com/html/html_forms.asp" target="_blank">form</a> like contact or comments. If you use a PHP framework like [Laravel](https://laravel.com) you should use internal security methods.

Your knowledge is ...
* Expert level: <a href="https://en.wikipedia.org/wiki/Regular_expression" target="_blank">RegEx</a>
* Basic level: PHP function "<a href="https://www.php.net/manual/en/function.preg-match.php" target="_blank">preg_match()</a>". The param "matches" is important for PHPsec.
* Expert level: <a href="https://www.php.net/manual/de/language.variables.superglobals.php" target="_blank">SuperGlobals</a> especially $GLOBALS
* Basic level: PHP function "<a href="https://www.php.net/manual/en/function.isset.php" target="_blank">isset()</a>" and  "<a href="https://www.php.net/manual/en/function.empty.php" target="_blank">empty()</a>" because PHPsec will force in you to test variables before using them. Otherwise you might encounter some errors, like "Fatal error: Uncaught Error: Typed property phpSec::$getRaw must not be accessed before initialization ..."


## Installation

* Create a sub directory "phpsec"
* Download https://github.com/ClausVB/PHPsec/blob/main/phpsec.php
* (YOUR_PROJECT)/phpsec/phpsec.php
* Use "require_once" (or "include")
* Take a look at the docs/examples
* Done

## Project's status and releases

| Date | State | Comment                                     |
|------------|-------|---------------------------------------|
| 2024-02-10 | Alpha | README.MD and file to test this class |
| 2024-02-17 | Beta  | New examples, improved class "PHPsec" |
| 2024-02-27 | RC1   | New examples, improved internal docs  |
| 2024-04-19 | RC2   | New constants regarding SuperGlobals  |
