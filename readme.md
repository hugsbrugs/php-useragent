# php-useragent

This librairy provides utilities function to get usergent informations from different methods

[![Build Status](https://travis-ci.org/hugsbrugs/php-useragent.svg?branch=master)](https://travis-ci.org/hugsbrugs/php-useragent)
[![Coverage Status](https://coveralls.io/repos/github/hugsbrugs/php-useragent/badge.svg?branch=master)](https://coveralls.io/github/hugsbrugs/php-useragent?branch=master)

## Install

Install package with composer
```
composer require hugsbrugs/php-useragent
```

In your PHP code, load library
```php
require_once __DIR__ . '/../vendor/autoload.php';
use Hug\UserAgent\UserAgent as UserAgent;
```


## Usage

Get browser infos from PHP [browscap](http://php.net/manual/en/function.get-browser.php
) database (Need to be installed and configured)
```php
$ua = UserAgent::get_browscap();
```

# Get browser infos from regex
```php
$ua2 = UserAgent::get_browser();
```

Get_browser_name (Possible values : Unknown Browser, Internet Explorer, Firefox, Safari, Chrome, Edge, Opera, Netscape, Maxthon, Konqueror, Handheld Browse)
```php
$ua3 = UserAgent::get_browser_name();
```

Get OS from list of most common OS (Possible Values : Unknown OS Platform, Windows 10, Windows 8.1, Windows 8, Windows 7, Windows Vista, Windows Server 2003/XP x64, Windows XP, Windows XP, Windows 2000, Windows ME, Windows 98, Windows 95, Windows 3.11, Mac OS X, Mac OS 9, Linux, Ubuntu, iPhone, iPod, iPad, Android, BlackBerry, Mobil)
```php
$os = UserAgent::get_os($ua = null);
```


## Unit Tests

```
phpunit --bootstrap vendor/autoload.php tests
```

## Author

Hugo Maugey [visit my website ;)](https://hugo.maugey.fr)
