<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 7/27/2018
 * Time: 2:43 PM
 */

namespace JimChen\MobSms\Tests\Support;

use JimChen\MobSms\Support\Config;
use JimChen\MobSms\Tests\TestCase;

class ConfigTest extends TestCase
{
    public function testGetConfig()
    {
        $config = new Config(['foo' => 1]);

        $this->assertSame(1, $config->get('foo'));
        $this->assertSame('Hello', $config->get('bar', 'Hello'));
    }
}
