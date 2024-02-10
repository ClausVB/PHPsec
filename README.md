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

## Installation

Work in progress ...

## Project's status and releases

| Date | State | Comment                                     |
|------------|-------|---------------------------------------|
| 2024-02-10 | Alpha | README.MD and file to test this class |
| 2024-02-xy | Alpha | Work in progress ...                  |
