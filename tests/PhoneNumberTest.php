<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 7/27/2018
 * Time: 2:54 PM
 */

namespace JimChen\MobSms\Tests;

use JimChen\MobSms\PhoneNumber;

class PhoneNumberTest extends TestCase
{
    public function testOnlyNumber()
    {
        $n = new PhoneNumber(18888888888);
        $this->assertSame(18888888888, $n->getNumber());
        $this->assertNull($n->getIDDCode());
        $this->assertSame('18888888888', $n->getUniversalNumber());
        $this->assertSame('18888888888', $n->getZeroPrefixedNumber());
        $this->assertSame('18888888888', \strval($n));
    }

    public function testDiffCode()
    {
        $n = new PhoneNumber(18888888888, 68);
        $this->assertSame(68, $n->getIDDCode());
        $n = new PhoneNumber(18888888888, '+68');
        $this->assertSame(68, $n->getIDDCode());
        $n = new PhoneNumber(18888888888, '0068');
        $this->assertSame(68, $n->getIDDCode());
    }

    public function testJsonEncode()
    {
        $n = new PhoneNumber(18888888888, 68);
        $this->assertSame(json_encode(['number' => $n->getUniversalNumber()]), \json_encode(['number' => $n]));
    }
}
