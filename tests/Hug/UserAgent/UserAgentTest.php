<?php

# For PHP7
// declare(strict_types=1);

// namespace Hug\Tests\UserAgent;

use PHPUnit\Framework\TestCase;

use Hug\UserAgent\UserAgent as UserAgent;

/**
 *
 */
final class UserAgentTest extends TestCase
{
    public $ua_firefox_linux = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:52.0) Gecko/20100101 Firefox/52.0';


    /* ************************************************* */
    /* ************ UserAgent::get_browscap ************ */
    /* ************************************************* */

    /**
     *
     */
    public function testCanGetBrowscap()
    {
        $test = UserAgent::get_browscap($this->ua_firefox_linux);
        $this->assertIsBool($test);
    }
    
    /* ************************************************* */
    /* ************* UserAgent::get_browser ************ */
    /* ************************************************* */

    /**
     *
     */
    public function testCanGetBrowser()
    {
    	$test = UserAgent::get_browser($this->ua_firefox_linux);
        $this->assertIsArray($test);
        $this->assertEquals('Mozilla Firefox', $test['name']);
        $this->assertEquals('linux', $test['platform']);
    }

    /* ************************************************* */
    /* *********** UserAgent::get_browser_name ********* */
    /* ************************************************* */

    /**
     *
     */
    public function testCanGetBrowserName()
    {
    	$test = UserAgent::get_browser_name($this->ua_firefox_linux);
        $this->assertIsString($test);
        $this->assertEquals('Firefox', $test);
    }

    /* ************************************************* */
    /* *************** UserAgent::get_os *************** */
    /* ************************************************* */

    /**
     *
     */
    public function testCanGetOs()
    {
    	$test = UserAgent::get_os($this->ua_firefox_linux);
        $this->assertIsString($test);
        $this->assertEquals('Linux', $test);
    }

}
