<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 7/27/2018
 * Time: 4:46 PM
 */

namespace JimChen\MobSms\Tests;

use JimChen\MobSms\MobSms;
use JimChen\MobSms\Messenger;
use JimChen\MobSms\PhoneNumber;

class MessengerTest extends TestCase
{
    protected $mobSms;

    public function setUp()
    {
        $this->mobSms = new MobSms([
            'appkey' => '27xxxxxxxxxx',
            'zone'   => 86,
        ]);
    }

    /**
     * @expectedException \JimChen\MobSms\Exceptions\RequestErrorException
     * @expectedExceptionMessage AppKey为空
     */
    public function testVerify()
    {
        /**
         * @var \Mockery $app
         */
        $app = \Mockery::mock(Messenger::class.'[request]', [$this->mobSms])->shouldAllowMockingProtectedMethods();

        $app->shouldReceive('request')->with('post', 'https://' . Messenger::ENDPOINT_HOST . Messenger::ENDPOINT_URI, [
            'headers'     => [
                'content-type' => 'application/x-www-form-urlencoded;charset=UTF-8',
                'accept'       => 'application/json',
            ],
            'form_params' => [
                'appkey' => '27xxxxxxxxxx',
                'zone'   => 86,
                'phone'  => 18219111987,
                'code'   => 1111,
            ],
            'exceptions'  => false,
        ])->andReturn(
            ['status' => 200],
            ['status' => 405]
        )->twice();

        $this->assertSame(['status' => 200], $app->verify(new PhoneNumber(18219111987), 1111));

        $app->verify(new PhoneNumber(18219111987), 1111);
    }
}