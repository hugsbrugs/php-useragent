<?php

// http://php.net/browscap
// https://browscap.org/
// https://github.com/browscap/browscap-php
// https://github.com/ThaDafinser/UserAgentParser
// https://wordpress.org/plugins/php-browser-detection/

require_once __DIR__ . '/../vendor/autoload.php';

use Hug\UserAgent\UserAgent as UserAgent;

// echo ini_get('browscap');

# Set Fake User Agent if called from command line
if(!isset($_SERVER['HTTP_USER_AGENT']))
{
	$_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:52.0) Gecko/20100101 Firefox/52.0';	
}
echo "HTTP_USER_AGENT<br>";
echo $_SERVER['HTTP_USER_AGENT'] . "<br><br>";

#
echo "get_browscap<br>";
$ua = UserAgent::get_browscap();
echo '<pre>';print_r($ua);echo '</pre><br><br>';

#
echo "get_browser<br>";
$ua2 = UserAgent::get_browser();
echo '<pre>';print_r($ua2);echo '</pre><br><br>';

# Get_browser_name
# Possible values : Unknown Browser, Internet Explorer, Firefox, Safari, Chrome, Edge, Opera, Netscape, Maxthon, Konqueror, Handheld Browse
echo "get_browser_name<br>";
$ua3 = UserAgent::get_browser_name();
echo '<pre>';print_r($ua3);echo '</pre><br><br>';



// Operating System

# Get OS from list of most common OS
# Possible Values : Unknown OS Platform, Windows 10, Windows 8.1, Windows 8, Windows 7, Windows Vista, Windows Server 2003/XP x64, Windows XP, Windows XP, Windows 2000, Windows ME, Windows 98, Windows 95, Windows 3.11, Mac OS X, Mac OS 9, Linux, Ubuntu, iPhone, iPod, iPad, Android, BlackBerry, Mobil
echo "get_os_short<br>";
$os = UserAgent::get_os($ua = null);
echo '<pre>';print_r($os);echo '</pre><br><br>';
