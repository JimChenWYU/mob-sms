<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 7/27/2018
 * Time: 2:13 PM
 */

namespace JimChen\MobSms\Contracts;

interface MessengerInterface
{
    public function verify(PhoneNumberInterface $to, $code);
}
