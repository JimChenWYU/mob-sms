<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 7/27/2018
 * Time: 3:01 PM
 */

namespace JimChen\MobSms\Tests;

use JimChen\MobSms\Messenger;
use JimChen\MobSms\MobSms;
use JimChen\MobSms\Contracts\MessengerInterface;
use JimChen\MobSms\PhoneNumber;

class MobSmeTest extends TestCase
{
    protected $config;

    protected function setUp()
    {
        $this->config = [
            'appkey' => '27xxxxxxxxxx',
            'zone'   => 86,
        ];
    }

    public function testGetMessenger()
    {
        $easySms = new MobSms([]);
        $this->assertInstanceOf(MessengerInterface::class, $easySms->getMessenger());
    }

    public function testSend()
    {
        // simple
        $mobSms = \Mockery::mock(MobSms::class.'[getMessenger]', [$this->config]);
        $messenger = \Mockery::mock(Messenger::class, [$mobSms]);
        $messenger->shouldReceive('send')->with(\Mockery::on(function ($number) {
            return $number instanceof PhoneNumber && !empty($number->getNumber());
        }), 1111)->andReturn('send-result');
        $mobSms->shouldReceive('getMessenger')->andReturn($messenger);
        $this->assertSame('send-result', $mobSms->send('18219111987', 1111));

        // phone number object
        $mobSms = \Mockery::mock(MobSms::class.'[getMessenger]', [$this->config]);
        $number = new PhoneNumber('18219111987', 86);
        $messenger = \Mockery::mock(Messenger::class);
        $messenger->shouldReceive('send')->with($number, 1111)->andReturn('mock-result');
        $mobSms->shouldReceive('getMessenger')->andReturn($messenger);
        $this->assertSame('mock-result', $mobSms->send($number, 1111));
    }
}
