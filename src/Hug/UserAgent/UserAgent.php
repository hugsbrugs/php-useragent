<?php

namespace Hug\UserAgent;

/**
 *
 */
class UserAgent
{

	/**
	 * Helper function to extract User Agent if not passed as params
	 *
	 * @param string $user_agent
	 * @return string $user_agent
	 */
	private static function get_ua($user_agent = null)
	{
		if($user_agent===null)
		{
			# Request is made from web server
		    if(isset($_SERVER))
		    {
		    	$user_agent = $_SERVER['HTTP_USER_AGENT'] ;
		    }
		    else
		    {
		    	# Command line : find server config
		    	global $HTTP_SERVER_VARS ;
		    	if(isset($HTTP_SERVER_VARS))
		    	{
		    		$user_agent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'] ;
		    	}
		    	else
		    	{
		    		global $HTTP_USER_AGENT ;
		    		$user_agent = $HTTP_USER_AGENT ;
		    	}
		    }
		}

		return $user_agent;
	}

	/**
	 * In order for this to work, your browscap configuration setting in php.ini must point to the correct location of the browscap.ini file on your system.
	 *
	 * browscap.ini is not bundled with PHP, but you may find an up-to-date » php_browscap.ini file here.
	 *
	 * While browscap.ini contains information on many browsers, it relies on user updates to keep the database current. The format of the file is fairly self-explanatory.
	 *
	 * http://browscap.org/stream?q=PHP_BrowsCapINI
	 * http://browscap.org/stream?q=Full_PHP_BrowsCapINI
	 * http://browscap.org/stream?q=Lite_PHP_BrowsCapINI
	 *
	 * sudo wget http://browscap.org/stream?q=Lite_PHP_BrowsCapINI -O /usr/local/etc/browscap.ini
	 *
	 * sudo nano /etc/php/7.0/apache2/php.ini 
	 *
	 * [browscap]
	 * ; http://php.net/browscap
	 * browscap = "/usr/local/etc/browscap.ini"
	 *
	 */
	public static function get_browscap($user_agent = null)
	{
		$browser = false;

		$user_agent = UserAgent::get_ua($user_agent);
		
		if(ini_get('browscap')!=='')
		{
			$browser = get_browser($user_agent, true);
			// $browser = get_browser();
		}
		else
		{
			error_log('UserAgent::get_browscap : browscap.ini not set');
		}

		return $browser;
	}


	/**
	 * Get Browser Name
	 *
	 * @param string $user_agent
	 * @return string $browser_name
	 */
	public static function get_browser_name($user_agent = null)
	{
	    $user_agent = UserAgent::get_ua($user_agent);
	    $browser = "Unknown Browser";

	    $browser_array = [
			'/msie/i'       =>  'Internet Explorer',
			'/firefox/i'    =>  'Firefox',
			'/safari/i'     =>  'Safari',
			'/chrome/i'     =>  'Chrome',
			'/edge/i'       =>  'Edge',
			'/opera/i'      =>  'Opera',
			'/netscape/i'   =>  'Netscape',
			'/maxthon/i'    =>  'Maxthon',
			'/konqueror/i'  =>  'Konqueror',
			'/mobile/i'     =>  'Handheld Browser'
		];

	    foreach ($browser_array as $regex => $value)
	    { 
	        if (preg_match($regex, $user_agent))
	        {
	            $browser = $value;
	            break;
	        }
	    }

	    return $browser;
	}


	/**
	 * Get Browser main informations
	 *
	 * @param string $user_agent
	 * @return array $browser_infos 
	 * @link http://php.net/manual/en/function.get-browser.php
	 */
	public static function get_browser($user_agent = null)
	{
	    // $u_agent = $_SERVER['HTTP_USER_AGENT'];
	    $u_agent = UserAgent::get_ua($user_agent);
	    $bname = 'Unknown';
	    $platform = 'Unknown';
	    $version= "";

	    //First get the platform?
	    if (preg_match('/linux/i', $u_agent)) {
	        $platform = 'linux';
	    }
	    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
	        $platform = 'mac';
	    }
	    elseif (preg_match('/windows|win32/i', $u_agent)) {
	        $platform = 'windows';
	    }
	   
	    // Next get the name of the useragent yes seperately and for good reason
	    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
	    {
	        $bname = 'Internet Explorer';
	        $ub = "MSIE";
	    }
	    elseif(preg_match('/Firefox/i',$u_agent))
	    {
	        $bname = 'Mozilla Firefox';
	        $ub = "Firefox";
	    }
	    elseif(preg_match('/Chrome/i',$u_agent))
	    {
	        $bname = 'Google Chrome';
	        $ub = "Chrome";
	    }
	    elseif(preg_match('/Safari/i',$u_agent))
	    {
	        $bname = 'Apple Safari';
	        $ub = "Safari";
	    }
	    elseif(preg_match('/Opera/i',$u_agent))
	    {
	        $bname = 'Opera';
	        $ub = "Opera";
	    }
	    elseif(preg_match('/Netscape/i',$u_agent))
	    {
	        $bname = 'Netscape';
	        $ub = "Netscape";
	    }
	   
	    // finally get the correct version number
	    $known = array('Version', $ub, 'other');
	    $pattern = '#(?<browser>' . join('|', $known) .
	    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	    if (!preg_match_all($pattern, $u_agent, $matches)) {
	        // we have no matching number just continue
	    }
	   
	    // see how many we have
	    $i = count($matches['browser']);
	    if ($i != 1) {
	        //we will have two since we are not using 'other' argument yet
	        //see if version is before or after the name
	        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
	            $version= $matches['version'][0];
	        }
	        else {
	            $version= $matches['version'][1];
	        }
	    }
	    else {
	        $version= $matches['version'][0];
	    }
	   
	    // check if we have a number
	    if ($version==null || $version=="") {$version="?";}
	   
	    return [
	        'userAgent' => $u_agent,
	        'name'      => $bname,
	        'version'   => $version,
	        'platform'  => $platform,
	        'pattern'    => $pattern
	    ];
	}


	/**
	 * Get Operating System from short User Agent list
	 *
	 * @param string $user_agent
	 * @return string $operating_system
	 */
	public static function get_os($user_agent = null)
	{
		# Get UA
		$user_agent = UserAgent::get_ua($user_agent);

		# Unknow OS
	    $os_platform = "Unknown OS Platform";

	    # Define regexp for OS 
	    $os_array = [
			'/windows nt 10/i'      =>  'Windows 10',
			'/windows nt 6.3/i'     =>  'Windows 8.1',
			'/windows nt 6.2/i'     =>  'Windows 8',
			'/windows nt 6.1/i'     =>  'Windows 7',
			'/windows nt 6.0/i'     =>  'Windows Vista',
			'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
			'/windows nt 5.1/i'     =>  'Windows XP',
			'/windows xp/i'         =>  'Windows XP',
			'/windows nt 5.0/i'     =>  'Windows 2000',
			'/windows me/i'         =>  'Windows ME',
			'/win98/i'              =>  'Windows 98',
			'/win95/i'              =>  'Windows 95',
			'/win16/i'              =>  'Windows 3.11',
			'/macintosh|mac os x/i' =>  'Mac OS X',
			'/mac_powerpc/i'        =>  'Mac OS 9',
			'/linux/i'              =>  'Linux',
			'/ubuntu/i'             =>  'Ubuntu',
			'/iphone/i'             =>  'iPhone',
			'/ipod/i'               =>  'iPod',
			'/ipad/i'               =>  'iPad',
			'/android/i'            =>  'Android',
			'/blackberry/i'         =>  'BlackBerry',
			'/webos/i'              =>  'Mobile'
		];

		# Loop to find OS
	    foreach ($os_array as $regex => $value)
	    { 
	        if(preg_match($regex, $user_agent))
	        {
	            $os_platform = $value;
	            break;
	        }
	    }   

	    return $os_platform;
	}

}